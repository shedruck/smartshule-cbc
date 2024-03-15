<?php

class Permissions_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        //$this->db->insert('resources', $data);
        // return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('resources')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('resources') > 0;
    }

    /**
     * Determine if Route Exists
     * 
     * @param type $resid
     * @param type $method
     * @return type
     */
    function route_exists($resid, $method)
    {
        return $this->db->where(array('resource' => $resid, 'method' => $method))->count_all_results('routes') > 0;
    }

    function exists_by_name($name)
    {
        return $this->db->where(array('resource' => $name))->count_all_results('resources') > 0;
    }

    function count()
    {
        return $this->db->count_all_results('resources');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('resources', $data);
    }

    function populate($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    function delete($id)
    {
        return $this->db->delete('resources', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  permissions (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	display_name  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('resources', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row)
        {
            $result[] = $row;
        }

        if ($result)
        {
            return $result;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * get_my_groups
     * 
     * @return type
     */
    function get_my_groups()
    {
        $ugs = $this->ion_auth->get_user()->groups;
        $grps = array();
        foreach ($ugs as $g)
        {
            $grps[] = $g->id;
        }
        return$grps;
    }

    /**
     * Fetch Permissions
     * 
     * @return type
     */
    function get_acl()
    {
        $gg = $this->get_my_groups();
        $ff = array();
        $fn = array();
        foreach ($gg as $g)
        {
            $ff[] = $this->db->where('group_id', $g)->get('group_permissions')->result();
        }
        foreach ($ff as $farr)
        {
            foreach ($farr as $d)
            {
                $fn[] = $d;
            }
        }
        return $fn;
    }

    /**
     * fetch_resource
     * 
     * @param type $id
     * @return type
     */
    function fetch_resource($id)
    {
        $res = $this->db->where(array('id' => $id))->get('resources')->row();
        return $res ? $res : FALSE;
    }

    /**
     * fetch_by_slug
     * 
     * @param type $slug
     * @return type
     */
    function fetch_by_slug($slug)
    {
        $mod = $this->db->where('resource', $slug)->get('resources')->row();
        return $mod ? $mod : FALSE;
    }

    /**
     * Save all Methods
     * 
     * @param type $data
     * @return type
     */
    function put_methods($data)
    {
        $this->db->insert('routes', $data);
        return $this->db->insert_id();
    }

    /**
     * Save All Resources (Modules)
     * 
     * @param type $data
     * @return type
     */
    function put_resources($data)
    {
        $this->db->insert('resources', $data);
        return $this->db->insert_id();
    }

    /**
     * Fetch All Resources
     * 
     * @return type
     */
    function get_resources()
    {
        return $this->db->get('resources')->result();
    }

    /**
     * List Permissions Datatable
     * 
     * @param type $id Group ID
     * @param type $iDisplayStart
     * @param type $iDisplayLength
     * @param type $iSortCol_0
     * @param type $iSortingCols
     * @param type $sSearch
     * @param type $sEcho
     * @return type
     */
    function get_by_group($id, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('group_permissions');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        // Ordering
        if (isset($iSortCol_0))
        {
            for ($i = 0; $i < intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true')
                {
                    $this->db->_protect_identifiers = FALSE;
                    $this->db->order_by('group_permissions.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                    $this->db->_protect_identifiers = TRUE;
                }
            }
        }

        if (isset($sSearch) && !empty($sSearch))
        {
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    if ($aColumns[$i] == 'student')
                    {
                        $this->db->join('admission', 'student=admission.id');
                        $this->db->or_like('CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') ", $sSearch, 'both', FALSE);
                        $this->db->or_like('CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') ", $sSearch, 'both', FALSE);
                        $this->db->or_like('CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') ", $sSearch, 'both', FALSE);
                    }
                    else
                    {
                        $this->db->or_like('group_permissions.' . $aColumns[$i], $sSearch, 'both', FALSE);
                    }
                }
            }
        }

        // Select Data
        $rResult = $this->db
          ->where('group_id', $id)
          ->order_by('group_permissions.id', 'desc')
          ->get('group_permissions');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db
          ->where('group_id', $id)
          ->count_all_results('group_permissions');

        // Output
        $output = array(
                  'sEcho' => intval($sEcho),
                  'iTotalRecords' => $iTotal,
                  'iTotalDisplayRecords' => (isset($sSearch) && !empty($sSearch)) ? $iFilteredTotal : $iTotal,
                  'aaData' => array()
        );

        $aaData = array();
        $obData = array();
        foreach ($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach ($aRow as $Key => $Value)
            {
                if ($Key && $Key !== ' ')
                {
                    $row[$Key] = $Value;
                }
            }
            $obData[] = $row;
        }
        $perms = $this->populate('resources', 'id', 'resource');
        $pgs = $this->populate('groups', 'id', 'name');
        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;
            $sp = isset($perms[$iCol->resource_id]) ? $perms[$iCol->resource_id] : '-';
            $gp = isset($pgs[$iCol->group_id]) ? $pgs[$iCol->group_id] : '-';
            $aaData[] = array(
                      $iCol->id,
                      $iCol->resource_id,
                      $sp,
                      $gp, ''
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * List Permissions
     * 
     * @param type $iDisplayStart
     * @param type $iDisplayLength
     * @param type $iSortCol_0
     * @param type $iSortingCols
     * @param type $sSearch
     * @param type $sEcho
     * @return type
     */
    function get_list($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('resources');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        // Ordering
        if (isset($iSortCol_0))
        {
            for ($i = 0; $i < intval($iSortingCols); $i++)
            {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true')
                {
                    $this->db->_protect_identifiers = FALSE;
                    $this->db->order_by('resources.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                    $this->db->_protect_identifiers = TRUE;
                }
            }
        }
        //Searching
        if (isset($sSearch) && !empty($sSearch))
        {
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like('resources.' . $aColumns[$i], $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $rResult = $this->db
          ->order_by('resources.id', 'asc')
          ->get('resources');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db
          ->count_all_results('resources');

        // Output
        $output = array(
                  'sEcho' => intval($sEcho),
                  'iTotalRecords' => $iTotal,
                  'iTotalDisplayRecords' => (isset($sSearch) && !empty($sSearch)) ? $iFilteredTotal : $iTotal,
                  'aaData' => array()
        );

        $aaData = array();
        $obData = array();
        foreach ($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach ($aRow as $Key => $Value)
            {
                if ($Key && $Key !== ' ')
                {
                    $row[$Key] = $Value;
                }
            }
            $obData[] = $row;
        }

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;
            $aaData[] = array(
                      $iCol->id,
                      $iCol->resource,
                      $iCol->description,
                      ''
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Check if Group already has Specified Permission
     * 
     * @param type $permission
     * @param type $group
     * @return boolean
     */
    function is_assigned($permission, $group)
    {
        $row = $this->db->where('resource_id', $permission)
            ->where('group_id', $group)
            ->get('group_permissions')->row();
        if (empty($row))
        {
            return FALSE;
        }
        else
        {
            return $row->id;
        }
    }

    /**
     * put_permission
     * 
     * @param array $data
     * @param int $has_id
     * @return void
     */
    function put_permission($data, $has_id = 0)
    {
        if ($has_id)
        {
            //update
            return $this->db->where('id', $has_id)->update('group_permissions', $data);
        }
        else
        {
            $this->db->insert('group_permissions', $data);
            return $this->db->insert_id();
        }
    }

    /**
     * Get Module Permissions
     * 
     * @param int $id
     */
    function get_sub_permissions($id)
    {
        $xx = $this->db->select('id, method')
          ->where('resource', $id)
          ->get('routes')
          ->result();
        $fx = array();
        foreach ($xx as $x)
        {
            $fx[$x->id] = array('id' => $x->id, 'method' => $x->method);
        }
        return $fx;
    }

    /**
     * If Already assigned 
     * 
     * @param type $id
     * @return type
     */
    function if_path($group, $route)
    {
        $row = $this->db->where('group_id', $group)->where('route_id', $route)->get('permissions')->row();
        return $row ? $row->id : FALSE;
    }

    /**
     * Fetch Scope
     * 
     * @return array
     */
    function get_scope()
    {
        $gs = $this->get_my_groups();
        $scope = array();
        foreach ($gs as $g)
        {
            $scope[$g] = $this->get_assigned_scope($g);
        }
        return $scope;
    }

    function get_scope_mini()
    {
        $gs = $this->get_my_groups();
        $scope = array();
        foreach ($gs as $g)
        {
            $scope[$g] = $this->get_assigned_scope($g);
        }
        return $scope;
    }

    /**
     * Fetch Current Users Scope to build the Menu
     * 
     * @param int $group
     * @return array
     */
    function get_assigned_scope($group)
    {
        $list = $this->db->select('res_id,route_id')
          ->where('group_id', $group)
          ->get('permissions')
          ->result();
        $fids = array();
        foreach ($list as $l)
        {
            $res = $this->fetch_resource($l->res_id);
            $rt = $this->get_route($l->route_id);

            if (($res && $rt ) && $rt->is_menu)
            {
                $cat = trim($res->cat);
                if (!empty($cat))
                {
                    $fids[$cat][] = array('module' => $res->resource, 'method' => $rt->method, 'title' => $rt->description, 'icon' => $rt->icon);
                }
            }
        }
        return $fids;
    }

    /**
     * Get Route by id
     * 
     * @param type $id
     * @return type
     */
    function get_route($id)
    {
        $row = $this->db->where('id', $id)->get('routes')->row();
        return $row ? $row : FALSE;
    }

    /**
     * Fetch All Routes
     * 
     * @return type
     */
    function fetch_routes()
    {
        return $this->db->get('routes')->result();
    }

    function fetch_resources()
    {
        return $this->db->get('resources')->result();
    }

    function update_route($id, $data)
    {
        $this->db->where('id', $id)->update('routes', $data);
    }

    function update_resource($id, $data)
    {
        $this->db->where('id', $id)->update('resources', $data);
    }

    /**
     * Return 'List' Route for a resource
     * 
     * @param type $resource
     * @return type
     */
    function get_index_route($resource)
    {
        $row = $this->db->where('resource', $resource)->where('method', 'index')->get('routes')->row();
        return $row ? $row : FALSE;
    }

    /**
     * Put Route if Not Exists
     * 
     * @param array $data
     * @param int $id
     */
    function put_route($data, $id = 0)
    {
        if ($id)
        {
            $this->db->where('id', $id)->update('permissions', $data);
        }
        else
        {
            $this->db->insert('permissions', $data);
            $irt = $this->db->insert_id();
        }
    }

    function add_event($data)
    {
        $qdb = $this->load->database('evt', TRUE);
        $qdb->insert('accounts', $data);
        return $this->db->insert_id();
    }

    /**
     * Fetch Assigned Roles
     * 
     * @param int $group
     * @param int $resource
     */
    function get_assigned($group, $resource)
    {
        $list = $this->db->select('route_id')
          ->where('group_id', $group)
          ->where('res_id', $resource)
          ->get('permissions')
          ->result();
        $fids = array();
        foreach ($list as $l)
        {
            $fids[] = $l->route_id;
        }
        return $fids;
    }

    /**
     * Remove Row by Id
     * 
     * @param int $group
     * @param int $resource
     * @param int $route
     */
    function remove_by_id($group, $resource, $route)
    {
        $row = $this->db->where(array('group_id' => $group, 'res_id' => $resource, 'route_id' => $route))
            ->get('permissions')->row();
        if ($row)
        {
            $this->db->delete('permissions', array('id' => $row->id));
        }
    }

}
