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
        };
       /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
        {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
            redirect('admin');
        }*/

        $this->load->model('add_stock_m');
        $this->load->model('accounts/accounts_m');
    }

    public function index()
    {
        //set the title of the page
        $data['title'] = 'Stock List';

        $config = $this->set_paginate_options();
        //Initialize the pagination class
        $this->pagination->initialize($config);


        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        //find all the categories with paginate and save it in array to past to the view
        $data['add_stock'] = $this->add_stock_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //number page variable
        $data['page'] = $page;
        $product = $this->add_stock_m->get_products();

        $data['product'] = $product;

        //load view
        $this->template->title('All Stock ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['title'] = 'Create add_stock';
        $data['updType'] = 'create';
        $form_data_aux = array();
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        $receipt = '';

        if (!empty($_FILES['receipt']['name']))
        {
            $this->load->library('files_uploader');
            $upload_data = $this->files_uploader->upload('receipt');
            $receipt = $upload_data['file_name'];
        }


        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
             $user = $this->ion_auth->get_user();
            $form_data = array(
                'day' => strtotime($this->input->post('day')),
                'user_id' => $this->input->post('user_id'),
                'product_id' => $this->input->post('product_id'),
                'quantity' => $this->input->post('quantity'),
                'receipt' => $receipt,
                'unit_price' => $this->input->post('unit_price'),
                'total' => $this->input->post('total'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );
            $form_data = array_merge($form_data, $form_data_aux);

            $add_stock_m = $this->add_stock_m->create($form_data);

            if ($add_stock_m) 
            {
                $get_account = $this->accounts_m->get_by_code(750);
                $balance = 0;
                $amt = $this->input->post('total');
                $balance = $get_account->balance;
                $bal = $balance + $amt;

                $bal_details = array(
                    'balance' => $bal,
                    'modified_by' => $user->id,
                    'modified_on' => time());
                $this->accounts_m->update_attributes($get_account->id, $bal_details);
				
				     $details = implode(' , ',$this->input->post());
					 $user = $this->ion_auth->get_user();
						$log = array(
							'module' =>  $this->router->fetch_module(), 
							'item_id' => $add_stock_m, 
							'transaction_type' => $this->router->fetch_method(), 
							'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$add_stock_m, 
							'details' => $details,   
							'created_by' => $user -> id ,   
							'created_on' => time()
						);

					  $this->ion_auth->create_log($log);
								  

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_success')));
            }

            redirect('admin/add_stock/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['add_stock_m'] = $get;

            $product = $this->add_stock_m->get_products();

            $data['product'] = $product;
            //load the view and the layout
            $this->template->title('Add Stock ')->build('admin/create', $data);
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
            redirect('admin/add_stock/');
        }
        if (!$this->add_stock_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/add_stock');
        }
        //search the item to show in edit form
        $get = $this->add_stock_m->find($id);
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
            $array_thumbnails = array();
            $array_required = array();
            $data['add_stock_m'] = $this->add_stock_m->find($id);

            $this->load->library('upload');
            $this->load->library('image_lib');

          
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'day' => strtotime($this->input->post('day')),
                'user_id' => $this->input->post('user_id'),
                'product_id' => $this->input->post('product_id'),
                'quantity' => $this->input->post('quantity'),
                'unit_price' => $this->input->post('unit_price'),
                'total' => $this->input->post('total'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $add_stock_m = $this->add_stock_m->update_attributes($this->input->post('id', TRUE), $form_data);

            
            if ($add_stock_m)
            {

                $get_account = $this->accounts_m->get_by_code(750);
                $balance = 0;

                $amt = $this->input->post('total');
                /**
                 * * Reduce accounts chart by the balance then add the input amount
                 * */
                $balance = $get_account->balance;
                $initial_amount = $get->total;
                $actual_amt = $balance - $initial_amount;

                $bal = $actual_amt + $amt;

                $bal_details = array(
                    'balance' => $bal,
                    'modified_by' => $user->id,
                    'modified_on' => time());
                $this->accounts_m->update_attributes($get_account->id, $bal_details);

                 $details = implode(' , ',$this->input->post());
				$user = $this->ion_auth->get_user();
						$log = array(
							'module' =>  $this->router->fetch_module(), 
							'item_id' => $add_stock_m, 
							'transaction_type' => $this->router->fetch_method(), 
							'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$add_stock_m, 
							'details' => $details,   
							'created_by' => $user -> id ,   
							'created_on' => time()
						);
			     $this->ion_auth->create_log($log);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/add_stock/");
            }

            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $add_stock_m->errors->full_messages()));
                redirect("admin/add_stock/");
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
        $data['add_stock_m'] = $get;

        $product = $this->add_stock_m->get_products();

        $data['product'] = $product;
        //load the view and the layout
        $this->template->title('Edit Stock ')->build('admin/edit', $data);
    }

    function delete($id = NULL, $page = 1)
    {
        $files_to_delete = array();

        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/add_stock');
        }

        //search the item to delete
        if (!$this->add_stock_m->exists($id))
        {
           // $details = implode(' , ',$this->input->post());
				$user = $this->ion_auth->get_user();
						$log = array(
							'module' =>  $this->router->fetch_module(), 
							'item_id' => $add_stock_m, 
							'transaction_type' => $this->router->fetch_method(), 
							'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$add_stock_m, 
							//'details' => $details,   
							'created_by' => $user -> id ,   
							'created_on' => time()
						);
			 $this->ion_auth->create_log($log);
			
			$this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/add_stock');
        }
        else
            $add_stock_m = $this->add_stock_m->find($id);

        //Save the files into array to delete after
        array_push($files_to_delete, $add_stock_m->receipt);

        //delete the item
        if ($this->add_stock_m->delete($id) == TRUE)
        {
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_delete_success')));

            //delete the old images
            foreach ($files_to_delete as $index)
            {
                if (is_file(FCPATH . 'public/uploads/add_stock/files/' . $index))
                    unlink(FCPATH . 'public/uploads/add_stock/files/' . $index);
            }
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/add_stock/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'day',
                'label' => 'Day',
                'rules' => 'xss_clean|required'),
            array(
                'field' => 'user_id',
                'label' => 'Person Responsible',
                'rules' => 'xss_clean|required'),
            array(
                'field' => 'product_id',
                'label' => 'Product Id',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'quantity',
                'label' => 'Quantity',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'unit_price',
                'label' => 'Unit Price',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'total',
                'label' => 'Total',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/add_stock/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 100;
        $config['total_rows'] = $this->add_stock_m->count();
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

    private function set_upload_options($controller, $field)
    {
        //upload an image options
        $config = array();
        if ($field == 'receipt')
        {
            $config['upload_path'] = FCPATH . 'assets/uploads/' . $controller . '/files/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = '2048';
            $config['encrypt_name'] = TRUE;
        }
        //create controller upload folder if not exists
        if (!is_dir($config['upload_path']))
        {
            mkdir(FCPATH . "public/uploads/$controller/");
            mkdir(FCPATH . "public/uploads/$controller/files/");
            mkdir(FCPATH . "public/uploads/$controller/img/");
            mkdir(FCPATH . "public/uploads/$controller/img/thumbs/");
        }

        return $config;
    }

}
