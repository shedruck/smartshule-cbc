<?php

class Expenses_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('expenses', $data);
                return $this->db->insert_id();
        }

        function put_req($table, $data)
        {
                return $this->insert_key_data($table, $data);
        }

        public function gen_terms()
        {
                $m = time();
                $y = date('-Y', time());
                $mm = get_term(date('m', $m));
                $months = array();
                if ($mm == 1)
                {
                        $months = array(
                            '01' => '01' . $y,
                            '02' => '02' . $y,
                            '03' => '03' . $y,
                            '04' => '04' . $y,
                        );
                }
                elseif ($mm == 2)
                {
                        $months = array(
                            '05' => '05' . $y,
                            '06' => '06' . $y,
                            '07' => '07' . $y,
                            '08' => '08' . $y,
                        );
                }
                elseif ($mm == 3)
                {
                        $months = array(
                            '09' => '09' . $y,
                            '10' => '10' . $y,
                            '11' => '11' . $y,
                            '12' => '12' . $y,
                        );
                }
                else
                {
                        //do nothing
                }

                return $months;
        }

        //Get Salaries Totals
        function total_basic()
        {
                return $this->db->select('sum(basic_salary) as basic')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(salary_date),'%m-%Y')", $this->gen_terms())
                                          ->get('record_salaries')
                                          ->row();
        }

        //Get Salaries Totals
        function total_nhif()
        {
                return $this->db->select('sum(nhif) as nhif')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(salary_date),'%m-%Y')", $this->gen_terms())
                                          ->get('record_salaries')
                                          ->row();
        }

        //Get Salaries Totals
        function total_allowances()
        {
                return $this->db->select('sum(total_allowance) as allowance')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(salary_date),'%m-%Y')", $this->gen_terms())
                                          ->get('record_salaries')
                                          ->row();
        }

        //Get Salaries Totals
        function total_deductions()
        {
                return $this->db->select('sum(total_deductions) as total')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(salary_date),'%m-%Y')", $this->gen_terms())
                                          ->get('record_salaries')
                                          ->row();
        }

        //Get Salaries Totals
        function deduct_advance()
        {
                return $this->db->select('sum(advance) as total')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(salary_date),'%m-%Y')", $this->gen_terms())
                                          ->get('record_salaries')
                                          ->row();
        }

        function total_advance()
        {
                return $this->db->select('sum(amount) as advance')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(advance_date),'%m-%Y')", $this->gen_terms())
                                          ->get('advance_salary')
                                          ->row();
        }

        //List All Exp Categories
        function list_categories()
        {

                $result = $this->db->select('expenses_category.*')
                             ->order_by('created_on', 'DESC')
                             ->get('expenses_category')
                             ->result();

                $rr = array();
                foreach ($result as $res)
                {
                        $rr[$res->id] = $res->title;
                }

                return $rr;
        }

        /**
         * Fetch Total Expenses for the term
         * 
         * @return type
         */
        function total_expenses()
        {
			  $set = $this->ion_auth->settings();
                $amt = $this->db->select('sum(amount) as total')
                                          ->where('status', 1)
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%m-%Y')", $this->gen_terms($set->term))
                                          //->where_in("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%m-%Y')", $this->gen_terms())
                                          ->get('expenses')
                                          ->row()->total;
                /* $pett = $this->db->select('sum(amount) as total')
                  ->where_in("DATE_FORMAT(FROM_UNIXTIME(petty_date),'%m-%Y')", $this->gen_terms())
                  ->get('petty_cash')
                  ->row()->total;
                  $amt = $exp + $pett; */
                $final = array('total' => $amt);
                return (object) $final;
        }

        /**
         * Total Petty Cash
         * 
         * @return object 
         */
        function total_petty_cash()
        {
			 $set = $this->ion_auth->settings();
                return $this->db->select('sum(amount) as total')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(petty_date),'%m-%Y')", $this->gen_terms($set->term))
                                          ->get('petty_cash')
                                          ->row();
        }

        //today's expenses
        function total_expenses_today()
        {
                return $this->db->select('sum(amount) as total')
                                          ->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%d-%m-%Y')", date('d-m-Y'))
                                          ->where('status', 1)
                                          ->get('expenses')
                                          ->row();
        }

        //This Month's expenses
        function total_expenses_month()
        {
                return $this->db->select('sum(amount) as total')
                                          ->where_in("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%m-%Y')", $this->gen_terms())
                                          ->where('status', 1)
                                          ->get('expenses')
                                          ->row();
        }

//This year's expenses
        function total_expenses_year()
        {
                return $this->db->select('sum(amount) as total')
                                          ->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%Y')", date('Y'))
                                          ->where('status', 1)
                                          ->get('expenses')
                                          ->row();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('expenses')->row();
        }

        function get_req($id)
        {
                $this->select_all_key('requisitions');
                $req = $this->db->where('id', $id)->get('requisitions')->row();

                $this->select_all_key('req_items');
                $req->items = $this->db->where($this->dx('rec_id') . '=' . $id, NULL, FALSE)->get('req_items')->result();

                return $req;
        }

        /**
         * Get All Messages
         * 
         * @param int $id
         * @return type
         */
        function get_messages($id)
        {
                $this->select_all_key('req_wall');
                return $this->db->where($this->dx('req_id') . '=' . $id, NULL, FALSE)->order_by('id', 'ASC')->get('req_wall')->result();
        }

        //Get By Category
        function by_category($id)
        {
                return $this->db->where(array('category' => $id, 'status' => 1))->get('expenses')->result();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('expenses') > 0;
        }

        /**
         * Check if Expenses Category Exists
         * 
         * @param int $id
         * @return boolean
         */
        function cat_exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('expenses_category') > 0;
        }

        function user_exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('users') > 0;
        }

        function count()
        {

                return $this->db->count_all_results('expenses');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('expenses', $data);
        }

        function get_pending_reqs()
        {
                return $this->db->where($this->dx('approved') . '=0', NULL, FALSE)
                                          ->where($this->dx('status') . '=1', NULL, FALSE)
                                          ->count_all_results('requisitions');
        }

        function clear_req_items($id)
        {
                return $this->db->where($this->dx('rec_id') . '=' . $id, NULL, FALSE)->delete('req_items');
        }

        function set_req($id, $data)
        {
                return $this->update_key_data($id, 'requisitions', $data);
        }

        function set_item($id, $data)
        {
                return $this->update_key_data($id, 'req_items', $data);
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
                return $this->db->delete('expenses', array('id' => $id));
        }

        /*         * * 
         * **Return all records
         * * */

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('expense_date', 'desc');
                $this->db->where('status', 1);
                $query = $this->db->get('expenses', $limit, $offset);

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
         * @param array $aColumns
         * @param int $iDisplayStart
         * @param int $iDisplayLength
         * @param type $iSortCol_0
         * @param int $iSortingCols
         * @param string $sSearch
         * @param int $sEcho
         */
        function get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
        {
                $aColumns = $this->db->list_fields('expenses');
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
                                        $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
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
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $this->db->_protect_identifiers = FALSE;
                                        if ($aColumns[$i] == 'title')
                                        {
                                                $this->db->join('expense_items', 'title=expense_items.id');
                                                $this->db->or_where("CONVERT(expense_items.name  USING 'latin1') LIKE '%" . $this->db->escape_like_str($sSearch) . "%'", NULL, FALSE);
                                        }
                                        else
                                        {
                                                $this->db->or_where($aColumns[$i] . " LIKE '%", $this->db->escape_like_str($sSearch) . "%'", NULL, FALSE);
                                        }
                                        $this->db->_protect_identifiers = TRUE;
                                }
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS expenses.' . str_replace(' , ', ' ', implode(',expenses.', $aColumns)), false);
                $this->db->where('expenses.status', 1);
                $rResult = $this->db->order_by('id', 'DESC')->get('expenses');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where('expenses.status', 1)->count_all_results('expenses');

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

                $cats = $this->populate('expenses_category', 'id', 'title');
                $its = $this->populate('expense_items', 'id', 'name');


                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;
                        $item = isset($its[$iCol->title]) ? $its[$iCol->title] : ' ';
                        $cat = isset($cats[$iCol->category]) ? $cats[$iCol->category] : ' ';
                        $by = $this->ion_auth->get_user($iCol->created_by);
                        if (!$this->user_exists($iCol->person_responsible))
                        {
                                $u = new stdClass();
                                $u->first_name = '';
                                $u->last_name = '';
                        }
                        else
                        {
                                $u = $this->ion_auth->get_user($iCol->person_responsible);
                        }

                        $banks =  $this->fee_payment_m->list_banks();
                        $bank =  isset($banks[$iCol->bank_id]) ? $banks[$iCol->bank_id] : '';

                        $aaData[] = array(
                            $iCol->id,
                            $iCol->expense_date ? date('d M Y', $iCol->expense_date) : ' ',
                            $item,
                            anchor('admin/expenses/by_category/' . $iCol->category, ' >> ' . $cat, ''),
                            $iCol->amount ? number_format($iCol->amount, 2) : '',
                            $u->first_name . ' ' . $u->last_name,
                             $bank,
                            $iCol->description . '<br>-------------- <br><b>By:</b> ' . $by->first_name . ' ' . $by->last_name . ' <b>Date:</b> ' . date('d/m/Y', $iCol->created_on),
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        /**
         * Datatable Server Side Data Fetcher
         * 
         * @param array $aColumns
         * @param int $iDisplayStart
         * @param int $iDisplayLength
         * @param type $iSortCol_0
         * @param int $iSortingCols
         * @param string $sSearch
         * @param int $sEcho
         */
        function get_reqs($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
        {
                $aColumns = $this->db->list_fields('requisitions');
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
                                        $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
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
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $this->db->_protect_identifiers = FALSE;
                                        $this->db->or_where($aColumns[$i] . " LIKE '%", $this->db->escape_like_str($sSearch) . "%'", NULL, FALSE);
                                        $this->db->_protect_identifiers = TRUE;
                                }
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('requisitions');
                $this->db->select($this->dx('requisitions.created_on') . ' as created_on, ' . $this->dxa('total') . ', ( select COUNT(req_items.id)  FROM req_items where ' . $this->dx('rec_id') . '=requisitions.id ) as items,' . $this->dxa('approved') . ',' . $this->dx('requisitions.created_by') . ' as created_by', FALSE);
                $this->db->join('req_items', 'requisitions.id= ' . $this->dx('rec_id'));
                $this->db->where($this->dx('requisitions.status') . ' = 1', NULL, FALSE)
                             ->order_by('id', 'DESC');
                $rResult = $this->db->group_by('created_on')->get('requisitions');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('requisitions.status') . ' = 1', NULL, FALSE)->count_all_results('requisitions');

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
                        //having count will always return atleast one row even when no rows
                        if ($aRow['items'] == 0)
                        {
                                break;
                        }
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
                $sts = array('0' => 'Pending', '1' => 'Approved', '2' => 'Rejected');
                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;
                        $by = $this->ion_auth->get_user($iCol->created_by);

                        $aaData[] = array(
                            $iCol->id,
                            $iCol->created_on ? date('d M Y', $iCol->created_on) : ' ',
                            $iCol->items,
                            number_format($iCol->total, 2),
                            $by->first_name . ' ' . $by->last_name,
                            $iCol->approved == 1 ? '<span class="caption green">' . $sts[$iCol->approved] . '</span>' : '<span class="caption purple">' . $sts[$iCol->approved] . '</span>'
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

        /*         * * 
         * **Return all voided Expenses
         * * */

        function all_voided($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $this->db->where('status', 0);
                $query = $this->db->get('expenses', $limit, $offset);

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


        
        function get_accounts(){
                $this->select_all_key('accounts');
                $this->db
                    ->where($this->dx('code') . '<600', NULL, FALSE)
                    ->where($this->dx('code') . '>300', NULL, FALSE)
                    ->order_by($this->dx('code'), 'ASC', FALSE);
                $result = $this->db->get('accounts')->result();
                $options= array();
                foreach($result as $r){
                    $options[$r->id] = $r->name;
                }
                return $options;
            }

}
