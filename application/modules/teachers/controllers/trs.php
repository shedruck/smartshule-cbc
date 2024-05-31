<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Trs extends Trs_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('teachers_m');
    if (!$this->ion_auth->logged_in()) {
      redirect('/login');
    }

  }


  public function assign_sub()
  {
    $data['teachers'] = $this->trs_m->list_();

    $this->load->helper('form');

    if ($this->input->post()) {

          
          $class = $this->input->post('class');
          $teacher =  $this->input->post('teacher');
          $type = $this->input->post('type');
          

         }

         $data['teacher'] = $teacher;
         $data['class'] = $class;
         $data['type'] = $type;
    

         if ($type == 1) {
           $data['subs'] = $this->trs_m->fetch_subjects();
         } else {
           $data['subs'] = $this->trs_m->fetch_cbcsubjects();
         }
         

    // echo "<pre>";
    // print_r($subs);
    // echo "<pre>";
    
    // die;

    $this->template->title('Social Behavior Report')->build('trs/assign', $data);
  }

  public function save_assign()
  {
    if ($this->input->post()) {
      $post = $this->input->post();
      $assigned_subjects_details = array();

      foreach ($post as $key => $value) {
        if (strpos($key, 'assign_') === 0) {
          $subject_id = str_replace('assign_', '', $key);
          if ($value == 1) {
            $form = array(
              'class' => $post['class'],
              'teacher' => $post['teacher'],
              'type' => $post['type'],
              'subject' => $subject_id,
              'term' => $this->school->term,
              'year' => $this->school->year,
              'created_by' => $this->user->id,
              'created_on' => time(),

            );
            $assigned_subjects_details[] = $form;
          }
        }
      }
      $successful_inserts = 0;
      foreach ($assigned_subjects_details as $assigned) {
        $ok = $this->trs_m->save_assign('subjects_assign', $assigned);
        if ($ok) {
          $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
          redirect('teachers/trs/assign_sub');
        } else {
          $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
          redirect('teachers/trs/assign_sub');
        }
      }
      
    } 
    
  }



}
