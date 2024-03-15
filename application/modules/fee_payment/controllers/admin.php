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

        $this->load->model('fee_payment_m');
        $this->load->model('admission/admission_m');
        $this->load->model('sms/sms_m');

        $this->load->library('pmailer');
        $this->load->library('image_cache');
        $this->load->model('accounts/accounts_m');
        $valid = $this->portal_m->get_class_ids();
        if ($this->input->get('pw'))
        {
            $pop = $this->input->get('pw');
            //limit to available classes only
            if (!in_array($pop, $valid))
            {
                $pop = $valid[0];
            }
            $this->session->set_userdata('pw', $pop);
        }
        else if ($this->session->userdata('pw'))
        {
            $pop = $this->session->userdata('pw');
        }
        else
        {
            //$pop = $valid[0];
            //$this->session->set_userdata('pw', $pop);
            $this->session->unset_userdata('pw');
        }
    }

    function check_refno()
    {
        $field = $_REQUEST['fieldId'];
        $val = $_REQUEST['fieldValue'];

        /* RETURN VALUE */
        $json = array();
        $json[0] = $field;

        if (!$this->fee_payment_m->trans_exists($val))
        {
            $json[1] = true;
            echo json_encode($json);   // RETURN ARRAY WITH success
        }
        else
        {
            $json[1] = false;
            echo json_encode($json);  // RETURN ARRAY WITH ERROR
        }
    }

    function list_invoices()
    {

        $id = $this->input->get('id');
        $sps = $this->fee_payment_m->student_term_invoices($id);
        $tf = $this->fee_payment_m->student_tuition_fee($id);

        $fx = $this->fee_payment_m->populate('fee_extras', 'id', 'title');
        $fee_bal = $this->fee_payment_m->fetch_balance($id);
        $jso = '[';
        $coma = ',';
        $all = count($sps);
        $i = 0;

        if (!empty($tf))
        {

            $jso .= '{"optionValue":"TUITION FEE ","optionDisplay":"' . number_format($tf->amount, 2) . '"}' . $coma;
        }

        foreach ($sps as $p)
        {
            $i++;
            if ($i == $all)
                $coma = '';
            $jso .= '{"optionValue":"' . strtoupper($fx[$p->fee_id]) . '","optionDisplay":"' . number_format($p->amount, 2) . '"}' . $coma;
        }

        $jso .= ']';

        echo $jso;
    }

    function f_bal()
    {

        $id = $this->input->get('id');

        $fee_bal = $this->fee_payment_m->fetch_balance($id);
        $fr = $this->fee_payment_m->student_fee_arrears($id);

        $tf = $fee_bal->balance;
        if ($fr)
        {
            $tf = (float) $fee_bal->balance + (float) $fr;
        }

        $jso = '[{"optionValue":"Data","optionDisplay":"' . number_format($tf, 2) . '"}]';

        echo $jso;
    }

    function update_yrs()
    {

        $this->fee_payment_m->update_yrs();
    }

    public function paid()
    {
        $data['bank'] = $this->fee_payment_m->list_banks();
        //load view
        $this->template->title(' Fee Payment ')->build('admin/list', $data);
    }

    public function mpesa_payment_logs()
    {


        $data['payments'] = $this->fee_payment_m->mpesa_payment_list();

        $pays = $this->fee_payment_m->payment_options('payment_options', 'id', 'account');
        $data['pays'] = $pays;
        //load view
        $this->template->title('M-Pesa Payment Logs')->build('admin/mpesa_list', $data);
    }

    /**
     * Fee Balances & statements
     */
    public function index()
    {
        //load view
        $this->template->title(' Fee Payment Status ')->build('admin/bal');
    }

    /**
     * Fee Balances & statements
     */
    public function refresh()
    {
        $this->session->unset_userdata('pw');
        //load view
        redirect('admin/fee_payment');
    }

    /**
     * Get Datatable
     * 
     */
    public function get_paid()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->fee_payment_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    /**
     * Get Datatable
     * 
     */
    public function get_voided()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->fee_payment_m->get_voided($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    /**
     * Fee Balances & statements
     */
    public function all_voided()
    {
        //load view
        $this->template->title(' Fee Payment Status ')->build('admin/voided');
    }

    /**
     * Get Datatable for Payment Status
     * 
     */
    public function get_by_student()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->fee_payment_m->get_bals($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    /**
     * Send Reminder SMS to Specific Parents by Minimum Fee Balance
     * 
     */
    public function bulk()
    {
        if ($this->input->post())
        {
            $bal = $this->input->post('bal');
            $max = $this->input->post('max');
            if ($bal)
            {
                if ($bal == 999999)
                {
                    $bal = 1; //coz filter_bal >=
                }
                $list = $this->fee_payment_m->filter_balance($bal, $max);

                //print_r($list);die;

                $i = 0;
                foreach ($list as $r)
                {
                    $i++;
                    $adm = $this->worker->get_student($r->student);
                    $stud = $adm->first_name . ' ' . $adm->last_name;
                    $parent = $this->portal_m->get_parent($adm->parent_id);
                    $phone = $parent->phone;
                    $to = 'parent/guardian';
                    if (empty($phone))
                    {
                        $phone = $parent->mother_phone;
                    }

                    $day = (int) date('d');
                    $md = (int) date('m') + 1;
                    $yr = (int) date('Y');

                    $message = $this->school->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance of ' . number_format($r->balance) . '. Kindly ensure it is paid before ' . $day . '/' . $md . '/' . $yr . '. Thanks for choosing ' . $this->school->school;
                    $this->sms_m->send_sms($phone, $message);

                    //$details = implode(' , ', $this->input->post());
                    $user = $this->ion_auth->get_user();
                    $log = array(
                        'module' => $this->router->fetch_module(),
                        'item_id' => $adm->parent_id,
                        'transaction_type' => $this->router->fetch_method(),
                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $adm->parent_id,
                        'details' => $message,
                        'created_by' => $user->id,
                        'created_on' => time()
                    );

                    $this->ion_auth->create_log($log);
                }

                $this->worker->sms_callback();
                $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Found ' . $i . ' Students'));
                redirect('admin/fee_payment/');
            }
        }
        $data['page'] = '';

        $this->template->title('Bulk SMS Reminder')->build('admin/custom', $data);
    }

    /**
     * Send SMS Balance Reminder for selected Students
     */
    public function multiple_reminder()
    {
        if ($this->input->post())
        {
            if ($this->input->post('sids'))
            {
                $list = $this->input->post('sids');

                $i = 0;
                if ($this->input->post('send'))
                {
                    foreach ($list as $student)
                    {
                        $adm = $this->worker->get_student($student);
                        $names = $adm->first_name . ' ' . $adm->last_name;
                        $parent = $this->portal_m->get_parent($adm->parent_id);
                        $row = $this->fee_payment_m->get_balance($student);

                        $day = (int) date('d');
                        $md = (int) date('m') + 1;
                        $yr = (int) date('Y');

                        if (!empty($parent) && $row->balance > 0)
                        {
                            $i++;
                            $to = 'parent/guardian';
                            $message = $this->school->message_initial . ' ' . $to . ', Student ' . $names . ' has a fee balance of ' . number_format($row->balance) . '. Kindly ensure it is paid before ' . $day . '/' . $md . '/' . $yr . '. Thanks for choosing ' . $this->school->school;
                            $this->sms_m->send_sms($parent->phone, $message);
                        }

                        //$details = implode(' , ', $this->input->post());
                        $user = $this->ion_auth->get_user();
                        $log = array(
                            'module' => $this->router->fetch_module(),
                            'item_id' => $adm->parent_id,
                            'transaction_type' => $this->router->fetch_method(),
                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $adm->parent_id,
                            'details' => $message,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $this->ion_auth->create_log($log);
                    }

                    $this->worker->sms_callback();
                }
                else
                {
                    $this->export($list);
                }
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Successfully Sent ({$i})</b>"));
            }
        }
        redirect('admin/fee_payment/bulk');
    }

    function generate_balances()
    {
        $this->load->model('reports/reports_m');
        $this->load->model('fee_structure/fee_structure_m');
        $streams = [];

        foreach ($this->classlist as $key => $clasl)
        {
            $cl = (object) $clasl;
            $streams[$key] = $cl->name;
        }

        $yr = $this->input->post('year');
        $term = $this->input->post('term');
        $class = $this->input->post('class');
        $sus = $this->input->post('sus');

        if (!$yr)
        {
            $yr = date('Y');
        }
        $rearr = $this->reports_m->get_arrears($class, $term, $yr, $sus);

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['class'] = $class;
        $data['streams'] = $streams;
        $data['yr'] = $yr;
        $data['banks'] = $this->fee_structure_m->banks();
        $data['classes_groups'] = $this->fee_structure_m->populate('class_groups', 'id', 'name');
        $data['stream_name'] = $this->fee_structure_m->populate('class_stream', 'id', 'name');
        $data['classes'] = $this->fee_structure_m->populate('classes', 'id', 'class');
        $data['term'] = $term;
        $data['rearr'] = $rearr;
        $data['adm'] = $this->reports_m->populate_admission();
        $this->template->title('Fee Arrears Report ')->build('admin/generate_balances', $data);
    }

    /**
     * export list to Excel
     * 
     * @param type $list
     */
    function export($list)
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

        $i = 2;
        $index = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Bulksms');

        // Add Header
        $objPHPExcel->setActiveSheetIndex($index);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PHONE');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'MESSAGE');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(120);

        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')
                          ->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('A1:B1')->applyFromArray(
                          array(
                              'font' => array(
                                  'size' => 10,
                                  'name' => 'Arial'
                              )
                          )
        );
        $styles = array(
            'font' => array(
                'size' => 10,
                'name' => 'Arial'
        ));

        $this->load->library('Fone');
        $util = \libphonenumber\PhoneNumberUtil::getInstance();

        foreach ($list as $student)
        {
            $adm = $this->worker->get_student($student);
            $names = $adm->first_name . ' ' . $adm->last_name;
            $parent = $this->portal_m->get_parent($adm->parent_id);

            $no = $util->parse($parent->phone, 'KE', null, true);
            $is_valid = $util->isValidNumber($no);
            if ($is_valid != 1)
            {
                continue;
            }
            $row = $this->fee_payment_m->get_balance($student);

            $code = $no->getcountryCode();
            $nat = $no->getNationalNumber();
            $phone = $code . $nat;

            $objPHPExcel->getActiveSheet()
                              ->getStyle('A' . $i)
                              ->getNumberFormat()
                              ->setFormatCode('##0');
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':B' . $i)->applyFromArray($styles);

            if (!empty($parent) && $row->balance > 0)
            {
                $to = 'parent/guardian';
                $message = $this->school->message_initial . ' ' . $to . ',This is a reminder that Student/Learner ' . $names . ' has a fee balance of ' . number_format($row->balance) . '. Kindly ensure the balance is cleared before Tuesday  14/12/2021 for your child to be allowed to sit for the end of term exams.. Thanks for choosing ' . $this->school->school;

                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $phone);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $message);

                $i++;
            }
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Bulksms_' . date('d_m_H:i:s') . '.xls" ');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //SEND REMINDER
    public function reminder($id = FALSE, $flag = FALSE)
    {
        $settings = $this->ion_auth->settings();
        $st_details = $this->fee_payment_m->get_student($id);
        $bal = $this->fee_payment_m->get_balance($id);
        $parent_details = $this->fee_payment_m->get_parent($st_details->parent_id);

        if (!empty($parent_details))
        {
            $skul = $this->ion_auth->settings();
            $recipient = $parent_details->phone;

            $day = (int) date('d');
            $md = (int) date('m') + 1;
            $yr = (int) date('Y');

            $to = 'parent/guardian';
            $stud = $st_details->first_name . ' ' . $st_details->last_name;
            if ($bal->balance < 0)
            {
                $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee overpay of ' . number_format($bal->balance) . ', this will be forwarded to next term. Thanks for choosing ' . $skul->school;
            }
            elseif ($bal->balance == 0)
            {
                $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has no fee balance. Thanks for choosing ' . $skul->school;
            }
            else
            {
                if ($flag)
                {
                    $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance of ' . number_format($bal->balance) . ', kindly ensure it is paid before ' . $day . '/' . $md . '/' . $yr . '. ' . $skul->school;
                }
                else
                {
                    $message = $settings->message_initial . ' ' . $to . ', Student ' . $stud . '  has a fee balance of ' . number_format($bal->balance) . ', kindly ensure it is paid before ' . $day . '/' . $md . '/' . $yr . '. Thanks for choosing ' . $skul->school;
                }
            }

            $this->sms_m->send_sms($recipient, $message);
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Reminder Successfully Sent</b>"));

            //$details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $id,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
                'details' => 'SMS reminder',
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b style='color:red'>Sorry, the selected student doesn't have Parent/Guardian details !!</b>"));
        }
        if ($flag)
        {
            redirect('admin/admission/inactive/');
        }
        else
        {
            redirect('admin/fee_payment/');
        }
    }

    function view($id)
    {
        redirect('admin/fee_payment/receipt/' . $id);
        if (!$this->fee_payment_m->exists($id))
        {
            redirect('admin/fee_payment');
        }
        $data['title'] = 'Fee Statement';
        $data['post'] = $this->fee_payment_m->get($id);
        $data['banks'] = $this->fee_payment_m->banks();

        $this->template->title(' Fee payment')->build('admin/view', $data);
    }

    /**
     * Student Fee Statement
     * 
     * @param int $id
     */
    function statement($id)
    {
        if (!$this->fee_payment_m->student_exists($id))
        {
            redirect('admin/fee_payment');
        }

        $post = $this->fee_payment_m->get_student($id);
        $data['banks'] = $this->fee_payment_m->banks();
        $data['post'] = $post;
        $data['class'] = $this->portal_m->fetch_class($post->class);
        $data['cl'] = $this->portal_m->get_class_options();
        $data['arrs'] = $this->fee_payment_m->fetch_total_arrears($id);
        $data['extras'] = $this->fee_payment_m->all_fee_extras();

        $payload = $this->worker->process_statement($id);

        $data['payload'] = $payload;
        $this->template->title(' Fee Statement')->build('admin/statement', $data);
    }

    function email_receipt($rec_id)
    {
        if (!$this->fee_payment_m->exists_receipt($rec_id))
        {
            redirect('admin/fee_payment');
        }

        $extras = $this->fee_payment_m->all_fee_extras();
        $title = 'Fee Receipt';
        $total = $this->fee_payment_m->total_payment($rec_id);
        $p = $this->fee_payment_m->get_pays($rec_id);
        $post = $this->fee_payment_m->get_row_time($rec_id);

        $banks = $this->fee_payment_m->banks();
        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();
        $ccc = $this->fee_payment_m->get_student($post->reg_no);
        if (!isset($ccc->class))
        {
            $sft = ' - ';
            $st = ' - ';
        }
        else
        {
            $crow = $this->portal_m->fetch_class($ccc->class);
            if (!$crow)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
            }
        }


        $rec_id = $rec_id;
        $class = $sft . '  ' . $st;
        $rect = $this->fee_payment_m->fetch_receipt($rec_id);
        $fee = $this->fee_payment_m->fetch_balance($rect->student);

        $settings = $this->ion_auth->settings();
        $st = $this->ion_auth->list_student($post->reg_no);

        //Postal Address
        $postal = $settings->postal_addr . ' Cell:' . $settings->cell;
        if (!empty($settings->tel))
        {
            $postal = $settings->postal_addr . '<br> Tel:' . $settings->tel . ' ' . $settings->cell;
        }
        //Admission NO
        $adm_no = $st->admission_number;
        if (!empty($st->old_adm_no))
        {
            $st->old_adm_no;
        }



        $form_data = '
				   
				    <div class="slip ">
							<div class="slip-content">
								<div class="row">
									<div class="col-sm-3 invoice-left">
										<img  src="' . base_url('uploads/files/' . $settings->document) . '" class="center" align="center" style="" width="80%" height="80" />
									</div>
									<div class="col-sm-6 text-center">
										<h4>' . $settings->school . '</h4>
										' .
                          $postal
                          . ' 
									</div>
									<div class="col-md-3 text-right">
										<h4>RECEIPT NO.<span style=" color:red;">' . $total->id . '</span></h4>
										<strong>Reg. Number: </strong> 
										' .
                          $adm_no
                          . '
										<br> 
										DATE: <span>' . date('d M, Y H:i', time()) . '</span>
									</div>
								</div>
								<div class="col-md-12" style="margin-bottom:5px;margin-top:5px;border-top: #eee solid 1px">
									<div class="col-sm-5">
										<strong>Received From:</strong> <span>' . $st->first_name . ' ' . $st->last_name . ' </span>
										<span>-' . $class . '</span>
									</div>
									<div class="col-sm-5">
										<span><strong>Amt in words : </strong> 
											Ksh. ' .
                          $words = convert_number_to_words($total->total);
        ucwords($words) . '
										 only</span>
									</div>
								</div>
								<table cellpadding="0" cellspacing="0" width="100%" class="receipt">
									<thead>
										<tr>
											<th width="3%">#</th>
											<th width="">Payment Date</th>
											<th width="">Description</th>
											<th width="">Payment Method</th>
											<th width="">Transaction No.</th>
											<th width="">Amount</th>
										</tr>
									</thead>
									<tbody>
										 ' .
                          $i = 0;
        foreach ($p as $p)
        {
            $user = $this->ion_auth->get_user($p->created_by);
            $i++;

            $form_data .= '
												  <tr>
													 <td>' . $i . '</td>
													 <td>' . date('d/m/Y', $p->payment_date) . '</td>
													 <td>';

            if ($p->description == 0)
            {
                'Tuition Fee Payment';
            }
            elseif (is_numeric($p->description))
            {
                $extras[$p->description];
            }
            else
            {
                $p->description;
            }
            $form_data .= '</td>
													 <td>' . ucwords($p->payment_method) . '</td>
													 <td>' . $p->transaction_no . '</td>
													 <td class="rttb">' . number_format($p->amount, 2) . '</td>
												 </tr>';
        }

        if ($i < 2)
        {
            // $i++;
            $form_data .= '
												 <tr>
													 <td>' . ($i + 1 ) . '</td>
													 <td></td>
													 <td></td>
													 <td></td>
													 <td></td>
													 <td></td>
												 </tr>';
        }
        $form_data .= ' <tr>
											<td> </td>
											<td></td>
											<td></td>
											<td></td>
											<td class="rttx" style="border-bottom:3px #000 double;  ">Total: ' . $this->currency . ' </td>
											<td class="rttb" style="border-bottom:3px #000 double;  ">' . number_format($total->total, 2) . ' </td>
										</tr> 
									</tbody>
								</table>
								<div class="row" style="margin-top:6px;">
									<div class="col-sm-6">
										 <b>Processed By:</b> ' . $user->first_name . ' ' . $user->last_name . '
									</div>
									<div class="col-sm-6">
										<div class="total">
											 <div class="text-right" style="border-bottom:1px solid #ccc">
												Fee Balance:<?php echo $this->currency; ?> <span style="border-bottom:1px solid #ccc"> 
												<b>' . number_format($fee->balance, 2) . ' </b></span>
											</div> 
										</div>
									</div>
								</div>
								
								
								<div class="">
									<div class="center" style="border-top:1px solid #ccc">		
										<span class="center" style="font-size:0.8em !important;text-align:center !important;">
											 ';
        if (!empty($settings->tel))
        {
            $settings->postal_addr . ' Tel:' . $settings->tel . ' ' . $settings->cell;
        }
        else
        {
            $settings->postal_addr . ' Cell:' . $settings->cell;
        }

        $form_data .= '</span>
									</div>
								</div>
							</div>
						</div>

				';

        $email_data = array(
            'form_data' => $form_data
        );

        $this->load->library('email');

        $config = array();
        $config['protocol'] = 'mail';
        $config['smtp_host'] = 'mail.gmail.com';
        $config['smtp_user'] = 'smartshul.ke@gmail.com';
        $config['smtp_pass'] = 'Mimisijui$#@!1234';
        $config['smtp_port'] = 25;

        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        $this->email->from('noreply@smartshule.com', ucwords($settings->school));
        $this->email->to('evans.ogola22@gmail.com');

        $this->email->subject('Payment Receipt');

        $message = $this->load->view('index/sample-email.tpl.php', $email_data, TRUE);

        $this->email->message($message);

        if ($this->email->send())
        {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Email Was successfully sent'));
            redirect('admin/fee_payment/receipt/' . $rec_id);
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Something went wrong please try again later'));
            redirect('admin/fee_payment/receipt/' . $rec_id);
        }
    }

    function receipt($rec_id)
    {
        if (!$this->fee_payment_m->exists_receipt($rec_id))
        {
            redirect('admin/fee_payment');
        }
        $data['r_id'] = $rec_id;
        $p = $this->fee_payment_m->find($rec_id);

        $rec_id = $p->receipt_id;

        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        $data['title'] = 'Fee Receipt';
        $data['total'] = $this->fee_payment_m->total_payment($rec_id);
        $data['p'] = $this->fee_payment_m->get_pays($rec_id);
        $post = $this->fee_payment_m->get_row_time($rec_id);
        $data['post'] = $post;
        $data['banks'] = $this->fee_payment_m->banks();
        $this->worker->calc_balance($post->reg_no);

        $data['id'] = $rec_id;
        $rect = $this->fee_payment_m->fetch_receipt($rec_id);
        $data['fee'] = $this->fee_payment_m->fetch_balance($rect->student);

        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();
        $ccc = $this->fee_payment_m->get_student($post->reg_no);
        if (!isset($ccc->class))
        {
            $sft = ' - ';
            $st = ' - ';
        }
        else
        {
            $crow = $this->portal_m->fetch_class($ccc->class);
            if (!$crow)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
            }
        }

        $data['class'] = $sft . '  ' . $st;
        $data['rec_id'] = $rec_id;

        $this->template->title(' Fee payment')->build('admin/receipt', $data);
    }

    function receipt_option2($rec_id)
    {
        if (!$this->fee_payment_m->exists_receipt($rec_id))
        {
            redirect('admin/fee_payment');
        }

        $data['r_id'] = $rec_id;
        $p = $this->fee_payment_m->find($rec_id);
        $rec_id = $p->receipt_id;

        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        $data['title'] = 'Fee Receipt';
        $data['total'] = $this->fee_payment_m->total_payment($rec_id);
        $data['p'] = $this->fee_payment_m->get_pays($rec_id);
        $post = $this->fee_payment_m->get_row_time($rec_id);
        $data['post'] = $post;
        $data['banks'] = $this->fee_payment_m->banks();
        $this->worker->calc_balance($post->reg_no);

        $data['id'] = $rec_id;
        $rect = $this->fee_payment_m->fetch_receipt($rec_id);
        $data['fee'] = $this->fee_payment_m->fetch_balance($rect->student);

        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();
        $ccc = $this->fee_payment_m->get_student($post->reg_no);
        if (!isset($ccc->class))
        {
            $sft = ' - ';
            $st = ' - ';
        }
        else
        {
            $crow = $this->portal_m->fetch_class($ccc->class);
            if (!$crow)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
            }
        }

        $data['class'] = $sft . '  ' . $st;
        $data['rec_id'] = $rec_id;

        $this->template->title(' Fee payment')->build('admin/receipt_option2', $data);
    }

    function receipt_1_old($rec_id)
    {
        if (!$this->fee_payment_m->exists_receipt($rec_id))
        {
            redirect('admin/fee_payment');
        }

        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        $data['title'] = 'Fee Receipt';
        $data['total'] = $this->fee_payment_m->total_payment($rec_id);
        $data['p'] = $this->fee_payment_m->get_pays($rec_id);
        $post = $this->fee_payment_m->get_row_time($rec_id);
        $data['post'] = $post;
        $data['rec_id'] = $rec_id;

        $data['banks'] = $this->fee_payment_m->banks();
        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();
        $ccc = $this->fee_payment_m->get_student($post->reg_no);
        if (!isset($ccc->class))
        {
            $sft = ' - ';
            $st = ' - ';
        }
        else
        {
            $crow = $this->portal_m->fetch_class($ccc->class);
            if (!$crow)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
            }
        }

        $data['class'] = $sft . '  ' . $st;
        $rect = $this->fee_payment_m->fetch_receipt($rec_id);
        $data['fee'] = $this->fee_payment_m->fetch_balance($rect->student);
        $this->template->title(' Fee payment')->build('admin/receipt', $data);
    }

    function view_sale($id)
    {
        echo $this->make_receipt($id);
    }

    function make_receipt($id)
    {
        $rect = $this->fee_payment_m->fetch_receipt($id);
        $extras = $this->fee_payment_m->all_fee_extras();
        ;
        $items = $this->fee_payment_m->get_pays($id);
        $fee = $this->fee_payment_m->fetch_balance($rect->student);
        $student = $this->worker->get_student($rect->student);
        $ref = isset($items[0]) ? $items[0]->transaction_no : ' - ';
        $date = isset($items[0]) ? date('d/m/y', $items[0]->payment_date) : ' - ';
        $method = isset($items[0]) ? $items[0]->payment_method : ' - ';

        $user = $this->ion_auth->get_user($rect->created_by);

        $rstring = ' 
                          <style type="text/css" media="all">
                            #receipt { width: 280px; margin: 0 auto; text-align:center; color:#000; font-family: Arial, Helvetica, sans-serif; font-size:12px;  }
                            #receipt img { max-width: 100px; width: auto; }                            
                            #receipt h3 { margin: 5px 0; }
                            .left { width:100%; float:left; text-align:left; margin-bottom: 3px; }
                            #receipt .table, .totals { width: 100%; margin:10px 0; }
                            #receipt table { border:0!important;}
                            #receipt table td{padding:0; border-left:0!important;border-right:0!important; border-top:1px solid #000; border-bottom:1px solid #000;}
                            #receipt .table th { border-bottom: 1px solid #000; background:0; }
                            .totals td { width: 24%; padding:0; }
                            .table td:nth-child(2) { overflow:hidden; }
                             #receipt p {padding: 5px 10px !important;}
                            
                         @media print 
                            {
                            #receipt {  margin: 0 auto; text-align:center; color:#000; font-family: Arial, Helvetica, sans-serif; font-size:21px;  }
                                                   
                            #receipt h3 { margin: 5px 0; }
                             
                            
                            .left { width:100%; float:left; text-align:left; margin-bottom: 3px; }
                            #receipt .table, .totals { width: 100%; margin:10px 0; }
                            #receipt table { border:0!important;}
                            #receipt table td{padding:0; border-left:0!important;border-right:0!important; border-top:1px solid #000; border-bottom:1px solid #000;}
                            #receipt .table th { border-bottom: 1px solid #000; background:0; }
                            .totals td { width: 24%; padding:0; }
                            .table td:nth-child(2) { overflow:hidden; }
                             #receipt p {margin: 0 0 0px !important;}
                             .slip-widget { display: none; }
                             #buttons { display: none; }
                             #receipt {  width: 100%; margin: 0 auto; }
                             #receipt img { max-width:100px; width: auto; }
                            }
                        </style>
                  
                        <div id="receipt">
                             <img src="' . base_url('uploads/files/' . $this->school->document) . '" alt="logo">
                            <h3>RECEIPT</h3>
                            <p style="font-size:20px !important">Student: <span>' . strtoupper(strtolower($student->first_name . ' ' . $student->last_name)) . '</span></p>
                            <p style="font-size:20px !important">Admission No: <span>' . $student->old_adm_no . '</span></p>
                            <p style="font-size:20px !important">Tel: <span>' . $student->phone . '</span></p>
                            <p style="font-size:16px !important">Level: <span>' . $student->cl->name . '</span></p>
                            <span class="left" style="font-size:20px !important">Receipt No: <span style="float:right;">SLP' . str_pad($id, 4, '0', 0) . '</span></span>
                            <span class="left" style="font-size:20px !important">Reference No: <span style="float:right;">' . $ref . '</span></span>
                             <span class="left" style="font-size:20px !important">Paid On: <span style="float:right;">' . $date . '</span></span>
                             <div class="clearfix"></div>

                            <table class="table" cellspacing="0" border="0" style="white-space: normal; "> 
                                <thead>
                                    <tr>
                                        <th style="border-right:0!important; font-size:20px !important; text-align:center">#</th>
                                        <th style="border-right:0!important; font-size:20px !important; text-align:center">Description</th>
                                        <th style="border-right:0!important;font-size:20px !important; float:right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>';
        $i = 0;
        foreach ($items as $row)
        {
            $desc = $row->description;
            if ($row->description == 0)
            {
                $desc = "FEE PAYMENT";
            }
            else
            {
                $desc = strtoupper($extras[$row->description]);
            }
            $i++;
            $rstring .= '
                                    <tr>
                                        <td style="text-align:center; width:30px; font-size:20px !important"> ' . $i . '.</td>
                                        <td style="text-align:left; width:180px; font-size:20px !important">' . $desc . '</td>
                                        <td style="text-align:right; font-size:20px !important">' . number_format($row->amount) . '</td>
                                    </tr>';
        }


        $rstring .= ' </tbody> 
                            </table>
                            
                            <table class="table" cellspacing="0" border="0">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align:left; border-top:0!important;font-weight:bold; padding-top:5px; font-size:20px !important">Total(KES)</td>
                                        <td colspan="2" style="border-top:0!important; padding-top:5px; text-align:right; font-weight:bold; font-size:20px !important">' . number_format($rect->total) . '</td>
                                    </tr>                                    
                                    <tr>
                                        <td colspan="2" style="text-align:left;border-bottom:1px solid #000 !important; font-size:20px !important">Mode</td>
                                        <td colspan="2" style="border-bottom:1px solid #000 !important; padding-top:5px; text-align:right; font-size:20px !important">' . $method . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:left; border-bottom:1px solid #000; padding-top:5px;font-size:20px !important">Fee Balance</td>
                                        <td colspan="2" style="border-bottom:1px solid #000; padding-top:5px; text-align:right;font-size:20px !important">' . number_format($fee->balance, 2) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:left; border-bottom:1px solid #000; padding-top:5px; font-size:18px !important">Printed By</td>
                                        <td colspan="2" style="border-bottom:1px solid #000; padding-top:5px; text-align:right; font-size:18px !important">' . strtoupper(strtolower($user->first_name . ' ' . $user->last_name)) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align:left; border-bottom:1px solid #000; padding-top:5px; font-size:18px !important">Date Printed</td>
                                        <td colspan="2" style="border-bottom:1px solid #000; padding-top:5px; text-align:right; font-size:18px !important">' . date('d-m-Y H:i:s') . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" font-size:16px !important; padding-top:5px;padding-bottom:5px;text-align:center !important; border-bottom:#ddd!important; ">Fee once paid is not refundable.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style=" font-size:16px !important; padding-top:5px;border-top:1px solid #ddd!important;text-align:center !important;border-bottom:0!important;">Please ensure that you received an SMS <br>that corresponds with this receipt</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <script type="text/javascript">
                         $(function ()
                        {
                         window.print();
                                // setTimeout(printReceipt, 1000);//delay to allow time for logo to load
                        });
                            function printReceipt()
                                {
                                   var divTo=document.getElementById("rcc");
                                   newWin= window.open("");
                                   newWin.document.write(divTo.outerHTML);
                                   newWin.print();
                                   newWin.close();
                                   $("#rcc").dialog(\'close\');
                                }
                        </script>
                 ';

        return $rstring;
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
        $next = $this->fee_payment_m->get_last_id();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $settings = $this->ion_auth->settings();

            $user = $this->ion_auth->get_user();
            $length = $this->input->post('payment_date');
            $size = count($length);

            $now = time();
            $t_array = $this->input->post('amount');
            $total = array_sum($t_array);

            $reg = $this->input->post('reg_no');
            $term = $this->input->post('term');
            $year = $this->input->post('year');
            $receipt = array(
                'total' => $total,
                'student' => $reg,
                'created_by' => $user->id,
                'created_on' => $now
            );
            $payment_date = $this->input->post('payment_date');
            $amount = $this->input->post('amount');
            //Handle Accidental Double Click
            if ($this->fee_payment_m->has_paid($reg, $amount, $payment_date))
            {
                redirect('admin/fee_payment/');
            }
            $rec_id = $this->fee_payment_m->insert_rec($receipt);

            $payment_method = $this->input->post('payment_method');
            $transaction_no = $this->input->post('transaction_no');
            $bank_id = $this->input->post('bank_id');
            $description = $this->input->post('description');
            $totm = 0;
            for ($i = 0; $i < $size; ++$i)
            {
                $bank_slip = '';
                if (!empty($_FILES['bank_slip']['name']))
                {
                    $this->load->library('files_uploader');
                    $upload_data = $this->files_uploader->upload('bank_slip');
                    $bank_slip = $upload_data['file_name'];
                }

                $table_list = array(
                    'payment_date' => strtotime($payment_date[$i]),
                    'reg_no' => $reg,
                    'amount' => $amount[$i],
                    'payment_method' => $payment_method[$i],
                    'transaction_no' => $transaction_no[$i],
                    'bank_id' => $bank_id[$i],
                    'receipt_id' => $rec_id,
                    'status' => 1,
                    'term' => $term,
                    'year' => $year,
                    'description' => $description[$i],
                    'created_by' => $user->id,
                    'created_on' => $now
                );
                $pid = $this->fee_payment_m->create($table_list);

                $totm += $amount[$i];

                $details = implode(' , ', $table_list);
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $pid,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $pid,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);
            }

            if ($pid)
            {
                $total = $this->fee_payment_m->total_payment($rec_id);
                $st = $this->worker->get_student($reg);
                $stud = $st->first_name . ' ' . $st->last_name;

                $data['pid'] = $pid;

                //update student Balance
                $this->worker->calc_balance($reg);
                $this->acl->cp_event('fee_payment', ['page' => 'manual']);
                $paro = $this->admission_m->find($reg);
                $bal = $this->fee_payment_m->get_balance($reg);

                $member = $this->ion_auth->get_single_parent($paro->parent_id);
                if (!empty($member))
                {
                    $to = 'parent/guardian';

                    if ($bal->balance < 0)
                    {
                        $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received ' . number_format($total->total) . ' being fee payment for ' . $stud . '. You have an overpay of ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                    }
                    elseif ($bal->balance == 0)
                    {
                        $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is 0.00. Thanks for choosing ' . $settings->school;
                    }
                    else
                    {
                        $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                    }

                    $this->sms_m->send_sms($member->phone, $message);
                    redirect('admin/fee_payment/receipt/' . $pid);
                }
                else
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => "<b style='color:red'>Sorry Parent cannot get notification since this student doesn't have Parent/Guardian details recorded in the system !!</b>"));
                    redirect('admin/fee_payment/receipt/' . $pid);
                }
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/fee_payment/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['next'] = $next;
            $data['result'] = $get;
            $data['bank'] = $this->fee_payment_m->list_banks();
            $data['extras'] = $this->fee_payment_m->all_fee_extras();
            //load the view and the layout
            if ($page==200)
            {
                $this->template->title('Add Fee Payment ')->build('admin/c2', $data);
            }
            else
            {
                $this->template->title('Add Fee Payment ')->build('admin/create', $data);
            }
        }
    }

    function edit($id = FALSE, $page = 0)
    {
        // redirect('admin/fee_payment/');
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_payment/');
        }
        if (!$this->fee_payment_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_payment');
        }
        //search the item to show in edit form
        $get = $this->fee_payment_m->find($id);

        //Rules for validation
        $this->form_validation->set_rules($this->validation_edit());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {
            $data['fee_payment_m'] = $this->fee_payment_m->find($id);

            $this->load->library('upload');
            $this->load->library('image_lib');

            $user = $this->ion_auth->get_user();
            // build array for the model

            $form_data = [
                'payment_date' => strtotime($this->input->post('payment_date')),
                'amount' => $this->input->post('amount'),
                'payment_method' => $this->input->post('payment_method'),
                'transaction_no' => $this->input->post('transaction_no'),
                'bank_id' => $this->input->post('bank_id'),
                'term' => $this->input->post('term'),
                'year' => $this->input->post('year'),
                'description' => $this->input->post('description'),
                'modified_by' => $user->id,
                'modified_on' => time()
            ];
            //find the item to update
            $done = $this->fee_payment_m->update_attributes($id, $form_data);

            if ($done)
            {
                $details = implode(' , ', $this->input->post());
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $done,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/fee_payment/paid");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/fee_payment/paid");
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
        $data['bank'] = $this->fee_payment_m->list_banks();
        //load the view and the layout
        $this->template->title('Edit Fee Payment ')->build('admin/data_edit', $data);
    }

    function void($id)
    {

//redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_payment/');
        }

        if (!$this->fee_payment_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_payment');
        }


        $user = $this->ion_auth->get_user();

        //search the item 
        $get = $this->fee_payment_m->find($id);

        //Get Receipt details
        $rec = $this->fee_payment_m->fetch_receipt($get->receipt_id);
        //Balance from Receipt
        $reduce_amount = $rec->total - $get->amount;

        $form_data = array(
            'status' => 0,
            'modified_by' => $user->id,
            'modified_on' => time()
        );

        $this->fee_payment_m->update_attributes($id, $form_data);

        $update_fee_receipt = array(
            'total' => $reduce_amount,
            'modified_by' => $user->id,
            'modified_on' => time()
        );

        $done = $this->fee_payment_m->update_fee_receipt($rec->id, $update_fee_receipt);

        if ($done)
        {
            $details = implode(' , ', $form_data);
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $done,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                'details' => $details,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $this->worker->calc_balance($rec->student);
            $this->worker->log_journal(0, 'fee_payment', $id, array(1101 => 'debit', 1102 => 'credit'), 999);
            /**
             * * Reduce accounts chart by the balance 
             * * Update Accounts Chart Balances
             * */
            $get_account = $this->accounts_m->get_by_code(200);

            $balance = $get_account->balance;
            $initial_amount = $get->amount;
            $actual_amt = $balance - $initial_amount;

            $bal_details = array(
                'balance' => $actual_amt,
                'modified_by' => $user->id,
                'modified_on' => time());
            $this->accounts_m->update_attributes($get_account->id, $bal_details);

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Record successfully voided'));
            redirect("admin/fee_payment/paid");
        }
    }

    function daily_bank_totals()
    {
        $campus = $this->config->item('campus_id');
        $res = $this->fee_payment_m->daily_totals($campus);

        echo json_encode(['total' => $res->total ? number_format($res->total) : '0.00']);
    }

    function mobile_totals()
    {
        $campus = $this->config->item('campus_id');
        $res = $this->fee_payment_m->get_totals($campus);

        echo json_encode($res);
    }

    function show($id, $type = '')
    {
        if ($type == 2)
        {
            $res = $this->fee_payment_m->fetch_mobile_paid($id);
            $res->raw_amt = (float) $res->amount;
            $res->amount = number_format($res->amount, 2);
            $res->date = $res->created_on > 10000 ? date('d M Y', $res->created_on) : ' - ';
            if ($res->seen == 1)
            {
                $rec = $this->fee_payment_m->fetch_receipt($res->receipt_id);
                $rec->items = $this->fee_payment_m->get_pays($res->receipt_id);

                $rw = $this->worker->get_student($rec->student);
                $rec->student = $rw->first_name . ' ' . $rw->last_name . ' (' . $rw->cl->name . ')';
                $rec->adm = $rw->admission_number;
                $rec->total = number_format($rec->total, 2);
                $res->receipt = $rec;
            }
        }
        else
        {
            $res = $this->fee_payment_m->fetch_bank_paid($id);
            $res->raw_amt = (float) $res->amount;
            $res->amount = number_format($res->amount, 2);
            $res->date = $res->tx_date > 10000 ? date('d M Y', $res->tx_date) : ' - ';
        }

        echo json_encode($res);
    }

    function assign_student()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);
        $amt = str_replace(',', '', $post->amount);
        $amount = (float) $amt;

        $rows = [];
        $tot = 0;
        foreach ($post->items as $t)
        {
            if ((!empty($t->student) && isset($t->student->id)) && (!empty($t->term) && isset($t->term->id)) && (!empty($t->year) && isset($t->year->id)) && $t->amount)
            {
                if ($t->uf)
                {
                    if (empty($t->fee) && !isset($t->fee->id))
                    {
                        continue;
                    }
                }

                $rows[] = (object) ['student' => $t->student->id, 'amount' => $t->amount, 'term' => $t->term->id, 'year' => $t->year->id, 'fee' => $t->uf ? $t->fee->id : '', 'desc' => $t->uf ? $t->fee->name : 'Fee Payment', 'uf' => $t->uf];
                $tot += $t->amount;
            }
        }

        if ($tot > $amount)
        {
            echo json_encode(['message' => 'Error. Payments exceed available amount', 'success' => false]);
            exit();
        }
        if ($tot != $amount)
        {
            echo json_encode(['message' => 'Error. Please assign the full amount.', 'success' => false]);
            exit();
        }

        $f_p = [];
        $f_tot = [];
        foreach ($rows as $r)
        {
            if (!isset($f_tot[$r->student]['fee']))
            {
                $f_tot[$r->student]['fee'] = 0;
            }
            if (!isset($f_tot[$r->student]['uniform']))
            {
                $f_tot[$r->student]['uniform'] = 0;
            }
            if ($r->uf)
            {
                $f_p[$r->student]['uniform'][] = $r;
                $f_tot[$r->student]['uniform'] += $r->amount;
            }
            else
            {
                $f_p[$r->student]['fee'][] = $r;
                $f_tot[$r->student]['fee'] += $r->amount;
            }
        }

        foreach ($f_p as $student => $paid)
        {
            foreach ($paid as $cat => $items)
            {
                //create receipt 
                $receipt = [
                    'total' => $f_tot[$student][$cat],
                    'student' => $student,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];
                if ($cat == 'uniform')
                {
                    $receipt['sales'] = 1;
                }
                $receipt_id = $this->fee_payment_m->insert_rec($receipt);
                if (!$receipt_id)
                {
                    return FALSE;
                }

                foreach ($items as $p)
                {
                    $pay = [
                        'payment_date' => $post->date,
                        'reg_no' => $student,
                        'amount' => $p->amount,
                        'payment_method' => $post->method,
                        'transaction_no' => $post->tx,
                        'receipt_id' => $receipt_id,
                        'status' => 1,
                        'term' => $p->term,
                        'year' => $p->year,
                        'refno' => $p->fee,
                        'description' => $p->desc,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];
                    $this->fee_payment_m->create($pay);
                }

                $campus = $this->config->item('campus_id');
                $this->fee_payment_m->link_bank(['st_id' => $post->id, 'receipt_id' => $receipt_id, 'amount' => $f_tot[$student][$cat], 'student' => $student, 'campus' => $campus, 'created_by' => $this->user->id, 'created_on' => time()]);
            }

            //update student Balance
            $this->worker->calc_balance($student);
            $bal = $this->fee_payment_m->get_balance($student);
            //send sms
            $rw = $this->admission_m->find($student);
            $member = $this->ion_auth->get_single_parent($rw->parent_id);

            if (!empty($member))
            {
                $to = $member->first_name;
                $message = $this->school->message_initial . ' ' . $to . ', Confirmed. We received  ' . number_format($amount) . ' being fee payment for ' . $rw->first_name . ' ' . $rw->last_name . '. Your balance is ' . number_format($bal->balance) . '. Thanks.';

                $this->sms_m->send_sms($member->phone, $message);
                $this->worker->sms_callback();
            }
        }
        //update tx
        $this->fee_payment_m->update_bank($post->id, ['status' => 1, 'status_date' => time(), 'modified_on' => time()]);

        echo json_encode(['message' => 'Payment assigned successfully', 'success' => true]);
    }

    function process_mpesa()
    {
        $json = file_get_contents('php://input');

        $post = json_decode($json);
        $amtt = str_replace(',', '', $post->amount);
        $amount = (float) $amtt;

        $rows = [];
        $tot = 0;
        foreach ($post->items as $t)
        {
            if ((!empty($t->student) && isset($t->student->id)) && (!empty($t->term) && isset($t->term->id)) && (!empty($t->year) && isset($t->year->id)) && $t->amount)
            {
                $rows[] = (object) ['student' => $t->student->id, 'amount' => $t->amount, 'term' => $t->term->id, 'year' => $t->year->id];
                $tot += $t->amount;
            }
        }

        if ($tot > $amount)
        {
            echo json_encode(['message' => 'Error. Payments exceed available amount', 'success' => false]);
            exit();
        }
        if ($tot != $amount)
        {
            echo json_encode(['message' => 'Error. Please assign the full amount.', 'success' => false]);
            exit();
        }
        foreach ($rows as $r)
        {
            //create receipt 
            $receipt = [
                'total' => $r->amount,
                'student' => $r->student,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];
            $receipt_id = $this->fee_payment_m->insert_rec($receipt);
            if (!$receipt_id)
            {
                return FALSE;
            }

            $pay = [
                'payment_date' => $post->date,
                'reg_no' => $r->student,
                'amount' => $r->amount,
                'payment_method' => 'Paybill',
                'transaction_no' => $post->tx,
                'receipt_id' => $receipt_id,
                'status' => 1,
                'term' => $r->term,
                'year' => $r->year,
                'description' => 'Fee Payment',
                'created_by' => 1,
                'created_on' => time()
            ];

            $this->fee_payment_m->create($pay);
            $campus = $this->config->item('campus_id');

            $this->fee_payment_m->link_c2(['c2_id' => $post->id, 'receipt_id' => $receipt_id, 'amount' => $r->amount, 'student' => $r->student, 'campus' => $campus, 'created_by' => $this->user->id, 'created_on' => time()]);
            //update student Balance
            $this->worker->calc_balance($r->student);
            $bal = $this->fee_payment_m->get_balance($r->student);

            //update tx
            $this->fee_payment_m->update_c2($post->id, ['seen' => 1, 'modified_on' => time()]);

            //send sms
            $rw = $this->admission_m->find($r->student);
            $member = $this->ion_auth->get_single_parent($rw->parent_id);
            $message = '';
            if (!empty($member))
            {
                $to = $member->first_name;
                $message = $this->school->message_initial . ' ' . $to . ', Confirmed. We received  ' . number_format($r->amount) . ' being fee payment for ' . $rw->first_name . ' ' . $rw->last_name . '. Your balance is ' . number_format($bal->balance) . '. Thanks for choosing ' . $this->school->school;

                $this->sms_m->send_sms($member->phone, $message);
                //$this->worker->sms_callback();
            }
        }

        echo json_encode(['message' => 'Successfully assigned', 'success' => true]);
    }

    function get_bank_upload()
    {
        $per = $this->input->get('per_page', '');
        $search = $this->input->get('search', '');
        $tab = $this->input->get('tab', '');
        $page = $this->input->get('page', 0);
        $campus = $this->config->item('campus_id');
        $start = ($page - 1) * $per;

        $result = $this->fee_payment_m->get_bank_statement($campus, $start, $per, $tab, $search);
        foreach ($result as $r)
        {
            $r->date = $r->tx_date > 10000 ? date('d M Y', $r->tx_date) : ' - ';
            $r->amount = number_format($r->amount, 2);
            if ($tab == 1)
            {
                //$rw = $this->worker->get_student($r->student);
                $r->assigned = ''; //$rw->first_name . ' ' . $rw->last_name . ' (' . $rw->cl->name . ')';
            }
        }
        $total = $this->fee_payment_m->count_bank_statement($campus, $tab, $search);

        echo json_encode(['total' => $total, 'paid' => $result]);
    }

    function get_mobile_payments()
    {
        $per = $this->input->get('per_page', '');
        $search = $this->input->get('search', '');
        $tab = $this->input->get('tab', '');
        $page = $this->input->get('page', 0);
        $campus = $this->config->item('campus_id');
        $start = $page ? ($page - 1) * $per : 0;

        $result = $this->fee_payment_m->get_mobile_payments($campus, $start, $per, $tab, $search);
        foreach ($result as $r)
        {
            $r->date = $r->created_on > 10000 ? date('d M Y H:i', $r->created_on) : ' - ';
            $r->amount = number_format($r->amount, 2);
            if ($tab == 1)
            {
                //$rw = $this->worker->get_student($r->student);
                //$r->assigned = $rw->first_name . ' ' . $rw->last_name . ' (' . $rw->cl->name . ')';
            }
        }
        $total = $this->fee_payment_m->count_mobile_payments($campus, $tab, $search);

        echo json_encode(['total' => $total, 'paid' => $result]);
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'payment_date[]',
                'label' => 'Payment Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'reg_no',
                'label' => 'Student Reg. No.',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'trim'),
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'trim'),
            array(
                'field' => 'bank_slip[]',
                'label' => 'Bank Slip',
                'rules' => 'trim'),
            array(
                'field' => 'bank_id[]',
                'label' => 'Bank',
                'rules' => 'trim'),
            array(
                'field' => 'payment_method[]',
                'label' => 'Payment Method',
                'rules' => 'required'),
            array(
                'field' => 'transaction_no[]',
                'label' => 'Transaction Number',
                'rules' => 'trim'),
            array(
                'field' => 'description[]',
                'label' => 'Description',
                'rules' => 'trim'),
            array(
                'field' => 'amount[]',
                'label' => 'Amount',
                'rules' => 'required|trim|xss_clean|numeric|max_length[20]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function validation_edit()
    {
        $config = array(
            array(
                'field' => 'payment_date[]',
                'label' => 'Payment Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'bank_slip[]',
                'label' => 'Bank Slip',
                'rules' => 'trim'),
            array(
                'field' => 'bank_id[]',
                'label' => 'Bank',
                'rules' => 'trim'),
            array(
                'field' => 'payment_method[]',
                'label' => 'Payment Method',
                'rules' => 'required'),
            array(
                'field' => 'transaction_no[]',
                'label' => 'Transaction Number',
                'rules' => 'trim'),
            array(
                'field' => 'description[]',
                'label' => 'Description',
                'rules' => 'trim'),
            array(
                'field' => 'amount[]',
                'label' => 'Amount',
                'rules' => 'required|trim|xss_clean|numeric|max_length[20]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/fee_payment/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 300;
        $config['total_rows'] = $this->fee_payment_m->count();
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

    public function view_balances()
    {
        print_r($this->fee_payment_m->fee_balances());
    }

}
