<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tsp extends Transport
{

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        $this->load->model('transport/tsp_m');
        $this->load->model('transport_m');
    }

    public function index()
    {
        $routes = $this->transport_m->get_routes();
        $list = [];
        foreach ($routes as $r)
        {
            $list[$r->id] = $r->name;
        }
        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);

        $ccc = [];
        foreach ($this->classlist as $key => $value)
        {
            $sp = (object) $value;
            $ccc[$key] = $sp->name;
        }

        $my = [];
        $opts = [];
        $assigned = $this->transport_m->get_assigned_routes($this->ion_auth->get_user()->id);
        $students = [];
        $ct = 0;

        foreach ($assigned as $k)
        {
            $ft = $this->transport_m->get_route_students($k);
            $ns = [];
            foreach ($ft as $f)
            {
                $sn = $this->worker->get_student($f->student);
                $avt = strtolower(substr($sn->first_name, 0, 1));
                $ns[] = ['id' => $f->student, 'name' => $sn->first_name . '  ' . $sn->middle_name . ' ' . $sn->last_name, 'v' => $avt, 'class' => $sn->cl->name, 'adm' => $sn->admission_number];
            }
            $students[$k] = $ns;
            $route = $this->transport_m->find_route($k);
            $my[$route->name] = count($ft);
            $opts[] = ['id' => $k, 'name' => isset($list[$k]) ? $list[$k] : ''];

            $ct += count($ft);
        }

        $rt = '';
        $slist = [];
        if (count($assigned) == 1)
        {
            //$r_id = $assigned[0];
            //$rt = json_encode(['id' => $r_id, 'name' => isset($list[$r_id]) ? $list[$r_id] : '']);
           // $slist = $students[$r_id];
        }

        $data['classes'] = $ccc;
        $data['students'] = []; //$slist;
        $data['route'] = ''; //$rt;

        $data['years'] = $yrs;
        $data['assigned'] = $my;
        $data['roster'] = []; // $students;
        $data['routes'] = $list;
        $data['total_r'] = count($assigned);
        $data['total_s'] = $ct;
        $data['options'] = $opts;
        //load view
        $this->template->title(' Transport')->build('portal/home', $data);
    }

    function recent()
    {
        $rec = $this->transport_m->get_recent();

        echo json_encode(['recent' => $rec]);
    }

    function list_students()
    {
        $per = $this->input->get('per_page', '');
        $search = $this->input->get('search', '');
        $page = $this->input->get('page', 0);
        $route = $this->input->get('route', 0);
        $tab = $this->input->get('tab', 0);
        $start = ($page - 1) * $per;

        $term = $this->school->term;
        $year = $this->school->year;

        $day = date('j');
        $month = date('n');
        $year_t = date('Y');

        $result = $this->transport_m->get_student_list($route, $start, $per, $search, $term, $year);
        
        $ns = [];
        foreach ($result as $r)
        {
            $att = $this->transport_m->get_att($r->student, $route, $day, $month, $year_t);
            if ($tab == 2)
            {
                if (empty($att))
                {
                    continue;
                }
                if ((!$att->board ) || ($att->board && $att->off))
                {
                    continue;
                }
            }
            $sn = $this->worker->get_student($r->student);
            $avt = strtolower(substr($sn->first_name, 0, 1));
            $ns[] = ['id' => $r->student,
                      'name' => $sn->first_name . '  ' . $sn->middle_name . ' ' . $sn->last_name,
                      'v' => $avt,
                      'class' => $sn->cl->name,
                      'adm' => $sn->admission_number,
                      'att' => empty($att) ? false : true
            ];
        }

        echo json_encode(['students' => $ns]);
    }

    function bulk()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        if (!$post->route)
        {
            echo json_encode(['message' => 'Missing Parameters']);
            exit();
        }
        foreach ($post->ids as $p)
        {
            $this->update_trans($p, $post->route, $post->action);
        }
    }

    function update()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        if (isset($post->id) && isset($post->route) && isset($post->status))
        {
            $this->update_trans($post->id, $post->route, $post->status);
        }
        else
        {
            echo json_encode(['message' => 'Missing Parameters']);
        }
    }

    function update_trans($student, $route, $status)
    {
        if ($status > 0)
        {
            $day = date('j');
            $month = date('n');
            $year = date('Y');

            $this->transport_m->update_att($student, $route, $status, $day, $month, $year);

            //send sms
            $rw = $this->admission_m->find($student);
            $member = $this->ion_auth->get_single_parent($rw->parent_id);
            if (!empty($member))
            {
                if ($status == 1)
                {
                    $action = ' has boarded the bus at ' . date('g:i A');
                }
                else if ($status == 2)
                {
                    $action = ' has alighted the bus at ' . date('g:i A');
                }
                if ($status == 1 || $status == 2)
                {
                    $to = 'Parent/Guardian';
                    $message = $this->school->message_initial . ' ' . $to . ', Student ' . $rw->first_name . ' ' . $rw->last_name . $action;
                    // $this->sms_m->send_sms($member->phone, $message);
                }
            }

            echo json_encode(['message' => 'Success']);
        }
        else if ($status == 0)
        {
            $rt = [
                      'route' => $route,
                      'student' => $student,
                      'day' => date('j'),
                      'month' => date('n'),
                      'year' => date('Y'),
                      'absent' => 1,
                      'created_by' => $this->user->id,
                      'created_on' => time()
            ];

            $this->transport_m->save('transport_att', $rt);
            echo json_encode(['message' => 'Success']);
        }
    }

    /**
     * log the user out
     */
    function logout()
    {
        $this->ion_auth->logout();
        //redirect them back to the page they came from
        redirect('/', 'refresh');
    }

    function profile()
    {
        $profile = $this->tsp_m->get_profile();
        $data['profile'] = $profile;
        $this->template->title(' Transport')->build('portal/profile', $data);
    }

}
