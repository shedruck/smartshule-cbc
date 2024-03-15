<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->template->set_layout('default');
        $this->template->set_partial('sidebar', 'partials/sidebar.php')
                //->set_partial('header', 'partials/header.php')
                ->set_partial('top', 'partials/top.php');
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        $this->load->model('counties_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        $data['counties'] = $this->counties_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Counties ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $form_data_aux = array();
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->counties_m->create($form_data);

            if ($ok) // the information has therefore been successfully saved in the db
            {
				  $details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
					$log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $ok, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$ok, 
						'details' => $details,   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
				  
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/counties/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->$field['field'] = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Counties ')->build('admin/create', $data);
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
            redirect('admin/counties/');
        }
        if (!$this->counties_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/counties');
        }
        //search the item to show in edit form
        $get = $this->counties_m->find($id);
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
                'description' => $this->input->post('description'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->counties_m->update_attributes($id, $form_data);

            // the information has therefore been successfully saved in the db
            if ($done)
            {
				  $details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
					$log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $done, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
						'details' => $details,   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
				  
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/counties/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/counties/");
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
        $this->template->title('Edit Counties ')->build('admin/create', $data);
    }

    /**
     * View Specific Counties 
     * 
     * @param int $id
     */
    function view($id = FALSE)
    {
        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/counties/');
        }
        if (!$this->counties_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/counties/');
        }
        //search the item to show in edit form
        $get = $this->counties_m->find($id);
        unset($get->id);
        unset($get->modified_by);
        unset($get->modified_on);
        unset($get->created_on);
        unset($get->created_by);
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('View Counties ')->build('admin/view', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/counties');
        }

        //search the item to delete
        if (!$this->counties_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/counties');
        }

        //delete the item
        if ($this->counties_m->delete($id) == TRUE)
        {
            //$details = implode(' , ', $this->input->post());
				$user = $this->ion_auth->get_user();
					$log = array(
						'module' =>  $this->router->fetch_module(), 
						'item_id' => $id, 
						'transaction_type' => $this->router->fetch_method(), 
						'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
						'details' => 'Record Deleted',   
						'created_by' => $user -> id,   
						'created_on' => time()
					);

				  $this->ion_auth->create_log($log);
				  
		   $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/counties/");
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

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/counties/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->counties_m->count();
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
        $config['full_tag_open'] = "<ul class='pagination  pagination-centered'>";
        $config['full_tag_close'] = '</ul>';
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }

}
