<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trs extends Trs_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('cbc_m');
        // $this->load->model('cbc_tr');
        $this->load->model('assignments_m');
        $this->load->model('trs_m');
        if (!$this->ion_auth->logged_in()) {
            redirect('/login');
        }

        // $this->cbc =  $this->cbc_tr;
    }


    // public function index()
    // {
    //     //load view
    //     $this->template->title(' CBC Assessment')->build('teachers/index', []);
    // }

    public function index()
    {
        $term = get_term(date('m'));
        $year = date('Y');
        $data['extras'] = $this->trs_m->get_current($term, $year);
        $data['classes'] = $this->trs_m->list_my_classes();

        $this->template->title('Assignments')->build('teachers/list', $data);
    }

    public function assign($class)
    {
        //Rules for validation
        $this->form_validation->set_rules($this->_assign_validation());

        $document = '';
        if (!empty($_FILES['document']['name']))
        {
            $this->load->library('files_uploader');
            $upload_data = $this->files_uploader->upload('document');
            $document = $upload_data['file_name'];
        }

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $this->load->model('assignments/assignments_m');
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'subject' => $this->input->post('subject'),
                'topic' => $this->input->post('topic'),
                'subtopic' => $this->input->post('subtopic'),
                'title' => $this->input->post('title'),
                'start_date' => strtotime($this->input->post('start_date')),
                'end_date' => strtotime($this->input->post('end_date')),
                'assignment' => $this->input->post('assignment'),
                'comment' => $this->input->post('comment'),
                'document' => $document,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->assignments_m->create($form_data);

            if ($ok)
            {
                $values = array(
                    'assgn_id' => $ok,
                    'class' => $class,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->assignments_m->insert_classes($values);
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }
            redirect('assignments/trs/list_assign/' . $class);
        }
        else
        {
            $get = new StdClass();
            foreach ($this->_assign_validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
        }
		
		$data['subjects'] = $this->portal_m->get_subject_assigned($class,$this->profile->id);
        $this->template->title('Assignments')->build('teachers/create', $data);
		
    }

    function mark_assign($id, $stud,$class,$sess=NULL)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('assignments/trs');
        }
        if (!$this->assignments_m->done_exists($id,$stud))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('assignments/trs/');
        }

        $data['p'] = $this->assignments_m->find_done($id);
        
        $data['class'] = $class;
        $data['stud'] = $stud;
      

        $this->template->title('View Assignment')->build('teachers/view_done', $data);
    }

    function set_as_marked($id,$stud, $class, $sess=NULL)
        {
                //redirect if no $id
            if (!$id && !$stud && !$class)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('assignments/trs');
                }
				
			 if (!$this->assignments_m->done_exists($id,$stud))
				{
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('assignments/trs');
				}
				
				$p = $this->assignments_m->find_done($id);
				
				$file = $p->result;
				
				  $this->load->library('files_uploader');
		  
					 $dest = FCPATH . "/uploads/assignments/" . date('Y') . '/';
						if (!is_dir($dest))
						{
								mkdir($dest, 0777, true);
						} 
						
						 

                if (!empty($_FILES['file']['name']))
                {
                       $uploadPath = $dest ;
						$config['upload_path'] = $uploadPath;
						$config['allowed_types'] = 'pdf|doc|docx|csv|xsl|xlsx';
						
						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						//$this->upload->do_upload('file');
				
						$upload_data = $this->files_uploader->upload('file');
						
						$file = $upload_data['file_name'];
						$file_size=$upload_data['file_size'];
						$file_type=$upload_data['file_type'];
                }
				
				$user = $this->ion_auth->get_user();
						 $data = array(
								'status' =>  1, 
								'result' => $file,
								'result_path' =>  'assignments/' . date('Y') . '/',
								'comment' => $this->input->post('comment'), 
								'points' => $this->input->post('points'), 
								'out_of' => $this->input->post('out_of'), 
								'date_marked' => time(), 
								'marked_by' => $user -> id
							);

						$ok =  $this->portal_m->update_unenc('assignments_done',$id,$data);
						  
				
                        if ($ok)
                        {

							 $tracker = array(
							 
									'student' => $stud,
									'item_id' => $id,
									'class' => $class,
									'type' => 1,
									'status' => 1,          
									'created_by' => $this->ion_auth->get_user()->id,
									'created_on' => time()
								);
								
                            //$this->portal_m->create_unenc('assignments_tracker',$tracker);

							$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
						}
						else{
								 $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
							}		
				
				redirect('assignments/trs/mark_assign/'.$id.'/'.$stud.'/'.$class.'/'.$this->session->userdata['session_id']);

		}

    function view_assign($id, $class)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('assignments/trs');
        }
        if (!$this->assignments_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('assignments/trs');
        }

        $data['p'] = $this->assignments_m->find($id);
        $data['done'] = $this->assignments_m->done($id);
        $data['class'] = $class;
        $data['extras'] = 0;
        if ($this->input->get())
        {
            $data['extras'] = 1;
        }

        $this->template->title('View Assignment')->build('teachers/view', $data);
    }

    public function edit_assign($id, $ref)
    {
        $asst = $this->assignments_m->find($id);
        //Rules for validation
        $this->form_validation->set_rules($this->_assign_validation());

        $document = $asst->document;
        if (!empty($_FILES['document']['name']))
        {
            $this->load->library('files_uploader');
            $upload_data = $this->files_uploader->upload('document');
            $document = $upload_data['file_name'];
        }

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $this->load->model('assignments/assignments_m');
            $user = $this->ion_auth->get_user();
            $form_data = array(
                 'subject' => $this->input->post('subject'),
                'topic' => $this->input->post('topic'),
                'subtopic' => $this->input->post('subtopic'),
				'title' => $this->input->post('title'),
                'start_date' => strtotime($this->input->post('start_date')),
                'end_date' => strtotime($this->input->post('end_date')),
                'assignment' => $this->input->post('assignment'),
                'comment' => $this->input->post('comment'),
                'document' => $document,
                'modified_by' => $user->id,
                'modified_on' => time()
            );
            $ok = $this->assignments_m->update_attributes($id, $form_data);

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Updated Successfully'));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            $action = $this->input->post('extras') == 1 ? 'list_extras' : 'list_assign';
            redirect('assignments/trs/' . $action . '/' . $ref);
        }
        else
        {
            $data['result'] = $asst;
        }
        $ex = 0;
        if ($this->input->get())
        {
            $ex = 1;
        }
        $data['type'] = 'Edit';
        $data['ex'] = $ex;
		
		$data['subjects'] = $this->portal_m->get_subject_assigned($ref,$this->profile->id);
        $this->template->title('Assignments')->build('teachers/create', $data);
    }

    public function list_assign($id)
    {
        $data['assignments'] = $this->trs_m->get_assignments($id);
        $data['classes'] = $this->trs_m->list_my_classes();
        $data['ref'] = $id;
        $data['extras'] = false;

        $this->template->title('Assignments')->build('teachers/list_assign', $data);
    }

    function _assign_validation()
    {
        $config = array(
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required|trim|xss_clean|max_length[260]'),
		array(
				'field' => 'subject',
                'label' => 'subject',
                'rules' => 'trim'),
		array(
				'field' => 'topic',
                'label' => 'Topic',
                'rules' => 'trim'),
				
		array(
				'field' => 'subtopic',
                'label' => 'Sub Topic',
                'rules' => 'trim'),
				
            array(
                'field' => 'start_date',
                'label' => 'Start Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'end_date',
                'label' => 'End Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'assignment',
                'label' => 'Assignment',
                'rules' => 'trim|min_length[0]'),
            array(
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'trim'),
            array(
                'field' => 'document',
                'label' => 'Document',
                'rules' => 'trim'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    function begin_form()
    {
        $data['classes'] = $this->cbc_tr->my_classes();
        $this->template->title(' Formative Assessment')->build('teachers/formative', $data);
    }

    function init_form($class)
    {
        $data[] = [];
        $this->template->title(' Formative Assessment')->build('teachers/formative', $data);
    }

    function get_subjects($c)
    {
        $payload = $this->cbc_tr->find_allocation($c);

        $cls = isset($this->streams[$c]) ? $this->streams[$c]  : '';
        echo json_encode(['load' => $payload, 'class' => $cls]);
    }

    //Function to Summative
    function do_summative($class, $subject, $exam = false)
    {
        $this->load->helper('form');
        $args = func_get_args();
        $subjects = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
        $su =  isset($subjects[$subject]) ? $subjects[$subject] : 'Subject';
        $data['strands'] =  $this->cbc->fetch_strands($subject);

        $data['substrands'] = $this->cbc->fetch_substrands();
        $data['subject'] = $su;
        $data['class'] = isset($this->streams[$class]) ? $this->streams[$class] : '';

        if ($exam) {
            $students = $this->cbc_tr->get_students($class);
            $data['students'] = $students;
        }


        if ($this->input->post()) {
            $k = 0;
            $kk = 0;
            $post = (object) $this->input->post();
            $stus = $post->student;

            foreach ($stus as $keey => $st) {
                $form_data = array(
                    'sub' => $subject,
                    'exam' => $exam,
                    'student' => $st,
                    'class' => $class,
                    'gid' => $post->grading,
                    'score' => $post->score[$st],
                    'type' => $post->extype,
                    'outof' => $post->outof
                );

                //Check if marks Exists
                $checkmarks = $this->cbc_tr->get_stu_marks($subject, $exam, $st);

                if ($checkmarks) {
                    //Update
                    $form_data['modified_by'] = $this->user->id;
                    $form_data['modified_on'] = time();
                    $done = $this->cbc_tr->update_with($checkmarks->id, $form_data, 'cbc_marks');

                    if ($done) {
                        $k++;
                    }
                } else {
                    //Insert
                    $form_data['created_by'] = $this->user->id;
                    $form_data['created_on'] = time();
                    $ok = $this->cbc_tr->create_marks('cbc_marks', $form_data);
                    if ($ok) {
                        $kk++;
                    }
                }
            }


            $inserted_message = $kk . ' records successfully Inserted.';
            $this->session->set_flashdata('inserted_message', array('type' => 'success', 'text' => $inserted_message));

            // Set session message for updated records
            $updated_message = $k . ' records successfully updated.';
            $this->session->set_flashdata('updated_message', array('type' => 'success', 'text' => $updated_message));

            redirect("cbc/trs/do_summative/" . $class . "/" . $subject . "/" . $exam);


        }

        $data['attr'] = $args;
        $data['gradings'] = $this->cbc_tr->populate('grading_system', 'id', 'title');
        $data['exam'] = $exam;
        $data['cls'] = $class;
        $data['sub'] = $subject;

        $this->template->title($su . ' assessment')->build('teachers/summative_form', $data);
    }

    function do_formative($class, $subject)
    {

        $args = func_get_args();
        $subjects = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
        $su =  isset($subjects[$subject]) ? $subjects[$subject] : 'Subject';
        $data['strands'] =  $this->cbc->fetch_strands($subject);

        $data['substrands'] = $this->cbc->fetch_substrands();
        $data['subject'] = $su;
        $data['class'] = isset($this->streams[$class]) ? $this->streams[$class] : '';


        if ($this->input->get()) {
            $get = (object) $this->input->get();
            $rubric =  $this->cbc->fetch_tasks($subject, $get->strand, $get->substrand);
            $data['rubric'] = $rubric;

            $strands =  $this->cbc->populate('cbc_la', 'id', 'name');
            $tasks =  $this->cbc->populate('cbc_topics', 'id', 'name');

            $data['strand'] = isset($strands[$get->strand]) ? $strands[$get->strand] : '';
            $data['substrand'] = isset($tasks[$get->substrand]) ? $tasks[$get->substrand] : '';
        }

        $data['attr'] = $args;

        $this->template->title($su . ' assessment')->build('teachers/formative_form', $data);
    }


    function perform_assessment()
    {
        if ($this->input->get()) {
            $get =  (object) $this->input->get();

            $post = (object) $this->cbc->decryptParameters($get->arg);




            $payload = $this->cbc->get_assessd($post);



            $students =  $this->cbc->get_students($post->class);

            $subjects = $this->cbc_tr->populate('cbc_subjects', 'id', 'name');
            $data['subject_name'] =  isset($subjects[$post->subject]) ? $subjects[$post->subject] : 'Subject';
            $data['class_name'] =  isset($this->streams[$post->class]) ? $this->streams[$post->class] : 'class';

            $data['students'] = $students;

            $data['post'] = $post;

            $data['payload'] = $payload;
            $data['task'] = $this->cbc->find_task($post->task);
        }

        $this->template->title('Formative Assessment')->build('teachers/forma_form', $data);
    }


    function get_comments()
    {
        if ($this->input->post()) {
            $post = (object) $this->input->post();
            $rmks  = $this->cbc->fetch_remark($post->post_data['subject'], $post->post_data['strand'], $post->post_data['substrand'], $post->post_data['task']);





            $remarks = [
                4 => $rmks->ee_remarks,
                3 => $rmks->me_remarks,
                2 => $rmks->ae_remarks,
                1 => $rmks->be_remarks
            ];

            $result = '';


            switch ($post->score) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $result = $remarks[$post->score];
                    break;
                default:
                    $result = "--";
                    break;
            }

            // Output the result
            echo json_encode($result);
        }
    }

    function save_assesment()
    {
        if ($this->input->post()) {
            $post = (object) $this->input->post();

            $p = (object) $this->cbc->decryptParameters($post->params);

            $session = bin2hex(random_bytes(16)) . base64_encode($this->user->id . date('i'));



            foreach ($post->student as $st => $student) {

                // learning area
                $assess = $this->cbc_m->get_assess($p->class, $st, $p->subject, $this->school->term, $this->school->year);
                if ($assess) {
                    $ss_id = $assess->id;
                } else {
                    $form = [
                        'class' => $p->class,
                        'student' => $st,
                        'term' => $this->school->term,
                        'year' => $this->school->year,
                        'subject' => $p->subject,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');
                }


                $rating = isset($post->score[$st]) ? $post->score[$st] : '';
                $remarks = isset($post->remarks[$st]) ? $post->remarks[$st] : '';



                // strand

                $sr = $this->cbc_m->get_strand_rating($ss_id, $p->strand);

                if ($sr) {
                    $form = [
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->cbc_m->update_with($sr->id, $form, 'cbc_assess_strands');
                } else {
                    if (isset($p->strand)) {
                        $form = [
                            'assess_id' => $ss_id,
                            'strand' => $p->strand,
                            'created_by' => $this->user->id,
                            'created_on' => time()
                        ];

                        $this->cbc_m->create_sub($form, 'cbc_assess_strands');
                    }
                }


                // substrand
                $row = $this->cbc_m->get_sub_rating($ss_id, $p->strand, $p->substrand);

                if ($row) {
                    $form = [
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->cbc_m->update_with($row->id, $form, 'cbc_assess_sub');
                } else {
                    $form = [
                        'assess_id' => $ss_id,
                        'strand' => $p->strand,
                        'sub_strand' => $p->substrand,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $this->cbc_m->create_sub($form, 'cbc_assess_sub');
                }


                // task
                $sk = $this->cbc_m->get_task_rating($ss_id, $p->strand, $p->substrand, $p->task);

                if ($sk) {
                    $form = [
                        'rating' => $rating,
                        'status' => ($post->publish == 1) ? 1 : 0,
                        'session' => $session,
                        'remarks' => $remarks,
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->cbc_m->update_with($sk->id, $form, 'cbc_assess_tasks');
                } else {
                    $form = [
                        'assess_id' => $ss_id,
                        'strand' => $p->strand,
                        'session' => $session,
                        'status' => ($post->publish == 1) ? 1 : 0,
                        'sub_strand' => $p->substrand,
                        'task' => $p->task,
                        'rating' => $rating,
                        'remarks' => $remarks,
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    ];

                    $this->cbc_m->create_sub($form, 'cbc_assess_tasks');
                }
            }


            // // $ss_id = $this->cbc_m->create_sub($form, 'cbc_assess');

            echo '<pre>';
            print_r($post);
            echo '</pre>';
            die();
        }
    }


    function begin_summative_form()
    {
        $data['classes'] = $this->cbc_tr->my_classes();
        $cls = $this->cbc_tr->my_classes();
        $this->template->title('Summative Assessment')->build('teachers/summative', $data);
    }
}
