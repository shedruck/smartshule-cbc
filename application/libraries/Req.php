<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once(dirname(__FILE__) . '/Requests.php');

class Req extends Requests
{

        public function __construct()
        {
                parent::__construct();
                Requests::register_autoloader();
        }

}
