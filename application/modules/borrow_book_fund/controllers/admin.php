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
			/* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
        {
             $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
			redirect('admin');
        }*/
			
			$this->load->model('borrow_book_fund_m');
	}


	public function index()
	{
	   $config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

 		$data['borrow_book_fund'] = $this->borrow_book_fund_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

		//page number  variable
		 $data['page'] = $page;
		 $data['per'] = $config['per_page'];
		 $data['books']=$this->borrow_book_fund_m->populate('book_fund','id','title');
		 $data['fine']=$this->borrow_book_fund_m->lib_settings();
		 
		 $data['classes_groups'] = $this->borrow_book_fund_m->populate('class_groups','id','name');
         $data['classes'] = $this->borrow_book_fund_m->populate('classes','id','class');
         $data['class_str'] = $this->borrow_book_fund_m->populate('classes','id','stream');
         $data['stream_name'] = $this->borrow_book_fund_m->populate('class_stream','id','name');
		 
         //$data['class'] = $classes_groups [$classes[$id]].' '.$stream_name[$class_str[$id]];

            //load view
            $this->template->title(' Give out  Book Fund ' )->build('admin/list', $data);
	}
	
	function per_class($id=NULL){
		
		  
         $data['students'] = $this->borrow_book_fund_m->fetch_full_students($id);
         $classes_groups = $this->borrow_book_fund_m->populate('class_groups','id','name');
         $classes = $this->borrow_book_fund_m->populate('classes','id','class');
         $class_str = $this->borrow_book_fund_m->populate('classes','id','stream');
         $stream_name = $this->borrow_book_fund_m->populate('class_stream','id','name');
		 
         $data['class'] = $classes_groups [$classes[$id]].' '.$stream_name[$class_str[$id]];
		
		  //create control variables
            $data['updType'] = 'create';
            $form_data_aux  = array();
            $data['page'] = ( $this->uri->segment(4) )  ? $this->uri->segment(4) : $page;
 
        //Rules for validation
        $this->form_validation->set_rules($this->validation_class());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK! 
		
		        $user = $this -> ion_auth -> get_user();
		        $stud_ids = array();   
                $stud_ids = $this->input->post('sids');
				
			
				
				 if (is_array($stud_ids) && count($stud_ids))
                     {
							$i=0; 
                            $students_with = 0;							
						 foreach($stud_ids as $st){
				         			$i++;			 
							$book = $this->input->post('book');
							$remarks = $this->input->post('remarks');
							
							  $t_books=$this->borrow_book_fund_m->total_quantity($book);
							  $t_borrowed=$this->borrow_book_fund_m->borrowed($book);
							   
							  if($t_borrowed>$t_books->t_quantity || $t_borrowed==$t_books->t_quantity){
								  $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => '<span style="color:red">Sorry, there is no enough stock for borrowing</span>' ));
								  redirect('admin/borrow_book_fund/create');
							  }
							  
							  if($this->borrow_book_fund_m-> exists_student_book($st,$book)){
								   $students_with =++$i;
							  }
							else{
									$table_list = array(
									
									'borrow_date' => strtotime($this->input->post('borrow_date')), 
									'student' => $st, 
									'book' => $book, 
									'status'=>1,
									'remarks' => $remarks[$i], 
									 'created_by' => $user -> id ,   
									 'created_on' => time()
								);
								
								$ok= $this->borrow_book_fund_m->create($table_list);
								
								$details = implode(' , ', $table_list);
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
								  
								  
			             	}
						 }
					}
		      
            if ( $ok ) 
            {
                    if( $students_with==0){
							$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Books Were successfully Given Out' ));
					}else{
							$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => 'Books Were successfully Given Out. '.  $students_with.' had already received this book'));
					}
				
            }
            else
            {
				    if( $students_with>0){
						
							$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => 'Books Were successfully Given Out. Some Students had already received this book. Please check again')); 
							
					}
                   
            }

			redirect('admin/borrow_book_fund/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get->{$field['field']}  = set_value($field['field']);
                }
		 
		
		}	
		
		 $data['result'] = $get; 
		 $data['books']=$this->borrow_book_fund_m->list_books();
		 //load the view and the layout
		 $this->template->title('Add Give out  Book Fund ' )->build('admin/per_class', $data);
		
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
      
			
			    $length=0;
				$length=$this->input->post('book');
				$size=count($length);
				//Check whether this student borrow doesn't exceeds limit
				$limit=$this->borrow_book_fund_m->lib_settings();
				$t_borrowed=$this->borrow_book_fund_m->count_book_per_student($this->input->post('student'));
				
				if($t_borrowed==$limit || $t_borrowed>$limit){
				   $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => '<span style="color:red">Sorry, this student has reached the maximum borrow books</span>' ));
							  redirect('admin/borrow_book_fund/create');
				}
				 
	      for($i=0; $i< $size; ++$i){
					//status =1 calculate rem days
					//status =2 book returned
			
						$book = $this->input->post('book');
						$remarks = $this->input->post('remarks');
						
				
						$table_list = array(
							
							'borrow_date' => strtotime($this->input->post('borrow_date')), 
							'student' => $this->input->post('student'), 
							'book' => $book[$i], 
							'status'=>1,
							'remarks' => $remarks[$i], 
							 'created_by' => $user -> id ,   
							 'created_on' => time()
						);
						
				$ok= $this->borrow_book_fund_m->create($table_list);
				
				$details = implode(' , ', $table_list);
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
								  
								  
				 
				 }

            if ( $ok ) 
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/borrow_book_fund/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get->{$field['field']}  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
				 $data['books']=$this->borrow_book_fund_m->list_books();
		 //load the view and the layout
		 $this->template->title('Add Give out  Book Fund ' )->build('admin/create', $data);
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
                    redirect('admin/borrow_book_fund/');
            }
         if(!$this->borrow_book_fund_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/borrow_book_fund');
              }
        //search the item to show in edit form
        $get =  $this->borrow_book_fund_m->find($id); 
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
				'borrow_date' => strtotime($this->input->post('borrow_date')), 
							'student' => $this->input->post('student'), 
							'book' => $this->input->post('book'), 
							'remarks' => $this->input->post('remarks'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->borrow_book_fund_m->update_attributes($id, $form_data);

        
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
				redirect("admin/borrow_book_fund/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/borrow_book_fund/");
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
			    $data['books']=$this->borrow_book_fund_m->list_books();
             //load the view and the layout
             $this->template->title('Edit Give out  Book Fund ' )->build('admin/edit', $data);
	}
	
	 function _valid_sid()
        {
                $sid = $this->input->post('sids');
                if (is_array($sid) && count($sid))
                {
                        return TRUE;
                }
                else
                {
                        $this->form_validation->set_message('_valid_sid', 'Please Select at least one Student.');
                        return FALSE;
                }
        }



	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/borrow_book_fund');
		}

		//search the item to delete
		if ( !$this->borrow_book_fund_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/borrow_book_fund');
		}
 
		//delete the item
		if ( $this->borrow_book_fund_m->delete($id) == TRUE) 
		{
			 //$details = implode(' , ', $this->input->post());
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
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/borrow_book_fund/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'borrow_date',
                 'label' => 'Borrow Date',
                 'rules' =>'required|xss_clean'),

                 array(
		 'field' =>'student',
                'label' => 'Student',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'book',
                'label' => 'Book',
                'rules' => 'xss_clean'),

                array(
		 'field' =>'remarks',
                'label' => 'Remarks',
                'rules' => 'xss_clean'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	 }
//Validate per class
	private function validation_class()
    {
$config = array(
                 array(
		 'field' =>'borrow_date',
                 'label' => 'Borrow Date',
                 'rules' =>'required|xss_clean'),
				 
				   array(
                        'field' => 'sids',
                        'label' => 'Student List',
                        'rules' => 'xss_clean|callback__valid_sid'),

                 array(
		 'field' =>'book',
                'label' => 'Book',
                'rules' => 'required|xss_clean'),

                array(
		 'field' =>'remarks',
                'label' => 'Remarks',
                'rules' => 'xss_clean'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/borrow_book_fund/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100000000;
            $config['total_rows'] = $this->borrow_book_fund_m->count();
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