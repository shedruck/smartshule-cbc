<?php

class Assignments_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('assignments', $data);
                return $this->db->insert_id();
        }

        function insert_classes($data)
        {
                $this->db->insert('assignment_list', $data);
                return $this->db->insert_id();
        }

        function insert_extras($data)
        {
                $this->db->insert('assignment_extras', $data);
                return $this->db->insert_id();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('assignments')->row();
        }

		function find_done($id)
        {
                return $this->db->where(array('id' => $id))->get('assignments_done')->row();
        }
		
		function done($id)
        {
                return $this->db->where(array('assignment' => $id))->get('assignments_done')->result();
        }

		function class_details($id,$creator)
        {
                return $this->db->where(array('id' => $id))->get('assignments')->row();
        }

        function get_my()
        {
                $u = $this->ion_auth->get_user()->id;
                $this->db->where('created_by', $u);
                return $this->db->get('assignments')->result();
        }

        function get_classes($id)
        {
                return $this->db->where(array('assgn_id' => $id))->get('assignment_list')->result();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('assignments') > 0;
        }
		
		function done_exists($id,$stud)
        {
                return $this->db->where(array('id' => $id,'student'=>$stud))->count_all_results('assignments_done') > 0;
        }

		function exists_class_assgn($id,$class)
        {
		
                return $this->db->where(array('assgn_id' => $id,'class'=>$class))->count_all_results('assignment_list') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('assignments');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('assignments', $data);
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
                return $this->db->delete('assignments', array('id' => $id));
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                //$u = $this->ion_auth->get_user()->id;
                //$this->db->where('created_by', $u);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('assignments', $limit, $offset);

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
		
		

        function list_assignments()
        {
                $this->select_all_key('admission');
                $this->db->join('admission', 'admission.id=student_id');
                $res = $this->db->where($this->dx('admission.status').'=1', null, false)
                                  ->where('assign_parent.parent_id', $this->parent->profile->id)->get('assign_parent')->result();

                $classes = array();
                $slids = array();
                foreach ($res as $r)
                {
                        $classes[] = $r->class;
                }
                $final = array_unique($classes);

                foreach ($final as $r)
                {
                        foreach ($this->list_ids($r) as $v)
                        {
                                $slids[] = $v;
                        }
                }

                return $this->get_list(array_unique($slids));
        }

        function list_ids($class)
        {
			  
                $list = $this->db->where('class', $class)->get('assignment_list')->result();

                $ids = array();
                foreach ($list as $l)
                {
                        $ids[] = $l->assgn_id;
                }
                return $ids;
        }

        function get_list($ids)
        {
			 $this->db->order_by('id','desc');
                if (empty($ids))
                {
                    $ids = array(0);
                }
				
                return $this->db->select('assignments.*')
                                          ->where_in('assignments.id', $ids)
                                          ->get('assignments')
                                          ->result();
        }
		
	function get_stud_assignments($student)
        {
		
			    $st = $this->portal_m->find($student);
				
				  foreach ($this->list_ids($st->class) as $v)
                        {
                                $slids[] = $v;
                        }
						
						//print_r(array_unique($slids));die;
						
				 return $this->get_list(array_unique($slids));
				 
                //$list = $this->db->where('class', $st->class)->get('assignment_list')->result();

              
        }

}
