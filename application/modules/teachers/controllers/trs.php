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


  public function fetch()
  {
    $query = $this->input->post('query');
    $data = $this->trs_m->search_students($query);
    echo json_encode($data);
  }

  function student_view($id)
  {

    $data['stu'] = $this->worker->get_student($id);
    $stu = $this->worker->get_student($id);

    $data['sibling'] = $this->trs_m->fetch_sibling($stu->parent_id);

    $sibling = $this->trs_m->fetch_sibling($stu->parent_id);

    $data['projects'] = $this->trs_m->get_projects($id);

    $data['subjects'] = $this->trs_m->populate('cbc_subjects', 'id', 'name');

    $att = $this->trs_m->get_attendance($stu->cl->id);

    $data['att_total'] = $this->trs_m->get_atte_totals($att, $id);

    // echo "<pre>";
    // print_r($att_total);
    // echo "<pre>";
    // die;

    $this->template->title('Student View')->build('trs/student', $data);
  }

  public function create($page = NULL)
  {
    // Initialize data
    $data['updType'] = 'create';
    $data['page'] = $this->uri->segment(4) ? $this->uri->segment(4) : $page;
    $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
    $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');

    // Define validation rules
    $this->form_validation->set_rules($this->validation());

    // Check if the form is valid
    if ($this->form_validation->run()) {
      // Process the form data
      $user = $this->ion_auth->get_user();
      $t_username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
      $temail = $this->input->post('email');

      if (empty($temail)) {
        $dat = explode(' ', $this->input->post('last_name'));
        $rand = (string)$this->random(); 
        $sch = $this->school->school;
         $temail = strtolower($this->input->post('first_name')) . '.' . strtolower($dat[0]) . $rand . '@' .$sch.'.ac.ke';

      }
      $tpassword = '12345678'; // temporary password
      $us_data = array(
        'first_name' => $this->input->post('first_name'),
        'last_name' => $this->input->post('last_name'),
        'phone' => $this->input->post('phone'),
        'me' => $this->ion_auth->get_user()->id,
      );
      $tid = $this->ion_auth->register($t_username, $tpassword, $temail, $us_data);

      // Add to Teachers group
      if ($tid) {
        $this->ion_auth->add_to_group(3, $tid);
      }

      // Handle file uploads
      $this->load->library('files_uploader');
      $file = $this->upload_file('passport');
      $id_document = $this->upload_file('id_document');
      $tsc_letter = $this->upload_file('tsc_letter');
      $credential_cert = $this->upload_file('credential_cert');

      // Prepare data for insertion
      $tt_data = array(
        'first_name' => $this->input->post('first_name'),
        'middle_name' => $this->input->post('middle_name'),
        'last_name' => $this->input->post('last_name'),
        'contract_type' => $this->input->post('contract_type'),
        'marital_status' => $this->input->post('marital_status'),
        'id_no' => $this->input->post('id_no'),
        'status' => 1,
        'passport' => $file,
        'department' => $this->input->post('department'),
        'qualification' => $this->input->post('qualification'),
        'religion' => $this->input->post('religion'),
        'position' => $this->input->post('position'),
        'date_joined' => strtotime($this->input->post('date_joined')),
        'date_left' => strtotime($this->input->post('date_left')),
        'dob' => strtotime($this->input->post('dob')),
        'gender' => $this->input->post('gender'),
        'group_id' => $this->input->post('member_groups'),
        'phone' => $this->input->post('phone'),
        'salary_status' => 0,
        'email' => $temail,
        'pin' => $this->input->post('pin'),
        'address' => $this->input->post('address'),
        'additionals' => $this->input->post('additionals'),
        'tsc_employee' => $this->input->post('tsc_employee'),
        'kuppet_member' => $this->input->post('kuppet_member'),
        'knut_member' => $this->input->post('knut_member'),
        'kuppet_number' => $this->input->post('kuppet_number'),
        'knut_number' => $this->input->post('knut_number'),
        'disability' => $this->input->post('disability'),
        'disability_type' => $this->input->post('disability_type'),
        'phone2' => $this->input->post('phone2'),
        'citizenship' => $this->input->post('citizenship'),
        'county' => $this->input->post('county'),
        'id_document' => $id_document,
        'tsc_letter' => $tsc_letter,
        'credential_cert' => $credential_cert,
        'ref_name' => $this->input->post('ref_name'),
        'ref_phone' => $this->input->post('ref_phone'),
        'ref_email' => $this->input->post('ref_email'),
        'ref_address' => $this->input->post('ref_address'),
        'ref_additionals' => $this->input->post('ref_additionals'),
        'tsc_number' => $this->input->post('tsc_number'),
        'subjects' => $this->input->post('subjects'),
        'user_id' => $tid,
        'status' => $this->input->post('status'),
        'designation' => $this->input->post('position'),
        'special' => $this->input->post('special'),
        'created_by' => $user->id,
        'created_on' => time()
      );

      // Insert data
      $ok = $this->trs_m->create($tt_data);

      if ($ok) {
        // Log the action
        $details = implode(' , ', $this->input->post());
        $log = array(
          'module' => $this->router->fetch_module(),
          'item_id' => $ok,
          'transaction_type' => $this->router->fetch_method(),
          'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
          'details' => $details,
          'created_by' => $user->id,
          'created_on' => time()
        );

        $this->ion_auth->create_log($log);

        // Update teacher record
        $this->teachers_m->update_teacher($ok, array('staff_no' => $ok));
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
      } else {
        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
      }

      redirect('teachers/trs/view_teachers/');
    } else {
      // Prepare data for view
      $get = new StdClass();
      foreach ($this->validation() as $field) {
        $get->{$field['field']} = set_value($field['field']);
      }

      $data['result'] = $get;
      // Load the view and layout
      $this->template->title('Add Teachers ')->build('trs/create', $data);
    }
  }

  // Helper function to upload files
  private function upload_file($field_name)
  {
    if (!empty($_FILES[$field_name]['name'])) {
      $upload_data = $this->files_uploader->upload($field_name);
      return $upload_data['file_name'];
    }
    return '';
  }

  private function validation()
    {

        $config = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'middle_name',
                'label' => 'Middle Name',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'trim'),
            array(
                'field' => 'date_left',
                'label' => 'Date of Leaving',
                'rules' => 'trim'),
            array(
                'field' => 'tsc_number',
                'label' => 'TSC Number',
                'rules' => 'trim'),
            array(
                'field' => 'kuppet_number',
                'label' => 'KUPPET Number',
                'rules' => 'trim'),
            array(
                'field' => 'knut_number',
                'label' => 'KNUT Number',
                'rules' => 'trim'),
            array(
                'field' => 'citizenship',
                'label' => 'Citizenship',
                'rules' => 'trim'),
            array(
                'field' => 'county',
                'label' => 'County',
                'rules' => 'trim'),
            array(
                'field' => 'date_joined',
                'label' => 'Date Joined',
                'rules' => 'trim'),
            array(
                'field' => 'contract_type',
                'label' => 'Contract Type',
                'rules' => 'trim'),
            array(
                'field' => 'marital_status',
                'label' => 'marital status',
                'rules' => 'trim'),
            array(
                'field' => 'dob',
                'label' => 'Date of Birth',
                'rules' => 'trim'),
            array(
                'field' => 'pin',
                'label' => 'PIN',
                'rules' => 'trim'),
            array(
                'field' => 'phone2',
                'label' => 'Phone2',
                'rules' => 'trim'),
            array(
                'field' => 'religion',
                'label' => 'Religion',
                'rules' => 'trim'),
            array(
                'field' => 'id_no',
                'label' => 'ID No',
                'rules' => 'trim'),
            array(
                'field' => 'disability',
                'label' => 'disabled',
                'rules' => 'trim'),
            array(
                'field' => 'disability_type',
                'label' => 'disability type',
                'rules' => 'trim'),
            array(
                'field' => 'kuppet_member',
                'label' => 'KUPPET member',
                'rules' => 'trim'),
            array(
                'field' => 'subjects',
                'label' => 'Subjects',
                'rules' => 'trim'),
            array(
                'field' => 'knut_member',
                'label' => 'KNUT member',
                'rules' => 'trim'),
            array(
                'field' => 'qualification',
                'label' => 'qualification',
                'rules' => 'trim'),
            array(
                'field' => 'position',
                'label' => 'position',
                'rules' => 'trim'),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'trim'),
            array(
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'trim'),
            array(
                'field' => 'department',
                'label' => 'department',
                'rules' => 'trim'),
            array(
                'field' => 'tsc_employee',
                'label' => 'tsc_employee',
                'rules' => 'trim'),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|min_length[0]|max_length[60]'),
            array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
            array(
                'field' => 'additionals',
                'label' => 'Additionals',
                'rules' => 'trim|min_length[0]|max_length[500]'),
            array(
                'field' => 'ref_name',
                'label' => 'Name',
                'rules' => 'trim'),
            array(
                'field' => 'ref_phone',
                'label' => 'Name',
                'rules' => 'trim'),
            array(
                'field' => 'ref_email',
                'label' => 'Email',
                'rules' => 'trim|valid_email'),
            array(
                'field' => 'ref_address',
                'label' => 'Address',
                'rules' => 'trim'),
            array(
                'field' => 'ref_additionals',
                'label' => 'Additional Details',
                'rules' => 'trim'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }


  function random()
  {
    $random_number = '';
    for ($i = 0; $i < 3; $i++) {
      $random_number .= mt_rand(1, 9);
    }
    return $random_number;
  }


  function edit($id, $page = NULL)
  {
    $this->load->model('users/users_m');

    //get the $id and sanitize
    $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

    $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

    //redirect if no $id
    if (!$id) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('teachers/trs/list/');
    }
    if (!$this->teachers_m->exists($id)) {
      $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
      redirect('teachers/trs/list/');
    }

    /**
     * * Details from Teachers Table
     * */
    $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
    $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');

    $get = $this->trs_m->find($id);

    //print_r($get);die;
    $this->data['result'] = $get;

    //$the_user = $this->ion_auth->get_user($id);
    // $usr_groups = $this->ion_auth->get_users_groups($id)->result();
    //Rules for validation
    $this->form_validation->set_rules($this->validation());

    //create control variables
    $data['updType'] = 'edit';
    $data['page'] = $page;

    //validate form input

    if ($this->form_validation->run() == true) {
      $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
      $email = $this->input->post('email');

      $additional_data = array(
        'username' => $username,
        'email' => $email,
        'phone' => $this->input->post('phone'),
        'first_name' => $this->input->post('first_name'),
        'last_name' => $this->input->post('last_name'),
        'modified_by' => $this->ion_auth->get_user()->id,
        'modified_on' => time(),
      );

      $this->ion_auth->update_user($get->user_id, $additional_data);

      $this->load->library('files_uploader');

      $file = $get->passport;
      if (!empty($_FILES['passport']['name'])) {

        $upload_data = $this->files_uploader->upload('passport');
        $file = $upload_data['file_name'];
      }

      $id_document = $get->id_document;
      if (!empty($_FILES['id_document']['name'])) {

        $upload_data = $this->files_uploader->upload('id_document');
        $id_document = $upload_data['file_name'];
      }

      $tsc_letter = $get->tsc_letter;
      if (!empty($_FILES['tsc_letter']['name'])) {

        $upload_data = $this->files_uploader->upload('tsc_letter');
        $tsc_letter = $upload_data['file_name'];
      }

      $credential_cert = $get->credential_cert;
      if (!empty($_FILES['credential_cert']['name'])) {

        $upload_data = $this->files_uploader->upload('credential_cert');
        $credential_cert = $upload_data['file_name'];
      }


      // UPDATE TEACHER'S TABLE
      $user = $this->ion_auth->get_user();
      // build array for the model
      $form_data = array(
        'first_name' => $this->input->post('first_name'),
        'middle_name' => $this->input->post('middle_name'),
        'last_name' => $this->input->post('last_name'),
        'contract_type' => $this->input->post('contract_type'),
        'marital_status' => $this->input->post('marital_status'),
        'id_no' => $this->input->post('id_no'),
        'department' => $this->input->post('department'),
        'qualification' => $this->input->post('qualification'),
        'religion' => $this->input->post('religion'),
        'position' => $this->input->post('position'),
        'date_joined' => strtotime($this->input->post('date_joined')),
        'date_left' => strtotime($this->input->post('date_left')),
        'dob' => strtotime($this->input->post('dob')),
        'gender' => $this->input->post('gender'),
        'group_id' => $this->input->post('member_groups'),
        'phone' => $this->input->post('phone'),
        'salary_status' => 0,
        'email' => $this->input->post('email'),
        'pin' => $this->input->post('pin'),
        'address' => $this->input->post('address'),
        'additionals' => $this->input->post('additionals'),
        'tsc_employee' => $this->input->post('tsc_employee'),
        'kuppet_member' => $this->input->post('kuppet_member'),
        'knut_member' => $this->input->post('knut_member'),
        'disability' => $this->input->post('disability'),
        'disability_type' => $this->input->post('disability_type'),
        'phone2' => $this->input->post('phone2'),
        'citizenship' => $this->input->post('citizenship'),
        'county' => $this->input->post('county'),
        'kuppet_number' => $this->input->post('kuppet_number'),
        'knut_number' => $this->input->post('knut_number'),
        'subjects' => $this->input->post('subjects'),
        'id_document' => $id_document,
        'tsc_letter' => $tsc_letter,
        'passport' => $file,
        'credential_cert' => $credential_cert,
        'ref_name' => $this->input->post('ref_name'),
        'ref_phone' => $this->input->post('ref_phone'),
        'ref_email' => $this->input->post('ref_email'),
        'ref_address' => $this->input->post('ref_address'),
        'ref_additionals' => $this->input->post('ref_additionals'),
        'tsc_number' => $this->input->post('tsc_number'),
        'special' => $this->input->post('special'),
        //'user_id' => 773,
        'status' => $this->input->post('status'),
        'designation' => $this->input->post('position'),
        'modified_by' => $user->id,
        'modified_on' => time()
      );
      $done = $this->teachers_m->update_teacher($id, $form_data);

      if ($done) {
        $details = implode(' , ', $this->input->post());
        $user = $this->ion_auth->get_user();
        $log = array(
          'module' => $this->router->fetch_module(),
          'item_id' => $done,
          'transaction_type' => $this->router->fetch_method(),
          'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
          'details' => $details,
          'created_by' => $user->id,
          'created_on' => time()
        );

        $this->ion_auth->create_log($log);


    
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
        redirect("teachers/trs/profile/" . $id);
      } else {
        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
        redirect("teachers/trs/view_teachers/");
      }
    } else {
      foreach (array_keys($this->validation()) as $field) {
        if (isset($_POST[$field])) {
          $get->$field = $this->form_validation->$field;
        }
      }
    }
    $data['result'] = $this->trs_m->get_teacher($id);
    //load the view and the layout
    $this->template->title('Edit Teachers ')->build('trs/create', $data);
  }


  function view_teachers(){

    $data['teachers'] = $this->trs_m->all_teachers();
    // echo "<pre>";
    // print_r($teachers);
    // echo "<pre>";
    // die;

    $this->template->title('Edit Teachers ')->build('trs/view', $data);
  }

 function profile($id){

    $data['teacher'] = $this->trs_m->get_teacher($id);

    $this->template->title('Teacher Profile ')->build('trs/profile', $data);
 }


  


}
