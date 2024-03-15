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

                $this->load->model('sms_m');
                $this->load->model('class_groups/class_groups_m');
                $this->load->model('email_templates/email_templates_m');
                $this->load->library('pmailer');
                $this->load->library('image_cache');
                if ($this->input->get('sw'))
                {
                        $pop = $this->input->get('sw');
                        $valid = $this->portal_m->get_class_ids();
                        // imit to available classes only
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
                        
                }
        }
		
    function test()
        {
			 
                $recipient = '0721341214';
                $message = 'Hello , this is test SMS from Smartshule System';
                $this->sms_m->send_sms($recipient, $message);
				
				print_r($message);die;
			 
        }

        /**
         * Check SMS Balance BongaTech New Portal
         */
        function balance_advanta()
        {
                $this->load->library('Req');
				
                if (empty($this->config->item('advanta_apikey')) && $this->config->item('advanta_partnerID') )
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'SMS Module is not configured'));
                        redirect('admin/sms/create');
                }

                $url = 'https://quicksms.advantasms.com/api/services/getbalance/';
				
				$apikey = $this->config->item('advanta_apikey');
				$partnerID = $this->config->item('advanta_partnerID');
				
				$json = '{ 
						  "apikey":"'.$apikey.'",
						  "partnerID":"'.$partnerID.'"
                           }';
				
                 $headers = array('Content-Type' => 'application/json');
			   
			     $balance =  $this->req->post($url, $headers, $json);
				 
                $res = json_decode($balance->body);

                $sms_bal = round($res->credit);
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<span style="font-size:17px; font-weight:bold; color:#00008b;"> Your SMS Account has <b style="color:red">' . number_format($sms_bal) . '</b>  SMS available.</span>'));
                redirect('admin/sms/create');
        }

		/**
         * Check SMS Balance BongaTech New Portal
         */
        function balance()
        {
               $this->load->library('Req');
                if (empty($this->config->item('access_token')) )
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'SMS Module is not configured'));
                        redirect('admin/sms/create');
                }
				
               
                $url = 'http://bulk.bongatech.co.ke/api/v1/account/balance';
				
				$access_token = $this->config->item('access_token');	
                $headers = array('Accept' => 'application/json', 'Content-Type' => ' application/json', 'Authorization' => 'Bearer ' . $access_token);
						
                $balance = $this->req->get($url, $headers);
				
                $res = json_decode($balance->body);
				
				
                $bal = $res->data;
                $sms_bal = round($bal->account_units);
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Your SMS Account has <span style="font-size:17px; font-weight:bold; color:#00008b;">' . number_format($sms_bal) . ' </span> SMS available.'));
                redirect('admin/sms/create');
        }

		/**
         * Check SMS Balance AfricasTalking
         */
        function balance_atf()
        {
                $this->load->library('Aft');
                if (empty($this->config->item('aft_key')) || empty($this->config->item('aft_username')))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'SMS Module is not configured'));
                        redirect('admin/sms/create');
                }
                $username = $this->config->item('aft_username');
                $apikey = $this->config->item('aft_key');

                try
                {
                        $gateway = new AfricasTalkingGateway($username, $apikey);
                        // Fetch the data from our USER resource and read the balance
                        $data = $gateway->getUserData();
                        $bbal = preg_replace('/[^0-9.]/', '', $data->balance);
                        $bal = "Your SMS Account Balance: <span style='font-size:17px; font-weight:bold; color:#00008b;'>Ksh " . number_format($bbal, 2) . "</span>";
                        // The result will have the format=> KES XXX
                }
                catch (AfricasTalkingGatewayException $e)
                {
                        $bal = "Encountered an error while fetching user data: " . $e->getMessage() . "\n";
                }

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $bal));
                redirect('admin/sms/create');
        }

        /**
         * Check SMS Balance BongaTech Old Portal
         */
        function balance_bulk()
        {
                $this->load->library('Req');
                if (empty($this->config->item('sms_pass')) || empty($this->config->item('sms_id')))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'SMS Module is not configured'));
                        redirect('admin/sms/create');
                }
                $tok = md5($this->config->item('sms_pass'));
                $userid = $this->config->item('sms_id');
                $url = 'http://197.248.4.47/smsapi/balance.php?UserID=' . $userid . '&Token=' . $tok;
                $balance = $this->req->get($url);

                $res = json_decode($balance->body);
                $bal = round($res->Balance);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Your SMS Account has <span style="font-size:17px; font-weight:bold; color:#00008b;">' . number_format($bal) . ' </span> SMS available.'));
                redirect('admin/sms/create');
        }

        public function index()
        {
                redirect('admin/sms/create');
                //set the title of the page
                $data['title'] = 'Sms List';

                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //number page variable
                $data['page'] = $page;
                //load view
                $this->template->title('All Sms')->build('admin/create', $data);
        }

        public function log()
        {
                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;
                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_log($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //number page variable
                $data['page'] = $page;

                //load view
                $this->template->title('All Sms Sent')->build('admin/log', $data);
        }
		
		public function log_text()
        {
                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;
                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_log($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //number page variable
                $data['page'] = $page;

                //load view
                $this->template->title('All Sms Sent')->build('admin/log_text', $data);
        }
		

        function sms_random($page = 0)
        {
                //Rules for validation
                $this->form_validation->set_rules($this->valid());

                //create control variables
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();

                        $numbers = $this->input->post('numbers');

                        $nums = preg_replace('/\s+/', ',', str_replace(array("\r\n", "\r", "\n"), ' ', trim($numbers)));

                        $numbs = preg_replace('#\s+#', ',', trim($nums));

                        $num = explode(',', $numbs);

                        $counter = 0;
                        foreach ($num as $key => $val)
                        {
                                $counter++;

                                $message = $this->input->post('message');
                                $sms_m = $this->sms_m->send_sms($val, $message);
                        }

                        $this->worker->sms_callback();
                        if ($sms_m)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $counter . ' SMS were successfully processed'));
                                redirect("admin/sms/log");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Sorry something went wrong please try again later'));
                                redirect("admin/sms/log");
                        }
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['sms_m'] = $get;

                        //load the view and the layout
                        $this->template->title('SMS Random Numbers ')->build('admin/random', $data);
                }
        }

        /**
         * print_contacts
         * 
         */
        public function print_contacts()
        {
                if ($this->input->post())
                {
                        $students = $this->input->post('sids');
                        $phones = array();
                        $got = array();

                        if ($this->input->post('stype') == 1)
                        {
                                $i = 0;

                                if (count($students) < 1)
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No recipients Selected'));
                                        redirect('admin/sms/custom');
                                }
                                foreach ($students as $s)
                                {
                                        $i++;
                                        $adm = $this->worker->get_student($s);
                                        $parent = $this->portal_m->get_parent($adm->parent_id);

                                        $nm = 'x254' . $parent->phone;
                                        $fnum = str_replace('x2540', 254, $nm);

                                        if (!in_array($fnum, $got))
                                        {
                                                $phones[] = $fnum;
                                        }
                                        $this->sms_m->send_sms($phone, $message);
                                }
                                echo '<pre>';
                                print_r($phones);
                                //print_r(array_unique($phones));
                                echo '</pre>';
                                die();
                        }

                        redirect('admin/sms/custom');
                }
                $data['page'] = '';

                $this->template->title('Custom SMS to Parents')->build('admin/custom', $data);
        }

        public function custom()
        {
                if ($this->input->post())
                {
                        $students = $this->input->post('sids');
                        if ($this->input->post('stype') == 1)
                        {
                                $sms = $this->input->post('sms');
                                if (strlen($sms) < 20)
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Message too Short'));
                                        redirect('admin/sms/custom');
                                }
                                if (count($students) < 1)
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No recipients Selected'));
                                        redirect('admin/sms/custom');
                                }
                                if ($this->input->post('export'))
                                {
                                        $this->export($students, $sms);
                                }
                                else
                                {
                                        $i = 0;
                                        foreach ($students as $s)
                                        {
                                                $i++;
                                                $adm = $this->worker->get_student($s);
                                                $parent = $this->portal_m->get_parent($adm->parent_id);

                                                if ($parent->sms == 1)
                                                {
                                                        //both parents
                                                        $this->sms_m->send_sms($parent->phone, $sms);

                                                        $this->sms_m->send_sms($parent->mother_phone, $sms);

                                                        //*********** LOG *************// 
                                                        $log = array(
                                                            'module' => $this->router->fetch_module(),
                                                            'item_id' => 'phone',
                                                            'transaction_type' => $this->router->fetch_method(),
                                                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method(),
                                                            'details' => $sms,
                                                            'created_by' => $this->user->id,
                                                            'created_on' => time()
                                                        );

                                                        $this->ion_auth->create_log($log);
                                                        //************Done Log *********//
                                                }
                                                else
                                                {
                                                        $phone = $parent->phone;
                                                        if (empty($phone))
                                                        {
                                                                $phone = $parent->mother_phone;
                                                        }
                                                        $this->sms_m->send_sms($phone, $sms);
                                                        //*********** LOG *************// 
                                                        /* $log = array(
                                                          'module' => $this->router->fetch_module(),
                                                          'item_id' => 'phone',
                                                          'transaction_type' => $this->router->fetch_method(),
                                                          'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method(),
                                                          'details' => $sms,
                                                          'created_by' => $this->user->id,
                                                          'created_on' => time()
                                                          );

                                                          $this->ion_auth->create_log($log); */
                                                        //************Done Log *********//
                                                }
                                        }

                                        $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Sent ' . $i . ' SMS'));
                                }
                        }
                        else
                        {
                                $i = 0;
                                foreach ($students as $s)
                                {
                                        $i++;
                                        $adm = $this->worker->get_student($s);
                                        $parent = $this->portal_m->get_parent($adm->parent_id);
                                        if (!$parent->user_id)
                                        {
                                                continue;
                                        }
                                        $link = base_url();
                                        //$user = $this->ion_auth->get_user($parent->user_id);
                                        $sms = $this->school->message_initial . ' ' . $parent->first_name . ' Your Login details: ' . $link . ' email:' . $parent->email . ' password:12345678. You can change Your password after Login';

                                        $phone = $parent->phone;
                                        if (empty($phone))
                                        {
                                                $phone = $parent->mother_phone;
                                        }

                                        $this->sms_m->send_sms($phone, $sms);
                                }
                                $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Sent ' . $i . ' SMS'));
                        }
                        $this->worker->sms_callback();
                        redirect('admin/sms/custom');
                }
                $data['page'] = '';

                $this->template->title('Custom SMS to Parents')->build('admin/custom', $data);
        }

        public function fee_extras()
        {
                if ($this->input->post())
                {
                        $students = $this->input->post('sids');

                        $sms = $this->input->post('sms');
                        if (strlen($sms) < 20)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Message too Short'));
                                redirect('admin/sms/fee_extras');
                        }
                        if (count($students) < 1)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No recipients Selected'));
                                redirect('admin/sms/fee_extras');
                        }
                        if ($this->input->post('export'))
                        {
                                $this->export($students, $sms);
                        }
                        else
                        {
                                $i = 0;
                                foreach ($students as $s)
                                {
                                        $i++;
                                        $adm = $this->worker->get_student($s);
                                        $parent = $this->portal_m->get_parent($adm->parent_id);

                                        if ($parent->sms == 1)
                                        {
                                                //both parents
                                                $phone = $parent->phone;
                                                $message = $this->school->message_initial . ' ' . $parent->first_name . ' ' . $sms;
                                                $this->sms_m->send_sms($phone, $message);

                                                $phone2 = $parent->mother_phone;
                                                $message2 = $this->school->message_initial . ' ' . $parent->mother_fname . ' ' . $sms;
                                                $this->sms_m->send_sms($phone2, $message2);
                                        }
                                        else
                                        {
                                                $phone = $parent->phone;
                                                if (empty($phone))
                                                {
                                                        $phone = $parent->mother_phone;
                                                }
                                                $message = $this->school->message_initial . ' ' . $parent->first_name . ' ' . $sms;
                                                $this->sms_m->send_sms($phone, $message);
                                        }
                                }
                                $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Sent ' . $i . ' SMS'));
                        }

                        $this->worker->sms_callback();
                        redirect('admin/sms/fee_extras');
                }

                $list = $this->sms_m->get_fee_list();

                $data['list'] = $list;
                $data['fee'] = $this->input->get('fee');
                $this->template->title('Custom SMS to Parents')->build('admin/fee_extras', $data);
        }

        /**
         * Get Datatable
         * 
         */
        public function get_table()
        {
                $fee = $this->input->get('fee');
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);
                $output = $this->sms_m->filter_students($fee, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        /**
         * export list to Excel
         * 
         * @param array $list
         * @param string $message
         */
        function export($list, $message)
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
                        $parent = $this->portal_m->get_parent($adm->parent_id);

                        $no = $util->parse($parent->phone, 'KE', null, true);
                        $is_valid = $util->isValidNumber($no);
                        if ($is_valid != 1)
                        {
                                continue;
                        }

                        $code = $no->getcountryCode();
                        $nat = $no->getNationalNumber();
                        $phone = $code . $nat;

                        $objPHPExcel->getActiveSheet()
                                     ->getStyle('D' . $i . ':H' . $i)
                                     ->getAlignment()
                                     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()
                                     ->getStyle('A' . $i)
                                     ->getNumberFormat()
                                     ->setFormatCode('##0');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':B' . $i)->applyFromArray($styles);

                        if (!empty($parent))
                        {
                                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $phone);
                                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $message);

                                $i ++;
                        }
                }

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Custom_sms_' . date('d_m_H:i:s') . '.xls" ');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
        }

        //Send Email General Function
        function create($page = NULL)
        {
                //create control variables
                $data['title'] = 'Create sms';
                $data['updType'] = 'create';
                $data['classes'] = $this->class_groups_m->get_classes();
                $data['the_class'] = $this->classes;
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $initial = isset($this->school->message_initial) && !empty($this->school->message_initial) ? $this->school->message_initial : 'Hi';
                ///LIST ALL Sms
                $data['title'] = 'Sms List';

                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);
                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_all($config['per_page'], $page);
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //number page variable
                $data['page'] = $page;
                $data['parents'] = $this->sms_m->get_active_parents();
                $data['users'] = $this->sms_m->get_users_phone();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {
                        $post = array();
                        $body = $this->input->post('sms');
                        //Send to parents
                        if ($this->input->post('send_to') == 'All Parents')
                        {
                                $members = $this->sms_m->active_parent();
                                if ($this->input->post('export'))
                                {
                                        foreach ($members as $member)
                                        {
                                                $to = $member->first_name;
                                                $message = $body;

                                                if ($member->sms == 1)
                                                {
                                                        //both parents
                                                        $post[] = (object) array('phone' => $member->phone, 'message' => $message);
                                                        $post[] = (object) array('phone' => $member->mother_phone, 'message' => $message);
                                                }
                                                else
                                                {
                                                        $post[] = (object) array('phone' => $member->phone, 'message' => $message);
                                                }
                                        }
                                        $this->export_bulk($post);
                                }
                                else
                                {
                                        $message = '';
                                        foreach ($members as $member)
                                        {
                                                $recipient = $member->phone;
                                                $to = $member->first_name . ' ' . $member->last_name;
                                                $message = $body;

                                                if ($member->sms == 1)
                                                {
                                                        //both parents
                                                        $this->sms_m->send_sms($member->phone, $message);

                                                        $phone2 = $member->mother_phone;
                                                        $this->sms_m->send_sms($phone2, $message);
                                                }
                                                else
                                                {
                                                        $this->sms_m->send_sms($recipient, $message);
                                                }
                                        }

                                        //*********** LOG *************// 
                                        $details = $message;
                                        $user = $this->ion_auth->get_user();
                                        $log = array(
                                            'module' => $this->router->fetch_module(),
                                            'item_id' => 'phone',
                                            'transaction_type' => $this->router->fetch_method(),
                                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/index',
                                            'details' => $details,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->ion_auth->create_log($log);

                                        //************Done Log *********//
                                }
                        }
                        elseif ($this->input->post('send_to') == 'All Teachers')
                        {
                                $members = $this->ion_auth->get_teacher();
                                $message = "";
                                $recipient = '';
                                if ($this->input->post('export'))
                                {
                                        foreach ($members as $member)
                                        {
                                                $to = $member->first_name;
                                                $message = $body;

                                                $post[] = (object) array('phone' => $member->phone, 'message' => $message);
                                        }
                                        $this->export_bulk($post);

                                        //*********** LOG *************// 
                                        $details = $message;
                                        $user = $this->ion_auth->get_user();
                                        $log = array(
                                            'module' => $this->router->fetch_module(),
                                            'item_id' => 'SMS',
                                            'transaction_type' => $this->router->fetch_method(),
                                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/index',
                                            'details' => $details,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->ion_auth->create_log($log);

                                        //************Done Log *********//
                                }
                                else
                                {
                                        foreach ($members as $member)
                                        {
                                                $recipient = $member->phone;
                                                $to = $member->first_name;
                                                $message = $body;
                                                $this->sms_m->send_sms($recipient, $message);
                                        }

                                        //*********** LOG *************// 
                                        $details = $message;
                                        $user = $this->ion_auth->get_user();
                                        $log = array(
                                            'module' => $this->router->fetch_module(),
                                            'item_id' => 'SMS',
                                            'transaction_type' => $this->router->fetch_method(),
                                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/index',
                                            'details' => $details,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->ion_auth->create_log($log);

                                        //************Done Log *********//
                                }
                        }
                        //Send to all staff
                        elseif ($this->input->post('send_to') == 'All Staff')
                        {
                                $message = '';
                                $members = $this->sms_m->get_all_staff();
                                if ($this->input->post('export'))
                                {
                                        foreach ($members as $member)
                                        {
                                                $to = $member->first_name;
                                                $message = $body;

                                                $post[] = (object) array('phone' => $member->phone, 'message' => $message);
                                        }
                                        $this->export_bulk($post);

                                        //*********** LOG *************// 
                                        $details = $message;
                                        $user = $this->ion_auth->get_user();
                                        $log = array(
                                            'module' => $this->router->fetch_module(),
                                            'item_id' => 'SMS',
                                            'transaction_type' => $this->router->fetch_method(),
                                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/index',
                                            'details' => $details,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->ion_auth->create_log($log);

                                        //************Done Log *********//
                                }
                                else
                                {
                                        foreach ($members as $member)
                                        {
                                                $recipient = $member->phone;
                                                $to = $member->first_name;
                                                $message = $body;
                                                $this->sms_m->send_sms($recipient, $message);
                                        }

                                        //*********** LOG *************// 
                                        $details = $message;
                                        $user = $this->ion_auth->get_user();
                                        $log = array(
                                            'module' => $this->router->fetch_module(),
                                            'item_id' => 'SMS',
                                            'transaction_type' => $this->router->fetch_method(),
                                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/index',
                                            'details' => $details,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->ion_auth->create_log($log);

                                        //************Done Log *********//
                                }
                        }
                        elseif ($this->input->post('send_to') == 'Staff')
                        {
                                $member = $this->ion_auth->get_user($this->input->post('staff'));
                                $recipient = $member->phone;
                                $to = $member->first_name;
                                $message = $body;

                                $this->sms_m->send_sms($recipient, $message);

                                //*********** LOG *************// 
                                $details = $message;
                                $user = $this->ion_auth->get_user();
                                $log = array(
                                    'module' => $this->router->fetch_module(),
                                    'item_id' => 'SMS',
                                    'transaction_type' => $this->router->fetch_method(),
                                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/index',
                                    'details' => $details,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $this->ion_auth->create_log($log);

                                //************Done Log *********//
                        }
                        else
                        {
                                
                        }
                        $this->worker->sms_callback();
                        redirect('admin/sms/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['sms_m'] = $get;

                        //load the view and the layout
                        $this->template->title('Compose SMS ')->build('admin/create', $data);
                }
        }

        /**
         * export sms to Excel
         * 
         * @param array $list
         * @param string $message
         */
        function export_bulk($list)
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

                foreach ($list as $s)
                {
                        $no = $util->parse($s->phone, 'KE', null, true);
                        $is_valid = $util->isValidNumber($no);
                        if ($is_valid != 1)
                        {
                                continue;
                        }

                        $code = $no->getcountryCode();
                        $nat = $no->getNationalNumber();
                        $phone = $code . $nat;

                        $objPHPExcel->getActiveSheet()
                                     ->getStyle('A' . $i)
                                     ->getNumberFormat()
                                     ->setFormatCode('##0');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':B' . $i)->applyFromArray($styles);

                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $phone);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $s->message);

                        $i ++;
                }

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Custom_sms_' . date('d_m_H:i:s') . '.xls" ');
                header('Cache-Control: max-age=0');

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
        }

        function get_contacts()
        {
                $contacts = array();
                $sent = $this->sms_m->sent_t();
                $ww = array();
                foreach ($sent as $x)
                {
                        $ww[] = $x->dest;
                }

                $members = $this->sms_m->active_parent();

                foreach ($members as $member)
                {
                        $contacts[] = $member->phone;
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms/');
                }
                if (!$this->sms_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms');
                }
                //search the item to show in edit form
                $get = $this->sms_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['title'] = lang('web_edit');
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'id' => $id,
                            'user_id' => $this->input->post('user_id'),
                            'cc' => $this->input->post('cc'),
                            'subject' => $this->input->post('subject'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //find the item to update
                        $sms_m = $this->sms_m->update_attributes($id, $form_data);


                        if ($sms_m)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/sms/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $sms_m->errors->full_messages()));
                                redirect("admin/sms/");
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
                $data['sms_m'] = $get;
                //load the view and the layout
                $this->template->title('Edit Sms ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms');
                }

                //search the item to delete
                if (!$this->sms_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms');
                }

                //delete the item
                if ($this->sms_m->delete($id) == TRUE)
                {
                        //*********** LOG *************// 
                        // $details = $message;
                        $user = $this->ion_auth->get_user();
                        $log = array(
                            'module' => $this->router->fetch_module(),
                            'item_id' => $id,
                            'transaction_type' => $this->router->fetch_method(),
                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
                            'details' => 'Record Deleted',
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $this->ion_auth->create_log($log);

                        //************Done Log *********//

                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/sms/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'user_id',
                        'label' => 'User Id',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'cc',
                        'label' => 'Cc',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'send_to',
                        'label' => 'Send To',
                        'rules' => 'trim|required|xss_clean',
                    ),
                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[255]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function valid()
        {
                $config = array(
                    array(
                        'field' => 'message',
                        'label' => 'Message',
                        'rules' => 'required|trim'),
                    array(
                        'field' => 'numbers',
                        'label' => ' at least one Number',
                        'rules' => 'required|trim'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/sms/log/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000;
                $config['total_rows'] = $this->sms_m->count_log();
                $config['uri_segment'] = 5;

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
                $config['full_tag_open'] = "<div class='pagination  pagination-centered'><ul>";
                $config['full_tag_close'] = '</ul></div>';

                return $config;
        }

}
