<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        $this->load->model('cbc_m');
    }

    function drop_subjects()
    {

        // $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'Access denied'));
        // redirect('admin/cbc/subjects');
        if ($this->input->post()) {

            // $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'Access denied'));
            // redirect('admin/cbc/subjects');
            $post = (object) $this->input->post();
            foreach ($post->subjects as $id => $p) {
                // start



                $row = $this->cbc_m->find($id, 'cbc_subjects');
                if (empty($row)) {
                    $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                    redirect('admin/cbc/subjects');
                }
                $list = $this->cbc_m->list_assigned_classes($id);
                $las = $this->cbc_m->get_la($id);

                foreach ($las as $ll) {
                    foreach ($ll->subs as $sub) {
                        foreach ($sub->tasks as $task) {
                            //delete from cbc_tasks
                            $this->cbc_m->delete_task($task->id);
                        }

                        //delete from cbc_topics
                        $this->cbc_m->delete_row($sub->id, 'cbc_topics');
                    }
                    //delete from cbc_la
                    $this->cbc_m->delete_row($sub->id, 'cbc_la');
                }

                $fn = [];
                foreach ($list as $f) {
                    $fn[] = $f->class_id;
                }
                //remove assigned classes
                foreach ($fn as $n) {
                    $this->cbc_m->remove_assigned($id, $n);
                }
                //delete from cbc_subjects
                $this->cbc_m->delete_row($id, 'cbc_subjects');

                // end 
            }

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Item has been deleted"));
            redirect("admin/cbc/subjects");
        }
    }


    public function index()
    {
        redirect('admin/cbc/subjects');
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['cbc'] = $this->cbc_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' CBC ')->build('admin/list', $data);
    }

    public function update_class_id()
    {

        $cbc = $this->cbc_m->all_cbc();
		
        foreach ($cbc as $c)
        {
			$cls = $c->class_id + 1;
            $this->cbc_m->update_attributes($c->id, array('class_id' => $cls));
		}

     redirect('admin/cbc');
    }
	
    public function assessment()
    {
        $data['tr'] = '';
        //load view
        $this->template->title(' Student Assessment Results')->build('admin/cbc', $data);
    }

    public function summative()
    {
        $this->load->library('Dates');
        // $this->admission_m->passport($stud->photo);
        $result = [];
        $list = [];
        if ($this->input->post())
        {
            $class = $this->input->post('class');
            $students = $this->input->post('students');
            $term = $this->input->post('term');
            $year = $this->input->post('year');

            if ($students)
            {
                $list = $students;
            }
            else
            {
                $list = $this->cbc_m->fetch_students($class,$term, $year);
            }

            $result = [];
            foreach ($list as $key => $k_id)
            {
                $assess = [];
                $summ = $this->cbc_m->get_summ_st($k_id, $term, $year);
                if (!empty($summ))
                {
                    $rw = $this->cbc_m->fetch_class($summ->class);

                    $subjects = empty($rw) ? [] : $this->cbc_m->get_subjects($rw->class);

                    $fsub = [];
                    $ids = [];
                    foreach ($subjects as $s)
                    {
                        $fsub[$s->subject] = $s->name;
                        $ids[] = $s->subject;
                    }

                    $ex = [];
                    $saved = [];
                    $merged = [];

                    $subs = $this->cbc_m->get_summ_ratings($summ->id);

                    foreach ($subs as $s)
                    {
                        $ex[$s->exam] = $s->exam;
                        $saved[$k_id][$s->subject][$s->exam] = $s->rating;
                    }

                    foreach ($saved as $st => $fs)
                    {
                        foreach ($ids as $id)
                        {
                            if (!isset($fs[$id]))
                            {
                                foreach ($ex as $ex_id)
                                {
                                    $fs[$id][$ex_id] = '';
                                }
                            }
                        }
                        $nw_mk = [];
                        foreach ($fs as $sub_id => $exams)
                        {
                            foreach ($ex as $ex_id)
                            {
                                if (!isset($exams[$ex_id]))
                                {
                                    $exams[$ex_id] = '';
                                }
                            }
                            ksort($exams);
                            $nw_mk[$sub_id] = $exams;
                        }
                        ksort($nw_mk);
                        $merged[$st] = $nw_mk;
                    }

                    foreach ($merged as $student => $rbk)
                    {
                        foreach ($rbk as $st_id => $mk)
                        {
                            $subj = isset($fsub[$st_id]) ? $fsub[$st_id] : ' - ';
                            $rmk = [];
                            foreach ($mk as $k_m => $m)
                            {
                                $rmk['exam_' . $k_m] = $m;
                            }
                            $assess[] = ['subject' => $subj, 'exams' => $rmk];
                        }
                    }
                }
                $result[$k_id]['summ'] = $summ;
                $result[$k_id]['assess'] = $assess;

                $rw_s = $this->worker->get_student($k_id);
               
                $rw_s->age = $rw_s->dob > 10000 ? $this->dates->createFromTimeStamp($rw_s->dob)->diffInYears() : '-';
                $result[$k_id]['student'] = $rw_s;
            }

            $data['term'] = $term;
            $data['year'] = $year;
        }


        if($this->input->post('send_sms'))
        {
            $class = $this->input->post('class');
            $students = $this->input->post('students');
            $term = $this->input->post('term');
            $year = $this->input->post('year');

            if ($students)
            {
                $list = $students;
            }
            else
            {
                $list = $this->cbc_m->fetch_students($class,$term, $year);
            }

            $this->sms_summative($list);
        }
        $data['list'] = $list;
        $data['result'] = $result;
        $data['class_types'] = $this->cbc_m->populate('class_groups', 'id', 'type');
        $data['classes'] = $this->cbc_m->populate('classes', 'id', 'class');
        //load view
        $this->template->title(' Summative Assessment')->build('admin/summative', $data);
    }


    function sms_summative($list)
    {
        foreach($list as $key => $std)
        {
            $i++;
            $adm = $this->worker->get_student($key);
            $stud = $adm->first_name . ' ' . $adm->last_name;
            $parent = $this->portal_m->get_parent($adm->parent_id);

            $to = 'Parent/Guardian';
            $link =  base_url();
            $message = $this->school->message_initial . ' ' . $to . ' kindly access your childs assessment report card in your portal. Click on the link below to access your portal, '.$link.' Thanks for choosing ' . $this->school->school;

            $phone = $parent->phone;
            if (empty($phone)) {
                $phone = $parent->mother_phone;
            }
            
            $this->sms_m->send_sms($phone, $message);
 
        }

        $this->worker->sms_callback();
        $found = 'Parent';
        if($i > 1)
        {
            $found = "Parents";
        }
        $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Sent to  ' . $i . ' '. $found));
        redirect('admin/cbc/summative/');
    }

    public function get_table()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->cbc_m->list_assess($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    public function send_reminder($class, $term, $year)
    {
        $stds = $this->cbc_m->get_assess_meta($class, $term, $year);

        $students = $stds->students;

        $i = 0;
        foreach($students as $key => $std)
        {
            $i++;
            $adm = $this->worker->get_student($key);
            $stud = $adm->first_name . ' ' . $adm->last_name;
            $parent = $this->portal_m->get_parent($adm->parent_id);

            $to = 'Parent/Guardian';
            $link =  base_url();
            $message = $this->school->message_initial . ' ' . $to . ' kindly access your childs assessment report card in your portal. Click on the link below to access your portal, '.$link.' Thanks for choosing ' . $this->school->school;

            $phone = $parent->phone;
            if (empty($phone)) {
                $phone = $parent->mother_phone;
            }
            
            $this->sms_m->send_sms($phone, $message);
 
        }

        $this->worker->sms_callback();
        $found = 'Parent';
        if($i > 1)
        {
            $found = "Parents";
        }
        $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Sent to  ' . $i . ' '. $found));
        redirect('admin/cbc/assess_report/'.$class.'/'.$term.'/'.$year);

    }

    public function assess_report($class, $term, $year)
    {
        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);

        if (isset($row->stream))
        {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class))
        {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;

        $result = [];
        if ($this->input->post())
        {
            $student = $this->input->post('student');
            $subject = $this->input->post('subject');
            $option = $this->input->post('format');
            if (!$option)
            {
                $option = 1;
            }

            $assess = $this->cbc_m->get_assess_report($class, $subject, $term, $year, $student);
            $sv = [];
            if ($assess)
            {
                $strands = $this->cbc_m->get_assess_strands($assess->id, 0, $subject);
                if (empty($strands))
                {
                    $subs = $this->cbc_m->get_assess_subs_join($assess->id, $subject);

                    $rt = [];
                    foreach ($subs as $sb)
                    {
                        $sv[$sb->strand]['subs'][$sb->sub_strand] = ['remarks' => $sb->remarks, 'rating' => $sb->rating];

                        $tasks = $this->cbc_m->get_assess_tasks($assess->id, $sb->strand, $sb->sub_strand);
                        foreach ($tasks as $t)
                        {
                            $sv[$t->strand]['subs'][$t->sub_strand]['tasks'][$t->task] = ['task' => $t->task, 'rating' => $t->rating, 'remarks' => $t->remarks];
                        }
                    }
                }
                else
                {
                    foreach ($strands as $str)
                    {
                        $sv[$str->strand]['rating'] = $str->rating;
                        $rt = [];

                        $subs = $this->cbc_m->get_assess_subs($assess->id, $str->strand);

                        if (empty($subs))
                        {
                            //handle empty subs when tasks not empty
                        }
                        else
                        {
                            foreach ($subs as $sb)
                            {
                                $sv[$sb->strand]['subs'][$sb->sub_strand] = ['remarks' => $sb->remarks, 'rating' => $sb->rating];

                                $tasks = $this->cbc_m->get_assess_tasks($assess->id, $sb->strand, $sb->sub_strand);
                                foreach ($tasks as $t)
                                {
                                    $sv[$t->strand]['subs'][$t->sub_strand]['tasks'][$t->task] = ['task' => $t->task, 'rating' => $t->rating, 'remarks' => $t->remarks];
                                }
                            }
                        }
                    }
                }

                $substrands = $this->cbc_m->populate('cbc_topics', 'id', 'name');
                $las = $this->cbc_m->populate('cbc_la', 'id', 'name');
                $task_opts = $this->cbc_m->populate('cbc_tasks', 'id', 'name');

                $this->load->library('Dates');

                $map = [1 => 'BE', 2 => 'AE', 3 => 'ME', 4 => 'EE'];
                $tm = [];
                $ppl = $this->worker->get_student($student);
                $name = $ppl->first_name . ' ' . $ppl->last_name;
                $age = $ppl->dob > 10000 ? $this->dates->createFromTimeStamp($ppl->dob)->diffInYears() : '-';

                foreach ($sv as $strd => $rated)
                {
                    $stw = isset($las[$strd]) ? $las[$strd] : ' - ';
                    $rmk = [];
                    if (isset($rated['subs']))
                    {
                        foreach ($rated['subs'] as $k_s => $r)
                        {

                            
                            $sub_name = isset($substrands[$k_s]) ? $substrands[$k_s] : ' - ';
                            $fn = [];
                            if (isset($r['tasks']))
                            {
                                foreach ($r['tasks'] as $tk)
                                {
                                   
                                    $t_name = isset($task_opts[$tk['task']]) ? $task_opts[$tk['task']] : ' - ';

                                    $t_rt = isset($tk['rating']) ? $tk['rating'] : '';
                                    if ($option == 1)
                                    {
                                        $x_rate = $t_rt ? $t_rt : '';
                                    }
                                    else
                                    {
                                        $x_rate = isset($map[$t_rt]) ? $map[$t_rt] : '';
                                    }

                                
                                    $fn[] = (object) ['task' => $t_name, 'rating' => $x_rate,'remarks' => $tk['remarks']];
                                }
                            }

                          

                            $sb_rt = isset($r['rating']) ? $r['rating'] : '';
                            if ($option == 1)
                            {
                                $q_rate = $sb_rt ? $sb_rt : '';
                            }
                            else
                            {
                                $q_rate = isset($map[$sb_rt]) ? $map[$sb_rt] : '';
                            }
                            $rmk[] = (object) ['name' => $sub_name, 'rating' => $q_rate, 'remarks' => isset($r['remarks']) ? $r['remarks'] : '', 'tasks' => $fn];
                        }
                    }
                    $st_rt = isset($rated['rating']) ? $rated['rating'] : '';
                    if ($option == 1)
                    {
                        $s_rate = $st_rt ? $st_rt : '';
                    }
                    else
                    {
                        $s_rate = isset($map[$st_rt]) ? $map[$st_rt] : '';
                    }
                    $tm[] = (object) ['name' => $stw, 'rating' => $s_rate, 'subs' => $rmk];
                }

                $result = (object) ['student' => $name, 'adm' => $ppl->admission_number, 'age' => $age, 'strands' => $tm];
            }
        }

        $meta = $this->cbc_m->get_assess_meta($class, $term, $year);

        $data['subjects'] = $this->cbc_m->get_subs($meta->subjects);
        $data['students'] = $meta->students;
        $data['term'] = $term;
        $data['class'] = $row;
        $data['year'] = $year;
        $data['result'] = $result;
        $data['payload'] = $assess;

        //load view
        $this->template->title('CBC Assessment Report')->build('admin/assess_report', $data);
    }

    /**
     *
     */
    public function subjects()
    {
        $config = $this->set_paginate_options();
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        $class = 0;
        if ($this->input->post('class'))
        {
            $class = $this->input->post('class');
        }
        $subjects = $this->cbc_m->get_cbc_sub($config['per_page'], $page, $class);
        foreach ($subjects as $s)
        {
            $s->classes = $this->cbc_m->fetch_classes($s->id);
        }

        $data['subjects'] = $subjects;
        $data['cats'] = [0 => "Regular Subject", 1 => "Optional Subject", 2 => "Elective Subject"];
        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        //load view
        $this->template->title('CBC Subjects')->build('subjects/subjects', $data);
    }

    public function setup()
    {
        $subjects = $this->cbc_m->get_cbc_sub();
        foreach ($subjects as $s)
        {
            $s->classes = $this->cbc_m->fetch_classes($s->id);
        }

        $data['subjects'] = $subjects;
        $data['cats'] = [0 => "Regular Subject", 1 => "Optional Subject", 2 => "Elective Subject"];

        $this->template->title('CBC - Configure Exam Subjects')->build('subjects/setup', $data);
    }

    /**
     * learning_areas
     * 
     * @param id $id
     */
    public function learning_areas($id)
    {
        if ($id && $this->input->post('name'))
        {
            $post = $this->input->post('name');
            $i = 0;
            foreach ($post as $p)
            {
                if (empty($p))
                {
                    continue;
                }
                $i++;
                $form = [
                    'subject' => $id,
                    'name' => $p,
                    'status' => 1,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];

                $this->cbc_m->create_sub($form, 'cbc_la');
            }
            if ($i)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                redirect('admin/cbc/learning_areas/' . $id);
            }
        }

        $post = $this->cbc_m->get_la($id);

        foreach ($post as $p)
        {
            $p->topics = $this->cbc_m->get_topics($p->id);
        }

        $data['post'] = $post;
        $data['la'] = $this->cbc_m->find($id, 'cbc_subjects');

        //load view
        $this->template->title('Learning Areas ')->build('subjects/strands', $data);
    }

    function edit_la($id = 0)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/subjects');
        }

        $row = $this->cbc_m->find($id, 'cbc_la');

       
        if (empty($row))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/subjects');
        }

        $data['subject'] = $this->cbc_m->find($row->subject, 'cbc_subjects');

        if ($this->input->post('topic'))
        {
            $post = $this->input->post('topic');
            $i = 0;
            foreach ($post as $p)
            {
                if (empty($p))
                {
                    continue;
                }
                $i++;
                $form = [
                    'name' => $p,
                    'strand' => $id,
                    'status' => 1,
                    'modified_by' => $this->user->id,
                    'modified_on' => time()
                ];

                $this->cbc_m->create_sub($form, 'cbc_topics');
            }
            if ($i)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/cbc/learning_areas/" . $row->subject);
            }
        }

        $row->topics = $this->cbc_m->get_topics($id);

        $data['post'] = $row;
        //load the view and the layout
        $this->template->title('Edit Learning Areas ')->build('subjects/form_la', $data);
    }

    function edit_subject($id = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/subjects');
        }

        $row = $this->cbc_m->find($id, 'cbc_subjects');
        if (empty($row))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/subjects');
        }
        $list = $this->cbc_m->list_assigned_classes($id);
        $fn = [];
        foreach ($list as $f)
        {
            $fn[] = $f->class_id;
        }

        if ($this->input->post())
        {
            $classes = $this->input->post('class');

            $rm = [];
            $add = [];
            foreach ($fn as $n)
            {
                if (!in_array($n, $classes))
                {
                    $rm[] = $n;
                }
            }

            foreach ($classes as $n)
            {
                if (!in_array($n, $fn))
                {
                    $add[] = $n;
                }
            }

            foreach ($add as $cls)
            {
                $sbc = [
                    'class_id' => $cls,
                    'subject_id' => $id,
                    'created_on' => time(),
                ];
                $this->cbc_m->save_by_classes($sbc);
            }
            foreach ($rm as $del)
            {
                $this->cbc_m->remove_assigned($id, $del);
            }

            $form = [
                'name' => $this->input->post('name'),
                'cat' => $this->input->post('cat'),
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $sv = $this->cbc_m->update_with($id, $form, 'cbc_subjects');

            if ($sv)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/cbc/subjects");
            }
        }

        $data['post'] = $row;
        $data['assigned'] = $fn;
        //load the view and the layout
        $this->template->title('Edit Subject ')->build('admin/form_sub', $data);
    }

    function purge($id = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/subjects');
        }

        $row = $this->cbc_m->find($id, 'cbc_subjects');
        if (empty($row))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/subjects');
        }
        $list = $this->cbc_m->list_assigned_classes($id);
        $las = $this->cbc_m->get_la($id);

        foreach ($las as $ll)
        {
            foreach ($ll->subs as $sub)
            {
                foreach ($sub->tasks as $task)
                {
                    //delete from cbc_tasks
                    $this->cbc_m->delete_task($task->id);
                }

                //delete from cbc_topics
                $this->cbc_m->delete_row($sub->id, 'cbc_topics');
            }
            //delete from cbc_la
            $this->cbc_m->delete_row($sub->id, 'cbc_la');
        }

        $fn = [];
        foreach ($list as $f)
        {
            $fn[] = $f->class_id;
        }
        //remove assigned classes
        foreach ($fn as $n)
        {
            $this->cbc_m->remove_assigned($id, $n);
        }
        //delete from cbc_subjects
        $this->cbc_m->delete_row($id, 'cbc_subjects');

        $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Item has been deleted"));
        redirect("admin/cbc/subjects");
    }

    function add_subject()
    {
        //create control variables
        $data['updType'] = 'create';

        //Rules for validation
        $this->form_validation->set_rules($this->subject_validation());
        //validate the fields of form
        if ($this->form_validation->run())
        {
            $form = [
                'name' => $this->input->post('name'),
                'cat' => $this->input->post('cat'),
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $sb_id = $this->cbc_m->create_sub($form, 'cbc_subjects');
            if ($sb_id)
            {
                $classes = $this->input->post('class');

                foreach ($classes as $cl)
                {
                    $sbc = [
                        'class_id' => $cl,
                        'subject_id' => $sb_id,
                        'created_on' => time(),
                    ];
                    $this->cbc_m->save_by_classes($sbc);
                }

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/cbc/subjects');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->subject_validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('CBC Subjects')->build('subjects/create', $data);
        }
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->cbc_m->create($form_data);

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/cbc/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->$field['field'] = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Cbc ')->build('admin/create', $data);
        }
    }

    function edit($id = FALSE, $page = 0)
    {
        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/');
        }
        if (!$this->cbc_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc');
        }
        //search the item to show in edit form
        $get = $this->cbc_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete = array();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {
            $user = $this->ion_auth->get_user();
            // build array for the model
            $form_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->cbc_m->update_attributes($id, $form_data);

            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/cbc/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/cbc/");
            }
        }
        else
        {
            foreach (array_keys($this->validation()) as $field)
            {
                if (isset($_POST[$field]))
                {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Cbc ')->build('admin/create', $data);
    }

    function edit_strand($id = 0, $la = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }
        if (!$this->cbc_m->exists($id, 'cbc_la'))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }
        //fetch item to show in edit form
        $get = $this->cbc_m->find($id, 'cbc_la');

        //create control variables
        $data['updType'] = 'edit';

        if ($this->input->post('name'))
        {
            $form = [
                'name' => $this->input->post('name'),
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $done = $this->cbc_m->update_with($id, $form, 'cbc_la');

            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect('admin/cbc/learning_areas/' . $la);
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect('admin/cbc/learning_areas/' . $la);
            }
        }

        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Strand ')->build('admin/edit_st', $data);
    }

    function edit_sub($id = 0, $la = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }
        if (!$this->cbc_m->exists($id, 'cbc_topics'))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }
        //fetch item to show in edit form
        $get = $this->cbc_m->find($id, 'cbc_topics');

        //create control variables
        $data['updType'] = 'edit';

        if ($this->input->post('name'))
        {
            $form = [
                'name' => $this->input->post('name'),
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $done = $this->cbc_m->update_with($id, $form, 'cbc_topics');

            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect('admin/cbc/learning_areas/' . $la);
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect('admin/cbc/learning_areas/' . $la);
            }
        }

        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Sub Strand ')->build('admin/edit_sub', $data);
    }

    function delete_substrand($id = 0, $la = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }
        if (!$this->cbc_m->exists($id, 'cbc_topics'))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }

        if ($this->cbc_m->delete_row($id, 'cbc_topics'))
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }
        redirect('admin/cbc/learning_areas/' . $la);
    }

    function tasks($id)
    {
        $post = json_decode(file_get_contents('php://input'));

        foreach ($post->tasks as $pt)
        {
            if (empty($pt->name))
            {
                continue;
            }
            $form = [
                'name' => $pt->name,
                'topic' => $id,
                'status' => 1,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $this->cbc_m->create_sub($form, 'cbc_tasks');
        }

        echo json_encode(['code' => 200, 'message' => 'Tasks added Successfully']);
    }

    function update_task($id)
    {
        $post = json_decode(file_get_contents('php://input'));

        if (!empty($post->name))
        {
            $form = [
                'name' => $post->name,
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $this->cbc_m->update_with($id, $form, 'cbc_tasks');
        }

        echo json_encode(['code' => 200, 'message' => 'Task Updated Successfully']);
    }

    function remove_task($id = 0, $parent = 0)
    {
        if (!$id || !$parent)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/subjects');
        }

        if (!$this->cbc_m->task_exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/cbc/subjects');
        }

        //delete the item
        if ($this->cbc_m->delete_task($id) == TRUE)
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/cbc/edit_la/" . $parent);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/cbc');
        }

        //search the item to delete
        if (!$this->cbc_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/cbc');
        }

        //delete the item
        if ($this->cbc_m->delete($id) == TRUE)
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/cbc/");
    }

    private function subject_validation()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|xss_clean|max_length[60]'
            ),
            array(
                'field' => 'cat',
                'label' => 'Subject Category',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/cbc/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 300;
        $config['total_rows'] = $this->cbc_m->count();
        $config['uri_segment'] = 4;

        $config['first_link'] = lang('web_first');
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = lang('web_last');
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = FALSE;
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = FALSE;
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active">  <a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = "<li>";
        $config['num_tag_close'] = '</li>';
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }

    function fix_t($id)
    {
        $per = 3000;
        $strands = $this->cbc_m->fix_cbc($per, $id);
    }

    function fix_class()
    {
        if($this->input->post())
        {


            $form_data = [
                'class_id' => $this->input->post('class_id'),
                'modified_on' =>time(),
                'modified_by' => $this->ion_auth->get_user()->id,
            ];

          
            $ok = $this->cbc_m->update_attributes($this->input->post('item'), $form_data);

             
        }

        $data['subs'] = $this->cbc_m->_get_subs();
        $data['subjects'] = $this->cbc_m->populate('cbc_subjects','id','name');
        $this->template->title('Fix Classes ')->build('admin/fix', $data);
    }

    function add_class()
    {
        $data['id'] = $this->input->get('q');
        
        $this->load->view('admin/add_class', $data);
    }

    function fx_class($id)
    {

        if($this->input->post())
        {
            $items = $this->input->post('items');
            
            foreach($items as $k => $d)
            {
                $ok = $this->cbc_m->delete($d);
            }

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Removed Successfully'));
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Something went wrong'));
            }

            redirect('admin/cbc/subjects');
        }
        $data['subjects'] = $this->cbc_m->populate('cbc_subjects','id','name');
        $data['payload'] = $this->cbc_m->get_the_class($id);
        $this->template->title('Fix Classes ')->build('admin/fix_subs', $data);
    }

    function save_remarks()
    {
        if($this->input->post())
        {
            $this->cbc_m->update_with($this->input->post('pk'), ['headteacher_remarks' => $this->input->post('value')], 'cbc_assess');
        }
        
       
    }

    function score_sheet()
    {
        $payload = [];
        $subjects = [];
        $marks = [];
        $grade_count = [];
        $subject_analysis = [];
        if($this->input->post())
        {

           
            $class = $this->input->post('class');
            $term = $this->input->post('term');
            $year = $this->input->post('year');
            $exam = $this->input->post('exam');
            $payload = $this->cbc_m->_gen_analysis($class, $term, $year, $exam);

         
            $subjects = $this->cbc_m->get_subjs($class);
            $marks = $this->cbc_m->_get_marks($class, $term, $year, $exam);
            $grade_count = $this->cbc_m->_count_grades_per_class($class, $term, $year, $exam);
            $subject_analysis = $this->cbc_m->_subject_analysis($class, $term, $year, $exam);
        }
        $data['payload'] = $payload;
        $data['subjects'] = $subjects;
        $data['marks'] = $marks;
        $data['grade_count'] = $grade_count;
        $data['subject_analysis'] = $subject_analysis;
        $this->template->title('Score Sheet ')->build('admin/score_sheet', $data);
    }


    function tr_analysis()
    {
        $results = [];
        if($this->input->post())
        {
            $post = (object) $this->input->post();

            $results = $this->cbc_m->get_results($post->teacher, $post->term, $post->year, $post->class);

        }

        $map_grades = [
            1 => 'BE',
            2 => 'AE',
            3 => 'ME',
            4 => 'EE'
        ];

        $data['map_grades'] = $map_grades;

        $data['results'] = $results;
        $data['subjects'] = $this->cbc_m->populate('cbc_subjects','id','name');

        $data['teachers'] = $this->cbc_m->get_teachers();
        $this->template->title('CBC Analysis ')->build('admin/tr_analysis', $data);
    }

    function student_analysis()
    {
        $results = [];
        if ($this->input->post()) 
        {
            $post = (object) $this->input->post();

            $results = $this->cbc_m->get_student_analysis($post->student,$post->exam, $post->term, $post->year, $post->class);

           
        }

        $map_grades = [
            1 => 'BE',
            2 => 'AE',
            3 => 'ME',
            4 => 'EE'
        ];


        $data['map_grades'] = $map_grades;

        $data['results'] = $results;
        $data['subjects'] = $this->cbc_m->populate('cbc_subjects', 'id', 'name');

        $data['students'] = $this->cbc_m->all_students();
        $this->template->title('CBC Analysis ')->build('admin/student_analysis', $data);
    }

    function get_remarks()
    {
        if ($this->input->post()) 
        {
            $post = (object) $this->input->post();

            $has_rmks = $this->cbc_m->has_remarks($post->subject, $post->topic, $post->task);

            echo json_encode($has_rmks);
        }
    }


    function add_remarks()
    {
        $mess = [];
        if($this->input->post())
        {
            $post = (object) $this->input->post();

            $form_data = [
                'subject' => $post->subject,
                'la' => $post->la,
                'topic' => $post->topic,
                'task' => $post->task,
                'ee_remarks' => $post->ee_remarks,
                'ae_remarks' => $post->ae_remarks,
                'me_remarks' => $post->me_remarks,
                'be_remarks' => $post->be_remarks,
                'created_on' => time(),
                'created_by' => $this->user->id
            ];

           


            $has_rmks = $this->cbc_m->has_remarks($post->subject, $post->topic, $post->task);

            if($has_rmks)
            {
                $ok = $this->cbc_m->update_with($has_rmks->id, $form_data, 'cbc_remarks');
            }
            else
            {
                $ok =  $this->cbc_m->create_sub($form_data, 'cbc_remarks');
            }


           if($ok)
           {
                $mess = ['status' => 200, 'message' => 'Remarks saved successfully'];
           }else
           {
                $mess = ['status' => 201, 'message' => 'Something went wrong'];
           }

           echo json_encode($mess);
        }
    }

    function delete_strand($id = 0, $la = 0)
    {
        if (!$id) 
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }
        if (!$this->cbc_m->exists($id, 'cbc_topics')) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/cbc/learning_areas/' . $la);
        }

        if ($this->cbc_m->delete_row($id, 'cbc_la')) 
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }
        redirect('admin/cbc/learning_areas/' . $la);
    }

    function map_class()
    {
        $classes = [
            1 => 'Playgroup',
            2 => 'PP1',
            3 => 'PP2',
            4 => 'Grade 1',
            5 => 'Grade 2',
            6 => 'Grade 3',
            7 => 'Grade 4',
            8 => 'Grade 5',
            9 => 'Grade 6',
            10 => 'Grade 7',
            11 => 'Grade 8',
            12 => 'Grade 9',  
        ];

        $jss_classes = [
            1 => 'Grade 7',
            2 => 'Grade 8',
            3 => 'Grade 9',
        ];

        $fn = [];

        foreach($classes as $p => $v)
        {
            $fn[$p] = $v;
        }

        return $fn;
    }

    function mapped_ids()
    {
        //bad => good

        $classes = [
            1 => 1, //play
            2 => 2, //pp1
            3 => 3, //pp2
            4 => 4, //g1
            5 => 5, //g2
            6 => 6, //g3
            7 => 7, //g4
            8 => 8, //g5
            9 => 9, //g6
            10 => 10, //g7
            11 => 11, //g8
            12 => 12, //g9
        ];

        return $classes;
    }

    

    function do_migrate($buff = 1)
    {
       $classes =  $this->map_class();
       $class_map =  $this->mapped_ids();
       $pop = $this->classes;
      
        if($this->input->post())
        {
            $post = (object) $this->input->post();

           
            if (empty($post->class)) 
            {
                $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'Class Not selected'));
                redirect('admin/cbc/do_migrate');
            }
            $class = isset($class_map[$post->class]) ? $class_map[$post->class] : 0;

            if($class == 0)
            {
                $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'Class not mapped!!'));
                redirect('admin/cbc/do_migrate');
            }


           
          

            
            
            ini_set('max_execution_time', 0);
            if ($buff) 
            {
                echo $this->worker->fetch_str();
                echo '<div id="closure" style="width:500px; margin: 100px auto; ">
                <div id="progress"></div>
                <div id="information"></div>
                </div>';
            }
            
            
            $i = 0;
            $payload = $this->cbc_m->_fetch_subjects($class);
            // Loop through subjects
            foreach ($payload['subjects'] as $subject) 
            {
                $i++;

                if ($buff) 
                {
                    $tx = 'Processing ' . $i;
                    $this->worker->show_progress($i, count($payload), $tx);
                }

                $form = [
                    'name' => $subject->name,
                    // 'year' => date('Y'),
                    'cat' => $subject->cat,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];

                $sb_id = $this->cbc_m->create_sub($form, 'cbc_subjects');
                if ($sb_id) 
                {
                    $sbc = [
                        'class_id' => $post->class,
                        'subject_id' => $sb_id,
                        'created_on' => time(),
                    ];
                    $this->cbc_m->save_by_classes($sbc);
                }


                // Loop through strands
                foreach ($subject->items as $lesson) 
                {
                    $form = [
                        'subject' => $sb_id,
                        'name' => $lesson['name'],
                        'status' => 1,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $strand = $this->cbc_m->create_sub($form, 'cbc_la');

                    // Loop through topics
                    foreach ($lesson['topics'] as $topic) 
                    {

                        $form = [
                            'name' => $topic['name'],
                            'strand' => $strand,
                            'status' => 1,
                            'modified_by' => $this->user->id,
                            'modified_on' => time()
                        ];

                        $top = $this->cbc_m->create_sub($form, 'cbc_topics');

                        // Loop through tasks
                        foreach ($topic['tasks'] as $task) 
                        {

                            $form = [
                                'name' => $task['name'],
                                'topic' => $top,
                                'status' => 1,
                                'created_by' => $this->user->id,
                                'created_on' => time()
                            ];

                            $tsk = $this->cbc_m->create_sub($form, 'cbc_tasks');

                            // Loop through remarks
                            foreach ($task['remarks'] as $remark) 
                            {
                                $remark = (array) $remark;

                                $form_data = [
                                    'subject' => $sb_id,
                                    'la' => $strand,
                                    'topic' => $top,
                                    'task' => $tsk,
                                    'ee_remarks' => $remark['ee_remarks'],
                                    'ae_remarks' => $remark['ae_remarks'],
                                    'me_remarks' => $remark['me_remarks'],
                                    'be_remarks' => $remark['be_remarks'],
                                    'created_on' => time(),
                                    'created_by' => $this->user->id
                                ];

                                $rem = $this->cbc_m->create_sub($form_data, 'cbc_remarks');
                               
                            }
                        }
                    }
                }
            }

            if ($buff) 
            {
                $this->worker->close_script();
            }

           echo '<pre>Added ';
           print_r($i);
           echo ' Subjects</pre><hr><br><a href="'.current_url().'">Reload</a>';
           die();

          

 

        }

        $data['pop'] = $pop;
        $this->template->title('CBC Analysis ')->build('admin/migration', $data);
    }

}
