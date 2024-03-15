<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Admin extends Admin_Controller
        {
        function __construct()
        {
        parent::__construct();
			/*$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/ 
			if (!$this->ion_auth->logged_in())
	{
	redirect('admin/login');
	}
			$this->load->model('evideos_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['evideos'] = $this->evideos_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

			//page number  variable
			 $data['page'] = $page;
			$data['per'] = $config['per_page'];

            //load view
            $this->template->title(' E-videos ' )->build('admin/list', $data);
	}

	public function watch_all($id=NULL)
	{	   
				
				if(empty($id)){ $id=1;}
				
				$data['post'] = $this->evideos_m->find($id);
				
				$config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['evideos'] = $this->evideos_m->get_all();
				
				//print_r($this->evideos_m->find($id));die;

            //create pagination links
            $data['links'] = $this->pagination->create_links();

			//page number  variable
			$data['page'] = $page;
			$data['per'] = $config['per_page'];

            //load view
            $this->template->title(' E-videos ' )->build('admin/watch', $data);
	}
	
	
        function list_subjects()
        {

                $id = $this->input->get('id');
				
				$sys = $this->ion_auth->populate('class_groups','id','education_system');
				
               //** Check if education system to list subjects/learning areas
			   
                if($sys[$id] ==1){
					
					 $subjects = $this->evideos_m->get_sub844($id);
					 $subs = $this->ion_auth->populate('subjects','id','name');
					 
				}elseif($sys[$id] ==2){
					 $subjects = $this->evideos_m->get_cbc_subjects($id);
					 $subs = $this->ion_auth->populate('cbc_subjects','id','name');
				}

                $jso = '[';
                $coma = ',';
                $all = count($subjects);
                $i = 0;
                $jso .= '{"optionValue":"","optionDisplay":"Select Option"}' . $coma;
                foreach ($subjects as $p)
                {
                        $i++;
                        if ($i == $all)
                                $coma = '';
                        $jso .= '{"optionValue":"' . $p->subject_id . '","optionDisplay":"' . strtoupper($subs[$p->subject_id]) . '"}' . $coma;
                }
				
				

                $jso .= ']';

                echo $jso;
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
				'title' => $this->input->post('title'), 
				'level' => $this->input->post('level'), 
				'type' => $this->input->post('type'), 
				'subject' => $this->input->post('subject'), 
				'topic' => $this->input->post('topic'), 
				'status' => 1, 
				'subtopic' => $this->input->post('subtopic'), 
				'preview_link' => $this->input->post('preview_link'), 
				'video_embed_code' => $this->input->post('video_embed_code'), 
				'description' => $this->input->post('description'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);

            $ok=  $this->evideos_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/evideos/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Evideos ' )->build('admin/create', $data);
		}		
	}

	function update_status($id = FALSE, $status)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/evideos/');
            }
         if(!$this->evideos_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/evideos');
              }
			  
	 $done = $this->evideos_m->update_attributes($id, array('status'=>$status));

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/evideos/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/evideos/");
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
                    redirect('admin/evideos/');
            }
         if(!$this->evideos_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/evideos');
              }
        //search the item to show in edit form
        $get =  $this->evideos_m->find($id); 
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
							'type' => $this->input->post('type'), 
							'subject' => $this->input->post('subject'), 
							'topic' => $this->input->post('topic'), 
							'subtopic' => $this->input->post('subtopic'), 
							'preview_link' => $this->input->post('preview_link'), 
							'video_embed_code' => $this->input->post('video_embed_code'), 
							'description' => $this->input->post('description'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->evideos_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/evideos/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/evideos/");
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
             $this->template->title('Edit Evideos ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/evideos');
		}

		//search the item to delete
		if ( !$this->evideos_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/evideos');
		}
 
		//delete the item
		                     if ( $this->evideos_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/evideos/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'title',
                'label' => 'Title',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[500]'),

                 array(
		 'field' =>'level',
                'label' => 'Level',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'type',
                 'label' => 'Type',
                 'rules' =>'xss_clean'),

                 array(
		 'field' =>'subject',
                'label' => 'Subject',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'topic',
                'label' => 'Topic',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

				array(
		 'field' =>'subtopic',
                'label' => 'subtopic',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                array(
		 'field' =>'preview_link',
                'label' => 'Preview Link',
                'rules' => 'required|trim|xss_clean|min_length[0]'),

                array(
		 'field' =>'video_embed_code',
                'label' => 'Video Embed Code',
                'rules' => 'required|trim|xss_clean|min_length[0]'),

                array(
		 'field' =>'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/evideos/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 1000000000;
            $config['total_rows'] = $this->evideos_m->count();
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