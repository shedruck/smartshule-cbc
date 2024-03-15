<?php
class Mc_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('mc', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('mc')->row();
     }

	 function get_st_mc($stud)
     {
        $res =  $this->db->where(array('student' => $stud))->get('mc_given')->result();
		
		$all = array();
		foreach($res as $r){
			
			$all[] = $this->db->where(array('id' => $r->mc_id))->get('mc')->row();
			
		}

		return $all;
     }

	 function given($id)
     {
		 $this->db->order_by('id','desc');
        return $this->db->group_by('created_on')->where(array('mc_id' => $id))->get('mc_given')->result();
     }

	 function all_given($id,$ct)
     {
		 $this->db->order_by('id','desc');
        return $this->db->where(array('mc_id' => $id,'created_on' => $ct))->get('mc_given')->result();
     }
	 
	 function get($id)
     {
        $this->db->where('created_by', $this -> ion_auth -> get_user()->id);
        return $this->db->where(array('id' => $id))->get('mc')->row();
     }
	 
	  function questions($id,$order_dir)
		{
			$this->db->where('created_by', $this -> ion_auth -> get_user()->id);
			return $this->db->order_by('id',$order_dir)->where(array('mc' => $id))->get('mc_questions')->result();
		}

		function mc_qs($id,$order_dir)
		{
		
			return $this->db->order_by('id',$order_dir)->where(array('mc' => $id))->get('mc_questions')->result();
		}


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('mc') >0;
    }
	
	function exists_($id)
    {
		  $this->db->where('created_by', $this -> ion_auth -> get_user()->id);
          return $this->db->where( array('id' => $id))->count_all_results('mc') >0;
    }
	
	function exists_st($id)
    {
		
		  $this->db->where('student', $this -> student -> id);
          return $this->db->where( array('mc_id' => $id))->count_all_results('mc_given') >0;
    }
	
	function exists_given($id,$stud)
    {
		  $this->db->where('student', $stud);
          return $this->db->where( array('mc_id' => $id))->count_all_results('mc_given') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('mc');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('mc', $data);
    }
	
    function update_done($id, $st)
    {
		
         return  $this->db->where(array('mc_id'=>$id,'student'=>$st)) ->update('mc_given', array('done'=>1,'modified_on'=>time()));
    }
	
	function update_remarks($id, $st, $data)
    {
		
         return  $this->db->where(array('mc_id'=>$id,'student'=>$st)) ->update('mc_given', $data);
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
        return $this->db->delete('mc', array('id' => $id));
     }
	 
	 
    function delete_given($id)
    {

        return $this->db->delete('mc_given', array('created_on' => $id));
    }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  mc (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	level  varchar(256)  DEFAULT '' NOT NULL, 
	title  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	topic  varchar(256)  DEFAULT '' NOT NULL, 
	instruction  text  , 
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
            $query = $this->db->get('mc', $limit, $offset);

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


	function get_all_mc($limit, $page)
    {
		
		 $this->db->where('created_by', $this -> ion_auth -> get_user()->id);
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('mc', $limit, $offset);

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





