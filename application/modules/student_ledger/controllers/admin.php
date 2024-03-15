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
        $this->load->model('student_ledger_m');
        // $this->load->model('fee_payment/fee_payment_m');
        // $this->load->model('fee_structure/fee_structure_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['student_ledger'] = $this->student_ledger_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Student Ledger ')->build('admin/list', $data);
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
                'name' => $this->input->post('name'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->student_ledger_m->create($form_data);

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/student_ledger/');
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
            $this->template->title('Add Student Ledger ')->build('admin/create', $data);
        }
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
            redirect('admin/student_ledger/');
        }
        if (!$this->student_ledger_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/student_ledger');
        }
        //search the item to show in edit form
        $get = $this->student_ledger_m->find($id);
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
                'name' => $this->input->post('name'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->student_ledger_m->update_attributes($id, $form_data);

            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/student_ledger/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/student_ledger/");
            }
        }
        else
        {
            foreach (array_keys($this->validation()) as $field)
            {
                if (isset($_POST[$field]))
                {
                    $get->{ $field} = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Student Ledger ')->build('admin/create', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/student_ledger');
        }

        //search the item to delete
        if (!$this->student_ledger_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/student_ledger');
        }

        //delete the item
        if ($this->student_ledger_m->delete($id) == TRUE)
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/student_ledger/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/student_ledger/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->student_ledger_m->count();
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

    function ledger()
    {

        if ($this->input->post())
        {
            $student = $this->input->post('student');
            $item = $this->input->post('item');
            $year = $this->input->post('year');
            $term = $this->input->post('term');

            if ($item == 1) //invoices
            {
                $data['invoices'] = $this->student_ledger_m->get_invoice($student, $term, $year);
            }

            if ($item == 2) //fee_extras
            {
                $data['f_extras'] = $this->student_ledger_m->get_fee_extras($student, $term, $year);
                $data['xtras'] = $this->student_ledger_m->populate('fee_extras', 'id', 'title');
            }

            if ($item == 3) //payments
            {
                $data['payments'] = $this->student_ledger_m->get_payments($student, $term, $year);
                $data['xtras'] = $this->student_ledger_m->populate('fee_extras', 'id', 'title');
            }
        }

        $range = range(date('Y') - 15, date('Y'));
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $this->template->title('Students Ledger ')->build('admin/ledger', $data);
    }

    function flag_invoice($id)
    {
        $row = $this->student_ledger_m->fetch_invoice($id);
        $data = [
            'flagged' => 1,
            'check_st' => 4,
            'f_status' => 0,
            'qb_status' => empty($row->edit_sequence) ? 4 : 3
        ];
        $ok = $this->student_ledger_m->update_($id, $data, 'invoices');

        $this->student_ledger_m->create_r('reversals', [
            'item_id' => $id,
            'item' => 'Invoice',
            'flagged_by' => $this->user->id,
            'flagged_on' => time(),
            'r_status' =>0,
            'description' => 'Flagged',
            'created_by' => $this->user->id,
            'created_on' => time()
                          ], false);
        if ($ok)
        {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Invoice Flagged'));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Something Went Wrong'));
        }

        redirect('admin/student_ledger/ledger');
    }

    function flag_extra($id)
    {
        $row = $this->student_ledger_m->fetch_extra($id);

        $data = [
            'flagged' => 1,
            'status' => 2,
            'f_status' => 0,
            'qb_status' => empty($row->edit_sequence) ? 4 : 3
        ];

        $ok = $this->student_ledger_m->update_att($id, $data, 'fee_extra_specs');

        $this->student_ledger_m->create_r('reversals', [
            'item_id' => $id,
            'item' => 'Extras',
            'flagged_by' => $this->user->id,
            'flagged_on' => time(),
            'r_status' =>0,
            'description' => 'Flagged',
            'created_by' => $this->user->id,
            'created_on' => time()
                          ], false);
        if ($ok)
        {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Successfully Flagged'));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Something Went Wrong'));
        }

        redirect('admin/student_ledger/ledger');
    }

    function flag_payment($id)
    {
        $row = $this->student_ledger_m->fetch_pay($id);
        $data = [
            'flagged' => 1,
            'status' => 3,
            'f_status' => 0,
            'qb_status' => empty($row->edit_sequence) ? 4 : 3
        ];

        $ok = $this->student_ledger_m->update_att($id, $data, 'fee_payment');
        
        $this->student_ledger_m->create_r('reversals', [
            'item_id' => $id,
            'item' => 'Payment',
            'flagged_by' => $this->user->id,
            'flagged_on' => time(),
            'r_status' =>0,
            'description' => 'Flagged',
            'created_by' => $this->user->id,
            'created_on' => time()
                          ], false);
        if ($ok)
        {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Successfully Flagged'));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Something Went Wrong'));
        }

        redirect('admin/student_ledger/ledger');
    }

    function fx()
    {
        return FALSE;
        $f_ev = $this->student_ledger_m->get_flagged_inv();
        
        foreach ($f_ev as $fv)
        {
            $this->student_ledger_m->update_($fv->id, ['f_status' => 0], 'invoices');
        }
        $f_v = $this->student_ledger_m->get_flagged_inv();
        echo '<pre>';
        print_r($f_v);
        echo '</pre>';
        die();
    }

    function flagged()
    {
        return FALSE;
        $void = $this->student_ledger_m->get_voided();
        $pay = $this->student_ledger_m->get_flagged('fee_payment', true);
        $extras = $this->student_ledger_m->get_flagged('fee_extra_specs', true);
        $inv = $this->student_ledger_m->get_flagged('invoices', false);

        foreach ($pay as $fp)
        {
            $this->student_ledger_m->create_r('reversals', [
                'item_id' => $fp->id,
                'item' => 'Payment',
                'flagged_by' => '', // $fp->modified_by,
                'flagged_on' => '', // $fp->modified_on,
                'description' => 'Flagged',
                'created_by' => $fp->created_by,
                'created_on' => '', // $fp->modified_on,
                              ], false);
        }
        foreach ($void as $v)
        {
            $this->student_ledger_m->create_r('reversals', [
                'item_id' => $v->id,
                'item' => 'Payment',
                'flagged_by' => '', // $v->modified_by,
                'flagged_on' => '', // $v->modified_on,
                'description' => 'Voided',
                'created_by' => $v->created_by,
                'created_on' => '', // $v->modified_on,
                              ], false);
        }
        foreach ($extras as $ex)
        {
            $this->student_ledger_m->create_r('reversals', [
                'item_id' => $ex->id,
                'item' => 'Extras',
                'flagged_by' => '', // $ex->modified_by,
                'flagged_on' => '', // $ex->modified_on,
                'description' => 'Flagged',
                'created_by' => $ex->created_by,
                'created_on' => '', // $ex->modified_on
                              ], false);
        }
        foreach ($inv as $iv)
        {
            $this->student_ledger_m->create_r('reversals', [
                'item_id' => $iv->id,
                'item' => 'Invoice',
                'flagged_by' => '', // $iv->modified_by,
                'flagged_on' => '', // $iv->modified_on,
                'description' => 'Flagged',
                'created_by' => $iv->created_by,
                'created_on' => '', // $iv->modified_on
                              ], false);
        }
    }

}
