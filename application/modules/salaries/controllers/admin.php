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
                $this->load->model('salaries_m');
        }

        public function index()
        {
                $this->template->title('Salaries')->build('admin/list');
        }

        /**
         * Get Datatable
         * 
         */
        public function list_employees()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->salaries_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
                echo json_encode($output);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $data['deductions'] = $this->salaries_m->populate('deductions', 'id', 'name');
                $data['allowances'] = $this->salaries_m->populate('allowances', 'id', 'name');
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                /**
                 * * List Salaried Employees 
                 * * Create View
                 * */
                $data['post'] = $this->salaries_m->get_all();
                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $emp = $this->input->post('employee');
                        if ($this->salaries_m->exists_employee($emp))
                        {
                                $this->session->set_flashdata('message', array('type' => 'warning', 'text' => '<b style="color:red">Sorry this Employee has been added to salary records!!</b>'));
                                redirect('admin/salaries');
                        }
                        $user = $this->ion_auth->get_user();
                        $basic_salo = $this->input->post('basic_salary');
                        $form_data = array(
                            'employee' => $emp,
                            'salary_method' => $this->input->post('salary_method'),
                            'basic_salary' => $basic_salo,
                            'bank_name' => $this->input->post('bank_name'),
                            'staff_deduction' => $this->input->post('staff_deduction'),
                            'bank_account_no' => $this->input->post('bank_account_no'),
                            'nhif' => $this->input->post('nhif'),
                            'nssf' => $this->input->post('nssf'),
                            'nhif_no' => $this->input->post('nhif_no'),
                            'nssf_no' => $this->input->post('nssf_no'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $ok = $this->salaries_m->create($form_data);
                        if ($ok)
                        {
                                /*                                 * NSERT DEDUCTIONS*** */
                                $deducs = $this->input->post('deductions');
                                foreach ($deducs as $dd)
                                {
                                        $deducs_vals = array(
                                            'salary_id' => $ok,
                                            'deduction_id' => $dd,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $this->salaries_m->insert_deducs($deducs_vals);
                                }
                                /*                                 * NSERT ALLOWANCE*** */
                                $allws = $this->input->post('allowances');
                                foreach ($allws as $ll)
                                {
                                        $allwnce_vals = array(
                                            'salary_id' => $ok,
                                            'allowance_id' => $ll,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $this->salaries_m->insert_allws($allwnce_vals);
                                }
								
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
                        redirect('admin/salaries/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
                        $data['result'] = $get;
                        $data['paye'] = $this->salaries_m->get_paye();
                        //load the view and the layout
                        $this->template->title('Add Salaries')->build('admin/create', $data);
                }
        }

        function edit($id = 0, $page = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/salaries/');
                }
                if (!$this->salaries_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/salaries');
                }
                $data['deductions'] = $this->salaries_m->populate('deductions', 'id', 'name');
                $data['allowances'] = $this->salaries_m->populate('allowances', 'id', 'name');
                //search the item to show in edit form
                $get = $this->salaries_m->find($id);

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
                            'employee' => $this->input->post('employee'),
                            'salary_method' => $this->input->post('salary_method'),
                            'basic_salary' => $this->input->post('basic_salary'),
                            'bank_name' => $this->input->post('bank_name'),
                            'bank_account_no' => $this->input->post('bank_account_no'),
                            'staff_deduction' => $this->input->post('staff_deduction'),
                            'nhif' => $this->input->post('nhif'),
                            'nssf' => $this->input->post('nssf'),
                            'nhif_no' => $this->input->post('nhif_no'),
                            'nssf_no' => $this->input->post('nssf_no'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->salaries_m->update_attributes($id, $form_data);

                        if ($done)
                        {
                                /*                                 * NSERT DEDUCTIONS*** */
                                $deducs = $this->input->post('deductions');
                                $this->salaries_m->delete_deductions($id);
                                foreach ($deducs as $dd)
                                {
                                        $deducs_vals = array(
                                            'salary_id' => $id,
                                            'deduction_id' => $dd,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $this->salaries_m->insert_deducs($deducs_vals);
                                }
                                /*                                 * NSERT ALLOWANCE*** */
                                $this->salaries_m->delete_allowances($id);
                                $allws = $this->input->post('allowances');
                                foreach ($allws as $ll)
                                {
                                        $allwnce_vals = array(
                                            'salary_id' => $id,
                                            'allowance_id' => $ll,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $this->salaries_m->insert_allws($allwnce_vals);
                                }
								
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
                                redirect("admin/salaries/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/salaries/");
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
                $data['paye'] = $this->salaries_m->get_paye();
                //load the view and the layout
                $this->template->title('Edit Salaries ')->build('admin/edit', $data);
        }

        function get_nhif($salo)
        {
                switch ($salo)
                {
                        case $salo < 1499:
                                $nhif = 30;
                                break;
                        case $salo < 1999:
                                $nhif = 40;
                                break;
                        case $salo < 2999:
                                $nhif = 60;
                                break;
                        case $salo < 3999:
                                $nhif = 80;
                                break;
                        case $salo < 4999:
                                $nhif = 100;
                                break;
                        case $salo < 5999:
                                $nhif = 120;
                                break;
                        case $salo < 6999:
                                $nhif = 140;
                                break;
                        case $salo < 7999:
                                $nhif = 160;
                                break;
                        case $salo < 9999:
                                $nhif = 200;
                                break;
                        case $salo < 10999:
                                $nhif = 220;
                                break;
                        case $salo < 11999:
                                $nhif = 240;
                                break;
                        case $salo < 12999:
                                $nhif = 260;
                                break;
                        case $salo < 13999:
                                $nhif = 280;
                                break;
                        case $salo < 14999:
                                $nhif = 300;
                                break;
                        default:
                                $nhif = 320;
                                break;
                }
                return $nhif;
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/salaries');
                }
                //search the item to delete
                if (!$this->salaries_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/salaries');
                }
                //delete the item
                if ($this->salaries_m->delete($id) == TRUE)
                {
                        $this->salaries_m->delete_deductions($id);
                        $this->salaries_m->delete_allowances($id);
						
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
				  
				  
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }
                redirect("admin/salaries/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'employee',
                        'label' => 'Employ',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'nhif',
                        'label' => 'NHIF',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'nssf',
                        'label' => 'NSSF',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'salary_method',
                        'label' => 'Salary Method',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'deductions',
                        'label' => 'Deductions',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'staff_deduction',
                        'label' => 'staff_deduction',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'allowances',
                        'label' => 'Allowances',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'basic_salary',
                        'label' => 'Basic Salary',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'bank_name',
                        'label' => 'Bank Name',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'bank_account_no',
                        'label' => 'Bank Account No',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'nhif_no',
                        'label' => 'Nhif No',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'nssf_no',
                        'label' => 'Nssf No',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/salaries/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000;
                $config['total_rows'] = $this->salaries_m->count();
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

}
