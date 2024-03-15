<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Iga_Controller extends MY_Controller
{

    public $school;

    public $terms;
    public $classes;
    public $classlist;
    public $is_iga = FALSE;
    public $avatar;
    public $currency = '';

    public function __construct()
    {
        parent::__construct();
        $tm = 'iga';
        $this->load->model('settings/settings_m');
        $this->load->model('portal_m');
        // Set the theme view folder
        $this->template
            ->set_theme($tm)
            ->append_metadata('
                            <script type="text/javascript">
                                 var BASE_URI = "' . BASE_URI . '";
                            </script>');

        // default theme directory for Asset library 
        $this->config->set_item('asset_dir', base_url() . 'assets/themes/' . $tm . '/');
        $this->config->set_item('asset_url', FCPATH . 'assets/themes/' . $tm . '/');

        // use the default layout
        if ($this->template->layout_exists('default.php')) {
            $this->template->set_layout('default.php');
        }
        if ($this->settings_m->is_setup()) {
            $this->school = $this->settings_m->fetch();
        } else {
            $this->school = [];
        }
        // Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
        $this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');

        $this->terms = $this->_terms();
        $this->classes = $this->portal_m->get_class_options();
        $this->classlist = $this->portal_m->get_all_classes();
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->get_user();
            $this->user->avt = strtolower(substr($this->user->first_name, 0, 1));
            $path = 'assets/themes/iga/img/avatar/' . $this->user->avt . '.png';

            $this->avatar = $path;
            if (isset($this->school->currency) && $this->school->currency != '') {
                $this->currency = $this->school->currency;
            }
            if (!empty($this->config->item('iga'))) {
                $iga = $this->config->item('iga');
                if ($this->ion_auth->is_in_group($this->user->id, $iga)) {
                    $this->is_iga = TRUE;
                }
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
