<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Admin extends Admin_Controller
        {
        function __construct()
        {
        parent::__construct();
			
			if (!$this->ion_auth->logged_in())
	{
	redirect('admin/login');
	}
			$this->load->model('book_list_m_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['book_list'] = $this->book_list_m_m->paginate_all($config['per_page'], $page);
                $data['books']=$this->book_list_m_m->view();
            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];
               
            //load view
            $this->template->title(' Book List ' )->build('admin/grid_view', $data);
	}

        public function listView(){
                $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['book_list']=$this->book_list_m_m->view();
                $data['class']=$this->book_list_m_m->drpDownClass();
                $data['subjects']=$this->book_list_m_m->drpDownSubject();
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                       
                $this->template->title('Book List- List View')->build('admin/list',$data);
        }

        public function filterByClass(){
                if(isset($_POST['filter_by_class'])){
                        $class= $this->input->post('class');
                        $config = $this->set_paginate_options(); //Initialize the pagination class
                        $this->pagination->initialize($config);
                        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                        $data['book_lists']=$this->book_list_m_m->filterbyclass($class);

                        $data['links'] = $this->pagination->create_links();

                        //page number  variable
                        $data['page'] = $page;
                        $data['per'] = $config['per_page'];
                        //load the view
                        $this->template->title('Book List- List View')->build('admin/filter_class',$data);
                }
               
                $this->template->title('Book List- List View')->build('admin/filter_class');
        }

        public function filterBySubject(){
                if(isset($_POST['filter_by_subject'])){
                        $subject= $this->input->post('subject');
                        $config = $this->set_paginate_options(); //Initialize the pagination class
                        $this->pagination->initialize($config);
                        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                        $data['book_lists']=$this->book_list_m_m->filterbysubject($subject);

                        $data['links'] = $this->pagination->create_links();

                        //page number  variable
                        $data['page'] = $page;
                        $data['per'] = $config['per_page'];
                        //load the view
                        $this->template->title('Book List- List View')->build('admin/filter_subject',$data);
                }
               
                $this->template->title('Book List- List View')->build('admin/filter_subject');
        }

        function create($page = NULL)
        {      
               
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
                $data['class_rooms'] = $this->book_list_m_m->getClasses();
                $data['subjects'] = $this->book_list_m_m->getSubjects();
                $user = $this -> ion_auth -> get_user();
                //form validation
                $this->form_validation->set_rules('class','Class','required');
                $this->form_validation->set_rules('subject','Subject','required');
                $this->form_validation->set_rules('book_name','Book Name','required');
                $this->form_validation->set_rules('publisher','Publisher','required');
                $this->form_validation->set_rules('price','Price','required');
                if(!$this->form_validation->run()){
                        //load view
                        $this->template->title('Add Book List ' )->build('admin/create', $data);  
                }else{
                        //image upload starts here

                        $dest = FCPATH ."/uploads/book_list/". date('Y') . '/';
                        if (!is_dir($dest)){
                        
                                mkdir($dest, 0777, true);
                        }
                        $config['upload_path']= $dest;
                        $config['allowed_types']= 'gif|jpeg|png|jpg';
                        $config['max_size']= '5028';
                        $config['max_width']= '0';
                        $config['max_height']= '0';
                        

                        $this->load->library('upload',$config);
                        if(!$this->upload->do_upload('userfile')){
                                $errors= array('error' => $this->upload->display_errors());
                                // print_r($errors);
                                $post_image= "noimage.jpg";
                                // print_r(array('upload_data' => $this->upload->data()));
                        }else{
                                $data= array('upload_data' => $this->upload->data());
                                $post_image= $_FILES['userfile']['name'];
                                // print_r(array('upload_data' => $this->upload->data()));
                        }
                                $form_data = array(
                                        'thumbnail'=>$post_image,
                                        'class' => $this->input->post('class'), 
                                        'subject' => $this->input->post('subject'), 
                                        'book_name' => $this->input->post('book_name'), 
                                        'publisher' => $this->input->post('publisher'), 
                                        'price' => $this->input->post('price'),
                                        'created_by' => $user -> id ,   
                                        'created_on' => time()
                                );
                        $ok=  $this->book_list_m_m->create($form_data);
                        if ( $ok){
                                $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                        }else{
                                $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                        }
                        redirect('admin/book_list/');
                }
                

                //load view
                $this->template->title('Add Book List ' )->build('admin/create', $data);
	}

       
	function edit($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/book_list/');
            }
         if(!$this->book_list_m_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/book_list');
              }
        //search the item to show in edit form
        $get =  $this->book_list_m_m->find($id); 
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
			$array_thumbnails 	= explode(",", "thumbnail");
			$array_required = explode(",", "thumbnail");
                    $data['book_list_m_m'] = $this->Book_list_m_m->find($id);

                    $this->load->library('upload');
                    $this->load->library('image_lib');

                    foreach ($_FILES as $index => $value)
                    {
                            if ($value['name'] != '')
                            {
                        //uploads rules for $index
                        if ($index == 'thumbnail')
                        {
                                $this->upload->initialize($this->set_upload_options('book_list', 'thumbnail'));
                        }

                                //upload the image
                                if ( ! $this->upload->do_upload($index))
                                {
                                        $data['upload_error'][$index] = $this->upload->display_errors("<span class='error'>", "</span>");

                                        //load the view and the layout
                                        $this->template->build('admin/create', $data);

                                        return FALSE;
                                }
                                else
                                {
                                        //create an array to send to image_lib library to create the thumbnail
                                        $info_upload = $this->upload->data();

                                        //Save the name an array to save on BD before
                                        $form_data_aux[$index]		=	$info_upload["file_name"];

                                        //Save the name of old files to delete
                                        array_push($files_to_delete, $data['book_list_m_m']->$index);

                                        //Initializing the imagelib library to create the thumbnail

                                        if (in_array($index, $array_thumbnails))
                                        {

            //thumbnails rules for $index
            if ($index == 'thumbnail')
            {
                    $this->image_lib->initialize($this->set_thumbnail_options($info_upload, 'book_list', 'thumbnail'));
            }

                //create the thumbnail
                if ( ! $this->image_lib->resize())
                {
                        $data['upload_error'][$index] = $this->image_lib->display_errors("<span class='error'>", "</span>");

                        //load the view and the layout
                        $this->template->build('admin/create', $data);

                        return FALSE;
                }
        }
}
}

			}

			$user = $this -> ion_auth -> get_user();
            // build array for the model
                                 $form_data = array( 
							'class' => $this->input->post('class'), 
							'subject' => $this->input->post('subject'), 
							'book_name' => $this->input->post('book_name'), 
							'publisher' => $this->input->post('publisher'), 
                                                        'price' =>$this->input->post('price'),
                                                        'modified_by' => $user -> id ,   
                                                        'modified_on' => time() 
                                                );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->book_list_m_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				//delete the old images
				foreach ($files_to_delete as $index)
				{
					if ( is_file(FCPATH.'public/uploads/book_list/img/'.$index) )
						unlink(FCPATH.'public/uploads/book_list/img/'.$index);

					if ( is_file(FCPATH.'public/uploads/book_list/img/thumbs/'.$index) )
						unlink(FCPATH.'public/uploads/book_list/img/thumbs/'.$index);
				}

				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/book_list/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/book_list/");
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
             $this->template->title('Edit Book List ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		$files_to_delete = array();

		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/book_list');
		}

		//search the item to delete
		if ( !$this->book_list_m_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/book_list');
		}
		else
			$book_list_m_m = $this->book_list_m_m->find($id);

		//Save the files into array to delete after
		array_push($files_to_delete, $book_list_m_m->thumbnail);
 
		//delete the item
		                     if ( $this->book_list_m_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));

			//delete the old images
			foreach ($files_to_delete as $index)
			{
				if ( is_file(FCPATH.'public/uploads/book_list/img/'.$index) )
					unlink(FCPATH.'public/uploads/book_list/img/'.$index);

				if ( is_file(FCPATH.'public/uploads/book_list/img/thumbs/'.$index) )
					unlink(FCPATH.'public/uploads/book_list/img/thumbs/'.$index);
			}

		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/book_list/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'class',
                 'label' => 'Class',
                 'rules' =>'required|xss_clean'),

                 array(
		 'field' =>'subject',
                 'label' => 'Subject',
                 'rules' =>'required|xss_clean'),

                 array(
		 'field' =>'book_name',
                'label' => 'Book Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'publisher',
                'label' => 'Publisher',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/book_list/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 10;
            $config['total_rows'] = $this->book_list_m_m->count();
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
		if ($field == 'thumbnail')
		{
			$config['upload_path'] 	= FCPATH.'uploads/'.$controller.'/img/';
			$config['allowed_types'] 	= 'gif|jpg|png';
			$config['encrypt_name']	= TRUE;
			$config['max_width']  		= '0';
			$config['max_height']  	= '0';
			$config['max_size'] 		= '2048';
		}
		//create controller upload folder if not exists
		if (!is_dir($config['upload_path']))
		{
			mkdir(FCPATH."uploads/$controller/",'0777',true);
			mkdir(FCPATH."uploads/$controller/files/",'0777',true);
			mkdir(FCPATH."uploads/$controller/img/",'0777',true);
			mkdir(FCPATH."uploads/$controller/img/thumbs/",'0777',true);
		}

		return $config;
	} 

	private function set_thumbnail_options($info_upload, $controller, $field)
	{
		$config = array();
		$config['image_library'] = 'gd2';
		$config['source_image'] = FCPATH.'public/uploads/'.$controller.'/img/'.$info_upload["file_name"];
		$config['new_image'] = FCPATH.'public/uploads/'.$controller.'/img/thumbs/'.$info_upload["file_name"];
		$config['create_thumb'] = TRUE; 
		if ($field == 'thumbnail')
		{
			$config['maintain_ratio'] = FALSE;
			$config['master_dim'] = 'width';
			$config['width'] = 100;
			$config['height'] = 100;
			$config['thumb_marker'] = '';
		} 
		return $config;
        
	} 

        
}