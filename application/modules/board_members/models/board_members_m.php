<?php
class Board_members_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }
	
	function create($data)
    {
        $this->insert_key_data('board_members', $data);
        return $this->db->insert_id();
    }

    function create__($data)
    {
        $this->db->insert('board_members', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
		  $this->select_all_key('board_members');
        return $this->db->where(array('id' => $id))->get('board_members')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('board_members') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('board_members');
    }
	
	 function update_attributes($id, $data)
    {
		  return  $this->update_key_data($id,'board_members', $data);
		
    }

    function update_attributes__($id, $data)
    {
         return  $this->db->where('id', $id) ->update('board_members', $data);
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
        return $this->db->delete('board_members', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  board_members (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	file  varchar(256)  DEFAULT '' NOT NULL, 
	title  varchar(256)  DEFAULT '' NOT NULL, 
	first_name  varchar(256)  DEFAULT '' NOT NULL, 
	last_name  varchar(256)  DEFAULT '' NOT NULL, 
	gender  varchar(32)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	position  varchar(256)  DEFAULT '' NOT NULL, 
	date_joined  INT(11), 
	profile  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
			
			 $this->select_all_key('board_members');
			 
			$this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
            
            $this->db->order_by('position', 'asc');
            $query = $this->db->get('board_members', $limit, $offset);

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

	function paginate_inactive($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
			
			 $this->select_all_key('board_members');
			 
			$this->db->where($this->dx('status') . ' = 0', NULL, FALSE);
            
            $this->db->order_by('id', 'asc');
            $query = $this->db->get('board_members', $limit, $offset);

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