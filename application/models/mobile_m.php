<?php

class Mobile_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
function getstudent()
{
	return "felix";
}
function getparent($id)
{
	$this->select_all_key("parents");
	return $this->db->where("user_id",$id)->get("parents")->row();
}
function getattendance($id)
{
	return $this->db->where("student",$id)->get("class_attendance_list")->result();
}
function getext($id)
{
	return $this->db->where("id",$id)->get("class_attendance")->row();
}
 function get_c_exam()
		 {
			
			return $this->db->get('exams')->result(); 
		 }



}