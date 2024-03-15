<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class St extends st_Controller
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
		
		$this->load->model('qa_m');
		$this->load->model('qa_questions/qa_questions_m');
	}

	public function index()
	{	   
	        $config = $this->set_paginate_options(); //Initialize the pagination class
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$data['qa'] = $this->qa_m->get_st_qa($this->student->id);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

			//page number  variable
			 $data['page'] = $page;
             $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Q and A ' )->build('st/list', $data);
	}

  

	function qa_view($id = FALSE, $page = NULL, $del=NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('qa/st/');
            }
         if(!$this->qa_m-> exists_st($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('qa/st/');
             }
			 
			 $this->st_m->delete_notification($this->student->id,$id,'3');
			
			 
			//$this->portal_m->delete_code('qa_given','id',$del); 
			  
        //search the item to show in edit form
          $data['post'] =  $this->portal_m->get_unenc_row('id',$id,'qa');
          $data['questions'] =  $this->qa_m->qa_qs($id,'asc');
		  

		 $this->template->title('View Q and A')->build('st/view_qa', $data);
	}
	
	
	function qa_start($id = FALSE, $page = NULL, $del=NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('qa/st/');
            }
         if(!$this->qa_m-> exists_st($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('qa/st/');
             }
			 
		//$this->portal_m->delete_code('assignments_tracker','id',$del); 
			  
        //search the item to show in edit form
          $data['post'] =  $this->portal_m->get_unenc_row('id',$id,'qa');
          $data['questions'] =  $this->qa_m->qa_qs($id,'asc');
		  

		 $this->template->title('View Q and A')->build('st/start', $data);
	}	
	
	
		//log the user in
        function qa_answers()
        {

				  $qa_id = $this->input->post('qa_id');
				  $question_id = $this->input->post('question_id');
				  $answer = $this->input->post('answer');

				 $d = $this->st_m->qa_done($this->student->id,$qa_id);
				 
				  $user = $this -> ion_auth -> get_user();
				 
				 if(empty($d)){
				  
					$data = array(
					'student' => $this->student->id, 
					'qa_id' => $qa_id, 
					'status' => 0, 
					'question' => $question_id, 
					'answer' => $answer, 
					'created_by' => $user -> id ,   
					'created_on' => time()
					);
					
				$conf = $this->st_m->get_qa_ans($this->student->id,$qa_id,$question_id);
				
				if(!empty($conf)){
					
					$p = $this->portal_m->update_unenc('qa_answers',$conf->id, array('answer'=>$answer,'modified_on'=>time(),'modified_by'=>$user -> id));
					
				}else{
					
					$p = $this->portal_m->create_unenc('qa_answers',$data);
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
			
			 $qa_id = $this->input->get('qa_id');
	
			 $posted = $this->portal_m->count_posted_answers($this->student->id,'qa_answers','qa_id',$qa_id);
			
			if($posted){
                       echo $posted;
				   }
				   else{
					   
					   echo 0;
				   }
			
		}
		
		
		

	function qa_result($id = FALSE, $page = NULL)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                     redirect('qa/st/');
            }
         if(!$this->qa_m-> exists_st($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				 redirect('qa/st/');
             }

		  $this->qa_m->update_done($id,$this->student->id); 
			  
        //search the item to show in edit form
          $data['p'] =  $this->portal_m->get_unenc_row('id',$id,'qa');
          $data['questions'] =  $this->qa_m->qa_qs($id,'asc');

		 $data['count_qstns'] = $this->st_m->count_qa_qstns($id);
		
		//*** Response per student *********//
		
		$data['post'] = $this->st_m->get_qa_post($id,$this->student->id);
		
		$data['count_done'] = $this->st_m->qa_count_done($id,$this->student->id);
		
		
		$data['count_done'] = $this->st_m->qa_count_done($id,$this->student->id);
		$data['qa_correct'] = $this->st_m->qa_correct($id,$this->student->id);
		$data['qa_wrong'] = $this->st_m->qa_wrong($id,$this->student->id);
		
		$data['sum_qa_points'] = $this->st_m->sum_qa_points($id,$this->student->id);
		$data['sum_awarded_points'] = $this->st_m->sum_awarded_points($id,$this->student->id);
		
		
		//********* Loop Through Student answers *********//
		
		$data['results'] = $this->st_m->get_qa_answers($id,$this->student->id,'asc');
		$data['given'] = $this->qa_m->given_row($id,$this->student->id);

		$this->template->title('View Q and A')->build('st/qa_result', $data);
	}
	
	



   private function valid_qa_q()
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
		$config['base_url'] = site_url() . 'qa/st/index/';
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