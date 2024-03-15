<?php

class Assessment_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
                $this->db_set();
        }

        function create($data)
        {
                $this->db->insert('assessment', $data);
                return $this->db->insert_id();
        }

        function create_sub($data)
        {
                $this->db->insert('assessment_sub', $data);
                return $this->db->insert_id();
        }

        function create_unit($data)
        {
                $this->db->insert('assessment_units', $data);
                return $this->db->insert_id();
        }

        function create_grading($data)
        {
                $this->db->insert('assessment_grading', $data);
                return $this->db->insert_id();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('assessment')->row();
        }

        function fetch_assessment($id)
        {
                $row = $this->db->where(array('id' => $id))->get('assessment')->row();
                if (empty($row))
                {
                        return array();
                }
                $row->grades = $this->db->where(array('assessment_id' => $id))->get('assessment_sub')->result();

                return $row;
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('assessment') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('assessment');
        }

        function count_units()
        {
                return $this->db->count_all_results('assessment_units');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('assessment', $data);
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

        function delete($id)
        {
                return $this->db->delete('assessment', array('id' => $id));
        }

        /**
         * Setup DB Table Automatically
         * 
         */
        function db_set()
        {
                $this->db->query(" 
                        CREATE TABLE IF NOT EXISTS `assessment` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `student` int(11) DEFAULT NULL,
                          `comment` text,
                          `created_by` int(11) DEFAULT NULL,
                          `modified_by` int(11) DEFAULT NULL,
                          `created_on` int(11) DEFAULT NULL,
                          `modified_on` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;  ");

                $this->db->query(" 
                        CREATE TABLE IF NOT EXISTS `assessment_grading` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `symbol` int(11) DEFAULT NULL,
                          `indicator` varchar(255) NOT NULL,
                          `min_marks` float DEFAULT NULL,
                          `max_marks` float DEFAULT NULL,
                          `description` varchar(255) DEFAULT NULL,
                          `created_by` int(11) DEFAULT NULL,
                          `modified_by` int(11) DEFAULT NULL,
                          `created_on` int(11) DEFAULT NULL,
                          `modified_on` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC; ");

                $this->db->query(" 
                        CREATE TABLE IF NOT EXISTS `assessment_sub` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `assessment_id` int(11) DEFAULT NULL,
                          `unit` int(11) DEFAULT NULL,
                          `grade` int(11) DEFAULT NULL,
                          `created_by` int(11) DEFAULT NULL,
                          `modified_by` int(11) DEFAULT NULL,
                          `created_on` int(11) DEFAULT NULL,
                          `modified_on` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC; ");

                $this->db->query(" 
                        CREATE TABLE IF NOT EXISTS `assessment_units` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `unit` varchar(255) NOT NULL DEFAULT '',
                          `cat` int(11) DEFAULT NULL,
                          `created_by` int(11) DEFAULT NULL,
                          `modified_by` int(11) DEFAULT NULL,
                          `created_on` int(11) DEFAULT NULL,
                          `modified_on` int(11) DEFAULT NULL,
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC; ");
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('assessment', $limit, $offset);

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

        function paginate_units($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                return $this->db->order_by('id', 'desc')
                                          ->get('assessment_units', $limit, $offset)
                                          ->result();
        }

        function get_grading()
        {
                return $this->db->order_by('id', 'desc')
                                          ->get('assessment_grading')
                                          ->result();
        }

        function fetch_units($id)
        {
                return $this->db
                                          ->where('cat', $id)
                                          ->order_by('id', 'desc')
                                          ->get('assessment_units')
                                          ->result();
        }

}
