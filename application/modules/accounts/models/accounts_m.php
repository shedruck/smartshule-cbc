<?php
class Accounts_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        return $this->insert_key_data('accounts', $data);
    }

    function find($id)
    {
        $this->select_all_key('accounts');
        return $this->db->where(array('id' => $id))->get('accounts')->row();
    }

    /*     * **
     * **Get account details by account code
     * * */

    function get_by_code($id)
    {
        $this->select_all_key('accounts');
        return $this->db->where($this->dx('code') . '=' . $id, NULL, FALSE)->get('accounts')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('accounts') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('accounts');
    }

    function update_attributes($id, $data)
    {
        return $this->update_key_data($id, 'accounts', $data);
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

    function populate_enc($table, $option_val, $option_text)
    {
        $this->select_all_key('accounts');
        $query = $this->db->select($option_val . ',' . $this->dxa($option_text), FALSE)->order_by($this->dx($option_text), 'ASC', FALSE)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown) {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
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
        $aColumns = $this->db->list_fields('accounts');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        // Ordering
        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true') {
                    $this->db->_protect_identifiers = FALSE;
                    $this->db->order_by($this->dx('accounts.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
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
        if (isset($sSearch) && !empty($sSearch)) {
            for ($i = 0; $i < count($aColumns); $i++) {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true') {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like('CONVERT(' . $this->dx('accounts.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->select_all_key('accounts');
        $this->db->order_by($this->dx('accounts.code'), 'ASC', FALSE);
        $rResult = $this->db->get('accounts');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all('accounts');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        $aaData = array();
        $obData = array();
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $Key => $Value) {
                if ($Key && $Key !== ' ') {
                    $row[$Key] = $Value;
                }
            }
            $obData[] = $row;
        }
        $types = $this->populate('account_types', 'id', 'name');

        $taxes = $this->populate('tax_config', 'id', 'name');
        foreach ($obData as $iCol) {
            $iCol = (object) $iCol;
            $act = isset($types[$iCol->account_type]) ? $types[$iCol->account_type] : '';
            $taxx = isset($taxes[$iCol->tax]) ? $taxes[$iCol->tax] : '';
            $aaData[] = array(
                $iCol->id,
                $iCol->code,
                $iCol->name,
                $act,
                $taxx,
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Fetch Chart of Accounts For PNL
     * 
     * @return array
     */
    function get_pnl()
    {
        $this->select_all_key('accounts');
        $this->db
           ->where($this->dx('code') . '< 600', NULL, FALSE)
            ->order_by($this->dx('code'), 'ASC', FALSE);
        // $this->db->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();

        $accs = array();
        foreach ($result as $r) {
            if (TRUE) //$r->account_type && $r->balance)
            {
                $code = $this->worker->get_account_group($r->code);

                $accs[$code][] = array('id' => $r->id,'account' => $r->name, 'code' => $r->code, 'balance' => $r->balance , 'cr' => $r->cr);
            }
        }
        $sorter = array('Revenue', 'Expenses');

        $fn = sort_by_array($accs, $sorter);

        return $fn;
    }

    

    /**
     * Fetch Chart of Accounts For Trial Balance
     * 
     * @return array
     */
    function get_accounts()
    {
        $this->select_all_key('accounts');
        $this->db->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();

        $accs = array();

        foreach ($result as $r) {
            if (TRUE) //$r->account_type && $r->balance)
            {
                // if ($r->code < 400 || (($r->code > 799) || ($r->code > 799))) {
                //     $side = 1; //cr
                // } else {
                //     $side = 0;
                // }
                // if($r->code ==399){ //forcing dicounts and waivers to be on the dr side of income
                //     $side = 0;
                // }
                $code = $this->worker->get_account_group($r->code);

                $accs[$code][] = array('id' => $r->id,'account' => $r->name, 'code' => $r->code, 'balance' => $r->balance, 'dr' => $r->dr, 'cr' => $r->cr);
            }
        }
        $sorter = array('Revenue', 'Expenses', 'Assets', 'Liabilities', 'Equity');

        $fn = sort_by_array($accs, $sorter);

        return $fn;
    }

    /**
     * Fetch Chart of Accounts For  Balance Sheet
     * 
     * @return array
     */
    function get_balance_sheet()
    {
        $this->select_all_key('accounts');
        $this->db->where($this->dx('code') . '> 599', NULL, FALSE)
            ->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();

        $accs = array();

        $cats = $this->populate('account_types', 'id', 'name');
        foreach ($result as $r) {
            if (TRUE) //$r->account_type && $r->balance)
            {
                $code = $this->worker->get_account_group($r->code);
                $ttl = isset($cats[$r->account_type]) ? $cats[$r->account_type] : 'Others';
                $accs[$code][$ttl][] = array('account' => $r->name, 'code' => $r->code, 'balance' => $r->balance,'dr'=>$r->dr,'id' =>$r->id);
            }
        }
        $sorter = array('Assets', 'Liabilities', 'Equity');
        $fn = sort_by_array($accs, $sorter);

        return $fn;
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  accounts (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	code  varchar(256)  DEFAULT '' NOT NULL, 
	account_type  INT(9) NOT NULL, 
	tax  INT(9) NOT NULL, 
	balance  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ($page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('accounts', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    function test_pnl()
    {
        $this->select_all_key('accounts');
        $this->db
        // ->where($this->dx('code') . '<600', NULL, FALSE)
        // ->where($this->dx('code') . '>300', NULL, FALSE)
        ->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();
        return $result;
    }

    function get_expense_category($account)
    {
        return $this->db->where(array('account' => $account))->get('expenses_category')->result();
    }

    function expense_cats(){
        $list = $this->db->get('expenses_category')->result();
        $cats = [];
        foreach($list as $l){
            $cats[$l->account] = $l->id;
        }
        return $cats;
    }

    function accs(){
        $this->select_all_key('accounts');
        $this->db->order_by($this->dx('id'), 'desc', FALSE);
        $result = $this->db->get('accounts')->result();
        return $result;
    }

    function expenses_Total($id){
        $result = $this->db
                ->select('sum (amount) as total')
                ->where(array('category' => $id))
                ->get('expenses')
                ->result();
                return $result;
    }

    function get_expenses($id, $from=0, $to=0){

        if (($from && $to) && $from == $to)
        {
            $this->db->where("expense_date = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('expense_date >= ',$from);
            }
            if ($to)
            {
                $this->db->where('expense_date <= ',$to);
            }
        }

        $total =  $this->db->select('sum(amount) as total, category')->where(array('category' => $id))->get('expenses')->result();
        $sum = [];
        foreach($total as $t){
            $sum[$t->category] = $t->total;
        }
        return $sum;
    }

    function expenze($id, $from=0, $to=0){
        if (($from && $to) && $from == $to)
        {
            $this->db->where("expense_date = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('expense_date >= ',$from);
            }
            if ($to)
            {
                $this->db->where('expense_date <= ',$to);
            }
        }
        $qr = $this->db->where('category',$id)->get('expenses')->result();
        return $qr;
    }

     

    function acc_cat(){
        $list = $this->db->get('expenses_category')->result();
        $acc = [];
        foreach($list as $l){
            $acc[$l->account] =$l->id;
        }
        return $acc;
    }

    

    function get_fee_payments($code){
        $this->select_all_key('fee_payment');
        
        if($code == 200){
            $this->db->where($this->dx('description') . '=0', NULL, FALSE);
        }else{
            $this->db->where($this->dx('description') . '>=1', NULL, FALSE);
        }
        $this->db->order_by($this->dx('created_on'), 'DESC', FALSE);
        $result = $this->db->get('fee_payment')->result();
        return $result;
    }

    function get_tuition_invoices($from = 0, $to = 0){

        if (($from && $to) && $from == $to)
        {
            $this->db->where("created_on = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('created_on >= ',$from);
            }
            if ($to)
            {
                $this->db->where('created_on <= ',$to);
            }
        }

        $qr =  $this->db->where('check_st',1)->order_by('id','DESC')->get('invoices')->result();

        return $qr;
    }

    function t_tuition_invoices($from = 0, $to = 0){
        if (($from && $to) && $from == $to)
        {
            $this->db->where("created_on = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('created_on >= ',$from);
            }
            if ($to)
            {
                $this->db->where('created_on <= ',$to);
            }
        }
        $total =  $this->db->select('SUM(amount) AS total')
                ->where('check_st',1)
                ->get('invoices')->row();
            return $total;
    }

    function t_supplier_invoices($from = 0, $to = 0){
        if (($from && $to) && $from == $to)
        {
            $this->db->where("created_on = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('created_on >= ',$from);
            }
            if ($to)
            {
                $this->db->where('created_on <= ',$to);
            }
        }
        $total =  $this->db->select('SUM(total) AS total')
                ->where('status',1)
                ->get('supplier_invoices')->row();
            return $total;
    }

    function acc_receivable($from=0, $to=0){
        // $this->select_all_key('fee_payment');
        if (($from && $to) && $from == $to)
        {
            $this->db->where($this->dx('payment_date') .'='. $from, NULL, FALSE);
        }
        else
        {
            if ($from)
            {
                $this->db->where($this->dx('payment_date') .'>='. $from, NULL, FALSE);
            }
            if ($to)
            {
                $this->db->where($this->dx('payment_date') .'<='. $to, NULL, FALSE);
            }
        }

        return $this->db
                    ->select('sum(' . $this->dx('amount') . ') as total', FALSE)
                    ->get('fee_payment')
                    ->row();
    }

    function other_revenue($from, $to){

        if (($from && $to) && $from == $to)
        {
            $this->db->where($this->dx('created_on') .'='. $from, NULL, FALSE);
        }
        else
        {
            if ($from)
            {
                $this->db->where($this->dx('created_on') .'>='. $from, NULL, FALSE);
            }
            if ($to)
            {
                $this->db->where($this->dx('created_on') .'<='. $to, NULL, FALSE);
            }
        }
        $total =  $this->db->select('sum(' . $this->dx('amount') . ') as total', FALSE)
                ->get('fee_extra_specs')->row();
        return $total;
    }

    function expenses(){
        // $total = $this->select()
    }

    function all_fee_p($from = 0, $to =0){
        $this->select_all_key('fee_payment');
        if (($from && $to) && $from == $to)
        {
            $this->db->where($this->dx('payment_date') .'='. $from, NULL, FALSE);
        }
        else
        {
            if ($from)
            {
                $this->db->where($this->dx('payment_date') .'>='. $from, NULL, FALSE);
            }
            if ($to)
            {
                $this->db->where($this->dx('payment_date') .'<='. $to, NULL, FALSE);
            }
        }

        return $this->db->get('fee_payment')->result();
    }

    function get_extra_invoices( $from = 0, $to =0)
    {

        $this->select_all_key('fee_extra_specs');
        
        if (($from && $to) && $from == $to)
        {
            $this->db->where($this->dx('created_on') .'='. $from, NULL, FALSE);
        }
        else
        {
            if ($from)
            {
                $this->db->where($this->dx('created_on') .'>='. $from, NULL, FALSE);
            }
            if ($to)
            {
                $this->db->where($this->dx('created_on') .'<='. $to, NULL, FALSE);
            }
        }

        return $this->db    
                ->order_by('id','DESC')
                ->get('fee_extra_specs')
                ->result();
    }

    function get_waivers(){
        return $this->db->order_by('created_on','DESC')->get('fee_waivers')->result();
    }

    function get_expenses_($from = 0, $to = 0){
        if (($from && $to) && $from == $to)
        {
            $this->db->where("expense_date = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('expense_date >= ',$from);
            }
            if ($to)
            {
                $this->db->where('expense_date <= ',$to);
            }
        }
        
        $result = $this->db->order_by('created_on','DESC')->get('expenses')->result();
        return $result;
    }

    function expense_item(){
        $list =  $this->db->order_by('created_on','DESC')->get('expense_items')->result();
        $item = [];
        foreach($list as $l){
            $item[$l->id] = $l->name;
        }
        return $item;
    }

    function get_invetory($from = 0, $to = 0){
        if (($from && $to) && $from == $to)
        {
            $this->db->where("day = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('day >= ',$from);
            }
            if ($to)
            {
                $this->db->where('day <= ',$to);
            }
        }

        return $this->db->order_by('created_on','DESC')->get('add_stock')->result();
    }

    function inventory_item(){
        $list =  $this->db->order_by('created_on','DESC')->get('items')->result();
        $items = [];
        foreach($list as $l){
            $items[$l->id] = $l->item_name;
        }
        return $items;
    }

    function bank_balance($id)
    {
        $list = $this->db->where('id', $id)->get('bank_accounts')->row();

        $result = $list->balance;
        return $result;
    }

    function bank_transactions($data)
    {
        $this->db->insert('bank_transactions', $data);
        return $this->db->insert_id();
    }

    function save_reconciliation($data)
    {
        $this->db->insert('bank_reconciliations', $data);
        return $this->db->insert_id();
    }

    function update_bank_balance($id, $data)
    {
        return $this->db->where('id', $id)->update('bank_accounts', $data);
    }

    function get_renconciliations()
    {
        return $this->db->get('bank_reconciliations')->result();
    }


    function gen_cashbook($from, $to, $bank)
    {

        //expenses
        if (($from && $to) && ($from == $to))
        {
            $this->db->where("expense_date = $from");
        }
        else
        {
            if ($from)
            {
                $this->db->where('expense_date >= ',$from);
            }
            if ($to)
            {
                $this->db->where('expense_date <= ',$to);
            }

            if($bank)
            {
                $this->db->where('bank_id', $bank);
            }
        }

        $exp =  $this->db->order_by('expense_date','ASC')->where('status',1)->get('expenses')->result();

        $expenses = [];

        foreach($exp as $ex)
        {
            $expenses[] = [
                'storeID' => $ex->id,
                'category' => 'Expenses',
                'bank_id' => $ex->bank_id,
                'transaction' => 'Expenses',
                'date' => $ex->expense_date,
                'dr' => $ex->amount,
                'cr' => 0,
                'created_by' => $ex->created_by
            ];
        }



        //fee_payments

        $this->select_all_key('fee_payment');
        if (($from && $to) && ($from == $to))
        {
            $this->db->where($this->dx('payment_date') .'='. $from, NULL, FALSE);
        }
        else
        {
            if ($from)
            {
                $this->db->where($this->dx('payment_date') .'>='. $from, NULL, FALSE);
            }
            if ($to)
            {
                $this->db->where($this->dx('payment_date') .'<='. $to, NULL, FALSE);
            }

            if($bank)
            {
                $this->db->where($this->dx('bank_id') .'<='. $bank, NULL, FALSE);
            }
        }

        $pay =  $this->db->order_by($this->dx('payment_date') .'ASC', NULL, FALSE)->where($this->dx('status') .'= 1', NULL, FALSE)->get('fee_payment')->result();

        $payments = [];
        foreach($pay as $p)
        {
            $students =  $this->worker->get_student($p->reg_no);
            $adm = $students->admission_number ? $students->admission_number : $student->old_adm_no;
            $student = strtoupper('['.$adm.'] '.$students->first_name.' '.$students->middle_name.' '.$students->last_name);
            $payments[] = [
                'storeID' => $p->id,
                'category' => 'Fee',
                'bank_id' => $p->bank_id,
                'transaction' => 'School Fee Payment for '. $student,
                'date' => $p->payment_date,
                'dr' => 0,
                'cr' => $p->amount,
                'created_by' => $p->created_by
            ];
        }


        return $payments + $expenses;


    }
}
