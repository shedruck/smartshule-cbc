<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Worker
{

    private $ci;
    private $terms;
    public $qb = 0;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('portal_m');
        $this->ci->load->model('accounting/accounting_m');
        $this->ci->load->model('admission/admission_m');
        $this->ci->load->model("fee_payment/fee_payment_m");
        $this->terms = $this->_terms();
        if ($this->qb)
        {
            $this->ci->load->model("quickbooks/quickbooks_m");
        }
    }

    /**
     * DB Based Sequential Invoice Number Generator
     * 
     * @return string
     */
    function gen_invoice()
    {
        $max = $this->ci->portal_m->get_max_invoice();
        if (!$max)
        {
            $max = 0;
        }
        $no = $max + 1;
        $str = str_pad($no, 3, '0', 0);
        $fn = 'FINV' . $str;

        return $fn;
    }

    function get_version()
    {
        return $this->qb;
    }

    /**
     * Fetch Admission Row
     * 
     * @param int $id
     * @return object
     */
    function get_student($id, $list = FALSE)
    {
        $row = $this->ci->admission_m->find($id, $list);
        if (empty($row))
        {
            $row = new stdClass();
            $row->first_name = '';
            $row->last_name = '';
            $row->class = 0;
            $row->dob = '';
            $row->admission_number = '';
        }

        if ($row->class)
        {
            $groups = $this->ci->admission_m->populate('class_groups', 'id', 'name');
            $streams = $this->ci->admission_m->populate('class_stream', 'id', 'name');
            $row->cl = $this->ci->admission_m->fetch_class($row->class);
            $st = '';
            $grp = '';
            if (isset($row->cl->stream))
            {
                $st = isset($streams[$row->cl->stream]) ? $streams[$row->cl->stream] : '';
            }
            if (isset($row->cl->class))
            {
                $grp = isset($groups[$row->cl->class]) ? $groups[$row->cl->class] : '';
            }
            $row->cl->name = $grp . ' ' . $st;
        }
        return $row;
    }

    function order_positions()
    {
        $pos = $this->ci->portal_m->put_positions();
        return $pos;
    }

    function performance_history()
    {
        $pos = $this->ci->portal_m->get_performance();
        return $pos;
    }

    /**
     * Fetch Accounts For Trial balance
     * 
     * @return type
     */
    function fetch_accounts()
    {
        $this->ci->load->model('accounts/accounts_m');
        $accounts = $this->ci->accounts_m->get_accounts();
        return $accounts;
    }

    /**
     * Fetch Accounts For PnL
     * 
     * @return array
     */
    function fetch_pnl()
    {
        $this->ci->load->model('accounts/accounts_m');
        $accounts = $this->ci->accounts_m->get_pnl();
        return $accounts;
    }

    /**
     * Fetch Accounts For balance sheet
     * 
     * @return object
     */
    function fetch_bsheet()
    {
        $this->ci->load->model('accounts/accounts_m');
        $accounts = $this->ci->accounts_m->get_balance_sheet();
        return $accounts;
    }

    /**
     * Process & Generate Invoices based on fee structure
     * 
     * @param boolean $buffers Show Output Flag
     * @param int $term 
     * @param int $year 
     * @param array $classes 
     */
    function do_invoice($buffers = TRUE, $term = FALSE, $year = FALSE, $classes = [])
    {
        ini_set('max_execution_time', 0);
        if ($buffers)
        {
            echo $this->fetch_str();
            echo '<div id="closure" style="width:500px; margin: 100px auto; ">
                                <div id="progress"></div>
                                <div id="information" ></div></div>';
        }
        $this->ci->load->model('invoices/invoices_m');
        if (!$term)
        {
            $term = get_term(date('m'));
        }
        if (!$year)
        {
            $year = date('Y');
        }
        $iclist = $this->ci->invoices_m->populate('class_groups', 'id', 'name');
        //invoice now
        if (empty($classes))
        {
            $classes = $this->ci->portal_m->get_classes();
        }
        $i = 0;

        foreach ($classes as $class)
        {
            $fee = $this->ci->portal_m->get_fee_structure($class, $term);

            if ($fee)
            {
                $list = $this->ci->portal_m->fetch_students($class);
                $kz = 0;
                foreach ($list as $key => $student)
                {
                    $is_invoiced = $this->ci->portal_m->is_invoiced($student, $term, $year);
                    if (!$is_invoiced)
                    {
                        //do invoice
                        $inv = $this->gen_invoice();
                        $invoice = array(
                            'student_id' => $student,
                            'term' => $term,
                            'year' => $year,
                            'invoice_no' => $inv,
                            'fee_id' => $fee->id,
                            'amount' => $fee->amount,
                            'check_st' => 1,
                            'created_by' => 1,
                            'created_on' => time()
                        );

                        $this->ci->portal_m->invoice_me($invoice);
                        $i++;
                    }

                    $kz++;
                    $fcl = isset($iclist[$class]) ? $iclist[$class] : $class;
                    if ($buffers)
                    {
                        $tx = 'Processing ' . $fcl;
                        $this->show_progress($kz, count($list), $tx);
                    }

                    //updbal
                    $this->calc_balance($student);
                }
            }
        }
        $log = array(
            'exec' => 1,
            'created_by' => 1,
            'created_on' => time()
        );
        $this->ci->portal_m->log_exec($log);
        if ($buffers)
        {
            $this->close_script();
        }
        return $i;
    }

    function sync_bals($buffers = TRUE)
    {
        ini_set('max_execution_time', 0);
        if ($buffers)
        {
            echo $this->fetch_str();
            echo '<div id="closure" style="width:500px; margin: 100px auto; ">
                                <div id="progress"></div>
                                <div id="information"></div>
                                </div>';
        }
        //invoice now
        $list = $this->ci->portal_m->get_all_students(0);

        $i = 0;
        foreach ($list as $student)
        {
            $i++;

            if ($buffers)
            {
                $tx = 'Processing ' . $i;
                $this->show_progress($i, count($list), $tx);
            }

            //updbal
            $this->calc_balance($student);
        }

        if ($buffers)
        {
            $this->close_script();
        }
        $log = array(
            'exec' => 1,
            'created_by' => 1,
            'created_on' => time()
        );
        $this->ci->portal_m->log_exec($log);

        return $i;
    }

    /**
     *  Generate Invoices based on fee structure for single Student
     * Without Saving to Database
     * 
     */
    function float_invoice($student, $term = 0, $year = 0)
    {
        $this->ci->load->model('invoices/invoices_m');

        //Get Class student was admitted
        $kid = $this->ci->portal_m->find($student);
        $row = $this->ci->portal_m->get_my_class($kid->class);

        $amount = 0;
        $fee = $this->ci->portal_m->get_fee_structure($row->class, $term);

        if ($fee)
        {
            $amount = $fee->amount;
        }

        $inv = str_pad(($student + 247), 5, '0', 0);
        return array(
            'student_id' => $student,
            'term' => $term,
            'year' => $year,
            'invoice_no' => $inv,
            'amount' => $amount,
            'created_on' => time()
        );
    }

    function float_invoice_bk($student)
    {
        $this->ci->load->model('invoices/invoices_m');
        $current = get_term(date('m'));
        $term = $current == 3 ? 1 : $current + 1; //find next term
        //Get Class student was admitted
        $kid = $this->ci->portal_m->find($student);
        $row = $this->ci->portal_m->get_my_class($kid->class);

        $amount = 0;
        if ($term == 1)//get next class
        {
            $class = $row->class + 1;
            $fee = $this->ci->portal_m->get_fee_structure($class, $term);
        }
        else
        {
            $fee = $this->ci->portal_m->get_fee_structure($row->class, $term);
        }
        if ($fee)
        {
            $amount = $fee->amount;
        }

        $inv = str_pad(($student + 247), 5, '0', 0);
        return array(
            'student_id' => $student,
            'term' => $term,
            'year' => ($term == 1) ? date('Y') + 1 : date('Y'),
            'invoice_no' => $inv,
            'amount' => $amount,
            'created_on' => time()
        );
    }

    /**
     * Process & Generate Invoices based on fee structure for single Student
     * 
     */
    function invoice_student($student, $class, $term = 0, $year = 0)
    {
        $this->ci->load->model('invoices/invoices_m');
        if (!$term)
        {
            $term = get_term(date('m'));
        }
        if (!$year)
        {
            $year = date('Y');
        }
        //invoice now 
        $i = 0;

        $fee = $this->ci->portal_m->get_fee_structure($class, $term);
        if ($fee)
        {
            $is_invoiced = $this->ci->portal_m->is_invoiced($student, $term);
            if (!$is_invoiced)
            {
                //do invoice
                $inv = $this->gen_invoice();
                $invoice = array(
                    'student_id' => $student,
                    'term' => $term,
                    'year' => $year,
                    'invoice_no' => $inv,
                    'fee_id' => $fee->id,
                    'check_st' => 1,
                    'amount' => $fee->amount,
                    'created_by' => 1,
                    'created_on' => time()
                );

                $this->ci->portal_m->invoice_me($invoice);
                $i++;
            }

            //updbal
            $this->calc_balance($student);
        }

        return $i;
    }

    /**
     * Auto Invoice Student additional extra fees
     * 
     * @param int $student
     * @return type
     */
    function invoice_admission_extras($student)
    {
        $this->ci->load->model('fee_structure/fee_structure_m');
        $term = get_term(date('m'));
        $year = date('Y');

        $autos = $this->ci->fee_structure_m->get_admission_extras($term);
        foreach ($autos as $fee)
        {
            $invoiced = $this->ci->fee_structure_m->is_invoiced($fee->id, $student, $term, $year);
            if (!$invoiced)
            {
                //do invoice
                $invoice = array(
                    'student' => $student,
                    'term' => $term,
                    'year' => $year,
                    'amount' => $fee->amount,
                    'description' => $fee->title,
                    'fee_id' => $fee->id,
                    'created_on' => time(),
                    'created_by' => 1
                );

                $this->ci->fee_structure_m->invoice_fee($invoice);
            }

            //updbal
            $this->calc_balance($student);
        }

        return count($autos) . ' Extras Invoiced';
    }

    /**
     * Calculate Student Balance after all transactions
     * Update in balances Table
     * 
     * @param int $student
     * @return boolean
     */
    function calc_balance($student)
    {
        if ($this->qb)
        {
            return $this->calc_balance_qb($student);
        }
        $payload = $this->process_statement($student);
        $ibal = $this->ci->fee_payment_m->fetch_total_arrears($student);
        ksort($payload);
        $invos = 0;
        $pays = 0;

        foreach ($payload as $syear => $p)
        {
            ksort($p);
            foreach ($p as $term => $trans)
            {
                $debit = 0;
                $credit = 0;

                foreach ($trans as $type => $paidd)
                {
                    sort_by_field($paidd, 'date');
                    foreach ($paidd as $paid)
                    {
                        $paid = (object) $paid;
                        $debit += $type == 'Debit' || $type == 'Transport' ? $paid->amount : 0;
                        $credit += $type == 'Credit' ? $paid->amount : 0;
                        $credit += $type == 'Waivers' ? $paid->amount : 0;
                         $credit += $type == 'Discount' ? $paid->amount : 0;

                        if (isset($paid->ex_type))
                        {
                            $credit += $paid->ex_type == 2 ? $paid->amount : 0;
                            $debit += $paid->ex_type == 1 ? $paid->amount : 0;
                        }
                    }
                }
                $ibal += ($debit - $credit);

                /**
                 * save term bal to db
                 */
                $ctx = $this->ci->fee_payment_m->term_bal_exists($student, $term, $syear);
                if ($ctx > 0)
                {
                    $keep_up = array(
                        'balance' => $ibal,
                        'invoice_amt' => $debit,
                        'paid' => $credit,
                        'modified_on' => now(),
                        'modified_by' => 1);
                    $this->ci->fee_payment_m->update_term_balance($student, $term, $syear, $keep_up);
                }
                else
                {
                    $keep = array(
                        'student' => $student,
                        'balance' => $ibal,
                        'invoice_amt' => $debit,
                        'term' => $term,
                        'year' => $syear,
                        'paid' => $credit,
                        'created_on' => now(),
                        'created_by' => 1);
                    $this->ci->fee_payment_m->keep_term_balance($keep);
                }
                $invos = $debit;
                $pays = $credit;
            }
        }

        //insert into new_bals if not exists otherwise update bal if record exists
        if ($this->ci->fee_payment_m->bal_exists($student))
        {
            //update
            $dbal = array('balance' => $ibal, 'invoice_amt' => $invos, 'paid' => $pays, 'modified_on' => now(), 'modified_by' => 1);
            $this->ci->fee_payment_m->update_balances($student, $dbal);
        }
        else
        {
            //insert new    
            $qbal = array('student' => $student, 'balance' => $ibal, 'invoice_amt' => $invos, 'paid' => $pays, 'created_on' => now(), 'created_by' => 1);
            $this->ci->fee_payment_m->put_balances($qbal);
        }
    }

    /**
     * Calculate Student Balance after all transactions - Quickbooks Version
     * Update in balances Table
     * 
     * @param int $student
     * @param int $course
     * @return boolean
     */
    function calc_balance_qb($student)
    {
        $payload = $this->process_statement_qb($student);
        $ibal = $this->ci->quickbooks_m->get_arrears($student);
        ksort($payload);
        $invos = 0;
        $pays = 0;

        foreach ($payload as $syear => $p)
        {
            ksort($p);
            foreach ($p as $term => $trans)
            {
                $debit = 0;
                $credit = 0;

                foreach ($trans as $type => $paidd)
                {
                    sort_by_field($paidd, 'date');
                    foreach ($paidd as $paid)
                    {
                        $paid = (object) $paid;
                        $debit += $type == 'Debit' ? $paid->amount : 0;
                        $credit += $type == 'Credit' ? $paid->amount : 0;
                        $credit += $type == 'Waivers' ? $paid->amount : 0;
                    }
                }
                $ibal += ($debit - $credit);

                /**
                 * save term bal to db
                 */
                $ctx = $this->ci->quickbooks_m->term_bal_exists($student, $term, $syear);

                if ($ctx > 0)
                {
                    $keep_up = array(
                        'balance' => $ibal,
                        'invoice_amt' => $debit,
                        'paid' => $credit,
                        'modified_on' => now(),
                        'modified_by' => 1);
                    $this->ci->quickbooks_m->update_term_balance($student, $term, $syear, $keep_up);
                }
                else
                {
                    $keep = array(
                        'student' => $student,
                        'balance' => $ibal,
                        'invoice_amt' => $debit,
                        'term' => $term,
                        'year' => $syear,
                        'paid' => $credit,
                        'created_on' => now(),
                        'created_by' => 1);

                    $this->ci->quickbooks_m->keep_term_balance($keep);
                }
                $invos = $debit;
                $pays = $credit;
            }
        }

        //insert into new_bals if not exists otherwise update bal if record exists
        if ($this->ci->quickbooks_m->bal_exists($student))
        {
            //update
            $dbal = array('balance' => $ibal, 'invoice_amt' => $invos, 'paid' => $pays, 'modified_on' => now(), 'modified_by' => 1);
            $this->ci->quickbooks_m->update_balances($student, $dbal);
        }
        else
        {
            //insert new    
            $qbal = array('student' => $student, 'balance' => $ibal, 'invoice_amt' => $invos, 'paid' => $pays, 'created_on' => now(), 'created_by' => 1);
            $this->ci->quickbooks_m->put_balances($qbal);
        }
    }

    /**
     * Process students invoices, waivers & payments - Quickbooks Version
     * 
     * @param int $student
     * @param int $course
     * @return array payload
     */
    function process_statement_qb($student)
    {
        $payload = array();
        $invoices = array();
        $paid = $this->ci->quickbooks_m->get_receipts($student);
        $debs = $this->ci->quickbooks_m->get_std_invoices($student);
        $wvs = $this->ci->fee_payment_m->get_waivers($student);
        $this->ci->load->model('invoices/invoices_m');

        foreach ($debs as $d)
        {
            $lines = $this->ci->quickbooks_m->get_invoice_items($d->id);
            $invoices[$d->id] = $lines;
        }

        foreach ($invoices as $kv => $ob)
        {
            foreach ($ob as $item)
            {
                $mt = date('m', $item->date);
                $mon = get_term($mt);
                $yr = date('Y', $item->date);
                $am = $item->quantity ? round($item->quantity * $item->rate, 2) : $item->rate;
                $payload[$yr][$mon]['Debit'][] = array('date' => $item->date, 'amount' => $am, 'desc' => $item->descrip, 'refno' => $item->invoice);
            }
        }

        foreach ($wvs as $w)
        {
            $payload[$w->year][$w->term]['Waivers'][] = array('amount' => $w->amount, 'date' => 0, 'desc' => $w->remarks, 'refno' => 0);
        }

        foreach ($paid as $p)
        {
            $mt = date('m', $p->payment_date);
            $mn = get_term($mt);
            $yr = $p->payment_date > 0 ? date('Y', $p->payment_date) : date('Y', $p->created_on);
            $payload[$yr][$mn]['Credit'][] = array('date' => $p->payment_date, 'refno' => $p->transaction_no, 'amount' => $p->amount, 'desc' => $p->description);
        }

        return $payload;
    }

    /**
     * Process Fee Status for Quickbooks Rows
     * 
     * @param type $buffers
     * @return int|string
     */
    function check_bals_qb($buffers = TRUE)
    {
        ini_set('max_execution_time', 0);
        if ($buffers)
        {
            echo $this->fetch_str();
            echo '<div id="closure" style="width:500px; margin: 100px auto; ">
                                <div id="progress"></div>
                                <div id="information"></div>
                                </div>';
        }
        $list = $this->ci->portal_m->get_all_students();

        $y = 0;
        $z = 0;

        foreach ($list as $student)
        {
            $z++;
            if ($buffers)
            {
                $mess = 'Processing ' . $this->get_student($student);
                $this->show_progress($z, count($list), $mess);
            }
            //updbal
            $this->calc_balance_qb($student);
        }

        if ($buffers)
        {
            $this->close_script();
        }
        return $y;
    }

    function clear()
    {
        return $this->ci->quickbooks_m->clear_log();
    }

    /**
     * Process student's invoices, waivers & payments
     * 
     * @param int $student
     * @return array payload
     */
    function process_statement($student)
    {
        if ($this->qb)
        {
            return $this->process_statement_qb($student);
        }
        $paid = $this->ci->fee_payment_m->get_receipts($student);
        $payload = array();
        $debs = $this->ci->fee_payment_m->get_debs_list($student);
        $wvs = $this->ci->fee_payment_m->get_waivers($student);
        $xtra = $this->ci->fee_payment_m->get_fee_extras($student);

        $transport = $this->ci->fee_payment_m->transport_invoices($student);
        $zone = $this->ci->fee_payment_m->populate('transport_routes', 'id', 'name');
        $stage = $this->ci->fee_payment_m->populate('transport_stages', 'id', 'stage_name');
        $flist = $this->ci->fee_payment_m->populate('fee_extras', 'id', 'title');

         $discs = $this->ci->fee_payment_m->get_discounts($student);

        foreach ($debs as $d)
        {
            $payload[$d->year][$d->term]['Debit'] = $this->ci->fee_payment_m->get_debits($d->student_id, $d->year, $d->term);
        }


        //automated
        $pers =  $this->ci->fee_payment_m->populate('discounts_assign', 'student', 'percentage');
        $grp =$this->ci->fee_payment_m->populate('discount_groups','id','name');
        foreach($discs as $d)
        {
            $per = isset($pers[$d->student]) ? $pers[$d->student] : 0;
            $group = isset($grp[$d->group]) ? $grp[$d->group] : 0;
            $ref = str_pad($d->id, 3, '0', 0);

            $payload[$d->year][$d->term]['Discount'][] =  ['date' => $d->created_on, 'amount' => $d->amount, 'desc' => $per.'% '.$group.' -Discount', 'refno' => 'DS-'.$ref];
        }



        foreach($transport as $l)
        {
            $zn = isset($zone[$l->route]) ? $zone[$l->route] : '';
            $stg = isset($stage[$l->stage]) ? $stage[$l->stage] : '';
            $desc = ($l->custom == 1) ? 'For '.$l->description : '';
            $way = ($l->way == 1) ? 'One Way' : 'Two Way';

            $payload[$l->year][$l->term]['Transport'][] =  ['date' => $l->created_on, 'amount' => $l->amount, 'desc' => 'Transport : '.$zn.' - '.$way.' '.$desc, 'refno' => $l->invoice_no];
        }

        foreach ($xtra as $f)
        {
            $exfee = $this->ci->fee_payment_m->get_extra($f->fee_id);
            if (isset($flist[$f->fee_id]))
            {
                $tt = ($flist[$f->fee_id] == $f->description) ? $flist[$f->fee_id] : $flist[$f->fee_id] . ' - ' . $f->description;
            }
            else
            {
                $tt = 'Undefined Extra Fee - ' . $f->fee_id;
            }

            $payload[$f->year][$f->term]['Extra'][] = array('date' => $f->created_on, 'amount' => $f->amount, 'desc' => $tt, 'refno' => '', 'ex_type' => $exfee ? $exfee->ftype : '');
        }
        foreach ($wvs as $w)
        {
            $year = $w->year;
            if (empty($w->year))
            {
                $year = date('Y', $w->created_on);
            }
            $payload[$year][$w->term]['Waivers'][] = array('amount' => $w->amount, 'date' => 0, 'desc' => $w->remarks, 'refno' => 0);
        }

        foreach ($paid as $p)
        {
            $date = $p->payment_date > 10000 ? $p->payment_date : $p->created_on;
            $mt = date('m', $date);
            if ((isset($p->year) && $p->year) && (isset($p->term) && $p->term))
            {
                $yr = $p->year;
                $term = $p->term;
            }
            else
            {
                $yr = date('Y', $date);

                $term = get_term($mt);
                if (in_array($mt, array(4, 8, 12)) && date('d', $date) > 4)
                {
                    if ($mt == 12)
                    {
                        $term = 1;
                        $yr = $yr + 1;
                    }
                    else
                    {
                        $term = $term + 1;
                    }
                }
            }

            $payload[$yr][$term]['Credit'][] = array('date' => $p->payment_date, 'refno' => $p->transaction_no, 'amount' => $p->amount, 'desc' => $p->description);
        }

        return $payload;
    }

    /**
     * Process student's invoices, waivers & payments
     * 
     * @param int $student
     * @return array payload
     */
    function float_statement($student, $term = 0, $year = 0)
    {
        $payload = array();
        $next = $this->float_invoice($student, $term, $year);
        $this->ci->load->model("sales_items/sales_items_m");
		
		$tm =$this->ci->ion_auth->settings();
			
        if (!$term)
        {
            //$current = get_term(date('m'));
			$current = $tm->term;
            $term = $current == 3 ? 1 : $current + 1;
        }
        if (!$year)
        {
            $year = date('Y');
        }
        $t_invoiced = $this->ci->portal_m->is_invoiced($student, $term, $year);
        $xtra = $this->ci->fee_payment_m->get_extras($student, $term, $year);
        $waivers = $this->ci->fee_payment_m->get_next_waivers($student, $term, $year);
        $discounts = $this->ci->fee_payment_m->get_next_discs($student, $term, $year);
        $sales = []; //$this->ci->fee_payment_m->get_sales_invoices($student, $term, $year);
         $transport = $this->ci->fee_payment_m->get_next_transport($student, $term, $year);
        $zone = $this->ci->fee_payment_m->populate('transport_routes', 'id', 'name');
        $stage = $this->ci->fee_payment_m->populate('transport_stages', 'id', 'stage_name');

        $flist = $this->ci->fee_payment_m->populate('fee_extras', 'id', 'title');
        $items = $this->ci->fee_payment_m->populate('sales_items', 'id', 'name');
        if (!empty($next))
        {
            $next = (object) $next;
            $payload[$next->year][$next->term]['Tuition'][] = array('date' => time(), 'amount' => $next->amount, 'invoiced' => $t_invoiced ? 1 : 0, 'desc' => 'Tuition Fee');
        }






        foreach($transport as $t)
        {
            $zn = isset($zone[$t->route]) ? $zone[$t->route] : '';
            $stg = isset($stage[$t->stage]) ? $stage[$t->stage] : '';
            $way = ($t->way == 1) ? 'One Way' : 'Two Way';
            $desc = ($t->custom == 1) ? 'For '.$t->description : '';
            $ttt = 'Transport : '.$zn.' - '.$way.' '.$desc;
            $payload[$t->year][$t->term]['Trans'][] = array('date' => $t->created_on, 'amount' => $t->amount, 'desc' => $ttt, 'refno' => $t->invoice_no, 'ex_type' => 'Transport' );
        }

        foreach ($xtra as $f)
        {
            $exfee = $this->ci->fee_payment_m->get_extra($f->fee_id);
            $trs = false; //$this->ci->portal_m->get_transport($student);
            if ($f->fee_id == 9000)
            {
                $tt = $trs ? "Transport: " . $trs->name : "Transport";
            }
            else
            {
                $tt = isset($flist[$f->fee_id]) ? $flist[$f->fee_id] . ' - ' . $f->description : 'Undefined Extra Fee - ' . $f->fee_id;
            }
            $payload[$f->year][$f->term]['Extra'][] = array('date' => $f->created_on, 'amount' => $f->amount, 'desc' => $tt, 'refno' => '', 'ex_type' => $exfee->ftype);
        }

        foreach ($sales as $s)
        {
            if (!isset($s->quantity) || !$s->quantity)
            {
                $row = $this->ci->sales_items_m->find($s->item_id);
                $div = $s->amount / $row->price;

                $s->quantity = $div < 1 ? ceil($s->amount / $row->price) : floor($s->amount / $row->price);
            }
            $title = isset($items[$s->item_id]) ? $items[$s->item_id] : '';

            $payload[$s->year][$s->term]['Uniform'][] = array('date' => $s->created_on, 'amount' => $s->amount, 'desc' => $s->quantity . ' - ' . $title, 'refno' => str_pad($s->id, 3, '0', 0));
        }
		
		
        foreach ($waivers as $w)
        {
            $payload[$w->year][$w->term]['Waivers'][] = array('date' => $w->date, 'amount' => $w->amount, 'desc' => empty($w->remarks) ? 'Waiver' : $w->remarks, 'refno' => '');
        }


        //automated
        $pers =  $this->ci->fee_payment_m->populate('discounts_assign', 'student', 'percentage');
        $grp =$this->ci->fee_payment_m->populate('discount_groups','id','name');
        foreach ($discounts as $d)
        {
             $per = isset($pers[$d->student]) ? $pers[$d->student] : 0;
            $group = isset($grp[$d->group]) ? $grp[$d->group] : 0;
            $ref = str_pad($d->id, 3, '0', 0);

            $payload[$d->year][$d->term]['Waivers'][] = array('date' => $d->created_on, 'amount' => $d->amount, 'desc' =>$per.'% '.$group.' -Discount', 'refno' => 'DS-'.$ref);
        }

        return $payload;
    }

    function float_statement_bk($student)
    {
        $payload = array();
        $next = $this->float_invoice($student);
		$tm =$this->ci->ion_auth->settings();
		
		
        //$current = get_term(date('m'));
        $current = $tm->term;
        $term = $current == 3 ? 1 : $current + 1;
        $year = date('Y');
        if ($term == 1)
        {
            $year = date('Y') + 1;
        }

        $xtra = $this->ci->fee_payment_m->get_extras($student, $term, $year);
        $waivers = $this->ci->fee_payment_m->get_next_waivers($student, $term, $year);

        $flist = $this->ci->fee_payment_m->populate('fee_extras', 'id', 'title');
        if (!empty($next))
        {
            $next = (object) $next;
            $payload[$next->year][$next->term]['Tuition'][] = array('date' => time(), 'amount' => $next->amount, 'desc' => 'Tuition Fee - Next Term');
        }
        foreach ($xtra as $f)
        {
            $exfee = $this->ci->fee_payment_m->get_extra($f->fee_id);
            $tt = isset($flist[$f->fee_id]) ? $flist[$f->fee_id] . ' - ' . $f->description : 'Undefined Extra Fee - ' . $f->fee_id;
            $payload[$f->year][$f->term]['Extra'][] = array('date' => $f->created_on, 'amount' => $f->amount, 'desc' => $tt, 'refno' => '', 'ex_type' => $exfee->ftype);
        }
        foreach ($waivers as $w)
        {
            $payload[$w->year][$w->term]['Waivers'][] = array('date' => $w->date, 'amount' => $w->amount, 'desc' => empty($w->remarks) ? 'Waiver' : $w->remarks, 'refno' => '');
        }

        return $payload;
    }

    /**
     * Determine Current  Student Fee Balance
     * 
     * @param int $student
     */
    function fetch_balance($student)
    {
        $row = $this->ci->fee_payment_m->get_balance($student);
        if ($row)
        {
            return $row;
        }
        else
        {
            return FALSE;
        }
    }

    function term_is_invoiced($term)
    {
        return $this->ci->portal_m->has_invoices($term);
    }

    /**
     * Void an Invoice
     * 
     * @param type $id
     * @return type
     */
    function void_invoice($id)
    {
        return $this->ci->portal_m->void_invoice($id, array('check_st' => 3, 'modified_on' => time(), 'modified_by' => 1));
    }

    /**
     * Helper Function to return Terms
     * 
     * @return type
     */
    function _terms()
    {
        return array(
            '1' => 'Term 1',
            '2' => 'Term 2',
            '3' => 'Term 3',
        );
    }

    /**
     * Process Promotion to next Class   
     * 
     * @todo Deactivate Alumni Parents
     */
    function parse_promotions()
    {
        $moved = $this->ci->portal_m->check_movement();
        if (!$moved)
        {
            $al = 0;
            $pcd = 0;
            $current = get_term(date('m'));
            $prev = $current == 1 ? 3 : $current - 1;
            if ($current == 1 && $prev == 3)
            {
                //lets move
                $pop = $this->ci->portal_m->fetch_moving_targets();
                foreach ($pop as $st => $class)
                {
                    $old = $this->ci->portal_m->fetch_class($class);
                    /** Begin Store Old Class for History Purposes ** */
                    $hiss = array(
                        'student' => $st,
                        'class' => $old->class,
                        'stream' => $old->stream,
                        'year' => date('Y') - 1,
                        'created_on' => time(),
                        'created_by' => 11111
                    );
                    $this->ci->portal_m->insert_key_data('history', $hiss);
                    // * End Store** */
                    if ($old->class == 11)
                    {
                        //make alumni --status=3
                        $admx = array('status' => 3, 'modified_on' => time());
                        $this->ci->portal_m->upd_student($st, $admx);
                        $al++;
                    }
                    else
                    {
                        $cnew = $old->class + 1;
                        $new = $this->ci->portal_m->get_class_stream($cnew, $old->stream);
                        if (isset($new->id))
                        {
                            //update adm class
                            $adm = array('class' => $new->id, 'modified_on' => time());
                            $this->ci->portal_m->upd_student($st, $adm);
                        }
                        else
                        {
                            //need to insert new row in classes & use its id as new class_id
                            $fnew = $this->ci->portal_m->make_class(array('class' => $cnew, 'stream' => $old->stream, 'status' => 1, 'created_on' => time()));
                            $admz = array('class' => $fnew, 'modified_on' => time());
                            $this->ci->portal_m->upd_student($st, $admz);
                        }
                        $pcd++;
                    }
                }
                //update Moved Status
                $log = array(
                    'term' => get_term(date('m')),
                    'year' => date('Y'),
                    'moved' => 1,
                    'created_on' => time(),
                    'created_by' => 1
                );
                $this->ci->portal_m->log_movement($log);
                //make History
            }
            if ($al || $pcd)
            {
                $this->ci->session->set_flashdata('message', array('type' => 'success', 'text' => 'Done: Made ' . $al . ' Alumni && Promoted ' . $pcd . ' Students'));
            }

            $bk = 1;
            if ($bk == 3)
            {
                echo '<pre>';
                echo 'Done: Made ' . $al . ' Alumni && Promoted ' . $pcd . ' Students';
                echo '</pre>';
            }
        }
    }

    /**
     * Replicate_extras from term 1 in term 2 & 3
     * 
     * @param bool $buffers
     * @param int $term
     * @return int
     */
    function replicate_extras($buffers = TRUE, $term = 0)
    {
        ini_set('max_execution_time', 0);
        if ($buffers)
        {
            echo $this->fetch_str();
            echo '<div id="closure" style="width:500px; margin: 100px auto; ">
                                <div id="progress"></div>
                                <div id="information"></div>
                                </div>';
        }
        $xlist = $this->ci->portal_m->populate('fee_extras', 'id', 'cycle');
        //get all active students
        $list = $this->ci->portal_m->get_all_students(1);
        $year = date('Y');

        $i = 0;
        $j = 0;
        foreach ($list as $student)
        {
            $i++;
            if ($buffers)
            {
                $tx = 'Processing ' . $i;
                $this->show_progress($i, count($list), $tx);
            }
            $extras = $this->ci->portal_m->get_term_extras($student);
            foreach ($extras as $ex)
            {
                if (isset($xlist[$ex->fee_id]) && $xlist[$ex->fee_id] == 'Once')
                {
                    continue; //Skip Fee extras payable Once
                }
                $is_invoiced = $this->ci->portal_m->is_invoiced_extras($student, $ex->fee_id, $term, $year);
                if (!$is_invoiced)
                {
                    $form = array(
                        'student' => $student,
                        'term' => $term,
                        'year' => $year,
                        'amount' => $ex->amount,
                        'description' => $ex->description,
                        'fee_id' => $ex->fee_id,
                        'created_by' => $this->ci->ion_auth->get_user()->id,
                        'created_on' => time()
                    );

                    $this->ci->portal_m->invoice_extras($form);
                    $j++;
                }
            }

            //updbal
            $this->calc_balance($student);
        }

        $this->ci->session->set_flashdata('message', array('type' => 'success', 'text' => "Generated " . $j . " Invoices"));
        if ($buffers)
        {
            $this->close_script('admin/invoices');
        }

        return $j;
    }

    /**
     * get_joint_remarks
     * 
     * @param type $term
     * @param type $year
     * @param type $student
     * @return type
     */
    function get_joint_remarks($term, $year, $student, $exams)
    {
        return $this->ci->portal_m->get_joint_remarks($term, $year, $student, $exams);
    }

    /**
     * rank_marks 
     * 
     * @param array $cat_groups
     * @param int $rank
     * @return type
     */
    function rank_marks($cat_groups, $rank)
    {
        $therest = array();
        $dropped = array();

        if ($rank == 2)
        {
            $optimal = isset($cat_groups[1]) ? array_slice($cat_groups[1], 0, 3, true) : array(); //grab 3 compulsory subjects
            $last = isset($cat_groups[1][3]) ? $cat_groups[1][3] : array(); //remove 4th compulsory if present - also assume its a science

            if (isset($cat_groups[2]))
            {
                if (!empty($last))
                {
                    $cat_groups[2][] = $last;
                    aasort($cat_groups[2], 'marks', TRUE);
                }
                $s = 0;
                foreach ($cat_groups[2] as $ct)
                {
                    $s++;
                    if ($s <= 2) //pick two sciences only
                    {
                        $optimal[] = $ct;
                    }
                    else
                    {
                        $therest[] = $ct;
                    }
                }
            }
            if (isset($cat_groups[3]))
            {
                $h = 0;
                foreach ($cat_groups[3] as $ht)
                {
                    $h++;
                    if ($h == 1) //pick one humanity only
                    {
                        $optimal[] = $ht;
                    }
                    else
                    {
                        $therest[] = $ht;
                    }
                }
            }
            if (isset($cat_groups[4]))
            {
                foreach ($cat_groups[4] as $ht)
                {
                    $therest[] = $ht;
                }
            }
            $others = aasort($therest, 'marks', TRUE);

            $j = 0;
            foreach ($others as $ot)
            {
                $j++;
                if ($j == 1)  //pick best 1 from the rest
                {
                    $optimal[] = $ot;
                }
                else
                {
                    $dropped[] = $ot['subject'];
                }
            }
        }
        else if ($rank == 3)
        {
            $optimal = isset($cat_groups[1]) ? $cat_groups[1] : array(); //grab all compulsory subjects
            //3 from all
            if (isset($cat_groups[2]))
            {
                $s = 0;
                foreach ($cat_groups[2] as $ct)
                {
                    $therest[] = $ct;
                }
            }
            if (isset($cat_groups[3]))
            {
                $s = 0;
                foreach ($cat_groups[3] as $ct)
                {
                    $therest[] = $ct;
                }
            }
            if (isset($cat_groups[4]))
            {
                foreach ($cat_groups[4] as $ht)
                {
                    $therest[] = $ht;
                }
            }
            $others = aasort($therest, 'marks', TRUE);
            $j = 0;
            foreach ($others as $ot)
            {
                $j++;
                if ($j < 4)  //pick best 3 from the rest
                {
                    $optimal[] = $ot;
                }
                else
                {
                    $dropped[] = $ot['subject'];
                }
            }
        }
        $final = array();
        $total = 0;
        foreach ($optimal as $r)
        {
            $total += $r['marks'];
            $final[] = $r['subject'];
        }

        return (object) array('optimal' => $final, 'dropped' => $dropped, 'total' => $total);
    }

    /**
     * Log a Journal Entry
     * 
     * @param float $amount
     * @param str $parent
     * @param int $ref_id
     * @param array $entries
     */
    function log_journal($amount, $parent, $ref_id, $entries, $update = FALSE)
    {
        if ($update == 999)//void
        {
            $this->ci->accounting_m->remove_journal($ref_id);
        }
        else
        {
            $by = $this->ci->ion_auth->logged_in() ? $this->ci->ion_auth->get_user()->id : 1;
            //prep the Entries
            foreach ($entries as $acc => $op)
            {
                $e = array('amount' => $amount);

                if ($update)
                {
                    $e['modified_on'] = now();
                    $e['modified_by'] = $by;
                    // $this->ci->accounting_m->update_journal($ref_id, $e);
                }
                else
                {
                    $e['account'] = $acc;
                    $e['side'] = $op;
                    $e['status'] = 1;
                    $e['parent'] = $parent;
                    $e['parent_id'] = $ref_id;
                    $e['created_on'] = now();
                    $e['created_by'] = $by;
                    //$this->ci->accounting_m->enter_journal($e);
                }
            }
        }
    }

    function scrape_expenses()
    {
        $exp = $this->ci->accounting_m->fetch_expenses();

        $ops = array(5003 => 'debit', 2001 => 'credit');
        $i = 0;
        $b = 0;
        foreach ($ops as $acc => $op)
        {
            foreach ($exp as $xp)
            {
                if ($op == 'debit')
                {
                    $b++;
                }
                else
                {
                    $i++;
                }
                $e = array('account' => $acc);
                $e['amount'] = $xp->amount;
                $e['side'] = $op;
                $e['status'] = 1;
                $e['parent'] = 'expenses';
                $e['parent_id'] = $xp->id;
                $e['created_on'] = $xp->created_on;
                $e['created_by'] = $xp->created_by;
                $this->ci->accounting_m->enter_journal($e);
            }
        }
        echo 'Debited:  ' . $b . ' & Credited: ' . $i;
    }

    /**
     * Group Accounts by Code
     *  
     * @param int $code
     * @return string
     */
    function get_account_group($code)
    {
        switch ($code)
        {
            case ($code < 400 && $code > 199):
                $title = 'Revenue';
                break;

            case ($code < 600 && $code > 399):
                $title = 'Expenses';
                break;

            case ($code < 800 && $code > 599):
                $title = 'Assets';
                break;

            case ($code < 900 && $code > 799):
                $title = 'Liabilities';
                break;

            case ($code < 1000 && $code > 899):
                $title = 'Equity';
                break;

            default:
                $title = 'Other';
                break;
        }
        return $title;
    }

    /**
     * Output current progress.
     *
     * @param $current integer Current progress out of total
     * @param $total   integer Total steps required to complete
     */
    function show_progress($current, $total, $title)
    {
        ob_start();
        $tt = round($current / $total * 100);
        echo '<script language="javascript">
                       document.getElementById("progress").innerHTML="<div style=\"width:' . $tt . '%;background-image:url(' . base_url('assets/ico/pbar-ani.gif') . ');\">&nbsp;</div>";
                       document.getElementById("information").innerHTML="' . $title . ' --- ' . $tt . '%";
                       document.title = "Please wait..' . $tt . '% ";</script>';

        $this->do_buffers();
    }

    /**
     * Show when Done Executing script
     * 
     */
    function close_script($next = '')
    {
        $redir = ' setTimeout("location.href = \"' . base_url($next) . '\";",2500); ';

        $close = '</script>';
        $str = '<script language="javascript">
          document.getElementById("information").innerHTML="------Done---------<br/>";
          document.title = "Dashboard  " ;
          var ifo = document.getElementById("information");
          ifo.parentNode.removeChild(ifo);
        
          var progr = document.getElementById("progress");
          progr.parentNode.removeChild(progr);
            
          var wrp = document.getElementById("closure");
          wrp.parentNode.removeChild(wrp);
       
        var hed = document.getElementById("h3x");
        hed.parentNode.removeChild(hed);

                     ';

        echo empty($next) ? $str . $close : $str . $redir . $close;
    }

    /**
     * Flush output buffer
     */
    function do_buffers()
    {
        echo(str_repeat(' ', 256));
        if (@ob_get_contents())
        {
            @ob_end_flush();
        }
        flush();
    }

    /**
     * HTML for the Progress Page
     * 
     * @return string
     */
    function fetch_str()
    {
        return '<style> .header {
                border-top: 1px solid #E35B59;
                border-bottom: 1px solid #943B3A;
                background: #B94A48;
                background: -moz-linear-gradient(top, #CF5351 0%, #A1403F 100%);
                 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#CF5351), color-stop(100%,#A1403F));  
                  background: -webkit-linear-gradient(top, #CF5351 0%,#A1403F 100%);  
                background: -o-linear-gradient(top, #CF5351 0%,#A1403F 100%);
                background: -ms-linear-gradient(top, #CF5351 0%,#A1403F 100%);
                 background: linear-gradient(to bottom, #CF5351 0%,#A1403F 100%);  
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#CF5351", endColorstr="#A1403F",GradientType=0 );
                -moz-box-shadmodal-footerow: inset 0 1px #E35B59, 2px 0 4px rgba(0, 0, 0, 0.1), 0px 1px 4px rgba(0, 0, 0, 0.2);
                 -webkit-box-shadow: inset 0 1px #E35B59, 2px 0 4px rgba(0, 0, 0, 0.1),0px 1px 4px rgba(0, 0, 0, 0.2);  
                  box-shadow: inset 0 1px #E35B59, 2px 0 4px rgba(0, 0, 0, 0.1), 0px 1px 4px rgba(0, 0, 0, 0.2);  
                }
                .toplogo {
                margin: 0px 0px 0px 20px;
                font-family: verdana;
                font-size: 19px;
                color: #FFF;
                padding: 7px 0px 5px 0px;
                font-weight: bold;
                text-shadow: 0 1px white;
                display: inline-block;
                line-height: 20px;
                }
                .buttons {
                float: right;
                padding: 4px 15px 0px 10px;
                }
                </style>
                <div class="header" id="h3x">
                <h2 class="toplogo"> <span style="font-size:.6em;border: 0px;
                padding: 0px;
                margin: 0px;
                text-shadow: 0px 1px 2px #333;
                padding: 5px 5px 6px 5px;
                background: transparent;
                cursor: pointer;">  Loading Smart Shule.. 	</span>
                 </h2>
                    <div class="buttons">
                        <div class="popup" id="subNavControll">
                            <div class="label"><span class="icos-list"></span></div>
                        </div>
                        <div class="dropdown">
                         </div>            
                     </div>
                 </div>';
    }

    function sms_callback()
    {
        $this->ci->load->library('Req');
        $username = $this->ci->config->item('aft_username');

        $headers = array('Content-Type' => 'application/json', 'X-App' => $username);
        //return $this->ci->req->post('https://sq.smartshule.com/api/queued', $headers, '{"queue":true }');
    }

}

/* End of file Worker.php */
/* Location: ./application/libraries/Worker.php */
