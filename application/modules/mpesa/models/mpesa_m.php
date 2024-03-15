<?php
class Mpesa_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($table,$data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('c2b')->row();
    }


    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('mpesa') > 0;
    }


    function count()
    {

        return $this->db->count_all_results('mpesa');
    }

    function update_attributes($table, $id, $data)
    {
        return  $this->db->where('id', $id)->update($table, $data);
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

    function delete($id)
    {
        return $this->db->delete('mpesa', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  mpesa (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
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
        $query = $this->db->get('mpesa', $limit, $offset);

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

    function loadPaymentLogs($postData = null)
    {
        $response = [];

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery .= "`txid` LIKE '%" . $searchValue . "%' 
            OR `reg_no` LIKE '%" . $searchValue . "%' 
            OR `first_name` LIKE '%" . $searchValue . "%' 
            ";
        }


        ## Total number of records without filtering

        $this->db->select('count(*) as allcount');
        $records = $this->db
            ->where('seen', 0)
            ->get('c2b')->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering

        $this->db->select('count(*) as allcount');
        if ($searchQuery) {
            $this->db->where($searchQuery);
        }
        $records = $this->db
            ->where('seen', 0)
            ->get('c2b')->result();
        $totalRecordwithFilter = $records[0]->allcount;


        ## Fetch records

        $this->db->select('*');
        if ($searchQuery) {
            $this->db->where($searchQuery);
        }

        $this->db->order_by('id', 'DESC');

        $this->db->limit($rowperpage, $start);


        $records = $this->db
            ->where('seen', 0)
            ->get('c2b')
            ->result();

        $data = [];

        $st = [2 => '<span class="label label-warning">Pending</span>', 1 => '<span class="label label-success">Processed</span>', 3 => '<span class="label label-info">Frozen</span>'];

        $index = 1;
        $check = '';

         

        foreach ($records as $p) 
        {
            $date = $this->ConvertDate($p->timestamp);

            if ($p->seen == 0) 
            {
                $check = '<button class="btn btn-primary"  data-toggle="modal" data-target="#processs" onclick="process_payments('.$p->id.')">Process</button>';
            } 
            else 
            {
                $check = '';
            }




            // $selectHtml = $this->students();
            $data[] = array(
                'index' => $index,
                "transaction_date" => $date,
                'transaction_no' => $p->txid,
                'phone' => $p->phone,
                'by' => $p->first_name,
                'reg_no' => $p->reg_no,
                'amount' => number_format($p->amount, 2),
                'check' =>  $check,
                // 'dropdwn' => $this->students()
            );
            $index++;
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
    }


    function convertDate($date)
    {
        $timestamp = strtotime($date);
        $formattedDate = date('dS M, Y H:i a', $timestamp);
        return $formattedDate;
    }

    function students()
    {
        $sel = '<select class="select2">
            <option value=""></option>
        ';
        $studs = $this->ion_auth->students_full_details();
        foreach ($studs as $k => $val) {
            $sel .= '<option value="' . $k . '">' . $val . '</option>';
        }
        $sel .= '</select>';

        return $sel;

    //    return json_encode(['select_html' => $sel]);
    }


    function get_invoices($student, $term, $year)
    {

        $paid = $this->get_paid($student, $term, $year);
        $payload = [];
        $tuition = $this->db
            ->where('term', $term)
            ->where('year', $year)
            ->where('student_id', $student)
            ->where('check_st', 1)
            ->get('invoices')
            ->result();

        $tt = [];
        foreach ($tuition as $t) {
            $pd = isset($paid[0]) ? $paid[0] : 0;
            $bal = $t->amount - $pd;
            if ($bal < 1) {
                continue;
            }
            $payload[] = [
                'f_id' => 0,
                'amount' => $t->amount,
                'type' => 'Tuition',
                'id' => 0,
                'transport' => false,
                'balance' =>  $bal
            ];
        }

        $this->select_all_key('fee_extra_specs');
        $extras = $this->db
            ->where($this->dx('term') . "=" . $term, NULL, FALSE)
            ->where($this->dx('year') . "=" . $year, NULL, FALSE)
            ->where($this->dx('student') . "=" . $student, NULL, FALSE)
            ->get('fee_extra_specs')
            ->result();
        $xtras = [];
        foreach ($extras as $ex) {
            $rw = $this->find_extra($ex->fee_id);
            // $tr = ($rw->transport == 1) ? TRUE : FALSE;

            $pd = isset($paid[$ex->fee_id]) ? $paid[$ex->fee_id] : 0;
            $bal = $ex->amount - $pd;
            if ($bal < 1) {
                continue;
            }
            $payload[] = [
                'f_id' => $ex->fee_id,
                'amount' => $ex->amount,
                'type' => 'Extras',
                'id' => $ex->fee_id,
                'transport' => FALSE,
                'balance' =>  $bal
            ];
        }



        $trans = $this->db
            ->where('term', $term)
            ->where('year', $year)
            ->where('student', $student)
            ->where('status', 1)
            ->get('transport')
            ->result();
        foreach ($trans as $tx) {
            $id = $this->get_transport_head($tx->route, $tx->way);

            $pd = isset($paid[$id]) ? $paid[$id] : 0;
            $bal = $tx->amount - $pd;
            if ($bal < 1) {
                continue;
            }

            $payload[] = [
                'f_id' => '8888-' . $tx->id,
                'amount' => $tx->amount,
                'type' => 'Transport',
                'id' => $id,
                'transport' => true,
                'balance' =>  $bal
            ];
        }

        /**Sales invoice */
        $this->select_all_key('sales_invoices');
        $this->db->where($this->dx('term') . "=" . $term, NULL, FALSE)
            ->where($this->dx('year') . "=" . $year, NULL, FALSE)
            ->where($this->dx('student') . "=" . $student, NULL, FALSE)
            ->where($this->dx('status') . "=1", NULL, FALSE);
        $uniforms = $this->db->get('sales_invoices')->result();

        $un = [];
        foreach ($uniforms as $pk) {
            $un[$pk->student][] = $pk->amount;
        }


        foreach ($un as $st => $amt) {
            $amtt = array_sum($amt);
            $pd = isset($paid[9090]) ? $paid[9090] : 0;
            $bal = $amtt - $pd;
            $payload[] = [
                'f_id' => 9090,
                'amount' => $amtt,
                'type' => 'Uniform',
                'id' => 9090,
                'transport' => false,
                'balance' =>  $bal
            ];
        }



        return $payload;
    }


    function find_extra($id)
    {
        return $this->db->where(array('id' => $id))->get('fee_extras')->row();
    }

    function get_transport_head($id, $way)
    {
        $list = $this->db->where('description', $way)->where('f_id', $id)->get('fee_extras')->row();
        return $list->id;
    }

    function find_transport($id)
    {
        return $this->db->where('id', $id)->get('transport')->row();
    }

    function get_paid($student, $term, $year)
    {
        $this->select_all_key('fee_payment');
        $list = $this->db
            ->where($this->dx('term') . "=" . $term, NULL, FALSE)
            ->where($this->dx('year') . "=" . $year, NULL, FALSE)
            ->where($this->dx('reg_no') . "=" . $student, NULL, FALSE)
            ->where($this->dx('status') . ' = 1', NULL, FALSE)
            ->get('fee_payment')
            ->result();
        $payload = [];
        $totals = [];
        foreach ($list as $l) {
            $totals[$l->description][]  = $l->amount;
        }

        foreach ($totals as $desc => $amount) {
            $payload[$desc] = array_sum($amount);
        }

        return $payload;
    }


    function split($student, $term, $year, $amount)
    {
        $payload = [];
        $out = [];

        if ($student && $term && $year && $amount) {
            $payload = $this->get_invoices($student, $term, $year);
            usort($payload, function ($a, $b) {
                return $b['balance'] <=> $a['balance'];
            });

            $posted_amount = $amount;
            foreach ($payload as $r) {
                $p = (object) $r;
                $allocatedAmount = min($posted_amount, $p->balance);
                $posted_amount -= $allocatedAmount;
                $out[$p->id][]  =  $allocatedAmount;
            }

            if ($posted_amount > 0) {
                $out[88880][] = $posted_amount;
            }
        }

        return $out;
    }

}
