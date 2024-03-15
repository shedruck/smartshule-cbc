<?php
class Qa_questions_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('qa_questions', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('qa_questions')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('qa_questions') >0;
    }
	
    function exists_($id)
    {
		  $this->db->where('created_by', $this -> ion_auth -> get_user()->id);
          return $this->db->where( array('id' => $id))->count_all_results('qa_questions') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('qa_questions');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('qa_questions', $data);
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
		$this->db->where('created_by', $this -> ion_auth -> get_user()->id);
        return $this->db->delete('qa_questions', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  qa_questions (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	qa  varchar(256)  DEFAULT '' NOT NULL, 
	question  text  , 
	answer  text  , 
	marks  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('qa_questions', $limit, $offset);

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