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
			$this->load->model('enotes_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['enotes'] = $this->enotes_m->get_all_enotes($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

			//page number  variable
			 $data['page'] = $page;
             $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' E-notes ' )->build('trs/list', $data);
	}
	
	
	 /**
         * Shows a Sane File Size 
         * 
         * @param double $kb
         * @param int $precision
         * @return double
         */
        function file_sizer($kb, $precision = 2)
        {
                $base = log($kb) / log(1024);
                $suffixes = array('', ' kb', ' MB', ' GB', ' TB');

                return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }
		

        function new_enotes($page = NULL)
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
          
		  $term = $this->input->post('term');

          $file_name = '';			
          $file_size = '';			
          $file_path = '';			
          $file_type = '';			
        		
		if (!empty($_FILES['file']['name']))
            {
			    $dest = FCPATH . "/uploads/enotes/" . date('Y') . '/term'.$term.'/';	
				
			    $config['upload_path'] = $dest;
			    $config['allowed_types'] = 'jpg|png|pdf|doc|docx|gif|jpeg';
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
						$this->template->build('trs/create', $data);

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
				'term' => $term, 
				'year' => $this->input->post('year'), 
				'class' => $this->input->post('class'), 
				'subject' => $this->input->post('subject'), 
				'topic' => $this->input->post('topic'), 
				'file_name' => $file_name, 
				'file_path' =>  "/uploads/enotes/" . date('Y') . '/term'.$term.'/' , 
				'file_size' => $file_size, 
				'file_type' => $file_type, 
				'subtopic' => $this->input->post('subtopic'), 
				'soft' => $this->input->post('soft'), 
				'status' => 0, 
				'remarks' => $this->input->post('remarks'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);
			$form_data = array_merge($form_data, $form_data_aux);

            $ok=  $this->enotes_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('enotes/trs');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('New E-notes ' )->build('trs/create', $data);
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
                    redirect('enotes/trs/');
            }
         if(!$this->portal_m-> exists_('enotes','id',$id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('enotes/trs');
              }
        //search the item to show in edit form
        $data['post'] =  $this->enotes_m->get($id); 
		
		 //load the view and the layout
		 $this->template->title('View E-notes ' )->build('trs/view', $data);
	}	
		
	function edit($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('enotes/trs/');
            }
         if(!$this->portal_m-> exists_('enotes','id',$id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('enotes/trs');
              }
        //search the item to show in edit form
        $get =  $this->enotes_m->find($id); 
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
				 
				   $term = $this->input->post('term');

          $file_name = $get->file_name;			
          $file_size = $get->file_size;			
          $file_type = $get->file_type;			
          $file_path = $get->file_path;			
        		
		if (!empty($_FILES['file']['name']))
            {
			    $dest = FCPATH . "/uploads/enotes/" . date('Y') . '/term'.$term.'/';	
				
			    $config['upload_path'] = $dest;
			    $config['allowed_types'] = 'jpg|png|pdf|doc|docx|gif|jpeg';
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
				'term' => $this->input->post('term'), 
				'year' => $this->input->post('year'), 
				'class' => $this->input->post('class'), 
				'subject' => $this->input->post('subject'),
				 'topic' => $this->input->post('topic'), 
				'subtopic' => $this->input->post('subtopic'),
                 'file_name' => $file_name, 
				'file_path' =>  "/uploads/enotes/" . date('Y') . '/term'.$term.'/' , 
				'file_size' => $file_size, 				
				'file_type' => $file_type, 				
				'soft' => $this->input->post('soft'), 
				'remarks' => $this->input->post('remarks'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->enotes_m->update_attributes($id, $form_data);

        if ( $done) 
                {


				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("enotes/trs");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("enotes/trs");
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
             $this->template->title('Edit Enotes ' )->build('trs/create', $data);
	}
	
	
	function update_status($id = FALSE, $status)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('enotes/trs');
            }
			
         if(!$this->portal_m-> exists_('enotes','id',$id)  )
             {
				 
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
             redirect('enotes/trs');
		   
              }
			  
	       $done = $this->enotes_m->update_attributes($id, array('status'=>$status));

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect('enotes/trs');
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect('enotes/trs');
			}

			  
	}


	function delete($id = NULL, $page = NULL)
	{
		$files_to_delete = array();

		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('enotes/trs');
		}

		//search the item to delete
		if ( !$this->portal_m-> exists_('enotes','id',$id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('enotes/trs');
		}
		else
			$enotes_m = $this->enotes_m->find($id);

		//Save the files into array to delete after
		array_push($files_to_delete, $enotes_m->file);
 
		//delete the item
	  if ( $this->enotes_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));

			

		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect('enotes/trs');
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'term',
                'label' => 'Term',
                'rules' => 'required|trim'),

                 array(
		 'field' =>'year',
                'label' => 'Year',
                'rules' => 'required|trim'),

                 array(
		 'field' =>'class',
                'label' => 'Class',
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
		 'field' =>'subtopic',
                'label' => 'Sub Topic',
                'rules' => 'trim'),

                array(
		 'field' =>'soft',
                'label' => 'Soft',
                'rules' => 'trim'),

                array(
		 'field' =>'remarks',
                'label' => 'Remarks',
                'rules' => 'trim'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'enotes/trs/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100;
            $config['total_rows'] = $this->enotes_m->count();
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