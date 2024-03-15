<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *  =============
 * 
 */
require_once __DIR__ . "/PHPExcel.php";

class Xlsx extends PHPExcel
{

    public function __construct()
    {
        parent::__construct();
    }

}
