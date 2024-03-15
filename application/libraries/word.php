<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once "assets/html2doc/phpword/PHPWord.php"; 
require_once "assets/html2doc/simplehtmldom/simple_html_dom.php"; 
require_once "assets/html2doc/htmltodocx_converter/h2d_htmlconverter.php"; 
require_once "assets/html2doc/phpword/styles.inc"; 
require_once "assets/html2doc/phpword/support_functions.inc"; 

class Word extends PHPWord { 
    public function __construct() { 
        parent::__construct(); 
			
    } 
}