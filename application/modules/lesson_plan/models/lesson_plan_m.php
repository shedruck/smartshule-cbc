<?php
class Lesson_plan_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('lesson_plan', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('lesson_plan')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('lesson_plan') >0;
    }
	
    function exists_trs_plan($id,$trs)
    {
		  
          return $this->db->where( array('id' => $id,'teacher'=>$trs))->count_all_results('lesson_plan') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('lesson_plan');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('lesson_plan', $data);
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
        return $this->db->delete('lesson_plan', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  lesson_plan (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	term  varchar(256)  DEFAULT '' NOT NULL, 
	year  varchar(256)  DEFAULT '' NOT NULL,
    class INT(11), 	
	teacher  varchar(256)  DEFAULT '' NOT NULL, 
	week  varchar(256)  DEFAULT '' NOT NULL, 
	day  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	lesson  text  , 
	activity  text  , 
	objective  text  , 
	materials  text  , 
	assignment  text  , 
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
            $query = $this->db->get('lesson_plan', $limit, $offset);

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
	
	function get_teacher_plan($limit, $page,$id)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $this->db->where('teacher', $id);
            $query = $this->db->get('lesson_plan', $limit, $offset);

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



