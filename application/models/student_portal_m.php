<?php

class Student_portal_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    //Get Classes
    public function get_class()
    {

        $results = $this->db->select('school_classes.*')
                ->get('school_classes')
                ->result();

        $arr = array();

        foreach ($results as $res)
        {

            $arr[$res->id] = $res->class_name;
        }

        return $arr;
    }

    function banks()
    {
        return $this->db->get('bank_accounts')->result();
    }

    public function get_bank_options()
    {

        $results = $this->db->select('bank_accounts.*')
                ->get('bank_accounts')
                ->result();

        $arr = array();

        foreach ($results as $res)
        {

            $arr[$res->id] = $res->bank_name;
        }

        return $arr;
    }
 

    function get_split($id)
    {
        return $this->db->where(array('fee_structure_id' => $id))->get('fee_structure_split')->result();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('fee_structure')->row();
    }

    /**
     * Fetch Admission Details
     * 
     * @param str $regno
     * @return object
     */
    function fetch($regno)
    {
        return $this->db->where(array('admission_number' => $regno))->get('admission')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('fee_structure') > 0;
    }

    function count()
    {
        return $this->db->count_all_results('fee_structure');
    }

    function update_attributes($id, $data)
    {
        //return $this->db->where('id', $id)->update('fee_structure', $data);
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

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('fee_structure', $limit, $offset);

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

    /**
     * Get fee Payments
     * 
     * @param type $id
     * @return type
     */
    function get_payments($id)
    {
        return $this->db->where(array('reg_no' => $id, 'status' => 1))->get('fee_payment')->result();
    }

    function total_paid($id)
    {
        return $this->db->select('sum(amount) as amount')
                        ->where('reg_no', $id)
                        ->where('status', 1)
                        ->get('fee_payment')
                        ->row()->amount;
    }

    function get_timeable($id)
    {
        return $this->db->where(array('class_id' => $id))->group_by('day_of_the_week')->order_by('created_on', 'asc')->get('class_timetable_list')->result();
    }

    function monday($id)
    {
        return $this->db->where(array('class_id' => $id, 'day_of_the_week' => 'monday'))->get('class_timetable_list')->result();
    }

    function tuesday($id)
    {
        return $this->db->where(array('class_id' => $id, 'day_of_the_week' => 'tuesday'))->get('class_timetable_list')->result();
    }

    function wednesday($id)
    {
        return $this->db->where(array('class_id' => $id, 'day_of_the_week' => 'wednesday'))->get('class_timetable_list')->result();
    }

    function thursday($id)
    {
        return $this->db->where(array('class_id' => $id, 'day_of_the_week' => 'thursday'))->get('class_timetable_list')->result();
    }

    function friday($id)
    {
        return $this->db->where(array('class_id' => $id, 'day_of_the_week' => 'friday'))->get('class_timetable_list')->result();
    }

    function list_subjects()
    {
        $result = $this->db->select('subjects.*')
                ->get('subjects')
                ->result();

        $arr = array();
        foreach ($result as $res)
        {
            $arr[$res->id] = $res->title;
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
        $result = $this->db->select('school_classes.*')
                ->get('school_classes')
                ->result();

        $arr = array();

        foreach ($result as $res)
        {
            $arr[$res->id] = $res->class_name;
        }

        return $arr;
    }

    function get_events()
    {
        return $this->db->select('school_events.*')
                        ->order_by('created_on', 'DESC')
                        ->get('school_events')
                        ->result();
    }
}
