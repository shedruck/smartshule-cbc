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
			$this->load->model('final_exams_certificates_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['final_exams_certificates'] = $this->final_exams_certificates_m->paginate_all($config['per_page'], $page);

				//create pagination links
				$data['links'] = $this->pagination->create_links();

			//page number  variable
			 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Final Exams Certificates ' )->build('admin/list', $data);
	}

        function create($page = NULL)
        {
            //create control variables
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
            $data['subjects'] = $this->final_exams_certificates_m->get_subjects();
 
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
          
			 $dest = FCPATH . "/uploads/final_exams_certificates/" . date('Y') . '/';
			 
			if (!is_dir($dest))
			{
					mkdir($dest, 0777, true);
			}
			
			$config['upload_path'] = $dest;
			$config['allowed_types'] = 'jpg|png|pdf|doc|docx|gif';
			$config['max_size'] = 1024 * 8;
			$config['encrypt_name'] = FALSE;

			$this->load->library('upload', $config);

			 $certificate = '';

			if (!empty($_FILES['certificate']['name']))
			{
			  $data =	$this->upload->do_upload('certificate');
			} 
		
			$data = $this->upload->data();

         $user = $this -> ion_auth -> get_user();
        $form_data = array(
				'student' => $this->input->post('student'), 
				'certificate_type' => $this->input->post('certificate_type'), 
				'serial_number' => $this->input->post('serial_number'), 
				'mean_grade' => $this->input->post('mean_grade'), 
				'points' => $this->input->post('points'), 
				'certificate' => $data['file_name'], 
				'filename' => $data['file_name'],
				'filesize' => $data['file_size'],
				'fpath' => 'final_exams_certificates/' . date('Y') . '/',
				'created_by' => $user -> id ,   
				'created_on' => time()
			);
			$form_data = array_merge($form_data, $form_data_aux);

            $ok=  $this->final_exams_certificates_m->create($form_data);

            if ( $ok)
            {
				
				$length=0;
				$length=$this->input->post('grade');
				$size=count($length);
				 
				for($i=0; $i< $size; ++$i){
				
					$subject = $this->input->post('subject');
					$grade = $this->input->post('grade');
					$form_data = array(
							'certificate_id' => $ok, 
							'subject' => $subject[$i], 
							'grade' => $grade[$i],											
							 'created_by' => $user -> id ,   
							 'created_on' => time()
						);
				// ** Check if grade is empty ****//
				 if(!empty($grade[$i])){
					 
					  $this->final_exams_certificates_m->create_grades($form_data);
				 }
				
				  
				}
                    
					
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
				  
				  
					$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/final_exams_certificates/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Final Exams Certificates ' )->build('admin/create', $data);
		}		
	}

	function view($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/final_exams_certificates/');
            }
         if(!$this->final_exams_certificates_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/final_exams_certificates');
             }
			  
		  $data['p'] =  $this->final_exams_certificates_m->find($id); 
		  $data['grades'] =  $this->final_exams_certificates_m->get_grades($id); 
		  
		$this->template->title('Certificates ' )->build('admin/view', $data);  
		
	}
	
	function edit($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/final_exams_certificates/');
            }
         if(!$this->final_exams_certificates_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/final_exams_certificates');
              }
        //search the item to show in edit form
        $get =  $this->final_exams_certificates_m->find($id); 
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
			$array_thumbnails = array();
			$array_required = explode(",", "certificate");
             $data['final_exams_certificates_m'] = $this->Final_exams_certificates_m->find($id);

			$user = $this -> ion_auth -> get_user();
            // build array for the model
            $form_data = array( 
							'student' => $this->input->post('student'), 
							'certificate_type' => $this->input->post('certificate_type'), 
							'serial_number' => $this->input->post('serial_number'), 
							'mean_grade' => $this->input->post('mean_grade'), 
							'points' => $this->input->post('points'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->final_exams_certificates_m->update_attributes($id, $form_data);

        if ( $done) 
            {
			
               $details = implode(' , ', $form_data);
				 $user = $this->ion_auth->get_user();
					$log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $done, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$ok, 
						'details' => $details,   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
				  
				  
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/final_exams_certificates/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/final_exams_certificates/");
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
             $this->template->title('Edit Final Exams Certificates ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		$files_to_delete = array();

		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/final_exams_certificates');
		}

		//search the item to delete
		if ( !$this->final_exams_certificates_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/final_exams_certificates');
		}
		else
			$final_exams_certificates_m = $this->final_exams_certificates_m->find($id);

		//Save the files into array to delete after
		array_push($files_to_delete, $final_exams_certificates_m->certificate);
 
		//delete the item
	if ( $this->final_exams_certificates_m->delete($id) == TRUE) 
		{
			
			// $details = implode(' , ', $this->input->post());
				 $user = $this->ion_auth->get_user();
					$log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $id, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
						'details' => 'Records Deleted',   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
				  
				  
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));

			//delete the old images
			foreach ($files_to_delete as $index)
			{
				if ( is_file(FCPATH.'public/uploads/final_exams_certificates/files/'.$index) )
					unlink(FCPATH.'public/uploads/final_exams_certificates/files/'.$index);
			}

		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/final_exams_certificates/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'student',
                'label' => 'Student',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'certificate_type',
                'label' => 'Certificate Type',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'serial_number',
                'label' => 'Serial Number',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'mean_grade',
                'label' => 'Mean Grade',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'points',
                'label' => 'Points',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/final_exams_certificates/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 10;
            $config['total_rows'] = $this->final_exams_certificates_m->count();
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
	private function set_upload_options($controller, $field)
	{
		//upload an image options
		$config = array(); 
		if ($field == 'certificate')
		{
			$config['upload_path'] 		= FCPATH.'assets/uploads/'.$controller.'/files/';
			$config['allowed_types'] 	= 'pdf';
			$config['max_size'] 		= '2048';
			$config['encrypt_name']		= TRUE;
		} 
		//create controller upload folder if not exists
		if (!is_dir($config['upload_path']))
		{
			mkdir(FCPATH."public/uploads/$controller/");
			mkdir(FCPATH."public/uploads/$controller/files/");
			mkdir(FCPATH."public/uploads/$controller/img/");
			mkdir(FCPATH."public/uploads/$controller/img/thumbs/");
		}

		return $config;
	} 
}