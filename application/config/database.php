<?php

 if ( !defined('BASEPATH')) exit('No direct script access allowed');
 /*
 | -------------------------------------------------------------------
 | DATABASE CONNECTIVITY SETTINGS
 | -------------------------------------------------------------------
 | This file will contain the settings needed to access your database.
 |
 | For complete instructions please consult the 'Database Connection'
 | page of the User Guide.
 |
 */

 $active_group = 'default';
 $active_record = TRUE;

 $db['default']['hostname'] = 'localhost';
 $db['default']['username'] = 'root';
 $db['default']['password'] = '';
 $db['default']['database'] = 'sms_cbc';
 $db['default']['dbdriver'] = 'mysqli';
 $db['default']['dbprefix'] = '';
 $db['default']['pconnect'] = TRUE;
 // $db['default']['db_debug'] = ($_SERVER["REMOTE_ADDR"] == '62.8.68.235') ? TRUE : FALSE;
 $db['default']['db_debug'] = TRUE;
 $db['default']['cache_on'] = FALSE;
 $db['default']['cachedir'] = '';
 $db['default']['char_set'] = 'utf8';
 $db['default']['dbcollat'] = 'utf8_general_ci';
 $db['default']['swap_pre'] = '';
 $db['default']['autoinit'] = TRUE;
 $db['default']['stricton'] = FALSE;

 $db['mgt']['hostname'] = "localhost";
 $db['mgt']['username'] = "";
 $db['mgt']['password'] = "";
 $db['mgt']['database'] = "";
 $db['mgt']['dbdriver'] = "mysqli";
 $db['mgt']['dbprefix'] = "";
 $db['mgt']['pconnect'] = FALSE;
 $db['mgt']['db_debug'] = FALSE;
 $db['mgt']['cache_on'] = FALSE;
 $db['mgt']['cachedir'] = "";
 $db['mgt']['char_set'] = "utf8";
 $db['mgt']['dbcollat'] = "utf8_general_ci";
 $db['mgt']['swap_pre'] = "";
 $db['mgt']['autoinit'] = TRUE;
 $db['mgt']['stricton'] = FALSE;

 $db['smsq']['hostname'] = "localhost";
 $db['smsq']['username'] = "sms_sq";
 $db['smsq']['password'] = "JMs45ypWDJ";
 $db['smsq']['database'] = "sms_sq";
 $db['smsq']['dbdriver'] = "mysqli";
 $db['smsq']['dbprefix'] = "";
 $db['smsq']['pconnect'] = FALSE;
 $db['smsq']['db_debug'] = FALSE;
 $db['smsq']['cache_on'] = FALSE;
 $db['smsq']['cachedir'] = "";
 $db['smsq']['char_set'] = "utf8";
 $db['smsq']['dbcollat'] = "utf8_general_ci";
 $db['smsq']['swap_pre'] = "";
 $db['smsq']['autoinit'] = TRUE;
 $db['smsq']['stricton'] = FALSE;



$db['evt']['hostname'] = "localhost";
$db['evt']['username'] = "sms_product";
$db['evt']['password'] = "PXlcwh1xXX";
$db['evt']['database'] = "sms_product";
$db['evt']['dbdriver'] = "mysqli";
$db['evt']['dbprefix'] = "";
$db['evt']['pconnect'] = FALSE;
$db['evt']['db_debug'] = FALSE;
$db['evt']['cache_on'] = FALSE;
$db['evt']['cachedir'] = "";
$db['evt']['char_set'] = "utf8";
$db['evt']['dbcollat'] = "utf8_general_ci";
$db['evt']['swap_pre'] = "";
$db['evt']['autoinit'] = TRUE;
$db['evt']['stricton'] = FALSE;
 /* End of file database.php */
 /* Location: ./application/config/database.php */
