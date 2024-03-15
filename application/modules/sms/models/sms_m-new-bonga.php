<?php

class Sms_m extends MY_Model
{

        /**
         * Model Constructor
         */
        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function sent_t()
        {
                return $this->db->select($this->dxa('dest'), FALSE)->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('created_on') . "),'%d-%m-%Y')" . "='" . date('d-m-Y') . "'", NULL, FALSE)->get('text_log')->result();
        }

        function my_sms()
        {
                $user = $this->ion_auth->get_user();
                $this->db->order_by('id', 'desc');

                $all = $this->db->where('recipient', 'All Parents')->get('sms')->result();
                $one = $this->db->where('recipient', $user->id)->where('type', 2)->get('sms')->result();

                if (empty($one))
                {
						return $all;
                }
                else
                {
                        $res = array_merge($all, $one);
                        return $res;
                }
        }

        function my_sms_new()
        {
                $usr = $this->ion_auth->get_user();
                $this->select_all_key('parents');
                $parent = $this->db->where($this->dx('user_id') . '=' . $usr->id, NULL, FALSE)->get('parents')->row();

                $country_code = '254';
                $recipient = $parent->phone;

                $new_number = substr_replace($recipient, $country_code, 0, ($recipient[0] == '0'));
                $this->select_all_key('text_log');
                $this->db->order_by('id', 'desc');
                return $this->db->where($this->dx('dest') . '=' . $new_number, NULL, FALSE)->get('text_log')->result();
        }

        /**
         * Log Status
         * 
         * @param type $data
         * @return type
         */
        function create($data)
        {
                $query = $this->db->insert('sms', $data);
                return $query;
        }

        function log_queue($data, $key)
        {
                $qdb = $this->load->database('smsq', TRUE);

                $qdb->insert('messages', $data);
                $id = $qdb->insert_id();

                $fk = array(
                    'message_id' => $id,
                    'keyp' => base64_encode(gzdeflate($key)),
                    'created_on' => time()
                );

                return $qdb->insert('messages_ks', $fk);
        }

        /**
         * Send SMS
         * 
         * @param string $phone
         * @param string $message
         * @return boolean
         */
        function send_sms_aft($phone, $message)
        {
                $this->load->library('Aft');
                $this->load->library('Fone');

                if (empty($this->config->item('aft_key')) || empty($this->config->item('aft_username')))
                {
                        $st = 'SMS Module is not configured';
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => $st));
                        return 'SMS Module is not configured';
                }

                $username = $this->config->item('aft_username');
                $apikey = $this->config->item('aft_key');
                $from = $this->config->item('sender');

                if (empty($phone))
                {
                        return FALSE;
                }
                $util = \libphonenumber\PhoneNumberUtil::getInstance();
                $no = $util->parse($phone, 'KE', null, true);
                $req = FALSE;

                $is_valid = $util->isValidNumber($no);
                if ($is_valid == 1)
                {
                        $code = $no->getcountryCode();
                        $nat = $no->getNationalNumber();
                        $phone = $code . $nat;
                        
                        $parts = array(
                            'source' => $from,
                            'dest' => $phone,
                            'relay' => $message,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );
                        $this->log_text($parts);

                        //send to queueing system if online
                        if (strpos(current_url(), 'smartshule.com') !== false)
                        {
                                $uri = parse_url(current_url());
                                $parts = explode('.', $uri['host']);

                                $post = array(
                                    'phone' => $phone,
                                    'sender_id' => $from,
                                    'api' => 'aft',
                                    'message' => $message,
                                    'carrier' => '', // $carrier,
                                    'app_id' => $from == 'SMARTSHULE' ? 'smartshule' : $username, //$parts[0] 
                                    'queue_status' => 1,
                                    'created_on' => time(),
                                    'created_by' => $this->user->id
                                );

                                $req = $this->log_queue($post, $apikey);
                        }
                        else
                        {
                        try
                        {
                                $gateway = new AfricasTalkingGateway($username, $apikey);
                                $req = $gateway->sendMessage($phone, $message, $from);
                        }
                        catch (AfricasTalkingGatewayException $exc)
                        {
                                $req = $exc->getMessage();
                        }
                }
                }

                return $req;
        }

          /**
         * Send SMS
         * 
         * @param string $phone
         * @param string $message
         * @return boolean
         */
		 
		  function post_sms($phone, $message){
			  
			      
				$this->load->library('Req');
                $this->load->library('Fone');

                 if (empty($this->config->item('sms_pass')) || empty($this->config->item('sms_id'))|| empty($this->config->item('sender')))
                {
                        $st = 'SMS Module is not configured';
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => $st));
                        return 'SMS Module is not configured';
                }

                $sms_id =  $this->config->item('sms_id');
                $sms_pass =  $this->config->item('sms_pass');
                $from =  $this->config->item('sender');

                if (empty($phone))
                {
                        return FALSE;
                }

                if (strpos($phone, ',') !== false)
                {
                        $data = explode(',', $phone);
                        $phone = $data[0];
                }

                $util = \libphonenumber\PhoneNumberUtil::getInstance();
                $no = $util->parse($phone, 'KE', null, true);
                $req = FALSE;

                $is_valid = $util->isValidNumber($no);
                if ($is_valid == 1)
                {
					
				$code = $no->getcountryCode();
				$nat = $no->getNationalNumber();
				$phone = $code . $nat;
				
				$by = 1;
						if ($this->ion_auth->logged_in())
                         {
                            $by = $this->ion_auth->get_user()->id;
						 }
				
				$parts = array(
					'source' => $from,
					'dest' => $phone,
					'relay' => $message,
					'created_on' => time(),
					'created_by' => $by
				);
				$this->log_text($parts);
				
		    $headers = array('Content-Type' => 'application/json');
			$url = 'https://bulk.bongatech.co.ke/api/v1/send-basic-sms?username='.$sms_id.'&password='.$sms_pass.'&sender='.$from.'&message='.$message.'&phone='.$phone.'&correlator=1';
			
			  try
				{
					$req = $this->req->get($url, $headers);
				}
				catch (Exception $exc)
				{
					$req = $exc->getMessage();
				}
				
			}
				
			  return $req;
		
		 }
		 
        function send_sms($phone, $message)
        {
                
				$this->load->library('Req');
                $this->load->library('Fone');

                if (empty($this->config->item('access_token')))
                {
                        $st = 'SMS Module is not configured';
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => $st));
                        return 'SMS Module is not configured';
                }
               
                $access_token = $this->config->item('access_token');
                $from =  $this->config->item('sender');

                if (empty($phone))
                {
                        return FALSE;
                }

                if (strpos($phone, ',') !== false)
                {
                        $data = explode(',', $phone);
                        $phone = $data[0];
                }

                $util = \libphonenumber\PhoneNumberUtil::getInstance();
                $no = $util->parse($phone, 'KE', null, true);
                $req = FALSE;

                $is_valid = $util->isValidNumber($no);
              
                        $code = $no->getcountryCode();
                        $nat = $no->getNationalNumber();
                        $phone = $code . $nat;

                        $url = 'https://bulk.bongatech.co.ke/api/v1/send-sms';
						
						$js = array(
						          "sender"=>$from,
								  "message"=>$message,
								  "phone"=>$phone,
								  "correlator"=>1
						);
						
						$json = json_encode($js);
					
						
						$by = 1;
						if ($this->ion_auth->logged_in())
                         {
                            $by = $this->ion_auth->get_user()->id;
						 }
						 
                        $parts = array(
                            'source' => $from,
                            'dest' => $phone,
                            'relay' => $message,
                            'created_on' => time(),
                            'created_by' => $by
                        );
                        $this->log_text($parts);
						
                        $headers = array('Accept' => 'application/json', 'Content-Type' => ' application/json', 'Authorization' => 'Bearer ' . $access_token);
						
						
                        try
                        {
                                $req = $this->req->post($url, $headers, $json);
								//print_r($req);die;
                        }
                        catch (Exception $exc)
                        {
                                $req = $exc->getMessage();
                        }
                

                return $req;
        }

		/**
         * Send SMS
         * 
         * @param string $phone
         * @param string $message
         * @return boolean
         */
        function send_sms_bongatech_old($phone, $message)
        {
                $this->load->library('Req');
                $this->load->library('Fone');

                if (empty($this->config->item('sms_pass')) || empty($this->config->item('sms_id')))
                {
                        $st = 'SMS Module is not configured';
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => $st));
                        return 'SMS Module is not configured';
                }

                $userid = $this->config->item('sms_id');
                $token = md5($this->config->item('sms_pass'));
                $from = empty($this->config->item('sender')) ? 'KEYPAD' : $this->config->item('sender');

                if (empty($phone))
                {
                        return FALSE;
                }

                if (strpos($phone, ',') !== false)
                {
                        $data = explode(',', $phone);
                        $phone = $data[0];
                }

                $util = \libphonenumber\PhoneNumberUtil::getInstance();
                $no = $util->parse($phone, 'KE', null, true);
                $req = FALSE;

                $is_valid = $util->isValidNumber($no);
                if ($is_valid == 1)
                {
                        $code = $no->getcountryCode();
                        $nat = $no->getNationalNumber();
                        $phone = $code . $nat;

                        //$url = '';//'http://197.248.4.47/smsapi/submit.php';
                        $url = 'http://api.bizsms.co.ke/submit1.php';
						
                        $stamp = date('YmdHis');
                        $json = '{
                                "AuthDetails": [{
                                        "UserID": "' . $userid . '",
                                        "Token": "' . $token . '",
                                        "Timestamp": "' . $stamp . '"
                                }],
                                "MessageType": ["2"],
                                "BatchType": ["0"],
                                "SourceAddr": ["' . $from . '"],
                                "MessagePayload": [
                                {
                                          "Text":"' . $message . '"  
                                }],
                                "DestinationAddr": [
                                {
                                        "MSISDN": "' . $phone . '",
                                        "LinkID": ""
                                }]
                           }';

                        /*if (!$sock = @fsockopen('www.google.com', 80))
                        {
                                return FALSE;
                        }*/
						
						$by = 1;
						if ($this->ion_auth->logged_in())
                         {
                            $by = $this->ion_auth->get_user()->id;
						 }
						 
                        $parts = array(
                            'source' => $from,
                            'dest' => $phone,
                            'relay' => $message,
                            'created_on' => time(),
                            'created_by' => $by
                        );
                        $this->log_text($parts);
                        $headers = array('Content-Type' => 'application/json');
                        try
                        {
                                $req = $this->req->post($url, $headers, $json);
                        }
                        catch (Exception $exc)
                        {
                                $req = $exc->getMessage();
                        }
                }

                return $req;
        }

        /**
         * Log Text to DB
         * 
         * @param array $data
         * @return int
         */
        function log_text($data)
        {
                return $this->insert_key_data('text_log', $data);
        }

        function count_down()
        {
                $this->select_all_key(lang('script'));
                $row = $this->db->where('id', 1)->get(lang('script'))->row();
                if (!empty($row))
                {
                        $rem = $row->total_count - 1;
                        $bk = array(
                            'total_count' => $rem,
                            'modified_by' => $this->ion_auth->get_user()->id,
                            'modified_on' => time()
                        );
                        $this->update_key_data(1, lang('script'), $bk);
                }
                return TRUE;
        }

        //Get all parents
        function active_parent()
        {
                $this->select_all_key('parents');
                return $this->db->where($this->dx('status') . '=1', NULL, FALSE)
                                          ->order_by('id', 'ASC')
                                          ->get('parents')
                                          ->result();
        }

        function get_active_parents()
        {
                $this->select_all_key('parents');
                $results = $this->db
                             ->where($this->dx('status') . '=1', NULL, FALSE)
                             ->get('parents')
                             ->result();
                $arr = array();

                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->first_name . ' ' . $res->last_name . ' (' . $res->phone . ')';
                }

                return $arr;
        }

        /**
         * Get All Active Staff
         * 
         * @return mixed
         */
        public function get_all_staff()
        {
                $this->select_all_key('users');
                return $this->db->select($this->dx('users_groups.group_id') . ' as gid', FALSE)->where($this->dx('users.active') . '= 1', NULL, FALSE)
                                          ->where($this->dx('users_groups.group_id') . '!= 8', NULL, FALSE)//student
                                          ->where($this->dx('users_groups.group_id') . '!= 6', NULL, FALSE)//parent
                                          ->where($this->dx('users_groups.group_id') . '!= 2', NULL, FALSE)//member
                                          ->join('users_groups', 'users.id=' . $this->dx('user_id'))
                                          ->get('users')
                                          ->result();
        }

        /**
         * Return All Active Users along with Phone No.
         * 
         * @return string
         */
        function get_users_phone()
        {
                $this->select_all_key('users');
                $results = $this->db->where($this->dx('active') . '= 1', NULL, FALSE)
                             ->get('users')
                             ->result();
                $arr = array();

                foreach ($results as $res)
                {
                        if (!empty($res->phone))
                        {
                                $arr[$res->id] = $res->first_name . ' ' . $res->last_name . ' (' . $res->phone . ')';
                        }
                }

                return $arr;
        }

        function get_inbox()
        {
                return $this->db->count_all_results('sms');
        }

        function get_sent()
        {
                return $this->db->where('status', 'sent')->count_all_results('sms');
        }

        function get_draft()
        {
                return $this->db->where('status', 'draft')->count_all_results('sms');
        }

        function get_trash()
        {
                return $this->db->where('status', 'trash')->count_all_results('sms');
        }

        function find($id)
        {
                $query = $this->db->get_where('sms', array('id' => $id));
                return $query->row();
        }

        function exists($id)
        {
                $query = $this->db->get_where('sms', array('id' => $id));
                $result = $query->result();

                if ($result)
                        return TRUE;
                else
                        return FALSE;
        }

        function count()
        {
                return $this->db->count_all_results('sms');
        }

        function count_log()
        {
                return $this->db->count_all_results('text_log');
        }

        function update_attributes($id, $data)
        {
                $this->db->where('id', $id);
                $query = $this->db->update('sms', $data);

                return $query;
        }

        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get($table);
                $dropdowns = $query->result();

                foreach ($dropdowns as $dropdown)
                {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        function delete($id)
        {
                $query = $this->db->delete('sms', array('id' => $id));

                return $query;
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('sms', $limit, $offset);

                $result = array();

                foreach ($query->result() as $row)
                {
                        $result[] = $row;
                }

                if ($result)
                {
                        return $result;
                }
                else
                {
                        return FALSE;
                }
        }

        function paginate_log($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->select_all_key('text_log');
                $this->db->order_by('id', 'desc');

                $query = $this->db->get('text_log', $limit, $offset);

                $result = array();

                foreach ($query->result() as $row)
                {
                        $result[] = $row;
                }

                if ($result)
                {
                        return $result;
                }
                else
                {
                        return FALSE;
                }
        }

}
