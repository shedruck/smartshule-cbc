
<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Trs extends Trs_Controller
{

  /**
   * Class constructor
   */
  function __construct()
  {
    parent::__construct();
    if ($this->ion_auth->logged_in()) {
      if (!$this->is_teacher) {
        redirect('admin');
      }
    } else {
      redirect('login');
    }
    $this->load->model('trs_m');
    $this->load->model('igcse_m');
    $this->load->model('evideos/evideos_m');
    $this->load->model('messages/messages_m');
    $this->load->model('lesson_plan/lesson_plan_m');
    $this->load->model('assignments/assignments_m');
    $this->load->model('past_papers/past_papers_m');
    $this->load->model('class_attendance/class_attendance_m');
    $this->load->library('Dates');
    $this->template->set_layout('default');
  }



  /**
   * Record Exam Marks
   */
  public function record()
  {
    $config = $this->_exam_paginate_options();
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
    $data['exams'] = $this->igcse_m->paginate_all($config['per_page'], $page);
    $data['thread'] = (object) $this->igcse_m->get_exams();
    //create pagination links
    $data['links'] = $this->pagination->create_links();


    if ($this->input->post()) {

      $class = $this->input->post('class');
      $thread = $this->input->post('thread');
      $exam = $this->input->post('exam');
      $subject = $this->input->post('subject');

      // $addmarks = $this->igcse_m->addmarks();
      $students = $this->igcse_m->get_students($class);
    }

    // $subs = $this->igcse_m->populate('subjects', 'id', 'name');
    // echo "<pre>";
    // print_r($subs);
    // echo "<pre>";
    // die;
    $data['page'] = $page;
    $data['per'] = $config['per_page'];
    $data['classes'] = $this->trs_m->list_my_classes();

    $this->template->title('Marks')->build('trs/record', $data);
  }

  public function view()
  {
    $config = $this->_exam_paginate_options();
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
    $data['exams'] = $this->igcse_m->paginate_all($config['per_page'], $page);
    $data['threads'] = (object) $this->igcse_m->get_exams();

    if ($this->input->post()) {


      $data['exams'] = $this->igcse_m->paginate_all($config['per_page'], $page);
      $data['threads'] = (object) $this->igcse_m->get_exams();
      $class = $this->input->post('class');
      $subject = $this->input->post('subject');
      $thread = $this->input->post('thread');
      $exam = $this->input->post('exam');

      $data['class1'] = $this->input->post('class');
      $data['class'] = $this->input->post('class');
      $data['thread'] = $this->input->post('thread');
      $data['subject'] = $this->input->post('subject');
      $data['exam'] = $this->input->post('exam');

      $data['marks'] = $this->igcse_m->get_marks_trs($class, $subject, $thread, $exam);
    }



    $data['page'] = $page;
    $data['per'] = $config['per_page'];
    $data['classes'] = $this->trs_m->list_my_classes();

    $this->template->title('Marks')->build('trs/view', $data);
  }

  public function addmarks()
  {
    $config = $this->_exam_paginate_options();
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
    $data['exams'] = $this->igcse_m->paginate_all($config['per_page'], $page);
    $data['thread'] = (object) $this->igcse_m->get_exams();
    //create pagination links
    $data['links'] = $this->pagination->create_links();
    $data['grading'] = $this->igcse_m->get_grading_system();



    if ($this->input->post()) {
      $class = $this->input->post('class');
      $thread = $this->input->post('thread');
      $exam = $this->input->post('exam');
      $subject = $this->input->post('subject');
      $data['class'] = $class;
      $data['thread'] = $thread;
      $data['exam'] = $exam;
      $data['subject'] = $subject;




      $data['outof'] = $this->igcse_m->fetch_outof($exam);

      // Retrieve students
      $students = $this->igcse_m->get_students($class);
      $data['students'] = $this->igcse_m->get_students($class);

      $student_ids = array();
      foreach ($students as $student) {
        $student_ids[] = $student->id;
      }

      $data['marks'] = $this->igcse_m->get_results($student_ids, $subject, $exam);
    }

    $data['page'] = $page;
    $data['per'] = $config['per_page'];
    $data['classes'] = $this->trs_m->list_my_classes();

    $this->template->title('Marks')->build('trs/addmarks', $data);
  }

  public function submit_marks()
  {


    if ($this->input->post()) {
      $class = $this->input->post('class');
      $thread = $this->input->post('thread');
      $exam = $this->input->post('exam');
      $subject = $this->input->post('subject');
      $type = $this->igcse_m->fetch_exam_details($exam);
      $gd_id = $this->input->post('grading');
      $outof = $this->input->post('outof');

      $student_ids = $this->input->post('student');
      $classgroup = $this->igcse_m->fetch_classgroup($class);

      // Retrieve marks from the input fields named 'marksnew[]' and 'marks[]'
      $marks_new = $this->input->post('marksnew');
      $marks = $this->input->post('marks');
      $user = $this->ion_auth->get_user();


      $update_success = false;

      foreach ($marks_new as $student_id => $mark_new) {
        $formdata = array(
          'marks' => $mark_new,
          'out_of' => $outof,
          'modified_by' => $user->id,
          'gid' => $gd_id,
          'modified_on' => time(),
        );

        $update_success = $this->db->set($formdata)
          ->where('student', $student_id)
          ->where('subject', $subject)
          ->where('exams_id', $exam)
          ->update('igcse_marks_list');
      }
      $insertion_success = false;
      if (is_array($marks)) {
        foreach ($marks as $student_id => $mark) {
          $data = array(
            'student' => $student_id,
            'marks' => $mark,
            'class' => $class,
            'subject' => $subject,
            'tid' => $thread,
            'gid' => $gd_id,
            'exams_id' => $exam,
            'type' => $type->type,
            'out_of' => $outof,
            'created_on' => time(),
            'created_by' => $user->id,
            'class_group' => $classgroup->class
          );

          $insertion_success = $this->igcse_m->save_marks($data);
        }
      }

      if ($update_success) {
        $this->session->set_flashdata('update_success', 'Update successful!');
      } else {
        $this->session->set_flashdata('insertion_success', 'Insertion successful!');
      }

      redirect('igcse/trs/record');
    }
  }

  public function fetch_exams($threadId)
  {
    $exams = $this->igcse_m->get_exams_by_thread($threadId);

    echo json_encode($exams);
  }
  public function fetch_data($selectedClassId)
  {
    $cls= $this->igcse_m->fetch_class($selectedClassId);
    $clsid = $cls->id;
    //check id of loggin teacher
    $teacher = $this->user->id;
    //class teacher
    $cls_tr = $this->igcse_m->class_teacher($selectedClassId);
    //normal teacher
    $trs = $this->igcse_m->get_teacher($teacher);

    if ($cls_tr->class_teacher == $teacher) {
      $class = $this->igcse_m->fetch_subjects_by_classteacher($clsid);

      $subs = $this->igcse_m->populate('subjects', 'id', 'name');
      $data = array();
      $subjectIds = array(); 
      foreach ($class as $row) {
        
        $subjectName = isset($subs[$row->subject_id]) ? $subs[$row->subject_id] : '';

        
        if (!in_array($row->subject_id, $subjectIds)) {
          $classSubject = array(
            'subject' => $subjectName,
            'value' => $row->subject_id 
          );
          $data[] = $classSubject;
          $subjectIds[] = $row->subject_id;
        }
      }
    }
 else {
      $class = $this->igcse_m->fetch_subjects_by_class($selectedClassId, $trs->id);
 
      $subs = $this->igcse_m->populate('subjects', 'id', 'name');
      $data = array();
      foreach ($class as $row) {
        // Get subject name from the $subs array using subject ID
        $subjectName = isset($subs[$row->subject]) ? $subs[$row->subject] : '';

        $classSubject = array(
          'subject' => $subjectName,
          'value' => $row->subject // Assign subject ID as the value
        );
        $data[] = $classSubject;
      }
    }
   

    // Return the options as JSON
    echo json_encode($data);
  }

  function record_marks()
  {
    $this->template->title('Record marks')->build('trs/record_marks');
  }

  function addcomment($class)
  {

    $data['threads'] = (object) $this->igcse_m->get_exams();


    if ($this->input->post()) {
      $thread = $this->input->post('thread');
      $data['marks'] = $this->igcse_m->gettotal($class, $thread);
      $data['thread'] = $thread;
      $data['class'] = $class;
    }


    $this->template->title('Add comment')->build('trs/addcomment', $data);
  }

  function submit_comment($thread, $class)
  {



    if ($this->input->post()) {

      $newcomment = $this->input->post('commentnew');
      $updatecomment = $this->input->post('comment');

      foreach ($newcomment as $st => $comment) {
        $formdata = array(
          'trs_comment' => $comment,
          'commentedby' => $this->user->id,
          'modified_by' =>  $this->user->id,
          'modified_on' => time(),
        );

        $insert_success = $this->db->set($formdata)
          ->where('student', $st)
          ->where('tid', $thread)
          ->where('class', $class)
          ->update('igcse_final_results');
      }

      foreach ($updatecomment as $st => $update) {
        $formdata = array(
          'trs_comment' => $update,
          'commentedby' => $this->user->id,
          'modified_by' =>  $this->user->id,
          'modified_on' => time(),
        );

        $update_success = $this->db->set($formdata)
          ->where('student', $st)
          ->where('tid', $thread)
          ->where('class', $class)
          ->update('igcse_final_results');
      }

      if ($update_success) {
        $this->session->set_flashdata('update_success', 'Update successful!');
      } elseif ($insert_success) {
        $this->session->set_flashdata('insertion_success', 'Insertion successful!');
      } else {
        redirect('igcse/trs/addcomment/');
      }

      redirect('igcse/trs/addcomment/' . $class);
    }
  }

  /**
   * Record Attendance
   */

  function error()
  {
    if (!$this->ion_auth->logged_in()) {
      $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
      redirect('login');
    }
    $this->template
      ->title('Not Found')
      ->set_layout('error')
      ->build('admin/error');
  }

  function _assign_validation()
  {
    $config = array(
      array(
        'field' => 'title',
        'label' => 'Title',
        'rules' => 'required|trim|xss_clean|max_length[260]'
      ),
      array(
        'field' => 'subject',
        'label' => 'subject',
        'rules' => 'trim'
      ),
      array(
        'field' => 'topic',
        'label' => 'Topic',
        'rules' => 'trim'
      ),

      array(
        'field' => 'subtopic',
        'label' => 'Sub Topic',
        'rules' => 'trim'
      ),

      array(
        'field' => 'start_date',
        'label' => 'Start Date',
        'rules' => 'required|xss_clean'
      ),
      array(
        'field' => 'end_date',
        'label' => 'End Date',
        'rules' => 'required|xss_clean'
      ),
      array(
        'field' => 'assignment',
        'label' => 'Assignment',
        'rules' => 'trim|min_length[0]'
      ),
      array(
        'field' => 'comment',
        'label' => 'Comment',
        'rules' => 'trim'
      ),
      array(
        'field' => 'document',
        'label' => 'Document',
        'rules' => 'trim'
      ),
    );
    $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
    return $config;
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

  /**
   * Pagination Options
   * 
   * @return array
   */
  private function _exam_paginate_options()
  {
    $config = array();
    $config['base_url'] = site_url() . 'trs/record/index';
    $config['use_page_numbers'] = TRUE;
    $config['per_page'] = 15;
    $config['total_rows'] = $this->igcse_m->count();
    $config['uri_segment'] = 4;

    $config['first_link'] = lang('web_first');
    $config['first_tag_open'] = "<li>";
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = lang('web_last');
    $config['last_tag_open'] = "<li>";
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = FALSE;
    $config['next_tag_open'] = "<li>";
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = FALSE;
    $config['prev_tag_open'] = "<li>";
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active">  <a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = "<li>";
    $config['num_tag_close'] = '</li>';
    $config['full_tag_open'] = '<ul class="pagination pagination-split">';
    $config['full_tag_close'] = '</ul></div>';

    return $config;
  }

  /**
   * Record Exams Validation
   * 
   * @return array
   */
  private function _rec_validation()
  {

    $config = array(
      array(
        'field' => 'record_date',
        'label' => 'Record Date',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'exam_type',
        'label' => 'The Exam',
        'rules' => 'trim|xss_clean'
      ),
      array(
        'field' => 'subject[]',
        'label' => 'Subject',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'student[]',
        'label' => 'student',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'total[]',
        'label' => 'Total',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'marks[]',
        'label' => 'Marks',
        'rules' => 'xss_clean'
      ),
      array(
        'field' => 'grading',
        'label' => 'Grading',
        'rules' => 'required'
      ),
      array(
        'field' => 'remarks[]',
        'label' => 'Remarks',
        'rules' => 'xss_clean'
      ),
    );
    $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
    return $config;
  }

  function newsletters()
  {

    $data['newsletters'] = $this->portal_m->newsletters();
    $this->template->title('Newsletters')->build('trs/newsletter', $data);
  }

  public function recordStudentFavHobbies()
  {
    if (isset($_POST['fav'])) {
      $data = array(
        'student' => $this->input->post('student'),
        'class' => $this->input->post('class'),
        'year' => $this->input->post('year'),
        'languages_spoken' => $this->input->post('languages_spoken'),
        'hobbies' => $this->input->post('hobbies'),
        'favourite_subjects' => $this->input->post('favourite_subjects'),
        'favourite_books' => $this->input->post('favourite_books'),
        'favourite_food' => $this->input->post('favourite_food'),
        'favourite_bible_verse' => $this->input->post('favourite_bible_verse'),
        'favourite_cartoon' => $this->input->post('favourite_cartoon'),
        'favourite_career' => $this->input->post('favourite_career'),
        'others' => $this->input->post('others'),
        'created_by' => $this->ion_auth->get_user()->id,
        'created_on' => time()
      );

      $ok = $this->trs_m->trCreateHobby($data);
      if ($ok) {
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
      } else {
        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
      }
      redirect('trs/students');
    }
  }

  public function ViewHobbies()
  {
    $data['mykids'] = $this->trs_m->my_kids();
    $hobbies = $this->trs_m->teacherViewHobbies();
    foreach ($hobbies as $key => $hobby) {
      $hobby->st = $this->worker->get_student($hobby->student);
    }

    $data['hobbies'] = $hobbies;
    $this->template->title('Favourites and Hobbies')->build('trs/hobbies_fav', $data);
  }

  public function appraisal()
  {
    $data['years'] = $this->trs_m->appraisalyears();
    $data['rules'] = $this->trs_m->checkappraisee_rate();
    $data['targets'] = $this->trs_m->checkpast_date();
    $data['teacher'] = $this->trs_m->getteacher();
    if ($this->input->post()) {
      $this->form_validation->set_rules('target_id', 'Target', 'required');
      $this->form_validation->set_rules('teacher', 'teacher', 'required');

      if (!$this->form_validation->run()) {
        //load view
        $this->template->title('Add Book List ')->build('admin/appraise', $data);
      } else {
        $teacher = $this->input->post('teacher');
        $user_id = $this->ion_auth->get_user()->id;

        $target_id = $this->input->post('target_id');
        $rate = $this->input->post('rate');
        foreach ($target_id as $t_id) {
          foreach ($rate as $r) {
            $data = array(
              'target' => $t_id,
              'user_id' => $user_id,
              'teacher' => $teacher,
              'appraisee_rate' => $r,
              'created_on' => time(),
              'created_by' => $this->ion_auth->get_user()->id
            );
          }

          // if($this->trs_m->limitteacher($t_id,$teacher)){
          //     $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => 'You have already appraised this target' ));
          // }else{
          $ok = $this->trs_m->insertresults($data);
          // }
        }
        $this->template->title(' Teacher | Appraisal ')->build('trs/appraisal/index', $data);

        if ($ok) {
          $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
        } else {
          $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
        }

        redirect('trs/appraisal');
      }
    }
    $this->template->title('Appraisal Reports')->build('trs/appraisal/index', $data);
  }

  public function appraisalResult($year)
  {
    $data['terms'] = $this->trs_m->appraisalterms($year);
    $this->template->title('Appraisal Reports')->build('trs/appraisal/result', $data);
  }

  public function appraisalResults($year, $term)
  {
    $data['results'] = $this->trs_m->appraisalresults($year, $term);
    $this->template->title('Appraisal Reports')->build('trs/appraisal/appraisal_results', $data);
  }

  public function selfAppraisal($target)
  {

    $data['targets'] = $this->trs_m->get_target_by_id($target);
    $data['teacher'] = $this->trs_m->getteacher();

    if ($this->input->post()) {
      $rate = $this->input->post('rate');
      $teacher = $this->input->post('teacher');
      $data = array(
        'target' => $target,
        'user_id' => $this->ion_auth->get_user()->id,
        'teacher' => $teacher,
        'appraisee_rate' => $rate,
        'created_on' => time(),
        'created_by' => $this->ion_auth->get_user()->id
      );

      $ok = $this->trs_m->insertresults($data);

      $this->template->title(' Teacher | Appraisal ')->build('trs/appraisal/index', $data);

      if ($ok) {
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
      } else {
        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
      }

      redirect('trs/appraisal');
    }
    $this->template->title('Teacher | Self Appraisal')->build('trs/appraisal/appraisal_form', $data);
  }

  public function subjectAssigned()
  {
    $data['subjects'] = $this->trs_m->get_assigned_subjects();
    $this->template->title('Teacher | Subjects Assigned')->build('trs/subjects', $data);
  }
}
