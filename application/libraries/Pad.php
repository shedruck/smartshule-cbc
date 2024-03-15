<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once(dirname(__FILE__) . '/Pad/Padl.php');
include_once(dirname(__FILE__) . '/Pad/License.php');

class Pad extends Padl
{

        public function __construct()
        {
                parent::__construct();
                Padl::registerAutoload();
         }

}
