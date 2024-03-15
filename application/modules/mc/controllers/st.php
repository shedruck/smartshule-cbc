<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class St extends St_Controller
        {
        function __construct()
        {
        parent::__construct();
		
		if ($this->ion_auth->logged_in())
        {
            if (!$this->is_student)
            {
                redirect('admin');
            }
        }
        else
        {
            redirect('login');
        }
		
		 $this->template->set_layout('default');
		
		$this->load->model('mc_m');
		$this->load->model('mc_questions/mc_questions_m');
	}

	public function index()
	{	   
	        $config = $this->set_paginate_options(); //Initialize the pagination class
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$data['mc'] = $this->mc_m->get_st_mc($this->student->id);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

			//page number  variable
			 $data['page'] = $page;
             $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Multiple Choices ' )->build('st/list', $data);
	}

  

	function mc_view($id = FALSE, $page = NULL, $del=NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('mc/st/');
            }
         if(!$this->mc_m-> exists_st($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('mc/st/');
             }
			 
			 $this->st_m->delete_notification($this->student->id,$id,'3');
			
			 
			//$this->portal_m->delete_code('mc_given','id',$del); 
			  
        //search the item to show in edit form
          $data['post'] =  $this->portal_m->get_unenc_row('id',$id,'mc');
          $data['questions'] =  $this->mc_m->mc_qs($id,'asc');
		  

		 $this->template->title('View Multiple Choices')->build('st/view_mc', $data);
	}
	
	
	function mc_start($id = FALSE, $page = NULL, $del=NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('mc/st/');
            }
         if(!$this->mc_m-> exists_st($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('mc/st/');
             }
			 
		//$this->portal_m->delete_code('assignments_tracker','id',$del); 
			  
        //search the item to show in edit form
          $data['post'] =  $this->portal_m->get_unenc_row('id',$id,'mc');
          $data['questions'] =  $this->mc_m->mc_qs($id,'asc');
		  

		 $this->template->title('View Multiple Choices')->build('st/start', $data);
	}	
	
	
		//log the user in
        function mc_answers()
        {
			
		
			
	              $stud = $this->student->id;
				  $choice = $this->input->get('choice');
				  $question = $this->input->get('question');
				  $mc_id = $this->input->get('mc_id');
				  
				  $state = $this->ion_auth->populate('mc_choices','id','state');
				  
				 $d = $this->st_m->mc_done($this->student->id,$mc_id);
				 
				 if(empty($d)){
				  
					$data = array(
					 'student' => $stud,
					 'choice_id' => $choice,
					 'question_id' => $question,
					 'mc_id' => $mc_id,
					 'state' => $state[$choice],
					 'created_on' => time(),
					 'created_by' => $this->ion_auth->get_user()->id
					);
					
				$conf = $this->st_m->get_mc_ans($stud,$mc_id,$question);
				
				if(!empty($conf)){
					
					$p = $this->portal_m->update_unenc('mc_answers',$conf->id, array('choice_id'=>$choice,'modified_on'=>time(),'modified_by'=>$this->ion_auth->get_user()->id,'state' => $state[$choice]));
					
				}else{
					
					$p = $this->portal_m->create_unenc('mc_answers',$data);
				}

				   if($p){
					  
					   echo 1;
				   }
				   else{
					   
					   echo 0;
				   }
				   
				 }else{
					  echo 0;
				 }
        }
		
		
		function update_done(){
			
			 $mc_id = $this->input->get('mc_id');
	
			 $posted = $this->portal_m->count_posted_answers($this->student->id,'mc_answers','mc_id',$mc_id);
			
			if($posted){
                       echo $posted;
				   }
				   else{
					   
					   echo 0;
				   }
			
		}
		
		
		

	function mc_result($id = FALSE, $page = NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('mc/st/');
            }
         if(!$this->mc_m-> exists_st($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('mc/st/');
             }

		  $this->mc_m->update_done($id,$this->student->id); 
			  
        //search the item to show in edit form
          $data['p'] =  $this->portal_m->get_unenc_row('id',$id,'mc');
          $data['questions'] =  $this->mc_m->mc_qs($id,'asc');

		 $data['count_qstns'] = $this->st_m->count_qstns($id);
		
		//*** Response per student *********//
		
		$data['post'] = $this->st_m->get_post($id,$this->student->id);
		$data['count_done'] = $this->st_m->count_done($id,$this->student->id);
		$data['mc_correct'] = $this->st_m->mc_correct($id,$this->student->id);
		$data['mc_wrong'] = $this->st_m->mc_wrong($id,$this->student->id);
		
		//********* Loop Through Student answers *********//
		$data['results'] = $this->st_m->get_mc_answers($id,$this->student->id,'asc');
				
		  

		 $this->template->title('View Multiple Choices')->build('st/mc_result', $data);
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
		$config['base_url'] = site_url() . 'mc/st/index/';
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