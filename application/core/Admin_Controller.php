<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{

        public $user;
        public $school;
        public $parent;
        public $terms;
        public $scope;
        public $student;
        public $classes;
        public $sms_balance;
        public $classlist;
        public $perm;
        public $side = 'sidebar';
        public $list_size = 10;
        public $oneoff = 0;
        public $poll = 0;
        public $rem;
        public $adm_prefix = '';
        public $currency = '';
        public $is_parent = FALSE;
        public $is_student = FALSE;
        public $can_text = FALSE;
    public $is_transport = FALSE;
    public $is_iga = FALSE;
    public $license = FALSE;

        public function __construct()
        {
              
                parent::__construct();
                $this->load->library('ion_auth');
                $this->load->model('portal_m');
                $this->load->model('settings/settings_m');
                $this->load->model('sms/sms_m');
                $this->load->library('Req');
                $clean = 0;

                if ($this->ion_auth->logged_in())
                {
                        $ajx = false;
                        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
                        {
                                $ajx = TRUE;
                        }
                        if (!$ajx)//dont deny ajax
                        {
                                if (!$this->acl->is_allowed() && (!preg_match('/^(admin)$/i', $this->uri->uri_string())))
                                {
                                        $this->session->set_flashdata('error', 'Access Denied');
                                        redirect('admin');
                                }
                        }
                        $this->user = $this->ion_auth->get_user();

                        if ($this->ion_auth->is_in_group($this->user->id, 8))
                        {
                                $this->is_student = TRUE;
                        }
                        if ($this->ion_auth->is_in_group($this->user->id, 6))
                        {
                                $this->is_parent = TRUE;
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
        }

                if (!$this->admin_theme->slug)
                {
                        show_error('This site has been set to use an admin theme that does not exist.');
                }
                // Set Backend Theme
                $this->template->set_theme(ADMIN_THEME);
                $this->terms = $this->_terms();
                // Set the admin theme directory for Asset library
                $this->config->set_item('asset_dir', $this->admin_theme->path . '/');
                $this->config->set_item('asset_url', BASE_URL . $this->admin_theme->web_path . '/');

                //Template configuration
                $this->template->set_theme(ADMIN_THEME)
                             ->prepend_metadata('
                                <script type="text/javascript">
                                    var flist = "' . $this->list_size . '";
                                </script>');
                 $this->school = $this->settings_m->fetch();
                if ($this->ion_auth->logged_in())
                {
                        if ($this->settings_m->is_setup())
                        {
                               
                                $this->scope = $this->permissions_m->get_scope();
                                if (isset($this->school->list_size) && $this->school->list_size > 10)
                                {
                                        $this->list_size = $this->school->list_size;
                                }
                                if (isset($this->school->prefix) && $this->school->prefix != '')
                                {
                                        $this->adm_prefix = $this->school->prefix;
                                }
                                if (isset($this->school->currency) && $this->school->currency != '')
                                {
                                        $this->currency = $this->school->currency;
                                }
                        }
                        if (!preg_match('/^(admin\/setup)/i', $this->uri->uri_string()) && !preg_match('/^(admin\/logout)/i', $this->uri->uri_string()))
                        {
                                if (!$this->settings_m->is_setup())
                                {
                                        $this->session->set_flashdata('message', 'You Must Configure School Settings Before You Can Use the System');
                                        redirect('admin/setup/');
                                }
                        }

                        if (!$this->settings_m->clean_up())
                        {
                                if (!preg_match('/^(admin)$/i', $this->uri->uri_string()) && !preg_match('/^(admin\/logout)/i', $this->uri->uri_string()) && !preg_match('/^(admin\/license)/i', $this->uri->uri_string()))
                                {
                                        ///redirect(lang('balance'));
                                }
                        }
                        $this->school->active = $this->portal_m->get_active_key();
                        $this->perm = get_perm();

                        if ($this->{lang('best')})
                        {
                                if (!$this->settings_m->bk_exists())
                                {
                                        $this->settings_m->put_bk(get_bk());
                                }
                        }

                        //$this->worker->parse_promotions();
                        if (!$this->portal_m->check_config())
                        {
                                $this->portal_m->put_config();
                        }
                        if (!$this->portal_m->has_exec() && $this->uri->segment(2) == '')
                        {
                                //$this->worker->do_invoice();
                        }
                        $this->can_text = $this->portal_m->get_text_status();

                        if (preg_match('/^(admin)$/i', $this->uri->uri_string()))
                        {
                                $this->template->set_layout('home');
                        }
                        else
                        {
                                if ($this->ion_auth->is_in_group($this->user->id, 3))
                                {
                                        $this->template
                                                     ->set_layout('teachers')
                                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                                     ->set_partial('teachers_top', 'partials/teachers_top.php');
                                }
                                else if ($this->ion_auth->is_in_group($this->user->id, 10101010))
                                {
                                        $this->template
                                                     ->set_layout('dir')
                                                     ->set_partial('dir_sidebar', 'partials/dir_side.php');
                                }
                                else
                                {
                                        $this->template->set_layout('default');
                                }
                        }

                        $this->template->set_partial('sidebar', 'partials/sidebar.php')
                                     ->set_partial('top', 'partials/top.php')
                                     ->set_partial('perms', 'partials/perms.php');
                        if (!$this->ion_auth->is_in_group($this->user->id, 1))
                        {
                                $this->side = 'p_sidebar';
                                $this->template->set_partial('p_sidebar', 'partials/p_sidebar.php');
                        }
                }
                ;
                $this->classes = $this->portal_m->get_class_options();
                $this->classlist = $this->portal_m->get_all_classes();
                $this->streams = $this->portal_m->get_all_streams();
                $this->sms_balance = $clean;
                $this->classt= $this->portal_m->get_class_teachers();
                $this->presentStds= $this->portal_m->get_present_stds();
                $this->stds= $this->portal_m->get_std();
                $this->routes= $this->portal_m->get_routes();
                $this->absentStds= $this->portal_m->get_absent_stds();
                $this->balances= $this->portal_m->get_balances();
                $this->descriptions= $this->portal_m->get_f_descriptions();
                $this->f_extras= $this->portal_m->get_fee_extras();
                $this->license= $this->portal_m->checkLicense();

                $this->rem = $this->settings_m->get_rem();

 
        }

        function _terms()
        {
                return array(
                    '1' => 'Term 1',
                    '2' => 'Term 2',
                    '3' => 'Term 3'
                );
        }

        function map_grades()
        {
                return array(
                    'A' => 12,
                    'A-' => 11,
                    'B+' => 10,
                    'B' => 9,
                    'B-' => 8,
                    'C+' => 7,
                    'C' => 6,
                    'C-' => 5,
                    'D+' => 4,
                    'D' => 3,
                    'D-' => 2,
                    'E' => 1
                );
        }

}
