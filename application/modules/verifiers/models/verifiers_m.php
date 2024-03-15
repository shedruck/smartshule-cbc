<?php
class Verifiers_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }
	
	 function create($data)
    {
        $this->insert_key_data('verifiers', $data);
        return $this->db->insert_id();
    }

    function create_old($data)
    {
        $this->db->insert('verifiers', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
		 $this->select_all_key('verifiers');
        return $this->db->where(array('id' => $id))->get('verifiers')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('verifiers') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('verifiers');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('verifiers', $data);
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
        return $this->db->delete('verifiers', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  verifiers (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	upi_number  varchar(256)  DEFAULT '' NOT NULL, 
	name  varchar(256)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	code  varchar(256)  DEFAULT '' NOT NULL, 
	reason  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
           
        $this->select_all_key('verifiers');
		
		   $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('verifiers', $limit, $offset);

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