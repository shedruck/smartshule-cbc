<?php
class Staff_clearance_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('staff_clearance', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('staff_clearance')->row();
     }
	 
	 	 function staff_details($id)
    {
        return $this->db->where(array('staff' => $id))->get('staff_clearance')->row();
     }

	 function by_staff($id)
     {
        return $this->db->where(array('staff' => $id))->get('staff_clearance')->result();
     }
	 
	 function all_staff(){
		 /**Group 
			 1 Teachers
			 2 Non Teachers
			 2 Subordinate
		 **/
		 
		$this->select_all_key('teachers');
		
		 $tr = $this->db->get('teachers')->result();
		 $tr_options = array();
			foreach($tr as $t) {
				$tr_options[$t->id.'-1'] = $t->first_name.' '.$t->last_name.' - '.$t->id_no.' - Teacher';
			}
			
		$this->select_all_key('non_teaching');
		
		 $nontr = $this->db->get('non_teaching')->result();
		 $nontr_options = array();
			foreach($nontr as $t) {
				$nontr_options[$t->id.'-2'] = $t->first_name.' '.$t->middle_name.' '.$t->last_name.' - '.$t->id_no.' - Non Teaching';
			}

		$this->select_all_key('subordinate');
		
		 $sub = $this->db->get('subordinate')->result();
		 $sub_options = array();
			foreach($sub as $t) {
				$sub_options[$t->id.'-2'] = $t->first_name.' '.$t->middle_name.' '.$t->last_name.' - '.$t->id_no.' - Subordinate';
			}
		  
		  return $tr_options + $nontr_options + $sub_options;
	 }
	 
	 function teachers(){
		 $this->select_all_key('teachers');
		 
		  $tr = $this->db->get('teachers')->result();
		 $tr_options = array();
			foreach($tr as $t) {
				$tr_options[$t->id] = $t->first_name.' '.$t->last_name.' - ID No. '.$t->id_no.' - Teacher';
			}
			
			 return $tr_options;
	 }
	 
	 function subordinate(){
		 $this->select_all_key('subordinate');
		$sub = $this->db->get('subordinate')->result();
		 $sub_options = array();
			foreach($sub as $t) {
				$sub_options[$t->id] = $t->first_name.' '.$t->middle_name.' '.$t->last_name.' - ID No. '.$t->id_no.' - Subordinate';
			}
		  
		  return $sub_options;
			
	 }

	 function non_teaching(){
		 
		  $this->select_all_key('non_teaching');
		
		 $nontr = $this->db->get('non_teaching')->result();
		 $nontr_options = array();
			foreach($nontr as $t) {
				$nontr_options[$t->id] = $t->first_name.' '.$t->middle_name.' '.$t->last_name.' - ID No. '.$t->id_no.' - Non Teaching';
			}
			
			 return $nontr_options;
			
	 }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('staff_clearance') >0;
    }
	
  function exists_staff($id)
    {
          return $this->db->where( array('staff' => $id))->count_all_results('staff_clearance') >0;
    }

	 function get_depts()
    {
        return $this->db->get('clearance_departments')->result();
     }


    function count()
    {
        
        return $this->db->count_all_results('staff_clearance');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('staff_clearance', $data);
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
        return $this->db->delete('staff_clearance', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  staff_clearance (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	date  INT(11), 
	department  varchar(32)  DEFAULT '' NOT NULL, 
	cleared  varchar(256)  DEFAULT '' NOT NULL, 
	charge  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->group_by('ref')->get('staff_clearance', $limit, $offset);

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

	function manage($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('staff_clearance', $limit, $offset);

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