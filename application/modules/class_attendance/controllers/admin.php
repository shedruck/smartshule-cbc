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
                $this->load->model('class_attendance_m');
                $this->load->model('class_groups/class_groups_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $classes = $this->class_attendance_m->get_class_stream();
                if (!empty($classes))
                {
                        foreach ($classes as $c)
                        {
                                $c->size = $this->class_groups_m->count_population($c->id);
                                $c->streams = $this->class_groups_m->fetch_streams($c->id);
                                $count = $this->portal_m->fetch_students($c->id);
                                //$c->size = count($count);
                                $c->checks = $this->class_attendance_m->get_by_class($c->id);
                        }
                }
                $data['post'] = $classes;
                $data['classes'] = $this->class_attendance_m->populate('class_groups', 'id', 'name');
                $data['streams'] = $this->class_attendance_m->populate('class_stream', 'id', 'name');
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Class Attendance')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/index', $data);
                }
                else
                {
                        $this->template->title(' Class Attendance ')->build('admin/index', $data);
                }
        }
		
	

        public function list_attendance($id = 0)
        {
                //search the item to show in edit form
                $data['class_attendance'] = $this->class_attendance_m->get($id);
                $data['class'] = $id;
                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Class Attendance')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/list', $data);
                }
                else
                {
                        $this->template->title(' Class Attendance ')->build('admin/list', $data);
                }
        }

        function view($id = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance/');
                }
                if (!$this->class_attendance_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance');
                }
                //search the item to show in edit form
                $data['post'] = $this->class_attendance_m->get_register($id);
                $data['dat'] = $this->class_attendance_m->find($id);
                $data['present'] = $this->class_attendance_m->count_present($id);
                $data['absent'] = $this->class_attendance_m->count_absent($id);
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Class Register')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/register', $data);
                }
                else
                {
                        $this->template->title(' Class Register ')->build('admin/register', $data);
                }
        }
		
		function send_sms($status,$id){
			
		   	if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance/');
                }
                if (!$this->class_attendance_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance');
                }
				
				$post = $this->class_attendance_m->get_register($id);
				
				if($status==1){
					$status="Absent";
					$post = $this->class_attendance_m->get_by_status($status,$id);
				}
				
				
				
			  $this->load->model('sms/sms_m');
			  
			  $dat = $this->class_attendance_m->find($id);
			 
			  
			  $count = 0;
			  foreach($post  as $p){
				 $count++; 
				 $u = $this->ion_auth->list_student($p->student);
				 $parent = $this->portal_m->get_parent($u->parent_id);
			   
				  $message = "Dear parent/guardian, your child ".ucwords($u->first_name) . ' ' . ucwords($u->last_name)." was  ".strtolower($p->status)." for ". strtolower($dat->title)." roll call on ".date('d M Y', $dat->attendance_date).". Thank you";
				  
				 $ok = $this->sms_m->send_sms($parent->phone, $message);
			    //print_r($count.' >>> '.$message.'-----'.$parent->phone);
			  }
			 
			  if ($ok)
				{
						$this->session->set_flashdata('message', array('type' => 'success', 'text' => $count.' Message notification was successfully sent'));
				}
				else
				{
						$this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Oops something went wrong please try again later'));
				}
               redirect('admin/class_attendance/');
		}

		function sms($id = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance/');
                }
                if (!$this->class_attendance_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance');
                }
                //search the item to show in edit form
                $data['post'] = $this->class_attendance_m->get_register($id);
                $data['dat'] = $this->class_attendance_m->find($id);
                $data['present'] = $this->class_attendance_m->count_present($id);
                $data['absent'] = $this->class_attendance_m->count_absent($id);
                $data['att_id'] = $id;
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Class Register')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/register', $data);
                }
                else
                {
                        $this->template->title(' Class Register ')->build('admin/sms', $data);
                }
        }

        function create($id = 0, $page = NULL)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance/');
                }
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //validate the fields of form
                if ($this->form_validation->run())
                {
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'class_id' => $id,
                            'attendance_date' => strtotime($this->input->post('attendance_date')),
                            'title' => $this->input->post('title'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->class_attendance_m->create($form_data);

                        $remarks = $this->input->post('remarks');
                        $temperature = $this->input->post('temperature');
                        $status = $this->input->post('status');
                        foreach ($status as $st => $state)
                        {
                                $attendace_list = array(
                                    'attendance_id' => $ok,
                                    'student' => $st,
                                    'status' => $state,
                                    'temperature' => $temperature[$st],
                                    'remarks' => $remarks[$st],
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                               $done =  $this->class_attendance_m->create_list($attendace_list);
								
								
								 $details = implode(' , ', $attendace_list);
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

                        if ($ok)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }
                        redirect('admin/class_attendance/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
                        $data['result'] = $get;
                        $data['students'] = $this->class_attendance_m->get_students($id);
                        //load the view and the layout
                        if ($this->ion_auth->is_in_group($this->user->id, 3))
                        {
                                $this->template->title(' Class Attendance')
                                             ->set_layout('teachers')
                                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                                             ->build('admin/create', $data);
                        }
                        else
                        {
                                $this->template->title('Add Class Attendance ')->build('admin/create', $data);
                        }
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance/');
                }
                if (!$this->class_attendance_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance');
                }
                //search the item to show in edit form
                $get = $this->class_attendance_m->find($id);

                $this->form_validation->set_rules($this->validation());
                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;
                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'class_id' => $this->input->post('class_id'),
                            'attendance_date' => strtotime($this->input->post('attendance_date')),
                            'title' => $this->input->post('title'),
                            'student' => $this->input->post('student'),
                            'status' => $this->input->post('status'),
                            'remarks' => $this->input->post('remarks'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->class_attendance_m->update_attributes($id, $form_data);

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
                                redirect("admin/class_attendance/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'error'));
                                redirect("admin/class_attendance/");
                        }
                }
                else
                {
                        foreach (array_keys($this->validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->{$field} = $this->form_validation->{$field};
                                }
                        }
                }
                $data['result'] = $get;
                //load the view and the layout
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Class Attendance')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/create', $data);
                }
                else
                {
                        $this->template->title('Edit Class Attendance ')->build('admin/create', $data);
                }
        }

        function delete($id = NULL, $page = 1)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance');
                }
                //search the item to delete
                if (!$this->class_attendance_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_attendance');
                }
                //delete the item
                if ($this->class_attendance_m->delete($id) == TRUE)
                {
                        $counts = $this->class_attendance_m->count_del($id);
                        for ($i = 0; $i < $counts; $i++)
                        {
                                $this->class_attendance_m->delete_list($id);
                        }
						
						// $details = implode(' , ', $this->input->post());
						 $user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $id, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
								'details' => 'Records Deleted',   
								'created_by' => $user -> id,   
								'created_on' => time()
							);

						  $this->ion_auth->create_log($log);
								  
								  
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }
                redirect("admin/class_attendance");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'attendance_date',
                        'label' => 'Attendance Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'remarks',
                        'label' => 'Remarks',
                        'rules' => 'xss_clean'),
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/class_attendance/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->class_attendance_m->count();
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

                return $config;
        }

        public function filter_attendance(){
                
                $data['attendance']= $this->class_attendance_m->filter_attendances();
                $this->template->title('Filter Class Attendance ')->build('admin/filter',$data);
        }

        public function filtering_attendance(){
                if($this->input->post()){
                        $date= strtotime($this->input->post('attendance_date'));
                        $title= $this->input->post('title');
                        $data['attendances']=$this->class_attendance_m->filtering_attendance($date, $title);
                        $this->template->title('Filter Class Attendance ')->build('admin/filtered_data',$data);
                 }
        }

        public function filtering_attendances(){
                if($this->input->post()){
                        $date= strtotime($this->input->post('attendance_date'));
                        $title= $this->input->post('title');
                        $status= $this->input->post('status');
                        $data['attendances']=$this->class_attendance_m->filtering_attendance_by_status($date, $title, $status);
                        $this->template->title('Filter Class Attendance ')->build('admin/filtered_data',$data);
                 }
        }

        public function view_attendance($class, $date, $title){
                $data['attendances'] = $this->class_attendance_m->view_attendance($class, $date, $title);
                $this->template->title('Filter Class Attendance ')->build('admin/view_att',$data);
        }

        public function view_attendances($class, $date, $title, $status){
                $data['attendances'] = $this->class_attendance_m->view_attendances_($class,$date, $title, $status);
                $this->template->title('Filter Class Attendance ')->build('admin/view_att',$data);
        }


}
