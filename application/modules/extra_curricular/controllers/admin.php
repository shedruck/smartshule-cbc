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
                $this->load->model('extra_curricular_m');
                $valid = $this->portal_m->get_class_ids();
                if ($this->input->get('cc'))
                {
                        $pop = $this->input->get('cc');
                        //limit to available classes only
                        if (!in_array($pop, $valid))
                        {
                                $pop = $valid[0];
                        }
                        $this->session->set_userdata('cc', $pop);
                }
                else if ($this->session->userdata('cc'))
                {
                        $pop = $this->session->userdata('cc');
                }
                if ($this->input->get('fw'))
                {
                        $pfp = $this->input->get('fw');
                        //limit to available classes only
                        if (!in_array($pfp, $valid))
                        {
                                $pfp = $valid[0];
                        }
                        $this->session->set_userdata('act', $pfp);
                }
                else if ($this->session->userdata('act'))
                {
                        $pfp = $this->session->userdata('act');
                }
        }
		
		function view_students($id,$page=NULL){
			//get the $id and sanitize
                $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/extra_curricular/');
                }
               
				
				$data['post'] = $this->extra_curricular_m->by_activity($id);
				
				$this->template->title(' Extra Curricular ')->build('admin/by_activity', $data);
		}
		
		 function delete($id = NULL, $page = 1)
        {
                //filter & Sanitize $id
                $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/extra_curricular');
                }

                //delete the item
                if ($this->extra_curricular_m->delete($id) == TRUE)
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

                redirect("admin/extra_curricular/");
        }

        /**
         * Manage Activities
         * 
         */
        function remove()
        {
                $show = FALSE;
                $show_iv = FALSE;
                $sids = $this->input->post('student');
                $activity = $this->input->post('activity');
                if ($this->input->post('extras'))
                {
                        if ($sids && !empty($sids))
                        {
                                $fsids = explode(',', $sids);
                                $fxs = array();

                                foreach ($fsids as $ff)
                                {
                                        $fxs[] = $this->extra_curricular_m->get_student_activities($ff, $activity);
                                }
                                $data['mine'] = $fxs;
                                $show = TRUE;
                        }
                }

                $data['show'] = $show;
                $data['iv'] = $show_iv;
                $data['list'] = $this->extra_curricular_m->populate('activities', 'id', 'name');
                $this->template->title('Manage Activities')->build('admin/remove', $data);
        }

        /**
         * Return List of Students in Posted Class
         */
        function get_class_targets()
        {
                $class = $this->input->post('class');
                $list = $this->extra_curricular_m->fetch_full_students($class);
                echo json_encode($list);
        }

        /**
         * Remove Assigned Activity
         *
         */
        function remove_act()
        {
                $id = $this->input->post('id');
                $stud = $this->input->post('rec');

                if ($id && $stud)
                {
                        //Remove Amount
                       $done =  $this->extra_curricular_m->remove_activity($id);
						
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
        }

        /**
         * Get Datatable
         * 
         */
        public function get_table()
        {
                $iDisplayStart = $this->input->get_post('iDisplayStart', true);
                $iDisplayLength = $this->input->get_post('iDisplayLength', true);
                $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
                $iSortingCols = $this->input->get_post('iSortingCols', true);
                $sSearch = $this->input->get_post('sSearch', true);
                $sEcho = $this->input->get_post('sEcho', true);
                $output = $this->extra_curricular_m->list_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

                echo json_encode($output);
        }

        public function index()
        {
                $term = get_term(date('m'));
                $year = date('Y');
                $current = array();
                $final = array();
                $extras = $this->extra_curricular_m->get_current($term, $year);
                foreach ($extras as $e)
                {
                        $current[$e->activity][] = $e;
                }
                foreach ($current as $act_id => $sids)
                {
                        $act = $this->extra_curricular_m->get_activity($act_id);
                        //$tt = $this->ion_auth->get_user($act->teacher);

                        $final[] = array('id' => $act_id, 'title' => $act->name, 'count' => count($sids), 'teacher' => ' - ');
                }

                $data['extras'] = $final;
                $this->template->title(' Extra Curricular ')->build('admin/list', $data);
        }

        /**
         * Extract Parent Contacts
         * 
         * @param int $id Activity Id
         */
        public function contacts($id)
        {
                $term = get_term(date('m'));
                $year = date('Y');
                $activity = $this->extra_curricular_m->get_activity($id);
                $extras = $this->extra_curricular_m->get_current($term, $year, $id);

                $emails = array();
                $phones = array();

                foreach ($extras as $e)
                {
                        $pr = $this->extra_curricular_m->get_parent($e->student);
                        if (empty($pr))
                        {
                                continue;
                        }
                        foreach ($pr as $p)
                        {
                                $row = $this->portal_m->get_parent($p->parent_id);
                                $user = $this->ion_auth->get_user($row->user_id);

                                $emails[] = $user->email;
                                $nm = 'x254' . $row->phone;
                                $fnum = str_replace('x2540', 254, $nm);
                                $phones[] = $fnum;
                        }
                }

                file_put_contents('uploads/files/' . $activity->name . '.txt', implode(",\n ", $emails));
                file_put_contents('uploads/files/' . $activity->name . '.txt', "***************\n Phone Nos. \n***************", FILE_APPEND);
                file_put_contents('uploads/files/' . $activity->name . '.txt', implode(",\n ", array_unique($phones)), FILE_APPEND);

                //load download library
                $this->load->helper('download');
                $sz = filesize('uploads/files/' . $activity->name . '.txt');
                header('content-length:' . $sz);
                force_download($activity->name . '_emails.txt', file_get_contents('uploads/files/' . $activity->name . '.txt'));
        }

        function create($page = NULL)
        {
                //create control variables
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                //Rules for validation
                $this->form_validation->set_rules($this->_ac_validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();
                        $students = $this->input->post('sids');
                        foreach ($students as $st)
                        {
                                $form_data = array(
                                    'student' => $st,
                                    'activity' => $this->input->post('activity'),
                                    'term' => $this->input->post('term'),
                                    'year' => $this->input->post('year'),
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $ok = $this->extra_curricular_m->create($form_data);
								
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
								  
								  
                        }

                        if ($ok)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                        }

                        redirect('admin/extra_curricular/');
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->_ac_validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }

                        $data['result'] = $get;
                        $data['activity'] = $this->extra_curricular_m->populate('activities', 'id', 'name');
                        $range = range(date('Y') - 1, date('Y') + 1);
                        $data['yrs'] = array_combine($range, $range);
                        $this->template->title('Extra Curricular ')->build('admin/create', $data);
                }
        }

        /**
         * Validation For activities
         * 
         */
        private function _ac_validation()
        {
                $config = array(
                    array(
                        'field' => 'sids',
                        'label' => 'Student List',
                        'rules' => 'xss_clean|callback__valid_sid'),
                    array(
                        'field' => 'activity',
                        'label' => 'Activity',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'year',
                        'label' => 'Fee Year',
                        'rules' => 'required|xss_clean'),
                    array(
                        'field' => 'term',
                        'label' => 'Fee Term',
                        'rules' => 'required|xss_clean')
                );
                $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
                return $config;
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

        private function set_paginate_options()
        {
                $config = array();
                $config['base_url'] = site_url() . 'admin/extra_curricular/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100000000000;
                $config['total_rows'] = $this->extra_curricular_m->count();
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

                return $config;
        }

}
