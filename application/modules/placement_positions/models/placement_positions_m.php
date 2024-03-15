<?php
class Placement_positions_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('placement_positions', $data);
        return $this->db->insert_id();
    }
 

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('placement_positions')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('placement_positions') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('placement_positions');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('placement_positions', $data);
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
        return $this->db->delete('placement_positions', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('placement_positions', $limit, $offset);

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