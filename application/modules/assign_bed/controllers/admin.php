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
                $this->load->model('assign_bed_m');
                $this->load->model('hostel_beds/hostel_beds_m');
        }
		
		
  function assign($bed=NULL,$page = NULL)
        {
            //create control variables
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
 
        //Rules for validation
        $this->form_validation->set_rules($this->valid_rules());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
			
			  if($this->assign_bed_m-> exists_student($this->input->post('student')) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => '<b style="color:red">Sorry this student has been assigned bed!!</b>' ) );
            redirect('admin/assign_bed/assign/'.$bed.'/'.$page);
              }
          $user = $this -> ion_auth -> get_user();
		  
        $form_data = array(
				'date_assigned' => strtotime($this->input->post('date_assigned')), 
				'student' => $this->input->post('student'), 
				'term' => $this->input->post('term'), 
				'year' => $this->input->post('year'), 
				'bed' =>$bed , 
				'comment' => $this->input->post('comment'), 
				'created_by' => $user -> id ,   
				'created_on' => time()
			);

            $ok=  $this->assign_bed_m->create($form_data);

            if ( $ok ) // the information has therefore been successfully saved in the db
            {
                    $updet = array(
						'status' => 1, 
						 'modified_by' => $user -> id ,   
						 'modified_on' => time()
					);
			 
            $this->hostel_beds_m->update_attributes($bed, $updet);
			
					$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/hostel_beds/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                }
				
				$range = range(date('Y') - 3, date('Y') + 1);
                $data['yrs'] = array_combine($range, $range);
		 
                 $data['result'] = $get; 
                 
		 //load the view and the layout
		 $this->template->title('Add Assign Bed ' )->build('admin/assign', $data);
		}		
	} 

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['assign_bed'] = $this->assign_bed_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['beds'] = $this->assign_bed_m->get_hostel_beds();
                //load view
                $this->template->title(' Assign Bed ')->build('admin/list', $data);
        }

        //Public function create post

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
                        if ($this->assign_bed_m->exists_student($this->input->post('student')))
                        {
                                $this->session->set_flashdata('message', array('type' => 'warning', 'text' => '<b style="color:red">Sorry this student has been assigned bed!!</b>'));
                                redirect('admin/assign_bed/create/1');
                        }

                        $user = $this->ion_auth->get_user();
                        $bed = $this->input->post('bed');
                        $form_data = array(
                            'date_assigned' => strtotime($this->input->post('date_assigned')),
                            'student' => $this->input->post('student'),
                            'term' => $this->input->post('term'),
                            'year' => $this->input->post('year'),
                            'bed' => $bed,
                            'comment' => $this->input->post('comment'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->assign_bed_m->create($form_data);

                        if ($ok) 
                        {
                                $updet = array(
                                    'status' => 1,
                                    'modified_by' => $user->id,
                                    'modified_on' => time()
                                );
                                $this->hostel_beds_m->update_attributes($bed, $updet);
								
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

                        redirect('admin/hostel_beds/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
                        $range = range(date('Y') - 3, date('Y') + 1);
                        $data['yrs'] = array_combine($range, $range);
                        $data['result'] = $get;
                        $data['beds'] = $this->assign_bed_m->list_hostel_beds();
                        //load the view and the layout
                        $this->template->title('Add Assign Bed ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assign_bed/');
                }
                if (!$this->assign_bed_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/assign_bed');
                }
                $range = range(date('Y') - 3, date('Y') + 1);
                $data['yrs'] = array_combine($range, $range);

                $data['beds'] = $this->assign_bed_m->get_hostel_beds();
                $get = $this->assign_bed_m->find($id);

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
                            'date_assigned' => strtotime($this->input->post('date_assigned')),
                            'student' => $this->input->post('student'),
                            'term' => $this->input->post('term'),
                            'year' => $this->input->post('year'),
                            'bed' => $this->input->post('bed'),
                            'comment' => $this->input->post('comment'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->assign_bed_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
                                $updet = array(
                                    'status' => 1,
                                    'modified_by' => $user->id,
                                    'modified_on' => time()
                                );

                                $this->hostel_beds_m->update_attributes($bed, $updet);
								
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
                                redirect("admin/assign_bed/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/assign_bed/");
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
                $this->template->title('Edit Assign Bed ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/assign_bed');
                }

                //search the item to delete
                if (!$this->assign_bed_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/assign_bed');
                }

                //delete the item
                if ($this->assign_bed_m->delete($id) == TRUE)
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

                redirect("admin/assign_bed/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'date_assigned',
                        'label' => 'Date Assigned',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'term',
                        'label' => 'Term',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'year',
                        'label' => 'Year',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'bed',
                        'label' => 'Bed',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'comment',
                        'label' => 'Comment',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

		
	private function valid_rules()
    {
$config = array(
                 array(
		 'field' =>'date_assigned',
                 'label' => 'Date Assigned',
                 'rules' =>'required|xss_clean'),
				 
		 array(
		 'field' =>'term',
                'label' => 'school term',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

				array(
		 'field' =>'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),


                 array(
		 'field' =>'student',
                'label' => 'Student',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

               

                array(
		 'field' =>'comment',
                'label' => 'Comment',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/assign_bed/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 1000000000;
                $config['total_rows'] = $this->assign_bed_m->count();
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
