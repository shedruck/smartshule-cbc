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
                $this->load->model('grades_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['grades'] = $this->grades_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                //load view
                $this->template->title(' Grades ')->build('admin/list', $data);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $form_data_aux = array();
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'remarks' => $this->input->post('remarks'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $ok = $this->grades_m->create($form_data);
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
                        redirect('admin/grades/');
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
                        $this->template->title('Add Grades ')->build('admin/create', $data);
                }
        }

        function quick_add($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $form_data_aux = array();
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'remarks' => $this->input->post('remarks'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $ok = $this->grades_m->create($form_data);
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
                        redirect('admin/grading/create');
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
                        $this->template->title('Add Grades ')->build('admin/create', $data);
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
                        redirect('admin/grades/');
                }
                if (!$this->grades_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grades');
                }
                //search the item to show in edit form
                $get = $this->grades_m->find($id);
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
                            'remarks' => $this->input->post('remarks'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);
                        //find the item to update
                        $done = $this->grades_m->update_attributes($id, $form_data);
                        
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
                                redirect("admin/grades/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/grades/");
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
                $this->template->title('Edit Grades ')->build('admin/create', $data);
        }

        /**
         * 
         * @param type $id
         * @param type $grading
         */
        function edit_grading($id = 0, $grading = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading/view/' . $grading);
                }
                if (!$this->grades_m->exists_grade($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading/view/' . $grading);
                }
                //search the item to show in edit form
                $get = $this->grades_m->find_grading($id);
                //Rules for validation
                $this->form_validation->set_rules($this->gd_validation());
                //create control variables
                $data['updType'] = 'edit';
                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'minimum_marks' => $this->input->post('minimum_marks'),
                            'maximum_marks' => $this->input->post('maximum_marks'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->grades_m->update_grading($id, $form_data);
                        
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
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => "error Saving Grading"));
                        }
                        redirect('admin/grading/view/' . $grading);
                }
                else
                {
                        foreach (array_keys($this->gd_validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->{$field} = $this->form_validation->{$field};
                                }
                        }
                }
                $data['result'] = $get;
                $data['grading'] = $grading;
                //load the view and the layout
                $this->template->title('Edit Grading ')->build('admin/grading', $data);
        }

        function delete($id = NULL, $grade = 0)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading');
                }
                /* 	//search the item to delete
                  if ( !$this->grades_m->exists($id) )
                  {
                  $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                  redirect('admin/grades');
                  } */
                //search the item to delete
                if (!$this->grades_m->exists_sys($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/grading');
                }
                //delete the item
                if ($this->grades_m->delete_records($id, $grade) == TRUE)
                {
                       // $details = implode(' , ', $this->input->post());
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
                redirect("admin/grading/view/" . $id);
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'remarks',
                        'label' => 'Remarks',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function gd_validation()
        {
                $config = array(
                    array(
                        'field' => 'minimum_marks',
                        'label' => 'Minimum Marks',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'maximum_marks',
                        'label' => 'Maximum Marks',
                        'rules' => 'required|trim|xss_clean'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/grades/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000000;
                $config['total_rows'] = $this->grades_m->count();
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
