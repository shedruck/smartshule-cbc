<?php
class Fee_pledge_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('fee_pledge', $data);
        return $this->db->insert_id();
    }
	//Parent details
	function get_parent($id)
    { 
	       $this->select_all_key('parents');
        
		return $this->db->where('id',$id)->get('parents')->row();
    }
	//Student  Details
function get_student($id)
    { 
	    $this->select_all_key('admission');
		return $this->db->where('id',$id)->get('admission')->row();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('fee_pledge')->row();
     }
	 //Unfulfilled Pledges
 function get_unfulfilled()
    {
        
		return $this->db->where(array('status' => 'pending'))->order_by('created_on','DESC')->limit(5)->get('fee_pledge')->result();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('fee_pledge') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('fee_pledge');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('fee_pledge', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();
       $options=array();
    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('fee_pledge', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  fee_pledge (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	pledge_date  INT(11), 
	amount  varchar(256)  DEFAULT '' NOT NULL, 
	status  varchar(256)  DEFAULT '' NOT NULL, 
	remark  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
           
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('fee_pledge', $limit, $offset);

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