<?php
class Enquiries_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('enquiries', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('enquiries')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('enquiries') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('enquiries');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('enquiries', $data);
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
        return $this->db->delete('enquiries', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  enquiries (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	date  INT(11), 
	first_name  varchar(256)  DEFAULT '' NOT NULL, 
	last_name  varchar(256)  DEFAULT '' NOT NULL, 
	dob  INT(11), 
	gender  varchar(32)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	class  varchar(256)  DEFAULT '' NOT NULL, 
	know_about  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
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
            $query = $this->db->get('enquiries', $limit, $offset);

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