<?php
class Qa_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('qa', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('qa')->row();
     }
	 
	  function update_qa($id, $data)
        {
                return $this->db->where('id', $id)->update('qa_answers', $data);
        } 
		
	 
	  function given($id)
     {
		 $this->db->order_by('id','desc');
        return $this->db->group_by('created_on')->where(array('qa_id' => $id))->get('qa_given')->result();
     }

	 function given_row($id,$stud)
     {

        return $this->db->where(array('qa_id' => $id,'student' => $stud))->get('qa_given')->row();
     }

	 function all_given($id,$ct)
     {
		 $this->db->order_by('id','desc');
        return $this->db->where(array('qa_id' => $id,'created_on' => $ct))->get('qa_given')->result();
     }
	 
	   function delete_given($id)
    {

        return $this->db->delete('qa_given', array('created_on' => $id));
    }
	
	function exists_given($id,$stud)
    {
		  $this->db->where('student', $stud);
          return $this->db->where( array('qa_id' => $id))->count_all_results('qa_given') >0;
    }
	
	function get_qa_post($id,$stud)
        {
			
            return $this->db->order_by('created_on','asc')->where(array('student'=>$stud,'qa_id'=>$id))->get('qa_answers')->row();
			
        }
	
	
	function update_remarks($id, $st, $data)
    {
		
         return  $this->db->where(array('id'=>$id,'student'=>$st)) ->update('qa_given', $data);
    }
	
	function update_status($id, $st, $data)
    {
		
         return  $this->db->where(array('qa_id'=>$id,'student'=>$st)) ->update('qa_given', $data);
    }
	
	function qa_qs($id,$order_dir)
		{
		
			return $this->db->order_by('id',$order_dir)->where(array('qa' => $id))->get('qa_questions')->result();
		}
		
	function update_done($id, $st)
    {
		
         return  $this->db->where(array('qa_id'=>$id,'student'=>$st)) ->update('qa_given', array('done'=>1,'modified_on'=>time()));
    }
	
	 function get_st_qa($stud)
     {
		 $this->db->order_by('id','desc');
		 
        $res =  $this->db->where(array('student' => $stud))->get('qa_given')->result();
		
		$all = array();
		foreach($res as $r){
			
			$all[] = $this->db->where(array('id' => $r->qa_id))->get('qa')->row();
			
		}

		return $all;
     }
	
	
	function exists_st($id)
    {
		
		  $this->db->where('student', $this -> student -> id);
          return $this->db->where( array('qa_id' => $id))->count_all_results('qa_given') >0;
    }

	 function questions($id)
		{
			$this->db->where('created_by', $this -> ion_auth -> get_user()->id);
			return $this->db->order_by('id','desc')->where(array('qa' => $id))->get('qa_questions')->result();
		}
	 
function get($id)
    {
		 $this->db->where('created_by', $this -> ion_auth -> get_user()->id);
        return $this->db->where(array('id' => $id))->get('qa')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('qa') >0;
    }

	function exists_($id)
    {
		  $this->db->where('created_by', $this -> ion_auth -> get_user()->id);
          return $this->db->where( array('id' => $id))->count_all_results('qa') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('qa');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('qa', $data);
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
        return $this->db->delete('qa', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  qa (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	level  INT(11), 
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
            $query = $this->db->get('qa', $limit, $offset);

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
	
	function get_trs_qa($limit, $page)
    {
            $this->db->where('created_by', $this -> ion_auth -> get_user()->id);
			
			$offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('qa', $limit, $offset);

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






