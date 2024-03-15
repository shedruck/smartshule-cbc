<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trs_Controller extends MY_Controller
{

        public $school;
        public $teacher;
        public $profile;
        public $terms;
        public $classes;
        public $classlist;
        public $streams;
        public $currency = '';
        public $is_teacher = FALSE;

        public function __construct()
        {
                parent::__construct();
                $tm = 'teachers';
                $this->load->model('settings/settings_m');
                $this->load->model('portal_m');
                $this->load->model('trs_m');
                $this->template->set_theme($tm);
                // Set the theme view folder
                $this->template
                             ->set_theme($tm)
                             ->append_metadata('
                            <script type="text/javascript">
                                var APPPATH_URI = "' . BASE_URI . '";
                                var BASE_URI = "' . BASE_URI . '";
                            </script>');

                // default theme directory for Asset library 
                $this->config->set_item('asset_dir', base_url() . 'assets/themes/' . $tm . '/');
                $this->config->set_item('asset_url', FCPATH . 'assets/themes/' . $tm . '/');
                // Is there a layout file for this module?
                if ($this->template->layout_exists($this->module . '.html'))
                {
                        $this->template->set_layout($this->module . '.html');
                }

                // use the default layout
                elseif ($this->template->layout_exists('default.php'))
                {
                        $this->template->set_layout('default.php');
                }


                $this->template->set_partial('top', 'partials/top.php')
                ->set_partial('sidebar', 'partials/sidebar.php');


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

                $this->terms = $this->_terms();
                $this->classes = $this->portal_m->get_class_options();
                $this->classlist = $this->portal_m->get_all_classes();
                $this->streams = $this->portal_m->get_all_streams();
                if ($this->ion_auth->logged_in())
                {
                        $this->user = $this->ion_auth->get_user();

                        if (isset($this->school->currency) && $this->school->currency != '')
                        {
                                $this->currency = $this->school->currency;
                        }

                        if ($this->ion_auth->is_in_group($this->user->id, 3))
                        {
                                $this->is_teacher = TRUE;
                                $this->teacher = $this->user;
								$this->profile = $this->portal_m->get_teacher_profile($this->user->id);
                        }
                }
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
