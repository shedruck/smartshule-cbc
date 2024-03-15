<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Public_Controller
{

        /**
         * Class Constructor
         */
        function __construct()
        {
                parent::__construct();
                $this->template->set_layout('default');
                $this->template->set_partial('header', 'partials/header.php');
                $this->template->set_partial('meta', 'partials/meta.php');
                $this->template->set_partial('footer', 'partials/footer.php');
                $this->template->set_partial('sidebar', 'partials/sidebar.php');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }

                $this->load->model('reports_m');
                $this->load->model('exams/exams_m');
        }

        /*         * *
         * *Load student report
         * *
         * */

        function student_report()
        {

                $fks = array();
 
                $this->load->model('admission/admission_m');

                foreach ($this->parent->kids as $k)
                {
                        $usr = $this->admission_m->find($k->student_id);

                        $fks[$k->student_id] = trim($usr->first_name . ' ' . $usr->last_name);
                }

                $data['kids'] = $fks;

                //Load Models
                $this->form_validation->set_rules('student', 'Student ', 'required|xss_clean');
                if ($this->form_validation->run() == true)
                {
                        $id = $this->input->post('student');


                        $this->load->model('borrow_book_fund/borrow_book_fund_m');
                        $this->load->model('medical_records/medical_records_m');
                        $this->load->model('fee_payment/fee_payment_m');
                        $this->load->model('fee_waivers/fee_waivers_m');
                        $this->load->model('assign_bed/assign_bed_m');
                        $this->load->model('hostel_beds/hostel_beds_m');
                        $this->load->model('students_placement/students_placement_m');
                        $this->load->model('disciplinary/disciplinary_m');
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
                        $data['transport'] = array();//$this->assign_transport_facility_m->get($id);
                        $data['transport_facility'] = array();//$this->assign_transport_facility_m->get_transport_facility();
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

                        $data['class_history'] = $this->reports_m->class_history($id);

                        $data['classes_groups'] = $this->reports_m->populate('class_groups', 'id', 'name');
                        $data['classes'] = $this->reports_m->populate('classes', 'id', 'class');
                        $data['class_str'] = $this->reports_m->populate('classes', 'id', 'stream');
                        $data['stream_name'] = $this->reports_m->populate('class_stream', 'id', 'name');

                        $this->template->title('View Student')->build('index/student_report', $data);
                }
                else
                {


                        $this->template->title('View Student Report')->build('index/student_report', $data);
                }
        }

}
