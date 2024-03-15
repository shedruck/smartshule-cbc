<?php
class Hostel_beds_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('hostel_beds', $data);
        return $this->db->insert_id();
    }
//List hostel rooms
  function list_hostel_rooms(){
	
	$result=$this->db->select('hostel_rooms.*')
				->order_by('created_on','DESC')
				->get('hostel_rooms')
				->result();
				$arr=array();
				
				foreach($result as $res){
				$hostel=$this->db->select('hostels.*')
				->where('id',$res->hostel_id)
				->get('hostels')
				->row();
			
				$arr[$res->id]=$hostel->title.' - Room '.$res->room_name;
				}
				
				return $arr;
	}
	
	
    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('hostel_beds')->row();
     }
   function get_student($id)
    {
        return $this->db->where(array('bed' => $id))->get('assign_bed')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('hostel_beds') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('hostel_beds');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('hostel_beds', $data);
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
        return $this->db->delete('hostel_beds', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('hostel_beds', $limit, $offset);

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