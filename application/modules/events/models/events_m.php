<?php
class Events_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('events', $data);
        return $this->db->insert_id();
    }


    function insert_event_filenames($id, $data)
    {
        $this->db->where('id', $id)->update('events', $data);
        
    } 
    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('events')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('events') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('events');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('events', $data);
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
        return $this->db->delete('events', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  events (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(256)  DEFAULT '' NOT NULL, 
	date  varchar(256)  DEFAULT '' NOT NULL, 
	start  varchar(256)  DEFAULT '' NOT NULL, 
	end  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('events', $limit, $offset);

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