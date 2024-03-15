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
                $this->load->model('assessment_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['assessment'] = $this->assessment_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' Assessment ')->build('admin/list', $data);
        }

        public function units()
        {
                if ($this->input->post())
                {
                        $titles = $this->input->post('title');
                        $segments = $this->input->post('segment');

                        $lenn = count($titles);
                        if ($lenn)
                        {
                                for ($ii = 0; $ii < $lenn; $ii++)
                                {
                                        if (isset($titles[$ii]) && isset($segments[$ii]))
                                        {
                                                $form = array(
                                                    'unit' => $titles[$ii],
                                                    'cat' => $segments[$ii],
                                                    'created_on' => time(),
                                                    'created_by' => $this->ion_auth->get_user()->id
                                                );
                                                $done = $this->assessment_m->create_unit($form);
												
												 $details = implode(' , ', $form);
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
				  
                                        }
                                }
                        }
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        redirect('admin/assessment/units');
                }
                $config = $this->paginate_units(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['assessment'] = $this->assessment_m->paginate_units($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' Assessment Units')->build('admin/units', $data);
        }

        public function grading()
        {
                $ind = array(
                    1 => "B",
                    2 => "A",
                    3 => "M",
                    4 => "E"
                );
                if ($this->input->post())
                {
                        $min = $this->input->post('min');
                        $max = $this->input->post('max');
                        $symbols = $this->input->post('symbol');
                        $indicators = $this->input->post('indicator');
                        $desc = $this->input->post('desc');

                        $lenn = count($min);
                        if ($lenn)
                        {
                                for ($ii = 0; $ii < $lenn; $ii++)
                                {
                                        if (isset($min[$ii]) && isset($max[$ii]) && isset($symbols[$ii]) && isset($indicators[$ii]) && isset($desc[$ii]))
                                        {
                                                $form = array(
                                                    'min_marks' => $min[$ii],
                                                    'max_marks' => $max[$ii],
                                                    'symbol' => $symbols[$ii],
                                                    'indicator' => $ind[$indicators[$ii]],
                                                    'description' => $desc[$ii],
                                                    'created_on' => time(),
                                                    'created_by' => $this->ion_auth->get_user()->id
                                                );
												
                                              $done =   $this->assessment_m->create_grading($form);
												
											 $details = implode(' , ', $form);
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
                                        }
                                }
                        }
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        redirect('admin/assessment/grading');
                }

                $data['grading'] = $this->assessment_m->get_grading();
                $data['ind'] = $ind;
                //load view
                $this->template->title(' Assessment Grading')->build('admin/grading', $data);
        }

        /**
         * Add Assessment
         * 
         * @param type $id
         */
        function create($id)
        {
                //validate the fields of form
                if ($this->input->post())
                {
                        $form = array(
                            'student' => $this->input->post('student'),
                            'comment' => $this->input->post('description'),
                            'created_by' => $this->user->id,
                            'created_on' => time()
                        );

                        $asse_id = $this->assessment_m->create($form);

                        if ($asse_id)
                        {
                                $grades = $this->input->post('grade');
                                foreach ($grades as $unit => $grade)
                                {
                                        $form_data = array(
                                            'assessment_id' => $asse_id,
                                            'unit' => $unit,
                                            'grade' => $grade,
                                            'created_by' => $this->user->id,
                                            'created_on' => time()
                                        );

                                       $done =  $this->assessment_m->create_sub($form_data);
										
										 $details = implode(' , ', $form_data);
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
                                }
                        }

                        if ($asse_id)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/assessment/create/' . $id);
                }
                $data['grades'] = $this->assessment_m->populate('assessment_grading', 'id', 'indicator');

                $data['units'] = $this->assessment_m->fetch_units($id);
                $this->template->title('Add Assessment ')->build('admin/create', $data);
        }

        function view($id)
        {
                $data['grades'] = $this->assessment_m->populate('assessment_grading', 'id', 'indicator');
                $data['units'] = $this->assessment_m->populate('assessment_units', 'id', 'unit');

                $data['assess'] = $this->assessment_m->fetch_assessment($id);
                $this->template->title('Add Assessment ')->build('admin/view', $data);
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assessment/');
                }
                if (!$this->assessment_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assessment');
                }
                //search the item to show in edit form
                $get = $this->assessment_m->find($id);
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
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);

                        //find the item to update

                        $done = $this->assessment_m->update_attributes($id, $form_data);

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
                                redirect("admin/assessment/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/assessment/");
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
                $this->template->title('Edit Assessment ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/assessment');
                }

                //search the item to delete
                if (!$this->assessment_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/assessment');
                }

                //delete the item
                if ($this->assessment_m->delete($id) == TRUE)
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

                redirect("admin/assessment/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/assessment/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->assessment_m->count();
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

        private function paginate_units()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/assessment/units/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->assessment_m->count_units();
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
                $config['full_tag_open'] = '<ul class="pagination pagination-centered">';
                $config['full_tag_close'] = '</ul>';
                $choice = $config["total_rows"] / $config["per_page"];
                //$config["num_links"] = round($choice);

                return $config;
        }

}
