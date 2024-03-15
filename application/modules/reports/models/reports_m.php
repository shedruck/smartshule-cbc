<?php

class Reports_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function days_present($id)
        {
                return $this->db->where(array('student' => $id, 'status' => 'Present'))->count_all_results('class_attendance_list');
        }

        function effort()
        {
                return $this->db->get('effort')->result();
        }

        function igcse_grading()
        {
                return $this->db->order_by('id', 'desc')->where(array('grading_id' => 1))->get('grading_records')->result();
        }

        function days_absent($id)
        {
                return $this->db->where(array('student' => $id, 'status' => 'Absent'))->count_all_results('class_attendance_list');
        }

        function find($id)
        {
                $query = $this->db->get_where('reports', array('id' => $id));
                return $query->row();
        }

        function get_code($id)
        {
                $this->select_all_key('verifiers');
                $query = $this->db->where($this->dx('code') . '="' . $id . '"', NULL, FALSE)->get('verifiers')->row();
                return $query;
        }

        function upi_student($id)
        {
                $this->select_all_key('admission');
                $query = $this->db->where($this->dx('upi_number') . '="' . $id . '"', NULL, FALSE)->get('admission')->row();
                return $query;
        }

        function get_extras($id)
        {
                $this->select_all_key('extras');
                $query = $this->db->where($this->dx('student') . '=' . $id, NULL, FALSE)->get('extras')->result();
                return $query;
        }

        function other_certs($id)
        {
                $query = $this->db->where('student', $id)->get('students_certificates')->result();
                return $query;
        }

        function national_exams($id)
        {
                $query = $this->db->where('student', $id)->get('final_exams_certificates')->result();
                return $query;
        }

        /**
         * 
         * @param type $id
         * @param type $table
         * @return type
         */
        function find_row($id, $table)
        {
                return $this->db->where(array('id' => $id))->get($table)->row();
        }

        function class_history($id)
        {
                $this->select_all_key('history');
                $this->db->order_by('id', 'desc');
                return $this->db->where($this->dx('student') . '=' . $id, NULL, FALSE)
                        ->get('history')
                        ->result();
        }

        /**
         * 
         * @param type $term
         * @param type $year
         * @param type $student
         * @return type
         */
        function remark_exists($term, $year, $student, $exams)
        {
                $in = $this->db->where('term', $term)
                        ->where('year', $year)
                        ->where('student', $student)
                        ->where('exams', $exams)
                        ->get('remarks_joint')
                        ->row();

                return $in ? $in->id : FALSE;
        }

        function update_remarks($id, $data)
        {
                return $this->db->where('id', $id)->update('remarks_joint', $data);
        }

        function save_remarks($data)
        {
                $this->db->insert('remarks_joint', $data);
                return $this->db->insert_id();
        }

        function get_exam($id)
        {
                $query = $this->db->get_where('exams', array('id' => $id));
                return $query->row();
        }

        /**
         * Expenses Summary Report
         * 
         * @param int $term
         * @param int $year
         * @return type
         */
        function get_expenses($term = 0, $year = 0)
        {
                if ($term) {
                        $mts = term_months($term);
                        $this->db->where_in('MONTH(FROM_UNIXTIME(expense_date)) ', $mts, NULL, FALSE);
                }
                if ($year) {
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%Y')", $year, NULL, FALSE);
                }

                return $this->db->where('status', 1)->group_by('category')->order_by('created_on', 'DESC')->get('expenses')->result();
        }

        /**
         * Fetch Expenses by Category
         * 
         * @param type $cat
         * @param type $term
         * @param type $year
         * @return type
         */
        function fetchx_by_category($cat = 0, $term = 0, $year = 0)
        {
                if ($term) {
                        $mts = term_months($term);
                        $this->db->where_in('MONTH(FROM_UNIXTIME(expense_date)) ', $mts, NULL, FALSE);
                }
                if ($year) {
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%Y')", $year, NULL, FALSE);
                }
                if ($cat) {
                        $this->db->where("category", $cat);
                }

                return $this->db->where(array('status' => 1))->get('expenses')->result();
        }

        function total_expense_amount($cat, $term = 0, $year = 0)
        {
                if ($term) {
                        $mts = term_months($term);
                        $this->db->where_in('MONTH(FROM_UNIXTIME(expense_date)) ', $mts, NULL, FALSE);
                }
                if ($year) {
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(expense_date),'%Y')", $year, NULL, FALSE);
                }
                return $this->db->select('sum(amount) as total')->where(array('category' => $cat, 'status' => 1))->get('expenses')->row();
        }

        function expense_categories()
        {
                $result = $this->db->select('expenses_category.*')
                        ->order_by('created_on', 'DESC')
                        ->get('expenses_category')
                        ->result();

                $rr = array();
                foreach ($result as $res) {
                        $rr[$res->id] = $res->title;
                }

                return $rr;
        }

        /**
         * Get Salaries report
         * 
         * @return type
         */
        function get_salaries()
        {
                return $this->db->select('record_salaries.*')->group_by('salary_date')->order_by('salary_date', 'DESC')->get('record_salaries')->result();
        }

        function count_employees($date)
        {
                return $this->db->where(array('salary_date' => $date))->count_all_results('record_salaries');
        }

        function total_basic($date)
        {
                return $this->db->select('sum(basic_salary) as basic')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_deductions($date)
        {
                return $this->db->select('sum(total_deductions) as ded')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_allowances($date)
        {
                return $this->db->select('sum(total_allowance) as allws')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_nhif($date)
        {
                return $this->db->select('sum(nhif) as nhif')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        function total_advance($date)
        {
                return $this->db->select('sum(advance) as advs')->where(array('salary_date' => $date))->get('record_salaries')->row();
        }

        //********************END WAGES ***********************//
        function exists($id)
        {
                $query = $this->db->get_where('reports', array('id' => $id));
                $result = $query->result();

                return $result;
        }

        /**
         * Fetch Admission History Report
         * 
         * @param type $class
         * @param type $year
         * @return type
         */
        function fetch_school_population()
        {

                return $this->db->where('status', 1)->get('class_groups')->result();
        }

        function fetch_adm_history($class = FALSE, $year = FALSE)
        {
                $this->select_all_key('history');
                $this->db->select($this->dx('admission.first_name') . ' as first_name, ' . $this->dx('admission.last_name') . ' as last_name,' . $this->dx('admission.admission_number') . ' as admission_number,' . $this->dx('admission.dob') . ' as dob,' . $this->dx('admission.old_adm_no') . ' as old_adm_no,', FALSE);
                $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname,' . $this->dx('parents.email') . ' as parent_email,' . $this->dx('parents.address') . ' as address,' . $this->dx('parents.phone') . ' as phone,' . $this->dx('admission.house') . ' as house', FALSE);
                $this->db->join('admission', 'admission.id= ' . $this->dx('student'));
                $this->db->join('parents', 'parents.id= ' . $this->dx('admission.parent_id'));
                $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
                $this->db->order_by($this->dx('admission.last_name'), 'ASC', FALSE);
                $this->db->where($this->dx('admission.status') . ' != 0', NULL, FALSE); //allow active & alumni

                if ($year) {
                        $this->db->where($this->dx('history.year') . ' = ' . $year, NULL, FALSE);
                }

                if ($class) {
                        $this->db->where($this->dx('history.class') . ' = ' . $class, NULL, FALSE);
                }

                $result = $this->db->get('history')->result();

                $adm = array();

                foreach ($result as $sd) {
                        $yr = date('Y');
                        $st = $this->get_class_by_year($sd->id, $yr);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $adm[$sd->class][$sd->stream][] = $sd;
                }



                return $adm;
        }

        /**
         * Fetch Fee Status 
         * 
         * @param int $class
         * @return type
         */
        function fetch_fee_status($class = FALSE, $sus = FALSE, $min = FALSE, $max)
        {
                //$this->select_all_key('admission');
                $this->db->select('admission.id,' . $this->dxa('class') . ',' . $this->dx('new_balances.balance') . ' as balance, ' . $this->dx('new_balances.invoice_amt') . ' as invoice_amt,' . $this->dx('new_balances.paid') . ' as paid', FALSE);
                $this->db->join('new_balances', 'admission.id= ' . $this->dx('student'));
                if ($class) {
                        $this->db->join('classes', 'classes.id= ' . $this->dx('admission.class'));
                        $this->db->where($this->dx('classes.class') . ' = ' . $class, NULL, FALSE);
                }
                $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                if ($sus) {
                        $this->db->or_where($this->dx('admission.status') . ' = 0', NULL, FALSE);
                }

                if ($min) {
                        $this->db->where($this->dx('new_balances.balance') . '>=' . $min, NULL, FALSE);
                }

                if ($max != 0) {
                        $this->db->where($this->dx('new_balances.balance') . '<=' . $max, NULL, FALSE);
                }
                $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
                $this->db->order_by($this->dx('admission.last_name'), 'ASC', FALSE);

                $result = $this->db->get('admission')->result();

                $fbal = array();

                foreach ($result as $sd) {
                        $st = $this->find_class($sd->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $fbal[$st->class][$st->stream][] = $sd;
                }

                return $fbal;
        }

        function find_class($id)
        {
                return $this->db->select('class,stream')->where('id', $id)->get('classes')->row();
        }

        /**
         * Fetch Payments
         * 
         * @param type $from
         * @param type $to
         * @param type $bank
         * @param string $method
         * @param string $for
         * @return type
         */
        function fetch_payments($from = 0, $to = 0, $bank = 0, $method = '', $for = 0)
        {
                $this->select_all_key('fee_payment');

                if (($from && $to) && $from == $to) {
                        $dt = date('d-m-Y', $from);
                        $this->db->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('payment_date') . "),'%d-%m-%Y') ='" . $dt . "'", NULL, FALSE);
                } else {
                        if ($from) {
                                $this->db->where($this->dx('payment_date') . '>=' . $from, NULL, FALSE);
                        }
                        if ($to) {
                                $this->db->where($this->dx('payment_date') . '<=' . $to, NULL, FALSE);
                        }
                }
                if ($bank) {
                        $this->db->where($this->dx('bank_id') . "=" . $bank, NULL, FALSE);
                }
                if ($method) {
                        $this->db->where($this->dx('payment_method') . "='" . $method . "'", NULL, FALSE);
                }
                if ($for) {
                        if ($for == 9999999) {
                                $for = 0;
                        }
                        $this->db->where($this->dx('description') . "=" . $for, NULL, FALSE);
                }
                $this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
                $this->db->order_by($this->dx('payment_date'), 'ASC', false);
                $result = $this->db->get('fee_payment')->result();
                $paid = array();

                /*  foreach ($result as $p)
                  {
                  $st = $this->worker->get_student($p->reg_no);
                  if (empty($st->cl))
                  {
                  $paid['class']['class'][] = $p;
                  }
                  else
                  {
                  $paid[$st->cl->class][$st->cl->stream][] = $p;
                  }
                  } */

                return $result;
        }


        function fetch_payments_repo($term = 0, $year = 0, $for = 0)
        {
                $this->select_all_key('fee_payment');

                if ($term) {
                        $this->db->where($this->dx('term') . "=" . $term, NULL, FALSE);
                }

                if ($year) {
                        $this->db->where($this->dx('year') . "=" . $year, NULL, FALSE);
                }

                if ($for) {
                        if ($for == 9999999) {
                                $for = 0;
                        }
                        $this->db->where($this->dx('description') . "=" . $for, NULL, FALSE);
                }
                $this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
                $this->db->order_by($this->dx('payment_date'), 'ASC', false);
                $result = $this->db->get('fee_payment')->result();
                $paid = array();



                return $result;
        }

        /**
         * Determine if Such Class Exists
         * 
         * @param int $id
         * @return boolean
         */
        function such_class($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('class_groups') > 0;
        }

        function update_arrears($id, $data)
        {
                return $this->update_key_data($id, 'fee_arrears', $data);
        }

        /**
         * Fee Extras Roster Report
         * 
         * @param int $fee
         * @param int $class
         * @param int $term
         * @param int $yr
         * @param int $show_payments
         * @return array
         */
        function get_fee_extras($fee, $class, $term, $yr, $show_payments = FALSE)
        {
                if (empty($fee)) {
                        return array();
                }
                $paid = array();

                if (!$term) {
                        $term = get_term(date('m'));
                }
                if (!$yr) {
                        $yr = date('Y');
                }
                if ($fee) {
                        $this->db->where($this->dx('fee_id') . 'IN  (' . implode(',', $fee) . ')', NULL, FALSE);
                }

                if ($class) {
                        $this->db->join('admission', $this->dx('student') . ' = admission.id')
                                ->where($this->dx('class') . '=' . $class, NULL, FALSE);
                }
                //$this->select_all_key('fee_extra_specs');
                $res = $this->db->select('fee_extra_specs.id as id,' . $this->dxa('student') . ',' . $this->dxa('fee_id') . ',SUM(' . $this->dx('amount') . ') as amount', FALSE)
                        ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                        ->where($this->dx('year') . '=' . $yr, NULL, FALSE)
                        ->group_by('student')
                        ->group_by('fee_id')
                        ->get('fee_extra_specs')
                        ->result();

                if ($show_payments) {
                        $mts = term_months($term);
                        $this->select_all_key('fee_payment');
                        $xpayments = $this->db
                                ->where_in("MONTH(FROM_UNIXTIME(" . $this->dx('payment_date') . ")) ", $mts, NULL, FALSE)
                                ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('payment_date') . "),'%Y')=" . $yr, NULL, FALSE)
                                ->where($this->dx('description') . 'IN  (' . implode(',', $fee) . ')', NULL, FALSE)
                                ->where($this->dx('status') . '=1', NULL, FALSE)
                                ->get('fee_payment')
                                ->result();
                        foreach ($xpayments as $x) {
                                $paid[$x->reg_no][$x->description][] = $x->amount;
                        }
                }

                $ros = array();
                foreach ($res as $r) {
                        $cls = $this->get_student_class($r->student);
                        if ($cls) {
                                $ros[$cls->class][] = array('student' => $r->student, 'amount' => $r->amount, 'fee' => $r->fee_id);
                        } else {
                                $ros['Other'][] = array('student' => $r->student, 'amount' => $r->amount, 'fee' => $r->fee_id);
                        }
                }

                return array('roster' => $ros, 'paid' => $paid);
        }

        /**
         * get_new_admissions

         * @param type $year
         * @return type
         */
        function get_new_admissions($year)
        {
                $result = $this->db
                        ->select('admission.id as id,' . $this->dx('admission.first_name') . ' as first_name, ' . $this->dx('admission.last_name') . ' as last_name,' . $this->dxa('admission_number') . ',' . $this->dxa('class') . ' ,' . $this->dxa('dob') . ' ,' . $this->dxa('old_adm_no') . ' ,', FALSE)
                        ->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname,' . $this->dx('parents.email') . ' as parent_email,' . $this->dx('parents.address') . ' as address,' . $this->dx('parents.phone') . ' as phone,' . $this->dx('admission.house') . ' as house', FALSE)
                        ->join('parents', 'parents.id= ' . $this->dx('admission.parent_id'))
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('admission_date') . "),'%Y')=" . $year, NULL, FALSE)
                        ->where($this->dx('admission.status') . '=1', NULL, FALSE)
                        ->order_by($this->dx('admission.first_name'), 'ASC', FALSE)
                        ->order_by($this->dx('admission.last_name'), 'ASC', FALSE)
                        ->get('admission')
                        ->result();

                $adm = array();
                foreach ($result as $sd) {
                        $st = $this->find_class($sd->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $sd->student = $sd->id;
                        $adm[$st->class][$st->stream][] = $sd;
                }
                return $adm;
        }

        /**
         * Get students in a specific House
         * 
         * @param type $house
         * @param type $class
         * @return type
         */
        function get_by_house($house, $class)
        {
                $this->db
                        ->select('id,' . $this->dx('admission.first_name') . ' as first_name, ' . $this->dx('admission.last_name') . ' as last_name,' . $this->dxa('admission_number') . ',' . $this->dxa('class') . ' ,' . $this->dxa('dob') . ' ,' . $this->dxa('old_adm_no') . ' ,', FALSE)
                        ->where($this->dx('house') . '=' . $house, NULL, FALSE);
                if ($class) {
                        $this->db->where($this->dx('class') . '=' . $class, NULL, FALSE);
                }
                $result = $this->db->where($this->dx('status') . '=1', NULL, FALSE)
                        ->order_by($this->dx('first_name'), 'ASC', FALSE)
                        ->order_by($this->dx('last_name'), 'ASC', FALSE)
                        ->get('admission')
                        ->result();

                $adm = array();
                foreach ($result as $sd) {
                        $st = $this->find_class($sd->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $sd->student = $sd->id;
                        $adm[$st->class][$st->stream][] = $sd;
                }
                return $adm;
        }

        function get_due_extras($class)
        {
                $list = $this->portal_m->fetch_students($class);
                if ($class && empty($list)) {
                        return array();
                }

                $yr = date('Y');
                $term = get_term(date('m'));

                if ($class) {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->where_in($this->dx('student'), $list, FALSE);
                        $this->db->_protect_identifiers = TRUE;
                }
                $this->select_all_key('fee_extra_specs');
                $res = $this->db->where($this->dx('year') . '=' . $yr, NULL, FALSE)
                        ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                        ->where('ftype', 1)
                        ->join('fee_extras', $this->dx('fee_id') . '=fee_extras.id')
                        ->get('fee_extra_specs')
                        ->result();

                $ros = array();
                foreach ($res as $r) {
                        $cls = $this->get_student_class($r->student);
                        if ($cls) {
                                $ros[$cls->class][$r->student][] = array('fee_id' => $r->fee_id, 'amount' => $r->amount);
                        } else {
                                $ros['Other'][$r->student][] = array('fee_id' => $r->fee_id, 'amount' => $r->amount);
                        }
                }

                return $ros;
        }

        /**
         * Extracurricular Activity  Report
         * 
         * @param int $activity
         * @param int $class
         * @param int $term
         * @param int $yr
         * @return array
         */
        function get_by_activity($activity, $class, $term, $yr)
        {
                $list = $this->portal_m->fetch_students($class);

                if ($class && empty($list)) {
                        return array();
                }
                if ($term) {
                        $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE);
                }
                if ($yr) {
                        $this->db->where($this->dx('year') . '=' . $yr, NULL, FALSE);
                }
                if ($activity) {
                        $this->db->where($this->dx('activity') . '=' . $activity, NULL, FALSE);
                }

                if ($class) {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->where_in($this->dx('student'), $list, FALSE);
                        $this->db->_protect_identifiers = TRUE;
                }
                $this->select_all_key('extras');
                $res = $this->db->get('extras')->result();

                $ros = array();
                foreach ($res as $r) {
                        $cls = $this->get_student_class($r->student);
                        if ($cls) {
                                $ros[$cls->class][] = array('student' => $r->student);
                        } else {
                                $ros['Other'][] = array('student' => $r->student);
                        }
                }
                return $ros;
        }

        /**
         * Fetch Fee Arrears
         * 
         * @param int $class
         * @param int $term
         * @param int $yr
         */
        function get_arrears($class, $term, $yr, $sus = FALSE)
        {
                $list = $this->portal_m->list_students($class, $sus);

                if ($class && empty($list)) {
                        return array();
                }
                if ($term) {
                        $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE);
                }
                if ($yr) {
                        $this->db->where($this->dx('year') . '=' . $yr, NULL, FALSE);
                }
                if ($class) {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->where_in($this->dx('student'), $list, FALSE);
                        $this->db->_protect_identifiers = TRUE;
                }
                $this->db->select($this->dx('keep_balances.balance') . ' as balance, ' . $this->dx('keep_balances.student') . ' as student,' . $this->dx('keep_balances.paid') . ' as paid', FALSE);
                $this->db->select($this->dx('keep_balances.term') . ' as term, ' . $this->dx('keep_balances.year') . ' as year', FALSE);
                $this->db->join('admission', 'admission.id= ' . $this->dx('student'));
                if ($sus) {
                        $this->db->where($this->dx('admission.status') . ' != 1', NULL, FALSE);
                } else {
                        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                }
                $res = $this->db->get('keep_balances')->result();

                $reas = array();
                foreach ($res as $r) {
                        $cls = $this->get_class_by_year($r->student, $r->year);
                        if ($r->balance) {
                                $frear = array(
                                        'student' => $r->student,
                                        'amount' => $r->balance,
                                        'paid' => $r->paid,
                                        'term' => $r->term,
                                        'year' => $r->year
                                );
                                if ($cls) {
                                        $reas[$cls->class][] = $frear;
                                } else {
                                        $reas['Other'][] = $frear;
                                }
                        }
                }

                return $reas;
        }

        function count()
        {
                return $this->db->count_all_results('reports');
        }

        function update_attributes($id, $data)
        {
                $this->db->where('id', $id);
                $query = $this->db->update('reports', $data);

                return $query;
        }

        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get($table);
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dropdown) {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        function populate_exams()
        {
                $query = $this->db->select('id,title, term, year ')->order_by('id', 'DESC')->get('exams');
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dp) {
                        $options[$dp->id] = $dp->title . '  - Term ' . $dp->term . ' ' . $dp->year;
                }
                return $options;
        }

        function get_labels()
        {
                $query = $this->db->select('id,title, term, year ')->order_by('id', 'DESC')->get('exams');
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dp) {
                        $options[$dp->id] = array('title' => $dp->title, 'term' => $dp->term);
                }
                $options[999999] = array('title' => 'Average', 'term' => 'Average');
                return $options;
        }

        /**
         * Exams Marks Printout For School
         * 
         * @param type $id
         * @return type
         */
        function fetch_exam_results($id, $class = 0, $group = 0, $rank = 1, $xclass)
        {
                if ($group) {
                        $streams = $this->get_group_streams($class);

                        $stids = array();
                        foreach ($streams as $stt) {
                                $stids[] = $stt->id;
                        }
                        $this->db->where_in('class_id', $stids);
                } else {
                        if ($class) {
                                $this->db->where('class_id', $class);
                        }
                }

                $ls = $this->db->where('exam_type', $id)->get('exams_management')->result();

                if (empty($ls)) {
                        return array();
                }
                $classes = array();
                $ids = array();

                foreach ($ls as $l) {
                        $classes[] = $l->class_id;
                        $ids[] = $l->id;
                }
                $exam_supply = $this->db->where_in('exams_id', $ids)->get('exams_management_list')->result();

                $exxams = array();
                $del = array();

                foreach ($exam_supply as $x) {
                        $del[] = $x->id;
                        $st = $this->get_student_class($x->student);

                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $mine = $this->_get_marks_list($x->id, $rank,$xclass);

                        $ct = 0;
                        if (isset($mine['mks'])) {
                                $ct = count($mine['mks']);
                                foreach ($mine['mks'] as $ll) {
                                        $dt = (object) $ll;
                                        if (isset($dt->units)) {
                                                $ct += count($dt->units);
                                        }
                                }
                        }
                        $exxams[$x->student] = $mine;
                }

                $fnn = array('xload' => $exxams, 'max' => $ct);

                return $fnn;
        }

        function get_group_streams($class)
        {
                return $this->db->where('class', $class)->get('classes')->result();
        }

        /**
         * Helper function to dig deeper into marks list table based on its relationship with 
         * Exams_management_list table
         * 
         * @param int $id
         * @param rank $id
         * @return array
         */


         function _get_subjects_cats($class)
         {
                $res = [];
                $list = $this->db->where('class',$class)->get('subject_categories')->result();
                foreach($list as $p)
                {
                        $res[$p->subject] = $p->category;
                }

                return $res;
         }
        function _get_marks_list($id, $rank = 1, $class)
        {
                $props = $this->_get_exam_info($id);
                // $cats = $this->populate('subject_categories', 'subject', 'category');
                $cats = $this->_get_subjects_cats($class);

                

                $res = $this->db->select('exams_marks_list.id as id,exams_marks_list.subject,inc, exams_marks_list.marks, subjects.is_optional')
                        ->join('subjects', 'subjects.id = subject')
                        ->where('exams_list_id', $id)
                        ->order_by('marks', 'DESC')
                        ->get('exams_marks_list')
                        ->result_array();

                $remids = array(); //ids to remove of duplicate marks

                $finite = array();
                $lsu = 0;
                $total = 0;
                $xsub = array();

                $cat_groups = array();
                $therest = array();
                $dropped = array();

                foreach ($res as $varr) {
                        $ff = (object) $varr;
                        if (in_array($ff->subject, $xsub)) {
                                $remids[] = $ff->id; //store ids marked for removal from db
                                continue;
                        }

                        $sgrade = $this->fetch_grading($props->exam, $props->class_id, $ff->subject);
                        $grading = empty($sgrade) ? 0 : $sgrade->grading;

                        $units = $this->fetch_sub_marks($id, $ff->subject);

                        if ($ff->is_optional == 2) {
                                if ($ff->inc) {
                                        $cat_groups[$cats[$ff->subject]][] = array('subject' => $ff->subject, 'marks' => $ff->marks);
                                        $lsu += $ff->marks;
                                        if (count($units)) {
                                                $finite['mks'][$ff->subject] = array('units' => $units, 'marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                        } else {
                                                $finite['mks'][$ff->subject] = array('marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                        }
                                }
                        } else {
                                if (!$ff->is_optional) {
                                        if (isset($cats[$ff->subject])) {
                                                $cat_groups[$cats[$ff->subject]][] = array('subject' => $ff->subject, 'marks' => $ff->marks);
                                        }
                                }
                                $lsu += $ff->is_optional == 1 ? 0 : $ff->marks;
                                if (count($units)) {
                                        $finite['mks'][$ff->subject] = array('units' => $units, 'marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                } else {
                                        $finite['mks'][$ff->subject] = array('marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                }
                        }

                        $xsub[] = $ff->subject;
                }

                if ($rank == 2) {
                        $optimal = isset($cat_groups[1]) ? array_slice($cat_groups[1], 0, 3, true) : array(); //grab 3 compulsory subjects
                        $last = isset($cat_groups[1][3]) ? $cat_groups[1][3] : array(); //remove 4th compulsory if present - also assume its a science

                        if (isset($cat_groups[2])) {
                                if (!empty($last)) {
                                        $cat_groups[2][] = $last;
                                        aasort($cat_groups[2], 'marks', TRUE);
                                }
                                $s = 0;
                                foreach ($cat_groups[2] as $ct) {
                                        $s++;
                                        if ($s <= 2) //pick two sciences only
                                        {
                                                $optimal[] = $ct;
                                        } else {
                                                $therest[] = $ct;
                                        }
                                }
                        }
                        if (isset($cat_groups[3])) {
                                $h = 0;
                                foreach ($cat_groups[3] as $ht) {
                                        $h++;
                                        if ($h == 1) //pick one humanity only
                                        {
                                                $optimal[] = $ht;
                                        } else {
                                                $therest[] = $ht;
                                        }
                                }
                        }
                        if (isset($cat_groups[4])) {
                                foreach ($cat_groups[4] as $ht) {
                                        $therest[] = $ht;
                                }
                        }
                        $others = aasort($therest, 'marks', TRUE);

                        $j = 0;
                        foreach ($others as $ot) {
                                $j++;
                                if ($j == 1)  //pick best 1 from the rest
                                {
                                        $optimal[] = $ot;
                                } else {
                                        $dropped[] = $ot['subject'];
                                }
                        }
                } else if ($rank == 3) {
                        $optimal = isset($cat_groups[1]) ? $cat_groups[1] : array(); //grab all compulsory subjects
                        //3 from all
                        if (isset($cat_groups[2])) {
                                $s = 0;
                                foreach ($cat_groups[2] as $ct) {
                                        $therest[] = $ct;
                                }
                        }
                        if (isset($cat_groups[3])) {
                                $s = 0;
                                foreach ($cat_groups[3] as $ct) {
                                        $therest[] = $ct;
                                }
                        }
                        if (isset($cat_groups[4])) {
                                foreach ($cat_groups[4] as $ht) {
                                        $therest[] = $ht;
                                }
                        }
                        $others = aasort($therest, 'marks', TRUE);
                        $j = 0;
                        foreach ($others as $ot) {
                                $j++;
                                if ($j < 4)  //pick best 3 from the rest
                                {
                                        $optimal[] = $ot;
                                } else {
                                        $dropped[] = $ot['subject'];
                                }
                        }
                }
                if ($rank == 4) {
                        $optimal = isset($cat_groups[1]) ? array_slice($cat_groups[1], 0, 7, true) : array(); //grab 7 compulsory subjects
                      
                        if (isset($cat_groups[2])) {
                                if (!empty($last)) {
                                        $cat_groups[2][] = $last;
                                        aasort($cat_groups[2], 'marks', TRUE);
                                }
                                $s = 0;
                                
                        }


                        if (isset($cat_groups[5])) {
                                $s = 0;
                                foreach ($cat_groups[5] as $ct) {
                                        $therest[] = $ct;
                                }
                        }
                      
                        $others = aasort($therest, 'marks', TRUE);

                     
                      

                        $j = 0;
                        foreach ($others as $ot) {
                                $j++;
                                if ($j == 1)  //pick best 1 from the rest
                                {
                                        $optimal[] = $ot;
                                } else {
                                        $dropped[] = $ot['subject'];
                                }
                        }
                }
                if ($rank > 1) {
                        $final = array();
                        foreach ($optimal as $r) {
                                $total += $r['marks'];
                                $final[] = $r['subject'];
                        }

                        $finite['total_ranked'] = $total;
                        $finite['ranked'] = $final;
                        $finite['dropped'] = $dropped;
                }
                $finite['tots'] = $lsu;

                return $finite;
        }

        function _get_marks_list_bk($id, $rank = 1)
        {
                $props = $this->_get_exam_info($id);

                $res = $this->db->select('exams_marks_list.id as id,exams_marks_list.subject,inc, exams_marks_list.marks, subjects.is_optional')
                        ->join('subjects', 'subjects.id = subject')
                        ->where('exams_list_id', $id)
                        ->get('exams_marks_list')
                        ->result_array();
                $remids = array(); //ids to remove of duplicate marks

                $finite = array();
                $lsu = 0;
                $xsub = array();
                foreach ($res as $key => $varr) {
                        $ff = (object) $varr;
                        if (in_array($ff->subject, $xsub)) {
                                $remids[] = $ff->id; //store ids marked for removal from db
                                continue;
                        }
                        $sgrade = $this->fetch_grading($props->exam, $props->class_id, $ff->subject);
                        $grading = empty($sgrade) ? 0 : $sgrade->grading;

                        $units = $this->fetch_sub_marks($id, $ff->subject);

                        if ($ff->is_optional == 2) {
                                if ($ff->inc) {
                                        $lsu += $ff->marks;
                                        if (count($units)) {
                                                $finite['mks'][$ff->subject] = array('units' => $units, 'marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                        } else {
                                                $finite['mks'][$ff->subject] = array('marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                        }
                                }
                        } else {
                                $lsu += $ff->is_optional == 1 ? 0 : $ff->marks;
                                if (count($units)) {
                                        $finite['mks'][$ff->subject] = array('units' => $units, 'marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                } else {
                                        $finite['mks'][$ff->subject] = array('marks' => $ff->marks, 'grading' => $grading, 'inc' => $ff->inc, 'opt' => $ff->is_optional);
                                }
                        }

                        $xsub[] = $ff->subject;
                }

                $finite['tots'] = $lsu;

                return $finite;
        }

        function map_ranking($id, $student, $rank = 1)
        {
                $srow = $this->portal_m->find($student);

                $ls = $this->db->where('class_id', $srow->class)->where('exam_type', $id)->get('exams_management')->result();

                if (empty($ls)) {
                        return array(
                                'mks' => array(),
                                'total_ranked' => 0,
                                'tots' => array(),
                                'ranked' => array(),
                                'dropped' => array()
                        );
                }
                $ids = array();

                foreach ($ls as $l) {
                        $ids[] = $l->id;
                }
                $rw = $this->db->where_in('exams_id', $ids)->where('student', $student)->get('exams_management_list')->row();

                $mine = $this->_get_marks_list($rw->id, $rank);
                unset($mine['mks']);

                return $mine;
        }

        /**
         * Process invoices, waivers & payments for Whole School
         * 
         * @param int $student
         * @return array payload
         */
        function fee_summary($term = 0, $year = 0)
        {
                $paid = $this->fee_payment_m->fetch_all_receipts($term, $year);
                $payload = array();
                $debs = $this->fee_payment_m->fetch_all_debs($term, $year);
                $wvs = $this->fee_payment_m->fetch_all_waivers($term, $year);
                $xtra = $this->fee_payment_m->fetch_all_exts($term, $year);
                $bals = $this->fee_payment_m->fetch_all_bals($term, $year);

                foreach ($debs as $d) {
                        $yr = date('Y', $d->created_on);
                        $student = $this->worker->get_student($d->student_id);
                        $st = $this->find_class($student->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }

                        $payload[$d->year][$d->term][$st->class][$st->stream]['debit'][] = $d->amount;
                }

                foreach ($xtra as $f) {
                        $student = $this->worker->get_student($f->student);
                        $st = $this->find_class($student->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $exfee = $this->fee_payment_m->get_extra($f->fee_id);
                        if (isset($exfee->ftype) && $exfee->ftype == 1) {
                                //charge
                                $payload[$f->year][$f->term][$st->class][$st->stream]['extra_c'][] = $f->amount;
                        } else {       //waiver
                                $payload[$f->year][$f->term][$st->class][$st->stream]['extra_w'][] = $f->amount;
                        }
                }

                foreach ($wvs as $w) {
                        $student = $this->worker->get_student($w->student);
                        $st = $this->find_class($student->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $payload[$w->year][$w->term][$st->class][$st->stream]['waivers'][] = $w->amount;
                }

                foreach ($paid as $p) {
                        $yr = isset($p->year) && !empty($p->year) ? $p->year : date('Y', $p->payment_date);
                        $student = $this->worker->get_student($p->reg_no);
                        $st = $this->find_class($student->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        if (isset($p->term) && !empty($p->term)) {
                                $mon = $p->term;
                        } else {
                                $mt = date('m', $p->payment_date);
                                $mon = get_term($mt);
                        }

                        $payload[$yr][$mon][$st->class][$st->stream]['credit'][] = $p->amount;
                }
                foreach ($bals as $mb) {
                        $student = $this->worker->get_student($mb->student);
                        $st = $this->find_class($student->class);
                        if (!$st) {
                                $st = new stdClass();
                                $st->class = 'Other';
                                $st->stream = 'Other';
                        }
                        $payload[$mb->year][$mb->term][$st->class][$st->stream]['bal'][] = $mb->balance;
                }

                return $payload;
        }

        /**
         * Get Student Class Group
         * 
         * @param int $student ID
         * @return int Class ID
         */
        function get_student_class($student)
        {
                $kla = $this->db->select($this->dxa('class'), FALSE)->where('id', $student)->get('admission')->row();

                if ($kla) {
                        $cid = $kla->class;
                        $std = $this->db->select('class,stream')->where('id', $cid)->get('classes')->row();
                        if ($std) {
                                $cl = $std;
                        } else {
                                $cl = FALSE;
                        }
                } else {
                        $cl = FALSE;
                }

                return $cl;
        }

        function get_class_by_year($student, $year)
        {
                $std = $this->db->select($this->dxa('class') . ' ,' . $this->dxa('stream'), FALSE)
                        ->where($this->dx('student') . '=' . $student, NULL, FALSE)
                        ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                        ->get('history')
                        ->row();
                if ($std) {
                        $cl = $std;
                } else {
                        $cl = FALSE;
                }

                return $cl;
        }

        function fix_adm($parent_id, $puser_id, $new_parent_id, $new_puser_id)
        {
                $where = $this->dx('parent_id') . '=' . $parent_id . ' AND ' . $this->dx('parent_user') . '=' . $puser_id . ' ';
                $this->update_key_where($where, 'admission', array('parent_id' => $new_parent_id, 'parent_user' => $new_puser_id));

                file_put_contents(APPPATH . '/log.sql', $this->db->last_query() . " \n ", 8);
                $this->fix_assign($parent_id, $new_parent_id);
                file_put_contents(APPPATH . '/log.sql', $this->db->last_query() . " \n ", 8);

                return TRUE;
        }

        function fix_assign($parent_id, $new_parent_id)
        {
                return $this->db->where('parent_id', $parent_id)->update('assign_parent', array('parent_id' => $new_parent_id));
        }

        function populate_admission()
        {
                $query = $this->db->select('id, ' . $this->dxa('first_name') . ' ,' . $this->dxa('last_name'), FALSE)->order_by($this->dx('first_name'), 'ASC', FALSE)->get('admission');
                $dropdowns = $query->result();

                $options = array();
                foreach ($dropdowns as $dp) {
                        $options[$dp->id] = $dp->first_name . '  ' . $dp->last_name;
                }
                return $options;
        }

        /**
         * Get Classes Options For Dropdown List
         * 
         * @param array $classes
         * @param array $streams
         * @return array
         */
        function get_classes($classes, $streams = FALSE)
        {
                $ops = $this->db->select('id,stream, class')->order_by('class')->get('classes')->result();

                $options = array();
                foreach ($ops as $p) {
                        if ($streams) {
                                if (isset($streams[$p->stream]) && isset($classes[$p->class_id])) {
                                        $options[$p->id] = $classes[$p->class_id] . ' ' . $streams[$p->stream];
                                }
                        } else {
                                if (isset($classes[$p->class_id])) {
                                        $options[$p->id] = $classes[$p->class_id];
                                }
                        }
                }
                return $options;
        }

        /**
         * Get Class names
         * 
         * @return array
         */
        function get_class_names()
        {
                $ops = $this->db->select('id, class_name')->order_by('id')->get('school_classes')->result();

                $options = array();
                foreach ($ops as $p) {
                        $options[$p->id] = $p->class_name;
                }
                return $options;
        }

        function get_by_assoc($alert, $assoc_id, $tbl, $type)
        {
                $qr = $this->db->select('id, company_id')
                        ->where(array('alert_id' => $alert, 'type' => $type))
                        ->get($tbl)
                        ->result();
                $cos = array();
                foreach ($qr as $q) {
                        $cos[] = $q->$assoc_id;
                }
                return $cos;
        }

        function get_users()
        {
                return $this->db->select('id, first_name, last_name, client_id')
                        ->where('active', 1)
                        ->order_by('first_name ', 'ASC')
                        ->order_by('last_name ', 'ASC')
                        ->get('users')->result();
        }

        function get_tasks()
        {
                return $this->db->where("DATE_FORMAT(FROM_UNIXTIME(task_date), '%d %b %Y')='" . date('d M Y') . "'", NULL, FALSE)->get('tasks')->result();
        }

        /**
         * Get Number of Students Admitted in Specified Class
         * 
         * @param int $class the Class ID
         */
        function count_population($class, $stream = FALSE)
        {
                $this->db->where($this->dx('class') . '=' . $class, NULL, FALSE);
                if ($stream) {
                        $this->db->where($this->dx('stream') . '=' . $stream, NULL, FALSE);
                }
                $res = $this->db->count_all_results('admission');
                return $res;
        }

        /**
         * Get List of Students Admitted in Specified Class
         * 
         * @param int $class the Class ID
         */
        function get_population($class, $stream = FALSE)
        {
                //$this->select_all_key('admission');
                $this->db->where($this->dx('class') . '=' . $class, NULL, FALSE);
                if ($stream) {
                        $this->db->where($this->dx('stream') . '=' . $stream, NULL, FALSE);
                }
                return $this->db->get('classes')->result();
        }

        /**
         * Fetch Class Marks
         * 
         * @param int $class
         * @param int $term
         * @return object
         */
        function get_marks($class, $term = FALSE)
        {
                $term = get_term(date('m'));
                $info = $this->db->select('*')
                        ->where('class_id', $class)
                        // ->where('MONTH(FROM_UNIXTIME(exams_management.created_on))', $term)
                        ->join('exams_management', 'exams_management_list.exams_id = exams_management.id')
                        ->get('exams_management_list')
                        ->result();
                $perf_list = array();

                foreach ($info as $f) {
                        $perf_list[] = array(
                                'student' => $f->student,
                                'exams_id' => $f->exams_id,
                                'term' => get_term(date('m', $f->record_date)),
                                'grading' => $f->grading,
                                'marks' => $this->_fetch_by_marks($f->exams_id, $f->student),
                                'total' => $f->total,
                                'remarks' => $f->remarks,
                                'created_by' => $f->created_by,
                                'record_date' => $f->record_date
                        );
                }

                return $perf_list;
        }

        /**
         * Helper Fuction To Get Specific Marks and inject them to main array
         * 
         * @param int $exam
         * @param int $student
         * @return array
         */
        function _fetch_by_marks($exam, $student)
        {
                $list = $this->db->select('id, student')
                        ->where('exams_id', $exam)
                        ->where('student', $student)
                        ->get('exams_management_list')
                        ->result();
                if (empty($list)) {
                        return array();
                } else {
                        $ids = array();
                        foreach ($list as $l) {
                                $ids[$l->id] = $l->student;
                        }
                        $marks = array();
                        foreach ($ids as $id => $student) {
                                $marks = $this->_get_marks_list($id);
                        }

                        aasort($marks, 'subject');
                        return $marks;
                }
        }

        /**
         * Fetch Exam Info
         * 
         * @param type $id
         * @return type
         */
        function _get_exam_info($id)
        {
                $res = $this->db->where('id', $id)
                        ->get('exams_management_list')
                        ->row();

                return $this->db->select('class_id, exam_type as exam', FALSE)
                        ->where('id', $res->exams_id)
                        ->get('exams_management')
                        ->row();
        }

        /**
         * fetch_grading System
         * 
         * @param int $exam
         * @param int $class
         * @param int $subject
         * @return type
         */
        function fetch_grading($exam, $class, $subject)
        {
                return $this->db->where(array('exam' => $exam, 'class' => $class, 'subject' => $subject))->get('exam_grading')->row();
        }

        /**
         * Get Grading records 
         * 
         * @param type $id
         * @param type $title
         * @return type
         */
        function get_grading_records($id)
        {
                $row = $this->db->where(array('grading_system' => $id))->get('grading')->row();
                if ($row) {
                        $records = $this->db->where(array('grading_id' => $row->id))->get('grading_records')->result();
                        $options = array();

                        foreach ($records as $r) {
                                $grade = $this->find_row($r->grade, 'grades');

                                $title = empty($grade) || !isset($grade->title) ? '-' : $grade->title;
                                $options[] = array('min' => $r->minimum_marks, 'max' => $r->maximum_marks, 'title' => $title);
                        }
                        return $options;
                } else {
                        return array();
                }
        }

        /**
         * Fetch Marks Sub
         * @param type $subject
         * @return type
         */
        function fetch_sub_marks($id, $subject)
        {
                $ss = $this->db->where('parent', $subject)
                        ->where('marks_list_id', $id)
                        ->get('sub_marks')
                        ->result();
                $ret = array();
                foreach ($ss as $s) {
                        $ret[$s->unit] = $s->marks;
                }
                return $ret;
        }

        function get_subjects($class)
        {
                return $this->db->where(array('class_id' => $class))->get('subjects_classes')->result();
        }

        function list_subjects()
        {
                $results = $this->db->order_by('id', 'ASC')->get('subjects')->result();
                $rr = array();
                foreach ($results as $res) {
                        $rr[$res->id] = $res->title;
                }

                return $rr;
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
         * Fetch Current Students in Specified Stream  
         * 
         * @param type $id
         * @return type
         */
        function fetch_stream_students($id)
        {
                if (!$id) {
                        return array();
                }

                $list = $this->db->select('id')
                        ->where($this->dx('class') . '=' . $id, NULL, FALSE)
                        ->where($this->dx('status') . '=1', NULL, FALSE)
                        ->get('admission')->result();

                $students = array();
                foreach ($list as $l) {
                        $students[] = $l->id;
                }
                return $students;
        }

        function fetch_appraisal($class, $year, $term)
        {
                $students = $this->fetch_stream_students($class);
                if (empty($students)) {
                        $students = array(0);
                }
                $this->select_all_key('appraisal');
                return $this->db
                        ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                        ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                        ->where($this->dx('student') . ' in (' . implode(',', $students) . ')', NULL, FALSE)
                        ->get('appraisal')
                        ->result();
        }

        /**
         * Fetch Student Balance Status
         * 
         * @param int $student
         */
        function get_bal_status($student)
        {
                $this->select_all_key('new_balances');
                return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                        ->get('new_balances')
                        ->row();
        }

        function fetch_sus_balances()
        {
                $this->select_all_key('new_balances');
                return $this->db->join('admission', 'admission.id= ' . $this->dx('student'))
                        ->where($this->dx('admission.status') . '=' . 0, NULL, FALSE)
                        ->where($this->dx('balance') . '!=' . 0, NULL, FALSE)
                        ->get('new_balances')
                        ->result();
        }

        /**
         * Get Starting Balances
         * 
         * @return result object
         * 
         */
        function fetch_starting_balances()
        {
                $this->select_all_key('fee_arrears');
                return $this->db->get('fee_arrears')
                        ->result();
        }

        function insert_rear($data)
        {
                return $this->insert_key_data('fee_arrears', $data);
        }

        /**
         * Fetch Parent details
         * 
         * @param int $id
         */
        function get_parent($id)
        {
                $this->select_all_key('parents');
                return $this->db->where('id', $id)
                        ->get('parents')
                        ->row();
        }
        function get_daily($date)
        {
                if (strtotime($date) < 10000) {
                        return [];
                }
                $__date = date('d-m-Y', strtotime($date));

                $this->select_all_key('admission');
                return $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('admission_date') . "),'%d-%m-%Y') ='" . $__date . "'", NULL, FALSE)
                        ->get('admission')
                        ->result();
        }

        function get_monthly($month, $year)
        {
                if (!$month || !$year) {
                        return [];
                }
                $__mt = str_pad($month, 2, '0', 0);

                $this->select_all_key('admission');
                return $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('admission_date') . "),'%m-%Y') ='" . $__mt . "-{$year}'", NULL, FALSE)
                        ->get('admission')
                        ->result();
        }

        function get_range($from, $to)
        {
                if (strtotime($from) < 10000 || strtotime($to) < 10000) {
                        return [];
                }
                $__from = date('Y-m-d', strtotime($from));
                $__to = date('Y-m-d', strtotime($to));

                $this->select_all_key('admission');
                return $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('admission_date') . "),'%Y-%m-%d') BETWEEN  CAST('{$__from}' AS DATE) AND CAST('{$__to}' AS DATE) ", NULL, FALSE)
                        ->get('admission')
                        ->result();
        }

        function get_daily_invoices($date, $export = false)
        {
                if (strtotime($date) < 10000) {
                        return [];
                }
                $__date = date('d-m-Y', strtotime($date));

                $this->select_all_key('fee_extra_specs');
                $extras = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('fee_extra_specs.created_on') . "),'%d-%m-%Y') ='" . $__date . "'", NULL, FALSE)
                        ->where($this->dx('fee_extra_specs.status') . '= 1', NULL, FALSE)
                        ->where('ftype', 1)
                        ->join('fee_extras', 'fee_extras.id=' . $this->dx('fee_id'))->get('fee_extra_specs')
                        ->result_array();

                $tt = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%d-%m-%Y') ='" . $__date . "'", NULL, FALSE)
                        ->where('check_st', 1)
                        ->get('invoices')
                        ->result_array();

                $trans = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%d-%m-%Y') ='" . $__date . "'", NULL, FALSE)
                        ->where('status =1', NULL, FALSE)
                        ->get('transport')
                        ->result_array();

                $invoices = array_merge($extras, $trans, $tt);
                $sortt = aasort($invoices, 'created_on');

                return $this->_prep_ledger($sortt, $export);
        }


        function get_monthly_invoices($month, $year, $export = false)
        {
                if (!$month || !$year) {
                        return [];
                }
                $__mt = str_pad($month, 2, '0', 0);

                $this->select_all_key('fee_extra_specs');
                $extras = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('fee_extra_specs.created_on') . "),'%m-%Y') ='" . $__mt . "-{$year}'", NULL, FALSE)
                        ->where('ftype', 1)
                        ->where($this->dx('fee_extra_specs.status') . '= 1', NULL, FALSE)
                        ->join('fee_extras', 'fee_extras.id=' . $this->dx('fee_id'))->get('fee_extra_specs')
                        ->result_array();

                $tt = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%m-%Y') ='" . $__mt . "-{$year}'", NULL, FALSE)
                        ->where('check_st', 1)
                        ->get('invoices')
                        ->result_array();

                $trans = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%m-%Y') ='" . $__mt . "-{$year}'", NULL, FALSE)
                        ->where('status =1', NULL, FALSE)
                        ->get('transport')
                        ->result_array();

                $invoices = array_merge($extras, $trans, $tt);
                $sortt = aasort($invoices, 'created_on');

                return $this->_prep_ledger($sortt, $export);
        }

        function get_range_invoices($from, $to, $export = false)
        {
                if (strtotime($from) < 10000 || strtotime($to) < 10000) {
                        return [];
                }
                $__from = date('Y-m-d', strtotime($from));
                $__to = date('Y-m-d', strtotime($to));

                $this->select_all_key('fee_extra_specs');
                $extras = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('fee_extra_specs.created_on') . "),'%Y-%m-%d') BETWEEN  CAST('{$__from}' AS DATE) AND CAST('{$__to}' AS DATE) ", NULL, FALSE)
                        ->where('ftype', 1)
                        ->where($this->dx('fee_extra_specs.status') . '= 1', NULL, FALSE)
                        ->join('fee_extras', 'fee_extras.id=' . $this->dx('fee_id'))
                        ->get('fee_extra_specs')
                        ->result_array();

                $tt = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%Y-%m-%d') BETWEEN  CAST('{$__from}' AS DATE) AND CAST('{$__to}' AS DATE) ", NULL, FALSE)
                        ->where('check_st', 1)
                        ->get('invoices')
                        ->result_array();


                $trans = $this->db
                        ->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%Y-%m-%d') BETWEEN  CAST('{$__from}' AS DATE) AND CAST('{$__to}' AS DATE) ", NULL, FALSE)
                        ->where('status =1', NULL, FALSE)
                        ->get('transport')
                        ->result_array();

                $invoices = array_merge($extras, $trans, $tt);

                $sortt = aasort($invoices, 'created_on');

                return $this->_prep_ledger($sortt, $export);
        }

        function _prep_ledger($data, $export = false)
        {
                $fn = [];
                $fees = [];
                foreach ($data as $sp) {
                        $s = (object) $sp;
                        if (isset($s->fee_id)) {
                                $fee = $this->fee_payment_m->get_extra($s->fee_id);
                                $fees[$s->fee_id] = $fee->title;
                                $s->cat = 'extras';
                                $s->title = $fee->title;
                                $sid = isset($s->student) ? $s->student : '';
                        }
                        if (isset($s->route)) {
                                $zone = $this->fee_payment_m->populate('transport_routes', 'id', 'name');
                                $stage = $this->fee_payment_m->populate('transport_stages', 'id', 'stage_name');
                                $zn = isset($zone[$s->route]) ? $zone[$s->route] : '';
                                $stg = isset($stage[$s->stage]) ? $stage[$s->stage] : '';
                                $desc = ($s->custom == 1) ? 'For ' . $s->description : '';
                                $way = ($s->way == 1) ? 'One Way' : 'Two Way';
                                $s->cat = 'transport';
                                $s->title = 'Transport : ' . $zn . ' - ' . $way . ' ' . $desc;
                                $sid = $s->student;
                        }

                        if (isset($s->student_id)) {
                                $s->cat = 'tuition';
                                $sid = $s->student_id;
                                $s->title = 'Tuition Fee';
                        }

                        $fn[$sid][] = $s;
                }

                return $export ? (object) ['post' => $fn, 'map' => $fees] : $fn;
        }




        //     best 8 subjects

        function get_streams($class)
        {
                return $this->db->where('class', $class)->get('classes')->result();
        }


        function _get_subjects()
        {
             $list  = $this->db->order_by('priority','ASC')->get('subjects')->result();
             foreach($list as $l)
             {
                $out[$l->id] = $l->short_name;
             }   

             return $out;
        }


        function _get_sub_types()
        {
                $list  = $this->db->get('subject_categories')->result();
                foreach ($list as $l) {
                        $out[$l->id] = $l->is_optional;
                }

                return $out;
        }

        function optional_subjects($id)
        {
                return $this->db->where('id', $id)->get('subjects')->row();
        }


        function _get_marks($class, $exam)
        {
                // $subjects = $this->_get_subjects();
                $types = $this->_get_sub_types();
                $list = $this->db->where(['class_id' => $class, 'exam_type' => $exam])->get('exams_management')->result();
                $mgt_list = [];
                foreach($list as $l)
                {
                        $mgt_list = $this->db->where(['exams_id' => $l->id])->get('exams_management_list')->result();
                        foreach($mgt_list as $p)
                        {
                             $marks = $this->db->where(['exams_list_id' => $p->id])->get('exams_marks_list')->result();

                             foreach($marks as $m)
                             {
                                $payload[$l->class_id][$p->student][$m->subject] = $m->marks;
                             }
                        }
                }
               
                echo '<pre>';
                print_r($payload);
                echo '</pre>';
                die();
              

                return $payload;
        }

        function get_exam_report_by_grp($class,$exam)
        {
               $classes = $this->get_streams($class);
               $payload = [];
               foreach($classes as $cl)
               {
                        $payload[] = $this->_get_marks($cl->id, $exam);
               }


        //        foreach($payload as $rr => $rows)
        //        {
        //                 foreach($rows as $cls => $data)
        //                 {
        //                         foreach($data as $load)
        //                         {
        //                                 foreach($load as $p)
        //                                 {
                                                
        //                                 }
        //                         }
                                
        //                 }
        //        }

             

               

        //        echo '<pre>';
        //        print_r($payload);
        //        echo '</pre>';
        //        die();
        }
}
