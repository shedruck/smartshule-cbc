<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
                $this->load->model('grading_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['grading'] = $this->grading_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['grades'] = $this->grading_m->grades();
                $data['list_grades'] = $this->grading_m->list_grades();

                //load view
                $data['grading_system'] = $this->grading_m->get_grading_system();
                $this->template->title(' Grading ')->build('index/list', $data);
        }

        function view($id = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading/');
                }
                if (!$this->grading_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading');
                }

                //search the item to show in edit form
                $data['grading_id'] = $id;
                $data['post'] = $this->grading_m->get_grades($id);
                $data['dat'] = $this->grading_m->find($id);
                $data['sys'] = $this->grading_m->get_grading_system();

                $this->template->title(' Grading ')->build('index/view', $data);
        }


        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'grading/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000000;
                $config['total_rows'] = $this->grading_m->count();
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
