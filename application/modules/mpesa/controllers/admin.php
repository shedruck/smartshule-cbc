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
        $this->load->model('mpesa_m');
        $this->load->model('fee_payment/fee_payment_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['mpesa'] = $this->mpesa_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Mpesa ')->build('admin/list', $data);
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
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok =  $this->mpesa_m->create($form_data);

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/mpesa/');
        } else {
            $get = new StdClass();
            foreach ($this->validation() as $field) {
                $get->$field['field']  = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Mpesa ')->build('admin/create', $data);
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
            redirect('admin/mpesa/');
        }
        if (!$this->mpesa_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/mpesa');
        }
        //search the item to show in edit form
        $get =  $this->mpesa_m->find($id);
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
                'modified_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->mpesa_m->update_attributes($id, $form_data);

            if ($done) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/mpesa/");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/mpesa/");
            }
        } else {
            foreach (array_keys($this->validation()) as $field) {
                if (isset($_POST[$field])) {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Mpesa ')->build('admin/create', $data);
    }


    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/mpesa');
        }

        //search the item to delete
        if (!$this->mpesa_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/mpesa');
        }

        //delete the item
        if ($this->mpesa_m->delete($id) == TRUE) {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/mpesa/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'
            ),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }


    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/mpesa/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->mpesa_m->count();
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


    function get_logs()
    {
        $postData = $this->input->get();
        // Get data
        $data = $this->mpesa_m->loadPaymentLogs($postData);

        echo json_encode($data);
    }





    function get_payment()
    {
        echo json_encode($this->mpesa_m->find($this->input->post('rec')));
    }


    function post_payment()
    {

        $response = [];
        if ($this->input->post()) {
            $post = (object) $this->input->post();

            $count = count($post->student);

            $row = $this->mpesa_m->find($post->payment);

            $user = $this->ion_auth->get_user();


            $payload = [];

            $total = 0;
            $set = $this->ion_auth->settings();
            if ($count > 1) {
                
                // Initialize the total variable before the loops
                $total = 0;
                $total_per = [];

                foreach ($post->student as $key => $std) {
                    $amount = $post->amount[$key];

                    if ($std && $set->term > 0 && $set->year > 1) //check term and year first
                    {
                        $payload[$std] = $this->mpesa_m->split($std, $set->term, $set->year, $amount);
                    }
                }

                $line_items = [];
                foreach ($payload as $st => $trans) {
                    foreach ($trans as $k => $amtt) {
                        foreach ($amtt as $item => $amt) {
                            $total_per[$st][] = $amt;
                            $line_items[$st][$k][] = $amt;


                            $total += $amt;
                        }
                    }
                }

                $sum = 0;
                foreach ($total_per as $stu => $tt) {
                    $sum = array_sum($tt);
                    $receipt = array(
                        'total' => $sum,
                        'student' => $st,
                        'created_by' => 1,
                        'created_on' => time()
                    );

                    $rec_id = $this->fee_payment_m->insert_rec($receipt);

                    if (isset($line_items[$stu])) {
                        foreach ($line_items[$stu] as $fee_id => $amounts) {
                            foreach ($amounts as   $amt) {

                                if ($amt < 1) {
                                    continue;
                                }

                                $date = strtotime($row->timestamp);


                                $table_list = array(
                                    'payment_date' => $date,
                                    'reg_no' => $stu,
                                    'amount' => $amt,
                                    'payment_method' => 'Mpesa',
                                    'transaction_no' => $row->txid,
                                    'bank_id' => 1,
                                    'receipt_id' => $rec_id,
                                    'status' => 1,
                                    // 'qb_status' => 0,
                                    // 'flagged' => 0,
                                    'term' => $set->term,
                                    'year' => $set->year,
                                    'description' => $fee_id,
                                    'created_by' => $user->id,
                                    'created_on' => time()
                                );

                                $pid = $this->fee_payment_m->create($table_list);

                                if ($pid) 
                                {
                                    $processed = [
                                        'c2_id' => $row->id,
                                        'receipt_id' => $rec_id,
                                        'student' => $stu,
                                        'campus' => 0,
                                        'amount' => $amt,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                    ];


                                    $this->mpesa_m->create('c2b_assign', $processed);
                                    $this->mpesa_m->update_attributes('c2b', $row->id, ['seen' => 1]);


                                    // log
                                    $details = implode(
                                        ' , ',
                                        $table_list
                                    );
                                    $log = array(

                                        'module' => $this->router->fetch_module(),
                                        'item_id' => $pid,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $pid,
                                        'details' => $details,
                                        'created_by' => 1,
                                        'created_on' => time()
                                    );

                                    $this->ion_auth->create_log($log);
                                }

                            }
                        }

                        
                    }

                    //sms

                    if ($pid) {



                        $stud = $this->worker->get_student($stu);

                        $parent = $this->portal_m->get_parent($stud->parent_id);


                        $amutn = number_format($sum, 2);
                        $st_name = $stud->first_name . ' ' . $stud->middle_name . ' ' . $stud->last_name;

                        // send mesage


                        $message =  'Dear Parent, confirmed we have received Ksh.' . $amutn . ' being school fee payment for ' . $st_name . '.Thank you for choosing '.$this->school->school;

                        $this->sms_m->send_sms($parent->phone, $message);
                        $this->sms_m->send_sms($parent->mother_phone, $message);
                    }

                    $this->worker->calc_balance($stu);
                }

                if($pid)
                {
                    $response = ['Response' => 'Payments processed successfully'];
                }
                else
                {
                    $response = ['Response' => 'Something went wrong'];
                }



                
            } 
            else 
            {

                foreach ($post->student as $k => $std) 
                {
                    if ($std && $set->term > 0 && $set->year > 1) 
                    {
                        $payload = $this->mpesa_m->split($std, $set->term, $set->year, $row->amount);

                        if ($payload) 
                        {
                            $total = 0;

                            foreach ($payload as $am => $amtt) 
                            {
                                $total += array_sum($amtt);
                            }



                            $receipt = array(
                                'total' => $total,
                                'student' => $std,
                                'created_by' => $user->id,
                                'created_on' => time()
                            );

                            $rec_id = $this->fee_payment_m->insert_rec($receipt);
                            foreach ($payload as $items => $amts) 
                            {

                                foreach ($amts as $k => $amt) 
                                {

                                    if ($amt < 1) {
                                        continue;
                                    }
                                    $date = strtotime($row->timestamp);
                                    $table_list = array(
                                        'payment_date' =>  $date,
                                        'reg_no' => $std,
                                        'amount' => $amt,
                                        'payment_method' => 'Mpesa',
                                        'transaction_no' => $row->txid,
                                        'bank_id' => 1,
                                        'receipt_id' => $rec_id,
                                        'status' => 1,
                                        // 'qb_status' => 0,
                                        // 'flagged' => 0,
                                        'term' => $set->term,
                                        'year' => $set->year,
                                        'description' => $items,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                    );

                                    $pid = $this->fee_payment_m->create($table_list);
                                    if ($pid) 
                                    {
                                        $processed = [
                                            'c2_id' => $row->id,
                                            'receipt_id' => $rec_id,
                                            'student' => $std,
                                            'campus' => 0,
                                            'amount' => $amt,
                                            'created_by' => $user->id,
                                            'created_on' => time()
                                        ];
                                        $this->mpesa_m->create('c2b_assign', $processed);
                                        $this->mpesa_m->update_attributes('c2b', $row->id, ['seen' => 1]);
                                    }
                                    // log
                                    $details = implode(
                                        ' , ',
                                        $table_list
                                    );
                                    $log = array(

                                        'module' => $this->router->fetch_module(),
                                        'item_id' => $pid,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $pid,
                                        'details' => $details,
                                        'created_by' => 1,
                                        'created_on' => time()
                                    );

                                    $this->ion_auth->create_log($log);
                                }
                            }


                            if ($pid) {



                                $stud = $this->worker->get_student($std);

                                $parent = $this->portal_m->get_parent($stud->parent_id);


                                $amutn = number_format($row->amount, 2);
                                $st_name = $stud->first_name . ' ' . $stud->middle_name . ' ' . $stud->last_name;

                                // send mesage


                                $message =  'Dear Parent, confirmed we have received Ksh.' . $amutn . ' being school fee payment for ' . $st_name . '.Thank you for choosing '.$this->school->school;

                                $this->sms_m->send_sms($parent->phone, $message);
                                $this->sms_m->send_sms($parent->mother_phone, $message);
                            }

                            $this->worker->calc_balance($std);
                        }
                    }
                }


                if ($pid) 
                {
                    $response = ['Response' => 'Payments processed successfully'];
                } 
                else 
                {
                    $response = ['Response' => 'Something went wrong'];
                }

            }
        }

        echo json_encode($response);
    }
}
