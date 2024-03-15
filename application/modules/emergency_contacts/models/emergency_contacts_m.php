<?php
class Emergency_contacts_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
         $this->insert_key_data('emergency_contacts', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
		 $this->select_all_key('emergency_contacts');
        return $this->db->where(array('id' => $id))->get('emergency_contacts')->row();
    }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('emergency_contacts') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('emergency_contacts');
    }

    function update_attributes($id, $data)
    {
         return $this->update_key_data($id, 'emergency_contacts', $data);
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
        return $this->db->delete('emergency_contacts', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
		 
      $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  emergency_contacts (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	relation  varchar(32)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	address  text  , 
	student_id INT(11), 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
            $this->select_all_key('emergency_contacts');
			
			$offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('emergency_contacts', $limit, $offset);

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