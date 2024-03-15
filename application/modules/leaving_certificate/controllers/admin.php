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
                $this->load->model('leaving_certificate_m');
                $this->load->model('admission/admission_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['leaving_certificate'] = $this->leaving_certificate_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                //load view
                $this->template->title(' Leaving Certificate ')->build('admin/list', $data);
        }

        /**
         * Leaving Certificate
         * 
         * @param int $id record ID
         * @param int $page - the pagination offset
         */
        function view($id = 0)
        {
                if (!$this->leaving_certificate_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/leaving_certificate');
                }
                $post = $this->leaving_certificate_m->find($id);
                $data['student'] = $this->admission_m->find($post->student_id);
                $data['post'] = $post;
                $this->template->title('Leaving Certificate')->build('admin/cert', $data);
        }

        function create($id = 0)
        {
                $page = 1;
                $stud_id = $id;
                if ($stud_id == 0)
                {
                        $stud_id = $this->input->post('student');
                }
                $this->load->library('Key');

                $data['student'] = $this->admission_m->find($id);
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
				//Verification cade
				$code = $this->portal_m->find($stud_id);
				$vcode =  $code->upi_number.'-'.date('Y').'/'.$stud_id;
				
                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $key = $this->key->generate_key();
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'ht_remarks' => $this->input->post('ht_remarks'),
                            'leaving_date' => strtotime($this->input->post('leaving_date')),
                            'co_curricular' => $this->input->post('co_curricular'),
                            'student_id' => $stud_id,
                            'verification_code' => $vcode,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
						
                        $exists = $this->leaving_certificate_m->check_exists($stud_id);
						
                        if ($exists)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Leaving Certificate Already Exists"));
                                redirect('admin/leaving_certificate/create');
                        }
                        else
                        {
                                $ok = $this->leaving_certificate_m->create($form_data);
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
                                redirect('admin/leaving_certificate/view/' . $ok);
                        }
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
                        if ($id == 0)
                        {
                                $this->template->title('Add Leaving Certificate ')->build('admin/create', $data);
                        }
                        else
                        {
                                $this->template->title('Add Leaving Certificate ')->build('admin/add', $data);
                        }
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/leaving_certificate/');
                }
                if (!$this->leaving_certificate_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/leaving_certificate');
                }
                //search the item to show in edit form
                $get = $this->leaving_certificate_m->find($id);

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
                            'ht_remarks' => $this->input->post('ht_remarks'),
                            'leaving_date' => strtotime($this->input->post('leaving_date')),
                            'co_curricular' => $this->input->post('co_curricular'),
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        $done = $this->leaving_certificate_m->update_attributes($id, $form_data);

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
                                redirect("admin/leaving_certificate/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/leaving_certificate/");
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
                $this->template->title('Edit Leaving Certificate ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/leaving_certificate');
                }
                //search the item to delete
                if (!$this->leaving_certificate_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/leaving_certificate');
                }
                //delete the item
                if ($this->leaving_certificate_m->delete($id) == TRUE)
                {
                         ////$details = implode(' , ', $this->input->post());
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
                redirect("admin/leaving_certificate/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'ht_remarks',
                        'label' => 'Head teacher Remarks',
                        'rules' => 'trim|required'),
                    array(
                        'field' => 'leaving_date',
                        'label' => 'Leaving Date',
                        'rules' => 'trim|required'),
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => 'trim|required|xss_clean|min_length[0]'),
                    array(
                        'field' => 'co_curricular',
                        'label' => 'Co Curricular',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/leaving_certificate/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 1000000000;
                $config['total_rows'] = $this->leaving_certificate_m->count();
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
