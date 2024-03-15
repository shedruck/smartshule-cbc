<?php
class Grants_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('grants', $data);
        return $this->db->insert_id();
    }
	
	  function list_banks()
        {
                $result = $this->db->select('bank_accounts.*')
                             ->order_by('created_on', 'DESC')
                             ->get('bank_accounts')
                             ->result();

                $rr = array();
                foreach ($result as $res)
                {
                        $rr[$res->id] = $res->bank_name . ' (' . $res->account_number . ')';
                }

                return $rr;
        }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('grants')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('grants') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('grants');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('grants', $data);
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
        return $this->db->delete('grants', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  grants (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	grant_type  varchar(32)  DEFAULT '' NOT NULL, 
	date  INT(11), 
	amount  varchar(256)  DEFAULT '' NOT NULL, 
	payment_method  varchar(32)  DEFAULT '' NOT NULL, 
	purpose  text  , 
	school_representative  varchar(256)  DEFAULT '' NOT NULL, 
	file  varchar(256)  DEFAULT '' NOT NULL, 
	contact_person  varchar(256)  DEFAULT '' NOT NULL, 
	contact_details  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('grants', $limit, $offset);

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