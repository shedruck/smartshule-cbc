<?php
class Lesson_plan_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($table,$data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('lesson_plan')->row();
    }

    function find_scheme($id)
    {
        return $this->db->where(array('id' => $id))->get('schemes_of_work')->row();
    }


    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('lesson_plan') > 0;
    }


    function count()
    {

        return $this->db->count_all_results('lesson_plan');
    }

    function update_attributes($table,$id, $data)
    {
        return  $this->db->where('id', $id)->update($table, $data);
    }

    function populate($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown) {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    function delete($id)
    {
        return $this->db->delete('lesson_plan', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  lesson_plan (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function paginate_all($limit, $page, $teacher = FALSE)
    {
        $offset = $limit * ($page - 1);

        $this->db->order_by('id', 'desc');

        if ($teacher) {
            $this->db->where('created_by', $teacher);
            $offset = 0;
        }
        $query = $this->db->get('lesson_plan', $limit, $offset)->result();

        $result = array();

        foreach ($query as $p) {
            $p->Scheme = $this->find_scheme($p->scheme);
            $result[] = $p;
        }

        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    function count_for_teacher($teacher_id)
    {
        $this->db->where('created_by', $teacher_id);
        return $this->db->count_all_results('lesson_plan');

    }

    function paginate_all_bk($limit, $page)
    {
        $offset = $limit * ($page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('lesson_plan', $limit, $offset)->result();

        $result = array();

        foreach ($query as $p) 
        {
            $p->Scheme =  $this->find_scheme($p->scheme);
            $result[] =  $p;
        }

        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }


    function _get_scheme()
    {
        $out = [];
        $list =  $this->db->where('created_by',$this->ion_auth->get_user()->id)->get('schemes_of_work')->result();

        foreach($list as $p)
        {
            $class = isset($this->classes[$p->level]) ? $this->classes[$p->level] : '';
            $out[$p->id] = $class.' Term '.$p->term.' '.$p->year.' week '.$p->week.' lesson '.$p->lesson;
        }

        return $out;
    }

    function get_by_scheme($scheme)
    {
        return $this->db->where('scheme',$scheme)->get('lesson_plan')->row();
    }

    function has_steps($scheme,$plan, $step)
    {
        return $this->db->where(['scheme' => $scheme, 'lesson_plan' => $plan,'step' => $step])->get('lesson_developments')->row();
    }


    function _get_steps($plan, $scheme)
    {
        return $this->db->where(['scheme' => $scheme, 'lesson_plan' => $plan])->order_by('step','ASC')->get('lesson_developments')->result();
    }
   

    function get_the_plan($plan,$scheme)
    {
        $list = $this->db->where(['id' => $plan,'scheme' => $scheme])->get('lesson_plan')->row();
        $list->Scheme = $this->find_scheme($scheme);
        $list->steps = $this->_get_steps($plan,$scheme);
        return $list;
    }

    function count_students($class)
    {
        $list = $this->db->where('class',$class)->get('classes')->result();

        foreach($list as $p)
        {
            $this->select_all_key('admission');
            $count = $this->db->where($this->dx('class'). '=' .$p->id,NULL, FALSE)->count_all_results('admission');
        }

        return $count;
    }

    function get_trs()
    {
        $this->select_all_key('teachers');
        $list =  $this->db->where($this->dx('status') . '=1', NULL, FALSE)->get('teachers')->result();
        $teachers = [];
        foreach ($list as $l) {
            $teachers[$l->user_id] = $l->first_name . ' ' . $l->middle_name . ' ' . $l->last_name;
        }
        return $teachers;
    }

    function get_teacher_plan($limit, $page,$id)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $this->db->where('teacher', $id);
            $query = $this->db->get('lesson_plan', $limit, $offset);

            $result = array();

            if ($query)
            {
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
            else return FALSE;

    }
}