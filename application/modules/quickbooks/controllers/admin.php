<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->template->set_layout('default');
        $this->template->set_partial('sidebar', 'partials/sidebar.php')
                          ->set_partial('top', 'partials/top.php');
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        $this->load->model('quickbooks_m');
        $this->load->model('fee_payment/fee_payment_m');
    }

    public function index()
    {
        redirect('admin');
        $config = $this->_set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['quickbooks'] = $this->quickbooks_m->paginate_all($config['per_page'], $page);
        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Quickbooks ')->build('admin/list', $data);
    }

    function calc($id = 0)
    {
        if ($id)
        {
            $rs = $this->quickbooks_m->get_arrears($id);
            $rb = $this->worker->calc_balance_qb($id);
            echo '<pre>';
            print_r($rs);
            print_r($rb);
            echo '</pre>';
        }
        else
        {
            $rb = $this->worker->check_bals_qb();
        }
    }

    /**
     * View QBWC log of Requests
     */
    public function log()
    {
        $config = $this->_set_paginate_options();  //Initialize the pagination class
        //overwrite total rows in $config array
        $config['total_rows'] = $this->quickbooks_m->count_log();
        $config['per_page'] = 250;
        $this->pagination->initialize($config);
        $this->load->library('Dates');
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 1;
        $data['quickbooks'] = $this->quickbooks_m->fetch_log($config['per_page'], $page);
        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Quickbooks Web Connector Requests ')->build('admin/log', $data);
    }

    public function students()
    {
        $this->load->library('Dates');
        $data['seen'] = $this->quickbooks_m->count_seen();
        $data['all'] = $this->quickbooks_m->count_all();
        //load view
        $this->template->title(' Quickbooks Temporary Students Log ')->build('admin/students', $data);
    }

    function fx()
    {
        $ad = $this->quickbooks_m->get_adm();
        $fn = [];
        $mis = [];
        $dup = [];
        $i = 0;
        echo '<pre>';
        print_r(count($ad));
        echo '</pre>';
        foreach ($ad as $s)
        {
            $i++;
            if ($s->admission_number == '200563-1')
            {
                $s->admission_number = 200563;
            }

            $id_ = is_numeric($s->admission_number) ? ($s->admission_number - 200000 ) : $s->admission_number;
            $mis[$id_][] = $id_;
        }

        foreach ($mis as $m => $lst)
        {
            if (count($lst) > 1)
            {
                 $dup[] = $m;
            }
        }
        sort($dup);
        echo '<pre>';
        print_r($dup);
        echo '</pre>';
        die();
    }

    function fix_ol()
    {
        $iv = $this->quickbooks_m->getvoid();

        foreach ($iv as $p)
        {
            $we = $this->fee_payment_m->find($p->item_id);

            $up = ['status' => 0];
            if ($we->qb_status == 1)
            {
                $up['qb_status'] = 3;
            }

            //$this->fee_payment_m->update_by($p->item_id, 'fee_payment', $up);
        }
    }

    public function status()
    {
        $flagged = $this->quickbooks_m->get_voided_pay(50);
        echo '<pre>';
        print_r($flagged);
        echo '</pre>';
        die();

        $inv = $this->quickbooks_m->count_p_invoices('invoices');
        $ext = $this->quickbooks_m->count_p_by('fee_extra_specs', true);
        $students = $this->quickbooks_m->count_p_by('admission', true);
        $paid = $this->quickbooks_m->count_p_by('fee_payment', true);

        $data['qb'] = (object) ['invoices' => $inv, 'extras' => $ext, 'students' => $students, 'paid' => $paid];

        $voided = $this->quickbooks_m->count_voided_pay();
        $r_pay = $this->quickbooks_m->count_reverse_pay();
        $r_inv = $this->quickbooks_m->count_reverse_invoices();
        $r_extra = $this->quickbooks_m->count_reverse_extras();
        $data['reverse'] = (object) ['invoices' => $r_inv, 'extras' => $r_extra, 'pay' => ($r_pay + $voided)];

        $this->template->title('Quickbooks Status')->build('admin/status', $data);
    }

    public function get_students()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->quickbooks_m->get_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    public function get_payments()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->quickbooks_m->get_payments($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    public function get_real_vs()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->quickbooks_m->get_qb_invoices($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    public function get_invoices()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->quickbooks_m->get_invoices($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    public function get_unlinked_students()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->quickbooks_m->get_unlinked_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    public function invoices()
    {
        $data['all'] = $this->quickbooks_m->count_all_vc();
        $data['seen'] = $this->quickbooks_m->count_seen_vc();
        $data['sum'] = $this->quickbooks_m->count_pending_vc();
        //load view
        $this->template->title(' Quickbooks Temporary Invoices Log ')->build('admin/invoices', $data);
    }

    public function payments()
    {
        $data['seen'] = $this->quickbooks_m->count_seen_pay();
        $data['all'] = $this->quickbooks_m->count_all_paid();
        $data['sum'] = $this->quickbooks_m->count_pending_paid();

        //load view
        $this->template->title(' Quickbooks Temporary Payments Log ')->build('admin/pays', $data);
    }

    public function ivs()
    {
        //load view
        $this->template->title(' Quickbooks  Invoices Log ')->build('admin/inv');
    }

    public function pending()
    {
        //load view
        $this->template->title(' Quickbooks Unlinked Students ')->build('admin/pending');
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'name' => $this->input->post('name'),
                'day' => strtotime($this->input->post('day')),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->quickbooks_m->create($form_data);

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Quickbooks  ' . lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/quickbooks/');
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
            $this->template->title('Add Quickbooks ')->build('admin/create', $data);
        }
    }

    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/quickbooks/');
        }
        if (!$this->quickbooks_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/quickbooks');
        }
        //search the item to show in edit form
        $get = $this->quickbooks_m->find($id);
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
                'day' => strtotime($this->input->post('day')),
                'description' => $this->input->post('description'),
                'modified_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->quickbooks_m->update_attributes($id, $form_data);


            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/quickbooks/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/quickbooks/");
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
        $this->template->title('Edit Quickbooks ')->build('admin/create', $data);
    }

    function vv($txid)
    {
        echo '<pre>';
        $iv = $this->quickbooks_m->get_invoice($txid);
        $lines = $this->quickbooks_m->get_invoice_lines($txid);

        print_r($iv);
        print_r($lines);
        echo '</pre>';
    }

    function reset_pay($id = 0)
    {
        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/quickbooks/payments');
        }
        $this->quickbooks_m->rem_pay($id);
        redirect('admin/quickbooks/payments');
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/quickbooks');
        }

        //search the item to delete
        if (!$this->quickbooks_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/quickbooks');
        }

        //delete the item
        if ($this->quickbooks_m->delete($id) == TRUE)
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/quickbooks/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'
            ),
            array(
                'field' => 'day',
                'label' => 'Day',
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
            ),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function _set_paginate_options($slug = FALSE)
    {
        $config = array();
        if (!empty($slug))
        {
            $config['base_url'] = site_url() . 'admin/quickbooks/' . $slug . '/index/';
        }
        else
        {
            $config['base_url'] = site_url() . 'admin/quickbooks/log/index/';
        }
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->quickbooks_m->count_log();
        $config['uri_segment'] = 5;

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
