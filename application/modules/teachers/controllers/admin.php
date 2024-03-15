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

        $this->load->model('teachers_m');
        $this->load->model('sms/sms_m');
    }

    function random($length)
    {
        $chars = "267134859";
        $thepassword = '';
        for ($i = 0; $i < $length; $i++)
        {
            $thepassword .= $chars[rand() % (strlen($chars) - 1) ];
        }
        return $thepassword;
    }

    function send_logins($id)
    {


        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers/');
        }
        if (!$this->teachers_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers');
        }

        $p = $this->teachers_m->find($id);
        $link = base_url();
        $pass = $this->random(8);

        $to = $p->first_name;
        $phone = $p->phone;
        $u = $this->ion_auth->get_user($p->user_id);

        $put = $this->ion_auth->update_user($u->id, array('password' => $pass));

        if ($put)
        {

            $message = 'Dear ' . $to . ', welcome to ' . ucwords(strtolower($this->school->school)) . ' teachers portal. Your login are; Link: ' . $link . ' Username: ' . $u->email . ' Password:' . $pass . ' . Kindly reset password.';

            $this->sms_m->send_sms($phone, $message);

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Login credentials were successfully sent'));
        }

        redirect('admin/teachers/profile/' . $id);
    }

	function email_logins($id){
		
		
		 //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers/');
        }
        if (!$this->teachers_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers');
        }
		
		 $p = $this->teachers_m->find($id);
		 $link = base_url();
		 $pass = $this->random(8);
		 
			$to = $p->first_name;
			$phone = $p->phone;
			$u = $this->ion_auth->get_user($p->user_id);
			
			$put = $this->ion_auth->update_user($u->id, array('password'=>$pass));
			
			if($put){
	
			  $data['to'] = $to;
			  $data['school'] = $this->school->school;
			  $data['link'] = $link;
			  $data['uname'] = $u->email;
			  $data['pass'] = $pass;
			  
				 
			   $this->load->library('email');
		
						$config = array();
						$config['protocol'] = 'mail';
						$config['smtp_host'] = 'mail.gmail.com';
						$config['smtp_user'] = 'smartshule.ke@gmail.com';
						$config['smtp_pass'] = 'Mimisijui$#@!1234';
						$config['smtp_port'] = 25;
						$this->email->initialize($config);
						 $this->email->set_mailtype("html");
						$this->email->set_newline("\r\n");
                       

						$this->email->from('noreply@smartshule.com', ucwords($settings->school));
						$this->email->to($p->email);
						//$this->email->to('evans.ogola22@gmail.com');

						$this->email->subject('Login Credentials');
						

						$message = $this->load->view('admin/logins.tpl.php', $data, TRUE);

						$this->email->message($message,$headers);

						if ($this->email->send())
						{
							$this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Email Was successfully sent'));
							
						}
						else
						{
							$this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Something went wrong please try again later'));
							
						}
			}
			
			 redirect('admin/teachers/profile/'.$id);
	}

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['teachers'] = $this->teachers_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();
        $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
        $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Teaching Staff ')->build('admin/grid', $data);
    }

    public function inactive()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['teachers'] = $this->teachers_m->paginate_inactive($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();
        $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
        $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Teaching Staff ')->build('admin/grid', $data);
    }

    public function get_table_assign()
    {
        $sEcho = $this->input->get_post('sEcho', true);
        $id = $this->input->get('id');
        $output = $this->teachers_m->get_datatable_assign($sEcho, $id);

        echo json_encode($output);
    }

    public function list_view()
    {
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['page'] = $page;
        //load view
        $data['mwalimu']= $this->teachers_m->list_();
        $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
        $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');
        $this->template->title(' Teachers ')->build('admin/list', $data);
    }

    public function filterByStatus(){
        
        $status= $this->input->post('status');
        $data['teacher']=$this->teachers_m->filterbystatus($status);
        $this->template->title(' Teachers ')->build('admin/filter',$data);
       
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;
        $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
        $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $t_username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $temail = $this->input->post('email');

            if (empty($temail))
            {
                $dat = explode(' ', $this->input->post('last_name'));
                $rand = $this->ion_auth->random(3);
                $temail = strtolower($this->input->post('first_name')) . '.' . strtolower($dat[0]) . '' . $rand . '@mtib.ac.ke';
            }
            $tpassword = '12345678'; //temporary password
            $us_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'me' => $this->ion_auth->get_user()->id,
            );
            $tid = $this->ion_auth->register($t_username, $tpassword, $temail, $us_data);
            //add to Teachers group
            if ($tid)
            {
                $this->ion_auth->add_to_group(3, $tid);
            }


            $this->load->library('files_uploader');

            $file = '';
            if (!empty($_FILES['passport']['name']))
            {

                $upload_data = $this->files_uploader->upload('passport');
                $file = $upload_data['file_name'];
            }

            $id_document = '';
            if (!empty($_FILES['id_document']['name']))
            {

                $upload_data = $this->files_uploader->upload('id_document');
                $id_document = $upload_data['file_name'];
            }

            $tsc_letter = '';
            if (!empty($_FILES['tsc_letter']['name']))
            {

                $upload_data = $this->files_uploader->upload('tsc_letter');
                $tsc_letter = $upload_data['file_name'];
            }

            $credential_cert = '';
            if (!empty($_FILES['credential_cert']['name']))
            {

                $upload_data = $this->files_uploader->upload('credential_cert');
                $credential_cert = $upload_data['file_name'];
            }


            $tt_data = array(
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'contract_type' => $this->input->post('contract_type'),
                'marital_status' => $this->input->post('marital_status'),
                'id_no' => $this->input->post('id_no'),
                'status' => 1,
                'passport' => $file,
                'department' => $this->input->post('department'),
                'qualification' => $this->input->post('qualification'),
                'religion' => $this->input->post('religion'),
                'position' => $this->input->post('position'),
                'date_joined' => strtotime($this->input->post('date_joined')),
                'date_left' => strtotime($this->input->post('date_left')),
                'dob' => strtotime($this->input->post('dob')),
                'gender' => $this->input->post('gender'),
                'group_id' => $this->input->post('member_groups'),
                'phone' => $this->input->post('phone'),
                'salary_status' => 0,
                'email' => $temail,
                'pin' => $this->input->post('pin'),
                'address' => $this->input->post('address'),
                'additionals' => $this->input->post('additionals'),
                'tsc_employee' => $this->input->post('tsc_employee'),
                'kuppet_member' => $this->input->post('kuppet_member'),
                'knut_member' => $this->input->post('knut_member'),
                'kuppet_number' => $this->input->post('kuppet_number'),
                'knut_number' => $this->input->post('knut_number'),
                'disability' => $this->input->post('disability'),
                'disability_type' => $this->input->post('disability_type'),
                'phone2' => $this->input->post('phone2'),
                'citizenship' => $this->input->post('citizenship'),
                'county' => $this->input->post('county'),
                'id_document' => $id_document,
                'tsc_letter' => $tsc_letter,
                'credential_cert' => $credential_cert,
                'ref_name' => $this->input->post('ref_name'),
                'ref_phone' => $this->input->post('ref_phone'),
                'ref_email' => $this->input->post('ref_email'),
                'ref_address' => $this->input->post('ref_address'),
                'ref_additionals' => $this->input->post('ref_additionals'),
                'tsc_number' => $this->input->post('tsc_number'),
                'subjects' => $this->input->post('subjects'),
                'user_id' => $tid,
                'status' => $this->input->post('status'),
                'designation' => $this->input->post('position'),
                'created_by' => $user->id,
                'created_on' => time()
            );
            $ok = $this->teachers_m->create($tt_data);

            if ($ok)
            {
                $details = implode(' , ', $this->input->post());
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $ok,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);

                $this->teachers_m->update_teacher($ok, array('staff_no' => $ok));
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/teachers/');
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
            $this->template->title('Add Teachers ')->build('admin/create', $data);
        }
    }

    //Update user
    function edit($id, $page = NULL)
    {
        $this->load->model('users/users_m');

        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers/');
        }
        if (!$this->teachers_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers');
        }

        /**
         * * Details from Teachers Table
         * */
        $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
        $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');

        $get = $this->teachers_m->find($id);

        //print_r($get);die;
        $this->data['result'] = $get;

        //$the_user = $this->ion_auth->get_user($id);
        // $usr_groups = $this->ion_auth->get_users_groups($id)->result();
        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //create control variables
        $data['updType'] = 'edit';
        $data['page'] = $page;

        //validate form input

        if ($this->form_validation->run() == true)
        {
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

            $this->load->library('files_uploader');

            $file = $get->passport;
            if (!empty($_FILES['passport']['name']))
            {

                $upload_data = $this->files_uploader->upload('passport');
                $file = $upload_data['file_name'];
            }

            $id_document = $get->id_document;
            if (!empty($_FILES['id_document']['name']))
            {

                $upload_data = $this->files_uploader->upload('id_document');
                $id_document = $upload_data['file_name'];
            }

            $tsc_letter = $get->tsc_letter;
            if (!empty($_FILES['tsc_letter']['name']))
            {

                $upload_data = $this->files_uploader->upload('tsc_letter');
                $tsc_letter = $upload_data['file_name'];
            }

            $credential_cert = $get->credential_cert;
            if (!empty($_FILES['credential_cert']['name']))
            {

                $upload_data = $this->files_uploader->upload('credential_cert');
                $credential_cert = $upload_data['file_name'];
            }


            // UPDATE TEACHER'S TABLE
            $user = $this->ion_auth->get_user();
            // build array for the model
            $form_data = array(
                'first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'contract_type' => $this->input->post('contract_type'),
                'marital_status' => $this->input->post('marital_status'),
                'id_no' => $this->input->post('id_no'),
                'department' => $this->input->post('department'),
                'qualification' => $this->input->post('qualification'),
                'religion' => $this->input->post('religion'),
                'position' => $this->input->post('position'),
                'date_joined' => strtotime($this->input->post('date_joined')),
                'date_left' => strtotime($this->input->post('date_left')),
                'dob' => strtotime($this->input->post('dob')),
                'gender' => $this->input->post('gender'),
                'group_id' => $this->input->post('member_groups'),
                'phone' => $this->input->post('phone'),
                'salary_status' => 0,
                'email' => $this->input->post('email'),
                'pin' => $this->input->post('pin'),
                'address' => $this->input->post('address'),
                'additionals' => $this->input->post('additionals'),
                'tsc_employee' => $this->input->post('tsc_employee'),
                'kuppet_member' => $this->input->post('kuppet_member'),
                'knut_member' => $this->input->post('knut_member'),
                'disability' => $this->input->post('disability'),
                'disability_type' => $this->input->post('disability_type'),
                'phone2' => $this->input->post('phone2'),
                'citizenship' => $this->input->post('citizenship'),
                'county' => $this->input->post('county'),
                'kuppet_number' => $this->input->post('kuppet_number'),
                'knut_number' => $this->input->post('knut_number'),
                'subjects' => $this->input->post('subjects'),
                'id_document' => $id_document,
                'tsc_letter' => $tsc_letter,
                'passport' => $file,
                'credential_cert' => $credential_cert,
                'ref_name' => $this->input->post('ref_name'),
                'ref_phone' => $this->input->post('ref_phone'),
                'ref_email' => $this->input->post('ref_email'),
                'ref_address' => $this->input->post('ref_address'),
                'ref_additionals' => $this->input->post('ref_additionals'),
                'tsc_number' => $this->input->post('tsc_number'),
                //'user_id' => 773,
                'status' => $this->input->post('status'),
                'designation' => $this->input->post('position'),
                'modified_by' => $user->id,
                'modified_on' => time());
            $done = $this->teachers_m->update_teacher($id, $form_data);

            if ($done)
            {
                $details = implode(' , ', $this->input->post());
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $done,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);

                $this->session->set_flashdata('message', "User Updated Successfully");
                redirect("admin/teachers/profile/" . $id);
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/teachers/");
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
        $this->template->title('Edit Teachers ')->build('admin/create', $data);
    }

    function disable($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers/');
        }
        if (!$this->teachers_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers');
        }

        $done = $this->teachers_m->update_teacher($id, array('status' => 0));

        if ($done)
        {
            //$details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $done,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                'details' => 'disabled',
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
            redirect("admin/teachers/");
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
            redirect("admin/teachers/");
        }
    }

    function enable($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ( $id != 0 ) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ( $page != 0 ) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers/');
        }
        if (!$this->teachers_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers');
        }

        $done = $this->teachers_m->update_teacher($id, array('status' => 1));

        if ($done)
        {
            //$details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $done,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                'details' => 'Enabled',
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
            redirect("admin/teachers/");
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
            redirect("admin/teachers/");
        }
    }

    function profile($id = FALSE)
    {
        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers/');
        }
        if (!$this->teachers_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/teachers');
        }

        $post = $this->teachers_m->find($id);
        $data['post'] = $post;

        //$this->load->model('record_salaries/record_salaries_m');


        $data['group'] = $this->teachers_m->populate('groups', 'id', 'name');
        $data['contracts'] = $this->teachers_m->populate('contracts', 'id', 'name');
        $data['departments'] = $this->teachers_m->populate('departments', 'id', 'name');
        //$data['record_salaries'] = $this->record_salaries_m->staff_salary($id);
        //$data['sickness'] = $this->subordinate_m->staff_sickness($id);
        //$data['staff_study'] = $this->subordinate_m->staff_study($id);
        //$data['staff_compassionate'] = $this->subordinate_m->staff_compassionate($id);
        //$data['staff_others'] = $this->subordinate_m->staff_others($id);
        //$data['staff_annual'] = $this->subordinate_m->staff_annual($id);


        $this->template->title(' Teacher Profile')->build('admin/view', $data);
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

        $output = $this->teachers_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/teachers');
        }

        //search the item to delete
        if (!$this->teachers_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/teachers');
        }

        //delete the item
        if ($this->teachers_m->delete($id) == TRUE)
        {
            //$details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $id,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
                'details' => 'Record Deleted',
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/teachers/");
    }

    function _valid_sid()
    {
        $ml = $this->input->post('email');
        if (!$this->teachers_m->exists_email($ml))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_valid_sid', 'Email Already Exists.');
            return FALSE;
        }
    }

    private function validation()
    {

        $config = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'middle_name',
                'label' => 'Middle Name',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'gender',
                'label' => 'Gender',
                'rules' => 'trim'),
            array(
                'field' => 'date_left',
                'label' => 'Date of Leaving',
                'rules' => 'trim'),
            array(
                'field' => 'tsc_number',
                'label' => 'TSC Number',
                'rules' => 'trim'),
            array(
                'field' => 'kuppet_number',
                'label' => 'KUPPET Number',
                'rules' => 'trim'),
            array(
                'field' => 'knut_number',
                'label' => 'KNUT Number',
                'rules' => 'trim'),
            array(
                'field' => 'citizenship',
                'label' => 'Citizenship',
                'rules' => 'trim'),
            array(
                'field' => 'county',
                'label' => 'County',
                'rules' => 'trim'),
            array(
                'field' => 'date_joined',
                'label' => 'Date Joined',
                'rules' => 'trim'),
            array(
                'field' => 'contract_type',
                'label' => 'Contract Type',
                'rules' => 'trim'),
            array(
                'field' => 'marital_status',
                'label' => 'marital status',
                'rules' => 'trim'),
            array(
                'field' => 'dob',
                'label' => 'Date of Birth',
                'rules' => 'trim'),
            array(
                'field' => 'pin',
                'label' => 'PIN',
                'rules' => 'trim'),
            array(
                'field' => 'phone2',
                'label' => 'Phone2',
                'rules' => 'trim'),
            array(
                'field' => 'religion',
                'label' => 'Religion',
                'rules' => 'trim'),
            array(
                'field' => 'id_no',
                'label' => 'ID No',
                'rules' => 'trim'),
            array(
                'field' => 'disability',
                'label' => 'disabled',
                'rules' => 'trim'),
            array(
                'field' => 'disability_type',
                'label' => 'disability type',
                'rules' => 'trim'),
            array(
                'field' => 'kuppet_member',
                'label' => 'KUPPET member',
                'rules' => 'trim'),
            array(
                'field' => 'subjects',
                'label' => 'Subjects',
                'rules' => 'trim'),
            array(
                'field' => 'knut_member',
                'label' => 'KNUT member',
                'rules' => 'trim'),
            array(
                'field' => 'qualification',
                'label' => 'qualification',
                'rules' => 'trim'),
            array(
                'field' => 'position',
                'label' => 'position',
                'rules' => 'trim'),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'trim'),
            array(
                'field' => 'phone',
                'label' => 'Phone',
                'rules' => 'trim'),
            array(
                'field' => 'department',
                'label' => 'department',
                'rules' => 'trim'),
            array(
                'field' => 'tsc_employee',
                'label' => 'tsc_employee',
                'rules' => 'trim'),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|min_length[0]|max_length[60]'),
            array(
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
            array(
                'field' => 'additionals',
                'label' => 'Additionals',
                'rules' => 'trim|min_length[0]|max_length[500]'),
            array(
                'field' => 'ref_name',
                'label' => 'Name',
                'rules' => 'trim'),
            array(
                'field' => 'ref_phone',
                'label' => 'Name',
                'rules' => 'trim'),
            array(
                'field' => 'ref_email',
                'label' => 'Email',
                'rules' => 'trim|valid_email'),
            array(
                'field' => 'ref_address',
                'label' => 'Address',
                'rules' => 'trim'),
            array(
                'field' => 'ref_additionals',
                'label' => 'Additional Details',
                'rules' => 'trim'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    public function assign()
    {
        $data['teachers'] = $this->teachers_m->list_teachers();
        $data['subjects'] = $this->teachers_m->populate('subjects', 'id', 'name');
        $data['cbc'] = $this->teachers_m->populate('cbc_subjects', 'id', 'name');
        $class = 0;
        $teacher = 0;
        if ($this->input->post())
        {
            $teacher = $this->input->post('teacher');
            $class = $this->input->post('class');
            $mode = $this->input->post('mode');
            if ($teacher)
            {
                $data['assigned'] = $this->teachers_m->make_assigned($teacher, $class, $mode);
            }
        }
        else if ($this->session->flashdata('fill'))
        {
            $fill = $this->session->flashdata('form');
            $teacher = $fill['teacher'];
            $data['assigned'] = $this->teachers_m->make_assigned($fill['teacher'], $fill['class'], $fill['type']);
        }

        $data['teacher'] = $teacher ? $this->teachers_m->find($teacher) : 0;
        $data['class'] = $class ? $this->portal_m->fetch_class($class) : 0;
        //load view
        $this->template->title(' Assign Classes ')->build('admin/assign', $data);
    }

    function assign_teacher($teacher, $class, $mode = 0)
    {
        if ($this->input->post())
        {
            $ids = $this->input->post('set');
            $ps = $this->input->post('post');

            $assigned = $this->teachers_m->get_teacher_classes($teacher, $class, $mode);

            $sett = [];
            $posted = [];
            foreach ($assigned as $ss)
            {
                $sett[] = $ss->subject;
            }

            if ($this->input->post('set') && $ps)
            {
                foreach ($ids as $k => $v)
                {
                    $posted[] = $k;
                }
            }

            $remove = [];
            if (!$this->input->post('set') && $ps)
            {
                $remove = $sett;//remove all set
            }

            foreach ($sett as $n)
            {
                if (!in_array($n, $posted))
                {
                    $remove[] = $n;
                }
            }
            $toadd = [];
            foreach ($posted as $n)
            {
                if (!in_array($n, $sett))
                {
                    $toadd[] = $n;
                }
            }

            foreach ($toadd as $s)
            {
                $form = [
                    'teacher' => $teacher,
                    'class' => $class,
                    'subject' => $s,
                    'type' => $mode,
                    'created_by' => $this->user->id,
                    'created_on' => time()
                ];

                $this->teachers_m->assign($form);
            }

            foreach ($remove as $del)
            {
                $this->teachers_m->remove_assigned($teacher, $class, $del, $mode);
            }
            $this->session->set_flashdata('message', ['type' => 'success', 'text' => 'Successfully Assigned']);
        }
        $this->session->set_flashdata('fill', 2);
        $this->session->set_flashdata('form', [
            'teacher' => $teacher,
            'class' => $class,
            'type' => $mode]);

        redirect('admin/teachers/assign');
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/teachers/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 100000000;
        $config['total_rows'] = $this->teachers_m->count();
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

    public function allocation_report(){
       $data['reports']= $this->teachers_m->get_allocation_report();
       $data['classes']=$this->teachers_m->allocated_classes();
       $data['teachers']=$this->teachers_m->getTeachers();
       $data['subjects']=$this->teachers_m->getSubjects();
       $this->template->title(' Assigned Classes ')->build('admin/report', $data);
    }

    public function filter_alocation(){
        $class= $this->input->post('class');
        $data['reports'] = $this->teachers_m-> filter_allocation_by_class($class);
        $this->template->title(' Assigned Classes ')->build('admin/filtered_allocation', $data);
    }

}
