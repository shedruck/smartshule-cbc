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

                $this->load->model('sms_m');
 
                $this->load->model('email_templates/email_templates_m');
                $this->load->library('pmailer');
                $this->load->library('image_cache');
        }
		
		  function test()
        {
                $recipient = '0721341214';
                $message = 'Hello Martin, Thanks for Choosing Us';
                $this->sms_m->send_sms($recipient, $message);
        }
		
		function another_parent_sms(){
			 $initial = isset($this->school->message_initial) && !empty($this->school->message_initial) ? $this->school->message_initial : 'Hi';
			 $members = $this->ion_auth->get_parent();
             $t = 0;
             $i = 1;
				foreach ($members as $member)
				{
					
						$recipient = $member->mother_phone;
						$description = "
						This is to inform you that our 2015 Pre-unit class will be graduating on Wed, 18th Nov 2015 as from 2PM in Tudor School. The Kindergarten pupils should be dropped to school at 12 Noon by their parents. As for primary pupils they will report to school as usual (7AM) and leave at 12:30PM. Those on transport shall be picked and dropped. All parents are invited. We appreciate your continued support.
						";
						
						$to = $member->first_name;
						$message = $initial . ' ' . $to . ','.$description;
						
						if(empty($recipient) || $recipient=='N/A'){
 						}
						
						else{
							$t +=$i;
							$this->sms_m->send_sms($recipient, $message);
						}
					 
					   // $from = "SMARTSHULE";
						//$this->sms_m->send_sms($new_number, $message, $from);
						
				}
				
				 $form_data = array(
                                    'recipient' => 'Mother Parents',
                                    'description' => $description,
                                    'type' => 2,
                                    'status' => 'sent',
                                    'created_by' =>1,
                                    'created_on' => time()
                                );
								
					$this->sms_m->create($form_data);
				//print_r($t.'<br>'.$description);die;
		}

        public function index()
        {
                redirect('admin/sms/create');
                //set the title of the page
                $data['title'] = 'Sms List';

                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);

                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //number page variable
                $data['page'] = $page;

                //load view
                $this->template->title('All Sms ')->build('admin/create', $data);
        }

        //Send Email General Function

        function create($page = NULL)
        {
                //create control variables
                $data['title'] = 'Create sms';
                $data['updType'] = 'create';
                $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

                $initial = isset($this->school->message_initial) && !empty($this->school->message_initial) ? $this->school->message_initial : 'Hi';
                ///LIST ALL Sms
                $data['title'] = 'Sms List';

                $config = $this->set_paginate_options();
                //Initialize the pagination class
                $this->pagination->initialize($config);
                 $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

                //find all the categories with paginate and save it in array to past to the view
                $data['sms'] = $this->sms_m->paginate_all($config['per_page'], $page);

                //create pagination links
                $data['links'] = $this->pagination->create_links();

                //number page variable
                $data['page'] = $page;
                $data['parents'] = $this->sms_m->get_active_parents();
                $data['users'] = $this->sms_m->get_users_phone();
                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //validate the fields of form
                if ($this->form_validation->run())
                {         //Validation OK!
                        $user = $this->ion_auth->get_user();

                        $user_id = $this->input->post('user_id');
                        $type = 0;

                        if ($this->input->post('send_to') == 'All Parents')
                        {
                                $user_id = 'All Parents';
                        }
                        if ($this->input->post('send_to') == 'All Teachers')
                        {
                                $user_id = 'All Teachers';
                        }
                        if ($this->input->post('send_to') == 'All Staff')
                        {
                                $user_id = 'All Staff';
                        }
                        if ($this->input->post('send_to') == 'Staff')
                        {
                                $user_id = $this->input->post('staff');
                                $type = 1;
                        }
                        if ($this->input->post('send_to') == 'Parent')
                        {
                                $user_id = $this->input->post('parent');
                                $type = 2;
                        }

                        //TYPE 1 is staff while TYPE 2 is Parent

                        if ($this->input->post('status') == 'draft')
                        {
                                $form_data = array(
                                    'recipient' => $user_id,
                                    'description' => $this->input->post('description'),
                                    'type' => $type,
                                    'status' => $this->input->post('status'),
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $sms_m = $this->sms_m->create($form_data);
                                redirect('admin/sms');
                        }
                        else
                        {

                                $form_data = array(
                                    'recipient' => $user_id,
                                    'description' => $this->input->post('description'),
                                    'type' => $type,
                                    'status' => 'sent',
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $ok = $this->sms_m->create($form_data);


                                if ($ok) 
                                {
                                        //Send to parents

                                        if ($this->input->post('send_to') == 'All Parents')
                                        {

                                                $members = $this->ion_auth->get_parent();

                                                foreach ($members as $member)
                                                {
                                                        $recipient = $member->phone;
                                                        $country_code = '254';
                                                        $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                                                        $to = $member->first_name;
                                                        $message = $initial . ' ' . $to . ', ' . $this->input->post('description');
														
														if(empty($recipient) || $recipient=='N/A')
                                                                                                                        {
 														}
														
														else{
															$this->sms_m->send_sms($recipient, $message);
														}
                                                     
													   // $from = "SMARTSHULE";
                                                        //$this->sms_m->send_sms($new_number, $message, $from);
														
                                                }
                                        }
                                        elseif ($this->input->post('send_to') == 'All Teachers')
                                        {

                                                $members = $this->ion_auth->get_teacher();

                                                foreach ($members as $member)
                                                {
                                                        $recipient = $member->phone;
                                                        $country_code = '254';
                                                        $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                                                        $to = $member->first_name;
                                                        $message = $initial . ' ' . $to . ', ' . $this->input->post('description');
                                                        //$from = "SMARTSHULE";
                                                        //$this->sms_m->send_sms($new_number, $message, $from);
														 $this->sms_m->send_sms($recipient, $message);
                                                }
                                        }
                                        //Send to all staff
                                        elseif ($this->input->post('send_to') == 'All Staff')
                                        {

                                                $members = $this->ion_auth->get_users();

                                                foreach ($members as $member)
                                                {
                                                        $recipient = $member->phone;
                                                        $country_code = '254';
                                                        $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                                                        $to = $member->first_name;
                                                        $message = $initial . ' ' . $to . ', ' . $this->input->post('description');
                                                       // $from = "SMARTSHULE";
                                                        //$this->sms_m->send_sms($new_number, $message, $from);
														 $this->sms_m->send_sms($recipient, $message);
                                                }
                                        }
                                        elseif ($this->input->post('send_to') == 'Staff')
                                        {

                                                $member = $this->ion_auth->get_user($this->input->post('staff'));

                                                $recipient = $member->phone;
                                                $country_code = '254';
                                                $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                                                $to = $member->first_name;
                                                $message = $initial . ' ' . $to . ', ' . $this->input->post('description');
                                                //$from = "SMARTSHULE";
                                                //$this->sms_m->send_sms($new_number, $message, $from);
												 $this->sms_m->send_sms($recipient, $message);
                                        }
                                        elseif ($this->input->post('send_to') == 'Parent')
                                        {

                                                $member = $this->ion_auth->get_single_parent($this->input->post('parent'));

                                                $recipient = $member->phone;
                                                $country_code = '254';
                                                $new_number = substr_replace($recipient, '+' . $country_code, 0, ($recipient[0] == '0'));

                                                $to = $member->first_name;
                                                $message = $initial . ' ' . $to . ', ' . $this->input->post('description');
                                                //$from = "SMARTSHULE";

                                               // $this->sms_m->send_sms($new_number, $message, $from); 
											   $this->sms_m->send_sms($recipient, $message);
                                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'SMS Sent Successfully'));
                                        }
                                }
                                else
                                {
                                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_success')));
                                }
                                redirect('admin/sms/');
                        }
                }
                else
                {
                        $get = new StdClass();
                        foreach ($this->validation() as $field)
                        {
                                $get->{$field['field']} = set_value($field['field']);
                        }
                        
                        $data['sms_m'] = $get;
                        $data['inbox'] = $this->sms_m->get_inbox();
                        $data['sent'] = $this->sms_m->get_sent();
                        $data['draft'] = $this->sms_m->get_draft();
                        $data['trash'] = $this->sms_m->get_trash();

                        //load the view and the layout
                        $this->template->title('Compose SMS ')->build('admin/create', $data);
                }
        }

        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms/');
                }
                if (!$this->sms_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/sms');
                }
                //search the item to show in edit form
                $get = $this->sms_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['title'] = lang('web_edit');
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'id' => $id,
                            'user_id' => $this->input->post('user_id'),
                            'cc' => $this->input->post('cc'),
                            'subject' => $this->input->post('subject'),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        //find the item to update
                        $sms_m = $this->sms_m->update_attributes($id, $form_data);

                        
                        if ($sms_m)
                        {
                                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/sms/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $sms_m->errors->full_messages()));
                                redirect("admin/sms/");
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
                $data['sms_m'] = $get;
                //load the view and the layout
                $this->template->title('Edit Sms ')->build('admin/create', $data);
        }

        function delete($id = NULL, $page = 1)
        {

                //redirect if its not correct
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/sms');
                }

                //search the item to delete
                if (!$this->sms_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

                        redirect('admin/sms');
                }

                //delete the item
                if ($this->sms_m->delete($id) == TRUE)
                {
                        $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_delete_success')));
                }
                else
                {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
                }

                redirect("admin/sms/");
        }

        private function validation()
        {
                $config = array(
                    array(
                        'field' => 'user_id',
                        'label' => 'User Id',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'cc',
                        'label' => 'Cc',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'send_to',
                        'label' => 'Send To',
                        'rules' => 'trim|required|xss_clean',
                    ),
                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[255]'),
                    array(
                        'field' => 'description',
                        'label' => 'Description',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
                );
                $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                return $config;
        }

        private function email_validation()
        {
                $config = array(
                    array(
                        'field' => 'parent',
                        'label' => 'Parent',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'staff',
                        'label' => 'Staff',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'cc',
                        'label' => 'Cc',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'status',
                        'label' => 'status',
                        'rules' => 'xss_clean'),
                    array(
                        'field' => 'subject',
                        'label' => 'Subject',
                        'rules' => 'trim|xss_clean|min_length[0]|max_length[255]'),
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
                $config['base_url'] = site_url() . 'admin/sms/index/';
                $config['use_page_numbers'] = TRUE;
                $config['per_page'] = 100;
                $config['total_rows'] = $this->sms_m->count();
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
