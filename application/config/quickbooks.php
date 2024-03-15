<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

if (function_exists('date_default_timezone_set'))
{
        date_default_timezone_set('Africa/Nairobi');
}

$config['user'] = 'quickbooks';
$config['pass'] = '123456';

//$config['loglevel'] = QUICKBOOKS_LOG_NORMAL;
//$config['loglevel'] = QUICKBOOKS_LOG_VERBOSE;
//$config['loglevel'] = QUICKBOOKS_LOG_DEBUG;				
$config['loglevel'] = QUICKBOOKS_LOG_DEVELOP;

//Memory limit
$config['memorylimit'] = '512M';
//Timezone
$config['tz'] = 'Africa/Nairobi';