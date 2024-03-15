<?php

class Transport_buses_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('transport_buses', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('transport_buses')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('transport_buses') > 0;
    }

    function assign_staff($id, $staff)
    {
        $exst = $this->db->where('bus', $id)->where('staff', $staff)
            ->count_all_results('transport_staff') > 0;

        if (!$exst)
        {
            $this->db->insert('transport_staff', ['staff' => $staff, 'bus' => $id, 'created_on' => time(), 'created_by' => $this->ion_auth->get_user()->id]);
            return $this->db->insert_id();
        }
    }

    function count()
    {

        return $this->db->count_all_results('transport_buses');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('transport_buses', $data);
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
        return $this->db->delete('transport_buses', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  transport_buses (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	reg_no  varchar(256)  DEFAULT '' NOT NULL, 
	capacity  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function bus_exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('transport_buses') > 0;
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('transport_buses', $limit, $offset);

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

}
