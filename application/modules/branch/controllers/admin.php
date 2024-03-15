<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        /*$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/login');
        }
        $this->load->model('branch_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['branch'] = $this->branch_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Branch ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $form_data_aux  = array();
        $data['page'] = ($this->uri->segment(4))  ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run()) {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'client_id' => $this->input->post('client_id'),
                'client_secret' => $this->input->post('client_secret'),
                'location' => $this->input->post('location'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok =  $this->branch_m->create($form_data);

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/branch/');
        } else {
            $get = new StdClass();
            foreach ($this->validation() as $field) {
                $get->{$field['field']}  = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Branch ')->build('admin/create', $data);
        }
    }

    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/branch/');
        }
        if (!$this->branch_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/branch');
        }
        //search the item to show in edit form
        $get =  $this->branch_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete  = array();
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
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'client_id' => $this->input->post('client_id'),
                'client_secret' => $this->input->post('client_secret'),
                'location' => $this->input->post('location'),
                'description' => $this->input->post('description'),
                'modified_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->branch_m->update_attributes($id, $form_data);

            if ($done) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/branch/");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/branch/");
            }
        } else {
            foreach (array_keys($this->validation()) as $field) {
                if (isset($_POST[$field])) {
                    $get->{$field} = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Branch ')->build('admin/create', $data);
    }


    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/branch');
        }

        //search the item to delete
        if (!$this->branch_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/branch');
        }

        //delete the item
        if ($this->branch_m->delete($id) == TRUE) {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/branch/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'
            ),

            array(
                'field' => 'url',
                'label' => 'Url',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
            ),

            array(
                'field' => 'client_id',
                'label' => 'Client Id',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
            ),

            array(
                'field' => 'client_secret',
                'label' => 'Client Secret',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
            ),

            array(
                'field' => 'location',
                'label' => 'location',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'
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


    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/branch/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->branch_m->count();
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

    function transfer()
    {
        $data['branches'] = $this->branch_m->fetch_branches();

        $this->template->title('Branch Transfer ')->build('admin/transfer', $data);
    }

    function new_transfer($id)
    {
        $class = 0;
        if ($this->input->post('class')) {
            $class = $this->input->post('class');
        }

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);

        $data['yrs'] = $yrs;
        $data['branch'] = $this->branch_m->find($id);
        $data['students'] = $this->branch_m->fetch_students($class);
        $data['classes'] = $this->streams;
        $this->template->title('Branch Transfer ')->build('admin/new_transfer', $data);
    }



    function sendRequest($url, $data)
    {
        $ch = curl_init($url);


        curl_setopt($ch, CURLOPT_POST, 1);


        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $result = curl_exec($ch);
        return $result;
    }



    function send()
    {


        if ($this->input->post()) {


            $students = $this->input->post('stds');
            $branch = $this->input->post('branch');

            $the_branch = $this->branch_m->find($branch);

           

            $count = count($students);

            if ($count > 20) {
                $this->session->set_flashdata('message', array('type' => 'warning', 'text' => 'Maximum Transfer allowed is 10 students at a time'));

                redirect('admin/branch/transfer');
            }



            if (is_array($students) && count($students)) {


                $count = count($students);
                $jdata = [];
                $branch =  $this->branch_m->find($this->input->post('branch'));
                $user = $this->ion_auth->get_user();
                foreach ($students as $key => $std) {

                    $jdata = json_encode([$this->branch_m->full_student_details($std),  $this->input->post()]);

                    $response[] = json_decode($this->sendRequest($branch->url . "/branch/receive_students", $jdata));



                    foreach ($response as $respo => $r) {
                        foreach ($r as $key => $p) {
                            if ($key == 0) {
                                if ($p->status == 200) {

                                    /**Update student status in admission table */
                                    $this->branch_m->update_student($std, ['status' => 4]);

                                    /**Insert into transfers table */
                                    $this->branch_m->create_('transfered_students',['student' => $std,'branch' => $the_branch->id, 'transfered_to' => $the_branch->url, 'created_by' => $user->id, 'created_on'  => time()]);
                                }
                                $mess =  $p->response;
                                $this->session->set_flashdata('message', array('type' => 'info', 'text' => $mess));
                            }
                        }
                    }
                }
            }

            redirect('admin/branch/transfer');
        } else {
            $this->session->set_flashdata('message', array('type' => 'info', 'text' => 'Please select students'));
            redirect('admin/branch/transfer');
        }
    }

   

    function send_rest_()
    {
        $this->load->library('Rest');

        if ($this->input->post('stds')) {

            $students = $this->input->post('stds');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $middle_name = $this->input->post('middle_name');
            $gender = $this->input->post('gender');
            $dob = $this->input->post('dob');
            $email = $this->input->post('email');
            $admission_date = $this->input->post('admission_date');
            $class = $this->input->post('daro');
            $admission_number = $this->input->post('admission_number');
            $user =  $this->ion_auth->get_user();
            $created_by = $user->first_name . ' ' . $user->last_name;
            $branch_id =  $this->input->post('branch');

            if (is_array($students) && count($students)) {


                $count = count($students);
                for ($k = 0; $k < $count; $k++) {
                    $data = [
                        'first_name' => $first_name[$k],
                        'last_name' => $last_name[$k],
                        'middle_name' => $middle_name[$k],
                        'gender' => $gender[$k],
                        'dob' => $dob[$k],
                        'email' => $email[$k],
                        'class' => $class[$k],
                        'admission_number' => $admission_number[$k],
                        'admission_date' => $admission_date[$k],
                        'created_by' => $created_by,
                        'created_on' => time(),
                    ];

                    $branch =  $this->branch_m->find($branch_id);
                    $link = $branch->url;
                    $ll = $link . '/api/transfer_stds';
                    $url = $ll;
                    $TOKEN = '4fe551ffc565987f1978339f78811f3884a99b17';
                    $headers = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $TOKEN];
                    $body = $data;
                    $req = Unirest\Request::post($url, $headers, $body);


                    print_r($req);
                    return $req;
                    // die;
                }
            }
        } else {
            echo 'select students';
        }
    }

    function transfer_pool()
    {
        $this->template->title('Transfers Pool')->build('admin/transfers', []);
    }


    function get_transfers()
    {
        $postData = $this->input->post();

        // Get data
        $data = $this->branch_m->load_transfered($postData);

        echo json_encode($data);
    }

    function request()
    {


        $url =  base_url('api/token');
        $key = 'EKGmMRLixv3mv565h0TtFb7GtuM7TDmK';
        $secret = 'g6UPCnoV0lsleAlUnmW6dCzZoLmdrkJLxxvbN6pgNdFcfwrmr3jWkSXZU8G94s5I';

        $data = array("client_id" => $key, "client_secret" => $secret, 'grant_type' => 'client_credentials');
        $data_string = json_encode($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $token_array = json_decode($response, true);
        $token = $token_array["access_token"];
        return  $token;
    }

    function get_token()
    {
        echo '<pre>';
        print_r($this->request());
        echo '</pre>';
        die();
    }


    function test_api()
    {
        $url =  base_url('api/token');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
                'X-Apple-Tz: 0',
                'X-Apple-Store-Front: 143444,12',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding: gzip, deflate',
                'Accept-Language: en-US,en;q=0.5',
                'Cache-Control: no-cache',
                'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
                'Host: www.example.com',
                'Referer: http://www.example.com/index.php', //Your referrer address
                'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
                'X-MicrosoftAjax: Delta=true'
            ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        curl_close($ch);

        print  $server_output;
    }





   
}
