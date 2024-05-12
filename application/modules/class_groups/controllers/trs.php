<?php defined('BASEPATH') or exit('No direct script access allowed');

class Trs extends Trs_Controller
{
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
        $this->load->model('exams/exams_m');
        $this->load->model('igcse/igcse_m');
        $this->load->model('evideos/evideos_m');
        $this->load->model('messages/messages_m');
        $this->load->model('lesson_plan/lesson_plan_m');
        $this->load->model('assignments/assignments_m');
		 $this->load->model('past_papers/past_papers_m');
        $this->load->model('class_attendance/class_attendance_m');
    }


    public function students($class = NULL)
    {
        $act = 0;
        $this->session->unset_userdata('extrra');
        if ($this->input->get('extras'))
        {
            $act = $this->input->get('extras');
            if ($act)
            {
               $this->session->set_userdata('extrra', $act);
            }
        }

        $data['students'] = $this->trs_m->list_my_classes($act);
        $data['class_id'] = $class;
        $data['mykids']=$this->trs_m->my_kids();

        $term = get_term(date('m'));
        $year = date('Y');
        $data['extras'] = $this->trs_m->get_current($term, $year);
        $this->template->title('My Students')->build('teachers/students', $data);
    }

    public function myclasses($class = NULL)
    {
        $act = 0;
        $this->session->unset_userdata('extrra');
        if ($this->input->get('extras'))
        {
            $act = $this->input->get('extras');
            if ($act)
            {
               $this->session->set_userdata('extrra', $act);
            }
        }

        $data['students'] = $this->trs_m->list_my_classes($act);
        $data['class_id'] = $class;
        $data['mykids']=$this->trs_m->my_kids();

        $term = get_term(date('m'));
        $year = date('Y');
        $data['extras'] = $this->trs_m->get_current($term, $year);
        $this->template->title('My Students')->build('teachers/myclasses', $data);
    }

    public function recordStudentFavHobbies(){
        if(isset($_POST['fav'])){
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
 
          $ok= $this->trs_m->trCreateHobby($data);
          if($ok){
             $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            
          }else{
             $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
          }
           redirect('class_groups/trs/students');
           
        }
    }

    public function ViewHobbies(){
        $data['mykids']=$this->trs_m->my_kids();
        $hobbies= $this->trs_m->teacherViewHobbies();
        foreach ($hobbies as $key => $hobby)
        {
            $hobby->st = $this->worker->get_student($hobby->student);
        }
    
           $data['hobbies']=$hobbies;
          $this->template->title('Favourites and Hobbies')->build('teachers/hobbies_fav', $data);
       }

       function view_student($id = 0)
    {
        if (!$this->admission_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('class_groups/trs/students');
        }
        $stud = $this->admission_m->find($id);
        $parent_id = $this->admission_m->find($id);
        $this->worker->calc_balance($id);

        $data['cl'] = $this->admission_m->fetch_class($parent_id->class);
        $data['fee'] = $this->fee_payment_m->fetch_balance($stud->id);
        $data['student'] = $stud;
        $data['passport'] = $this->admission_m->passport($stud->photo);


        $this->load->model('borrow_book_fund/borrow_book_fund_m');
        $this->load->model('borrow_book/borrow_book_m');
        $this->load->model('medical_records/medical_records_m');
        $this->load->model('fee_payment/fee_payment_m');
        $this->load->model('fee_waivers/fee_waivers_m');
        $this->load->model('assign_bed/assign_bed_m');
        $this->load->model('hostel_beds/hostel_beds_m');
        $this->load->model('students_placement/students_placement_m');
        $this->load->model('disciplinary/disciplinary_m');
        $this->load->model('reports/reports_m');

        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        if (!$this->admission_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/reports/student_report');
        }
        $stud = $this->admission_m->find($id);
        $data['passport'] = $this->admission_m->passport($stud->photo);
        $student = $this->admission_m->find($id);
        $data['student'] = $student;

        $parent_id = $this->admission_m->find($id);
        $data['parent_details'] = $this->admission_m->get_parent($parent_id->parent_id);
        $data['cl'] = $this->admission_m->fetch_class($parent_id->class);
        $data['title'] = 'Fee Statement';

        $data['em_cont'] = $this->admission_m->get_emergency_contacts($id);
        $data['extra_c'] = $this->reports_m->get_extras($id);
        $data['other_certs'] = $this->reports_m->other_certs($id);
        $data['national_exams'] = $this->reports_m->national_exams($id);

        $data['p'] = $this->fee_payment_m->get_receipts($id);
        //Beds
        $data['bed'] = $this->assign_bed_m->get($id);
        $data['beds'] = $this->assign_bed_m->get_hostel_beds();
        //Placement position
        $data['position'] = $this->students_placement_m->get($id);
        $data['st_pos'] = $this->students_placement_m->get_positions();
        //Exams Results
        $exams = array(); //$this->exams_management_m->get_by_student($id);

        $data['exams'] = $exams;
        //Exams Type
        $data['type'] = $this->admission_m->populate('exams', 'id', 'year');
        $data['term'] = $this->admission_m->populate('exams', 'id', 'term');
        $data['type_details'] = $this->admission_m->populate('exams', 'id', 'title');

        //Disciplinary
        $data['disciplinary'] = $this->disciplinary_m->get($id);
        //Medical Records
        $data['medical'] = $this->medical_records_m->by_student($id);

        $tm = get_term(date('m'));
        $data['waiver'] = $this->admission_m->get_waiver($id, $tm);
        //Transport Details
        $data['transport'] = array(); //$this->assign_transport_facility_m->get($id);
        $data['transport_facility'] = array(); // $this->assign_transport_facility_m->get_transport_facility();
        $data['amt'] = $this->admission_m->total_fees($student->class);
        $data['post'] = $this->fee_payment_m->get_row($id);
        $data['banks'] = $this->fee_payment_m->banks();
        $this->worker->calc_balance($id);
        // $data['paid'] = $this->fee_payment_m->fetch_balance($student->id);
        $data['fee'] = $this->fee_payment_m->fetch_balance($student->id);
        $data['paro'] = $this->admission_m->get_paro($stud->parent_id);

        //Book Fund
        $data['books'] = $this->reports_m->populate('book_fund', 'id', 'title');
        $data['student_books'] = $this->borrow_book_fund_m->by_student($id);

        // Library Books
        $data['lib_books'] = $this->reports_m->populate('books', 'id', 'title');
        $data['borrowed_books'] = $this->borrow_book_m->by_student($id);

        $data['class_history'] = $this->reports_m->class_history($id);

        $data['classes_groups'] = $this->reports_m->populate('class_groups', 'id', 'name');
        $data['classes'] = $this->reports_m->populate('classes', 'id', 'class');
        $data['class_str'] = $this->reports_m->populate('classes', 'id', 'stream');
        $data['stream_name'] = $this->reports_m->populate('class_stream', 'id', 'name');
		
		$data['favourite_hobbies'] = $this->portal_m->get_unenc_result('student',$student->id,'favourite_hobbies');

        $data['days_present'] = $this->reports_m->days_present($id);
        $data['days_absent'] = $this->reports_m->days_absent($id);

        $this->template->title('View Student')->build('teachers/view', $data);
    }
    
}
