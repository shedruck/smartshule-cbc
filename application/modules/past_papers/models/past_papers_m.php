<?php
class Past_papers_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('past_papers', $data);
        return $this->db->insert_id();
    }

	function create_folder($data)
    {
        $this->db->insert('folders', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('past_papers')->row();
     }

	 function by_folder($id)
     {
        return $this->db->where(array('folder' => $id))->order_by('created_on','desc')->get('past_papers')->result();
     }
	 



    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('past_papers') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('past_papers');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('past_papers', $data);
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
        return $this->db->delete('past_papers', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  past_papers (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	year  varchar(256)  DEFAULT '' NOT NULL, 
	name  varchar(256)  DEFAULT '' NOT NULL, 
	file  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('past_papers', $limit, $offset);

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
	
	function by_folder_($id,$limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            $this->db->where('folder',$id);
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('past_papers', $limit, $offset);

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

	function folders($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('folders', $limit, $offset);

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