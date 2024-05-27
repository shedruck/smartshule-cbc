<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Trs extends Trs_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('teachers_m');
    if (!$this->ion_auth->logged_in()) {
      redirect('/login');
    }

  }


  public function assign_sub()
  {
    $teachers = $this->trs_m->list_();

    echo "<pre>";
    print_r($teachers);
    echo "<pre>";
    die;
    
    $this->template->title('Assign Subjects')->build('teachers/assign');
  }

}
