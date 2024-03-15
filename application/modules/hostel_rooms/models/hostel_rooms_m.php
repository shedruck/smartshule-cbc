<?php
class Hostel_rooms_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('hostel_rooms', $data);
        return $this->db->insert_id();
    }
	
	//List Hostels	
	function list_hostels(){
	
	$result=$this->db->select('hostels.*')
				->order_by('created_on','DESC')
				->get('hostels')
				->result();
				$arr=array();
				
				foreach($result as $res){
				$arr[$res->id]=$res->title;
				}
				
				return $arr;
	}
	

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('hostel_rooms')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('hostel_rooms') >0;
    }
	
function count_beds($id)
    {
          return $this->db->where( array('room_id' => $id))->count_all_results('hostel_beds');
    }
  function count_free_beds($id)
    {
          return $this->db->where( array('room_id' => $id,'status'=>0))->count_all_results('hostel_beds');
		
		  
    }


    function count()
    {
        
        return $this->db->count_all_results('hostel_rooms');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('hostel_rooms', $data);
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
        return $this->db->delete('hostel_rooms', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('hostel_rooms', $limit, $offset);

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