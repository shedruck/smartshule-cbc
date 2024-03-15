<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'addons/tcpdf/tcpdf.php';

class Tc_pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
}


/* End of file Pdf.php */
/* Location: ./application/libraries/tc_pdf.php */