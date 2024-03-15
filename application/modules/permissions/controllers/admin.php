<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }

        if (!$this->acl->is_allowed())
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => '<b style="color:red">Sorry you do not have permission to access this Module!!</b>'));
            redirect('admin');
        }
        $this->load->model('permissions_m');
    }

    public function index()
    {
        redirect('admin/permissions/assign');
        $config = $this->_set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['permissions'] = $this->permissions_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Permissions ')->build('admin/list', $data);
    }

    /**
     * View Allocated Permissions
     * 
     */
    function view()
    {
        //$data['perms'] = $this->permissions_m->populate('permissions', 'id', 'display_name');
        $data['groups'] = $this->permissions_m->populate('groups', 'id', 'name');
        $this->template->title('Specific Module Permissions')->build('admin/permission', $data);
    }

    function set_menu()
    {
        $val = $this->input->post('val');
        $name = $this->input->post('name');
        $id = str_replace('menu', '', $name);
        $menu = $val == 'true' ? 1 : 0;

        if ($id)
        {
            $xr = array(
                'is_menu' => $menu
            );
            $this->permissions_m->update_route($id, $xr);
        }
    }
 
    /**
     * Assign Permissions
     * 
     */
    public function assign()
    {
        $this->form_validation->set_rules($this->perm_validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            $slist = $this->input->post('sids');
            $group = $this->input->post('group');
            $i = 0;
            $j = 0;

            if (is_array($slist) && count($slist))
            {
                foreach ($slist as $s)
                {
                    if ($group)
                    {
                        $xr = array(
                            'resource_id' => $s,
                            'group_id' => $group,
                        );
                        $has_id = $this->permissions_m->is_assigned($s, $group);

                        if ($has_id)
                        {
                            //update assignment
                            $this->permissions_m->put_permission($xr + array('modified_on' => time(), 'modified_by' => $this->user->id), $has_id);
                            $j++;
                        }
                        else
                        {
                            // insert new assignment
                            $pm = $this->permissions_m->put_permission($xr + array('created_on' => time(), 'created_by' => $this->user->id));
                            if ($pm)
                            {
                                $route = $this->permissions_m->get_index_route($s);
                                if ($route)
                                {
                                    $rt = array(
                                        'group_id' => $group,
                                        'route_id' => $route->id,
                                        'res_id' => $s,
                                        'created_on' => time(),
                                        'created_by' => $this->user->id,
                                    );
                                    $done = $this->permissions_m->put_route($rt);
                                    $i++;

                                    $details = implode(' , ', $rt);
                                    $user = $this->ion_auth->get_user();
                                    $log = array(
                                        'module' => $this->router->fetch_module(),
                                        'item_id' => $done,
                                        'transaction_type' => $this->router->fetch_method(),
                                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                                        'details' => $details,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                    );

                                    $this->ion_auth->create_log($log);
                                }
                            }
                        }
                    }
                }
            }

            $mess = 'Status: Granted ' . $i . '  Permissions and Updated ' . $j . ' Existing Permissions ';
            $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));

            redirect('admin/permissions/assign');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->perm_validation() as $field)
            {
                $prop = $field['field'];
                $get->$prop = set_value($prop);
            }

            $data['result'] = $get;
            $data['list'] = array();
            $data['groups'] = $this->permissions_m->populate('groups', 'id', 'name');
            //load view
            $this->template->title(' Assign Modules ')->build('admin/assign', $data);
        }
    }

    function _valid_sid()
    {
        $sid = $this->input->post('sids');
        if (is_array($sid) && count($sid))
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_valid_sid', 'Please Select at least one Item.');
            return FALSE;
        }
    }

    private function perm_validation()
    {
        $config = array(
            array(
                'field' => 'sids',
                'label' => 'Permissions List',
                'rules' => 'xss_clean|callback__valid_sid'),
            array(
                'field' => 'group',
                'label' => 'User Group',
                'rules' => 'required')
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    /**
     * Return Permissions allocated to selected User Group
     */
    function list_assoc($id = 0)
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->permissions_m->get_by_group($id, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    /**
     * Permissions List
     * 
     * @param type $id
     */
    function get_list()
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->permissions_m->get_list($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    private function _set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/permissions/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->permissions_m->count();
        $config['uri_segment'] = 4;

        $config['first_link'] = lang('web_first');
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = lang('web_last');
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

        return $config;
    }

    function get_routes($group, $id)
    {
        $list = $this->permissions_m->populate('resources', 'id', 'resource');
        $gplist = $this->permissions_m->populate('groups', 'id', 'name');
        $rname = isset($list[$id]) ? $list[$id] : ' ';
        $gname = isset($gplist[$group]) ? $gplist[$group] : ' ';
        $sel = $this->permissions_m->get_sub_permissions($id);
        $allowed = $this->permissions_m->get_assigned($group, $id);
        $methods = array();
        foreach ($sel as $kt => $rt)
        {
            $methods[$kt]['id'] = $rt['id'];
            $methods[$kt]['method'] = $rt['method'];
            $methods[$kt]['checked'] = in_array($kt, $allowed) ? 1 : 0;
        }
        $ttl = '<strong>Module: </strong>' . humanize($rname) . '  <strong>User Group: </strong>' . ucwords($gname) . '</p>';
        $htt = '<table width="100%"> <tr> 
                           <div class="form-group"> ';
        $i = 1;
        foreach ($methods as $fk => $ss)
        {
            $str = (isset($ss['checked']) && $ss['checked'] == 1) ? 'checked="checked"' : '';
            $s = (object) $ss;

            if (!(($i++) % 2))
            {
                $htt .= '<td> <input type="checkbox" value="' . $s->id . '" ' . $str . ' class="ck"> ' . humanize($s->method) . '</div></td></tr><tr>';
            }
            else
            {
                $htt .= '<td>  <input type="checkbox" value="' . $s->id . '"  ' . $str . ' class="ck"> ' . humanize($s->method) . '</div></td>';
                if ($i == (count($sel) + 1))
                {
                    $htt .= '<td> </td>';
                }
            }
        }

        $htt .= '</table>';
        $res = array('title' => $ttl, 'text' => $htt);
        echo json_encode($res);
    }

    /**
     * Fix Routing
     * 
     */
    function fix_routes()
    {
        $get = $this->permissions_m->fetch_routes();
        $data['result'] = $get;
        $data['resources'] = $this->permissions_m->populate('resources', 'id', 'resource');
        //load the view and the layout
        $this->template->title('Fix Routing ')->build('admin/arfix', $data);
    }

    /**
     * Fix resources
     * 
     */
    function fix_resources()
    {
        $get = $this->permissions_m->fetch_resources();
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Fix Resources ')->build('admin/resfix', $data);
    }

    /**
     * Update Route ajax
     */
    function mend_routes()
    {

        $name = $this->input->post('name');
        $ttl = $this->input->post('value');
        if ($name)
        {
            $dest = explode('__', $name);
            if (count($dest))
            {
                $sid = $dest[1];
                $rmk = array(
                    $dest[0] => $ttl,
                    'modified_on' => time(),
                    'modified_by' => $this->user->id,
                );
                //update route
                $this->permissions_m->update_route($sid, $rmk);
            }
        }
    }

    function mend_resources()
    {
        $name = $this->input->post('name');
        $val = $this->input->post('value');
        if ($name && $val)
        {
            $dest = explode('_', $name);
            if (count($dest))
            {
                $sid = $dest[1];
                $rmk = array(
                    $dest[0] => $val,
                    'modified_on' => time(),
                    'modified_by' => $this->user->id,
                );

                //update route
                $this->permissions_m->update_resource($sid, $rmk);
            }
        }
    }

    /**
     * Set Scope
     * 
     */
    function set_scope()
    {
        $ids = $this->input->post('ids');
        $group = $this->input->post('group');
        $res = $this->input->post('res');
        $fids = explode(',', $ids);

        if (count($fids))
        {
            $set = $this->permissions_m->get_assigned($group, $res);
            $chuck = array_diff($set, $fids);
            if (!empty($chuck))
            {
                foreach ($chuck as $c)
                {
                    $this->permissions_m->remove_by_id($group, $res, $c);
                }
            }
            foreach ($fids as $f)
            {
                $rtid = $this->permissions_m->if_path($group, $f);
                if ($rtid)
                {
                    $rt = array(
                        'modified_on'
                        => time(),
                        'modified_by' => $this->user->id,
                    );
                    $this->permissions_m->put_route($rt, $rtid);
                }
                else
                {
                    $route = $this->permissions_m->get_route($f);
                    if ($route)
                    {
                        $rt = array('group_id' => $group,
                            'route_id' => $f,
                            'res_id' => $route->resource,
                            'created_on' => time(),
                            'created_by' => $this->user->id,
                        );
                        $this->permissions_m->put_route($rt);
                    }
                }
            }
        }
    }

    /**
     * Generate Resources( All Modules )
     * 
     */
    function generate_resources()
    {
        $directories = array();
        $path = realpath(APPPATH . '/modules/');
        $iterator = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);

        foreach ($iterator as $path)
        {
            if ($path->isDir())
            {
                $cache = $this->GetInfoArray($path->__toString());
                isset($cache) ? $directories[] = $cache : "";
                unset($cache);
            }
        }
        sort($directories);
        $i = 0;
        $cats = $this->_map_cats();
        foreach ($directories as $folder)
        {
            $hide = array('account_types',
                'accounts',
                'accounting',
                'quickbooks',
                'rest',
                'emails',
                'email_templates',
                'setup',
                'permissions',
                'sandbox',
                'tools',
                'uploads');
            if (in_array($folder, $hide))
            {
                continue;
            }

            $ct = isset($cats[$folder]) ? $cats[$folder] : '';
            $log = array(
                'resource' => $folder,
                'cat' => $ct,
                'description' => humanize($folder),
                'created_on' => time(),
                'created_by' => $this->ion_auth->get_user()->id,
            );
            if (!$this->permissions_m->exists_by_name($folder))
            {
                $this->permissions_m->put_resources($log);
                $i++;
            }
        }
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Added ' . $i . ' New Resources'));
        redirect('admin/permissions/assign');
    }

    /**
     * Generate Routes( All Module Controllers with 
     * Corresponding Public Methods)
     * 
     */
    function generate_routes()
    {
        $res = $this->permissions_m->get_resources();

        $methods = array();
        foreach ($res as $r)
        {
            $controller = APPPATH . 'modules/' . $r->resource . '/controllers/admin.php';
            preg_match_all('/function (\w+)/', file_get_contents($controller), $m);

            $his = array();
            foreach ($m[1] as $ttle)
            {
                if (!in_array($ttle, $this->acl->list_private()) && strpos($ttle, 'validation') === FALSE && strpos($ttle, 'do_upload') === FALSE && strpos($ttle, 'removed') === FALSE && strpos($ttle, '1') === FALSE && strpos($ttle, 'old') === FALSE && $this->starts_with($ttle, '_') == FALSE)
                {
                    $his[] = $ttle;
                }
            }
            $methods[$r->resource] = $his;
        }

        $i = 0;
        foreach ($methods as $mod => $method)
        {
            $module = $this->permissions_m->fetch_by_slug($mod);

            if ($module)
            {
                foreach ($method as $m)
                {
                    if (!$this->permissions_m->route_exists($module->id, $m))
                    {
                        $suff = $m == 'index' ? '' : ucwords(humanize($m)) . ' ';
                        $suff .= $module->description;
                        if ($m == 'create')
                        {
                            $suff = 'Add New ';
                        }

                        $icons = array(
                            'index' => 'clip-list',
                            'create' => 'clip-plus-circle-2',
                            'edit' => 'clip-pencil',
                            'search' => 'clip-search',
                            'void' => 'clip-close-4',
                            'voided' => 'clip-close-4');
                        $rts = array(
                            'resource' => $module->id,
                            'method' => $m,
                            'icon' => isset($icons[$m]) ? $icons[$m] : '',
                            'is_menu' => ($m == 'create' || $m == 'edit' ) ? 0 : 1,
                            'description' => $suff,
                            'created_on' => time(),
                            'created_by' => $this->ion_auth->get_user()->id,
                        );

                        $this->permissions_m->put_methods($rts);
                        $i++;
                    }
                }
            }
        }
        $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Added ' . $i . ' New Routes'));
        redirect('admin/permissions/assign');
    }

    private function GetInfoArray($path)
    {
        $d = new SplFileInfo($path);
        if ($d->getBasename() == "." || $d->getBasename() == "..")
        {
            return;
        }
        else
        {
            $r = array(
                "pathname" => $d->getPathname(),
                "access" => $d->getATime(),
                "modified" => $d->getMTime(),
                "permissions" => $d->getPerms(),
                "size" => $d->getSize(),
                "type" => $d->getType(),
                "path" => $d->getPath(),
                "basename" => $d->getBasename(),
                "filename" => $d->getFilename()
            );
            return $d->getBasename();
        }
    }

    function starts_with($haystack, $needle)
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    function _map_cats()
    {
        return array(
            "activities" => "Administration",
            "add_stock" => "Inventory",
            "address_book" => "Communication",
            "address_book_category" => "Communication",
            "admission" => "Administration",
            "advance_salary" => "Accounts",
            "allowances" => "Accounts",
            "assign_bed" => "Administration",
            "assignments" => "Academics",
            "bank_accounts" => "Accounts",
            "book_fund" => "Library",
            "book_fund_stock" => "Library",
            "books" => "Library",
            "books_category" => "Library",
            "books_stock" => "Library",
            "borrow_book" => "Library",
            "borrow_book_fund" => "Library",
            "class_attendance" => "Academics",
            "class_groups" => "Academics",
            "class_rooms" => "Academics",
            "class_stream" => "Academics",
            "class_timetable" => "Academics",
            "deductions" => "Accounts",
            "disciplinary" => "Administration",
            "employees_attendance" => "Users",
            "exams" => "Academics",
            "expense_items" => "Accounts",
            "expenses" => "Accounts",
            "expenses_category" => "Accounts",
            "extra_curricular" => "Administration",
            "fee_arrears" => "Accounts",
            "fee_extras" => "Accounts",
            "fee_payment" => "Accounts",
            "fee_pledge" => "Accounts",
            "fee_structure" => "Accounts",
            "fee_waivers" => "Accounts",
            "give_items" => "Inventory",
            "grades" => "Academics",
            "grading" => "Academics",
            "grading_system" => "Academics",
            "groups" => "Users",
            "hostel_beds" => "Administration",
            "hostel_rooms" => "Administration",
            "hostels" => "Administration",
            "house" => "Administration",
            "invoices" => "Accounts",
            "items" => "Inventory",
            "items_category" => "Inventory",
            "leaving_certificate" => "Administration",
            "library_settings" => "Library",
            "medical_records" => "Administration",
            "parents" => "Users",
            "paye" => "Accounts",
            "petty_cash" => "Accounts",
            "placement_positions" => "Administration",
            "purchase_order" => "Accounts",
            "record_salaries" => "Accounts",
            "record_sales" => "Accounts",
            "reports" => "Reports",
            "return_book" => "Library",
            "return_book_fund" => "Library",
            "salaries" => "Accounts",
            "sales_items" => "Accounts",
            "sales_items_category" => "Accounts",
            "sales_items_stock" => "Accounts",
            "events" => "Academics",
            "sms" => "Communication",
            "sms_templates" => "Communication",
            "stock_taking" => "Inventory",
            "students_placement" => "Administration",
            "sub_cats" => "Academics",
            "subjects" => "Academics",
            "suspended" => "Administration",
            "tax_config" => "Accounts",
            "teachers" => "Users",
            "transport" => "Administration",
            "users" => "Users"
        );
    }

}
