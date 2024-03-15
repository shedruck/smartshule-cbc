<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cbc_exams extends Trs_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cbc_exams_m');
        if (!$this->ion_auth->logged_in()) {
            redirect('/login');
        }
    }

    function index()
    {

        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['payload'] = $this->cbc_exams_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        $data['subjects'] = $this->cbc_exams_m->populate('cbc_subjects', 'id', 'name');
      
        $this->template->title('Student Assessment')->build('trs/index', $data);
    }

    function summative_assess()
    {
        $this->template->title('Student Assessment')->build('trs/summative');
    }

    function assess_init()
    {
        $payload = [];
        if ($this->input->post()) {
            $post = (object) $this->input->post();
            $students = (object) $this->cbc_exams_m->get_students($post->class);

            $class_name = isset($this->streams[$post->class]) ? $this->streams[$post->class] : '';
            $payload = [
                'class_name' => $class_name,
                'subjects' => $this->cbc_exams_m->get_subjects_assigned($this->profile->id, $post->class),
                'students' => $students,
                'post' => $post
            ];



            echo json_encode($payload);
        }
    }

    function post_marks()
    {
        if ($this->input->post()) {
            $post = (object) $this->input->post();

            $user = $this->ion_auth->get_user();
            $form_data = [
                'term' => $post->term,
                'year' => $post->year,
                'class' => $post->class,
                'exam' => $post->exam,
                'subject' => $post->subject,
                'status' => 2,
                'created_by' => $user->id,
                'created_on' => time()
            ];

            $check = $this->cbc_exams_m->check_exam($post->exam, $post->term, $post->year, $post->subject, $post->class);


            if ($check) {

                $ok = false;
                // $this->cbc_exams_m->update_attributes('cbc_exams', $check->id, $form_data);
            } else {
                $ok = $this->cbc_exams_m->create('cbc_exams', $form_data);
            }


            $u = 0;
            $n = 0;

            foreach ($post->marks as $st => $mk) {
                if (empty($mk)) {
                    continue;
                }

                $found = $this->cbc_exams_m->find_exams($check->id);


                $marks = [
                    'exam_id' => $ok ? $ok : $check->id,
                    'exam' => $post->exam,
                    'subject' => $post->subject,
                    'term' => $post->term,
                    'year' => $post->year,
                    'class' => $post->class,
                    'student' => $st,
                    'marks' => $mk,
                    'created_on' => time(),
                    'created_by' => $user->id,

                ];

                if ($found) {
                    $this->cbc_exams_m->update_attributes('cbc_exams_marks', $found->id, $marks);
                    $u++;
                } else {
                    $this->cbc_exams_m->create('cbc_exams_marks', $marks);
                    $n++;
                }
            }

            $mess = 'Updated : ' . $u . ' records, Added : ' . $n . ' records';


            $this->session->set_flashdata('message', array('type' => 'info', 'text' => $mess));

            redirect("trs/cbc_exams");
        }
    }

    function report_forms($class,$exam, $term, $year)
    {
        $data['post'] =  [
            'exam' => $exam,
            'term' => $term,
            'year' => $year,
            'class' => $class
        ];
    
        $data['subjects'] =$this->cbc_exams_m->get_subjects_class($class);
        $data['payload'] = $this->cbc_exams_m->get_marks($class, $exam, $term, $year);
        $this->template->title('Report Forms')->build('trs/report', $data);
    }


    function results()
    {
        if($this->input->post())
        {
            $p = (object) $this->input->post();
        }

        $this->template->title('Results')->build('trs/results', []);
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/cbc_exams/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->cbc_exams_m->count();
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
}
