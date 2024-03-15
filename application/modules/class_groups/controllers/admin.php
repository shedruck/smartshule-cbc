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
                $this->load->model('class_groups_m');
                $valid = $this->portal_m->get_class_ids();
                if ($this->input->get('sw'))
                {
                        $pop = $this->input->get('sw');
                        //limit to available classes only
                        if (!in_array($pop, $valid))
                        {
                                $pop = $valid[0];
                        }
                        $this->session->set_userdata('pop', $pop);
                }
                else if ($this->session->userdata('pop'))
                {
                        $pop = $this->session->userdata('pop');
                }
                else
                {
                        //$pop = $valid[0];
                        // $this->session->set_userdata('pop', $pop);
                }
        }

        function classes()
        {
                $data[''] = '';
                $this->template->title(' All  Classes ')->build('admin/classes', $data);
        }

        /**     
         * Get Datatable
         * 
         */
        public function get_classes()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->class_groups_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $post = $this->class_groups_m->paginate_cg($config['per_page'], $page);

                if (!empty($post))
                {
                        foreach ($post as $p)
                        {
                                $p->streams = $this->class_groups_m->fetch_streams($p->id);
                                $count = $this->portal_m->fetch_students($p->id);
                                $p->size = count($count);
                        }
                }
                else
                {
                        $post = array();
                }
                $data['class_groups'] = $post;
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' Class Groups ')->build('admin/list', $data);
        }

        function add_stream($id = FALSE, $page = NULL)
        {
                $data['group'] = $id;
                //redirect if no $id
                if (!$id)
                {
                        redirect('admin/class_groups/');
                }
                if (!$this->class_groups_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups');
                }

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;
                if ($this->input->post())
                {
                        $user = $this->ion_auth->get_user();
                        //Insert Streams for Class Group
                        $streams = $this->input->post('streams');
                        if ($streams && is_array($streams) && count($streams))
                        {
                                foreach ($streams as $k)
                                {
                                        $claas = array(
                                            'class' => $id,
                                            'stream' => $k,
                                            'status' => 1,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $done = $this->class_groups_m->add_stream($claas);
                                        if ($done)
                                        {
                                                $details = implode(' , ', $claas);
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
                                        }
                                        else
                                        {
                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                        }
                                }
                        }

                        redirect("admin/class_groups/");
                }
                $data['streams'] = $this->class_groups_m->populate('class_stream', 'id', 'name');
                $class = $this->class_groups_m->find($id);
                $data['class'] = $class->name;
                //load the view and the layout
                $this->template->title('Add Streams')->build('admin/add', $data);
        }

        function create($page = NULL)
        {
                // redirect('admin/class_groups');
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
                            'name' => $this->input->post('name'),
                            'education_system' => $this->input->post('education_system'),
                            'description' => $this->input->post('description'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->class_groups_m->create($form_data);

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

                        redirect('admin/class_groups/');
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
                        $this->template->title('Add Class Groups ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/');
                }
                if (!$this->class_groups_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups');
                }
                //search the item to show in edit form
                $get = $this->class_groups_m->find($id);
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
                            'education_system' => $this->input->post('education_system'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->class_groups_m->update_attributes($id, $form_data);


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
                                redirect("admin/class_groups/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/class_groups/");
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
                $this->template->title('Edit Class Groups ')->build('admin/create', $data);
        }
		
		 /**
         * Promote To Next Class Manually
         * 
         */
        public function promotion()
        {
                $list = $this->class_groups_m->populate('fee_extras', 'id', 'title');
                $this->form_validation->set_rules($this->ex_validation());

                $data['classes'] = $this->class_groups_m->get_classes();
                //validate the fields of form
                if ($this->form_validation->run())
                {
                        $sids = $this->input->post('sids');
                        $class = $this->input->post('class');

                        $i = 0;
                        $iv = 0;
                        foreach ($sids as $student)
                        {
                                //check for current invoice and void
                                $iv_id = $this->class_groups_m->get_current_invoice($student);
                                if ($iv_id)
                                {
                                        //void 
                                        //$this->worker->void_invoice($iv_id);
                                        $iv++;
                                }
                                if ($class == 900000) //alumni
                                {
                                        $adm = array('status' => 3, 'modified_on' => time());
                                        $this->portal_m->upd_student($student, $adm);
                                }
                                else
                                {
                                        //update new class
                                        $this->class_groups_m->update_class($student, array('class' => $class, 'modified_on' => time(), 'modified_by' => $this->ion_auth->get_user()->id));
                                }
                                $i++;
								
								//$details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
									$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $iv_id, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$iv_id, 
										//'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
								  
                        }
						
						
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Success. Moved ' . $i . ' Students,Voided ' . $iv . ' Invoices'));
                        redirect("admin/class_groups/");
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->ex_validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['list'] = $list;

                        $range = range(date('Y') - 1, date('Y') + 1);
                        $data['yrs'] = array_combine($range, $range);
                        //load view
                        $this->template->title('Move To Next Class')->build('admin/movement', $data);
                }
        }

        /**
         * Promote To Next Class Manually
         * 
         */
        public function promotion_old()
        {
                $list = $this->class_groups_m->populate('fee_extras', 'id', 'title');
                $this->form_validation->set_rules($this->ex_validation());

                $data['classes'] = $this->class_groups_m->get_classes();
                //validate the fields of form
                if ($this->form_validation->run())
                {
                        $sids = $this->input->post('sids');
                        $class = $this->input->post('class');
                        $i = 0;
                        $iv = 0;
                        foreach ($sids as $student)
                        {
                                //check for current invoice and void
                                $iv_id = $this->class_groups_m->get_current_invoice($student);
                                if ($iv_id)
                                {
                                        //void 
                                        $this->worker->void_invoice($iv_id);
                                        $iv++;
                                }
                                //update new class
                                $this->class_groups_m->update_class($student, array('class' => $class, 'modified_on' => time(), 'modified_by' => $this->ion_auth->get_user()->id));
								
								//Update Class History
                                $this->class_groups_m->update_history(array('student' => $student,'class' => $class, 'year' => date('Y'),'created_on' => time(), 'created_by' => $this->ion_auth->get_user()->id));
								
                                $i++;
								
								//$details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
									$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $iv_id, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$iv_id, 
										//'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
								  
                        }
						
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Success. Moved ' . $i . ' Students,Voided ' . $iv . ' Invoices'));
                        redirect("admin/class_groups/");
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->ex_validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['list'] = $list;

                        $range = range(date('Y') - 1, date('Y') + 1);
                        $data['yrs'] = array_combine($range, $range);
                        //load view
                        $this->template->title('Move To Next Class')->build('admin/movement', $data);
                }
        }

        /**
         * Get Datatable
         * 
         */
        public function get_students()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->class_groups_m->list_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        /**
         *  ADD CLASS TEACHER
         *  Update classes table
         */
        function class_teacher($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/classes');
                }
                if (!$this->class_groups_m->exists_class($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/classes');
                }

                $class = $this->class_groups_m->get_class($id);
                $data['classes'] = $this->classes;
                $data['streams'] = $this->class_groups_m->populate('class_stream', 'id', 'name');

                $data['post'] = $this->class_groups_m->get_population($id);
                $data['all'] = $this->class_groups_m->get_all();
                //search the item to show in edit form
                $user = $this->ion_auth->get_user();
                if ($this->input->post('rec'))
                {
                        $form = array(
                            'rec' => $this->input->post('rec'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        if ($this->class_groups_m->classes_update($id, $form))
                        {
                                $details = implode(' , ', $this->input->post());
								$user = $this->ion_auth->get_user();
								$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $id, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
										'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
								  
								
								$this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Success'));
                                redirect("admin/class_groups/classes");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Error.Unable to save'));
                                redirect("admin/class_groups/classes");
                        }
                }
                else
                {
                        //Rules for validation
                        $this->form_validation->set_rules($this->valid_rules());

                        //create control variables
                        $data['updType'] = 'edit';
                        $data['page'] = $page;

                        if ($this->form_validation->run())
                        {
                                // build array for the model
                                $form_data = array(
                                    'class_teacher' => $this->input->post('class_teacher'),
                                    'modified_by' => $user->id,
                                    'modified_on' => time());
                                $done = $this->class_groups_m->classes_update($id, $form_data);

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
                                        redirect("admin/class_groups/classes");
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Error.Unable to save'));
                                        redirect("admin/class_groups/classes");
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
                }
                $data['class'] = $class;
                //load the view and the layout
                $this->template->title('Class Settings ')->build('admin/teacher', $data);
        }

        /**
         * Validation 
         * 
         * @return array
         */
        private function ex_validation()
        {
                $config = array(
                    array(
                        'field' => 'sids',
                        'label' => 'Student List',
                        'rules' => 'xss_clean|callback__valid_sid'),
                    array(
                        'field' => 'class',
                        'label' => 'Target Class',
                        'rules' => 'required|xss_clean')
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

        function _valid_sid()
        {
                $sid = $this->input->post('sids');
                if (is_array($sid) && count($sid))
                {
                        return TRUE;
                }
                else
                {
                        $this->form_validation->set_message('_valid_sid', 'Please Select at least one Student.');
                        return FALSE;
                }
        }

        /**
         * Disable/Enable Class
         * 
         * @param type $status
         * @param type $id
         */
        function change_status($status, $id = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/classes');
                }
                if (!$this->class_groups_m->exists_class($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/classes');
                }

                $user = $this->ion_auth->get_user();
                // build array for the model
                $form = array(
                    'status' => $status,
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $done = $this->class_groups_m->classes_update($id, $form);
				
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

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Status Successfully set'));
                redirect("admin/class_groups/classes");
        }

        function disable($id = FALSE)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/');
                }
                if (!$this->class_groups_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups');
                }

                $user = $this->ion_auth->get_user();
                // build array for the model
                $form_data = array(
                    'status' => 0,
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $done = $this->class_groups_m->update_attributes($id, $form_data);
                $this->class_groups_m->classes_update($id, $form_data);


                if ($done)
                {
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
						
						
						$this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Class was successfully disabled'));
                        redirect("admin/class_groups/");
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/class_groups/");
                }
        }

        // SET STATUS 0 TO DISABLE CLASS
        // Update Class Groups as paid
        function enable($id = FALSE)
        {
                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/');
                }
                if (!$this->class_groups_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups');
                }

                $user = $this->ion_auth->get_user();
                // build array for the model
                $form_data = array(
                    'status' => 1,
                    'modified_by' => $user->id,
                    'modified_on' => time());


                $done = $this->class_groups_m->update_attributes($id, $form_data);
                $this->class_groups_m->classes_update($id, $form_data);


                if ($done)
                {
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
						
						$this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Class was successfully enabled'));
                        redirect("admin/class_groups/");
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/class_groups/");
                }
        }

        /**
         * View Class
         * 
         * @param type $id
         */
        function view($id)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/classes/');
                }
                if (!$this->class_groups_m->cl_exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups/classes/');
                }

                $class_id = $this->class_groups_m->class_id($id);
 
                $data['class'] = $this->class_groups_m->get_class($id);
                $data['classes'] = $this->classes;
                $data['streams'] = $this->class_groups_m->populate('class_stream', 'id', 'name');

                $data['post'] = $this->class_groups_m->get_population($id);
                $data['teachers'] = $this->ion_auth->get_teachers();

                $this->template->title('View Class Profile')->build('admin/view', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                redirect('admin/class_groups');
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups');
                }

                //search the item to delete
                if (!$this->class_groups_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups');
                }

                //delete the item
                if ($this->class_groups_m->delete($id) == TRUE)
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

                redirect("admin/class_groups/");
        }

        private function valid_rules()
        {
                $config = array(
                    array(
                        'field' => 'class_teacher',
                        'label' => 'Class Teacher',
                        'rules' => 'trim|required|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

				array(
                        'field' => 'education_system',
                        'label' => 'education system',
                        'rules' => 'required|trim'),
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
                $config['base_url'] = site_url() . 'admin/class_groups/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 20;
                $config['total_rows'] = $this->class_groups_m->count();
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
