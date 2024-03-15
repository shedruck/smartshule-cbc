<?php

class Fee_extras_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('fee_extras', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('fee_extras')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('fee_extras') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('fee_extras');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('fee_extras', $data);
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
        return $this->db->delete('fee_extras', array('id' => $id));
    }

    

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  fee_extras (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(256)  DEFAULT '' NOT NULL, 
	ftype  int(11)  , 
	amount  float , 
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

        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('fee_extras', $limit, $offset);

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

    function getInvoiced(){
        $this->select_all_key('fee_extra_specs');
        return $this->db
                    ->order_by('created_on', 'desc')
                    ->get('fee_extra_specs')
                    ->result();
    }

    function updateAll_($id, $data){
        return $this->update_key_data($id, 'fee_extra_specs', $data);
    }

    function get_f_extras(){
           
            $this->select_all_key('fee_extra_specs');
            return $this->db
                    ->where($this->dx('description') . '= "Transport"', NULL, FALSE)
                    ->get('fee_extra_specs')->result();
    }

    function get_transport_r()
    {
        $list =  $this->db->get('fee_extras')->result();
        $drp = [];
        foreach($list as $l)
        {
            if(!empty($l->f_id))
            {
                $drp[$l->id] = $l->title;
            }
        }

        return $drp;

    }

      function _get_trans_invoices(){
           
            $this->select_all_key('fee_extra_specs');
            return $this->db
                    ->where($this->dx('description') . '= "Transport"', NULL, FALSE)
                    ->where($this->dx('term') . '= 1', NULL, FALSE)
                    ->where($this->dx('year') . '= 2022', NULL, FALSE)
                    ->where($this->dx('status') . '= 1', NULL, FALSE)
                    ->get('fee_extra_specs')->result();
    }


    function get_transport_stds()
    {
        return $this->db
                    ->where('term',1)
                    ->where('year',2022)
                    ->where('status',1)
                    ->get('transport')
                    ->result();
    }

    function v_look_t($id)
    {
        return $this->db
                    ->where('student', $id)
                    ->where('term',1)
                    ->where('year',2022)
                    ->where('status',1)
                    ->get('transport')
                    ->row();
    }


    function v_look_x($id)
    {
        return $this->db
                     ->where($this->dx('description') . '= "Transport"', NULL, FALSE)
                    ->where($this->dx('term') . '= 1', NULL, FALSE)
                    ->where($this->dx('year') . '= 2022', NULL, FALSE)
                    ->where($this->dx('status') . '= 1', NULL, FALSE)
                    ->where($this->dx('student') . " ='" . $id . "'", NULL, FALSE)
                    ->get('fee_extra_specs')
                    ->row();
    }


   

}
