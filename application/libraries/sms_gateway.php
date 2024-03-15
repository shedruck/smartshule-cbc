<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once 'addons/AfricasTalkingGateway.php'; 

class sms_gateway extends AfricasTalkingGateway 
{ 

function __construct() 

{ 


// Specify your login credentials
$from='SMARTSHULE';  
$username    = "Calvince";
$apiKey      = "fa082df8db9dc8fae6796fb67748a19156c62dbc93b7067ffd4668932cac513a"; 

parent::__construct($username, $apiKey,$from); 

} 
} 

//$this->load->library('aft'); 

//$this->aft->sendmessage(); 
/* End of file Pdf.php */ 
/* Location: ./application/libraries/tc_pdf.php */