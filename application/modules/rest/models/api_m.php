<?php

class Api_m extends MY_Model
{

    /**
     * Call the Model constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Fetch a Single item by ID
     *
     * @param int $id
     * @param string $table
     */
    function find($id, $table)
    {
        $this->select_all_key($table);
        $row = $this->db->where(array('id' => $id))->get($table)->row();
        return empty($row) ? FALSE : $row;
    }

    function get_token($token)
    {
        return $this->db->where(array('access_token' => $token))->get('oauth_access_tokens')->row();
    }

    function get_passport($id)
    {
        return $this->db->where(['id' => $id])->get('passports')->row();
    }

    function get_parent_passport($id)
    {
        return $this->db->where(['id' => $id])->get('parents_passports')->row();
    }

    /**
     * get_keys
     * 
     * @return type
     */
    function get_keys()
    {
        return $this->db->get('oauth_clients')->row();
    }

    function set_keys($data)
    {
        //reset keys table
        $this->db->query('truncate oauth_clients');

        $this->db->insert('oauth_clients', $data);
        return $this->db->insert_id();
    }

    function save_rec($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function put_last($data)
    {
        return $this->insert_key_data('last_ids', $data);
    }

    /**
     * Count Active Students
     * 
     * @return type
     */
    function count_students()
    {
        return $this->db
                                            ->where($this->dx('status') . '=1', NULL, FALSE)
                                            ->count_all_results('admission');
    }

    function student_genders()
    {
        $ls = $this->db->select(' distinct ' . $this->dx('gender') . ' as gender', false)
                           ->where($this->dx('status') . '=1', NULL, FALSE)
                          ->get('admission')
                          ->result();
        $gen = [];
        foreach ($ls as $s)
        {
            $gen[$s->gender] = $this->count_genders($s->gender);
        }
        
        return $gen;
    }

    function count_genders($gd)
    {
        return $this->db->where($this->dx('gender') . "='" . $gd . "'", NULL, FALSE) ->where($this->dx('status') . '=1', NULL, FALSE)->count_all_results('admission');
    }

    function get_payments()
    {
        $scl = $this->portal_m->get_class_options();
        $strms = $this->populate('class_stream', 'id', 'name');
        $pays = $this->db->select('id,' . $this->dxa('payment_date') . ',' . $this->dxa('reg_no') . ',' . $this->dxa('amount') . ',' . $this->dxa('payment_method') . ',' . $this->dxa('description'), FALSE)
                          ->where($this->dx('status') . '= 1', NULL, FALSE)
                          ->order_by($this->dx('payment_date'), 'DESC', FALSE)
                          ->limit(30)
                          ->get('fee_payment')
                          ->result();
        foreach ($pays as $p)
        {
            $st = $this->find($p->reg_no, 'admission');
            $cc = $this->portal_m->fetch_class($st->class);
            $name = isset($scl[$cc->class]) ? $scl[$cc->class] : ' -';
            $strr = isset($strms[$cc->stream]) ? $strms[$cc->stream] : ' ';
            $p->class = $name . ' ' . $strr;
            $p->description = $p->description ? $p->description : '';
            $p->student = $st->first_name . ' ' . $st->last_name;
            $p->payment_date = $p->payment_date > 10000 ? date('d M Y', $p->payment_date) : ' - ';
        }
        return $pays;
    }

    function get_recent_students()
    {
        $scl = $this->portal_m->get_class_options();
        $strms = $this->populate('class_stream', 'id', 'name');
        $this->db->select('id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name') . ',' . $this->dxa('admission_number') . ',' . $this->dxa('admission_date') . ',' . $this->dxa('class'), FALSE);
        $this->db->where($this->dx('status') . '=1', NULL, FALSE);
        $list = $this->db->order_by('id', 'DESC')
                          ->limit(30)
                          ->get('admission')
                          ->result();
        foreach ($list as $l)
        {
            $cc = $this->portal_m->fetch_class($l->class);
            $name = isset($scl[$cc->class]) ? $scl[$cc->class] : ' -';
            $strr = isset($strms[$cc->stream]) ? $strms[$cc->stream] : ' ';
            $l->class = $name . ' ' . $strr;
            $l->admission_date = $l->admission_date > 10000 ? date('d M Y', $l->admission_date) : ' - ';
        }
        return $list;
    }

    /**
     * get_students List
     * 
     * @return type
     */
    function get_students($cursor, $limit)
    {
        if ($limit > 50)
        {
            $limit = 50;
        }
        if (!$limit || $limit < 1)
        {
            $limit = 20;
        }
        if (!$cursor)
        {
            $cursor = 0;
        }
        $scl = $this->portal_m->get_class_options();
        $strms = $this->populate('class_stream', 'id', 'name');
        $list = $this->db->select('id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name') . ',' . $this->dxa('admission_number') . ',' . $this->dxa('admission_date') . ',' . $this->dxa('class'), FALSE)
                          ->select($this->dxa('dob') . ',' . $this->dxa('gender') . ',' . $this->dxa('residence'), FALSE)
                          ->where($this->dx('status') . '=1', NULL, FALSE)
                          ->where('id >', $cursor)
                          ->limit($limit)
                          ->order_by('id', 'ASC')
                          ->get('admission')
                          ->result();

        foreach ($list as $l)
        {
            $cc = $this->portal_m->fetch_class($l->class);
            $name = isset($scl[$cc->class]) ? $scl[$cc->class] : ' -';
            $strr = isset($strms[$cc->stream]) ? $strms[$cc->stream] : ' ';
            $l->class = $name . ' ' . $strr;
            $l->admission_date = $l->admission_date > 10000 ? date('d M Y', $l->admission_date) : ' - ';
            $l->date_of_birth = $l->dob > 10000 ? date('d M Y', $l->dob) : ' - ';
            $l->gender = 2;
            unset($l->dob);
        }
        return $list;
    }

    /**
     * List Class Students with Balances
     * 
     * @param int $class
     * @return type
     */
    function list_students($class)
    {
        $rResult = $this->db->select('admission.id as id,' . $this->dxa('first_name') . '  , ' . $this->dxa('last_name') . '  , ' . $this->dxa('class') . '  , ' . $this->dxa('old_adm_no') . ' ,' . $this->dxa('admission_number'), FALSE)
                          ->select($this->dx('new_balances.balance') . ' as balance, ' . $this->dx('new_balances.invoice_amt') . ' as invoice_amt,' . $this->dx('new_balances.paid') . ' as paid', FALSE)
                          ->join('new_balances', 'admission.id= ' . $this->dx('student'))
                          ->order_by('balance', 'desc')
                          ->where($this->dx('admission.class') . ' =' . $class, NULL, FALSE)
                          ->where($this->dx('admission.status') . ' = 1', NULL, FALSE)
                          ->get('admission')
                          ->result();

        $output = array();

        foreach ($rResult as $iCol)
        {
            $adm = empty($iCol->old_adm_no) ? $iCol->admission_number : $iCol->old_adm_no;

            $output[] = array(
                'id' => $iCol->id,
                'name' => $iCol->first_name . ' ' . $iCol->last_name,
                'reg_no' => $adm,
                'invoiced' => $iCol->invoice_amt,
                'paid' => $iCol->paid,
                'balance' => $iCol->balance
            );
        }

        return $output;
    }

    function fetch_class($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    /**
     * Fetch Classes
     * 
     * @return type
     */
    function get_class_options()
    {
        $list = $this->db->select('id, name')
                          ->where('status', 1)
                          ->order_by('id')
                          ->get('class_groups')
                          ->result();
        $cls = array();
        foreach ($list as $l)
        {
            $cls[$l->id] = $l->name;
        }
        return $cls;
    }

    function fetch_balance($id)
    {
        $this->select_all_key('new_balances');
        $ret = $this->db->where($this->dx('student') . ' =' . $id, NULL, FALSE)
                                            ->get('new_balances')->row();

        return $ret;
    }

    /**
     * total sales for the term
     * 
     * @return type
     */
    function sum_sales()
    {
        return $this->db->select('sum(total) as total')
                                            ->where_in("DATE_FORMAT(FROM_UNIXTIME(created_on),'%m-%Y')", gen_terms())
                                            ->get('sales_receipts')
                                            ->row()->total;
    }

    /**
     * Low Stock Sales Items
     * 
     * @param type $qty
     * @return type
     */
    function get_low_stock_sales($qty)
    {
        return $this->db->select('item_name, quantity')
                                            ->where("quantity <=", $qty)
                                            ->join('sales_items', 'item_id=sales_items.id')
                                            ->order_by('quantity', 'DESC')
                                            ->get('sales_items_stock')
                                            ->result();
    }

    /**
     * Low Stock Sales Items
     * 
     * @param type $qty
     * @return type
     */
    function get_low_stock_inventory($qty)
    {
        return $this->db->select('item_name, qty')
                                            ->where("qty <=", $qty)
                                            ->join('items', 'item_id=items.id')
                                            ->order_by('qty', 'DESC')
                                            ->get('stocks')
                                            ->result();
    }

    /**
     * Get Invoices paginated by cursor
     * 
     * @todo Set term for invoices also include year
     * @param type $cursor
     * @param int $limit
     * @param int $term
     * @param int $year
     * @return type
     */
    function get_tuition_invoices($cursor, $limit, $term, $year)
    {
        if ($limit > 50)
        {
            $limit = 50;
        }
        if (!$limit || $limit < 1)
        {
            $limit = 20;
        }
        if (!$cursor)
        {
            $cursor = 0;
        }
        return $this->db->select("id,invoice_no, student_id as student,term, year, amount")
                                            ->select(" FROM_UNIXTIME(created_on, ' %d %M %Y') as invoice_date", FALSE)
                                            ->where('check_st', 1)
                                            ->where('term', $term)
                                            ->where('year', $year)
                                            ->where('id >', $cursor)
                                            ->order_by('id', 'ASC')
                                            ->limit($limit)
                                            ->get('invoices')
                                            ->result();
    }

    /**
     * Get Invoices paginated by cursor
     * 
     * @todo Set term for invoices also include year
     * @param type $cursor
     * @param int $limit
     * @param int $term
     * @param int $year
     * @return type
     */
    function get_extras_invoices($cursor, $limit, $term, $year)
    {
        if ($limit > 50)
        {
            $limit = 50;
        }
        if (!$limit || $limit < 1)
        {
            $limit = 20;
        }
        if (!$cursor)
        {
            $cursor = 0;
        }
        $result = $this->db->select('fee_extra_specs.id as id,' . $this->dxa('student') . '  , ' . $this->dxa('term') . '  , ' . $this->dxa('year') . '  , ' . $this->dx('fee_extra_specs.amount') . ' as amount ,' . $this->dx('fee_extra_specs.description') . ' as description', FALSE)
                          ->select(' title ')
                          ->select(" FROM_UNIXTIME(" . $this->dx('fee_extra_specs.created_on') . " , ' %d %M %Y') as invoice_date", FALSE)
                          ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                          ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                          ->join('fee_extras', $this->dx('fee_id') . ' =fee_extras.id ')
                          ->where('fee_extra_specs.id >', $cursor)
                          ->order_by('fee_extra_specs.id', 'ASC')
                          ->limit($limit)
                          ->get('fee_extra_specs')
                          ->result();
        foreach ($result as $r)
        {
            $suff = empty($r->description) ? '' : ' - ' . $r->description;
            $r->description = $r->title . $suff;
            unset($r->title);
        }
        return $result;
    }

    /**
     * get_recent_sales
     * 
     * @return type
     */
    function get_recent_sales()
    {
        $ids = array();
        $sales = array();
        $last = $this->db
                          ->order_by('id', 'DESC')
                          ->limit(30)
                          ->get('sales_receipts')
                          ->result();
        $items = $this->populate('sales_items', 'id', 'item_name');

        foreach ($last as $l)
        {
            $std = $this->worker->get_student($l->student);
            $l->student = $std->first_name . ' ' . $std->last_name;
            $l->items = $this->get_sale_items($l->id);
            foreach ($l->items as $ii)
            {
                $ii->item = isset($items[$ii->item_id]) ? $items[$ii->item_id] : '-';
            }

            $ids[] = $l->id;
            $sales[] = $l;
        }

        return $sales;
    }

    /**
     *   get_all_payments paginated by cursor
     * 
     * @todo Set term for invoices also include year
     * @param type $cursor
     * @param int $limit
     * @param int $term
     * @param int $year
     * @return type
     */
    function get_all_payments($cursor, $limit)
    {
        if ($limit > 50)
        {
            $limit = 50;
        }
        if (!$limit || $limit < 1)
        {
            $limit = 20;
        }
        if (!$cursor)
        {
            $cursor = 0;
        }
        $query = "
                    SELECT p1.id, p1.student,FROM_UNIXTIME(created_on, ' %d %M %Y') as created_on,
                               (SELECT COUNT(*) 
                                    FROM fee_payment p2 
                                    WHERE " . $this->dx('p2.receipt_id') . " = p1.id AND " . $this->dx('status') . "=1 ) as items
                    FROM fee_receipt p1
                    HAVING items>0 AND   p1.id >" . $cursor . " ORDER BY id ASC" . ' limit ' . $limit;

        $receipts = $this->db->query($query)->result();

        $items = $this->populate('fee_extras', 'id', 'title');
        foreach ($receipts as $r)
        {
            $r->items = $this->get_rct_items($r->id, $items);
        }

        return $receipts;
    }

    function get_sale_items($receipt)
    {
        return $this->db->where("receipt_id", $receipt)
                                            ->get('record_sales')
                                            ->result();
    }

    /**
     * Receipt line items
     * 
     * @param type $id
     * @param type $extras titles for fee
     * @return type
     */
    function get_rct_items($id, $extras)
    {
        $items = $this->db->select('id,' . $this->dxa('payment_date') . '  , ' . $this->dxa('amount') . '  , ' . $this->dxa('transaction_no') . '  , ' . $this->dxa('payment_method') . ' ,' . $this->dxa('description'), FALSE)
                          ->where($this->dx('receipt_id') . '=' . $id, NULL, FALSE)
                          ->where($this->dx('status') . '=' . 1, NULL, FALSE)
                          ->get('fee_payment')
                          ->result();

        foreach ($items as $t)
        {
            $t->description = isset($extras[$t->description]) ? $extras[$t->description] : 'Fee Payment';
            $t->payment_date = $t->payment_date > 10000 ? date('d M Y', $t->payment_date) : ' - ';
            unset($t->id);
        }
        return $items;
    }

    /**
     * count_items
     * 
     * @return type
     */
    function count_items()
    {
        return $this->db->count_all_results('sales_items');
    }

    /**
     * Fetch Admission Row
     * 
     * @param int $id
     * @return object
     */
    function find_student($id, $qb = FALSE)
    {
        $this->select_all_key('admission');
        if ($qb)
        {
            return $this->db->where($this->dx('list_id') . " ='" . $id . "'", NULL, FALSE)->get('admission')->row();
        }
        return $this->db->where(array('id' => $id))->get('admission')->row();
    }

    function populate($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    /**
     * Fetch Class by class_id & Stream 
     * 
     * @param type $class
     * @param type $stream
     * @return type
     */
    function get_class_stream($class, $stream)
    {
        return $this->db->where(array('class' => $class, 'stream' => $stream))->get('classes')->row();
    }

    /**
     * Fetch Fee Status 
     * 
     * @param int $class
     * @param int $stream
     * @return type
     */
    function list_fee_status($class, $stream)
    {
        $row = $this->get_class_stream($class, $stream);
        if (empty($row))
        {
            return array();
        }

        $result = $this->db->select('admission.id,' . $this->dxa('class') . ',' . $this->dx('new_balances.balance') . ' as balance, ' . $this->dx('new_balances.invoice_amt') . ' as invoice_amt,' . $this->dx('new_balances.paid') . ' as paid', FALSE)
                          ->select(',' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
                          ->join('new_balances', 'admission.id= ' . $this->dx('student'))
                          ->where($this->dx('admission.class') . ' = ' . $row->id, NULL, FALSE)
                          ->where($this->dx('admission.status') . ' = 1', NULL, FALSE)
                          ->where($this->dx('balance') . ' > 0 ', NULL, FALSE)
                          ->order_by($this->dx('admission.first_name'), 'ASC', FALSE)
                          ->order_by($this->dx('admission.last_name'), 'ASC', FALSE)
                          ->get('admission')
                          ->result();

        $bal = 0;
        $paid = 0;
        $inv = 0;

        $scl = $this->portal_m->get_class_options();
        $strms = $this->populate('class_stream', 'id', 'name');
        $name = isset($scl[$class]) ? $scl[$class] : ' -';
        $strr = isset($strms[$stream]) ? $strms[$stream] : ' ';
        $title = $name . ' ' . $strr;

        foreach ($result as $sd)
        {
            $bal += $sd->balance > 0 ? $sd->balance : 0;
            $paid += $sd->paid;
            $inv += $sd->invoice_amt;
        }

        return array(
            'class' => $title,
            'balance' => $bal,
            'paid' => $paid,
            'invoiced' => $inv,
            'students' => $result,
        );
    }

    /**
     * Fee Summary 
     * 
     */
    function fetch_fee_summary()
    {
        $this->db->select('admission.id,' . $this->dxa('class') . ',' . $this->dx('new_balances.balance') . ' as balance, ' . $this->dx('new_balances.invoice_amt') . ' as invoice_amt,' . $this->dx('new_balances.paid') . ' as paid', FALSE);
        $this->db->join('new_balances', 'admission.id= ' . $this->dx('student'));

        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);

        $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
        $this->db->order_by($this->dx('admission.last_name'), 'ASC', FALSE);

        $result = $this->db->get('admission')->result();

        $fbal = array();

        foreach ($result as $sd)
        {
            $st = $this->fetch_class($sd->class);
            if (!$st)
            {
                $st = new stdClass();
                $st->class = 'Other';
                $st->stream = 'Other';
            }
            $fbal[$st->class][$st->stream][] = $sd;
        }
        ksort($fbal);

        $i = 0;
        $s = 0;
        $tbal = 0;
        $fpaid = 0;
        $due = 0;
        $summary = [];
        $streams = $this->populate('class_stream', 'id', 'name');
        $per_class = [];
        foreach ($fbal as $kl => $strpecs)
        {
            $cname = isset($this->classes[$kl]) ? $this->classes[$kl] : ' ';
            foreach ($strpecs as $str => $kids)
            {
                $ivs = 0;
                $pds = 0;
                $bal = 0;
                $kstr = isset($streams[$str]) ? $streams[$str] : ' &nbsp;';
                foreach ($kids as $kid)
                {
                    $i++;
                    $s++;
                    $ivs += $kid->invoice_amt;
                    $pds += $kid->paid;
                    $bal += $kid->balance > 0 ? $kid->balance : 0;
                }
                $per_class[] = ['name' => $cname . ' ' . $kstr, 'invoiced' => $ivs, 'paid' => $pds, 'balance' => $bal, 'class' => $kl, 'stream' => $str];

                $tbal += $bal;
                $fpaid += $pds;
                $due += $ivs;
            }
        }
        $summary['classes'] = $per_class;
        $summary['totals'] = ['invoiced' => $due, 'paid' => $fpaid, 'balance' => $tbal];

        return $summary;
    }

    /**
     * Fetch overall Fee Status 
     * 
     * @return type
     */
    function list_bal_status()
    {
        $result = $this->db->select('admission.id,' . $this->dx('admission.class') . ' as class,' . $this->dx('new_balances.balance') . ' as balance, ' . $this->dx('new_balances.invoice_amt') . ' as invoice_amt,' . $this->dx('new_balances.paid') . ' as paid', FALSE)
                          ->select(',' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
                          ->select(', classes.class  as cc, stream ')
                          ->join('new_balances', 'admission.id= ' . $this->dx('student'))
                          ->join('classes', 'classes.id= ' . $this->dx('admission.class'))
                          ->where($this->dx('admission.status') . ' = 1', NULL, FALSE)
                          ->where($this->dx('balance') . ' > 0 ', NULL, FALSE)
                          ->order_by($this->dx('admission.first_name'), 'ASC', FALSE)
                          ->order_by($this->dx('admission.last_name'), 'ASC', FALSE)
                          ->get('admission')
                          ->result();

        $bal = 0;
        $paid = 0;
        $inv = 0;

        $scl = $this->portal_m->get_class_options();
        $strms = $this->populate('class_stream', 'id', 'name');

        $fn = [];
        $last = [];
        foreach ($result as $sd)
        {
            $bal += $sd->balance > 0 ? $sd->balance : 0;
            $paid += $sd->paid;
            $inv += $sd->invoice_amt;
            $fn[$sd->cc][$sd->stream][] = $sd;
        }
        ksort($fn);
        foreach ($fn as $cl => $streams)
        {
            foreach ($streams as $sl => $students)
            {
                $name = isset($scl[$cl]) ? $scl[$cl] : ' -';
                $strr = isset($strms[$sl]) ? $strms[$sl] : ' ';
                $title = $name . ' ' . $strr;
                $last[$title] = $students;
            }
        }
        return array(
            'balance' => $bal,
            'paid' => $paid,
            'invoiced' => $inv,
            'students' => $last,
        );
    }

    /**
     * Fetch current waivers 
     * 
     * @param int $term 
     * @param int $year 
     * @return type
     */
    function get_waivers($term, $year)
    {
        $result = $this->db->select($this->dx('admission.class') . ' as class,' . $this->dxa('first_name') . ' , ' . $this->dxa('last_name'), FALSE)
                          ->select('fee_waivers.* ')
                          ->select(', classes.class  as cc, stream ')
                          ->join('admission', 'admission.id= student')
                          ->join('classes', 'classes.id= ' . $this->dx('admission.class'))
                          ->where('fee_waivers.term', $term)
                          ->where('fee_waivers.year', $year)
                          ->where('fee_waivers.status', 1)
                          ->order_by($this->dx('admission.class'), 'ASC', FALSE)
                          ->get('fee_waivers')
                          ->result();

        $waiv = 0;

        $scl = $this->portal_m->get_class_options();
        $strms = $this->populate('class_stream', 'id', 'name');

        $fn = [];
        $last = [];
        foreach ($result as $sd)
        {
            $waiv += $sd->amount;
            $fn[$sd->cc][$sd->stream][] = $sd;
        }
        ksort($fn);
        foreach ($fn as $cl => $streams)
        {
            foreach ($streams as $sl => $students)
            {
                $name = isset($scl[$cl]) ? $scl[$cl] : ' -';
                $strr = isset($strms[$sl]) ? $strms[$sl] : ' ';
                $title = $name . ' ' . $strr;
                $last[$title] = $students;
            }
        }

        return array(
            'total' => $waiv,
            'students' => $last,
        );
    }

    function get_stock()
    {
        return $this->db->order_by('id', 'asc')->get('sales_items')->result();
    }

    function filter_stock($month)
    {
        $result = $this->db
                          ->where('MONTH(FROM_UNIXTIME(stock_date)) = ' . $month, NULL, FALSE)
                          ->where('YEAR(FROM_UNIXTIME(stock_date)) = ' . date('Y'), NULL, FALSE)
                          ->order_by('stock_date', 'asc')
                          ->get('sales_stock')
                          ->result();

        $list = [];
        $items = $this->populate('sales_items', 'id', 'name');

        foreach ($result as $r)
        {
            if ($r->quantity < 1)
            {
                continue;
            }
            $user = $this->ion_auth->get_user($r->created_by);
            $name = isset($items[$r->item_id]) ? $items[$r->item_id] : '-';
            $list[] = (object) ['id' => $r->id, 'date' => date('d M Y', $r->stock_date), 'name' => $name, 'qty' => $r->quantity, 'staff' => $user->first_name . ' ' . $user->last_name];
        }

        return $list;
    }

    function find_banks()
    {
        return $this->db->get('bank_accounts')->result();
    }

    function update_k_data($table, $id, $data)
    {
        $res = $this->update_key_data($id, $table, $data);
        return $res;
    }

    function get_events()
    {
        return $this->db->order_by('id', 'DESC')->get('events')->result();
    }

    function getex_activities($student)
    {
        $this->select_all_key('extras');
        return $this->db->select('activities.name as activity_name')->where($this->dx('student') . "='" . $student . "'", NULL, false)->join('activities', 'activities.id=' . $this->dx('extras.activity'))->order_by('extras.id', 'DESC')->get('extras')->result();
    }

    function get_diary($id, $page, $limit = 10, $from = '', $to = '')
    {
        $offset = $limit * ( $page - 1);

        $this->db->where('student', $id);
        if ($from)
        {
            $this->db->where('date_ >=', $from, FALSE);
        }
        if ($to)
        {
            $this->db->where('date_ <=', $to, FALSE);
        }
        $tempdb = clone $this->db;
        $count = $tempdb->from('diary')->count_all_results();
        $result = $this->db->order_by('id', 'desc')->get('diary', $limit, $offset)->result();

        foreach ($result as $row)
        {
            $row->uploads = $this->get_uploads($row->id, 1);
        }

        return (object) ['result' => $result, 'meta' => ['count' => $count, 'pages' => ceil($count / $limit)]];
    }

    function diary_exists($id, $t = 1)
    {
        $table = $t == 1 ? 'diary' : 'diary_extra';
        return $this->db->where('id', $id)->count_all_results($table) > 0;
    }

    function get_diary_extra($id, $page, $limit = 10, $from = '', $to = '')
    {
        $offset = $limit * ( $page - 1);

        $this->db->where('student', $id);
        if ($from)
        {
            $this->db->where('date_ >=', $from, FALSE);
        }
        if ($to)
        {
            $this->db->where('date_ <=', $to, FALSE);
        }
        $tempdb = clone $this->db;
        $count = $tempdb->from('diary_extra')->count_all_results();
        $result = $this->db->order_by('id', 'desc')->get('diary_extra', $limit, $offset)->result();

        foreach ($result as $row)
        {
            $row->uploads = $this->get_uploads($row->id, 2);
        }

        return (object) ['result' => $result, 'meta' => ['count' => $count, 'pages' => ceil($count / $limit)]];
    }

    function post_comment($id, $user, $comment, $t = 1)
    {
        $row = $this->db->where(['diary' => $id, 'parent' => $user, 'cat' => $t])->get('diary_comments')->row();
        if ($row)
        {
            $this->update_k_data('diary_comments', $id, ['comment' => $comment, 'modified_on' => time()]);
        }
        else
        {
            $this->save_rec('diary_comments', ['diary' => $id, 'parent' => $user, 'cat' => $t, 'status' => 1, 'comment' => $comment, 'created_on' => time()]);
        }
        return true;
    }

    function get_comment($id, $user=0, $t = 1)
    {
        return $this->db->where(['diary' => $id,  'cat' => $t])->get('diary_comments')->row();
    }

    function get_messages($id, $page, $limit = 10)
    {
        $this->load->library('Fone');

        $this->select_all_key('parents');
        $parent = $this->db->where($this->dx('user_id') . '=' . $id, NULL, FALSE)->get('parents')->row();

        if (empty($parent->phone))
        {
            return (object) ['result' => [], 'meta' => ['count' => 0, 'pages' => 0]];
        }
        $util = \libphonenumber\PhoneNumberUtil::getInstance();
        $no = $util->parse($parent->phone, 'KE', null, true);

        $is_valid = $util->isValidNumber($no);
        if ($is_valid != 1)
        {
            return (object) ['result' => [], 'meta' => ['count' => 0, 'pages' => 0]];
        }

        $code = $no->getcountryCode();
        $nat = $no->getNationalNumber();
        $phone = $code . $nat;

        $offset = $limit * ( $page - 1);

        $this->select_all_key('text_log');
        $this->db->where($this->dx('dest') . '=' . $this->db->escape($phone), null, false);

        $tempdb = clone $this->db;
        $count = $tempdb->from('text_log')->count_all_results();
        $result = $this->db->order_by('id', 'desc')->get('text_log', $limit, $offset)->result();

        return (object) ['result' => $result, 'meta' => ['count' => $count, 'pages' => ceil($count / $limit)]];
    }

    function get_uploads($id, $cat)
    {
        $images = [];

        $res = $this->db->select('id,' . $this->dxa('filename') . ',' . $this->dxa('path'), false)
                          ->where($this->dx('diary_id') . ' = ' . $id, NULL, FALSE)
                          ->where($this->dx('cat') . ' = ' . $cat, NULL, FALSE)
                          ->get('diary_uploads')
                          ->result();
        foreach ($res as $r)
        {
            $images[] = [
                'id' => $r->id,
                'url' => base_url('uploads/diary/' . $r->path . $r->filename)
            ];
        }
        return $images;
    }

    function get_ftt($term, $year)
    {
        return $this->db->where('term', $term)
                                            ->where('year', $year)
                                            ->get('food_tt')
                                            ->result();
    }

}
