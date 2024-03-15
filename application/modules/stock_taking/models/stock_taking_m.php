<?php
class Stock_taking_m extends MY_Model{

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function create($data)
    {
    	$query = $this->db->insert('stock_taking', $data);
    	return $query;
    }


    function find($id)
    {
    	$query = $this->db->get_where('stock_taking', array('id' => $id));
    	return $query->row();
     }


    function exists($id)
    {
    	$query = $this->db->get_where('stock_taking', array('id' => $id));
    	$result = $query->result();

    	if ($result)
    		return TRUE;
    	else
    		return FALSE;
    }


    function count()
    {
    	
    	return $this->db->count_all_results('stock_taking');
    }


    function update_attributes($id, $data)
    {
    	$this->db->where('id', $id);
		$query = $this->db->update('stock_taking', $data);

		return $query;
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();

    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}


    function delete($id)
    {
    	$query = $this->db->delete('stock_taking', array('id' => $id));

    	return $query;
    }


	function paginate_all($limit, $page)
	{
		$offset = $limit * ( $page - 1) ;
		
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('stock_taking', $limit, $offset);

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