<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_accounts extends Public_Controller
{
function __construct()
{
parent::__construct();
		$this->template->set_layout('portal');
			$this->template->set_partial('header','partials/header.php');
			$this->template->set_partial('meta','partials/meta.php');
			$this->template->set_partial('footer','partials/footer.php');
			$this->template->set_partial('sidebar','partials/sidebar.php');
			if (!$this->ion_auth->logged_in())
				{
				redirect('login');
				}
	
	/* if (!$this->ion_auth->is_in_group($this->user->id, 1) && !$this->ion_auth->is_in_group($this->user->id, 7))
        {
             $this->session->set_flashdata('message', array('type' => 'success', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
			redirect('admin');
        }*/
	
			$this->load->model('bank_accounts_m');
	}


	function accounts()
	{
	   $config = $this->set_paginate_options(); 	//Initialize the pagination class
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;

 		$data['bank_accounts'] = $this->bank_accounts_m->paginate_all($config['per_page'], $page);

            //create pagination links
            $data['links'] = $this->pagination->create_links();

	//page number  variable
	 $data['page'] = $page;
                $data['per'] = $config['per_page'];

            //load view
            $this->template->title(' Bank Accounts ' )->build('index/list', $data);
	}

        

	private function set_paginate_options()
	{
		$config = array();
		$config['base_url'] = site_url() . 'admin/bank_accounts/index/';
		$config['use_page_numbers'] = TRUE;
	       $config['per_page'] = 100;
            $config['total_rows'] = $this->bank_accounts_m->count();
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