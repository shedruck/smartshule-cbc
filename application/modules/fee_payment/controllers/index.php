<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
              

                $this->load->model('fee_payment_m');
                $this->load->model('admission/admission_m');
                $this->load->model('sms/sms_m');
                $this->load->library('pmailer');
                //$this->load->library('mpesa');
                $this->load->library('image_cache');
                $this->load->model('accounts/accounts_m');
                $valid = $this->portal_m->get_class_ids();
              
        }
		
	function upi_verifier(){
		
		$reg_no = $this->input->get('reg_no');	
		$upi = $this->portal_m->upi_checker($reg_no);

		$jso = 0;
		if($upi){
			$jso = 1;
		}
		echo $jso;
		
	}
	
	//*****
	//***SandBox ENV
	//*** @param student id
	//***
	public function confirm_mpesa_sandbox($reg_no){
		
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
							$this->portal_m->create_response($data); */
							 
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
								
							$reg = $reg_no;
								 $receipt = array(
									'total' => $amount,
									'student' => $reg_no,
									'created_by' => 1,
									'created_on' => time()
								);
							$rec_id = $this->fee_payment_m->insert_rec($receipt);
							 
							  $table_list = array(
                                    'payment_date' => time(),
                                    'reg_no' => $reg_no,
                                    'amount' => $amount,
                                    'payment_method' => 'M-Pesa',
                                    'transaction_no' => $transaction_no,
                                    'bank_id' => 999999,
                                    'receipt_id' => $rec_id,
                                    'status' => 1,
                                    'description' => 'Fee Payment',
                                    'created_by' => 1,
                                    'created_on' => time()
                                );
                            $pid = $this->fee_payment_m->create($table_list);
							
							
							if(!empty($transaction_no) && $amount !=0 ){
								
								$settings = $this->ion_auth->settings();
								
								$total = $this->fee_payment_m->total_payment($rec_id);
                                $st = $this->worker->get_student($reg_no);
                                $stud = $st->first_name . ' ' . $st->last_name;

                                //update student Balance
                                $this->worker->calc_balance($reg_no);

                                $paro = $this->admission_m->find($reg_no);
                                $bal = $this->fee_payment_m->get_balance($reg_no);

                                $member = $this->ion_auth->get_single_parent($paro->parent_id);
                                if (!empty($member))
                                {
                                        $to = $member->first_name;

                                        if ($bal->balance < 0)
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received ksh.' . number_format($total->total) . ' being fee payment for ' . $stud . '. You have an overpay of ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                                        }
                                        elseif ($bal->balance == 0)
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ksh.' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is 0.00. Thanks for choosing ' . $settings->school;
                                        }
                                        else
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ksh.' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                                        }

                                        $this->sms_m->send_sms($member->phone, $message);
                                        //redirect('admin/fee_payment/receipt/' . $rec_id);
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
	
	//*****
	//***Live ENV
	//*** @param student id
	//***
	public function confirm_mpesa($reg_no){
		
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
							$this->portal_m->create_response($data); */
							 
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
								
				if(!empty($transaction_no) && $amount !=0 ){			
						
						$reg = $reg_no;		
								 $receipt = array(
									'total' => $amount,
									'student' => $reg,
									'created_by' => 1,
									'created_on' => time()
								);
							//$rec_id = $this->fee_payment_m->insert_rec($receipt);
							 
							  $table_list = array(
                                    'payment_date' => time(),
                                    'reg_no' => $reg,
                                    'amount' => $amount,
                                    'payment_method' => 'M-Pesa',
                                    'transaction_no' => $transaction_no,
                                    'bank_id' => 999999,
                                    'receipt_id' => $rec_id,
                                    'status' => 1,
                                    'description' => 'Fee Payment',
                                    'created_by' => 1,
                                    'created_on' => time()
                                );
								
                              //$pid = $this->fee_payment_m->create($table_list);
							
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
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received ksh.' . number_format($total->total) . ' being fee payment for ' . $stud . '. You have an overpay of ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                                        }
                                        elseif ($bal->balance == 0)
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ksh.' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is 0.00. Thanks for choosing ' . $settings->school;
                                        }
                                        else
                                        {
                                                $message = $settings->message_initial . ' ' . $to . ', Confirmed. We received  ksh.' . number_format($total->total) . ' being fee payment for ' . $stud . '. Your balance is ' . number_format($bal->balance) . '. Thanks for choosing ' . $settings->school;
                                        }

                                        $this->sms_m->send_sms($member->phone, $message);
                                        //redirect('admin/fee_payment/receipt/' . $rec_id);
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

			
			
	 private function validation()
        {
                $config = array(
                 
                    array(
                        'field' => 'reg_no',
                        'label' => 'Reg No',
                        'rules' => 'required|trim|min_length[0]|max_length[60]'),
               
                    array(
                        'field' => 'account',
                        'label' => 'account',
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
}
