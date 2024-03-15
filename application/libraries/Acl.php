<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Acl
{

        // Set the instance variable
        var $ci;
        public $private;

        function __construct()
        {
                // Get the instance
                $this->ci = & get_instance();
                $this->private = $this->list_private();
                $this->ci->load->model('permissions/permissions_m');
        }

        /**
         * Check if the current or a preset role has access to a resource
         *  
         * For checking urls: $resource should be string 
         * For echo Purposes : $resource should be  array and $echo TRUE
         * 
         * @param mixed $resource
         * @param boolean $echo 
         * @return boolean
         */
        function is_allowed($resource = FALSE, $echo = FALSE)
        {
                $open = array('admin/login', 'admin/logout', 'admin/help', 'admin/change_password', 'login/index', 'logout/index', 'logout', 'login');
                //allow automatic access to internal functions
                if (preg_match('/^(xn_)/i', $this->ci->uri->segment(3)) || preg_match('/^(_)/i', $this->ci->uri->segment(3)))
                {
                        return TRUE;
                }
                // Check if the current page is to be ignored
                if (in_array($this->ci->uri->uri_string(), $open))
                {
                        // Dont need to have special access
                        return TRUE;
                }
                foreach ($this->private as $prv)
                {
                        if (strpos($this->ci->uri->uri_string(), $prv) !== false)
                        {
                                return TRUE;
                        }
                }

                $mine = $this->ci->permissions_m->get_my_groups();
                //allow admin access to all
                if (in_array(1, $mine))
                {
                        return TRUE;
                }

                $perms = $this->ci->permissions_m->get_acl();

                if (!$resource)
                {
                        $resource = $this->ci->uri->segment(2);
                }
                $ur_str = $this->ci->uri->segment(1) . '/' . $this->ci->uri->segment(2) . '/' . $this->ci->uri->segment(3, 'index');
        $scope = [];

                foreach ($perms as $p)
                {
                        $fres = $this->ci->permissions_m->fetch_resource($p->resource_id);
                        if ($fres)
                        {
                                $scope[] = $fres->resource;
                        }
                }

                if (is_array($resource))
                {
                        if ($echo)
                        {
                                if (isset($resource[0]))
                                {
                                        $mod = $resource[0];
                                        $action = isset($resource[1]) ? $resource[1] : 'index';
                                        $request = 'admin/' . $mod . '/' . $action;
                                        $allo = $this->_get_allocated($mod);

                                        return (in_array($request, $allo)) ? TRUE : FALSE;
                                }
                                else
                                {
                                        return FALSE;
                                }
                        }
                        else
                        {
                                $result = array_intersect($resource, $scope);
                                return empty($result) ? FALSE : TRUE;
                        }
                }
                else
                {
                        if (in_array($resource, $scope))
                        {
                                //check individual routes
                                $paths = $this->_get_allocated($resource);

                                $internal = $this->ci->uri->segment(3);

                                if (in_array($internal, $this->private))
                                {
                                        $paths[] = 'admin/' . $resource . '/' . $internal;
                                }
                                /*
                                 * uncomment  below to debug
                                 * 
                                  echo '<pre>Module: ';
                                  print_r($resource);
                                  echo ' <br>Uri String: ';
                                  print_r($ur_str);
                                  echo ' <br>Allowed: ';
                                  print_r($paths);
                                  echo '</pre>';
                                  die(); */
                                $split = explode('/', $ur_str, 2);
                                $has_id = FALSE;
                                if (isset($split[3]) && !empty($split[3]))
                                {
                                        $has_id = TRUE;
                                        $new = $split[0] . '/' . $split[1] . '/' . $split[2];
                                }
                                if ($has_id)
                                {
                                        return ((in_array($ur_str, $paths)) OR ( in_array($ur_str . '/index', $paths)) OR ( in_array($new, $paths))) ? TRUE : FALSE;
                                }
                                return ((in_array($ur_str, $paths)) OR ( in_array($ur_str . '/index', $paths))) ? TRUE : FALSE;
                        }
                        else
                        {
                                return FALSE;
                        }
                }
        }

    function cp_event($event, $props = [])
    {
        $url = base_url();
        //$url = (strpos(base_url(), 'x.com') !== false) ? 'http://view.smartshule.com/' : base_url();

        $sub_1 = trim(str_replace('www.', '', $url));
        $subd = rtrim(str_replace('https://', '', $sub_1), '/');
        $arr = preg_split('[\.]', $subd);
        $slug = isset($arr[0]) ? str_replace('http://', '', $arr[0]) : '';
        if ($event == 'login' || $event == 'failed_login')
        {
            $this->ci->load->library('UserAgent');

            $ua = new UserAgent();
            if ($ua->isTablet())
            {
                $platform = 'tablet';
            }
            elseif ($ua->isDesktop())
            {
                $platform = 'desktop';
            }
            elseif ($ua->isMobile())
            {
                $platform = 'mobile';
            }
            else
            {
                $platform = 'other';
            }
            $props['os'] = $ua->OS();
            $props['browser'] = $ua->Browser();
            $props['platform'] = $platform;
        }

        return $this->ci->permissions_m->add_event([
                    'account' => $this->encrypt($slug),
                    'event' => $this->encrypt($event),
                    'status' => 0,
                    'metadata' => empty($props) ? '' : serialize($props),
                    'created_on' => time()
        ]);
    }

    public function encrypt($data)
    {
        $key = 'Q7Y3d7WejdXu';
        $method = "aes-256-cbc";
        $iv = "1234567891234567";
        if (empty($key))
        {
            throw new \InvalidArgumentException("Please set key.");
        }
        if (empty($data))
        {
            throw new \InvalidArgumentException("Please set data.");
        }
        return openssl_encrypt($data, $method, $key, 0, $iv);
    }

    public function decrypt($data)
    {
        $key = 'Q7Y3d7WejdXu';
        $method = "aes-256-cbc";
        $iv = "1234567891234567";
        if (empty($key))
        {
            throw new \InvalidArgumentException("Please set key.");
        }
        if (empty($data))
        {
            throw new \InvalidArgumentException("Please set data.");
        }
        return openssl_decrypt($data, $method, $key, 0, $iv);
    }

        /**
         * Helper to fetch allocated Permissions
         * 
         * @param mixed $resource
         * @return array
         */
        function _get_allocated($resource)
        {
                $mine = $this->ci->permissions_m->get_my_groups();
                $free = $this->ci->permissions_m->fetch_by_slug($resource);
                if (!$free)
                {
                        return array();
                }
                $allo = array();
                $paths = array();
                foreach ($mine as $grp)
                {
                        $allo[] = $this->ci->permissions_m->get_assigned($grp, $free->id);
                }
                foreach ($allo as $ik => $my_rts)
                {
                        foreach ($my_rts as $rid)
                        {
                                $rr = $this->ci->permissions_m->get_route($rid);
                                if ($rr)
                                {
                                        $paths[] = 'admin/' . $resource . '/' . $rr->method;
                                }
                        }
                }
                return $paths;
        }

        /**
         * Check if Director
         * 
         * @return boolean
         */
        function is_director()
        {
                $mine = $this->ci->permissions_m->get_my_groups();
                return in_array(7, $mine) ? TRUE : FALSE;
        }

        /**
         * Frontend for Students
         * 
         * @return boolean
         */
        function is_frontend()
        {
                $mine = $this->ci->permissions_m->get_my_groups();
                return in_array(8, $mine) ? TRUE : FALSE;
        }

        /**
         * List Ignored Methods
         * 
         * @return array
         */
        function list_private()
        {
                return array('validation', 'mend_routes', 'sync', 'quick_nav', 'ajax_edit', 'quick_add', 'set_text',
                    'set_scope', 'generate_resources', 'generate_routes', 'get_extension', 'push_lower',
                    'GetInfoArray', 'fix_routes', 'new_arrear', 'get_table', '_prep_marks', 'login', 'logout', 'pick_students',
                    '_set_paginate_options', 'set_paginate_options', 'save_photo', 'update_fee', 'post_theme',
                    '__construct', 'delete', 'set_upload_options', 'fix_resources', 'fix_history', 'sms_code', 'remove_session',
                    'file_sizer', 'valid_rules', '_valid_sid', 'valid_parent', 'put_arrear', 'check_unique_mail', 'gzFile',
                    'set_thumbnail_options', 'switch_account', 'by', '_valid_csrf_nonce', 'getTable', 'fee_hub', 'fee_fix', 'post_bg','save_remarks',
                    'valid_regular', 'get_opts', 'list_bals', 'fix_arrears', '_get_csrf_nonce', 'parse_sm', 'get_class_targets',
                    '_set_rules', 'list_assoc', 'get_list', 'send', 'validation_edit', 'save_config', 'uninstall', 'mend_resources');
        }

}
