<?php

class Exams_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('exams', $data);
        return $this->db->insert_id();
    }

    function create_ap($data)
    {
        return $this->insert_key_data('appraisal', $data);
    }

    /**
     * Fetch One Exam by Id
     * @param type $id
     * @return type
     */
    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('exams')->row();
    }

    /**
     * Fetch Grading System
     * @param type $id
     * @return type
     */
    function get_grading($id)
    {
        return $this->db->where('id', $id)
                                            ->get('grading_system')
                                            ->row();
    }

    function years_exams()
    {
        return $this->db->where('year', date('Y'))->order_by('created_on', 'DESC')->get('exams')->result();
    }

    function student_exams($student)
    {
        
    }

    /**
     * List all Available Grading Systems
     * 
     * @return type
     */
    function get_grading_system()
    {
        $result = $this->db->select('grading_system.*')
                          ->order_by('created_on', 'DESC')
                          ->get('grading_system')
                          ->result();

        $arr = array();
        foreach ($result as $res)
        {
            $arr[$res->id] = $res->title;
        }

        return $arr;
    }

    /**
     * Fetch Recorded Classes
     * 
     * @param type $exam
     */
    function fetch_recorded_classes($exam)
    {
        $result = $this->db->where('exam_type', $exam)
                          ->order_by('class_id', 'ASC')
                          ->get('exams_management')
                          ->result();

        $arr = array();

        foreach ($result as $res)
        {
            $size = $this->fetch_by_size($res->id);
            $arr[] = array('class' => $res->class_id, 'pop' => $size);
        }

        return $arr;
    }

    /**
     * Get Class  by Class id & Stream
     * 
     * @param type $class
     * @param type $stream
     * @return type
     */
    function get_by_class($class, $stream)
    {
        return $this->db->where('class', $class)
                                            ->where('stream', $stream)
                                            ->get('classes')->row();
    }

    /**
     * Fetch no. of recorded Students
     * 
     * @param type $id
     * @return type
     */
    function fetch_by_size($id)
    {
        return $this->db->where('exams_id', $id)->count_all_results('exams_management_list');
    }

    /**
     * List Class Options
     * 
     * @return type
     */
    function list_classes()
    {
        $cc = $this->populate('class_groups', 'id', 'name');
        $str = $this->populate('class_stream', 'id', 'name');
        $result = $this->db->order_by('class', 'ASC')
                          ->where('status', 1)
                          ->get('classes')
                          ->result();

        $arr = array();

        foreach ($result as $res)
        {
            $lcc = isset($cc[$res->class]) ? $cc[$res->class] : '-';
            $lst = isset($str[$res->stream]) ? $str[$res->stream] : '-';

            $arr[$res->id] = (object) array('name' => $lcc . ' ' . $lst, 'rec' => $res->rec);
        }

        return $arr;
    }

    /**
     * Fetch a Class(Stream) Row
     * 
     * @param type $id
     * @return type
     */
    function get_stream($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    /**
     * Insert Exam Results
     * 
     * @param type $data
     * @return type
     */
    function create_ex($data)
    {
        $this->db->insert('exams_management', $data);
        return $this->db->insert_id();
    }

    /**
     * fetch_grading System
     * 
     * @param int $exam
     * @param int $class
     * @param int $subject
     * @return type
     */
    function fetch_grading($exam, $class, $subject)
    {
        return $this->db->where(array('exam' => $exam, 'class' => $class, 'subject' => $subject))->get('exam_grading')->row();
    }

    /**
     * Insert exam_grading
     * 
     * @param int $exam
     * @param int $class
     * @param int $subject
     * @param int $grading
     * @param int $user
     * @return type
     */
    function set_grading($exam, $class, $subject, $grading, $user)
    {
        $in = $this->db->where('exam', $exam)
                          ->where('class', $class)
                          ->where('subject', $subject)
                          ->where('grading', $grading)
                          ->get('exam_grading')
                          ->row();
        $exsts = count($in) ? TRUE : FALSE;

        $data = array(
            'exam' => $exam,
            'class' => $class,
            'subject' => $subject,
            'grading' => $grading,
            'created_by' => $user,
            'created_on' => time()
        );
        if (!$exsts)
        {
            $this->db->insert('exam_grading', $data);
            return $this->db->insert_id();
        }
        else
        {
            $other = $this->db
                              ->where('exam', $exam)
                              ->where('class', $class)
                              ->where('subject', $subject)
                              ->get('exam_grading')
                              ->result();

            foreach ($other as $o)
            {
                $this->db->where('id', $o->id)->update('exam_grading', array('grading' => $grading));
            }
        }
        return $in->id;
    }

    /**
     * Record Students Who did the Exam
     * 
     * @param type $data
     * @return type
     */
    function create_list($data)
    {
        $ex = $this->db->where('student', $data['student'])->where('exams_id', $data['exams_id'])->get('exams_management_list')->row();

        if ($ex)
        {
            return $ex->id;
        }
        else
        {
            $this->db->insert('exams_management_list', $data);
            return $this->db->insert_id();
        }
    }

    /**
     * Insert Students Marks
     * 
     * @param type $data
     * @return type
     */
    function insert_marks($data)
    {
        $this->db->insert('exams_marks_list', $data);
        return $this->db->insert_id();
    }

    /**
     * Insert Sub units Marks
     * 
     * @param type $data
     * @return type
     */
    function insert_subs($data)
    {
        $this->db->insert('sub_marks', $data);
        return $this->db->insert_id();
    }

    /**
     * Return Students in this Class
     * 
     * @param type $class
     * @param type $stream
     * @return type
     */
    function get_students($class, $stream)
    {
        $kla = $this->portal_m->get_class_stream($class, $stream);
        $this->select_all_key('admission');
        return $this->db->where($this->dx('class') . '=' . $kla->id, NULL, FALSE)->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();
    }

    /**
     * Check if appraisal exists
     * 
     * @param int $student
     * @param int $term
     * @param int $year
     * @return int
     */
    function check_appraisal($student, $term, $year)
    {
        $row = $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                                            ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                                            ->get('appraisal')->row();

        return empty($row) ? 0 : $row->id;
    }

    function get_appraisal($student, $term, $year)
    {
        $this->select_all_key('appraisal');
        $row = $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                            ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                                            ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                                            ->get('appraisal')->row();

        return $row;
    }

    /**
     * Update Appraisal
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    function update_ap($id, $data)
    {
        return $this->update_key_data($id, 'appraisal', $data);
    }

    /**
     * Return Students in this Class
     * 
     * @param type $class
     * @param type $stream
     * @return type
     */
    function get_assigned_students($subject)
    {
        $list = $this->db->select('student')
                          ->where('subject', $subject)
                          ->where('year', date('Y'))
                          ->get('subjects_assign')
                          ->result();
        $fn = array();
        foreach ($list as $l)
        {
            $this->select_all_key('admission');
            $fn[] = $this->db->where('id', $l->student)->get('admission')->row();
        }

        return $fn;
    }

    /**
     * Fetch all Sub Units
     * 
     * @return type
     */
    function fetch_sub_tests()
    {
        $subs = array();

        $list = $this->db->order_by('id', 'ASC')->get('sub_cats')->result();
        foreach ($list as $l)
        {
            $subs[$l->parent][$l->id] = $l->title;
        }
        return $subs;
    }

    /**
     * Fetch all Sub Units
     * 
     * @param int $id Subject ID
     * @return array()
     */
    function fetch_by_subs($id = 0)
    {
        $subs = array();
        if ($id)
        {
            $this->db->where('parent', $id);
        }
        $list = $this->db->order_by('id', 'ASC')->get('sub_cats')->result();
        foreach ($list as $l)
        {
            $subs[$l->id] = $l->title;
        }
        return $subs;
    }

    function fetch_out_of($id = 0)
    {
        $subs = array();
        if ($id)
        {
            $this->db->where('parent', $id);
        }
        $list = $this->db->order_by('id', 'ASC')->get('sub_cats')->result();
        foreach ($list as $l)
        {
            $subs[$l->id] = $l->out_of;
        }
        return $subs;
    }

    /**
     * Get Subject by ID
     * 
     * @param type $id
     * @return type
     */
    function fetch_subject($id)
    {
        return $this->db->where(array('id' => $id))->get('subjects')->row();
    }
	
	/**
     * Get Subject by ID
     * 
     * @param type $id
     * @return type
     */
    function fetch_subject_alt($id,$custom)
    {
        return $this->db->where(array('id' => $id,'custom'=>$custom))->get('subjects')->row();
    }

    /**
     * Fetch Subjects for this Class
     * 
     * @param int $class
     * @return int
     */
    function get_subjects($class, $term, $flag = 0)
    {
        if ($flag)
        {
            $list = $this->get_full_subjects();
        }
        else
        {
            $list = $this->list_subjects_alt();
        }
        $ccla = 0;
        $rc = $this->db->where('id', $class)->get('classes')->row();
        $subrc = $this->populate('subjects', 'id', 'name');
        if ($rc && isset($rc->class))
        {
            $ccla = $rc->class;
        }
        $subs = $this->db
                          ->where(array('class_id' => $ccla, 'term' => $term))
                          ->join('subjects', 'subjects.id = subject_id')
                          ->order_by('subject_id', 'ASC')
                          ->get('subjects_classes')
                          ->result();
        $fn = array();

        foreach ($subs as $ks)
        {
            $units = $this->fetch_by_subs($ks->subject_id);
            $outs = $this->fetch_out_of($ks->subject_id);
            $sname = isset($subrc[$ks->subject_id]) ? $subrc[$ks->subject_id] : '';
            $tt = isset($list[$ks->subject_id]) ? $list[$ks->subject_id] : '-';
            $sbk = $this->fetch_subject($ks->subject_id);
            $ttp = isset($sbk->is_optional) ? $sbk->is_optional : '';
            if (count($units))
            {
                $fn[$ks->subject_id] = array('title' => $tt, 'units' => $units, 'full' => $sname, 'outs' => $outs, 'opt' => $ttp);
            }
            else
            {
                $fn[$ks->subject_id] = array('title' => $tt, 'opt' => $ttp, 'full' => $sname);
            }
        }

        return $fn;
    }

    function get_subjects_alt($class, $term, $flag = 0)
    {
        if ($flag)
        {
            $list = $this->get_full_subjects();
        }
        else
        {
            $list = $this->list_subjects();
        }
        $ccla = 0;
        $rc = $this->db->where('id', $class)->get('classes')->row();
        $subrc = $this->populate('subjects', 'id', 'name');
        if ($rc && isset($rc->class))
        {
            $ccla = $rc->class;
        }
        $subs = $this->db
                          ->join('subjects', 'subjects.id = subject_id')
                          ->where('subjects.is_optional !=1', NULL, FALSE)
                          ->where(array('class_id' => $ccla, 'term' => $term))
                          ->order_by('subject_id', 'ASC')
                          ->get('subjects_classes')
                          ->result();
        $fn = array();

        foreach ($subs as $ks)
        {
            $units = $this->fetch_by_subs($ks->subject_id);
            $sname = isset($subrc[$ks->subject_id]) ? $subrc[$ks->subject_id] : '-';
            $tt = isset($list[$ks->subject_id]) ? $list[$ks->subject_id] : '-';
            $sbk = $this->fetch_subject($ks->subject_id);
            $ttp = isset($sbk->is_optional) ? $sbk->is_optional : '';
            if (count($units))
            {
                $fn[$ks->subject_id] = array('title' => $tt, 'units' => $units, 'full' => $sname, 'opt' => $ttp);
            }
            else
            {
                $fn[$ks->subject_id] = array('title' => $tt, 'opt' => $ttp, 'full' => $sname);
            }
        }

        return $fn;
    }

    /**
     * List All Subjects
     * 
     * @return type
     */
    function list_subjects($flag = 0)
    {
        $results = $this->db->where('is_optional !=', 1)->get('subjects')->result();
        $rr = array();

        foreach ($results as $res)
        {
            $rr[$res->id] = $flag ? $res->name : $res->short_name;
        }

        return $rr;
    }

    function list_subjects_alt($flag = 0)
    {
        $results = $this->db->get('subjects')->result();
        $rr = array();

        foreach ($results as $res)
        {
            $rr[$res->id] = $flag ? $res->name : $res->short_name;
        }

        return $rr;
    }

    /**
     * Count Class Subjects
     * 
     * @param type $class
     * @return type
     */
    function count_subjects($class)
    {
        return $this->db->where(array('class_id' => $class))->get('subjects_classes')->num_rows();
    }

    /**
     * Return Full Subjects
     * 
     * @return type
     */
    function get_full_subjects()
    {
        $result = $this->db->select('subjects.*')
                          ->where('is_optional !=', 1)
                          ->order_by('created_on', 'DESC')
                          ->get('subjects')
                          ->result();

        $rr = array();
        foreach ($result as $res)
        {
            $rr[$res->id] = $res->name;
        }

        return $rr;
    }

    /**
     * Get Exams Options
     * 
     * @return array
     */
    function list_exams()
    {
        $results = $this->db->order_by('created_on', 'DESC')->get('exams')->result();
        $xx = array();
        foreach ($results as $res)
        {
            $xx[$res->id] = $res->title . ' - Term ' . $res->term . '  <b>( Year ' . $res->year . ' )</b>';
        }

        return $xx;
    }

    /**
     * Save Remarks
     * 
     * @param type $data
     * @return type
     */
    function save_remarks($data)
    {
        $this->db->insert('remarks', $data);
        return $this->db->insert_id();
    }

    function save_gen_remarks($data)
    {
        $this->db->insert('remarks_full', $data);
        return $this->db->insert_id();
    }

    function save_rpt_remarks($data)
    {
        $this->db->insert('rpt_remarks', $data);
        return $this->db->insert_id();
    }

    /**
     * Determine in Student Marks have already been Entered
     * 
     * @param int $parent
     * @param int $subject
     * @param int $exam
     * @param int $student
     */
    function rmak_exists($parent, $subject, $exam, $student)
    {
        $in = $this->db->where('parent', $parent)
                          ->where('sub_id', $subject)
                          ->where('exam', $exam)
                          ->where('student', $student)
                          ->get('remarks')
                          ->row();

        return count($in) ? $in->id : FALSE;
    }

    /**
     * 
     * @param type $exam
     * @param type $student
     * @return type
     */
    function gen_exists($exam, $student)
    {
        $in = $this->db->where('exam', $exam)
                          ->where('student', $student)
                          ->get('remarks_full')
                          ->row();

        return count($in) ? $in->id : FALSE;
    }

    /**
     * 
     * @param type $exam
     * @param type $student
     * @return type
     */
    function rpt_exists($exam, $student)
    {
        $in = $this->db->where('exam', $exam)
                          ->where('student', $student)
                          ->get('rpt_remarks')
                          ->row();

        return count($in) ? $in->id : FALSE;
    }

    function get_rpt_remarks($exam, $student)
    {
        return $this->db->where('exam', $exam)
                                            ->where('student', $student)
                                            ->get('rpt_remarks')
                                            ->row();
    }

    /**
     * Fetch Score for Student by Exam
     * 
     * @param int $exam
     * @param int $student
     * @return type
     */
    function fetch_by_exam($exam, $student)
    {
        return $this->db->where('exam', $exam)
                                            ->where('student', $student)
                                            ->get('remarks')
                                            ->result();
    }

    /**
     * General Remarks
     * 
     * @param type $exam
     * @param type $student
     * @return type
     */
    function fetch_gen_remarks($exam, $student)
    {
        return $this->db->where('exam', $exam)
                                            ->where('student', $student)
                                            ->get('remarks_full')
                                            ->row();
    }

    /**
     * Update Remarks
     * 
     * @param type $id
     * @param type $data
     * @return boolean
     */
    function update_remarks($id, $data)
    {
        return $this->db->where('id', $id)->update('remarks', $data);
    }

    function update_gen_remarks($id, $data)
    {
        return $this->db->where('id', $id)->update('remarks_full', $data);
    }

    function update_rpt_remarks($id, $data)
    {
        return $this->db->where('id', $id)->update('rpt_remarks', $data);
    }

    /**
     * Update Exams Student List
     * 
     * @param int $student
     * @param int $exam
     * @param array $data
     * @return boolean
     */
    function update_list($id, $data)
    {
        return $this->db->where('id', $id)->update('exams_management_list', $data);
    }

    /**
     * Update Subject Marks OR Insert if not exists
     * 
     * @param int $exam
     * @param int $subject
     * @param array $data
     */
    function bulk_update_marks($exam, $subject, $data)
    {
        $rec = $this->db->where('exams_list_id', $exam)
                                            ->where('subject', $subject)
                                            ->count_all_results('exams_marks_list') > 0;
        if ($rec)
        {
            return $this->db->where('exams_list_id', $exam)
                                                ->where('subject', $subject)
                                                ->update('exams_marks_list', $data);
        }
        else
        {
            $this->db->insert('exams_marks_list', array(
                'exams_list_id' => $exam,
                'subject' => $subject,
                'created_by' => isset($data['modified_by']) ? $data['modified_by'] : '',
                'created_on' => time(),
                              ) + $data);
        }
    }

    /**
     * Update Sub Marks
     * 
     * @param int $exam
     * @param int $parent
     * @param int $unit
     * @param array $data
     * @return boolean
     */
    function update_sub_marks($exam, $parent, $unit, $data)
    {
        $rec = $this->db->where('marks_list_id', $exam)
                                            ->where('parent', $parent)
                                            ->where('unit', $unit)
                                            ->count_all_results('sub_marks') > 0;
        if ($rec)
        {
            return $this->db->where('marks_list_id', $exam)
                                                ->where('parent', $parent)
                                                ->where('unit', $unit)
                                                ->update('sub_marks', $data);
        }
        else
        {
            $svalues = array(
                'marks_list_id' => $exam,
                'parent' => $parent,
                'unit' => $unit,
                'marks' => $data['marks'],
                'created_by' => $this->user->id,
                'created_on' => time()
            );
            return $this->insert_subs($svalues);
        }
    }

    function has_rec($list_id, $subject)
    {
        return $this->db->where('exams_list_id', $list_id)
                                            ->where('subject', $subject)
                                            ->count_all_results('exams_marks_list');
    }

    function update_marks($list_id, $subject, $data)
    {
        return $this->db->where('exams_list_id', $list_id)
                                            ->where('subject', $subject)
                                            ->update('exams_marks_list', $data);
    }

    /**
     * Fetch Row to Update
     * 
     * @param type $student
     * @param type $exam
     * @return type
     */
    function get_update_target($student, $exam)
    {
        $row = $this->db->where('student', $student)
                          ->where('exams_id', $exam)
                          ->get('exams_management_list')
                          ->row();
        return $row ? $row->id : FALSE;
    }

    /**
     * Check if Such exam Exists
     * 
     * @param type $id
     * @return type
     */
    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('exams') > 0;
    }

    /**
     * Check Whether marks have already been recorded
     * to avoid duplication
     * 
     * @param int $exam
     * @param int $class
     * @return boolean
     */
    function rec_exists($exam, $class)
    {
        return $this->db->where(array('class_id' => $class, 'exam_type' => $exam))->count_all_results('exams_management') > 0;
    }

    function is_recorded($exam)
    {
        return $this->db->where(array('exam_type' => $exam))->count_all_results('exams_management') > 0;
    }

    /**
     * Fetch Specific row
     * 
     * @param type $exam
     * @param type $class
     * @return type
     */
    function fetch_rec($exam, $class)
    {
        return $this->db->where(array('class_id' => $class, 'exam_type' => $exam))->get('exams_management')->row();
    }

    /**
     * Fetch Exam to edit
     * 
     * @param type $exam
     * @param type $class
     * @return type
     */
    function fetch_list($exam, $class)
    {
        return $this->db->where(array('class_id' => $class, 'exam_type' => $exam))
                                            ->get('exams_management')
                                            ->row();
    }

    /**
     * Fetch Student List in Exam
     * 
     * @param int $exam
     * @return object
     */
    function fetch_student_list($exam)
    {
        return $this->db->where('exams_id', $exam)
                                            ->get('exams_management_list')
                                            ->result();
    }

    /**
     * Fetch Marks List
     * 
     * @param int $list_id
     * @return array
     */
    function fetch_marks_list($list_id)
    {
        $fn = array();
        $list = $this->db->select('subject, marks')
                          ->where('exams_list_id', $list_id)
                          ->get('exams_marks_list')
                          ->result();
        foreach ($list as $l)
        {
            $units = $this->fetch_sub_marks($l->subject, $list_id);
            if (count($units))
            {
                $fn[] = array('subject' => $l->subject, 'marks' => $l->marks, 'inc' => $l->inc, 'units' => $units);
            }
            else
            {
                $fn[] = array('subject' => $l->subject, 'marks' => $l->marks, 'inc' => $l->inc);
            }
        }
        return $fn;
    }

    function fetch_done_list($subject, $list_id)
    {
        $list = $this->db->select('marks, inc, remarks, effort')
                          ->where('subject', $subject)
                          ->where('exams_list_id', $list_id)
                          ->get('exams_marks_list')
                          ->result();

        foreach ($list as $l)
        {
            $units = $this->fetch_sub_marks($subject, $list_id);
            if (count($units))
            {
                return array('subject' => $subject, 'mk' => $l->marks, 'effort' => $l->effort, 'remarks' => $l->remarks, 'inc' => $l->inc, 'units' => $units);
            }
            else
            {
                return array('subject' => $subject, 'mk' => $l->marks, 'effort' => $l->effort, 'remarks' => $l->remarks, 'inc' => $l->inc);
            }
        }
    }

    /**
     * Fetch Submarks
     * @param type $subject
     * @param type $list_id
     */
    function fetch_sub_marks($subject, $list_id)
    {
        $subm = $this->db->select('unit, marks')
                          ->where('parent', $subject)
                          ->where('marks_list_id', $list_id)
                          ->get('sub_marks')
                          ->result();
        $fn = array();
        foreach ($subm as $s)
        {
            $fn[$s->unit] = $s->marks;
        }
        return $fn;
    }
	
	 /**
     * Get Subject Marks
     * 
     * @param int $exam
     * @param int $student
     * @param int $subject
     */
    function get_subject_result($exam, $student, $subject)
    {
        $sbk = $this->fetch_subject($subject);
        $rows = $this->db->select('a.id as id,a.remarks as remarks, a.total as total')
                          ->where('exam_type', $exam)
                          ->where('student', $student)
                          ->join('exams_management b', 'b.id= a.exams_id')
                          ->get('exams_management_list a')
                          ->result();

        if (count($rows) > 1)
        {
            $srow = $rows[(count($rows) - 1)];
        }
        else
        {
            if (isset($rows[0]))
            {
                $srow = $rows[0];
            }
            else
            {
                $srow = array();
            }
        }

        if ($srow)
        {
            $rw = $this->db->where('exams_list_id', $srow->id)
                              ->where('subject', $subject)
                              ->get('exams_marks_list')
                              ->row();
            if (empty($rw))
            {
                return array('marks' => 0, 'sub_id' => 0,'effort' => 0,'created_by' => 0, 'opt' => $sbk->is_optional, 'inc' => 0);
            }

            $subs = $this->fetch_sub_marks($subject, $srow->id);

            $ttp = isset($sbk->is_optional) ? $sbk->is_optional : '';
            if (count($subs))
            {
                $pop = $this->fetch_by_subs($subject);
                $fnsubs = array();
                foreach ($subs as $sd => $sm)
                {
                    $uname = isset($pop[$sd]) ? $pop[$sd] : '-';
                    $fnsubs[] = array('name' => $uname, 'marks' => $sm);
                }
                $sheet = array('subject' => $sbk->name, 'sub_id' => $subject, 'marks' => $rw->marks,'effort' => $rw->effort,'remarks' => $rw->remarks,'created_by' => $rw->created_by, 'opt' => $ttp, 'units' => $fnsubs, 'inc' => $rw->inc);
            }
            else
            {
                $sheet = array('subject' => $sbk->name, 'sub_id' => $subject, 'marks' => $rw->marks,'effort' => $rw->effort,'remarks' => $rw->remarks,'created_by' => $rw->created_by, 'opt' => $ttp, 'inc' => $rw->inc);
            }

            return $sheet;
        }
        else
        {
            return array('marks' => 0, 'sub_id' => 0,'effort' => 0,'created_by' => 0, 'opt' => 0, 'inc' => 0);
        }
    }

    /**
     * Get Subject Marks
     * 
     * @param int $exam
     * @param int $student
     * @param int $subject
     */
    function get_subject_result__($exam, $student, $subject)
    {
        $sbk = $this->fetch_subject($subject);
        $rows = $this->db->select('a.id as id,a.remarks as remarks, a.total as total')
                          ->where('exam_type', $exam)
                          ->where('student', $student)
                          ->join('exams_management b', 'b.id= a.exams_id')
                          ->get('exams_management_list a')
                          ->result();

        if (count($rows) > 1)
        {
            $srow = $rows[(count($rows) - 1)];
        }
        else
        {
            if (isset($rows[0]))
            {
                $srow = $rows[0];
            }
            else
            {
                $srow = array();
            }
        }

        if ($srow)
        {
            $rw = $this->db->where('exams_list_id', $srow->id)
                              ->where('subject', $subject)
                              ->get('exams_marks_list')
                              ->row();
            if (empty($rw))
            {
                return array('marks' => 0, 'sub_id' => 0, 'opt' => $sbk->is_optional, 'inc' => 0);
            }

            $subs = $this->fetch_sub_marks($subject, $srow->id);

            $ttp = isset($sbk->is_optional) ? $sbk->is_optional : '';
            if (count($subs))
            {
                $pop = $this->fetch_by_subs($subject);
                $fnsubs = array();
                foreach ($subs as $sd => $sm)
                {
                    $uname = isset($pop[$sd]) ? $pop[$sd] : '-';
                    $fnsubs[] = array('name' => $uname, 'marks' => $sm);
                }
                $sheet = array('subject' => $sbk->name, 'sub_id' => $subject, 'marks' => $rw->marks, 'remarks' => $rw->remarks,'opt' => $ttp, 'units' => $fnsubs, 'inc' => $rw->inc);
            }
            else
            {
                $sheet = array('subject' => $sbk->name, 'sub_id' => $subject, 'marks' => $rw->marks,'remarks' => $rw->remarks, 'opt' => $ttp, 'inc' => $rw->inc);
            }

            return $sheet;
        }
        else
        {
            return array('marks' => 0, 'sub_id' => 0, 'opt' => 0, 'inc' => 0);
        }
    }

    /**
     * Fetch Data for Result Slip
     * 
     * @param int $exam
     * @param int $student
     */
    function get_report($exam, $student, $class)
    {
        $fn = array();
        $rows = $this->db->select('a.id as id,a.remarks as remarks, a.total as total')
                          ->where('exam_type', $exam)
                          ->where('student', $student)
                          ->join('exams_management b', 'b.id= a.exams_id')
                          ->get('exams_management_list a')
                          ->result();

        if (count($rows) > 1)
        {
            $srow = $rows[(count($rows) - 1)];
        }
        else
        {
            if (isset($rows[0]))
            {
                $srow = $rows[0];
            }
            else
            {
                $srow = array();
            }
        }
        if ($srow)
        {
            $marks = $this->db->where('exams_list_id', $srow->id)
                              ->get('exams_marks_list')
                              ->result();

            $sheet = array();
            $avsubs = array();
            $dupes = array();
            $dup_ids = array();
            $keys = array();

            foreach ($marks as $m)
            {
                $subs = $this->fetch_sub_marks($m->subject, $srow->id);
                $sbk = $this->fetch_subject($m->subject);
                $gdd = $this->fetch_grading($exam, $class, $m->subject);
                $ttp = isset($sbk->is_optional) ? $sbk->is_optional : '';

                $avsubs[] = $m->subject;
                if (count($subs))
                {
                    $sheet[] = array('id' => $m->id, 'subject' => $m->subject, 'marks' => $m->marks, 'priority' => $sbk->priority, 'inc' => $m->inc, 'opt' => $ttp, 'units' => $subs, 'grading' => $gdd->grading, 'remarks' => $m->remarks, 'effort' => $m->effort);
                }
                else
                {
                    $sheet[] = array('id' => $m->id, 'subject' => $m->subject, 'marks' => $m->marks, 'priority' => $sbk->priority, 'inc' => $m->inc, 'opt' => $ttp, 'grading' => $gdd->grading, 'remarks' => $m->remarks, 'effort' => $m->effort);
                }
            }
            /**
             * Automatically Drop Duplicate Marks for the same subject
             */
            if (has_duplicate($avsubs))
            {
                foreach ($avsubs as $sub)
                {
                    $dupes[$sub] = duplicates($avsubs, $sub);
                }
            }

            foreach ($dupes as $skid => $no)
            {
                if ($no > 1)
                {
                    $dup_ids[] = $skid;
                }
            }

            foreach ($dup_ids as $ke => $subb)
            {
                foreach ($sheet as $pos => $maxx)
                {
                    $mx = (object) $maxx;
                    if ($mx->subject == $subb)
                    {
                        $keys[$subb][] = $pos;
                    }
                }
            }

            /**
             * Retain the first instance only
             */
            $unset = array();
            foreach ($keys as $ik => $poss_arr)
            {
                foreach ($poss_arr as $index => $oldpos)
                {
                    if ($index == 0)
                    {
                        continue;
                    }
                    else
                    {
                        $unset[] = $oldpos;
                    }
                }
            }

            /**
             * Clear the rest instances
             * @todo Delete the dup entry from DB
             */
            foreach ($unset as $rid)
            {
                unset($sheet[$rid]);
            }
            $tot = 0;
            foreach ($sheet as $h)
            {
                $h = (object) $h;
                if (($h->opt == 2 && $h->inc == 1) || ($h->opt == 0))
                {
                    $tot += $h->marks;
                }
            }
            /**
             * Remove elective subjects which student is not taking
             */
            foreach ($sheet as $sh_id => $sh_row)
            {
                $rx = (object) $sh_row;
                if ($rx->inc == 0 && $rx->opt == 2)
                {
                    unset($sheet[$sh_id]);
                }
            }

            $fn['total'] = $tot;
            $fn['mean'] = round($tot / count($sheet), 2);
            $fn['marks'] = sort_by_field($sheet, 'priority', SORT_ASC);

            return $fn;
        }
        else
        {
            return array();
        }
    }

    /**
     * Count All exams
     * 
     * @return type
     */
    function count()
    {
        return $this->db->count_all_results('exams');
    }

    /**
     * Update Exams
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('exams', $data);
    }

    /**
     * Helper Function
     * @param type $table
     * @param type $option_val
     * @param type $option_text
     * @return type
     */
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

    function exam_details($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text . ' (' . $dropdown->year . ')';
        }
        return $options;
    }

    /**
     * Fetch all Exams
     * 
     * @return array
     */
    function fetch_all_exams()
    {
        $res = $this->db->select('id, title, term, year')
                          ->order_by('term', 'ASC')
                          ->order_by('year', 'ASC')
                          ->get('exams')
                          ->result();
        $options = array();
        foreach ($res as $d)
        {
            $options[$d->id] = $d->title . ' ' . $d->term . ' ' . $d->year;
        }
        return $options;
    }

    /**
     * Datatable Server Side Data Fetcher
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function list_results($exam, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $targets = $this->list_exam_ids($exam);

        $aColumns = $this->db->list_fields('exams_management_list');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        // Ordering
        if (isset($iSortCol_0))
        {
            for ($i = 0; $i < intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true')
                {
                    if ($aColumns[$i] == 'student')
                    {
                        $this->db->join('admission', 'student=admission.id');
                        $this->db->order_by('CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') ", $this->db->escape_str($sSortDir), FALSE);
                    }
                    else
                    {
                        $this->db->_protect_identifiers = FALSE;
                        $this->db->order_by('exams_management_list.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                        $this->db->_protect_identifiers = TRUE;
                    }
                }
            }
        }

        if (isset($sSearch) && !empty($sSearch))
        {
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    if ($aColumns[$i] == 'student')
                    {
                        $this->db->join('admission', 'student=admission.id');
                        $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                        $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $sSearch . "%'  ";
                    }
                    else
                    {
                        $where .= ' OR exams_management_list.' . $aColumns[$i] . "  LIKE '%" . $sSearch . "%'  ";
                    }
                    //here
                }
            }
            $this->db->where('(' . $where . ')', NULL, FALSE);
        }


        // Select Data
        $rResult = $this->db
                          ->where_in('exams_id', $targets)
                          ->order_by('student', 'ASC')
                          ->get('exams_management_list');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->where_in('exams_id', $targets)->count_all_results('exams_management_list');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        $aaData = array();
        $obData = array();
        foreach ($rResult->result_array() as $aRow)
        {
            $row = array();
            foreach ($aRow as $Key => $Value)
            {
                if ($Key && $Key !== ' ')
                {
                    $row[$Key] = $Value;
                }
            }
            $obData[] = $row;
        }

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;
            $stud = $this->worker->get_student($iCol->student);
            $aaData[] = array(
                $iCol->student,
                $stud->first_name . ' ' . $stud->last_name,
                $iCol->total,
                $iCol->remarks,
                '',
                ''
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * get_score_units
     * 
     * @return type
     */
    function get_score_units($exam, $student, $class)
    {
        $res = $this->db->where('class', $class)->order_by('category', 'ASC')->order_by('id', 'ASC')->get('score_units')->result();
        $units = array();
        foreach ($res as $r)
        {
            $r->mk = $this->get_score($exam, $student, $r->id);
            $units[$r->category][] = $r;
        }
        return $units;
    }

    /**
     * Get saved Score
     * 
     * @param type $exam
     * @param type $student
     * @param type $unit
     * @return type
     */
    function get_score($exam, $student, $unit)
    {
        $row = $this->db->where(array('exam' => $exam, 'student' => $student, 'unit' => $unit))->get('scores')->row();

        return empty($row) ? '' : $row->grade;
    }

    function get_remarks($exam, $student)
    {
        $row = $this->db->where(array('exam' => $exam, 'student' => $student))->get('score_remarks')->row();

        return empty($row) ? "" : $row->remarks;
    }

    /**
     * List Exam Ids
     * 
     * @param type $exam
     */
    function list_exam_ids($exam)
    {
        if ($this->session->userdata('pop'))
        {
            $pop = $this->session->userdata('pop');
            $this->db->where('class_id', $pop);
        }
        $lsu = $this->db->where('exam_type', $exam)->get('exams_management')->result();

        $list = array();
        foreach ($lsu as $l)
        {
            $list[] = (int) $l->id;
        }
        return count($list) ? $list : array('0');
    }

    /**
     * Clear Duplicate
     * 
     * @param type $id
     */
    function clear_dupe($id)
    {
        return $this->db->delete('exams', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  exams (
 	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(256) NOT NULL DEFAULT '',
	`grading` INT(11) NOT NULL,
	`term` INT(11) NOT NULL,
	`year` INT(11) NOT NULL,
	`start_date` INT(11) NULL DEFAULT NULL,
	`end_date` INT(11) NULL DEFAULT NULL,
	`description` TEXT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
                )
                COLLATE='utf8_general_ci'
                ENGINE=InnoDB; ");
    }

    /**
     * Fetch Data for GRID
     * 
     * @param type $limit
     * @param type $page
     * @return boolean
     */
    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('exams', $limit, $offset);

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
