<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        $this->load->model('fee_arrears_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['fee_arrears'] = $this->fee_arrears_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Fee Arears ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'student' => $this->input->post('student'),
                'amount' => $this->input->post('amount'),
                'term' => $this->input->post('term'),
                'year' => $this->input->post('year'),
                'created_by' => $user->id,
                'created_on' => time()
            );
            if (!$this->fee_arrears_m->exists_student($this->input->post('student')))
            {
                $ok = $this->fee_arrears_m->create($form_data);

                if ($ok)
                {

                    $this->worker->calc_balance($this->input->post('student'));
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }


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
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Sorry the selected student's fee arrears has been recoreded"));
            }




            redirect('admin/fee_arrears/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Fee Arears ')->build('admin/create', $data);
        }
    }

    function per_class($id = NULL)
    {
        $data['students'] = $this->fee_arrears_m->fetch_full_students($id);
        $classes_groups = $this->fee_arrears_m->populate('class_groups', 'id', 'name');
        $classes = $this->fee_arrears_m->populate('classes', 'id', 'class');
        $class_str = $this->fee_arrears_m->populate('classes', 'id', 'stream');
        $stream_name = $this->fee_arrears_m->populate('class_stream', 'id', 'name');

        $data['class'] = $classes_groups [$classes[$id]] . ' ' . $stream_name[$class_str[$id]];

        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation_class());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK! 
            $user = $this->ion_auth->get_user();
            $amount = array();
            $stud_ids = $this->input->post('sids');

            if (is_array($stud_ids) && count($stud_ids))
            {
                $i = -1;
                $students_with = 0;
                $term = $this->input->post('term');
                $year = $this->input->post('year');
                $amount = $this->input->post('amount');
                foreach ($stud_ids as $st)
                {
                    $i++;

                    if ($this->fee_arrears_m->exists_student($st))
                    {
                        $students_with = ++$i;
                    }
                    else
                    {
                        $table_list = array(
                            'term' => $term,
                            'student' => $st,
                            'year' => $year,
                            'amount' => $amount[$st],
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->fee_arrears_m->create($table_list);

                        $this->worker->calc_balance($st);

                        $details = implode(' , ', $table_list);
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
                    }
                }
            }

            if ($ok)
            {
                if ($students_with == 0)
                {
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Fee Arrears Were Successfully Recorded'));
                }
                else
                {
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Fee Arrears Were Successfully Recorded. ' . $students_with . ' fee arrears had already been recorded'));
                }
            }
            else
            {
                if ($students_with > 0)
                {

                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => "Fee arrears were successfully recorded. Some Student's fee arrears had already had already been recorded. Please check again"));
                }
            }

            redirect('admin/fee_arrears/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }
        }

        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Record Fee Arrears ')->build('admin/per_class', $data);
    }

    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_arrears/');
        }
        if (!$this->fee_arrears_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/fee_arrears');
        }
        //search the item to show in edit form
        $get = $this->fee_arrears_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete = array();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {
            $user = $this->ion_auth->get_user();
            // build array for the model
            $form_data = array(
                'student' => $this->input->post('student'),
                'amount' => $this->input->post('amount'),
                'term' => $this->input->post('term'),
                'year' => $this->input->post('year'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->fee_arrears_m->update_attributes($id, $form_data);

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
                redirect("admin/fee_arrears/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/fee_arrears/");
            }
        }
        else
        {
            foreach (array_keys($this->validation()) as $field)
            {
                if (isset($_POST[$field]))
                {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Fee Arears ')->build('admin/create', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/fee_arrears');
        }

        //search the item to delete
        if (!$this->fee_arrears_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/fee_arrears');
        }

        //delete the item
        if ($this->fee_arrears_m->delete($id) == TRUE)
        {
            //$details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $id,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
                'details' => 'Record Deleted',
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

        redirect("admin/fee_arrears/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'student',
                'label' => 'Student',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function validation_class()
    {
        $config = array(
            array(
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'xss_clean'),
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/fee_arrears/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10000000000;
        $config['total_rows'] = $this->fee_arrears_m->count();
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
