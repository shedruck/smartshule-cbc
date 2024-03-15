<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class St_Controller extends MY_Controller
{

        public $school;
        public $student;
        public $passport;
        public $terms;
        public $classes;
        public $classlist;
        public $currency = '';
        public $is_student = FALSE;

        public function __construct()
        {
                parent::__construct();
                $tm = 'trs';
                $this->load->model('settings/settings_m');
                $this->load->model('portal_m');
                $this->load->model('st_m');
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

                $this->terms = $this->_terms();
                $this->classes = $this->portal_m->get_class_options();
                $this->classlist = $this->portal_m->get_all_classes();
                if ($this->ion_auth->logged_in())
                {
                        $this->user = $this->ion_auth->get_user();
                       
                        if (isset($this->school->currency) && $this->school->currency != '')
                        {
                                $this->currency = $this->school->currency;
                        }

                        if ($this->ion_auth->is_in_group($this->user->id, 8))
                        {
							
							 $this->is_student = TRUE;
							$st = $this->portal_m->get_student($this->user->id);
							$this->student = $this->worker->get_student($st->id);
								
								
							$photo = $this->student->photo ? $this->st_m->passport($this->student->photo) : 0;
							if ($photo)
							{
									$path = base_url('uploads/' . $photo->fpath . '/' . $photo->filename);
							}
							else
							{
									$avt = strtolower(substr($this->user->first_name, 0, 1));
									$path = 'assets/themes/default/img/avatar/' . $avt . '.png';
							}
							$this->passport = $path;
				
                                
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
