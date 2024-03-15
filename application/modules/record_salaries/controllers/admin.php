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
                $this->load->model('record_salaries_m');
                $this->load->model('advance_salary/advance_salary_m');
                $this->load->model('accounts/accounts_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['record_salaries'] = $this->record_salaries_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                //load view
                $this->template->title(' Processed Salaries ')->build('admin/list', $data);
        }

        //List all processed salaries
        function employees($id)
        {
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                //page number  variable
                $data['page'] = $page;
                $data['record_salaries'] = $this->record_salaries_m->get_all($id);
                //load view
                $this->template->title(' Processed Salaries ')->build('admin/employees', $data);
        }

        /**
         * export list to Excel
         * 
         * @param type $id
         */
        function export($id)
        {
                $this->load->library('Xlsx');
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()
                             ->setCreator("User")
                             ->setLastModifiedBy("user")
                             ->setTitle("Office 2007 XLSX  Document")
                             ->setSubject("Office 2007 XLSX  Document")
                             ->setDescription("Document for Office 2007 .")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Results Excel");

                $paid = $this->record_salaries_m->get_all($id);

                $i = 6;
                $index = 0;
                $objPHPExcel->setActiveSheetIndex(0)->setTitle('Payroll Summary');

                // Add Header
                $objPHPExcel->setActiveSheetIndex($index);

                $objPHPExcel->getActiveSheet()->setCellValue('B4', '#');
                $objPHPExcel->getActiveSheet()->setCellValue('C4', 'EMPLOYEE');
                $objPHPExcel->getActiveSheet()->setCellValue('D4', 'GROSS SALARY');
                $objPHPExcel->getActiveSheet()->setCellValue('E4', 'PAYE');
                $objPHPExcel->getActiveSheet()->setCellValue('F4', 'NSSF');
                $objPHPExcel->getActiveSheet()->setCellValue('G4', 'NHIF');
                $objPHPExcel->getActiveSheet()->setCellValue('H4', 'NET SALARY');
                $objPHPExcel->getActiveSheet()->setCellValue('I4', 'BANK NAME');
                $objPHPExcel->getActiveSheet()->setCellValue('J4', 'BANK ACCOUNT');
                $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B4'), 'B4:J4');

                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
                $objPHPExcel->getActiveSheet()
                             ->getStyle('D4:H4')
                             ->getAlignment()
                             ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('B4:J4')
                             ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B4:J4')->applyFromArray(
                             array(
                                 'font' => array(
                                     'size' => 10,
                                     'name' => 'Arial'
                                 ),
                                 'fill' => array(
                                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                     'color' => array('rgb' => 'c40f0f')
                                 ),
                                 'borders' => array(
                                     'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                     'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                                 )
                             )
                );
                $styles = array(
                    'font' => array(
                        'size' => 10,
                        'name' => 'Arial'
                ));

                $j = 0;
                foreach ($paid as $p)
                {
                        $j++;
                        $u = $this->ion_auth->get_user($p->employee);
                        $paye = $p->paye > 0 ? $p->paye : 0;
                        $bank = explode('<br>', $p->bank_details);

                        $objPHPExcel->getActiveSheet()
                                     ->getStyle('D' . $i . ':H' . $i)
                                     ->getAlignment()
                                     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()
                                     ->getStyle('D' . $i . ':H' . $i)
                                     ->getNumberFormat()
                                     ->setFormatCode('#,##0.00');
                        $net = ($p->basic_salary + $p->total_allowance) - ( $paye + $p->nssf + $p->nhif);

                        $objPHPExcel->getActiveSheet()->getStyle('B' . $i . ':J' . $i)->applyFromArray($styles);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $j);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $u->first_name . ' ' . $u->last_name);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $p->basic_salary + $p->total_allowance);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $paye);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $p->nssf);
                        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $i, $p->nhif);
                        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $i, $net);
                        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $i, isset($bank[0]) ? $bank[0] : '');
                        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $i, isset($bank[1]) ? $bank[1] : '');

                        $i ++;
                }

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Payroll.xls" ');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
        }

        //List all processed salaries
        function my_slips()
        {
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                //page number  variable
                $data['page'] = $page;
                $data['record_salaries'] = $this->record_salaries_m->get_my_slip();
                //load view
                $this->template->title(' My Salaries Slips')
                             ->set_layout('teachers')
                             ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                             ->set_partial('teachers_top', 'partials/teachers_top.php')
                             ->build('admin/employees', $data);
        }

        function slip($id)
        {
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                //page number  variable
                $data['page'] = $page;
                $data['post'] = $this->record_salaries_m->find($id);
                $data['tax'] = $this->record_salaries_m->get_tax();
                $data['ranges'] = $this->record_salaries_m->get_paye_ranges();
                $data['paye'] = $this->record_salaries_m->populate('paye', 'id', 'tax');
                //load view
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template->title(' Pay Slip')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/slip', $data);
                }
                else
                {
                        $this->template->title(' Pay Slip ')->build('admin/slip', $data);
                }
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $data['employees'] = $this->record_salaries_m->list_employees();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //validate the fields of form
                if ($this->form_validation->run())
                {
                        //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $ranges = $this->record_salaries_m->get_paye_ranges();

                        if ($this->input->post('salo') == 0)
                        {
                                $emp = $this->input->post('employee');
                                //Get employee salary details
                                $post = $this->record_salaries_m->salary_details($emp);

                                //Check if there is advance salary
                                $advance = $this->record_salaries_m->get_advance($emp);
                                $adv = 0;
                                if ($advance)
                                {
                                        $adv = $advance->amount;
                                }
                                //Get Deductions and Allowances
                                //--------------DEDUCTIONS DETAILS ----------///
                                $deductions = $this->record_salaries_m->salary_deductions($post->id);
                                $the_deductions = 0;
                                $dedcs = 0;
                                if (!empty($deductions))
                                {
                                        $total_deductions = $this->record_salaries_m->total_deductions($post->id);
                                        //Deductions details
                                        $decs_arr = array();
                                        $decs_ids = array();
                                        $dec_details = $this->record_salaries_m->list_deductions();
                                        foreach ($deductions as $dec)
                                        {
                                                $decs_ids[] = $dec->deduction_id;
                                                $decs_arr[] = $dec_details[$dec->deduction_id];
                                        }
                                        $dedcs = implode(',', $decs_arr);
                                        //$total_deductions = $this->record_salaries_m->total_deductions($decs_ids);
                                        $the_deductions = $total_deductions->totals;
                                }
                                //----------------Allowances details--------------------------///
                                $allowances = $this->record_salaries_m->salary_allowances($post->id);
                                $the_allowance = 0;
                                $allwnces = 0;
                                if (!empty($allowances))
                                {
                                        $all_arr = array();
                                        $all_ids = array();
                                        $all_details = $this->record_salaries_m->list_allowances();
                                        foreach ($allowances as $alls)
                                        {
                                                $all_ids[] = $alls->allowance_id;
                                                $all_arr[] = $all_details[$alls->allowance_id];
                                        }
                                        $allwnces = implode(',', $all_arr);
                                        //Get Total Allowances
                                        $total_allowances = $this->record_salaries_m->total_allowances($all_ids);
                                        $the_allowance = $total_allowances->totals;
                                }
                                //------OTHER DETAILS ----------------///
                                $bank_d = $post->bank_name . '<br>' . $post->bank_account_no;

                                $wtx = 0;
                                $taxable = ($post->basic_salary + $the_allowance) - $post->nssf;
                                $e = 0;
                                $poc_amt = 0;
                                foreach ($ranges as $R)
                                {
                                        $e++;
                                        $amt = $e == 1 ? $R->amount : $taxable - $poc_amt;
                                        if ($e == 1 && $taxable < $R->amount)
                                        {
                                                $amt = $taxable;
                                        }
                                        if ($amt < 0)
                                        {
                                                $amt = 0;
                                        }
                                        if ($amt >= $R->amount)
                                        {
                                                $amt = $R->amount;
                                        }
                                        if ($e == count($ranges))
                                        {
                                                $amt = $taxable - $poc_amt;
                                        }
                                        $rtax = $amt * ($R->tax / 100);
                                        $poc_amt += $amt;
                                        $wtx += $rtax;
                                }
                                $paye = $wtx - $this->school->relief;

                                // <editor-fold defaultstate="collapsed" desc="comment">
                                $form_data = array(
                                    'salary_date' => strtotime($this->input->post('salary_date')),
                                    'month' => $this->input->post('month'),
                                    'year' => $this->input->post('year'),
                                    'paye' => $paye,
                                    'employee' => $emp,
                                    'basic_salary' => $post->basic_salary,
                                    'nhif' => $post->nhif,
                                    'nssf' => $post->nssf,
                                    'staff_deduction' => $post->staff_deduction,
                                    'bank_details' => $bank_d,
                                    'advance' => $adv,
                                    'deductions' => $dedcs,
                                    'total_deductions' => $the_deductions,
                                    'allowances' => $allwnces,
                                    'total_allowance' => $the_allowance,
                                    'nhif_no' => $post->nhif_no,
                                    'nssf_no' => $post->nssf_no,
                                    'salary_method' => $post->salary_method,
                                    'comment' => $this->input->post('comment'),
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                ); // </editor-fold>

                                $ok = $this->record_salaries_m->create($form_data);
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

									   /**
                                         * *Update Advance salary with the amount paid
                                         * */
                                        $update_status = array(
                                            'status' => 0,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        $this->advance_salary_m->update_attributes($advance->id, $update_status);
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                                redirect('admin/record_salaries/');
                        }
                        elseif ($this->input->post('salo') == 1)
                        {
                                //Bulk Salary Processing
                                $all_emps = $this->record_salaries_m->get_employees();
                                foreach ($all_emps as $post)
                                {
                                        $advance = $this->record_salaries_m->get_advance($post->employee);
                                        //Check if there is advance salary
                                        $adv = 0;
                                        if ($advance)
                                        {
                                                $adv = $advance->amount;
                                        }

                                        //Get Deductions and Allowances
                                        //--------------DEDUCTIONS DETAILS ----------///
                                        $deductions = $this->record_salaries_m->salary_deductions($post->id);
                                        $the_deductions = 0;
                                        $dedcs = 0;
                                        if (!empty($deductions))
                                        {
                                                //Deductions details
                                                $decs_arr = array();
                                                $decs_ids = array();
                                                $dec_details = $this->record_salaries_m->list_deductions();
                                                foreach ($deductions as $dec)
                                                {
                                                        $decs_ids[] = $dec->deduction_id;
                                                        $decs_arr[] = $dec_details[$dec->deduction_id];
                                                }
                                                $dedcs = implode(',', $decs_arr);
                                                //Get Total Deductions
                                                $total_deductions = $this->record_salaries_m->total_deductions($decs_ids);
                                                $the_deductions = $total_deductions->totals;
                                        }
                                        //----------------Allowances details--------------------------///
                                        $allowances = $this->record_salaries_m->salary_allowances($post->id);
                                        $the_allowance = 0;
                                        $allwnces = 0;
                                        if (!empty($allowances))
                                        {
                                                $all_arr = array();
                                                $all_ids = array();
                                                $all_details = $this->record_salaries_m->list_allowances();
                                                foreach ($allowances as $alls)
                                                {
                                                        $all_ids[] = $alls->allowance_id;
                                                        $all_arr[] = $all_details[$alls->allowance_id];
                                                }
                                                $allwnces = implode(',', $all_arr);
                                                //Get Total Allowances
                                                $total_allowances = $this->record_salaries_m->total_allowances($all_ids);
                                                $the_allowance = $total_allowances->totals;
                                        }
                                        //------OTHER DETAILS ----------------///
                                        $bank_d = $post->bank_name . '<br>' . $post->bank_account_no;
                                        $taxable = ($post->basic_salary + $the_allowance) - $post->nssf;
                                        // <editor-fold defaultstate="collapsed" desc="comment">
                                        $e = 0;
                                        $poc_amt = 0;
                                        $wtx = 0;
                                        foreach ($ranges as $R)
                                        {
                                                $e++;
                                                $amt = $e == 1 ? $R->amount : $taxable - $poc_amt;
                                                if ($e == 1 && $taxable < $R->amount)
                                                {
                                                        $amt = $taxable;
                                                }
                                                if ($amt < 0)
                                                {
                                                        $amt = 0;
                                                }
                                                if ($amt >= $R->amount)
                                                {
                                                        $amt = $R->amount;
                                                }
                                                if ($e == count($ranges))
                                                {
                                                        $amt = $taxable - $poc_amt;
                                                }
                                                $rtax = $amt * ($R->tax / 100);
                                                $poc_amt += $amt;
                                                $wtx += $rtax;
                                        }
                                        $paye = $wtx - $this->school->relief;

                                        $form_data = array(
                                            'salary_date' => strtotime($this->input->post('salary_date')),
                                            'month' => $this->input->post('month'),
                                            'year' => $this->input->post('year'),
                                            'employee' => $post->employee,
                                            'basic_salary' => $post->basic_salary,
                                            'paye' => $paye,
                                            'staff_deduction' => $post->staff_deduction,
                                            'nhif' => $post->nhif,
                                            'nssf' => $post->nssf,
                                            'bank_details' => $bank_d,
                                            'advance' => $adv,
                                            'deductions' => $dedcs,
                                            'total_deductions' => $the_deductions,
                                            'allowances' => $allwnces,
                                            'total_allowance' => $the_allowance,
                                            'nhif_no' => $post->nhif_no,
                                            'nssf_no' => $post->nssf_no,
                                            'salary_method' => $post->salary_method,
                                            'comment' => $this->input->post('comment'),
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $ok = $this->record_salaries_m->create($form_data);
                                        // </editor-fold>
                                        //Update Salary account
                                        $update_status = array(
                                            'status' => 0,
                                            'modified_by' => $user->id,
                                            'modified_on' => time());
                                        if (isset($advance->id) && $advance->id)
                                        {
                                                $this->advance_salary_m->update_attributes($advance->id, $update_status);
                                        }
										
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
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                                redirect('admin/record_salaries/');
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => '<b style="color:red">Select Process Type!!</b>'));
                                redirect('admin/record_salaries/create/1');
                        }
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $prop = $field['field'];
                                $get->$prop = set_value($field['field']);
                        }
                        $data['result'] = $get;
                        //load the view and the layout
                        $this->template->title('Add Record Salaries ')->build('admin/create', $data);
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
                        redirect('admin/record_salaries');
                }
                //search the item to delete
                if (!$this->record_salaries_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/record_salaries');
                }
                //delete the item
                if ($this->record_salaries_m->delete($id) == TRUE)
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
                redirect("admin/record_salaries/");
        }

        function void($id = 0)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/record_salaries');
                }

                //delete the item
                if ($this->record_salaries_m->void($id) == TRUE)
                {
                       //$details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $id, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
								'details' => 'Record Voided',   
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
                redirect("admin/record_salaries/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'salary_date',
                        'label' => 'Salary Date',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'employee',
                        'label' => 'Employee',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'month',
                        'label' => 'month',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'year',
                        'label' => 'year',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'comment',
                        'label' => 'Comment',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/record_salaries/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000;
                $config['total_rows'] = $this->record_salaries_m->count();
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
