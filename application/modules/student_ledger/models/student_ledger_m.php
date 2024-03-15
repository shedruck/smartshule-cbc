<?php

class Student_ledger_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('student_ledger', $data);
        return $this->db->insert_id();
    }

    function create_r($table, $data, $enc = 0)
    {
        if ($enc)
        {
            return $this->insert_key_data($table, $data);
        }

        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('student_ledger')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('student_ledger') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('student_ledger');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('student_ledger', $data);
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
        return $this->db->delete('student_ledger', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  student_ledger (
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
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('student_ledger', $limit, $offset);

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

    function get_invoice($student, $term = 0, $year = 0)
    {
        if ($term)
        {
            $this->db->where('term', $term);
        }

        if ($year)
        {
            $this->db->where('year', $year);
        }

        return $this->db->where('student_id', $student)->get('invoices')->result();
    }

    function update_($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }

    function update_att($id, $data, $table)
    {
        return $this->update_key_data($id, $table, $data);
    }

    function get_flagged_pay()
    {
        $this->select_all_key('fee_payment');
        return $this->db->where("( " . $this->dx('flagged') . '=1 OR ' . $this->dx('status') . '=0 ) ', NULL, FALSE)
                                            ->get('fee_payment')
                                            ->result();
    }

    function get_flagged_extras()
    {
        $this->select_all_key('fee_extra_specs');
        return $this->db->where($this->dx('flagged') . '=1 ', NULL, FALSE)
                                            ->get('fee_extra_specs')
                                            ->result();
    }

    function get_flagged_inv()
    {
        return $this->db->where('flagged', 1)
                                            ->get('invoices')
                                            ->result();
    }

    function get_flagged($table, $enc = true)
    {
        if (!$enc)
        {
            return $this->db->where('flagged', 1)
                                                ->get($table)
                                                ->result();
        }
        $this->select_all_key($table);
        return $this->db->where($this->dx('flagged') . '=1 ', NULL, FALSE)
                                            ->get($table)
                                            ->result();
    }

    function get_voided()
    {
        $this->select_all_key('fee_payment');
        return $this->db->where($this->dx('status') . '=0 ', NULL, FALSE)
                                            ->get('fee_payment')
                                            ->result();
    }

    function get_fee_extras($student, $term = 0, $year = 0)
    {
        $this->select_all_key('fee_extra_specs');
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

    function fetch_extra($id)
    {
        $this->select_all_key('fee_extra_specs');

        return $this->db->where('id', $id)->get('fee_extra_specs')->row();
    }

    function fetch_pay($id)
    {
        $this->select_all_key('fee_payment');

        return $this->db->where('id', $id)->get('fee_payment')->row();
    }

    function fetch_invoice($id)
    {
        return $this->db->where('id', $id)->get('invoices')->row();
    }

    function get_payments($student, $term = 0, $year = 0)
    {
        $this->select_all_key('fee_payment');
        if ($term)
        {
            $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE);
        }

        if ($year)
        {
            $this->db->where($this->dx('year') . '=' . $year, NULL, FALSE);
        }

        return $this->db
                                            ->where($this->dx('reg_no') . '=' . $student, NULL, FALSE)
                                            ->get('fee_payment')
                                            ->result();
    }

}
