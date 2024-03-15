<?php

class Invoices_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('invoices', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('invoices')->row();
    }

    function fetch_temp_iv($id)
    {
        return $this->db->where(array('TxnID' => $id))->get('qb_invoice')->row();
    }

    function fetch_temp_ivlines($id)
    {
        return $this->db->where(array('TxnID' => $id))->get('qb_invoice_lineitem')->result();
    }

    function fetch_iv($id)
    {
        $this->select_all_key('fee_invoice');
        return $this->db->where('id', $id)->get('fee_invoice')->row();
    }

    function fetch_iv_item($id)
    {
        $this->select_all_key('fee_invoice_items');
        return $this->db->where($this->dx('invoice_id') . '=' . $id, NULL, FALSE)->get('fee_invoice_items')->result();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('invoices') > 0;
    }

    function iv_exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('fee_invoice') > 0;
    }

    function clear_invoice($id)
    {
        return $this->db->delete('fee_invoice', array('id' => $id));
    }

    function clear_items($id)
    {
        return $this->db->where($this->dx('invoice_id') . '=' . $id, NULL, FALSE)->delete('fee_invoice_items');
    }

    function clear_temp_invoice($tx_id)
    {
        return $this->db->delete('qb_invoice', array('TxnID' => $tx_id));
    }

    function clear_temp_invoice_lines($tx_id)
    {
        return $this->db->delete('qb_invoice_lineitem', array('TxnID' => $tx_id));
    }

    function count()
    {
        return $this->db->count_all_results('invoices');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('invoices', $data);
    }

    function update_extras($id, $data)
    {
        return $this->update_key_data($id, 'fee_extra_specs', $data);
    }

    function update_ufs($id, $data)
    {
        return $this->update_key_data($id, 'sales_invoices', $data);
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

    function delete($id)
    {
        return $this->db->delete('invoices', array('id' => $id));
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('invoices', $limit, $offset);

        $result = array();
        foreach ($query->result() as $row)
        {
            $result[] = $row;
        }

        if ($result)
        {
            return $result;
        }
        else
        {
            return FALSE;
        }
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
    function get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho, $month = 0, $yr = 0, $status = 0)
    {
        $aColumns = $this->db->list_fields('invoices');

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
                    $this->db->order_by('invoices.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);

                    $this->db->_protect_identifiers = TRUE;
                }
            }
        }

        if (isset($sSearch) && !empty($sSearch))
        {
            $where = '';
            $or = ' OR ';
            $j = 0;
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if ($bSearchable == 'true')
                {
                    $prefx = $j ? $or : '';
                    $sSearch = $this->db->escape_like_str($sSearch);
                    if ($aColumns[$i] == 'student_id')
                    {
                        $this->db->join('admission', 'student_id=admission.id');
                        $inner = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $inner .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $inner .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $sSearch . "%'  ";
                        $where .= $prefx . $inner;
                    }
                    else
                    {
                        $where .= $prefx . ' invoices.' . $aColumns[$i] . " LIKE '%" . $sSearch . "%'  ";
                    }

                    $j++;
                }
            }

            if (!empty($where))
            {
                $this->db->where('(' . $where . ')', NULL, FALSE);
            }
        }
        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS invoices.* ', false);
        if ($month && $yr)
        {
            $this->db->where('MONTH(FROM_UNIXTIME(created_on)) = ' . $month, NULL, FALSE)
                              ->where('YEAR(FROM_UNIXTIME(created_on)) = ' . $yr, NULL, FALSE);
        }
        $st = $status ? 3 : 1;
        $rResult = $this->db->where('check_st', $st)->order_by('id', 'DESC')->get('invoices');
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        if ($month && $yr)
        {
            $this->db->where('MONTH(FROM_UNIXTIME(created_on)) = ' . $month, NULL, FALSE)
                              ->where('YEAR(FROM_UNIXTIME(created_on)) = ' . $yr, NULL, FALSE);
        }
        
        $iTotal = $this->db->where('check_st', $st)->count_all('invoices');

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

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;
            $tm = isset($this->terms[$iCol->term]) ? $this->terms[$iCol->term] : ' ';
            $std = $this->get_student($iCol->student_id);
            $sname = $std->first_name . ' ' . $std->last_name;

            $aaData[] = array(
                $iCol->id,
                $sname,
                $iCol->invoice_no,
                $iCol->created_on ? date('d M Y', $iCol->created_on) : ' ',
                number_format($iCol->amount, 2),
                $tm . ' ' . $iCol->year,
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function pick_students($keyword)
    {
        $this->db->join('admission', $this->dx('fee_invoice.reg_no') . ' = admission.id');
        $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $keyword . "%'  OR ";
        $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $keyword . "%'  OR ";
        $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $keyword . "%'  ";
        return $where;
    }

    function list_fee_extras($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho, $month = 0, $yr = 0)
    {
        $aColumns = $this->db->list_fields('fee_extra_specs');

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
                    if ($aColumns[$i] == 'student')
                    {
                        $this->db->join('admission', 'student=admission.id');
                        $this->db->order_by('CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') ", $this->db->escape_str($sSortDir), FALSE);
                    }
                    else
                    {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->order_by('fee_extra_specs.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                        $this->db->_protect_identifiers = TRUE;
                    }
                }
            }
        }

        if (isset($sSearch) && !empty($sSearch))
        {
            $where = '';
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    if ($aColumns[$i] == 'student')
                    {
                        $this->db->join('admission', $this->dx('student') . '=admission.id');
                        $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $sSearch . "%'  ";
                    }
                    else
                    {
                        $where .= 'OR CONVERT(' . $this->dx('fee_extra_specs.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'  ";
                    }
                }
            }
            if (isset($where) && !empty($where))
            {
                $this->db->where('(' . $where . ')', NULL, FALSE);
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('fee_extra_specs');
        if ($month && $yr)
        {
            $this->db->where('MONTH(FROM_UNIXTIME(' . $this->dx('fee_extra_specs.created_on') . ' )) = ' . $month, NULL, FALSE)
                              ->where('YEAR(FROM_UNIXTIME(' . $this->dx('fee_extra_specs.created_on') . ' )) = ' . $yr, NULL, FALSE);
        }
        $this->db->order_by($this->dx('fee_extra_specs.created_on'), 'DESC', false);
        $rResult = $this->db->get('fee_extra_specs');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        if ($month && $yr)
        {
            $this->db->where('MONTH(FROM_UNIXTIME(' . $this->dx('fee_extra_specs.created_on') . ' )) = ' . $month, NULL, FALSE)
                              ->where('YEAR(FROM_UNIXTIME(' . $this->dx('fee_extra_specs.created_on') . ' )) = ' . $yr, NULL, FALSE);
        }
        $iTotal = $this->db->count_all_results('fee_extra_specs');

        // Output
        $output = [
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => []
        ];

        $aaData = [];
        $obData = [];
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
        $extras = $this->populate('fee_extras', 'id', 'title');

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;

            $ccc = $this->get_student($iCol->student);
            $std = '';
            if (!empty($ccc))
            {
                $stud = $ccc->first_name . ' ' . $ccc->last_name;
                $std = isset($stud) ? $stud : ' ';
            }
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

            $desc = isset($extras[$iCol->fee_id]) ? $extras[$iCol->fee_id] : '-';

            $aaData[] = [
                $iCol->id,
                $iCol->created_on ? date('d M Y ', $iCol->created_on) : ' ',
                '<a class="btn-link" target="_blank" href="' . base_url('admin/fee_payment/statement/' . $iCol->student) . '" title="View Statement">' . $std . ' ' . $sft . ' ' . $st . '</a>',
                $desc,
                $iCol->amount > 0 ? number_format($iCol->amount, 2) : $iCol->amount,
                'Term ' . $iCol->term . ' ' . $iCol->year
            ];
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function list_uniform($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho, $month = 0, $yr = 0)
    {
        $aColumns = $this->db->list_fields('sales_invoices');

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
                    if ($aColumns[$i] == 'student')
                    {
                        $this->db->join('admission', 'student=admission.id');
                        $this->db->order_by('CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') ", $this->db->escape_str($sSortDir), FALSE);
                    }
                    else
                    {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->order_by('sales_invoices.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                        $this->db->_protect_identifiers = TRUE;
                    }
                }
            }
        }

        if (isset($sSearch) && !empty($sSearch))
        {
            $where = '';
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    if ($aColumns[$i] == 'student')
                    {
                        $this->db->join('admission', $this->dx('student') . '=admission.id');
                        $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $sSearch . "%'  ";
                    }
                    else
                    {
                        $where .= 'OR CONVERT(' . $this->dx('sales_invoices.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'  ";
                    }
                }
            }
            if (isset($where) && !empty($where))
            {
                $this->db->where('(' . $where . ')', NULL, FALSE);
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('sales_invoices');
        if ($month && $yr)
        {
            $this->db->where('MONTH(FROM_UNIXTIME(' . $this->dx('sales_invoices.created_on') . ' )) = ' . $month, NULL, FALSE)
                              ->where('YEAR(FROM_UNIXTIME(' . $this->dx('sales_invoices.created_on') . ' )) = ' . $yr, NULL, FALSE);
        }
        $this->db->order_by($this->dx('sales_invoices.created_on'), 'DESC', false);
        $rResult = $this->db->get('sales_invoices');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        if ($month && $yr)
        {
            $this->db->where('MONTH(FROM_UNIXTIME(' . $this->dx('sales_invoices.created_on') . ' )) = ' . $month, NULL, FALSE)
                              ->where('YEAR(FROM_UNIXTIME(' . $this->dx('sales_invoices.created_on') . ' )) = ' . $yr, NULL, FALSE);
        }
        $iTotal = $this->db->count_all_results('sales_invoices');

        // Output
        $output = [
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => []
        ];

        $aaData = [];
        $obData = [];
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
        $s_items = $this->populate('sales_items', 'id', 'name');

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;

            $ccc = $this->get_student($iCol->student);
            $std = '';
            if (!empty($ccc))
            {
                $stud = $ccc->first_name . ' ' . $ccc->last_name;
                $std = isset($stud) ? $stud : ' ';
            }
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

            $desc = isset($s_items[$iCol->item_id]) ? $s_items[$iCol->item_id] : '-';

            $aaData[] = [
                $iCol->id,
                $iCol->created_on ? date('d M Y ', $iCol->created_on) : ' ',
                '<a class="btn-link" target="_blank" href="' . base_url('admin/fee_payment/statement/' . $iCol->student) . '" title="View Statement">' . $std . ' ' . $sft . ' ' . $st . '</a>',
                $desc,
                $iCol->amount > 0 ? number_format($iCol->amount, 2) : $iCol->amount,
                'Term ' . $iCol->term . ' ' . $iCol->year
            ];
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Datatable Server Side Data Fetcher - QB
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_qb_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('fee_invoice');

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
                    $this->db->order_by($this->dx('fee_invoice.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
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
            $sSearch = $this->db->escape_like_str($sSearch);
            $wh = $this->pick_students($sSearch);
            $this->db->or_where($wh, NULL, FALSE);
            /*  for ($i = 0; $i < count($aColumns); $i++)
              {
              $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

              // Individual column filtering
              if (isset($bSearchable) && $bSearchable == 'true')
              {
              if ($aColumns[$i] == 'reg_no')
              {
              $sSearch = $this->db->escape_like_str($sSearch);
              $wh = $this->pick_students($sSearch);
              $this->db->or_where($wh, NULL, FALSE);
              }
              else
              {
              $sSearch = $this->db->escape_like_str($sSearch);
              $this->db->or_like('CONVERT(' . $this->dx('fee_invoice.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
              }
              }
              } */
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('fee_invoice');
        $rResult = $this->db->get('fee_invoice');
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all('fee_invoice');

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

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;
            $mt = date('m', $iCol->created_on);
            $tn = get_term($mt);
            $tm = isset($this->terms[$tn]) ? $this->terms[$tn] : ' ';
            $std = $this->get_student($iCol->reg_no);
            $sname = $std->first_name . ' ' . $std->last_name;
            $aaData[] = array(
                $iCol->id,
                $sname,
                $iCol->refno,
                $iCol->created_on ? date('d M Y', $iCol->created_on) : ' ',
                number_format($iCol->amount, 2),
                $tm,
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function get_student($id)
    {
        $this->select_all_key('admission');
        return $this->db->where(array('id' => $id))->get('admission')->row();
    }

    function find_fee($id)
    {
        return $this->db->where(array('id' => $id))->get('fee_structure')->row();
    }

}
