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
			$this->load->model('record_sales_m');
	}


	public function index()
	{
	   $config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

 		$record_sales = $this->record_sales_m->paginate_all($config['per_page'], $page);
		
		if(!empty($record_sales)){
			foreach($record_sales as $sales){
			   $t_qnty = $this->record_sales_m->get_total_qnty($sales->receipt_id);
			   $sales->t_qnty = $t_qnty;
			   
			   $t_totals = $this->record_sales_m->get_totals($sales->receipt_id);
			   $sales->t_totals = $t_totals;

			   $all_items = $this->record_sales_m->get_items($sales->receipt_id);
			   $sales->all_items = $all_items;
			
			}
		}
		
		
		$data['record_sales'] = $record_sales;

            //create pagination links
            $data['links'] = $this->pagination->create_links();
			
			

	//page number  variable
	 $data['page'] = $page;
     $data['per'] = $config['per_page'];
     $data['items'] = $this->record_sales_m->populate('sales_items','id','item_name');
            //load view
            $this->template->title(' Record Sales ' )->build('admin/list', $data);
	}	

	public function manipulate($id)
	{
	   $config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

 		$record_sales = $this->record_sales_m->manipulate($id);
		
		//$details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
					$log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $id, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
						'details' => 'Record Manipulated',   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);

		
		    $data['record_sales'] = $record_sales;

            //create pagination links
            $data['links'] = $this->pagination->create_links();
			
			

	//page number  variable
	 $data['page'] = $page;
     $data['per'] = $config['per_page'];
     $data['items'] = $this->record_sales_m->populate('sales_items','id','item_name');
            //load view
            $this->template->title(' Record Sales ' )->build('admin/manipulate', $data);
	}
	
	public function voided()
	{
	   $config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

 		$record_sales = $this->record_sales_m->voided();

		
		    $data['record_sales'] = $record_sales;

            //create pagination links
            $data['links'] = $this->pagination->create_links();
			
			

	//page number  variable
	 $data['page'] = $page;
     $data['per'] = $config['per_page'];
     $data['items'] = $this->record_sales_m->populate('sales_items','id','item_name');
            //load view
            $this->template->title(' Record Sales ' )->build('admin/voided', $data);
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
		  
		  

            $now = time();
            $t_array = $this->input->post('total');
            $total = array_sum($t_array);

            $reg = $this->input->post('reg_no');
            $receipt = array(
                'total' => $total,
                'student' => $this->input->post('student'),
                'created_by' => $user->id,
                'created_on' => $now
            );

            $rec_id = $this->record_sales_m->insert_rec($receipt);

		    $length = $this->input->post('item_id');
            $size = count($length);
		  
		   for ($i = 0; $i < $size; ++$i)
            {
				$quantity = $this->input->post('quantity');
                $item_id = $this->input->post('item_id');
                $unit_price = $this->input->post('unit_price');
                $total = $this->input->post('total');
                $payment_method = $this->input->post('payment_method');
               
                $description = $this->input->post('description');
				
				$form_data = array(
						'sales_date' => strtotime($this->input->post('sales_date')), 
						'item_id' => $item_id[$i], 
						'quantity' => $quantity[$i], 
						'receipt_id' => $rec_id, 
						'status' => 1, 
						'unit_price' => $unit_price[$i], 
						'total' => $total[$i], 
						'payment_method' => $payment_method[$i], 
						'description' => $description[$i], 
						 'created_by' => $user -> id ,   
						 'created_on' => time()
					);

					$ok=  $this->record_sales_m->create($form_data);
			 }
            if ( $ok ) 
            {
                $details = implode(' , ', $form_data);
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
			   
			   redirect('admin/record_sales/receipt/'.$rec_id);
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/record_sales/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         $get->{$field['field']}  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
				 $data['items'] = $this->record_sales_m->populate('sales_items','id','item_name');
		 //load the view and the layout
		 $this->template->title('Add Record Sales ' )->build('admin/create', $data);
		}		
	}
	
	function receipt($id){
		  
		
         if(!$this->record_sales_m-> exists_rec($id) )
             {
				 $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => '<b style="color:red">Sorry that receipt do not exist</b>' ) );
				redirect('admin/record_sales');
             }
			  
		 $rec =  $this->record_sales_m->rec_details($id); 
		 $data['rec'] =  $rec ; 
		 $data['sales'] =  $this->record_sales_m->sales_details($id);

        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();	
          $ccc = $this->record_sales_m->get_student($rec->student);
        if (!isset($ccc->class))
        {
            $sft = ' - ';
            $st = ' - ';
        }
        else
        {
            $crow = $this->portal_m->fetch_class($ccc->class);
            if (!$crow)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
            }
        }
       $data['class'] = $sft . '  ' . $st;		
		 
		 $data['items'] = $this->record_sales_m->populate('sales_items','id','item_name');
		//load the view and the layout
		 $this->template->title('Sales Receipt ' )->build('admin/receipt', $data);
	
	}
	
	/****
	**** VOID SALES
	**** SET STATUS 0
	***/
	 function void($id)
    {

//redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/record_sales/');
        }

        if (!$this->record_sales_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/record_sales');
        }

        
        $user = $this->ion_auth->get_user();

        //search the item 
        $get = $this->record_sales_m->find($id);
		
		
        //Get Receipt details
        $rec = $this->record_sales_m->get_receipt($get->receipt_id);
        //Balance from Receipt
        $reduce_amount = abs($rec->total- $get->total);

        $form_data = array(
            'quantity' => 0,
            'status' => 0,
            'modified_by' => $user->id,
            'modified_on' => time()
        );

        $this->record_sales_m->update_attributes($id, $form_data);

        $update_fee_receipt = array(
            'total' => $reduce_amount,
            'modified_by' => $user->id,
            'modified_on' => time()
        );

        $done = $this->record_sales_m->update_fee_receipt($rec->id, $update_fee_receipt);


        if ($done)
        {
             //$details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
					$log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $id, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
						'details' => 'Record Voided',   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
			 
			 
			 /**
             * * Reduce accounts chart by the balance 
             * * Update Accounts Chart Balances
             * */
			 
            /* $this->worker->calc_balance($rec->student);
            
            $get_account = $this->accounts_m->get_by_code(200);
            $balance = 0;

            $balance = $get_account->balance;
            $initial_amount = $get->amount;
            $actual_amt = $balance - $initial_amount;

            $bal_details = array(
                'balance' => $actual_amt,
                'modified_by' => $user->id,
                'modified_on' => time());
            $this->accounts_m->update_attributes($get_account->id, $bal_details); */

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Record successfully voided'));
            redirect("admin/record_sales");
        }
    }
	function edit_removed($id = FALSE, $page = 0)
	{ 
          
            //get the $id and sanitize
            $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

            $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('admin/record_sales/');
            }
         if(!$this->record_sales_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/record_sales');
              }
        //search the item to show in edit form
        $get =  $this->record_sales_m->find($id); 
		 $data['items'] = $this->record_sales_m->populate('sales_items','id','item_name');
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
				'sales_date' => strtotime($this->input->post('sales_date')), 
							'item_id' => $this->input->post('item_id'), 
							'quantity' => $this->input->post('quantity'), 
							'unit_price' => $this->input->post('unit_price'), 
							'total' => $this->input->post('total'), 
							'payment_method' => $this->input->post('payment_method'), 
							'description' => $this->input->post('description'), 
				 'modified_by' => $user -> id ,   
				 'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->record_sales_m->update_attributes($id, $form_data);

        
        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/record_sales/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/record_sales/");
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
             $this->template->title('Edit Record Sales ' )->build('admin/edit', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/record_sales');
		}

		//search the item to delete
		if ( !$this->record_sales_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/record_sales');
		}
 
		//delete the item
	 if ( $this->record_sales_m->delete($id) == TRUE) 
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

		redirect("admin/record_sales/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'sales_date',
                 'label' => 'Sales Date',
                 'rules' =>'required|xss_clean'),
				 array(
		 'field' =>'student',
                 'label' => 'Student',
                 'rules' =>'required|xss_clean'),

                 array(
		 'field' =>'item_id',
                'label' => 'Item Id',
                'rules' => ''),

                 array(
		 'field' =>'quantity',
                'label' => 'Quantity',
                'rules' => ''),

                 array(
		 'field' =>'unit_price',
                'label' => 'Units',
                'rules' => ''),

                 array(
		 'field' =>'total',
                'label' => 'Total',
                'rules' => ''),

				array(
		 'field' =>'payment_method',
                'label' => 'payment method',
                'rules' => ''),

                array(
		 'field' =>'description',
                'label' => 'Description',
                'rules' => ''),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/record_sales/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 10000000;
            $config['total_rows'] = $this->record_sales_m->count();
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