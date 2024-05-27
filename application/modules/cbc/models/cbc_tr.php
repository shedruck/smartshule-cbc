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

    function exam_setting($data, $table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
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
                    ->order_by('first_name','ASC')
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
        foreach($list as $p)
        {
            $row = $this->get_asses_strands($p->id, $post->strand, $post->substrand, $post->task);
            $fn[$p->student] =  $row;
        }   

        return $fn;
    }

    function find_task($id)
    {
        return $this->db->where('id',$id)->where('status',1)->get('cbc_tasks')->row();
    }

    //Get Class Students
    function get_stu_marks($sub,$exam,$stu) {
        return $this->db
                    ->where('sub',$sub)
                    ->where('exam',$exam)
                    ->where('student',$stu)
                    ->get('cbc_marks')
                    ->row();
    }

    //Function to Create CBC Marks
    function create_marks($table,$data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    //Update 
    function update_with($id, $data, $table)
    {
        return $this->db->where('id', $id)->update($table, $data);
    }

    //Check whether marks for exam exist
    function check_exists($sub,$exam,$cls) {
        return $this->db
                    ->where('sub',$sub)
                    ->where('exam',$exam)
                    ->where('class',$cls)
                    ->get('cbc_marks')
                    ->row();
    }


    function create_exam($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }


    function all_exams(){
        return $this->db->order_by('id', 'DESC')->get('cbc_threads')->result();
    }

    function exams()
    {
        $list = $this->db->order_by('id', 'DESC')->get('cbc_threads')->result();
        $ex = array(); // Initialize the array

        foreach ($list as $l) {
            $ex[$l->id] = $l->exam.' Term '.$l->term.' '.$l->year; // Append each element to the array
        }

        return $ex;
    }

    

    function get_exam($id)
    {
        return $this->db->where('id', $id)->order_by('id', 'DESC')->get('cbc_threads')->row();
    }

    function check_grading($id)
    {
        return $this->db->where('id', $id)->get('cbc_settings')->row();
    }

    function get_grades($id){
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

    function check_social($st, $t, $y){
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
    function update_setting($id, $data, $table){
        return $this->db->where('id', $id)->update($table, $data);
    }

    function update_exam($id, $data, $table) {
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
     function get_termexams($term, $year){
        return $this->db->where('term', $term)->where('year', $year)->get('cbc_threads')->result();
     }
    function get_teachers($class, $term, $year, $sub)
    {
        return $this-> db->where('class', $class)->where('term', $term)->where('year', $year)->where('subject', $sub)->get('subjects_assign')->row();
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
        if (empty($exam) && empty($st) ) {
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
       $myst[$l->id] =  $l->first_name.' '.$l->last_name;
       }
        
        return  $myst;
    }

    function get_assess($cls, $term, $year, $sb)
    {
        return $this->db->where('class', $cls)->where('term', $term)->where('year', $year)->where('subject', $sb)->get('cbc_assess')->result();
    }

    function get_formative($ids) {

        if (empty($ids)) {
          return [];
        }
        
        $query = $this->db->where_in('assess_id', $ids)->where('status', 1)->get('cbc_assess_tasks');

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

        // Initialize an array to store the count of present days for each student
        $presentCounts = array();

        // Iterate through the data
        foreach ($data as $row) {
            // Extract student and status from the current row
            $student = $row->student;
            $status = $row->status;

            // Check if the student already exists in the presentCounts array
            if (!isset($presentCounts[$student])) {
                // If not, initialize the count to 0
                $presentCounts[$student] = 0;
            }

            // If status is 'present' or 'Present' (case-insensitive), increment the count for the student
            if (strcasecmp($status, 'present') === 0) {
                $presentCounts[$student]++;
            }
        }

        // Sort the array by present count in descending order
        arsort($presentCounts);

          $topStudents = array_slice($presentCounts, 0, 5, true);

        return $topStudents;
    }

}
