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
		
        $this->load->model('petty_cash_m');
		 $this->load->model('accounts/accounts_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        $data['petty_cash'] = $this->petty_cash_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Petty Cash ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';

        $data['users'] = $this->petty_cash_m->list_staff();
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'petty_date' => strtotime($this->input->post('petty_date')),
                'description' => $this->input->post('description'),
                'amount' => $this->input->post('amount'),
                'person' => $this->input->post('person'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok = $this->petty_cash_m->create($form_data);

            if ($ok) 
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
																		  
				
				$get_account = $this->accounts_m->get_by_code(429);
                $balance = 0;
                $amt = $this->input->post('amount');
                $balance = $get_account->balance;
                $bal = $balance + $amt;

                $bal_details = array(
                    'balance' => $bal,
                    'modified_by' => $user->id,
                    'modified_on' => time());
                $this->accounts_m->update_attributes($get_account->id, $bal_details);
				
				$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/petty_cash/');
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
            $this->template->title('Add Petty Cash ')->build('admin/create', $data);
        }
    }

    public function get_table()
    {
         $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->petty_cash_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
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
            redirect('admin/petty_cash/');
        }
        if (!$this->petty_cash_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/petty_cash');
        }
        //search the item to show in edit form
        $get = $this->petty_cash_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $data['users'] = $this->petty_cash_m->list_staff();

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
                'petty_date' => strtotime($this->input->post('petty_date')),
                'description' => $this->input->post('description'),
                'amount' => $this->input->post('amount'),
                'person' => $this->input->post('person'),
                'modified_by' => $user->id,
                'modified_on' => time());

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->petty_cash_m->update_attributes($id, $form_data);

            
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
				  
				  
				$get_account = $this->accounts_m->get_by_code(429);
                $balance = 0;

                $amt = $this->input->post('amount');
                /**
                 * * Reduce accounts chart by the balance then add the input amount
                 * */
                $balance = $get_account->balance;
                $initial_amount = $get->amount;
                $actual_amt = $balance - $initial_amount;

                $bal = $actual_amt + $amt;

                $bal_details = array(
                    'balance' => $bal,
                    'modified_by' => $user->id,
                    'modified_on' => time());
                $this->accounts_m->update_attributes($get_account->id, $bal_details);
				
				
				$this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/petty_cash/");
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/petty_cash/");
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
        $this->template->title('Edit Petty Cash ')->build('admin/create', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/petty_cash');
        }

        //search the item to delete
        if (!$this->petty_cash_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/petty_cash');
        }

        //delete the item
        if ($this->petty_cash_m->delete($id) == TRUE)
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

        redirect("admin/petty_cash/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'petty_date',
                'label' => 'Petty Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'amount',
                'label' => 'Amount',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'person',
                'label' => 'Person',
                'rules' => 'required|xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/petty_cash/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 1000000;
        $config['total_rows'] = $this->petty_cash_m->count();
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
