<?php defined('BASEPATH') OR exit('No direct script access allowed');

        class Index extends Public_Controller
        {
        function __construct()
        {
        parent::__construct();
			/*$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/ 
	
			$this->load->model('verifiers_m');
	}
	



     function push_data($page = NULL)
        {
         
		$code = $this->ion_auth->ref_no(4);
		   //Validation OK!
        //$user = $this -> ion_auth -> get_user();
        $form_data = array(
				'upi_number' => $this->input->post('upi_number'), 
				'name' => $this->input->post('name'), 
				'phone' => $this->input->post('phone'), 
				'email' => $this->input->post('email'), 
				'code' => $code, 
				'reason' => $this->input->post('reason'), 
				//'created_by' => $user -> id ,   
				'created_on' => time()
			);
			

            $ok =  $this->verifiers_m->create($form_data);

            if ( $ok)
            {
				  $this->load->model('sms/sms_m');
				  $sms = 'Code: '.$code;
				  
				  $this->sms_m->send_sms($this->input->post('phone'), $sms);
				  
				  $this->session->set_flashdata('message', array( 'type' => 'success', 'text' => lang('web_create_success') ));
            }
            else
            {
                    $this->session->set_flashdata('message', array( 'type' => 'error', 'text' => lang('web_create_failed') ));
            }

			redirect('portal','refresh');

	}
	
	

	
	private function validation()
    {
$config = array(
                 array(
		 'field' =>'upi_number',
                'label' => 'Upi Number',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'name',
                'label' => 'Name',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'phone',
                'label' => 'Phone',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'email',
                'label' => 'Email',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),

                 array(
		 'field' =>'code',
                'label' => 'Code',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[60]'),

                array(
		 'field' =>'reason',
                'label' => 'Reason',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
		);
		$this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
return $config; 
	}
        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'index/verifiers/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 1000000;
            $config['total_rows'] = $this->verifiers_m->count();
            $config['uri_segment'] = 4 ;

            $config['first_link'] = lang('web_first');
            $config['first_tag_open'] = "<li>";
            $config['first_tag_close'] = '</li>';
            $config['last_link'] = lang('web_last') ;
            $config['last_tag_open'] = "<li>";
            $config['last_tag_close'] = '</li>';
            $config['next_link'] = FALSE;
            $config['next_tag_open'] = "<li>";
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = FALSE;
            $config['prev_tag_open'] = "<li>";
            $config['prev_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active">  <a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = "<li>";
            $config['num_tag_close'] = '</li>';
            $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
            $config['full_tag_close'] = '</ul></div>';
            $choice = $config["total_rows"] / $config["per_page"];
            //$config["num_links"] = round($choice);

            return $config;
	} 
}