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
        if ($this->ion_auth->logged_in())
        {
            if (!$this->is_teacher)
            {
                redirect('admin');
            }
        }
        else
        {
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
        $this->load->library('Dates');
        $this->template->set_layout('default');
    }

    /**
     * Home Page
     */
    public function index()
    {
        $assigned = $this->trs_m->all_classes();
        $data['classes'] = array_unique($assigned);

        $data['students'] = $this->admission_m->count_my_students();
        $data['events'] = $this->portal_m->get_events();


        $this->template->title('Home')->build('trs/home', $data);
    }
	
	function eclassroom(){
		 $data['data'] = '';
		 $this->template->title('E-Classroom')->build('trs/e-classroom', $data);
		 
	}
	

	
	/****
	*** Past Papers 
	*****
	*****/
	
		function past_papers(){

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
			$data['past_papers'] = $this->past_papers_m->folders(10000000, 1);
			
			//load view
			$this->template->title('All Past Papers ' )->build('trs/past-papers/pp-folders', $data);
				
		}
		
		
	function view_past_papers($id=FALSE, $page = NULL)
        {
            //redirect if no $id
            if (!$id){
                    $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
                    redirect('trs/past_papers');
          }
		   
		    $data['folder'] = $id;
			$data['pp'] = $this->past_papers_m->by_folder($id);

			//create pagination links
			$data['links'] = $this->pagination->create_links();
			//load the view and the layout
		 $this->template->title('View Past Papers ' )->build('trs/past-papers/pp-files', $data);
		 
		}
	

    /**
     * E-Videos 
     */
	 
	  public function evideos_landing()
		{
			
			$data['messages'] = '';
			$this->template
						  ->title('E-videos')
						  ->build('trs/evideos/landing', $data);
		}
		
 public function watch_general($session,$id=NULL)
	{	   

		
	if(empty($id)){ 
				    $post = $this->portal_m->get_last_gvideo();
				    $data['post'] = $post;
					$data['comments'] = $this->portal_m->get_video_comments($post->id,2);
				}else{
					$data['post'] = $this->portal_m->find_general_vid($id);
					$data['comments'] = $this->portal_m->get_video_comments($id,2);
			   }
				
			 $data['general'] = $this->portal_m->get_general_evideos();
            //load view
            $this->template->title(' General E-videos ' )->build('trs/evideos/watch-general', $data);
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
	
	/**
	** Level Videos
	**/
	
	function level_evideos($class, $session){

		//redirect if no $id
		if (!$class){
				$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
				redirect('trs/evideos_landing/');
		}
			
         $sys = $this->ion_auth->populate('class_groups','id','education_system');
		
			if( $sys[$class] ==1){
				
				 $data['subjects'] = $this->evideos_m->get_sub844($class);
				 $data['subs'] = $this->ion_auth->populate('subjects','id','name');
				 
			}elseif($sys[$class] ==2){
				
				 $data['subjects'] = $this->evideos_m->get_cbc_subjects($class);
				 $data['subs'] = $this->ion_auth->populate('cbc_subjects','id','name');
			}
						
			$data['class'] = $class;
				
		 $this->template->title('E-Videos')->build('trs/evideos/level_evideos', $data);
		 
	}
	
		public function watch($subject,$class,$session,$id=NULL)
	    {	   
				
				//redirect if no $id
				if (!$class && $subject){
						$this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => lang('web_object_not_exist') ) );
						redirect('trs/evideos_landing/');
				}
			
			
				if(empty($id)){ 
				    $post = $this->portal_m->get_last_video($class,$subject);
				    $data['post'] = $post;
					$data['comments'] = $this->portal_m->get_video_comments($post->id,1);
				}else{
					$data['post'] = $this->evideos_m->find($id);
					$data['comments'] = $this->portal_m->get_video_comments($id,1);
				}
				
				//print_r($cg->class.'-'.$subject);die;

                $data['evideos'] = $this->portal_m->get_per_subject($class,$subject);
				$data['class']=$class;
				
				$sys = $this->ion_auth->populate('class_groups','id','education_system');
				if($sys[$class] ==1){
					
						$subs = $this->ion_auth->populate('subjects','id','name');
				 
				}elseif($sys[$class] ==2){
					
						 $subs = $this->ion_auth->populate('cbc_subjects','id','name');
				}
				
				$data['class']=$class;
				$data['subject']=$subs[$subject];

            //load view
            $this->template->title(' E-videos ' )->build('trs/evideos/watch', $data);
	}
	 
	 /**
     * messages
     */
    public function messages()
    {
        $feed = $this->messages_m->get_feed(array($this->user->id));

        $data['messages'] = $feed;
        $this->template
                          ->title('Messages & Feedback')
                          ->build('trs/messages/messages', $data);
    }

    function lesson_plan()
    {
        $config = $this->set_paginate_lesson_plan(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['lesson_plan'] = $this->lesson_plan_m->get_teacher_plan($config['per_page'], $page, $this->profile->id);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Lesson Plan ')->build('trs/lesson_plan/list', $data);
    }

    function add_plan($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';

        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->valid_lesson_plan());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'teacher' => $this->profile->id,
                'class' => $this->input->post('class'),
                'term' => $this->input->post('term'),
                'year' => $this->input->post('year'),
                'week' => $this->input->post('week'),
                'day' => $this->input->post('day'),
                'subject' => $this->input->post('subject'),
                'lesson' => $this->input->post('lesson'),
                'activity' => $this->input->post('activity'),
                'objective' => $this->input->post('objective'),
                'materials' => $this->input->post('materials'),
                'assignment' => $this->input->post('assignment'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->lesson_plan_m->create($form_data);

            if ($ok)
            {
                $details = implode(' , ', $this->input->post());
                $user = $this->ion_auth->get_user();
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

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('trs/lesson_plan/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->valid_lesson_plan() as $field)
            {
                $get->$field['field'] = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('New Lesson Plan ')->build('trs/lesson_plan/create', $data);
        }
    }

    function view_plan($id = FALSE, $page = 0)
    {
        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/lesson_plan/');
        }
        if (!$this->lesson_plan_m->exists_trs_plan($id,$this->profile->id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/lesson_plan');
        }
        //search the item to show in edit form
        $get = $this->lesson_plan_m->find($id);

        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('View Lesson Plan ')->build('trs/lesson_plan/view', $data);
    }

    function edit_plan($id = FALSE, $page = 0)
    {
        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/lesson_plan/');
        }
		
        if (!$this->lesson_plan_m->exists_trs_plan($id,$this->profile->id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/lesson_plan');
        }
        //search the item to show in edit form
        $get = $this->lesson_plan_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete = array();
        //Rules for validation
        $this->form_validation->set_rules($this->valid_lesson_plan());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {
            $user = $this->ion_auth->get_user();
            // build array for the model
            $form_data = array(
                'class' => $this->input->post('class'),
                'term' => $this->input->post('term'),
                'year' => $this->input->post('year'),
                'week' => $this->input->post('week'),
                'day' => $this->input->post('day'),
                'subject' => $this->input->post('subject'),
                'lesson' => $this->input->post('lesson'),
                'activity' => $this->input->post('activity'),
                'objective' => $this->input->post('objective'),
                'materials' => $this->input->post('materials'),
                'assignment' => $this->input->post('assignment'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->lesson_plan_m->update_attributes($id, $form_data);

            if ($done)
            {
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

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("trs/lesson_plan/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("trs/lesson_plan/");
            }
        }
        else
        {
            foreach (array_keys($this->valid_lesson_plan()) as $field)
            {
                if (isset($_POST[$field]))
                {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Lesson Plan ')->build('trs/lesson_plan/create', $data);
    }

    function delete_plan($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/lesson_plan');
        }

        //search the item to delete
        if (!$this->lesson_plan_m->exists_trs_plan($id,$this->profile->id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/lesson_plan');
        }

        //delete the item
        if ($this->lesson_plan_m->delete($id) == TRUE)
        {
            $details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $id,
                'transaction_type' => $this->router->fetch_method(),
                'description' => 'Record Deleted',
                'details' => $details,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/lesson_plan/");
    }

    private function valid_lesson_plan()
    {
        $config = array(
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'class',
                'label' => 'Class',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'week',
                'label' => 'Week',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'day',
                'label' => 'Day',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'subject',
                'label' => 'Subject',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'lesson',
                'label' => 'Lesson',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[500]'),
            array(
                'field' => 'activity',
                'label' => 'Activity',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
            array(
                'field' => 'objective',
                'label' => 'Objective',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
            array(
                'field' => 'materials',
                'label' => 'Materials',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
            array(
                'field' => 'assignment',
                'label' => 'Assignment',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_lesson_plan()
    {
        $config = array();
        $config['base_url'] = site_url() . 'trs/lesson_plan/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 100000000;
        $config['total_rows'] = $this->lesson_plan_m->count();
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
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }

    /**
     * View Message conversation
     * 
     * @param int $id
     */
    public function view_message($id)
    {
        $this->form_validation->set_rules($this->_rep_validation());
        $message = $this->messages_m->get_message($id);
        //set seen
        if ($this->input->get('st'))
        {
            $last = $this->messages_m->get_last($id);
            $this->messages_m->update_link($last->id, array('seen' => 1, 'modified_on' => time()));
        }

        $valid = $this->messages_m->list_mine(array($this->user->id));
        //limit access to my messages when manipulating the id in url
        if (!in_array($id, $valid))
        {
            redirect('trs/messages');
        }
        if ($this->form_validation->run())
        {
            $rep = $this->input->post('message');
            $user = $this->ion_auth->get_user();
            $last = $this->messages_m->get_last($id);
            $form = array(
                'sender' => $user->id,
                'convo_id' => $id,
                'recipient' => $last->created_by == $this->ion_auth->get_user()->id ? $last->recipient : $last->created_by,
                'message' => $rep,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->messages_m->create_convo($form);
            redirect('trs/view_message/' . $id);
        }
        $data['message'] = $message;
        $this->template
                          ->title('View Message')
                          ->build('trs/messages/view', $data);
    }

    /**
     * new_message
     * 
     */
    function new_message()
    {
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $user = $this->ion_auth->get_user();

            $recps = $this->input->post('to');
            foreach ($recps as $r)
            {
                $form_data = array(
                    'title' => $this->input->post('title'),
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $msid = $this->messages_m->create($form_data);

                if ($msid)
                {
                    $form = array(
                        'convo_id' => $msid,
                        'sender' => $user->id,
                        'recipient' => $r,
                        'seen' => 0,
                        'message' => $this->input->post('message'),
                        'created_by' => $user->id,
                        'created_on' => time()
                    );

                    $this->messages_m->create_convo($form);
                }
            }
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            redirect('trs/messages');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }
            $data['result'] = $get;
            $data['parents'] = $this->trs_m->list_class_parents();

            //load the view and the layout
            $this->template->title('New Message')->build('trs/messages/create', $data);
        }
    }

    private function _rep_validation()
    {
        $config = array(
            array(
                'field' => 'message',
                'label' => 'Message',
                'rules' => 'required|trim'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'message',
                'label' => 'Message',
                'rules' => 'required|max_length[10000]'),
            array(
                'field' => 'title',
                'label' => 'Message Title',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'to',
                'label' => 'Recipient',
                'rules' => 'required')
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    /**
     * My students Page
     */
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
        $this->template->title('My Students')->build('trs/students', $data);
    }

    /**
     * list_students DATA
     */
    public function list_students($class = NULL)
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        if (!empty($class))
        {
            $output = $this->trs_m->get_per_class($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho, $class);
        }
        elseif ($this->session->userdata('extras'))
        {
            $output = $this->trs_m->get_extras_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        }
        else
        {
            $output = $this->admission_m->get_my_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        }

        echo json_encode($output);
    }

    /**
     * View Admission Record
     * 
     * @param int $id record ID
     * @param int $page - the pagination offset
     */
    function view_student($id = 0)
    {
        if (!$this->admission_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/students');
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

        $this->template->title('View Student')->build('trs/view', $data);
    }

    /**
     * View Assignment
     * 
     * @param int $id
     * @param int $class
     */
    function view_assign($id, $class)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/assignments');
        }
        if (!$this->assignments_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/assignments');
        }

        $data['p'] = $this->assignments_m->find($id);
        $data['done'] = $this->assignments_m->done($id);
        $data['class'] = $class;
        $data['extras'] = 0;
        if ($this->input->get())
        {
            $data['extras'] = 1;
        }

        $this->template->title('View Assignment')->build('trs/assign/view', $data);
    }
	
	 function list_subjects()
        {
			    $this->load->model('evideos/evideos_m');

                $id = $this->input->get('id');
				
				$sys = $this->ion_auth->populate('class_groups','id','education_system');
				
               //** Check if education system to list subjects/learning areas
			   
                if($sys[$id] ==1){
					
					 $subjects = $this->evideos_m->get_sub844($id);
					 $subs = $this->ion_auth->populate('subjects','id','name');
					 
				}elseif($sys[$id] ==2){
					 $subjects = $this->evideos_m->get_cbc_subjects($id);
					 $subs = $this->ion_auth->populate('cbc_subjects','id','name');
				}

                $jso = '[';
                $coma = ',';
                $all = count($subjects);
                $i = 0;
                $jso .= '{"optionValue":"","optionDisplay":"Select Option"}' . $coma;
                foreach ($subjects as $p)
                {
                        $i++;
                        if ($i == $all)
                                $coma = '';
                        $jso .= '{"optionValue":"' . $p->subject_id . '","optionDisplay":"' . $subs[$p->subject_id] . '"}' . $coma;
                }
				
				

                $jso .= ']';

                echo $jso;
        }

	/**
     * View Assignment
     * 
     * @param int $id
     * @param int $class
     */
    function mark_assign($id, $stud,$class,$sess=NULL)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/assignments');
        }
        if (!$this->assignments_m->done_exists($id,$stud))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/assignments');
        }

        $data['p'] = $this->assignments_m->find_done($id);
        
        $data['class'] = $class;
        $data['stud'] = $stud;
      

        $this->template->title('View Assignment')->build('trs/assign/view_done', $data);
    }
	
	
		   //Details view function
      function set_as_marked($id,$stud, $class, $sess=NULL)
        {
                //redirect if no $id
            if (!$id && !$stud && !$class)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('trs/assignments');
                }
				
			 if (!$this->assignments_m->done_exists($id,$stud))
				{
					$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
					redirect('trs/assignments');
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
				
				redirect('trs/mark_assign/'.$id.'/'.$stud.'/'.$class.'/'.$this->session->userdata['session_id']);

		}
	
	

    /**
     * My Account
     */
    public function account()
    {
        $this->load->model('record_salaries/record_salaries_m');
        $data['students'] = $this->admission_m->count_my_students();
        $data['slips'] = $this->record_salaries_m->get_my_slip();
        $this->template->title('My Account')->build('trs/profile', $data);
    }

    function slip($id)
    {
        $this->load->model('record_salaries/record_salaries_m');
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        //page number  variable
        $data['page'] = $page;
        $data['post'] = $this->record_salaries_m->find($id);
        $data['tax'] = $this->record_salaries_m->get_tax();
        $data['ranges'] = $this->record_salaries_m->get_paye_ranges();
        $data['paye'] = $this->record_salaries_m->populate('paye', 'id', 'tax');

        $this->template->title(' Pay Slip')->build('trs/slip', $data);
    }

    /**
     * Record Exam Marks
     */
    public function record()
    {
        $config = $this->_exam_paginate_options();
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['exams'] = $this->exams_m->paginate_all($config['per_page'], $page);
        $data['thread']= (object) $this->exams_m->get_exams();
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
        

        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        $data['classes'] = $this->trs_m->list_my_classes();

        $this->template->title('Marks')->build('trs/exam/record', $data);
    }

    public function view()
    {
        $config = $this->_exam_paginate_options();
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['exams'] = $this->exams_m->paginate_all($config['per_page'], $page);
        $data['threads'] = (object) $this->exams_m->get_exams();

        if ($this->input->post()) {


            $data['exams'] = $this->exams_m->paginate_all($config['per_page'], $page);
            $data['threads'] = (object) $this->exams_m->get_exams();
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

        $this->template->title('Marks')->build('trs/exam/view', $data);
    }

    public function addmarks()
    {
        $config = $this->_exam_paginate_options();
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['exams'] = $this->exams_m->paginate_all($config['per_page'], $page);
        $data['thread'] = (object) $this->exams_m->get_exams();
        //create pagination links
        $data['links'] = $this->pagination->create_links();
        $data['grading'] = $this->exams_m->get_grading_system();
        
       

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
            // echo"<pre>";
            // print_r($outof);
            // echo "<pre>";
            // die;

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

        $this->template->title('Marks')->build('trs/exam/addmarks', $data);
    }

    public function submit_marks() {


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

           
            foreach ($marks_new as $student_id => $mark_new) {
                $this->db->set('marks', $mark_new);
                $this->db->where('student', $student_id);
                $this->db->where('subject', $subject);
                $this->db->update('igcse_marks_list');
            }

            $update_success = false;
           
            foreach ($marks_new as $student_id => $mark_new) {
                $formdata = array(
                    'marks' => $mark_new,
                    'out_of' => $outof,
                    'modified_by' => $user->id,
                    'modified_on' => time(), 
                );

                $update_success = $this->db->set($formdata)
                    ->where('student', $student_id)
                    ->where('subject', $subject)
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
            } 
            else {
                $this->session->set_flashdata('insertion_success', 'Insertion successful!');
            }

            redirect('trs/record');

           
        }
    }

    public function fetch_exams($threadId)
    {
        $exams = $this->exams_m->get_exams_by_thread($threadId);
       
        echo json_encode($exams);
       
    }
    public function fetch_data($selectedClassId)
    {
        $teacher = $this->user->id;
        $cls_tr = $this->igcse_m->class_teacher($selectedClassId);
        $trs = $this->igcse_m->get_teacher($teacher);

        if ($cls_tr->class_teacher == $teacher) {
            $class = $this->igcse_m->fetch_subjects_by_classteacher($selectedClassId);
        } else {
            $class = $this->igcse_m->fetch_subjects_by_class($selectedClassId, $trs->id);
        }
                     
              
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

        // Return the options as JSON
        echo json_encode($data);
    }


        

    function record_marks()
    {
        $this->template->title('Record marks')->build('trs/exam/record_marks');
    }

    function addcomment($class){

        $data['threads'] = (object) $this->exams_m->get_exams();

        
        if ($this->input->post()) {
            $thread = $this->input->post('thread');
            $data['marks'] = $this->igcse_m->gettotal($class, $thread);
            $data['thread'] = $thread;
            $data['class'] = $class;

        
        }
       

        $this->template->title('Add comment')->build('trs/exam/addcomment', $data);



    }

    function submit_comment($thread, $class){

               
        
        if ($this->input->post()) {

           
            // if (condition) {
            //     # code...
            // } else {
            //     # code...
            // }
            

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
            } elseif($insert_success) {
                $this->session->set_flashdata('insertion_success', 'Insertion successful!');
            }

            redirect('trs/addcomment/'. $class);

            

        }
        
    }
    
    /**
     * Record Attendance
     */
    public function attendance()
    {
        $data['classes'] = $this->trs_m->list_my_classes();

        $this->template->title('Attendance')->build('trs/att/attendance', $data);
    }

    /**
     * Add new Attendance
     * 
     * @param int $class
     */
    function register($class = 0)
    {
        if (!$class)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/attendance');
        }
        //create control variables
        $data['updType'] = 'create';
        //Rules for validation
        $this->form_validation->set_rules($this->_att_validation());
        //validate the fields of form
        if ($this->form_validation->run())
        {
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
            $temperature=  $this->input->post('temperature');
            foreach ($status as $st => $state)
            {
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

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }
            redirect('trs/attendance');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->_att_validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }
            $data['result'] = $get;
            $data['students'] = $this->class_attendance_m->get_students($class);

            $this->template->title('Add Class Attendance ')->build('trs/att/register', $data);
        }
    }

    public function list_register($id = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/attendance/');
        }

        $data['class_attendance'] = $this->class_attendance_m->get($id, 1);
        $data['class'] = $id;

        $this->template->title(' Class Attendance ')->build('trs/att/list', $data);
    }

    function view_register($id = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/attendance/');
        }
        if (!$this->class_attendance_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/attendance/');
        }
        //search the item to show in edit form
        $data['post'] = $this->class_attendance_m->get_register($id);
        $data['dat'] = $this->class_attendance_m->find($id);
        $data['present'] = $this->class_attendance_m->count_present($id);
        $data['absent'] = $this->class_attendance_m->count_absent($id);

        $this->template->title(' Class Register ')->build('trs/att/view', $data);
    }

    function edit_register($id = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/attendance/');
        }
        if (!$this->class_attendance_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/attendance/');
        }
        $post = $this->class_attendance_m->get_register($id);
        $dat = $this->class_attendance_m->find($id);
        //search the item to show in edit form

        if ($this->input->post())
        {
            $this->form_validation->set_rules($this->_att_validation());
            //validate the fields of form
            if ($this->form_validation->run())
            {
                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'attendance_date' => strtotime($this->input->post('attendance_date')),
                    'title' => $this->input->post('title'),
                    'modified_by' => $user->id,
                    'modified_on' => time()
                );

                $edit = $this->class_attendance_m->update_attributes($id, $form_data);
                if ($edit)
                {
                    $remarks = $this->input->post('remarks');
                    $status = $this->input->post('status');

                    foreach ($status as $st => $state)
                    {
                        $form = array(
                            'status' => $state,
                            'remarks' => $remarks[$st],
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );
                        $this->class_attendance_m->update_list($id, $st, $form);
                    }
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Updated Successfully'));
                    redirect('trs/view_register/' . $id);
                }
            }
        }
        $data['post'] = $post;
        $data['dat'] = $dat;
        $data['present'] = $this->class_attendance_m->count_present($id);
        $data['absent'] = $this->class_attendance_m->count_absent($id);
        $this->template->title('Edit Class Register ')->build('trs/att/edit', $data);
    }

    /**
     *  Exam Results
     * 
     * @param int $exam
     * @param int $class
     */
    public function results($exam, $class)
    {
        $flag = 1;
        $sort = 1;
        $list = $this->portal_m->list_students($class);

        $payload = array();
        $xm = $this->exams_m->find($exam);
        $rec = $this->exams_m->is_recorded($exam);
        $has = TRUE;
        if (!$xm || !$rec)
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
            $has = FALSE;
        }
        $this->load->model('reports/reports_m');
        foreach ($list as $key => $sid)
        {
            $obst = $this->worker->get_student($sid);
            $tar = $this->exams_m->get_stream($obst->class);
            $report = $this->exams_m->get_report_tr_portal($exam, $sid, $tar->class);
            $st = $this->worker->get_student($sid);
            $dcl = $this->reports_m->get_class_by_year($sid, $xm->year);
            $mcl = '';
            if (!empty($dcl))
            {
                $mcl = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
            }
            $report['cls'] = $mcl;
            $report['student'] = $st;
            $payload[] = $report;
        }

        $streams = $this->exams_m->populate('class_stream', 'id', 'name');
        $data['proc'] = $has;
        $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
        $data['subjects'] = $this->exams_m->get_subjects($class, $xm->term, 1);
        $data['exam'] = $xm;
        $data['full'] = $this->exams_m->list_subjects_alt(1);
        $data['streams'] = $streams;
        foreach ($payload as $kk => $p)
        {
            if (!isset($p['marks']))
            {
                unset($payload[$kk]);
            }
        }

        $data['payload'] = ($sort == 1) ? sort_by_field($payload, 'total', 3) : sort_by_field($payload, 'mean', 3);
        
        $data['flag'] = $flag;
        $data['classes'] = $this->classlist;
        $range = range(date('Y') - 1, date('Y') + 1);
        $data['yrs'] = array_combine($range, $range);
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');

        $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');
        $data['subject_title'] = $this->exams_m->populate('subjects', 'id', 'short_name');
        $data['years_exams'] = $this->exams_m->years_exams();
        $data['exams_name'] = $this->exams_m->exam_details('exams', 'id', 'title');
        $data['exams_type_id'] = $this->exams_m->populate('exams_management', 'id', 'exam_type');

        $this->template->title('Exam Results')->build('trs/exam/results', $data);
    }

    /**
     * Assignments
     */
    public function assignments()
    {
        $term = get_term(date('m'));
        $year = date('Y');
        $data['extras'] = $this->trs_m->get_current($term, $year);
        $data['classes'] = $this->trs_m->list_my_classes();

        $this->template->title('Assignments')->build('trs/assignments', $data);
    }

    /**
     * Assignments
     */
    public function list_assign($id)
    {
        $data['assignments'] = $this->trs_m->get_assignments($id);
        $data['classes'] = $this->trs_m->list_my_classes();
        $data['ref'] = $id;
        $data['extras'] = false;

        $this->template->title('Assignments')->build('trs/assign/list', $data);
    }

    /**
     * Extras Assignments
     */
    public function list_extras($id)
    {
        $data['assignments'] = $this->trs_m->get_extras_assignments($id);
        $data['classes'] = $this->trs_m->list_my_classes();
        $data['ref'] = $id;
        $data['extras'] = true;

        $this->template->title('Assignments')->build('trs/assign/list', $data);
    }

    /**
     * Add Assignment
     * 
     * @param int $class
     */
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
            redirect('trs/list_assign/' . $class);
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
        $this->template->title('Assignments')->build('trs/assign/create', $data);
		
    }

    /**
     * Assignment for Extra curricular Activities
     * 
     * @param int $activity
     */
    public function assign_extra($activity)
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
                $term = get_term(date('m'));
                $year = date('Y');
                $values = array(
                    'assgn_id' => $ok,
                    'activity' => $activity,
                    'term' => $term,
                    'year' => $year,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->assignments_m->insert_extras($values);
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('trs/list_extras/' . $activity);
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
        $this->template->title('Assignments')->build('trs/assign/create', $data);
    }

    /**
     * edit assignment
     * 
     * @param int $id
     * @param int $ref
     */
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
            redirect('trs/' . $action . '/' . $ref);
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
        $this->template->title('Assignments')->build('trs/assign/create', $data);
    }

    /**
     * Record Class Teacher's Remarks
     * 
     * @param int $exam_id Exam ID
     * @param int $id Class
     */
    function remarks($exam_id, $id)
    {
        $tar = $this->exams_m->get_stream($id);
        $class = $tar->class;
        $stream = $tar->stream;
        $data['students'] = $this->exams_m->get_students($class, $stream);

        $data['class'] = $id;
        $data['exm'] = $exam_id;

        $this->template->title('Record Performance')->build('trs/remarks', $data);
    }

    /**
     * Record Remarks
     * 
     * @param int $exam
     * @param int $id Class ID
     * @param int $student
     */
    function report($exam, $id, $student)
    {
        $tar = $this->exams_m->get_stream($id);
        $this->load->model('reports/reports_m');
        $class = $tar->class;
        $stream = $tar->stream;
        $exm = $this->exams_m->find($exam);

        $data['students'] = $this->exams_m->get_students($class, $stream);
        $data['subjects'] = $this->exams_m->get_subjects($id, $exm->term);

        $dcl = $this->reports_m->get_class_by_year($student, $exm->year);

        $data['cls'] = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
        $data['list_subjects'] = $this->exams_m->list_subjects();
        $data['subtests'] = $this->exams_m->fetch_sub_tests();
        $data['count_subjects'] = $this->exams_m->count_subjects($class, $exm->term);
        $data['full_subjects'] = $this->exams_m->get_full_subjects();
        //create control variables
        $data['updType'] = 'create';
        $data['exams'] = $this->exams_m->list_exams();
        $data['remarks'] = $this->exams_m->fetch_by_exam($exam, $student);
        $data['full'] = $this->exams_m->fetch_gen_remarks($exam, $student);

        $data['student'] = $student;
        $data['class'] = $class;
        $data['id'] = $id;
        $data['row'] = $exm;
        $data['exam'] = $exam;

        $this->template->title('Record Performance')->build('trs/lower', $data);
    }

    /**
     * Record Exam Marks
     * 
     * @param int $exid Exam ID
     * @param int $id Class
     */
    function bulk_edit($exid = 0, $id = 0)
    {
        if (!$exid || !$id)
        {
            redirect('admin/examss');
        }

        $students = array();
        $rest = array();
        $sb = 0;
        $class_name = $this->exams_m->populate('class_groups', 'id', 'name');
        $tar = $this->exams_m->get_stream($id);
        $exam = $this->exams_m->find($exid);
        $xm = $this->exams_m->fetch_rec($exid, $id);

        $class_id = $tar->class;
        $stream = $tar->stream;
        $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . '</span>';
        $subjects = $this->exams_m->get_subjects($id, $exam->term);

        $gdd = 0;
        $sel = 0;
        if ($this->input->get('sb'))
        {
            $sb = $this->input->get('sb');
            $data['selected'] = isset($subjects[$sb]) ? $subjects[$sb] : array();
            $row_gd = $this->exams_m->fetch_grading($exid, $id, $sb);

            if (!empty($row_gd))
            {
                $gdd = $row_gd->grading;
            }
            $row = $this->exams_m->fetch_subject($sb);
            $rrname = $row ? ' - ' . $row->name : '';
            $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . $rrname . '</span>';
            if ($row->is_optional == 2)
            {
                $sel = 1;
            }

            $students = $this->exams_m->get_students($class_id, $stream);

            $list = $this->exams_m->fetch_list($exid, $id);
            if ($list)
            {
                //   redirect('admin/examss');
                $pps = $this->exams_m->fetch_student_list($list->id);

                foreach ($pps as $mk)
                {
                    $marks = $this->exams_m->fetch_done_list($sb, $mk->id);
                    $rest[$mk->student]['marks'] = $marks;
                    $rest[$mk->student]['total'] = $mk->total;
                    $rest[$mk->student]['remarks'] = $mk->remarks;
                }
            }
        }
        $data['sel_gd'] = $gdd;
        $data['list_subjects'] = $this->exams_m->list_subjects();
        $data['subjects'] = $subjects;
        $data['count_subjects'] = $this->exams_m->count_subjects($class_id, $exam->term);
        $data['full_subjects'] = $this->exams_m->get_full_subjects();
        $data['grading'] = $this->exams_m->get_grading_system();
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = '';
        $data['exams'] = $this->exams_m->list_exams();
        //Rules for validation
        $this->form_validation->set_rules($this->_rec_validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            if ($this->input->get('sb'))
            {
                $marks = $this->input->post('marks');
                $gd_id = $this->input->post('grading');
                $units = $this->input->post('units');
                $mkpost = $this->input->post();

                $inc = array();
                if (isset($mkpost['done']))
                {
                    $inc = $mkpost['done'];
                }
                if ($this->exams_m->rec_exists($exid, $id))
                {
                    $sbj = $this->input->get('sb');

                    $user = $this->ion_auth->get_user();
                    $this->exams_m->set_grading($exid, $id, $sbj, $gd_id, $user->id); //update grading system
                    $perf_list = array();
                    $sub_marks = array();

                    if ($units)
                    {
                        foreach ($units as $stid => $unmarks)
                        {
                            foreach ($unmarks as $uid => $mk)
                            {
                                $sunits[] = array(
                                    'parent' => $sbj,
                                    'unit' => $uid,
                                    'marks' => $mk
                                );
                            }
                        }
                    }

                    foreach ($marks as $std => $score)
                    {
                        $sunits = array();
                        $sub_marks = array(
                            'subject' => $sb,
                            'marks' => $score
                        );
                        if ($units && isset($units[$std]))
                        {
                            $mine = $units[$std];
                            foreach ($mine as $uid => $mk)
                            {
                                $sunits[] = array(
                                    'parent' => $sbj,
                                    'unit' => $uid,
                                    'marks' => $mk
                                );
                            }
                        }
                        $perf_list[] = array(
                            'exams_id' => $xm->id,
                            'student' => $std,
                            'marks' => $sub_marks,
                            'units' => $sunits,
                                          // 'remarks' => isset($remarks[$std]) ? $remarks[$std] : ''
                        );
                    }

                    foreach ($perf_list as $dat)
                    {
                        $dat = (object) $dat;
                        $list_id = $this->exams_m->get_update_target($dat->student, $dat->exams_id);
                        $mm = (object) $dat->marks;
                        $mkcon = $mm->marks ? $mm->marks : 0;

                        $mod = array(
                            'inc' => isset($inc[$dat->student]) ? 1 : 0,
                            'marks' => $mkcon,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        if ($this->exams_m->has_rec($list_id, $mm->subject))
                        {
                            $this->exams_m->update_marks($list_id, $mm->subject, $mod);

                            if (isset($dat->units) && count($dat->units))
                            {
                                foreach ($dat->units as $sm)
                                {
                                    $sm = (object) $sm;
                                    $svalues = array(
                                        'marks' => $sm->marks,
                                        'modified_by' => $user->id,
                                        'modified_on' => time()
                                    );
                                    $this->exams_m->update_sub_marks($list_id, $sm->parent, $sm->unit, $svalues);
                                }
                            }
                        }
                        else
                        {
                            $mklist = $this->_prep_marks($sb, $xm->id, $marks, $units);

                            foreach ($mklist as $dat)
                            {
                                $dat = (object) $dat;
                                $values = array(
                                    'exams_id' => $dat->exams_id,
                                    'student' => $dat->student,
                                    // 'total' => $dat->total,
                                    // 'remarks' => $dat->remarks,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                                $list_id = $this->exams_m->create_list($values);

                                $mm = (object) $dat->marks;
                                $fvalues = array(
                                    'exams_list_id' => $list_id,
                                    'marks' => $mm->marks ? $mm->marks : 0,
                                    'subject' => $mm->subject,
                                    'inc' => isset($inc[$dat->student]) ? 1 : 0,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                                $this->exams_m->insert_marks($fvalues);

                                if (isset($dat->units) && count($dat->units))
                                {
                                    foreach ($dat->units as $sm)
                                    {
                                        $sm = (object) $sm;
                                        $svalues = array(
                                            'marks_list_id' => $list_id,
                                            'parent' => $sm->parent,
                                            'unit' => $sm->unit,
                                            'marks' => $sm->marks,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $this->exams_m->insert_subs($svalues);
                                    }
                                }
                            }
                        }
                    }

                    if (TRUE)
                    {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Update Successful'));
                    }
                    else
                    {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Update Failed'));
                    }
                }
                else
                {
                    //not exists 
                    $sb = $this->input->get('sb');
                    $user = $this->ion_auth->get_user();
                    $form_data = array(
                        'exam_type' => $exid,
                        'class_id' => $id,
                        'created_by' => $user->id,
                        'created_on' => time()
                    );
                    $ok = $this->exams_m->create_ex($form_data);
                    $this->exams_m->set_grading($exid, $id, $sb, $gd_id, $user->id);
                    $perf_list = $this->_prep_marks($sb, $ok, $marks, $units);

                    foreach ($perf_list as $dat)
                    {
                        $dat = (object) $dat;
                        $values = array(
                            'exams_id' => $dat->exams_id,
                            'student' => $dat->student,
                            // 'total' => $dat->total,
                            // 'remarks' => $dat->remarks,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $list_id = $this->exams_m->create_list($values);

                        $mm = (object) $dat->marks;
                        $mkcon = $mm->marks ? $mm->marks : 0;

                        $fvalues = array(
                            'exams_list_id' => $list_id,
                            'marks' => $mkcon,
                            'subject' => $mm->subject,
                            'inc' => isset($inc[$dat->student]) ? 1 : 0,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $this->exams_m->insert_marks($fvalues);

                        if (isset($dat->units) && count($dat->units))
                        {
                            foreach ($dat->units as $sm)
                            {
                                $sm = (object) $sm;
                                $svalues = array(
                                    'marks_list_id' => $list_id,
                                    'parent' => $sm->parent,
                                    'unit' => $sm->unit,
                                    'marks' => $sm->marks,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );
                                $this->exams_m->insert_subs($svalues);
                            }
                        }
                    }

                    if ($ok)
                    {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                    }
                    else
                    {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                    }
                }
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Subject Not Specified'));
            }
            redirect('trs/record/');
        }
        else
        {
            $data['assign'] = $sel;
            $data['class_name'] = $heading;
            $data['result'] = $rest;
            $data['students'] = $students;
            $data['sb'] = $sb;

            $this->template->title('Exam Marks')->build('trs/exam/rec', $data);
        }
    }

    function _prep_marks($subject, $exm_mgmt_id, $marks = array(), $units = array())
    {
        $perf_list = array();
        $sub_marks = array();
        $user = $this->ion_auth->get_user();
        if ($units && !empty($units))
        {
            foreach ($units as $stid => $unmarks)
            {
                foreach ($unmarks as $uid => $mk)
                {
                    $sunits[] = array(
                        'parent' => $subject,
                        'unit' => $uid,
                        'marks' => $mk
                    );
                }
            }
        }

        foreach ($marks as $std => $score)
        {
            $sunits = array();
            $sub_marks = array(
                'subject' => $subject,
                'marks' => $score
            );
            if ($units && isset($units[$std]))
            {
                $mine = $units[$std];
                foreach ($mine as $uid => $mk)
                {
                    $sunits[] = array(
                        'parent' => $subject,
                        'unit' => $uid,
                        'marks' => $mk
                    );
                }
            }
            $perf_list[] = array(
                'exams_id' => $exm_mgmt_id,
                'student' => $std,
                'marks' => $sub_marks,
                'units' => $sunits,
                'created_by' => $user->id,
                'created_on' => time()
            );
        }
        return $perf_list;
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
            redirect('trs/login', 'refresh');
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
                              ->build('trs/change_password', $this->data);
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
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('trs/change_password', 'refresh');
            }
        }
    }

    /**
     * forgot password
     */
    function forgot_password()
    {
        //get the identity type from config and send it when you load the view
        $identity = $this->config->item('identity', 'ion_auth');
        $identity_human = ucwords(str_replace('_', ' ', $identity)); //if someone uses underscores to connect words in the column names
        $this->form_validation->set_rules($identity, $identity_human, 'required|valid_email');
        if ($this->form_validation->run() == false)
        {
            //setup the input
            $this->data[$identity] = array('name' => $identity,
                'id' => $identity, //changed
            );
            //set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['identity'] = $identity;
            $this->data['identity_human'] = $identity_human;
            $this->template
                              ->set_layout('login')
                              ->title('Admin', 'Forgot Password')
                              ->build('admin/forgot_password', $this->data);
        }
        else
        {
            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));
            if ($forgotten)
            { //if there were no errors
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                redirect('admin/login', 'refresh'); //we should display a confirmation page here instead of the login page
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('admin/forgot_password', 'refresh');
            }
        }
    }

    /**
     * reset password - final step for forgotten password
     * @param string $code
     */
    public function reset_password($code)
    {
        $reset = $this->ion_auth->forgotten_password_complete($code);
        if ($reset)
        {  //if the reset worked then send them to the login page
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
            redirect('admin/login', 'refresh');
        }
        else
        { //if the reset didnt work then send them back to the forgot password page
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
            redirect('admin/forgot_password', 'refresh');
        }
    }
    /**
     * Catch 404s
     * 
     */
    function error()
    {
        if (!$this->ion_auth->logged_in())
        {
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

    private function _att_validation()
    {
        $config = array(
            array(
                'field' => 'attendance_date',
                'label' => 'Attendance Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'xss_clean'),
            array(
                'field' => 'student',
                'label' => 'Student',
                'rules' => 'xss_clean'),
            array(
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'xss_clean'),
            array(
                'field' => 'remarks',
                'label' => 'Remarks',
                'rules' => 'xss_clean'),
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
        $config['total_rows'] = $this->exams_m->count();
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
                'rules' => 'xss_clean'),
            array(
                'field' => 'exam_type',
                'label' => 'The Exam',
                'rules' => 'trim|xss_clean'),
            array(
                'field' => 'subject[]',
                'label' => 'Subject',
                'rules' => 'xss_clean'),
            array(
                'field' => 'student[]',
                'label' => 'student',
                'rules' => 'xss_clean'),
            array(
                'field' => 'total[]',
                'label' => 'Total',
                'rules' => 'xss_clean'),
            array(
                'field' => 'marks[]',
                'label' => 'Marks',
                'rules' => 'xss_clean'),
            array(
                'field' => 'grading',
                'label' => 'Grading',
                'rules' => 'required'),
            array(
                'field' => 'remarks[]',
                'label' => 'Remarks',
                'rules' => 'xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

  function newsletters(){
		  
        $data['newsletters'] = $this->portal_m->newsletters();
               $this->template->title('Newsletters')->build('trs/newsletter', $data);
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
          redirect('trs/students');
          
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
      $this->template->title('Favourites and Hobbies')->build('trs/hobbies_fav', $data);
   }

   public function appraisal(){
        $data['years']= $this->trs_m->appraisalyears();
        $data['rules']= $this->trs_m->checkappraisee_rate();
        $data['targets']= $this->trs_m->checkpast_date();
        $data['teacher']= $this->trs_m->getteacher();
        if( $this->input->post()){
             $this->form_validation->set_rules('target_id','Target','required');
             $this->form_validation->set_rules('teacher','teacher','required');
     
             if(!$this->form_validation->run()){
                 //load view
                 $this->template->title('Add Book List ' )->build('admin/appraise', $data); 
             }else{
                 $teacher= $this->input->post('teacher');
                 $user_id= $this->ion_auth->get_user()->id;
     
                 $target_id=$this->input->post('target_id');
                 $rate=$this->input->post('rate');
                 foreach($target_id as $t_id){
                     foreach($rate as $r){
                         $data= array(
                             'target' =>$t_id,
                             'user_id'=>$user_id,
                             'teacher'=>$teacher,
                             'appraisee_rate'=>$r,
                             'created_on'=>time(),
                             'created_by'=>$this->ion_auth->get_user()->id
                         );
                     }

                    // if($this->trs_m->limitteacher($t_id,$teacher)){
                    //     $this->session->set_flashdata('message', array( 'type' => 'warning', 'text' => 'You have already appraised this target' ));
                    // }else{
                    $ok= $this->trs_m->insertresults($data);
                    // }
                 }
                 $this->template->title(' Teacher | Appraisal ' )->build('trs/appraisal/index',$data);
                 
                 if ( $ok)
                 {
                         $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                 }
                 else
                 {
                         $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                 }
     
                 redirect('trs/appraisal');
                 }
       
   }
   $this->template->title('Appraisal Reports')->build('trs/appraisal/index',$data);
}

   public function appraisalResult($year){
       $data['terms']=$this->trs_m->appraisalterms($year);
       $this->template->title('Appraisal Reports')->build('trs/appraisal/result',$data);
      
   }

   public function appraisalResults($year,$term){
    $data['results']=$this->trs_m->appraisalresults($year,$term);
    $this->template->title('Appraisal Reports')->build('trs/appraisal/appraisal_results',$data);
   }

   public function selfAppraisal($target){
     
       $data['targets']=$this->trs_m->get_target_by_id($target);
       $data['teacher']= $this->trs_m->getteacher();

       if( $this->input->post()){
         $rate= $this->input->post('rate');
         $teacher= $this->input->post('teacher');
            $data= array(
                'target' =>$target,
                'user_id'=>$this->ion_auth->get_user()->id,
                'teacher'=>$teacher,
                'appraisee_rate'=>$rate,
                'created_on'=>time(),
                'created_by'=>$this->ion_auth->get_user()->id
            );

              $ok= $this->trs_m->insertresults($data);
                   
                 $this->template->title(' Teacher | Appraisal ' )->build('trs/appraisal/index',$data);
                 
                 if ( $ok)
                 {
                         $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                 }
                 else
                 {
                         $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                 }
     
                 redirect('trs/appraisal');
         }
       $this->template->title('Teacher | Self Appraisal')->build('trs/appraisal/appraisal_form',$data);

   }

   public function subjectAssigned(){
    $data['subjects']= $this->trs_m->get_assigned_subjects();
    $this->template->title('Teacher | Subjects Assigned')->build('trs/subjects',$data);
   }
       
}
