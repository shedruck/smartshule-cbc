<?php
class Grading_system_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('grading_system', $data);
        return $this->db->insert_id();
    }

    function addgrades($data)
    {
        $this->db->insert('gs_grades', $data);
        return $this->db->insert_id();
    }

    function fetchgrades($id)
    {
        return $this->db
                ->where('grade_id',$id)
                ->get('gs_grades')
                ->result();
    }

    function update_gs_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('gs_grades', $data);
    }

    function checkgrade($gsi,$grade)
    {
          return $this->db
                    ->where( array('grade_id' => $gsi))
                    ->where( array('grade' => $grade))
                    ->get('gs_grades')
                    ->row();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('grading_system')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('grading_system') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('grading_system');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('grading_system', $data);
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
        return $this->db->delete('grading_system', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('grading_system', $limit, $offset);

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