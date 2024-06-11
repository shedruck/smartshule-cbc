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
        $this->load->model('teachers/teachers_m');
        $this->load->model('exams/exams_m');
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

    function get_subjects_form($c)
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

        $classgrp = $this->cbc_tr->get_cls_group($class);

        
        $data['exam_type'] = $this->cbc_tr->get_exam_perclass($exam, $classgrp->class);

        // $exam = $this->cbc_tr->get_exam_perclass($exam, $classgrp->class);

        // print_r($exam);
        // die;
      

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
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                redirect('cbc/trs/begin_form');
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                redirect('cbc/trs/begin_form');
            }
        }
    }

    function begin_summative_form()
    {
        $data['classes'] = $this->cbc_tr->my_classes2();
        $cls = $this->cbc_tr->my_classes();
        $this->template->title('Summative Assessment')->build('teachers/summative', $data);
    }

    function set_exam()
    {
        $ok = false; // Initialize $ok variable

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

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                redirect("cbc/trs/all_exams/");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                redirect("cbc/trs/all_exams/");
            }
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
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                    redirect("cbc/trs/manage_exams/" . $exam);
                } else {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
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
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                redirect("cbc/trs/manage_exams/" . $exam);
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
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
            } else {
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
        $this->template->title('Generate Reports')->build('teachers/bulk_sum', $data);
    }

    public function fetch_students()
    {
        $class = $this->input->post('class');
        if ($class) {

            $students = $this->cbc_tr->get_students_by_class($class);

            // Prepare data to be returned as JSON
            $data = array();
            foreach ($students as $student) {
                $data[$student->id] = $student->first_name . ' ' . $student->last_name;
            }

            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function fetch_subjects()
    {
        $class = $this->input->post('class');
        if ($class) {

            $cls = $this->cbc_tr->get_clsgroup($class);

            $subids =   $this->cbc_tr->get_subids($cls->class);

            $ids = [];
            foreach ($subids as $key => $sub) {
                $ids[] = $sub->subject_id;
            }

            $subjects = $this->cbc_tr->get_subjects_by_class($ids);

            // Prepare data to be returned as JSON
            $data = array();
            foreach ($subjects as $subject) {
                $data[$subject->id] = $subject->name;
            }

            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }


    public function fetch_subs_perclass($class)
    {
      
        if ($class) {

            $cls = $this->cbc_tr->get_clsgroup($class);

            $subids =   $this->cbc_tr->get_subids($cls->class);

            $ids = [];
            foreach ($subids as $key => $sub) {
                $ids[] = $sub->subject_id;
            }

            $subjects = $this->cbc_tr->get_subjects_by_class($ids);

            // Prepare data to be returned as JSON
            $data = array();
            foreach ($subjects as $subject) {
                $data[$subject->id] = $subject->name;
            }

           return $data;
        } else {
           return []; 
        }
    }


    function get_subs($class){

        if ($class) {

            $cls = $this->cbc_tr->get_clsgroup($class);

            $subids =   $this->cbc_tr->get_subids($cls->class);

            $ids = [];
            foreach ($subids as $key => $sub) {
                $ids[] = $sub->subject_id;
            }

            $subjects = $this->cbc_tr->get_subjects_by_class($ids);

            // Prepare data to be returned as JSON
            $data = array();
            foreach ($subjects as $subject) {
                $data[$subject->id] = $subject->name;
            }


            return $data;

    }
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
            $data['subject'] = $subject;

            $assess = $this->cbc_tr->get_assess($class, $term, $year, $subject);

            $ass_id = [];

            foreach ($assess as $kk => $ass) {
                $ass_id[] = $ass->id;
            }

            $data['report'] = $this->cbc_tr->get_formative($ass_id);
        }

        $data['strandz'] =  $this->cbc->fetch_strands_by_sub($subject);

        $data['subz'] =  $this->cbc->fetch_substrands_by_sub();


        $data['task'] = $this->cbc_tr->get_task();
        // $subids = $this->cbc_tr->get_formative($ass_id);
        // echo "<pre>";
        // print_r($tasks);
        // echo "<pre>";
        // die;


        $data['subjects'] = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');

        $this->template->title('Formative Report')->build('teachers/bulk_formative', $data);
    }

    function single_formative($class){
        if ($this->input->post()) {


            $student = $this->input->post('student');
            $term = $this->input->post('term');
            $year = $this->input->post('year');
            $subject = $this->input->post('subject');


            $data['class'] = $class;
            $data['term'] = $term;
            $data['year'] = $year;
            $data['subject'] = $subject;

            $assess = $this->cbc_tr->get_assess($class, $term, $year, $subject);

            $ass_id = [];

            foreach ($assess as $kk => $ass) {
                $ass_id[] = $ass->id;
            }

            $data['report'] = $this->cbc_tr->get_formative_stu($ass_id, $student);
        }

        $data['strandz'] =  $this->cbc->fetch_strands_by_sub($subject);

        $data['subz'] =  $this->cbc->fetch_substrands_by_sub();


        $data['task'] = $this->cbc_tr->get_task();
        // $subids = $this->cbc_tr->get_formative($ass_id);
        // echo "<pre>";
        // print_r($tasks);
        // echo "<pre>";
        // die;
        $data['stud'] = $this->cbc_tr->get_students_perstream($class);


        $data['subs'] = $this->fetch_subs_perclass($class);

        $this->template->title('Formative Report')->build('teachers/single_formative', $data);
    }



    function formative_perstudent()
    {
        $act = 0;
        $this->session->unset_userdata('extrra');
        if ($this->input->get('extras')) {
            $act = $this->input->get('extras');
            if ($act) {
                $this->session->set_userdata('extrra', $act);
            }
        }

        $data['students'] = $this->trs_m->list_my_classes($act);

        $this->template->title('Formative Report')->build('teachers/formative_perstudent', $data);
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
                redirect('cbc/trs/social_report/' . $cls);
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

    function social_print($class)
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


    public function save_input()
    {
        if ($this->input->post('input')) {
            $input = $this->input->post('input');
            $st = $this->input->post('ky');
            $exam = $this->input->post('exam');
            $term = $this->input->post('term');
            $year = $this->input->post('year');
            $field = $this->input->post('field');

            if ($field === 'input') {
                $this->cbc_tr->insert_input($input, $st, $exam);
                $updated_value = $this->cbc_tr->get_field($st, $exam);
            } else if ($field === 'comment') {
                $this->cbc_tr->insert_tr_remarks($input, $st, $exam);
                $updated_value = $this->cbc_tr->get_tr_remarks($st, $exam);
            }

            echo json_encode(array('updated_value' => $updated_value));
        }
    }

    //Function to generate joint reports
    public function joint_reports()
    {
        $data['stud'] = $this->cbc_tr->find_student();
        $data["exams"] = $this->cbc_tr->exams();
        $data['threads'] = $this->cbc_tr->exam_threads();

        if ($this->input->post()) {
            $post = (object) $this->input->post();

            $form_data = array(
                'name' => $post->exam,
                'term' => $post->term,
                'year' => $post->year,
                'created_by' => $this->user->id,
                'created_on' => time()
            );

            $ok = $this->cbc_tr->create('cbc_exam_threads', $form_data);

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                redirect("cbc/trs/joint_reports");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                redirect("cbc/trs/joint_reports");
            }
        }

        // $data['subjects'] = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
        $data['subjects'] = $this->cbc_tr->populate('subjects', 'id', 'name');
        $this->template->title('Joint Exam Results')->build('teachers/joint', $data);
    }

    //Function to generate Results
    public function results($id)
    {
        $thread = $this->cbc_tr->find($id, 'cbc_exam_threads');
        $exams = $this->cbc_tr->find_exams($thread->term, $thread->year);

        $data['thread'] = $thread;
        $data['exams'] = $exams;

        $this->template->title('View Exam Results')->build('teachers/results', $data);
    }

    //Function to print results
    function reports($level, $thread) {
        $exams = $this->cbc_tr->find_exams($thread->term, $thread->year);
        $thread = $this->cbc_tr->find($thread, 'cbc_exam_threads');
        $classtreams = $this->cbc_tr->class_group_streams($level);
        $subjects = $this->cbc_tr->get_all_class_subjects2($level);

        //Prepare Streams 
        $streams = [];

        foreach ($classtreams as $cls) {
            $streams[$cls->id] = $this->streams[$cls->id];
        }


        //Receive Send
        if ($this->input->post()) {
            $post = (object) $this->input->post();

            $class = $post->class;
            $level = $post->level;
            $comparewith = $post->compare;

            if ($class == 0) {
                $students = $this->cbc_tr->get_students_by_group($level);
            } else {
                $students = $this->cbc_tr->get_students_by_stream($class);
            }

            // echo "<pre>";
            //     print_r($students);
            // echo "</pre>";
            // die;
            
            if (empty($students)) {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No marks found for students in this Class'));
                redirect('cbc/trs/results/' . $thread->id);
            } else {
                $results = $this->cbc_tr->results($thread->id,$students);
                $compareresults = $this->cbc_tr->results($comparewith,$students);

                $data['results'] = $results;
                $data['compareresults'] = $compareresults;
                $data['comparison'] = $comparewith;
            }
            
        }

        $data['threads'] = $this->cbc_tr->populate('cbc_exam_threads','id','name');
        $data['subjects'] = $subjects;
        $data['streams'] = $streams;
        $data['thread'] = $thread;
        $data['exams'] = $exams;
        $data['level'] = $level;
        $data['gradings'] = $this->cbc_tr->populate('grading_system', 'id', 'title');

        $this->template->title('View Exam Reports')->build('teachers/reports', $data);
    }

    //Function to Compute Marks
    public function sync($level, $thread)
    {
        $exams = $this->cbc_tr->find_exams($thread->term, $thread->year);
        $thread = $this->cbc_tr->find($thread, 'cbc_exam_threads');
        $classtreams = $this->cbc_tr->class_group_streams($level);

        //Prepare Streams 
        $streams = [];

        foreach ($classtreams as $cls) {
            $streams[$cls->id] = $this->streams[$cls->id];
        }


        //Receive Send
        if ($this->input->post()) {
            $post = (object) $this->input->post();
            //Get all marks
            $marks = $this->cbc_tr->get_marks($post->level, $post->exams);

            if (count($marks) == 0) {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No Marks Recorded'));
                // redirect("cbc/trs/sync/".$level."/".$thread);
                redirect("cbc/trs/joint_reports");
            }

            $weights = [];

            foreach ($post->exams as $exkey => $ex) {
                $weights[$ex] = $post->weight[$exkey];
            }

            $preparedmarks = $this->prepare_marks($marks, $post->exams, $weights, $post->grading, $post->operation, $post->level);

            //Pass the Prepared marks for further operations for ranking
            $futheroperations = (object) $this->further_operations($preparedmarks, $post->grading, $post->operation, $post->level, $thread->id);

            $mess = 'Marks Computed Successfully with '.$futheroperations->updates.' updates and '.$futheroperations->insertions.' new insertions.';
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
            redirect("cbc/trs/joint_reports");
        }

        $data['streams'] = $streams;
        $data['thread'] = $thread;
        $data['exams'] = $exams;
        $data['level'] = $level;
        $data['gradings'] = $this->cbc_tr->populate('grading_system', 'id', 'title');

        $this->template->title('Compute Results')->build('teachers/sync', $data);
    }

    //Function to store ranked Marks
    public function storeFinalResults($rankedMarks) {

    }

    //Function for further Operations
    public function further_operations($preparedmarks, $grading, $operation, $level, $tid)
    {
        $studentresults = [];
        $updates = 0;
        $insertions = 0;

        // echo "<pre>";
        //     print_r($preparedmarks);
        // echo "</pre>";
        // die;

        foreach ($preparedmarks as $st => $subjects) {
            $subjectstotal = 0;
            $subjectscount = 0;
            $pointstotal = 0;
            $class = 0;
            $type = 0;
            $subjectsweights = '';
            $examsids = '';

            foreach ($subjects as $sbkey => $marks) {
                $mk = (object) $marks;
                $subjectstotal += $mk->marks;
                $class = $mk->class;
                $type = $mk->type;
                $subjectsweights = $mk->involvedweights;
                $examsids = $mk->involvedexams;
                $subjectscount++;

                //Check Grade
                //Check if type is rubric to assign grades statically
                if ($type == 1) {
                    if ($mk->marks == 4) {
                        $grade = 'EE';
                        $points = 4;
                        $remarks = 'EXCEEDS EXPECTATIONS';
                    } elseif ($mk->marks == 3) {
                        $grade = 'ME';
                        $points = 3;
                        $remarks = 'MEETING EXPECTATIONS';
                    } elseif ($mk->marks == 2) {
                        $grade = 'AE';
                        $points = 2;
                        $remarks = 'APPROACHING EXPECTATIONS';
                    } elseif ($mk->marks == 1) {
                        $grade = 'BE';
                        $points = 1;
                        $remarks = 'BELOW EXPECTATIONS';
                    } 
                } else {
                    $grd = (object) $this->cbc_tr->get_grade($grading, $mk->marks);
                    // $pointstotal += $grd->points;
                    $grade = $grd->grade;
                    $points = $grd->points;
                    $remarks = $grd->comment;
                }
                
                // $grade = (object) $this->cbc_tr->get_grade($grading, $mk->marks);
                $pointstotal += $points;

                $form_data = array(
                    'tid' => $tid,
                    'combinedmarks' => $mk->marks,
                    'involvedmarkids' => $mk->involvedmarkids,
                    'involvedscores' => $mk->involvedscores,
                    'involvedexams' => $mk->involvedexams,
                    'involvedweights' => $mk->involvedweights,
                    'operation' => $operation,
                    'class' => $mk->class,
                    'classgrp' => $mk->classgrp,
                    'subject' => $sbkey,
                    'student' => $st,
                    'type' => $mk->type,
                    'grade' => $grade,
                    'points' => $points,
                    'remarks' => $remarks
                );

                //Check marks
                $checkmarko = $this->cbc_tr->check_marks($tid, $st, $sbkey);

                if ($checkmarko) {
                    $form_data['modified_by'] = $this->user->id;
                    $form_data['modified_on'] = time();

                    $done = $this->cbc_tr->update_with($checkmarko->id, $form_data, 'cbc_subs_included');

                    if ($done) {
                        $updates++;
                    }
                } else {
                    $form_data['created_by'] = $this->user->id;
                    $form_data['created_on'] = time();

                    $ok = $this->cbc_tr->create('cbc_subs_included', $form_data);

                    if ($ok) {
                        $insertions++;
                    }
                }

            }

            //Prepare Students Total Marks and Averages

            $studentresults[$st] = array(
                'subjectstotal' => $subjectstotal,
                'pointstotal' => $pointstotal,
                'subjectscount' => $subjectscount,
                'subjectsweights' => $subjectsweights,
                'examsids' => $examsids,
                'type' => $type,
                'classgrp' => $level,
                'class' => $class
            );
        }

        // echo "<pre>";
        //     print_r($studentresults);
        // echo "</pre>";
        // die;

        $rankedStudents = $this->rank_students($studentresults);

        //Store Ranked Students in DB
        foreach ($rankedStudents as $stu => $marks) {
            $mk = (object) $marks;
            $avgmarks = round($mk->subjectstotal / $mk->subjectscount);
            $avgpoints = round($mk->pointstotal / $mk->subjectscount,2);
        
            //Check if rubric to assign grades statically
            if ($type == 1) {
                if ($avgmarks == 4) {
                    $grade = 'EE';
                } elseif ($avgmarks == 3) {
                    $grade = 'ME';
                } elseif ($avgmarks == 2) {
                    $grade = 'AE';
                } elseif ($avgmarks == 1) {
                    $grade = 'BE';
                }
            } else {
                $grd = (object) $this->cbc_tr->get_grade($grading,$avgmarks);
                $grade = $grd->grade;
            }
            
            $pos = explode('/',$mk->classrank)[0];

            $form_data = array(
                'tid' => $tid,
                'student' => $stu,
                'subjectscount' => $mk->subjectscount,
                'total_marks' => $mk->subjectstotal,
                'average_marks' => $avgmarks,
                'total_points' => $mk->pointstotal,
                'average_points' => $avgpoints,
                'stream_rank' => $mk->streamrank,
                'class_rank' => $mk->classrank,
                'mean_grade' => $grade,
                'classgrp' => $mk->classgrp,
                'class' => $mk->class,
                'gid' => $grading,
                'operation' => $operation,
                'position' => $pos,
                'examsids' => $examsids,
                'subjectsweights' => $subjectsweights,
                'type' => $mk->type
            );

            //Check if marks Previosly entered
            $checkmarko = $this->cbc_tr->check_final_results($tid,$stu);

            if ($checkmarko) {
                $form_data['modified_by'] = $this->user->id;
                $form_data['modified_on'] = time();

                $done = $this->cbc_tr->update_with($checkmarko->id,$form_data,'cbc_final_results');
            } else {
                $form_data['created_by'] = $this->user->id;
                $form_data['created_on'] = time();

                $ok = $this->cbc_tr->create_marks('cbc_final_results',$form_data);
            }
            
        }

        return array(
                'rankedStudents' => $rankedStudents,
                'updates' => $updates,
                'insertions' => $insertions
            );
    }

    //Function to Assign Group and Class Positions
    function rank_students($students)
    {
        $students = $students;
        // Step 1: Sort students by total marks in descending order
        uasort($students, function ($a, $b) {
            return $b['subjectstotal'] <=> $a['subjectstotal'];
        });

        // Step 2: Calculate classrank for all students
        $totalStudentsInClassGrp = count($students);
        $lastTotal = null;
        $classRank = 0;
        $rankCounter = 0;

        foreach ($students as &$student) {
            $rankCounter++;
            if ($student['subjectstotal'] !== $lastTotal) {
                $classRank = $rankCounter;
                $lastTotal = $student['subjectstotal'];
            }
            $student['classrank'] = $classRank . '/' . $totalStudentsInClassGrp;
        }

        // Step 3: Group students by class and calculate streamrank
        $classes = [];

        foreach ($students as &$student) {
            $classes[$student['class']][] = &$student;
        }

        foreach ($classes as &$classStudents) {
            $totalStudentsInClass = count($classStudents);
            usort($classStudents, function ($a, $b) {
                return $b['subjectstotal'] <=> $a['subjectstotal'];
            });

            $lastTotal = null;
            $streamRank = 0;
            $rankCounter = 0;

            foreach ($classStudents as &$student) {
                $rankCounter++;
                if ($student['subjectstotal'] !== $lastTotal) {
                    $streamRank = $rankCounter;
                    $lastTotal = $student['subjectstotal'];
                }
                $student['streamrank'] = $streamRank . '/' . $totalStudentsInClass;
            }
        }

        return $students;
    }

    //Function to compute marks
    public function compute()
    {
        $post = (object) $this->input->post();

        //Get all marks
        $marks = $this->cbc_tr->get_marks($post->level, $post->exams);

        $preparedmarks = $this->prepare_marks($marks, $post->exams, $post->weight, $post->grading, $post->operation, $post->level);

        return $preparedmarks;
    }


    //Function to filter students marks
    public function prepare_marks($marks, $exams, $weight, $grading, $operation, $level)
    {
        //Filter Students
        $students = [];
        $subjects = [];

        foreach ($marks as $mark) {
            $students[] = $mark->student;
            $subjects[] = $mark->sub;
        }

        $filteredstudents = array_unique($students);
        $filteredsubjects = array_unique($subjects);

        //Prepare Student marks for each subject
        $studentsubs = [];

        foreach ($filteredstudents as $skey => $student) {
            $sbs = [];

            foreach ($filteredsubjects as $subject) {
                $sbs[] = $subject;
            }

            $studentsubs[$student] = $sbs;
        }

        //Now Populate the Marks 
        $studentmarks = [];

        foreach ($studentsubs as $stu => $subs) {
            $submarks = [];
            $subjects = $subs;

            foreach ($marks as $mk) {
                foreach ($subjects as $subj) {
                    if ($subj == $mk->sub && $stu == $mk->student) {
                        $submarks[$subj][$mk->exam] = [
                            'markid' => $mk->id,
                            'class' => $mk->class,
                            'classgrp' => $mk->class_grp,
                            'exam' => $mk->exam,
                            'type' => $mk->type,
                            'mark' => $mk->score,
                            'outof' => $mk->outof,
                        ];
                    }
                }
            }

            $studentmarks[$stu] = $submarks;
        }

        //Combine the marks and Log
        $combinedmarks = $this->combine_marks($studentmarks, $exams, $weight, $grading, $operation, $level);

        return $combinedmarks;
    }

    //Function to calculate marks
    public function combine_marks($marks, $exams, $weight, $grading, $operation, $level)
    {
        $combinedmarks = [];

        foreach ($marks as $stu => $subjects) {
            $subs = $subjects;
            $subscores = [];

            foreach ($subs as $sub => $exs) {
                $finalscore = 0;
                $involvedexams = [];
                $involvedscores = [];
                $involvedmarkids = [];
                $involvedweights = [];
                $class = 0;
                $classgrp = 0;
                $type = 0;
                foreach ($exs as $exkey => $score) {
                    $scr = (object) $score;

                    $uzito = $weight[$exkey];
                    $outof = $scr->outof;
                    $marko = $scr->mark;

                    //Capture Classes and Class Groups
                    $class = $scr->class;
                    $classgrp = $scr->classgrp;
                    $type = $scr->type;

                    //Capture Involved Marks
                    $involvedexams[] = $scr->exam;
                    $involvedscores[] = $scr->mark;
                    $involvedmarkids[] = $scr->markid;
                    $involvedweights[] = $weight[$exkey];

                    //Check if Rubric Not to Convert
                    if ($type == 1) {
                        $finalscore += $marko;
                    } else {
                        $convertedmarko = round(($marko * $uzito) / $outof, 0);
                        $finalscore += $convertedmarko;
                    }
                    // $convertedmarko = round(($marko * $uzito) / $outof, 0);
                    // $finalscore += $convertedmarko;
                }

                //Determine Final Score Based on Operation
                if ($operation == 1) {
                    $computedscore = round($finalscore / count($exams), 0);
                } elseif ($operation == 2) {
                    $computedscore = $finalscore;
                }

                //Push Final Score to Marks Array for Subjects
                $subscores[$sub] = array(
                    'marks' => $computedscore,
                    'involvedexams' => implode(',', $involvedexams),
                    'involvedscores' => implode(',', $involvedscores),
                    'involvedmarkids' => implode(',', $involvedmarkids),
                    'involvedweights' => implode(',', $involvedweights),
                    'class' => $class,
                    'classgrp' => $classgrp,
                    'type' => $type
                );
            }

            //Push Combined Marks for subjects to Student array
            $combinedmarks[$stu] = $subscores;
        }


        return $combinedmarks;
    }


    //Function to Edit Thread
    public function edit_thread()
    {
        $post = (object) $this->input->post();

        $form_data = array(
            'name' => $post->exam,
            'term' => $post->term,
            'year' => $post->year
        );

        $done = $this->cbc_tr->update_with($post->tid, $form_data, 'cbc_exam_threads');

        if ($done) {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Updated Successfully'));
            redirect("cbc/trs/joint_reports");
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            redirect("cbc/trs/joint_reports");
        }
    }

    public function delete_thread($id = false)
    {
        // $post = (object) $this->input->post();

        $form_data = array(
            'status' => 2,
        );

        $done = $this->cbc_tr->update_with($id, $form_data, 'cbc_exam_threads');

        if ($done) {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Deleted Successfully'));
            redirect("cbc/trs/joint_reports");
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            redirect("cbc/trs/joint_reports");
        }
    }


   
}
