<?php
class Coop_bank_file_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('coop_bank_file', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('coop_bank_file')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('coop_bank_file') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('coop_bank_file');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('coop_bank_file', $data);
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
        return $this->db->delete('coop_bank_file', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  coop_bank_file (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	transaction_date  varchar(256)  DEFAULT '' NOT NULL, 
	value_date  varchar(256)  DEFAULT '' NOT NULL, 
	channel_ref  varchar(256)  DEFAULT '' NOT NULL, 
	transaction_ref  varchar(256)  DEFAULT '' NOT NULL, 
	narrative  varchar(256)  DEFAULT '' NOT NULL, 
	debit  varchar(256)  DEFAULT '' NOT NULL, 
	credit  varchar(256)  DEFAULT '' NOT NULL, 
	running_bal  varchar(256)  DEFAULT '' NOT NULL, 
	transaction_no  varchar(256)  DEFAULT '' NOT NULL, 
	admission_no  varchar(256)  DEFAULT '' NOT NULL, 
	student  varchar(256)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('coop_bank_file', $limit, $offset);

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