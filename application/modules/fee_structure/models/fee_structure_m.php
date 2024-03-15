<?php

class Fee_structure_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function add_fee_class($data)
    {
        $this->db->insert('fee_class', $data);
        return $this->db->insert_id();
    }

    //Get Single Student
    function get_student($id)
    {
        $this->select_all_key('admission');
        return $this->db->where(array('id' => $id))->get('admission')->row();
    }

    /**
     * Update Fee Structure
     * 
     * @param type $id
     * @param type $data
     */
    function update_fee($id, $data)
    {
        return $this->db->where('id', $id)->update('fee_class', $data);
    }

    function suspend_invoice($id, $data)
    {
        return $this->db->where('id', $id)->update('invoices', $data);
    }

    /**
     * Fees For Each Term
     * 
     * @param array $data
     * @return boolean Success
     */
    function add_fee_term($data)
    {
        $this->db->insert('fee_term', $data);
        return $this->db->insert_id();
    }

    function save_class_fee($data)
    {
        $this->db->insert('fee_class', $data);
        return $this->db->insert_id();
    }

    function create_rec($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function move_fee()
    {
        $fcc = $this->db->order_by('id', 'ASC')->get('fee_class')->result();

        foreach ($fcc as $f)
        {
            $amount = $this->get_fee_amount($f->fee_id);
            $fw = array(
                'amount' => $amount,
                'modified_by' => $this->user->id,
                'modified_on' => time(),
            );
            $this->update_fee($f->id, $fw);
        }
    }

    /**
     * Fetch Amount
     * 
     * @param type $feeid
     * @return type
     */
    function get_fee_amount($feeid)
    {
        $spec = $this->db->where('fee_id', $feeid)->get('fee_specs')->row();
        return empty($spec) ? 0 : $spec->amount;
    }

    //Get Classes
    public function get_classes($fee)
    {
        $results = $this->db->select('class_id, term')
                          ->where('fee_id', $fee)
                          ->get('fee_class')
                          ->result();

        $frr = array();
        foreach ($results as $res)
        {
            $frr[$res->class_id][] = $res->term;
        }
        $fstr = array();
        foreach ($frr as $clas => $fspe)
        {
            $str = '';
            foreach ($fspe as $tm)
            {
                $str .= $tm . ', ';
            }
            $fstr[$clas] = rtrim(' Term ' . $str, ', ');
        }
        return $fstr;
    }

    /**
     * Fetch Fee Extras all (Waivers & Charges) for Student
     * 
     * @param type $student
     * @return type
     */
    function get_fee_extras($student, $fee = 0, $term = 0, $year = 0)
    {
        $this->select_all_key('fee_extra_specs');
        if ($fee)
        {
            $this->db->where($this->dx('fee_id') . '=' . $fee, NULL, FALSE);
        }
        if ($term)
        {
            $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE);
        }
        if ($year)
        {
            $this->db->where($this->dx('year') . '=' . $year, NULL, FALSE);
        }
        return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            ->get('fee_extra_specs')
                                            ->result();
    }

    /**
     * Datatable Server Side Data Fetcher
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function list_fee_extras($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('admission');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        // Ordering
        if (isset($iSortCol_0))
        {
            for ($i = 0; $i < intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true')
                {
                    $this->db->_protect_identifiers = FALSE;
                    $this->db->order_by($this->dx('admission.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
                    $this->db->_protect_identifiers = TRUE;
                }
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch))
        {
            $orstr = '';
            $or = ' OR ';
            $yx = 0;
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $prefx = $yx ? $or : '';
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $orstr .= $prefx . 'CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
                    $yx++;
                }
            }

            $outer_or = $or . 'CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
            $outer_or .= $or . 'CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.middle_name') . ')' . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
            $outer_or .= $or . 'CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.middle_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
            $this->db->where(" (" . $orstr . $outer_or . ")", NULL, FALSE);
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('admission');
        $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
        //$this->db->order_by('admission.id', 'desc');
        if ($this->session->userdata('pop'))
        {
            $pop = $this->session->userdata('pop');
            $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
        }
        else if ($this->session->userdata('pw'))
        {
            $pop = $this->session->userdata('pw');
            $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
        }
        else
        {
            //  
        }
        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
        $rResult = $this->db->get('admission');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;



        // Total data set length
        if ($this->session->userdata('pop'))
        {
            $pop = $this->session->userdata('pop');
            $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
        }
        $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all_results('admission');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        $aaData = array();
        $obData = array();
        foreach ($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach ($aRow as $Key => $Value)
            {
                if ($Key && $Key !== ' ')
                {

                    $row[$Key] = $Value;
                }
            }
            $obData[] = $row;
        }

        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;

            $adm = '';
            if (!empty($iCol->old_adm_no))
            {
                $adm = $iCol->old_adm_no;
            }
            else
            {
                $adm = $iCol->admission_number;
            }
            $crow = $this->portal_m->fetch_class($iCol->class);
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
            $aaData[] = array(
                $iCol->id,
                ucwords($iCol->first_name) . ' ' . ucwords($iCol->middle_name) .' '. ucwords($iCol->last_name) ,
                $sft . ' ' . $st,
                $adm,
                ''
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function banks()
    {
        return $this->db->get('bank_accounts')->result();
    }

    /**
     * Fetch Student Balalnce
     * 
     * @param type $id
     * @return type
     */
    function fetch_balance($id)
    {
        $this->select_all_key('new_balances');
        return $this->db->where($this->dx('student') . ' =' . $id, NULL, FALSE)
                                            ->get('new_balances')->row();
    }

    /**
     * Get Parent For this Student
     * 
     * @param type $id
     * @return type
     */
    function fetch_parent($id)
    {
        $this->select_all_key('admission');
        $row = $this->db->where(array('id' => $id))->get('admission')->row();
        if (!$row)
        {
            return FALSE;
        }
        $this->select_all_key('parents');
        return $this->db->where(array('id' => $row->parent_id))->get('parents')->row();
    }

    /**
     * Fetch All Extras
     * 
     */
    function fetch_extras()
    {
        return $this->db->get('fee_extras')->result();
    }

    /**
     * Trips Invoices
     * 
     * @param type $data
     * @return type
     */
    function invoice_trips($data)
    {
        return $this->insert_key_data('fee_trips', $data);
    }

    /**
     * Check if Student has been invoiced for this Period
     * 
     * @param type $fee
     * @param type $student
     * @param type $term
     * @param type $year
     */
    function is_invoiced($fee, $student, $term, $year)
    {
        $row = $this->db
                                            ->where($this->dx('fee_id') . '=' . $fee, NULL, FALSE)
                                            ->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                                            ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                                            ->get('fee_extra_specs')->row();
        if (empty($row))
        {
            return FALSE;
        }
        else
        {
            return $row->id;
        }
    }

    /**
     * Insert Extra-Fee invoices
     * 
     * @param array $data
     * @param int $has_id
     * @param int $dem on demand flag
     * @return boolean success
     */
    function invoice_fee($data, $has_id = 0, $dem = 0)
    {
        if ($has_id && !$dem)
        {
            //update
            return $this->update_key_data($has_id, 'fee_extra_specs', $data);
        }
        else
        {
            return $this->insert_key_data('fee_extra_specs', $data);
        }
    }

    /**
     * Fetch Default Amount
     * 
     * @param int $id
     * @return object
     */
    function get_extra($id)
    {
        return $this->db->where(['id' => $id])->get('fee_extras')->row();
    }

    function feest_exists($class, $term)
    {
        return $this->db->where(array('class_id' => $class, 'term' => $term))->count_all_results('fee_class') > 0;
    }

    function iv_exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('invoices') > 0;
    }

    /**
     * Fetch Current Students in Specified Class
     * 
     * @param type $class
     * @return type
     */
    function fetch_students($class)
    {
        $list = $this->db->select('id')
                          ->where($this->dx('class') . '=' . $class, NULL, FALSE)
                          ->get('admission')
                          ->result();
        $students = array();
        foreach ($list as $l)
        {
            $students[] = $l->id;
        }
        return $students;
    }

    function get_invoices($list)
    {
        if (empty($list))
        {
            return array();
        }

        $debs = $this->db->where_in('student_id', $list)
                          ->where('check_st !=', 3)
                          ->order_by('id', 'DESC')
                          ->get('invoices')
                          ->result();
        foreach ($debs as $d)
        {
            $rw = $this->worker->get_student($d->student_id);
            $d->student = $rw->first_name . ' ' . $rw->last_name;
        }

        return $debs;
    }

    function get_uniform($list)
    {
        if (empty($list))
        {
            return array();
        }
        $this->select_all_key('sales_invoices');
        $debs = $this->db->where($this->dx('student') . ' IN ( ' . implode(',', $list) . ')', NULL, FALSE)
                          ->where($this->dx('status') . '=1', NULL, FALSE)
                          ->order_by('id', 'DESC')
                          ->get('sales_invoices')
                          ->result();
        foreach ($debs as $d)
        {
            $rw = $this->worker->get_student($d->student);
            $d->student = $rw->first_name . ' ' . $rw->last_name;
        }

        return $debs;
    }

    function fetch_full_students($class)
    {
        $list = $this->db->select('id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
                          ->where($this->dx('class') . '=' . $class, NULL, FALSE)
                          ->where($this->dx('status') . '=1', NULL, FALSE)
                          ->get('admission')
                          ->result();
        $fnlist = array();
        foreach ($list as $l)
        {
            $fnlist[] = array('id' => (int) $l->id, 'text' => $l->first_name . ' ' . $l->last_name);
        }
        return $fnlist;
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

    function find_invoice($id)
    {
        return $this->db->where(array('id' => $id))->get('invoices')->row();
    }

    function update_extras($id, $data)
    {
        return $this->update_key_data($id, 'fee_extra_specs', $data);
    }

    function update_invoice($id, $data)
    {
        return $this->db->where('id', $id)->update('invoices', $data);
    }

    function remove_extras($id)
    {
        return $this->db->delete('fee_extra_specs', array('id' => $id));
    }

    /**
     * Fetch List of fee Structures
     * 
     * @return array
     */
    function get_list()
    {
        $feest = $this->db->get('fee_class')->result();
        $fst = array();
        foreach ($feest as $f)
        {
            $fst[$f->class_id][$f->term] = array('amount' => $f->amount, 'id' => $f->id);
        }
        return $fst;
    }

    /**
     * 
     * @return type
     */
    function get_admission_extras()
    {
        return $this->db->where('auto', 1)->get('fee_extras')->result();
    }

    function find_sales_invoice($id)
    {
        $this->select_all_key('sales_invoices');
        return $this->db->where(array('id' => $id))->get('sales_invoices')->row();
    }

    function remove_sales_invoice($id)
    {
        return $this->db->delete('sales_invoices', array('id' => $id));
    }

    function fetch_item($id)
    {
        return $row = $this->db->where('id', $id)->get('sales_items')->row();
    }

    function update_stock($id, $qty, $student, $src = '')
    {
        $row = $this->db->where('id', $id)->get('sales_items')->row();

        $new = ($row->stock + $qty);

        $this->db->where('id', $id)->update('sales_items', ['stock' => $new, 'modified_on' => time()]);
        $form = [
            'item_id' => $id,
            'current_qty' => $row->stock,
            'sold_qty' => $qty,
            'new_qty' => $new,
            'student' => $student,
            'source' => $src . ' -VOID',
            'created_on' => time(),
            'created_by' => $this->user->id,
        ];
        return $this->create_rec('sales_stock_log', $form);
    }

    function get_series()
    {
        $count = $this->db->count_all_results('fee_extra_specs');
        if (!$count)
        {
            $series = 1;

            return (10000 + $series);
        }

        $row_max = $this->db->select('id,' . $this->dxa('invoice_no') . ',' . $this->dxa('student'), FALSE)
                          ->order_by('id', 'DESC')
                          ->limit(1)
                          ->get('fee_extra_specs')
                          ->row();

        if (empty($row_max->invoice_no))
        {
            return 10000 + ($row_max->id + 1);
        }

        return ((str_replace('INM', '', $row_max->invoice_no)) + 1);
    }
    
    function term_update($oldterm, $oldyear, $term, $year)
    {
        return $this->update_key_where(' (' . $this->dx('term') . ' =' . $oldterm . ' AND ' . $this->dx('year') . ' =' . $oldyear . ' )', 'fee_extra_specs', ['term' => $term, 'year' => $year]);
    }

    function fx_invoice()
    {
        //$this->term_update(3, 2020, 2, 2020);
        $this->term_update(1, 2021, 1, 2020);
        $this->term_update(2, 2021, 2, 2020);
        $this->term_update(3, 2021, 3, 2020);

        die('done');
    }

    function update_yrs()
    {

        return $this->update_key_where($this->dx('year') . ' = 2021', 'fee_payment', array('year' => 2020));
    }

    function update_invs()
    {
        return $this->db->where('year', 2021)->update('invoices', array('year' => 2020));
    }

    function update_pays()
    {

        $this->select_all_key('fee_payment');

        $rec = $this->db->get('fee_payment')->result();

        foreach ($rec as $p)
        {

            $past = strtotime("-1 years", $p->payment_date);
            $this->update_key_where($this->dx('payment_date') . ' = ' . $p->payment_date, 'fee_payment', array('payment_date' => $past));
        }

        die('done');
    }

    function get_accounts_bal($code){
        $this->select_all_key('accounts');
        $this->db
        ->where($this->dx('code') . '='.$code, NULL, FALSE)
        ->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->row();
        return $result;
    }

    function update_account($id, $data){
        
        $query = $this->update_key_data($id,'accounts', $data);

        return $query;
    }

    function fee_specs($id)
    {
        $this->select_all_key('fee_extra_specs');
        return $this->db->where(array('id' => $id))->get('fee_extra_specs')->row();
    }

    function get_ex_list()
    {
        $list = $this->db
                    ->where('f_id = 0', NULL)
                    ->or_where('f_id is NULL', NULL)
                    ->get('fee_extras')
                    ->result();

        $drp = [];
        foreach($list as $l)
        {
            $drp[$l->id] = $l->title;
        }

        return $drp;
    }

    
    function get_transport_rts()
    {
        $list = $this->db
                    ->get('transport_routes')
                    ->result();
        $drp = [];
        foreach($list as $l)
        {
                $drp[$l->id] = $l->name;
        }

        return $drp;

    }



      function filter( $term, $year, $item= false ,$student = false, $class = false) 
        {

                $list = $this->portal_m->list_students($class);
                        
                        
                if ($class && empty($list))
                {
                    return array();
                }
                 
                if ($class)
                {
                    $this->db->_protect_identifiers = FALSE;
                    $this->db->where_in($this->dx('student'), $list, FALSE);
                    $this->db->_protect_identifiers = TRUE;
                }

               



                 $this->db->select($this->dx('fee_extra_specs.description') .'as description, '.$this->dx('fee_extra_specs.amount') .'as amount, '.$this->dx('fee_extra_specs.student') . ' as student, ' . $this->dx('fee_extra_specs.invoice_no') . ' as invoice_no,'.$this->dx('fee_extra_specs.term') . ' as term,' .$this->dx('fee_extra_specs.year').'as year'. 
                    ','.$this->dx('fee_extra_specs.fee_id'). 'as fee_id', FALSE);
                $this->db->join('admission', 'admission.id= ' . $this->dx('student'));
                $this->db->where($this->dx('fee_extra_specs.term') . '=' . $term, NULL, FALSE);        
                $this->db->where($this->dx('fee_extra_specs.year') . '=' . $year, NULL, FALSE); 
                // $this->db->where($this->dx('fee_extra_specs.status') . '= 1' , NULL, FALSE); 
                if($item)
                {
                     $this->db->where($this->dx('fee_extra_specs.fee_id') . '=' . $item, NULL, FALSE);        
                }  

                if($student)
                {
                     $this->db->where('admission.id', $student);        
                }  

                $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                $res = $this->db->get('fee_extra_specs')->result();
 

                return $res ;
                
        }

    


}
