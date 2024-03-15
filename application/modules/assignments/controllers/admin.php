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
                $this->load->model('assignments_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['assignments'] = $this->assignments_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                $this->template->title(' Assignments ')->build('admin/list', $data);
        }

        //Details view function
        function view($id)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assignments/');
                }
                if (!$this->assignments_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assignments');
                }

                $data['p'] = $this->assignments_m->find($id);

                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Assignment Details')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/view', $data);
                }
                else
                {
                        $this->template->title(' Assignment Details ')->build('admin/view', $data);
                }
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                $document = '';

                if (!empty($_FILES['document']['name']))
                {
                        $this->load->library('files_uploader');
                        $upload_data = $this->files_uploader->upload('document');
                        $document = $upload_data['file_name'];
                }

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'end_date' => strtotime($this->input->post('end_date')),
                            'assignment' => $this->input->post('assignment'),
                            'comment' => $this->input->post('comment'),
                            'document' => $document,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->assignments_m->create($form_data);

                        if ($ok)
                        {
                                foreach ($this->input->post('class') as $class_id)
                                {
                                        $values = array(
                                            'assgn_id' => $ok,
                                            'class' => $class_id,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->assignments_m->insert_classes($values);
                                }
								
								 $details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
								 $log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $ok, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$ok, 
										'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
								
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/assignments/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        //load the view and the layout
                        if ($this->ion_auth->is_in_group($this->user->id, 3))
                        {
                                $this->template->title(' Assignment Details')
                                             ->set_layout('teachers')
                                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                                             ->build('admin/create', $data);
                        }
                        else
                        {
                                $this->template->title('Add Assignments ')->build('admin/create', $data);
                        }
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assignments/');
                }
                if (!$this->assignments_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assignments');
                }
                //search the item to show in edit form
                $get = $this->assignments_m->find($id);
                //variables for check the upload
                $form_data_aux = array();
                $files_to_delete = array();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                $document = $get->document;

                if (!empty($_FILES['document']['name']))
                {
                        $this->load->library('files_uploader');
                        $upload_data = $this->files_uploader->upload('document');
                        $document = $upload_data['file_name'];
                }

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'end_date' => strtotime($this->input->post('end_date')),
                            'assignment' => $this->input->post('assignment'),
                            'comment' => $this->input->post('comment'),
                            'document' => $document,
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);

                        //find the item to update

                        $done = $this->assignments_m->update_attributes($id, $form_data);


                        if ($done)
                        {

                                foreach ($this->input->post('class') as $class_id)
                                {
                                        $values = array(
                                            'assgn_id' => $ok,
                                            'class' => $class_id,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->assignments_m->insert_classes($values);
                                }
								
								$details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
								 $log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $done, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
										'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);


                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/assignments/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/assignments/");
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
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Edit Assignment')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/create', $data);
                }
                else
                {
                        $this->template->title('Edit Assignments ')->build('admin/create', $data);
                }
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/assignments');
                }

                //search the item to delete
                if (!$this->assignments_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/assignments');
                }

                //delete the item
                if ($this->assignments_m->delete($id) == TRUE)
                {
                       // $details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
								 $log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $id, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
										//'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
								  
						
						$this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/assignments/");
        }

        function validation()
        {
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'start_date',
                        'label' => 'Start Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'end_date',
                        'label' => 'End Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'class',
                        'label' => 'Class',
                        'rules' => ''),
                    array(
                        'field' => 'assignment',
                        'label' => 'Assignment',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'comment',
                        'label' => 'Comment',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'document',
                        'label' => 'Document',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/assignments/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
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
