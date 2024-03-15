<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        /*$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/login');
        }
        $this->load->model('transport_drivers_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['transport_drivers'] = $this->transport_drivers_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        $data['categories'] = $this->transport_drivers_m->populate('driver_categories', 'id', 'name');

        //load view
        $this->template->title(' Transport Drivers ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $form_data_aux  = array();
        $data['page'] = ($this->uri->segment(4))  ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run() ) {         //Validation OK!
            $user = $this->ion_auth->get_user();

            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = '12345678d';
            $group = $this->input->post('group');

            $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'passport' => '',
                    'me' => $this->ion_auth->get_user()->id,
            );

            $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);


            $this->ion_auth->add_to_group($group, $u_id);
            if($u_id)
            {
                $form_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'middle_name' => $this->input->post('middle_name'),
                    'last_name' => $this->input->post('last_name'),
                    'phone' => $this->input->post('phone'),
                    'email' => $this->input->post('email'),
                    'driving_license' => $this->input->post('driving_license'),
                    'dl' => $this->input->post('dl'),
                    'expiry_date' => $this->input->post('expiry_date'),
                    'category' => $this->input->post('category'),
                    'status' => 1,
                    'user_id' => $u_id,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $ok =  $this->transport_drivers_m->create($form_data);
            }
            

            if ($ok) 
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            } 
            else 
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/transport_drivers/');
        } else {
            $get = new StdClass();

            
            foreach ($this->validation() as $field) {
                $get->$field['field']  = set_value($field['field']);
            }

            $data['result'] = $get;
            $data['groups_list'] = $this->transport_drivers_m->populate('groups', 'id', 'name');
            $data['categories'] = $this->transport_drivers_m->populate('driver_categories','id','name');
            //load the view and the layout
            $this->template->title('Add Transport Drivers ')->build('admin/create', $data);
        }
    }

    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/transport_drivers/');
        }
        if (!$this->transport_drivers_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/transport_drivers');
        }
        //search the item to show in edit form
        $get =  $this->transport_drivers_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete  = array();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {
            $user = $this->ion_auth->get_user();
            // build array for the model
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');

            $additional_data = array(
                'username' => $username,
                'email' => $email,
                'phone' => $this->input->post('phone'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'modified_by' => $this->ion_auth->get_user()->id,
                'modified_on' => time(),
            );

            $this->ion_auth->update_user($get->user_id, $additional_data);
            $form_data = array(
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'driving_license' => $this->input->post('driving_license'),
                'email' => $this->input->post('email'),
                'dl' => $this->input->post('dl'),
                'expiry_date' => $this->input->post('expiry_date'),
                'category' => $this->input->post('category'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->transport_drivers_m->update_attributes($id, $form_data);

            if ($done) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/transport_drivers/");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/transport_drivers/");
            }
        } else {
            foreach (array_keys($this->validation()) as $field) {
                if (isset($_POST[$field])) {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        $data['categories'] = $this->transport_drivers_m->populate('driver_categories', 'id', 'name');
        //load the view and the layout
        $this->template->title('Edit Transport Drivers ')->build('admin/create', $data);
    }


    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/transport_drivers');
        }

        //search the item to delete
        if (!$this->transport_drivers_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/transport_drivers');
        }

        //delete the item
        if ($this->transport_drivers_m->delete($id) == TRUE) {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/transport_drivers/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'first_name',
                'label' => 'Fist Name',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'middle_name',
                'label' => 'Middle Name',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'phone',
                'label' => 'Phone Number',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'driving_license',
                'label' => 'Driving License Number',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'category',
                'label' => 'Category',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'group',
                'label' => 'Group',
                'rules' => 'trim|xss_clean'
            ),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }


    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/transport_drivers/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->transport_drivers_m->count();
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
