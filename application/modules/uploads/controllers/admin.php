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
                $this->load->model('uploads_m');
                $this->load->model('admission/admission_m');
                $this->load->model('parents/parents_m');
                $this->load->model('fee_arrears/fee_arrears_m');
                $this->load->model('teachers/teachers_m');
				 $this->load->model('non_teaching/non_teaching_m');
				 $this->load->model('subordinate/subordinate_m');
				 $this->load->model('emergency_contacts/emergency_contacts_m');
        }
		
		function siblings(){
			
			 $student = $this->input->post('student');
			 $parent = $this->input->post('parent');
			 
			 $data['parents'] = $this->uploads_m->fetch_parent_options();
			 $data['updType'] = 'edit';
			 
			 if($student && $parent){
				 
				 
				 // student details
				 $st = $this->uploads_m->get_student($student);
				 $pt = $this->uploads_m->find_parent($st->parent_id);
				 // print_r($pt );die;
				  
				 //**** Delete assigned parent ***/
				 //$this->uploads_m->delete_assigned_parent($student);
				
				 
				 //Delete parent user and user group
				 if($pt && isset($pt->user_id)){
					 
					  $this->uploads_m->delete_user($pt->user_id);
				      $this->uploads_m->delete_users_group($pt->user_id); 
					  $this->uploads_m->delete_parent($st->parent_id);	
				 }

				  //update student assign parents table
                     
                 $pid = $this->uploads_m->update_pst($student,array('parent_id'=>$parent));
					
				//update student parent id
				
				if($pid){
					
					//print_r($pid);die;
					
					 $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Parent has been successfully assigned"));
					 
					 $this->admission_m->update_attributes($student, array('parent_id' => $parent));
					 
				}else{
					
					 $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry something went wrong"));
				}
				
				redirect('admin/admission/view/'.$student);
				 
			 }
			 
			  //load the view and the layout
              $this->template->title('Add Uploads ')->build('admin/sibling', $data);

			
		}



    function narok_upload()
    {
        $this->load->model('fee_arrears/fee_arrears_m');
        require_once APPPATH . 'libraries/xlsxreader.php';

        $reader = new XLSXReader(FCPATH . 'uploads/new.xlsx');
        $reader->decodeUTF8(true);
        $reader->read();
        $woksh = array();

        $sheets = $reader->getSheets();

        $i = 0;
        foreach ($sheets as $sheet) {
            $i++;
            $data = $reader->getSheetDatas($sheet["id"]);
            $titles = $data[0];
            unset($data[0]);

            foreach ($data as $rid => $row) {
                $nwrow = array();
                foreach ($row as $cid => $cell) {
                    if (!isset($titles[$cid])) {
                        echo '<pre>xx  ';
                        print_r("[{$cid}] not set");
                        print_r($titles);
                        print_r($row);
                        echo '</pre>';
                        die;
                    }
                    $nwrow[$titles[$cid]] = trim($cell);
                }
                foreach ($titles as $tl) {
                    if (!isset($nwrow[$tl])) {
                        $nwrow[$tl] = '';
                    }
                }
                $woksh[] = $nwrow;
            }
            break;
        }

        $skz = 0;

        echo '<pre>';
        print_r($woksh);
        echo '</pre>';
        die;



        $emm = 0;
        $school_mail = "@test.com";
        $prefix = "TEST";
        foreach ($woksh as $srow) {
            $skz++;
            $st = (object) $srow;

            $exists = 0;
            $ex_row = (object) [];
            // $p_phone = explode('/', $st->p_phone);

            $first_name = $st->first_name;
            $middle_name = $st->middle_name;
            $last_name = $st->last_name;

            //  $student = explode(' ',$st->student);
            // $first_name = $student[0];
            // $middle_name = isset($student[1]) ? $student[1] : '';
            // $last_name = isset($student[2]) ? $student[2] : '';


            $p_first = $st->p_first ? $st->p_first : 'Parent';
            $p_middle = $st->p_middle;
            $p_last = $st->p_last ? $st->p_last : 'Parent';
            $p_phone = $st->p_phone;
            $class = $st->class;

            $last_adm = $this->admission_m->get_last_id();
            $number = $last_adm + 1;

            $adno = $st->adm_no ? $st->adm_no : $prefix . str_pad($number, 3, '0', 0);

            // $adno =  $st->admno;

            // if (substr($p_phone[0], 0, 1) != '0')
            // {
            //     $p_phone1 = strlen($p_phone[0]) == 0 ? '' : '0' . $p_phone[0];
            // }

            // if (substr($p_phone[1], 0, 1) != '0')
            // {
            //     $p_phone2 = strlen($p_phone[1]) == 0 ? '' : '0' . $p_phone[1];
            // }

            if (substr($st->p_phone, 0, 1) != '0') {
                $p_phone = strlen($st->p_phone) == 0 ? '' : '0' . $p_phone;
            }

            $p2_phone = $st->p2_phone;
            if (substr($st->p2_phone, 0, 1) != '0') {
                $phone2 = strlen($st->p2_phone) == 0 ? '' : '0' . $p2_phone;
            }

            $phone = $p_phone;

            // echo $phone;die;


            if (empty($phone)) {
                // $phone = empty($st->m_phone) ? FALSE : $st->m_phone;
                $phone = "07";
            }


            $pemail = $st->email;
            $name = strtolower(str_replace(' ', '', $p_first . '.' . $p_last));
            if (empty($pemail)) {
                $pemail = $name . '-' . $skz . $school_mail;

                if ($this->admission_m->user_email_exists($pemail)) {
                    $pemail = $name . '-' . $skz . $school_mail;
                }
                if ($this->admission_m->user_email_exists($pemail)) {
                    echo '<pre>Still exists';
                    print_r($pemail);
                    print_r($srow);
                    $pemail = $name . '-' . $skz . $school_mail;
                    print_r($pemail);
                    echo '</pre>';
                }
            } else {
                $exs_id = $this->admission_m->parent_exists($pemail, $phone);
                if ($exs_id) {
                    $exists = 1;
                    $ex_row = $this->admission_m->get_parent($exs_id);
                }
            }


            //parent exists
            if ($exists) {
                $pid = $ex_row->user_id;
                $ps_id = $ex_row->id;
            } else {
                $ppassword = '12345678'; //temporary password
                $additional = [
                    'first_name' => $p_first,
                    'last_name' => $p_last,
                    'phone' => $phone,
                    'me' => $this->ion_auth->get_user()->id,
                ];
                $pt = explode('@', $pemail);
                $pid = $this->ion_auth->register($pt[0], $ppassword, $pemail, $additional);
            }
            if ($pid) {
                $this->ion_auth->add_to_group(6, $pid);
                /* End Parent Add to Users */

                $pdata = [
                    'first_name' => $p_first,
                    'last_name' => $p_last,
                    'f_middle_name' => $st->p_middle,
                    'email' => $pemail,
                    'identity' => '',
                    'f_relation' => '',
                    'f_id' => $st->p2_first,
                    'm_id' => $st->p2_first,
                    'mother_fname' => $st->p2_first,
                    'mother_lname' => $st->p2_last,
                    'm_middle_name' => $st->p2_middle,
                    'mother_email' => $st->p2_email,
                    'mother_phone' => $st->p2_phone,
                    'status' => 1,
                    'user_id' => $pid,
                    'phone' => $phone,
                    'phone2' => '',
                    'address' => '',
                    'created_on' => time(),
                    'created_by' => $this->ion_auth->get_user()->id,
                    'occupation' => '',
                    'mother_occupation' => $st->mother_occupation,

                ];

                $ps_id = $exists ? $ex_row->id : $this->admission_m->save_parent($pdata); //parent id
            } else {
                echo '<pre>';
                print_r($pemail);
                print_r($srow);
                echo '</pre>';
                die('no pid');
            }

            /* Create Student User */
            // $student = explode(' ',$st->student);
            // $first_name = $student[0];
            // $middle_name = isset($student[1]) ? $student[1] : '';
            // $last_name = isset($student[2]) ? $student[2] : '';

            $username = strtolower(str_replace(' ', '', $first_name . '.' . $last_name));
            $email = $username . '-' . $adno . $school_mail;
            $password = '12345678'; //temporary password

            $additional_data = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'me' => $this->ion_auth->get_user()->id,
            ];
            if ($this->admission_m->user_email_exists($email)) {
                $email = $username . $adno . $school_mail;
            }
            $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);


            $gender = 1;

            if ($st->gender == "F" || $st->gender == "Female" || $st->gender == "f" || $st->gender == "female" || $st->gender == "FEMALE") {
                $gender = 2;
            }

            $timestamp = $this->from_excel($st->dob);
            $doa = $st->admission_date ? $this->from_excel($st->admission_date) : '';
            $dbb = $st->dob ? $this->from_excel($st->dob) : '';
            $sdata = [
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'house' => '',
                'boarding_day' => '',
                'email' => $email,
                'user_id' => $u_id,
                'parent_id' => $ps_id,
                'parent_user' => $pid,
                'gender' => $gender,
                'status' => 1,
                'dob' => $dobb,
                'admission_date' => $doa,
                'admission_number' => $adno,
                'class' => $st->class,
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id,
                'scholarship_type' => '',
                'upi_number' => '',
                'residence' => $st->residence,
                'allergies' => $st->allergies
            ];



            $rec = $this->admission_m->create($sdata); //student admission id


            $ec = array(
                    'parent_id' => $ps_id,
                    'student' => $rec,
                    'name' => $st->name,
                    'middle_name' => $st->contact_m_name,
                    'last_name' => $st->contact_l_name,
                    'relation' => $st->contact_relation,
                    'phone' => $st->contact_phone,
                    'email' => $st->contact_email,
                    'provided_by' => '',
                    'id_no' => '',
                    'address' => '',
                    'created_by' => $this->ion_auth->get_user()->id,
                    'created_on' => time()
                );

            $this->admission_m->insert_emergency_contacts($ec);

            /*if($rec && $st->balance !=0)
            {

                $bal = [
                    'student' => $rec,
                    'amount' => $st->balance,
                    'term' => 2,
                    'year' => 2022,
                    'created_by' => $user->id,
                    'created_on' => time()
                ];

                $this->fee_arrears_m->create($bal);
            }
            */

            if (!$rec) {
                echo '<pre>';
                print_r('norec -------------------');
                print_r($st);
                echo '</pre>';
                return FALSE;
            } else {
                /** Put in History - run admin/sync after importing data** */
                //assign parent
                $fss = array(
                    'parent_id' => $ps_id,
                    'student_id' => $rec,
                    'status' => 1,
                    'created_on' => time(),
                    'created_by' => $this->ion_auth->get_user()->id
                );
                $this->admission_m->assign_parent($fss);
                //add to students group
                $this->ion_auth->add_to_group(8, $u_id);
            }
        }

        echo '<pre>';
        echo '<br>';
        print_r('Done ' . $skz);
        echo '</pre>';
    }		
			    
        
        //Upload Student			
        function upload_student_det()
        {
                $class = $this->input->post('class');
             
                if (empty($class))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
                      
                       $name = $fileop[0];

                       $data = explode(' ',$name);
                       		   
					   $fname = strtoupper($data[0]);
					   $lname = '';		
					   if(!empty($data[1])){
						    $lname =  strtoupper($data[1]);
					   }
					  
					   $mname = '';
						
						if(!empty($data[2])){
							$lname =  strtoupper($data[2]);
							$mname =  strtoupper($data[1]);
						}
						
						//**** Parent 1
               
					   $father_name = $fileop[1];
					   $dat = explode(' ',$father_name);
						
					   $f_fname = strtoupper($dat[0]);
					   $f_lname = '';	
					   
					   if(!empty($dat[1])){
						   
						    $f_lname =  strtoupper($dat[1]);
					   }

						if(!empty($dat[2])){
							
							$f_lname =  strtoupper($dat[2]).' '.strtoupper($dat[1]);
						
						}
						
						$fphone = $fileop[2];
						
						//**** Parent 1
               
					   $mother_name = $fileop[3];
					   $da = explode(' ',$mother_name);
					   
					    $m_fname = '';	
					    $m_lname = '';	
						 
					   if(isset($da)){
						
							   $m_fname = strtoupper($da[0]);
							 
							   
							   if(!empty($da[1])){
								   
									$m_lname =  strtoupper($da[1]);
							   }

							   if(!empty($da[2])){
									
									$m_lname =  strtoupper($da[2]).' '.strtoupper($da[1]);
								
								}
					   }
						$mphone = $fileop[4];
						$do = $fileop[5];
						
						$dd = explode('/',$do);
						$d = $dd[0];
						$m = $dd[1];
						$y = $dd[2];
						
						$dob = $m.'/'.$d.'/'.$y;



                //******** Check Email Address ***************
				
                        $username = strtolower($f_fname);
                        $pemail =  strtolower($f_fname).'-' . $i . '@neemaschool.business.site';
                        
                        $password = $this->random_numbers(8); //temporary password - will require to be changed on first login

                     //******** Start Posting ***************//
                        $additional_data = array(
                            'first_name' => $f_fname,
                            'last_name' => $f_lname,
                            'phone' => $fphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
						
                        $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

                        $this->ion_auth->add_to_group(6, $puid);
                        /* Create Parent Record */

                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $f_fname,
                            'last_name' => $f_lname,
                            'email' => $pemail,
                            'phone' => $fphone,
							'mother_fname' => $m_fname,
                            'mother_lname' => $m_lname,
                            'mother_phone' => $mphone,
							
							
                            'status' => 1,
                            'user_id' => $puid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $pid = $this->admission_m->save_parent($form_data);

                        /* Create Student User */
                        $username = strtolower($fname);
                        $semail = trim(strtolower($fname)). '-' . $admission_number . '@neemaschool.business.site';

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => $fphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
                            'middle_name' => $mname,
                            'last_name' => $lname,
                            'email' => $semail,
                            'user_id' => $u_id,
                            'dob' => strtotime($dob),
                            'parent_id' => $pid,
                            'status' => 1,
                            'phone' => $fphone,
                            'class' => $class,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);
						
						 //Update student ADM No.
                        $last_adm = $this->admission_m->get_last_id();
                        $number = $last_adm + 1;
                        $adno = $this->adm_prefix . '/' . str_pad($ok, 3, '0', 0);
                        //$adno = 'NJS/'.$admission_number;

                        $this->admission_m->update_attributes($ok, array('admission_number' => $adno));
						
						
						 /** Put in History ** */
						 $scls = $this->admission_m->get_my_class($class);
                                $hiss = array(
                                    'student' => $ok,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
								
                          $this->admission_m->put_history($hiss);

                //Insert student assign parents table
                        $assg = array(
                            'student_id' => $ok,
                            'status' => 1,
                            'parent_id' => $pid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->uploads_m->assign_parent($assg);

               
                }

                if ($ok)
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/admission/');
        }

		//Upload Student			
        function upload_studs()
        {
                $class = $this->input->post('class');
             
                if (empty($class))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
						
						 //Update student ADM No.
						  $last_adm = $this->admission_m->get_last_id();
						 if($last_adm){ 
							$number = $last_adm + 1;
						 }
                       
                      
                       $class_ = $class;
                       $name = $fileop[0];
                       $gender = $fileop[1];
                       $arrears = $fileop[2];

                       $data = explode(' ',$name);
                       		   
					   $fname = strtoupper($data[0]);

					   $lname = '';		
					   if(!empty($data[1])){
						    $lname =  strtoupper($data[1]);
					   }
					  
					   $mname = '';
						
						if(!empty($data[2])){
							$lname =  strtoupper($data[2]);
							$mname =  strtoupper($data[1]);
						}
						
						if(!empty($data[3])){
							$lname =  strtoupper($data[2]).' '.strtoupper($data[3]);
							$mname =  strtoupper($data[1]);
						}
						
						
						if($gender =='M'){
							$gender = '1';
						}else{
							$gender = '2';
						}

						$pfname = 'Guardian';
						$plname = '';
						$pphone = '07';
						
						//print_r($class_.'-'.  $fname );die;

                //******** Check Email Address ***************
				
                        $username = strtolower($pfname);
                        $pemail =  'guardian.' . $number . '@milikischool.sc.ke';
                        
                        $password = $this->random_numbers(8); //temporary password - will require to be changed on first login

                     //******** Start Posting ***************//
                        $additional_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'phone' => $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
						
                        $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

                        $this->ion_auth->add_to_group(6, $puid);
                        /* Create Parent Record */

                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'email' => $pemail,
                            'phone' => $pphone,
                            'status' => 1,
                            'user_id' => $puid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $pid = $this->admission_m->save_parent($form_data);

                        /* Create Student User */
						
						
						
                        $username = strtolower($fname);
                        $semail = trim(strtolower($fname)). '.' . strtolower($this->adm_prefix).''.$number.'@ruirupeak.sc.ke';

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
                            'middle_name' => $mname,
                            'last_name' => $lname,
                            'email' => $semail,
                            'gender' => $gender,
                            'boarding_day' => 'day',
                            'user_id' => $u_id,
                            'parent_id' => $pid,
                            'status' => 1,
                            'phone' => $pphone,
                            'class' => $class_,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);
						
						
						/**** Update Admission Number ***/
                        $adno = $this->adm_prefix . '-' . str_pad($ok, 3, '0', 0);
                        $this->admission_m->update_attributes($ok, array('admission_number' => $adno));
						
						
						 /** Put in History ** */
						 $scls = $this->admission_m->get_my_class($class);
                                $hiss = array(
                                    'student' => $ok,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
								
                          $this->admission_m->put_history($hiss);

                //Insert student assign parents table
                        $assg = array(
                            'student_id' => $ok,
                            'status' => 1,
                            'parent_id' => $pid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->uploads_m->assign_parent($assg);
						
					//*** Insert Fee Arrears  ***//
						 if(!empty($arrears) && $arrears !=0){
							  $form_data = array(
											'student' => $ok,
											'amount' => $arrears,
											'term' => 2,
											'year' => date('Y'),
											'created_by' => $this->ion_auth->get_user()->id,
											'created_on' => time()
										);

									  $this->fee_arrears_m->create($form_data);
									  $done =   $this->worker->calc_balance($ok);
						 }					
								

               
                }

                if ($ok)
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/admission/');
        }
		
		
		//Upload Student			
        function upload_names()
        {
                $class = $this->input->post('class');
             
                if (empty($class))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
						
						 //Update student ADM No.
						  $last_adm = $this->admission_m->get_last_id();
						 if($last_adm){ 
							$number = $last_adm + 1;
						 }
                       
                      
                       $class_ = $class;
                       $name = $fileop[0];

                       $data = explode(' ',$name);
                       		   
					   $fname = strtoupper($data[0]);

					   $lname = '';		
					   if(!empty($data[1])){
						    $lname =  strtoupper($data[1]);
					   }
					  
					   $mname = '';
						
						if(!empty($data[2])){
							$lname =  strtoupper($data[2]);
							$mname =  strtoupper($data[1]);
						}
						
						if(!empty($data[3])){
							$lname =  strtoupper($data[2]).' '.strtoupper($data[3]);
							$mname =  strtoupper($data[1]);
						}
						

						$pfname = 'Guardian';
						$plname = '';
						$pphone = '07';
						
						//print_r($class_.'-'.  $fname );die;

                //******** Check Email Address ***************
				
                        $username = strtolower($pfname);
                        $pemail =  'guardian.' . $number . '@uwezoelite.sc.ke';
                        
                        $password = $this->random_numbers(8); //temporary password - will require to be changed on first login

                     //******** Start Posting ***************//
                        $additional_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'phone' => $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
						
                        $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

                        $this->ion_auth->add_to_group(6, $puid);
                        /* Create Parent Record */

                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'email' => $pemail,
                            'phone' => $pphone,
                            'status' => 1,
                            'user_id' => $puid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $pid = $this->admission_m->save_parent($form_data);

                        /* Create Student User */
						
						
						
                        $username = strtolower($fname);
                        $semail = trim(strtolower($fname)). '.' . strtolower($this->adm_prefix).''.$number.'@uwezoelite.sc.ke';

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
                            'middle_name' => $mname,
                            'last_name' => $lname,
                            'email' => $semail,
                            'boarding_day' => 'day',
                            'user_id' => $u_id,
                            'parent_id' => $pid,
                            'status' => 1,
                            'phone' => $pphone,
                            'class' => $class_,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);
						
						
						/**** Update Admission Number ***/
                        $adno = $this->adm_prefix . '-' . str_pad($ok, 3, '0', 0);
                        $this->admission_m->update_attributes($ok, array('admission_number' => $adno));
						
						
						 /** Put in History ** */
						 $scls = $this->admission_m->get_my_class($class);
                                $hiss = array(
                                    'student' => $ok,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
								
                          $this->admission_m->put_history($hiss);

                //Insert student assign parents table
                        $assg = array(
                            'student_id' => $ok,
                            'status' => 1,
                            'parent_id' => $pid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->uploads_m->assign_parent($assg);
						
					//*** Insert Fee Arrears  ***//
									

                }

                if ($ok)
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/admission/');
        }

		//Upload Student			
        function upload_stud_lis()
        {
                $class = $this->input->post('class');
             
                if (empty($class))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
						$number  = 1;
						 $last_adm = $this->admission_m->get_last_id();
						 if($last_adm){ 
							$number = $last_adm + 1;
						 }
                      
                       $admission_number = $fileop[0];
                       $fname = strtoupper($fileop[1]);
                       $lname = strtoupper($fileop[2]);
                       $gender = strtolower($fileop[3]);
                       $dob = trim($fileop[4]);
					   $admission_date = trim($fileop[5]);
					   $arrears = $fileop[6];
						 
                       $residence = $fileop[7];
                       $allergies = $fileop[8];
                       $doctor_name = strtoupper($fileop[9]);
                       $doctor_tel = $fileop[10];
					   
                       $pfname =  strtoupper($fileop[11]);
                       $pmname =  strtoupper($fileop[12]);
                       $plname =  strtoupper($fileop[13]) ;
                       $pemail = strtolower($fileop[14]);
                       $pphone = $fileop[15];
                       $pfaddress = $fileop[16];
					   
                       $mfname =  strtoupper($fileop[17]);
                       $mmname =  strtoupper($fileop[18]);
                       $mlname =  strtoupper($fileop[19]);
                       $memail = strtolower($fileop[20]);
                       $mphone = $fileop[21];
					   
					   if($gender =='male'){
							$gender = '1';
						}else{
							$gender = '2';
						}
						
						$lname = explode(' ',$lname);
						$mname = '';
						if(!empty($lname[1])){
							
							$mname = $lname[0];
							$lname = $lname[1];
						}else{
							$lname = $lname[0];
						}
						

						$dob = explode('/',$dob);
					
						if(!empty($dob)  && isset($dob)){
							
							$d = $dob[0];
							$m = $dob[1];
							$y = $dob[2];
							
							$dob = $m.'/'.$d.'/'.$y;
						}
							$admission_date = explode('/',$admission_date);
						
						if(!empty($admission_date) && isset($admission_date)){
							
							$d = $admission_date[0];
							$m = $admission_date[1];
							$y = $admission_date[2];
							
							$admission_date = $m.'/'.$d.'/'.$y;
							
						}else{
							$admission_date  = '';
						}
						
						$pphone  = explode('/',$pphone );
						
						$pphone = (int)$pphone[0];
						
						if(!empty($pphone[1])){
							
							$pfaddress = $pphone[1];
							
						}

                     //**** Guardian Details ***//

                      
						$username = strtolower($pfname);
						
						if(empty($pemail) && !filter_var($pemail, FILTER_VALIDATE_EMAIL)){
							
							$pemail =  strtolower($pfname).'.' . $number . '@umojapagsch.sc.ke';
							
						}

                        $password = $this->random(8); //temporary password - will require to be changed on first login

                     //******** Start Posting ***************//
                        $additional_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'phone' => '0'.$pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
						
                        $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

                        $this->ion_auth->add_to_group(6, $puid);
                        /* Create Parent Record */

                        $user = $this->ion_auth->get_user();
						
                        $form_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname.' '.$pmname,
                            'email' => $pemail,
							
                            'f_relation' => 'father',
                            'phone' => '0'.$pphone,
                            'address' => $pfaddress,
                            'status' => 1,
                            'user_id' => $puid,
							 
							'mother_fname' => $mfname,
							'mother_lname' => $mlname.' '.$mmname,
							'mother_email' => $memail,
							'mother_phone' => '0'.$mphone,
							'm_relation' => 'mother',
							
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $pid = $this->admission_m->save_parent($form_data);

                        /** Create Student User **/
						
                        $username = strtolower($fname);
                        $semail = trim(strtolower($fname)). '-' . $number . '@umojapagsch.sc.ke';
                        $password = $this->random(8); //temporary password - will require to be changed on first login

                        $additional_data = array(
						
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => '0'.$pphone,
                            'me' => $this->ion_auth->get_user()->id,
							
                        );
                        $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */

                        $user = $this->ion_auth->get_user();
						
                        $form_data = array(
                            'first_name' => $fname,
                            'middle_name' => $mname,
                            'last_name' => $lname,
                            'email' => $semail,
                            'user_id' => $u_id,
                            //'admission_number' => $admission_number,
                            'residence' => $residence,
                            'allergies' => $allergies,
                            'doctor_name' => $doctor_name,
                            'doctor_phone' => $doctor_tel,
                            'admission_date' => strtotime($admission_date),
                            'dob' => strtotime($dob),
                            'gender' => $gender,
                            'student_status' => 'Both Parents Alive',
                            'boarding_day' => 'day',
                            'parent_id' => $pid,
                            'status' => 1,
                            'phone' => '0'.$pphone,
                            'class' => $class,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);
						
						 
                        $adno = $this->adm_prefix . '/' . str_pad($ok, 3, '0', 0);
                        $this->admission_m->update_attributes($ok, array('admission_number' => $adno));
						
						
						 /** Put in History ** */
						 $scls = $this->admission_m->get_my_class($class);
                                $hiss = array(
                                    'student' => $ok,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
								
                          $this->admission_m->put_history($hiss);

                //Insert student assign parents table
                        $assg = array(
                            'student_id' => $ok,
                            'status' => 1,
                            'parent_id' => $pid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->uploads_m->assign_parent($assg);

               
                }

                if ($ok)
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/admission/');
        }
		
		
		
	//Upload Student			
    function upload_balances()
        {
               

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
                      
                       $adm_no = $fileop[0];
                       $arrears = $fileop[1];

                      
                //Update Arrears
              
						if ($arrears > 0)
                        {
							   
					$get_stud = $this->admission_m->get_by_adm_no($adm_no);
					
					//print_r($get_stud->id);die;
					
                                $form_data = array(
                                    'student' => $get_stud->id,
                                    'amount' => $arrears,
                                    'term' => 2,
                                    'year' => date('Y'),
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time()
                                );

                                $this->fee_arrears_m->create($form_data);
                              $ok =   $this->worker->calc_balance($get_stud->id);
                        }
                }

                if ($ok)
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/fee_payment/paid');
        }


		//Upload Student			
        function upload_students_data()
        {
                $class = $this->input->post('class');
             
                if (empty($class))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
						$number = 0;
						$last_adm = $this->admission_m->get_last_id();
						
						 if($last_adm){ 
							$number = $last_adm + 1;
						 }
                      
                      $name = $fileop[0];
					  $data = explode(' ',$name);
                       		   
					   $fname = strtoupper($data[0]);

					   $lname = '';		
					   if(!empty($data[1])){
						    $lname =  strtoupper($data[1]);
					   }
					  
					   $mname = '';
						
						if(!empty($data[2])){
							$lname =  strtoupper($data[2]);
							$mname =  strtoupper($data[1]);
						}
						
						if(!empty($data[3])){
							$lname =  strtoupper($data[2]).' '.strtoupper($data[3]);
							$mname =  strtoupper($data[1]);
						}

						$admission_number = $fileop[1];
						$student_number = $fileop[2];
						
						$emergency_name = $fileop[3];
						$emergency_phone = $fileop[4];

                        //**** Father Details ***//

                       $pdata = explode(' ',$fileop[5]);
					   
					   $pfname = strtoupper($pdata[0]);
					   $plname = '';
					   
                        if(!empty($pdata[1])){
							$plname =  strtoupper($pdata[1]);
						}

						if(!empty($pdata[2])){
							$plname =  strtoupper($pdata[1]).' '.strtoupper($pdata[2]);
						}

                        $pphone = $fileop[6];
                       
                 //******************* Mother Details ***//
						
                       $mdata = explode(' ',$fileop[7]);
					   
					   $mfname = strtoupper($mdata[0]);
					   $mlname = '';
					   
						if(!empty($mdata[1])){
							
							$mlname =  strtoupper($mdata[1]);
							
						}
						if(!empty($mdata[2])){
							
							$mlname =  strtoupper($mdata[1]).' '.strtoupper($mdata[2]);
							
						}
                        $mphone = $fileop[8];
                     
                  //******** Check Email Address ***************//
				
				    $arrears = $fileop[9];
				
					$username = strtolower($pfname);
				   
					$pemail = trim(strtolower($pfname)). '.' . $number . '@srehoboth.sc.ke';
				   

					$password ='@'.$this->random(8); //temporary password - will require to be changed on first login

                 //******** Start Posting ***************//
                        $additional_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'phone' => '0' . $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

                        $this->ion_auth->add_to_group(6, $puid);
                        /* Create Parent Record */

                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'email' => $pemail,
                            'mother_fname' => $mfname,
                            'mother_lname' => $mlname,
                            'phone' => '0' . $pphone,
                            'mother_phone' => '0' . $mphone,
                            'status' => 1,
                            'user_id' => $puid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $pid = $this->admission_m->save_parent($form_data);

                        /* Create Student User */
                        $username = strtolower($fname);
                        $semail = trim(strtolower($fname)).'-' . strtolower($admission_number) . '@srehoboth.sc.ke';
                        $password = '@12345678!'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => '0' . $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
                            'middle_name' => $mname,
                            'last_name' => $lname,
                            'email' => $semail,
                            'student_phone' => '0' . $student_phone,
                            'user_id' => $u_id,
                            'old_adm_no' => $admission_number,
                            'admission_number' => $admission_number,
                            'parent_id' => $pid,
                            'status' => 1,
                            'phone' => '0' . $pphone,
                            'class' => $class,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);
						
						
						 /** Emergency Contacts** */
						
                                $emg = array(
                                    'student' => $ok,
                                    'parent_id' => $pid,
                                    'name' => strtoupper($emergency_name),
                                    'phone' => $emergency_phone,
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
								
                            $this->emergency_contacts_m->create($emg);

								/** Put in History ** */
						 $scls = $this->admission_m->get_my_class($class);
                                $hiss = array(
                                    'student' => $ok,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->admission_m->put_history($hiss);

                //Insert student assign parents table
                        $assg = array(
                            'student_id' => $ok,
                            'status' => 1,
                            'parent_id' => $pid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->uploads_m->assign_parent($assg);

                //Update Arrears
              
						if ($arrears > 0)
                        {

                                $form_data = array(
                                    'student' => $ok,
                                    'amount' => $arrears,
                                    'term' => 2,
                                    'year' => '2021',
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time()
                                );

                                $this->fee_arrears_m->create($form_data);
                                $this->worker->calc_balance($ok);
                        }
                }

                if ($ok)
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/admission/');
        }

		
		//Upload Student			
        function upload_students_details()
        {
                $class = $this->input->post('class');
             
                if (empty($class))
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
                      
                       $name = $fileop[0];

                       $data = explode(' ',$name);	
					   $fname = strtoupper($data[0]);
					   $mname =  strtoupper($data[1]);
						
						if(!empty($data[2])){
							$lname =  strtoupper($data[2]);
						}
                        
						
                        $gender = $fileop[1];
						$admission_date =  strtotime($fileop[2]);
						if(empty($admission_date)){
							$admission_date = '1/1/2021';
						}
						
                        $dob = strtotime($fileop[3]);
						if(empty($dob)){
							$dob = '';
						}
						$admission_number = $fileop[4];
						$former_school = $fileop[5];
                  
                        $arrears = 0;

                        //**** Father Details ***//

                       $pdata = explode(' ',$fileop[6]);
					   
					   $pfname = strtoupper($pdata[0]);
					   $plname =  strtoupper($pdata[1]);
					   
                        if(!empty($pdata[2])){
							$plname =  strtoupper($pdata[2]);
						}

                        $pphone = $fileop[7];
                        $f_relation = $fileop[8];
						$pemail = strtolower($fileop[12]);

              //******************* Mother Details ***//
						
                       $mdata = explode(' ',$fileop[9]);
					   
					   $mfname = strtoupper($mdata[0]);
					   $mlname =  strtoupper($mdata[1]);
					   
						if(!empty($mdata[2])){
							$mlname =  strtoupper($mdata[2]);
						}
						
						 
                        $memail = strtolower($fileop[12]);
						$m_relation = $fileop[10];
                        $mphone = $fileop[11];
                     
                //******** Check Email Address ***************//
				
                        $username = strtolower($pfname);
                        if (empty($pemail) || $pemail == 'N/A')
                        {
                            $pemail = trim(strtolower($pfname)) . '.' . trim(strtolower($last)) . '.' . $i . '@acadelite.sc.ke';
                        }

                        $password = '12345678'; //temporary password - will require to be changed on first login

                 //******** Start Posting ***************//
                        $additional_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'phone' => '0' . $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

                        $this->ion_auth->add_to_group(6, $puid);
                        /* Create Parent Record */

                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $pfname,
                            'last_name' => $plname,
                            'email' => $pemail,
                            'mother_fname' => $mfname,
                            'mother_lname' => $mlname,
                            'f_relation' => $f_relation,
                            'm_relation' => $m_relation,
                            'phone' => '0' . $pphone,
                            'mother_phone' => '0' . $mphone,
                            'address' => ' ',
                            'mother_address' => '',
                            'status' => 1,
                            'user_id' => $puid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $pid = $this->admission_m->save_parent($form_data);

                        /* Create Student User */
                        $username = strtolower($fname);
                        $semail = trim(strtolower($fname)) . '.' . trim(strtolower($mname)) . '-' . $i . '@acadelite.sc.ke';
                        $password = '12345678'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => '0' . $pphone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

                        $this->ion_auth->add_to_group(8, $u_id);
                        /* Create Student User */


                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
                            'middle_name' => $mname,
                            'last_name' => $lname,
                            'gender' => $gender,
                            'email' => $semail,
                            'dob' => $dob,
                            'former_school' => $former_school,
							
							
                            'user_id' => $u_id,
                            'old_adm_no' => $admission_number,
                            'parent_id' => $pid,
                            'status' => 1,
                            'phone' => '0' . $pphone,
                            'admission_date' => $admission_date,
                            'class' => $class,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $ok = $this->admission_m->create($form_data);
						
						
						 /** Put in History ** */
						 $scls = $this->admission_m->get_my_class($class);
                                $hiss = array(
                                    'student' => $ok,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->admission_m->put_history($hiss);

                //Insert student assign parents table
                        $assg = array(
                            'student_id' => $ok,
                            'status' => 1,
                            'parent_id' => $pid,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $this->uploads_m->assign_parent($assg);

                //Update student ADM No.
                        $last_adm = $this->admission_m->get_last_id();
                        $number = $last_adm + 1;
                        //$adno = $this->adm_prefix . '-' . str_pad($ok, 3, '0', 0);
                        $adno = 'AIS/'.$admission_number;

                        $this->admission_m->update_attributes($ok, array('admission_number' => $adno));

                //Update Arrears
              
						if ($arrears > 0)
                        {

                                $form_data = array(
                                    'student' => $ok,
                                    'amount' => $arrears,
                                    'term' => 1,
                                    'year' => date('Y'),
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time()
                                );

                                $this->fee_arrears_m->create($form_data);
                                $this->worker->calc_balance($ok);
                        }
                }

                if ($ok)
                {


                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/admission/');
        }

		

        //Upload Student			
        function upload_students_only()
        {

                $class = $this->input->post('class');
                //$campus = $this->input->post('campus_id');

                // if (empty($campus))
                // {

                //         $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Campus before upload. Kindly Try Again."));
                //         redirect('admin/uploads');
                // }
                if (empty($class))
                {

                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry You must select Class before upload. Kindly Try Again."));
                        redirect('admin/uploads');
                }

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");


            $pphone = $fileop[3];
            $f_relation = 'Father';
            $pemail = strtolower($fileop[6]);

            //******************* Mother Details ***//

            $mdata = explode(' ', $fileop[4]);

            $mfname = strtoupper($mdata[0]);
            $mlname = strtoupper($mdata[1]);

            if (!empty($mdata[2]))
            {

                $mlname = strtoupper($mdata[1]) . ' ' . strtoupper($mdata[2]);
            }


            $memail = strtolower($fileop[6]);
            $m_relation = 'Mother';
            $mphone = $fileop[5];

            //******** Check Email Address ***************//

            $username = strtolower($pfname);
            if (empty($pemail))
            {
                $pemail = trim(strtolower($pfname)) . '.' . $i . '@depaul-austin.academy';
            }

            $password = '12345678'; //temporary password - will require to be changed on first login
            //******** Start Posting ***************//
            $additional_data = array(
                'first_name' => $pfname,
                'last_name' => $plname,
                'phone' => $pphone,
                'me' => $this->ion_auth->get_user()->id,
            );

            $puid = $this->ion_auth->register($username, $password, $pemail, $additional_data);

            $this->ion_auth->add_to_group(6, $puid);
            /* Create Parent Record */

            $user = $this->ion_auth->get_user();
            $form_data = array(
                'first_name' => $pfname,
                'last_name' => $plname,
                'email' => $pemail,
                'mother_fname' => $mfname,
                'mother_lname' => $mlname,
                'f_relation' => $f_relation,
                'm_relation' => $m_relation,
                'phone' => $pphone,
                'mother_phone' => $mphone,
                'status' => 1,
                'user_id' => $puid,
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id
            );

            $pid = $this->admission_m->save_parent($form_data);

            /* Create Student User */
            $username = strtolower($fname);
            $semail = trim(strtolower($fname)) . '-' . $i . '@depaul-austin.academy';
            $password = '12345678'; //temporary password - will require to be changed on first login

            $additional_data = array(
                'first_name' => $fname,
                'last_name' => $lname,
                'phone' => $pphone,
                'me' => $this->ion_auth->get_user()->id,
            );
            $u_id = $this->ion_auth->register($username, $password, $semail, $additional_data);

            $this->ion_auth->add_to_group(8, $u_id);
            /* Create Student User */


            $user = $this->ion_auth->get_user();
            $form_data = array(
                'first_name' => $fname,
                'middle_name' => $mname,
                'last_name' => $lname,
                'email' => $semail,
                'user_id' => $u_id,
                'admission_number' => $admission_number,
                'parent_id' => $pid,
                'status' => 1,
                'phone' => $pphone,
                'class' => $class,
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id
            );

            $ok = $this->admission_m->create($form_data);

            /** Put in History ** */
            $scls = $this->admission_m->get_my_class($class);
            $hiss = array(
                'student' => $ok,
                'class' => $scls->class,
                'stream' => $scls->stream,
                'year' => date('Y'),
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id
            );

            $this->admission_m->put_history($hiss);

            //Insert student assign parents table
            $assg = array(
                'student_id' => $ok,
                'status' => 1,
                'parent_id' => $pid,
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id
            );

            $this->uploads_m->assign_parent($assg);
        }


		
		  function random($length)
			{
				$chars = "267134859";
				$thepassword = '';
				for ($i = 0;$i < $length;$i++)
				{
					$thepassword .= $chars[rand() % (strlen($chars) - 1) ];
				}
				return $thepassword;
			}
	

		//Upload Teaching			
        function upload_teaching()
        {
                $file = $_FILES['csv']['tmp_name'];
				
				$this->load->model('teachers/teachers_m');

                $handler = fopen($file, "r");

                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
	
					   $fname = $fileop[0];
					   $mname = $fileop[1];
					   $lname = $fileop[2];
					   $gender = $fileop[3];
					   $dob = strtotime($fileop[4]);
					   $religion = ucwords($fileop[5]);
					   $marital_status = $fileop[6];
					   $id_no = $fileop[7];
					   $pin = $fileop[8];
					   $contract_type = $fileop[9];
					   $position = $fileop[10];
					   $qualification = $fileop[11];
					   $tsc_no = $fileop[12];
					   $phone = $fileop[13];
					   $phone2 = $fileop[14];
					   $email =  strtolower($fileop[15]);
                        $address = $fileop[16];
                        
						
                        $ref_name = $fileop[17];
                        $ref_phone = $fileop[18];
                        $ref_email = $fileop[19];
						$subjects = $fileop[20];
						
						$tsc = '';
						
						if($fileop[12]){
							
							$tsc = 'Yes';
							
						}
   

                        /* Create Student User */
                        $username = strtolower($fname);
                        $password = '@'.$this->random(8); //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' =>  $phone,
                            'me' => $this->ion_auth->get_user()->id,
                        );
						
                        $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);

                        $this->ion_auth->add_to_group(3, $u_id);

                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'first_name' => $fname,
							'middle_name' => $mname,
							'last_name' => $lname,
							'contract_type' => $contract_type,
							'marital_status' => $marital_status,
							'id_no' => $id_no,
							'status' => 1,
							'department' => 1,
							'qualification' => $qualification,
							'religion' => $religion,
							'position' => $position,
							'date_joined' => '',
							'date_left' => '',
							'dob' => $dob,
							'gender' => $gender,
							'group_id' => '',
							'phone' => $phone,
							'salary_status' => 0,
							'email' => $email,
							'pin' => $pin,
							'address' => $address,
							'additionals' => '',
							'tsc_employee' => $tsc,
							'tsc_number' => $tsc_no,
							'kuppet_member' => '',
							'knut_member' => '',
							'kuppet_number' => '',
							'knut_number' => '',
							'disability' => '',
							'disability_type' => '',
							'phone2' => $phone2,
							'citizenship' => '114',
							'county' => '',
							'id_document' =>'',
							
							'ref_name' => $ref_name,
							'ref_phone' => $ref_phone,
							'ref_email' => $ref_email,
							'ref_address' => '',
							'ref_additionals' => '',
							
							'subjects' => $subjects,
							'user_id' => $u_id,
							'designation' => $position,
							'created_by' => $user->id,
							'created_on' => time()
                        );

                        $ok = $this->teachers_m->create($form_data);
						$this->teachers_m->update_teacher($ok, array('staff_no'=>'JGS/EMP/-'.$ok));

                }

                if ($ok)
                {

                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }


                redirect('admin/teachers/');
        }
		
		
		//Upload Teaching			
        function upload_non_teaching()
        {
                $file = $_FILES['csv']['tmp_name'];
				
				$this->load->model('non_teaching/non_teaching_m');

                $handler = fopen($file, "r");

                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
	
					   $fname = $fileop[0];
					   $mname = $fileop[1];
					   $lname = $fileop[2];
					   $gender = $fileop[3];
					   $dob = strtotime($fileop[4]);
					   $religion = ucwords($fileop[5]);
					   $marital_status = $fileop[6];
					   $id_no = $fileop[7];
					   $pin = $fileop[8];
					   $contract_type = $fileop[9];
					   $position = $fileop[10];
					   $qualification = $fileop[11];
					   $tsc_no = $fileop[12];
					   $phone = $fileop[13];
					   $phone2 = $fileop[14];
					   $email =  strtolower($fileop[15]);
                       $address = $fileop[16];
                        
						
                        $ref_name = $fileop[17];
                        $ref_phone = $fileop[18];
                        $ref_email = $fileop[19];
						$subjects = $fileop[20];
						
                        $user = $this->ion_auth->get_user();
						
                        $form_data = array(
                           
                            'first_name' => $fname,
                            'middle_name' => $mname,
                            'last_name' => $lname,
                            'contract_type' => $contract_type,
                            'marital_status' => $marital_status,
                            'id_no' => $id_no,
                            'status' => 1,
                            'department' => 2,
                            'qualification' => $qualification,
                            'religion' => $religion,
                            'position' => $position,
                            'dob' => $dob,
                            'gender' => $gender,
                            'group_id' =>2,
                            'phone' => $phone,
                            'salary_status' => 0,
                            'email' => $email,
                            'pin' => $pin,
                            'address' => $address,
							'additionals' => $phone2,
							
							'ref_name' => $ref_name,
                            'ref_phone' => $ref_phone ,
                            'ref_email' =>  $ref_email ,
							
							
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->non_teaching_m->create($form_data);
						$this->non_teaching_m->update_attributes($ok, array('staff_no'=>'JGS/EMP/NT/-'.$ok));

                }

                if ($ok)
                {

                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }


                redirect('admin/non_teaching/');

        }
		
		

        function demo()
        {
                die('error');
                $file = FCPATH . 'uploads/upload.csv';
                $handler = fopen($file, "r");

                $i = 0;

                $classes = array(
                    'Play group' => 1,
                    'Baby class' => 2,
                    'Nursery' => 3,
                    'Pre-unit' => 4,
                    'Class one' => 5,
                    'Class two' => 6,
                    'Class three' => 7,
                    'Class four' => 8,
                    'Class five' => 9,
                    'Class six' => 10,
                    'Class seven' => 11,
                    'Class eight' => 12
                );
                $wwcl = array();
                $this->load->model('admission/admission_m');

                // die;
                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;

                        $p1fname = $fileop[8];
                        $p1lname = $fileop[9] . ' ' . $fileop[10];
                        $pemail = $fileop[11];
                        /* Add Parent to  Users */
                        $p_username = strtolower($p1fname . '.' . strtolower($p1lname));
                        if (empty($pemail))
                        {
                                $pemail = $p_username . '@prairieschool.co.ke';
                        }
                        if ($this->admission_m->user_email_exists($pemail))
                        {
                                $pemail = rand(1, 13) . $pemail;
                        }
                        $ppassword = '12345678'; //temporary password - will require to be changed on first login
                        $additional = array(
                            'first_name' => $p1fname,
                            'last_name' => $p1lname,
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $pid = $this->ion_auth->register($p_username, $ppassword, $pemail, $additional);
                        //add to Parents group
                        if ($pid)
                        {
                                $this->ion_auth->add_to_group(6, $pid);

                                /* End Parent Add to Users */
                                $pdata = array(
                                    'first_name' => $p1fname,
                                    'last_name' => $p1lname,
                                    'email' => $pemail,
                                    'mother_fname' => $fileop[14],
                                    'mother_lname' => $fileop[15] . ' ' . $fileop[16],
                                    'mother_email' => $fileop[17],
                                    'mother_phone' => $fileop[18],
                                    'status' => 1,
                                    'user_id' => $pid,
                                    'phone' => $fileop[12],
                                    'address' => $fileop[13],
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );

                                $ps_id = $this->admission_m->save_parent($pdata); //parent id
                        }
                        else
                        {
                                echo '<pre>';
                                print_r($p_username);
                                print_r($ppassword);
                                print_r($pemail);
                                print_r($additional);
                                print_r($fileop);
                                echo '</pre>';
                                die('no pid');
                        }
                        $last_adm = $this->admission_m->get_last_id();
                        $number = $last_adm + 1;

                        $adno = $this->school->prefix . '-' . str_pad($number, 3, '0', 0);
                        /* Create Student User */
                        $username = strtolower($fileop[0]) . '.' . $adno;

                        $email = $username . 'prairieschool.co.ke';
                        $password = '12345678'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fileop[0],
                            'last_name' => $fileop[1] . ' ' . $fileop[2],
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        if ($this->admission_m->user_email_exists($email))
                        {
                                $email = rand(1, 3) . $email;
                        }
                        $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);
                        $cls = isset($classes[$fileop[5]]) ? $classes[$fileop[5]] : 11;
                        $sdata = array(
                            'first_name' => $fileop[0],
                            'last_name' => $fileop[1] . ' ' . $fileop[2],
                            'dob' => empty($fileop[4]) ? 0 : strtotime($fileop[4]),
                            'gender' => $fileop[3],
                            'house' => 0,
                            'allergies' => $fileop[7],
                            'residence' => $fileop[6],
                            'email' => $email,
                            'user_id' => $u_id,
                            'parent_id' => $ps_id,
                            'parent_user' => $pid,
                            'status' => 1,
                            'admission_date' => 0,
                            'class' => $cls,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id
                        );

                        $rec = $this->admission_m->create($sdata); //student admission id
                        if ($cls == 11)
                        {
                                $wwcl[] = $rec;
                        }
                        if (!$rec)
                        {
                                echo '<pre>';
                                print_r('norec-------------------');
                                print_r($fileop);
                                echo '</pre>';
                                return FALSE;
                        }
                        else
                        {
                                //Get Class student was admitted
                                $scls = $this->admission_m->get_my_class($cls);
                                //$this->worker->invoice_student($rec, $scls->class);

                                /** Put in History ** */
                                $hiss = array(
                                    'student' => $rec,
                                    'class' => $scls->class,
                                    'stream' => $scls->stream,
                                    'year' => date('Y'),
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->admission_m->put_history($hiss);

                                //assign parent
                                $fss = array(
                                    'parent_id' => $ps_id,
                                    'student_id' => $rec,
                                    'status' => 1,
                                    'created_on' => time(),
                                    'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->admission_m->assign_parent($fss);
                        }

                        //add to students group
                        $this->ion_auth->add_to_group(8, $u_id);
                        $this->admission_m->update_attributes($rec, array('admission_number' => $adno));
                }
                echo '<pre>';
                print_r($wwcl);
                echo '</pre>';
                die('done');
        }

        function random_pass($length)
        {

                $chars = "123GHJKLMkmnpqNPQRST456789abcdefghijrstuvwxyzABCDEFUVWXYZ";
                $thepassword = '';
                for ($i = 0; $i < $length; $i++)
                {
                        $thepassword .= $chars[rand() % (strlen($chars) - 1)];
                }

        }

		function random_numbers($length)
        {
                $chars = "1234567890";
                $thepassword = '';
                for ($i = 0; $i < $length; $i++)
                {
                        $thepassword .= $chars[rand() % (strlen($chars) - 1)];
                }
                return $thepassword;
        }

        function parent_logins()
        {
                $all_parents = $this->uploads_m->all_parents();

                foreach ($all_parents as $p)
                {

                        $pemail = $this->ion_auth->get_user($p->user_id);
                        $pswd = strtoupper($this->random_pass(8));

                        //print_r($pemail->email.' '.$pswd);die;

                        $additional_data = array(
                            'password' => $pswd,
                            'modified_by' => $this->ion_auth->get_user()->id,
                            'modified_on' => time(),
                        );

                        $ok = $this->ion_auth->update_user($p->user_id, $additional_data);

                        if ($ok)
                        {
                                $form_data = array(
                                    'parent_id' => $p->id,
                                    'name' => $p->first_name . ' ' . $p->last_name,
                                    'phone' => $p->phone,
                                    'username' => $pemail->email,
                                    'password' => $pswd,
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time(),
                                );

                                $this->uploads_m->create_logins($form_data);
                        }
                }
                redirect('admin/parents');
        }

        function parent_user_logins()
        {
                $all_parents = $this->uploads_m->all_parents();
                foreach ($all_parents as $p)
                {
                        $pswd = strtoupper($this->random_pass(8));
                        $mai = strtoupper($this->random_pass(5));

                        //print_r($pemail->email.' '.$pswd);die;
                        $email = $p->email;

                        if ($this->ion_auth->email_check($email))
                        {
                                $email = $mai . '-BBN@pcas.co.ke';

                                //print_r('Exixst..'.$p->email);die;
                        }
                        elseif (empty($email))
                        {
                                $email = $mai . '-BBN@pcas.co.ke';

                                //print_r('Empty...'.$p->email);die;
                        }
                        elseif ($email == 'N/A')
                        {
                                $email = $mai . '-BBN@pcas.co.ke';
                                //print_r('N/A...'.$p->email);die;
                        }
                        else
                        {
                                $email = $p->email;
                        }

                        $additional_data = array(
                            'email' => $email,
                            'password' => $pswd,
                            'modified_by' => $this->ion_auth->get_user()->id,
                            'modified_on' => time(),
                        );

                        $ok = $this->ion_auth->update_user($p->user_id, $additional_data);

                        if ($ok)
                        {
                                $form_data = array(
                                    'parent_id' => $p->id,
                                    'name' => $p->first_name . ' ' . $p->last_name,
                                    'phone' => $p->phone,
                                    'username' => $email,
                                    'password' => $pswd,
                                    'created_by' => $this->ion_auth->get_user()->id,
                                    'created_on' => time(),
                                );

                                $this->uploads_m->create_logins($form_data);
                        }
                }
                redirect('admin/parents');
        }

        function update_parents_students()
        {

                $studs = $this->uploads_m->get_all();
                //print_r($studs);die;

                $user = $this->ion_auth->get_user();
                foreach ($studs as $s)
                {
                        $form_data = array(
                            'parent_id' => $s->parent_id,
                            'student_id' => $s->id,
                            'status' => 1,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->uploads_m->assign_parent($form_data);
                }
        }

        public function send_credentials()
        {
                $settings = $this->ion_auth->settings();
                $parents = $this->uploads_m->get_plogins();

                $count = 0;
                foreach ($parents as $p)
                {
                        $count ++;
                        $skul = $this->ion_auth->settings();

                        $recipient = $p->phone;
                        $country_code = '254';
                        $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                        $to = $p->name;
                        $dat = explode(' ', $to);

                        $message = 'Dear ' . $dat[0] . ', welcome to busy bee school parents portal. Your login credentials are: portal: system.pcas.co.ke username: ' . $p->username . ' password:' . $p->password . ' .Please reset your password after logging in. For any queries contact us at: it@pcas.co.ke or 0720578842';
                        //$this->sms_m->send_sms($recipient, $message);
                }
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Credentials Successfully Sent. </b><span style='color:#fff; '>( Number of Parents Notified " . $count . ')</span>'));

                redirect('admin/sms');
        }

        //Upload Parents
        function upload_parents()
        {

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");

                $i = 0;

                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;

                        $fname = $fileop[0];
                        $mname = $fileop[1];

                        if (empty($mname))
                        {
                                $mname = '';
                        }

                        $lname = $mname . ' ' . $fileop[2];

                        $email = $fileop[3];

                        if (empty($email))
                        {

                                $email = strtolower($fname) . '-' . strtolower($this->adm_prefix) . '@pcas.co.ke';
                        }

                        $phone = $fileop[4];
                        $phone2 = $fileop[5];
                        $address = $fileop[6];
                        $parent_id = $fileop[7];

                        $mom_fname = $fileop[8];
                        $mom_mname = $fileop[9];

                        if (!empty($mom_mname))
                        {
                                $mom_mname = '';
                        }

                        $mom_lname = $mom_mname . ' ' . $fileop[10];

                        $mom_email = $fileop[11];
                        $mom_phone = $fileop[12];
                        $mom_phone2 = $fileop[13];


                        /* Create Student User */
                        $username = strtolower($fname);
                        $password = '12345678'; //temporary password - will require to be changed on first login

                        $additional_data = array(
                            'first_name' => $fname,
                            'last_name' => $lname,
                            'phone' => '0' . $phone,
                            'me' => $this->ion_auth->get_user()->id,
                        );

                        $this->uploads_m->create_logins($form_data);
                }
                redirect('admin/parents');
        }

       public function index()
        {
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
               $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['uploads'] = $this->uploads_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();


                //page number  variable
               $data['page'] = $page;
               $data['per'] = $config['per_page'];
               $data['campus'] = $this->uploads_m->populate('campus', 'id', 'name');


               //load view
               $this->template->title(' Uploads ')->build('admin/list', $data);
         }
        function bb()
        {
            $this->load->model('fee_payment/fee_payment_m');
            require_once APPPATH . 'libraries/xlsxreader.php';
    
            $reader = new XLSXReader(FCPATH . 'uploads/8A.xlsx');
            $reader->decodeUTF8(true);
            $reader->read();
            $woksh = array();
    
            $sheets = $reader->getSheets();
    
            $i = 0;
            foreach ($sheets as $sheet)
            {
                $i++;
                $data = $reader->getSheetDatas($sheet["id"]);
    
                $titles = $data[0];
                unset($data[0]);
    
                foreach ($data as $rid => $row)
                {
                    $nwrow = array();
                    foreach ($row as $cid => $cell)
                    {
                        if (!isset($titles[$cid]))
                        {
                            echo '<pre>xx  ';
                            print_r("[{$cid}] not set");
                            print_r($titles);
                            print_r($row);
                            echo '</pre>';
                            die;
                        }
                        $nwrow[$titles[$cid]] = $cell;
                    }
                    foreach ($titles as $tl)
                    {
                        if (!isset($nwrow[$tl]))
                        {
                            $nwrow[$tl] = '';
                        }
                    }
                    $woksh[] = $nwrow;
                }
                break;
            }
    
      
    
            // echo '<pre>';
            // echo '<br>';
            // print_r( $woksh );
            //  echo '</pre>';
            // die;
            foreach ($woksh as $key => $value) {
                # code...
                $std = (object) $value;
                $student_name= $std->StudentName;
                $std_name = explode (' ', $student_name);

                $first_name= $std_name[0];
                $middle_name= $std_name[1];
                $last_name= $std_name[2];
                $admission_number="AP-".date('y').rand(000,100);
                    $data = array(
                        'admission_number'=>$admission_number,
                        'first_name' => $first_name,
                        'middle_name' => $middle_name,
                        'last_name' => $last_name,
                        'class' => 1,
                        'status' => 1,
                        'created_on' => time(),
                        'created_by' => $this->ion_auth->get_user()->id
                    );
                    // $data= array_filter($data);
                // echo '<pre>';
                // echo '<br>';
                //  print_r($data);
                //  echo '</pre>';
             
                    $ok=$this->uploads_m->create($data); 
            }
               if($ok){
                   echo "<script> alert('success')</script>";
               }else{
                 echo "<script> alert('Failed ')</script>";
               }
            
            // print_r($data);
            echo '</pre>';
            die;
        }
  
    /**
     *  
     * 
     * @return boolean
     */
    function br()
    {
        $this->load->model('fee_payment/fee_payment_m');
        require_once APPPATH . 'libraries/xlsxreader.php';

        $reader = new XLSXReader(FCPATH . 'uploads/emba.xlsx');
        $reader->decodeUTF8(true);
        $reader->read();
        $woksh = array();

        $sheets = $reader->getSheets();

        $i = 0;
        foreach ($sheets as $sheet)
        {
            $i++;
            $data = $reader->getSheetDatas($sheet["id"]);

            $titles = $data[0];
            unset($data[0]);

            foreach ($data as $rid => $row)
            {
                $nwrow = array();
                foreach ($row as $cid => $cell)
                {
                    if (!isset($titles[$cid]))
                    {
                        echo '<pre>xx  ';
                        print_r("[{$cid}] not set");
                        print_r($titles);
                        print_r($row);
                        echo '</pre>';
                        die;
                    }
                    $nwrow[$titles[$cid]] = $cell;
                }
                foreach ($titles as $tl)
                {
                    if (!isset($nwrow[$tl]))
                    {
                        $nwrow[$tl] = '';
                    }
                }
                $woksh[] = $nwrow;
            }
            break;
        }

        $skz = 0;

        foreach ($woksh as $srow)
        {
            $skz++;
            $st = (object) $srow;

            $pemail = 'p-' . rand(5, 90000) . '@embakasigarrisonsec.sc.ke';

            if ($this->admission_m->user_email_exists($pemail))
            {
                $pemail = 'p-' . rand(5, 90000) . '@embakasigarrisonsec.sc.ke';
            }
            if ($this->admission_m->user_email_exists($pemail))
            {
                echo '<pre>Still exists';
                print_r($pemail);
                print_r($srow);
                $pemail = 'p-' . rand(5, 90000) . '@embakasigarrisonsec.sc.ke';
                print_r($pemail);
                echo '</pre>';
            }

            $ppassword = '12345678'; //temporary password
            $additional = array(
                'first_name' => 'Parent ',
                'last_name' => ' ',
                'phone' => $st->phone ? $st->phone : '0770',
                'me' => $this->ion_auth->get_user()->id,
            );
            $pid = $this->ion_auth->register(str_replace('@embakasigarrisonsec.sc.ke', '', $pemail), $ppassword, $pemail, $additional);
            if ($pid)
            {
                $this->ion_auth->add_to_group(6, $pid);
                /* End Parent Add to Users */

                $pdata = array(
                    'first_name' => 'Parent',
                    'last_name' => '',
                    'email' => $pemail,
                    'mother_fname' => '',
                    'mother_lname' => '',
                    'mother_email' => '',
                    'mother_phone' => '',
                    'status' => 1,
                    'user_id' => $pid,
                    'phone' => $st->phone ? $st->phone : '0770',
                    'address' => '',
                    'created_on' => time(),
                    'created_by' => $this->ion_auth->get_user()->id
                );

                $ps_id = $this->admission_m->save_parent($pdata); //parent id
            }
            else
            {
                echo '<pre>';
                print_r($pemail);
                print_r($srow);
                echo '</pre>';
                die('no pid');
            }
            $nnn = explode(' ', trim($st->name), 2);
            /* Create Student User */
            $username = strtolower(str_replace(' ', '', $st->name));
            $sufx = isset($nnn[1]) ? $nnn[1] : 's.' . rand(1, 30000);
            $email = str_replace("'", '', trim(strtolower(str_replace(' ', '', $sufx)))) . '@embakasigarrisonsec.sc.ke';

            $password = '12345678'; //temporary password - will require to be changed on first login

            $additional_data = [
                'first_name' => isset($nnn[0]) ? $nnn[0] : '',
                'last_name' => isset($nnn[1]) ? $nnn[1] : '',
                'me' => $this->ion_auth->get_user()->id,
            ];
            if ($this->admission_m->user_email_exists($email))
            {
                $email = rand(1, 30000) . $email;
            }
            $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);

            $class = $this->uploads_m->get_class_stream($st->class, $st->stream);

            $gender = '';
            if ($st->gender == 'Female')
            {
                $gender = 2;
            }
            if ($st->gender == 'Male')
            {
                $gender = 1;
            }
            $sdata = [
                'first_name' => isset($nnn[0]) ? $nnn[0] : '',
                'last_name' => isset($nnn[1]) ? $nnn[1] : '',
                'house' => '',
                'email' => $email,
                'user_id' => $u_id,
                'parent_id' => $ps_id,
                'parent_user' => $pid,
                'status' => 1,
                'admission_date' => 0,
                'admission_number' => $st->adm,
                'gender' => $gender,
                'entry_marks' => $st->kcpe,
                'class' => $class,
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id
            ];
            $rec = $this->admission_m->create($sdata); //student admission id
            if (!$rec)
            {
                echo '<pre>';
                print_r('norec -------------------');
                print_r($st);
                echo '</pre>';
                return FALSE;
            }
            else
            {
                /** Put in History - run admin/sync after importing data** */
                //assign parent
                $fss = array(
                    'parent_id' => $ps_id,
                    'student_id' => $rec,
                    'status' => 1,
                    'created_on' => time(),
                    'created_by' => $this->ion_auth->get_user()->id
                );
                $this->admission_m->assign_parent($fss);
                //add to students group
                $this->ion_auth->add_to_group(8, $u_id);
            }
        }

        echo '<pre>';
        echo '<br>';
        print_r('Done ' . $skz);
        echo '</pre>';
    }

    function br_upload()
    {
        require_once APPPATH . 'libraries/xlsxreader.php';

        $reader = new XLSXReader(FCPATH . 'uploads/kis.xlsx');
        $reader->decodeUTF8(true);
        $reader->read();
        $woksh = array();

        $sheets = $reader->getSheets();

        $i = 0;
        foreach ($sheets as $sheet)
        {
            $i++;
            $data = $reader->getSheetDatas($sheet["id"]);
            $titles = $data[0];
            unset($data[0]);

            foreach ($data as $rid => $row)
            {
                $nwrow = array();
                foreach ($row as $cid => $cell)
                {
                    if (!isset($titles[$cid]))
                    {
                        echo '<pre>xx  ';
                        print_r("[{$cid}] not set");
                        print_r($titles);
                        print_r($row);
                        echo '</pre>';
                        die;
                    }
                    $nwrow[$titles[$cid]] = trim($cell);
                }
                foreach ($titles as $tl)
                {
                    if (!isset($nwrow[$tl]))
                    {
                        $nwrow[$tl] = '';
                    }
                }
                $woksh[] = $nwrow;
            }
            break;
        }
       
 
            $skz++;
            $st = (object) $srow;

            $exists = 0;
            $ex_row = (object) [];

            $st->ph_phone = str_replace('+254', '0', str_replace(' ', '', $st->ph_phone));
            $st->p_mobile = str_replace('+254', '0', str_replace(' ', '', $st->p_mobile));
            $st->p_work = str_replace('+254', '0', str_replace(' ', '', $st->p_work));

            $pemail = strtolower($st->p_email);
            if (empty($pemail))
            {
                $pemail = 'p-' . rand(5, 90000) . '@kis.sc.ke';

                if ($this->admission_m->user_email_exists($pemail))
                {
                    $pemail = 'p-' . rand(5, 90000) . '@kis.sc.ke';
                }
                if ($this->admission_m->user_email_exists($pemail))
                {
                    echo '<pre>Still exists';
                    print_r($pemail);
                    print_r($srow);
                    $pemail = 'p-' . rand(5, 90000) . '@kis.sc.ke';
                    print_r($pemail);
                    echo '</pre>';
                }
            }
            else
            {
                $exs_id = $this->admission_m->parent_existsx($pemail);
                if ($exs_id)
                {
                    $exists = 1;
                    $ex_row = $this->admission_m->get_parent($exs_id);
                }
                
            }

            if ($exists)
            {
                $pid = $ex_row->user_id;
            }
            else
            {
                $ppassword = '12345678'; //temporary password
                $additional = [
                    'first_name' => empty($st->p_first) ? 'Parent ' : $st->p_first,
                    'last_name' => empty($st->p_last) ? 'Parent ' : $st->p_last,
                    'phone' => $st->p_mobile,
                    'me' => $this->ion_auth->get_user()->id,
                ];
                $pt = explode('@', $pemail);
                $pid = $this->ion_auth->register($pt[0], $ppassword, $pemail, $additional);
            }
            if ($pid)
            {
                $this->ion_auth->add_to_group(6, $pid);
                /* End Parent Add to Users */

                $pdata = [
                    'first_name' => empty($st->p_first) ? 'Parent ' : $st->p_first,
                    'last_name' => empty($st->p_last) ? 'Parent ' : $st->p_last,
                    'email' => $pemail,
                    'identity' => $st->p_no,
                    'f_relation' => $st->rel,
                    'mother_fname' => '',
                    'mother_lname' => '',
                    'mother_email' => '',
                    'mother_phone' => '',
                    'status' => 1,
                    'user_id' => $pid,
                    'phone' => $st->ph_phone,
                    'phone2' => $st->p_mobile == $st->ph_phone ? ' ' : $st->p_mobile,
                    'address' => $st->p_work == $st->ph_phone ? ' ' : $st->p_work,
                    'created_on' => time(),
                    'created_by' => $this->ion_auth->get_user()->id
                ];

                $ps_id = $exists ? $ex_row->id : $this->admission_m->save_parent($pdata); //parent id
            }
            else
            {
                echo '<pre>';
                print_r($pemail);
                print_r($srow);
                echo '</pre>';
                die('no pid');
            }

            /* Create Student User */
            $username = strtolower(str_replace(' ', '', $st->first_name . '.' . $st->last_name));
            $email = $username . '@kis.sc.ke';
            $password = '12345678'; //temporary password

            $additional_data = [
                'first_name' => $st->first_name,
                'last_name' => $st->last_name,
                'me' => $this->ion_auth->get_user()->id,
            ];
            if ($this->admission_m->user_email_exists($email))
            {
                $email = rand(1, 999) . '.' . $email;
            }
            $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);

            $timestamp = $this->from_excel($st->dob);
            $sdata = [
                'first_name' => $st->first_name,
                'middle_name' => $st->mid_name,
                'last_name' => $st->last_name,
                'house' => '',
                'email' => $email,
                'user_id' => $u_id,
                'parent_id' => $ps_id,
                'parent_user' => $pid,
                'gender' => $st->gender == 'M' ? 1 : 2,
                'status' => 1,
                'dob' => $timestamp,
                'admission_date' => 0,
                'admission_number' => $st->adm,
                'class' => $st->class,
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id
            ];
            $rec = $this->admission_m->create($sdata); //student admission id
            if (!$rec)
            {
                echo '<pre>';
                print_r('norec -------------------');
                print_r($st);
                echo '</pre>';
                return FALSE;
            }
            else
            {
                /** Put in History - run admin/sync after importing data** */
                //assign parent
                $fss = array(
                    'parent_id' => $ps_id,
                    'student_id' => $rec,
                    'status' => 1,
                    'created_on' => time(),
                    'created_by' => $this->ion_auth->get_user()->id
                );
                $this->admission_m->assign_parent($fss);
                //add to students group
                $this->ion_auth->add_to_group(8, $u_id);
            }
        

        echo '<pre>';
        echo '<br>';
        print_r('Done ' . $skz);
        echo '</pre>';
    }

    function from_excel($excel_time)
    {
        return ($excel_time - 25569) * 86400;
    }

    public function index_1010()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['uploads'] = $this->uploads_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        $data['campus'] = $this->uploads_m->populate('campus', 'id', 'name');

        //load view
        $this->template->title(' Uploads ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $form_data_aux = array();
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->uploads_m->create($form_data);

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/uploads/');
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
            $this->template->title('Add Uploads ')->build('admin/create', $data);
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
            redirect('admin/uploads/');
        }
        if (!$this->uploads_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/uploads');
        }

	}
        function set_paginate_options()

        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/uploads/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10;
                $config['total_rows'] = $this->uploads_m->count();
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






