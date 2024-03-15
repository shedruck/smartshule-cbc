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

                $this->load->model('settings_m');
                $this->load->model('registration_details/registration_details_m');
                $this->load->model('ownership_details/ownership_details_m');
                $this->load->model('institution_docs/institution_docs_m');
                $this->load->model('contact_person/contact_person_m');
        }

        function update_set()
        {

                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'term' => $this->input->post('term'),
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $this->settings_m->update_settings($form_data);
        }
		
		function exam_lock()
        {

                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'exam_lock' => $this->input->post('exam_lock'),
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $this->settings_m->update_settings($form_data);
        }
		

		function post_dashboard()
        {

                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'dashboard' => $this->input->post('dashboard'),
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $this->settings_m->update_settings($form_data);
        }
		
		function post_theme()
        {

                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'theme_color' => $this->input->post('theme'),
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $this->settings_m->update_settings($form_data);
        }

        function post_bg()
        {
                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'background' => $this->input->post('bg'),
                    'modified_by' => $user->id,
                    'modified_on' => time());

                $this->settings_m->update_settings($form_data);
        }
		
		   //Student ID
        function certificate()
        {
               $data['p'] = $this->settings_m->fetch(); 
                $this->template->title('Approval Certificate ')->set_layout('card')->build('admin/certificate', $data);
        }
		
		function index(){
			
			//edit Settings
				$get = $this->settings_m->fetch();
				$reg = $this->registration_details_m->find($get->id);
				$own = $this->ownership_details_m->find($get->id);
				$docs = $this->institution_docs_m->find($get->id);
				$contacts = $this->contact_person_m->find($get->id);
						
				$data['result'] = $get;
                $data['reg'] = $reg;
                $data['own'] = $own;
                $data['docs'] = $docs;
                $data['contacts'] = $contacts;
                //load the view and the layout
                $this->template->title('School & System Settings')->build('admin/settings', $data);
						
		}

    

 function add_new()
        {
                
				
				//check For POST
                if ($this->input->post())
                {
                     
						$user = $this->ion_auth->get_user();
                        //Rules for validation
                        $this->form_validation->set_rules($this->validation());
                        // build array for the model
						 $get = $this->settings_m->fetch();
                       $document = $get->document;

                        if (!empty($_FILES['document']['name']))
                        {
                                $this->load->library('files_uploader');
                                $upload_data = $this->files_uploader->upload('document');
                                $document = $upload_data['file_name'];
                        }

                        $form_data = array(
                            'school' => $this->input->post('school'),
                            'postal_addr' => $this->input->post('postal_addr'),
                            'email' => $this->input->post('email'),
                            'tel' => $this->input->post('tel'),
                            'message_initial' => $this->input->post('message_initial'),
                            'pre_school' => $this->input->post('pre_school'),
                            'cell' => $this->input->post('cell'),
                            'map' => $this->input->post('map'),
                            'vision' => $this->input->post('vision'),
                            'mission' => $this->input->post('mission'),
                            'social_network' => $this->input->post('social_network'),
                            'sender_id' => $this->input->post('sender_id'),
                            'document' => $document,
                            'motto' => $this->input->post('motto'),
                            'currency' => $this->input->post('currency'),
                            'employees_time_in' => $this->input->post('employees_time_in'),
                            'employees_time_out' => $this->input->post('employees_time_out'),
                            'website' => $this->input->post('website'),
                            'list_size' => $this->input->post('list_size'),
                            'prefix' => $this->input->post('prefix'),
                            'fax' => $this->input->post('fax'),
                            'relief' => $this->input->post('relief'),
                            'town' => $this->input->post('town'),
                            'mobile_pay' => $this->input->post('mobile_pay'),
                            'school_code' => $this->input->post('school_code'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
							
							$done = $this->settings_m->update_settings($form_data);
							
							//******---------- Update log -------*********/
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
							//*****************DONE LOG ***************//
								
								 $reg_rec = array(
										'registration_no' => $this->input->post('registration_no'), 
										'date_reg' => strtotime($this->input->post('date_reg')), 
										'institution_category' => $this->input->post('institution_category'), 
										'institution_cluster' => $this->input->post('institution_cluster'), 
										'county' => $this->input->post('county'), 
										'sub_county' => $this->input->post('sub_county'), 
										'ward' => $this->input->post('ward'), 
										'institution_type' => $this->input->post('institution_type'), 
										'education_system' => $this->input->post('education_system'), 
										'education_level' => $this->input->post('education_level'), 
										'knec_code' => $this->input->post('knec_code'), 
										'institution_accommodation' => $this->input->post('institution_accommodation'), 
										'scholars_gender' => $this->input->post('scholars_gender'), 
										'locality' => $this->input->post('locality'), 
										'kra_pin' => $this->input->post('kra_pin'), 
										 'created_by' => $user -> id ,   
										 'created_on' => time()
									);

							     $ok =  $this->registration_details_m->update_attributes(1,$reg_rec);
								 
								 //*********** LOG *************// 
								  $details = implode(' , ', $reg_rec);
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
								  
								  //************Done Log *********//
								   $own_rec = array(
											'ownership' => $this->input->post('ownership'), 
											'proprietor' => $this->input->post('proprietor'), 
											'ownership_type' => $this->input->post('ownership_type'), 
											'certificate_no' => $this->input->post('certificate_no'), 
											'town' => $this->input->post('town'), 
											'police_station' => $this->input->post('police_station'), 
											'health_facility' => $this->input->post('health_facility'), 
											 'created_by' => $user -> id ,   
											 'created_on' => time()
										);

								    $ok = $this->ownership_details_m->update_attributes(1,$own_rec);
									
									//***************** LOG ****************//
									$details = implode(' , ', $own_rec);
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
									  
									 //*********LOG DONE ***************//
									
									$this->load->library('files_uploader');
									
									 $docs = $this->institution_docs_m->find(1);
									 $ownership_doc = $docs->ownership_doc;
									 $incorporation_doc = $docs->incorporation_doc;
									 $institution_cert = $docs->institution_cert;
									 $title_deed = $docs->title_deed;
									 $ministry_approval = $docs->ministry_approval;
									
									 if (!empty($_FILES['ownership_doc']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('ownership_doc');
												$ownership_doc = $upload_data['file_name'];
										}

									if (!empty($_FILES['incorporation_doc']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('incorporation_doc');
												$incorporation_doc = $upload_data['file_name'];
										}
										
									if (!empty($_FILES['institution_cert']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('institution_cert');
												$institution_cert = $upload_data['file_name'];
										}
									if (!empty($_FILES['title_deed']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('title_deed');
												$title_deed = $upload_data['file_name'];
										}
										
									if (!empty($_FILES['ministry_approval']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('ministry_approval');
												$ministry_approval = $upload_data['file_name'];
										}
									
									$doc_rec = array(
											 'ownership_doc' => $ownership_doc ,   
											 'incorporation_doc' => $incorporation_doc ,   
											 'institution_cert' => $institution_cert ,
                                             'title_deed' => $title_deed ,   
					                         'ministry_approval' => $ministry_approval ,											 
											 'created_by' => $user -> id ,   
											 'created_on' => time()
										);
										
									$ok = $this->institution_docs_m->update_attributes(1,$doc_rec);
									
									$details = implode(' , ', $doc_rec);
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
									  
									   //************Done Log *********//
								  
								  $form_data = array(
										'name' => $this->input->post('name'), 
										'phone' => $this->input->post('phone'), 
										'designation' => $this->input->post('designation'), 
										'email' => $this->input->post('contact_email'), 
										 'created_by' => $user -> id ,   
										 'created_on' => time()
									);

								$this->contact_person_m->update_attributes(1, $form_data);
								  
								  //*********** LOG *************// 
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
								  
								  //************Done Log *********//
				  
							
                }
                //check For Settings
                if (!$this->settings_m->is_setup())
                {
                        
						//Insert Settings
                        if ($this->form_validation->run())
                        {        //Validation OK!
                                $ok = $this->settings_m->create($form_data);

                                if ($ok) 
                                {
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                                if (!$this->settings_m->laid_cables())
                                {
                                        $this->settings_m->commence($this->throttle);
                                }
                                //head to Setup Wizard
                                redirect('admin/setup/');
                        }
                        else
                        {
                                $get = new StdClass();
                                foreach ($this->validation() as $field)
                                {
                                        $get->{$field['field']} = set_value($field['field']);
                                }
                        }
                        $data['updType'] = 'add_new';
                }
                else
                {
                        // print_r('rest');die;    
						
						//edit Settings
                        $get = $this->settings_m->fetch();
                        $reg = $this->registration_details_m->find($get->id);
                        $own = $this->ownership_details_m->find($get->id);
                        $docs = $this->institution_docs_m->find($get->id);
                        $contacts = $this->contact_person_m->find($get->id);
						
                        $document = $get->document;
                        $user = $this->ion_auth->get_user();

                        if (!empty($_FILES['document']['name']))
                        {
                                $this->load->library('files_uploader');
                                $upload_data = $this->files_uploader->upload('document');
                                $document = $upload_data['file_name'];
                        }

                        $form_data = array(
                            'school' => $this->input->post('school'),
                            'postal_addr' => $this->input->post('postal_addr'),
                            'email' => $this->input->post('email'),
                            'tel' => $this->input->post('tel'),
                            'cell' => $this->input->post('cell'),
                            'sender_id' => $this->input->post('sender_id'),
                            'pre_school' => $this->input->post('pre_school'),
                            'message_initial' => $this->input->post('message_initial'),
                            'document' => $document,
                            'employees_time_in' => $this->input->post('employees_time_in'),
                            'employees_time_out' => $this->input->post('employees_time_out'),
                            'motto' => $this->input->post('motto'),
                            'map' => $this->input->post('map'),
                            'social_network' => $this->input->post('social_network'),
                            'mission' => $this->input->post('mission'),
                            'vision' => $this->input->post('vision'),
                            'currency' => $this->input->post('currency'),
                            'website' => $this->input->post('website'),
                            'list_size' => $this->input->post('list_size'),
                            'prefix' => $this->input->post('prefix'),
                            'fax' => $this->input->post('fax'),
                            'relief' => $this->input->post('relief'),
                            'town' => $this->input->post('town'),
                            'mobile_pay' => $this->input->post('mobile_pay'),
                            'school_code' => $this->input->post('school_code'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        if ($this->form_validation->run())  //validation has been passed
                        {
                                $done = $this->settings_m->update_settings($form_data);
                                // the information has   been successfully saved in the db
								
								//*********** LOG *************// 
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
								  
								  //************Done Log *********//
								  
								
								 $form_data = array(
										'registration_no' => $this->input->post('registration_no'), 
										'date_reg' => strtotime($this->input->post('date_reg')), 
										'institution_category' => $this->input->post('institution_category'), 
										'institution_cluster' => $this->input->post('institution_cluster'), 
										'county' => $this->input->post('county'), 
										'sub_county' => $this->input->post('sub_county'), 
										'ward' => $this->input->post('ward'), 
										'institution_type' => $this->input->post('institution_type'), 
										'education_system' => $this->input->post('education_system'), 
										'education_level' => $this->input->post('education_level'), 
										'knec_code' => $this->input->post('knec_code'), 
										'institution_accommodation' => $this->input->post('institution_accommodation'), 
										'scholars_gender' => $this->input->post('scholars_gender'), 
										'locality' => $this->input->post('locality'), 
										'kra_pin' => $this->input->post('kra_pin'), 
										 'created_by' => $user -> id ,   
										 'created_on' => time()
									);

							     $ok =  $this->registration_details_m->update_attributes(1,$form_data);
								  
								  //*********** LOG *************// 
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
								  
								  //************Done Log *********//
								  
								  
								   $form_data = array(
											'ownership' => $this->input->post('ownership'), 
											'proprietor' => $this->input->post('proprietor'), 
											'ownership_type' => $this->input->post('ownership_type'), 
											'certificate_no' => $this->input->post('certificate_no'), 
											'town' => $this->input->post('town'), 
											'police_station' => $this->input->post('police_station'), 
											'health_facility' => $this->input->post('health_facility'), 
											 'created_by' => $user -> id ,   
											 'created_on' => time()
										);

								    $ok = $this->ownership_details_m->update_attributes(1,$form_data);
									
									//*********** LOG *************// 
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
								  
								  //************Done Log *********//
									
									$this->load->library('files_uploader');
									 $ownership_doc = $docs->ownership_doc;
									 $incorporation_doc = $docs->incorporation_doc;
									 $institution_cert = $docs->institution_cert;
									 $title_deed = $docs->title_deed;
									 $ministry_approval = $docs->ministry_approval;
									
									 if (!empty($_FILES['ownership_doc']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('ownership_doc');
												$ownership_doc = $upload_data['file_name'];
										}

									if (!empty($_FILES['incorporation_doc']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('incorporation_doc');
												$incorporation_doc = $upload_data['file_name'];
										}
										
									if (!empty($_FILES['institution_cert']['name'])){
										 
												
												$upload_data = $this->files_uploader->upload('institution_cert');
												$institution_cert = $upload_data['file_name'];
										}
									
									$form_data = array(
											 'ownership_doc' => $ownership_doc ,   
											 'incorporation_doc' => $incorporation_doc ,   
											 'institution_cert' => $institution_cert , 
                                             'title_deed' => $title_deed ,   
					                         'ministry_approval' => $ministry_approval ,											 
											 'created_by' => $user -> id ,   
											 'created_on' => time()
										);
										
									$ok = $this->institution_docs_m->update_attributes(1,$form_data);
									
									//*********** LOG *************// 
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
								  
								  //************Done Log *********//
								  
								  $form_data = array(
										'name' => $this->input->post('name'), 
										'phone' => $this->input->post('phone'), 
										'designation' => $this->input->post('designation'), 
										'email' => $this->input->post('contact_email'), 
										 'created_by' => $user -> id ,   
										 'created_on' => time()
									);

								 $this->contact_person_m->update_attributes(1, $form_data);
								  
								  //*********** LOG *************// 
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
								  
								  //************Done Log *********//
								
								
                                if ($done)
                                {
                                        //head bak to dashboard
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                        redirect("admin/settings");
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => "An error occured kindly consult IT "));
                                        redirect("admin/settings/");
                                }
                        }
                        else
                        {
                                foreach (array_keys($this->validation()) as $field)
                                {
                                        if (isset($_POST[$field]))
                                        {
                                                $get->$field = $this->form_validation->$field;
                                                $reg->$field = $this->form_validation->$field;
                                                $own->$field = $this->form_validation->$field;
                                                $docs->$field = $this->form_validation->$field;
                                        }
                                }
                        }
                        $data['updType'] = 'add_new';
                }

                $data['result'] = $get;
                $data['reg'] = $reg;
                $data['own'] = $own;
                $data['docs'] = $docs;
                $data['contacts'] = $contacts;
                //load the view and the layout
                $this->template->title('School & System Settings')->build('admin/new', $data);
        }
 
        /**
         * SMS CODE Page
         */
        function sms_code()
        {
                $this->load->library('Pad');

                $data['ct'] = $this->settings_m->get_by_current();
                $this->template
                             ->title('SMS Code')
                             ->build('admin/active', $data);
        }

        function parse_sm()
        {
                if ($this->input->post('sm_code'))
                {
                        $lii = $this->input->post('sm_code');
                        if (strlen($lii) > 1000)
                        {
                                $user = $this->ion_auth->get_user();
                                $padl = new Padl\License(true, true, true, true);

                                $lice = $padl->validate($lii);
                                $lc = json_decode(json_encode($lice));

                                if ($lc->RESULT == 'OK')
                                {
                                        if (isset($lc->DATA) && isset($lc->DATA->sms) && isset($lc->DATA->client) && isset($lc->DATA->key) && isset($this->school->hash) && !empty($this->school->hash))
                                        {
                                                if ($lc->DATA->client == $this->school->hash)
                                                {
                                                        $ct = $lc->DATA->sms;
                                                        $hash = $lc->ID;
                                                        $form_data = array(
                                                            'client' => $lc->DATA->client,
                                                            'count' => $ct,
                                                            'ref' => $lc->DATA->key,
                                                            'hash' => $hash,
                                                            'raw_str' => $lii,
                                                            'created_by' => $user->id,
                                                            'created_on' => time()
                                                        );

                                                        if ($this->settings_m->sm_exists($lc->DATA->client, $lc->DATA->key, $hash))
                                                        {
                                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'CODE HAS ALREADY BEEN USED!'));
                                                        }
                                                        else
                                                        {
                                                                $dd = $this->settings_m->save_sm($form_data);
                                                                if ($dd)
                                                                {
                                                                        //update nwbks count 
                                                                        if ($this->settings_m->bk_exists())
                                                                        {
                                                                                $row = $this->settings_m->find_bk();

                                                                                $bk = array(
                                                                                    'total_count' => $ct + $row->total_count,
                                                                                    'modified_by' => $user->id,
                                                                                    'modified_on' => time()
                                                                                );

                                                                                $this->settings_m->update_bk($bk);
                                                                        }

                                                                        $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => 'Top up Successful'));
                                                                }
                                                        }
                                                }
                                                else
                                                {
                                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'ILLEGAL CODE'));
                                                }
                                        }
                                        else
                                        {
                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'MISSING PARAMETERS'));
                                        }
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'INVALID CODE'));
                                }
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'INVALID CODE'));
                        }
                }

                redirect('admin/settings/sms_code');
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'school',
                        'label' => 'School Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'postal_addr',
                        'label' => 'Postal Address',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[350]'),
                    array(
                        'field' => 'currency',
                        'label' => 'Currency',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'sender_id',
                        'label' => 'SMS Sender ID',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'tel',
                        'label' => 'Telephone',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'cell',
                        'label' => 'cell phone',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'motto',
                        'label' => 'Motto',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'document',
                        'label' => 'Document',
                        'rules' => ''),

						array(
                        'field' => 'map',
                        'label' => 'Map',
                        'rules' => 'trim'),
						
						array(
                        'field' => 'mission',
                        'label' => 'Mission',
                        'rules' => 'trim'),
						
						array(
                        'field' => 'vision',
                        'label' => 'Vision',
                        'rules' => 'trim'),
						
						array(
                        'field' => 'social_network',
                        'label' => 'Social network',
                        'rules' => 'trim'),
                    array(
                        'field' => 'list_size',
                        'label' => 'list_size',
                        'rules' => ''),
                    array(
                        'field' => 'pre_school',
                        'label' => 'pre_school',
                        'rules' => 'trim'),
                    array(
                        'field' => 'website',
                        'label' => 'Official Website',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'fax',
                        'label' => 'Fax',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'message_initial',
                        'label' => 'message initial',
                        'rules' => 'required|trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'town',
                        'label' => 'Town',
                        'rules' => 'required|trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'employees_time_in',
                        'label' => 'employees time in',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'employees_time_out',
                        'label' => 'employees time out',
                        'rules' => 'required|trim|xss_clean'),
                    array(
                        'field' => 'school_code',
                        'label' => 'School Code',
                        'rules' => 'trim|xss_clean|min_length[0]'),
			//-----VALIDATE Contacts-----------------------	
          array(
		 'field' =>'name',
                'label' => 'Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'designation',
                'label' => 'Designation',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'contact_email',
                'label' => 'Email',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
			
			//-----VALIDATE REG-----------------------			
					array(
		 'field' =>'registration_no',
                'label' => 'Registration No',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'date_reg',
                'label' => 'Date Reg',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_category',
                'label' => 'Institution Category',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_cluster',
                'label' => 'Institution Cluster',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'county',
                'label' => 'County',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'sub_county',
                'label' => 'Sub County',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'ward',
                'label' => 'Ward',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_type',
                'label' => 'Institution Type',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'education_system',
                'label' => 'Education System',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'education_level',
                'label' => 'Education Level',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'knec_code',
                'label' => 'Knec Code',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_accommodation',
                'label' => 'Institution Accommodation',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'scholars_gender',
                'label' => 'Scholars Gender',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'locality',
                'label' => 'Locality',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'kra_pin',
                'label' => 'Kra Pin',
                'rules' => 'trim|xss_clean'),
				
		array(
		 'field' =>'ownership',
                'label' => 'Ownership',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'proprietor',
                'label' => 'Proprietor',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'ownership_type',
                'label' => 'Ownership Type',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'certificate_no',
                'label' => 'Certificate No',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'town',
                'label' => 'Town',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'police_station',
                'label' => 'Police Station',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'health_facility',
                'label' => 'Health Facility',
                'rules' => 'trim|xss_clean|min_length[0]'),
				
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        
  private function validate_registration()
    {
        $config = array(
                 array(
		 'field' =>'registration_no',
                'label' => 'Registration No',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'date_reg',
                'label' => 'Date Reg',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_category',
                'label' => 'Institution Category',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_cluster',
                'label' => 'Institution Cluster',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'county',
                'label' => 'County',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'sub_county',
                'label' => 'Sub County',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'ward',
                'label' => 'Ward',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_type',
                'label' => 'Institution Type',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'education_system',
                'label' => 'Education System',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'education_level',
                'label' => 'Education Level',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'knec_code',
                'label' => 'Knec Code',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'institution_accommodation',
                'label' => 'Institution Accommodation',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'scholars_gender',
                'label' => 'Scholars Gender',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'locality',
                'label' => 'Locality',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'kra_pin',
                'label' => 'Kra Pin',
                'rules' => 'trim|xss_clean|min_length[0]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
		
		
	 private function validate_ownership()
    {
$config = array(
                 array(
		 'field' =>'ownership',
                'label' => 'Ownership',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'proprietor',
                'label' => 'Proprietor',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'ownership_type',
                'label' => 'Ownership Type',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'certificate_no',
                'label' => 'Certificate No',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'town',
                'label' => 'Town',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'police_station',
                'label' => 'Police Station',
                'rules' => 'trim|xss_clean|min_length[0]'),

                 array(
		 'field' =>'health_facility',
                'label' => 'Health Facility',
                'rules' => 'trim|xss_clean|min_length[0]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}	
		
		/**
         * GZIPs a file on disk (appending .gz to the name)
         *
         * From http://stackoverflow.com/questions/6073397/how-do-you-create-a-gz-file-using-php
         * Based on function by Kioob at:
         * http://www.php.net/manual/en/function.gzwrite.php#34955
         * 
         * @param string $source Path to file that should be compressed
         * @param integer $level GZIP compression level (default: 9)
         * @return string New filename (with .gz appended) if success, or false if operation fails
         */
        function gzFile($source, $level = 9)
        {
                $dest = $source . '.gz';
                $mode = 'wb' . $level;
                $error = false;
                if ($fp_out = gzopen($dest, $mode))
                {
                        if ($fp_in = fopen($source, 'rb'))
                        {
                                while (!feof($fp_in))
                                        gzwrite($fp_out, fread($fp_in, 1024 * 512));
                                fclose($fp_in);
                        }
                        else
                        {
                                $error = true;
                        }
                        gzclose($fp_out);
                }
                else
                {
                        $error = true;
                }
                if ($error)
                        return false;
                else
                        return $dest;
        }
  
        function backup()
        {
                $this->load->library('Dump');
                $dump = new Ifsnop\Mysqldump\Mysqldump($this->db->database, $this->db->username, $this->db->password);
                 
                @mkdir(FCPATH . 'uploads/dump', 777, TRUE);
                $dump->start(FCPATH . 'uploads/dump/' . underscore($this->school->school).date('-d_M_Y_H_i') . '.sql');

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Backup Complete'));
                redirect('admin');
        }

}
