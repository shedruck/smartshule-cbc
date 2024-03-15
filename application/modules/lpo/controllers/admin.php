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
        $this->load->model('lpo_m');
    }

    public function suppliers()
    {
        $data['per'] = '';

        //load view
        $this->template->title(' Suppliers ')->build('admin/suppliers', $data);
    }

    /**
     * Get Suppliers
     *
     */
    public function list_suppliers()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->lpo_m->get_suppliers($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    public function index()
    {
        $data['per'] = '';

        //load view
        $this->template->title(' LPO ')->build('admin/list', $data);
    }

    /**
     * Get Suppliers
     *
     */
    public function list_lpo()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->lpo_m->get_lpo($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);
        echo json_encode($output);
    }

    function add_supplier($page = 0)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->supplier_validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $user = $this->ion_auth->get_user();
            $form = [
                'name' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'created_by' => $user->id,
                'created_on' => time()
            ];

            $ok = $this->lpo_m->create('lpo_suppliers', $form);

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/lpo/suppliers');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->supplier_validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Supplier ')->build('admin/add_supplier', $data);
        }
    }

    function post_lpo()
    {
        $json = file_get_contents('php://input');
        $post = json_decode($json);

        if ($post->supplier && $post->date && count($post->items))
        {
            $form = [
                'lpo_date' => strtotime($post->date),
                'supplier' => $post->supplier->id,
                'total' => $post->total,
                'status' => 1,
                'created_by' => $this->user->id,
                'created_on' => time()
            ];
            $lpo_id = $this->lpo_m->create('lpo', $form);

            foreach ($post->items as $p)
            {
                $amount = $p->price * $p->qty;
                if (!$amount)
                {
                    continue;
                }
                $lines = [
                    'lpo' => $lpo_id,
                    'item' => $p->item->id,
                    'amount' => $amount,
                    'quantity' => $p->qty,
                    'unit_price' => $p->price,
                    'status' => 1,
                    'created_on' => time(),
                    'created_by' => $this->user->id
                ];
                $this->lpo_m->create('lpo_items', $lines);
            }
            echo json_encode(['message' => 'Success']);
        }
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
        {
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->lpo_m->create($form_data);

            if ($ok)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/lpo/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $suppliers = $this->lpo_m->populate('lpo_suppliers', 'id', 'name');
            $exp_items = $this->lpo_m->populate('expense_items', 'id', 'name');

            $items = [];
            foreach ($exp_items as $k => $s)
            {
                $items[] = ['id' => $k, 'name' => $s];
            }
            $options = [];
            foreach ($suppliers as $k => $s)
            {
                $options[] = ['id' => $k, 'text' => $s];
            }
            $data['options'] = $options;
            $data['items'] = $items;
            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add LPO ')->build('admin/create', $data);
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
            redirect('admin/lpo/');
        }
        if (!$this->lpo_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/lpo');
        }
        //search the item to show in edit form
        $get = $this->lpo_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
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
                'description' => $this->input->post('description'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //find the item to update
            $done = $this->lpo_m->update_attributes($id, $form_data);

            if ($done)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/lpo/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/lpo/");
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
        //load the view and the layout
        $this->template->title('Edit LPO ')->build('admin/create', $data);
    }

    function view($id = 0)
    {
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/lpo/');
        }
        if (!$this->lpo_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/lpo');
        }
        $lpo = $this->lpo_m->find($id);
        $lpo->supplier =$this->lpo_m->find_supplier($lpo->supplier); 
        $lpo->items =$this->lpo_m->get_items($id);
        $data['lpo'] = $lpo;
        //load the view and the layout
        $this->template->title('View LPO')->build('admin/view', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/lpo');
        }

        //search the item to delete
        if (!$this->lpo_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/lpo');
        }

        //delete the item
        if ($this->lpo_m->delete($id) == TRUE)
        {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/lpo/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function supplier_validation()
    {
        $config = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'],
            [
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]']
        ];
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/lpo/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->lpo_m->count();
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
