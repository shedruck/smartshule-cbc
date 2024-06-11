<?php

class Cbc_tr extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function exam_setting($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    //Get Mark by id
    function find_mark($id) {
        return $this->db
                    ->where('id',$id)
                    ->get('cbc_marks')
                    ->row();
    }

    //Check if Combined Marks is already there
    function check_marks($tid,$stu,$sub) {
        return $this->db
                    ->where('tid',$tid)
                    ->where('student',$stu)
                    ->where('subject',$sub)
                    ->get('cbc_subs_included')
                    ->row();
    }

    //Check if Final Results already computed
    function check_final_results($tid,$student) {
        return $this->db
                    ->where('tid',$tid)
                    ->where('student',$student)
                    ->get('cbc_final_results')
                    ->row();
    }

    

    //Check Grade
    function get_grade($gid,$marks) {
        $gradingsystem = $this->db
                              ->where('grade_id',$gid)
                              ->get('gs_grades')
                              ->result();

        foreach ($gradingsystem as $gs) {
            if ($marks >= $gs->minimum_marks && $marks <= $gs->maximum_marks) {
                $grade = $gs->grade;
                $points = $gs->points;
                $comment = $gs->comment;
            }
        }

        return array(
            'grade' => $grade,
            'points' => $points,
            'comment' => $comment
        );
    }

    function add_social($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }


    function my_classes()
    {
        $list =  $this->db->where('teacher', $this->profile->id)->where(['term' => $this->school->term, 'year' => $this->school->year, 'type' => 2])->group_by('class')->get('subjects_assign')->result();

        $fn = [];
        $pop =  $this->count_students();
        foreach ($list as $p) {
            $cls = isset($this->streams[$p->class]) ? $this->streams[$p->class] : 'Unknown Class';
            $tt = isset($pop[$p->class]) ? $pop[$p->class]  : 0;
            $fn[$p->class] = [
                'id' => $p->class,
                'name' => $cls,
                'total' => $tt
            ];
        }

        return $fn;
    }

    function my_classes2() {
        if ($this->profile->special == 1) {
            return $this->get_all_classes();
        } else {
            return $this->get_assigned_classes_only();
        }
        
    }

    //Function to get all classes
    function get_all_classes() {
        $list = $this->db
                     ->get('classes')
                     ->result();

        $pop =  $this->count_students();
        $out = [];

        foreach ($list as $key => $l) {
            $cls = isset($this->streams[$l->id]) ? $this->streams[$l->id] : 'Unknown Class';
            $tt = isset($pop[$l->id]) ? $pop[$l->id]  : 0;

            $out[$l->id] = [
                'id' => $l->id,
                'name' => $cls,
                'total' => $tt
            ];
        }

        return $out;
    }

    //Function to get only assigned Classes
    function get_assigned_classes_only() {
        $list =  $this->db->where('teacher', $this->profile->id)->where(['term' => $this->school->term, 'year' => $this->school->year, 'type' => 1])->group_by('class')->get('subjects_assign')->result();

        $fn = [];
        $pop =  $this->count_students();
        foreach ($list as $p) {
            $cls = isset($this->streams[$p->class]) ? $this->streams[$p->class] : 'Unknown Class';
            $tt = isset($pop[$p->class]) ? $pop[$p->class]  : 0;
            $fn[$p->class] = [
                'id' => $p->class,
                'name' => $cls,
                'total' => $tt
            ];
        }

        return $fn;
    }

    function count_students()
    {
        $this->select_all_key('admission');
        $list =  $this->db->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();

        $out = [];
        foreach ($list as $p) {
            $out[$p->class][] = $p;
        }

        $fn = [];

        foreach ($out as $cls => $vl) {
            $fn[$cls] = count($vl);
        }

        return $fn;
    }

    //function to get level marks
    function get_marks($level,$exams) {
        if (count($exams) == 0) {
            return [];
        }

        return $this->db
                    ->where('class_grp',$level)
                    ->where_in('exam',$exams)
                    ->get('cbc_marks')
                    ->result();
    }

    function populate($table, $id, $name)
    {
        $rs = $this->db->select('*')->order_by($id)->get($table)->result();

        $options = [];
        foreach ($rs as $r) {
            $options[$r->{$id}] = $r->{$name};
        }
        return $options;
    }

    function find_allocation($clas)
    {
        $list =  $this->db
            ->where('teacher', $this->profile->id)
            ->where(
                [
                    'term' => $this->school->term,
                    'year' => $this->school->year,
                    'class' => $clas,
                    'type' => 2
                ]
            )
            ->get('subjects_assign')->result();

        $sub =  $this->populate('cbc_subjects', 'id', 'name');
        // $sub =  $this->populate('subjects', 'id', 'name');


        $out = [];
        foreach ($list as $p) {
            $nm = isset($sub[$p->subject]) ? $sub[$p->subject] : 'Undefined subject';
            $out[] =  [
                'id' => $p->subject,
                'name' => $nm
            ];
        }

        return $out;
    }

    function find_allocation2($clas)
    {
        if ($this->profile->special == 1) {
            $out = $this->get_all_class_subjects($clas);
        } else {
            $out = $this->find_allocation($clas);
        }

        return $out;
    }

    //Function Get all class subjects
    function get_all_class_subjects($clas)
    {
        $class = $this->get_cls_group($clas);

        $list =  $this->db
            ->where(
                [
                    'term' => $this->school->term,
                    // 'year' => $this->school->year,
                    'class_id' => $class->class,
                ]
            )
            ->get('subjects_classes')
            ->result();

        $sub =  $this->populate('cbc_subjects', 'id', 'name');
        // $sub =  $this->populate('subjects', 'id', 'name');

        $out = [];
        foreach ($list as $p) {
            $nm = isset($sub[$p->subject_id]) ? $sub[$p->subject_id] : 'Undefined subject';
            $out[] =  [
                'id' => $p->subject_id,
                'name' => $nm
            ];
        }

        return $out;

        // return $list;
    }

    function get_all_class_subjects2($clas)
    {
        $class = $this->get_cls_group($clas);

        $list =  $this->db
            ->where(
                [
                    'class_id' => $clas,
                ]
            )
            ->get('subjects_classes')
            ->result();

        // $sub =  $this->populate('cbc_subjects', 'id', 'name');
        $sub =  $this->populate('subjects', 'id', 'name');

        $out = [];
        foreach ($list as $p) {
            $nm = isset($sub[$p->subject_id]) ? $sub[$p->subject_id] : 'Undefined subject';
            $out[$p->subject_id] = $nm;
        }

        return $out;

        // return $list;
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

     //Get streams 
     function get_streams($group) {
        $list = $this->db->where('class', $group)->get('classes')->result();

        $strlist = [];

        foreach ($list as $key => $l) {
            $strlist[] = $l->id;
        }

        return $strlist;
     }


    //Get Class Group
    function get_cls_group($clas)
    {
        return $this->db->where('id', $clas)->get('classes')->row();
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

    function get_students_perstream($class = false)
    {
        $this->select_all_key('admission');
        $this->db->where($this->dx('class') . " ='" . $class . "'", NULL, FALSE);
        $list = $this->db->get('admission')->result();

        $stus = [];

        foreach ($list as $key => $l) {
            $stus[$l->id] = $l->first_name.'  '. $l->last_name;
        }

        return $stus;
    }

     //Get final results by students 
     function results($tid,$students = array()) {
        return $this->db
                    ->where(array('tid' => $tid))
                    ->where_in('student',$students)
                    ->order_by('total_marks','DESC')
                    ->get('cbc_final_results')
                    ->result();
     }

     //Compare the Previous Overall Score
     function prev_score($tid,$stu) {
        return $this->db
                ->where(array('tid' => $tid))
                ->where(array('student' => $stu))
                ->get('cbc_final_results')
                ->row();
     }

     function student_scores($tid,$stu) {
        // print_r($subids);
        // die;
        return $this->db
                    ->where(array('tid' => $tid))
                    ->where(array('student' => $stu))
                    // ->where_in(array('subject' => $subids))
                    ->get('cbc_subs_included')
                    ->result();
     }

     //CompareScore 
     function compare_score($tid,$stu,$sub) {
        return $this->db
                ->where(array('tid' => $tid))
                ->where(array('student' => $stu))
                ->where(array('subject' => $sub))
                ->get('cbc_subs_included')
                ->row();
     }

     //The last four performances
     function last_four_scores($student) {
        return $this->db
                    ->where('student',$student)
                    ->order_by('tid','ASC')
                    ->limit(4)
                    ->get('cbc_final_results')
                    ->result();
     }

     function teacher_assigned($class,$sub,$term,$year) {
        return $this->db
                    ->where('class',$class)
                    ->where('subject',$sub)
                    ->where('subject',$term)
                    ->where('subject',$year)
                    ->get('subjects_assign')
                    ->row();
     }

     function subscores($tid,$classgrp,$sub) {
        return $this->db
                    ->where(array('tid' => $tid))
                    ->where(array('classgrp' => $classgrp))
                    ->where(array('subject' => $sub))
                    ->get('cbc_subs_included')
                    ->result();
     }



    function fetch_strands($subject)
    {
        return $this->db->where('subject', $subject)->where('status', 1)->order_by('id', 'ASC')->get('cbc_la')->result();
    }

    function fetch_strands_by_sub($subject)
    {
        $list = $this->db->where('subject', $subject)->where('status', 1)->order_by('id', 'ASC')->get('cbc_la')->result();

        $strands = [];
        foreach ($list as $uy => $d) {
            $strands[$d->id] = $d->name;
        }
        return $strands;
    }

    function fetch_substrands_by_sub()
    {
        $list =  $this->db->where('status', 1)->get('cbc_topics')->result();

        $fn = [];

        foreach ($list as $p) {
            $fn[$p->id] = $p->name;
        }

        return $fn;
    }


    function fetch_substrands()
    {
        $list =  $this->db->where('status', 1)->get('cbc_topics')->result();

        $fn = [];

        foreach ($list as $p) {
            $fn[$p->strand][] = $p;
        }

        return $fn;
    }

    function fetch_remarks($subject, $strand, $sub, $task)
    {
        return $this->db
            ->where('subject', $subject)
            ->where('la', $strand)
            ->where('topic', $sub)
            ->where('task', $task)
            ->get('cbc_remarks')->result();
    }


    function fetch_remark($subject, $strand, $sub, $task)
    {
        return $this->db
            ->where('subject', $subject)
            ->where('la', $strand)
            ->where('topic', $sub)
            ->where('task', $task)
            ->get('cbc_remarks')->row();
    }

    function fetch_tasks($subject, $strand, $substrand)
    {
        $list =  $this->db->where(['topic' => $substrand, 'status' => 1])->get('cbc_tasks')->result();

        $fn = [];

        foreach ($list as $p) {
            $p->remarks =  $this->fetch_remarks($subject, $strand, $substrand, $p->id);
            $fn[] = $p;
        }

        return $fn;
    }

    function get_task()
    {
        $list = $this->db->get('cbc_tasks')->result();

        $tasks = [];

        foreach ($list as $y => $li) {
           
            $tasks[$li->id] = $li->name;
        }
        return $tasks;
    }



    function wrapWords($text)
    {
        $words = explode(' ', $text);
        $wordCount = count($words);
        $result = '';

        for ($i = 0; $i < $wordCount; $i++) {

            $result .= $words[$i];


            if (($i + 1) % 3 === 0 && $i !== $wordCount - 1) {
                $result .= "<br>";
            } else {
                $result .= " ";
            }
        }

        return $result;
    }

    function encryptParameters($params)
    {
        $serializedParams = serialize($params);
        $encryptedParams = base64_encode($serializedParams);
        return $encryptedParams;
    }


    function decryptParameters($encryptedParams)
    {
        $decodedParams = base64_decode($encryptedParams);
        $params = unserialize($decodedParams);
        return $params;
    }

    function get_students($class)
    {
        $this->select_all_key('admission');
        return $this->db
            ->where($this->dx('class') . " ='" . $class . "'", NULL, FALSE)
            ->where($this->dx('status') . " ='1'", NULL, FALSE)
            ->order_by('first_name', 'ASC')
            ->get('admission')
            ->result();
    }

    function get_asses_strands($id, $strand, $substrand, $task)
    {
        return $this->db->where([
            'assess_id' => $id,
            'strand' => $strand,
            'sub_strand' => $substrand,
            'task' => $task
        ])->get('cbc_assess_tasks')->row();
    }

    function get_assessd($post)
    {
        $list = $this->db->where([
            'term' => $this->school->term,
            'year' => $this->school->year,
            'class' => $post->class,
            'subject' => $post->subject,
        ])->get('cbc_assess')->result();

        $fn = [];
        foreach ($list as $p) {
            $row = $this->get_asses_strands($p->id, $post->strand, $post->substrand, $post->task);
            $fn[$p->student] =  $row;
        }

        return $fn;
    }

    function find_task($id)
    {
        return $this->db->where('id', $id)->where('status', 1)->get('cbc_tasks')->row();
    }

    function find($id,$table)
    {
        return $this->db->where('id', $id)->get($table)->row();
    }

    //Get Term Exams
    function find_exams($term = false, $year = false) {
        if ($term) {
            $this->db->where('term',$term);
        }

        if ($year) {
            $this->db->where('year',$year);
        }

        return $this->db
                    ->get('cbc_threads')
                    ->result();
    }

    //Get Class Group Streams
    function class_group_streams($class) {
        $list = $this->db
                     ->where('class',$class)
                     ->get('classes')
                     ->result();

        $out = [];

        return $list;
    }

    //Get Class Students
    function get_stu_marks($sub, $exam, $stu)
    {
        return $this->db
            ->where('sub', $sub)
            ->where('exam', $exam)
            ->where('student', $stu)
            ->get('cbc_marks')
            ->row();
    }

    //Function to Create CBC Marks
    function create_marks($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    //Update 
    function update_with($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }

    //Check whether marks for exam exist
    function check_exists($sub, $exam, $cls)
    {
        return $this->db
            ->where('sub', $sub)
            ->where('exam', $exam)
            ->where('class', $cls)
            ->get('cbc_marks')
            ->row();
    }


    function create_exam($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }


    function all_exams()
    {
        return $this->db->order_by('id', 'DESC')->get('cbc_threads')->result();
    }

    function exams()
    {
        $list = $this->db->order_by('id', 'DESC')->get('cbc_threads')->result();
        $ex = array(); // Initialize the array

        foreach ($list as $l) {
            $ex[$l->id] = $l->exam . ' Term ' . $l->term . ' ' . $l->year; // Append each element to the array
        }

        return $ex;
    }

    function exam_threads()
    {
        $list = $this->db->where('status',1)->order_by('id', 'DESC')->get('cbc_exam_threads')->result();
        // $ex = array(); // Initialize the array

        // foreach ($list as $l) {
        //     $ex[$l->id] = $l->name . ' Term ' . $l->term . ' ' . $l->year; // Append each element to the array
        // }

        // return $ex;

        return $list;
    }


    function get_exam($id)
    {
        return $this->db->where('id', $id)->order_by('id', 'DESC')->get('cbc_threads')->row();
    }

    function get_exam_perclass($id, $cls)
    {
        return $this->db->where('id', $id)->where('class', $cls)->order_by('id', 'DESC')->get('cbc_settings')->row();
    }

    function check_grading($id)
    {
        return $this->db->where('id', $id)->get('cbc_settings')->row();
    }

    function get_grades($id)
    {
        return $this->db->where('grade_id', $id)->get('gs_grades')->result();
    }

    function get_classgrp($id)
    {
        return $this->db->where('id', $id)->get('classes')->row();
    }

    function get_classes($clsgp)
    {
        return $this->db->where('id', $clsgp)->get('classes')->row();
    }

    function check_social($st, $t, $y)
    {
        return $this->db->where('student', $st)->where('term', $t)->where('year', $y)->get('cbc_social')->row();
    }

    function get_settings($class, $exam)
    {
        return $this->db->where('exam', $exam)->where('class', $class)->get('cbc_settings')->row();
    }
    function get_settings_by_id($id)
    {
        return $this->db->where('id', $id)->get('cbc_settings')->row();
    }
    function update_setting($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }

    function update_exam($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }

    function update_social($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }

    function exam_update($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }


    function delete($table, $id)
    {
        return $this->db->delete($table, ['id' => $id]);
    }

    function all_classgroups()
    {
        return $this->db->order_by('id', 'DESC')->get('class_groups')->result();
    }
    function get_termexams($term, $year)
    {
        return $this->db->where('term', $term)->where('year', $year)->get('cbc_threads')->result();
    }
    function get_teachers($class, $term, $year, $sub)
    {
        return $this->db->where('class', $class)->where('term', $term)->where('year', $year)->where('subject', $sub)->get('subjects_assign')->row();
    }


    public function fetch_marks2($exam, $cls)
    {
        if (empty($exam) && empty($cls)) {
            return [];
        }


        $query = $this->db
            ->where('exam', $exam)
            ->where('class', $cls)
            ->get('cbc_marks');

        // Check for results
        if ($query->num_rows() > 0) {
            $results = $query->result();
            $grouped_results = [];

            foreach ($query->result() as $row) {
                $grouped_results[$row->student][$row->sub][] = (array) $row;
            }
            return $grouped_results;
        } else {
            // No results found
            return [];
        }
    }

    public function fetch_marks($exam, $cls)
    {
        if (empty($exam) && empty($cls)) {
            return [];
        }

        $this->db->from('cbc_marks');

        if (!empty($exam)) {
            $this->db->where_in('exam', $exam);
        }

        if (!empty($cls)) {
            $this->db->where('class', $cls);
        }

        $query = $this->db->get();

        // Check for results
        if ($query->num_rows() > 0) {
            $results = $query->result();
            $grouped_results = [];

            foreach ($query->result() as $row) {
                $grouped_results[$row->student][$row->sub][] = (array) $row;
            }
            return $grouped_results;
        } else {
            // No results found
            return [];
        }
    }


    public function fetch_marks_by_stud($exam, $st)
    {
        if (empty($exam) && empty($st)) {
            return [];
        }

        $query = $this->db
            ->where('exam', $exam)
            ->where('student', $st)
            ->get('cbc_marks');

        // Check for results
        if ($query->num_rows() > 0) {
            $results = $query->result();
            $grouped_results = [];

            foreach ($query->result() as $row) {
                $grouped_results[$row->student][$row->sub][] = (array) $row;
            }
            return $grouped_results;
        } else {
            // No results found
            return [];
        }
    }

    function find_student()
    {
        $this->select_all_key('admission');
        $list = $this->db->get('admission')->result();

        $myst = [];
        foreach ($list as $key => $l) {
            $myst[$l->id] =  $l->first_name . ' ' . $l->last_name;
        }

        return  $myst;
    }

    function find_student1($cls)
    {
        $this->select_all_key('admission');
        
        $list = $this->db->where($this->dx('class') . " ='" . $cls . "'", NULL, FALSE)->get('admission')->result();

        $myst = [];
        foreach ($list as $key => $l) {
            $myst[$l->id] =  $l->first_name . ' ' . $l->last_name;
        }

        return  $myst;
    }

    function get_assess($cls, $term, $year, $sb)
    {
        return $this->db->where('class', $cls)->where('term', $term)->where('year', $year)->where('subject', $sb)->get('cbc_assess')->result();
    }



    function get_assessp($cls, $st, $term, $year, $sb)
    {
        return $this->db->where('student', $st)->where('class', $cls)->where('term', $term)->where('year', $year)->where('subject', $sb)->get('cbc_assess')->result();
    }

    function get_formative($ids)
    {

        if (empty($ids)) {
            return [];
        }

        $query = $this->db->where_in('assess_id', $ids)->where('status', 1)->order_by('strand', 'ASC')->order_by('sub_strand', 'ASC')->get('cbc_assess_tasks');

        if ($query->num_rows() > 0) {
            $results = $query->result();
            $grouped_results = [];

            foreach ($query->result() as $row) {
                $grouped_results[$row->student][$row->strand][$row->sub_strand][] = (array) $row;
            }
            return $grouped_results;
        } else {
            // No results found
            return [];
        }
    }

    function get_formative_stu($ids, $stu)
    {

        if (empty($ids)) {
            return [];
        }

        $query = $this->db->where_in('assess_id', $ids)->where('status', 1)->where('student', $stu)->order_by('strand', 'ASC')->order_by('sub_strand', 'ASC')->get('cbc_assess_tasks');

        if ($query->num_rows() > 0) {
            $results = $query->result();
            $grouped_results = [];

            foreach ($query->result() as $row) {
                $grouped_results[$row->student][$row->strand][$row->sub_strand][] = (array) $row;
            }
            return $grouped_results;
        } else {
            // No results found
            return [];
        }
    }


    function get_class($id)
    {
        return $this->db->where(array('class_teacher' => $id))->get('classes')->row();
    }

    function get_by_class($id)
    {
        if (empty($id)) {
            return [];
        }

        $this->db->where('class_id', $id)
            ->where('term', $this->school->term)
            ->where('year', $this->school->year)
            ->order_by('attendance_date', 'DESC') // Sort by attendance_date in ascending order
            ->limit(10); // Limit the result to 10 records
        $result = $this->db->get('class_attendance')->result();
        return $result;
    }


    function get_by_class1($id)
    {
        if (empty($id)) {
            return [];
        }

        $this->db->where('class_id', $id)
            ->where('term', $this->school->term)
            ->where('year', $this->school->year)
            ->order_by('attendance_date', 'DESC'); // Sort by attendance_date in ascending order
        $result = $this->db->get('class_attendance')->result();
        return $result;
    }

    function get_class_att($id)
    {

        if (empty($id)) {
            return [];
        }

        $data = $this->db->where_in('attendance_id', $id)->get('class_attendance_list')->result();

        $result = [];

        foreach ($data as $entry) {
            if (!isset($result[$entry->attendance_id])) {
                $result[$entry->attendance_id] = 0;
            }
        }

        // Count the Present statuses
        foreach ($data as $entry) {
            if ($entry->status === 'Present') {
                $result[$entry->attendance_id]++;
            }
        }


        return $result;
    }

    function get_class_at($id)
    {

        if (empty($id)) {
            return [];
        }

        $data = $this->db->where_in('attendance_id', $id)->get('class_attendance_list')->result();

         $presentCounts = array();

        // Iterate through the data
        foreach ($data as $row) {
            $student = $row->student;
            $status = $row->status;

            if (!isset($presentCounts[$student])) {
               $presentCounts[$student] = 0;
            }

            if (strcasecmp($status, 'present') === 0) {
                $presentCounts[$student]++;
            }
        }

        // Sort the array by present count in descending order
        arsort($presentCounts);

        $topStudents = array_slice($presentCounts, 0, 5, true);

        return $topStudents;
    }


   function get_students_by_class($cls){

        $this->select_all_key('admission');
        $this->db->where($this->dx('class') . " ='" . $cls . "'", NULL, FALSE);
        return $this->db->get('admission')->result();

   }

    public function get_clsgroup($class)
    {
        $this->db->where('id', $class); 
        $query = $this->db->get('classes'); 
        return $query->row();
    }

    function  get_subids($cls){
        $this->db->where('class_id', $cls);
        $query = $this->db->get('cbc');
        return $query->result();
    }

    function  get_subjects_by_class($ids)
    {
        $this->db->where_in('id', $ids);
        $query = $this->db->get('cbc_subjects');
        return $query->result();
    }

    public function insert_input($input, $st, $ex)
    {
       
        $data = array(
            'remarks' => $input
        );
        $this->db->where('student', $st);
        $this->db->where('exam', $ex);
        $result = $this->db->update('cbc_marks', $data); 
        return $result;
    }

    public function get_field($ky, $exam)
    {
        $this->db->select('remarks');
        $this->db->where('student', $ky);
        $this->db->where('exam', $exam);
        $query = $this->db->get('cbc_marks');
        $result = $query->row();

        return $result ? $result->remarks : null;
    }

    public function insert_tr_remarks($input, $st, $ex)
    {
        $data = array(
            'tr_remarks' => $input
        );
        $this->db->where('student', $st);
        $this->db->where('exam', $ex);
        $this->db->update('cbc_marks', $data);
    }

    public function get_tr_remarks($ky, $exam)
    {
        $this->db->select('tr_remarks');
        $this->db->where('student', $ky);
        $this->db->where('exam', $exam);
        $query = $this->db->get('cbc_marks');
        $result = $query->row();

        return $result ? $result->tr_remarks : null;
    }


    public function insert_formative_comment($input, $ass, $st, $sub)
    {

        $data = array(
            'gn_remarks' => $input
        );
        $this->db->where('assess_id', $ass);
        $this->db->where('student', $st);
        $this->db->where('subject', $sub);
        $result = $this->db->update('cbc_assess_tasks', $data);
        return $result;
    }

    public function get_rmk($ass, $st, $sub)
    {
        $this->db->select('gn_remarks');
        $this->db->where('student', $st);
        $this->db->where('assess_id', $ass);
        $this->db->where('subject', $sub);
        $query = $this->db->get('cbc_assess_tasks');
        $result = $query->row();

        return $result ? $result->gn_remarks : null;
    }

    public function insert_tr_rmks($input, $ass, $st, $sub)
    {

        $data = array(
            'tr_remarks' => $input
        );
        $this->db->where('assess_id', $ass);
        $this->db->where('student', $st);
        $this->db->where('subject', $sub);
        $result = $this->db->update('cbc_assess_tasks', $data);
        return $result;
    }
    public function get_tr_rmks($ass, $st, $sub)
    {
        $this->db->select('tr_remarks');
        $this->db->where('student', $st);
        $this->db->where('assess_id', $ass);
        $this->db->where('subject', $sub);
        $query = $this->db->get('cbc_assess_tasks');
        $result = $query->row();

        return $result ? $result->tr_remarks : null;
    }


    
   

}
