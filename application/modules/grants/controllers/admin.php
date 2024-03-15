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
			$this->load->model('grants_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['grants'] = $this->grants_m->paginate_all($config['per_page'], $page);
              $data['bank'] = $this->grants_m->list_banks();
            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Grants ' )->build('admin/list', $data);
	}

        function create($page = NULL)
        {
            //create control variables
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
             $data['bank'] = $this->grants_m->list_banks();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
          
			$array_thumbnails = array();
			$array_required = array();
               /*
               * TRY THIS FOR UPLOAD*/
              $file = '';

            if (!empty($_FILES['userfile']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('userfile');
                $file = $upload_data['file_name'];
            } 
               
$user = $this -> ion_auth -> get_user();
        $form_data = array(
				'grant_type' => $this->input->post('grant_type'), 
				'date' => strtotime($this->input->post('date')), 
				'file' => $file, 
				'amount' => $this->input->post('amount'), 
				'bank' => $this->input->post('bank'), 
				'payment_method' => $this->input->post('payment_method'), 
				'purpose' => $this->input->post('purpose'), 
				'school_representative' => $this->input->post('school_representative'), 
				'contact_person' => $this->input->post('contact_person'), 
				'contact_details' => $this->input->post('contact_details'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);
			$form_data = array_merge($form_data, $form_data_aux);

            $ok=  $this->grants_m->create($form_data);

            if ( $ok)
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
								  
					
					$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/grants/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Grants ' )->build('admin/create', $data);
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
                    redirect('admin/grants/');
            }
         if(!$this->grants_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/grants');
              }
        //search the item to show in edit form
        $get =  $this->grants_m->find($id); 
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
			   
             $data['grants_m'] = $this->grants_m->find($id);
			 
			   $file = $get->file;

            if (!empty($_FILES['userfile']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('userfile');
                $file = $upload_data['file_name'];
            } 

			$user = $this -> ion_auth -> get_user();
            // build array for the model
            $form_data = array( 
							'grant_type' => $this->input->post('grant_type'), 
				             'date' => strtotime($this->input->post('date')), 
							'file' => $file, 
							'amount' => $this->input->post('amount'), 
							'bank' => $this->input->post('bank'), 
							'payment_method' => $this->input->post('payment_method'), 
							'purpose' => $this->input->post('purpose'), 
							'school_representative' => $this->input->post('school_representative'), 
							'contact_person' => $this->input->post('contact_person'), 
							'contact_details' => $this->input->post('contact_details'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->grants_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				
				 $details = implode(' , ', $this->input->post());
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

				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/grants/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/grants/");
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
			    $data['bank'] = $this->grants_m->list_banks();
             //load the view and the layout
             $this->template->title('Edit Grants ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		$files_to_delete = array();

		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/grants');
		}

		//search the item to delete
		if ( !$this->grants_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/grants');
		}
		else
			$grants_m = $this->grants_m->find($id);

		//Save the files into array to delete after
		array_push($files_to_delete, $grants_m->file);
 
		//delete the item
  if ( $this->grants_m->delete($id) == TRUE) 
		{
			// $details = implode(' , ', $this->input->post());
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
								  
								  
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));

			//delete the old images
			foreach ($files_to_delete as $index)
			{
				if ( is_file(FCPATH.'public/uploads/grants/files/'.$index) )
					unlink(FCPATH.'public/uploads/grants/files/'.$index);
			}

		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/grants/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'grant_type',
                 'label' => 'Grant Type',
                 'rules' =>'required|xss_clean'),

                 array(
		 'field' =>'date',
                 'label' => 'Date',
                 'rules' =>'required|xss_clean'),

                 array(
		 'field' =>'amount',
                'label' => 'Amount',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'payment_method',
                 'label' => 'Payment Method',
                 'rules' =>'required|xss_clean'),

				 array(
		 'field' =>'bank',
                 'label' => 'Bank',
                 'rules' =>'trim'),

                array(
		 'field' =>'purpose',
                'label' => 'Purpose',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[500]'),

                 array(
		 'field' =>'school_representative',
                'label' => 'School Representative',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'contact_person',
                'label' => 'Contact Person',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'contact_details',
                'label' => 'Contact Details',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/grants/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100000000000;
            $config['total_rows'] = $this->grants_m->count();
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
		if ($field == 'file')
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