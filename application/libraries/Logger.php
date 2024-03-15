<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logger
{

    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('portal_m');
    }

    function log_new_user($id, $data)
    {

        $CI = & get_instance();

        return $ci->portal_m->log_event($data);
    }

}
