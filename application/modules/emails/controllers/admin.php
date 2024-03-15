<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
			$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php')
					->set_partial('teachers_top', 'partials/teachers_top.php')
                     ->set_partial('teacher_sidebar', 'partials/teachers_sidebar.php');
			if (!$this->ion_auth->logged_in()){
					redirect('admin/login');
					}

			$this->load->model('emails_m');
			
			$this->load->model('email_templates/email_templates_m');
			$this->load->library('pmailer');
			$this->load->library('image_cache');
	}


	public function index()
	{
		
		redirect('admin/emails/create');
		//set the title of the page
		$data['title'] = 'Emails List'; 

		$config = $this->set_paginate_options(); 
		//Initialize the pagination class
		$this->pagination->initialize($config);


		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

		//find all the categories with paginate and save it in array to past to the view
		$data['emails'] = $this->emails_m->paginate_all($config['per_page'], $page);

		//create pagination links
		$data['links'] = $this->pagination->create_links();

		//number page variable
		$data['page'] = $page;

		//load view
		if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->template->title(' Exams Timetable')->build('admin/create', $data);
        }
		else{
			$this->template->title('All Emails ' )->build('admin/create', $data);
		}
		
	}

	
	//Send Email General Function

	function create($page = NULL)
	{
		//create control variables
		$data['title']		= 	'Create emails';
		$data['updType']	= 	'create';
		$form_data_aux  = 	array();
		$data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
		
		///LIST ALL Emails
		$data['title'] = 'Emails List'; 

		$config = $this->set_paginate_options(); 
		//Initialize the pagination class
		$this->pagination->initialize($config);


		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

		//find all the categories with paginate and save it in array to past to the view
		$data['emails'] = $this->emails_m->paginate_all($config['per_page'], $page);

		//create pagination links
		$data['links'] = $this->pagination->create_links();

		//number page variable
		$data['page'] = $page;
		
		///END LIST ALL EMAILS
 
        //Rules for validation
	$this->form_validation->set_rules($this->validation());
	
	 $attachment = '';

                if ( ! empty($_FILES['attachment']['name']))
                {
                        $this -> load -> library('files_uploader');
                        $upload_data = $this -> files_uploader -> upload('attachment');
                        $attachment = $upload_data['file_name'];
                }

		//validate the fields of form
		if ($this->form_validation->run() )
 		{         //Validation OK!
        $user = $this -> ion_auth -> get_user();
		
		$user_id=$this->input->post('user_id');
		
		//Type 1 is for school staff
		//Type 2 is for parents
		$type=0;
		
		 if ($this->input->post('send_to') == 'All Parents'){ $user_id='All Parents';}
		 if ($this->input->post('send_to') == 'All Teachers'){ $user_id='All Teachers';}
		 if ($this->input->post('send_to') == 'All Staff'){ $user_id='All Staff';}
		 if ($this->input->post('send_to') == 'Staff'){ $user_id=$this->input->post('staff'); $type=1;}
		 if ($this->input->post('send_to') == 'Parent'){ $user_id=$this->input->post('parent'); $type=2;}
		 
		 //TYPE 1 is staff while TYPE 2 is Parent
		 
		 
	if($this->input->post('status')=='draft'){
		
			$form_data = array(
					'recipient' => $user_id, 
					'cc' => $this->input->post('cc'), 
					'subject' => $this->input->post('subject'), 
					'description' => $this->input->post('description'), 
					'attachment' => $attachment, 
					'type' => $type, 
					'status' => $this->input->post('status'), 
					'created_by' => $user -> id ,   
					'created_on' => time()
				);
				
			$emails_m =  $this->emails_m->create($form_data); 
			
			redirect('admin/emails');
		}
		else{
		
		$form_data = array(
					'recipient' => $user_id, 
					'cc' => $this->input->post('cc'), 
					'subject' => $this->input->post('subject'), 
					'description' => $this->input->post('description'), 
					'attachment' => $attachment, 
					'type' => $type, 
					'status' =>'sent', 
					'created_by' => $user -> id ,   
					'created_on' => time()
				);
				
			$ok =  $this->emails_m->create($form_data); 
			
          
			if ( $ok ) 
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
				 
				 
				 //Send to parents
				
				$attachment = "uploads/files/" . $attachment;
                $attmnt = array();
                if (!empty($document))
                {
                    $attmnt[] = $attachment;
                }

                if ($this->input->post('send_to') == 'All Parents')
                {

                        $members = $this->ion_auth->get_parent();
						
						//print_r($members );die;
						
						foreach($members as $member){
						
								$subject =$this->input->post('subject');
								$to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";
								$cc = $this->input->post('cc');
								$bcc = "";
								$from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

								$content = '';

								$year = date('Y');
								$email_body = $this->email_templates_m->template('general', array(
									'SUBJECT' => $subject,
									'TO' => $to,
									'FROM' => $from,
									'DESCRIPTION' => $this->input->post('description'),
								));
								 
							   $mail_from='no-reply@school.com';
							   $html_msg = $this->image_cache->get_embed($email_body,1);
							   $this->pmailer->send_mail($member->email, $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
							   //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
					   
					   }
					   
                          
					   if(!$this->input->post('cc')==''){
					   $this->pmailer->send_mail($this->input->post('cc'), $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
					    //$this->pmailer->send_mail($this->input->post('cc'), $subject,$email_body,$mail_from);
					   }

						$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Email Save Successfully' ));
                }  
				
				if ($this->input->post('send_to') == 'All Teachers')
                {

                        $members = $this->ion_auth->get_teacher();
						
						foreach($members as $member){
								$subject = $this->input->post('subject');
								$to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";
								$cc = $this->input->post('cc');
								$bcc = "";
								$from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

								$content = '';

								$year = date('Y');
								$email_body = $this->email_templates_m->template('general', array(
									'SUBJECT' => $subject,
									'TO' => $to,
									'FROM' => $from,
									'DESCRIPTION' => $this->input->post('description'),
								));
								
								//print_r($email_body);die;
								
							   $mail_from='no-reply@school.com';
							   $html_msg = $this->image_cache->get_embed($email_body,1);
							   $this->pmailer->send_mail($member->email, $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
							   //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
					   
					   }
					   
                          
					   if(!$this->input->post('cc')==''){
					   $this->pmailer->send_mail($this->input->post('cc'), $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
					    //$this->pmailer->send_mail($this->input->post('cc'), $subject,$email_body,$mail_from);
					   }

						$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Email Save Successfully' ));
                } 
				//Send to all staff
				if ($this->input->post('send_to') == 'All Staff')
                {

                        $members = $this->ion_auth->get_users();
						
						foreach($members as $member){
								$subject = $this->input->post('subject');
								$to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";
								$cc = $this->input->post('cc');
								$bcc = "";
								$from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

								$content = '';

								$year = date('Y');
								$email_body = $this->email_templates_m->template('general', array(
									'SUBJECT' => $subject,
									'TO' => $to,
									'FROM' => $from,
									'DESCRIPTION' => $this->input->post('description'),
								));
								
							   $mail_from='no-reply@school.com';
							   $html_msg = $this->image_cache->get_embed($email_body,1);
							   $this->pmailer->send_mail($member->email, $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
							   //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
					   
					   }
					   
                          
					   if(!$this->input->post('cc')==''){
					   $this->pmailer->send_mail($this->input->post('cc'), $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
					    //$this->pmailer->send_mail($this->input->post('cc'), $subject,$email_body,$mail_from);
					   }

						$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Email Save Successfully' ));
                } 
				
				
				if($this->input->post('send_to') == 'Staff')
                {
                     
                      
						$member = $this->ion_auth->get_user($this->input->post('staff'));
						
						
						
                        $subject = $this->input->post('subject');
                        $to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";
                        $cc = $this->input->post('cc');
                        $bcc = "";
                       $from = $user->first_name . ' ' . $user->last_name . " <" . $user->email . " > ";

                        $content = '';

                        $year = date('Y');
                        $email_body = $this->email_templates_m->template('general', array(
                            'SUBJECT' => $subject,
                            'TO' => $to,
                            'FROM' => $from,
                            'DESCRIPTION' => $this->input->post('description'),
                        ));
						
						//print_r($email_body);die;
						
					   $mail_from='no-reply@school.com';
					    $html_msg = $this->image_cache->get_embed($email_body,1);
					    $this->pmailer->send_mail($member->email, $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
                       //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
                          
					 if(!$this->input->post('cc')==''){
					   $this->pmailer->send_mail($this->input->post('cc'), $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
					    //$this->pmailer->send_mail($this->input->post('cc'), $subject,$email_body,$mail_from);
					   }
					$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Email Save Successfully' ));
                
                }
				if($this->input->post('send_to') == 'Parent')
                {
                     
                      
						$member = $this->ion_auth->get_single_parent($this->input->post('parent'));
						
                        $subject = $this->input->post('subject');
                       $to = $member->first_name . ' ' . $member->last_name . " <" . $member->email . " > ";
                        $cc = $this->input->post('cc');
                        $bcc = "";
                       $from = $user->first_name .' '.$user->last_name . " <".$user->email ." > ";

                        $content = '';

                        $year = date('Y');
                        $email_body = $this->email_templates_m->template('general', array(
                            'SUBJECT' => $subject,
                            'TO' => $to,
                            'FROM' => $from,
                            'DESCRIPTION' => $this->input->post('description'),
                        ));
						
						//print_r($email_body);die;
						
					   $mail_from='no-reply@school.com';
					      $html_msg = $this->image_cache->get_embed($email_body,1);
					    $this->pmailer->send_mail($member->email, $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
                       //$this->pmailer->send_mail($member->email, $subject,$email_body,$mail_from);
                          
					 if(!$this->input->post('cc')==''){
					   $this->pmailer->send_mail($this->input->post('cc'), $subject,$html_msg['content'], $mail_from, $attmnt,'','',$html_msg['embed']);
					    //$this->pmailer->send_mail($this->input->post('cc'), $subject,$email_body,$mail_from);
					   }
					$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Email Save Successfully' ));
                
                }
				else{}
				
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Email Sent Successfully' ));
			}
			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_success') ));
			}
			redirect('admin/emails/');

	  	  }
		
		}else
           {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get->{$field['field']}  = set_value($field['field']);
                 }
				 
                
                 $data['emails_m'] = $get; 
			
		 //load the view and the layout
		 if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->template->title(' Compose Email')->build('admin/create', $data);
        }
		else{
			 $this->template->title(' Compose Email ')->build('admin/create', $data);
		}
		
		}		
	}

	function edit($id = FALSE, $page = 0)
	{ 
          
		//get the $id and sanitize
		$id = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $this->input->post('id', TRUE);
		$id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//get the $page and sanitize
		$page = ( $this->uri->segment(5) )  ? $this->uri->segment(5) : $page;
		$page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

		//redirect if no $id
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
			redirect('admin/emails/');
		}
         if(!$this->emails_m-> exists($id) )
             {
                 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
			redirect('admin/emails');
              }
			//search the item to show in edit form
			$get =  $this->emails_m->find($id); 
		//variables for check the upload
		$form_data_aux = array();
		$files_to_delete  = array(); 
		//Rules for validation
		$this->form_validation->set_rules($this->validation());

		//create control variables
		$data['title'] = lang('web_edit');
		$data['updType'] = 'edit';
		$data['page'] = $page;
                 
		if ($this->form_validation->run() )  //validation has been passed
		 {
			$user = $this -> ion_auth -> get_user();
			// build array for the model
			$form_data = array(
					       	'id'	=> $id,
							'user_id' => $this->input->post('user_id'), 
							'cc' => $this->input->post('cc'), 
							'subject' => $this->input->post('subject'), 
							'description' => $this->input->post('description'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

			//add the aux form data to the form data array to save
			$form_data = array_merge($form_data_aux, $form_data);

			//find the item to update
			
			$emails_m = $this->emails_m->update_attributes($this->input->post('id', TRUE), $form_data);

			
			if ( $emails_m) 
			{
				
				$details = implode(' , ', $this->input->post());
								$user = $this->ion_auth->get_user();
									$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $emails_m, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$emails_m, 
										'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
								  
				
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/emails/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $emails_m->errors->full_messages() ) );
				redirect("admin/emails/");
			}
	  	}
             else
             {
                 foreach (array_keys($this -> validation()) as $field)
                {
                        if (isset($_POST[$field]))
                        {  
                                $get -> $field = $this -> form_validation -> $field;
                        }
                }
		}
               $data['emails_m'] = $get;
		 //load the view and the layout
		 $this->template->title('Edit Emails ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/emails');
		}

		//search the item to delete
		if ( !$this->emails_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/emails');
		}

		//delete the item
		if ($this->emails_m->delete($id) == TRUE) 
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
			
			$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/emails/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'user_id',
                 'label' => 'User Id',
                 'rules' =>'xss_clean'),

                 array(
		 'field' =>'cc',
                 'label' => 'Cc',
                 'rules' =>'xss_clean'),
				 
		  array(
            'field' => 'send_to',
            'label' => 'Send To',
            'rules' => 'trim|required|xss_clean',
        ),

                 array(
		 'field' =>'subject',
                'label' => 'Subject',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[255]'),

                array(
		 'field' =>'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
	
	private function email_validation()
    {
$config = array(
                 array(
		 'field' =>'parent',
                 'label' => 'Parent',
                 'rules' =>'xss_clean'),
array(
		 'field' =>'staff',
                 'label' => 'Staff',
                 'rules' =>'xss_clean'),

                 array(
		 'field' =>'cc',
                 'label' => 'Cc',
                 'rules' =>'xss_clean'),
				 
		  array(
		 'field' =>'status',
                 'label' => 'status',
                 'rules' =>'xss_clean'),
				 
		

                 array(
		 'field' =>'subject',
                'label' => 'Subject',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[255]'),

                array(
		 'field' =>'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/emails/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100;
		$config['total_rows'] = $this->emails_m->count();
		$config['uri_segment'] = 4 ;

	    $config['first_link'] = lang('web_first');
	    $config['first_tag_open'] = "<li>";
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = lang('web_last') ;
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
	    $choice = $config["total_rows"] / $config["per_page"];
	    //$config["num_links"] = round($choice);

	    return $config;
	} 
}