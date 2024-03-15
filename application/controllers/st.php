<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class St extends St_Controller
{

        /**
         * Class constructor
         */
        function __construct()
        {
                parent::__construct();
                if ($this->ion_auth->logged_in())
                {
                        if (!$this->is_student)
                        {
                            redirect('admin');
                        }
                }
                else
                {
                        redirect('login');
                }
                $this->load->model('st_m');
                $this->load->model('trs_m');
                $this->load->model('exams/exams_m');
                $this->load->model('reports/reports_m');
                $this->load->model('messages/messages_m');
                $this->load->model('assignments/assignments_m');
				$this->load->model('grading/grading_m');
                $this->load->model('class_attendance/class_attendance_m');
                $this->load->model('past_papers/past_papers_m');
                $this->load->model('evideos/evideos_m');
                $this->load->library('Dates');
                $this->template->set_layout('default');
        }

 

        public function index()
        {
                $data['events'] = $this->portal_m->get_events();
				
                $rep = $this->st_m->get_class_rep($this->student->class);
                $data['class_rep'] = $rep?  $this->portal_m->get_teacher_profile($rep->class_teacher) : (object) [];
                $data['summary'] = $this->fee_payment_m->get_balance($this->student->id);
				
                $data['borrowed_books'] = $this->st_m->count_borrowed_books($this->student->id);
                $data['returned_books'] = $this->st_m->count_returned_books($this->student->id);
				
                $data['count_present'] = $this->st_m->count_attendance('Present',$this->student->id);
                $data['count_absent'] = $this->st_m->count_attendance('Absent',$this->student->id);
                $data['count_assignments'] = $this->st_m->count_assignments($this->student->class,$this->student->admission_date);
                $data['class_assignments'] = $this->st_m->class_assignments($this->student->class,$this->student->admission_date,8);
				
                $data['count_exams'] = $this->st_m->count_exams($this->student->admission_date);
                $data['all_exams'] = $this->st_m->all_exams($this->student->admission_date,8);
				
				$data['done_exams'] = $this->st_m->count_done_exams($this->student->id);
				$data['done_cbc'] = $this->st_m->done_cbc($this->student->id);
               
                $this->template->title('Home')->build('st/home/home', $data);
        }
		
		function landing($page){
			
			  
                $data['borrowed_books'] = $this->st_m->count_borrowed_books($this->student->id);
                $data['returned_books'] = $this->st_m->count_returned_books($this->student->id);
				
                $data['count_present'] = $this->st_m->count_attendance('Present',$this->student->id);
                $data['count_absent'] = $this->st_m->count_attendance('Absent',$this->student->id);
                $data['count_assignments'] = $this->st_m->count_assignments($this->student->class,$this->student->admission_date);
                $data['class_assignments'] = $this->st_m->class_assignments($this->student->class,$this->student->admission_date,8);
				
                $data['count_cbc_subjects'] = $this->st_m->count_cbc_subjects($this->student->class);
                $data['count_educators'] = $this->st_m->count_educators($this->student->class);
				
		        $data['grading_systems'] = $this->grading_m->paginate_all(10000, 1);
				
                $data['count_exams'] = $this->st_m->count_exams($this->student->admission_date);
                $data['all_exams'] = $this->st_m->all_exams($this->student->admission_date,8);
				$data['done_exams'] = $this->st_m->count_done_exams($this->student->id);
				$data['done_cbc'] = $this->st_m->done_cbc($this->student->id);
				
				 $cg = $this->portal_m->class_group_row($this->student->class);
				 $data['count_videos'] = $this->st_m->count_evideos($cg->class);
				 
				 $data['count_enotes'] = $this->st_m->count_enotes($cg->class);
			
			$data['title'] = $page;
			$data['student'] = $this->student->id;
			$this->template->title('Home')->build('st/home/'.$page, $data);
		}
		
		function class_subjects(){
			
			 $data['cbc'] = $this->st_m->get_cbc_sub($this->student->class);
			 $data['subjects'] = $this->st_m->get_subjects($this->student->class);	 
			 $this->template->title('Subjects / CBS Assessment')->build('st/academics/subjects', $data);
			 
		}
		
		 public function grading_system()
        {
			   

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['grading'] = $this->grading_m->paginate_all(10000, $page);

                $data['grades'] = $this->grading_m->grades();
                $data['list_grades'] = $this->grading_m->list_grades();

                //load view
                $data['grading_system'] = $this->grading_m->get_grading_system();
                $this->template->title('Grading Systems ')->build('st/academics/grading_system', $data);
        }

        function view_grades($id = 0)
        {
			   
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('st/landing/academics');
                }
                if (!$this->grading_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('st/landing/academics');
                }

                //search the item to show in edit form
                $data['grading_id'] = $id;
                $data['post'] = $this->grading_m->get_grades($id);
                $data['dat'] = $this->grading_m->find($id);
                $data['sys'] = $this->grading_m->get_grading_system();

                $this->template->title(' Grading ')->build('st/academics/grading_view', $data);
        }
		
		function educators(){
			
			 $data['educators'] = $this->st_m->get_educators($this->student->class);
			// print_r($this->st_m->get_educators($this->student->class));die;
             $this->template->title(' Grading ')->build('st/academics/educators', $data);
			
		}

		
		//*****
		//*****
		//***** E - Class Room 
		//*****
		//*****
		
		//******* Past Papers **********//
		function past_papers(){

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$data['past_papers'] = $this->past_papers_m->folders(1000000, 1);
			$data['level'] = $this->st_m->get_level_pp($this->student->class);

			//load view
			$this->template->title('All Past Papers ' )->build('st/e_class_room/pp-folders', $data);
				
		}
		
		function level_past_papers($page=NULL){

			$data['pp'] = $this->st_m->get_level_pp($this->student->class);
			//load view
			$this->template->title('Level Past Papers ' )->build('st/e_class_room/level-files', $data);
		}
		
   function view_past_papers($id=FALSE, $page = NULL)
        {
            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('st/past_papers');
          }
		   
		    $data['folder'] = $id;
			$data['pp'] = $this->past_papers_m->by_folder($id);

			//create pagination links
			$data['links'] = $this->pagination->create_links();
			//load the view and the layout
		 $this->template->title('View Past Papers ' )->build('st/e_class_room/pp-files', $data);
		 
		}

    //******** E-Videos **************//
	
	
	function evideos(){

		 $cg = $this->portal_m->class_group_row($this->student->class);

         $sys = $this->ion_auth->populate('class_groups','id','education_system');
		
			if($sys[$cg->class] ==1){
				
				 $data['subjects'] = $this->evideos_m->get_sub844($cg->class);
				 $data['subs'] = $this->ion_auth->populate('subjects','id','name');
				 
			}elseif($sys[$cg->class] ==2){
				 $data['subjects'] = $this->evideos_m->get_cbc_subjects($cg->class);
				 $data['subs'] = $this->ion_auth->populate('cbc_subjects','id','name');
			}
			
			 $data['count_general'] = $this->st_m->count_general_evideos();
			
			$data['class'] = $cg->class;
				
		 $this->template->title('E-Videos')->build('st/e_class_room/evideos_landing', $data);
		 
	}
	
	public function watch($subject,$session,$id=NULL)
	{	   
				$cg = $this->portal_m->class_group_row($this->student->class);
				
				if(empty($id)){ 
				    $post = $this->st_m->get_last_video($cg->class,$subject);
				    $data['post'] = $post;
					$data['comments'] = $this->st_m->get_video_comments($post->id,1);
				}else{
					$data['post'] = $this->evideos_m->find($id);
					$data['comments'] = $this->st_m->get_video_comments($id,1);
				}
				
				//print_r($cg->class.'-'.$subject);die;

                $data['evideos'] = $this->st_m->get_per_subject($cg->class,$subject);
				$data['class']=$cg->class;
				
				$sys = $this->ion_auth->populate('class_groups','id','education_system');
				if($sys[$cg->class] ==1){
					
						$subs = $this->ion_auth->populate('subjects','id','name');
				 
				}elseif($sys[$cg->class] ==2){
					
						 $subs = $this->ion_auth->populate('cbc_subjects','id','name');
				}
				
				$data['subject']=$subs[$subject];

            //load view
            $this->template->title(' E-videos ' )->build('st/e_class_room/watch', $data);
	}

	public function watch_general($session,$id=NULL)
	{	   

		
			 if(empty($id)){ 
				    $post = $this->st_m->get_last_gvideo();
				    $data['post'] = $post;
					$data['comments'] = $this->st_m->get_video_comments($post->id,2);
				}else{
					$data['post'] = $this->st_m->find_general_vid($id);
					$data['comments'] = $this->st_m->get_video_comments($id,2);
			   }
				
			 $data['general'] = $this->st_m->get_general_evideos();
            //load view
            $this->template->title(' General E-videos ' )->build('st/e_class_room/watch-general', $data);
	}
	
	function post_comment(){
		
		$type=  $this->input->post('type');
		$id=  $this->input->post('id');
		$comment=  $this->input->post('comment');
		
		if( $this->input->post()){
			  $user = $this -> ion_auth -> get_user();
			$data = array(
			  'video_id'=>$id,
			  'type'=>$type,
			  'comment'=>$comment,
			  'status'=>1,
			  'created_by' => $user -> id ,   
			  'created_on' => time()
			);
			
			$this->portal_m->create_unenc('evideo_comments',$data);
		}
		
	}
	
		
	function enotes(){

		 $cg = $this->portal_m->class_group_row($this->student->class);

         $sys = $this->ion_auth->populate('class_groups','id','education_system');
		
			if($sys[$cg->class] ==1){
				
				 $data['subjects'] = $this->evideos_m->get_sub844($cg->class);
				 $data['subs'] = $this->ion_auth->populate('subjects','id','name');
				 
			}elseif($sys[$cg->class] ==2){
				 $data['subjects'] = $this->evideos_m->get_cbc_subjects($cg->class);
				 $data['subs'] = $this->ion_auth->populate('cbc_subjects','id','name');
			}
			
			$data['class'] = $cg->class;
				
		 $this->template->title('E-Notes')->build('st/e_class_room/enotes_landing', $data);
		 
	}
	
	function view_enotes($subject,$session){
		
		 //redirect if no $id
            if (!$subject && !$session){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('st/enotes/');
            }
			
			$cg = $this->portal_m->class_group_row($this->student->class);
			$data['notes'] = $this->st_m->get_unenc_erecords($subject,$cg->class,'enotes');
			
			
			 $sys = $this->ion_auth->populate('class_groups','id','education_system');
			if($sys[$cg->class] ==1){
					
						$subs = $this->ion_auth->populate('subjects','id','name');
				 
				}elseif($sys[$cg->class] ==2){
					
						 $subs = $this->ion_auth->populate('cbc_subjects','id','name');
				}
				
			$data['subject']=$subs[$subject];
		
		    $this->template->title('E-Notes')->build('st/e_class_room/enotes', $data);
	}
	
function assignments(){
	
     $data['class_assignments'] = $this->st_m->class_assignments($this->student->class,$this->student->admission_date);
	 
	 $this->template->title('Assignments')->build('st/e_class_room/assignments', $data);
	
}

   function assignments_view($id,$class,$session=NULL)
    {
        //redirect if no $id
        $st = $this->portal_m->get_student($this->user->id);
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('st/assignments');
        }
        if (!$this->assignments_m->exists_class_assgn($id,$this->student->class))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('st/assignments');
        }
		 
		 $data['done'] = $this->st_m->get_done_assgn($this->student->id,$id);
		
		 $post = $this->assignments_m->find($id);
		 $data['post'] =  $post;
		 $data['class'] =  $class;
		
		 
		 $this->template->title('Assignments')->build('st/e_class_room/assignments_view', $data);
		 
	}
	
		/******* Upload Assignment ***********/
		
	function upload_assignment($id,$class,$sess=NULL)
        {
			 //redirect if no $id
               if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('st#academics');
                }
				
                if (!$this->assignments_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('st/assignments');
                }
				
			$document = '';
				
			  $this->load->library('files_uploader');
	  
				 $dest = FCPATH . "/uploads/assignments/" . date('Y') . '/';
					if (!is_dir($dest))
					{
							mkdir($dest, 0777, true);
					} 
						
						 

                if (!empty($_FILES['document']['name']))
                {
                       $uploadPath = $dest ;
						$config['upload_path'] = $uploadPath;
						$config['allowed_types'] = 'pdf|doc|docx|csv|xsl|xlsx|jpg|png';
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						//$this->upload->do_upload('file');
				
						$upload_data = $this->files_uploader->upload('document');
						
						$file = $upload_data['file_name'];
						$file_size=$upload_data['file_size'];
						$file_type=$upload_data['file_type'];
                }
				
				//*** Status 0 - Completed Assignment****//
				
				    $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'date' =>time(),
                            'student' => $this->student->id,
                            'assignment' => $this->input->post('assignment'),
                            'student_comment' => $this->input->post('comment'),
                            'file' => $file,
                            'path' =>  'assignments/' . date('Y') . '/',
                            'file_size' => $file_size,
                            'file_type' => $file_type,
                            'status' => '0', 
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                     $ok = $this->portal_m->create_unenc('assignments_done',$form_data);
					 
					 if($ok){
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("st/assignments_view/".$id.'/'.$class.'/'.$this->session->userdata['session_id']);
							
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("st/assignments_view/".$id.'/'.$class.'/'.$this->session->userdata['session_id']);
                        }
			
		}

		
		 /****
         **** Show attendance
         ****/
		 
        public function attendance_register()
        {

                $att = array();
                $stud = '';
				$month =(int)date('m');
				$year =(int)date('Y');
				
              
				$student = $this->student->id;
				$stud = $student;
				$att = $this->class_attendance_m->stud_get_trend_($student);
						
						$data['present']= $this->class_attendance_m->stud_att_counter($student,'Present');
				$data['absent']= $this->class_attendance_m->stud_att_counter($student,'Absent');
              
               
				
                $data['att'] = $att;
                $data['stud'] = $stud;

                $this->template->title('Class Attendance')->build('st/academics/class_attendance_view', $data);
        }
		
    function certificates(){
		 
		  $data['nx'] = $this->st_m->st_national_exams($this->student->id);
		  $data['oc'] = $this->st_m->st_other_certificates($this->student->id);
          $this->template->title(' Certificates Exams')->build('st/academics/certificates', $data);
		  
	 }	
		
  public function diary()
    {
		$this->load->model('diary/diary_m');
        $config = $this->set_paginate_diary(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
		
        $data['diary'] = $this->st_m->get_diary($config['per_page'], $page);
        $data['extra_diary'] = $this->st_m->get_extra_diary($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Diary ')->build('st/academics/diary', $data);
    }
	
  private function set_paginate_diary()
    {
        $config = array();
        $config['base_url'] = site_url() . 'st/diary/index';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 100;
        $config['total_rows'] = $this->diary_m->count();
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
       $config['full_tag_open'] = '<div class="pagination pull-right1"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></div><br>';
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }
	
	function exams(){
		
		$data['exams'] = $this->st_m->all_exams($this->student->admission_date,100000);
        //load view
        $this->template->title(' Diary ')->build('st/academics/exams', $data);
	}
	

     /**
         * Generate Report Forms  - Bulk
         * 
         * @param $exam
         * 
         */
	function results($exam)
        {
                
                $has = TRUE;
                $remk = FALSE;
                if ($this->student->id && $exam)
                {
                        $student = $this->student->id;
                        $exam = $exam;
                        $xm = $this->exams_m->find($exam);
                        $rec = $this->exams_m->is_recorded($exam);

                        $st = $this->worker->get_student($student);
                        $cls = $this->exams_m->get_stream($st->class);
                        $data['subjects'] = $this->exams_m->get_subjects($cls->class, $xm->term);
                        if ($cls->rec == 2)
                        {
                                $remk = TRUE;
                        }

                        if (!$xm || !$rec)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                                $has = FALSE;
                        }
                        if ($remk)
                        {
                                $data['remarks'] = $this->exams_m->fetch_by_exam($exam, $student);
                                $data['full'] = $this->exams_m->fetch_gen_remarks($exam, $student);
                        }
                        else
                        {
                                $mine = $this->exams_m->get_report($exam, $student,$cls->class);
                                $data['report'] = $mine;
                        }

                        $data['grading'] = $xm ? $this->exams_m->get_grading($xm->grading) : array();

                        $data['exam'] = $xm;
                        $data['full_subjects'] = $this->exams_m->get_full_subjects();

                        $streams = $this->exams_m->populate('class_stream', 'id', 'name');
                        $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
                        $data['student'] = $st;
                        $data['streams'] = $streams;
                        $data['cls'] = $cls;
						$data['days_present'] = $this->reports_m->days_present($student);
                        $data['days_absent'] = $this->reports_m->days_absent($student);
                }
                else
                {
                        redirect('st/exams');
                }
                $data['proc'] = $has;
            
                $this->load->model('admission/admission_m');

          
                 $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');
                $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');
                $data['remk'] = $remk;
                $data['exams'] = $this->exams_m->fetch_all_exams();
                $this->template->title(' View Exam Results')->build('st/academics/results', $data);
        }
		
		
     function national_exams(){
		 
		  $this->load->model('reports/reports_m');
		  $this->load->model('reports/reports_m');
				  
		  $p =  $this->st_m->student_final_exam($this->student->id); 
		  $data['grades'] =  $this->st_m->get_grades($p->id); 
		  $data['p'] = $p;
				  
		 
		 $this->template->title('National Report Forms')->build('st/exams/national_exams_results', $data);
	 }

        /**
         * Student Fee Statement
         * 
         * @param type $id
         */
		 
		 function fee_pledge(){
			 
			   $data['fee_pledge'] = $this->st_m->student_pledges($this->student->id);
			 
			  $this->template->title('Fee Pledges')->build('st/pledge/list', $data);
		 }
		 
        function fee()
        {
                $data['banks'] = $this->fee_payment_m->banks();
                $data['summary'] = $this->fee_payment_m->get_balance($this->student->id);
                $data['post'] = $this->student;
                $data['arrs'] = $this->fee_payment_m->fetch_total_arrears($this->student->id);
                $data['extras'] = $this->fee_payment_m->all_fee_extras();
                $payload = $this->worker->process_statement($this->student->id);

                $data['payload'] = $payload;
                $this->template->title(' Fee Statement')->build('st/fee/statement', $data);
        }
		
		function receipts(){
			
			$data['recs'] = $this->st_m->student_receipts();
			$this->template->title(' Fee Receipts')->build('st/payments/receipts', $data);
				
		}
		
		
		

		/****
		****
		*** Student Profile
		***
		**/

        function profile()
        {
                $id = $this->student->id;



                $this->load->model('reports/reports_m');
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
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('students');
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

                $data['days_present'] = $this->reports_m->days_present($id);
                $data['days_absent'] = $this->reports_m->days_absent($id);
				$data['favourite_hobbies'] = $this->portal_m->get_unenc_result('student',$id,'favourite_hobbies');

                $this->template->title('View Student')->build('st/home/profile', $data);
        }



		/****
		****
		*** Student Profile
		***
		**/

        function account()
        {
                $id = $this->student->id;



                $this->load->model('reports/reports_m');
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
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('students');
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

                $data['days_present'] = $this->reports_m->days_present($id);
                $data['days_absent'] = $this->reports_m->days_absent($id);
				$data['favourite_hobbies'] = $this->portal_m->get_unenc_result('student',$id,'favourite_hobbies');

                $this->template->title('View Student')->build('st/home/profile', $data);
        }
		
	function library_books(){
			
			 $this->load->model('reports/reports_m');
                $this->load->model('borrow_book_fund/borrow_book_fund_m');
                $this->load->model('borrow_book/borrow_book_m');
			 $data['lib_books'] = $this->reports_m->populate('books', 'id', 'title');
             $data['borrowed_books'] = $this->borrow_book_m->by_student($this->student->id);
				
			$this->template->title(' Fee Receipts')->build('st/common/library', $data);
				
		}
		

        /**
         * log the user out
         */
        function logout()
        {
                $this->ion_auth->logout();
                //redirect them back to the page they came from
                redirect('/', 'refresh');
        }

        /**
         * change password
         */
        function change_password()
        {
                $this->form_validation->set_rules('old', 'Old password', 'required');
                $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
                $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');
                if (!$this->ion_auth->logged_in())
                {
                        redirect('login', 'refresh');
                }
                $user = $this->ion_auth->get_user($this->session->userdata('user_id'));
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                if ($this->form_validation->run() == FALSE)
                {
                        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                        $this->data['old_password'] = array('name' => 'old',
                            'id' => 'old',
                            'class' => 'form-control',
                            'type' => 'password',
                        );
                        $this->data['new_password'] = array('name' => 'new',
                            'id' => 'new',
                            'class' => 'form-control',
                            'type' => 'password',
                        );
                        $this->data['new_password_confirm'] = array('name' => 'new_confirm',
                            'id' => 'new_confirm',
                            'class' => 'form-control',
                            'type' => 'password',
                        );
                        $this->data['user_id'] = array('name' => 'user_id',
                            'id' => 'user_id',
                            'type' => 'hidden',
                            'value' => $user->id,
                        );
                        $this->template
                                     ->title('Change Password')
                                     ->build('st/auth/change_password', $this->data);
                }
                else
                {
                        $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));
                        $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
                        if ($change)
                        { //if the password was successfully changed
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                $this->logout();
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Unable to change password'));
                                redirect('st/change_password', 'refresh');
                        }
                }
        }
		

		
	//*********** Fee *************//
	
	   /**
         * Student Fee Statement
         * 
         * @param type $id
         */
        function fee_statement()
        {
			
			   $id = $this->student->id;
                if (!$this->student)
                {
                        redirect('st');
                }
           
                if (!$this->fee_payment_m->student_exists($id))
                {
                        redirect('st#finance');
                }
				
				 $this->load->model('fee_payment/fee_payment_m');

                $post = $this->fee_payment_m->get_student($id);
                $data['banks'] = $this->fee_payment_m->banks();
                $data['post'] = $post;
                $data['class'] = $this->portal_m->fetch_class($post->class);
                $data['cl'] = $this->portal_m->get_class_options();
                $data['arrs'] = $this->fee_payment_m->fetch_total_arrears($id);
                $data['extras'] = $this->fee_payment_m->all_fee_extras();
                $payload = $this->worker->process_statement($id);

                $data['payload'] = $payload;
                $this->template->title(' Fee Statement')->build('st/payments/fee_statement', $data);
        }
		

		
		  /**
         * Get Datatable
         * 
         */
        public function get_paid()
        {
			    $this->load->model('fee_payment/fee_payment_m');
			  
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);

                $output = $this->fee_payment_m->student_receipts($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho,$this->student->id);
                echo json_encode($output);
        }
		
		
        function view_receipt($rec_id)
        {
			    $this->load->model('fee_payment/fee_payment_m');
				
                if (!$this->fee_payment_m->exists_receipt($rec_id)) {
                        redirect('st/get_paid');
                }

                $data['extras'] = $this->fee_payment_m->all_fee_extras();
                $data['title'] = 'Fee Receipt';
                $data['total'] = $this->fee_payment_m->total_payment($rec_id);
                $data['p'] = $this->fee_payment_m->get_pays($rec_id);
                $post = $this->fee_payment_m->get_row_time($rec_id);
                $data['post'] = $post;
                $data['rec_id'] = $rec_id;

                $data['banks'] = $this->fee_payment_m->banks();
                $classes = $this->ion_auth->list_classes();
                $streams = $this->ion_auth->get_stream();
                $ccc = $this->fee_payment_m->get_student($post->reg_no);
                if (!isset($ccc->class)) {
                        $sft = ' - ';
                        $st = ' - ';
                } else {
                        $crow = $this->portal_m->fetch_class($ccc->class);
                        if (!$crow) {
                                $sft = ' - ';
                                $st = ' - ';
                        } else {
                                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
                        }
                }



                $data['class'] = $sft . '  ' . $st;
                $rect = $this->fee_payment_m->fetch_receipt($rec_id);
                $data['fee'] = $this->fee_payment_m->fetch_balance($rect->student);
                $this->template->title(' Fee payment')->build('st/payments/view_receipt',$data);
        }
		
		  /**
         * View Fee Structure
         * 
         */
        function fee_structure()
        {
                  $this->load->model('fee_structure/fee_structure_m');

                $fee_structure = array(); //$this->fee_structure_m->fetch_all();
                if (!empty($fee_structure))
                {
                        foreach ($fee_structure as $f)
                        {
                                $f->classes = array(); //deleted
                        }
                }
                else
                {
                        $fee_structure = array();
                }
                $fnl = array();
                foreach ($fee_structure as $fee)
                {
                        if (isset($fee->classes) && !empty($fee->classes))
                        {
                                foreach ($fee->classes as $tt => $fspe)
                                {
                                        foreach ($fspe as $clas => $spec)
                                        {
                                                $fnl[$tt] [$clas] = $spec;
                                        }
                                }
                        }
                }

                $data['fxtras'] = $this->fee_structure_m->fetch_extras();
                // $data['parent'] = $parent;
                 $data['banks'] = $this->fee_structure_m->banks();
                //  $data['id'] = $id;
                $data['fee'] = $fnl;
                //load the view and the layout
                $this->template->title('Fee Structure')->build('st/payments/fee_structure', $data);
        }

		
		//*********** Notice Board ****//
		
	public function notice_board()
	{	   

        $data['notice_board'] = $this->portal_m->get_all('notice_board');
            //load view
        $this->template->title(' Notice Board ' )->build('st/common/notice_board', $data);
	}
	
	public function events()
	{	   

        $data['events'] = $this->portal_m->get_all('events');
            //load view
        $this->template->title(' Events ' )->build('st/common/events', $data);
	}
	
	//********** SMS ***********//
	
	public function sms_alerts()
        {
                $this->load->model('sms/sms_m');
                $data['sms'] = $this->st_m->student_sms();

                //load the view and the layout
                $this->template->title('My Messages ')->build('st/common/log', $data);
        }
		
	//****** Newsletters ********//	
	public function newsletters()
	{	   

        $data['newsletters'] = $this->portal_m->get_all('newsletters');
            //load view
        $this->template->title(' Newsletters ' )->build('st/common/newsletters', $data);
	}

        public function zoom_classes(){
                $data['classes']= $this->portal_m->get_zoom_notifications();
                $this->template->title(' Zoom Classes ' )->build('st/e_class_room/zoom_classes', $data);
        }

        public function mark_as_read(){
                $user_id=$this->input->post('user_id');
                $zoom_id=$this->input->post('zoom_id');
                $data= array(
                        'status' => '1'
                );
                $ok= $this->portal_m->mark_as_read($user_id,$zoom_id,$data);
                if($ok){
                        echo "success";
                }else{
                        echo "failed";
                }

        }

        
 

}
