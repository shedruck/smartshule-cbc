<?php

class Setup_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
 

    function count_teachers()
    {
        return $this->db->count_all_results('teachers');
    }

    function count_classes()
    {
        return $this->db->count_all_results('classes');
    }

    function count_subjects()
    {
        return $this->db->count_all_results('subjects');
    }

    function count_houses()
    {
        return $this->db->count_all_results('house');
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
 
}
