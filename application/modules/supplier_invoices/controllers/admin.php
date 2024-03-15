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
			$this->load->model('supplier_invoices_m');
              $this->load->model('fee_payment/fee_payment_m');
              $this->load->model('expenses/expenses_m');
              $this->load->model('expense_items/expense_items_m');
	}

	public function index()
	{	   $config = $this->set_paginate_options(); //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['supplier_invoices'] = $this->supplier_invoices_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Supplier Invoices' )->build('admin/list', $data);
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
                'expense' => $this->input->post('category'),
				'supplier' => $this->input->post('supplier'), 
				'supplier_email' => $this->input->post('supplier_email'), 
				'supplier_phone' => $this->input->post('supplier_phone'), 
				'item' => $this->input->post('item'), 
				'quantity' => $this->input->post('quantity'), 
				'unit_price' => $this->input->post('unit_price'), 
				 'created_by' => $user -> id ,   
				 'created_on' => time()
			);

            $ok=  $this->supplier_invoices_m->create($form_data);

            if ( $ok)
            {
                    $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('admin/supplier_invoices/');

	  	}else
                {
                $get = new StdClass();
                foreach ($this -> validation() as $field)
                {   
                         // $get -> $field['field']  = set_value($field['field']);
                 }
		 
                 $data['result'] = $get; 
		 //load the view and the layout
        $data['expense_categories'] = $this->supplier_invoices_m->expense_catyegories();

        $exps = $this->supplier_invoices_m->populate('expenses_category','id','title');

        $expenses = [];
        foreach ($exps as $k => $e)
        {
            $expenses[] = ['id' => $k, 'text' => $e];
        }
        $data['expens_cats'] =  $expenses;
		 $this->template->title('Add Supplier Invoice ' )->build('admin/create', $data);
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
                    redirect('admin/supplier_invoices/');
            }
         if(!$this->supplier_invoices_m-> exists($id) )
             {
             $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
            redirect('admin/supplier_invoices');
              }
        //search the item to show in edit form
        $get =  $this->supplier_invoices_m->find($id); 
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
							'supplier' => $this->input->post('supplier'), 
							'supplier_email' => $this->input->post('supplier_email'), 
							'supplier_phone' => $this->input->post('supplier_phone'), 
							'item' => $this->input->post('item'), 
							'quantity' => $this->input->post('quantity'), 
							'unit_price' => $this->input->post('unit_price'), 
                            'modified_by' => $user -> id ,   
                            'modified_on' => time() );

        //add the aux form data to the form data array to save
        $form_data = array_merge($form_data_aux, $form_data);

        //find the item to update
        
            $done = $this->supplier_invoices_m->update_attributes($id, $form_data);

        if ( $done) 
                {
				$this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_edit_success') ));
				redirect("admin/supplier_invoices/");
			}

			else
			{
				$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => $done->errors->full_messages() ) );
				redirect("admin/supplier_invoices/");
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
             $this->template->title('Edit Invoice ' )->build('admin/create', $data);
	}


	function delete($id = NULL, $page = 1)
	{
		//filter & Sanitize $id
		$id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

		//redirect if its not correct
		if (!$id){
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/supplier_invoices');
		}

		//search the item to delete
		if ( !$this->supplier_invoices_m->exists($id) )
		{
			$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );

			redirect('admin/supplier_invoices');
		}
 
		//delete the item
		                     if ( $this->supplier_invoices_m->delete($id) == TRUE) 
		{
			$this->session->set_flashdata('message', array( 'type' => 'sucess', 'text' => lang('web_delete_success') ));
		}
		else
		{
			$this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_delete_failed') ) );
		}

		redirect("admin/supplier_invoices/");
	}
  
    private function validation()
    {
$config = array(
                 array(
		 'field' =>'supplier',
                'label' => 'Supplier',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'supplier_email',
                'label' => 'Supplier Email',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'supplier_phone',
                'label' => 'Supplier Phone',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'item',
                'label' => 'Item',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'quantity',
                'label' => 'Quantity',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'unit_price',
                'label' => 'Unit Price',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/supplier_invoices/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 99999;
            $config['total_rows'] = $this->supplier_invoices_m->count();
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

    function create_custom_receipt()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        if ($post->supplier &&  count($post->items))
        {
            $form = [
                'expense' => $post->category->id,
                'supplier' => $post->supplier,
                'supplier_email'=>$post->email,
                'supplier_phone'=>$post->phone,
                'total' => $post->total,
                'balance' => $post->total,
                'status' => 1,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

           

            // print_r($form);
            $receipt = $this->supplier_invoices_m->create('supplier_invoices', $form);

            foreach ($post->items as $p)
            {
                $amount = $p->price * $p->qty;
                if (!$amount)
                {
                    continue;
                }
                $lines = [
                    'receipt' => $receipt,
                    'item' => $p->item,
                    'amount' => $amount,
                    'quantity' => $p->qty,
                    'unit_price' => $p->price,
                    'status' => 1,
                    'created_on' => time(),
                    'created_by' => $this->user->id,
                    'amount_due' => $amount
                ];

                $done =  $this->supplier_invoices_m->create('supplier_invoice_items', $lines);

                $expense_item = [
                    'name' => $p->item,
                    'description' => $done,
                    'created_by' => $this->user->id,
                    'created_on' => time(),
                ];

                $this->expense_items_m->create($expense_item);


                
            }
            echo json_encode(['message' => 'Success']);
        }
    }



    function view($id = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/supplier_invoices/');
        }
        if (!$this->supplier_invoices_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/supplier_invoices');
        }
        $receipt = $this->supplier_invoices_m->find($id);
        // $receipt->supplier =$this->lpo_m->find_supplier($lpo->supplier); 
        $receipt->items =$this->supplier_invoices_m->get_items($id);
         $data['receipt'] = $receipt;
         $data['expense_categories'] = $this->supplier_invoices_m->populate('expenses_category','id','account');
         $data['accounts'] = $this->supplier_invoices_m->get_accounts();
        // echo true;
        //load the view and the layout
        $this->template->title('View Invoice')->build('admin/view', $data);
    }

    public function receipt_number($maxlength = 6) {
        $chary = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
                        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $return_str = "";
        for ( $x=0; $x<=$maxlength; $x++ ) {
                $return_str .= $chary[rand(0, count($chary)-1)];
        }
        return $return_str;
    }

    function pay($id){
        if(!$id){
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/supplier_invoices/');
        }

        if($this->input->post())
        {
            $item = $this->input->post('itemss');
            $amount = $this->input->post('amount');
            $ref =  $this->receipt_number();
            $user = $this->ion_auth->get_user();

            $bank_id = $this->input->post('bank');
            

            if(is_array($item) && count($item) && is_array($amount) && count($amount))
            {
                $count = count($item);
                $total = 0;
                for($k=0; $k< $count; $k++)
                {
                   $data = [
                       'invoice' => $id,
                       'item' => $item[$k],
                       'amount' => $amount[$k],
                       'check_no' => $this->input->post('check_no'),
                       'bank' => $this->input->post('bank'),
                       'ref' => $ref,
                       'created_by' => $user->id,
                       'created_on' => time(),
                       'status' =>1
                   ]; 

                   $itemm =  $this->supplier_invoices_m->populate('expense_items','description','id');
                   $title = isset($itemm[$item[$k]]) ? $itemm[$item[$k]] : '';

                   $e_category =  $this->supplier_invoices_m->populate('supplier_invoices','id','expense');
                   $category = isset($e_category[$id]) ? $e_category[$id] : '';
                   $person = $user->id;

                   $ok = $this->supplier_invoices_m->create('supplier_payments',$data);
                   $expense = array(
                       'expense_date' => time(),
                       'title' => $title,
                       'category' => $category,
                       'amount' => $amount[$k],
                       'receipt_no' => $this->input->post('check_no'),
                       'bank_id' => $this->input->post('bank'),
                       'status' => 1,
                       'person_responsible' => $person,
                       'created_by' => $user->id,
                       'created_on' => time(),
                       'description' => $ok,
                   );
                    




                   $total += $amount[$k];
                   
                   //get item_amount_due

                   $amount_due = $this->supplier_invoices_m->item_amount_due($item[$k]);
                   $amt_due = ($amount_due - $amount[$k]) ;

                   $ite = [
                       'amount_due' => $amt_due,
                   ];

                   if($ok)
                   {
                       $this->supplier_invoices_m->update_bals($item[$k], $ite, 'supplier_invoice_items');
                       $this->expenses_m->create($expense);
                   }
                  

                }

              


                //get the supplier due
                $balance = $this->supplier_invoices_m->supplier_balance($id);
                $paid = $this->supplier_invoices_m->supplier_paid($id);
                $pay = ($paid+$total);
                $bal = ($balance - $total);
                $supp = [
                    'balance' => $bal,
                    'paid' => $pay,
                ];
                
                $update = $this->supplier_invoices_m->update_bals($id, $supp, 'supplier_invoices');

                if($update)
                {
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Selected Items paid Successfully "));
                }else
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Something went wrong "));
                }

                redirect('admin/supplier_invoices/receipt/'.$ref);
            }
        }

        $data['supplier'] = $id;
        $data['phone'] = $this->supplier_invoices_m->populate('supplier_invoices','id','supplier_phone');
        $data['items'] = $this->supplier_invoices_m->get_items($id);
        $data['suppliers'] = $this->supplier_invoices_m->supplier();
        $data['banks'] = $this->fee_payment_m->list_banks();
        $this->template->title('Pay Invoice')->build('admin/pay', $data);
    }

    function paid_invoices()
    {
        $data['paid'] = $this->supplier_invoices_m->get_payments();
        $data['suppliers'] = $this->supplier_invoices_m->supplier();
        $data['items'] = $this->supplier_invoices_m->receipt_items();
        $data['paid_total'] = $this->supplier_invoices_m->populate('supplier_invoices','id','paid');
        $data['balance'] = $this->supplier_invoices_m->populate('supplier_invoices','id','balance');
        $data['item_balance'] = $this->supplier_invoices_m->populate('supplier_invoice_items','id','amount_due');
        $data['item'] = $this->supplier_invoices_m->populate('supplier_invoice_items','id','item');
        $this->template->title('Paid Invoices')->build('admin/paid', $data);
    }

    function receipt($ref)
    {
        $data['receipt'] = $this->supplier_invoices_m->receipt($ref);
        $data['items'] = $this->supplier_invoices_m->receipt_items();
        $data['balance'] = $this->supplier_invoices_m->populate('supplier_invoices','id','balance');
        $data['suppliers'] = $this->supplier_invoices_m->supplier();
        $data['amount'] = $this->supplier_invoices_m->total_receipt($ref);
        $data['payments'] = $this->supplier_invoices_m->get_receipt_data($ref);
        $data['banks'] = $this->fee_payment_m->list_banks();
        $data['expense'] = $this->supplier_invoices_m->populate('supplier_invoices','id','expense');
        $data['expense_categories'] = $this->supplier_invoices_m->populate('expenses_category','id','account');
        $data['accounts'] = $this->supplier_invoices_m->get_accounts();
        $this->template->title('Receipt')->build('admin/receipt', $data);
    }

    function aging()
    {
        $max = 0;
        $min = 0;

        if($this->input->post())
        {
            $min = $this->input->post('from');
            $max = $this->input->post('to');
            
        }

        $days = [

            0 => 0,
            15 => 15,
            30 => 30,
            45 => 45,
            60 => 60,
            90 => 90,
          
        ];

       
        
        $data['days'] = $days;
        $data['suppliers'] = $this->supplier_invoices_m->suppliers($min, $max);
        
        $this->template->title('Aging Summary')->build('admin/aging', $data);
    }

    function statement()
    {
      $data['suppliers'] =  $this->supplier_invoices_m->all_suppliers();
        $this->template->title('Suppliers')->build('admin/supplier', $data);
        
    }

    function view_statement($id)
    {
        $payload = [];

        if($this->input->post())
        {
            $from = strtotime($this->input->post('from'));
            $to = strtotime($this->input->post('to'));

            $payload = $this->supplier_invoices_m->get_statement($id, $from, $to);
        } else
        {

            $payload =  $this->supplier_invoices_m->get_statement($id);
        }

        $post = $this->supplier_invoices_m->find($id);
        $data['post'] = $post;
        $data['payload'] = $payload;
        $this->template->title($post->supplier. '-supplier Statement')->build('admin/statement', $data);
        
    }


    function void_payment($id)
    {
        $row = $this->supplier_invoices_m->get_payment($id);
        $invoice = $this->supplier_invoices_m->find($id);

        $inv_update = [
            'balance' => $invoice->balance + $row->amount,
            'paid' => $invoice->paid -$row->amount,
        ];

        $item = $this->supplier_invoices_m->item_row($row->item);

        $items_update = [
            'amount_due' => $item->amount_due + $row->amount
        ];

        $up =  $this->supplier_invoices_m->update_attributes($invoice->id, $inv_update);


        if($up)
        {

            $this->supplier_invoices_m->update_table('supplier_invoice_items', $item->id, $items_update);
            $ok = $this->supplier_invoices_m->unlink_payment($id);
        }

        if ($ok) {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Payment Voided Successfully'));
            redirect("admin/supplier_invoices/paid_invoices");
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Someting went wrong!!'));
            redirect("admin/supplier_invoices/paid_invoices");
        }
 
    }
}