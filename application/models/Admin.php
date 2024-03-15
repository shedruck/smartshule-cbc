<?php defined('BASEPATH') OR exit('No direct script access allowed');

                        class Admin extends Admin_Controller
                        {
                         /**
                         * Class Constructor
                         */
                        function __construct()
                        {
                        parent::__construct();
			$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                     -> set_partial('top', 'partials/top.php'); 
			if (!$this->ion_auth->logged_in())
                        {
                        redirect('admin/login');
                        }
			$this->load->model('story_books_m');
	}

                /**
                * List All Story Books 
                *
                */
	public function index()
	{
	   $config = $this->set_paginate_options(); //Initialize the pagination class
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			
			if ($this->ion_auth->is_admin()){
				
			        $data['story_books'] = $this->story_books_m->paginate_all($config['per_page'], $page);
					  
					}
		   else{
			    
				$data['story_books'] = $this->story_books_m->my_items($config['per_page'], $page); 
		   } 

          

            //create pagination links
            $data['links'] = $this->pagination->create_links();

            //page number  variable
            $data['page'] = $page;
            $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Story Books ' )->build('admin/list', $data);
	}
        /**
                *Add New Story Books 
                *
                *@param $page
                */
        function create($page = NULL)
        {
            //create control variables
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
			
			$data['education_level'] = $this->story_books_m->populate('education_level', 'id', 'name');
			$data['age_group'] = $this->story_books_m->populate('levels', 'id', 'name');
			$data['book_category'] = $this->story_books_m->populate('books_category', 'id', 'name');

 
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
          
			$array_thumbnails = array();
			$array_required = array();
                  $file ='';				 
                    if (!empty($_FILES['file']['name']))
                    {
                            $this->load->library('files_uploader');
                            $upload_data = $this->files_uploader->upload('file');
                            $file = $upload_data['file_name'];
                    } 
					
					$user = $this -> ion_auth ->user()->row();
					$code = $this -> ion_auth ->code();
					
                       $form_data = array(
				'title' => $this->input->post('title'), 
				'book_category' => $this->input->post('book_category'), 
				'education_level' => $this->input->post('education_level'), 
				'age_group' => $this->input->post('age_group'), 
				'requisition' => $this->input->post('requisition'), 
				'author' => $this->input->post('author'), 
				'flag' => $this->input->post('flag'), 
				'in_stock' => $this->input->post('in_stock'), 
				 'quantity' => $this->input->post('quantity'), 
				'file' =>  $file, 
				'code' =>  $code->code, 
				'reference' => 'SB-014-'.$this->ion_auth->ref_no(8), 
				'company' =>  $code->company_name, 
				
				'publisher' => $this->input->post('publisher'), 
				'price' => $this->input->post('price'), 
				'discount' => $this->input->post('discount'), 
				'description' => $this->input->post('description'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);
			$form_data = array_merge($form_data, $form_data_aux);

            $ok=  $this->story_books_m->create($form_data);

            if ( $ok ) // Insert Successful
            {
                    if( $this->input->post('requisition')=='Featured'){
                       $form_data = array(
						'module_name' => $this->router->fetch_module(), 
						'item_id' => $ok, 
						'url' => $this->input->post('title'), 
						'period' => strtotime($this->input->post('period')), 
						'created_by' => $user -> id ,   
						'created_on' => time()
					);

					$this->ion_auth->create_special_offers($form_data);
				  }
				  
				   $this->session->set_flashdata('message', array( 'type' => 'success', 'text' =>'Story Books '. lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('error', array( 'type' => 'error', 'text' =>'Story Books '. lang('web_create_failed') ));
            }

			redirect('admin/story_books/');

	  }else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
                 //load the view
                 $this->template->title('Add Story Books ' )->build('admin/create', $data);
                }		
	}
                /**
                *Edit  Story Books 
                *
                *@param int $id
                *@param int $page
                */
	function edit($id = FALSE, $page = 0)
	{ 
          
            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/story_books/');
            }
         if(!$this->story_books_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/story_books');
              }
        //search the item to show in edit form
        $get =  $this->story_books_m->find($id); 
		
		$data['education_level'] = $this->story_books_m->populate('education_level', 'id', 'name');
			$data['age_group'] = $this->story_books_m->populate('levels', 'id', 'name');
			$data['book_category'] = $this->story_books_m->populate('books_category', 'id', 'name');

			
            //variables for the upload
            $form_data_aux = array();
            $files_to_delete  = array(); 
            //Rules for validation
            $this->form_validation->set_rules($this->validation());

            //create control variables
            $data['updType'] = 'edit';
            $data['page'] = $page;

            if ($this->form_validation->run() )  //validation has been passed
             {
			
                    $data['story_books_m'] = $this->story_books_m->find($id);
					
					  $file =$get->file;				 
                    if (!empty($_FILES['file']['name']))
                    {
                            $this->load->library('files_uploader');
                            $upload_data = $this->files_uploader->upload('file');
                            $file = $upload_data['file_name'];
                    } 
					

                 $user = $this -> ion_auth -> user()->row();
            // build array for the model
            $form_data = array( 
							'title' => $this->input->post('title'), 
							'book_category' => $this->input->post('book_category'), 
							'education_level' => $this->input->post('education_level'), 
							'age_group' => $this->input->post('age_group'), 
							'requisition' => $this->input->post('requisition'), 
							'author' => $this->input->post('author'), 
							'flag' => $this->input->post('flag'), 
							'in_stock' => $this->input->post('in_stock'), 
			            	 'quantity' => $this->input->post('quantity'), 
								'file' =>  $file, 
							'publisher' => $this->input->post('publisher'), 
							'price' => $this->input->post('price'), 
							'discount' => $this->input->post('discount'), 
							'description' => $this->input->post('description'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
            $done = $this->story_books_m->update_attributes($id, $form_data);

        // the information has  been successfully saved in the db
       if ( $done) 
                {

              if( $this->input->post('requisition')=='Featured'){
                       $form_data = array(
						'module_name' => $this->router->fetch_module(), 
						'item_id' => $id, 
						'url' => $this->input->post('title'), 
						'period' => strtotime($this->input->post('period')), 
						'created_by' => $user -> id ,   
						'created_on' => time()
					);

					$this->ion_auth->create_special_offers($form_data);
				  }
				  
            $this->session->set_flashdata('message', array( 'type' => 'success', 'text' =>'Story Books '. lang('web_edit_success') ));
            redirect("admin/story_books/");
            }
            else
            {
                    $this->session->set_flashdata('error', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
                    redirect("admin/story_books/");
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
             $this->template->title('Edit Story Books ' )->build('admin/create', $data);
	}

                /**
                * Delete Record
                * 
                * @param int $id
                */
	function delete($id = NULL, $page = 1)
	{
		$files_to_delete = array();


            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/story_books');
            }
		//fetch the item to delete
		if ( !$this->story_books_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
 			redirect('admin/story_books');
		}		else
	$story_books_m = $this->story_books_m->find($id);
		//Save the files into array to delete after
		array_push($files_to_delete, $story_books_m->file);
 
	//delete the item
	 if ( $this->story_books_m->delete($id) == TRUE) 
	{
	$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' =>'Story Books '. lang('web_delete_success') ));

			//delete the old images
			foreach ($files_to_delete as $index)
			{
				if ( is_file(FCPATH.'uploads/story_books/files/'.$index) )
					unlink(FCPATH.'uploads/story_books/files/'.$index);
			}
		}
		else
		{
			$this->session->set_flashdata('error', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/story_books/");
	}
  /**
  * Generate Validation Rules
  *
  * @return array()
  */
    private function validation()
    {
$config = array(
                 array(
	 'field' =>'title',
                'label' => 'Title',
                'rules' => 'required|trim|min_length[0]|max_length[60]'),

                 array(
	 'field' =>'book_category',
                 'label' => 'Book Category',
                 'rules' =>'required'),

                 array(
	 'field' =>'education_level',
                 'label' => 'Education Level',
                 'rules' =>'required'),

                 array(
	 'field' =>'age_group',
                 'label' => 'Age Group',
                 'rules' =>'trim'),
				 
				 array(
	 'field' =>'quantity',
                'label' => 'quantity',
                'rules' => 'trim|min_length[0]|max_length[60]'),
				
				array(
	 'field' =>'in_stock',
                'label' => 'in_stock',
                'rules' => 'required|trim|min_length[0]|max_length[60]'),

				 array(
	 'field' =>'flag',
                 'label' => 'flag',
                 'rules' =>'trim'),

                 array(
	 'field' =>'requisition',
                 'label' => 'Requisition',
                 'rules' =>'required'),

                 array(
	 'field' =>'author',
                'label' => 'Author',
                'rules' => 'trim|min_length[0]|max_length[60]'),

                 array(
	 'field' =>'publisher',
                'label' => 'Publisher',
                'rules' => 'trim|min_length[0]|max_length[60]'),

                 array(
	 'field' =>'price',
                'label' => 'Price',
                'rules' => 'required|trim|min_length[0]|max_length[60]'),

                 array(
	 'field' =>'discount',
                'label' => 'Discount',
                'rules' => 'trim|min_length[0]|max_length[60]'),

                array(
	 'field' =>'description',
                'label' => 'Description',
               'rules' => 'trim|min_length[0]'),
		);
	$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        
                /**
                * Generate Pagination Config
                *
                *@return array()
                */
	private function set_paginate_options()
	{
                        $config = array();
                        $config['base_url'] = site_url() . 'admin/story_books/index/';
                        $config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 0;
            $config['total_rows'] = $this->story_books_m->count();
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
            $config['full_tag_open'] = '<ul class="pagination pagination-centered">';
            $config['full_tag_close'] = '</ul>';
            //$choice = $config["total_rows"] / $config["per_page"];
            //$config["num_links"] = round($choice);

            return $config;
	} 
              /**
              * Generate Upload  Config
              *
              * @return array()
              */
	private function set_upload_options($controller, $field)
	{
            //upload an image options
            $config = array(); 
		if ($field == 'file')
		{
			$config['upload_path'] 	= FCPATH.'uploads/'.$controller.'/files/';
			$config['allowed_types'] 	= 'pdf';
			$config['max_size'] 		= '2048';
			$config['encrypt_name']		= TRUE;
		} 
            //create controller upload folder if not exists
            if (!is_dir($config['upload_path']))
            {
              mkdir(FCPATH . "uploads/$controller/", 777, TRUE);
              mkdir(FCPATH . "uploads/$controller/thumbs/", 777, TRUE);
            }
            return $config;
	} 

        
}