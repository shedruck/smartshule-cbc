<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include_once(dirname(__FILE__) . '/Ifsnop/Mysqldump/Mysqldump.php');

class Dump extends Ifsnop\Mysqldump\Mysqldump
{

    public function __construct()
    {
        parent::__construct();
     }

}
