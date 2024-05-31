<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trs extends Trs_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cbc_m');
        $this->load->model('cbc_tr');
        if (!$this->ion_auth->logged_in()) {
            redirect('/login');
        }

        $this->cbc =  $this->cbc_tr;
    }


    public function index()
    {
        //load view
        $this->template->title(' CBC Assessment')->build('teachers/index', []);
    }

    function begin_form()
    {
        $data['classes'] = $this->cbc_tr->my_classes();
        $this->template->title(' Formative Assessment')->build('teachers/formative', $data);
    }

    function init_form($class)
    {
        $data[] = [];
        $this->template->title(' Formative Assessment')->build('teachers/formative', $data);
    }

    function get_subjects($c)
    {
        $payload = $this->cbc_tr->find_allocation($c);

        $cls = isset($this->streams[$c]) ? $this->streams[$c]  : '';
        echo json_encode(['load' => $payload, 'class' => $cls]);
    }

    function get_subjects_for_summ($c)
    {
        $payload = $this->cbc_tr->find_allocation2($c);

        $cls = isset($this->streams[$c]) ? $this->streams[$c]  : '';
        echo json_encode(['load' => $payload, 'class' => $cls]);
    }

    //Function to Summative
    function do_summative($class, $subject, $exam = false)
    {
        $this->load->helper('form');
        $args = func_get_args();
        $subjects = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
        $su =  isset($subjects[$subject]) ? $subjects[$subject] : 'Subject';
        $data['strands'] =  $this->cbc->fetch_strands($subject);

        $data['substrands'] = $this->cbc->fetch_substrands();
        $data['subject'] = $su;
        $data['class'] = isset($this->streams[$class]) ? $this->streams[$class] : '';


        $data['exam_type'] = $this->cbc_tr->get_exam($exam);

        if ($exam) {
            $students = $this->cbc_tr->get_students($class);
            $data['students'] = $students;
        }


        if ($this->input->post()) {
            $k = 0;
            $kk = 0;
            $post = (object) $this->input->post();
            $stus = $post->student;

            $classgrp = $this->cbc_tr->get_classgrp($class);

            foreach ($stus as $keey => $st) {
                $form_data = array(
                    'sub' => $subject,
                    'exam' => $exam,
                    'student' => $st,
                    'class' => $class,
                    'class_grp' => $classgrp->class,
                    'gid' => $post->grading,
                    'score' => $post->score[$st],
                    'type' => $post->extype,
                    'outof' => $post->outof,

                );

                //Check if marks Exists
                $checkmarks = $this->cbc_tr->get_stu_marks($subject, $exam, $st);

                if ($checkmarks) {
                    //Update
                    $form_data['modified_by'] = $this->user->id;
                    $form_data['modified_on'] = time();
                    $done = $this->cbc_tr->update_with($checkmarks->id, $form_data, 'cbc_marks');

                    if ($done) {
                        $k++;
                    }
                } else {
                    //Insert
                    $form_data['created_by'] = $this->user->id;
                    $form_data['created_on'] = time();
                    $ok = $this->cbc_tr->create_marks('cbc_marks', $form_data);
                    if ($ok) {
                        $kk++;
                    }
                }
            }

            if ($kk > 0) {
                $inserted_message = $kk . ' records successfully Inserted.';
                $this->session->set_flashdata('inserted_message', array('type' => 'success', 'text' => $inserted_message));
            }
            if ($k > 0) {
                // Set session message for updated records
                $updated_message = $k . ' records successfully updated.';
                $this->session->set_flashdata('updated_message', array('type' => 'success', 'text' => $updated_message));
            }
            redirect("cbc/trs/do_summative/" . $class . "/" . $subject . "/" . $exam);
        }



        $data['exams'] = $this->cbc_tr->exams();
        $data['attr'] = $args;
        $data['gradings'] = $this->cbc_tr->populate('grading_system', 'id', 'title');
        $data['exam'] = $exam;
        $data['cls'] = $class;
        $data['sub'] = $subject;

        $this->template->title($su . ' assessment')->build('teachers/summative_form', $data);
    }

    function do_formative($class, $subject)
    {

        $args = func_get_args();
        $subjects = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
        $su =  isset($subjects[$subject]) ? $subjects[$subject] : 'Subject';
        $data['strands'] =  $this->cbc->fetch_strands($subject);

        $data['substrands'] = $this->cbc->fetch_substrands();
        $data['subject'] = $su;
        $data['class'] = isset($this->streams[$class]) ? $this->streams[$class] : '';


        if ($this->input->get()) {
            $get = (object) $this->input->get();
            $rubric =  $this->cbc->fetch_tasks($subject, $get->strand, $get->substrand);
            $data['rubric'] = $rubric;

            $strands =  $this->cbc->populate('cbc_la', 'id', 'name');
            $tasks =  $this->cbc->populate('cbc_topics', 'id', 'name');

            $data['strand'] = isset($strands[$get->strand]) ? $strands[$get->strand] : '';
            $data['substrand'] = isset($tasks[$get->substrand]) ? $tasks[$get->substrand] : '';
        }

        $data['attr'] = $args;

        $this->template->title($su . ' assessment')->build('teachers/formative_form', $data);
    }


    function perform_assessment()
    {
        if ($this->input->get()) {
            $get =  (object) $this->input->get();

            $post = (object) $this->cbc->decryptParameters($get->arg);


            $payload = $this->cbc->get_assessd($post);

            $students =  $this->cbc->get_students($post->class);

            $subjects = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
            $data['subject_name'] =  isset($subjects[$post->subject]) ? $subjects[$post->subject] : 'Subject';
            $data['class_name'] =  isset($this->streams[$post->class]) ? $this->streams[$post->class] : 'class';

            $data['students'] = $students;

            $data['post'] = $post;

            $data['payload'] = $payload;
            $data['task'] = $this->cbc->find_task($post->task);
        }

        $this->template->title('Formative Assessment')->build('teachers/forma_form', $data);
    }


    function get_comments()
    {
        if ($this->input->post()) {
            $post = (object) $this->input->post();
            $rmks  = $this->cbc->fetch_remark($post->post_data['subject'], $post->post_data['strand'], $post->post_data['substrand'], $post->post_data['task']);


            $remarks = [
                4 => $rmks->ee_remarks,
                3 => $rmks->me_remarks,
                2 => $rmks->ae_remarks,
                1 => $rmks->be_remarks
            ];

            $result = '';


            switch ($post->score) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $result = $remarks[$post->score];
                    break;
                default:
                    $result = "--";
                    break;
            }

            // Output the result
            echo json_encode($result);
        }
    }

    function save_assesment()
    {
        if ($this->input->post()) {
            $post = (object) $this->input->post();

            $p = (object) $this->cbc->decryptParameters($post->params);


            $session = bin2hex(random_bytes(16)) . base64_encode($this->user->id . date('i'));

            foreach ($post->student as $st => $student) {

                // learning area
                $assess = $this->cbc_m->get_assess($p->class, $st, $p->subject, $this->school->term, $this->school->year);
                if ($assess) {
                    $ss_id = $assess->id;
                } else {
                    $form = [
                        'class' => $p->class,
                        'student' => $st,
                        'term' => $this->school->term,
                        'year' => $this->school->year,
                        'subject' => $p->subject,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');
                }


                $rating = isset($post->score[$st]) ? $post->score[$st] : '';
                $remarks = isset($post->remarks[$st]) ? $post->remarks[$st] : '';



                // strand

                $sr = $this->cbc_m->get_strand_rating($ss_id, $p->strand);

                if ($sr) {
                    $form = [
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->cbc_m->update_with($sr->id, $form, 'cbc_assess_strands');
                } else {
                    if (isset($p->strand)) {
                        $form = [
                            'assess_id' => $ss_id,
                            'strand' => $p->strand,
                            'created_by' => $this->user->id,
                            'created_on' => time()
                        ];

                        $this->cbc_m->create_sub($form, 'cbc_assess_strands');
                    }
                }


                // substrand
                $row = $this->cbc_m->get_sub_rating($ss_id, $p->strand, $p->substrand);

                if ($row) {
                    $form = [
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->cbc_m->update_with($row->id, $form, 'cbc_assess_sub');
                } else {
                    $form = [
                        'assess_id' => $ss_id,
                        'strand' => $p->strand,
                        'sub_strand' => $p->substrand,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $this->cbc_m->create_sub($form, 'cbc_assess_sub');
                }


                // task
                $sk = $this->cbc_m->get_task_rating($ss_id, $p->strand, $p->substrand, $p->task);

                if ($sk) {
                    $form = [
                        'rating' => $rating,
                        'status' => ($post->publish == 1) ? 1 : 0,
                        'session' => $session,
                        'remarks' => $remarks,
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $ok =  $this->cbc_m->update_with($sk->id, $form, 'cbc_assess_tasks');
                } else {
                    $form = [
                        'assess_id' => $ss_id,
                        'subject' => $p->subject,
                        'strand' => $p->strand,
                        'student' => $st,
                        'session' => $session,
                        'status' => ($post->publish == 1) ? 1 : 0,
                        'sub_strand' => $p->substrand,
                        'task' => $p->task,
                        'rating' => $rating,
                        'remarks' => $remarks,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $done =  $this->cbc_m->create_sub($form, 'cbc_assess_tasks');
                }
            }

            if ($ok || $done) {
                redirect('cbc/trs/begin_form');
            }
        }
    }

    function begin_summative_form()
    {
        $data['classes'] = $this->cbc_tr->my_classes();
        $cls = $this->cbc_tr->my_classes();
        $this->template->title('Summative Assessment')->build('teachers/summative', $data);
    }

    function set_exam()
    {


        if ($this->input->post()) {

            $post = (object) $this->input->post();

            $edate = strtotime($post->edate);
            $sdate = strtotime($post->sdate);
            $rdate = strtotime($post->rdate);


            $form = [
                'exam' => $post->exam,
                'term' => $post->term,
                'year' => $post->year,
                'sdate' => $sdate,
                'edate' => $edate,
                'rdate' => $rdate,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];


            $ok = $this->cbc_tr->create_exam($form, 'cbc_threads');
        }


        if ($ok) {
            // Set session message for updated records
            $created_message = 'Exam successfully created';
            $this->session->set_flashdata('created_message', array('type' => 'success', 'text' => $created_message));

            redirect("cbc/trs/all_exams/");
        }

        $this->template->title('Exam Setup')->build('teachers/set_exam');
    }

    function all_exams()
    {

        $data['exams'] = $this->cbc_tr->all_exams();

        $this->template->title('All Exams')->build('teachers/exams', $data);
    }

    function manage_exams($id)
    {


        $data['result1'] = $this->cbc_tr->get_exam($id);

        $data['exam'] = $id;

        $data['classes'] = $this->cbc_tr->all_classgroups();

        $data['gradings'] = $this->cbc_tr->populate('grading_system', 'id', 'title');

        $this->template->title('Manage Exams')->build('teachers/manage', $data);
    }

    function save_setting($exam, $class)
    {


        if ($this->input->post()) {

            $form = [
                'class' => $class,
                'exam' => $exam,
                'gs_system' => $this->input->post('gs_system_' . $class),
                'type' => $this->input->post('type_' . $class),
                'compute' => $this->input->post('compute_' . $class),
                'rubric' => $this->input->post('rubric_' . $class),
                'marks' => $this->input->post('marks_' . $class),
                'comments' => $this->input->post('comments_' . $class),
                'teacher' => $this->input->post('teacher_' . $class),
                'grade' => $this->input->post('grade_' . $class),
                'position' => $this->input->post('position_' . $class),
                'created_by' => $this->user->id,
                'created_On' => time()
            ];


            $ok = $this->cbc_tr->exam_setting($form, 'cbc_settings');

            if ($ok) {

                $form1 = [
                    'type' => $this->input->post('type_' . $class),
                    'modified_by' => $this->user->id,
                    'modified_on' => time()
                ];

                $md = $this->cbc_tr->exam_update($exam, $form1, 'cbc_threads');
            }

            if ($md) {
                // Set session message for updated records
                $created_message = 'Exam Settings successfully Done';
                $this->session->set_flashdata('created_message', array('type' => 'success', 'text' => $created_message));

                redirect("cbc/trs/manage_exams/" . $exam);
            }
        }
    }

    function edit_settings($id, $exam, $class)
    {

        $data['result'] =  $this->cbc_tr->get_settings_by_id($id);
        $data['gradings'] = $this->cbc_tr->populate('grading_system', 'id', 'title');
        $data['exam'] = $exam;

        if ($this->input->post()) {


            $form = [
                'class' => $class,
                'exam' => $exam,
                'gs_system' => $this->input->post('gs_system'),
                'type' => $this->input->post('type'),
                'compute' => $this->input->post('compute'),
                'rubric' => $this->input->post('rubric'),
                'marks' => $this->input->post('marks'),
                'comments' => $this->input->post('comments'),
                'teacher' => $this->input->post('teacher'),
                'grade' => $this->input->post('grade'),
                'position' => $this->input->post('position'),
                'modified_by' => $this->user->id,
                'modified_On' => time()
            ];


            $ok = $this->cbc_tr->update_setting($id, $form, 'cbc_settings');

            if ($ok) {

                $form1 = [
                    'type' => $this->input->post('type'),
                    'modified_by' => $this->user->id,
                    'modified_on' => time()
                ];

                $md = $this->cbc_tr->exam_update($exam, $form1, 'cbc_threads');
            }

            if ($md) {
                // Set session message for updated records
                $created_message = 'Exam Settings successfully Updated';
                $this->session->set_flashdata('created_message', array('type' => 'success', 'text' => $created_message));

                redirect("cbc/trs/manage_exams/" . $exam);
            }
        }

        $this->template->title('Edit Settings')->build('teachers/edit_settings', $data);
    }


    function edit($id)
    {


        //redirect if no $id
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('cbc/trs/all_exams/');
        }

        $data['result'] = $this->cbc_tr->get_exam($id);

        $this->template->title('Exam Edit')->build('teachers/set_exam', $data);

        if ($this->input->post()) {

            $post = (object) $this->input->post();

            $edate = strtotime($post->edate);
            $sdate = strtotime($post->sdate);
            $rdate = strtotime($post->rdate);


            $form = [
                'exam' => $post->exam,
                'term' => $post->term,
                'year' => $post->year,
                'sdate' => $sdate,
                'edate' => $edate,
                'rdate' => $rdate,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];


            $ok = $this->cbc_tr->update_exam($id, $form, 'cbc_threads');
        }


        if ($ok) {
            // Set session message for updated records
            $created_message = 'Exam successfully Updated';
            $this->session->set_flashdata('created_message', array('type' => 'success', 'text' => $created_message));

            redirect("cbc/trs/all_exams/");
        }
    }

    function delete($id)
    {

        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('cbc/trs/all_exams/');
        }

        $ok = $this->cbc_tr->delete('cbc_threads', $id);
        if ($ok) {
            // Set session message for updated records
            $delete_message = 'Exam successfully Deleted';
            $this->session->set_flashdata('delete_message', array('type' => 'success', 'text' => $delete_message));

            redirect("cbc/trs/all_exams/");
        }
    }


    function generate_reports()
    {

        $data['stud'] = $this->cbc_tr->find_student();
        $data["exams"] = $this->cbc_tr->exams();

        if ($this->input->post()) {

            $class = $this->input->post('class');
            $exam = $this->input->post('exam');
            $student = $this->input->post('student');
          
            $ex = $this->cbc_tr->get_exam($exam);

            $data['ex'] = $this->cbc_tr->get_exam($exam);

            $st = $this->worker->get_student($student);


            $data['student'] = $student;
            $data['exam'] = $exam;
            $data['class'] = $class;
            $data['term'] = $ex->term;
            $data['year'] = $ex->year;
                      
           if ($this->input->post('student')) {
                $data['grouped_marks'] = $this->cbc_tr->fetch_marks_by_stud($exam, $student);

                $data['reports'] = $this->cbc_tr->fetch_marks_by_stud($exam, $student);
                $data['class'] = $st->cl->id;
           } else{
                $data['grouped_marks'] = $this->cbc_tr->fetch_marks($exam, $class);

                $data['reports'] = $this->cbc_tr->fetch_marks($exam, $class);
           }
           
            $pivot_data = $this->cbc_tr->fetch_marks_by_stud($exam, $student);
        }

        // echo "<pre>";
        // print_r($pivot_data);
        // echo "<pre>";
        // die;

        $data['subjects'] = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
        $this->template->title('Edit Settings')->build('teachers/bulk_sum', $data);
    }

    function summ_single()
    {

        $data['stud'] = $this->cbc_tr->find_student();

        if ($this->input->post()) {


            $student = $this->input->post('student');
            $term = $this->input->post('term');
            $year = $this->input->post('year');

            $data['student'] = $student;
            $data['term'] = $term;
            $data['year'] = $year;


            $exs = $this->cbc_tr->get_termexams($term, $year);

            $ids = [];  // Initialize the array properly

            foreach ($exs as $e) {
                $ids[] = $e->id;
            }

            $data['exams'] = $ids;

            $data['grouped_marks'] = $this->cbc_tr->fetch_marks_by_stud($ids, $student);

            $data['reports'] = $this->cbc_tr->fetch_marks_by_stud($ids, $student);
            $p = $this->cbc_tr->fetch_marks_by_stud($ids, $student);

            $stdetails = $this->worker->get_student($student);
        }

        $data['class'] = $stdetails->cl->id;

        // echo "<pre>";
        // print_r($stdetails);
        // echo "<pre>";
        // die;

        $data['subjects'] = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
        $this->template->title('Edit Settings')->build('teachers/single_sum', $data);
    }


    function bulk_formative()
    {

        if ($this->input->post()) {


            $class = $this->input->post('class');
            $term = $this->input->post('term');
            $year = $this->input->post('year');
            $subject = $this->input->post('subject');

            $data['class'] = $class;
            $data['term'] = $term;
            $data['year'] = $year;

            $assess = $this->cbc_tr->get_assess($class, $term, $year, $subject);

            $ass_id = [];

            foreach ($assess as $kk => $ass) {
                $ass_id[] = $ass->id;
            }

            $data['report'] = $this->cbc_tr->get_formative($ass_id);
        }

        $data['strandz'] =  $this->cbc->fetch_strands_by_sub($subject);

        $data['subz'] =  $this->cbc->fetch_substrands_by_sub();


        // echo "<pre>";
        // print_r()
        // echo "<pre>";


        $data['subjects'] = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');

        $this->template->title('Formative Report')->build('teachers/bulk_formative', $data);
    }



    function begin_social()
    {

        $data['classes'] = $this->cbc_tr->my_classes();

        $this->template->title('Social Behaviour')->build('teachers/social', $data);
    }

    public function social_report($class)
    {
        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);
        $subjects = $this->cbc_m->get_subjects($row->class);

        if (isset($row->stream)) {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class)) {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;

        $data['cls'] = $class;

        $search = 0;


        if ($this->input->post()) {

            $studentid = $this->input->post('student');
            $t = $this->input->post('term');
            $y = $this->input->post('year');

            $search = 1;
        }

        $data['status'] =  $search;


        $data['studentid'] =  $studentid;
        $data['t'] =  $t;
        $data['y'] =  $y;


        // get data in table 
        $recs = $this->cbc_tr->check_social($studentid, $t, $y);

        // print_r($recs);
        // die;

        $data['rec'] = $recs;


        $data['students'] = $this->cbc_m->get_students($class);
        $data['class'] = $row;
        $data['subjects'] = $subjects;
        $classes = $this->trs_m->list_my_classes();
        $assigned = isset($this->teacher->profile->id) ? $this->trs_m->list_assigned_classes($this->teacher->profile->id) : [];

        $data['classes'] = $classes + $assigned;
        //load view
        $this->template->title('Assessment - Social Behavior Report')->build('teachers/social_report', $data);
    }

    function save_social($cls, $st, $t, $y)
    {

        $recs = $this->cbc_tr->check_social($st, $t, $y);

        if ($this->input->post()) {

            if (!empty($recs)) {

                $id = $recs->id;

                $form = [
                    'class' =>  $cls,
                    'student' =>  $st,
                    'term' =>  $t,
                    'year' =>  $y,
                    'cons' =>  $this->input->post('cons'),
                    'org' =>  $this->input->post('org'),
                    'comm' =>  $this->input->post('comm'),
                    'accept' =>  $this->input->post('accept'),
                    'ind' =>  $this->input->post('ind'),
                    'others' =>  $this->input->post('others'),
                    'school' =>  $this->input->post('school'),
                    'home' =>  $this->input->post('home'),
                    'cs' =>  $this->input->post('cs'),
                    'rev' =>  $this->input->post('rev'),
                    'property' =>  $this->input->post('property'),
                    'groupw' =>  $this->input->post('groupw'),
                    'coop' =>  $this->input->post('coop'),
                    'time_' =>  $this->input->post('time_'),
                    'conf' =>  $this->input->post('conf'),
                    'conce' =>  $this->input->post('conce'),
                    'punctual' =>  $this->input->post('punctual'),
                    'motivation' =>  $this->input->post('motivation'),
                    'fluent' =>  $this->input->post('fluent'),
                    'mtrr' =>  $this->input->post('mtrr'),
                    'speed' =>  $this->input->post('speed'),
                    'kasi' =>  $this->input->post('kasi'),
                    'compr' =>  $this->input->post('compr'),
                    'klw' =>  $this->input->post('klw'),
                    'exte' =>  $this->input->post('exte'),
                    'ziada' =>  $this->input->post('ziada'),
                    'tone' =>  $this->input->post('tone'),
                    'sauti' =>  $this->input->post('sauti'),
                    'spell' =>  $this->input->post('spell'),
                    'hj' =>  $this->input->post('hj'),
                    'remarks' =>  $this->input->post('remarks'),
                    'modified_by' => $this->user->id,
                    'modified_on' => time()
                ];

                $pp = $this->cbc_tr->update_social($id, $form, 'cbc_social');
            } else {

                $form = [
                    'class' =>  $cls,
                    'student' =>  $st,
                    'term' =>  $t,
                    'year' =>  $y,
                    'cons' =>  $this->input->post('cons'),
                    'org' =>  $this->input->post('org'),
                    'comm' =>  $this->input->post('comm'),
                    'accept' =>  $this->input->post('accept'),
                    'ind' =>  $this->input->post('ind'),
                    'others' =>  $this->input->post('others'),
                    'school' =>  $this->input->post('school'),
                    'home' =>  $this->input->post('home'),
                    'cs' =>  $this->input->post('cs'),
                    'rev' =>  $this->input->post('rev'),
                    'property' =>  $this->input->post('property'),
                    'groupw' =>  $this->input->post('groupw'),
                    'coop' =>  $this->input->post('coop'),
                    'time_' =>  $this->input->post('time_'),
                    'conf' =>  $this->input->post('conf'),
                    'conce' =>  $this->input->post('conce'),
                    'punctual' =>  $this->input->post('punctual'),
                    'motivation' =>  $this->input->post('motivation'),
                    'fluent' =>  $this->input->post('fluent'),
                    'mtrr' =>  $this->input->post('mtrr'),
                    'speed' =>  $this->input->post('speed'),
                    'kasi' =>  $this->input->post('kasi'),
                    'compr' =>  $this->input->post('compr'),
                    'klw' =>  $this->input->post('klw'),
                    'exte' =>  $this->input->post('exte'),
                    'ziada' =>  $this->input->post('ziada'),
                    'tone' =>  $this->input->post('tone'),
                    'sauti' =>  $this->input->post('sauti'),
                    'spell' =>  $this->input->post('spell'),
                    'hj' =>  $this->input->post('hj'),
                    'remarks' =>  $this->input->post('remarks'),
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];

                $ok = $this->cbc_tr->add_social($form, 'cbc_social');
            }

            if ($pp || $ok) {
                redirect('cbc/trs/social_report/' .$cls);
            }
        }
    }

    public function fetch_student()
    {
        // Retrieve data sent via POST
        $student = $this->input->post('student');
        $term = $this->input->post('term');
        $year = $this->input->post('year');

        $stu = $this->worker->get_student($student);

        // Prepare response data
        $responseData = array(
            'student' => $stu->first_name . ' ' . $stu->last_name,
            'term' => $term,
            'year' => $year
        );

        // Send response as JSON
        header('Content-Type: application/json');
        echo json_encode($responseData);
    }

    function social_print($class){

        $groups = $this->cbc_m->populate('class_groups', 'id', 'name');
        $streams = $this->cbc_m->populate('class_stream', 'id', 'name');

        $row = $this->cbc_m->fetch_class($class);
        $subjects = $this->cbc_m->get_subjects($row->class);

        if (isset($row->stream)) {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class)) {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $row->name = $grp . ' ' . $st;

        $data['cls'] = $class;

        $search = 0;
        if ($this->input->post()) {

            $student = $this->input->post('student');
            $term = $this->input->post('term');
            $year = $this->input->post('year');

            $search = 1;

            $recs = $this->cbc_tr->check_social($student, $term, $year);
            
        }

        $data['stu'] = $student;
        $data['term'] = $term;
        $data['year'] = $year;
 
        $data['rec'] =  $this->cbc_tr->check_social($student, $term, $year);
 
        $data['status'] = $search;

        $data['students'] = $this->cbc_m->get_students($class);
        $data['class'] = $row;
        $data['subjects'] = $subjects;
        $classes = $this->trs_m->list_my_classes();
        $assigned = isset($this->teacher->profile->id) ? $this->trs_m->list_assigned_classes($this->teacher->profile->id) : [];

        $data['classes'] = $classes + $assigned;
        

        $this->template->title('Social Behavior Report')->build('teachers/social_print', $data);

    }

   
}
