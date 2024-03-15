<?php
class Grading_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('grading', $data);
        return $this->db->insert_id();
    }
	 function insert_records($data)
    {
        $this->db->insert('grading_records', $data);
        return $this->db->insert_id();
    }
	
  function get_grading_system(){
	
	$result=$this->db->select('grading_system.*')
				->order_by('created_on','DESC')
				->get('grading_system')
				->result();
				
				$arr=array();
				
				foreach($result as $res){
				
				$arr[$res->id]=$res->title;
				}
				
				return $arr;
	
	}
	
	function list_grades(){
	
	  return $this->db->select('grades.*')->order_by('created_on','DESC')->get('grades')->result();
	}
	
	function grades(){
	
	$res=$this->db->select('grades.*')->order_by('created_on','DESC')->get('grades')->result();
	
		$rr=array();
		foreach($res as $r){		
			$rr[$r->id]=$r->title;		
		}
		return $rr;
		
	
	}

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('grading')->row();
     }
  function get_grades($id)
    {
        return $this->db->where(array('grading_id' => $id))->order_by('maximum_marks','DESC')->get('grading_records')->result();
     }
	 
	public function grades_details($id = false)
    {
        

        $this->db->where('grades.id', $id);
        return $this->db->get('grades')->row();

        
    }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('grading') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('grading');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('grading', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();

    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('grading', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('grading', $limit, $offset);

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