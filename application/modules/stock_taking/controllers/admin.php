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
		
        $this->load->model('stock_taking_m');
        $this->load->model('add_stock/add_stock_m');
    }

    public function index()
    {
        //set the title of the page
        $data['title'] = 'Stock_taking List';

        $config = $this->set_paginate_options();
        //Initialize the pagination class
        $this->pagination->initialize($config);


        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        //find all the categories with paginate and save it in array to past to the view
        $data['stock_taking'] = $this->stock_taking_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //number page variable
        $data['page'] = $page;
        $product = $this->add_stock_m->get_products();

        $data['product'] = $product;

        //load view
        $this->template->title('Stock taking ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['title'] = 'Create stock_taking';
        $data['updType'] = 'create';
        $form_data_aux = array();
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
 
            if ($closing_stock > $dat->quantity)
            {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Closing stock can't more than quantity (opening stock)"));

                redirect("admin/stock_taking/create", $data);
            }

            $form_data = array(
                'stock_date' => strtotime($this->input->post('stock_date')),
                'product_id' => $this->input->post('product_id'),
                'closing_stock' => $this->input->post('closing_stock'),
                'comment' => $this->input->post('comment'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $stock_taking_m = $this->stock_taking_m->create($form_data);



            if ($stock_taking_m) 
            {
                $details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $stock_taking_m, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$stock_taking_m, 
								'details' => $details,   
								'created_by' => $user -> id,   
								'created_on' => time()
							);

						  $this->ion_auth->create_log($log);
						  
				
				$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_success')));
            }

            redirect('admin/stock_taking/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['stock_taking_m'] = $get;
            $product = $this->add_stock_m->get_products();

            $data['product'] = $product;
            //load the view and the layout
            $this->template->title('Add Stock')->build('admin/create', $data);
        }
    }

    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $this->input->post('id', TRUE);
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //get the $page and sanitize
        $page = ( $this->uri->segment(5) ) ? $this->uri->segment(5) : $page;
        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/stock_taking/');
        }
        if (!$this->stock_taking_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/stock_taking');
        }
        //search the item to show in edit form
        $get = $this->stock_taking_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete = array();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['title'] = lang('web_edit');
        $data['updType'] = 'edit';
        $data['page'] = $page;

        if ($this->form_validation->run())  //validation has been passed
        {



            $form_data = array(
                'stock_date' => strtotime($this->input->post('stock_date')),
                'product_id' => $this->input->post('product_id'),
                'closing_stock' => $this->input->post('closing_stock'),
                'comment' => $this->input->post('comment'),
                'created_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $stock_taking_m = $this->stock_taking_m->update_attributes($this->input->post('id', TRUE), $form_data);

            
            if ($stock_taking_m)
            {
                       $details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $stock_taking_m, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$stock_taking_m, 
								'details' => $details,   
								'created_by' => $user -> id,   
								'created_on' => time()
							);

						  $this->ion_auth->create_log($log);
				
				$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/stock_taking/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $stock_taking_m->errors->full_messages()));
                redirect("admin/stock_taking/");
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
        $data['stock_taking_m'] = $get;
        $product = $this->add_stock_m->get_products();

        $data['product'] = $product;
        //load the view and the layout
        $this->template->title('Edit Stock ')->build('admin/edit', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/stock_taking');
        }

        //search the item to delete
        if (!$this->stock_taking_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/stock_taking');
        }

        //delete the item
        if ($this->stock_taking_m->delete($id) == TRUE)
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
			
			$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/stock_taking/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'stock_date',
                'label' => 'Stock Date',
                'rules' => 'xss_clean'),
            array(
                'field' => 'product_id',
                'label' => 'Product Id',
                'rules' => 'xss_clean'),
            array(
                'field' => 'closing_stock',
                'label' => 'Closing Stock',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'comment',
                'label' => 'Comment',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/stock_taking/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 100;
        $config['total_rows'] = $this->stock_taking_m->count();
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
        $config['full_tag_open'] = "<div class='pagination  pagination-centered'><ul>";
        $config['full_tag_close'] = '</ul></div>';
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }

}
