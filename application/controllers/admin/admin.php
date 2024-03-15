<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        if ($this->ion_auth->logged_in())
        {
            //**** Parent ****//
            if ($this->is_parent)
            {
                if (!$this->ion_auth->is_in_group($this->user->id, 1))
                {
                    redirect('account');
                }
            }
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

            $t_g = $this->config->item('transport'); 
            if ($t_g && $this->ion_auth->is_in_group($this->user->id, $t_g))
            {
                redirect('transport');
        }
        }
        $this->load->model('admission/admission_m');
        $this->load->model('assignments/assignments_m');
        $this->load->model('reports/reports_m');
        $this->load->model('add_stock/add_stock_m');
        $this->load->model('expenses/expenses_m');
        $this->load->model('fee_payment/fee_payment_m');
        $this->load->model('fee_waivers/fee_waivers_m');
        $this->load->model('school_events/school_events_m');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        $events = $this->school_events_m->get_all();
        $data['events'] = $events;
        $users = $this->ion_auth->fetch_logged_in();
        $gs = array();
        foreach ($users as $key => $value)
        {
            $upost = new stdClass();
            $upost->user_id = $value;
            $upost->groups = $this->portal_m->get_groups($value);
            $gs[] = $upost;
        }
        $data['users'] = $gs;
        $data['months'] = array('1' => 'Jan', '2' => 'Feb', '3' => 'Mar', '4' => 'Apr', '5' => 'May',
                  '6' => 'Jun', '7' => 'Jul', '8' => 'Aug', '9' => 'Sept', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
        $data['recent_payments'] = $this->fee_payment_m->get_payments();
        $data['total_fees'] = $this->fee_payment_m->full_total_fees();
        $data['total_expenses'] = $this->expenses_m->total_expenses();
        $data['total_waiver'] = $this->fee_waivers_m->total_waiver();
        $data['total_stock'] = $this->add_stock_m->total_stock();
        $data['total_petty_cash'] = $this->expenses_m->total_petty_cash();
        ///Salaries Balances
        $basic = $this->expenses_m->total_basic();
        $allowances = $this->expenses_m->total_allowances();
        $deductions = $this->expenses_m->total_deductions();
        $nhif = $this->expenses_m->total_nhif();
        $total_paid = ($basic->basic + $allowances->allowance + $nhif->nhif + $deductions->total);
        $data['wages'] = $total_paid;
        /**
         * 1-admin
         * 3-teacher
         * 4-hm
         * 6-parents
         * 7-mgr
         * 8-stude
         * 10-dir
         */
        if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            //tc Dashboard
            $data['my_students'] = $this->admission_m->count_my_students();
            $data['assignments'] = $this->assignments_m->get_my();

            $this->template
              ->title('Dashboard')
              ->set_layout('teachers')
              ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
              ->set_partial('teachers_top', 'partials/teachers_top.php')
              ->build('admin/teacher', $data);
        }
        /* Director */
        else if ($this->ion_auth->is_in_group($this->user->id, 10101010))
        {
            $data['reqs'] = $this->expenses_m->get_pending_reqs();
            $this->template
              ->set_layout('dir')
              ->set_partial('dir_sidebar', 'partials/dir_side.php')
              ->title('Dashboard')
              ->build('admin/dir', $data);
        }
        else
        {
            $this->template
              ->title('Dashboard')
              ->build('admin/index', $data);
        }
    }

    function help()
    {
        $data['title'] = 'Manual';
        $this->template
          ->title('Help')
          ->set_layout('help.php')
          ->build('admin/help', $data);
    }

    function fee_statement()
    {
        $this->load->model('fee_payment/fee_payment_m');
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['fee_payment'] = $this->fee_payment_m->get_all();
        //create pagination links
        $data['links'] = $this->pagination->create_links();
        //page number  variable
        $data['page'] = $page;
        $data['bank'] = $this->fee_payment_m->list_banks();
        //load view
        $this->template->title(' Fee Statement ')->build('admin/statement', $data);
    }

    function inventory()
    {
        if ($this->ion_auth->logged_in())
        {
            $this->load->model('add_stock/add_stock_m');
            //find all the categories with paginate and save it in array to past to the view
            $data['add_stock'] = $this->add_stock_m->get_all();
            $data['product'] = $this->add_stock_m->get_products();
            $data['reorder_level'] = $this->add_stock_m->populate('items', 'id', 'reorder_level');
            $this->template->title('School Inventory')->set_layout('default.php')->build('admin/inventory', $data);
        }
    }

    function _aasort(&$array, $key)
    {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va)
        {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va)
        {
            $ret[$ii] = $array[$ii];
        }
        return $ret;
    }

    public function ckeditor()
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        $url = FCPATH . 'assets/uploads/ckeditor/' . time() . "_" . $_FILES['upload']['name'];
        $url_aux = substr($url, strlen(FCPATH) - 1);
        if (($_FILES['upload'] == "none") OR ( empty($_FILES['upload']['name'])))
        {
            $message = "No file uploaded.";
        }
        else if (file_exists(FCPATH . 'assets/uploads/ckeditor/' . $_FILES['upload']['name']))
        {
            $message = "File already exists";
        }
        else if ($_FILES['upload']["size"] == 0)
        {
            $message = "The file is of zero length.";
        }
        else if (($_FILES['upload']["type"] != "image/jpeg") AND ( $_FILES['upload']["type"] != "image/jpeg") AND ( $_FILES['upload']["type"] != "image/png"))
        {
            $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
        }
        else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
        {
            $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
        }
        else
        {
            $message = "Image uploaded correctly";
            move_uploaded_file($_FILES['upload']['tmp_name'], $url);
        }
        $funcNum = $_GET['CKEditorFuncNum'];
        $url = $url_aux;
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }

    //log the user in
    function login()
    {
        $this->load->model('settings/settings_m');
        $this->data['settings'] = $this->settings_m->fetch();
        $this->template->set_layout('login');
        $this->data['title'] = "Login";
        if ($this->ion_auth->logged_in())
        {
            //already logged in so no need to access this page
            redirect('admin');
        }
        //validate form input
        // print_r($this->settings_m->fetch());
        //  die();
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == true)
        { //check to see if the user is logging in
            //check for "remember me"
            $remember = (bool) $this->input->post('remember');

            $uname = $this->input->post('email');

            if (is_numeric($uname))
            {

                $u = $this->ion_auth->user_by_phone($uname);

                if (!empty($u))
                {
                    $uname = $u->email;
                }
                else
                {
                    $uname = $uname;
                }


                //print_r($uname.' - '.$u->email);die;
            }

            if ($this->ion_auth->login($uname, $this->input->post('password'), $remember))
            { //if the login is successful
                //redirect them back to the home page
                $details = 'Account login';
                $user = $this->ion_auth->get_user();
                $gp = $this->ion_auth->get_users_groups($user->id)->row();
                $this->acl->cp_event('login', ['page' => 'Backend', 'group' => ucwords($gp->name)]);
                $log = array(
                          'module' => $this->router->fetch_module(),
                          'item_id' => 'Account Login',
                          'transaction_type' => $this->router->fetch_method(),
                          'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $user->id,
                          'details' => $details,
                          'created_by' => $user->id,
                          'created_on' => time()
                );

                $this->ion_auth->create_log($log);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $this->ion_auth->messages()));
                redirect('admin', 'refresh');
            }
            else
            {
                //if the login was un-successful
                $this->acl->cp_event('failed_login', ['page' => 'Backend']);
                //redirect them back to the login page
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $this->ion_auth->errors()));
                redirect('admin/login', 'refresh');
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
              //->set_partial('metadata', 'partials/metadata.html')
              ->set_layout('login')
              ->title('Welcome', 'Login')
              ->build('admin/login', $this->data);
        }
    }

    /**
     * log the user out
     */
    function logout()
    {

        $details = 'Account logout';
        $user = $this->ion_auth->get_user();
        $log = array(
                  'module' => $this->router->fetch_module(),
                  'item_id' => 'Account Logout',
                  'transaction_type' => $this->router->fetch_method(),
                  'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $user->id,
                  'details' => $details,
                  'created_by' => $user->id,
                  'created_on' => time()
        );

        $this->ion_auth->create_log($log);

        $this->ion_auth->logout();
        //redirect them back to the page they came from
        redirect('admin/users', 'refresh');
    }

    //change password
    function change_password()
    {
        $this->form_validation->set_rules('old', 'Old password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login', 'refresh');
        }
        $user = $this->ion_auth->get_user($this->session->userdata('user_id'));
        $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
        if ($this->form_validation->run() == FALSE)
        { //display the form
            //set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['old_password'] = array('name' => 'old',
                      'id' => 'old',
                      'class' => 'col-md-7',
                      'type' => 'password',
            );
            $this->data['new_password'] = array('name' => 'new',
                      'id' => 'new',
                      'class' => 'col-md-7',
                      'type' => 'password',
            );
            $this->data['new_password_confirm'] = array('name' => 'new_confirm',
                      'id' => 'new_confirm',
                      'class' => 'col-md-7',
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
    function update_password()
    {

        $this->form_validation->set_rules('identity', 'Phone or Email', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('message', 'ensure you enter phone or email');
            redirect("login", 'refresh');
        }
        else
        {

            $item_type = $this->input->post('identity');

            if (is_numeric($item_type))
            {
                $input_type = "phone";
            }
            else
            {
                $input_type = "email";
            }


            $identity = $this->ion_auth->similar($input_type, $item_type);

            if (empty($identity))
            {
                $this->session->set_flashdata('message', 'Sorry that user does not exist!!');
                redirect("admin/login", 'refresh');
            }

            $password = $this->ion_auth->ref_no(8);

            $change = $this->ion_auth->reset_password($identity->id, $password);

            if ($change)
            {


                $this->load->model('sms/sms_m');
                $sms = 'Dear ' . $identity->first_name . ', your password was changed to ' . $password . ' kindly login and change';
                // print_r($identity);die;
                $this->sms_m->send_sms($identity->phone, $sms);
                //SEND EMAIL



                $this->load->library('email');

                $this->email->from('noreply@dsms.com', 'Digital School Management System');
                $this->email->to($identity->email);

                $this->email->subject('Password Change');

                $form_data = array(
                          'id' => $identity->id,
                          'first_name' => $identity->first_name,
                          'last_name' => $identity->last_name,
                          'password' => $password,
                );

                $message = $this->load->view('auth/email/forgot_password.tpl.php', $form_data, TRUE);

                $this->email->message($message);

                if ($this->email->send())
                {
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Your password was changed and has been sent to  both your phone number and email'));
                    redirect("admin/login", 'refresh');
                }
                else
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Something went wrong could send email'));
                    redirect("forgot_password", 'refresh');
                }

                redirect("admin/login", 'refresh');
            }
            else
            {

                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Sorry that user is does not exist!!'));

                redirect("admin/login", 'refresh');
            }

            $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Your password was changed and has been sent to  both your phone number and email'));

            redirect("admin/login", 'refresh');
        }
    }

    //forgot password
    function forgot_password_old()
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
              ->set_layout('login')
              ->title('Admin', 'Forgot Password')
              ->build('admin/forgot_password', $this->data);
        }
        else
        {
            //run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));
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
            redirect('admin/forgot_password', 'refresh');
        }
    }

    //activate the user
    function activate($id, $code = false)
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        if ($code !== false)
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
            redirect('admin/forgot_password', 'refresh');
        }
    }

    //deactivate the user
    function deactivate($id = NULL)
    {
        $id or redirect('admin');
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        // no funny business, force to integer
        $id = (int) $id;
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
              ->build('admin/forgot_password', $this->data);
        }
        else
        {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes')
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
                {
                    show_404();
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
    function create_user()
    {
        $this->data['title'] = "Create User";
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('admin/users', 'refresh');
        }
        //validate form input
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('phone1', 'First Part of Phone', 'required|xss_clean|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('phone2', 'Second Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
        $this->form_validation->set_rules('phone3', 'Third Part of Phone', 'required|xss_clean|min_length[3]|max_length[3]');
        $this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        if ($this->form_validation->run() == true)
        {
            $username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $additional_data = array('first_name' => $this->input->post('first_name'),
                      'last_name' => $this->input->post('last_name'),
                      'company' => $this->input->post('company'),
                      'phone' => $this->input->post('phone1') . '-' . $this->input->post('phone2') . '-' . $this->input->post('phone3'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data))
        { //check to see if we are creating the user
            //redirect them back to the admin page  ('message',
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => "User Created Successfully"));
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
            $this->data['company'] = array('name' => 'company',
                      'id' => 'company',
                      'type' => 'text',
                      'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone1'] = array('name' => 'phone1',
                      'id' => 'phone1',
                      'type' => 'text',
                      'value' => $this->form_validation->set_value('phone1'),
            );
            $this->data['phone2'] = array('name' => 'phone2',
                      'id' => 'phone2',
                      'type' => 'text',
                      'value' => $this->form_validation->set_value('phone2'),
            );
            $this->data['phone3'] = array('name' => 'phone3',
                      'id' => 'phone3',
                      'type' => 'text',
                      'value' => $this->form_validation->set_value('phone3'),
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
            $this->template
              ->set_layout('default')
              ->title('Admin', 'Create User')
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

    function profile()
    {
        $data['gs'] = $this->portal_m->get_groups($this->user->id);
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        if ($this->ion_auth->is_in_group($this->user->id, 7))
        {
            $this->template
              ->title('Profile')
              ->set_layout('client')
              ->build('admin/profile', $data);
        }
        else
        {
            $data['cos'] = '';
            $this->template
              ->title('Profile')
              //  ->set_layout('home')
              ->build('admin/profile', $data);
        }
    }

    function recent()
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        if ($this->ion_auth->is_in_group($this->user->id, 7))
        {
            $data['cos'] = $this->portal_m->get_companies();
            $this->template
              ->title('Recent Activity', $this->client->name)
              ->set_layout('client')
              ->build('admin/recent', $data);
        }
        else
        {
            redirect('admin');
        }
    }

    function activity()
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        $data['cos'] = '';
        $this->template->set_layout('default')
          ->title('Recent Activity Log')
          ->build('admin/activity', $data);
    }

    /**
     * Catch 404s
     * 
     */
    function gotcha()
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        $this->template
          ->title('Not Found')
          ->set_layout('default')
          ->build('admin/error');
    }

    /**
     * License Activation Page
     */
    function license()
    {
        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('error', array('type' => 'error', 'text' => lang('web_not_logged')));
            redirect('admin/login');
        }
        $this->load->library('Pad');
        if ($this->input->post('license'))
        {
            $lii = $this->input->post('license');
            if (strlen($lii) > 1000)
            {
                $user = $this->ion_auth->get_user();
                $form_data = array(
                          'license' => $lii,
                          'status' => 1,
                          'created_by' => $user->id,
                          'created_on' => time()
                );
                $this->portal_m->save_key($form_data);
            }
        }
        $data['key'] = $this->school->active;
        $data['keys'] = $this->portal_m->fetch_keys();
        $this->template->title('Smart Shule License')
          ->set_layout('default')
          ->build('admin/active', $data);
    }

    public function forgotten_password()
    {
        $data['title'] = 'Forgot Password';
        $this->template
          ->set_layout('default')
          ->title('Admin', 'Forgot Password')
          ->build('admin/forgot_password', $this->data);
    }

    public function rl()
    {
        if ($this->input->post())
        {
            $data = array(
                      'status' => $this->input->post('status')
            );
            $ok = $this->portal_m->update_license($data);
            if ($ok)
            {

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }
            redirect('admin/');
        }
        // echo true;
        $this->template
          ->set_layout('default')
          ->title('Admin', 'License')
          ->build('admin/renew', $this->data);
    }

}
