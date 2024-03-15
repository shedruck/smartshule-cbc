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
			$this->load->model('appraisal_targets_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['appraisal_targets'] = $this->appraisal_targets_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

                $data['limit']= $this->appraisal_targets_m->checkpast_date();
               
            //load view
            $this->template->title(' Appraisal Targets ' )->build('admin/list', $data);
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
				'term' => $this->input->post('term'), 
				'year' => $this->input->post('year'), 
				'target' => $this->input->post('target'), 
				'description' => $this->input->post('description'), 
				'created_by' => $user -> id ,   
				'created_on' => time(),
                'start_date' =>$this->input->post('start_date'),
                'end_date' =>$this->input->post('end_date')
			);

            $ok=  $this->appraisal_targets_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/appraisal_targets/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Appraisal Targets ' )->build('admin/create', $data);
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
                    redirect('admin/appraisal_targets/');
            }
         if(!$this->appraisal_targets_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/appraisal_targets');
              }
        //search the item to show in edit form
        $get =  $this->appraisal_targets_m->find($id); 
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
							'term' => $this->input->post('term'), 
							'year' => $this->input->post('year'), 
							'target' => $this->input->post('target'), 
							'description' => $this->input->post('description'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->appraisal_targets_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/appraisal_targets/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/appraisal_targets/");
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
             $this->template->title('Edit Appraisal Targets ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/appraisal_targets');
		}

		//search the item to delete
		if ( !$this->appraisal_targets_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/appraisal_targets');
		}
 
		//delete the item
		                     if ( $this->appraisal_targets_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/appraisal_targets/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'term',
                 'label' => 'Term',
                 'rules' =>'required|xss_clean'),

                 array(
		 'field' =>'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'target',
                'label' => 'Target',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                array(
		 'field' =>'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/appraisal_targets/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 10;
            $config['total_rows'] = $this->appraisal_targets_m->count();
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

    public function appraise(){
        $data['targets']= $this->appraisal_targets_m->checkpast_date();
        $data['teachers']= $this->appraisal_targets_m->getteachers();
       if( $this->input->post()){
            $this->form_validation->set_rules('target_id','Target','required');
            $this->form_validation->set_rules('teacher','teacher','required');

            if(!$this->form_validation->run()){
                //load view
                $this->template->title('Add Book List ' )->build('admin/appraise', $data); 
            }else{
                $teacher= $this->input->post('teacher');
                $mwalimu= explode('.', $teacher);
                $user_id= $mwalimu[0];
                $teacher= $mwalimu[1];
                

                $target_id=$this->input->post('target_id');
                $rate=$this->input->post('rate');
                foreach($target_id as $t_id){
                    foreach($rate as $r){
                        $data= array(
                            'target' =>$t_id,
                            'user_id'=>$user_id,
                            'teacher'=>$teacher,
                            'rate'=>$r,
                            'created_on'=>time(),
                            'created_by'=>$this->ion_auth->get_user()->id
                        );
                    }
                   $ok= $this->appraisal_targets_m->insertresults($data);
                }
                $this->template->title(' Admin | Appraising Teachers ' )->build('admin/appraise', $data);
                
                if ( $ok)
                {
                        $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                }
                else
                {
                        $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                }

                redirect('admin/appraisal_targets/appraisalResults');
                }

            
        }
        $this->template->title(' Admin | Appraising Teachers ' )->build('admin/appraise', $data);
       
        
    }
    public function appraisalResults(){
        $data['results']= $this->appraisal_targets_m->getappraisalresults();
        $data['teachers']= $this->appraisal_targets_m->listteachers();

        $this->template->title(' Admin | Appraisal Results ')->build('admin/appraisal_results',$data);
    }

    public function filterByTeacher(){
        if( $this->input->post()){
            $teacher=$this->input->post('teacher');
            $data['results']=$this->appraisal_targets_m->filterresults_byteacher($teacher);
            $this->template->title(' Admin | Appraisal Results ')->build('admin/filter_results',$data);
        }
    }

    public function appraiseTeacher(){
        $id= $this->input->post('appraisal_id');
        $rate=  $this->input->post('rate');

        // if($rate)

        $data= array(
            'rate' =>$rate,
            'modified_on'=>time(),
            'modified_by'=>$this->ion_auth->get_user()->id
        );

        if($this->appraisal_targets_m->appraisetacher($id,$data)){
            echo "success";
        }else{
            echo "failed";
        }

    }
}