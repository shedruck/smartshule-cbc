<?php

class Activities_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
                $this->db_set();
        }

        function create($data)
        {
                $this->db->insert('activities', $data);
                return $this->db->insert_id();
        }

        /**
         * 
         * @param int $activity
         * @param int $teacher
         * @param int $term
         * @param int $year
         * @return boolean
         */
        function assign_teacher($activity, $teacher, $term, $year)
        {
                $exists = $this->get_current_teacher($activity, $term, $year);
                if (empty($exists))
                {
                        $form = array(
                            'activity' => $activity,
                            'teacher' => $teacher,
                            'term' => $term,
                            'year' => $year,
                            'created_by' => $this->user->id,
                            'created_on' => time()
                        );
                        return $this->insert_key_data('extras_teacher', $form);
                }

                return $this->update_key_data($exists->id, 'extras_teacher', array('teacher' => $teacher, 'modified_on' => time(), 'modified_by' => $this->user->id,));
        }

        /**
         * list_teachers
         * 
         * @return result array
         */
        function list_teachers()
        {
                $group = $this->config->item('teachers');
                $results = $this->db->select('users.id as id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
                             ->where($this->dx('users_groups.group_id') . '= ' . $group, NULL, FALSE)
                             ->where($this->dx('users.active') . '= 1', NULL, FALSE)
                             ->join('users_groups', 'users.id=' . $this->dx('user_id'))
                             ->get('users')
                             ->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->first_name . ' ' . $res->last_name;
                }
                return $arr;
        }

        function get_current_teacher($id, $term, $year)
        {
                $this->select_all_key('extras_teacher');
                return $this->db
                                          ->where($this->dx('activity') . ' = ' . $id, NULL, FALSE)
                                          ->where($this->dx('term') . ' = ' . $term, NULL, FALSE)
                                          ->where($this->dx('year') . ' = ' . $year, NULL, FALSE)
                                          ->get('extras_teacher')
                                          ->row();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('activities')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('activities') > 0;
        }

        function count()
        {

                return $this->db->count_all_results('activities');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('activities', $data);
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
                return $this->db->delete('activities', array('id' => $id));
        }

        /**
         * Setup DB Table Automatically
         * 
         */
        function db_set()
        {
                $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  activities (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('activities', $limit, $offset);

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
