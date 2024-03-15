<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                /*$this->template->set_layout('default');
                $this->template->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('top', 'partials/top.php');*/
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
               /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                        redirect('admin');
                }*/

                //Restrict going to any other function before school settings(index) is complete
                if (!$this->settings_m->is_setup())
                {
                        if (!preg_match('/^(admin\/setup)$/i', $this->uri->uri_string()))
                        {
                                $this->session->set_flashdata('message', 'You Must Configure School Settings Before You Can Use the System');
                                redirect('admin/setup/');
                        }
                }
                $this->load->model('setup_m');
        }

        /**
         * Add New School Settings
         * 
         */
        function index()
        {
                //check For POST
                if ($this->input->post())
                {
                        $user = $this->ion_auth->get_user();
                        //Rules for validation
                        $this->form_validation->set_rules($this->skul_validation());
                        // build array for the model
                        $document = '';

                        if (!empty($_FILES['document']['name']))
                        {
                                $this->load->library('files_uploader');
                                $upload_data = $this->files_uploader->upload('document');
                                $document = $upload_data['file_name'];
                        }

                        $form_data = array(
                            'school' => $this->input->post('school'),
                            'postal_addr' => $this->input->post('postal_addr'),
                            'email' => $this->input->post('email'),
                            'tel' => $this->input->post('tel'),
                            'cell' => $this->input->post('cell'),
                            'document' => $document,
                            'motto' => $this->input->post('motto'),
                            'website' => $this->input->post('website'),
                            'fax' => $this->input->post('fax'),
                            'town' => $this->input->post('town'),
                            'school_code' => $this->input->post('school_code'),
                            'modified_by' => $user->id,
                            'modified_on' => time());
                }
                //check For Settings
                if (!$this->settings_m->is_setup())
                {
                        //Insert Settings
                        if ($this->form_validation->run())
                        {        //Validation OK!
                                $ok = $this->settings_m->create($form_data);

                                if ($ok) 
                                {
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                }
                                if (!$this->settings_m->laid_cables())
                                {
                                        $this->settings_m->commence($this->throttle);
                                }
                                //head to next step
                                redirect('admin/setup/teachers/');
                        }
                        else
                        {
                                $get = new StdClass();
                                foreach ($this->skul_validation() as $field)
                                {
                                        $get->{$field['field']} = set_value($field['field']);
                                }
                        }
                        $data['updType'] = 'create';
                }
                else
                {
                        //edit Settings
                        $get = $this->settings_m->fetch();
                        $document = $get->document;
                        $user = $this->ion_auth->get_user();

                        if (!empty($_FILES['document']['name']))
                        {
                                $this->load->library('files_uploader');
                                $upload_data = $this->files_uploader->upload('document');
                                $document = $upload_data['file_name'];
                        }

                        $form_data = array(
                            'school' => $this->input->post('school'),
                            'postal_addr' => $this->input->post('postal_addr'),
                            'email' => $this->input->post('email'),
                            'tel' => $this->input->post('tel'),
                            'cell' => $this->input->post('cell'),
                            'document' => $document,
                            'motto' => $this->input->post('motto'),
                            'website' => $this->input->post('website'),
                            'fax' => $this->input->post('fax'),
                            'town' => $this->input->post('town'),
                            'school_code' => $this->input->post('school_code'),
                            'modified_by' => $user->id,
                            'modified_on' => time());


                        if ($this->form_validation->run())  //validation has been passed
                        {
                                $done = $this->settings_m->update_settings($form_data);
                                // the information has   been successfully saved in the db
                                if ($done)
                                {
                                        //head bak to dashboard
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                        redirect("admin/setup/teachers/");
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                        redirect("admin/setup/");
                                }
                        }
                        else
                        {
                                foreach (array_keys($this->skul_validation()) as $field)
                                {
                                        if (isset($_POST[$field]))
                                        {
                                                $get->$field = $this->form_validation->$field;
                                        }
                                }
                        }
                        $data['updType'] = 'edit';
                }

                $data['result'] = $get;
                //load the view and the layout
                $this->template->title('School Settings')->set_layout('setup')->build('admin/sett', $data);
        }

        /**
         * And Teachers
         * 
         */
        public function teachers()
        {
                $this->load->model('teachers/teachers_m');

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['page'] = $page;

                $this->template->title(' Manage Teachers ')->set_layout('setup')->build('admin/wizz', $data);
        }

        function new_teacher($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $this->load->model('teachers/teachers_m');
                //Rules for validation
                $this->form_validation->set_rules($this->tvalidation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $t_username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
                        $temail = $this->input->post('email');
                        $tpassword = 'tv66uv'; //temporary password
                        $us_data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'phone' => $this->input->post('phone'),
                            'me' => $this->ion_auth->get_user()->id,
                        );
                        $tid = $this->ion_auth->register($t_username, $tpassword, $temail, $us_data);
                        //add to Teachers group
                        if ($tid)
                        {
                                $this->ion_auth->add_to_group(3, $tid);
                        }

                        $tt_data = array(
                            'user_id' => $tid,
                            'status' => $this->input->post('status'),
                            'designation' => $this->input->post('designation'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->teachers_m->create($tt_data);

                        if ($ok) 
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/setup/teachers/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->tvalidation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        //load the view and the layout
                        $this->template->title('Add Teachers ')->build('admin/new_teacher', $data);
                }
        }

        function edit_teacher($id = FALSE, $page = 0)
        {
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/teachers/');
                }
                $this->load->model('teachers/teachers_m');
                if (!$this->teachers_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/teachers');
                }
                //search the item to show in edit form
                $get = $this->teachers_m->find($id);
                //Rules for validation
                $this->form_validation->set_rules($this->tvalidation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'numba' => $this->input->post('numba'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->teachers_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/setup/teachers/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/setup/teachers/");
                        }
                }
                else
                {
                        foreach (array_keys($this->tvalidation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->$field = $this->form_validation->$field;
                                }
                        }
                }
                $data['result'] = $get;
                //load the view and the layout
                $this->template->title('Edit Teachers ')->build('admin/new_teacher', $data);
        }

        private function tvalidation()
        {
                $config = array(
                    array(
                        'field' => 'first_name',
                        'label' => 'First Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'last_name',
                        'label' => 'Last Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'phone',
                        'label' => 'Phone',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'designation',
                        'label' => 'Designation',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        function classes()
        {
                $this->load->model('class_groups/class_groups_m');

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $post = $this->class_groups_m->get_all_cg();

                if (!empty($post))
                {
                        foreach ($post as $p)
                        {
                                $p->streams = $this->class_groups_m->fetch_streams($p->id);
                                $count = $this->portal_m->fetch_students($p->id);
                                $p->size = count($count);
                        }
                }
                else
                {
                        $post = array();
                }
                $data['class_groups'] = $post;
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;


                //load view
                $this->template->title(' Class Groups ')->set_layout('setup')->build('admin/classes', $data);
        }

        function add_stream($id = FALSE, $page = NULL)
        {

                $this->load->model('class_groups/class_groups_m');
                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;
                $data['group'] = $id;
                //redirect if no $id
                if (!$id)
                {
                        redirect('admin/class_groups/');
                }
                if (!$this->class_groups_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/class_groups');
                }

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;
                if ($this->input->post())
                {
                        $user = $this->ion_auth->get_user();
                        //Insert Streams for Class Group
                        $streams = $this->input->post('streams');
                        if ($streams && is_array($streams) && count($streams))
                        {
                                foreach ($streams as $k)
                                {
                                        $claas = array(
                                            'class' => $id,
                                            'stream' => $k,
                                            'status' => 1,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );
                                        $done = $this->class_groups_m->add_stream($claas);
                                        if ($done)
                                        {
                                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                        }
                                        else
                                        {
                                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                        }
                                }
                        }

                        redirect("admin/setup/classes");
                }
                $data['streams'] = $this->class_groups_m->populate('class_stream', 'id', 'name');
                $class = $this->class_groups_m->find($id);
                $data['class'] = $class->name;
                //load the view and the layout
                $this->template->title('Add Streams ')->build('admin/add_stream', $data);
        }

        function edit_class($id = FALSE, $page = 0)
        {
                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/classes/');
                }
                $this->load->model('class_groups/class_groups_m');
                if (!$this->class_groups_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/classes');
                }
                //search the item to show in edit form
                $get = $this->class_groups_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->class_validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'class_name' => $this->input->post('class_name'),
                            'max_no_of_students' => $this->input->post('max_no_of_students'),
                            'class_teacher' => $this->input->post('class_teacher'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        // update
                        $done = $this->class_groups_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/setup/classes/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/setup/classes/");
                        }
                }
                else
                {
                        foreach (array_keys($this->class_validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->$field = $this->form_validation->$field;
                                }
                        }
                }
                $data['result'] = $get;
                $data['stream'] = $this->class_groups_m->get_stream();
                //load the view and the layout
                $this->template->title('Edit Classes ')->build('admin/new_class', $data);
        }

        /**
         * Quick Add Stream
         * 
         * @param type $page
         */
        function quick_add($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->str_validation());
                $this->load->model('class_stream/class_stream_m');
                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        if ($this->input->post('name'))
                        {
                                $user = $this->ion_auth->get_user();

                                $form_data = array(
                                    'name' => $this->input->post('name'),
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $ok = $this->class_stream_m->create($form_data);
                                if ($ok) 
                                {
                                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                                }
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }
                }
                redirect($_SERVER['HTTP_REFERER']);
        }

        public function subjects()
        {
                //Go back if previous step is incomplete
                if ($this->setup_m->count_classes() < 1)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'You Must add some Classes First.'));
                        redirect('admin/setup/classes/');
                }
                $this->load->model('subjects/subjects_m');
                $ctt = $this->subjects_m->count();
                $config = $this->set_paginate_options('admin/subjects/index/', $ctt);  //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $subs = $this->subjects_m->paginate_all($config['per_page'], $page);
                foreach ($subs as $s)
                {
                        $s->subs = $this->subjects_m->fetch_subcats($s->id);
                }

                $data['subjects'] = $subs;
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
 
                $this->template->title('Manage Subjects')->set_layout('setup')->build('admin/subjects', $data);
        }

        function new_subject($page = NULL)
        {
                $this->load->model('subjects/subjects_m');
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->sub_validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'name' => $this->input->post('title'),
                            'code' => $this->input->post('code'),
                            // 'grading_system' => $this->input->post('grading_system'),
                            'status' => 1,
                            'description' => $this->input->post('description'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->subjects_m->create($form_data);

                        if ($ok) 
                        {
                                foreach ($this->input->post('class') as $class_id)
                                {
                                        $values = array(
                                            'subject_id' => $ok,
                                            'class_id' => $class_id,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        );

                                        $this->subjects_m->insert_classes($values);
                                }

                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/setup/subjects/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->sub_validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['grading'] = $this->subjects_m->get_grading_system();

                        $data['result'] = $get;
                        //load the view and the layout
                        $this->template->title('Add Subject ')->set_layout('setup')->build('admin/new_sub', $data);
                }
        }

        function edit_subject($id = FALSE, $page = 0)
        {
                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;
                $this->load->model('subjects/subjects_m');
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/subjects/');
                }
                if (!$this->subjects_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/subjects');
                }
                //search the item to show in edit form
                $get = $this->subjects_m->find($id);
                //Rules for validation
                $this->form_validation->set_rules($this->sub_validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'name' => $this->input->post('title'),
                            //'class_id' => $this->input->post('class'), 							
                            'code' => $this->input->post('code'),
                            // 'grading_system' => $this->input->post('grading_system'),
                            'status' => $this->input->post('status'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //Insert Classes for subject
                        foreach ($this->input->post('class') as $class_id)
                        {
                                $values = array(
                                    'subject_id' => $id,
                                    'class_id' => $class_id,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $this->subjects_m->insert_classes($values);
                        }

                        $done = $this->subjects_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/setup/subjects/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/setup/subjects/");
                        }
                }
                else
                {
                        foreach (array_keys($this->sub_validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->$field = $this->form_validation->$field;
                                }
                        }
                }
                $data['result'] = $get;
                $data['grading'] = $this->subjects_m->get_grading_system();
                //load the view and the layout
                $this->template->title('Edit Subject ')->set_layout('setup')->build('admin/new_sub', $data);
        }

        public function houses()
        {
                //Go back if previous step is incomplete
                if ($this->setup_m->count_subjects() < 1)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'You Must add some Subjects First.'));
                        redirect('admin/setup/subjects/');
                }
                $this->load->model('house/house_m');
                $ctt = $this->house_m->count();
                $config = $this->set_paginate_options('admin/houses/index/', $ctt);
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                $data['house'] = $this->house_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];

                //load view
                $this->template->title(' House ')->set_layout('setup')->build('admin/houses', $data);
        }

        function new_house($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                $this->load->model('house/house_m');
                //Rules for validation
                $this->form_validation->set_rules($this->hao_validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'slogan' => $this->input->post('slogan'),
                            'leader' => $this->input->post('leader'),
                            'description' => $this->input->post('description'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->house_m->create($form_data);

                        if ($ok) // the information has  been successfully saved in the db
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/setup/houses/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->hao_validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        //load the view and the layout
                        $this->template->title('Add House ')->set_layout('setup')->build('admin/new_house', $data);
                }
        }

        function edit_house($id = FALSE, $page = 0)
        {
                //get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

                $this->load->model('house/house_m');
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/houses/');
                }
                if (!$this->house_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/setup/houses');
                }
                //search the item to show in edit form
                $get = $this->house_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->hao_validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'slogan' => $this->input->post('slogan'),
                            'leader' => $this->input->post('leader'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->house_m->update_attributes($id, $form_data);

                        
                        if ($done)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/setup/houses/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/setup/houses/");
                        }
                }
                else
                {
                        foreach (array_keys($this->hao_validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->$field = $this->form_validation->$field;
                                }
                        }
                }
                $data['result'] = $get;
                //load the view and the layout
                $this->template->title('Edit House ')->set_layout('setup')->build('admin/new_house', $data);
        }

        public function finish()
        {
                $data['teachers'] = $this->setup_m->count_teachers();
                $data['classes'] = $this->setup_m->count_classes();
                $data['subjects'] = $this->setup_m->count_subjects();
                $data['houses'] = $this->setup_m->count_houses();
                $this->template->title(' Setup Complete ')->set_layout('setup')->build('admin/conf', $data);
        }

        private function skul_validation()
        {
                $config = array(
                    array(
                        'field' => 'school',
                        'label' => 'School Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'postal_addr',
                        'label' => 'Postal Address',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'tel',
                        'label' => 'Telephone',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'cell',
                        'label' => 'cell phone',
                        'rules' => 'required|trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'motto',
                        'label' => 'Motto',
                        'rules' => 'trim|xss_clean|min_length[0]'),
                    array(
                        'field' => 'document',
                        'label' => 'Document',
                        'rules' => ''),
                    array(
                        'field' => 'website',
                        'label' => 'Official Website',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'fax',
                        'label' => 'Fax',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'town',
                        'label' => 'Town',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'school_code',
                        'label' => 'School Code',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function class_validation()
        {
                $config = array(
                    array(
                        'field' => 'class_name',
                        'label' => 'Class Name',
                        'rules' => 'trim|required|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'stream',
                        'label' => 'Class Stream',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'max_no_of_students',
                        'label' => 'Max No Of Students',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'class_teacher',
                        'label' => 'Class Teacher',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        /**
         * For Strem
         * 
         * @return array
         */
        private function str_validation()
        {
                $config = array(
                    array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        /**
         * Subjects Validation
         * 
         * @return array
         */
        private function sub_validation()
        {
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'code',
                        'label' => 'Code',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'class',
                        'label' => 'class',
                        'rules' => ''),
                    array(
                        'field' => 'grading_system',
                        'label' => 'Grading System',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'status',
                        'label' => 'Status',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function hao_validation()
        {
                $config = array(
                    array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'slogan',
                        'label' => 'Slogan',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'leader',
                        'label' => 'Leader',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options($base, $count)
        {
                $config = array();
                $config['base_url'] = site_url($base);
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 50;
                $config['total_rows'] = $count;
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

}
