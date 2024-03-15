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
        $this->load->model('api_m');
    }

    public function index()
    {
        $gen = 0;
        if ($this->input->post())
        {
            $gen = 1;
            $id = $this->generate_random('alnum', 32);
            $secret = $this->generate_random('alnum', 64);
            $keys = array('client_id' => $id, 'client_secret' => $secret);
            $this->api_m->set_keys($keys);
            $cred = (object) $keys;
        }
        else
        {
            $cred = $this->api_m->get_keys();
        }
        $data['creds'] = $cred;
        $data['gen'] = $gen;
        //load view
        $this->template->title(' API ')->build('admin/list', $data);
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
