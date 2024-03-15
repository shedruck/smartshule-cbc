<?php

class Diary_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('diary', $data);
        return $this->db->insert_id();
    }
	
	 //Get students
        public function get_students($id)
        {
                $this->select_all_key('admission');
                $results = $this->db->where($this->dx('class') . '=' . $id, NULL, FALSE)->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();
                $arr = array();
                foreach ($results as $r)
                {
					  $adm = $r->admission_number;
					  if (!empty($r->old_adm_no))
						{
								$adm =  $r->old_adm_no;
						}
						
                        $arr[$r->id] = $r->first_name . ' ' . $r->last_name.'<br> ADM: <b>'.$adm .'</b>';
                }
                return $arr;
        }

    function create_ex($data)
    {
        $this->db->insert('diary_extra', $data);
        return $this->db->insert_id();
    }
	
	
    function get_diary($id)
    {
		
        return $this->db
		             ->order_by('created_on','desc')
					->where(array('status' => 1,'student' => $id))
					->get('diary')
					->result();
    }

	function ex_diary($id)
    {
		
        return $this->db
		            ->order_by('created_on','desc')
					->where(array('status' => 1, 'student' => $id))
					->get('diary_extra')
					->result();
    }
	

    function create_file($data)
    {
        return $this->insert_key_data('diary_uploads', $data);
    }

    function update_files($id, $data)
    {
        return $this->update_key_data($id, 'diary_uploads', $data);
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('diary')->row();
    }

    function find_ex($id)
    {
        return $this->db->where(array('id' => $id))->get('diary_extra')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('diary') > 0;
    }

    function exists_ex($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('diary_extra') > 0;
    }

    function count()
    {
        return $this->db->count_all_results('diary');
    }

    function count_ex()
    {
        return $this->db->count_all_results('diary_extra');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('diary', $data);
    }

    function update_ex($id, $data)
    {
        return $this->db->where('id', $id)->update('diary_extra', $data);
    }

    function populate($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    function delete($id, $table)
    {
        return $this->db->delete($table, ['id' => $id]);
    }

    function paginate_all($limit, $page, $id= false)
    {
        $offset = $limit * ( $page - 1);
        if($id)
        {
             $this->db->where('created_by', $id);
        }
       
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('diary', $limit, $offset);

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

    function paginate_extra($limit, $page, $id= false)
    {
        $activities = $this->populate('activities', 'id', 'name');
        $offset = $limit * ( $page - 1);
        if($id)
        {
             $this->db->where('created_by', $id);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('diary_extra', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row)
        {
            $name = isset($activities[$row->activity]) ? $activities[$row->activity] : ' - ';
            $row->activity = $name;
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
