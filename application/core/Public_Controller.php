<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function module_exists($var)
{
        return false;
}

// Code here is run before frontend controllers
class Public_Controller extends MY_Controller
{

        public $school;
        public $is_parent = FALSE;
        public $parent;
        public $terms;
        public $classes;
        public $classlist;
        public $currency = '';
        public $is_student = FALSE;
    public $is_transport = FALSE;
        public $is_iga = FALSE;
        public $can_text = FALSE;

        public function __construct()
        {
                parent::__construct();

                $this->load->model('settings/settings_m');
                $this->load->model('portal_m');
                $this->template->set_theme($this->theme->slug);
                // Set the theme view folder
                $this->template
                             ->set_theme($this->theme->slug)
                             ->append_metadata('
                        <script type="text/javascript">
                                var APPPATH_URI = "' . BASE_URI . '";
                                var BASE_URI = "' . BASE_URI . '";
                        </script>');

                // default theme directory for Asset library 
                $this->config->set_item('asset_dir', $this->theme->path . '/');
                $this->config->set_item('asset_url', BASE_URL . $this->theme->web_path . '/');
                // Is there a layout file for this module?
                if ($this->template->layout_exists($this->module . '.html'))
                {
                        $this->template->set_layout($this->module . '.html');
                }

                // use the default layout
                elseif ($this->template->layout_exists('default.html'))
                {
                        $this->template->set_layout('default.html');
                }
                if ($this->settings_m->is_setup())
                {
                        $this->school = $this->settings_m->fetch();
                }
                else
                {
                        $this->school = array();
                }
                // Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
                $this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');

                // If there is a blog module, link to its RSS feed in the head
                if (module_exists('blog'))
                {
                        $this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="' . $this->settings->site_name . '" href="' . site_url('blog/rss/all.rss') . '" />');
                }
				
                $this->terms = $this->_terms();
                $this->classes = $this->portal_m->get_class_options();
                $this->classlist = $this->portal_m->get_all_classes();
				
                if ($this->ion_auth->logged_in())
                {
					
                        $this->user = $this->ion_auth->get_user();

                        if ($this->ion_auth->is_in_group($this->user->id, 8))
                        {
                                $this->is_student = TRUE;
                        }
            if (!empty($this->config->item('transport')))
            {
                $t_g = $this->config->item('transport');
                if ($this->ion_auth->is_in_group($this->user->id, $t_g))
                {
                    $this->is_transport = TRUE;
                }
            }


                        if (!empty($this->config->item('iga'))) {
                                $iga = $this->config->item('iga');
                                if ($this->ion_auth->is_in_group($this->user->id, $iga)) {
                                        $this->is_iga = TRUE;
                                }
                        }
                        if (isset($this->school->currency) && $this->school->currency != '')
                        {
                                $this->currency = $this->school->currency;
                        }

                        if ($this->ion_auth->is_in_group($this->user->id, 6))
                        {
                                $uss = $this->user->id;
                                $this->is_parent = TRUE;
                                $this->parent = $this->portal_m->get_profile($uss);

                                $this->parent->profile = $this->portal_m->get_profile($uss);
                                $this->parent->kids = $this->portal_m->get_kids($this->parent->user_id);

                                //Logic For Switching Student
                                if ($this->is_parent && $this->parent->kids)
                                {
                                        $mine = array();
                                        foreach ($this->parent->kids as $p)
                                        {
                                                $mine[] = $p->id;
                                        }

                                        if ($this->input->get('switch'))
                                        {
                                                $def = $this->input->get('switch');
                                                //limit to my  kids only
                                                if (!in_array($def, $mine))
                                                {
                                                        $def = $mine[0];
                                                }
                                                $this->session->set_userdata('student_id', $def);
                                        }
                                        else if ($this->session->userdata('student_id'))
                                        {
                                                $def = $this->session->userdata('student_id');
                                        }
                                        else
                                        {
                                                $def = $mine[0];
                                                $this->session->set_userdata('student_id', $def);
                                        }
                                        if (!isset($def))
                                        {
                                                $def = $mine[0];
                                                $this->session->set_userdata('student_id', $def);
                                        }
                                        $this->student = $this->portal_m->get_student($def);
                                }
                                else
                                {
                                        $this->student = array();
                                }
                        }
                }
				
				//print_r('Rest');die;

                $this->template->server = $_SERVER;
        }

        function _terms()
        {
                return array(
                    '1' => 'Term 1',
                    '2' => 'Term 2',
                    '3' => 'Term 3',
                );
        }

}
