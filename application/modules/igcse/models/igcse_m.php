<?php
class Igcse_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('igcse', $data);
        return $this->db->insert_id();
    }

    //Create IGCSE Exam
    function create_exam($data) {
        $this->db->insert('igcse_exams', $data);
        return $this->db->insert_id();
    }

    //Create a Record
    function create_rec($table,$data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('igcse')->row();
    }

    function find1($id)
    {
        return $this->db->where(array('id' => $id))->get('igcse')->row();
    }

    function get_stream($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    function fetch_subject($id)
    {
        return $this->db->where(array('id' => $id))->get('subjects')->row();
    }

    function get_students($class)
    {
        $this->select_all_key('admission');
        $this->db->where($this->dx('class') . " ='" . $class . "'", NULL, FALSE);
        $this->db->where($this->dx('status') . " ='" . 1 . "'", NULL, FALSE);
        return $this->db->get('admission')->result();
    }

    // function get_students($class, $stream)
    // {
    //     $kla = $this->portal_m->get_class_stream($class, $stream);
    //     $this->select_all_key('admission');
    //     return $this->db->where($this->dx('class') . '=' . $kla->id, NULL, FALSE)->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();
    // }

    // function get_subjects($class, $term, $flag = 0, $group = 0)
    // {
    //     if ($flag)
    //     {
    //         $list = $this->get_full_subjects();
    //     }
    //     else
    //     {
    //         $list = $this->list_subjects_alt();
    //     }
    //     $ccla = $group ? $class : 0;
    //     if (!$group)
    //     {
    //         $rc = $this->db->where('id', $class)->get('classes')->row();
    //         $subrc = $this->populate('subjects', 'id', 'name');
    //         if ($rc && isset($rc->class))
    //         {
    //             $ccla = $rc->class;
    //         }
    //     }
    //     $subs = $this->db
    //                       ->where(array('class_id' => $ccla, 'term' => $term))
    //                       ->join('subjects', 'subjects.id = subject_id')
    //                       ->order_by('subject_id', 'ASC')
    //                       ->get('subjects_classes')
    //                       ->result();
    //     $fn = array();

    //     foreach ($subs as $ks)
    //     {
    //         $units = $this->fetch_by_subs($ks->subject_id);
    //         $outs = $this->fetch_out_of($ks->subject_id);
    //         $sname = isset($subrc[$ks->subject_id]) ? $subrc[$ks->subject_id] : '';
    //         $tt = isset($list[$ks->subject_id]) ? $list[$ks->subject_id] : '-';
    //         $sbk = $this->fetch_subject($ks->subject_id);
    //         $ttp = isset($sbk->is_optional) ? $sbk->is_optional : '';
    //         if (count($units))
    //         {
    //             $fn[$ks->subject_id] = array('title' => $tt, 'units' => $units, 'full' => $sname, 'outs' => $outs, 'opt' => $ttp);
    //         }
    //         else
    //         {
    //             $fn[$ks->subject_id] = array('title' => $tt, 'opt' => $ttp, 'full' => $sname);
    //         }
    //     }

    //     return $fn;
    // }

    function get_subjects($class,$term) {
        $list = $this->db
                    ->where('term',$term)
                    ->where('class_id', $class)
                    ->get('subjects_classes')
                    ->result();

        $subs = [];

        foreach ($list as $key => $l) {
            $subject = $this->get_subject($l->subject_id);

            $subs[$l->subject_id] = [
                'name' => $subject->name,
                'short_name' => $subject->short_name
            ];
        }

        return $subs;
     }

    public function get_exams_by_tid($exid)
    {
        $this->db->select('*');
        $this->db->from('igcse_exams');
        $this->db->where('tid', $exid);
        $this->db->limit(1); // Limit the result to 1 row
        $query = $this->db->get();

        return $query->row(); // Return the single row
    }

    // public function get_exams_by_tid($exid)
    // {
    //     $this->db->select('*');
    //     $this->db->from('igcse_exams');
    //     $this->db->where('tid', $exid);
    //     $this->db->limit(1); // Limit the result to 1 row
    //     $query = $this->db->get();

    //     return $query->row(); // Return the single row
    // }
    

     //Find Actual IGCSE Exam
     function find_igcse_exam($id) {
        return $this->db->where(array('id' => $id))->get('igcse_exams')->row();
     }

     //Function to Retrieve Grading System
     function retrieve_grading($gid) {
        return $this->db->where(array('grade_id' => $gid))->get('gs_grades')->result();
     }

     //Get marks for ranking 
     function get_computed_marks($classgrp = false,$tid = false) {
        if ($classgrp) {
            $this->db->where('class_group', $classgrp);
        }

        if ($tid) {
            $this->db->where('tid', $tid);
        }

        return $this->db->get('igcse_computed_marks')->result();
     }

     //Check whetehr marks Inserted
     function check_results($tid,$stu) {
        return $this->db
                    ->where(array('tid' => $tid))
                    ->where(array('student' => $stu))
                    ->get('igcse_final_results')
                    ->row();
     }

     //Function to get Subject Scores
     function subscores($tid,$classgrp,$sub) {
        return $this->db
                    ->where(array('tid' => $tid))
                    ->where(array('class_group' => $classgrp))
                    ->where(array('subject' => $sub))
                    ->get('igcse_computed_marks')
                    ->result();
     }


     function student_count($tid,$class) {
        return $this->db->where(array('tid' => $tid))->where('class',$class)->get('igcse_final_results')->result();
     }

     //The last four performances
     function last_four_scores($student) {
        return $this->db
                    ->where('student',$student)
                    ->order_by('tid','ASC')
                    ->limit(4)
                    ->get('igcse_final_results')
                    ->result();
     }

     //function get teacher assigned
     function teacher_assigned($class,$sub) {
        return $this->db
                    ->where('class',$class)
                    ->where('subject',$sub)
                    ->get('subjects_assign')
                    ->row();
     }

     //CompareScore 
     function compare_score($tid,$stu,$sub) {
        return $this->db
                ->where(array('tid' => $tid))
                ->where(array('student' => $stu))
                ->where(array('subject' => $sub))
                ->get('igcse_computed_marks')
                ->row();
     }

     //Compare the Previous Overall Score
     function prev_score($tid,$stu) {
        return $this->db
                ->where(array('tid' => $tid))
                ->where(array('student' => $stu))
                ->get('igcse_final_results')
                ->row();
     }

     //Check whether there are previously entered marks for that subject
     function check_marks($tid,$exid,$sub) {
        return $this->db
                    ->where(array('tid' => $tid))
                    ->where(array('exams_id' => $exid))
                    ->where(array('subject' => $sub))
                    ->get('igcse_marks_list')
                    ->result();
     }

     //Check out of
     function check_outof($tid,$exid) {

     }

     function student_scores($tid,$stu) {
        return $this->db
                    ->where(array('tid' => $tid))
                    ->where(array('student' => $stu))
                    ->get('igcse_computed_marks')
                    ->result();
     }

     //Function to get Marks for a student
     function check_student_marks($tid,$exid,$sub,$stu) {
        return $this->db
                ->where(array('tid' => $tid))
                ->where(array('exams_id' => $exid))
                ->where(array('subject' => $sub))
                ->where(array('student' => $stu))
                ->get('igcse_marks_list')
                ->row();
     }

     //Function to check marks for student
     function check_marks_availability($tid,$sub,$stu) {
        return $this->db
                ->where(array('tid' => $tid))
                ->where(array('subject' => $sub))
                ->where(array('student' => $stu))
                ->get('igcse_computed_marks')
                ->row();
     }

     //Get Exams
     function get_thread_exams($tid) {
        return $this->db
                    ->where(array('tid' => $tid))
                    ->get('igcse_exams')
                    ->result();
     }

    //Get all IGCSE Thread
    function all_igcse() {
        $list = $this->db
                    ->order_by('id','DESC')
                    ->get('igcse')
                    ->result();

        $threads = [];

        foreach ($list as $key => $l) {
            $threads[$l->id] = $l->title.' (Term '.$l->term.'/'.$l->year.')';
        }

        return $threads;
    }

     //Get marks by class stream
     function marks_by_stream($tid,$class) {
        return $this->db->where(array('tid' => $tid))->where('class',$class)->get('igcse_marks_list')->result();
     }

      //Get marks by class stream
      function marks_by_group($tid,$class) {
        return $this->db->where(array('tid' => $tid))->where('class_group',$class)->get('igcse_marks_list')->result();
     }

     //Get Cats Count 
     function cats($tid) {
        return $this->db->where(array('tid' => $tid))->where('type',2)->get('igcse_exams')->result();
     }

     //Function to get Marks
     function get_students_by_group($group = false) {
        $streams = $this->get_streams($group);

        $stus = [];

        foreach ($streams as $class) {
            $this->select_all_key('admission');
            $this->db->where($this->dx('class') . " ='" . $class . "'", NULL, FALSE);
            $list = $this->db->get('admission')->result();

            $studes = [];

            foreach ($list as $key => $l) {
                $studes[] = $l->id;
            }

            $stus[$class] = $studes;
        }

        $result = [];

        foreach ($stus as $students) {
            $result = array_merge($result, $students);
        }

        return $result;        
     }

     //Get Subjects by Class
     function get_class_subjects($group = false,$term = false) {
        $streams = $this->get_streams($group);
        $subjects = $this->populate('subjects','id','name');

        $list = $this->db
                     ->where('term',$term)
                     ->where_in('class_id', $streams)
                     ->get('subjects_classes')
                     ->result();

        $subs = [];

        foreach ($list as $key => $l) {
            $subject = $this->get_subject($l->subject_id);

            $subs[$l->subject_id] = [
                'name' => $subject->name,
                'short_name' => $subject->short_name
            ];
        }

        return $subs;
     }

     function get_class_subjects2($group = false,$term = false) {
        $streams = $this->get_streams($group);
        $subjects = $this->populate('subjects','id','name');

        $list = $this->db
                     ->where('term',$term)
                     ->where_in('class_id', $streams)
                     ->get('subjects_classes')
                     ->result();

        $subs = [];

        foreach ($list as $key => $l) {
            $subject = $this->get_subject($l->subject_id);

            $subs[$l->subject_id] = $subject->name;
        }

        return $subs;
     }


     //Get
     

     function get_subjects2($class,$term) {
        $list = $this->db
                    ->where('term',$term)
                    ->where('class_id', $class)
                    ->get('subjects_classes')
                    ->result();

        $subs = [];

        foreach ($list as $key => $l) {
            $subject = $this->get_subject($l->subject_id);

            $subs[$l->subject_id] = $subject->name;
        }

        return $subs;
     }

     //Function to map grade

     //Function to find subject
     function get_subject($id) {
        return $this->db
                    ->where(array('id' => $id))
                    ->get('subjects')
                    ->row();
     }

     //Function to get student mark 
     function get_stu_mark($stu,$sub,$ex) {
        return $this->db
                    ->where('student',$stu)
                    ->where('subject', $sub)
                    ->where('exams_id', $ex)
                    ->get('igcse_marks_list')
                    ->row();
     }

     function get_students_by_stream($class = false) {
        $this->select_all_key('admission');
        $this->db->where($this->dx('class') . " ='" . $class . "'", NULL, FALSE);
        $list = $this->db->get('admission')->result();

        $stus = [];

        foreach ($list as $key => $l) {
            $stus[] = $l->id;
        }

        return $stus;
     }

     //Get streams 
     function get_streams($group) {
        $list = $this->db->where('class', $group)->get('classes')->result();

        $strlist = [];

        foreach ($list as $key => $l) {
            $strlist[] = $l->id;
        }

        return $strlist;
     }

     //Prepare Exasms
     function list_exams($id) {
        $list = $this->db->where('id !=', $id)->get('igcse')->result();

        $exams = [];

        foreach ($list as $key => $l) {
            $exams[$l->id] = $l->title.' ( Term '.$l->term.' '.$l->year.')';
        }

        return $exams;
     }


     //Get final results by students 
     function results($tid,$students = array()) {
        return $this->db->where(array('tid' => $tid))->where_in('student',$students)->order_by('total','DESC')->get('igcse_final_results')->result();
     }

     //Function to get marks list
     function marks_list($tid,$subject,$students = array()) {
        return $this->db->where(array('tid' => $tid))
                        ->where(array('subject' => $subject))
                        ->where_in('student',$students)
                        ->order_by('total','DESC')
                        ->get('igcse_computed_marks')
                        ->result();
     }

     //Get computed marks
     function get_student_computed_marks($tid,$students = array()) {
        return $this->db->where(array('tid' => $tid))->where_in('student',$students)->get('igcse_computed_marks')->result();
     }

     

     //Get marks by 

     function mains($tid) {
        return $this->db->where(array('tid' => $tid))->where('type',1)->get('igcse_exams')->result();
     }

    function exists($id)
    {
        return $this->db->where( array('id' => $id))->count_all_results('igcse') >0;
    }

    function count()
    {        
        return $this->db->count_all_results('igcse');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('igcse', $data);
    }

    function update_table($id, $table, $data)
    {
         return  $this->db->where('id', $id) ->update($table, $data);
    }

    function update_marks_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('igcse_marks_list', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();
       $options=array();
    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('igcse', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  igcse (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }


    function get_teachers()
    {
        //$this->db->select('teachers.id as id ,' . $this->dxa('first_name') . ', ' . $this->dxa('last_name'), FALSE);
        $this->db->select('teachers.id as id ,' . $this->dx('teachers.first_name') . ' as first_name, ' . $this->dx('teachers.last_name') . ' as last_name', FALSE);
        return $this->db->where($this->dx('teachers.status') . ' != 0', NULL, FALSE)
            ->where('users.id', $this->user->id) // Select where user_id is equal to $this->user->id
            ->join('teachers', 'users.id=' . $this->dx('user_id'))
            ->limit(1) // Limit the result to only one row
            ->get('users')
            ->row(); // Return only one row
    }

    function get_teacher($id)
    {
        $this->select_all_key('teachers');
        $this->db->where($this->dx('user_id') . " ='" . $id . "'", NULL, FALSE);
        $this->db->where($this->dx('status') . " ='" . 1 . "'", NULL, FALSE);
        return $this->db->get('teachers')->row();
    }

    function is_classteacher($class){
        $query = $this->db->where('id', $class)
        ->get('classes');
        return $query->row();

    }

    function list_teachers()
    {
        $teacher = $this->get_teachers(); 
        if ($teacher) {
            return array($teacher->id => $teacher->first_name . ' ' . $teacher->last_name);
        } else {
           return array();
        }
    }

    function fetch_subjects_by_class($selectedClassId, $teacher)
    {
        $this->db->where('class', $selectedClassId)
            ->where('teacher', $teacher); // Changed 'class' to 'teacher' for the second condition
        $query = $this->db->get('subjects_assign');
        return $query->result();
    }

    function fetch_subjects_by_classteacher($selectedClassId)
    {
        $this->db->where('class_id', $selectedClassId);
        $query = $this->db->get('subjects_classes');
        return $query->result();
    }
    function fetch_class($selectedClassId){

        $this->db->where('class', $selectedClassId);
        $query = $this->db->get('classes');
        return $query->row();
        
    }


    function fetch_outof($exam)
    {

        $query = $this->db->where('exams_id', $exam)
            ->get('igcse_marks_list');
        return $query->row();
    }

    function fetch_exam_details($exam)
    {

        $query = $this->db->where('id', $exam)
            ->get('igcse_exams');
        return $query->row();
    }

    function fetch_classgroup($class)
    {

        $query = $this->db->where('id', $class)
            ->get('classes');
        return $query->row();
    }

    function get_marks_trs($class, $subject, $thread, $exam)
    {
        $query = $this->db->where('class', $class)
            ->where('tid', $thread)
            ->where('subject', $subject)
            ->where('exams_id', $exam)
            ->get('igcse_marks_list');
        return $query->result();
    }

    function get_examstable($id){
        $query = $this->db->where('id', $id)
               ->get('igcse_exams');
        return $query->row();  
    }




    function get_class_with_teacher()
    {
        
        $teacher = $this->get_teachers();

        if ($teacher) {
           
            return $this->db->select('class')
                ->where('teacher', $teacher->id)
                ->group_by('class') // Group by class to avoid duplicate classes
                ->get('subjects_assign')
                ->result();
        } else {
            
            return array();
        }
    }

    function class_teacher($id)
    {
        $this->db->select('*');
        $this->db->from('classes');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row(); 
      
    }

    

  

    function get_st($id)
    {
        $this->select_all_key('admission');
        $this->db->where('id', $id);
        return $this->db->get('admission')->row();
    }

    function gettotal($class, $exam)
    {
        $query = $this->db->where('class', $class)
            ->where('tid', $exam)
            ->order_by('total', 'desc') // Order by total_score in descending order
            ->get('igcse_final_results');
        return $query->result();
    }

    function tidfound($thread){
        $query = $this->db->where('tid', $thread)
              ->get('igcse_final_results');
        return $query->result();
    }

    public function get_results($student, $subject, $exam)
    {
        $this->db->select('*');
        $this->db->from('igcse_marks_list');
        $this->db->where_in('student', $student);
        $this->db->where('subject', $subject);
        $this->db->where('exams_id', $exam);
        $query = $this->db->get();
        return $query->result(); // Return the results
    }

    public function get_exams_by_thread($exid)
    {
        $this->db->select('*');
        $this->db->from('igcse_exams');
        $this->db->where('tid', $exid);
        $query = $this->db->get();
        return $query->result(); // Return the single row
    }

    
    function get_grading_system()
    {
        $result = $this->db->select('grading_system.*')
        ->order_by('created_on', 'DESC')
        ->get('grading_system')
        ->result();

        $arr = array();
        foreach ($result as $res) {
            $arr[$res->id] = $res->title;
        }

        return $arr;
    }
    public function get_exams()
    {
        $this->db->select('*');
        $this->db->from('igcse');
        $query = $this->db->get();

        return $query->result(); // Return the single row
    }

    public function save_marks($data)
    {
        // Insert new marks
        $this->db->insert('igcse_marks_list', $data);
    }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('igcse', $limit, $offset);

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