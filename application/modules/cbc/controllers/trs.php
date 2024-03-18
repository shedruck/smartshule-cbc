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

                    $this->cbc_m->update_with($sk->id, $form, 'cbc_assess_tasks');
                } else {
                    $form = [
                        'assess_id' => $ss_id,
                        'strand' => $p->strand,
                        'session' => $session,
                        'status' => ($post->publish == 1) ? 1 : 0,
                        'sub_strand' => $p->substrand,
                        'task' => $p->task,
                        'rating' => $rating,
                        'remarks' => $remarks,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $this->cbc_m->create_sub($form, 'cbc_assess_tasks');
                }
            }


            // // $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');

            echo '<pre>';
            print_r($post);
            echo '</pre>';
            die();
        }
    }


    function begin_summative_form()
    {
        $data['classes'] = $this->cbc_tr->my_classes();
        $cls = $this->cbc_tr->my_classes();
        // $data['students'] = $this->cbc_m->get_students($cls['id']);
        echo '<pre>';
        print_r($cls);
        echo '</pre>';
        die();
        // $classes = $this->cbc_tr->my_classes();
        $this->template->title('Summative Assessment')->build('teachers/summative', $data);
    }
}
