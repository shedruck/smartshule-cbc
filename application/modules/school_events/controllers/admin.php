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
                $this->load->model('school_events_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['school_events'] = $this->school_events_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' School Events')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/index', $data);
                }
                else
                {
                        $this->template->title(' School Events ')->build('admin/list', $data);
                }
        }

        public function list_view()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['school_events'] = $this->school_events_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' School Events')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/list', $data);
                }
                else
                {
                        $this->template->title(' School Events ')->build('admin/list', $data);
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
                        redirect('admin/school_events/');
                }
                if (!$this->school_events_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/school_events');
                }

                $data['school_events'] = $this->school_events_m->get_all();

                $data['post'] = $this->school_events_m->find($id);
             

                $this->template->title(' School Events ')->build('admin/view', $data);
        }

        //User Calendar Function
        function calendar()
        {

                $events = $this->school_events_m->get_all();
                $data['events'] = $events;
                //set the View
                $this->template->title('Calendar')->build('admin/calendar', $data);
        }

        /**
         * * Create Function
         * * Public Access
         * */
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
                            'title' => $this->input->post('title'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'end_date' => strtotime($this->input->post('end_date')),
                            'venue' => $this->input->post('venue'),
                            'visibility' => $this->input->post('visibility'),
                            'reminder' => $this->input->post('reminder'),
                            'reminder_type' => $this->input->post('reminder_type'),
                            'description' => $this->input->post('description'),
                            'color' => $this->input->post('color'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->school_events_m->create($form_data);

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

                        redirect('admin/school_events/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['groups'] = $this->school_events_m->get_groups();

                        $this->template->title('Add School Events ')->build('admin/create', $data);
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
                        redirect('admin/school_events/');
                }
                if (!$this->school_events_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/school_events');
                }
                //search the item to show in edit form
                $get = $this->school_events_m->find($id);
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
                            'title' => $this->input->post('title'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'end_date' => strtotime($this->input->post('end_date')),
                            'venue' => $this->input->post('venue'),
                            'visibility' => $this->input->post('visibility'),
                            'reminder' => $this->input->post('reminder'),
                            'reminder_type' => $this->input->post('reminder_type'),
                            'description' => $this->input->post('description'),
                            'color' => $this->input->post('color'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);

                        //find the item to update

                        $done = $this->school_events_m->update_attributes($id, $form_data);

                        
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
                                redirect("admin/school_events/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/school_events/");
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
                $data['groups'] = $this->school_events_m->get_groups();
                //load the view and the layout

                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title('Edit School Events ')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/create', $data);
                }
                else
                {
                        $this->template->title('Edit School Events ')->build('admin/create', $data);
                }
        }

        function delete($id = NULL, $page = 1)
        {

                if (!$this->ion_auth->is_in_group($this->user->id, 1))
                {
                        redirect('');
                }
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/school_events');
                }

                //search the item to delete
                if (!$this->school_events_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/school_events');
                }

                //delete the item
                if ($this->school_events_m->delete($id) == TRUE)
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

                redirect("admin/school_events/");
        }

        private function validation()
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
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'venue',
                        'label' => 'Venue',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'visibility',
                        'label' => 'Visibility',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'reminder',
                        'label' => 'Reminder',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'reminder_type',
                        'label' => 'Reminder Type',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'required|trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'color',
                        'label' => 'Color',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/school_events/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000;
                $config['total_rows'] = $this->school_events_m->count();
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
