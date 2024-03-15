<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parents extends Public_Controller
{

    /**
     * Class constructor
     */
    function __construct()
    {
        parent::__construct();

        $this->template
          ->set_layout('default.php')
          ->set_partial('meta', 'partials/meta.php')
          ->set_partial('header', 'partials/header.php')
          ->set_partial('sidebar', 'partials/sidebar.php')
          ->set_partial('footer', 'partials/footer.php');

        if (!$this->ion_auth->logged_in())
        {
            redirect('login');
        }

        if (!$this->ion_auth->is_in_group($this->user->id, 6))
        {
            redirect('login');
        }

        $this->load->model('portal_m');
        $this->load->model('exams/exams_m');
        $this->load->model('reports/reports_m');
        $this->load->model('fee_payment/fee_payment_m');
        $this->load->model('sms/sms_m');
        $this->load->model('diary/diary_m');
        $this->load->model('messages/messages_m');
        $this->load->model('assignments/assignments_m');
        $this->load->model('class_attendance/class_attendance_m');
        $this->load->library('Dates');
    }

    /*     * **
     * *** Landing Pages
     * ** */

    public function pgs($page)
    {
        $data['data'] = '';

        if ($page == 'academics')
        {

            $this->template->title('ACADEMICS')->build('parents/academics_landing', $data);
        }

        if ($page == 'communication')
        {

            $this->template->title('COMMUNICATION')->build('parents/communication_landing', $data);
        }
    }

    /*     * **
     * *** Show attendance
     * ** */

    public function class_attendance()
    {



        $att = array();
        $stud = '';
        $month = (int) date('m');
        $year = (int) date('Y');

        if ($this->input->post('student'))
        {
            $student = $this->input->post('student');
            $stud = $student;
            $att = $this->class_attendance_m->stud_get_trend_($student);

            $data['present'] = $this->class_attendance_m->stud_att_counter($student, 'Present');
            $data['absent'] = $this->class_attendance_m->stud_att_counter($student, 'Absent');
        }

        $data['att'] = $att;
        $data['stud'] = $stud;

        $this->template->title('Class Attendance')->build('parents/class_attendance_view', $data);
    }

    /*     * **
     * *** Show Assignment
     * ** */

    public function assignments()
    {
        $assign = array();
        if ($this->input->post('student'))
        {
            $student = $this->input->post('student');

            $assign = $this->assignments_m->get_stud_assignments($student);
        }
        $data['assign'] = $assign;

        $this->template->title('Class Assignments')->build('parents/class_assignments', $data);
    }

    /**
     * Generate Report Forms  - Bulk
     * 
     * @param $exam
     * @param $student
     */
    function results()
    {
        if (!$this->parent)
        {
            redirect('account');
        }
        $has = TRUE;
        $remk = FALSE;
        if ($this->input->post('student') && $this->input->post('exam'))
        {
            $student = $this->input->post('student');
            $exam = $this->input->post('exam');
            $xm = $this->exams_m->find($exam);
            $rec = $this->exams_m->is_recorded($exam);

            $st = $this->worker->get_student($student);
            $cls = $this->exams_m->get_stream($st->class);
            $data['subjects'] = $this->exams_m->get_subjects($cls->class, $xm->term);
            if ($cls->rec == 2)
            {
                $remk = TRUE;
            }

            if (!$xm || !$rec)
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                $has = FALSE;
            }
            if ($remk)
            {
                $data['remarks'] = $this->exams_m->fetch_by_exam($exam, $student);
                $data['full'] = $this->exams_m->fetch_gen_remarks($exam, $student);
            }
            else
            {
                $mine = $this->exams_m->get_report($exam, $student, $cls->class);
                $data['report'] = $mine;
            }

            $data['grading'] = $xm ? $this->exams_m->get_grading($xm->grading) : array();

            $data['exam'] = $xm;
            $data['full_subjects'] = $this->exams_m->get_full_subjects();

            $streams = $this->exams_m->populate('class_stream', 'id', 'name');
            $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
            $data['student'] = $st;
            $data['streams'] = $streams;
            $data['cls'] = $cls;
            $data['days_present'] = $this->reports_m->days_present($student);
            $data['days_absent'] = $this->reports_m->days_absent($student);
        }
        else
        {
            $has = FALSE;
        }
        $data['proc'] = $has;
        $fks = array();
        $this->load->model('admission/admission_m');

        foreach ($this->parent->kids as $k)
        {
            $usr = $this->admission_m->find($k->student_id);

            $fks[$k->student_id] = trim($usr->first_name . ' ' . $usr->last_name);
        }

        $data['kids'] = $fks;
        $data['remk'] = $remk;
        $data['exams'] = $this->exams_m->fetch_all_exams();
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');
        $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');

        $this->template->title(' Exam Results')->build('parents/exams_results', $data);
    }

    function student_certificates()
    {

        $data['nx'] = $this->portal_m->national_exams();
        $data['other'] = $this->portal_m->other_certificates();
        $this->template->title(' Student Certificates ')->build('parents/certificates', $data);
    }

    function national_exam_cert()
    {

        $data['nx'] = $this->portal_m->national_exams();
        $this->template->title(' National Exams ')->build('parents/national_exams', $data);
    }

    function diary($page = NULL)
    {

        $stud = '';
        $diary = array();
        $ex_diary = array();

        if (isset($page))
        {
            $student = $page;

            $data['stud'] = $student;
            $diary = $this->diary_m->get_diary($student);
            $ex_diary = $this->diary_m->ex_diary($student);
        }

        if ($this->input->post('student'))
        {
            $student = $this->input->post('student');

            $data['stud'] = $student;
            $diary = $this->diary_m->get_diary($student);
            $ex_diary = $this->diary_m->ex_diary($student);
        }
        //*** Post Parent Comment ***//
        if ($this->input->post('parent_comment') && $this->input->post('student') && $this->input->post('item'))
        {
            $id = $this->input->post('item');
            $user = $this->ion_auth->get_user();

            $ok = $this->diary_m->update_attributes($id, array('parent_comment' => $this->input->post('parent_comment'), 'modified_by' => $user->id, 'modified_on' => time()));

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Comment was successfully submitted'));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Sorry something went wrong try again alter'));
            }
        }

        //*** Post Ex Diary Parent Comment ***//

        if ($this->input->post('xparent_comment') && $this->input->post('student') && $this->input->post('item'))
        {
            $id = $this->input->post('item');
            $user = $this->ion_auth->get_user();

            $ok = $this->diary_m->update_ex($id, array('parent_comment' => $this->input->post('xparent_comment'), 'modified_by' => $user->id, 'modified_on' => time()));

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Comment was successfully submitted'));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Sorry something went wrong try again alter'));
            }
        }

        $data['diary'] = $diary;
        $data['ex_diary'] = $ex_diary;

        $this->template->title('Students Diary')->build('parents/diary', $data);
    }

    function other_certificates()
    {

        $data['nx'] = $this->portal_m->other_certificates();
        $this->template->title(' Other Certificated Exams ')->build('parents/other_certs', $data);
    }

    function events()
    {

        $data['events'] = $this->portal_m->school_events();
        $this->template->title('School Events')->build('parents/events', $data);
    }

    function sms()
    {

        $data['sms'] = $this->sms_m->my_sms_new();
        $this->template->title('SMS Messages')->build('parents/sms', $data);
    }

    function notices()
    {
        $config = $this->set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        $data['notices'] = $this->portal_m->paginate_notices($config['per_page'], $page);
        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        $this->template->title('Notice Board')->build('parents/notices', $data);
    }

    function newsletters()
    {

        $data['newsletters'] = $this->portal_m->newsletters();
        $this->template->title('Newsletters')->build('parents/newsletters', $data);
    }

    function rules_regulations()
    {

        $this->load->model('rules_regulations/rules_regulations_m');
        $data['rules_regulations'] = $this->rules_regulations_m->list_all();
        $this->template->title('Rules & Regulations')->build('parents/rules', $data);
    }

    function upi_verifier()
    {

        $reg_no = $this->input->get('reg_no');
        $upi = $this->portal_m->upi_checker($reg_no);

        $jso = 0;
        if ($upi)
        {
            $jso = 1;
        }
        echo $jso;
    }

    function account_balance()
    {

        try
        {
            //Set the response content type to application/json
            header("Content-Type:application/json");
            $resp = '{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}';
            //read incoming request

            $postData = file_get_contents('php://input');
            //log file
            $filePath = __DIR__ . "/messages.log";
            //error log
            $errorLog = __DIR__ . "/errors.log";
            //Parse payload to json

            $jdata = json_decode($postData);

            $bal = array(
                      'date' => time(),
                      'balance_log' => $jdata,
                      'created_by' => 1,
                      'created_on' => time()
            );
            $this->fee_payment_m->insert_balance($bal);

            //perform business operations on $jdata here
            //open text file for logging messages by appending
            $file = fopen($filePath, "a");
            //log incoming request

            fwrite($file, "\r\n\r\n\r\n\r\n*****Incoming cfm Request*****\r\n\r\n");
            fwrite($file, print_r($postData, true));
            fwrite($file, "\r\n\r\n\r\n\r\n");
            //log response and close file
            fwrite($file, $resp);
            fclose($file);
        }
        catch (Exception $ex)
        {
            //append exception to errorLog
            $logErr = fopen($errorLog, "a");
            fwrite($logErr, $ex->getMessage());
            fwrite($logErr, "\r\n");
            fclose($logErr);
        }
        //echo response
        echo $resp;
    }

    /**
     * Load student report
     *
     */
    function student_report($id)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('students');
        }

        $this->load->model('admission/admission_m');

        if (!$this->admission_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('students');
        }



        $this->load->model('reports/reports_m');
        $this->load->model('borrow_book_fund/borrow_book_fund_m');
        $this->load->model('borrow_book/borrow_book_m');
        $this->load->model('medical_records/medical_records_m');
        $this->load->model('fee_payment/fee_payment_m');
        $this->load->model('fee_waivers/fee_waivers_m');
        $this->load->model('assign_bed/assign_bed_m');
        $this->load->model('hostel_beds/hostel_beds_m');
        $this->load->model('students_placement/students_placement_m');
        $this->load->model('disciplinary/disciplinary_m');

        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        if (!$this->admission_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('students');
        }


        $stud = $this->admission_m->find($id);
        $data['passport'] = $this->admission_m->passport($stud->photo);
        $student = $this->admission_m->find($id);
        $data['student'] = $student;

        $parent_id = $this->admission_m->find($id);
        $data['parent_details'] = $this->admission_m->get_parent($parent_id->parent_id);
        $data['cl'] = $this->admission_m->fetch_class($parent_id->class);
        $data['title'] = 'Fee Statement';

        $data['em_cont'] = $this->admission_m->get_emergency_contacts($id);
        $data['extra_c'] = $this->reports_m->get_extras($id);
        $data['other_certs'] = $this->reports_m->other_certs($id);
        $data['national_exams'] = $this->reports_m->national_exams($id);

        $data['p'] = $this->fee_payment_m->get_receipts($id);
        //Beds
        $data['bed'] = $this->assign_bed_m->get($id);
        $data['beds'] = $this->assign_bed_m->get_hostel_beds();
        //Placement position
        $data['position'] = $this->students_placement_m->get($id);
        $data['st_pos'] = $this->students_placement_m->get_positions();
        //Exams Results
        $exams = array(); //$this->exams_management_m->get_by_student($id);

        $data['exams'] = $exams;
        //Exams Type
        $data['type'] = $this->admission_m->populate('exams', 'id', 'year');
        $data['term'] = $this->admission_m->populate('exams', 'id', 'term');
        $data['type_details'] = $this->admission_m->populate('exams', 'id', 'title');

        //Disciplinary
        $data['disciplinary'] = $this->disciplinary_m->get($id);
        //Medical Records
        $data['medical'] = $this->medical_records_m->by_student($id);

        $tm = get_term(date('m'));
        $data['waiver'] = $this->admission_m->get_waiver($id, $tm);
        //Transport Details
        $data['transport'] = array(); //$this->assign_transport_facility_m->get($id);
        $data['transport_facility'] = array(); // $this->assign_transport_facility_m->get_transport_facility();
        $data['amt'] = $this->admission_m->total_fees($student->class);
        $data['post'] = $this->fee_payment_m->get_row($id);
        $data['banks'] = $this->fee_payment_m->banks();
        $this->worker->calc_balance($id);
        // $data['paid'] = $this->fee_payment_m->fetch_balance($student->id);
        $data['fee'] = $this->fee_payment_m->fetch_balance($student->id);
        $data['paro'] = $this->admission_m->get_paro($stud->parent_id);

        //Book Fund
        $data['books'] = $this->reports_m->populate('book_fund', 'id', 'title');
        $data['student_books'] = $this->borrow_book_fund_m->by_student($id);

        // Library Books
        $data['lib_books'] = $this->reports_m->populate('books', 'id', 'title');
        $data['borrowed_books'] = $this->borrow_book_m->by_student($id);

        $data['class_history'] = $this->reports_m->class_history($id);

        $data['classes_groups'] = $this->reports_m->populate('class_groups', 'id', 'name');
        $data['classes'] = $this->reports_m->populate('classes', 'id', 'class');
        $data['class_str'] = $this->reports_m->populate('classes', 'id', 'stream');
        $data['stream_name'] = $this->reports_m->populate('class_stream', 'id', 'name');

        $data['days_present'] = $this->reports_m->days_present($id);
        $data['days_absent'] = $this->reports_m->days_absent($id);
        $data['favourite_hobbies'] = $this->portal_m->get_unenc_result('student', $id, 'favourite_hobbies');

        $this->template->title('Student Profile')->build('parents/student_report', $data);
    }

    public function mpesa_payment()
    {


        $pays = $this->fee_payment_m->payment_options('payment_options', 'id', 'account');
        $data['payment_options'] = $pays;

        //print_r($pays);die;

        $this->form_validation->set_rules($this->valid_rules());
        //validate the fields of form
        $d = 1;
        if ($this->form_validation->run())
        {

            require_once APPPATH . 'libraries/Mpesa.php';

            $reg_no = $this->input->post('reg_no');
            $amount = $this->input->post('amount');
            $phone = $this->input->post('phone');
            $account = $this->input->post('payable');

            $data = array(
                      'payment_date' => time(),
                      'reg_no' => $reg_no,
                      'transaction_no' => '',
                      'phone' => $phone,
                      'amount' => $amount,
                      'account' => $account,
                      'bank_id' => '9999',
                      'payment_method' => 'M-Pesa',
                      'description' => 'Fee Payment',
                      'status' => 0,
                      'created_by' => time(),
            );

            $ok = $this->fee_payment_m->mpesa_payment_logs($data);

            //******************* MPESA PUSH *********************//
            $bill_no = $this->fee_payment_m->populate('payment_options', 'id', 'business_number');
            $biz_number = $bill_no[$account];

            $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';

            $mpesa = new \Safaricom\Mpesa\Mpesa();
            $BusinessShortCode = $biz_number;
            $TransactionType = 'CustomerPayBillOnline';
            $Amount = $amount;
            $PartyA = $phone;
            $PartyB = $biz_number;
            $PhoneNumber = $phone;
            $CallBackURL = 'http://demo.smartshule.com/fee_payment/index/confirm_mpesa/' . $reg_no;
            $AccountReference = $reg_no;
            $TransactionDesc = 'Fee Payment';
            $Remarks = 'Fee Payment';
            $stkPushSimulation = $mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks);

            //**********Push Json Response *******//
            redirect('portals/parents/check_payment/' . $ok);
        }
        else
        {
            $get = new StdClass();
            foreach ($this->valid_rules() as $field)
            {
                $get->$field['field'] = set_value($field['field']);
            }

            $data['result'] = $get;

            //load the view
            $this->template->title('M-Pesa Payment')->build('mpesa/mpesa', $data);
        }
    }

    public function malipo()
    {
        $data['banks'] = $this->portal_m->get_bank_accounts();
        if (isset($_POST['m_bank']))
        {
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('reg_no', 'Student', 'required');
            $this->form_validation->set_rules('term', 'Term', 'required');
            $this->form_validation->set_rules('api_key', 'Account Name', 'required');

            $phone = $this->input->post('phone');
            $amount = $this->input->post('amount');
            $reg_no = $this->input->post('reg_no');
            $term = $this->input->post('term');
            $account_info = $this->input->post('api_key');
            $account_split = explode('.', $account_info);

            $account_name = $account_split[0];
            $username = $account_split[1];
            $api_key = $account_split[2];
            $account_number = $account_split[3];
            $description = "For $term " . date('Y') . " Paid via $account_name ($account_number)";

            $data = array(
                      'payment_date' => time(),
                      'reg_no' => $reg_no,
                      'transaction_no' => '',
                      'phone' => $phone,
                      'amount' => $amount,
                      'account' => $account_number,
                      'bank_id' => '9999',
                      'payment_method' => 'M-Pesa',
                      'description' => $description,
                      'status' => 0,
                      'created_on' => time(),
            );
            // print_r($data);

            if ($this->form_validation->run() === FALSE)
            {
                $this->template->title('M-Pesa Payment')->build('mpesa/m_bank', $data);
            }
            else
            {
                $this->template->title('M-Pesa Payment')->build('mpesa/global', $data);
                $this->template->title('M-Pesa Payment')->build('mpesa/m_bank', $data);
                $this->portal_m->mpesa_bank();
                $ok = $this->fee_payment_m->mpesa_payment_logs($data);

                redirect('portals/parents/check_payment/' . $ok);
                // redirect('https://app.unlimitedhand.co.ke/mercvenusmain/payments/view');
            }
            $this->template->title('M-Pesa Payment')->build('mpesa/m_bank', $data);
        }
        $this->template->title('M-Pesa Payment')->build('mpesa/m_bank', $data);
    }

    function check_payment($id)
    {

        $data['p'] = $this->portal_m->get_payment_log($id);
        //print_r($this->portal_m->get_payment_log($id));die;
        //load the view
        $this->template->title('M-Pesa Payment ')->build('mpesa/confirm', $data);
    }

    public function confirm_mpesa($reg_no)
    {

        try
        {
            //Set the response content type to application/json
            header("Content-Type:application/json");
            $resp = '{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}';
            //read incoming request

            $postData = file_get_contents('php://input');
            //log file
            $filePath = __DIR__ . "/messages.log";
            //error log
            $errorLog = __DIR__ . "/errors.log";
            //Parse payload to json
            $jdata = json_decode($postData);

            /*  $data = array(
              'response' => $postData,
              'created_on' => time(),
              );
              $this->shopping_cart_m->create_response($data); */

            $body = $jdata;
            $stkCallback = $body->Body;
            $stackdata = $stkCallback->stkCallback;
            $mid = $stackdata->MerchantRequestID;

            $CallbackMetadata = $stackdata->CallbackMetadata;
            $item = $CallbackMetadata->Item;

            $paid = $item[0];
            $transaction = $item[1];
            $phone_no = $item[4];

            $amount = $paid->Value;
            $transaction_no = $transaction->Value;
            $phone = $phone_no->Value;
            //print_r($mid);die;

            $u = $this->portal_m->find($reg_no);
            $reg = $u->id;
            $receipt = array(
                      'total' => $total,
                      'student' => $reg_no,
                      'created_by' => 1,
                      'created_on' => time()
            );
            $rec_id = $this->fee_payment_m->insert_rec($receipt);

            $table_list = array(
                      'payment_date' => time(),
                      'reg_no' => $reg,
                      'amount' => $amount,
                      'payment_method' => 'M-Pesa',
                      'transaction_no' => $transaction_no,
                      'bank_id' => 999999,
                      'receipt_id' => $rec_id,
                      'status' => 1,
                      'description' => $item,
                      'created_by' => 1,
                      'created_on' => time()
            );
            $pid = $this->fee_payment_m->create($table_list);

            if ($pid)
            {

                $settings = $this->ion_auth->settings();

                $total = $this->fee_payment_m->total_payment($rec_id);
                $st = $this->worker->get_student($reg);
                $stud = $st->first_name . ' ' . $st->last_name;

                //update student Balance
                $this->worker->calc_balance($reg);

                $paro = $this->admission_m->find($reg);
                $bal = $this->fee_payment_m->get_balance($reg);

                $member = $this->ion_auth->get_single_parent($paro->parent_id);
                if (!empty($member))
                {
                    $to = $member->first_name;

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
                    redirect('admin/fee_payment/receipt/' . $rec_id);
                }
            }


            //perform business operations on $jdata here
            //open text file for logging messages by appending
            $file = fopen($filePath, "a");
            //log incoming request

            fwrite($file, "\r\n\r\n\r\n\r\n*****Incoming cfm Request*****\r\n\r\n");
            fwrite($file, print_r($postData, true));
            fwrite($file, "\r\n\r\n\r\n\r\n");
            //log response and close file
            fwrite($file, $resp);
            fclose($file);
        }
        catch (Exception $ex)
        {
            //append exception to errorLog
            $logErr = fopen($errorLog, "a");
            fwrite($logErr, $ex->getMessage());
            fwrite($logErr, "\r\n");
            fclose($logErr);
        }
        //echo response
        echo $resp;
    }

    private function valid_rules()
    {
        $config = array(
                  array(
                            'field' => 'reg_no',
                            'label' => 'Reg No',
                            'rules' => 'required|trim|min_length[0]|max_length[60]'),
                  array(
                            'field' => 'payable',
                            'label' => 'account payable',
                            'rules' => 'required|trim'),
                  array(
                            'field' => 'phone',
                            'label' => 'phone ',
                            'rules' => 'required'),
                  array(
                            'field' => 'amount',
                            'label' => 'Amount',
                            'rules' => 'required|trim|numeric|max_length[11]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    /* {"Body":
      {
      "stkCallback":
      {
      "MerchantRequestID":"28875-128208-1",
      "CheckoutRequestID":"ws_CO_DMZ_72821690_05092018133229327",
      "ResultCode":0,
      "ResultDesc":"The service request is processed successfully.",
      "CallbackMetadata":{
      "Item":[
      {"Name":"Amount","Value":2.00},
      {"Name":"MpesaReceiptNumber","Value":"MI59HA7IF7"},
      {"Name":"Balance"},
      {"Name":"TransactionDate","Value":20180905133243},
      {"Name":"PhoneNumber","Value":254721341214}
      ]}
      }
      }
      }


      {"Result":
      {"ResultType":0,
      "ResultCode":0,
      "ResultDesc":"The service request is processed successfully.",
      "OriginatorConversationID":"10573-10212036-1",
      "ConversationID":"AG_20191220_000063f0912d697f778c",
      "TransactionID":"NLK8SM2YXO","ResultParameters":{
      "ResultParameter":[

      {"Key":"TransactionAmount","Value":10},
      {"Key":"TransactionReceipt","Value":"NLK8SM2YXO"},
      {"Key":"ReceiverPartyPublicName","Value":"254721341214 - EVANS OGOLA"},
      {"Key":"TransactionCompletedDateTime","Value":"20.12.2019 09:49:18"},
      {"Key":"B2CUtilityAccountAvailableFunds","Value":43.00},
      {"Key":"B2CWorkingAccountAvailableFunds","Value":1000.00},
      {"Key":"B2CRecipientIsRegisteredCustomer","Value":"Y"},
      {"Key":"B2CChargesPaidAccountAvailableFunds","Value":0.00}
      ]
      },
      "ReferenceData":{"ReferenceItem":{"Key":"QueueTimeoutURL","Value":"http:\/\/internalapi.safaricom.co.ke\/mpesa\/b2cresults\/v1\/submit"}
      }
      }
      }
     */

    /**
     * Home Page
     */
    public function index_()
    {
        $data['students'] = $this->admission_m->count_my_students();
        $data['classes'] = $this->admission_m->count_classes();
        $data['events'] = $this->portal_m->get_events();

        $this->template->title('Home')->build('parents/home', $data);
    }

    /**
     * log the user out
     */
    function logout()
    {
        $this->ion_auth->logout();
        //redirect them back to the page they came from
        redirect('/', 'refresh');
    }

    /**
     * change password
     */
    function change_password()
    {
        $this->form_validation->set_rules('old', 'Old password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');
        if (!$this->ion_auth->logged_in())
        {
            redirect('trs/login', 'refresh');
        }
        $user = $this->ion_auth->get_user($this->session->userdata('user_id'));
        $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
        if ($this->form_validation->run() == FALSE)
        {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['old_password'] = array('name' => 'old',
                      'id' => 'old',
                      'class' => 'form-control',
                      'type' => 'password',
            );
            $this->data['new_password'] = array('name' => 'new',
                      'id' => 'new',
                      'class' => 'form-control',
                      'type' => 'password',
            );
            $this->data['new_password_confirm'] = array('name' => 'new_confirm',
                      'id' => 'new_confirm',
                      'class' => 'form-control',
                      'type' => 'password',
            );
            $this->data['user_id'] = array('name' => 'user_id',
                      'id' => 'user_id',
                      'type' => 'hidden',
                      'value' => $user->id,
            );
            $this->template
              ->title('Change Password')
              ->build('trs/change_password', $this->data);
        }
        else
        {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));
            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
            if ($change)
            { //if the password was successfully changed
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                $this->logout();
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('trs/change_password', 'refresh');
            }
        }
    }

    /**
     * forgot password
     */
    function forgot_password()
    {
        //get the identity type from config and send it when you load the view
        $identity = $this->config->item('identity', 'ion_auth');
        $identity_human = ucwords(str_replace('_', ' ', $identity)); //if someone uses underscores to connect words in the column names
        $this->form_validation->set_rules($identity, $identity_human, 'required|valid_email');
        if ($this->form_validation->run() == false)
        {
            //setup the input
            $this->data[$identity] = array('name' => $identity,
                      'id' => $identity, //changed
            );
            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['identity'] = $identity;
            $this->data['identity_human'] = $identity_human;
            $this->template
              ->set_layout('login')
              ->title('Admin', 'Forgot Password')
              ->build('admin/forgot_password', $this->data);
        }
        else
        {
            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));
            if ($forgotten)
            { //if there were no errors
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                redirect('admin/login', 'refresh'); //we should display a confirmation page here instead of the login page
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('admin/forgot_password', 'refresh');
            }
        }
    }

    /**
     * reset password - final step for forgotten password
     * @param string $code
     */
    public function reset_password($code)
    {
        $reset = $this->ion_auth->forgotten_password_complete($code);
        if ($reset)
        {  //if the reset worked then send them to the login page
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
            redirect('admin/login', 'refresh');
        }
        else
        { //if the reset didnt work then send them back to the forgot password page
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
            redirect('admin/forgot_password', 'refresh');
        }
    }

    /**
     * Catch 404s
     * 
     */
    function error()
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('login');
        }
        $this->template
          ->title('Not Found')
          ->set_layout('error')
          ->build('admin/error');
    }

    function _assign_validation()
    {
        $config = array(
                  array(
                            'field' => 'title',
                            'label' => 'Title',
                            'rules' => 'required|trim|xss_clean|max_length[260]'),
                  array(
                            'field' => 'start_date',
                            'label' => 'Start Date',
                            'rules' => 'required|xss_clean'),
                  array(
                            'field' => 'end_date',
                            'label' => 'End Date',
                            'rules' => 'required|xss_clean'),
                  array(
                            'field' => 'assignment',
                            'label' => 'Assignment',
                            'rules' => 'trim|min_length[0]'),
                  array(
                            'field' => 'comment',
                            'label' => 'Comment',
                            'rules' => 'trim'),
                  array(
                            'field' => 'document',
                            'label' => 'Document',
                            'rules' => 'trim'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function _att_validation()
    {
        $config = array(
                  array(
                            'field' => 'attendance_date',
                            'label' => 'Attendance Date',
                            'rules' => 'required|xss_clean'),
                  array(
                            'field' => 'title',
                            'label' => 'Title',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'student',
                            'label' => 'Student',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'status',
                            'label' => 'Status',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'remarks',
                            'label' => 'Remarks',
                            'rules' => 'xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    /**
     * Pagination Options
     * 
     * @return array
     */
    private function _exam_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'trs/record/index';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 15;
        $config['total_rows'] = $this->exams_m->count();
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
        $config['full_tag_open'] = '<ul class="pagination pagination-split">';
        $config['full_tag_close'] = '</ul></div>';

        return $config;
    }

    /**
     * Record Exams Validation
     * 
     * @return array
     */
    private function _rec_validation()
    {

        $config = array(
                  array(
                            'field' => 'record_date',
                            'label' => 'Record Date',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'exam_type',
                            'label' => 'The Exam',
                            'rules' => 'trim|xss_clean'),
                  array(
                            'field' => 'subject[]',
                            'label' => 'Subject',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'student[]',
                            'label' => 'student',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'total[]',
                            'label' => 'Total',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'marks[]',
                            'label' => 'Marks',
                            'rules' => 'xss_clean'),
                  array(
                            'field' => 'grading',
                            'label' => 'Grading',
                            'rules' => 'required'),
                  array(
                            'field' => 'remarks[]',
                            'label' => 'Remarks',
                            'rules' => 'xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'portals/parents/notices/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->portal_m->count_notices();
        $config['uri_segment'] = 4;

        $config['first_link'] = lang('web_first');
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = lang('web_last');
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = FALSE;
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = FALSE;
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active">  <a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item page-link">';
        $config['num_tag_close'] = '</li>';
        $config['full_tag_open'] = '<ul class="pagination pagination-centered">';
        $config['full_tag_close'] = '</ul>';
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }

}
