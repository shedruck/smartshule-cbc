<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                /* $this->template->set_layout('default');
                  $this->template->set_partial('sidebar', 'partials/sidebar.php')
                  ->set_partial('top', 'partials/top.php'); */
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
                $this->load->model('fee_pledge_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['fee_pledge'] = $this->fee_pledge_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' Fee Pledge ')->build('admin/list', $data);
        }

        //SEND REMINDER

        public function reminder($id = FALSE)
        {

                $student_details = $this->fee_pledge_m->find($id);

                $st_details = $this->fee_pledge_m->get_student($student_details->student);

                $parent_details = $this->fee_pledge_m->get_parent($st_details->parent_id);

                if (!empty($parent_details))
                {
                        $class = $this->ion_auth->list_classes();
                        $skul = $this->ion_auth->settings();

                        $recipient = $parent_details->phone;
                        $country_code = '254';
                        $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                        $to = $parent_details->first_name;

                        $student = $this->ion_auth->students_full_details();

                        $stud = $student[$student_details->student];

                        $amount = $student_details->amount;

                        $due_details = 'is due on ' . date('d M Y', $student_details->pledge_date) . ' remember to fulfil it';
                        if ($student_details->pledge_date < time())
                        {
                                $due_details = ' is Overdue , kindly fulfil it';
                        }
                        $message = $skul->message_initial . ' ' . $to . ', Your pledge of ' . number_format($amount, 2) . ' for ' . $stud . ' ' . $due_details . '. Thanks for choosing ' . $skul->school;

                        //$from = "SMARTSHULE";
                        $this->sms_m->send_sms($new_number, $message);
						
						 //$details = implode(' , ', $this->input->post());
								$user = $this->ion_auth->get_user();
									$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $id, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
										'details' => $message,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);

                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Reminder Successfully Sent</b>"));
                }
                else
                {

                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b style='color:red'>Sorry, That student do not have Parent/Guardian details !!</b>"));
                }
                redirect('admin/fee_pledge/');
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
                            'pledge_date' => strtotime($this->input->post('pledge_date')),
                            'amount' => $this->input->post('amount'),
                            'status' => $this->input->post('status'),
                            'remark' => $this->input->post('remark'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->fee_pledge_m->create($form_data);

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

                        redirect('admin/fee_pledge/');
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
                        $this->template->title('Add Fee Pledge ')->build('admin/create', $data);
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
                        redirect('admin/fee_pledge/');
                }
                if (!$this->fee_pledge_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_pledge');
                }
                //search the item to show in edit form
                $get = $this->fee_pledge_m->find($id);
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
                            'student' => $this->input->post('student'),
                            'pledge_date' => strtotime($this->input->post('pledge_date')),
                            'amount' => $this->input->post('amount'),
                            'status' => $this->input->post('status'),
                            'remark' => $this->input->post('remark'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //add the aux form data to the form data array to save
                        $form_data = array_merge($form_data_aux, $form_data);

                        //find the item to update

                        $done = $this->fee_pledge_m->update_attributes($id, $form_data);

                        
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
                                redirect("admin/fee_pledge/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/fee_pledge/");
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
                $this->template->title('Edit Fee Pledge ')->build('admin/create', $data);
        }

        //Update pledge as paid
        function paid($id = FALSE, $page = 0)
        {

                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_pledge/');
                }
                if (!$this->fee_pledge_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_pledge');
                }

                $user = $this->ion_auth->get_user();
                // build array for the model
                $form_data = array(
                    'status' => 'paid',
                    'modified_by' => $user->id,
                    'modified_on' => time());


                $done = $this->fee_pledge_m->update_attributes($id, $form_data);

                
                if ($done)
                {           $details = implode(' , ', $form_data);
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
                        redirect("admin/fee_pledge/");
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/fee_pledge/");
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

                        redirect('admin/fee_pledge');
                }

                //search the item to delete
                if (!$this->fee_pledge_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/fee_pledge');
                }

                //delete the item
                if ($this->fee_pledge_m->delete($id) == TRUE)
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

                redirect("admin/fee_pledge/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'pledge_date',
                        'label' => 'Pledge Date',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'amount',
                        'label' => 'Amount',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'remark',
                        'label' => 'Remark',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/fee_pledge/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000000;
                $config['total_rows'] = $this->fee_pledge_m->count();
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
