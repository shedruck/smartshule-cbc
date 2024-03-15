<?php

class Class_timetable_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('class_timetable', $data);
        return $this->db->insert_id();
    }

    function create_list($data)
    {
        $this->db->insert('class_timetable_list', $data);
        return $this->db->insert_id();
    }

    //Select all Subjects
    function list_subjects()
    {

        $result = $this->db->select('subjects.*')
                ->get('subjects')
                ->result();

        $arr = array();

        foreach ($result as $res)
        {
            $arr[$res->id] = $res->name;
        }

        return $arr;
    }

    //Select all class rooms
    function list_class_rooms()
    {

        $result = $this->db->select('class_rooms.*')
                ->get('class_rooms')
                ->result();

        $arr = array();

        foreach ($result as $res)
        {
            $arr[$res->id] = $res->name;
        }

        return $arr;
    }

    //Select all classes
    function list_classes()
    {

        $result = $this->db->select('class_groups.*')
                ->get('class_groups')
                ->result();

        $arr = array();

        foreach ($result as $res)
        {
            $arr[$res->id] = $res->name;
        }

        return $arr;
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('class_timetable')->row();
    }


	 
	 
	 
	function get_classes()
    {
        return $this->db->get('classes')->result();
    }

    function get($id)
    {
        return $this->db->where(array('class_id' => $id))->get('class_timetable')->row();
    }

	function get_tbl($class,$term,$year)
    {
        return $this->db->where(array('class_id' => $class,'term'=>$term,'year'=>$year))->get('class_timetable')->row();
    }

    function list_tbl($id)
    {
        return $this->db->where(array('class_id' => $id))->group_by('day_of_the_week')->order_by('priority', 'asc')->get('class_timetable_list')->result();
    }
	
	
	
    function list_all($id)
    {
        return $this->db->where(array('class_id' => $id))->group_by('day_of_the_week')->order_by('created_on', 'asc')->get('class_timetable_list')->result();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('class_timetable') > 0;
    }

	function exists_period($class,$term,$year)
    {
        return $this->db->where(array('class_id' => $class,'term'=>$term,'year'=>$year))->count_all_results('class_timetable') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('class_timetable');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('class_timetable', $data);
    }

    function populate($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();

        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    function delete($id)
    {
        return $this->db->delete('class_timetable', array('id' => $id));
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $this->db->group_by('class_id');
        $query = $this->db->get('class_timetable', $limit, $offset);

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
