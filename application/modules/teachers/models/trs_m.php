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

  function save_assign($table, $data)
  {
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }
  
}
