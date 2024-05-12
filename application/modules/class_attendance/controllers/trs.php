<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Trs extends Trs_Controller
{

  function __construct()
  {
    parent::__construct();

    if (!$this->ion_auth->logged_in()) {
      redirect('/login');
    }
    $this->load->model('class_attendance_m');
    $this->load->model('trs_m');
  }

  public function list()
  {
    $data['classes'] = $this->trs_m->list_my_classes();
    // echo "hellos";

    $this->template->title('Attendance')->build('trs/attendance', $data);
  }

  function register($class = 0)
  {
    if (!$class) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('class_attendance/trs/list');
    }
    //create control variables
    $data['updType'] = 'create';
    //Rules for validation
    $this->form_validation->set_rules($this->_att_validation());
    //validate the fields of form
    if ($this->form_validation->run()) {
      $user = $this->ion_auth->get_user();
      $form_data = array(
        'class_id' => $class,
        'attendance_date' => strtotime($this->input->post('attendance_date')),
        'title' => $this->input->post('title'),
        'created_by' => $user->id,
        'created_on' => time()
      );

      $ok = $this->class_attendance_m->create($form_data);

      $remarks = $this->input->post('remarks');
      $status = $this->input->post('status');
      $temperature =  $this->input->post('temperature');
      foreach ($status as $st => $state) {
        $attendace_list = array(
          'attendance_id' => $ok,
          'student' => $st,
          'status' => $state,
          'temperature' => $temperature[$st],
          'remarks' => $remarks[$st],
          'created_by' => $user->id,
          'created_on' => time()
        );
        $this->class_attendance_m->create_list($attendace_list);
      }

      if ($ok) {
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
      } else {
        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
      }
      redirect('class_attendance/trs/list');
    } else {
      $get = new StdClass();
      foreach ($this->_att_validation() as $field) {
        $get->{$field['field']} = set_value($field['field']);
      }
      $data['result'] = $get;
      $data['students'] = $this->class_attendance_m->get_students($class);

      $this->template->title('Add Class Attendance ')->build('trs/register', $data);
    }
  }

  public function list_register($id = 0)
  {
    if (!$id) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('class_attendance/attendance/list/');
    }

    $data['class_attendance'] = $this->class_attendance_m->get($id, 1);
    $data['class'] = $id;

    $this->template->title(' Class Attendance ')->build('trs/list', $data);
  }

  function view_register($id = 0)
  {
    if (!$id) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('class_attendance/attendance/list/');
    }
    if (!$this->class_attendance_m->exists($id)) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('class_attendance/attendance/list/');
    }
    //search the item to show in edit form
    $data['post'] = $this->class_attendance_m->get_register($id);
    $data['dat'] = $this->class_attendance_m->find($id);
    $data['present'] = $this->class_attendance_m->count_present($id);
    $data['absent'] = $this->class_attendance_m->count_absent($id);

    $this->template->title(' Class Register ')->build('trs/view', $data);
  }

  function edit_register($id = 0)
  {
    if (!$id) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('trs/attendance/');
    }
    if (!$this->class_attendance_m->exists($id)) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('trs/attendance/');
    }
    $post = $this->class_attendance_m->get_register($id);
    $dat = $this->class_attendance_m->find($id);
    //search the item to show in edit form

    if ($this->input->post()) {
      $this->form_validation->set_rules($this->_att_validation());
      //validate the fields of form
      if ($this->form_validation->run()) {
        $user = $this->ion_auth->get_user();
        $form_data = array(
          'attendance_date' => strtotime($this->input->post('attendance_date')),
          'title' => $this->input->post('title'),
          'modified_by' => $user->id,
          'modified_on' => time()
        );

        $edit = $this->class_attendance_m->update_attributes($id, $form_data);
        if ($edit) {
          $remarks = $this->input->post('remarks');
          $status = $this->input->post('status');

          foreach ($status as $st => $state) {
            $form = array(
              'status' => $state,
              'remarks' => $remarks[$st],
              'modified_by' => $user->id,
              'modified_on' => time()
            );
            $this->class_attendance_m->update_list($id, $st, $form);
          }
          $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Updated Successfully'));
          redirect('class_attendance/attendance/view_register/' . $id);
        }
      }
    }
    $data['post'] = $post;
    $data['dat'] = $dat;
    $data['present'] = $this->class_attendance_m->count_present($id);
    $data['absent'] = $this->class_attendance_m->count_absent($id);
    $this->template->title('Edit Class Register ')->build('trs/edit', $data);
  }


  /**
   * Add new Attendance
   * 
   * @param int $class
   */


  private function validation()
  {
    $config = array(
      array(
        'field' => 'student',
        'label' => 'Student',
        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
      ),
      array(
        'field' => 'activity',
        'label' => 'Activity',
        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
      ),
      array(
        'field' => 'date_',
        'label' => 'Date ',
        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
      ),
      array(
        'field' => 'teacher_comment',
        'label' => 'Teacher Comment',
        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
      ),
      array(
        'field' => 'parent_comment',
        'label' => 'Parent Comment',
        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
      ),
    );
    $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
    return $config;
  }

  private function set_paginate_options()
  {
    $config = array();
    $config['base_url'] = site_url() . 'trs/diary/index/';
    $config['use_page_numbers'] = TRUE;
    $config['per_page'] = 100;
    $config['total_rows'] = $this->diary_m->count();
    $config['uri_segment'] = 4;

    $config['first_link'] = lang('web_first');
    $config['first_tag_open'] = "<li class='paginate_button'>";
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = lang('web_last');
    $config['last_tag_open'] = "<li class='paginate_button'>";
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = FALSE;
    $config['next_tag_open'] = "<li class='paginate_button'>";
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = FALSE;
    $config['prev_tag_open'] = "<li class='paginate_button'>";
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active">  <a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = "<li class='paginate_button pull-right'>";
    $config['num_tag_close'] = '</li>';
    $config['full_tag_open'] = '<div class="pagination pull-right1"><ul class="pagination">';
    $config['full_tag_close'] = '</ul></div><hr>';
    $choice = $config["total_rows"] / $config["per_page"];
    //$config["num_links"] = round($choice);

    return $config;
  }

  function _file_sizer($kb, $precision = 2)
  {
    $base = log($kb) / log(1024);
    $suffixes = array(' kb', ' MB', ' GB', ' TB');

    $ff = isset($suffixes[floor($base)]) ? $suffixes[floor($base)] : '';
    return round(pow(1024, $base - floor($base)), $precision) . $ff;
  }

  private function _att_validation()
  {
    $config = array(
      array(
        'field' => 'attendance_date',
        'label' => 'Attendance Date',
        'rules' => 'required|xss_clean'
      ),
      array(
        'field' => 'title',
        'label' => 'Title',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'student',
        'label' => 'Student',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'status',
        'label' => 'Status',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'remarks',
        'label' => 'Remarks',
        'rules' => 'xss_clean'
      ),
    );
    $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
    return $config;
  }
}
