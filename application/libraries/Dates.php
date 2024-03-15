<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once( 'Carbon/Carbon.php');

class Dates extends Carbon\Carbon
{

    public function __construct()
    {
        parent::__construct();
    }

}
