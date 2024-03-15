<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Trs extends Trs_Controller
        {
        function __construct()
        {
        parent::__construct();
			$this->template->set_layout('default');
			
			if (!$this->ion_auth->logged_in())
					{
					      if (!$this->is_teacher)
								{
									redirect('login');
								}
					}
			$this->load->model('qa_m');
			$this->load->model('qa_questions/qa_questions_m');
	}

	public function index()
	{	  
	
        	$config = $this->set_paginate_options(); //Initialize the pagination class
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$data['qa'] = $this->qa_m->get_trs_qa($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

			//page number  variable
			 $data['page'] = $page;
              $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Q and A' )->build('trs/list', $data);
	}

        function new_qa($page = NULL)
        {
            //create control variables
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
 
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
          $user = $this -> ion_auth -> get_user();
        $form_data = array(
				'level' => $this->input->post('level'), 
				'title' => $this->input->post('title'), 
				'hours' => $this->input->post('hours'), 
				'minutes' => $this->input->post('minutes'),
				'subject' => $this->input->post('subject'), 
				'topic' => $this->input->post('topic'), 
				'instruction' => $this->input->post('instruction'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);

            $ok=  $this->qa_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('qa/trs');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Qa ' )->build('trs/create', $data);
		}		
	}
	


	function manage($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('qa/trs/');
            }
         if(!$this->qa_m-> exists_($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('qa/trs/');
              }
        //search the item to show in edit form
          $post =  $this->qa_m->get($id);
          $data['questions'] =  $this->qa_m->questions($id);
		  

		 //Rules for validation
			$this->form_validation->set_rules($this->valid_questions());

				//validate the fields of form
				if ($this->form_validation->run() )
				{         //Validation OK!
					  $user = $this -> ion_auth -> get_user();
					$form_data = array(
						
						'qa' => $id, 
						'question' => $this->input->post('question'), 
						'answer' => $this->input->post('answer'), 
						'marks' => $this->input->post('marks'), 
						 'created_by' => $user -> id ,   
						 'created_on' => time()
					);

					$ok =  $this->qa_questions_m->create($form_data);

					if ( $ok)
					{
							$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
					}
					else
					{
							$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
					}
					
					 $type_sub = $this->input->post('submit');
					 
					if($type_sub == 'Save and Add'){
						redirect(current_url());
					}elseif($type_sub == 'Save and Review'){
						
						redirect('qa/trs/view_qa/'.$id.'/'.$this->session->userdata['session_id']);
					}
					else{
						redirect('qa/trs/');
					}


				}else
                {
                $get = new StdClass();
                foreach ($this -> valid_questions() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
             
              $data['result'] = $get; 
		      $data['post'] = $post;
		      $data['updType'] = 'create';
		      $this->template->title('Manage Q & A ' )->build('trs/manage', $data);
		}


	}
	
	
	
	
	function view_qa($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('qa/trs/');
            }
         if(!$this->qa_m-> exists_($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('qa/trs/');
              }
        //search the item to show in edit form
          $data['post'] =  $this->qa_m->get($id);
          $data['questions'] =  $this->qa_m->questions($id);
		  $data['classes'] = $this->trs_m->list_my_classes();

		 $this->template->title('View Q & A ' )->build('trs/view_qa', $data);
	}		
	
	function edit_questions($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('qa/trs/');
            }
         if(!$this->qa_questions_m-> exists_($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('qa/trs/');
              }
        //search the item to show in edit form
        $get =  $this->qa_questions_m->find($id); 
            //variables for check the upload
            $form_data_aux = array();
            $files_to_delete  = array(); 
            //Rules for validation
            $this->form_validation->set_rules($this->valid_questions());

            //create control variables
            $data['updType'] = 'edit';
            $data['page'] = $page;

            if ($this->form_validation->run() )  //validation has been passed
             {
							$user = $this -> ion_auth -> get_user();
							// build array for the model
							$form_data = array( 
								
								'question' => $this->input->post('question'), 
								'answer' => $this->input->post('answer'), 
								'marks' => $this->input->post('marks'), 
								 'modified_by' => $user -> id ,   
								 'modified_on' => time() );

						//add the aux form data to the form data array to save
						$form_data = array_merge($form_data_aux, $form_data);

						//find the item to update
						
							$done = $this->qa_questions_m->update_attributes($id, $form_data);

						if ( $done) 
								{
								$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
								 redirect('qa/trs/manage/'.$get->qa.'/'.$this->session->userdata['session_id']);
							}

							else
							{
								$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
								 redirect('qa/trs/');
							}
						}
							 else
							 {
								 foreach (array_keys($this -> valid_questions()) as $field)
								{
										if (isset($_POST[$field]))
										{  
												$get -> $field = $this -> form_validation -> $field;
										}
								}
						}
              
               $data['result'] = $get;
			   $data['post'] =$this->qa_m->get($get->qa);
			   $data['questions'] =  $this->qa_m->questions($get->qa);
             //load the view and the layout
             $this->template->title('Edit Questions ' )->build('trs/edit_questions', $data);
	}

 function edit($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('qa/trs/');
            }
         if(!$this->qa_m-> exists_($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('qa/trs/');
              }
        //search the item to show in edit form
        $get =  $this->qa_m->get($id); 
            //variables for check the upload
            $form_data_aux = array();
            $files_to_delete  = array(); 
            //Rules for validation
            $this->form_validation->set_rules($this->validation());

            //create control variables
            $data['updType'] = 'edit';
            $data['page'] = $page;

            if ($this->form_validation->run() )  //validation has been passed
             {
			$user = $this -> ion_auth -> get_user();
            // build array for the model
            $form_data = array( 
				'title' => $this->input->post('title'), 
				'level' => $this->input->post('level'),
				'hours' => $this->input->post('hours'), 
				'minutes' => $this->input->post('minutes'),				
				'subject' => $this->input->post('subject'), 
				'topic' => $this->input->post('topic'), 
				'instruction' => $this->input->post('instruction'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->qa_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("qa/trs/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("qa/trs/");
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
               $data['result'] = $get;
             //load the view and the layout
             $this->template->title('Edit Q & A ' )->build('trs/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}

		//search the item to delete
		if ( !$this->qa_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}
		
	
 
		//delete the item
	if ( $this->qa_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect('qa/trs/');
	}
	
	
	function delete_question($qa,$id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}

		//search the item to delete
		if ( !$this->qa_questions_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}
		
	
 
		//delete the item
	if ( $this->qa_questions_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect('qa/trs/manage/'.$qa.'/'.$this->session->userdata['session_id']);
	}
	
	

	/****
	***** POST QUESTIONS
	****/
	
	function post_qa($id,$class,$session=NULL){
		
		  //redirect if no $id
                if (!$id && !$class)
                {
                        
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('qa/trs/');
						
                }
				
			
			 if(!$this->portal_m-> exists_('qa','id',$id) )
                {
				   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
				   redirect('qa/trs/');
                }
				  
				  $counter = 0;
				  $sts = $this->portal_m->class_students($class);
				  
				 $created_on =  time();
				  
					
					foreach($sts as $p){
						
					 $tracker = array(
							'student' => $p->id,
							'qa_id' => $id,
							'class' => $class,
							'status' => 0,          
							'done' => 0,          
							'created_by' => $this->ion_auth->get_user()->id,
							'created_on' => $created_on
						);
						
					$ok = $this->portal_m->create_unenc('qa_given',$tracker);
					
					/**
					** update notifications table
					** ATT - 1
					** QA - 2
					** MC - 3
					****/
					 $tt = array(
								'student' => $p->id,
								'item_id' => $id,
								'type' => 2,
								'status' => 1,          
								'created_by' => $this->ion_auth->get_user()->id,
								'created_on' => $created_on
							);
                       $this->portal_m->create_unenc('assignments_tracker',$tt);

					$counter++;
	           }
			   
			 if($ok){
						
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Multiple Choices Quiz was successfully posted to '.$counter.' learners' ));
						
			}else{
				
			 $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
			  
			}
				
		 redirect('qa/trs/given_quiz/'.$id.'/'.$this->session->userdata['session_id']);
	
	}

			
  function given_quiz($id,$sess=NULL){
	     
   		 if (!$id)
                {
                        
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('qa/trs/');
						
                }
				
			
			 if(!$this->portal_m-> exists_('qa','id',$id) )
                {
				   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
				   redirect('qa/trs/');
                }
				
			$data['post'] = $this->portal_m->get_unenc_row('id',$id,'qa');	
			$data['given'] = $this->qa_m->given($id);	
			 $data['classes'] = $this->trs_m->list_my_classes();
			
	       $this->template->title('Given Q and A ' )->build('trs/given', $data);
  }
  
  
  	function revert($created_on,$id, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}

		//search the item to delete
		if ( !$this->qa_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}
 
		//delete the item
	if ( $this->qa_m->delete_given($created_on) == TRUE) 
		{
		
			$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Posted quiz has been successfully reverted' ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect('qa/trs/given_quiz/'.$id.'/'.$this->session->userdata['session_id']);
	}

	
  function qa_remarks($created_on,$id, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id && !$created_on){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}

		//search the item to delete
		if ( !$this->qa_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}
		
		$data['post'] = $this->portal_m->get_unenc_row('id',$id,'qa');	
		$data['given'] = $this->qa_m->all_given($id,$created_on);	
		$data['qa_id'] = $id;	
		$data['created'] = $created_on;	
		
	   $this->template->title('Given Q and A ' )->build('trs/remarks', $data);
 
		
	}

	function post_marked($created_on,$id, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id && !$created_on){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}

		//search the item to delete
		if ( !$this->qa_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('qa/trs/');
		}
		
		 $sids = $this->input->post('students');
		 
		 if($sids){
			 
			  foreach ($sids as $st)
				{
					
				  $ok = $this->qa_m->update_status($id, $st, array('status'=>1));
				  
				  if($ok){
						$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Results were successfully posted' ) );
				  }else{
						$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => 'Something went wrong try again later' ) );
				  }
					
				}
		 }
		
		 
		redirect('qa/trs/qa_remarks/'.$created_on.'/'.$id.'/'.$this->session->userdata['session_id']);
 
		
	}
	
	
	
	
	function qa_result($id = FALSE,$student, $page = NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('qa/trs/');
            }
         if(!$this->qa_m-> exists_given($id,$student) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('qa/trs/');
             }

		  $this->qa_m->update_done($id,$student); 
		  
		  $this->load->model('st_m');
			  
        //search the item to show in edit form
          $data['p'] =  $this->portal_m->get_unenc_row('id',$id,'qa');
		  
          $data['questions'] =  $this->qa_m->qa_qs($id,'asc');

		 $data['count_qstns'] = $this->st_m->count_qa_qstns($id);
		
		//*** Response per student *********//
		
	
		$data['student'] = $student;
		
		
		//********* Loop Through Student answers *********//
		$data['results'] = $this->st_m->get_qa_answers($id,$student,'asc');

		
		$data['post'] = $this->st_m->get_qa_post($id,$student);
		
		$data['count_done'] = $this->st_m->qa_count_done($id,$student);
		$data['qa_correct'] = $this->st_m->qa_correct($id,$student);
		$data['qa_wrong'] = $this->st_m->qa_wrong($id,$student);
		
		$data['sum_qa_points'] = $this->st_m->sum_qa_points($id,$student);
		$data['sum_awarded_points'] = $this->st_m->sum_awarded_points($id,$student);
	
		//********* Loop Through Student answers *********//
		$data['given'] = $this->qa_m->given_row($id,$student);

		$this->template->title('View Multiple Choices')->build('trs/qa_result', $data);
	}
	
	
	
	function post_comment(){
		
		
		$id =  $this->input->get('id');
		$st =  $this->input->get('st');
		
		$comment=  $this->input->get('comment');
		$marked=  $this->input->get('marked');
		$status= $this->input->get('status');

			
			$data = array(
			  'status'=>$status,
			  'marked'=>$marked,
			  'remarks'=>$comment,
			  'rmk_date'=>time(),
			);
			
		   $ok = $this->qa_m->update_remarks($id, $st, $data);
		   
		   if($ok){
					   echo json_encode(1);
				 }else{
					   echo json_encode(0);
				 }
		
		
	}
	
	
		
		function update_qa(){
			
			$user = $this->ion_auth->get_user();
			$id = $this->input->get('id');
				 $data = array(
						'status' =>  1, 
						'state' => $this->input->get('state'), 
						'comment' => $this->input->get('comment'), 
						'points' => $this->input->get('points'), 
						'marked_on' => time(), 
						'marked_by' => $user -> id
					);

				 $ok =  $this->qa_m->update_qa($id,$data);
				 
				 if($ok){
					   echo json_encode(1);
				 }else{
					   echo json_encode(0);
				 }
		  
		}
	
	
  private function valid_questions()
    {
$config = array(
                

                array(
		 'field' =>'question',
                'label' => 'Question',
                'rules' => 'required|trim'),

                array(
		 'field' =>'answer',
                'label' => 'Answer',
                'rules' => 'trim'),

                 array(
		 'field' =>'marks',
                'label' => 'Marks',
                'rules' => 'required|trim'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'level',
                'label' => 'level',
                'rules' => 'required|trim'),
				
				array(
		 'field' =>'title',
                'label' => 'Title',
                'rules' => 'required|trim'),
				
					array(
		 'field' =>'hours',
                'label' => 'Hours',
                'rules' => 'required|trim'),
				
				array(
		 'field' =>'minutes',
                'label' => 'Minutes',
                'rules' => 'required|trim'),

                 array(
		 'field' =>'subject',
                'label' => 'Subject',
                'rules' => 'required|trim'),

                 array(
		 'field' =>'topic',
                'label' => 'Topic',
                'rules' => 'trim'),

                array(
		 'field' =>'instruction',
                'label' => 'Instruction',
                'rules' => 'trim'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'qa/trs/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100;
            $config['total_rows'] = $this->qa_m->count();
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
            $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
            $config['full_tag_close'] = '</ul></div>';
            $choice = $config["total_rows"] / $config["per_page"];
            //$config["num_links"] = round($choice);

            return $config;
	} 
}