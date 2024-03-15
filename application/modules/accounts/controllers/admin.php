<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends Admin_Controller
    {

         function __construct()
         {
              parent::__construct();
              /* $this->template->set_layout('default');
                $this->template->set_partial('sidebar', 'partials/sidebar.php')
                ->set_partial('top', 'partials/top.php'); */

              if (!$this->ion_auth->logged_in())
              {
                   redirect('admin/login');
              }

              $this->load->model('accounts_m');
              $this->load->model('fee_payment/fee_payment_m');

              /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                redirect('admin');
                } */
         }

     

         public function index()
         {


             $data['charts'] = $this->accounts_m->populate_enc('accounts', 'id', 'name');
              $config = $this->set_paginate_options();  //Initialize the pagination class
              $this->pagination->initialize($config);

              $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

              $data['accounts'] = $this->accounts_m->paginate_all($config['per_page'], $page);

              //create pagination links
              $data['links'] = $this->pagination->create_links();

              //page number  variable
              $data['page'] = $page;
              $data['per'] = $config['per_page'];

              //load view
              $this->template->title(' Accounts ')->build('admin/list', $data);
         }

         public function trial()
         {
              $accounts = $this->worker->fetch_accounts();
              $data['accounts'] = $accounts;

              //load view
              $this->template->title('Accounts - Trial Balance')->build('admin/trialb', $data);
         }

         public function trial_()
         {
               $from = "";
               $to ="";
               if($this->input->post()){
                    
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');

                    if($from){
                         $from = strtotime($from);
                    }
                    if($to){
                         $to = strtotime($to);
                    }
               }
              $accounts = $this->worker->fetch_accounts();
              $data['accounts'] = $accounts;
              $data['acc_payable'] =$this->accounts_m->t_supplier_invoices($from, $to);
              $data['fee_payment'] = $this->accounts_m->t_tuition_invoices($from, $to);
              $data['other_revenue'] = $this->accounts_m->other_revenue($from, $to);
              $data['cr_acc_receivable'] = $this->accounts_m->acc_receivable($from, $to);
              $data['bank'] = $this->accounts_m->acc_receivable($from, $to);

              //load view
              $this->template->title('Accounts - Trial Balance')->build('admin/trial', $data);
         }


         public function pnl()
         {
              $accounts = $this->worker->fetch_pnl();
              $data['accounts'] = $accounts;
              
              //load view
              $this->template->title('Accounts - Profit & Loss')->build('admin/pnl', $data);
         }

         public function pnl__()
         {     
              $from = "";
              $to ="";
              if($this->input->post()){
                   
                   $from = $this->input->post('from');
                   $to = $this->input->post('to');

                   if($from){
                         $from = strtotime($from);
                   }
                   if($to){
                         $to = strtotime($to);
                   }
              }
              $accounts = $this->worker->fetch_pnl();
              $data['from'] = $from;
              $data['to']  = $to;
              $data['accounts'] = $accounts;
              $data['tuition'] = $this->accounts_m->t_tuition_invoices($from, $to);
              
              $data['extra'] = $this->accounts_m->other_revenue($from, $to);
              $expense_cats = $this->accounts_m->expense_cats();
              $accs = $this->accounts_m->accs();
              $data['e_cat'] = $this->accounts_m->acc_cat();

              $expenses=[];
              foreach($accs as $acc){
                   $cat_id = isset($expense_cats[$acc->id]) ? $expense_cats[$acc->id] : '';
                   //get expense item usinf the cat ids

                   $sum=0;
                 
                    $all = $this->accounts_m->get_expenses($cat_id, $from, $to);
                    foreach($all as $al => $amt ){
                         $sum += $amt;
                    }

                   $expenses[$cat_id]= $sum;
                 
                   
              }
              $data['expenses'] =  $expenses;

          
           
        
             
              
              //load view
              $this->template->title('Accounts - Profit & Loss')->build('admin/pnll', $data);
         }

         public function gl(){

               $from = 0;
               $to = 0;

               if($this->input->post()){
                   
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');
 
                    if($from){
                          $from = strtotime($from);
                    }
                    if($to){
                          $to = strtotime($to);
                    }
               }

               $data['tuition'] = $this->accounts_m->all_fee_p($from, $to);
               $data['expenses'] = $this->accounts_m->get_expenses_($from, $to);
               $data['e_item'] = $this->accounts_m->expense_item();
               $data['inventory'] = $this->accounts_m->get_invetory($from, $to);
               $data['items'] = $this->accounts_m->inventory_item();

               //load view
               $this->template->title('Accounts - General Ledger')->build('admin/gl', $data);
         }

         public function journal(){
               $from = 0;
               $to = 0;

               if($this->input->post()){
               
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');

                    if($from){
                         $from = strtotime($from);
                    }
                    if($to){
                         $to = strtotime($to);
                    }
               }
               $data['tuition'] = $this->accounts_m->all_fee_p($from, $to);
               $data['invoices'] = $this->accounts_m->get_tuition_invoices($from, $to);
               $data['expenses'] = $this->accounts_m->get_expenses_($from, $to);
               $data['e_item'] = $this->accounts_m->expense_item();
               $data['inventory'] = $this->accounts_m->get_invetory($from, $to);
               $data['items'] = $this->accounts_m->inventory_item();
               $this->template->title('Accounts - Journal Book')->build('admin/journal', $data);
         }

         public function balance()
         {
              $data['sheet'] = $this->worker->fetch_bsheet();

              //load view
              $this->template->title('Accounts - Balance Sheet')->build('admin/balance_sheet', $data);
         }

         function create($page = NULL)
         {

              /* if (!$this->ion_auth->is_in_group($this->user->id, 1))
                {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                redirect('admin/admission/my_students');
                } */
              //create control variables
              $data['updType'] = 'create';

              $data['account_types'] = $this->accounts_m->populate('account_types', 'id', 'name');

              $data['tax_config'] = $this->accounts_m->populate('tax_config', 'id', 'name');
              $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

              //Rules for validation
              $this->form_validation->set_rules($this->validation());

              //validate the fields of form
              if ($this->form_validation->run())
              {         //Validation OK!
                   $user = $this->ion_auth->get_user();
                   $form_data = array(
                           'name' => $this->input->post('name'),
                           'code' => $this->input->post('code'),
                           'account_type' => $this->input->post('account_type'),
                           'tax' => $this->input->post('tax'),
                           'created_by' => $user->id,
                           'created_on' => time()
                   );

                   $ok = $this->accounts_m->create($form_data);

                   if ($ok) 
                   {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                   }

                   redirect('admin/accounts/');
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
                   $this->template->title('Add Accounts ')->build('admin/create', $data);
              }
         }

         /**
          * Get Datatable
          * 
          */
         public function get_table()
         {
              $iDisplayStart = $this->input->get_post('iDisplayStart', true);
              $iDisplayLength = $this->input->get_post('iDisplayLength', true);
              $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
              $iSortingCols = $this->input->get_post('iSortingCols', true);
              $sSearch = $this->input->get_post('sSearch', true);
              $sEcho = $this->input->get_post('sEcho', true);

              $output = $this->accounts_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
              echo json_encode($output);
         }

         function edit($id = FALSE, $page = 0)
         {

              /* if (!$this->ion_auth->is_in_group($this->user->id, 1))
                {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                redirect('admin/admission/my_students');
                } */

              //get the $id and sanitize
              $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

              $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

              //redirect if no $id
              if (!$id)
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/accounts/');
              }
              if (!$this->accounts_m->exists($id))
              {
                   $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                   redirect('admin/accounts');
              }
              //search the item to show in edit form
              $get = $this->accounts_m->find($id);
              //variables for check the upload
              $form_data_aux = array();
              $files_to_delete = array();
              $data['account_types'] = $this->accounts_m->populate('account_types', 'id', 'name');

              $data['tax_config'] = $this->accounts_m->populate('tax_config', 'id', 'name');

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
                           'name' => $this->input->post('name'),
                           'code' => $this->input->post('code'),
                           'account_type' => $this->input->post('account_type'),
                           'tax' => $this->input->post('tax'),
                         //   'balance' => $this->input->post('balance'),
                           // 'dr' => $this->input->post('dr'),
                           // 'cr' => $this->input->post('cr'),
                           'modified_by' => $user->id,
                           'modified_on' => time());

                   //add the aux form data to the form data array to save
                   $form_data = array_merge($form_data_aux, $form_data);

                   //find the item to update

               //     print_r($form_data);die;

                   $done = $this->accounts_m->update_attributes($id, $form_data);

                   
                   if ($done)
                   {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                        redirect("admin/accounts/");
                   }
                   else
                   {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                        redirect("admin/accounts/");
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
              $this->template->title('Edit Accounts ')->build('admin/create', $data);
         }
 
          private function validation()
         {
              $config = array(
                      array(
                              'field' => 'name',
                              'label' => 'Name',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'code',
                              'label' => 'Code',
                              'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      array(
                              'field' => 'account_type',
                              'label' => 'Account Type',
                              'rules' => 'required|xss_clean'),
                      array(
                              'field' => 'tax',
                              'label' => 'Tax',
                              'rules' => 'required|xss_clean'),
                    //   array(
                    //           'field' => 'balance',
                    //           'label' => 'Balance',
                    //           'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      // array(
                      //         'field' => 'cr',
                      //         'label' => 'Credit',
                      //         'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                      // array(
                      //         'field' => 'dr',
                      //         'label' => 'Debit',
                      //         'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
              );
              $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
              return $config;
         }

         private function set_paginate_options()
         {
              $config = array();
              $config['base_url'] = site_url() . 'admin/accounts/index/';
              $config['use_page_numbers'] = TRUE;
              $config['per_page'] = 10;
              $config['total_rows'] = $this->accounts_m->count();
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

         function update_bal(){
              $accounts = $this->accounts_m->test_pnl();
              foreach($accounts as $ac){
                   $data=array(
                        'balance' => 0
                   );
                   $this->accounts_m->update_attributes($ac->id, $data);
              }
         }

         function expand_revenue($code){
               $from = "";
               $to ="";
               if($this->input->post()){
                    
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');

                    if($from){
                         $from = strtotime($from);
                    }
                    if($to){
                         $to = strtotime($to);
                    }
               }

               if($code == 200){
                    $data['tuition'] = $this->accounts_m->get_tuition_invoices($from, $to);
               }elseif ($code == 260) {
                    // $fee= $this->accounts_m->get_fee_payments($code);
                    // $data['extras'] = $this->accounts_m->populate('fee_extras', 'id', 'title');
                    $data['f_extras'] = $this->accounts_m->get_extra_invoices($from, $to);
               }elseif ($code == 399){
                    $data['waivers'] = $this->accounts_m->get_waivers();
               }else{
                    //do nothing
               }

               $data['from'] = $from;
               $data['to'] = $to;
              
               $this->template->title(' Revenue ')->build('admin/expand', $data);
         }

         function expand_expenses($id){
               $from = "";
               $to ="";
               if($this->input->post()){
                    
                    $from = $this->input->post('from');
                    $to = $this->input->post('to');

                    if($from){
                         $from = strtotime($from);
                    }
                    if($to){
                         $to = strtotime($to);
                    }
               }
               $expense_cats= $data['expense_cats'] = $this->accounts_m->get_expense_category($id);
               foreach($expense_cats as $e){
                    //    echo $e->id;
                    $expenses= $this->accounts_m->expenze($e->id, $from, $to);
                    $data['expense_items'] = $this->accounts_m->populate('expense_items', 'id', 'name');
                    $data['expense_categories'] = $this->accounts_m->populate('expenses_category', 'id', 'title');
                    $data['accounts'] = $this->accounts_m->populate_enc('accounts', 'id', 'name');
                    $data['expenses'] = $expenses;
                    $data['from'] = $from;
                    $data['to'] = $to;
               }

             $this->template->title('Expenses ')->build('admin/expand', $data);
         }

         function expand_assets($id){
              $data['assets'] = '';

              $this->template->title(' Assets ')->build('admin/expand', $data);

         }

         function expand_liabilities($id){
               $data['liabilities'] = '';

               $this->template->title(' Liabilities ')->build('admin/expand', $data);

         }

         function expand_equity(){
               $data['equities'] = '';

               $this->template->title(' Equity ')->build('admin/expand', $data);

         }

         function bank_reconciliation()
         {
          $user = $this->ion_auth->get_user();
          if($this->input->post())
          {
               $bank_id = $this->input->post('bank_id');
               $date = $this->input->post('date');
               $dr =  $this->input->post('dr');
               $cr =  $this->input->post('cr');
               $transaction =  $this->input->post('transaction');
               $bal = $this->accounts_m->bank_balance($bank_id);

               
               $new_bal = ($bal + $dr - $cr);
               
               


               $bank_bl = [
                   'balance' => $new_bal,
               ];


               $bank_trans = [
                    'bank' => $this->input->post('bank_id'),
                    'transaction' =>  $this->input->post('transaction'),
                    'dr' => $this->input->post('dr'),
                    'cr' => $this->input->post('cr'),
                    'balance' => $bal,
                    'created_on' => strtotime($date),
                    'status' => 1,
                    'created_by' => $user->id
                ];


                $upt = $this->accounts_m->update_bank_balance($bank_id, $bank_bl);

                $ok = $this->accounts_m->bank_transactions($bank_trans);

                $reconcile = [
                     'bank' => $bank_id,
                     'period' => strtotime($date),
                     'bank_trans_id'=> $ok,
                     'created_on' => strtotime($date),
                     'created_by' => $user->id
                ];

                $this->accounts_m->save_reconciliation($reconcile);

                if(($ok) && ($upt))
                {
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Selected Account Successfully Reconciled"));
                }else
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Could not Reconcile Selected Account!!"));
                }

                redirect('admin/accounts/bank_reconciliation');
          }
          $data['dr'] = $this->accounts_m->populate('bank_transactions', 'id' ,'dr');
          $data['cr'] = $this->accounts_m->populate('bank_transactions', 'id' ,'cr');
          $data['transaction'] = $this->accounts_m->populate('bank_transactions', 'id' ,'transaction');
          $data['recs'] = $this->accounts_m->get_renconciliations();
          $data['banks'] = $this->fee_payment_m->list_banks();
          $this->template->title(' Bank Reconciliations ')->build('admin/reconciliations', $data);
         }


         function cash_book()
         {
          
            // $from = "";
            // $bank = "";
            // $to ="";
            // if($this->input->post())
            // {
                
                $from = $this->input->post('from');
                $to = $this->input->post('to');
                $bank = $this->input->post('bank_id');
            
                if($from)
                {
                        $from = strtotime($from);
                }
                if($to)
                {
                        $to = strtotime($to);
                }
            // }
            // else
            // {

            // }
         
            $data['transactions'] = $this->accounts_m->gen_cashbook($from, $to, $bank);
            $data['banks'] = $this->fee_payment_m->list_banks();
            $this->template->title(' CASH BOOK ')->build('admin/cash_book', $data);
         }

    }
    