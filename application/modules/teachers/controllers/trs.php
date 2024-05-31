<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Trs extends Trs_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('teachers_m');
    $this->load->model('trs_m');
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

         $data['result'] = $this->trs_m->fetch_result($class, $teacher, $type);
         $data['teacher'] = $teacher;
         $data['class'] = $class;
         $data['type'] = $type;
        

         $class_group = $this->trs_m->get_clsgroup($class);
         
         $get_ids = $this->trs_m->get_subids($class_group->class);

         $ids = [];
         foreach ($get_ids as $key => $v) {
          $ids[] = $v->subject_id;
         }
      

         if ($type == 1) {
           $data['subs'] = $this->trs_m->fetch_subjects();
         } else {
           $data['subs'] = $this->trs_m->get_subjects_by_class($ids);
         }
         

    $this->template->title('Assign Teacher Subjects')->build('trs/assign', $data);
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

      $success = true;
      foreach ($assigned_subjects_details as $assigned) {
        // Check if the subject is already assigned to someone else
        $existing_assignment = $this->trs_m->get_subject_assignment($assigned['subject'], $assigned['class'], $assigned['term'], $assigned['year']);
        if ($existing_assignment) {
         
          $update_data = array(
            'teacher' => $assigned['teacher'],
            'type' => $assigned['type'],
            'modified_by' => $this->user->id,
            'modified_on' => time(),
          );
          $ok = $this->trs_m->update_assign('subjects_assign', $existing_assignment->id, $update_data);
        } else {
         
          $ok = $this->trs_m->save_assign('subjects_assign', $assigned);
        }

        if (!$ok) {
          $success = false;
          break;
        }
      }

      if ($success) {
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
      } else {
        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
      }

      redirect('teachers/trs/assign_sub');
    }
  }

  public function delete_assign()
  {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Extract data from POST request
      $subjectId = $_POST['subject_id'];
      $classId = $_POST['class'];
      $teacherId = $_POST['teacher'];
      $typeId = $_POST['type'];
      $termId = $_POST['term'];
      $yearId = $_POST['year'];
      $checked = $this->input->post('checked');

      // Update or delete record based on checkbox status
      if ($checked) {

        $existing_assignment = $this->trs_m->get_subject_assignment($subjectId, $classId, $termId, $yearId);

        if ($existing_assignment) {

          $update_data = array(
            'teacher' => $teacherId,
            'type' => $typeId,
            'modified_by' => $this->user->id,
            'modified_on' => time(),
          );
           $this->trs_m->update_assign('subjects_assign', $existing_assignment->id, $update_data);

        } else {

          $form = array(
            'class' => $classId,
            'teacher' => $teacherId,
            'type' => $typeId,
            'subject' => $subjectId,
            'term' => $termId,
            'year' => $yearId,
            'created_by' => $this->user->id,
            'created_on' => time(),
          );

          $ok = $this->trs_m->save_assign('subjects_assign', $form);
        }

       
      } else {
        $this->trs_m->delete_record($subjectId, $classId, $teacherId, $typeId, $termId, $yearId);
      }
      

      // Send success response
      echo json_encode(['status' => 'success']);
    } else {
      // Not a valid AJAX request
      show_404();
    }
  }


  

  public function fetch_subjects()
  {
    $class = $this->input->post('class');
    $systemType = $this->input->post('system');

    if ($class) {
      $cls = $this->trs_m->get_clsgroup($class);
      $subids = $this->trs_m->get_subids($cls->class);

      $ids = [];
      foreach ($subids as $key => $sub) {
        $ids[] = $sub->subject_id;
      }

      if ($systemType === '2') {

        $subjects = $this->trs_m->get_subjects_by_class($ids);
      }else {
        $subjects = $this->trs_m->fetch_subjects();;
      }

      $data = array();
      foreach ($subjects as $subject) {
        $data[] = array(
          'id' => $subject->id,
          'name' => $subject->name
        );
      }

      echo json_encode($data);
    } else {
      echo json_encode(array());
    }
  }


  public function subjectAssigned()
  {

    $subs  = $this->trs_m->get_assigned_subjects();

    $subscbc  = $this->trs_m->get_assigned_subjects_cbc();

    $subjects = array_merge($subs, $subscbc);

    $data['subjects'] = $subjects;


    $this->template->title('Teacher | Subjects Assigned')->build('trs/subjects', $data);
  }



}
