<?php
class Registration_details_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('registration_details', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('registration_details')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('registration_details') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('registration_details');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('registration_details', $data);
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
        return $this->db->delete('registration_details', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  registration_details (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	registration_no  varchar(256)  DEFAULT '' NOT NULL, 
	date_reg  varchar(256)  DEFAULT '' NOT NULL, 
	institution_category  varchar(256)  DEFAULT '' NOT NULL, 
	institution_cluster  varchar(256)  DEFAULT '' NOT NULL, 
	county  varchar(256)  DEFAULT '' NOT NULL, 
	sub_county  varchar(256)  DEFAULT '' NOT NULL, 
	ward  varchar(256)  DEFAULT '' NOT NULL, 
	institution_type  varchar(256)  DEFAULT '' NOT NULL, 
	education_system  varchar(256)  DEFAULT '' NOT NULL, 
	education_level  varchar(256)  DEFAULT '' NOT NULL, 
	knec_code  varchar(256)  DEFAULT '' NOT NULL, 
	institution_accommodation  varchar(256)  DEFAULT '' NOT NULL, 
	scholars_gender  varchar(256)  DEFAULT '' NOT NULL, 
	locality  varchar(256)  DEFAULT '' NOT NULL, 
	kra_pin  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('registration_details', $limit, $offset);

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