<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parents extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->template->set_layout('default');
                $this->template
                             ->set_layout('default.php')
                             ->set_partial('meta', 'partials/meta.php')
                             ->set_partial('header', 'partials/header.php')
                             ->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('footer', 'partials/footer.php');

                $this->load->model('shop_item_m');
        }

        function create(){
         if($this->input->post()){
                $items= $this->input->post('items');
                foreach ($items as $key => $item) {
                      $data= array(
                                'student' => $this->input->post('student'),
                                'item' =>$item,
                                'ref' => 'R-'.time(),
                                'created_by' => $this->ion_auth->get_user()->id,
                                'created_on' => time()
                      );
                      $ok= $this->shop_item_m->create_request($data);
                }

                if ( $ok)
                {
                        $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
                }
                else
                {
                        $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
                }
    
                            redirect('account/');
         }
        }
}
    ?>