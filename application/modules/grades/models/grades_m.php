<?php

class Grades_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('grades', $data);
                return $this->db->insert_id();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('grades')->row();
        }

        function find_grading($id)
        {
                return $this->db->where(array('id' => $id))->get('grading_records')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('grades') > 0;
        }

        function exists_grade($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('grading_records') > 0;
        }

        function exists_sys($id)
        {
                return $this->db->where(array('grading_id' => $id))->count_all_results('grading_records') > 0;
        }

        function count()
        {

                return $this->db->count_all_results('grades');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('grades', $data);
        }

        function update_grading($id, $data)
        {
                return $this->db->where('id', $id)->update('grading_records', $data);
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
                return $this->db->delete('grades', array('id' => $id));
        }

        function delete_records($id, $grade)
        {
                return $this->db->delete('grading_records', array('grading_id' => $id, 'grade' => $grade));
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('grades', $limit, $offset);

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
