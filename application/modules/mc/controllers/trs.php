<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Trs extends Trs_Controller
        {
        function __construct()
        {
        parent::__construct();
		
		if ($this->ion_auth->logged_in())
        {
            if (!$this->is_teacher)
            {
                redirect('admin');
            }
        }
        else
        {
            redirect('login');
        }
		
		$this->load->model('mc_m');
		$this->load->model('mc_questions/mc_questions_m');
	}

	public function index()
	{	   
	        $config = $this->set_paginate_options(); //Initialize the pagination class
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$data['mc'] = $this->mc_m->get_all_mc($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

			//page number  variable
			 $data['page'] = $page;
             $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Multiple Choices ' )->build('trs/list', $data);
	}

        function create($page = NULL)
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
				'hours' => $this->input->post('hours'), 
				'minutes' => $this->input->post('minutes'), 
				'title' => $this->input->post('title'), 
				'subject' => $this->input->post('subject'), 
				'topic' => $this->input->post('topic'), 
				'instruction' => $this->input->post('instruction'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);

            $ok=  $this->mc_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('mc/trs/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                $get -> {$field['field']}  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Mc ' )->build('trs/create', $data);
		}		
	}

	function edit($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('mc/trs/');
            }
         if(!$this->mc_m-> exists_($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('mc/trs');
              }
        //search the item to show in edit form
        $get =  $this->mc_m->find($id); 
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
				'level' => $this->input->post('level'), 
				'hours' => $this->input->post('hours'), 
				'minutes' => $this->input->post('minutes'),
				'title' => $this->input->post('title'), 
				'subject' => $this->input->post('subject'), 
				'topic' => $this->input->post('topic'), 
				'instruction' => $this->input->post('instruction'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->mc_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("mc/trs/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("mc/trs/");
			}
	  	}
             else
             {
                 foreach (array_keys($this -> validation()) as $field)
                {
                        if (isset($_POST[$field]))
                        {  
                        $get -> {$field} = $this -> form_validation -> $field;
                        }
                }
		}
               $data['result'] = $get;
             //load the view and the layout
             $this->template->title('Edit Mc ' )->build('trs/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('mc/trs/');
		}

		//search the item to delete
		if ( !$this->mc_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('mc/trs/');
		}
 
		//delete the item
		                     if ( $this->mc_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect('mc/trs/');
	}
	
	
		
	function manage($id,$page=NULL)
        {
			
					   //redirect if no $id
		   if (!$id )
			{
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('mc/trs');
			}
				
		  if(!$this->mc_m-> exists_($id) )
             {
                 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                 redirect('mc/trs');
             }
	  
		$user = $this -> ion_auth -> get_user();	  
		$data['questions'] = $this->mc_m->questions($id,'desc');
		 	
		 $this->form_validation->set_rules($this->valid_mc_q());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
			 $type_sub = $this->input->post('submit');
				$form_data = array(
						'mc' => $id, 
						'question' => $this->input->post('question'), 
						'created_by' => $user -> id ,   
						'created_on' => time()
					);

            $ok =  $this->portal_m->create_unenc('mc_questions',$form_data);

            if ( $ok)
            {
					$length = $this->input->post('choice');
					$size = count($length);
					for ($i = 0; $i < $size; ++$i)
					{
						$choice = $this->input->post('choice');
						$state = $this->input->post('state');
						 
						 $data = array(
								'question_id' => $ok, 
								'choice' => $choice[$i], 
								'state' => $state[$i], 
								'created_by' => $user -> id ,   
								'created_on' => time()
							);
						if(isset($choice[$i])){
							
							 $this->portal_m->create_unenc('mc_choices',$data);
						}
					  
					}
						
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
					
					if($type_sub == 'Save and Add'){
						redirect(current_url());
					}
					elseif($type_sub == 'Save and Review'){
						
						redirect('mc/trs/view_mc/'.$id.'/'.$this->session->userdata['session_id']);
					}
					
					
					else{
						redirect('mc/trs/');
					}
					
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
					redirect('mc/trs/mc_questions/'.$id.'/'.$this->session->userdata['session_id']);
            }

			

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                }
		 
          $data['post'] = $id; 
          $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Multiple Choices ' )->build('trs/mc_questions', $data);
		 
		}		
	}
	
	function view_mc($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('mc/trs/');
            }
         if(!$this->mc_m-> exists_($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('mc/trs/');
              }
        //search the item to show in edit form
          $data['post'] =  $this->mc_m->get($id);
          $data['questions'] =  $this->mc_m->questions($id,'asc');
		   $data['classes'] = $this->trs_m->list_my_classes();

		 $this->template->title('View Multiple Choices')->build('trs/view_mc', $data);
	}	
	
	
	function mc_edit_question($mc,$id,$page)
        {
			
					   //redirect if no $id
		   if (!$mc &&  $id )
			{
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('mc/trs/');
			}
				
		  if(!$this->portal_m-> exists_('mc_questions','id',$id) )
             {
                 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                 redirect('mc/trs/');
             }

		  $user = $this->ion_auth->get_user() -> id;
		  $data['choices'] = $this->portal_m->get_unenc_result('question_id',$id,'mc_choices'); ;
		  $data['questions'] =  $this->mc_m->questions($mc,'desc');

		$data['mc'] = $mc;
	
		$this->form_validation->set_rules($this->valid_mc_q());

            //validate the fields of form
            if ($this->form_validation->run() )
            {       
		      //Validation OK!
			 $type_sub = $this->input->post('submit');
				$form_data = array(
						'question' => $this->input->post('question'), 
						'modified_by' => $user ,   
						'modified_on' => time()
					);

            $ok =  $this->portal_m->update_code($id,'id','mc_questions',$form_data);

            if ( $ok)
            {
					$length = $this->input->post('counter');
					$size = count($length);
					for ($i = 0; $i < $size; ++$i)
					{
						$id = $this->input->post('ids');
						$choice = $this->input->post('choice');
						$state = $this->input->post('state');
						 
						 $data = array(
								
								'choice' => $choice[$i], 
								'state' => $state[$i], 
								'modified_by' => $user ,   
								'modified_on' => time()
							);
							
						$this->portal_m->update_code($id[$i],'id','mc_choices',$data);
					}
						
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
					
					if($type_sub == 'Save and Add'){
						redirect(current_url());
					}
					elseif($type_sub == 'Save and Review'){
						
						redirect('mc/trs/view_mc/'.$mc.'/'.$this->session->userdata['session_id']);
					}
					
					
					else{
						redirect('mc/trs/manage/'.$mc.'/'.$this->session->userdata['session_id']);
					}
					
					
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
					redirect('trs/view_mc/');
					
            }

			

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                }
		 
                 $data['result'] = $get; 
                 $data['id'] = $id; 
                 $data['post'] = $mc; 
		 //load the view and the layout
		 $this->template->title('Edit Multiple Choices ' )->build('trs/edit_mc_question', $data);
		}		
	}
	
	
	/****
	***** POST QUESTIONS
	****/
	
	function post_mc($id,$class,$session=NULL){
		
		  //redirect if no $id
                if (!$id && !$class)
                {
                        
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('mc/trs/');
						
                }
				
			
			 if(!$this->portal_m-> exists_('mc','id',$id) )
                {
				   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
				   redirect('mc/trs/');
                }
				  
				  $counter = 0;
				  $sts = $this->portal_m->class_students($class);
				  
				 $created_on =  time();
				  
				  //print_r($sts);die;
					
					foreach($sts as $p){
						
					 $tracker = array(
							'student' => $p->id,
							'mc_id' => $id,
							'class' => $class,
							'status' => 0,          
							'done' => 0,          
							'created_by' => $this->ion_auth->get_user()->id,
							'created_on' => $created_on
						);
						
					$ok = $this->portal_m->create_unenc('mc_given',$tracker);
					
					/**
					** update notifications table
					** ATT - 1
					** QA - 2
					** MC - 3
					****/
					 $tt = array(
								'student' => $p->id,
								'item_id' => $id,
								'type' => 3,
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
				
		 redirect('mc/trs/given_quiz/'.$id.'/'.$this->session->userdata['session_id']);
	
	}
	
	
	function post_comment(){
		
		
		$id =  $this->input->post('id');
		$st =  $this->input->post('st');
		
		$comment=  $this->input->post('comment');
	
		if( $this->input->post()){
			
			$data = array(
			  'remarks'=>$comment,
			  'rmk_date'=>time(),
			);
			
		   $this->mc_m->update_remarks($id, $st, $data);
		}
		
	}
	
		
  function given_quiz($id,$sess=NULL){
	     
   		 if (!$id)
                {
                        
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('mc/trs/');
						
                }
				
			
			 if(!$this->portal_m-> exists_('mc','id',$id) )
                {
				   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
				   redirect('mc/trs/');
                }
				
			$data['post'] = $this->portal_m->get_unenc_row('id',$id,'mc');	
			$data['given'] = $this->mc_m->given($id);	
			 $data['classes'] = $this->trs_m->list_my_classes();
	       $this->template->title('Given Multiple Choices ' )->build('trs/given', $data);
  }
  
  	function revert($created_on,$id, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('mc/trs/');
		}

		//search the item to delete
		if ( !$this->mc_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('mc/trs/');
		}
 
		//delete the item
	if ( $this->mc_m->delete_given($created_on) == TRUE) 
		{
		
			$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Posted quiz has been successfully reverted' ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect('mc/trs/given_quiz/'.$id.'/'.$this->session->userdata['session_id']);
	}
	
	function mc_remarks($created_on,$id, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('mc/trs/');
		}

		//search the item to delete
		if ( !$this->mc_m->exists_($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('mc/trs/');
		}
		
		$data['post'] = $this->portal_m->get_unenc_row('id',$id,'mc');	
		$data['given'] = $this->mc_m->all_given($id,$created_on);	
		
	   $this->template->title('Given Multiple Choices ' )->build('trs/remarks', $data);
 
		
	}
	
	function mc_result($id = FALSE,$student, $page = NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('mc/trs/');
            }
         if(!$this->mc_m-> exists_given($id,$student) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('mc/trs/');
             }

		  $this->mc_m->update_done($id,$student); 
		  
		  $this->load->model('st_m');
			  
        //search the item to show in edit form
          $data['p'] =  $this->portal_m->get_unenc_row('id',$id,'mc');
          $data['questions'] =  $this->mc_m->mc_qs($id,'asc');

		 $data['count_qstns'] = $this->st_m->count_qstns($id);
		
		//*** Response per student *********//
		
		$data['post'] = $this->st_m->get_post($id,$student);
		$data['student'] = $student;
		$data['count_done'] = $this->st_m->count_done($id,$student);
		$data['mc_correct'] = $this->st_m->mc_correct($id,$student);
		$data['mc_wrong'] = $this->st_m->mc_wrong($id,$student);
		
		//********* Loop Through Student answers *********//
		$data['results'] = $this->st_m->get_mc_answers($id,$student,'asc');

		$this->template->title('View Multiple Choices')->build('trs/mc_result', $data);
	}
	
	
   private function valid_mc_q()
    {
      $config = array(
                 array(
		 'field' =>'question',
                'label' => 'Question',
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
                'label' => 'Level',
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
                'label' => 'instruction',
                'rules' => 'trim'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'mc/trs/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100;
            $config['total_rows'] = $this->mc_m->count();
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