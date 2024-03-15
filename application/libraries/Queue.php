<?php
/*
if (!defined('BASEPATH'))
        exit('No direct script access allowed');
*/
//include_once(dirname(__FILE__) . '/vendor/autoload.php');

class Queue
{

        public function __construct()
        {
                
        }

        public function send_sms($data = array())
        {
                echo '<pre>';
                print_r($data);
                echo '</pre>';
                file_put_contents('cron.txt', print_r($data, TRUE), FILE_APPEND);
                return true;
        }

}
