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
    return $this->db->order_by('id', 'desc')->group_by('status')->get('teachers')->result();
  }
  
}
