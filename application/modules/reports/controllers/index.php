<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Public_Controller
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
				
                $this->load->model('reports_m');
                $this->load->model('exams/exams_m');
        }

        function access_portal(){
			
			$data['message'] = '';
			$this->template
						 ->title('Student Details Verification')
						 ->set_layout('verification.php')
						 ->build('index/portal', $data);
		}
		
	  function check_upi(){
		      
			 $upi_number = $this->input->post('upi_number'); 
			 $stud =  $this->reports_m->upi_student(trim($upi_number));
			 $return["json"] = 0;
			 
			 if(!empty($stud)){
				  $return["json"] = json_encode($stud);
			 }
			
             echo json_encode($return);
			 
		}

		
		function verify_code(){
			
			 //Rules for validation
             $this->form_validation->set_rules($this->validation());

            //validate the fields of form
            if ($this->form_validation->run() )
            {         //Validation OK!
			  
			  $code = $this->input->post('code'); 
			  $terms = $this->input->post('terms');
			  
			  // Check if code is validate
			  $cc = $this->reports_m->get_code($code);
			  
			  $data['cc'] = $cc;
			  
			 // print_r($cc);die;
			  if($cc){ 
			 
				 $stud =  $this->reports_m->upi_student(trim($cc->upi_number));
				 
				 $id = $stud->id;
				 
				  $this->load->model('borrow_book_fund/borrow_book_fund_m');
				  $this->load->model('borrow_book/borrow_book_m');
                        $this->load->model('medical_records/medical_records_m');
                        $this->load->model('fee_payment/fee_payment_m');
                        $this->load->model('fee_waivers/fee_waivers_m');
                        $this->load->model('assign_bed/assign_bed_m');
                        $this->load->model('hostel_beds/hostel_beds_m');
                        $this->load->model('students_placement/students_placement_m');
                        $this->load->model('disciplinary/disciplinary_m');

                        $data['extras'] = $this->fee_payment_m->all_fee_extras();
                        if (!$this->admission_m->exists($id))
                        {
                                $this->session->set_flashdata('message', 'Sorry that record does not exist in database');
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

                       
				  
			  }else{
				  
				  $this->session->set_flashdata('message','Sorry the code you entered is invalid');
							redirect('portal');
			  }
			

				 $this->template->title(' Student History Report')
										->set_layout('student_report.php')
										->build('index/student_report', $data);
            }
			
			else{
					redirect('portal','refresh');
			}
		}
		
		 /**
         * Load student report
         *
         */
        function student_report($id)
        {
               //redirect if no $id
					if (!$id){
							$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
							redirect('admin/admission/');
					}
					
					  $this->load->model('admission/admission_m');
					
				 if(!$this->admission_m-> exists($id) )
					 {
						$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
					   redirect('admin/admission');
					}
			  
			  
                      
                        $this->load->model('borrow_book_fund/borrow_book_fund_m');
                        $this->load->model('medical_records/medical_records_m');
                        $this->load->model('fee_payment/fee_payment_m');
                        $this->load->model('fee_waivers/fee_waivers_m');
                        $this->load->model('assign_bed/assign_bed_m');
                        $this->load->model('hostel_beds/hostel_beds_m');
                        $this->load->model('students_placement/students_placement_m');
                        $this->load->model('disciplinary/disciplinary_m');

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

                        $data['class_history'] = $this->reports_m->class_history($id);

                        $data['classes_groups'] = $this->reports_m->populate('class_groups', 'id', 'name');
                        $data['classes'] = $this->reports_m->populate('classes', 'id', 'class');
                        $data['class_str'] = $this->reports_m->populate('classes', 'id', 'stream');
                        $data['stream_name'] = $this->reports_m->populate('class_stream', 'id', 'name');

                        $this->template->title('View Student')->build('admin/student_report', $data);
               
        }
		
		

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'code',
                        'label' => 'Code',
                        'rules' => 'required'),
                    array(
                        'field' => 'terms',
                        'label' => 'terms',
                        'rules' => 'required'),
                    
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

}
