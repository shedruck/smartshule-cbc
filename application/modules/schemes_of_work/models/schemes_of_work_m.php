<?php
class Schemes_of_work_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('schemes_of_work', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('schemes_of_work')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('schemes_of_work') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('schemes_of_work');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('schemes_of_work', $data);
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
        return $this->db->delete('schemes_of_work', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  schemes_of_work (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	year  varchar(256)  DEFAULT '' NOT NULL, 
	term  varchar(256)  DEFAULT '' NOT NULL, 
	level  varchar(256)  DEFAULT '' NOT NULL, 
	week  varchar(256)  DEFAULT '' NOT NULL, 
	lesson  text  , 
	strand  varchar(256)  DEFAULT '' NOT NULL, 
	substrand  varchar(256)  DEFAULT '' NOT NULL, 
	specific_learning_outcomes  text  , 
	key_inquiry_question  text  , 
	learning_experiences  text  , 
	learning_resources  text  , 
	assessment  text  , 
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
            $query = $this->db->get('schemes_of_work', $limit, $offset);

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
            $query = $this->db->get('schemes_of_work', $limit, $offset);

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

    function get_subjects_assigned()
    {
        $out = [];
        $list =  $this->db->where(['type' => 2, 'teacher' => $this->profile->id])->get('subjects_assign')->result();
        $subs = $this->populate('cbc_subjects','id','name');
        foreach($list as $p)
        {
            $subject =  isset($subs[$p->subject]) ? $subs[$p->subject] : '';
            $clas = isset($this->streams[$p->class]) ? $this->streams[$p->class] : '';
            $out[$p->subject] = $subject.'-'.$clas;
        }

        return $out;
    }

    function get_trs()
    {
        $this->select_all_key('teachers');
        $list =  $this->db->where($this->dx('status'). '=1',NULL, FALSE)->get('teachers')->result();
        $teachers = [];
        foreach ($list as $l) {
            $teachers[$l->user_id] = $l->first_name . ' ' . $l->middle_name . ' ' . $l->last_name;
        }
        return $teachers;
    }

    function get_report($teacher, $term,$year,$subject, $class, $week = false)
    {
        if($teacher)
        {
            $this->db->where('created_by',$teacher);
        }

        if($week)
        {
            $this->db->where('week',$week);
        }

        if($term)
        {
            $this->db->where('term',$term);
        }

        if($year)
        {
            $this->db->where('year',$year);
        }

        if($subject)
        {
            $this->db->where('subject',$subject);
        }

        if($class)
        {
            $this->db->where('level',$class);
        }

        return $this->db->get('schemes_of_work')->result();
    }

    function get_single_row($teacher, $term, $year, $subject, $class, $week = false)
    {
        if ($teacher) {
            $this->db->where('created_by', $teacher);
        }

        if ($week) {
            $this->db->where('week', $week);
        }

        if ($term) {
            $this->db->where('term', $term);
        }

        if ($year) {
            $this->db->where('year', $year);
        }

        if ($subject) {
            $this->db->where('subject', $subject);
        }

        if ($class) {
            $this->db->where('level', $class);
        }

        return $this->db->order_by('week', 'ASC')->order_by('lesson', 'ASC')->get('schemes_of_work')->row();
    }
}




