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
                /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                  {
                  $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                  redirect('admin');
                  } */

                $this->load->model('fee_waivers_m');
                $this->load->model('accounts/accounts_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['fee_waivers'] = $this->fee_waivers_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' Fee Waivers ')->build('admin/list', $data);
        }

        
        function create($page = NULL)
        {
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();

                        $length = $this->input->post('date');
                        $size = count($length);
                        $ammt = 0;
                        for ($i = 0; $i < $size; ++$i)
                        {
                                $date = $this->input->post('date');
                                $amount = $this->input->post('amount');
                                $year = $this->input->post('year');
                                $term = $this->input->post('term');
                                $remarks = $this->input->post('remarks');
                                $student = $this->input->post('student');

                                $table_list = array(
                                    'date' => strtotime($date[$i]),
                                    'student' => $student[$i],
                                    'amount' => $amount[$i],
                                    'term' => $term[$i],
                                    'year' => $year[$i],
                                    'status' => 0,
                                    'qb_status' =>0,
                                    'f_status' => 0,
                                    'flagged' => 0,
                                    'remarks' => $remarks[$i],
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                               
								
                                $ok = $this->fee_waivers_m->create($table_list);

                                //get the initial balance from the Discounts and waivers acc
                                // $acc_bal= $this->fee_waivers_m->get_accounts_bal('399');
                                // foreach($acc_bal as $b){
                                //         $new_bal= ($b->balance+500);
                                // }

                                

                                // echo $new_balance;
                              
								
                                $ammt += $amount[$i];
                                $bal= $this->fee_waivers_m->get_accounts_bal('399');
                                $new_bal= ($ammt+$bal->balance);

                                // $this->worker->calc_balance($student[$i]);
                                //SEND SMS TO PARENT

                                $st_details = $this->fee_waivers_m->get_student($student[$i]);
                                $parent_details = $this->fee_waivers_m->get_parent($st_details->parent_id);

                                if (!empty($parent_details))
                                {
                                        $skul = $this->ion_auth->settings();
                                        $recipient = $parent_details->phone;
                                        $to = $parent_details->first_name;

                                        $st = $this->worker->get_student($student[$i]);
                                        if (empty($st))
                                        {
                                                $st = new stdClass();
                                                $st->first_name = '';
                                                $st->last_name = '';
                                        }
                                        $stud = $st->first_name . ' ' . $st->last_name;
                                        $initial = isset($this->school->message_initial) && !empty($this->school->message_initial) ? $this->school->message_initial : 'Hi';

                                        $message = $initial . ' ' . $to . ', Student ' . $stud . ' has been awarded a fee waiver of ' . number_format($amount[$i], 2) . '. Thanks for choosing ' . $skul->school;
                                        $this->sms_m->send_sms($recipient, $message);
                                }
								
								$details = implode(' , ', $table_list);
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
								  
                        }
                        // echo $new_bal;
                        $up_acc= array(
                                'balance' => $new_bal,
                                'modified_on' => time(),
                                'modified_by' => $user->id
                        );

                       

                        if ($ok)
                        {
                                $this->fee_waivers_m->update_account('56', $up_acc);
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/fee_waivers/');
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
                        $this->template->title('Add Fee Waivers ')->build('admin/create', $data);
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
                        redirect('admin/fee_waivers/');
                }
                if (!$this->fee_waivers_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_waivers');
                }
                //get the item to show in edit form
                $get = $this->fee_waivers_m->find($id);
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
                            'date' => strtotime($this->input->post('date')),
                            'student' => $this->input->post('student'),
                            'amount' => $this->input->post('amount'),
                            'term' => $this->input->post('term'),
                            'year' => $this->input->post('year'),
                            'remarks' => $this->input->post('remarks'),
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        $done = $this->fee_waivers_m->update_attributes($id, $form_data);

                        $bal= $this->fee_waivers_m->get_accounts_bal('399'); //current balance in the account tbl
                
                        $current_bal= $bal->balance; //current balance in the accounts tbl for the selected account

                        $amount= $this->input->post('amount');
                        if($amount > $get->amount){
                                $diff= ($amount -$get->amount);
                                $new_balance= ($current_bal + $diff);
                        }
                        if($amount == $get->amount){
                                $new_balance= $current_bal ;
                        }
                   
                        if($amount < $get->amount){
                                $diff= ($get->amount-$amount);
                                $new_balance=  ($current_bal - $diff);
                        }

                        $acc_data=array(
                                'balance' => $new_balance,
                                'modified_on' =>time(),
                                'modified_by' =>$user->id
                        );

                        $this->fee_waivers_m->update_account('56', $acc_data);
                           


                        if ($done)

                        {
                                $this->fee_waivers_m->update_account('56', $acc_data);
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
                                redirect("admin/fee_waivers/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/fee_waivers/");
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
                $this->template->title('Edit Fee Waivers ')->build('admin/edit', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_waivers');
                }

                //search the item to delete
                if (!$this->fee_waivers_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/fee_waivers');
                }
                $bal= $this->fee_waivers_m->get_accounts_bal('399'); //current balance in the account tbl
                $get = $this->fee_waivers_m->find($id);
                $user= $this->ion_auth->get_user();
               
                $current_bal= $bal->balance;
                $new_balance= ($current_bal - $get->amount);

                $acc_data=array(
                        'balance' => $new_balance,
                        'modified_on' =>time(),
                        'modified_by' =>$user->id
                );
               

                // delete the item
                if ($this->fee_waivers_m->delete($id) == TRUE)
                {
                        $this->fee_waivers_m->update_account('56', $acc_data);//update acc
                         
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

                redirect("admin/fee_waivers/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'date',
                        'label' => 'Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'student',
                        'label' => 'Student',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'amount',
                        'label' => 'Amount',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'year',
                        'label' => 'Year',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'term',
                        'label' => 'Term',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'remarks',
                        'label' => 'Remarks',
                        'rules' => 'xss_clean'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/fee_waivers/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10000000;
                $config['total_rows'] = $this->fee_waivers_m->count();
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


        function pending()
        {

              if($this->input->post())
              {
                  $items = $this->input->post('items');
                  $count = count($items);
                  $user = $this->ion_auth->get_user();
                  $t = 0;

                  if(is_array($items) && count($items))
                  {
                      for($k=0; $k<$count; $k++)
                      {
                          $data = [
                              'status' => 1,
                              'modified_on' => time(),
                              'modified_by' => $user->id,
                          ];

                          $ok = $this->fee_waivers_m->update_attributes($items[$k], $data);
                          $t++;

                          $details = implode(' , ', $data);
                          $log = array(
                              'module' => $this->router->fetch_module(),
                              'item_id' => $items[$k],
                              'transaction_type' => $this->router->fetch_method(),
                              'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $items[$k],
                              'details' => $details,
                              'created_by' => $user->id,
                              'created_on' => time()
                          );

                          $this->ion_auth->create_log($log);
                      }
                  }

                  if ($ok)
                  {
                      $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-check'></i> Successfully approved ({$k})</b>"));
                  }
                  else
                  {
                      $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Could Not approve selected items ({$k})</b>"));
                  }

                  redirect('admin/fee_waivers/pending');
              }

              $data['pending'] = $this->fee_waivers_m->get_pending() ;

              $this->template->title('PENDING WAIVERS ')->build('admin/p_waivers', $data);
        }

}
