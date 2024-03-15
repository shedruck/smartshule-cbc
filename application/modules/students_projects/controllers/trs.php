<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Trs extends Trs_Controller
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
			$this->load->model('students_projects_m');
	}

	public function index()
	{	   
	     $config = $this->set_paginate_options(); //Initialize the pagination class
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		$data['students_projects'] = $this->students_projects_m->paginate_trs($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Students Projects ' )->build('index/list', $data);
	}
	
	  function file_sizer($kb, $precision = 2)
        {
                $base = log($kb) / log(1024);
                $suffixes = array('', ' kb', ' MB', ' GB', ' TB');

                return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
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
          
		  
		  $file_name = '';			
          $file_size = '';			
          $file_path = '';			
          $file_type = '';			
        		
		if (!empty($_FILES['file']['name']))
            {
				
				
			    $dest = FCPATH . "/uploads/students_projects/" . date('Y').'/'.$this->input->post('term');	
				
			    $config['upload_path'] = $dest;
			    $config['allowed_types'] = 'jpg|png|gif|jpeg';
				$config['max_size'] = 1024 * 50;
				$config['encrypt_name'] = FALSE;
				
			    $this->load->library('upload', $config);
		    	
		     if (!is_dir($dest))
                {
					 
                        mkdir($dest, 0777, true);
						
                }
				//$data = $this->upload->do_upload('file');
				
				 //upload the image
				
				//upload the image
				if ( ! $this->upload->do_upload('file'))
				{
						$data['upload_error'][$index] = $this->upload->display_errors("<span class='error'>", "</span>");

						//load the view and the layout
						$this->template->build('admin/create', $data);

						return FALSE;
				}

			    $data = $this->upload->data();
				
				$file_name = $data['file_name'];
				$file_type = $data['file_type'];
				$file_path = $dest ;
				$file_size = $this->file_sizer($data['file_size']) ;
			  
			 }
		
        $user = $this -> ion_auth -> get_user();
        $form_data = array(
				'level' => $this->input->post('level'), 
				'student' => $this->input->post('student'), 
				'year' => $this->input->post('year'), 
				'term' => $this->input->post('term'), 
				'subject' => $this->input->post('subject'), 
				'strand' => $this->input->post('strand'), 
				'remarks' => $this->input->post('remarks'), 
				
				'file_name' => $file_name, 
				'file_path' => "/uploads/students_projects/" . date('Y').'/'.$this->input->post('term') , 
				'file_size' => $file_size, 
				'file_type' => $file_type,
				
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);
			$form_data = array_merge($form_data, $form_data_aux);

            $ok=  $this->students_projects_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('students_projects/trs');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Students Projects ' )->build('index/create', $data);
		}		
	}
	
	function view($id = FALSE, $page = 0)
    {
        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/students_projects/');
        }
        if (!$this->students_projects_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/students_projects');
        }
        //search the item to show in edit form
        $get = $this->students_projects_m->find($id);

        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('View Scheme of work ')->build('index/view', $data);
    }

	function edit($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('students_projects/trs');
            }
         if(!$this->students_projects_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/students_projects');
              }
        //search the item to show in edit form
        $get =  $this->students_projects_m->find($id); 
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
				 
				 
		 $file_name = $get->file_name;			
          $file_size = $get->file_size;			
          $file_type = $get->file_type;			
          $file_path = $get->file_path;			
        		
		if (!empty($_FILES['file']['name']))
            {
				
				
			    $dest = FCPATH . "/uploads/students_projects/" . date('Y').'/'.$this->input->post('term');	
				
			    $config['upload_path'] = $dest;
			    $config['allowed_types'] = 'jpg|png|gif|jpeg';
				$config['max_size'] = 1024 * 50;
				$config['encrypt_name'] = FALSE;
				
			    $this->load->library('upload', $config);
		    	
		     if (!is_dir($dest))
                {
					 
                        mkdir($dest, 0777, true);
						
                }
				//$data = $this->upload->do_upload('file');
				
				 //upload the image
				
				//upload the image
				if ( ! $this->upload->do_upload('file'))
				{
						$data['upload_error'][$index] = $this->upload->display_errors("<span class='error'>", "</span>");

						//load the view and the layout
						$this->template->build('admin/create', $data);

						return FALSE;
				}

			    $data = $this->upload->data();
				
				$file_name = $data['file_name'];
				$file_type = $data['file_type'];
				$file_path = $dest ;
				$file_size = $this->file_sizer($data['file_size']) ;
			  
			 }
			 
			 
			
			$user = $this -> ion_auth -> get_user();
            // build array for the model
            $form_data = array( 
							'level' => $this->input->post('level'), 
							'student' => $this->input->post('student'), 
							'year' => $this->input->post('year'), 
							'term' => $this->input->post('term'), 
							'subject' => $this->input->post('subject'), 
							'strand' => $this->input->post('strand'), 
							'remarks' => $this->input->post('remarks'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->students_projects_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				//delete the old images
				foreach ($files_to_delete as $index)
				{
					if ( is_file(FCPATH.'public/uploads/students_projects/files/'.$index) )
						unlink(FCPATH.'public/uploads/students_projects/files/'.$index);
				}

				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("students_projects/trs");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("students_projects/trs");
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
             $this->template->title('Edit Students Projects ' )->build('index/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		$files_to_delete = array();

		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('students_projects/trs');
		}

		//search the item to delete
		if ( !$this->students_projects_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('students_projects/trs');
		}
		else
			$students_projects_m = $this->students_projects_m->find($id);

		//Save the files into array to delete after
		array_push($files_to_delete, $students_projects_m->file);
 
		//delete the item
		                     if ( $this->students_projects_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));

			//delete the old images
			foreach ($files_to_delete as $index)
			{
				if ( is_file(FCPATH.'public/uploads/students_projects/files/'.$index) )
					unlink(FCPATH.'public/uploads/students_projects/files/'.$index);
			}

		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("students_projects/trs");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'level',
                'label' => 'Level',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'student',
                'label' => 'Student',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'term',
                'label' => 'Term',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'subject',
                'label' => 'Subject',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'strand',
                'label' => 'Strand',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                array(
		 'field' =>'remarks',
                'label' => 'Remarks',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'students_projects/trs/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100;
            $config['total_rows'] = $this->students_projects_m->count();
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