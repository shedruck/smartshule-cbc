<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Admin
 */
class Admin extends Admin_Controller
{

        /**
         * @var
         */
        public $get;

        /**
         * @var
         */
        public $pcount;

        /**
         *
         */
        function __construct()
        {
                parent::__construct();
                if (!$this->ion_auth->logged_in())
                {
                        redirect('admin/login');
                }
                $this->load->model('subjects_m');
                $valid = $this->portal_m->get_class_ids();
                if ($this->input->get('sw'))
                {
                        $pop = $this->input->get('sw');
                        //limit to available classes only
                        if (!in_array($pop, $valid))
                        {
                                $pop = $valid[0];
                        }
                        $this->session->set_userdata('pop', $pop);
                }
                else if ($this->session->userdata('pop'))
                {
                        $pop = $this->session->userdata('pop');
                }
                else
                {
                        
                }
        }

        /**
         *
         */
        public function index()
        {
                $config = $this->set_paginate_options();  //Initialize the pagination class
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
                $subs = $this->subjects_m->paginate_all($config['per_page'], $page);
                foreach ($subs as $s)
                {
                        $s->subs = $this->subjects_m->fetch_subcats($s->id);
                }

                $data['subjects'] = $subs;
                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //page number  variable
                $data['page'] = $page;
                $data['per'] = $config['per_page'];
                //load view
                $this->template->title(' Subjects ')->build('admin/list', $data);
        }

        public function assign()
        {
                $list = $this->subjects_m->get_electives();
                $this->form_validation->set_rules($this->sub_validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {
                        $slist = $this->input->post('sids');
                        $sub = $this->input->post('subject');
                        $year = $this->input->post('year');
                        if (is_array($slist) && count($slist))
                        {
                                foreach ($slist as $s)
                                {
                                        $row = array(
                                            'student' => $s,
                                            'year' => $year,
                                            'subject' => $sub,
                                            'created_on' => time(),
                                            'created_by' => $this->ion_auth->get_user()->id
                                        );
                                      $ok =  $this->subjects_m->assign_elective($row, $s, $sub, $year);
                                }
								
								$details = implode(' , ', $slist).','.$sub.','.$year;
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
						  
                        }

                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Success'));
                        redirect('admin/subjects/assign');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->sub_validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
                        $data['result'] = $get;
                        $data['list'] = $list;

                        $range = range(date('Y') - 1, date('Y') + 1);
                        $data['yrs'] = array_combine($range, $range);
                        //load view
                        $this->template->title('Assign Subjects ')->build('admin/assign', $data);
                }
        }

        /**
         * @return array
         */
        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/subjects/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 10000000;
                $config['total_rows'] = $this->subjects_m->count();
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
                //$choice = $config["total_rows"] / $config["per_page"];
                //$config["num_links"] = round($choice);

                return $config;
        }

        /**
         * @param null $page
         */
        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->validation());
                //validate the fields of form
                if ($this->form_validation->run())
                {  //Validation OK!
                        $has_subs = $this->input->post('sub_units');
                        $user = $this->ion_auth->get_user();
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'code' => $this->input->post('code'),
                            'custom' => $this->input->post('custom'),
                            'short_name' => $this->input->post('short_name'),
                            'priority' => $this->input->post('priority'),
                            'sub_units' => $has_subs,
                            'is_optional' => $this->input->post('is_optional'),
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $ok = $this->subjects_m->create($form_data);
                        if ($ok) 
                        {
                                $classes = $this->input->post('class');
                                $terms = $this->input->post('term');

                                if ($classes && $terms)
                                {
                                        $wlen = count($classes);
                                        if ($wlen)
                                        {

                                                for ($ii = 0; $ii < $wlen; $ii++)
                                                {
                                                        if (isset($classes[$ii]) && isset($terms[$ii]))
                                                        {
                                                                $tlen = count($terms[$ii]);
                                                                if ($tlen)
                                                                {
                                                                        for ($h = 0; $h < $tlen; $h++)
                                                                        {
                                                                                $sbc = array(
                                                                                    'class_id' => $classes[$ii],
                                                                                    'subject_id' => $ok,
                                                                                    'term' => $terms[$ii][$h],
                                                                                    'created_on' => time(),
                                                                                    'created_by' => $user->id
                                                                                );
                                                                                $this->subjects_m->save_by_classes($sbc);
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                }
								
								
								$details = implode(' , ', $form_data);
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

                        redirect('admin/subjects/');
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
                        $this->template->title('Add Subjects ')->build('admin/create', $data);
                }
        }

        function _valid_sid()
        {
                $sid = $this->input->post('sids');
                if (is_array($sid) && count($sid))
                {
                        return TRUE;
                }
                else
                {
                        $this->form_validation->set_message('_valid_sid', 'Please Select at least one Student.');
                        return FALSE;
                }
        }

        private function sub_validation()
        {
                $config = array(
                    array(
                        'field' => 'sids',
                        'label' => 'Student List',
                        'rules' => 'xss_clean|callback__valid_sid'),
                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'year',
                        'label' => 'Year',
                        'rules' => 'required|xss_clean')
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
        }

        /**
         * @return array
         */
        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|trim|xss_clean|max_length[60]'
                    ),
                    array(
                        'field' => 'code',
                        'label' => 'Code',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[30]'
                    ),
                    array(
                        'field' => 'short_name',
                        'label' => 'Short Name',
                        'rules' => 'required'
                    ),
					array(
                        'field' => 'custom',
                        'label' => 'Custom',
                        'rules' => 'trim'
                    ),
                    array(
                        'field' => 'is_optional',
                        'label' => 'Subject Type',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'priority',
                        'label' => 'Subject Priority',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'sub_units',
                        'label' => 'Sub Units',
                        'rules' => 'required|xss_clean'
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

        private function unit_validation()
        {
                $config = array(
                    array(
                        'field' => 'title',
                        'label' => 'Title',
                        'rules' => 'required|trim|xss_clean|max_length[60]'
                    ),
                    array(
                        'field' => 'out_of',
                        'label' => 'Out of',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[30]'
                    )
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        /**
         * @param bool|FALSE $id
         * @param int $page
         */
        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects/');
                }
                if (!$this->subjects_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }
                //search the item to show in edit form
                $get = $this->subjects_m->find($id);
                $get->subs = $this->subjects_m->fetch_subcats($id);

                $get->classign = $this->subjects_m->fetch_assigned_classes($id);
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $has_subs = $this->input->post('sub_units');
                        $user = $this->ion_auth->get_user();

                        // build array for the model
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'code' => $this->input->post('code'),
							'custom' => $this->input->post('custom'),
                            'short_name' => $this->input->post('short_name'),
                            'priority' => $this->input->post('priority'),
                            'is_optional' => $this->input->post('is_optional'),
                            'sub_units' => $has_subs,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        $done = $this->subjects_m->update_attributes($id, $form_data);
                        
                        if ($done)
                        {
                                $classes = $this->input->post('class');
                                $terms = $this->input->post('term');

                                if ($classes && $terms)
                                {
                                        $wlen = count($classes);
                                        if ($wlen)
                                        {
                                                for ($ii = 0; $ii < $wlen; $ii++)
                                                {
                                                        if (isset($classes[$ii]) && isset($terms[$ii]))
                                                        {
                                                                $tlen = count($terms[$ii]);
                                                                if ($tlen)
                                                                {
                                                                        for ($h = 0; $h < $tlen; $h++)
                                                                        {
                                                                                $sbc = array(
                                                                                    'class_id' => $classes[$ii],
                                                                                    'subject_id' => $id,
                                                                                    'term' => $terms[$ii][$h],
                                                                                    'created_on' => time(),
                                                                                    'created_by' => $user->id
                                                                                );
                                                                                $this->subjects_m->save_by_classes($sbc, $classes[$ii], $id, $terms[$ii][$h]);
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                }
								
						$details = implode(' , ', $form_data);
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
                                redirect("admin/subjects/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/subjects/");
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
                $data['id'] = $id;
                //load the view and the layout
                $this->template->title('Edit Subjects')->build('admin/edit', $data);
        }

        function edit_unit($id = FALSE)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects/');
                }
                if (!$this->subjects_m->unit_exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }
                //search the item to show in edit form
                $get = $this->subjects_m->find_unit($id);
                $this->form_validation->set_rules($this->unit_validation());

                if ($this->form_validation->run())  //validation has been passed
                {
                        $title = $this->input->post('title');
                        $out = $this->input->post('out_of');
                        $user = $this->ion_auth->get_user();

                        // build array for the model
                        $form_data = array(
                            'title' => $title,
                            'out_of' => $out,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        $done = $this->subjects_m->update_unit($id, $form_data);
                        
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
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Error. Unable to save'));
                        }
                        redirect("admin/subjects/units/" . $get->parent);
                }
                else
                {
                        foreach (array_keys($this->unit_validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->$field = $this->form_validation->$field;
                                }
                        }
                }

                $data['unit'] = $get;
                $data['id'] = $id;
                //load the view and the layout
                $this->template->title('Edit Unit ')->build('admin/edit_unit', $data);
        }

        /**
         * Sub Units For Subject
         * 
         * @param int $id
         */
        function units($id = FALSE)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects/');
                }
                if (!$this->subjects_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }
                //search the item to show in edit form
                $get = $this->subjects_m->find($id);
                $get->subs = $this->subjects_m->fetch_subcats($id);

                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['updType'] = 'edit';

                if ($this->form_validation->run())  //validation has been passed
                {
                        $has_subs = $this->input->post('sub_units');
                        $user = $this->ion_auth->get_user();

                        // build array for the model
                        $form_data = array(
                            'name' => $this->input->post('name'),
                            'code' => $this->input->post('code'),
                            'short_name' => $this->input->post('short_name'),
                            'is_optional' => $this->input->post('is_optional'),
                            'sub_units' => $has_subs,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );

                        $done = $this->subjects_m->update_attributes($id, $form_data);
                        
                        if ($done)
                        {
                                $units = $this->input->post('sub_name');
                                $outs = $this->input->post('out_of');
                                $classes = $this->input->post('class');
                                $terms = $this->input->post('term');
                                if ($has_subs)
                                {
                                        $len = count($units);
                                        if ($len)
                                        {
                                                for ($i = 0; $i < $len; $i++)
                                                {
                                                        if (isset($units[$i]) && isset($outs[$i]))
                                                        {
                                                                $arr = array(
                                                                    'title' => $units[$i],
                                                                    'parent' => $id,
                                                                    'out_of' => $outs[$i],
                                                                    'created_on' => time(),
                                                                    'created_by' => $user->id
                                                                );
                                                                $this->subjects_m->save_units($arr, $units[$i], $id);
                                                        }
                                                }
                                        }
                                }

                                if ($classes && $terms)
                                {
                                        $wlen = count($classes);
                                        if ($wlen)
                                        {
                                                for ($ii = 0; $ii < $wlen; $ii++)
                                                {
                                                        if (isset($classes[$ii]) && isset($terms[$ii]))
                                                        {
                                                                $tlen = count($terms[$ii]);
                                                                if ($tlen)
                                                                {
                                                                        for ($h = 0; $h < $tlen; $h++)
                                                                        {
                                                                                $sbc = array(
                                                                                    'class_id' => $classes[$ii],
                                                                                    'subject_id' => $id,
                                                                                    'term' => $terms[$ii][$h],
                                                                                    'created_on' => time(),
                                                                                    'created_by' => $user->id
                                                                                );
                                                                                $this->subjects_m->save_by_classes($sbc, $classes[$ii], $id, $terms[$ii][$h]);
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                }

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
                                redirect("admin/subjects/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/subjects/");
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

                $data['sub'] = $get;
                $data['id'] = $id;
                //load the view and the layout
                $this->template->title('Edit Sub Units')->build('admin/units', $data);
        }

        /**
         * View Past Question Papers
         *
         * @param type $subject
         */
        /* function past_papers($subject)
          {
          if (!$subject)
          {
          $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
          redirect('admin/subjects/');
          }
          if (!$this->subjects_m->exists($subject))
          {
          $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
          redirect('admin/subjects');
          }
          $get = $this->subjects_m->find($subject);
          $get->subs = $this->subjects_m->fetch_subcats($subject);
          $get->classign = $this->subjects_m->fetch_assigned_classes($subject);
          $papers = $this->subjects_m->fetch_questions($subject);
          $this->pcount = count($papers);
          $data['papers'] = $papers;
          $this->get = $get;
          $data['exams'] = $this->subjects_m->fetch_exam_list();
          $this->template->title('View Question Papers ')->set_layout('subject')->build('admin/questions', $data);
          } */

        /**
         * View Subjects Per Class
         */
        function per_class()
        {
                $pst = FALSE;
                if ($this->input->post())
                {
                        $class = $this->input->post('class');
                        $pst = $this->subjects_m->get_subjects($class);
                }
                $data['pst'] = $pst;
                $data['subjects'] = $this->subjects_m->populate('subjects', 'id', 'name');
                //load view
                $this->template->title('Class Subjects Report')->build('admin/class', $data);
        }

        function quick_add($id)
        {
                if ($this->input->post())
                {
                        $nm = $this->input->post('name');
                        $out = $this->input->post('out_of');
                        $quick = array(
                            'title' => $nm,
                            'parent' => $id,
                            'out_of' => $out,
                            'created_on' => time(),
                            'created_by' => 1
                        );
                      $done =   $this->subjects_m->save_quick($quick);
						
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
						  
						  
                }
                redirect('admin/subjects/units/' . $id);
        }

        function rem_unit($parent, $unit)
        {
                $this->subjects_m->delink($parent, $unit);
                redirect('admin/subjects/units/' . $parent);
        }

        /**
         * View Subject Profile
         *      *
         *
         * @param type $id
         * @param type $page
         */
        function view($id, $page = 1)
        {
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects/');
                }
                if (!$this->subjects_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }
                //search the item to show in edit form
                $get = $this->subjects_m->find($id);
                $get->subs = $this->subjects_m->fetch_subcats($id);
                $get->classign = $this->subjects_m->fetch_assigned_classes($id);
                $papers = $this->subjects_m->fetch_questions($id);
                $this->pcount = count($papers);
                //create control variables
                $data['updType'] = 'edit';
                $data['result'] = $get;
                $this->get = $get;
                //load the view and the layout
                $this->template->title('View Subject ')->set_layout('subject')->build('admin/view', $data);
        }

        /**
         * @param type $subject
         */
        function past_papers($subject)
        {
                if (!$subject)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects/');
                }
                if (!$this->subjects_m->exists($subject))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }
                $get = $this->subjects_m->find($subject);
                $get->subs = $this->subjects_m->fetch_subcats($subject);
                $get->classign = $this->subjects_m->fetch_assigned_classes($subject);
                $papers = $this->subjects_m->fetch_questions($subject);
                $this->pcount = count($papers);
                $data['papers'] = $papers;
                $this->get = $get;
                $data['exams'] = $this->subjects_m->fetch_exam_list();
                $this->template->title('View Question Papers ')->set_layout('viewer')->build('admin/light', $data);
        }

        /**
         * @param $id
         *
         * @return bool
         */
        public function download($id)
        {
                return TRUE;

                if (!$post = $this->files_m->get($id))
                {
                        redirect('');
                }
                if ($post->status != 'live' && !$this->ion_auth->is_admin() || !file_exists('uploads/files/' . $post->document))
                {
                        redirect('');
                }
                //increment downloads count
                $this->files_m->update($id, array('downloads_count' => $post->downloads_count + 1));
                //load download library
                $this->load->helper('download');
                $sz = filesize('uploads/files/' . $post->document);
                header('content-length:' . $sz);
                force_download($post->document, file_get_contents('uploads/files/' . $post->document));
        }

        /**
         * Upload Question Paper
         *
         * @param int $subject
         */
        function upload($subject)
        {
                if (!$subject)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects/');
                }
                if (!$this->subjects_m->exists($subject))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }
                $get = $this->subjects_m->find($subject);
                $get->subs = $this->subjects_m->fetch_subcats($subject);
                $get->classign = $this->subjects_m->fetch_assigned_classes($subject);

                $papers = $this->subjects_m->fetch_questions($subject);
                $this->pcount = count($papers);
                $this->get = $get;
                $data['exams'] = $this->subjects_m->fetch_exam_list();
                $data['sid'] = $subject;
                $this->template->title('Upload Question Papers ')->set_layout('subject')->build('admin/upload', $data);
        }

        /**
         * Process the Upload
         *
         * @param int $id Subject
         */
        public function do_upload($id)
        {
                if (!$this->ion_auth->logged_in())
                {
                        echo 'login';
                }
                else
                {
                        $status = "";
                        $msg = "";
                        $pid = "";
                        $file_element_name = 'filename';
                        $dest = FCPATH . "/uploads/papers/" . date('Y') . '/';
                        if (!is_dir($dest))
                        {
                                mkdir($dest, 0777, true);
                        }
                        if ($status != "error")
                        {
                                $config['upload_path'] = $dest;
                                $config['allowed_types'] = 'jpg|png';
                                $config['max_size'] = 1024 * 8;
                                $config['encrypt_name'] = FALSE;

                                $this->load->library('upload', $config);

                                if (!$this->upload->do_upload($file_element_name))
                                {
                                        $status = 'error';
                                        $msg = $this->upload->display_errors('', '');
                                }
                                else
                                {
                                        $data = $this->upload->data();
                                        $file_id = $this->subjects_m->save_paper(
                                                     array(
                                                         'filename' => $data['file_name'],
                                                         'subject' => $id,
                                                         'filesize' => file_sizer($data['file_size']),
                                                         'fpath' => 'papers/' . date('Y') . '/',
                                                         'created_by' => $this->ion_auth->get_user()->id,
                                                         'created_on' => now()
                                        ));
                                        if ($file_id)
                                        {
                                                $status = "success";
                                                $pid = $file_id;
                                                $msg = "File successfully uploaded";
                                        }
                                        else
                                        {
                                                unlink($data['full_path']);
                                                $status = "error";
                                                $msg = "Something went wrong when saving the file, please try again.";
                                        }
                                }
                                @unlink($_FILES[$file_element_name]);
                        }
                        echo json_encode(array('status' => $status, 'msg' => $msg, 'pid' => $pid));
                }
        }

        /**
         * @param $id
         *
         * @return mixed
         */
        function update_paper($id)
        {
                $fx = array(
                    'exam' => $this->input->post('exam'),
                    'modified_by' => 1,
                    'modified_on' => time()
                );
                return $this->subjects_m->update_paper($id, $fx);
        }

        /**
         * @param null $id
         * @param int $page
         */
        function delete($id = NULL, $page = 1)
        {
                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }

                //search the item to delete
                if (!$this->subjects_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/subjects');
                }

                //delete the item
                if ($this->subjects_m->delete($id) == TRUE)
                {
                       $details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $id, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$id, 
								'details' => $details,   
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

                redirect("admin/subjects/");
        }

        /**
         * Remove Subject From Class
         *
         * @param $id
         *
         * @return bool
         */
        public function remove_class($id)
        {
                $class = $this->input->post('class');
                if (empty($class))
                {
                        return TRUE;
                }
                else
                {
                        $done = $this->subjects_m->remove_class($id, $class);
						
						//$details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $done, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
								'details' => 'Removed',   
								'created_by' => $user -> id,   
								'created_on' => time()
							);

						  $this->ion_auth->create_log($log);
						  
						  
                        return TRUE;
						
                }
        }

        /**
         * Remove Sub From Unit
         *
         * @param $id
         *
         * @return bool
         */
        public function remove_sub($id)
        {
                $rec = $this->input->post('id');
               
                if (empty($rec))
                {
                        return TRUE;
                }
                else
                {
                        $done = $this->subjects_m->remove_sub($id, $rec);
						
						//$details = implode(' , ', $this->input->post());
						$user = $this->ion_auth->get_user();
							$log = array(
								'module' =>  $this->router->fetch_module(), 
								'item_id' => $done, 
								'transaction_type' => $this->router->fetch_method(), 
								'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
								'details' => 'Removed',   
								'created_by' => $user -> id,   
								'created_on' => time()
							);

						  $this->ion_auth->create_log($log);
						  
						  
                        return TRUE;
                }
        }

}
