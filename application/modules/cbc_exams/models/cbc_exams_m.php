<?php
class Cbc_exams_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
        $this->db_set2();
    }

    function create($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('cbc_exams')->row();
    }


    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('cbc_exams') > 0;
    }


    function count()
    {

        return $this->db->count_all_results('cbc_exams');
    }

    function update_attributes($table, $id, $data)
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
        return $this->db->delete('cbc_exams', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  cbc_exams (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`term` INT(11) NULL DEFAULT '0',
	`year` INT(11) NULL DEFAULT '0',
	`class` INT(11) NULL DEFAULT '0',
	`exam` INT(11) NULL DEFAULT '0',
	`subject` INT(11) NULL DEFAULT '0',
	`status` INT(11) NULL DEFAULT '0',
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }


    function db_set2()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  cbc_exams_marks (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`exam_id` INT(11) NULL DEFAULT '0',
	`student` INT(11) NULL DEFAULT '0',
	`subject` INT(11) NULL DEFAULT '0',
	`term` INT(11) NULL DEFAULT '0',
	`year` INT(11) NULL DEFAULT '0',
	`class` INT(11) NULL DEFAULT '0',
	`exam` INT(11) NULL DEFAULT '0',
	`marks` INT(11) NULL DEFAULT '0',
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ($page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('cbc_exams', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    function get_subjects_assigned($teacher, $class)
    {
        $res = [];
        $list = $this->db->where('type', 2)->where('teacher', $teacher)->where('class', $class)->get('subjects_assign')->result();
        $subjects = $this->populate('cbc_subjects', 'id', 'name');
        foreach ($list as $p) {
            $sub = isset($subjects[$p->subject]) ? $subjects[$p->subject] : '';
            $cl = isset($this->streams[$p->class]) ? $this->streams[$p->class] : '';
            $res[$p->subject] = $sub . ' ' . $cl;
        }

        return $res;
    }

    function get_subjects_class($class)
    {
        $res = [];
        $list = $this->db->where('type', 2)->where('class', $class)->get('subjects_assign')->result();
        $subjects = $this->populate('cbc_subjects', 'id', 'name');
        foreach ($list as $p) {
            $sub = isset($subjects[$p->subject]) ? $subjects[$p->subject] : '';
            $cl = isset($this->streams[$p->class]) ? $this->streams[$p->class] : '';
            $res[$p->subject] = $sub;
        }

        return $res;
    }

    function get_students($class)
    {
        $this->select_all_key('admission');
        $res = [];
        $list = $this->db->where($this->dx('status') . ' =1', NULL, FALSE)
            ->where($this->dx('class') . '=' . $class, NULL, FALSE)
            ->order_by($this->dx('admission.first_name'), 'ASC', FALSE)
            ->get('admission')
            ->result();

        foreach ($list as $p) {
            $res[] = [
                'student' => $p->id,
                'name' => $p->first_name . ' ' . $p->middle_name . ' ' . $p->last_name,
                'admission_number' => $p->admission_number
            ];
        }

        return   $res;
    }


    function check_exam($exam, $term, $year, $subject, $class)
    {
        $list =  $this->db
            ->where('exam', $exam)
            ->where('term', $term)
            ->where('year', $year)
            ->where('subject', $subject)
            ->where('class', $class)
            ->get('cbc_exams')->row();

        return $list;
    }

    function find_exams($id)
    {
        return $this->db->where('exam_id',$id)->get('cbc_exams_marks')->row();
    }


    function paginate_mine($limit, $page)
    {
        $user = $this->ion_auth->get_user();
        $offset = $limit * ($page - 1);

        $this->db->order_by('id', 'desc');
        $this->db->where('created_by', $user->id);
        $query = $this->db->get('cbc_exams', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row) {
            $result[] = $row;
        }

        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }


    function find_examms($id)
    {
        return $this->db->where('exam_id', $id)->get('cbc_exams_marks')->result();
    }

    function get_row($id)
    {
        return $this->db->where('id', $id)->get('cbc_exams')->row();
    }


    function get_marks($class, $exam, $term, $year)
    {
        $payload = $this->db->where([
            'class' => $class,
            'exam' => $exam,
            'term' => $term,
            'year' => $year
        ])->get('cbc_exams_marks')->result();

        $out = [];
         
        foreach($payload as $p)
        {
            $tr = $this->ion_auth->get_user($p->created_by);
            $ini = $this->generateInitials($tr->first_name, $tr->last_name);
            $out[$p->student][$p->subject][] = ['marks' => $p->marks,'tr' => $tr->first_name.' '.$tr->last_name];
        }

        return $out;
    }


    function generateInitials($firstName, $lastName)
    {
        // Use the first character of the first name and last name to form initials
        $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));

        return $initials;
    }


 




    function calculateGradeAndRemarks($marks)
    {
        $gradingSystem = array(
            'EE' => array('min' => 90, 'max' => 100, 'remarks' => 'EXEEDING EXPECTATIONS'),
            'ME' => array('min' => 70, 'max' => 89, 'remarks' => 'MEETING EXPECTATIONS'),
            'AE' => array('min' => 50, 'max' => 69, 'remarks' => 'APPROACHING EXPECTATIONS'),
            'BE' => array('min' => 0, 'max' => 59, 'remarks' => 'BELOW EXPECTATIONS')
        );

         
        foreach ($gradingSystem as $grade => $range) 
        {
            if ($marks >= $range['min'] && $marks <= $range['max']) 
            {
                $result['grade'] = $grade;
                $result['remarks'] = $range['remarks'];
                return $result;
            }
        }
        
        return array('error' => 'Invalid marks');
    }

 


   
}
