<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Diary extends Trs_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
        {
            redirect('/login');
        }
        $this->load->model('diary_m');
    }
	
	/**
     * Add new Attendance
     * 
     * @param int $class
     */
    function per_level($class = 0, $session=NULL)
    {
		
        if (!$class)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/diary');
        }
        //create control variables
        $data['updType'] = 'create';
        //Rules for validation
        $this->form_validation->set_rules($this->_dia_validation());
        //validate the fields of form
        if ($this->form_validation->run())
        {
            
			
			$user = $this->ion_auth->get_user();
          
		     $fids = [];
            $filestr = $this->input->post('fids');
            if (!empty($filestr))
            {
                $filestr = rtrim($filestr, '|');
                $fids = explode('|', $filestr);
            }
			
            $teacher_comment = $this->input->post('teacher_comment');
			
			//print_r($teacher_comment);die;
            foreach ($teacher_comment as $st => $comm)
            {
				
				if(isset($comm) && !empty($comm)){
					
				
                   $form = [
						'student' => $st,
						'activity' => $this->input->post('activity'),
						'date_' => strtotime($this->input->post('date_')),
						'status' => 1,
						'verified' => 1,
						'teacher_comment' => $comm,
						'created_by' => $this->user->id,
						'created_on' => time()
					];

					$id = $this->diary_m->create($form);
					
					foreach ($fids as $fid)
						{
							$upform = [
								'diary_id' => $id,
								'modified_by' => $this->user->id,
								'modified_on' => time()
							];

							$this->diary_m->update_files($fid, $upform);
						}
				}
            }

            if ($id)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }
            redirect('trs/diary');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->_dia_validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }
            $data['result'] = $get;
            $data['students'] = $this->diary_m->get_students($class);

            $this->template->title('Diary Per Class ')->build('trs/per_class', $data);
        }
    }
	
	 private function _dia_validation()
    {
        $config = array(
            array(
                'field' => 'date_',
                'label' => 'date_ Date',
                'rules' => 'required|trim'),
            array(
                'field' => 'activity',
                'label' => 'activity',
                'rules' => 'xss_clean'),
            array(
                'field' => 'teacher_comment',
                'label' => 'teacher_comment',
                'rules' => 'xss_clean'),
           
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['diary'] = $this->diary_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
		 $data['classes'] = $this->trs_m->list_my_classes();

        //load view
        $this->template->title(' Diary ')->build('trs/list', $data);
    }

    public function extra()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['diary'] = $this->diary_m->paginate_extra($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Diary ')->build('trs/list_ex', $data);
    }

    function create($page = 0)
    {
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $fids = [];
            $filestr = $this->input->post('fids');
            if (!empty($filestr))
            {
                $filestr = rtrim($filestr, '|');
                $fids = explode('|', $filestr);
            }

            $form = [
                'student' => $this->input->post('student'),
                'activity' => $this->input->post('activity'),
                'date_' => strtotime($this->input->post('date_')),
                'status' => 1,
                'verified' => 1,
                'teacher_comment' => $this->input->post('teacher_comment'),
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $id = $this->diary_m->create($form);

            if ($id)
            {
                foreach ($fids as $fid)
                {
                    $upform = [
                        'diary_id' => $id,
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->diary_m->update_files($fid, $upform);
                }

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('trs/diary');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field'] } = set_value($field['field']);
            }
            $data['students'] = $this->trs_m->my_students();
            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Diary Entry')->build('trs/create', $data);
        }
    }

    function create_ex($page = 0)
    {
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $fids = [];
            $filestr = $this->input->post('fids');
            if (!empty($filestr))
            {
                $filestr = rtrim($filestr, '|');
                $fids = explode('|', $filestr);
            }

            $form = [
                'student' => $this->input->post('student'),
                'activity' => $this->input->post('activity'),
                'date_' => strtotime($this->input->post('date_')),
                'status' => 1,
                'verified' => 1,
                'teacher_comment' => $this->input->post('teacher_comment'),
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $id = $this->diary_m->create_ex($form);

            if ($id)
            {
                foreach ($fids as $fid)
                {
                    $upform = [
                        'diary_id' => $id,
                        'modified_by' => $this->user->id,
                        'modified_on' => time()
                    ];

                    $this->diary_m->update_files($fid, $upform);
                }

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('trs/diary/extra');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }
            $data['students'] = $this->trs_m->my_students();
            $data['activities'] = $this->diary_m->populate('activities', 'id', 'name');
            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Diary Entry')->build('trs/create_ex', $data);
        }
    }

    function upload($cat)
    {
        if (!$this->ion_auth->logged_in())
        {
            echo 'login';
            return FALSE;
        }
        $this->load->library('upload');
        $upload_path = FCPATH . 'uploads/diary/';

        if (!file_exists($upload_path))
        {
            mkdir($upload_path, DIR_WRITE_MODE, true);
        }

        if (!is_dir($upload_path))
        {
            mkdir($upload_path);
        }
        if (!is_dir($upload_path . date('Y') . '/'))
        {
            mkdir($upload_path . date('Y') . '/');
        }
        if (!is_dir($upload_path . date('Y') . '/' . date('M')))
        {
            mkdir($upload_path . date('Y') . '/' . date('M') . '/');
        }

        $this->upload_config = [
            'upload_path' => $upload_path . date('Y') . '/' . date('M') . '/',
            'allowed_types' => 'jpg|png|jpeg|gif',
            'max_size' => 20048,
            'remove_space' => TRUE,
            'encrypt_name' => TRUE,
        ];

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload('file'))
        {
            $upload_error = $this->upload->display_errors();
            echo json_encode($upload_error);
        }
        else
        {
            $file_info = $this->upload->data();
            $file_info['path'] = date('Y') . '/' . date('M') . '/';

            $user = $this->ion_auth->get_user();
            $form = [
                'filename' => $file_info['file_name'],
                'file_size' => $this->_file_sizer($file_info['file_size']),
                'path' => $file_info['path'],
                'status' => 1,
                'cat' => $cat,
                'created_on' => time(),
                'created_by' => $user->id
            ];

            $id = $this->diary_m->create_file($form);
            if ($id)
            {
                $file_info['fid'] = $id;
            }

            echo json_encode($file_info);
        }
    }

    function edit($id = FALSE)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/diary');
        }
        if (!$this->diary_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/diary');
        }
        //search the item to show in edit form
        $get = $this->diary_m->find($id);

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';

        if ($this->form_validation->run()) //validation has been passed
        {
            $user = $this->ion_auth->get_user();
            // build array for the model
            $form = [
                'student' => $this->input->post('student'),
                'activity' => $this->input->post('activity'),
                'date_' => strtotime($this->input->post('date_')),
                'teacher_comment' => $this->input->post('teacher_comment'),
                'modified_by' => $user->id,
                'modified_on' => time()
            ];
            $done = $this->diary_m->update_attributes($id, $form);

            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("trs/diary/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Unexpected Error'));
                redirect("trs/diary");
            }
        }
        else
        {
            foreach (array_keys($this->validation()) as $field)
            {
                if (isset($_POST[$field]))
                {
                    $get->{$field} = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        $data['students'] = $this->trs_m->my_students();
        //load the view and the layout
        $this->template->title('Edit Diary ')->build('trs/create', $data);
    }

    function edit_ex($id = FALSE)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/diary/extra');
        }
        if (!$this->diary_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('trs/diary/extra');
        }
        //search the item to show in edit form
        $get = $this->diary_m->find_ex($id);

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';

        if ($this->form_validation->run()) //validation has been passed
        {
            $form = [
                'student' => $this->input->post('student'),
                'activity' => $this->input->post('activity'),
                'date_' => strtotime($this->input->post('date_')),
                'teacher_comment' => $this->input->post('teacher_comment'),
                'modified_by' => $this->user->id,
                'modified_on' => time()
            ];
            $done = $this->diary_m->update_ex($id, $form);

            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("trs/diary/extra");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Unexpected Error'));
                redirect("trs/diary/extra");
            }
        }
        else
        {
            foreach (array_keys($this->validation()) as $field)
            {
                if (isset($_POST[$field]))
                {
                    $get->{$field} = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        $data['students'] = $this->trs_m->my_students();
        $data['activities'] = $this->diary_m->populate('activities', 'id', 'name');
        //load the view and the layout
        $this->template->title('Edit Diary ')->build('trs/create_ex', $data);
    }

    function delete($id = NULL, $cat = 2)
    {
        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            $cat == 2 ? redirect('trs/diary/extra') : redirect('trs/diary');
        }

        //search the item to delete
        if (!$this->diary_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            $cat == 2 ? redirect('trs/diary/extra') : redirect('trs/diary');
        }
        $t = $cat == 2 ? 'diary_extra' : 'diary';
        //delete the item
        if ($this->diary_m->delete($id, $t) == TRUE)
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        $cat == 2 ? redirect('trs/diary/extra') : redirect('trs/diary');
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'student',
                'label' => 'Student',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'activity',
                'label' => 'Activity',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'date_',
                'label' => 'Date ',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'teacher_comment',
                'label' => 'Teacher Comment',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
            array(
                'field' => 'parent_comment',
                'label' => 'Parent Comment',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
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

}
