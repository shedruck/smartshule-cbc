<?php

class Trs_m extends MY_Model
{

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
  }
  function list_()
  {
    $this->select_all_key('teachers');
    $list = $this->db->order_by('id', 'desc')->get('teachers')->result();

    $trs = [];
    foreach ($list as $key => $l) {
     $trs[$l->id] = $l->first_name.' '.$l->last_name;
    }
    return $trs;
  }

  function fetch_subjects()
  {
    return $this->db->order_by('id', 'DESC')->get('subjects')->result();
  }

  function fetch_cbcsubjects()
  {
    return $this->db->order_by('id', 'DESC')->get('cbc_subjects')->result();
  }

  function fetch_result($cls, $tr, $type)
  {
    return $this->db->order_by('id', 'DESC')->where('class',$cls)
                                            ->where('teacher', $tr)
                                            ->where('type', $type)
                                            ->where('term', $this->school->term)
                                            ->where('year', $this->school->year) 
                                            ->get('subjects_assign')->result();
  }


  function save_assign($table, $data)
  {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }

  public function get_subject_assignment($subject_id, $class, $term, $year)
  {
    $this->db->where('subject', $subject_id);
    $this->db->where('class', $class);
    $this->db->where('term', $term);
    $this->db->where('year', $year);
    $query = $this->db->get('subjects_assign');
    return $query->row(); 
  }

  public function delete_record($subjectId, $classId, $teacherId, $typeId, $termId, $yearId)
  {
    // Define the condition for deleting the record
    $this->db->where('subject', $subjectId);
    $this->db->where('class', $classId);
    $this->db->where('teacher', $teacherId);
    $this->db->where('type', $typeId);
    $this->db->where('term', $termId);
    $this->db->where('year', $yearId);

    
    $this->db->delete('subjects_assign');

    if ($this->db->affected_rows() > 0) {
      return true; 
    } else {
      return false; // No record deleted (or record not found)
    }
  }

  public function update_assign($table, $id, $data)
  {
    $this->db->where('id', $id);
    return $this->db->update($table, $data);
  }

  public function get_clsgroup($class)
  {
    $this->db->where('id', $class);
    $query = $this->db->get('classes');
    return $query->row();
  }


  function  get_subids($cls)
  {
    $this->db->where('class_id', $cls);
    $query = $this->db->get('cbc');
    return $query->result();
  }

  function  get_subjects_by_class($ids)
  {
    if (empty($ids)) {
      return [];
    }
    $this->db->where_in('id', $ids);
    $query = $this->db->get('cbc_subjects');
    return $query->result();
  }

  public function get_assigned_subjects_cbc()
  {
    $id = $this->ion_auth->get_user()->id;
    $this->select_all_key('teachers');
    $this->select('cbc_subjects.*');
    $this->select('subjects_assign.*');
    return $this->db

      ->join('teachers', 'teachers.id=subjects_assign.teacher')
      ->join('cbc_subjects', 'cbc_subjects.id = subjects_assign.subject')
      ->where($this->dx('teachers.user_id') . '=' . $id, NULL, FALSE)
      ->where('subjects_assign.term', $this->school->term)
      ->where('subjects_assign.year', $this->school->year)
      ->get('subjects_assign')
      ->result();
  }


  public function get_assigned_subjects()
  {
    $id = $this->ion_auth->get_user()->id;
    $this->select_all_key('teachers');
    $this->select('subjects.*');
    $this->select('subjects_assign.*');
    return $this->db

      ->join('teachers', 'teachers.id=subjects_assign.teacher')
      ->join('subjects', 'subjects.id = subjects_assign.subject')
      ->where($this->dx('teachers.user_id') . '=' . $id, NULL, FALSE)
      ->where('subjects_assign.term', $this->school->term)
      ->where('subjects_assign.year', $this->school->year)
      ->get('subjects_assign')
      ->result();
  }

  // search for students


  public function search_students($query)
  {
    $this->select_all_key('admission');

    $this->db->like('CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') ", $query, 'both', FALSE);
    $this->db->or_like('CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') ", $query, 'both', FALSE);
    $this->db->or_like('CONVERT(' . $this->dx('admission.admission_number') . " USING 'latin1') ", $query, 'both', FALSE);
    $this->db->or_like('CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') ", $query, 'both', FALSE);
    $query = $this->db->get('admission');
    return $query->result_array();
  }


  function findtr($id)
  {
    $this->select_all_key('users');
    $query = $this->db->get_where('users', array('id' => $id));
    return $query->row();
  }

  function get_stpassport($ph){
    $this->db->where('id', $ph);
    $query = $this->db->get('passports');
    return $query->row();
  }


  function get_prpassport($ph)
  {
    $this->db->where('id', $ph);
    $query = $this->db->get('parents_passports');
    return $query->row();
  }

  function fetch_sibling($id){

    $this->select_all_key('admission');
    $this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
    $this->db->where($this->dx('parent_id') .' =' . $id, NULL, FALSE);
    $query = $this->db->get('admission');
    return $query->result();
  }
  

  function get_projects($st){
    $this->db->where('student', $st);
    $query = $this->db->get('students_projects');
    return $query->result();
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

  function get_attendance($cls){
    $this->db->where('class_id', $cls);
    $this->db->where('term', $this->school->term);
    $this->db->where('year', $this->school->year);
    $query = $this->db->get('class_attendance')->result();

    $myids=[];

    foreach ($query as $key => $q) {
      $myids[] = $q->id;
    }
   
    return $myids;
  }

function get_atte_totals($ids, $stud) {
    if (empty($ids)) {
        return ['present_count' => 0, 'absent_count' => 0];
    }

    $this->db->select('
        SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count,
        SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count
    ');
    $this->db->where_in('attendance_id', $ids);
    $this->db->where('student', $stud);
    $query = $this->db->get('class_attendance_list')->row();

    return [
        'present_count' => $query->present_count,
        'absent_count' => $query->absent_count
    ];
}


}
