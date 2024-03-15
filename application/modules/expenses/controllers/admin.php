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

                $this->load->model('expenses_m');
                $this->load->model('accounts/accounts_m');
                $this->load->model('accounts/fee_payment_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['expenses'] = $this->expenses_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['cats'] = $this->expenses_m->list_categories();
                $data['total_expenses'] = $this->expenses_m->total_expenses();
                $data['total_petty_cash'] = $this->expenses_m->total_petty_cash();
                $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');
                $data['total_exp_day'] = $this->expenses_m->total_expenses_today();
                $data['total_exp_month'] = $this->expenses_m->total_expenses_month();
                $data['total_exp_year'] = $this->expenses_m->total_expenses_year();
                $data['bank'] = $this->fee_payment_m->list_banks();
                ///Salaries Balances
                $basic = $this->expenses_m->total_basic();
                $allowances = $this->expenses_m->total_allowances();
                $dec_advance = $this->expenses_m->deduct_advance();
                $advance = $this->expenses_m->total_advance();
                $total_paid = (($basic->basic + $allowances->allowance + $advance->advance ) - $dec_advance->total);
                $data['wages'] = $total_paid;
                $this->template->title('Expenses')->build('admin/list', $data);
        }

        public function requisitions()
        {
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['reqs'] = $this->expenses_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['cats'] = $this->expenses_m->list_categories();
                $data['total_expenses'] = $this->expenses_m->total_expenses();
                $data['total_petty_cash'] = $this->expenses_m->total_petty_cash();
                $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');

                $this->template->title('Requisitions')->build('admin/reqs', $data);
        }

        public function by_category($id)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/');
                }
                if (!$this->expenses_m->cat_exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses');
                }
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['expenses'] = $this->expenses_m->by_category($id);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['cats'] = $this->expenses_m->list_categories();
                $data['total_expenses'] = $this->expenses_m->total_expenses();
                $data['total_petty_cash'] = $this->expenses_m->total_petty_cash();
                $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');
                $data['total_exp_day'] = $this->expenses_m->total_expenses_today();
                $data['total_exp_month'] = $this->expenses_m->total_expenses_month();
                $data['total_exp_year'] = $this->expenses_m->total_expenses_year();
                ///Salaries Balances
                $basic = $this->expenses_m->total_basic();
                $allowances = $this->expenses_m->total_allowances();
                $dec_advance = $this->expenses_m->deduct_advance();
                $advance = $this->expenses_m->total_advance();
                $total_paid = (($basic->basic + $allowances->allowance + $advance->advance ) - $dec_advance->total);
                $data['wages'] = $total_paid;
                //load view
                $this->template->title('Expenses')->build('admin/by_category', $data);
        }

        public function voided()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['expenses'] = $this->expenses_m->all_voided($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['cats'] = $this->expenses_m->list_categories();
                $data['total_expenses'] = $this->expenses_m->total_expenses();
                $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');
                $data['total_exp_day'] = $this->expenses_m->total_expenses_today();
                $data['total_exp_month'] = $this->expenses_m->total_expenses_month();
                $data['total_exp_year'] = $this->expenses_m->total_expenses_year();
                ///Salaries Balances
                $basic = $this->expenses_m->total_basic();
                $allowances = $this->expenses_m->total_allowances();
                $dec_advance = $this->expenses_m->deduct_advance();
                $advance = $this->expenses_m->total_advance();
                $total_paid = (($basic->basic + $allowances->allowance + $advance->advance ) - $dec_advance->total);
                $data['wages'] = $total_paid;
                //load view
                $this->template->title(' Expenses ')->build('admin/voided', $data);
        }

        //Details view function
        function view($id)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/');
                }
                if (!$this->expenses_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses');
                }
                $data['p'] = $this->expenses_m->find($id);
                $data['cats'] = $this->expenses_m->list_categories();
                $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');
                $this->template->title(' Expense Details ')->build('admin/view', $data);
        }

        function void($id)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/');
                }
                if (!$this->expenses_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses');
                }
                //search the item to show in edit form
                $get = $this->expenses_m->find($id);
                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'status' => 0,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );
                //find the item to update
                $done = $this->expenses_m->update_attributes($id, $form_data);
                
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
						
						$get_account = $this->accounts_m->get_by_code(429);
                        /**
                         * * Reduce accounts chart by the balance then add the input amount
                         * */
                        $balance = $get_account->balance;
                        $initial_amount = $get->amount;
                        $actual_amt = $balance - $initial_amount;
                        $bal_details = array(
                            'balance' => $actual_amt,
                            'modified_by' => $user->id,
                            'modified_on' => time());
                        $this->accounts_m->update_attributes($get_account->id, $bal_details);
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Record successfully voided'));
                        redirect("admin/expenses");
                }
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
                { //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $total = 0;
                        $length = $this->input->post('expense_date');
                        $size = count($length);
                        for ($i = 0; $i < $size; ++$i)
                        {
                                $expense_date = $this->input->post('expense_date');
                                $amount = $this->input->post('amount');
                                $title = $this->input->post('title');
                                $category = $this->input->post('category');
                                $person_responsible = $this->input->post('person_responsible');
                                $rec = $this->input->post('receipt');
                                $description = $this->input->post('description');
                                $receipt = $rec[$i];
                                 $bank_id =  $this->input->post('bank_id');
								
                                if (!empty($_FILES[$receipt]['name']))
                                {
                                        $this->load->library('files_uploader');
                                        $upload_data = $this->files_uploader->upload($receipt);
                                        $receipt = $upload_data['file_name'];
                                }

                                $form_data = array(
                                    'expense_date' => strtotime($expense_date[$i]),
                                    'title' => $title[$i],
                                    'category' => $category[$i],
                                    'amount' => $amount[$i],
                                    'receipt' => $receipt,
                                    'bank_id' => $bank_id[$i],
                                    'status' => 1,
                                    'person_responsible' => $person_responsible[$i],
                                    'description' => $description[$i],
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                                $total += $amount[$i];
                                $ok = $this->expenses_m->create($form_data);
								
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
								  
								  
                        }
                        if ($ok) 
                        {
                                $this->worker->log_journal($total, 'expenses', $ok, array(5003 => 'debit', 2001 => 'credit'));
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }
                        redirect('admin/expenses/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
                        $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');
                        $data['result'] = $get;
                        $data['list_user'] = $this->ion_auth->get_user_list();
                        $data['cats'] = $this->expenses_m->list_categories();
                         $data['chart'] = $this->expenses_m->get_accounts();
                         $data['bank'] = $this->fee_payment_m->list_banks();
                        //load the view and the layout
                        $this->template->title('Add Expenses ')->build('admin/create', $data);
                }
        }

        /**
         * Add Requisition
         * 
         */
        function create_req()
        {
                $payd = json_decode(file_get_contents('php://input'), true);
                if (!empty($payd))
                {
                        $user = $this->ion_auth->user()->row();
                        if (!count($payd['items']) || $payd['total'] == 0)
                        {
                                $err = ['code' => 400, 'errors' => ['Add at least one Item']];
                                echo json_encode($err);
                                exit();
                        }
                        else
                        {
                                $items = $payd['items'];
                                if (count($items))
                                {
                                        $rq = $this->expenses_m->put_req('requisitions', array('total' => $payd['total'], 'approved' => 0, 'status' => 1, 'created_on' => time(), 'created_by' => $user->id));

                                        if ($rq)
                                        {
                                                foreach ($items as $it)
                                                {
                                                        $t = (object) $it;
                                                        $rform = array(
                                                            'rec_id' => $rq,
                                                            'descr' => $t->description,
                                                            'qty' => $t->qty,
                                                            'price' => $t->cost,
                                                            'status' => 3,
                                                            'created_on' => time(),
                                                            'created_by' => $user->id
                                                        );
														
                                                       $done = $this->expenses_m->put_req('req_items', $rform);
														
														 $details = implode(' , ', $rform);
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
                                        }
                                }
                        }
                        return true;
                }
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : 0;
                $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');
                $data['list_user'] = $this->ion_auth->get_user_list();
                $data['cats'] = $this->expenses_m->list_categories();
                //load the view and the layout
                $this->template->title('Create Requisition ')->build('admin/create_req', $data);
        }

        /**
         * Post Requisition Update
         */
        function post_comment()
        {
                $post = json_decode(file_get_contents('php://input'), true);

                if (isset($post['req']) && isset($post['msg']) && !empty($post['msg']))
                {
                        $user = $this->ion_auth->user()->row();
                        $rform = array(
                            'req_id' => $post['req'],
                            'message' => $post['msg'],
                            'created_on' => time(),
                            'created_by' => $user->id
                        );
						
                       $done =  $this->expenses_m->put_req('req_wall', $rform);
						
						 $details = implode(' , ', $rform);
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
        }

        /**
         * Change Status
         */
        function post_status()
        {
                $post = json_decode(file_get_contents('php://input'), true);

                if (isset($post['id']) && isset($post['status']))
                {
                        $user = $this->ion_auth->user()->row();
                        $rqst = array('status' => $post['status'], 'modified_by' => $user->id, 'modified_on' => time());
                        $done = $this->expenses_m->set_item($post['id'], $rqst);
						
						 $details = implode(' , ', $rqst);
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
                else
                {
                        $err = ['code' => 400, 'errors' => ['Invalid POST. Try Again']];
                        echo json_encode($err);
                        exit();
                }
        }

        function update_req($id)
        {
                $payd = json_decode(file_get_contents('php://input'), true);
                if (!empty($payd))
                {
                        $user = $this->ion_auth->user()->row();
                        if (!count($payd['items']) || $payd['total'] == 0)
                        {
                                $err = ['code' => 400, 'errors' => ['Add at least one Item']];
                                echo json_encode($err);
                                exit();
                        }
                        else
                        {
                                $items = $payd['items'];
                                if (count($items))
                                {
                                        $this->expenses_m->set_req($id, array('total' => $payd['total'], 'approved' => 0, 'modified_on' => time(), 'modified_by' => $user->id));
                                        $this->expenses_m->clear_req_items($id);
                                        foreach ($items as $it)
                                        {
                                                $t = (object) $it;
                                                $rform = array(
                                                    'rec_id' => $id,
                                                    'descr' => $t->descr,
                                                    'qty' => $t->qty,
                                                    'price' => $t->cost,
                                                    // 'status' => 3,
                                                    'created_on' => time(),
                                                    'created_by' => $user->id
                                                );
                                                $done = $this->expenses_m->put_req('req_items', $rform);
												
												 $details = implode(' , ', $rform);
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
                                }
                        }
                        return true;
                }
        }

        function edit_req($id)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/requisitions');
                }
                $data['list_user'] = $this->ion_auth->get_user_list();
                $req = $this->expenses_m->get_req($id);

                foreach ($req->items as $r)
                {
                        $r->description = $r->descr;
                        $r->cost = $r->price;
                }
                $data['req'] = $req;
                $data['id'] = $id;
                //load the view and the layout
                $this->template->title('Edit Requisition')->build('admin/edit_req', $data);
        }

        function view_req($id)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/requisitions');
                }
                $data['list_user'] = $this->ion_auth->get_user_list();
                $req = $this->expenses_m->get_req($id);

                $messages = $this->expenses_m->get_messages($id);
                $pend = array();
                $appr = array();
                $rejt = array();
                foreach ($req->items as $w)
                {
                        $w->sub = $w->qty * $w->price;
                        if ($w->status == 1)
                        {
                                $appr[] = $w;
                        }
                        else if ($w->status == 0)
                        {
                                $rejt[] = $w;
                        }
                        else
                        {
                                $pend[] = $w;
                        }
                }

                foreach ($messages as $m)
                {
                        $usr = $this->ion_auth->user($m->created_by)->row();
                        $m->by = strtolower(substr($usr->first_name, 0, 1));
                        $m->name = $usr->first_name . ' ' . $usr->last_name;
                        $m->ts = date('d M Y H:i', $m->created_on);
                }
                $data['req'] = $req;
                $data['appr'] = $appr;
                $data['pend'] = $pend;
                $data['rejt'] = $rejt;
                $data['messages'] = $messages;
                $data['id'] = $id;
                $this->template->title('View Requisition')->build('admin/view_req', $data);
        }

        /**
         * Approve Req
         * 
         * @param int $id
         */
        function approve_req($id, $status)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/requisitions');
                }
                $user = $this->ion_auth->get_user();
                $rqst = array('approved' => $status, 'modified_by' => $user->id, 'modified_on' => time());
                $done = $this->expenses_m->set_req($id, $rqst);
				
				 $details = implode(' , ', $rqst);
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

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Requisition Status Updated'));
                redirect('admin/expenses/requisitions');
        }

        function void_req($id)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/requisitions');
                }
                $user = $this->ion_auth->get_user();
                $rqst = array('status' => 0, 'modified_by' => $user->id, 'modified_on' => time());
                $done = $this->expenses_m->set_req($id, $rqst);
				
				 $details = implode(' , ', $rqst);
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
								  

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Requisition Successfully Voided'));
                redirect('admin/expenses/requisitions');
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses/');
                }
                if (!$this->expenses_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/expenses');
                }
                //search the item to show in edit form
                $get = $this->expenses_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;
                $data['items'] = $this->expenses_m->populate('expense_items', 'id', 'name');
                $receipt = $get->receipt;
                if (!empty($_FILES['receipt']['name']))
                {
                        $this->load->library('files_uploader');
                        $upload_data = $this->files_uploader->upload('receipt');
                        $receipt = $upload_data['file_name'];
                }
                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        $amt = $this->input->post('amount');
                        // build array for the model
                        $form_data = array(
                            'expense_date' => strtotime($this->input->post('expense_date')),
                            'title' => $this->input->post('title'),
                            'category' => $this->input->post('category'),
                            'amount' => $amt,
                            'receipt' => $receipt,
                             'bank_id' => $this->input->post('bank_id'),
                            'person_responsible' => $this->input->post('person_responsible'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->expenses_m->update_attributes($id, $form_data);
                        
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

							   $this->worker->log_journal($amt, 'expenses', $id, array(5003 => 'debit', 2001 => 'credit'), TRUE);

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/expenses/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/expenses/");
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
                $data['list_user'] = $this->ion_auth->get_user_list();
                $data['cats'] = $this->expenses_m->list_categories();
                $data['bank'] = $this->fee_payment_m->list_banks();
                //load the view and the layout
                $this->template->title('Edit Expenses ')->build('admin/edit', $data);
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'expense_date',
                        'label' => 'Expense Date',
                        'rules' => ''),
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => ''),
                    array(
                        'field' => 'category',
                        'label' => 'Category',
                        'rules' => ''),
                    array(
                        'field' => 'amount',
                        'label' => 'Amount',
                        'rules' => ''),
                    array(
                        'field' => 'person_responsible',
                        'label' => 'Person Responsible',
                        'rules' => ''),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => ''),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        public function get_table()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);
                $output = $this->expenses_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        public function get_reqs()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);
                $output = $this->expenses_m->get_reqs($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/expenses/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000000;
                $config['total_rows'] = $this->expenses_m->count();
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
                //$choice = $config["total_rows"] / $config["per_page"];
                //$config["num_links"] = round($choice);
                return $config;
        }

}
