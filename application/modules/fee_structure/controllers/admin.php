<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        $this->load->model('fee_structure_m');
        $valid = $this->portal_m->get_class_ids();
        if ($this->input->get('sw'))
        {
            $pop = $this->input->get('sw');
            //limit to available classes only
            if (!in_array($pop, $valid))
            {
                $pop = $valid[0];
            }
            $this->session->set_userdata('pop', $pop);
        }
        else if ($this->session->userdata('pop'))
        {
            $pop = $this->session->userdata('pop');
        }
        else
        {
            //$pop = $valid[0];
            // $this->session->set_userdata('pop', $pop);
        }
    }

    /**
     * remove_session Clear Highlighted Class
     * 
     */

    public function fx_invoice()
    {
        $this->fee_structure_m->fx_invoice();
    }

	public function update_invs()
    {
        $this->fee_structure_m->update_invs();
    }
	
	public function update_pays()
    {
        $this->fee_structure_m->update_pays();
    }

	public function remove_session()
    {
        $this->session->unset_userdata('pop');
    }

    /**
     * List Fee Structures
     * 
     */
    public function index()
    {
        $fee = $this->fee_structure_m->get_list();

        $data['fee'] = $fee;
        $data['class'] = $this->portal_m->get_class_options();
        //load view
        $this->template->title('Fee Structure')->build('admin/list', $data);
    }

    /**
     * Fee Extras Chargeable to Student
     * 
     */
    public function extras()
    {
       
        $list = $this->fee_structure_m->get_ex_list();
        
        // $list = $this->fee_structure_m->populate('fee_extras', 'id', 'title');
        $this->form_validation->set_rules($this->ex_validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $slist = $this->input->post('sids');
            $fee = $this->input->post('fee');
            $inv_date = $this->input->post('inv_date');
            $amount = $this->input->post('amount');
            $desc = $this->input->post('description');
            $term = $this->input->post('term');
            $year = $this->input->post('year');
            $i = 0;
            $j = 0;
            $amt = 0;
            if (is_array($slist) && count($slist))
            {
                foreach ($slist as $s)
                {
                    // $invoice = $this->fee_structure_m->get_series();
                    // $invoice_no = 'INM' . str_pad($invoice, 4, '0', STR_PAD_LEFT);

                    $invoice = $this->fee_structure_m->get_series();
                    $invoice_no = 'INM' .$invoice;
                    $lenn = count($fee);
                    if ($lenn)
                    {
                        for ($ii = 0; $ii < $lenn; $ii++)
                        {
                            if (isset($fee[$ii]) && isset($term[$ii]) && isset($year[$ii]) && isset($amount[$ii]))
                            {
                                if ($fee[$ii] > 0 && $term[$ii] > 0 && $year[$ii] && $amount[$ii] > 0)
                                {
                                    $xr = [
                                        'student' => $s,
                                        'term' => $term[$ii],
                                        'year' => $year[$ii],
                                        'amount' => $amount[$ii],
                                        'description' => $desc[$ii],
                                        'fee_id' => $fee[$ii],
                                        'created_on' => strtotime($inv_date),
                                        'created_by' => $this->ion_auth->get_user()->id,
                                        // 'qb_status' => 0,
                                        // 'status' => 0,
                                        // 'flagged' => 0,
                                    ];

                                    $amt +=$amount[$ii];
                                    $has_id = $this->fee_structure_m->is_invoiced($fee[$ii], $s, $term[$ii], $year[$ii]);

                                    if ($has_id)
                                    {
                                        $rf = $this->fee_structure_m->get_extra($fee[$ii]);
                                        $dem = ($rf && $rf->cycle == '999') ? 1 : 0;
                                        $this->fee_structure_m->invoice_fee($xr, $has_id, $dem);
                                        $dem ? $i++ : $j++;
                                    }
                                    else
                                    {
                                        $xr['invoice_no'] = $invoice_no;
                                        // insert new invoice
                                        $rid = $this->fee_structure_m->invoice_fee($xr);

                                        $details = implode(' , ', $xr);
                                        $user = $this->ion_auth->get_user();
                                        $log = array(
                                            'module' => $this->router->fetch_module(),
                                            'item_id' => $rid,
                                            'transaction_type' => $this->router->fetch_method(),
                                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $rid,
                                            'details' => $details,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->ion_auth->create_log($log);

                                        /* if (isset($fetypes[$fee[$ii]]))
                                          {
                                          if ($fetypes[$fee[$ii]] == 1)
                                          {
                                          $this->worker->log_journal($amount[$ii], 'fee_extra_specs', $rid, array(1102 => 'debit', 4001 => 'credit'));
                                          }
                                          else//waiver
                                          {
                                          $this->worker->log_journal($amount[$ii], 'fee_extra_specs', $rid, array(4001 => 'debit', 1102 => 'credit'));
                                          }
                                          } */

                                        $i++;
                                    }
                                    //update student Balance
                                }
                            }
                        }
                    }
                    $this->worker->calc_balance($s);
                }

                //get the account balance for the account receivables

                $acc_r = $this->fee_structure_m->get_accounts_bal('610');
                $rev = $this->fee_structure_m->get_accounts_bal('260');
                //update the balance
                $new_bal_dr = ($acc_r->dr + $amt);
                $new_bal_cr = ($rev->cr + $amt);

                $dr = array(
                    'dr' => $new_bal_dr,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                $cr = array(
                    'cr' => $new_bal_cr,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                $this->fee_structure_m->update_account('31',$dr);
                $this->fee_structure_m->update_account('2',$cr);
              

              
            }

            $mess = 'Status: Made ' . $i . ' new Invoices and Updated ' . $j . ' Existing Invoices ';
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Success'));
            redirect('admin/fee_structure/extras');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->ex_validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            $data['list'] = $list;

            $range = range(date('Y') - 1, date('Y') + 1);
            $data['yrs'] = array_combine($range, $range);
            //load view
            $this->template->title(' Fee Structure Extras ')->build('admin/extras', $data);
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
        $output = $this->fee_structure_m->list_fee_extras($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {        //Validation OK!
            $user = $this->ion_auth->get_user();
            $term = $this->input->post('term');
            $class = $this->input->post('school_class');
            $amount = $this->input->post('tuition');
            $ok = [];
            $exst = 0;
            if (( is_array($term) && count($term)) && ( is_array($class) && count($class)) && $amount)
            {
                foreach ($class as $cc)
                {
                    foreach ($term as $tt)
                    {
                        if (!$this->fee_structure_m->feest_exists($cc, $tt))
                        {
                            $spec = array(
                                'class_id' => $cc,
                                'amount' => $amount,
                                'term' => $tt,
                                'created_by' => $user->id,
                                'created_on' => time()
                            );

                            $ok[] = $this->fee_structure_m->save_class_fee($spec);
                        }
                        else
                        {
                            $exst++;
                        }

                        $details = implode(' , ', $spec);
                        $user = $this->ion_auth->get_user();
                        $log = array(
                            'module' => $this->router->fetch_module(),
                            'item_id' => count($ok),
                            'transaction_type' => $this->router->fetch_method(),
                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . count($ok),
                            'details' => $details,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $this->ion_auth->create_log($log);
                    }
                }
            }

            if (count($ok))
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                if (count($exst))
                {
                    $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'Fee Structure Already Exists'));
                }
                else
                {
                    $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_create_failed')));
                }
            }
            redirect('admin/fee_structure/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }
            $data['result'] = $get;
            $data['class'] = $this->portal_m->get_class_options();
            $data['banks'] = $this->fee_structure_m->banks();
            //load the view and the layout
            $this->template->title('Add Fee Structure ')->build('admin/create', $data);
        }
    }

    /**
     * Ajax Edit Fee
     * 
     */
    function update_fee()
    {
        $name = $this->input->post('name');
        $val = $this->input->post('value');
        if ($name && $val)
        {
            $dest = explode('__', $name);
            if (count($dest))
            {
                $id = $dest[1];
                $fee = array(
                    $dest[0] => str_replace(',', '', $val),
                    'modified_on' => time(),
                    'modified_by' => $this->user->id,
                );

                //update route
                $done = $this->fee_structure_m->update_fee($id, $fee);

                $details = implode(' , ', $fee);
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $done,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);
            }
        }
    }

    /**
     * Generate Invoice
     * 
     */
     function invoice()
    {
        $flag = FALSE;
        $show_bal = $this->input->post('bal');
        $show_wv = $this->input->post('waiver');

        if ($this->input->post())
        {
            $flag = TRUE;
            $class = $this->input->post('class');
            $students = $this->input->post('students');
            $term = $this->input->post('term');
            $year = $this->input->post('year');

            if ($students)
            {
                $list = $students;
            }
            else
            {
                $list = $this->portal_m->fetch_students($class);
            }

            $bal = [];
            $parent = [];
            $payload = [];
            foreach ($list as $key => $sid)
            {
                $payload[$sid]['bal'] = $this->fee_structure_m->fetch_balance($sid);
                $payload[$sid]['parent'] = $this->fee_structure_m->fetch_parent($sid);
                $payload[$sid]['invoice'] = $this->worker->float_statement($sid, $term, $year);
            }
        }
        else
        {
            $parent = FALSE;
            $bal = FALSE;
            $id = FALSE;
            $payload = [];
        }
        $fee_structure = [];
        if (!empty($fee_structure))
        {
            foreach ($fee_structure as $f)
            {
                $f->classes = []; //deleted
            }
        }
        else
        {
            $fee_structure = [];
        }
        $fnl = [];
        foreach ($fee_structure as $fee)
        {
            if (isset($fee->classes) && !empty($fee->classes))
            {
                foreach ($fee->classes as $tt => $fspe)
                {
                    foreach ($fspe as $clas => $spec)
                    {
                        $fnl[$tt][$clas] = $spec;
                    }
                }
            }
        }

        $data['fxtras'] = $this->fee_structure_m->fetch_extras();
        if (!$flag)
        {
            $data['parent'] = $parent;
            $data['bal'] = $bal;
            $data['post'] = $this->fee_structure_m->get_student($id);
            $data['id'] = $id;
            $data['inov'] = str_pad(($id + 247), 5, '0', 0);
        }
        $data['payload'] = $payload;
        $data['fee'] = $fnl;
        $data['flag'] = $flag;
        $data['has_wv'] = $show_wv;
        $data['has_bal'] = $show_bal;

        $data['classes_groups'] = $this->fee_structure_m->populate('class_groups', 'id', 'name');
        $data['classes'] = $this->fee_structure_m->populate('classes', 'id', 'class');
        $data['class_str'] = $this->fee_structure_m->populate('classes', 'id', 'stream');
        $data['stream_name'] = $this->fee_structure_m->populate('class_stream', 'id', 'name');
        $data['banks'] = $this->fee_structure_m->banks();

        //load the view and the layout
        $this->template->title('Fee Structure')->build('admin/invoice', $data);
    }

    /**
     * Manage Fee Extras
     * 
     */
    function my_extras()
    {
        $show = FALSE;
        $show_iv = FALSE;
        $show_uf = FALSE;
        $sids = $this->input->post('student');
        $fee = $this->input->post('fee');
        $term = $this->input->post('term');
        $year = $this->input->post('year');
        if ($this->input->post('extras'))
        {
            if ($sids && !empty($sids))
            {
                $fsids = explode(',', $sids);
                $fxs = [];

                foreach ($fsids as $ff)
                {
                    $fxs[] = $this->fee_structure_m->get_fee_extras($ff, $fee, $term, $year);
                }
                $data['feex'] = $fxs;
                $show = TRUE;

                // $data['pk'] = $student;
            }
        }
        elseif ($this->input->post('invoices'))
        {
            if (!empty($sids))
            {
                $fsids = explode(',', $sids);
                $invoices = $fxs[] = $this->fee_structure_m->get_invoices($fsids);
                $show_iv = TRUE;
                $data['invoices'] = $invoices;
            }
        }
        elseif ($this->input->post('uniform'))
        {
            if (!empty($sids))
            {
                $fsids = explode(',', $sids);
                $uniform = $fxs[] = $this->fee_structure_m->get_uniform($fsids);
                $show_uf = TRUE;
                $data['uniform'] = $uniform;
            }
        }
        else
        {
            
        }
        $data['show'] = $show;
        $data['iv'] = $show_iv;
        $data['unf'] = $show_uf;
        $data['extras'] = $this->fee_structure_m->populate('fee_extras', 'id', 'title');
        $data['sale_items'] = []; // $this->fee_structure_m->populate('sales_items', 'id', 'name');
        $this->template->title('Manage Fee Extras')->build('admin/feex', $data);
    }

    /**
     * Update Fee Extra Amounts
     * 
     */
    function put_extras($slot = 0)
    {
        $f_id = $this->input->post('name');
        $val = $this->input->post('value');
        $stud = $this->input->post('pk');

        $map = [0 => 'amount', 1 => 'year', 2 => 'term'];
        $user = $this->ion_auth->get_user();
        if ($f_id && $val)
        {
            $dest = explode('_', $f_id);
            if (count($dest) && isset($dest[1]))
            {
                $sid = $dest[1];
                $rmk = [
                    $map[$slot] => $val,
                    'modified_on' => time(),
                    'modified_by' => $user->id,
                ];

                $row = $this->fee_structure_m->fee_specs($sid);
                if(isset($rmk['amount'])){
                    $amount = $rmk['amount'];
                    //get account data
                    $acc_receivable_bal= $this->fee_structure_m->get_accounts_bal('610');//accounts receivable dr
                    $revenue_bal= $this->fee_structure_m->get_accounts_bal('260');//Revenue cr

                    $dr = $acc_receivable_bal->dr;
                    $cr = $revenue_bal->cr;
                    $inv_amount = $row->amount;
                    $new_bal_dr = 0;


                    if($amount > $inv_amount){
                        // echo true;
                        $diff = ($amount - $inv_amount);
                        $new_bal_dr = ($dr + $diff);
                        $new_bal_cr = ($cr + $diff);
                    }
    
                    if($amount < $inv_amount){
                        $diff = ($inv_amount-$amount);
                        $new_bal_dr = ($dr - $diff);
                        $new_bal_cr = ($cr - $diff);
                    }

                    $update_dr = array(
                        'dr' => $new_bal_dr,
                        'modified_by' => $user->id,
                        'modified_on' => time()
                    );
    
                    $update_cr = array(
                        'cr' => $new_bal_cr,
                        'modified_by' => $user->id,
                        'modified_on' => time()
                    );
    

                    // print_r($update_cr);
                    $this->fee_structure_m->update_account('31',$update_dr); //dr accounts Receivable
                    $this->fee_structure_m->update_account('2', $update_cr); //cr accounts receivable

                    
                }
                //update Amount
                $done = $this->fee_structure_m->update_extras($sid, $rmk);
                $this->worker->calc_balance($stud);

                $details = implode(' , ', $rmk);
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $done,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);
                
               
            }
        }
    }

    /**
     * Update Tuition Fee Amount
     * 
     */
    function edit_invoice($key = 0)
    {
        $value = $this->input->post('value');
        $id = $this->input->post('pk');
        $user = $this->ion_auth->get_user();
        $map = [
            0 => 'amount',
            1 => 'term',
            2 => 'year'
        ];
        if ($id && $value)
        {
            $form = [
                'modified_on' => time(),
                'modified_by' => $user->id,
            ];
            $form[$map[$key]] = $value;


            $row = $this->fee_structure_m->find_invoice($id);
            if(isset($form['amount'])){
               
                $amount = $form['amount'];
                
                //get account data
                $acc_receivable_bal= $this->fee_structure_m->get_accounts_bal('610');//accounts receivable dr
                $revenue_bal= $this->fee_structure_m->get_accounts_bal('200');//Revenue cr

                $dr = $acc_receivable_bal->dr;
                $cr = $revenue_bal->cr;
                $inv_amount = $row->amount;
                $new_bal_dr = 0;
 
                
                if($form['amount'] > $inv_amount){
                    // echo true;
                    $diff = ($amount - $inv_amount);
                    $new_bal_dr = ($dr + $diff);
                    $new_bal_cr = ($cr + $diff);
                }

                if($form['amount'] < $inv_amount){
                    $diff = ($inv_amount-$amount);
                    $new_bal_dr = ($dr - $diff);
                    $new_bal_cr = ($cr - $diff);
                }

                $update_dr = array(
                    'dr' => $new_bal_dr,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                $update_cr = array(
                    'cr' => $new_bal_cr,
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                $this->fee_structure_m->update_account('31',$update_dr); //dr accounts Receivable
                $this->fee_structure_m->update_account('1', $update_cr); //cr accounts receivable
               

               
            }
            //update Amount
            $done = $this->fee_structure_m->update_invoice($id, $form);
            $row = $this->fee_structure_m->find_invoice($id);
            //update statement
            $this->worker->calc_balance($row->student_id);


            $details = implode(' , ', $form);
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $done,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                'details' => $details,
                'created_by' => $user->id,
                'created_on' => time()
            );

           

            
          
           
            $this->ion_auth->create_log($log);
        }
    }

    /**
     * Remove Fee Extra Amount
     *  
     */
    function remove_extra()
    {
        $id = $this->input->post('id');
        $stud = $this->input->post('rec');
        if ($id && $stud)
        {
            //Remove Amount
            $done = $this->fee_structure_m->remove_extras($id);
            $this->worker->calc_balance($stud);

            $details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $done,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                'details' => $details,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);
        }
    }

    /**
     * delete_bulk_extras
     */
    function delete_bulk_extras()
    {
        $ids = $this->input->post('sids');
        $amount = 0;
       

        foreach ($ids as $student => $rws)
        {
            foreach ($rws as $id)
            {
                //Remove Amount
                $get = $this->fee_structure_m->fee_specs($id);
                $amount += $get->amount;
                
                $ok = $this->fee_structure_m->remove_extras($id);
                $this->worker->calc_balance($student);
            }
        }


        $acc_receivable_bal= $this->fee_structure_m->get_accounts_bal('610');//accounts receivable dr
        $revenue_bal= $this->fee_structure_m->get_accounts_bal('260');//other revenue cr

        $new_balance_dr = ($acc_receivable_bal->dr - $amount);
        $new_balance_cr = ($revenue_bal->cr - $amount);

        $dr = array(
            'dr' => $new_balance_dr,
            'modified_on' =>time(),
            'modified_by' => $this->ion_auth->get_user()->id
        );

        $cr = array(
            'cr' => $new_balance_cr,
            'modified_on' =>time(),
            'modified_by' => $this->ion_auth->get_user()->id
        );
        
        if($ok){
            $this->fee_structure_m->update_account('31',$dr); //dr accounts Receivable
            $this->fee_structure_m->update_account('2', $cr); //cr accounts receivable  
        }

        // echo $amount;
        // echo '<pre>';
        // print_r($cr);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($dr);
        // echo '</pre>';
        redirect('admin/fee_structure/my_extras');
    }

    /**
     * Return List of Students in Posted Class
     */
    function get_class_targets()
    {
        $class = $this->input->post('class');
        $list = $this->fee_structure_m->fetch_full_students($class);
        echo json_encode($list);
    }

    /**
     * Fetch Default Amount For Fee Extra Record
     * 
     * @return string
     */
    function fetch_default()
    {
        $fee = $this->input->post('fee');
        if ($fee)
        {
            $res = $this->fee_structure_m->get_extra($fee);
            echo $res->amount ? $res->amount : '0';
        }
        else
        {
            echo '0';
        }
    }

    function delete($id = NULL, $page = 1)
    {
        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_structure');
        }

        //search the item to delete
        if (!$this->fee_structure_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_structure');
        }
        //delete the item
        if ($this->fee_structure_m->delete($id) == TRUE)
        {

            //$details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $id,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
                'details' => 'Recorde Deleted',
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }
        redirect("admin/fee_structure/");
    }

    function void_invoice($id)
    {
        //redirect if its not correct
        if (!$id)
        {
            return FALSE;
        }
        $row = $this->fee_structure_m->find_invoice($id);
        //search the item to delete
        if (!$this->fee_structure_m->iv_exists($id))
        {
            return FALSE;
        }
        $finv = array(
            'check_st' => 3,
            'modified_by' => $this->ion_auth->get_user()->id,
            'modified_on' => time()
        );
        // echo '<pre>';
        // print_r($row);
        // echo '</pre>';
        //get account balances for both dr and cr acc
        $acc_receivable_bal= $this->fee_structure_m->get_accounts_bal('610');//accounts receivable dr
        $revenue_bal= $this->fee_structure_m->get_accounts_bal('200');//Revenue cr

        $new_balance_dr = ($acc_receivable_bal->dr - $row->amount);
        $new_balance_cr = ($revenue_bal->cr - $row->amount);

        $dr = array(
            'dr' => $new_balance_dr,
            'modified_on' =>time(),
            'modified_by' => $this->ion_auth->get_user()->id
        );

        $cr = array(
            'cr' => $new_balance_cr,
            'modified_on' =>time(),
            'modified_by' => $this->ion_auth->get_user()->id
        );

        $this->fee_structure_m->update_account('31',$dr); //dr accounts Receivable
        $this->fee_structure_m->update_account('1', $cr); //cr accounts receivable
        return $this->fee_structure_m->suspend_invoice($id, $finv);

        $details = implode(' , ', $finv);
        $user = $this->ion_auth->get_user();
        $log = array(
            'module' => $this->router->fetch_module(),
            'item_id' => $id,
            'transaction_type' => $this->router->fetch_method(),
            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
            'details' => $details,
            'created_by' => $user->id,
            'created_on' => time()
        );

        $this->ion_auth->create_log($log);
    }

    function void_uniform($id)
    {
        $row = $this->fee_structure_m->find_sales_invoice($id);
        $student = $row->student;

        $item = $this->fee_structure_m->fetch_item($row->item_id);

        $qty = floor($row->amount / $item->price);

        if ($id && $student)
        {
            //Remove Amount
            $this->fee_structure_m->remove_sales_invoice($id);

            //update stock
            $this->fee_structure_m->update_stock($row->item_id, $qty, $student, 'invoice');
            $this->worker->calc_balance($student);
        }
    }

    /**
     * Validation For Fee Extras
     * 
     */
    private function ex_validation()
    {
        $config = array(
            array(
                'field' => 'sids',
                'label' => 'Student List',
                'rules' => 'xss_clean|callback__valid_sid'),
            array(
                'field' => 'fee',
                'label' => 'Applicable Fee',
                'rules' => 'required|xss_clean'),
				
				array(
                'field' => 'inv_date',
                'label' => 'inv_date',
                'rules' => 'xss_clean'),
            array(
                'field' => 'year',
                'label' => 'Fee Year',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'term',
                'label' => 'Fee Term',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'amount',
                'label' => 'Fee Amount',
                'rules' => 'xss_clean|required')
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
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

    private function validation()
    {
        $config = array(
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'school_class',
                'label' => 'Class',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'tuition',
                'label' => 'Tuition Fee',
                'rules' => 'required')
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = [];
        $config['base_url'] = site_url() . 'admin/fee_structure/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 100;
        $config['total_rows'] = $this->fee_structure_m->count();
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


    function filter_extras()
    {
        if($this->input->post())
        {
            $class = $this->input->post('class');
            $item =  $this->input->post('fee');
            $term  = $this->input->post('term');
            $year = $this->input->post('year');
            $student = $this->input->post('student');

            $payload = $this->fee_structure_m->filter( $term, $year, $item, $student, $class);

        }

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);

        $data['payload'] = $payload;

        $data['yrs'] = $yrs;

        $data['extras'] = $this->fee_structure_m->get_ex_list();

        $this->template->title(' Fee Extras In ')->build('admin/filter', $data);
    }

    function save_invoice()
    {
        if ($this->input->post())
        {

            // echo '<pre>';
            // print_r($this->input->post());
            // echo '</pre>';
            // die;
         
            $slist = $this->input->post('sids');
            $fee = $this->input->post('feee');
            $amount = $this->input->post('amount');
            $desc = $this->input->post('description');
            $term = $this->input->post('termx');
            $year = $this->input->post('yearx');
            $i = 0;
            $j = 0;
            $amt = 0;

            foreach ($slist  as  $k) 
            {
                 $invoice = $this->fee_structure_m->get_series();
                 $invoice_no = 'INV' . str_pad($invoice, 4, '0', STR_PAD_LEFT);

                 if (isset($fee[$k]) && isset($term) && isset($year) && isset($amount[$k]))
                 {
                    $count =  count($fee[$k]);
                    for($z =0; $z<$count; $z++)
                    {


                    if ($fee[$k][$z] > 0 && $term > 0 && $year > 0 && $amount[$k][$z] > 0)
                    {

                        $xr = [
                            'student' => $k,
                            'term' => $term,
                            'year' => $year,
                            'amount' => $amount[$k][$z],
                            'description' => $desc[$k][$z],
                            'fee_id' => $fee[$k][$z],
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id,
                            // 'qb_status' => 0,
                            // 'status' => 1,
                            // 'flagged' => 0,
                        ];

                        $amt +=$amount[$k][$z];
                        $has_id = $this->fee_structure_m->is_invoiced($fee[$k][$z], $k, $term, $year);

                        if ($has_id)
                        {
                            $rf = $this->fee_structure_m->get_extra($fee[$k][$z]);
                            $dem = ($rf && $rf->cycle == '999') ? 1 : 0;
                            $this->fee_structure_m->invoice_fee($xr, $has_id, $dem);
                            $dem ? $i++ : $j++;
                        }
                        else
                        {
                            $xr['invoice_no'] = $invoice_no;
                            // insert new invoice
                            $rid = $this->fee_structure_m->invoice_fee($xr);

                            $details = implode(' , ', $xr);
                            $user = $this->ion_auth->get_user();
                            $log = array(
                                'module' => $this->router->fetch_module(),
                                'item_id' => $rid,
                                'transaction_type' => $this->router->fetch_method(),
                                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $rid,
                                'details' => $details,
                                'created_by' => $user->id,
                                'created_on' => time()
                            );

                            $this->ion_auth->create_log($log);

                           

                            $i++;
                        }

                        $this->worker->calc_balance($k);
                    }
                }
                 }
            }


 

            $mess = 'Status: Made ' . $i . ' new Invoices and Updated ' . $j . ' Existing Invoices ';
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
            redirect('admin/fee_structure/filter_extras');
        }
    }

}
