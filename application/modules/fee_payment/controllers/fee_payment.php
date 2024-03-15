<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fee_payment extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('fee_payment_m');
        $this->template
                          ->set_layout('default.php')
                          ->set_partial('meta', 'partials/meta.php')
                          ->set_partial('header', 'partials/header.php')
                          ->set_partial('sidebar', 'partials/sidebar.php')
                          ->set_partial('footer', 'partials/footer.php');
    }

    public function kcb_test()
    {
        //https://sbes.smartshule.com/bk/kcb/test_bed

        $filePath = __DIR__ . "/messages.log";

        $response = file_get_contents('php://input');

        file_put_contents("messages.log", print_r('This is My Test', 1));

        $file = fopen($filePath, "a");
        //log incoming request

        fwrite($file, "\r\n\r\n\r\n\r\n*****Incoming KCB Push*****\r\n\r\n");
        fwrite($file, print_r($response, true));

        fclose($file);
    }

    public function kcb_prod()
    {
        //https://sbes.smartshule.com/bk/kcb/test_bed

        $filePath = __DIR__ . "/messages.log";

        $response = file_get_contents('php://input');

        file_put_contents("messages.log", print_r('This is My Test', 1));

        $file = fopen($filePath, "a");
        //log incoming request

        fwrite($file, "\r\n\r\n\r\n\r\n*****Incoming KCB Push*****\r\n\r\n");
        fwrite($file, print_r($response, true));

        fclose($file);
    }

    public function process_fee_()
    {
        $res = $this->worker->do_invoice();
        echo ' <hr>Made <strong>' . $res . '</strong> New Invoices';
        echo '<hr>Updated All Student Balances <br> <br> ';
        echo anchor('admin/fee_payment/paid', '<i class="glyphicon glyphicon-list">
                </i>Go Back to fee Payment Status', 'class="btn btn-primary"');
    }

    function calc($id = FALSE)
    {
        $this->fee_payment_m->trunc_keepbals();
        if ($id)
        {
            $this->worker->calc_balance($id);
            echo '<center><h2><button>' . anchor('admin/fee_payment', 'Fee balances was Successfully Synchronized Click here  Go Back', 'class="btn btn-primary"') . '</button></h2> </center>';
        }
        else
        {
            $this->worker->sync_bals(1);

            echo '<center><h2><button>' . anchor('admin/fee_payment', 'Fee balances was Successfully Synchronized Click here  Go Back', 'class="btn btn-primary"') . '</button></h2> </center>';
        }
    }

    /**
     * Show Fee Details to Parent
     * 
     */
    function fee()
    {
        if (!$this->parent)
        {
            redirect('account');
        }
        $data[''] = '';
        $data['rec'] = $this->portal_m->get_recs();
        $data['waivers'] = $this->portal_m->fee_waivers();
        $fn = $this->pledges();

        $this->load->model('fee_structure/fee_structure_m');

        $data['banks_acc'] = $this->fee_structure_m->banks();

        $data['pledges'] = $fn;

        $this->template->title(' FINANCIALS   ')->build('index/summary', $data);
    }

    /**
     * Student Fee Statement
     * 
     * @param type $id
     */
    function statement($id)
    {
        if (!$this->parent)
        {
            redirect('account');
        }
        $valid = array();
        foreach ($this->parent->kids as $pk)
        {
            $valid[] = $pk->student_id;
        }
        if (!in_array($id, $valid))
        {
            $id = $valid[0];
        }
        if (!$this->fee_payment_m->student_exists($id))
        {
            redirect('admin/fee_payment');
        }

        $post = $this->fee_payment_m->get_student($id);
        $data['banks'] = $this->fee_payment_m->banks();
        $data['post'] = $post;
        $data['class'] = $this->portal_m->fetch_class($post->class);
        $data['cl'] = $this->portal_m->get_class_options();
        $data['arrs'] = $this->fee_payment_m->fetch_total_arrears($id);
        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        $payload = $this->worker->process_statement($id);

        $data['payload'] = $payload;
        $this->template->title(' Fee Statement')->build('index/statement', $data);
    }

    /**
     * Fee Receipt 
     */

    /**
     * Show Fee Details to Parent
     * 
     */
    function pledges()
    {
        if (!$this->parent)
        {
            redirect('account');
        }
        $pledges = array();
        $i = 0;
        foreach ($this->parent->kids as $pp)
        {
            $stp = $this->fee_payment_m->get_pledges($pp->student_id);
            $pledges[] = $stp;
            $i++;
        }
        $fn = array();
        foreach ($pledges as $k => $list)
        {
            foreach ($list as $ple)
            {
                $fn[] = $ple;
            }
        }

        return $fn;
        //$data['pledges'] = $fn;
        //$this->template->title(' Fee Pledges ')->build('index/pledges', $data);
    }

    function receipt($rec_id)
    {


        if (!$this->fee_payment_m->exists_receipt($rec_id))
        {
            redirect('account');
        }

        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        $data['title'] = 'Fee Receipt';
        $data['total'] = $this->fee_payment_m->total_payment($rec_id);
        $data['p'] = $this->fee_payment_m->get_pays($rec_id);
        $post = $this->fee_payment_m->get_row_time($rec_id);
        $data['post'] = $post;
        $data['rec_id'] = $rec_id;

        $data['banks'] = $this->fee_payment_m->banks();
        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();
        $ccc = $this->fee_payment_m->get_student($post->reg_no);
        if (!isset($ccc->class))
        {
            $sft = ' - ';
            $st = ' - ';
        }
        else
        {
            $crow = $this->portal_m->fetch_class($ccc->class);
            if (!$crow)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
            }
        }
        $data['class'] = $sft . '  ' . $st;
        $rect = $this->fee_payment_m->fetch_receipt($rec_id);
        $data['fee'] = $this->fee_payment_m->fetch_balance($rect->student);
        $this->template->title(' Fee Receipt')->build('parents/receipt', $data);
    }

    public function mpesa_loggs()
    {
        print_r($this->fee_payment_m->mpesa_payment_list());
    }

    public function fee_payment_logs()
    {
        print_r($this->fee_payment_m->get_total_receipts());
    }

    public function callBack()
    {
        $response = file_get_contents('php://input');
        $data = json_decode($response);

        //Callback response values. You can now use this values for your own good.

        $Transaction_Type = $data->response->Transaction_Type; //can either be C2B or B2C
        $Source = $data->response->Source; //contains customer name and phone for C2B transaction
        $Destination = $data->response->Destination; //contains the receipient of funds name and phone for B2C transaction
        $Amount = $data->response->Amount; //Contains transaction amount
        $MPESA_Reference = $data->response->MPESA_Reference; //Contains MPESA reference number for the transaction
        $Account = $data->response->Account; //Contains your account number;
        $User_Reference = $data->response->User_Reference; //this is the unique payment reference provided for C2B transaction
        $Transaction_Date = $data->response->Transaction_Date; //Contains the date and time when transaction happened

        $data = array(
            'payment_date' => strtotime($Transaction_Date),
            'reg_no' => $User_Reference,
            'transaction_no' => $MPESA_Reference,
            //'phone' => $Source,
            'amount' => $Amount,
            //'account' => $Account,
            'bank_id' => '9999',
            'payment_method' => 'M-Pesa',
            'description' => 'Fee Payment',
            'status' => 1,
            'created_on' => time()
        );
        $this->fee_payment_m->create($data);
        // echo 'seen';
    }

    /**
     * confirm transaction
     * 
     * @return type
     */
    function paybill()
    {
        //log file
        $path = APPPATH . "modules/fee_payment/mpesa.log";
        //error log
        $error = APPPATH . "modules/fee_payment/mpesa-errors.log";

        //Set the response content type to application/json
        header("Content-Type: application/json");
        try
        {
            //read incoming request
            $post = file_get_contents('php://input');

            //open text file for logging messages by appending
            $file = fopen($path, "a");
            //log incoming request
            fwrite($file, $post);
            fwrite($file, "\r\n");
            fclose($file);
            /* */
            //Parse payload from json
            $jdata = json_decode($post);
            $txid = $jdata->TransID;

            $form = [
                'txid' => $txid,
                'timestamp' => $jdata->TransTime,
                'amount' => $jdata->TransAmount,
                'shortcode' => $jdata->BusinessShortCode,
                'reg_no' => $jdata->BillRefNumber,
                'account_bal' => $jdata->OrgAccountBalance,
                'phone' => $jdata->MSISDN,
                'first_name' => $jdata->FirstName,
                //'middle_name' => $jdata->MiddleName,
                //'last_name' => $jdata->LastName,
                'seen' => 0,
                'created_on' => time()
            ];

            if (!$this->fee_payment_m->c2_exists($txid))
            {
                //log tx
                $this->fee_payment_m->create_c2($form);
            }
        }
        catch (Exception $ex)
        {
            //append exception to errorLog
            $logger = fopen($error, "a");
            fwrite($logger, $ex->getMessage());
            fwrite($logger, "\r\n");
            fclose($logger);
        }

        echo json_encode(['C2BPaymentConfirmationResult' => 'Success']);
    }

    /**
     * Validate transaction
     * 
     * @return type
     */
    function tx_validate()
    {
        //log file
        $log = APPPATH . "modules/fee_payment/mpesa.val.log";
        //error log
        $error = APPPATH . "modules/fee_payment/mpesa-errors.log";

        //Set the response content type to application/json
        header("Content-Type: application/json");
        try
        {
            //read incoming request
            $post = file_get_contents('php://input');

            //log messages by appending
            $file = fopen($log, "a");
            fwrite($file, $post);
            fwrite($file, "\r\n");
            fclose($file);
        }
        catch (Exception $ex)
        {
            //append exception to file
            $logger = fopen($error, "a");
            fwrite($logger, $ex->getMessage());
            fwrite($logger, "\r\n");
            fclose($logger);
        }

        echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }

    function kreate_yuser()
    {

        $username = 'keypad systems';
        $email = 'brian@admin.com';
        $password = '12345678';

        $additional_data = array(
            'first_name' => 'Keypad',
            'last_name' => 'Systems',
            'phone' => '070000000',
            'passport' => '',
            'me' => 1,
        );

        $u_id = $this->ion_auth->register($username, $password, $email, $additional_data);
        $this->ion_auth->add_to_group(1, $u_id);

        echo '<pre>';
        print_r($u_id);
        echo '</pre>';
        die();
    }
}
