<?php
class Subordinate_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->insert_key_data('subordinate', $data);
        return $this->db->insert_id();
    }
	
	function insert_gm($data)
    {
        $this->db->insert('member_groups', $data);
        return $this->db->insert_id();
    }
	

    function find($id)
    {
         $this->select_all_key('subordinate');
		return $this->db->where(array('id' => $id))->get('subordinate')->row();
     }
 
function staff_sickness($id)
        {
                return $this->db->select('sickness_absence.*')->where('staff', $id)->order_by('created_on', 'DESC')->get('sickness_absence')->result();
        }

		
		function staff_study($id)
        {
                return $this->db->where('staff', $id)->order_by('created_on', 'DESC')->get('study_leave')->result();
        }

		
		function staff_compassionate($id)
        {
                return $this->db->where('staff', $id)->order_by('created_on', 'DESC')->get('compassionate_leave')->result();
        }
		
		function staff_others($id)
        {
                return $this->db->where('staff', $id)->order_by('created_on', 'DESC')->get('other_absence')->result();
        }
		
		function staff_annual($id)
        {
                return $this->db->where('staff', $id)->order_by('created_on', 'DESC')->get('normal_leave')->result();
        }

    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('subordinate') >0;
    }
  function exists_mg($mem,$gp)
    {
          return $this->db->where( array('member_id' => $mem,'group_id'=>$gp))->count_all_results('member_groups') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('subordinate');
    }

    function update_attributes1($id, $data)
    {
         return  $this->db->where('id', $id) ->update('subordinate', $data);
    }
	
 function update_attributes($id, $data)
    {
		  return  $this->update_key_data($id,'subordinate', $data);
		
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
        return $this->db->delete('subordinate', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  subordinate (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	first_name  varchar(256)  DEFAULT '' NOT NULL, 
	middle_name  varchar(256)  DEFAULT '' NOT NULL, 
	last_name  varchar(256)  DEFAULT '' NOT NULL, 
	gender  varchar(256)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	address  text  , 
	additionals  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
           

		   $offset = $limit * ( $page - 1) ;
			$this->db->order_by('created_on', 'DESC');
             $this->select_all_key('subordinate');
			
			 $this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
            
            $query = $this->db
						
						->order_by('subordinate.id', 'DESC')
						->get('subordinate', $limit, $offset);

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

	function paginate_inactive($limit, $page)
    {
           
		   $offset = $limit * ( $page - 1) ;
			$this->db->order_by('created_on', 'DESC');
             $this->select_all_key('subordinate');
			
			 $this->db->where($this->dx('status') . ' = 0', NULL, FALSE);
            
            $query = $this->db
						
						->order_by('subordinate.id', 'DESC')
						->get('subordinate', $limit, $offset);

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