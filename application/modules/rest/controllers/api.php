<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Public_Controller
{

    public $user;

    public function __construct()
    {
        parent::__construct();

        if (strpos(current_url(), 'authorize') === false)
        {
            header("Access-Control-Allow-Origin:*");
            header('Content-type: application/json');
            header("Access-Control-Allow-Methods:GET,POST,OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization, X-API-Version, X-Requested-With");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }
        else
        {
            $this->template
                              ->set_layout('api.php')
                              ->set_partial('meta', 'partials/meta.php')
                              ->set_partial('header', 'partials/header.php')
                              ->set_partial('sidebar', 'partials/sidebar.php')
                              ->set_partial('footer', 'partials/footer.php');
        }

        $this->load->model('api_m');
        $this->load->model('sms/sms_m');
        $this->load->library('Oauth_server');
    }

    public function authorize()
    {
        $server = $this->oauth_server->init_server();

        $request = OAuth2\Request::createFromGlobals();
        $response = new OAuth2\Response();

        // validate the authorize request
        if (!$server->validateAuthorizeRequest($request, $response))
        {
            $response->send();
            die;
        }
        $user_id = 6137;

        if ($this->input->post())
        {
            $is_authorized = ($this->input->post('authorized') === 'yes');
            $server->handleAuthorizeRequest($request, $response, $is_authorized, $user_id);
            if ($is_authorized)
            {
                // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
                $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=') + 5, 40);
                //exit("SUCCESS! Authorization Code: $code");
                return isset($request->query['redirect_uri']) ? redirect($request->query['redirect_uri'] . '?code=' . $code) : $code;
            }
            $response->send();
        }
        $data['qs'] = $this->input->server('QUERY_STRING');
        $this->template->title(' Authorize Smartshule ')->build('admin/authorize', $data);
    }
  
    function auth()
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $res = $server->getResponse()->send();
            die();
        }
        return $server;
    }

    function user()
    {
        $server = $this->auth();

        $token = (object) $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
        $user = $this->ion_auth->get_user($token->user_id);

        $profile = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
        ];

        echo json_encode($profile);
    }

    function parent()
    {
        $server = $this->auth();

        $token = (object) $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
        $user = $this->ion_auth->get_user($token->user_id);
        $parent = $this->portal_m->get_profile($user->id);
        $parent->kids = $this->portal_m->get_kids($user->id);
        $kids = [];
        $bal = 0;
        foreach ($parent->kids as $k)
        {
            $bal += $k->balance;
            $student = $this->worker->get_student($k->student_id);
            $kid = [
                'id' => $k->student_id,
                'adm_no' => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                'name' => $student->first_name . '  ' . $student->last_name,
                'class' => $student->cl->name,
                'invoice_amt' => number_format($k->invoice_amt, 2),
                'paid' => number_format($k->paid, 2),
                'balance' => number_format($k->balance, 2),
            ];
            $kids[] = $kid;
        }
        $user->balance = number_format($bal, 2);
        $profile = [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'balance' => $user->balance
        ];
        echo json_encode(['profile' => $profile, 'kids' => $kids]);
    }

    /**
     * Fetch Admission Stats 
     */
    function students()
    {
        $this->auth();

        $stats = [];
        $students = $this->api_m->count_students();
        $recent = $this->api_m->get_recent_students();
        $classes = $this->portal_m->get_class_options();
        $classlist = $this->portal_m->get_all_classes();
        $streams = $this->portal_m->get_all_streams();
        $genders = $this->api_m->student_genders();
        $stats['total'] = $students;
        $stats['classes'] = $classes;
        $stats['classlist'] = $classlist;
        $stats['streams'] = $streams;
        $stats['recent'] = $recent;
        $stats['genders'] = $genders;

        echo json_encode($stats, JSON_NUMERIC_CHECK);
    }

    /**
     * Fetch Students in Class 
     */
    function roster($id)
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $server->getResponse()->send();
            die();
        }
        $list = $this->api_m->list_students($id);
        $classes = $this->api_m->get_class_options();
        $streams = $this->api_m->populate('class_stream', 'id', 'name');
        $crow = $this->api_m->fetch_class($id);
        if (!$crow)
        {
            $ct = ' - ';
            $st = ' - ';
        }
        else
        {
            $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
            $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
        }
        $name = $ct . ' ' . $st;
        echo json_encode(array('name' => $name, 'students' => $list), JSON_NUMERIC_CHECK);
    }

    /**
     * Fetch Student info 
     */
    function profile_old($id)
    {
        //$this->auth();

        $stud = $this->api_m->find_student($id);
        $groups = $this->api_m->populate('class_groups', 'id', 'name');
        $streams = $this->api_m->populate('class_stream', 'id', 'name');
        $houses = $this->api_m->populate('house', 'id', 'name');

        $row = $this->api_m->fetch_class($stud->class);
        $st = '';
        $grp = '';
        if (isset($row->stream))
        {
            $st = isset($streams[$row->stream]) ? $streams[$row->stream] : '';
        }
        if (isset($row->class))
        {
            $grp = isset($groups[$row->class]) ? $groups[$row->class] : '';
        }
        $by = $this->ion_auth->get_user($stud->created_by);
        $stud->created_by = $by->first_name . ' ' . $by->last_name;
        $stud->house = isset($houses[$stud->house]) ? $houses[$stud->house] : '';

        $row->name = $grp . ' ' . $st;
        $stud->class = $row;
        $stud->fee = $this->api_m->fetch_balance($stud->id);

        echo json_encode($stud, JSON_NUMERIC_CHECK);
    }

    /**
     * Fee Status
     */
    function paid()
    {
        $this->auth();

        $this->load->model('fee_payment/fee_payment_m');
        $this->load->model('expenses/expenses_m');
        $this->load->model('fee_waivers/fee_waivers_m');
        $fee = [];
        $fee['paid'] = $this->fee_payment_m->full_total_fees()->total ? $this->fee_payment_m->full_total_fees()->total : 0;
        $fee['expenses'] = $this->expenses_m->total_expenses()->total ? $this->expenses_m->total_expenses()->total : 0;
        $fee['waiver'] = $this->fee_waivers_m->total_waiver()->total ? $this->fee_waivers_m->total_waiver()->total : 0;
        ///Salaries Balances
        $basic = $this->expenses_m->total_basic();
        $allowances = $this->expenses_m->total_allowances();
        $deductions = $this->expenses_m->total_deductions();
        $nhif = $this->expenses_m->total_nhif();
        $total_paid = ($basic->basic + $allowances->allowance + $nhif->nhif + $deductions->total);
        $fee['payroll'] = $total_paid;
        $fee['graph'] = $this->fee_payment_m->payments_by_date();
        $fee['recent'] = $this->api_m->get_payments();

        echo json_encode($fee, JSON_NUMERIC_CHECK);
    }

    /**
     * tuition fee Invoices
     * 
     */
    function tuition()
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $server->getResponse()->send();
            die();
        }
        $cursor = $this->input->get('last');
        $limit = $this->input->get('limit');
        $term = $this->input->get('term');
        $year = $this->input->get('year');

        if (!$term)
        {
            $term = get_term(date('m'));
        }
        if (!$year)
        {
            $year = date('Y');
        }

        $res = $this->api_m->get_tuition_invoices($cursor, $limit, $term, $year);
        foreach ($res as $r)
        {
            $r->description = "Tuition Fee";
        }
        echo json_encode(array('invoices' => $res), JSON_NUMERIC_CHECK);
    }

    /**
     * extras fee Invoices
     * 
     */
    function extras()
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $server->getResponse()->send();
            die();
        }
        $cursor = $this->input->get('last');
        $limit = $this->input->get('limit');
        $term = $this->input->get('term');
        $year = $this->input->get('year');

        if (!$term)
        {
            $term = get_term(date('m'));
        }
        if (!$year)
        {
            $year = date('Y');
        }

        $res = $this->api_m->get_extras_invoices($cursor, $limit, $term, $year);

        echo json_encode(array('invoices' => $res), JSON_NUMERIC_CHECK);
    }

    /**
     * extras fee Invoices
     * 
     */
    function payments()
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $server->getResponse()->send();
            die();
        }
        $cursor = $this->input->get('last');
        $limit = $this->input->get('limit');
        $term = $this->input->get('term');
        $year = $this->input->get('year');

        if (!$term)
        {
            $term = get_term(date('m'));
        }
        if (!$year)
        {
            $year = date('Y');
        }

        $res = $this->api_m->get_all_payments($cursor, $limit);

        echo json_encode(array('payments' => $res), JSON_NUMERIC_CHECK);
    }

    /**
     * list_students
     */
    function list_students()
    {
        $cursor = $this->input->get('last');
        $limit = $this->input->get('limit');

        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $server->getResponse()->send();
            die();
        }
        $res = $this->api_m->get_students($cursor, $limit);

        echo json_encode(['students' => $res], JSON_NUMERIC_CHECK);
    }

    /**
     * Fee Summary 
     * 
     */
    function fee()
    {
        $this->auth();

        $stats = $this->api_m->fetch_fee_summary();

        echo json_encode($stats, JSON_NUMERIC_CHECK);
    }

    /**
     *  List balances
     * 
     * @param type $class
     * @param type $stream
     */
    function balances($class, $stream)
    {
        $this->auth();

        $stats = $this->api_m->list_fee_status($class, $stream);

        echo json_encode($stats, JSON_NUMERIC_CHECK);
    }

    /**
     *  List balances
     * 
     * @param type $class
     * @param type $stream
     */
    function stock()
    {
        $this->auth();

        $post = $this->api_m->get_stock();

        echo json_encode($post, JSON_NUMERIC_CHECK);
    }

    function filter_stock()
    {
        $this->auth();
        $month = $this->input->post('month');

        $post = array();
        $data = $this->api_m->filter_stock($month);
        foreach ($data as $p)
        {
            if ($p->qty < 1)
            {
                continue;
            }
            $post[$p->date][] = $p;
        }

        echo json_encode($post, JSON_NUMERIC_CHECK);
    }

    /**
     *  List balances for whole school
     * 
     */
    function arrears()
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $server->getResponse()->send();
            die();
        }

        $stats = $this->api_m->list_bal_status();

        echo json_encode($stats, JSON_NUMERIC_CHECK);
    }

    /**
     *  List waivers for current term
     * 
     */
    function waivers()
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            $server->getResponse()->send();
            die();
        }

        $term = get_term(date('m'));
        $year = date('Y');

        $stats = $this->api_m->get_waivers($term, $year);

        echo json_encode($stats, JSON_NUMERIC_CHECK);
    }

    /**
     * Sales Summary 
     */
    function sales()
    {
        $server = $this->oauth_server->init_server();

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals()))
        {
            //echo json_encode(array('error' => $server->getResponse()->getstatusText(), 'code' => $server->getResponse()->getstatusCode()));
            $server->getResponse()->send();
            die();
        }

        $stats = [];
        $low = 5;
        $sum_term = $this->api_m->sum_sales();
        $low_stock = $this->api_m->get_low_stock_sales($low);
        $low_inv = $this->api_m->get_low_stock_inventory($low);

        $count_items = $this->api_m->count_items();
        $recent = $this->api_m->get_recent_sales();

        $stats['total'] = $sum_term;
        $stats['count_low'] = count($low_stock);
        $stats['items'] = $count_items;
        $stats['term'] = get_term(date('m'));
        $stats['recent'] = $recent;
        $stats['low_stock'] = $low_stock;
        $stats['inventory'] = $low_inv;

        echo json_encode($stats, JSON_NUMERIC_CHECK);
    }

    function filter_pos($array)
    {
        return array_filter($array, function ($num)
        {
            return $num > 0;
        });
    }

    function index()
    {
        die();
    }

    /**
     * Token Request Endpoint
     * 
     * @return type
     */
    function token()
    {
        $this->oauth_server->token2();
    }

    function token_parent()
    {
        $res = $this->oauth_server->token();
        if (empty($res))
        {
            echo json_encode(['success' => false, 'message' => 'Wrong Username or Password. Try Again']);
            exit();
        }
        $tok = (object) $res;
        $user = new stdClass();
        $user->token = $tok;
        $user->profile = $this->user_from_token($tok->access_token);
        echo json_encode(['user' => $user]);
    }

    /**
     * Token Validation Endpoint
     * 
     * @return type
     */
    function resource()
    {
        return $this->oauth_server->resource();
    }

    /**
     *  Student Fee statement
     * 
     */
    function statement($id, $return = 0)
    {
        $this->load->model('fee_payment/fee_payment_m');
        $this->auth();

        $arrs = $this->fee_payment_m->fetch_total_arrears($id);
        $student = $this->api_m->find_student($id);
        $payload = $this->worker->process_statement($id);
        $fee = $this->api_m->fetch_balance($id);
        if ($return)
        {
            return (object) ['arrears' => $arrs, 'statement' => $payload];
        }
        echo json_encode(['student' => $student, 'fee' => $fee, 'arrears' => $arrs, 'statement' => $payload], JSON_NUMERIC_CHECK);
    }

    function StudentList()
    {
        $this->auth();
        $response = [];
        $pid = $this->input->get('ParentId');

        if ($pid)
        {
            $parent = $this->ion_auth->get_single_parent($pid);
            if ($parent)
            {
                $students = $this->portal_m->get_kids($parent->user_id);
                foreach ($students as $s)
                {
                    $student = $this->worker->get_student($s->student_id);
                    $fee = $this->api_m->fetch_balance($student->id);

                    $link = '';
                    if (!empty($student->photo))
                    {
                        $passport = $this->admission_m->passport($student->photo);
                        $link = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
                    }
                    $details = [
                        "SID" => $student->id,
                        "Name" => $student->first_name . " " . $student->middle_name . " " . $student->last_name,
                        "Admno" => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                        "HomeAddress" => $parent->address,
                        "Active" => ($student->status == 1) ? TRUE : FALSE,
                        "Photo" => $link,
                        "Class" => $student->cl->name,
                        "AdmissionDate" => $student->admission_date > 10000 ? date('Y-m-d', $student->admission_date) : ' - ',
                        "CurrentBalance" => $fee->balance,
                    ];
                    $response["Response"]['Data']['students'][] = $details;
                }
            }
            else
            {
                $response["Response"]['status'] = ['code' => 0, 'message' => 'Failed! Parent not Found'];
            }
        }
        else
        {
            $response["Response"]['status'] = ['code' => 0, 'message' => 'Failed! Parent not Found'];
        }

        echo json_encode($response);
    }

    function Profile($id)
    {
       $this->auth();

        if ($id)
        {
            $student = $this->worker->get_student($id);
            if (empty($student) || !isset($student->id))
            {
                echo json_encode(["Profile" => []]);
                exit();
            }
            $fee = $this->api_m->fetch_balance($student->id);
            
            $link = '';
            if (!empty($student->photo))
            {
                $passport = $this->admission_m->passport($student->photo);
                $link = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
            }
            $profile = [
                "Name" => $student->first_name . " " . $student->middle_name . " " . $student->last_name,
                "Admno" => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                "Gender" => $student->gender == 1 ? 'MALE' : 'FEMALE',
                "HomeAddress" => $student->residence,
                "HomeLocation" => $student->estate,
                "Hospital" => $student->hospital,
                "Doctor" => $student->doctor_name,
                "DoctorPhone" => $student->doctor_phone,
                "EmergencyPhone" => $student->emergency_phone,
                "Active" => ($student->status == 1) ? TRUE : FALSE,
                "Photo" => $link,
                "Class" => $student->cl->name,
                "AdmissionDate" => $student->admission_date > 10000 ? date('Y-m-d', $student->admission_date) : ' - ',
                "CurrentBalance" => $fee->balance,
            ];

            $parent = $this->ion_auth->get_single_parent($student->parent_id);

            if (!empty($parent))
            {
                $profile['Parents'] = [
                    [
                        "Name" => $parent->first_name . ' ' . $parent->last_name,
                        "Phone" => $parent->phone,
                        "Email" => $parent->email
                    ],
                    [
                        "Name" => $parent->mother_fname . ' ' . $parent->mother_lname,
                        "Phone" => $parent->mother_phone,
                        "Email" => $parent->mother_email
                    ],
                ];
            }

            $response = ["Profile" => $profile];
        }
        else
        {
            $response = ["Profile" => []];
        }

        echo json_encode($response);
    }

    /**
     * Customized for Fairmonts app
     */
    function token_fm()
    {
        $response = [];
        $res = $this->oauth_server->token();

        if (empty($res))
        {
            $response["Response"]['status'] = ['code' => 0, 'message' => 'Failed ! Invalid Login Details'];
            echo json_encode($response);
            exit();
        }
        $this->load->model('admission/admission_m');
        $user = $this->user_from_token($res['access_token'], 1);
        $parent = $this->portal_m->get_profile($user->id);

        $response["Response"]['status'] = ['code' => 1, 'message' => 'Success'];
        $response["Response"]['token'] = $res;
        $response["Response"]['Data'] = ['parentID' => $parent->id, 'emailAddress' => $parent->email, 'firstName' => $parent->first_name, 'gender' => null, 'accountStatus' => 'Active', 'students' => []];

        $students = $this->portal_m->get_kids($user->id);
        foreach ($students as $s)
        {
            $student = $this->worker->get_student($s->student_id);
            $fee = $this->api_m->fetch_balance($student->id);
            $tm = get_term(date('m'));
            $waiver = $this->admission_m->get_waiver($student->id, $tm);

            $link = '';
            if (!empty($student->photo))
            {
                $passport = $this->admission_m->passport($student->photo);
                $link = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
            }
            $details = [
                "SID" => $student->id,
                "SUID" => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                "Name" => $student->first_name . " " . $student->middle_name . " " . $student->last_name,
                "Admno" => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                "SEX" => $student->gender,
                "ClassID" => $student->class,
                "CName" => $student->cl->name,
                "StreamID" => $student->cl->id,
                "StreamName" => null,
                "ParentName" => $parent->first_name . ' ' . $parent->last_name,
                "DOB" => $student->dob > 10000 ? date('Y-m-dT00:00:00', $student->dob) : ' - ',
                "ParentID" => $parent->id,
                "ParentCellNo" => $parent->phone,
                "Parent2Name" => $parent->mother_fname . ' ' . $parent->mother_lname,
                "Parent2Phone" => $parent->mother_phone,
                "GuardianName" => $parent->first_name . ' ' . $parent->last_name,
                "GuardianPhone" => $parent->phone,
                "GuardianRelationship" => null,
                "GuardianOccupation" => $parent->occupation,
                "ParentEmail" => $parent->email,
                "Parent2Email" => $parent->mother_email,
                "Home" => $student->residence,
                "HomeAddress" => $parent->address,
                "HomeLocation" => "",
                "Active" => ($student->status == 1) ? TRUE : FALSE,
                "TrxDate" => null,
                "ImageUrl" => $link,
                "RegisteredOn" => $student->admission_date > 10000 ? date('Y-m-d', $student->admission_date) : ' - ',
                "Filter" => null,
                "TransportPackageId" => null,
                "TransportPackage" => null,
                "HasSubscription" => 0,
                "PackageId" => null,
                "PackageName" => null,
                "UserName" => null,
                "SubScriptionNextDate" => null,
                "SubScriptionStartDate" => null,
                "SubScriptionDate" => null,
                "ActiveSubscription" => false,
                "ParentCancelSubscription" => false,
                "Description" => null,
                "ID" => null,
                "Grandtotal" => $fee->invoice_amt,
                "Payments" => $fee->paid,
                "TotalWaivered" => $waiver,
                "Balances" => $fee->balance,
                "Status" => "Has No Subscription"
            ];
            $response["Response"]['Data']['students'][] = $details;
        }

        echo json_encode($response);
    }

    /**
     * User info from Token upon login
     * 
     * @param type $token
     * @return type
     */
    function user_from_token($token = '', $sub = 0)
    {
        $row = $this->api_m->get_token($token);

        $user = $this->ion_auth->get_user($row->user_id);
        if ($sub)
        {
            return $user;
        }
        $parent = $this->portal_m->get_profile($user->id);
        $parent->kids = $this->portal_m->get_kids($user->id);
        $kids = [];
        $bal = 0;
        foreach ($parent->kids as $k)
        {
            $bal += $k->balance;
            $student = $this->worker->get_student($k->student_id);
            $kid = [
                'id' => $k->student_id,
                'adm_no' => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                'name' => $student->first_name . '  ' . $student->last_name,
                'class' => $student->cl->name,
                'invoice_amt' => number_format($k->invoice_amt, 2),
                'paid' => number_format($k->paid, 2),
                'balance' => number_format($k->balance, 2),
            ];
            $kids[] = $kid;
        }
        $user->balance = number_format($bal, 2);

        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'balance' => $user->balance,
            'kids' => $kids
        ];
    }

    function BankInfo()
    {
        $this->auth();

        $response['BankInfo'] = [];
        $bnks = $this->api_m->find_banks();

        foreach ($bnks as $b)
        {
            $bk = [
                "BANKACCOUNTID" => $b->id,
                "BANKNAME" => $b->bank_name,
                "BANKBRANCHNAME" => $b->branch,
                "ACCOUNTNAME" => $b->account_name,
                "ACCOUNTNUMBER" => $b->account_number,
                "ACTIVE" => true,
                "DESC" => $b->description,
                "BANKCODE" => null
            ];
            array_push($response['BankInfo'], $bk);
        }

        echo json_encode($response);
    }

    function firstlogin()
    {
        $phone = $this->input->get('phone_no');
        $response = [];
        if ($phone)
        {
            $parent = $this->ion_auth->find_parent($phone);
            if ($parent)
            {
                $response = ["Check" => "Already Exists"];
            }
            else
            {
                $response = ["Check" => "Failed"];
            }
        }
        else
        {
            $response = ["Check" => "Missing Parameter"];
        }
        echo json_encode($response);
    }

    function addpassword()
    {
        $response = [];
        $username = $this->input->post('phone_no');
        $password = $this->input->post('password');
        $code = $this->input->post('code');

        if ($username && $password && $code)
        {
            $parent = $this->ion_auth->find_parent($username);
            $user = $this->ion_auth->get_user($parent->user_id);
            if ($user->activation_code == $code)
            {
                if (strlen($password) > 7)
                {
                    $kp = $this->ion_auth->reset_password($parent->user_id, $password);
                    if ($kp)
                    {
                        $response = ["Update" => "Success"];
                    }
                    else
                    {
                        $response = ["Update" => "Failed"];
                    }
                }
                else
                {
                    $response = ["Update" => "Failed ! Short Password"];
                }
            }
            else
            {
                $response = ["Update" => "Failed ! Invalid Code"];
            }
        }
        else
        {
            $response = ["Update" => "Missing Parameter"];
        }
        echo json_encode($response);
    }

    function GenerateResetPasswordCode()
    {
        $response = [];
        $username = $this->input->get('phone_no');
        if ($username)
        {
            $parent = $this->ion_auth->find_parent($username);
            if ($parent)
            {
                $usr = $this->ion_auth->get_user($parent->user_id);
                if ($usr)
                {
                    $code = $this->ion_auth->ref_no(6);
                    $this->ion_auth->make_update($parent->user_id, ['forgotten_password_code' => $code, 'activation_code' => $code, 'modified_on' => time()]);

                    $message = "Your activation code is " . $code;
                    $this->sms_m->send_sms($username, $message);
                    $response = ["Check" => $code];
                }
                else
                {
                    $response = ["Check" => "Failed. User not Found"];
                }
            }
            else
            {
                $response = ["Check" => "Failed. Parent not Found"];
            }
        }
        else
        {
            $response = ["Check" => "Missing Parameter"];
        }
        echo json_encode($response);
    }

    function UpdateStudentProfilePic()
    {
        $this->auth();
        $response = [];
        $sid = $this->input->post('SId');
        $img = $this->input->post('ImageinBase64');
        $file_name = $this->input->post('File_Name');
        $student = $this->worker->get_student($sid);
        if (!$student)
        {
            $response = ["Check" => "Student not Found"];
        }

        if ($sid && $img && $file_name)
        {
            $binary = base64_decode($img);

            header('Content-Type: bitmap; charset=utf-8');
            $fname = 'pic_' . $file_name;

            $dest = FCPATH . "/uploads/student/" . date('Y') . '/';
            if (!is_dir($dest))
            {
                mkdir($dest, 0777, true);
            }
            $file = fopen($dest . $fname, 'wb');
            fwrite($file, $binary);
            fclose($file);

            $this->load->model('admission/admission_m');
            $file_id = $this->admission_m->save_photo(
                              [
                                  'filename' => $fname,
                                  'filesize' => 0,
                                  'fpath' => 'student/' . date('Y') . '/',
                                  'created_by' => 999,
                                  'created_on' => now()
            ]);

            $this->admission_m->update_attributes($sid, ['photo' => $file_id]);

            $response = ["Check" => "Success", "path" => base_url("/uploads/student/" . date('Y') . '/' . $fname)];
        }
        else
        {
            $response = ["Check" => "Failed"];
        }

        echo json_encode($response);
    }

    function PostParentProfilePicture()
    {
        $this->auth();
        $response = [];
        $pid = $this->input->post('ParentId');
        $file_name = $this->input->post('File_Name');
        $img = $this->input->post('ImageinBase64');
        $parent = $this->ion_auth->get_single_parent($pid);
        if (!$parent)
        {
            $response = ["Check" => "Failed. Parent not Found."];
        }
        if ($pid && $img && $file_name)
        {
            $binary = base64_decode($img);

            header('Content-Type: bitmap; charset=utf-8');
            $fname = 'p_' . $file_name;
            $dest = FCPATH . "/uploads/parents/" . date('Y') . '/';
            if (!is_dir($dest))
            {
                mkdir($dest, 0777, true);
            }
            $file = fopen($dest . $fname, 'wb');
            fwrite($file, $binary);
            fclose($file);

            $file_id = $this->api_m->save_rec('parents_passports',
                              [
                                  'filename' => $fname,
                                  'filesize' => 0,
                                  'fpath' => 'parents/' . date('Y') . '/',
                                  'created_by' => 999,
                                  'created_on' => time()
            ]);

            $this->api_m->update_k_data('parents', $pid, ['father_photo' => $file_id]);
            $response = ["Check" => "Success", "path" => base_url('uploads/parents/' . date('Y') . '/' . $fname)];
        }
        else
        {
            $response = ["Check" => "Failed. Missing Parameters"];
        }

        echo json_encode($response);
    }

    function StudentProfilePicture()
    {
        $this->auth();
        $response = [];
        $sid = $this->input->post('Sid');

        if ($sid)
        {
            $student = $this->worker->get_student($sid);
            if (!empty($student))
            {
                $row = $this->api_m->get_passport($student->photo);
                $response = ["Check" => "Success", "path" => base_url('uploads/' . $row->fpath . $row->filename)];
            }
            else
            {
                $response = ["Check" => "Failed"];
            }
        }
        else
        {
            $response = ["Check" => "Failed"];
        }
        echo json_encode($response);
    }

    function ParentProfilePicture()
    {
        $this->auth();

        $pid = $this->input->get('Parentid');
        $response = [];

        if ($pid)
        {
            $parent = $this->ion_auth->get_single_parent($pid);
            if (!empty($parent))
            {
                $row = $this->api_m->get_parent_passport($parent->father_photo);
                $response = ["Check" => "Success", "path" => base_url('uploads/' . $row->fpath . $row->filename)];
            }
            else
            {
                $response = ["Check" => "Failed"];
            }
        }
        else
        {
            $response = ["Check" => "Failed"];
        }
        echo json_encode($response);
    }

    function SchoolEvents()
    {
        $this->auth();
        $response = [];
        $evnts = $this->api_m->get_events();
        if (!empty($evnts))
        {
            $response["events"] = [];
            foreach ($evnts as $e)
            {
                $response["events"][] = ["title" => $e->title, "date" => date('d M Y', $e->date), "start_time" => $e->start, "end_time" => $e->end, "description" => $e->description, "created_on" => date('Y-m-d', $e->created_on)];
            }
        }
        else
        {
            $response["events"] = array();
        }

        echo json_encode($response);
    }

    function StudentExtraCurricularActivities()
    {
        $this->auth();
        $response = [];
        $sid = $this->input->post('Sid');
        if ($sid)
        {
            $events = $this->api_m->getex_activities($sid);
            if (!empty($events))
            {
                $response["activites"] = [];
                foreach ($events as $e)
                {
                    $response["activites"][] = ["activity" => $e->activity_name, "term" => $e->term, "year" => $e->year];
                }
            }
            else
            {
                $response = ["activites" => array()];
            }
        }
        else
        {
            $response = ["activites" => array()];
        }
        echo json_encode($response);
    }

    function FetchStudentDiary()
    {
        $server = $this->auth();

        $response = [];
        $adm = $this->input->get('admNo');
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $from = $this->input->get('fromDate') ? strtotime($this->input->get('fromDate')) : 0;
        $to = $this->input->get('toDate') ? strtotime($this->input->get('toDate')) : 0;

        if (!$adm)
        {
            $response = ["Report" => []];
            echo json_encode($response);
            exit();
        }
        $per = 10;
        $dr = $this->api_m->get_diary($adm, $page, $per, $from, $to);
        $report = [];

        $res = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());

        foreach ($dr->result as $d)
        {
            $student = $this->worker->get_student($d->student);
            $user = $this->ion_auth->get_user($d->created_by);
            $pc = $this->api_m->get_comment($d->id, $res['user_id'], 1);
            $report[] = [
                'DiaryId' => $d->id,
                'StudentId' => $d->student,
                'Admno' => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                'ClassID' => $student->cl->id,
                'CName' => $student->cl->name,
                'Name' => $student->first_name . ' ' . $student->last_name,
                'SEX' => $student->gender == 1 ? 'MALE' : 'FEMALE',
                'SysDate' => $d->date_ > 10000 ? date('Y-m-d\T00:00:00', $d->date_) : ' - ',
                'Date' => $d->date_ > 10000 ? date('Y-m-d\T00:00:00', $d->date_) : ' - ',
                'DayEntry' => $d->activity,
                'TeacherComment' => $d->teacher_comment,
                'ParentComment' => $pc ? $pc->comment : '',
                'Filter' => '',
                'UserName' => '',
                'IsCancelled' => false,
                'verified' => null,
                'Teacher' => $user->first_name . ' ' . $user->last_name,
                'Uploaded' => count($d->uploads) ? true : false,
                'Images' => $d->uploads
            ];
        }

        echo json_encode(["Report" => $report, 'meta' => $dr->meta]);
    }

    function ExtraCurricularDiary()
    {
        $this->auth();

        $response = [];
        $adm = $this->input->get('admNo');
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $from = $this->input->get('fromDate') ? strtotime($this->input->get('fromDate')) : 0;
        $to = $this->input->get('toDate') ? strtotime($this->input->get('toDate')) : 0;

        if (!$adm)
        {
            $response = ["Report" => []];
            echo json_encode($response);
            exit();
        }
        $per = 10;
        $dr = $this->api_m->get_diary_extra($adm, $page, $per, $from, $to);
        $report = [];
        $activities = $this->api_m->populate('activities', 'id', 'name');
        foreach ($dr->result as $d)
        {
            $student = $this->worker->get_student($d->student);
            $user = $this->ion_auth->get_user($d->created_by);
            $report[] = [
                'DiaryId' => $d->id,
                'StudentId' => $d->student,
                'Admno' => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                'CName' => $student->cl->name,
                'Name' => $student->first_name . ' ' . $student->last_name,
                'Date' => $d->date_ > 10000 ? date('Y-m-d\T00:00:00', $d->date_) : ' - ',
                'ExtraCurriculaID' => $d->activity,
                'ExtraCurriculaName' => isset($activities[$d->activity]) ? $activities[$d->activity] : ' - ',
                'TeacherComment' => $d->teacher_comment,
                'ParentComment' => $d->parent_comment,
                'UserName' => '',
                'Teacher' => $user->first_name . ' ' . $user->last_name,
                'Uploaded' => count($d->uploads) ? true : false,
                'Images' => $d->uploads
            ];
        }

        echo json_encode(["Report" => $report, 'meta' => $dr->meta]);
    }

    function GetStudentGroupedFees()
    {
        $this->auth();
        $id = $this->input->get('admNo');
        if (!$id)
        {
            $response = ["Report" => []];
            echo json_encode($response);
            exit();
        }

        $report = $this->worker->get_grouped_fee($id);
        echo json_encode(["Report" => $report]);
    }

    function FeeSummary()
    {
        $server = $this->auth();
        $res = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
        $id = $this->input->get('admNo');
        $students = $this->portal_m->get_kids($res['user_id']);
        $bal = 0;
        $rows = [];
        foreach ($students as $k)
        {
            if ($id)
            {
                if ($k->student_id != $id)
                {
                    continue;
                }
            }
            $bal += $k->balance;
            $student = $this->worker->get_student($k->student_id);

            $rows[] = [
                'id' => $k->student_id,
                'adm_no' => empty($student->old_adm_no) ? $student->admission_number : $student->old_adm_no,
                'name' => $student->first_name . ' ' . $student->last_name,
                'class' => $student->cl->name,
                'invoiced_amt' => number_format($k->invoice_amt, 2),
                'paid' => number_format($k->paid, 2),
                'balance' => number_format($k->balance, 2),
            ];
        }
        $response = ["Report" => ['students' => $rows, 'total_balance' => number_format($bal, 2)]];
        echo json_encode($response);
    }

    function FeeStatement()
    {
        $this->auth();

        $id = $this->input->get('admNo');
        if (!$id)
        {
            $response = ["Report" => []];
            echo json_encode($response);
            exit();
        }

        $fn = [];
        $extras = $this->api_m->populate('fee_extras', 'id', 'title');
        $res = $this->statement($id, 1);
        $ibal = $res->arrears;

        ksort($res->statement);
        $txs = [];
        foreach ($res->statement as $y => $p)
        {
            ksort($p);
            foreach ($p as $term => $trans)
            {
                foreach ($trans as $type => $paidd)
                {
                    foreach ($paidd as $paid)
                    {
                        $paid['type'] = $type;
                        $txs[$y][$term][] = $paid;
                    }
                }
            }
        }

        foreach ($txs as $y => $p)
        {
            foreach ($p as $term => $trans)
            {
                $mf = ['year' => $y, 'term' => $this->terms[$term], 'balance_bf' => number_format($ibal, 2)];

                $st_paid = sort_by_field($trans, 'date');

                $i = 0;
                $dr = 0;
                $cr = 0;
                $wv = 0;
                $idw = 0;
                $exc = 0;
                $exw = 0;
                $lines = [];
                foreach ($st_paid as $paidd)
                {
                    $paid = (object) $paidd;
                    $debit = $paid->type == 'Debit' ? $paid->amount : 0;
                    $debit += $paid->type == 'Sales' ? $paid->amount : 0;
                    $credit = $paid->type == 'Credit' ? $paid->amount : 0;
                    $sales_paid = $paid->type == 'Sold' ? $paid->amount : 0;
                    if ($debit)
                    {
                        $idw = $paid->date;
                    }
                    $waiver = $paid->type == 'Waivers' ? $paid->amount : 0;
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
                    $cr += ($credit + $sales_paid);
                    $wv += $waiver;
                    $bal = ($debit + $bcg) - ($credit + $waiver + $bw + $sales_paid);
                    $ibal += $bal;
                    $i++;

                    if ($idw || $paid->type == 'Waivers')
                    {
                        $wdate = date('d M Y', $paid->date);
                    }
                    else
                    {
                        $wdate = isset($this->terms[$term]) ? $this->terms[$term] : '';
                    }
                    $tdate = $paid->date > 0 ? date('d M Y', $paid->date) : $paid->date;

                    $mess = ucwords($paid->desc);
                    if ((is_numeric($mess) && $mess == 0) || empty($paid->desc))
                    {
                        $mess = 'Fee Payment';
                    }
                    elseif (is_numeric($mess))
                    {
                        $mess = isset($extras[$mess]) ? $extras[$mess] : ' - ';
                    }
                    else
                    {
                        //
                    }
                    $wwv = $paid->desc ? 'Waiver - ' . $paid->desc : 'Fee Waiver';

                    if ($waiver)
                    {
                        $crd = number_format($waiver, 2);
                    }
                    elseif ($bw)
                    {
                        $crd = number_format($bw, 2);
                    }
                    elseif ($sales_paid)
                    {
                        $crd = number_format($sales_paid, 2);
                    }
                    else
                    {
                        $crd = number_format($credit, 2);
                    }

                    $lines[] = [
                        'date' => $waiver ? $wdate : $tdate,
                        'refno' => $paid->refno ? $paid->refno : gen_string(),
                        'desc' => $waiver ? $wwv : rtrim($mess, ' -'),
                        'debit' => $bcg ? number_format($bcg, 2) : number_format($debit, 2),
                        'credit' => $crd,
                        'bal' => number_format($ibal, 2),
                    ];
                }
                $mf['data'] = $lines;
                $mf['totals'] = ['debit' => number_format($dr + $exc, 2), 'credit' => number_format($cr + $wv + $exw, 2), 'bal' => number_format($ibal, 2)];
                $fn[] = $mf;
            }
        }
        echo json_encode($fn);
    }

    function FoodTimetableDetails()
    {
        $this->auth();
        $response = [];
        $term = $this->input->get('term');
        $year = $this->input->get('year');

        if (!$term || !$year)
        {
            $response = ["FoodTimeTable" => []];
            echo json_encode($response);
            exit();
        }
        $tt = $this->api_m->get_ftt($term, $year);
        $tables = $this->api_m->populate('food_tt_tables', 'id', 'sub_code');
        $times = $this->api_m->populate('food_tt_times', 'id', 'name');

        foreach ($tt as $p)
        {
            $time = isset($times[$p->time_]) ? $times[$p->time_] : ' -';
            $table = isset($tables[$p->table]) ? $tables[$p->table] : ' -';
            $term = isset($this->terms[$p->term]) ? $this->terms[$p->term] : ' -';

            $response[] = [
                'Id' => $p->id,
                'TableCode' => $p->table,
                'TableSubCode' => $table,
                'TermID' => $p->term,
                'Term' => $term,
                'Date' => date('Y-m-d\T00:00:00'),
                'Week' => $p->week,
                'Time' => $time,
                'Monday' => $p->monday,
                'Tuesday' => $p->tuesday,
                'Wednesday' => $p->wednesday,
                'Thursday' => $p->thursday,
                'Friday' => $p->friday
            ];
        }

        echo json_encode(["FoodTimeTable" => $response]);
    }

    function SmsMessages()
    {
        $server = $this->auth();

        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $res = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());

        $messages = $this->api_m->get_messages($res['user_id'], $page);

        $parsed = [];

        foreach ($messages->result as $m)
        {
            $parsed[] = [
                "id" => $m->id,
                "phone" => $m->dest,
                "message" => $m->relay,
                "sender" => $m->source,
                "date" => date('Y-m-d H:i:s', $m->created_on),
            ];
        }

        echo json_encode(["messages" => $parsed, 'meta' => $messages->meta]);
    }

    function PostComment()
    {
        $server = $this->auth();
        $response = [];
        $id = $this->input->post('id');
        $comment = $this->input->post('comment');

        if ($id && $comment)
        {
            $res = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());

            if (!$this->api_m->diary_exists($id))
            {
                $response["Response"]['status'] = ['code' => 0, 'message' => 'Failed! Diary does not exist'];
                echo json_encode($response);
                exit();
            }

            $this->api_m->post_comment($id, $res['user_id'], $comment, 1);
            $response["Response"]['status'] = ['code' => 1, 'message' => 'Success'];
        }
        else
        {
            $response["Response"]['status'] = ['code' => 0, 'message' => 'Failed! Missing Parameters'];
        }

        echo json_encode($response);
    }

    function PostCommentExtra()
    {
        $server = $this->auth();
        $response = [];
        $id = $this->input->post('id');
        $comment = $this->input->post('comment');

        if ($id && $comment)
        {
            $res = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());

            if (!$this->api_m->diary_exists($id, 2))
            {
                $response["Response"]['status'] = ['code' => 0, 'message' => 'Failed! Diary does not exist'];
                echo json_encode($response);
                exit();
            }

            $this->api_m->post_comment($id, $res['user_id'], $comment, 2);
            $response["Response"]['status'] = ['code' => 1, 'message' => 'Success'];
        }
        else
        {
            $response["Response"]['status'] = ['code' => 0, 'message' => 'Failed! Missing Parameters'];
        }

        echo json_encode($response);
    }

    /**
     * 
     * @param type $type
     * @param type $length
     * @return type
     */
    function generate_random($type = 'alnum', $length = 64)
    {
        switch ($type)
        {
            case 'alnum':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alpha':
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'hexdec':
                $pool = '0123456789abcdef';
                break;
            case 'numeric':
                $pool = '0123456789';
                break;
            case 'nozero':
                $pool = '123456789';
                break;
            case 'distinct':
                $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
                break;
            default:
                $pool = (string) $type;
                break;
}

        $crypto_rand_secure = function ($min, $max)
        {
            $range = $max - $min;
            if ($range < 0)
            {
                return $min; // not so random...
            }
            $log = log($range, 2);
            $bytes = (int) ( $log / 8 ) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
            do
            {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // discard irrelevant bits
            }
            while ($rnd >= $range);
            return $min + $rnd;
        };

        $token = "";
        $max = strlen($pool);
        for ($i = 0; $i < $length; $i++)
        {
            $token .= $pool[$crypto_rand_secure(0, $max)];
        }
        return $token;
    }

}
