<?php
class Assign_bed_m extends CI_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('assign_bed', $data);
        return $this->db->insert_id();
    }
	
	//List hostel Beds
  function list_hostel_beds(){
	
	$result=$this->db->select('hostel_beds.*')
				->where('status',0)
				->order_by('created_on','DESC')
				->get('hostel_beds')
				->result();
				$arr=array();
				
				foreach($result as $res){
						$room=$this->db->select('hostel_rooms.*')
							->where('id',$res->room_id)
							->get('hostel_rooms')
							->result();
						foreach($room as $rm){
								$hostel=$this->db->select('hostels.*')
									->where('id',$rm->hostel_id)
									->get('hostels')
									->row();
						  }
						  $arr[$res->id]=$hostel->title.' - Bed Number #'.$res->bed_number;
				
				}
				
				return $arr;
	}	//List hostel Beds
	
  function get_hostel_beds(){
	
	$result=$this->db->select('hostel_beds.*')
				
				->order_by('created_on','DESC')
				->get('hostel_beds')
				->result();
				$arr=array();
				
				foreach($result as $res){
						$room=$this->db->select('hostel_rooms.*')
							->where('id',$res->room_id)
							->get('hostel_rooms')
							->result();
						foreach($room as $rm){
								$hostel=$this->db->select('hostels.*')
									->where('id',$rm->hostel_id)
									->get('hostels')
									->row();
						  }
						  $arr[$res->id]=$hostel->title.' - Bed Number #'.$res->bed_number;
				
				}
				
				return $arr;
	}
	

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('assign_bed')->row();
     }
 function get($id)
    {
        return $this->db->where(array('student' => $id))->get('assign_bed')->result();
    }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('assign_bed') >0;
    }
  function exists_student($id)
    {
          return $this->db->where( array('student' => $id))->count_all_results('assign_bed') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('assign_bed');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('assign_bed', $data);
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
        return $this->db->delete('assign_bed', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('assign_bed', $limit, $offset);

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