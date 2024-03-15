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
			$this->load->model('board_members_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['board_members'] = $this->board_members_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Board Members ' )->build('admin/grid', $data);
	}

	public function inactive()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['board_members'] = $this->board_members_m->paginate_inactive($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Board Members ' )->build('admin/grid', $data);
	}

	public function list_view()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['board_members'] = $this->board_members_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Board Members ' )->build('admin/list', $data);
	}
	
	function profile($id = FALSE)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/board_members/');
                }
                if (!$this->board_members_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/board_members');
                }

                $post = $this->board_members_m->find($id);
                $data['post'] = $post;

                $this->load->model('record_salaries/record_salaries_m');


                $data['group'] = $this->board_members_m->populate('groups', 'id', 'name');
                $data['contracts'] = $this->board_members_m->populate('contracts', 'id', 'name');
                $data['departments'] = $this->board_members_m->populate('departments', 'id', 'name');
               
                $this->template->title(' Board Member Profile')->build('admin/view', $data);
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
          
			$array_thumbnails = array();
			$array_required = array();
               /*
               * TRY THIS FOR UPLOAD*/
            $file = '';

            if (!empty($_FILES['file']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('file');
                $file = $upload_data['file_name'];
            } 
              
			$national_id = '';

            if (!empty($_FILES['national_id']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('national_id');
                $national_id = $upload_data['file_name'];
            } 
              
        $user = $this -> ion_auth -> get_user();
        $form_data = array(
				'title' => $this->input->post('title'), 
				'first_name' => $this->input->post('first_name'), 
				'last_name' => $this->input->post('last_name'), 
				'gender' => $this->input->post('gender'), 
				'phone' => $this->input->post('phone'), 
				'work_place' => $this->input->post('work_place'), 
				'file' => $file, 
				'national_id' => $national_id, 
				'status' => 1, 
				'email' => $this->input->post('email'), 
				'position' => $this->input->post('position'), 
				'date_joined' => strtotime($this->input->post('date_joined')), 
				'profile' => $this->input->post('profile'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);
			$form_data = array_merge($form_data, $form_data_aux);

            $ok=  $this->board_members_m->create($form_data);

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

			redirect('admin/board_members/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Board Members ' )->build('admin/create', $data);
		}		
	}

	function disable($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/board_members/');
            }
         if(!$this->board_members_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/board_members');
              }
			  
          $done = $this->board_members_m->update_attributes($id, array('status'=>0));
			   
			   
        if ( $done) 
            {
				//$details = implode(' , ', $this->input->post());
				 $user = $this->ion_auth->get_user();
				 $log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $done, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
						'details' => 'disabled',   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
								  
								  
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/board_members/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/board_members/");
			}
	}
	
	function enable($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/board_members/');
            }
         if(!$this->board_members_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/board_members');
              }
			  
          $done = $this->board_members_m->update_attributes($id, array('status'=>1));
			   
			   
        if ( $done) 
            {
				//$details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
								 $log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $done, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
										'details' => 'Enabled',   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
				
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/board_members/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/board_members/");
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
                    redirect('admin/board_members/');
            }
         if(!$this->board_members_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/board_members');
              }
        //search the item to show in edit form
        $get =  $this->board_members_m->find($id); 
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
		
            $data['board_members_m'] = $this->board_members_m->find($id);

             $file = $get->file;

            if (!empty($_FILES['file']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('file');
                $file = $upload_data['file_name'];
            } 
			
			$national_id = $get->national_id;

            if (!empty($_FILES['national_id']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('national_id');
                $national_id = $upload_data['file_name'];
            } 
			
			
			$user = $this -> ion_auth -> get_user();
            // build array for the model
            $form_data = array( 
							'title' => $this->input->post('title'), 
							'first_name' => $this->input->post('first_name'), 
							'last_name' => $this->input->post('last_name'), 
							'gender' => $this->input->post('gender'), 
							'phone' => $this->input->post('phone'), 
							'work_place' => $this->input->post('work_place'), 
							'file' => $file, 
							'national_id' => $national_id, 
							'email' => $this->input->post('email'), 
							'position' => $this->input->post('position'), 
				             'date_joined' => strtotime($this->input->post('date_joined')), 
							'profile' => $this->input->post('profile'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->board_members_m->update_attributes($id, $form_data);

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
				redirect("admin/board_members/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/board_members/");
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
             $this->template->title('Edit Board Members ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		$files_to_delete = array();

		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/board_members');
		}

		//search the item to delete
		if ( !$this->board_members_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/board_members');
		}
		else
			$board_members_m = $this->board_members_m->find($id);

		//Save the files into array to delete after
		array_push($files_to_delete, $board_members_m->file);
 
		//delete the item
  if ( $this->board_members_m->delete($id) == TRUE) 
		{
			                 // $details = implode(' , ', $this->input->post());
								 $user = $this->ion_auth->get_user();
								 $log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $id, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
										'details' => 'deleted record',   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);
			
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));

			

		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/board_members/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'title',
                'label' => 'Title',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'first_name',
                'label' => 'First Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'last_name',
                'label' => 'Last Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'gender',
                 'label' => 'Gender',
                 'rules' =>'required|xss_clean'),

				 array(
		 'field' =>'national_id',
                 'label' => 'national_id',
                 'rules' =>'trim'),

				 array(
		 'field' =>'work_place',
                 'label' => 'work place',
                 'rules' =>'trim'),

                 array(
		 'field' =>'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'position',
                'label' => 'Position',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'date_joined',
                 'label' => 'Date Joined',
                 'rules' =>'required|xss_clean'),

                array(
		 'field' =>'profile',
                'label' => 'Profile',
                'rules' => 'trim|xss_clean|min_length[0]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/board_members/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 1000000000;
            $config['total_rows'] = $this->board_members_m->count();
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