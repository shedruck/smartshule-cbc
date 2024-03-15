    <?php

    class Index extends Public_Controller
    {

            public $data;

            function __construct()
            {
                    parent::__construct();
                    $this->template
                                 ->set_layout('default.php')
                                 ->set_partial('meta', 'partials/meta.php')
                                 ->set_partial('header', 'partials/header.php')
                                 ->set_partial('sidebar', 'partials/sidebar.php')
                                 ->set_partial('footer', 'partials/footer.php');

                    $this->load->model('student_portal_m');
                    $this->load->model('school_events/school_events_m');
                    $this->load->model('portal_m');
                    $this->load->library('Guzzle');
                     $this->load->model('mobile_m');

                   $this->load->model('parents/parents_m');
                       $this->load->model('admission/admission_m');
                       $this->load->model('exams/exams_m');
                       $this->load->model('assignments/assignments_m');
                       $this->load->model('sms/sms_m');

                   if ($this->ion_auth->logged_in())
                    {
                           
							
							//*** Teacher ****//
							if ($this->ion_auth->is_in_group($this->user->id, 3))
							{
								  if (!$this->ion_auth->is_in_group($this->user->id, 1))
									{
											redirect('trs');
									}
							}  
							//**** Student ****//
							if ($this->is_student && $this->ion_auth->is_in_group($this->user->id, 8))
							{
								 if (!$this->ion_auth->is_in_group($this->user->id, 1))
									{
											redirect('st');
									}
							}   
							
							
                            //send everyone away from from student portal if they are not students or parents
                            if ((!$this->is_student && !$this->is_parent) && $this->uri->segment(1) != 'fee_payment' && $this->uri->segment(1) != 'switch_account')
                            {
                                    redirect('admin');
                            }
                    }
            }
    		
    	

            public function index()
            {
                    redirect('login');
                    //show frontend
                    /* $this->template
                      ->title('Homepage ')
                      ->build('index/main'); */
            }

            public function my_sms()
            {
                    if (!$this->ion_auth->logged_in())
                    {
                            redirect('login');
                    }
                    $this->load->model('sms/sms_m');
                    $data['sms'] = $this->sms_m->my_sms_new();

                    //load the view and the layout
                    $this->template->title('My Messages ')->set_layout('portal')->build('parents/my_sms', $data);
            }
			


            public function contact($result = NULL)
            {
                    $this->template->title(lang('web_contact'));
                    $this->_set_rules();

                    if ($this->form_validation->run() == FALSE)
                    {
                            $this->template->build('index/contact');
                    }
                    else
                    {
                            $form_data = array(
                                'name' => $this->input->post('name', TRUE),
                                'lastname' => $this->input->post('lastname', TRUE),
                                'email' => $this->input->post('email', TRUE),
                                'phone' => $this->input->post('phone', TRUE),
                                'comments' => $this->input->post('comments', TRUE)
                            );

                            $this->load->library('email');
                            $this->email->from('admin@admin.com', 'Codeigniter');
                            $this->email->to('xx@example.com');

                            $this->email->subject('Contact Form');

                            $message = $this->load->view('index/email/formcontact.tpl.php', $form_data, TRUE);

                            $this->email->message($message);

                            if ($this->email->send())
                            {
                                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_mail_ok')));
                                    redirect('contact');
                            }
                            else
                            {
                                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_mail_ko')));
                                    redirect('contact');
                            }
                    }
            }
 function switch_account()
    {
        if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->ion_auth->remove_from_group([3], $this->user->id);
            $this->ion_auth->add_to_group(11, $this->user->id);
        }
        else if ($this->ion_auth->is_in_group($this->user->id, 11))
        {
            $this->ion_auth->remove_from_group([11], $this->user->id);
            $this->ion_auth->add_to_group(3, $this->user->id);
        }
        else
        {

        }

        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Account Successfully Updated'));
        redirect('admin');
    }

            /**
             * Set rules for form
             * @return void
             */
            private function _set_rules()
            {
                    //validate form input
                    $this->form_validation->set_rules('name', 'lang:web_name', 'required|trim|xss_clean|min_length[2]|max_length[100]');
                    $this->form_validation->set_rules('lastname', 'lang:web_lastname', 'required|trim|xss_clean|min_length[2]|max_length[100]');
                    $this->form_validation->set_rules('email', 'lang:web_email', 'required|trim|valid_email|xss_clean');
                    $this->form_validation->set_rules('phone', 'lang:web_phone', 'required|trim|numeric|xss_clean');
                    $this->form_validation->set_rules('comments', 'lang:web_comments', 'required|trim|xss_clean');

                    $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
            }

            /**
             * My Profile
             */
            function profile()
            {
                    if (!$this->ion_auth->logged_in())
                    {
                            redirect('login');
                    }

                    $user = $this->ion_auth->get_user();
                    $data['streams'] = $this->student_portal_m->populate('class_stream', 'id', 'name');
                    $data['post'] = $this->student_portal_m->fetch($user->admission_number);
                    $this->template->set_layout('portal')
                                 ->title('My Profile', $user->first_name . ' ' . $user->last_name)
                                 ->build('index/profile', $data);
            }

            function update_parent()
            {
				
			 if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }
				
                    $this->load->model('parents/parents_m');
                    //Rules for validation
                    $this->form_validation->set_rules($this->validation());

                    //validate the fields of form
                    if ($this->form_validation->run())
                    {

                            $user = $this->ion_auth->get_user();
                            $u = $this->ion_auth->parent_profile($user->id);
                            $form_data = array(
                                'email' => $this->input->post('email'),
                                'phone' => $this->input->post('phone'),
                                'occupation' => $this->input->post('occupation'),
                                'mother_occupation' => $this->input->post('mother_occupation'),
                                'address' => $this->input->post('address'),
                                'mother_address' => $this->input->post('mother_address'),
                                'mother_email' => $this->input->post('mother_email'),
                                'mother_phone' => $this->input->post('mother_phone'),
                                'modified_on' => time(),
                                'modified_by' => $this->ion_auth->get_user()->id
                            );
                            $ok = $this->parents_m->update_parent($u->id, $form_data);

                            if ($ok)
                            {

                                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));

                                    redirect('parent_profile');
                            }
                            else
                            {
                                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));

                                    redirect('parent_profile');
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
                            //load the view and the layout
                            $this->template->title('Add Uploads ')->build('index/parent_profile', $data);
                    }
            }

            private function validation()
            {
                    $config = array(
                        array(
                            'field' => 'email',
                            'label' => 'email',
                            'rules' => 'required|trim|xss_clean|valid_email'),
                        array(
                            'field' => 'occupation',
                            'label' => 'occupation',
                            'rules' => 'trim|xss_clean'),
                        array(
                            'field' => 'address',
                            'label' => 'address',
                            'rules' => 'trim|xss_clean'),
                        array(
                            'field' => 'mother_address',
                            'label' => 'mother_address',
                            'rules' => 'trim|xss_clean'),
                        array(
                            'field' => 'mother_email',
                            'label' => 'mother_email',
                            'rules' => 'trim|xss_clean|valid_email'),
                        array(
                            'field' => 'mother_phone',
                            'label' => 'mother_phone',
                            'rules' => 'trim|xss_clean'),
                        array(
                            'field' => 'mother_occupation',
                            'label' => 'mother_occupation',
                            'rules' => 'trim|xss_clean'),
                        array(
                            'field' => 'phone',
                            'label' => 'Description',
                            'rules' => 'required|trim'),
                    );
                    $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
                    return $config;
            }

            /**
             * My Profile
             */
            function parent_profile()
            {
                    if (!$this->ion_auth->logged_in())
                    {
                            redirect('login');
                    }


                    $this->template->set_layout('portal')
                                 ->title('My Profile')
                                 ->build('index/parent_profile');
            }

            /**
             * School Calendar
             */
            function calendar()
            {
                    if (!$this->ion_auth->logged_in())
                    {
                            redirect('login');
                    }

                    $user = $this->ion_auth->get_user();
                    $data[''] = '';
                    $this->template->set_layout('portal')
                                 ->title('School Calendar')
                                 ->build('index/calendar', $data);
            }

            /**
             * Login Page
             */
            function login()
            {
				
                     if ($this->ion_auth->logged_in())
                {
                        if ($this->is_parent)
                        { 
					
                                if (!$this->ion_auth->is_in_group($this->user->id, 1))
                                {
									
                                         redirect('account');
                                }
                        }
                        if ($this->ion_auth->is_in_group($this->user->id, 3) && !$this->ion_auth->is_in_group($this->user->id, 1) )
                        {
                                redirect('trs');
                        }
						
						if ($this->ion_auth->is_in_group($this->user->id, 6) && !$this->ion_auth->is_in_group($this->user->id, 1))
                        {
							
                                redirect('account');
                        }
                        if ($this->ion_auth->is_in_group($this->user->id, 8) && !$this->ion_auth->is_in_group($this->user->id, 1))
                        {
                                redirect('st');
                        }
                }
                    //validate form input
                    $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
                    $this->form_validation->set_rules('password', 'Password', 'required');

                    if ($this->form_validation->run() == true)
                    { //check to see if the user is logging in
                            //check for "remember me"
						

                            $remember = (bool) $this->input->post('remember');

                            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
                            { 
							      
									//if the login is successful
                                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                    redirect('account');
                            }
                            else
                            { //if the login was un-successful
                                    //redirect them back to the login page
                                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                                    redirect('login', 'refresh');
                            }
                    }
                    else
                    {  
					
					//the user is not logging in so display the login page
                            //set the flash data error message if there is one
                            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                            $this->data['email'] = array('name' => 'email',
                                'id' => 'username', //class="input-large col-md-10" name="username" id="username"
                                'type' => 'text',
                                'class' => 'input-large col-md-10',
                                'type' => 'text',
                                'value' => $this->form_validation->set_value('email'),
                            );
                            $this->data['password'] = array('name' => 'password',
                                'id' => 'password',
                                'type' => 'password',
                                'class' => 'input-large col-md-10',
                            );


                            $this->template
                                         ->title('Welcome', 'Login')
                                         ->set_layout('login')
                                         ->build('index/login', $this->data);
                    }
            }

            /**
             * User Logout
             * 
             */
            function logout()
            {
                    $this->data['title'] = "Logout";
                    //log the user out
                    $logout = $this->ion_auth->logout();
                    //redirect them back to the page they came from
                    redirect('/', 'refresh');
            }

            function change_password()
            {
                    $this->form_validation->set_rules('old', 'Old password', 'required');
                    $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
                    $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

                    if (!$this->ion_auth->logged_in())
                    {
                            redirect('login', 'refresh');
                    }
                    $user = $this->ion_auth->get_user($this->session->userdata('user_id'));
                    $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');

                    if ($this->form_validation->run() == FALSE)
                    { //display the form
                            //set the flash data error message if there is one
                            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                            $this->data['old_password'] = array('name' => 'old',
                                'id' => 'old',
                                'class' => 'col-md-7 input-lg form-control',
                                'type' => 'password',
                            );
                            $this->data['new_password'] = array('name' => 'new',
                                'id' => 'new',
                                'class' => 'col-md-7 input-lg form-control',
                                'type' => 'password',
                            );
                            $this->data['new_password_confirm'] = array('name' => 'new_confirm',
                                'id' => 'new_confirm',
                                'class' => 'col-md-7 input-lg form-control',
                                'type' => 'password',
                            );
                            $this->data['user_id'] = array('name' => 'user_id',
                                'id' => 'user_id',
                                'type' => 'hidden',
                                'value' => $user->id,
                            );

                            $this->template
                                         ->set_layout('portal')
                                         ->title('Change Password')
                                         ->build('index/change_password', $this->data);
                    }
                    else
                    {
                            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

                            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

                            if ($change)
                            { //if the password was successfully changed
                                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                    $this->logout();
                            }
                            else
                            {
                                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                                    redirect('change_password', 'refresh');
                            }
                    }
            }

            //forgot password
            function forgot_password()
            {
                    //get the identity type from config and send it when you load the view
                    $identity = $this->config->item('identity', 'ion_auth');
                    $identity_human = ucwords(str_replace('_', ' ', $identity)); //if someone uses underscores to connect words in the column names
                    $this->form_validation->set_rules($identity, $identity_human, 'required|valid_email');
                    if ($this->form_validation->run() == false)
                    {
                            //setup the input
                            $this->data[$identity] = array('name' => $identity,
                                'id' => $identity, //changed
                            );
                            //set any errors and display the form
                            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
                            $this->data['identity'] = $identity;
                            $this->data['identity_human'] = $identity_human;
                            $this->template
                                         ->title('Forgot Password')
                                         ->build('index/forgot_password', $this->data);
                    }
                    else
                    {
                            $email = $this->input->post('email');
                            //run the forgotten password method to email an activation code to the user
                            $forgotten_key = $this->ion_auth->forgotten_password($email);

                            if ($forgotten_key)
                            { //if there were no errors
                                    if (!is_online())
                                    {
                                            $this->session->set_flashdata('message', array('type' => 'danger', 'text' => "Unable to send Email"));
                                            redirect('login', 'refresh');
                                    }
                                    /* Email */
                                    $data = array(
                                        'identity' => $email,
                                        'forgotten_password_code' => $forgotten_key,
                                    );
                                    $body = $this->load->view('auth/email/forgot_password.tpl.php', $data, TRUE);

                                    $url = $this->config->item('email_url');
                                    $post = array(
                                        'from' => $this->config->item('no_reply'),
                                        'fromName' => $this->school->school,
                                        'apikey' => $this->config->item('email_key'),
                                        'subject' => 'Forgotten Password Verification',
                                        'to' => $email,
                                        'bodyHtml' => $body,
                                        'isTransactional' => true
                                    );
                                    $this->guzzle->post($url, $post);
                                    /*      End Email */

                                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                    redirect('login', 'refresh'); //we should display a confirmation page here instead of the login page
                            }
                            else
                            {
                                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                                    redirect('forgot_password', 'refresh');
                            }
                    }
            }

            /**
             * reset password
             * 
             * @param string $code
             */
            public function reset_password($code)
            {
                    if (!$code)
                    {
                            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => "Please check your Email for Password Reset Instructions"));
                            redirect('login', 'refresh');
                    }
                    $row = $this->ion_auth->get_user_by_code($code);
                    if (empty($row))
                    {
                            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => "Reset Code has Expired or doesn't Exist"));
                            redirect('login', 'refresh');
                    }

                    $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
                    $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');
                    $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                    if ($this->form_validation->run() == FALSE)
                    {
                            //display the form
                            //set the flash data error message if there is one
                            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                            $this->data['new_password'] = array(
                                'name' => 'new',
                                'id' => 'new',
                                'class' => 'col-md-7 input-lg form-control',
                                'type' => 'password',
                            );
                            $this->data['new_password_confirm'] = array(
                                'name' => 'new_confirm',
                                'id' => 'new_confirm',
                                'class' => 'col-md-7 input-lg form-control',
                                'type' => 'password',
                            );

                            $this->template
                                         ->title('Reset Password')
                                         ->build('index/reset_password', $this->data);
                    }
                    else
                    {
                            $changed = $this->ion_auth->update_password($row->email, $this->input->post('new'));

                            if ($changed)
                            { //if the password was successfully changed
                                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                                    if (!is_online())
                                    {
                                            $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Password has been reset. Unable to send Email"));
                                            redirect('login', 'refresh');
                                    }
                                    /* Email */
                                    $body = "<html>
                                                    <body>
                                                    <h1>Your Password has been Reset Successfully  </h1>
                                                    <p>Please " . anchor('/', 'click here to login') . "</p>
                                                    </body>
                                                </html>";

                                    $url = $this->config->item('email_url');
                                    $post = array(
                                        'from' => $this->config->item('no_reply'),
                                        'fromName' => $this->school->school,
                                        'apikey' => $this->config->item('email_key'),
                                        'subject' => 'Your Password has been Reset',
                                        'to' => $row->email,
                                        'bodyHtml' => $body,
                                        'isTransactional' => true
                                    );
                                    $this->guzzle->post($url, $post);
                                    /*      End Email */
                                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => "Password has been reset"));
                                    redirect('login', 'refresh');
                            }
                            else
                            {
                                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                                    redirect('change_password', 'refresh');
                            }
                    }
            }

            /**
             * My Account (for Logged in User)
             * 
             */
            function account()
            {
                    if (!$this->ion_auth->logged_in())
                    {
                            redirect('login');
                    }

                    if ($this->ion_auth->logged_in())
                    {
                            $data['events'] = $this->portal_m->get_events(1);
                            if ($this->ion_auth->is_in_group($this->user->id, 6))
                            {
								  
								  
								  if($this->parent->status !=1){
									  
									    $this->logout();
										
									   $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Your account has been disabled'));
									   redirect('login');
									   
								  }
                                   
								$data['rec'] = $this->portal_m->get_recs();
								$data['assign'] = $this->assignments_m->list_assignments();
								$data['sms'] = $this->sms_m->my_sms_new();
								 $data['events'] = $this->portal_m->school_events();
								 
								  $this->load->model('fee_structure/fee_structure_m');
			  
			                      $data['banks_acc'] = $this->fee_structure_m->banks();
								 
								$pays = $this->fee_payment_m->payment_options('payment_options','id','account');
			                   $data['payment_options'] = $pays;
								
								//parent
								$this ->template
									  ->title('Parent')
									  ->build('admin/parent', $data);
                            }
                            elseif ($this->ion_auth->is_in_group($this->user->id, 8))
                            {
                                    //stud
                                    $this->template
                                                 ->title('My Account')
                                                 ->build('admin/student', $data);
                            }
                    }
            }
			
		function students(){
			
			   if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }
			
			$data['data'] = '';
				 $this->template
					 ->title('My Children')
					 ->build('index/kids', $data);
					 
			}
			

            function events()
            {
				   if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }
				
                    $data['events'] = $this->portal_m->school_events();

                    $this->template
                                 ->title('Events & Announcements')
                                 ->build('index/events', $data);
            }

            /**
             * View Results
             * 
             */
            function results()
            {
				    if (!$this->ion_auth->logged_in())
                {
                        redirect('login');
                }
                   
				   $data[''] = '';

                    $this->template->set_layout('portal')->title(' View Results')->build('index/results', $data);
            }

            /**
             * Fetch Calendar Events
             * 
             */
            function get_events()
            {
                    $events = $this->student_portal_m->get_events();
                    $event_data = array();

                    foreach ($events as $event)
                    {
                            $user = $this->ion_auth->get_user($event->created_by);
                            $end_date = $event->end_date;

                            if ($end_date < time())
                            {
                                    $event_data[] = array(
                                        'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
                                        'start' => date('d M Y H:i', $event->start_date),
                                        'end' => date('d M Y H:i', $event->end_date),
                                        'venue' => $event->venue,
                                        'event_title' => $event->title,
                                        'cache' => true,
                                        'backgroundColor' => 'black',
                                        'description' => strip_tags($event->description),
                                        'user' => $user->first_name . ' ' . $user->last_name,
                                    );
                            }
                            else
                            {
                                    $event_data[] = array(
                                        'title' => $event->title . ' at ' . $event->venue . ' ( From :' . date('d M Y H:i', $event->start_date) . ' -- To ' . date('d M Y H:i', $event->end_date) . ' ) ',
                                        'start' => date('d M Y H:i', $event->start_date),
                                        'end' => date('d M Y H:i', $event->end_date),
                                        'venue' => $event->venue,
                                        'event_title' => $event->title,
                                        'cache' => true,
                                        'backgroundColor' => $event->color,
                                        'description' => strip_tags($event->description),
                                        'user' => $user->first_name . ' ' . $user->last_name,
                                    );
                            }
                    }

                    echo json_encode($event_data);
            }

            /**
             * Catch 404s
             * 
             */
            function gotcha()
            {
                    /*  if (!$this->ion_auth->logged_in())
                      {
                      $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
                      redirect('login');
                      } */
                    $this->template
                                 ->title('Not Found')
                                 ->set_layout('default')
                                 ->build('admin/error');
            }
            function postsid()
            {
                $this->load->model('admission/admission_m');
                $sid = $_POST["getb"];
                $data = array(
                    'sid'=>$sid,
                    'status'=>"new");
                $rst = $this->admission_m->createsid($data);
                echo "ok";
              //  $try = $this->admission_m->getsidall();
               // print_r($try);die;
            }

            function url_verify()
            {
				
				
    $dset = $this->ion_auth->settings();
    //echo $dset->school;
    $response["school"] = array();
    $fdata = array(
        'name'=>$dset->school,
        'id'=>$dset->id,
        'image'=>$dset->document,
        'address'=>$dset->postal_addr,
        'loc'=>$dset->map,
        'phone'=>$dset->tel,
        'email'=>$dset->email
        );
    array_push($response["school"], $fdata);

    echo json_encode($response);



            }
            function check_model()
            {
               
                $name = $this->mobile_m->getstudent();
                echo $name."ui";
            }
            function mobile_login()
            {
                $uname ="koselamwe@mail.com";//"jarosoja@mail.com";// $_POST["uname"];//
                $pwd ="12345678"; //$_POST["pwd"];//
                $response["rst"] = array();
                $response["table_login"] = array();
                $response["table_parent"] = array();
                $response["table_student"] = array();
                 $response["table_fee"] = array();
                   $response["table_fee_statement"] = array();
                    $response["attendance"] = array();
                    $response["exams"] = array();
               if($this->ion_auth->login($uname, $pwd)) 
               {
                $return_data = array(
                    'content'=>"login",
                    'exist' =>"yes");
                 array_push($response["rst"], $return_data);
                 //getting user data
                 $user = $this->ion_auth->get_user();
                 //print_r($user);die;
                 $table_login = array(
                    'id'=>$user->id,
                    'name'=>$user->first_name." ".$user->last_name,
                    'email'=>$user->email,
                    'pwd'=>$pwd
                    );
                 array_push($response["table_login"], $table_login);

                 if($parent = $this->parents_m->get($user->id))
                 {
                 array_push($response["table_parent"], $parent);

                        $class = $this->ion_auth->list_classes();
                        $stream = $this->ion_auth->get_stream();

                       // $u = $this->ion_auth->get_user($student->created_by);
                      
                 if($children = $this->parents_m->my_children($parent->id))
                 {
                    foreach ($children as $key => $value) {
                        $cl = $this->admission_m->fetch_class($value->class);
                         $cls = isset($class[$cl->class]) ? $class[$cl->class] : ' -';
                            $strm = isset($stream[$cl->stream]) ? $stream[$cl->stream] : ' -';
                           $ima =$this->admission_m->passport($value->photo); 
                        
                        $stu = array(
                            'id'=>$value->id,
                            'fname'=>$value->first_name,
                            'lname'=>$value->last_name,
                            'gender'=>$value->gender,
                            'age'=>date('d/m/Y',$value->dob),
                            'upi'=>$value->upi_number,
                            'sclass'=>$cls . ' ' . $strm,
                            'mclass'=>$value->class,
                            'image'=> $ima->fpath . '' . $ima->filename,
                            'adm'=>$value->admission_number
                            );


                     array_push($response["table_student"], $stu);
                 }
                 }
                 //$exams= array();
            $exa = array();
            $exb = array();
            $exama= $this->mobile_m->get_c_exam();
            if(!empty($exama))
            {
                foreach($exama as $es)
            {
                $exams = array(
                    'id'=>$es->id,
                    'title' => $es->title,
                    'term' => $es->term,
                    'year' => $es->year,
                    'start' => date('d/m/Y',$es->start_date),
                    'end' => date('d/m/Y',$es->end_date),
                    'status' => $es->description,
                    );
            
            array_push($response["exams"],$exams);
            foreach($response["table_student"] as $gh)
            {
                       $student=$gh["id"];  
                        $mine = $this->exams_m->get_report($es->id, $student,$gh["mclass"]);
                        echo json_encode($mine);
               
            }

        }

            }




              //   $arent = $this->portal_m->get_profile($uss);

                                  //  $this->parent->profile = $this->portal_m->get_profile($uss);
                                   // $this->parent->kids = $this->portal_m->get_kids($this->parent->user_id);
                 if($fee = $this->portal_m->get_kids($parent->user_id) )
                 {
                     foreach ($fee as $k)
                     {
                    $sfe = array(
                        'student_id'=>$k->student_id ,
                        'invoice_amt'=>$k->invoice_amt ,
                        'paid'=>$k->paid ,
                        'balance'=>$k->balance ,
                        'fdate'=>date('d/m/Y',$k->created_on) ,
                        'des'=>$k->status ,

                        );
                      array_push($response["table_fee"], $sfe);
                       if($payload = $this->worker->process_statement($k->student_id))
                 {
                    
      $exc = "";
                                                                    $bcg = "";
                                                                    $exw = "";
                                                                    $bw = "";
                                                            
                                                            $dr = "";
                                                            $cr = "";
                                                            $wv = "";
                                                            $bal = "";
                                                            $ibal = "";
     ksort($payload);
                    foreach ($payload as $y => $p){
                            ksort($p);
                        
                            foreach ($p as $term => $trans)
                            {
                 foreach ($trans as $type => $paidd)
                              {
                                 foreach ($paidd as $paid)
                                                        {
                                 $paid = (object) $paid;
                                                            $debit = $type == 'Debit' ? $paid->amount : 0;
                                                            $credit = $type == 'Credit' ? $paid->amount : 0;
                                                            if ($debit)
                                                            {
                                                                    $idw = $paid->date;
                                                            }
                                                            $waiver = $type == 'Waivers' ? $paid->amount : 0;
                                                            $bw = 0;
                                                            $bcg = 0;
                                                            if (isset($paid->ex_type))
                                                            {
                                                                    $wva = $paid->ex_type == 2 ? $paid->amount : 0;
                                                                    $cg = $paid->ex_type == 1 ? $paid->amount : 0;
                                                                    $exc += $cg;
                                                                    $bcg += $cg;
                                                                    $exw += $wva;
                                                                    $bw += $wva;
                                                            }
                                                            $dr += $debit;
                                                            $cr += $credit;
                                                            $wv += $waiver;
                                                            $bal = ($debit + $bcg) - ($credit + $waiver + $bw);
                                                            $ibal += $bal;
                                                            if ($idw)
                                                                        {
                                                                                $wdate = date('d/m/Y', $idw);
                                                                        }
                                                                        else
                                                                        {
                                                                                $wdate = isset($this->terms[$term]) ? $this->terms[$term] : '';
                                                                        }
                                                                        $tdate = $paid->date > 0 ? date('d/m/Y', $paid->date) : $paid->date;
                                           $mess = ucwords($paid->desc);
                                                                    if (is_numeric($mess) && $mess == 0)
                                                                            $mess = 'Tuition Fee Payment';
                                                                    elseif (is_numeric($mess))
                                                                            $mess = isset($extras[$mess]) ? $extras[$mess] : ' - ';
                                                                    $wwv = $paid->desc ? 'Waiver - ' . $paid->desc : 'Fee Waiver';
                                             $fdeb="";
                                             $fcred="";
                                              if ($bcg)
                                                                    {
                                                                           $fdeb= number_format($bcg, 2);
                                                                    }
                                                                    else
                                                                    {
                                                                            $fdeb=number_format($debit, 2);
                                                                    }  
                                          if ($waiver)
                                                                    {
                                                                            $fcred = number_format($waiver, 2);
                                                                    }
                                                                    elseif ($bw)
                                                                    {
                                                                            $fcred = number_format($bw, 2);
                                                                    }
                                                                    else
                                                                    {
                                                                             $fcred = number_format($credit, 2);
                                                                    }                                            
                                 $fedata = array(
                            'year'=>$y,
                            'student_id'=>$k->student_id,
                            'term'=>$this->terms[$term],
                            'date'=> $waiver ? $wdate : $tdate,
                            'refno'=>$paid->refno ? $paid->refno : gen_string(),
                            'des'=> $waiver ? $wwv : rtrim($mess, ' -'),
                            'debit'=>$fdeb,
                            'credit'=>$fcred,
                            'balance'=>number_format($ibal, 2)

                            );
                                 array_push($response["table_fee_statement"], $fedata);
                                 }
                            }
                         }
                     }




                 }

                  if($attendance = $this->mobile_m->getattendance($k->student_id)){
                  foreach ($attendance as $key => $value) {
                    $atte = $this->mobile_m->getext($value->attendance_id);
                     $attdata = array(
                        'student_id'=>$value->student,
                        'date'=>date('d/m/Y',$atte->attendance_date),
                        'for'=>$atte->title,
                        'status'=>$value->status
                        );
                      array_push($response["attendance"], $attdata);
                                 
                  }
              }

                }

                 }


                
                 

             }
                





               }
               else
               {
                 $return_data = array(
                    'content'=>"login",
                    'exist' =>"no");
                 array_push($response["rst"], $return_data);
               }
               echo json_encode($response);
        


            }






    }





     
                                                 