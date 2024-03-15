<?php

class Salaries_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('salaries', $data);
                return $this->db->insert_id();
        }

        //Insert Deductions
        function insert_deducs($data)
        {
                $this->db->insert('employee_deductions', $data);
                return $this->db->insert_id();
        }

        function get_emp_deductions($id)
        {
                return $this->db->where('salary_id', $id)->get('employee_deductions')->result();
        }

        function get_emp_allowances($id)
        {
                return $this->db->where('salary_id', $id)->get('employee_allowances')->result();
        }

        //Insert Deductions
        function insert_allws($data)
        {
                $this->db->insert('employee_allowances', $data);
                return $this->db->insert_id();
        }

        //List Deductions
        function list_deductions()
        {
                $results = $this->db->get('deductions')->result();
                $arr = array();
                foreach ($results as $r)
                {
                        $arr[$r->id] = $r->name . ' - ' . number_format($r->amount, 2);
                }
                return $arr;
        }

        //List Deductions
        function get_paye()
        {
                $results = $this->db->get('paye')->result();
                $arr = array();
                foreach ($results as $r)
                {
                        if (is_numeric($r->range_from) && is_numeric($r->range_to))
                        {
                                $arr[$r->id] = number_format($r->range_from, 2) . ' --- ' . number_format($r->range_to, 2) . ' ( ' . $r->tax . '% )';
                        }
                        else
                        {
                                $arr[$r->id] = $r->range_from . ' --- ' . $r->range_to . ' ( ' . $r->tax . '% )';
                        }
                }
                return $arr;
        }

        //List Allowances
        function list_allowances()
        {
                $results = $this->db->get('allowances')->result();
                $arr = array();
                foreach ($results as $r)
                {
                        $arr[$r->id] = $r->name . ' - ' . number_format($r->amount, 2);
                }
                return $arr;
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('salaries')->row();
        }

        function get_all()
        {
                return $this->db->order_by('created_on', 'DESC')->get('salaries')->result();
        }

        //Get Employee deductions
        function get_deductions($id)
        {
                return $this->db->where(array('salary_id' => $id))->get('employee_deductions')->result();
        }

        //Get Employee allowances
        function get_allowance($id)
        {
                return $this->db->where(array('salary_id' => $id))->get('employee_allowances')->result();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('salaries') > 0;
        }

        function exists_employee($id)
        {
                return $this->db->where(array('employee' => $id))->count_all_results('salaries') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('salaries');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('salaries', $data);
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
                return $this->db->delete('salaries', array('id' => $id));
        }

        function delete_deductions($id)
        {
                return $this->db->delete('employee_deductions', array('salary_id' => $id));
        }

        function delete_allowances($id)
        {
                return $this->db->delete('employee_allowances', array('salary_id' => $id));
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('salaries', $limit, $offset);
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
        function get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
        {
                $aColumns = $this->db->list_fields('salaries');

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
                                        $this->db->order_by('salaries.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
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
                        $where = '';
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $sSearch = $this->db->escape_like_str($sSearch);
                                        /* if ($aColumns[$i] == 'reg_no')
                                          {
                                          $this->db->join('admission', $this->dx('reg_no') . '=admission.id');
                                          $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                                          $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                                          $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $sSearch . "%'  ";
                                          }
                                          else
                                          {
                                          $where .= 'OR CONVERT(' . $this->dx('fee_payment.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'  ";
                                          } */
                                        //$sSearch = $this->db->escape_like_str($sSearch);
                                        $this->db->or_like('salaries.' . $aColumns[$i], $sSearch, 'both', FALSE);
                                }
                        }
                        if (isset($where) && !empty($where))
                        {
                                $this->db->where('(' . $where . ')', NULL, FALSE);
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select('salaries.*');
                $this->db->order_by('id', 'desc');
                $rResult = $this->db->get('salaries');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->count_all_results('salaries');

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

                $deductions = $this->list_deductions();
                $allowances = $this->list_allowances();

                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;

                        $u = $this->ion_auth->get_user($iCol->employee);
                        $emp = empty($u) ? '-' : $u->first_name . ' ' . $u->last_name;

                        $decstring = '';
                        $allostring = '';
                        $decs = $this->salaries_m->get_deductions($iCol->id);
                        $decstring .= 'NHIF - ' . number_format($iCol->nhif, 2) . '<br>';
                        $decstring .= $iCol->nssf > 0 ? ' NSSF - ' . number_format($iCol->nssf, 2) . '<br>' : '';
                        foreach ($decs as $d)
                        {
                                $decstring .= isset($deductions[$d->deduction_id]) ? $deductions[$d->deduction_id] : ' -';
                                $decstring .= '<br>';
                        }
                        if (isset($iCol->staff_deduction) && !empty($iCol->staff_deduction))
                        {
                                $decstring .= 'Staff Ded: ' . number_format($iCol->staff_deduction);
                        }

                        $allws = $this->salaries_m->get_allowance($iCol->id);
                        foreach ($allws as $d)
                        {
                                $allostring .= isset($allowances[$d->allowance_id]) ? $allowances[$d->allowance_id] : '';
                                $allostring .= '<br>';
                        }

                        $aaData[] = array(
                            $iCol->id,
                            $emp,
                            number_format($iCol->basic_salary, 2),
                            $decstring,
                            $allostring,
                            $iCol->bank_name . '<br>ACC-' . $iCol->bank_account_no,
                            'NHIF #- ' . $iCol->nhif_no . '<br> NSSF #- ' . $iCol->nssf_no
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }

}
