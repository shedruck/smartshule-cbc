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
			$this->load->model('discounts_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['discounts'] = $this->discounts_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Discounts ' )->build('admin/list', $data);
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
				'name' => $this->input->post('name'), 
                'percentage' => $this->input->post('percentage'),
				 'created_by' => $user -> id , 
                 'status' => 1,  
				 'created_on' => time()
			);

            $ok=  $this->discounts_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/discounts/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get -> {$field['field']}  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
		 $this->template->title('Add Discounts ' )->build('admin/create', $data);
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
                    redirect('admin/discounts/');
            }
         if(!$this->discounts_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/discounts');
              }
        //search the item to show in edit form
        $get =  $this->discounts_m->find($id); 
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
							'name' => $this->input->post('name'), 
                            'percentage' => $this->input->post('percentage'),
            				 'modified_by' => $user -> id ,   
            				 'modified_on' => time() 
                            );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->discounts_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/discounts/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/discounts/");
			}
	  	}
             else
             {
                 foreach (array_keys($this -> validation()) as $field)
                {
                        if (isset($_POST[$field]))
                        {  
                                $get ->{ $field} = $this -> form_validation -> $field;
                        }
                }
		}
               $data['result'] = $get;
             //load the view and the layout
             $this->template->title('Edit Discounts ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/discounts');
		}

		//search the item to delete
		if ( !$this->discounts_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/discounts');
		}
 
		//delete the item
		                     if ( $this->discounts_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/discounts/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		        'field' =>'name',
                'label' => 'Name',
                'rules' => 'trim|xss_clean|required'),

                 array(
                'field' =>'percentage',
                'label' => 'Percentage',
                'rules' => 'trim|xss_clean|required'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/discounts/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 10;
            $config['total_rows'] = $this->discounts_m->count();
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

    function assign_groups()
    {

        if($this->input->post())
        {
             $students = $this->input->post('sids');
             $disc = $this->input->post('discount');
             $get = $this->discounts_m->find($disc);
             $user = $this->ion_auth->get_user();
             $i = 0;
             $j = 0;

             foreach($students as $key => $std)
             {
                $form_data = [
                    'student' => $std,
                    'percentage' => $get->percentage,
                    'discount_id' => $disc,
                    'status' => 1,
                    'created_by' => $user->id,
                    'created_on' => time(),
                ];

                $has_group = $this->discounts_m->has_group($std);

                if($has_group)
                {
                    $ok = $this->discounts_m->update_data('discounts_assign', $has_group, $form_data);
                    $i++;
                }
                else
                {
                    $ok = $this->discounts_m->save_data('discounts_assign',$form_data);
                    if($ok)
                    {
                        $j++;
                    }
                }


                $details = implode(' , ', $this->input->post());
                $log = array(
                        'module' =>  $this->router->fetch_module(),
                        'item_id' => $ok,
                        'transaction_type' => $this->router->fetch_method(),
                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                        'details' => $details,
                        'created_by' => $user->id,
                        'created_on' => time()
                );

                $this->ion_auth->create_log($log);


                $mess = 'Status:  ' . $j . ' new and Updated ' . $i . ' Existing Students ';
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
             }

             redirect('admin/discounts/students');

             
        }

         $range = range(date('Y') - 1, date('Y') + 1);
         $yrs = array_combine($range, $range);
         krsort($yrs);
         $data['yrs'] = $yrs;
         $data['list'] = $this->discounts_m->active_groups();
         $this->template->title(' Assign Group ')->build('admin/assign', $data);
    }

    function students()
    {
        $res = [];
        if($this->input->post())
        {
            $res = $this->discounts_m->filter_students($this->input->post('discounts_assign'), $this->input->post('class'));
        }
        $data['res'] = $res;
        $data['groups'] = $this->discounts_m->populate('discount_groups','id','name');
        $this->template->title(' Student Groups ')->build('admin/students', $data);
    }

    function change_status($action, $id)
    {
        if (!$id)
        {
                $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                redirect('admin/discounts/students');
        }
        $user = $this->ion_auth->get_user();
        $ok = $this->discounts_m->update_data('discounts_assign', $id, ['status' => ($action == 'disable') ? 2 : 1, 'modified_on' => time(), 'modified_by' => $user->id]);

       if ($ok) 
        {
            $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
            redirect("admin/discounts/students");
        }

        else
        {
            $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
            redirect("admin/discounts/students");
        }

    }

    function issue_discount()
    {
        if($this->input->post())
        {

           
             $group = $this->input->post('group');
             $term = $this->input->post('term');
             $year = $this->input->post('year');

             $students = $this->discounts_m->filter_students($group);

             
             $total = [];
             $sum = [];
             foreach($students as $s)
             {
                if($s->status ==1)
                {

                     $invoices = $this->discounts_m->get_std_invoices($s->student, $term, $year);

                     foreach($invoices as $rows)
                     {
                        $in = (object)$rows;

                        if($in->type == "Extras")
                        {
                             $fee = $this->discounts_m->discounted_fee($in->fee_id);  

                             
                        }
                       
                        
                      
                        if(isset($fee->discounted) == 1 || $in->type =="Tuition" || $in->type =="Transport")
                        {
                            $sum[$in->student][] = $in->amount;
                        }

                       
                        foreach($sum as $key => $value)
                        {
                            $total[$in->student] = array_sum($value);
                        }

                     }
               }

             }

           


            $pers = $this->discounts_m->get_percentages();
            $grp = $this->discounts_m->populate('discounts_assign','student','discount_id');
            $i = 0;
            $j = 0;

            foreach($total as $std => $amount)
            {
                $per = isset($pers[$std]) ? $pers[$std] : 0;
                $disc = ($per * $amount) / (100);

                $group = isset($grp[$std]) ? $grp[$std] : 0;

                $form_data = [
                    'student' => $std,
                    'group' => $group,
                    'term' => $term,
                    'year' => $year,
                    'amount' => $disc,
                    'total' => $amount,
                    'status' => 1,
                    'created_by' => $this->ion_auth->get_user()->id,
                    'created_on' => time(),
                ];


                $has_discount = $this->discounts_m->has_discount($std, $term, $year);

                if($has_discount)
                {
                    $ok = $this->discounts_m->update_data('discounts', $has_discount, $form_data);
                    $i++;
                }
                else
                {
                    $ok = $this->discounts_m->save_data('discounts',$form_data);
                    if($ok)
                    {
                        $j++;
                    }
                }


                $details = implode(' , ', $form_data);
                $log = array(
                        'module' =>  $this->router->fetch_module(),
                        'item_id' => $ok,
                        'transaction_type' => $this->router->fetch_method(),
                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                        'details' => $details,
                        'created_by' => $this->ion_auth->get_user()->id,
                        'created_on' => time()
                );

                $this->ion_auth->create_log($log);


                $mess = 'Status:  ' . $j . ' new and Updated ' . $i . ' Existing Student(s) ';
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
            }

            redirect("admin/discounts/issue_discount");

            
        }
        $range = range(date('Y') - 1, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['list'] = $this->discounts_m->active_groups();
        $this->template->title(' Issue Discount ')->build('admin/issue_discount', $data);
    }

    function discounts_list()
    {
        
        $term = $this->input->post('term');
        $year = $this->input->post('year');
        $group = $this->input->post('group');

        $discounts = $this->discounts_m->get_discounts($term, $year, $group);
      
        $range = range(date('Y') - 1, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['list'] = $this->discounts_m->populate('discount_groups','id','name');
        $data['discounts'] = $discounts;
        $this->template->title(' Issued Discounts ')->build('admin/issued_discounts', $data);
        
    }

    function void($id)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/discounts/discounts_list');
        } 

        $ok = $this->discounts_m->update_data('discounts',$id,['status' => 0, 'modified_on' => time(), 'modified_by' => $this->ion_auth->get_user()->id]);

        if($ok)
        {
            $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
                redirect("admin/discounts/discounts_list");
        }
        else
        {
             $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $ok->errors->full_messages() ) );
                redirect("admin/discounts/discounts_list");
        }

    }
}