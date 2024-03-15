<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assignments extends Public_Controller
{
	

        function __construct()
        {
                parent::__construct();
                $this->template->set_layout('default');
                $this->template->set_partial('sidebar', 'partials/sidebar.php');
                $this->template->set_partial('footer', 'partials/footer.php');
                $this->template->set_partial('header', 'partials/header.php')
                             ->set_partial('meta', 'partials/meta.php');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }
                $this->load->model('assignments_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                
                $data['post'] = $this->assignments_m->list_assignments();
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                
                $this->template->title(' Assignments ')->build('index/list', $data);
        }

        function view($id)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('assignments/');
                }
                if (!$this->assignments_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('assignments');
                }


                $data['p'] = $this->assignments_m->find($id);

                $this->template->title(' Assignment Details ')->build('index/view', $data);
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'assignments/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->assignments_m->count();
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
