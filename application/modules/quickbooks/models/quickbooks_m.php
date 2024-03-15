<?php

class Quickbooks_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    /**
     * Save Customer List
     * 
     * @param array $data
     */
    function save_customer_list($data)
    {
        $this->db->insert('qb_customers', $data);
        return $this->db->insert_id();
    }

    function save_compare($data)
    {
        $this->db->insert('qb_compare', $data);
        return $this->db->insert_id();
    }

    /**
     * Save Invoice List
     * 
     * @param array $data
     */
    function save_invoice_list($data)
    {
        $this->db->insert('qb_invoice', $data);
        return $this->db->insert_id();
    }

    /**
     * Save Payments List
     * 
     * @param array $data
     */
    function save_payments_list($data)
    {
        return $this->insert_key_data('qb_payments', $data);
    }

    /**
     * Empty this table for new data
     * 
     * @return type
     */
    function clear_log()
    {
        $sql = 'truncate quickbooks_log';
        return $this->db->query($sql);
    }

    /**
     * Check If Payment Exists in holding table
     * 
     * @param type $txid
     * @param type $regno
     * @return boolean
     */
    function qb_payment_exists($txid, $regno)
    {
        return $this->db->where($this->dx('transaction_no') . "='" . $txid . "'", NULL, FALSE)
                                            ->where($this->dx('reg_no') . "='" . $regno . "'", NULL, FALSE)
                                            ->count_all_results('qb_payments') > 0;
    }

    function qb_payment_row($txid, $regno)
    {
        $this->select_all_key('qb_payments');
        return $this->db->where($this->dx('transaction_no') . "='" . $txid . "'", NULL, FALSE)
                                            ->where($this->dx('reg_no') . "='" . $regno . "'", NULL, FALSE)
                                            ->get('qb_payments')
                                            ->row();
    }

    /**
     * Check if Invoice already Exists
     * 
     * @param type $txid
     * @param type $list_id
     * @return type
     */
    function qb_invoice_exists($txid)
    {
        return $this->db->where('TxnID', $txid)->count_all_results('qb_invoice') > 0;
    }

    /**
     * Check if Customer Exists
     * 
     * @param type $list_id
     * @return type
     */
    function qb_customer_exists($list_id)
    {
        return $this->db->where('list_id', $list_id)->count_all_results('qb_customers') > 0;
    }

    function qb_compare_exists($list_id)
    {
        return $this->db->where('list_id', $list_id)->count_all_results('qb_compare') > 0;
    }

    function count_seen()
    {
        return $this->db->where('seen', 1)->count_all_results('qb_customers');
    }

    function count_all_vc()
    {
        return $this->db->count_all_results('qb_invoice');
    }

    /**
     * Get Pending amount
     * 
     * @return type
     */
    function count_pending_vc()
    {
        return $this->db->select('sum(amount) as sum', FALSE)
                                            ->where('seen !=1', NULL, FALSE)
                                            ->get('qb_invoice')
                                            ->row()->sum;
    }

    function count_seen_vc()
    {
        return $this->db->where('seen', 1)->count_all_results('qb_invoice');
    }

    function count_seen_pay()
    {
        return $this->db->where($this->dx('seen') . ' =1', NULL, FALSE)->count_all_results('qb_payments');
    }

    function count_all()
    {
        return $this->db->count_all_results('qb_customers');
    }

    function count_all_paid()
    {
        return $this->db->count_all_results('qb_payments');
    }

    function get_customer($list_id)
    {
        return $this->db->where('list_id', $list_id)->get('qb_customers')->row();
    }

    function get_compare($list_id)
    {
        return $this->db->where('list_id', $list_id)->get('qb_compare')->row();
    }

    function update_customer($id, $data)
    {
        return $this->db->where('id', $id)->update('qb_customers', $data);
    }

    /**
     * Clear old Invoice Items
     * 
     * @param type $id
     * @return type
     */
    function clear_invoice_lines($id)
    {
        return $this->db->delete('qb_invoice_lineitem', array('TxnID' => $id));
    }

    /**
     * Fix Unmatched Balances
     * 
     * @param type $id
     * @return type
     */
    function dkfix()
    {
        $list = $this->get_lost();

        foreach ($list as $lx)
        {
            $l = (object) $lx;
            echo " *********** Student {$l->student_id} *********** \n<br/>";
            /* QB_payments */
            $qbp = $this->db->where($this->dx('reg_no') . "='" . $l->list_id . "'", NULL, FALSE)->count_all_results('qb_payments');
            echo "|***  " . $qbp . " temp payments  \n<br/>";
            //$this->db->where($this->dx('reg_no') . "='" . $l->list_id . "'", NULL, FALSE)->delete('qb_payments');

            /* Fee_receipt */
            $qrec = $this->db->where('student', $l->student_id)->count_all_results('fee_receipt');
            echo "|***  " . $qrec . " Fee Receipts \n<br/>";
            //$this->db->where('student', $l->student_id)->delete('fee_receipt');

            /* Fee_payment */
            $qfeep = $this->db->where($this->dx('reg_no') . '=' . $l->student_id, NULL, FALSE)->count_all_results('fee_payment');
            echo "|***  " . $qfeep . " Fee payments  \n<br/>";
            //$this->db->where($this->dx('reg_no') . '=' . $l->student_id, NULL, FALSE)->delete('fee_payment');

            /* QB_invoice_lineitem */
            $ivs = $this->db->where('Customer_ListID' . "='" . $l->list_id . "'", NULL, FALSE)->get('qb_invoice')->result();
            echo "|***  " . count($ivs) . " QB Invoices  \n<br/>";
            foreach ($ivs as $v)
            {
                $iits = $this->db->where('TxnID' . "='" . $v->TxnID . "'", NULL, FALSE)->count_all_results('qb_invoice_lineitem');
                echo "|******  " . $iits . " Invoice Items  \n<br/>";
                //$this->db->delete('qb_invoice_lineitem', array('TxnID' => $v->TxnID));
            }

            /* QB_invoice */
            //$this->db->delete('qb_invoice', array('Customer_ListID' => $l->list_id));

            /* fee_invoice_items */
            $qivs = $this->db->where($this->dx('reg_no') . '=' . $l->student_id, NULL, FALSE)->get('fee_invoice')->result();
            echo "|***  " . count($qivs) . " Fee Invoices  \n<br/>";
            foreach ($qivs as $qv)
            {
                $iits = $this->db->where($this->dx('invoice_id') . '=' . $qv->id, NULL, FALSE)->count_all_results('fee_invoice_items');
                echo "|******  " . $iits . " Invoice Items  \n<br/>";
                //$this->db->where($this->dx('invoice_id') . '=' . $qv->id, NULL, FALSE)->delete('fee_invoice_items');
            }

            /* Fee Invoice */
            //$this->db->where($this->dx('reg_no') . '=' . $l->student_id, NULL, FALSE)->delete('fee_invoice');
            echo " *********** End {$l->student_id} *********** \n<br/>---------------------------------\n<br/>\n<br/>";
        }
    }

    function get_lost()
    {
        return array();
    }

    /**
     * Save Invoice Items
     * 
     * @param type $data
     * @return type
     */
    function save_invoice_line($data)
    {
        $this->db->insert('qb_invoice_lineitem', $data);
        return $this->db->insert_id();
    }

    /**
     * Update Invoice
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    function update_ivs($id, $data)
    {
        return $this->db->where('TxnID', $id)->update('qb_invoice', $data);
    }

    function create_rec($data)
    {
        return $this->insert_key_data('fee_payment', $data);
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('quickbooks')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('quickbooks') > 0;
    }

    function count()
    {
        return $this->db->count_all_results('quickbooks');
    }

    function count_log()
    {
        return $this->db->count_all_results('quickbooks_log');
    }

    function count_students()
    {
        return $this->db->count_all_results('qb_customers');
    }

    function count_invoices()
    {
        return $this->db->count_all_results('qb_invoice');
    }

    function count_pays()
    {
        return $this->db->count_all_results('qb_payments');
    }

    function update_rec($id)
    {
        //return $this->update_key_data($id, 'qb_payments', array('seen' => 0));
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('quickbooks', $data);
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
        return $this->db->delete('quickbooks', array('id' => $id));
    }

    function rem_pay($id)
    {
        return $this->db->delete('qb_payments', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  quickbooks (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(255)  DEFAULT '' NOT NULL, 
	day  INT(11), 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('quickbooks', $limit, $offset);

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
     * Fetch Log
     * 
     * @param type $limit
     * @param type $page
     * @return boolean
     */
    function fetch_log($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('quickbooks_log_id', 'desc');
        $query = $this->db->get('quickbooks_log', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row)
        {
            $result[] = $row;
        }

        return $result;
    }

    function fetch_pays($limit, $page)
    {
        $offset = $limit * ( $page - 1);
        $this->select_all_key('qb_payments');
        return $this->db->order_by('id', 'DESC')->get('qb_payments', $limit, $offset)->result();
    }

    function fetch_students($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('FullName', 'asc');
        $query = $this->db->get('qb_customers', $limit, $offset);
        $result = array();

        foreach ($query->result() as $row)
        {
            $result[] = $row;
        }

        return $result;
    }

    /**
     * Fetch all Customers(Students) From temporary table
     * 
     * @return type
     */
    function fetch_qb_list()
    {
        return $this->db->where('seen !=', 1)->get('qb_customers')->result();
    }

    /**
     * Fetch all Customers(Students) Invoices
     * 
     * @return type
     */
    function fetch_invoice_list()
    {
        return $this->db->where('seen !=', 1)->get('qb_invoice')->result();
    }

    /**
     * Fetch all Customers(Students) Payments
     * 
     * @return type
     */
    function fetch_payments_list()
    {
        $this->select_all_key('qb_payments');
        return $this->db->where($this->dx('seen') . '!=1', NULL, FALSE)->get('qb_payments')->result();
    }

    /**
     * Fetch all New Customers(Students) 
     * 
     * @return type
     */
    function fetch_customer_list()
    {
        return $this->db->where('seen !=', 1)->get('qb_customers')->result();
    }

    function fetch_seen_customers()
    {
        return $this->db->where('seen', 1)->get('qb_customers')->result();
    }

    /**
     * Find Student by List Id
     *  
     * @param type $list_id
     * @return type
     */
    function get_regno($list_id)
    {
        $this->select_all_key('admission');
        return $this->db->where($this->dx('list_id') . "='" . $list_id . "'", NULL, FALSE)->get('admission')->row();
    }

    function get_st($id)
    {
        $this->select_all_key('admission');
        return $this->db->where('id', $id)->get('admission')->row();
    }

    function get_adm()
    {
        $this->select_all_key('admission');
        return $this->db->get('admission')->result();
    }

    function search_reg($list_id)
    {
        return $this->db->where('list_id', $list_id)->get('qb_customers')->result();
    }

    /**
     * Find Student by Email
     * 
     * @param type $email
     * @return type
     */
    function get_by_email($email)
    {
        $this->select_all_key('admission');
        return $this->db->where($this->dx('email') . "='" . $email . "'", NULL, FALSE)->get('admission')->row();
    }

    /**
     * Find Student by Admission No.
     * 
     * @param type $adm
     * @return type
     */
    function get_by_adm($adm)
    {
        $this->select_all_key('admission');
        return $this->db->where($this->dx('admission_number') . "='" . $adm . "'", NULL, FALSE)->get('admission')->row();
    }

    /**
     * Fetch Invoice Rows
     * 
     * @param type $tx_id
     * @return type
     */
    function get_invoice($tx_id)
    {
        return $this->db->where('TxnID', $tx_id)->get('qb_invoice')->result();
    }

    function get_invoice_lines($tx_id)
    {
        return $this->db->where('TxnID', $tx_id)->get('qb_invoice_lineitem')->result();
    }

    /**
     * Add Student
     * 
     * @param array $data
     * @return type
     */
    function add_student($data)
    {
        return $this->insert_key_data('admission', $data);
    }

    /**
     * put_imported_invoice
     * 
     * @param array $data
     * @return type
     */
    function put_imported_invoice($data)
    {
        return $this->insert_key_data('fee_invoice', $data);
    }

    /**
     * put_invoice_item
     * 
     * @param array $data
     * @return type
     */
    function put_invoice_item($data)
    {
        return $this->insert_key_data('fee_invoice_items', $data);
    }

    /**
     * Update student Record
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    function update_rw($id, $data)
    {
        return $this->update_key_data($id, 'admission', $data);
    }

    function update_rv($id, $data, $item)
    {
        return $this->db->where('item_id', $id)->where('item', $item)->update('reversals', $data);
    }

    function update_pay($id, $data)
    {
        return $this->update_key_data($id, 'qb_payments', $data);
    }

    function fxlist($id, $data)
    {
        return $this->db->where('id', $id)->update('qb_customers', $data);
        //  return $this->update_key_data($id, 'admission', $data);
    }

    /**
     * Set Seen Status
     * 
     * @param int $id
     * @param int $tbl
     * @param int $data
     * @param boolean $enc
     * @return void
     */
    function set_seen($id, $tbl, $data, $enc = TRUE)
    {
        if ($enc)
        {
            return $this->update_key_data($id, $tbl, $data);
        }
        else
        {
            return $this->db->where('id', $id)->update($tbl, $data);
        }
    }

    /**
     * Set Student List ID from Quickbooks
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    function link_student($id, $data)
    {
        return $this->update_key_data($id, 'admission', $data);
    }

    function link_raw($id, $data)
    {
        return $this->update_key_str($id, 'admission', $data);
    }

    /**
     * Fetch All payments by this student
     * 
     * @param type $id
     * @return type'
     */
    function get_receipts($id)
    {
        $this->select_all_key('fee_payment');
        return $this->db->where($this->dx('reg_no') . ' =' . $id, NULL, FALSE)
                                            ->where($this->dx('status') . ' = 1', NULL, FALSE)
                                            ->get('fee_payment')->result();
    }

    /**
     * Fetch Student Invoices
     * 
     * @param int $id Student ID
     */
    function get_std_invoices($id)
    {
        $this->select_all_key('fee_invoice');
        return $this->db->where($this->dx('reg_no') . "='" . $id . "'", NULL, FALSE)
                                            ->get('fee_invoice')->result();
    }

    /**
     * get_invoice_items
     * 
     * @param type $id
     * @return type
     */
    function get_invoice_items($id)
    {
        $ref = '';
        $ivo = $this->db->select($this->dxa('refno'), FALSE)->where('id', $id)->get('fee_invoice')->row();
        if (isset($ivo) && !empty($ivo->refno))
        {
            $ref = $ivo->refno;
        }
        $this->select_all_key('fee_invoice_items');
        $rows = $this->db->where($this->dx('invoice_id') . "='" . $id . "'", NULL, FALSE)
                                            ->get('fee_invoice_items')->result();

        foreach ($rows as $row)
        {
            $row->invoice = $ref;
        }
        return $rows;
    }

    /**
     * Get Arrears For Student
     * 
     * @param type $student
     * @return type
     */
    function get_arrears($student)
    {
        $this->select_all_key('fee_arrears');
        $arrs = $this->db->select('sum(' . $this->dx('amount') . ') as sum', FALSE)->where($this->dx('student') . ' =' . $student, NULL, FALSE)
                                            ->get('fee_arrears')
                                            ->row()->sum;
        return $arrs;
    }

    function total_arrears()
    {
        $this->select_all_key('fee_arrears');
        $arrs = $this->db->select('sum(' . $this->dx('amount') . ') as sum', FALSE)
                                            ->get('fee_arrears')
                                            ->row()->sum;
        return $arrs;
    }

    /**
     * Get Pending amount
     * 
     * @return type
     */
    function count_pending_paid()
    {
        return $this->db->select('sum(' . $this->dx('amount') . ') as sum', FALSE)
                                            ->where($this->dx('seen') . '!=1', NULL, FALSE)
                                            ->get('qb_payments')
                                            ->row()->sum;
    }

    function get_students_pending($limit)
    {
        $this->select_all_key('admission');
        return $this->db->where("( " . $this->dx('qb_status') . '=0 OR  ' . $this->dx('qb_status') . ' IS NULL) ', NULL, FALSE)
                                            ->where($this->dx('status') . '=1', NULL, FALSE)
                                            ->limit($limit)
                                            ->get('admission')
                                            ->result();
    }

    function get_tuition_pending($limit)
    {
        return $this->db->where('( qb_status=0 OR qb_status IS NULL ) ', NULL, FALSE)
                                            ->where('check_st', 1)
                                            ->limit($limit)
                                            ->get('invoices')
                                            ->result();
    }

    function get_extras_pending($limit)
    {
        $this->select_all_key('fee_extra_specs');
        return $this->db->where("( " . $this->dx('qb_status') . '=0 OR  ' . $this->dx('qb_status') . ' IS NULL ) ', NULL, FALSE)
                                            ->where($this->dx('status') . '=1', NULL, FALSE)
                                            ->limit($limit)
                                            ->get('fee_extra_specs')
                                            ->result();
    }

    function get_payments_pending($limit)
    {
        $this->select_all_key('fee_payment');
        return $this->db->where("( " . $this->dx('qb_status') . '=0 OR  ' . $this->dx('qb_status') . ' IS NULL ) ', NULL, FALSE)
                                            ->where($this->dx('status') . '=1', NULL, FALSE)
                                            ->limit($limit)
                                            ->get('fee_payment')
                                            ->result();
    }

    function count_p_invoices()
    {
        return $this->db->where('( qb_status= 0 OR qb_status IS NULL) ', NULL, FALSE)->where('check_st ', 1)->count_all_results('invoices');
    }

    function count_p_by($table, $enc = false)
    {
        return $enc ?
                          $this->db->where("( " . $this->dx('qb_status') . '=0 OR  ' . $this->dx('qb_status') . ' IS NULL ) ', NULL, FALSE)->where($this->dx('status') . '=1', NULL, FALSE)->count_all_results($table) :
                          $this->db->where('( qb_status= 0 OR qb_status IS NULL) ', NULL, FALSE)->count_all_results($table);
    }

    function count_voided_pay()
    {
        return $this->db->where($this->dx('status') . '=0', NULL, FALSE)
                                            ->where($this->dx('f_status') . '=1', NULL, FALSE)
                                            ->where($this->dx('qb_status') . '=3', NULL, FALSE)
                                            ->where("( " . $this->dx('flagged') . '=0 OR  ' . $this->dx('flagged') . ' IS NULL ) ', NULL, FALSE)
                                            ->count_all_results('fee_payment');
    }

    function count_reverse_invoices()
    {
        return $this->db->where('qb_status', 3)->where('f_status', 1)->count_all_results('invoices');
    }

    function getvoid()
    {
        $ls = $this->db->where('item', 'Payment')->where('description', 'Voided')->get('reversals')->result();
        return $ls;
    }

    function count_reverse_extras()
    {
        return $this->db->where($this->dx('qb_status') . '=3', NULL, FALSE)->where($this->dx('f_status') . '=1', NULL, FALSE)->count_all_results('fee_extra_specs');
    }

    function count_reverse_pay()
    {
        return $this->db->where($this->dx('flagged') . '=1', NULL, FALSE)
                                            ->where($this->dx('f_status') . '=1', NULL, FALSE)
                                            ->where($this->dx('status') . '=3', NULL, FALSE)
                                            ->where($this->dx('qb_status') . '=3', NULL, FALSE)
                                            ->count_all_results('fee_payment');
    }

    function get_voided_pay($limit)
    {
        $this->select_all_key('fee_payment');
        return $this->db->where($this->dx('status') . '=0', NULL, FALSE)
                                            ->where($this->dx('f_status') . '=1', NULL, FALSE)
                                            ->where("( " . $this->dx('flagged') . '=0 OR  ' . $this->dx('flagged') . ' IS NULL ) ', NULL, FALSE)
                                            ->where("( " . $this->dx('qb_status') . '=3) ', NULL, FALSE)
                                            ->limit($limit)
                                            ->get('fee_payment')
                                            ->result();
    }

    function get_flagged_pay($limit)
    {
        $this->select_all_key('fee_payment');
        return $this->db->where("( " . $this->dx('flagged') . '=1) ', NULL, FALSE)
                                            ->where($this->dx('f_status') . '=1', NULL, FALSE)
                                            ->where($this->dx('status') . '=3', NULL, FALSE)
                                            ->where("( " . $this->dx('qb_status') . '=3) ', NULL, FALSE)
                                            ->limit($limit)
                                            ->get('fee_payment')
                                            ->result();
    }

    function get_flagged_extras($limit)
    {
        $this->select_all_key('fee_extra_specs');
        return $this->db->where("( " . $this->dx('flagged') . '=1) ', NULL, FALSE)
                                            ->where($this->dx('f_status') . '=1', NULL, FALSE)
                                            ->where($this->dx('status') . '=2', NULL, FALSE)
                                            ->where($this->dx('qb_status') . '=3', NULL, FALSE)
                                            ->limit($limit)
                                            ->get('fee_extra_specs')
                                            ->result();
    }

    function get_flagged_invoices($limit)
    {
        return $this->db->where('flagged', 1)
                                            ->where('f_status', 1)
                                            ->where('check_st', 4)
                                            ->where('qb_status', 3)
                                            ->limit($limit)
                                            ->get('invoices')
                                            ->result();
    }

    function get_all_payments($limit)
    {
        $this->select_all_key('fee_payment');
        return $this->db->where($this->dx('status') . '=1', NULL, FALSE)
                                            ->limit($limit)
                                            ->get('fee_payment')
                                            ->result();
    }

    function get_ops_max()
    {
        $this->select_all_key('ops');
        return $this->db->order_by('id', 'DESC')
                                            ->limit(1)
                                            ->get('ops')
                                            ->row();
    }

    /**
     * Check if a balance entry exists for sudent
     * 
     * @param type $student
     * @return type
     */
    function bal_exists($student)
    {
        return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            // ->where($this->dx('campus_id') . '=' . $this->campus->id, NULL, FALSE)
                                            ->count_all_results('new_balances') > 0;
    }

    function get_bal($student)
    {
        $this->select_all_key('new_balances');
        return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            ->get('new_balances')
                                            ->row();
    }

    /**
     * Check if a Bal entry exists for student , term & Year
     * @param type $student
     * @param type $term
     * @param type $year
     * @return type
     */
    function term_bal_exists($student, $term, $year)
    {
        return $this->db->where($this->dx('student') . "='" . $student . "'", NULL, FALSE)
                                            ->where($this->dx('term') . "='" . $term . "'", NULL, FALSE)
                                            ->where($this->dx('year') . "='" . $year . "'", NULL, FALSE)
                                            ->count_all_results('keep_balances');
    }

    /**
     * Update Term balance entry
     * 
     * @param int $id
     * @param array $data
     * @return boolean
     */
    function update_term_balance($student, $term, $year, $data)
    {
        $where = $this->dx('student') . ' = ' . $student . ' AND  ' . $this->dx('term') . ' = ' . $term . ' AND  ' . $this->dx('year') . ' = ' . $year;
        return $this->update_key_where($where, 'keep_balances', $data);
    }

    function fx_arrear($id, $amount)
    {
        return $this->update_key_data($id, 'fee_arrears', array('amount' => $amount));
    }

    /**
     * Insert new Term Balance entry
     * 
     * @param array $data
     * @return boolean
     */
    function keep_term_balance($data)
    {
        return $this->insert_key_data('keep_balances', $data);
    }

    /**
     * Insert new Balance entry
     * 
     * @param array $data
     * @return boolean
     */
    function put_balances($data)
    {
        return $this->insert_key_data('new_balances', $data);
    }

    /**
     * Update balance entry
     * 
     * @param int $id
     * @param array $data
     * @return boolean
     */
    function update_balances($id, $data)
    {
        return $this->update_key_where($this->dx('student') . ' = ' . $id, 'new_balances', $data);
    }

    //Insert receipt
    function insert_rec($data)
    {
        $this->db->insert('fee_receipt', $data);
        return $this->db->insert_id();
    }

    function insert_s($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function create($data)
    {
        return $this->insert_key_data('fee_payment', $data);
    }

    function get_list_id($name)
    {
        return $this->db->select('list_id')->where('full_name', $name)->get('qb_customers')->row()->list_id;
    }

    /**
     * Datatable Server Side Data Fetcher For Students QB
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('qb_customers');

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
                    $this->db->order_by('qb_customers' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
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
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like('qb_customers.' . $aColumns[$i], $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $rResult = $this->db->order_by('full_name', 'asc')->get('qb_customers');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all_results('qb_customers');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal, // $iFilteredTotal,
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

            $aaData[] = array(
                $iCol->id,
                $iCol->full_name . ' ~ ' . $iCol->id,
                $iCol->list_id,
                $iCol->acc_no ? $iCol->acc_no : '',
                number_format($iCol->balance, 2),
                $iCol->seen ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>',
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Datatable Server Side Data Fetcher For Students QB
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_payments($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('qb_payments');

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
                    $this->db->order_by('qb_payments' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
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
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like($this->dx('qb_payments.' . $aColumns[$i]), $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->select_all_key('qb_payments');
        $rResult = $this->db->order_by('seen', 'asc')->order_by('payment_date', 'desc')->get('qb_payments');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all_results('qb_payments');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal, // $iFilteredTotal,
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
            $st = $this->worker->get_student($iCol->reg_no, TRUE);
            $aaData[] = array(
                $iCol->id,
                $st->first_name . ' ' . $st->last_name,
                $iCol->payment_date,
                $iCol->reg_no,
                number_format($iCol->amount, 2),
                $iCol->seen ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>',
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Datatable Server Side Data Fetcher For QB invoices
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_qb_invoices($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
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
                    $this->db->order_by('fee_invoice' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
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
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like($this->dx('fee_invoice.' . $aColumns[$i]), $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->select_all_key('fee_invoice');
        $rResult = $this->db->order_by('id', 'desc')->get('fee_invoice');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all_results('fee_invoice');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal, // $iFilteredTotal,
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
            $st = $this->worker->get_student($iCol->reg_no, 0);
            $aaData[] = array(
                $iCol->id,
                $st->first_name . ' ' . $st->last_name,
                $iCol->txn_id,
                number_format($iCol->amount, 2),
                $iCol->reg_no,
                $iCol->created_on > 10000 ? date('d M Y', $iCol->created_on) : '',
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Datatable Server Side Data Fetcher For QB Invoices
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_invoices($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('qb_invoice');

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
                    $this->db->order_by('qb_invoice' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
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
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like('qb_invoice.' . $aColumns[$i], $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $rResult = $this->db->order_by('seen', 'asc')->order_by('id', 'asc')->get('qb_invoice');

        // Data set length after filtering
        $rc = $this->db->select('FOUND_ROWS() AS found_rows ')->get()->row();
        $iFilteredTotal = $rc->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all_results('qb_invoice');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal, // $iFilteredTotal,
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
            $st = $this->worker->get_student($iCol->Customer_ListID, TRUE);
            $aaData[] = array(
                $iCol->id,
                $st->first_name . ' ' . $st->last_name,
                $iCol->Customer_FullName,
                $iCol->Customer_ListID . ' <span class="label label-info">' . $iCol->TxnID . '</span>',
                number_format($iCol->amount, 2),
                $iCol->seen ? '<span class="label label-success">Yes</span>' : '<span class="label label-warning">No</span>',
            );
        }
        $output['aaData'] = $aaData;

        return $output;
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
    function get_unlinked_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('admission');

        if (isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

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
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like('CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('admission');
        $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname,' . $this->dx('parents.email') . ' as parent_email,' . $this->dx('parents.address') . ' as address,' . $this->dx('parents.phone') . ' as phone,', FALSE);
        $this->db->join('parents', 'parents.id= ' . $this->dx('parent_id'));
        $this->db->order_by('admission.id', 'desc');
        $this->db->where(' length(list_id) = 0', NULL, FALSE);
        $rResult = $this->db->get('admission');

        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        $iTotal = $this->db->where(' length(list_id) = 0', NULL, FALSE)
                          ->count_all_results('admission');

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
            $crow = $this->fetch_class($iCol->class);
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
            $status = '';
            if ($iCol->status == 3)
            {
                $status = '<span class="label label-info">Alumni</span>';
            }
            else if ($iCol->status == 1)
            {
                $status = '<span class = "label label-success">Yes</span>';
            }
            else
            {
                $status = '<span class = "label label-warning">No</span>';
            }
            $aaData[] = array(
                $iCol->id,
                ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name),
                $sft . ' ' . $st,
                $adm,
                $iCol->parent_fname . ' ' . $iCol->parent_lname,
                $status,
                $iCol->address,
                ''
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Fetch Class Row by ID
     * 
     * @class  int $id
     * @return object
     */
    function fetch_class($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    function get_debs_list($student)
    {
        return $this->db->where('student_id', $student)
                                            ->where('check_st =', 1)
                                            ->where('qb_status =', 0)
                                            ->get('invoices')
                                            ->result();
    }

    function get_fee_extras($student)
    {
        $this->select_all_key('fee_extra_specs');
        return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            ->where($this->dx('qb_status') . '=0', NULL, FALSE)
                                            ->get('fee_extra_specs')
                                            ->result();
    }

}
