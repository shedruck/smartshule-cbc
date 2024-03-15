<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->template->set_layout('default');
                $this->template->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('top', 'partials/top.php')
                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                             ->set_partial('teacher_sidebar', 'partials/teachers_sidebar.php');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }


                $this->load->model('class_timetable_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['classes'] = $this->class_timetable_m->get_classes();

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                

                $this->template->title(' Class Timetable ')->build('admin/classes', $data);
               
        }
		
		public function index_()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['class_timetable'] = $this->class_timetable_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['subject'] = $this->class_timetable_m->list_subjects();
                $data['rooms'] = $this->class_timetable_m->list_class_rooms();
                $data['classes'] = $this->class_timetable_m->list_classes();

                $this->template->title(' Class Timetable ')->build('admin/list', $data);
               
        }
		

        function create($class_group, $class)
        {
                //print_r($this->input->post()); die;

                $page = 1;
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
						$term = $this->input->post('term');
						$year = $this->input->post('year');
                        $form_data = array(
                            'class_id' => $class,
                            'term' => $term,
                            'year' => $year,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                    
                      if(!$this->class_timetable_m->exists_period($class,$term,$year)){
						  
						   $ok = $this->class_timetable_m->create($form_data);
						   
					  }else{
						  
						  $rec = $this->class_timetable_m->get_tbl($class,$term,$year);
						  
						  $ok = $rec->id;
					  }
                      $dtw =  $this->input->post('day_of_the_week');
					   
					   $priority = 0;
					   
					   if ($dtw  == 'Monday') {
							$priority = 1;
						} elseif ($dtw  == 'Tuesday') {
							$priority = 2;
						}  elseif ($dtw  == 'Wednesday') {
							$priority = 3;
						} 
						 elseif ($dtw  == 'Thursday') {
							$priority = 4;
						}  elseif ($dtw  == 'Friday') {
							$priority = 5;
						} 
						
						
                        $length = $this->input->post('subject');
                        $size = count($length);

                        for ($i = 0; $i < $size; ++$i)
                        {

                                $subs = $this->input->post('subject');
                                $st = $this->input->post('start_time');
                                $ed = $this->input->post('end_time');
                                $rm = $this->input->post('room');
                                $tc = $this->input->post('teacher');

                                $table_list = array(
                                    'class_id' => $ok,
                                    'day_of_the_week' => $dtw,
                                    'subject' => $subs[$i],
                                    'priority' => $priority,
                                    'start_time' => $st[$i],
                                    'end_time' => $ed[$i],
                                    'room' => $rm[$i],
                                    'teacher' => $tc[$i],
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                                $data = $this->class_timetable_m->create_list($table_list);
								
								
                        }

                        if ($ok) 
                        {
                                 $details = implode(' , ', $form_data);
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

                        redirect('admin/class_timetable/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
						
						
				$this->load->model('evideos/evideos_m');		
				$sys = $this->ion_auth->populate('class_groups','id','education_system');
				
                if($sys[$class_group] ==1){
					
					 $subjects = $this->portal_m->get_sub844($class_group);
					
				}elseif($sys[$class_group] ==2){
					
					 $subjects = $this->portal_m->get_cbc_subjects($class_group);
					 
				}

					$data['result'] = $get;
					$data['subject'] = $subjects;
					$data['rooms'] = $this->class_timetable_m->list_class_rooms();
					$data['classes'] = $this->class_timetable_m->list_classes();
					$data['class'] = $class;
					$data['classg'] = $class_group;
					//load the view and the layout
				   
					$this->template->title('Add Class Timetable ')->build('admin/create', $data);
                        
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
                        redirect('admin/class_timetable/');
                }
                if (!$this->class_timetable_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_timetable');
                }
				
                //search the item to show in edit form
                $get = $this->class_timetable_m->find($id);
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
                            'timetable_id' => $this->input->post('class_id'),
                            'day_of_the_week' => $this->input->post('day_of_the_week'),
                             'modified_by' => $user->id,
                            'modified_on' => time());

                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);

                        //find the item to update


                        $done = $this->class_timetable_m->update_attributes($id, $form_data);

                        
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
                                redirect("admin/class_timetable/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/class_timetable/");
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
                $data['subject'] = $this->class_timetable_m->list_subjects();
                $data['rooms'] = $this->class_timetable_m->list_class_rooms();
                $data['classes'] = $this->class_timetable_m->list_classes();
                //load the view and the layout
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template
                                     ->title('Edit Class Timetable ')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/create', $data);
                }
                else
                {
                        $this->template->title('Edit Class Timetable ')->build('admin/create', $data);
                }
        }

        function view($class_group, $class)
        {
			    //redirect if no $id
                if (!$class && $class_group)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_timetable/');
                }
           
		      $settings = $this->ion_auth->settings();
			  
		       $term = $settings->term;
		       $year = date('Y');
			   
			   if($this->input->post()){
				   $term = $this->input->post('term');
				   $year = $this->input->post('year');
			   }

                $p = $this->class_timetable_m->get_tbl($class,$term,$year);
                $days = $this->class_timetable_m->list_tbl($p->id);
				
				$period = array();
				
				
				$sys = $this->ion_auth->populate('class_groups','id','education_system');
				
                if($sys[$class_group] ==1){
					
					 $subjects = $this->portal_m->get_sub844($class_group);
					
				}elseif($sys[$class_group] ==2){
					
					 $subjects = $this->portal_m->get_cbc_subjects($class_group);
					 
				}

					$data['subjects'] = $subjects;

             

                $data['days'] = $days;
                $data['tbl'] = $p->id;
				
                $data['subject'] = $this->class_timetable_m->list_subjects();
                $data['rooms'] = $this->class_timetable_m->list_class_rooms();
                $data['classes'] = $this->class_timetable_m->list_classes();


               $this->template->title('View Class Timetable ')->build('admin/view', $data);
             
        }

		function view_($id = 0)
        {

                $post = $this->class_timetable_m->get($id);

                $data['list'] = $this->class_timetable_m->list_all($post->class_id);
                $data['monday'] = $this->class_timetable_m->monday($id);
                $data['tuesday'] = $this->class_timetable_m->tuesday($id);
                $data['wednesday'] = $this->class_timetable_m->wednesday($id);
                $data['thursday'] = $this->class_timetable_m->thursday($id);
                $data['friday'] = $this->class_timetable_m->friday($id);

                $data['subject'] = $this->class_timetable_m->list_subjects();
                $data['rooms'] = $this->class_timetable_m->list_class_rooms();
                $data['classes'] = $this->class_timetable_m->list_classes();


                        $this->template->title('View Class Timetable ')->build('admin/timetable', $data);
             
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/class_timetable');
                }

                //search the item to delete
                if (!$this->class_timetable_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/class_timetable');
                }

                //delete the item
                if ($this->class_timetable_m->delete($id) == TRUE)
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
						
						$this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/class_timetable/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'term',
                        'label' => 'Term',
                        'rules' => 'required'),
						
						array(
                        'field' => 'year',
                        'label' => 'Year',
                        'rules' => 'required'),
                    array(
                        'field' => 'subject[]',
                        'label' => 'Subject',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'day_of_the_week',
                        'label' => 'Day Of The Week',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'start_time[]',
                        'label' => 'Start Time',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'end_time[]',
                        'label' => 'End Time',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'room[]',
                        'label' => 'Room',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'teacher[]',
                        'label' => 'Teacher',
                        'rules' => 'xss_clean'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/class_timetable/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->class_timetable_m->count();
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
