<?php

class Students_placement_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('students_placement', $data);
                return $this->db->insert_id();
        }

        //Custom Codes
        //Get Classes
        public function get_class()
        {
                $arr = array();

                foreach ($this->classlist as $key => $resp)
                {
                        $res = (object)$resp;

                        $arr[$key] = $res->name;
                }

                return $arr;
        }

        //Get Placement Positions
        public function get_positions()
        {

                $results = $this->db->select('placement_positions.*')
                             ->order_by('created_on', 'DESC')
                             ->get('placement_positions')
                             ->result();

                $arr = array();

                foreach ($results as $res)
                {

                        $arr[$res->id] = $res->title;
                }

                return $arr;
        }

        //Generated Codes

        function get_all()
        {
                return $this->db->select('students_placement.*')->order_by('created_on', 'DESC')->get('students_placement')->result();
        }

        function get($id)
        {
                return $this->db->where(array('student' => $id))->get('students_placement')->result();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('students_placement')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('students_placement') > 0;
        }

        function count()
        {

                return $this->db->count_all_results('students_placement');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('students_placement', $data);
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
                return $this->db->delete('students_placement', array('id' => $id));
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('students_placement', $limit, $offset);

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
