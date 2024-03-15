<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        public $categories;

        function __construct()
        {
                parent::__construct();

                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
                $this->categories = array(
                    1 => 'Compulsory',
                    2 => 'Sciences',
                    3 => 'Humanities',
                    4 => 'Applied/Technical Subjects',
                    5 => 'Optionals'
                );
                $this->load->model('subject_categories_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['subject_categories'] = $this->subject_categories_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['categories'] = $this->categories;
                $data['subjects'] = $this->subject_categories_m->populate('subjects', 'id', 'name');

                //load view
                $this->template->title(' Subject Categories ')->build('admin/list', $data);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';

                $data['subjects'] = $this->subject_categories_m->populate('subjects', 'id', 'name');
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!

                        $post = (object) $this->input->post();

                     
                        $user = $this->ion_auth->get_user();

                        foreach($post->classes as $k => $class)
                        {
                                foreach($post->subjects as $kk => $subject)
                                {
                                        $form_data = array(
                                                'class' => $class,
                                                'subject' => $subject,
                                                'category' => $post->category,
                                                'created_by' => $user->id,
                                                'created_on' => time()
                                        );  
                                        $ok = $this->subject_categories_m->create($form_data);
                                }
                        }

                      
                       

                        if ($ok)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/subject_categories/create');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['categories'] = $this->categories;
                        $data['result'] = $get;
                        //load the view and the layout
                        $this->template->title('Add New ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subject_categories/');
                }
                if (!$this->subject_categories_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subject_categories');
                }
                $get = $this->subject_categories_m->find($id);
                $data['subjects'] = $this->subject_categories_m->populate('subjects', 'id', 'name');

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {

                        $post = (object) $this->input->post();

                    

                        $user = $this->ion_auth->get_user();

                        foreach ($post->classes as $k => $class) {
                                foreach ($post->subjects as $kk => $subject) {
                                        $form_data = array(
                                                'class' => $class,
                                                'subject' => $subject,
                                                'category' => $post->category,
                                                'modified_by' => $user->id,
                                                'modified_on' => time()
                                        );

                                        $done = $this->subject_categories_m->update_attributes($id, $form_data);

                                }
                        }
                      

                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/subject_categories/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/subject_categories/");
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
                $data['categories'] = $this->categories;
                //load the view and the layout
                $this->template->title('Edit Subject Categories ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/subject_categories');
                }

                //search the item to delete
                if (!$this->subject_categories_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/subject_categories');
                }

                //delete the item
                if ($this->subject_categories_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/subject_categories/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'subjects',
                        'label' => 'Subject',
                        'rules' => 'required|xss_clean'),

                        array(
                                'field' => 'classes',
                                'label' => 'Classes',
                                'rules' => 'required|xss_clean'
                        ),
                    array(
                        'field' => 'category',
                        'label' => 'Category',
                        'rules' => 'required|xss_clean'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/subject_categories/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->subject_categories_m->count();
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
