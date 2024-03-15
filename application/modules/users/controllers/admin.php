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

        $this->load->model('users_m');
    }

    public function index()
    {
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

        $data['page'] = $page;
        $data['groups_list'] = $this->users_m->populate('groups', 'id', 'description');

        //load view
        $this->template->title('System Users')->build('admin/list', $data);
    }

    function random_numbers($length)
    {
        $chars = "1234567890";
        $thepassword = '';
        for ($i = 0; $i < $length; $i++)
        {
            $thepassword .= $chars[rand() % (strlen($chars) - 1)];
        }
        return $thepassword;
    }

    function remove_spaces_on_users_email()
    {
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $limit = 100000;
        $data['page'] = $page;
        $groups_list = $this->users_m->paginate_all($limit, $page);

        $this->load->model('parents/parents_m');
        $i = 0;
        foreach ($groups_list as $p)
        {
            $i++;
            $u_emai = preg_replace('/\s+/', '.', $p->email);
            $u_emai = str_replace("'", '', $u_emai);

            $parent_d = $this->parents_m->get($p->id);

            if ($parent_d)
            {

                $pu = $this->parents_m->update_parent($parent_d->id, array('email' => $u_emai));

                if ($pu)
                {

                    $this->ion_auth->update_user($p->id, array('email' => $u_emai));
                }
            }
        }

        print_r($i);
        die;

        redirect('admin/parents');

        //print_r($groups_list);die;
    }

    function send_credential($grp)
    {
        $this->load->model('sms/sms_m');
        $count = 0;

        $link = base_url();
        $pass = $this->random_numbers(8);

        //**** Send to Parents
        if ($grp == 'parents')
        {

            $parents = $this->portal_m->fetch_user_ids('parents');
			
			//print_r($parents);die;

            foreach ($parents as $p)
            {
                $count++;

                $to = $p->first_name;
                $phone = $p->phone;
                $second_phone = $p->mother_phone;
                $u = $this->ion_auth->get_user($p->user_id);

                $put = $this->ion_auth->update_user($u->id, array('password' => $pass));

                if ($put)
                {

                    if ($u->email == 'admin@admin.com' || $u->email == 'super@admin.com' || $u->email == 'secretary@admin.com')
                    {
                        
                    }
                    else
                    {

                        $email = $u->email;
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            $emai = $this->portal_m->slug(strtolower(trim($u->first_name) . '.' . trim($u->last_name) . '-' . $count));
                            $email = $emai . '@smartshule.com';

                            $this->ion_auth->update_user($u->id, array('email' => $email));
                        }



                        $message = 'Dear ' . ucwords($to) . ', welcome to ' . ucwords(strtolower($this->school->school)) . ' parents portal. Your login credentials are Portal Link: ' . $link . ' Username: ' . $email . ' Password:' . $pass . ' . Kindly ensure you reset your password after logging in.';

                        //print_r($message);die;

                        if ($this->sms_m->send_sms($phone, $message))
                        {

                            $this->sms_m->send_sms($second_phone, $message);

                            $this->portal_m->create_unenc('cre_logs', array('name' => $to, 'phone' => $phone, 'sms' => $message));
                        }
                    }
                }
            }

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Credentials Successfully Sent. </b><span style='color:#fff; '>( Number of Parents Notified " . $count . ')</span>'));
        }

        //**** Send to Teachers
        if ($grp == 'teachers')
        {

            $teachers = $this->portal_m->fetch_user_ids('teachers');
			
			

            foreach ($teachers as $p)
            {
                $count++;
                $to = $p->first_name;
                $phone = $p->phone;
                $u = $this->ion_auth->get_user($p->user_id);

                $put = $this->ion_auth->update_user($u->id, array('password' => $pass));

                if ($put)
                {

                    $message = 'Dear ' . $to . ', welcome to ' . ucwords(strtolower($this->school->school)) . ' teachers portal. Your login credentials are Portal Link: ' . $link . ' Username: ' . $u->email . ' Password:' . $pass . ' . Kindly ensure you reset your password after logging in.';

                    //$this->sms_m->send_sms($phone, $message);
                }
            }

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Credentials Successfully Sent. </b><span style='color:#fff; '>( Number of Teachers Notified " . $count . ')</span>'));
        }

        //**** Send to Students
        if ($grp == 'students')
        {

            $students = $this->portal_m->fetch_user_ids('admission');

            foreach ($students as $p)
            {
                $count++;

                $to = $p->first_name;
                $phone = $p->phone;
                $u = $this->ion_auth->get_user($p->user_id);

                $put = $this->ion_auth->update_user($u->id, array('password' => $pass));

                if ($put)
                {

                    $message = 'Dear ' . ucwords($to) . ', welcome to ' . ucwords(strtolower($this->school->school)) . ' students portal. Your login credentials are Portal Link: ' . $link . ' Username: ' . $u->email . ' Password:' . $pass . ' . Kindly ensure you reset your password after logging in.';

                    //$this->sms_m->send_sms($phone, $message);
                }
            }

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Credentials Successfully Sent. </b><span style='color:#fff; '>( Number of Students Notified " . $count . ')</span>'));
        }

        $this->worker->sms_callback();
        redirect('admin/sms/create');
    }

    public function filtered_users()
    {
        $data['group_id'] = $this->input->post('group_id');
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['page'] = $page;
        $data['groups_list'] = $this->users_m->populate('groups', 'id', 'description');

        //load view
        $this->template->title('System Users')->build('admin/filtered', $data);
    }

    /**
     * Get Datatable
     * 
     */
    public function filter_users($gid)
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->users_m->filter_users($gid, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    function delete_user($id)
    {
        return false;
        if ($id == 1)
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Not Allowed'));
            redirect('admin/users');
        }

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/users/');
        }
        if (!$this->users_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/users');
        }
        $this->users_m->delete_user($id);
    }

    function suspend($id)
    {
        if ($id == 1)
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Not Allowed'));
            redirect('admin/users');
        }

        //redirect if no $id
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/users/');
        }
        if (!$this->users_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/users');
        }
        $user = $this->ion_auth->get_user();
        $form_data = array(
            'active' => 0,
            'modified_by' => $user->id,
            'modified_on' => time()
        );
        if ($this->ion_auth->is_in_group($id, 3))
        {
            $form_t = array(
                'status' => 0,
                'modified_by' => $user->id,
                'modified_on' => time()
            );
            $this->users_m->upd_teacher($id, $form_t);
        }
        //Do update
        $done = $this->users_m->update_attributes($id, $form_data);

        if ($done)
        {
            $details = 'User Suspended';
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

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'User was successfully suspended'));
            redirect("admin/users/");
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

        $output = $this->users_m->get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    //Update user
    function edit($id)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin', 'refresh');
        }
        if (!$this->users_m->exists($id))
        {
            $this->session->set_flashdata('error', lang('web_object_not_exist'));
            redirect('admin/users');
        }

        $the_user = $this->ion_auth->get_user($id);
        $this->data['the_user'] = $the_user;

        $usr_groups = $this->ion_auth->get_users_groups($id)->result();

        $glist = array();
        foreach ($usr_groups as $grp)
        {
            $glist[] = $grp->id;
        }
        $gs = $this->users_m->populate('groups', 'id', 'name');
        $this->data['groups_list'] = $gs;

        $this->data['selected'] = $glist;
        //validate form input
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        //$this->form_validation->set_rules('phone', ' Phone Number', 'required|xss_clean');
        //$this->form_validation->set_rules('phone2', 'Second Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
        //$this->form_validation->set_rules('phone3', 'Third Part of Phone', 'required|xss_clean|min_length[4]|max_length[4]');

        $this->form_validation->set_rules('groups', 'Groups', 'required');
        // $this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
        if ($this->input->post('password'))
        {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        }
        if ($this->form_validation->run() == true)
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $phone = $this->input->post('phone');

            $passport = $the_user->passport;
            if (!empty($_FILES['passport']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('passport');
                $passport = $upload_data['file_name'];
            }

            $additional_data = array(
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'passport' => $passport,
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'modified_by' => $this->ion_auth->get_user()->id,
                'modified_on' => time(),
            );

            if (empty($password))
            {
                unset($additional_data['password']);
            }

            if (empty($phone))
            {
                unset($additional_data['phone']);
            }

            $put = $this->ion_auth->update_user($id, $additional_data);

            $details = 'User details edited';

            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $put,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $put,
                'details' => $details,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $sl = $this->input->post('groups');
            if (count($sl))
            {
                //remove from existing groups
                foreach ($glist as $g_id)
                {
                    if ($g_id == 2)
                    {
                        continue;
                    }
                    $this->ion_auth->remove_from_group($g_id, $id);
                }
                foreach ($sl as $d)
                {
                    if ($d == 1 && !$this->ion_auth->is_in_group($this->user->id, 1))
                    {
                        $this->session->set_flashdata('error', "Only Admin can Add Members to the Admin Group!");
                        redirect("admin/users", 'refresh');
                    }
                    $this->ion_auth->add_to_group($d, $id);
                }
            }

            //redirect them back to the admin page
            $this->session->set_flashdata('message', "User Updated Successfully");
            redirect("admin/users", 'refresh');
        }
        else
        { //display the create user form
            //set the flash data error message if there is one
            //$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['first_name'] = array('name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->input->post('first_name') ? $this->input->post('first_name') : $the_user->first_name,
            );
            $this->data['last_name'] = array('name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->input->post('last_name') ? $this->input->post('last_name') : $the_user->last_name,
            );
            $this->data['phone'] = array('name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->input->post('phone') ? $this->input->post('phone') : $the_user->phone,
            );
            $this->data['email'] = array('name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->input->post('email') ? $this->input->post('email') : $the_user->email,
            );

            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array('name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
            $this->template->title('Update User')->build('admin/edit_user', $this->data);
        }
    }

    //log the user in
    function login()
    {
        $this->template->set_layout('login');
        $this->data['title'] = "Login";

        if ($this->ion_auth->logged_in())
        {
            //already logged in so no need to access this page
            redirect('admin');
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

                $details = 'Account login';
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $user->id,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $user->id,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);

                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                redirect('admin', 'refresh');
            }
            else
            { //if the login was un-successful
                //redirect them back to the login page
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('admin/login', 'refresh'); //use redirects instead of loading views for compatibility with CI_Controller libraries
            }
        }
        else
        {  //the user is not logging in so display the login page
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
                              ->set_partial('metadata', 'partials/metadata.html')
                              ->title('Welcome', 'Login')
                              ->build('admin/login', $this->data);
        }
    }

    //log the user out
    function logout()
    {
        $details = 'Account Logout';
        $user = $this->ion_auth->get_user();
        $log = array(
            'module' => $this->router->fetch_module(),
            'item_id' => 'Account Logout',
            'transaction_type' => $this->router->fetch_method(),
            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/logout',
            'details' => $details,
            'created_by' => $user->id,
            'created_on' => time()
        );

        $this->ion_auth->create_log($log);

        //log the user out
        $this->ion_auth->logout();
        //redirect them back to the page they came from
        redirect('admin/users', 'refresh');
    }

    //change password
    function change_password()
    {
        redirect('admin/change_password');

        $this->form_validation->set_rules('old', 'Old password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login', 'refresh');
        }
        $user = $this->ion_auth->get_user($this->session->userdata('user_id'));

        if ($this->form_validation->run() == false)
        { //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['old_password'] = array('name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array('name' => 'new',
                'id' => 'new',
                'type' => 'password',
            );
            $this->data['new_password_confirm'] = array('name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
            );
            $this->data['user_id'] = array('name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            $this->template
                              ->set_layout('default')
                              ->title('Admin', 'Change Password')
                              ->build('admin/change_password', $this->data);
        }
        else
        {
            $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            { //if the password was successfully changed
                $details = 'Password Change';
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $change,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $change,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                $this->logout();
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('admin/change_password', 'refresh');
            }
        }
    }

    //forgot password
    function forgot_password()
    {
        if ($this->ion_auth->logged_in())
        {
            $this->ion_auth->logout();
            redirect('admin/forgot_password');
        }
        //get the identity type from config and send it when you load the view
        $identity = $this->config->item('identity', 'ion_auth');
        $identity_human = ucwords(str_replace('_', ' ', $identity)); //if someone uses underscores to connect words in the column names
        $this->form_validation->set_rules($identity, $identity_human, 'required');
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
                              ->set_layout('login')
                              ->title('Admin', 'Forgot Password')
                              ->build('admin/forgot_password', $this->data);
        }
        else
        {
            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->input->post($identity));

            if ($forgotten)
            { //if there were no errors
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                redirect('admin/login', 'refresh'); //we should display a confirmation page here instead of the login page
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('admin/forgot_password', 'refresh');
            }
        }
    }

    //reset password - final step for forgotten password
    public function reset_password($code)
    {
        $reset = $this->ion_auth->forgotten_password_complete($code);

        if ($reset)
        {  //if the reset worked then send them to the login page
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
            redirect('admin/login', 'refresh');
        }
        else
        { //if the reset didnt work then send them back to the forgot password page
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
            redirect('admin/users/forgot_password', 'refresh');
        }
    }

    //activate the user
    function activate($id, $code = false)
    {
        //Do update $form_data = array(
        $form = array(
            'active' => 1,
            'modified_by' => $this->user->id,
            'modified_on' => time()
        );
        $this->users_m->update_attributes($id, $form);
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'User Account has been activated'));
        redirect('admin/users', 'refresh');

        /*  if ($code !== false)
          $activation = $this->ion_auth->activate($id, $code);
          else if ($this->ion_auth->is_admin())
          $activation = $this->ion_auth->activate($id);

          if ($activation)
          {
          //redirect them to the auth page
          $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
          redirect('admin/users', 'refresh');
          }
          else
          {
          //redirect them to the forgot password page
          $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
          redirect('admin/users/forgot_password', 'refresh');
          } */
    }

    //deactivate the user
    function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('admin', 'refresh');
        }

        //redirect if its not correct
        if (!$id OR $id == 1)
        {
            $this->session->set_flashdata('error', lang('web_object_not_exist'));
            redirect('admin');
        }
        // no funny business, force to integer
        $id = (int) $id;
        if (!$this->users_m->exists($id))
        {
            $this->session->set_flashdata('error', lang('web_object_not_exist'));
            redirect('admin/users');
        }
        $this->form_validation->set_rules('confirm', 'confirmation', 'required');
        $this->form_validation->set_rules('id', 'user ID', 'required|is_natural');

        if ($this->form_validation->run() == FALSE)
        {

            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->get_user_array($id);

            $this->template
                              ->set_layout('default')
                              ->title('Admin', 'Deactivate User')
                              ->build('admin/deactivate_user', $this->data);
        }
        else
        {

            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes')
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                    redirect('admin/users/', 'refresh');
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
                {
                    $this->ion_auth->deactivate($id);
                }
            }
            //redirect them back to the auth page
            redirect('admin/users', 'refresh');
        }
    }

    //create a new user
    function create()
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin', 'refresh');
        }

        $this->data['groups_list'] = $this->users_m->populate('groups', 'id', 'name');

        //validate form input
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone No.', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

        $this->form_validation->set_rules('groups', 'Groups', 'required');
        //$this->form_validation->set_rules('role', 'User Role', 'required');

        if ($this->form_validation->run() == true)
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $passport = '';
            if (!empty($_FILES['passport']['name']))
            {
                $this->load->library('files_uploader');
                $upload_data = $this->files_uploader->upload('passport');
                $passport = $upload_data['file_name'];
            }

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'passport' => $passport,
                'me' => $this->ion_auth->get_user()->id,
            );
        }
        if ($this->form_validation->run() == true && $u_id = $this->ion_auth->register($username, $password, $email, $additional_data))
        { //check to see if we are creating the user
            $gs = $this->input->post('groups');

            if (isset($gs) && !empty($gs) && count($gs) > 0)
            {
                if ((in_array(1, $gs)) && (in_array(4, $gs)))
                {
                    $this->session->set_flashdata('error', "Not Allowed!");
                    redirect("admin/users", 'refresh');
                }
                if ((in_array(3, $gs)) && (in_array(4, $gs)))
                {
                    $this->session->set_flashdata('error', "Not Allowed! ");
                    redirect("admin/users", 'refresh');
                }
                foreach ($gs as $d)
                {
                    if ($d == 1 && !$this->ion_auth->is_in_group($this->user->id, 1))
                    {
                        $this->session->set_flashdata('error', "Only Admin can Add Members to the Admin Group!");
                        redirect("admin/users", 'refresh');
                    }
                    $this->ion_auth->add_to_group($d, $u_id);
                }
            }

            $details = 'New User created';
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $u_id,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $u_id,
                'details' => $details,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            //redirect them back to the admin page  ('message',
            $this->session->set_flashdata('info', "User Created Successfully");
            redirect('admin/users', 'refresh');
        }
        else
        { //display the create user form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array('name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array('name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['email'] = array('name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            );

            $this->data['phone'] = array('name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );

            $this->data['phone1'] = array('name' => 'phone1',
                'id' => 'phone1',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone1'),
            );
            $roles = array('staff' => 'staff', 'client' => 'client', 'company' => 'company');
            $this->data['role'] = form_dropdown('role', array('' => 'Select role') + $roles, $this->form_validation->set_value('role'), ' class="chzn-select  " id="role_sel" ');

            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array('name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->template
                              ->set_layout('default')
                              ->title('Create User')
                              ->build('admin/create_user', $this->data);
        }
    }

    function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
                          $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function profile($id = 0)
    {
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        $u = $this->ion_auth->get_user($id);
        $id OR $id = $u->id;
        if (!$this->users_m->exists($id))
        {
            $this->session->set_flashdata('error', lang('web_object_not_exist'));
            redirect('admin/users');
        }
        $data['id'] = $id;
        $this->template
                          ->title('User Profile', $u->first_name . ' ' . $u->last_name)
                          ->build('admin/profile', $data);
    }

    function parent_credentials()
    {
        $this->load->model('sms/sms_m');
        $link = base_url();
        $pass = $this->random_numbers(8);
        if($this->input->post())
        {
             
             
             $stds = $this->input->post('students');
             $count = count($stds);
             $k = 0;
             for($i=0; $i<$count; $i++)
             {
                $adm = $this->worker->get_student($stds[$i]);
                $parent = $this->portal_m->get_parent( $adm->parent_id);
             

                $to = $parent->first_name;
                $phone = $parent->phone;
                $second_phone = $parent->mother_phone;
                $u = $this->ion_auth->get_user($parent->user_id);

                $put = $this->ion_auth->update_user($u->id, array('password' => $pass));
                if ($put)
                {

                    if ($u->email == 'admin@admin.com' || $u->email == 'super@admin.com' || $u->email == 'secretary@admin.com')
                    {
                        
                    }
                    else
                    {

                        $email = $u->email;
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            $emai = $this->portal_m->slug(strtolower(trim($u->first_name) . '.' . trim($u->last_name) . '-' . $count));
                            $email = $emai . '@smartshule.com';

                            $this->ion_auth->update_user($u->id, array('email' => $email));
                        }



                        $message = 'Dear ' . ucwords($to) . ', welcome to ' . ucwords(strtolower($this->school->school)) . ' parents portal. Your login credentials are Portal Link: ' . $link . ' Username: ' . $email . ' Password:' . $pass . ' . Kindly ensure you reset your password after logging in.';

                        //print_r($message);die;

                        if ($this->sms_m->send_sms($phone, $message))
                        {
                            $k++;

                            $this->sms_m->send_sms($second_phone, $message);

                            $this->portal_m->create_unenc('cre_logs', array('name' => $to, 'phone' => $phone, 'sms' => $message));
                        }
                    }
                }
             }
             
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => "<b ><i class='glyphicon glyphicon-envelope'></i> Credentials Successfully Sent. </b><span style='color:#fff; '>( Number of Parents Notified " . $k . ')</span>'));
             redirect('admin/users/parent_credentials');
        }
        $data['data'] = [];
        $this->template->title(' Send Logins')->build('admin/parent_credentials', $data);
    }


}
