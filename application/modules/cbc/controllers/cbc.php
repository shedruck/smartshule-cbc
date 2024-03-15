<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cbc extends Trs_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cbc_m');
        if (!$this->ion_auth->logged_in())
        {
            redirect('/login');
        }
    }

    public function index()
    {
        $classes = $this->trs_m->list_my_classes();
        $assigned = isset($this->teacher->profile->id) ? $this->trs_m->list_assigned_classes($this->teacher->profile->id) : [];

        $data['classes'] = $classes + $assigned;

        //load view
        $this->template->title(' Student Assessment')->build('trs/cbc', $data);
    }

    public function summative($class)
    {
        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);
        $subjects = $this->cbc_m->get_subjects($row->class);

        if (isset($row->stream))
        {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class))
        {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;

        $data['students'] = $this->cbc_m->get_students($class);
        $data['class'] = $row;

        $data['subjects'] = $subjects;
        $data['exams'] = [['id' => 1, 'name' => 'Opener Exam'], ['id' => 2, 'name' => 'Mid Term'], ['id' => 3, 'name' => 'End Term']];
        //load view
        $this->template->title(' Student Assessment')->build('trs/summative_form', $data);
    }

    public function list_exams()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->cbc_m->get_exams($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    public function assess($class)
    {
        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);
        $subjects = $this->cbc_m->get_subjects($row->class);

        if (isset($row->stream))
        {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class))
        {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;

        $data['students'] = $this->cbc_m->get_students($class);
        $data['class'] = $row;

        $data['subjects'] = $subjects;
        //load view
        $this->template->title(' Student Assessment ')->build('trs/assess', $data);
    }

    public function get_assess($sub = 0)
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $assess = $this->cbc_m->get_assess($post->class, $post->student, $post->subject, $post->term, $post->year);
        $list = $this->cbc_m->get_topics($post->strand->id, $sub);

        $subs = [];
        $tasks = [];
        $fn_sub = [];
        $rm_sub = [];
        $fn_tsk = [];
        $strand = (object) ['rating' => ''];
        if ($assess && $post->strand)
        {
            $strand = $this->cbc_m->get_assess_strands($assess->id, $post->strand->id);

            $subs = $this->cbc_m->get_assess_subs($assess->id);

            foreach ($subs as $s)
            {
                $fn_sub[$s->sub_strand] = $s->rating;
                $rm_sub[$s->sub_strand] = $s->remarks;
            }

            $tasks = $this->cbc_m->get_assess_tasks($assess->id);

            foreach ($tasks as $ts)
            {
                $fn_tsk[$ts->task] = $ts->rating;
            }

            foreach ($list as $ls)
            {
                $ls->rate = (isset($fn_sub[$ls->id])) ? $fn_sub[$ls->id] : '';
                $ls->remarks = (isset($rm_sub[$ls->id])) ? $rm_sub[$ls->id] : '';
                foreach ($ls->tasks as $t)
                {
                    $t->rate = (isset($fn_tsk[$t->id])) ? $fn_tsk[$t->id] : '';
                }
            }
        }

        echo json_encode(['subjects' => $list, 'strand' => $strand, 'results' => ['subs' => $subs, 'tasks' => $tasks]], JSON_NUMERIC_CHECK);
    }

    public function get_summ()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $summ = $this->cbc_m->get_summ($post->class, $post->student, $post->term, $post->year);

        $row = $this->cbc_m->fetch_class($post->class);
        $subjects = $this->cbc_m->get_subjects($row->class);
        foreach ($subjects as $s)
        {
            $s->rate = '';
        }

        $this->load->library('Dates');
        $rw = $this->worker->get_student($post->student);
        $age = $rw->dob > 10000 ? $this->dates->createFromTimeStamp($rw->dob)->diffInYears() : '-';
        $student = ['adm' => $rw->admission_number, 'age' => $age];

        $fn = [];
        if ($summ)
        {
            $res = $this->cbc_m->get_summ_ratings($summ->id, $post->exam);
            foreach ($res as $r)
            {
                $fn[$r->subject] = $r->rating;
            }
            foreach ($subjects as $s)
            {
                $s->rate = isset($fn[$s->subject]) ? $fn[$s->subject] : '';
            }

            echo json_encode(['results' => $subjects, 'student' => $student, 'opening' => $summ->opening, 'closing' => $summ->closing, 'gen_remarks' => str_replace("\n", '', $summ->gen_remarks), 'tr_remarks' => str_replace("\n", '', $summ->tr_remarks)]);
        }
        else
        {
            echo json_encode(['results' => $subjects, 'student' => $student]);
        }
    }

    public function post_summ()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $summ = $this->cbc_m->get_summ($post->class, $post->student, $post->term, $post->year);

        if ($summ)
        {
            $cbc_id = $summ->id;
        }
        else
        {
            $form = [
                'class' => $post->class,
                'student' => $post->student,
                'term' => $post->term,
                'year' => $post->year,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $cbc_id = $this->cbc_m->create_sub($form, 'cbc_summ');
        }

        foreach ($post->assess as $ss)
        {
            $row = $this->cbc_m->get_summ_score($cbc_id, $ss->subject, $post->exam);

            if ($row)
            {
                $form = [
                    'rating' => $ss->rate,
                    'modified_by' => $this->user->id,
                    'modified_on' => time()
                ];

                $this->cbc_m->update_with($row->id, $form, 'cbc_summ_score');
            }
            else
            {
                $form = [
                    'cbc_id' => $cbc_id,
                    'subject' => $ss->subject,
                    'exam' => $post->exam,
                    'rating' => $ss->rate,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];

                $this->cbc_m->create_sub($form, 'cbc_summ_score');
            }
        }

        echo json_encode(['message' => 'success']);
    }

    public function post_summ_remarks()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $student = $post->student->id;
        $term = $post->term->id;
        $year = $post->year->id;
        $summ = $this->cbc_m->get_summ($post->class, $student, $term, $year);

        $map = [
            1 => 'gen_remarks',
            2 => 'tr_remarks',
            3 => 'closing',
            4 => 'opening',
        ];
        if ($summ)
        {
            $form = [
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $form[$map[$post->cat]] = $post->remarks;
            $this->cbc_m->update_with($summ->id, $form, 'cbc_summ');
        }
        else
        {
            $form = [
                'class' => $post->class,
                'student' => $student,
                'term' => $term,
                'year' => $year,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];
            $form[$post->cat == 1 ? 'gen_remarks' : 'tr_remarks'] = $post->remarks;

            $this->cbc_m->create_sub($form, 'cbc_summ');
        }

        echo json_encode(['message' => 'success']);
    }

    public function post_ratings()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $student = $post->student->id;
        $term = $post->term->id;
        $year = $post->year->id;
        $subject = $post->subject->id;
        $assess = $this->cbc_m->get_assess($post->class, $student, $subject, $term, $year);

        if ($assess)
        {
            $ss_id = $assess->id;
        }
        else
        {
            $form = [
                'class' => $post->class,
                'student' => $student,
                'term' => $term,
                'year' => $year,
                'subject' => $subject,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');
        }

        $row = $this->cbc_m->get_strand_rating($ss_id, $post->strand);
        if ($row)
        {
            $form = [
                'rating' => $post->rating,
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $this->cbc_m->update_with($row->id, $form, 'cbc_assess_strands');
        }
        else
        {
            $form = [
                'assess_id' => $ss_id,
                'strand' => $post->strand,
                'rating' => $post->rating,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $this->cbc_m->create_sub($form, 'cbc_assess_strands');
        }

        echo json_encode(['message' => 'success']);
    }

    public function post_subs()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);
        $assess = $this->cbc_m->get_assess($post->class, $post->student, $post->subject, $post->term, $post->year);

        if ($assess)
        {
            $ss_id = $assess->id;
        }
        else
        {
            $form = [
                'class' => $post->class,
                'student' => $post->student,
                'term' => $post->term,
                'year' => $post->year,
                'subject' => $post->subject,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');
        }

        $row = $this->cbc_m->get_sub_rating($ss_id, $post->strand, $post->sub);

        if ($row)
        {
            $form = [
                'remarks' => $post->rating,
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $this->cbc_m->update_with($row->id, $form, 'cbc_assess_sub');
        }
        else
        {
            $form = [
                'assess_id' => $ss_id,
                'strand' => $post->strand,
                'sub_strand' => $post->sub,
                'remarks' => $post->rating,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $this->cbc_m->create_sub($form, 'cbc_assess_sub');
        }

        echo json_encode(['message' => 'success']);
    }

    /**
     * post_rubric
     */
    public function post_rubric()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $assess = $this->cbc_m->get_assess($post->class, $post->student, $post->subject, $post->term, $post->year);

        if ($assess)
        {
            $ss_id = $assess->id;
        }
        else
        {
            $form = [
                'class' => $post->class,
                'student' => $post->student,
                'term' => $post->term,
                'year' => $post->year,
                'subject' => $post->subject,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');
        }

        $sr = $this->cbc_m->get_strand_rating($ss_id, $post->strand);
        if ($sr)
        {
            $form = [
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];
            if (isset($post->rating))
            {
                $form['rating'] = $post->rating;
            }

            $this->cbc_m->update_with($sr->id, $form, 'cbc_assess_strands');
        }
        else
        {
            if (isset($post->rating))
            {
                $form = [
                    'assess_id' => $ss_id,
                    'strand' => $post->strand,
                    'rating' => $post->rating,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];

                $this->cbc_m->create_sub($form, 'cbc_assess_strands');
            }
        }

        foreach ($post->assess as $s)
        {
            $row = $this->cbc_m->get_sub_rating($ss_id, $post->strand, $s->id);
            if ($row)
            {
                $form = [
                    'rating' => $s->rate,
                    'modified_by' => $this->user->id,
                    'modified_on' => time()
                ];

                $this->cbc_m->update_with($row->id, $form, 'cbc_assess_sub');
            }
            else
            {
                $form = [
                    'assess_id' => $ss_id,
                    'strand' => $post->strand,
                    'sub_strand' => $s->id,
                    'rating' => $s->rate,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];

                $this->cbc_m->create_sub($form, 'cbc_assess_sub');
            }
            foreach ($s->tasks as $t)
            {
                $sk = $this->cbc_m->get_task_rating($ss_id, $post->strand, $s->id, $t->id);
                if ($sk)
                {
                    $form = [
                        'rating' => $t->rate,
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->cbc_m->update_with($sk->id, $form, 'cbc_assess_tasks');
                }
                else
                {
                    $form = [
                        'assess_id' => $ss_id,
                        'strand' => $post->strand,
                        'sub_strand' => $s->id,
                        'task' => $t->id,
                        'rating' => $t->rate,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $this->cbc_m->create_sub($form, 'cbc_assess_tasks');
                }
            }
        }

        echo json_encode(['message' => 'success']);
    }

    public function post_tasks()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $assess = $this->cbc_m->get_assess($post->class, $post->student, $post->subject, $post->term, $post->year);
        if ($assess)
        {
            $ss_id = $assess->id;
        }
        else
        {
            $form = [
                'class' => $post->class,
                'student' => $post->student,
                'term' => $post->term,
                'year' => $post->year,
                'subject' => $post->subject,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');
        }

        $row = $this->cbc_m->get_task_rating($ss_id, $post->strand, $post->sub, $post->task);
        if ($row)
        {
            $form = [
                'rating' => $post->rating,
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];

            $this->cbc_m->update_with($row->id, $form, 'cbc_assess_tasks');
        }
        else
        {
            $form = [
                'assess_id' => $ss_id,
                'strand' => $post->strand,
                'sub_strand' => $post->sub,
                'task' => $post->task,
                'rating' => $post->rating,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $this->cbc_m->create_sub($form, 'cbc_assess_tasks');
        }

        echo json_encode(['message' => 'success']);
    }

    public function strands($id)
    {
        $strands = $this->cbc_m->get_la($id);

        echo json_encode($strands);
    }

    public function list_strands($id)
    {
        $strands = $this->cbc_m->get_la($id);

        $fn = [];
        foreach ($strands as $s)
        {
            $fn[] = ['id' => $s->id, 'name' => $s->name];
        }

        echo json_encode(['strands' => $fn]);
    }

    public function list_sub_strands($id)
    {
        $strands = $this->cbc_m->get_topics($id);

        $fn = [];
        foreach ($strands as $s)
        {
            $fn[] = ['id' => $s->id, 'name' => $s->name];
        }

        echo json_encode(['subs' => $fn]);
    }

    public function sub_strands($id)
    {
        $topics = $this->cbc_m->get_topics($id);
        echo json_encode($topics);
    }

    public function social_report($class)
    {
        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);
        $subjects = $this->cbc_m->get_subjects($row->class);

        if (isset($row->stream))
        {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class))
        {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;

        $data['students'] = $this->cbc_m->get_students($class);
        $data['class'] = $row;
        $data['subjects'] = $subjects;
        $classes = $this->trs_m->list_my_classes();
        $assigned = isset($this->teacher->profile->id) ? $this->trs_m->list_assigned_classes($this->teacher->profile->id) : [];

        $data['classes'] = $classes + $assigned;
        //load view
        $this->template->title('Assessment - Social Behavior Report')->build('trs/social', $data);
    }

    public function get_social()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);
        $assess = $this->cbc_m->get_social($post->class, $post->student, $post->term, $post->year);

        if ($assess)
        {
            echo json_encode(['results' => [
                    'cons' => $assess->cons,
                    'org' => $assess->org,
                    'comm' => $assess->comm,
                    'accept' => $assess->accept,
                    'ind' => $assess->ind,
                    'others' => $assess->others,
                    'school' => $assess->school,
                    'home' => $assess->home,
                    'cs' => $assess->cs,
                    'rev' => $assess->rev,
                    'property' => $assess->property,
                    'groupw' => $assess->groupw,
                    'coop' => $assess->coop,
                    'time_' => $assess->time_,
                    'conf' => $assess->conf,
                    'conce' => $assess->conce,
                    'punctual' => $assess->punctual,
                    'motivation' => $assess->motivation,
                    'fluent' => $assess->fluent,
                    'mtrr' => $assess->mtrr,
                    'speed' => $assess->speed,
                    'kasi' => $assess->kasi,
                    'compr' => $assess->compr,
                    'klw' => $assess->klw,
                    'exte' => $assess->exte,
                    'ziada' => $assess->ziada,
                    'tone' => $assess->tone,
                    'sauti' => $assess->sauti,
                    'spell' => $assess->spell,
                    'hj' => $assess->hj,
                    'remarks' => $assess->remarks
            ]]);
        }
        else
        {
            echo json_encode(['results' => [
                    'cons' => '',
                    'org' => '',
                    'comm' => '',
                    'accept' => '',
                    'ind' => '',
                    'others' => '',
                    'school' => '',
                    'home' => '',
                    'cs' => '',
                    'rev' => '',
                    'property' => '',
                    'groupw' => '',
                    'coop' => '',
                    'time_' => '',
                    'conf' => '',
                    'conce' => '',
                    'punctual' => '',
                    'motivation' => '',
                    'fluent' => '',
                    'mtrr' => '',
                    'speed' => '',
                    'kasi' => '',
                    'compr' => '',
                    'klw' => '',
                    'exte' => '',
                    'ziada' => '',
                    'tone' => '',
                    'sauti' => '',
                    'spell' => '',
                    'hj' => '',
                    'remarks' => ''
            ]]);
        }
    }

    public function get_social_report()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $result = $this->cbc_m->get_social_report($post->class, $post->term, $post->year);

        $this->load->library('Dates');
        $fn = [];
        foreach ($result as $r)
        {
            $st = $this->worker->get_student($r->student);
            $age = $st->dob > 10000 ? $this->dates->createFromTimeStamp($st->dob)->diffInYears() : '-';
            $fn[] = [
                'name' => $st->first_name . ' ' . $st->last_name,
                'adm' => $st->admission_number,
                'age' => $age,
                'cons' => $r->cons,
                'org' => $r->org,
                'comm' => $r->comm,
                'accept' => $r->accept,
                'ind' => $r->ind,
                'others' => $r->others,
                'school' => $r->school,
                'home' => $r->home,
                'cs' => $r->cs,
                'rev' => $r->rev,
                'property' => $r->property,
                'groupw' => $r->groupw,
                'coop' => $r->coop,
                'time_' => $r->time_,
                'conf' => $r->conf,
                'conce' => $r->conce,
                'punctual' => $r->punctual,
                'motivation' => $r->motivation,
                'fluent' => $r->fluent,
                'mtrr' => $r->mtrr,
                'speed' => $r->speed,
                'kasi' => $r->kasi,
                'compr' => $r->compr,
                'klw' => $r->klw,
                'exte' => $r->exte,
                'ziada' => $r->ziada,
                'tone' => $r->tone,
                'sauti' => $r->sauti,
                'spell' => $r->spell,
                'hj' => $r->hj,
                'remarks' => $r->remarks
            ];
        }

        echo json_encode(['results' => $fn]);
    }

    public function post_social()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $social = [];

        foreach ((array) $post->social as $k => $s)
        {
            if (!empty($s))
            {
                $social[$k] = $s;
            }
        }
        if (empty($social))
        {
            echo json_encode(['message' => 'Empty']);
            exit();
        }
        else
        {
            $student = $post->student->id;
            $term = $post->term->id;
            $year = $post->year->id;

            $assess = $this->cbc_m->get_social($post->class, $student, $term, $year);

            if ($assess)
            {
                //update
                $social['modified_by'] = $this->user->id;
                $social['modified_on'] = time();
                $this->cbc_m->update_with($assess->id, $social, 'cbc_social');
            }
            else
            {
                $form = [
                    'class' => $post->class,
                    'student' => $student,
                    'term' => $term,
                    'year' => $year,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];
                foreach ($social as $kk => $val)
                {
                    $form[$kk] = $val;
                }

                $this->cbc_m->create_sub($form, 'cbc_social');
            }

            echo json_encode(['message' => 'Success']);
        }
    }

    public function summative_report($class)
    {
        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);
        $subjects = $this->cbc_m->get_subjects($row->class);

        if (isset($row->stream))
        {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class))
        {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;
        $data['students'] = $this->cbc_m->get_students($class);
        $data['class'] = $row;
        $data['subjects'] = $subjects;
        $classes = $this->trs_m->list_my_classes();
        $assigned = isset($this->teacher->profile->id) ? $this->trs_m->list_assigned_classes($this->teacher->profile->id) : [];

        $data['classes'] = $classes + $assigned;
        //load view
        $this->template->title('Assessment - Summative Report')->build('trs/summative', $data);
    }

    public function get_summ_report()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $rw = $this->cbc_m->fetch_class($post->class);
        if (empty($rw))
        {
            echo json_encode(['results' => []]);
            exit();
        }
        $map = [1 => 'BE', 2 => 'AE', 3 => 'ME', 4 => 'EE'];
        $res = $this->cbc_m->get_summ_report($post->class, $post->term, $post->year);
        $subjects = $this->cbc_m->get_subjects($rw->class);

        $fsub = [];
        $ids = [];
        foreach ($subjects as $s)
        {
            $fsub[$s->subject] = $s->name;
            $ids[] = $s->subject;
        }
        $fn = [];
        $ex = [];
        $saved = [];
        $merged = [];

        $this->load->library('Dates');
        foreach ($res as $r)
        {
            $subs = $this->cbc_m->get_summ_ratings($r->id);
            $st = $this->worker->get_student($r->student);
            $age = $st->dob > 10000 ? $this->dates->createFromTimeStamp($st->dob)->diffInYears() : '-';

            foreach ($subs as $s)
            {
                $ex[$s->exam] = $s->exam;
                $saved[$r->student][$s->subject][$s->exam] = $s->rating;
            }

            $fn[$r->student] = [
                'adm' => $st->admission_number,
                'age' => $age,
                'gen_remarks' => $r->gen_remarks,
                'tr_remarks' => $r->tr_remarks,
                'closing' => $r->closing,
                'opening' => $r->opening,
            ];
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

        $result = [];
        foreach ($merged as $student => $assess)
        {
            $tm = [];
            $st = $this->worker->get_student($student);
            $name = $st->first_name . ' ' . $st->last_name;

            foreach ($assess as $sid => $mk)
            {
                $subj = isset($fsub[$sid]) ? $fsub[$sid] : ' - ';
                $rmk = [];
                $rtd = [];

                $wx = array_filter($mk, function ($x)
                {
                    return !empty($x);
                });

                if (!isset($wx[4]))
                {
                    $wx[4] = array_sum($wx) ? floor(array_sum($wx) / count($wx)) : '';
                }
                foreach ($wx as $k_m => $m)
                {
                    $gd = $m;
                    if ($post->option == 2)
                    {
                        $gd = isset($map[$m]) ? $map[$m] : '';
                    }
                    $rmk['exam_' . $k_m] = $gd;
                    $rtd[] = ['exam' => $k_m, 'rate' => $gd];
                }

                $tm[] = ['subject' => $subj, 'exams' => $rmk, 'rub' => $rtd];
            }

            $result[] = ['student' => $name, 'meta' => $fn[$student], 'assess' => $tm];
        }

        echo json_encode(['results' => $result]);
    }

    public function assess_report($class)
    {
        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);
        $subjects = $this->cbc_m->get_subjects($row->class);

        if (isset($row->stream))
        {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class))
        {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;
        $data['students'] = $this->cbc_m->get_students($class);
        $data['class'] = $row;
        $data['subjects'] = $subjects;
        $classes = $this->trs_m->list_my_classes();
        $assigned = isset($this->teacher->profile->id) ? $this->trs_m->list_assigned_classes($this->teacher->profile->id) : [];

        $data['classes'] = $classes + $assigned;
        //load view
        $this->template->title('CBC Assessment Report')->build('trs/assess_report', $data);
    }

    public function get_assess_report()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        $rw = $this->cbc_m->fetch_class($post->class);
        if (empty($rw))
        {
            echo json_encode(['results' => []]);
            exit();
        }

        $assess = $this->cbc_m->get_assess_report($post->class, $post->subject, $post->term, $post->year);
        if (empty($assess))
        {
            echo json_encode(['results' => []]);
            exit();
        }

        $sv = [];
        foreach ($assess as $s)
        {
            $strands = $this->cbc_m->get_assess_strands($s->id, 0, $post->subject);

            if (empty($strands))
            {
                $subs = $this->cbc_m->get_assess_subs_join($s->id, $post->subject);

                $rt = [];
                foreach ($subs as $sb)
                {
                    //$sv[$s->student][$sb->strand]['rating'] = $sb->rating;
                    $sv[$s->student][$sb->strand]['subs'][$sb->sub_strand] = ['remarks' => $sb->remarks, 'rating' => $sb->rating];

                    $tasks = $this->cbc_m->get_assess_tasks($s->id, $sb->strand, $sb->sub_strand);
                    foreach ($tasks as $t)
                    {
                        $sv[$s->student][$t->strand]['subs'][$t->sub_strand]['tasks'][$t->task] = ['task' => $t->task, 'rating' => $t->rating];
                    }
                }
            }
            else
            {
                foreach ($strands as $str)
                {
                    $sv[$s->student][$str->strand]['rating'] = $str->rating;
                    $rt = [];

                    $subs = $this->cbc_m->get_assess_subs($s->id, $str->strand);

                    if (empty($subs))
                    {
                        //handle empty subs when tasks not empty
                    }
                    else
                    {
                        foreach ($subs as $sb)
                        {
                            $sv[$s->student][$sb->strand]['subs'][$sb->sub_strand] = ['remarks' => $sb->remarks, 'rating' => $sb->rating];

                            $tasks = $this->cbc_m->get_assess_tasks($s->id, $sb->strand, $sb->sub_strand);
                            foreach ($tasks as $t)
                            {
                                $sv[$s->student][$t->strand]['subs'][$t->sub_strand]['tasks'][$t->task] = ['task' => $t->task, 'rating' => $t->rating];
                            }
                        }
                    }
                }
            }
        }

        $result = [];
        $substrands = $this->cbc_m->populate('cbc_topics', 'id', 'name');
        $las = $this->cbc_m->populate('cbc_la', 'id', 'name');
        $task_opts = $this->cbc_m->populate('cbc_tasks', 'id', 'name');

        $this->load->library('Dates');

        $map = [1 => 'BE', 2 => 'AE', 3 => 'ME', 4 => 'EE'];
        foreach ($sv as $student => $p_assess)
        {
            $tm = [];
            $ppl = $this->worker->get_student($student);
            $name = $ppl->first_name . ' ' . $ppl->last_name;
            $age = $ppl->dob > 10000 ? $this->dates->createFromTimeStamp($ppl->dob)->diffInYears() : '-';

            foreach ($p_assess as $strd => $rated)
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
                                if ($post->option == 1)
                                {
                                    $x_rate = $t_rt ? $t_rt : '';
                                }
                                else
                                {
                                    $x_rate = isset($map[$t_rt]) ? $map[$t_rt] : '';
                                }
                                $fn[] = ['task' => $t_name, 'rating' => $x_rate];
                            }
                        }

                        $sb_rt = isset($r['rating']) ? $r['rating'] : '';
                        if ($post->option == 1)
                        {
                            $q_rate = $sb_rt ? $sb_rt : '';
                        }
                        else
                        {
                            $q_rate = isset($map[$sb_rt]) ? $map[$sb_rt] : '';
                        }
                        $rmk[] = ['name' => $sub_name, 'rating' => $q_rate, 'remarks' => isset($r['remarks']) ? $r['remarks'] : '', 'tasks' => $fn];
                    }
                }
                $st_rt = isset($rated['rating']) ? $rated['rating'] : '';
                if ($post->option == 1)
                {
                    $s_rate = $st_rt ? $st_rt : '';
                }
                else
                {
                    $s_rate = isset($map[$st_rt]) ? $map[$st_rt] : '';
                }
                $tm[] = ['name' => $stw, 'rating' => $s_rate, 'subs' => $rmk];
            }

            $result[] = ['student' => $name, 'adm' => $ppl->admission_number, 'age' => $age, 'strands' => $tm];
        }

        echo json_encode(['results' => $result]);
    }

}
