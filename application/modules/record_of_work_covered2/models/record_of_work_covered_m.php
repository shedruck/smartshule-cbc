<?php
class Record_of_work_covered_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('record_of_work_covered', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('record_of_work_covered')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('record_of_work_covered') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('record_of_work_covered');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('record_of_work_covered', $data);
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
        return $this->db->delete('record_of_work_covered', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  record_of_work_covered (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	year  varchar(256)  DEFAULT '' NOT NULL, 
	term  varchar(256)  DEFAULT '' NOT NULL, 
	level  varchar(256)  DEFAULT '' NOT NULL, 
	week  varchar(256)  DEFAULT '' NOT NULL, 
	subject  INT(11), 
	date  INT(11), 
	strand  varchar(256)  DEFAULT '' NOT NULL, 
	substrand  varchar(256)  DEFAULT '' NOT NULL, 
	work_covered  text  , 
	reflection  text  , 
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
            $query = $this->db->get('record_of_work_covered', $limit, $offset);

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

    function paginate_trs($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
			 $user = $this -> ion_auth -> get_user();
			$this->db->where('created_by',$user->id);
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('record_of_work_covered', $limit, $offset);

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





