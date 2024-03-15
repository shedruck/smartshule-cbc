<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        /*$this->template->set_layout('default');
        $this->template->set_partial('sidebar', 'partials/sidebar.php')
                     ->set_partial('top', 'partials/top.php');*/
        if (!$this->ion_auth->logged_in())
        {
            redirect('login');
        }
		
		/* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
        {
             $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
			redirect('admin');
        }*/
		
        $this->load->model('purchase_order_m');

        $this->load->model('address_book/address_book_m');
        $this->load->model('accounts/accounts_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        $details = $this->purchase_order_m->paginate_all($config['per_page'], $page);
	    if(!empty($details)){
				foreach($details as $del){
				   
				  $payment=$this->purchase_order_m->get_pays($del->id);
				  $amount_paid=$this->purchase_order_m->amount_paid($del->id);
				  $del->amount_paid =$amount_paid;
				  $del->payment =$payment;
				}
		}
		$data['purchase_order'] = $details;
		
        //create pagination links
        $data['links'] = $this->pagination->create_links();

        $data['tax'] = $this->purchase_order_m->tax();
		
        $data['months_lpo'] = $this->purchase_order_m->total_lpo_month();
        $data['count_months_lpo'] = $this->purchase_order_m->count_lpo_month();
		
		$data['total_unpaid'] = $this->purchase_order_m->total_unpaid();
		$data['total_balance'] = $this->purchase_order_m->total_balance();
        $data['count_unpaid'] = $this->purchase_order_m->count_unpaid();
		
		
        $data['total_overdue'] = $this->purchase_order_m->total_overdue();
        $data['count_overdue'] = $this->purchase_order_m->count_overdue();
		
		$data['total_paid'] = $this->purchase_order_m->total_paid();
        $data['count_paid'] = $this->purchase_order_m->count_paid();
		
		

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        $data['address_book'] = $this->purchase_order_m->suppliers();
		
        //load view
        $this->template->title(' Purchase Order ')->build('admin/list', $data);
    }
	
	public function voided()
    {
        $config = $this->set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        $data['purchase_order'] = $this->purchase_order_m->all_voided($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        $data['tax'] = $this->purchase_order_m->tax();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        $data['address_book'] = $this->purchase_order_m->suppliers();
        //load view
        $this->template->title(' Purchase Order ')->build('admin/voided', $data);
    }

    function void($id)
    {

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/purchase_order/');
        }
        if (!$this->purchase_order_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/purchase_order');
        }
        //search the item to show in edit form
        $get = $this->purchase_order_m->find($id);

        $user = $this->ion_auth->get_user();

        $form_data = array(
            'status' => 0,
            'modified_by' => $user->id,
            'modified_on' => time()
        );


        //find the item to update

        $done = $this->purchase_order_m->update_attributes($id, $form_data);

        
        if ($done)
        {
			//$details = implode(' , ', $form_data);
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
				  
				  
			$get_account=$this->accounts_m->get_by_code(500);
		    $balance=0;
				
				/**
				** Reduce accounts chart by the balance then add the input amount
				**/
				$balance=$get_account->balance;
				$initial_amount=$get->total;
				$actual_amt=$balance-$initial_amount;
				
			$bal_details = array(
                'balance' => $actual_amt,
                'modified_by' => $user->id,
                'modified_on' => time());
				 $this->accounts_m->update_attributes($get_account->id, $bal_details);
				 

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Record successfully voided'));
            redirect("admin/purchase_order");
        }
    }

    public function order($id)
    {

        $post = $this->purchase_order_m->find($id);
        $data['post'] = $post;
        $data['details'] = $this->purchase_order_m->purchase_details($id);
        $data['supplier'] = $this->purchase_order_m->get_supplier($post->supplier);
        $data['tax'] = $this->purchase_order_m->tax();

        $data['title'] = 'Purchase Order';
        //load view
        $this->template->title(' Purchase Order ')->build('admin/order', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $form_data_aux = array();

        $data['address_book'] = $this->purchase_order_m->suppliers();
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());



        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
 		
			$pd=$this->input->post('purchase_date');
			$dd=$this->input->post('due_date');
			
			
			if(strtotime($dd) < strtotime($pd) ){
			 $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry set correct due date. Due date cannot be less than purchase order date</b>'));
			 
			   redirect('admin/purchase_order/create/1');
			}

            $user = $this->ion_auth->get_user();

            $form_data = array(
                'purchase_date' => strtotime($this->input->post('purchase_date')),
                'supplier' => $this->input->post('supplier'),
                'comment' => $this->input->post('comment'),
                'due_date' => strtotime($this->input->post('due_date')),
                'vat' => $this->input->post('vat'),
                'total' => $this->input->post('total'),
                'status' => 1,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->purchase_order_m->create($form_data);

            $length = array();
            $length = $this->input->post('quantity');
            $unit_price = $this->input->post('unit_price');
            $size = count($length);

            for ($i = 0; $i < $size; ++$i)
            {

                $qnt = $this->input->post('quantity');
                $desc = $this->input->post('description');
                $amt = $this->input->post('unit_price');
                $totals = (int) $amt[$i] * (int) $qnt[$i];

                $insert_purchase = array(
                    'purchase_id' => $ok,
                    'quantity' => $qnt[$i],
                    'description' => $desc[$i],
                    'unit_price' => $amt[$i],
                    'totals' => $totals,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

               $data = $this->purchase_order_m->insert_purchase($insert_purchase);
            }
			
			$get_account=$this->purchase_order_m->get_by_code(800);
			$balance=0;
			$amt=$this->input->post('total');
			$balance=$get_account->balance;
			$bal=$balance +  $amt;
			 
			
            if ($ok) 
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
				
				
				$bal_details = array(
                'balance' => $bal,
                'modified_by' => $user->id,
                'modified_on' => time());
				 $this->accounts_m->update_attributes($get_account->id, $bal_details);
				 
				$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/purchase_order');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Purchase Order ')->build('admin/create', $data);
        }
    } 
   /**
   ***Make pay for order
   ***Public Function
   **/
	function make_pay($id=FALSE,$page = NULL)
    {
        
		 //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/purchase_order/');
        }
        if (!$this->purchase_order_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/purchase_order');
        }
		
		//create control variables
        $data['updType'] = 'create';
        $form_data_aux = array();

        $data['address_book'] = $this->purchase_order_m->suppliers();
		$tax = $this->purchase_order_m->tax();
		$data['tax'] = $tax;
		$data['accounts']=$this-> purchase_order_m->accounts();
	
		   
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->valid_rules());
		
		$details=$this->purchase_order_m->find($id);
		
		$data['p']=$details;

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
           
			/****
			***Check if the amount paid is greater than the due amount
			****/
			
			$due_amount=$details->total;
			
			$tot=0;
			$amount=$this->input->post('amount');
			
			 $vat = $tax->amount;
				if ($details->vat == 1)
				{
					$amt = ($due_amount * $vat) / 100; //echo $vat;
					$tot= ($amt + $due_amount);
				}
				else{ $tot=$due_amount;}
		
		
			if($tot < $amount ){
			 $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry, the amount entered cannot be more than  amount due </b>'));
			 
			   redirect('admin/purchase_order/make_pay/'.$id);
			}
			
			

            $user = $this->ion_auth->get_user();

            $form_data = array(
                'pay_date' => strtotime($this->input->post('pay_date')),
                'amount' => $amount,
                'order_id' => $id,
                'pay_type' => $this->input->post('pay_type'),
                'account' => 500,
                'created_by' => $user->id,
                'created_on' => time()
            );

           $ok = $this->purchase_order_m->insert_pay($form_data);
		   
             if ($ok) 
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
			
			/****
			***Update Chart of Accounts Balance (Reduce account payable by amount paid)
			****/
			
			$get_account=$this->purchase_order_m->get_by_code(800);
			$balance=0;
			$amt=$this->input->post('amount');
			$balance=$get_account->balance;
			$bal=$balance -  $amt;
			
                $bal_details = array(
                'balance' => $bal,
                'modified_by' => $user->id,
                'modified_on' => time());
				 $this->accounts_m->update_attributes($get_account->id, $bal_details);
			
			
			/****
			***Update Chart of Accounts Balance (increase purchases account by amount paid)
			****/
			$get_account=$this->purchase_order_m->get_by_code(500);
			$balance=$get_account->balance;
			$bal=$balance +  $amount;
				
				$bal_details = array(
                'balance' => $bal,
                'modified_by' => $user->id,
                'modified_on' => time());
				 $this->accounts_m->update_attributes($get_account->id, $bal_details);
			
			/****
			***Update Purchase Order Balance
			****/			
			 $tax= $this->purchase_order_m->tax();
			 $amt_paid= $this->input->post('amount');
			 $tb=0;
			 $actual_bal=0;
			 
			 if($details->balance>0){
			     $actual_bal=($details->balance-$amt_paid);
			 }
			 else{
					 $vat = $tax->amount;
						if ($details->vat == 1)
						{
							$t = ($details->total * $vat) / 100; //echo $vat;
							 $tb=($t + $details->total);
						}
						else{ $tb=$details->total;}
						
						$actual_bal=($tb-$amt_paid);
			 }
			 
			 
			 $prch_bal = array(
                
                'balance' => $actual_bal,
                'status' => 3,
                'modified_by' => $user->id,
                'modified_on' => time());
           
             $this->purchase_order_m->update_attributes($id, $prch_bal);
		
			
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Payment was successfully recorded'));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/purchase_order');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Purchase Order ')->build('admin/payment', $data);
        }
    }

    function edit_old($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/purchase_order/');
        }
        if (!$this->purchase_order_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/purchase_order');
        }
        //search the item to show in edit form
        $get = $this->purchase_order_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete = array();
        $data['category'] = $this->purchase_order_m->populate('category', 'id', 'name');

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {
            $user = $this->ion_auth->get_user();
            // build array for the model
            $form_data = array(
                'purchase_date' => strtotime($this->input->post('purchase_date')),
                'supplier' => $this->input->post('supplier'),
                'discount' => $this->input->post('discount'),
				 'due_date' => strtotime($this->input->post('due_date')),
                'quantity' => $this->input->post('quantity'),
                'comment' => $this->input->post('comment'),
                'description' => $this->input->post('description'),
                'amount' => $this->input->post('amount'),
                'vat' => $this->input->post('vat'),
                'total' => $this->input->post('total'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->purchase_order_m->update_attributes($id, $form_data);

            
            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/purchase_order/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/purchase_order/");
            }
        }
        else
        {
            foreach (array_keys($this->validation()) as $field)
            {
                if (isset($_POST[$field]))
                {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Purchase Order ')->build('admin/create', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/purchase_order');
        }

        //search the item to delete
        if (!$this->purchase_order_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/purchase_order');
        }

        //delete the item
        if ($this->purchase_order_m->delete($id) == TRUE)
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
			
			$this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/purchase_order/");
    }

    private function valid_rules()
    {
        $config = array(
            array(
                'field' => 'pay_date',
                'label' => 'Payment Date',
                'rules' => 'required|xss_clean'),
				
				array(
                'field' => 'pay_type',
                'label' => 'Pay Type',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required|xss_clean'),
            
          
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

	private function validation()
    {
        $config = array(
            array(
                'field' => 'purchase_date',
                'label' => 'Purchase Order Date',
                'rules' => 'required|xss_clean'),
				
				array(
                'field' => 'due_date',
                'label' => 'Purchase Order Due Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'supplier',
                'label' => 'Supplier',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'quantity[]',
                'label' => 'Quantity',
                'rules' => 'xss_clean'),
            array(
                'field' => 'description[]',
                'label' => 'Description',
                'rules' => 'xss_clean'),
            array(
                'field' => 'amount[]',
                'label' => 'Amount',
                'rules' => 'xss_clean'),
            array(
                'field' => 'vat',
                'label' => 'Vat',
                'rules' => 'xss_clean'),
            array(
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'xss_clean'),
            array(
                'field' => 'total',
                'label' => 'Total',
                'rules' => 'xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/purchase_order/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->purchase_order_m->count();
        $config['uri_segment'] = 4;

        $config['first_link'] = lang('web_first');
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = lang('web_last');
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
