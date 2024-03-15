<?php

class School_events_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('school_events', $data);
        return $this->db->insert_id();
    }

    //Custom codes

    function get_all()
    {
         return $this->db->select('school_events.*')
                        ->order_by('start_date', 'DESC')
                        ->get('school_events')
                        ->result();
    }

    function get_groups()
    {

        $results = $this->db->select('groups.*')
                ->get('groups')
                ->result();

        $arr = array();

        foreach ($results as $res)
        {

            $arr[$res->id] = $res->name;
        }

        return $arr;
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('school_events')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('school_events') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('school_events');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('school_events', $data);
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
        return $this->db->delete('school_events', array('id' => $id));
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('school_events', $limit, $offset);

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
