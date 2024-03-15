<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('sangar_scaffolds');
        $this->load->language('sangar_scaffolds');
        /*$this->template->set_theme('admin');
     
        $this->template->
                set_partial('sidebar', 'partials/sidebar.php')
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

        if (!$this->ion_auth->is_admin())
        {
            $this->session->set_flashdata('error', lang('web_not_backend'));
            redirect('admin/');
        }
    }

    function index()
    {
        //Rules for validation
        $this->_set_rules();

        //validate the fields of form
        if ($this->form_validation->run() == FALSE)
        {
            $this->template->title(' Home');
            $this->template->set('updType', 'create');
            $this->template->build('admin/create');
        }
        else
        {

            $data = array(
                'controller_name' => $this->input->post('controller_name', TRUE),
                'model_name' => $this->input->post('model_name', TRUE),
                'scaffold_code' => $this->input->post('scaffold_code', TRUE),
                'scaffold_delete_bd' => $this->input->post('scaffold_delete_bd', TRUE),
                'scaffold_bd' => $this->input->post('scaffold_bd', TRUE),
                'scaffold_routes' => $this->input->post('scaffold_routes', TRUE),
                'scaffold_menu' => $this->input->post('scaffold_menu', TRUE),
                'create_controller' => $this->input->post('create_controller', TRUE),
                'create_model' => $this->input->post('create_model', TRUE),
                'create_view_create' => $this->input->post('create_view_create', TRUE),
                'create_view_list' => $this->input->post('create_view_list', TRUE),
                'create_view_list' => $this->input->post('create_view_list', TRUE),
                'scaffold_model_type' => $this->input->post('scaffold_model_type', TRUE),
            );

            $result = $this->sangar_scaffolds->create($data);

            if ($result === TRUE)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('scaffolds_ok')));

                redirect("/admin/" . $this->input->post('controller_name', TRUE));
            }
            else
            {
                $this->template->title("Generator");
                $this->template->set('updType', 'create');
                $this->template->set('message', array('type' => 'error', 'text' => $result));
                $this->template->build('gen/create');
            }
        }
    }

    private function _set_rules($type = 'create', $id = NULL)
    {
        //validate form input
        $this->form_validation->set_rules('controller_name', 'Controller Name', 'required|xss_clean');
        $this->form_validation->set_rules('model_name', 'Controller Name', 'required|xss_clean');
        $this->form_validation->set_rules('scaffold_code', 'Scaffold Code', 'required|xss_clean');
        $this->form_validation->set_error_delimiters('<br /><div class="control-group error">', '</div>');
    }

}

