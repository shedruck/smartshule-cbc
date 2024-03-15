<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

               // $this->template->set_partial('u-sidebar', 'partials/sidebar.php');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
                $this->load->model('non_teaching_m');
                $this->load->model('sms/sms_m');
        }

        /**
         * Module Index
         *
         */
        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $non_teaching = $this->non_teaching_m->paginate_all($config['per_page'], $page);

                $data['non_teaching'] = $non_teaching;

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
				
                $data['contracts'] = $this->non_teaching_m->populate('contracts', 'id', 'name');
                $data['departments'] = $this->non_teaching_m->populate('departments', 'id', 'name');

                //load view
                $this->template->title(' Non Teaching ')->build('admin/grid', $data);
        }

		/**
         * Module Index
         *
         */
        public function inactive()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $non_teaching = $this->non_teaching_m->paginate_inactive($config['per_page'], $page);

                $data['non_teaching'] = $non_teaching;

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
				
                $data['contracts'] = $this->non_teaching_m->populate('contracts', 'id', 'name');
                $data['departments'] = $this->non_teaching_m->populate('departments', 'id', 'name');

                //load view
                $this->template->title(' Inactive Non Teaching ')->build('admin/grid', $data);
        }

		/**
         * Module Index
         *
         */
        public function list_view()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $non_teaching = $this->non_teaching_m->paginate_all($config['per_page'], $page);

                $data['non_teaching'] = $non_teaching;

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
				
                $data['contracts'] = $this->non_teaching_m->populate('contracts', 'id', 'name');
                $data['departments'] = $this->non_teaching_m->populate('departments', 'id', 'name');

                //load view
                $this->template->title(' Non Teaching ')->build('admin/list', $data);
        }

        function upload_non_teaching()
        {
                $file = $_FILES['csv']['tmp_name'];
                $handler = fopen($file, "r");

                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;

                        $first_name = $fileop[0];
                        $last_name = $fileop[1];
                        $gender = $fileop[2];
                        $dob = strtotime($fileop[3]); 
						
						if(empty($dob)){
							$dob = '';
						}
						
						$email    = strtolower($fileop[4]);
						
                        $phone = '0'.$fileop[5];
						
						if(empty($phone)){
							$phone = '';
						}
						
                        $address    = $fileop[6];
                        $staff_no    = $fileop[7];
                        $marital_status    = $fileop[8];
                        $id_no    = $fileop[9];
                        $pin_no    = $fileop[10];
                        $date_joined    = strtotime($fileop[11]);
						
						if(empty($date_joined)){
							$date_joined = '';
						}
						
                        $contract_type    = $fileop[12];
                        $department    = $fileop[13];
                        $position    = $fileop[14];
                        $qualification    = '';

                        $user = $this->ion_auth->get_user();
                       $form_data = array(
                            'staff_no' => $staff_no,
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'contract_type' => $contract_type,
                            'marital_status' => $marital_status,
                            'id_no' => $id_no,
                            'status' => 1,
                            'division' => '',
                            'department' => $department,
                            'qualification' => $qualification,
                            'religion' => '',
                            'position' => $position,
                            'date_joined' => $date_joined,
                            'dob' => $dob,
                            'gender' => $gender,
                            'group_id' =>2,
                            'phone' => $phone,
                            'salary_status' => 0,
                            'email' => $email,
                            'pin' => $pin_no,
                            'address' => $address,
							'additionals' => '',
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->non_teaching_m->create($form_data);
                }

                if ($ok) // the information has therefore been successfully saved in the db
                {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/non_teaching/');
        }

        /**
         * Add New Non_teaching 
         *
         * @param $page
         */
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
			
			           $this->load->library('files_uploader');
			
						  $file ='';				 
							if (!empty($_FILES['passport']['name']))
							{
								   
									$upload_data = $this->files_uploader->upload('passport');
									$file = $upload_data['file_name'];
							}
							
						$id_document ='';				 
							if (!empty($_FILES['id_document']['name']))
							{
								   
									$upload_data = $this->files_uploader->upload('id_document');
									$id_document = $upload_data['file_name'];
							} 
					
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'middle_name' => $this->input->post('middle_name'),
                            'last_name' => $this->input->post('last_name'),
                            'contract_type' => $this->input->post('contract_type'),
                            'marital_status' => $this->input->post('marital_status'),
                            'id_no' => $this->input->post('id_no'),

							'passport' => $file,
							'id_document' => $id_document,
                            'department' => $this->input->post('department'),
                            'qualification' => $this->input->post('qualification'),
                            'religion' => $this->input->post('religion'),
                            'position' => $this->input->post('position'),
                            'date_joined' => strtotime($this->input->post('date_joined')),
                            'date_left' => strtotime($this->input->post('date_left')),
                            'dob' => strtotime($this->input->post('dob')),
                            'gender' => $this->input->post('gender'),
                            'group_id' => $this->input->post('member_groups'),
                            'phone' => $this->input->post('phone'),
                            'salary_status' => 0,
                            'status' => 1,
                            'email' => $this->input->post('email'),
                            'pin' => $this->input->post('pin'),
                            'address' => $this->input->post('address'),
                            'additionals' => $this->input->post('additionals'),
							
                            'ref_name' => $this->input->post('ref_name'),
                            'ref_phone' => $this->input->post('ref_phone'),
                            'ref_email' => $this->input->post('ref_email'),
                            'ref_address' => $this->input->post('ref_address'),
                            'ref_additionals' => $this->input->post('ref_additionals'),
							
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->non_teaching_m->create($form_data);

                        if ($ok) // the information has therefore been successfully saved in the db
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
								
								$this->non_teaching_m->update_attributes($ok, array('staff_no'=>$ok));
								
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Non_teaching ' . lang('web_create_success')));

                        }
                        else
                        {
                                $this->session->set_flashdata('error', array('type' => 'error', 'text' => 'Non_teaching ' . lang('web_create_failed')));
                        }

                        redirect('admin/non_teaching/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['groups'] = $this->non_teaching_m->populate('groups', 'id', 'name');
                        $data['contracts'] = $this->non_teaching_m->populate('contracts', 'id', 'name');
                        $data['departments'] = $this->non_teaching_m->populate('departments', 'id', 'name');
                        //load the view and the layout
                        $this->template->title('Add Non teaching Staff ')->build('admin/create', $data);
                }
        }

        /**
         * Edit  Non_teaching 
         *
         * @param $id
         * @param $page
         */
        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/non_teaching/');
                }
                if (!$this->non_teaching_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/non_teaching');
                }
                //search the item to show in edit form
                $get = $this->non_teaching_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;
                $data['groups'] = $this->non_teaching_m->populate('groups', 'id', 'name');
                if ($this->form_validation->run())  //validation has been passed
                {
                        
					 $file = $get->passport;   
							 
							if (!empty($_FILES['passport']['name']))
							{
									$this->load->library('files_uploader');
									$upload_data = $this->files_uploader->upload('passport');
									$file = $upload_data['file_name'];
							} 
							
						$id_document = $get->id_document;     
							 
							if (!empty($_FILES['id_document']['name']))
							{
									$this->load->library('files_uploader');
									$upload_data = $this->files_uploader->upload('id_document');
									$id_document = $upload_data['file_name'];
							}
						
						$user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'middle_name' => $this->input->post('middle_name'),
                            'last_name' => $this->input->post('last_name'),
                            'phone' => $this->input->post('phone'),
                            'contract_type' => $this->input->post('contract_type'),
                            'marital_status' => $this->input->post('marital_status'),
                            'id_no' => $this->input->post('id_no'),
							'passport' => $file,
							'id_document' => $id_document,
                            'department' => $this->input->post('department'),
                            'qualification' => $this->input->post('qualification'),
                            'religion' => $this->input->post('religion'),
                            'position' => $this->input->post('position'),
                            'date_joined' => strtotime($this->input->post('date_joined')),
                            'date_left' => strtotime($this->input->post('date_left')),
                            'dob' => strtotime($this->input->post('dob')),
                            'gender' => $this->input->post('gender'),
                            'email' => $this->input->post('email'),
                            'salary_status' => $this->input->post('salary_status'),
                            'pin' => $this->input->post('pin'),
                            'group_id' => $this->input->post('member_groups'),
                            'address' => $this->input->post('address'),
                            'additionals' => $this->input->post('additionals'),
							
							'ref_name' => $this->input->post('ref_name'),
                            'ref_phone' => $this->input->post('ref_phone'),
                            'ref_email' => $this->input->post('ref_email'),
                            'ref_address' => $this->input->post('ref_address'),
                            'ref_additionals' => $this->input->post('ref_additionals'),
							
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->non_teaching_m->update_attributes($id, $form_data);

                        // the information has therefore been successfully saved in the db
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
								  
								  
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Non_teaching ' . lang('web_edit_success')));
                                redirect("admin/non_teaching/");
                        }
                        else
                        {
                                $this->session->set_flashdata('error', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/non_teaching/");
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
                $data['contracts'] = $this->non_teaching_m->populate('contracts', 'id', 'name');
                $data['departments'] = $this->non_teaching_m->populate('departments', 'id', 'name');
                //load the view and the layout
                $this->template->title('Edit Non_teaching ')->build('admin/create', $data);
        }

        function profile($id = FALSE)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/non_teaching/');
                }
                if (!$this->non_teaching_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/non_teaching');
                }

                $post = $this->non_teaching_m->find($id);
                $data['post'] = $post;

                $this->load->model('record_salaries/record_salaries_m');


                $data['group'] = $this->non_teaching_m->populate('groups', 'id', 'name');
                $data['contracts'] = $this->non_teaching_m->populate('contracts', 'id', 'name');
                $data['departments'] = $this->non_teaching_m->populate('departments', 'id', 'name');
                //$data['record_salaries'] = $this->record_salaries_m->staff_salary($id);
                //$data['sickness'] = $this->non_teaching_m->staff_sickness($id);
                //$data['staff_study'] = $this->non_teaching_m->staff_study($id);
                //$data['staff_compassionate'] = $this->non_teaching_m->staff_compassionate($id);
                //$data['staff_others'] = $this->non_teaching_m->staff_others($id);
                //$data['staff_annual'] = $this->non_teaching_m->staff_annual($id);


                $this->template->title(' Non_teaching Profile')->build('admin/view', $data);
        }

        
		function disable($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/non_teaching/');
            }
         if(!$this->non_teaching_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/non_teaching');
              }
			  
          $done = $this->non_teaching_m->update_attributes($id, array('status'=>0));
			   
			   
        if ( $done) 
            {
				//$details = implode(' , ', $this->input->post());
				 $user = $this->ion_auth->get_user();
				 $log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $done, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
						'details' => 'disabled',   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
								  
								  
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/non_teaching/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/non_teaching/");
			}
	}
	
	function enable($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/non_teaching/');
            }
         if(!$this->non_teaching_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/non_teaching');
              }
			  
          $done = $this->non_teaching_m->update_attributes($id, array('status'=>1));
			   
			   
        if ( $done) 
            {
				//$details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
								 $log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $done, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
										'details' => 'Enabled',   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
				
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/non_teaching/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/non_teaching/");
			}
	}	
		
		/**
         * Add To Group  Non_teaching 
         *
         * @param $id
         * @param $page
         */
        function add_groups($id = FALSE)
        {

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/non_teaching/');
                }
                if (!$this->non_teaching_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/non_teaching');
                }

                // the information has therefore been successfully saved in the db

                $user = $this->ion_auth->get_user();
                $memG = $this->input->post('member_groups');

                if (isset($memG))
                {

                        $gdata = array(
                            'member_id' => $id,
                            'group_id' => $memG,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        $done = $this->non_teaching_m->insert_gm($gdata);

                        //print_r($memG );die;
                }


                if ($done)
                {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Non_teaching ' . lang('web_edit_success')));
                        redirect("admin/non_teaching/");
                }
                else
                {
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/non_teaching/");
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

                        redirect('admin/non_teaching');
                }

                //search the item to delete
                if (!$this->non_teaching_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/non_teaching');
                }

                //delete the item
                if ($this->non_teaching_m->delete($id) == TRUE)
                {
                        // $details = implode(' , ', $this->input->post());
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
								  
						$this->session->set_flashdata('message', array('type' => 'sucess', 'text' => 'Non_teaching ' . lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/non_teaching/");
        }

        /**
         * Generate Validation Rules
         *
         * @return array()
         */
        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'first_name',
                        'label' => 'First Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'middle_name',
                        'label' => 'Middle Name',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'gender',
                        'label' => 'Gender',
                        'rules' => 'trim'),
                
                    array(
                        'field' => 'date_left',
                        'label' => 'Date of Leaving',
                        'rules' => 'trim'),
                    array(
                        'field' => 'contract_type',
                        'label' => 'Contract Type',
                        'rules' => 'trim'),
                    array(
                        'field' => 'marital_status',
                        'label' => 'marital status',
                        'rules' => 'trim'),
                    array(
                        'field' => 'dob',
                        'label' => 'Date of Birth',
                        'rules' => 'trim'),

						array(
                        'field' => 'date_joined',
                        'label' => 'Date Joined',
                        'rules' => 'trim'),
                    array(
                        'field' => 'pin',
                        'label' => 'PIN',
                        'rules' => 'trim'),
                    array(
                        'field' => 'religion',
                        'label' => 'Religion',
                        'rules' => 'trim'),
                    array(
                        'field' => 'id_no',
                        'label' => 'ID No',
                        'rules' => 'trim'),
                    array(
                        'field' => 'qualification',
                        'label' => 'qualification',
                        'rules' => 'trim'),
                    array(
                        'field' => 'position',
                        'label' => 'position',
                        'rules' => 'trim'),

					
                    array(
                        'field' => 'last_name',
                        'label' => 'Last Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'phone',
                        'label' => 'Phone',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                  

						array(
                        'field' => 'department',
                        'label' => 'department',
                        'rules' => 'trim'),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|valid_email|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'address',
                        'label' => 'Address',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                    array(
                        'field' => 'additionals',
                        'label' => 'Additionals',
                        'rules' => 'trim|min_length[0]|max_length[500]'),
						
					array(
                        'field' => 'ref_name',
                        'label' => 'Name',
                        'rules' => 'trim'),
					array(
                        'field' => 'ref_phone',
                        'label' => 'Name',
                        'rules' => 'trim'),
						
					array(
                        'field' => 'ref_email',
                        'label' => 'Email',
                        'rules' => 'trim|valid_email'),
					array(
                        'field' => 'ref_address',
                        'label' => 'Address',
                        'rules' => 'trim'),
					array(
                        'field' => 'ref_additionals',
                        'label' => 'Additional Details',
                        'rules' => 'trim'),
						
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        /**
         * Generate Pagination Config
         *
         * @return array()
         */
        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/non_teaching/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000000;
                $config['total_rows'] = $this->non_teaching_m->count();
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
                //$choice = $config["total_rows"] / $config["per_page"];
                //$config["num_links"] = round($choice);

                return $config;
        }

}
