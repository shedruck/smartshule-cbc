<?php
class Fee_arrears_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        //$this->db_set();
    }

    function create($data)
    {
        $this->insert_key_data('fee_arrears', $data);
        return $this->db->insert_id();
    }
	


    function find($id)
    {
		 $this->select_all_key('fee_arrears');
        return $this->db->where(array('id' => $id))->get('fee_arrears')->row();
     }


 


    function exists($id)
    {
          
		  return $this->db->where( array('id' => $id))->count_all_results('fee_arrears') >0;
    }

	function exists_student($id)
    {
          
		  return $this->db->where($this->dx('student').'='.$id, NULL,FALSE)->count_all_results('fee_arrears') >0;
    }
	
	//students
	
	 function fetch_full_students($class)
          {
              $list = $this->db->select('id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name'). ',' . $this->dxa('admission_number'), FALSE)
                      ->where($this->dx('class') . '=' . $class, NULL, FALSE)
                      ->get('admission')
                      ->result();
            
              return $list;
          }
	


    function count()
    {
        
        return $this->db->count_all_results('fee_arrears');
    }

    function update_attributes($id, $data)
    {
           return $this->update_key_data($id, 'fee_arrears', $data);
		 
		 //return  $this->db->where('id', $id) ->update('fee_arrears', $data);
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
        return $this->db->delete('fee_arrears', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
		 
		 
            
      }
      
    function paginate_all($limit, $page)
    {
            
			 $this->select_all_key('fee_arrears');
			$offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('fee_arrears', $limit, $offset);

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