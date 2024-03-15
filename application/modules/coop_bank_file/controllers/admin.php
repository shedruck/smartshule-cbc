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
			$this->load->model('coop_bank_file_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['coop_bank_file'] = $this->coop_bank_file_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Coop Bank File ' )->build('admin/list', $data);
	}
	
     function coop()
        {
			
			
			if (!empty($_FILES['file']['name']))
            {
			    $dest = FCPATH . "/uploads/bank_files/" . date('Y') . '/'.date('m').'/';	
				
			    $config['upload_path'] = $dest;
			    $config['allowed_types'] = 'xls|xlsx|';
				$config['max_size'] = 1024 * 50;
				$config['encrypt_name'] = FALSE;
				
			    $this->load->library('upload', $config);
		    	
		     if (!is_dir($dest))
                {
					 
                        mkdir($dest, 0777, true);
						
                }
				//$data = $this->upload->do_upload('file');
				
				
				//upload the file
				if ( ! $this->upload->do_upload('file'))
				{
						$data['upload_error'][$index] = $this->upload->display_errors("<span class='error'>", "</span>");

						redirect('admin/coop_bank_file');

						return FALSE;
				}

			    $data = $this->upload->data();
				
				$file_name = $data['file_name'];
				$file_path = $dest ;
			  
			 } 	
			
        
		   
            require_once APPPATH . 'libraries/xlsxreader.php';
    
            $reader = new XLSXReader(FCPATH . ''.$dest.'/'.$file_name);
			
			print_r($dest );die;
			die;
            $reader->decodeUTF8(true);
            $reader->read();
            $woksh = array();
    
            $sheets = $reader->getSheets();
    
            $i = 0;
            foreach ($sheets as $sheet)
            {
                $i++;
                $data = $reader->getSheetDatas($sheet["id"]);
    
                $titles = $data[0];
                unset($data[0]);
    
                foreach ($data as $rid => $row)
                {
                    $nwrow = array();
                    foreach ($row as $cid => $cell)
                    {
                        if (!isset($titles[$cid]))
                        {
                            echo '<pre>xx  ';
                            print_r("[{$cid}] not set");
                            print_r($titles);
                            print_r($row);
                            echo '</pre>';
                            die;
                        }
                        $nwrow[$titles[$cid]] = $cell;
                    }
                    foreach ($titles as $tl)
                    {
                        if (!isset($nwrow[$tl]))
                        {
                            $nwrow[$tl] = '';
                        }
                    }
                    $woksh[] = $nwrow;
                }
                break;
            }
    
      
    
             echo '<pre>';
             echo '<br>';
             print_r( $woksh );
             echo '</pre>';
            die;
            foreach ($woksh as $key => $value) {
                # code...
                $std = (object) $value;
                $student_name= $std->StudentName;
                $std_name = explode (' ', $student_name);

                $first_name= $std_name[0];
                $middle_name= $std_name[1];
                $last_name= $std_name[2];
                $admission_number="AP-".date('y').rand(000,100);
                    $data = array(
                        'admission_number'=>$admission_number,
                        'first_name' => $first_name,
                        'middle_name' => $middle_name,
                        'last_name' => $last_name,
                        'class' => 1,
                        'status' => 1,
                        'created_on' => time(),
                        'created_by' => $this->ion_auth->get_user()->id
                    );
                    // $data= array_filter($data);
                // echo '<pre>';
                // echo '<br>';
                //  print_r($data);
                //  echo '</pre>';
             
                    $ok=$this->uploads_m->create($data); 
            }
               if($ok){
                   echo "<script> alert('success')</script>";
               }else{
                 echo "<script> alert('Failed ')</script>";
               }
            
            // print_r($data);
            echo '</pre>';
            die;
        }
  
	
			//Upload Student			
    function upload_coop_bank_files()
        {
               
			   $this->load->model('coop_bank_file/coop_bank_file_m');

                $file = $_FILES['csv']['tmp_name'];

                $handler = fopen($file, "r");
                $i = 0;
                $user = $this -> ion_auth -> get_user();
                while (($fileop = fgetcsv($handler, 1000, ",")) !== false)
                {
                        $i++;
                      
                       $transaction_date = $fileop[0];
                       $value_date = $fileop[1];
                       $channel_ref = $fileop[2];
                       $transaction_ref = $fileop[3];
                       $narrative = $fileop[4];
                       $debit = $fileop[5];
                       $credit = $fileop[6];
                       $running_bal = $fileop[7];
					   
					   $nv = explode('-',$narrative);
					   
					 
					   
					if(!empty($nv[0])){
						  
					   $trans_no = $nv[0];
					   $stud = $nv[1];
					   
					   $student_details = explode(' ',$stud);
					   $admname = $student_details [0];
					   $phone = $student_details [1];
					   
					   $student = preg_replace('/[0-9]+/', '', $admname);
					   $admission_no = (int)$admname;
					   
					
                                $form_data = array(
                                    'transaction_date' => $transaction_date,
                                    'value_date' => $value_date,
                                    'channel_ref' => $channel_ref,
                                    'transaction_ref' => $transaction_ref,
                                    'narrative' => $narrative,
									
                                    'debit' => $debit,
                                    'credit' => $credit,
									
                                    'transaction_no' => $trans_no,
                                    'admission_no' => $admission_no,
                                    'student' => $student,
                                    'phone' => $phone,
									
                                    'created_by' => $user -> id,
                                    'created_on' => time()
                                );
								
							//	print_r($form_data);die;

                              $ok =   $this->coop_bank_file_m->create($form_data);
                            
					   }
                }

                if ($ok)
                {

                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }

                redirect('admin/coop_bank_file/');
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
				'transaction_date' => $this->input->post('transaction_date'), 
				'value_date' => $this->input->post('value_date'), 
				'channel_ref' => $this->input->post('channel_ref'), 
				'transaction_ref' => $this->input->post('transaction_ref'), 
				'narrative' => $this->input->post('narrative'), 
				'debit' => $this->input->post('debit'), 
				'credit' => $this->input->post('credit'), 
				'running_bal' => $this->input->post('running_bal'), 
				'transaction_no' => $this->input->post('transaction_no'), 
				'admission_no' => $this->input->post('admission_no'), 
				'student' => $this->input->post('student'), 
				'phone' => $this->input->post('phone'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);

            $ok=  $this->coop_bank_file_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/coop_bank_file/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Coop Bank File ' )->build('admin/create', $data);
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
                    redirect('admin/coop_bank_file/');
            }
         if(!$this->coop_bank_file_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/coop_bank_file');
              }
        //search the item to show in edit form
        $get =  $this->coop_bank_file_m->find($id); 
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
							'transaction_date' => $this->input->post('transaction_date'), 
							'value_date' => $this->input->post('value_date'), 
							'channel_ref' => $this->input->post('channel_ref'), 
							'transaction_ref' => $this->input->post('transaction_ref'), 
							'narrative' => $this->input->post('narrative'), 
							'debit' => $this->input->post('debit'), 
							'credit' => $this->input->post('credit'), 
							'running_bal' => $this->input->post('running_bal'), 
							'transaction_no' => $this->input->post('transaction_no'), 
							'admission_no' => $this->input->post('admission_no'), 
							'student' => $this->input->post('student'), 
							'phone' => $this->input->post('phone'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->coop_bank_file_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/coop_bank_file/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/coop_bank_file/");
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
             $this->template->title('Edit Coop Bank File ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/coop_bank_file');
		}

		//search the item to delete
		if ( !$this->coop_bank_file_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/coop_bank_file');
		}
 
		//delete the item
		                     if ( $this->coop_bank_file_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/coop_bank_file/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'transaction_date',
                'label' => 'Transaction Date',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'value_date',
                'label' => 'Value Date',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'channel_ref',
                'label' => 'Channel Ref',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'transaction_ref',
                'label' => 'Transaction Ref',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'narrative',
                'label' => 'Narrative',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'debit',
                'label' => 'Debit',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'credit',
                'label' => 'Credit',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'running_bal',
                'label' => 'Running Bal',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'transaction_no',
                'label' => 'Transaction No',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'admission_no',
                'label' => 'Admission No',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'student',
                'label' => 'Student',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'phone',
                'label' => 'Phone',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/coop_bank_file/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 10;
            $config['total_rows'] = $this->coop_bank_file_m->count();
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