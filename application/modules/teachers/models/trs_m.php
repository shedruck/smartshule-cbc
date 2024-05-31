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

}
