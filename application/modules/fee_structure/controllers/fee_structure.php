<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Fee_structure extends Public_Controller
{

        public function __construct()
        {
                parent::__construct();
                $this->load->model('fee_structure_m');
                $this->template
                             ->set_layout('default.php')
                             ->set_partial('meta', 'partials/meta.php')
                             ->set_partial('header', 'partials/header.php')
                             ->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('footer', 'partials/footer.php');
        }

        /**
         * View Fee Structure
         * 
         */
        function view()
        {
                if (!$this->parent)
                {
                        redirect('account');
                }
                $bal = 0;
                foreach ($this->parent->kids as $pp)
                {
                        $bal += $pp->balance;
                }

                $fee_structure = array(); //$this->fee_structure_m->fetch_all();
                if (!empty($fee_structure))
                {
                        foreach ($fee_structure as $f)
                        {
                                $f->classes = array(); //deleted
                        }
                }
                else
                {
                        $fee_structure = array();
                }
                $fnl = array();
                foreach ($fee_structure as $fee)
                {
                        if (isset($fee->classes) && !empty($fee->classes))
                        {
                                foreach ($fee->classes as $tt => $fspe)
                                {
                                        foreach ($fspe as $clas => $spec)
                                        {
                                                $fnl[$tt] [$clas] = $spec;
                                        }
                                }
                        }
                }

                $data['fxtras'] = $this->fee_structure_m->fetch_extras();
                // $data['parent'] = $parent;
                $data['bal'] = $bal;
                //  $data['id'] = $id;
                $data['fee'] = $fnl;
                //load the view and the layout
                $this->template->title('Fee Structure')->build('index/view', $data);
        }

}
