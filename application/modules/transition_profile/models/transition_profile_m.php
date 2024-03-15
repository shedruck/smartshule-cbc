<?php
class Transition_profile_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('transition_profile', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('transition_profile')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('transition_profile') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('transition_profile');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('transition_profile', $data);
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
        return $this->db->delete('transition_profile', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  transition_profile (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	allergy  text  , 
	general_health  text  , 
	general_academic  text  , 
	feeding_habit  text  , 
	behaviour  text  , 
	co_curriculum   text  , 
	parental_involvement  text  , 
	transport  varchar(32)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all_($limit, $page)
    {       

            $user = $this->ion_auth->get_user();
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $this->where('created_by',$user->id);
            $query = $this->db->get('transition_profile', $limit, $offset);

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

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('transition_profile', $limit, $offset);

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

    function get_data(){
        $result = $this->db->order_by('id', 'DESC')->get('transition_profile')->result();
        return $result;
    }

    function get_report(){
        return $this->db
                    ->group_by('class')
                    ->get('transition_profile')
                    ->result();
    }

    function report($class, $year, $student = 0){
        if($student){
            $this->db->where('student', $student);
        }
        return $this->db
                    ->where('class', $class)
                    ->where('year', $year)
                    ->get('transition_profile')
                    ->result();
    }
}

