<?php

class Users_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function find($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('users') > 0;
    }

    function users_groups()
    {
        $this->select_all_key('users_groups');
        return $this->db->get('users_groups')->result();
    }

    function exists1($id)
    {
        $query = $this->db->get_where('users', array('id' => $id));
        $result = $query->result();

        if ($result)
            return TRUE;
        else
            return FALSE;
    }

    function count()
    {
        return $this->db->count_all_results('users');
    }

    function update_attributes($id, $data)
    {
        return $this->update_key_data($id, 'users', $data);
    }

    function populate($table, $option_val, $option_text)
    {
        $dropdowns = $this->db->select('*')
                                            ->order_by($option_text)
                                            ->get($table)->result();

        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    function delete($id)
    {
        return $this->db->delete('users', array('id' => $id));
    }

    function delete_user($id)
    {
        $this->db->delete('users', array('id' => $id));
        return $this->db->delete('users_groups', array('user_id' => $id));
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);
        $this->select_all_key('users');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('users', $limit, $offset);

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
     * Datatable Server Side Data Fetcher
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('users');

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
                    $this->db->order_by($this->dx($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
                    $this->db->_protect_identifiers = TRUE;
                }
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch))
        {
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);

                    $this->db->or_like('CONVERT(' . $this->dx('users.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->db->select('SQL_CALC_FOUND_ROWS id, ' . $this->dx('first_name') . ' as first_name,' . $this->dxa('last_name') . ',' . $this->dxa('active') . ',' . $this->dxa('email') . ',' . $this->dxa('last_login') . ',' . $this->dxa('phone') . ',' . $this->dxa('passport'), FALSE);
        $this->db->where($this->dx('users.active') . '> 0', NULL, FALSE);
        $this->db->order_by('id', 'desc');

        $rResult = $this->db->get('users');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
        // Total data set length
        $iTotal = $this->db->count_all('users');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
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
            $gp = $this->ion_auth->get_users_groups($iCol->id)->result();
            $str = '';
            foreach ($gp as $g)
            {
                $str .= '  <span class="label label-info">' . $g->description . '</span>';
            }

            $passport = $iCol->passport;
            $fake = base_url('uploads/files/member.png');
            $ppst = '<image src="' . $fake . '" width="40" height="40" class="img-polaroid" >';

            if ($passport)
            {
                $path = base_url('uploads/files/' . $passport);
                $ppst = '<image src="' . $path . '" width="40" height="40" class="img-polaroid" >';
            }



            $aaData[] = array(
                $iCol->id,
                $ppst,
                $iCol->first_name . ' ' . $iCol->last_name,
                $iCol->phone,
                $iCol->email,
                $iCol->active ? 'Active' : 'Suspended',
                $str,
                $iCol->last_login ? date('d M Y', $iCol->last_login) : ' '
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Datatable Server Side Data Fetcher
     * Filter User Group
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function filter_users($gid, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('users');

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
                    $this->db->order_by($this->dx($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
                    $this->db->_protect_identifiers = TRUE;
                }
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        if (isset($sSearch) && !empty($sSearch))
        {
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);

                    $this->db->or_like('CONVERT(' . $this->dx('users.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                }
            }
        }
        // Select Data
        $this->db->where($this->dx('users_groups.group_id') . '=' . $gid, NULL, FALSE);
        $this->db->select('SQL_CALC_FOUND_ROWS users.id, ' . $this->dx('first_name') . ' as first_name,' . $this->dxa('last_name') . ',' . $this->dxa('active') . ',' . $this->dxa('email') . ',' . $this->dxa('last_login') . ',' . $this->dxa('phone'), FALSE);
        $this->db->join('users_groups', $this->dx('user_id') . '= users.id');
        $this->db->where($this->dx('users.active') . '=1', NULL, FALSE);
        $this->db->order_by('id', 'desc');

        $rResult = $this->db->get('users');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;
        // Total data set length
        $iTotal = $this->db->count_all('users');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
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
            $gp = $this->ion_auth->get_users_groups($iCol->id)->result();
            $str = '';
            foreach ($gp as $g)
            {
                $str .= '  <span class="label label-info">' . $g->description . '</span>';
            }
            $aaData[] = array(
                $iCol->id,
                $iCol->first_name . ' ' . $iCol->last_name,
                $iCol->phone,
                $iCol->email,
                $iCol->active ? 'Active' : 'Suspended',
                $str,
                $iCol->last_login ? date('d M Y', $iCol->last_login) : ' '
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Update teacher
     * 
     * @param type $user
     * @param type $data
     */
    function upd_teacher($user, $data)
    {
        return $this->update_key_where($this->dx('user_id') . ' = ' . $user, 'teachers', $data);
    }

}
