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
                $this->load->model('students_placement_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['students_placement'] = $this->students_placement_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['class'] = $this->students_placement_m->get_class();
                $data['position'] = $this->students_placement_m->get_positions();
                 //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title('Students Placement ')
						 ->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
						->build('admin/list', $data);
                }
                else
                {
                        $this->template->title(' Students Placement ')->build('admin/list', $data);
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
                            'student' => $this->input->post('student'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'position' => $this->input->post('position'),
                            'student_class' => $this->input->post('student_class'),
                            'duration' => strtotime($this->input->post('duration')),
                            'description' => $this->input->post('description'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->students_placement_m->create($form_data);

                        if ($ok) 
                        {
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

                        redirect('admin/students_placement/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;

                        $data['positions'] = $this->students_placement_m->get_positions();
                        //load the view and the layout
                        if ($this->ion_auth->is_in_group($this->user->id, 3))
                        {
                                $this->template->title('Students Placement ')
								 ->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
								->build('admin/create', $data);
                        }
                        else
                        {
                                $this->template->title('Add Students Placement ')->build('admin/create', $data);
                        }
                }
        }

        function view($id = 0)
        {

                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;


                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/students_placement/');
                }
                if (!$this->students_placement_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/students_placement');
                }


                $data['students_placement'] = $this->students_placement_m->get_all();


                $data['position'] = $this->students_placement_m->get_positions();

                //search the item to show in edit form

                $data['post'] = $this->students_placement_m->find($id);
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title('Students Placement ')
						 ->set_layout('teachers')
				->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
				->set_partial('teachers_top', 'partials/teachers_top.php')
						->build('admin/view', $data);
                }
                else
                {
                        $this->template->title(' Students Placement ')->build('admin/view', $data);
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
                        redirect('admin/students_placement/');
                }
                if (!$this->students_placement_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/students_placement');
                }
                //search the item to show in edit form
                $get = $this->students_placement_m->find($id);
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

                        $start_date = $this->input->post('start_date');


                        if ($this->input->post('start_date') == '')
                        {

                                $start_date = $get->start_date;
                        }
                        $duration = $this->input->post('duration');
                        if ($this->input->post('duration') == '')
                        {

                                $duration = $get->duration;
                        }

                        $form_data = array(
                            'student' => $this->input->post('student'),
                            'start_date' => strtotime($start_date),
                            'position' => $this->input->post('position'),
                            'student_class' => $this->input->post('student_class'),
                            'duration' => strtotime($duration),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);

                        //find the item to update

                        $done = $this->students_placement_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
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
                                redirect("admin/students_placement/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/students_placement/");
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
                $data['classes'] = $this->students_placement_m->get_class();
                $data['positions'] = $this->students_placement_m->get_positions();
                //load the view and the layout
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title('Edit Students Placement ')
						 ->set_layout('teachers')
						->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
						->set_partial('teachers_top', 'partials/teachers_top.php')
						->build('admin/create', $data);
                }
                else
                {
                        $this->template->title('Edit Students Placement ')->build('admin/create', $data);
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

                        redirect('admin/students_placement');
                }

                //search the item to delete
                if (!$this->students_placement_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/students_placement');
                }

                //delete the item
                if ($this->students_placement_m->delete($id) == TRUE)
                {
                        //$details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $id, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
								'details' => 'Record Deleted',   
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

                redirect("admin/students_placement/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'start_date',
                        'label' => 'Start Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'position',
                        'label' => 'Position',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'student_class',
                        'label' => 'student class',
                        'rules' => 'required'),
                    array(
                        'field' => 'duration',
                        'label' => 'Duration',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/students_placement/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->students_placement_m->count();
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
