<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                /* $this->template->set_layout('default');
                  $this->template->set_partial('sidebar','partials/sidebar.php')
                  -> set_partial('top', 'partials/top.php'); */
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
               /* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
                {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
                        redirect('admin');
                }*/

                $this->load->model('books_m');
        }

        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $data['books'] = $this->books_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();
                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                $data['category'] = $this->books_m->get_category();
                //load view
                $this->template->title(' Books ')->build('admin/list', $data);
        }

        /**
         * *Public function
         * *View
         * */
        function view($id = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/books/');
                }
                if (!$this->books_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/books');
                }

                $data['category'] = $this->books_m->get_category();
                $data['post'] = $this->books_m->find($id);

                $this->template->title(' Books ')->build('admin/view', $data);
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $add = 'add_stock';
                $data['add'] = 'add_stock';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'author' => $this->input->post('author'),
                            'publisher' => $this->input->post('publisher'),
                            'year_published' => $this->input->post('year_published'),
                            'isbn_number' => $this->input->post('isbn_number'),
                            'category' => $this->input->post('category'),
                            'edition' => $this->input->post('edition'),
                            'pages' => $this->input->post('pages'),
                            'copyright' => $this->input->post('copyright'),
                            'shelf' => $this->input->post('shelf'),
                            'memo' => $this->input->post('memo'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->books_m->create($form_data);
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
								  
							   $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                                redirect('admin/books/');
                        }
                        if ($add == 'add_stock')
                        {
                                redirect('admin/books_stock/create/' . $ok . '/1');
                        }
                        else
                        {
                                redirect('admin/books/');
                        }
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['category'] = $this->books_m->get_category();
                        //load the view and the layout
                        $this->template->title('Add Books ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/books/');
                }
                if (!$this->books_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/books');
                }
                //search the item to show in edit form
                $get = $this->books_m->find($id);
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
                            'title' => $this->input->post('title'),
                            'author' => $this->input->post('author'),
                            'publisher' => $this->input->post('publisher'),
                            'year_published' => $this->input->post('year_published'),
                            'isbn_number' => $this->input->post('isbn_number'),
                            'category' => $this->input->post('category'),
                            'edition' => $this->input->post('edition'),
                            'pages' => $this->input->post('pages'),
                            'copyright' => $this->input->post('copyright'),
                            'shelf' => $this->input->post('shelf'),
                            'memo' => $this->input->post('memo'),
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        $done = $this->books_m->update_attributes($id, $form_data);
                        
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
                                redirect("admin/books/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/books/");
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
                $data['category'] = $this->books_m->get_category();
                //load the view and the layout
                $this->template->title('Edit Books ')->build('admin/edit', $data);
        }

        function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/books');
                }

                //search the item to delete
                if (!$this->books_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/books');
                }

                //delete the item
                if ($this->books_m->delete($id) == TRUE)
                {    
			           //$details = implode(' , ', $this->input->post());
						 $user = $this->ion_auth->get_user();
						 $log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $id, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
								'details' => 'Deleted Record',   
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

                redirect("admin/books/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'author',
                        'label' => 'Author',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'publisher',
                        'label' => 'Publisher',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'year_published',
                        'label' => 'Year Published',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'isbn_number',
                        'label' => 'Isbn Number',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'category',
                        'label' => 'Category',
                        'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'edition',
                        'label' => 'Edition',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'pages',
                        'label' => 'Pages',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'copyright',
                        'label' => 'Copyright',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'shelf',
                        'label' => 'Shelf',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
                    array(
                        'field' => 'memo',
                        'label' => 'Memo',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/books/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->books_m->count();
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
