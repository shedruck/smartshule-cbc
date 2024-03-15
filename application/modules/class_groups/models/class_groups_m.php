<?php

class Class_groups_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('class_groups', $data);
        return $this->db->insert_id();
    }

    function get_class($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('class_groups')->row();
    }

    function class_id($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row()->class;
    }

    function get_all()
    {
        return $this->db->where('status', 1)->order_by('class', 'DESC')->get('classes')->result();
    }

    function get_all_cg()
    {
        return $this->db->get('class_groups')->result();
    }

    function get_all_class_stream()
    {
        return $this->db->select('classes.*')->order_by('created_on', 'DESC')->get('classes')->result();
        //return $this->db->select('classes.*')->order_by('created_on', 'DESC')->group_by('class_id')->get('classes')->result();
    }

    function get_stream()
    {

        $result = $this->db->select('class_stream.*')
                          ->order_by('created_on', 'DESC')
                          ->get('class_stream')
                          ->result();
        $arr = array();

        foreach ($result as $res)
        {
            $arr[$res->id] = $res->name;
        }

        return $arr;
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('class_groups') > 0;
    }

    function exists_class($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('classes') > 0;
    }

    function cl_exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('classes') > 0;
    }

    function add_stream($data)
    {
        $this->db->insert('classes', $data);
        return $this->db->insert_id();
    }

    function fetch_streams($class)
    {
        $all = $this->db->select('id,stream')->where('class', $class)->get('classes')->result();
        $fn = array();
        $list = $this->populate('class_stream', 'id', 'name');
        foreach ($all as $s)
        {
            $tt = isset($list[$s->stream]) ? $list[$s->stream] : ' -';
            $fn[] = $tt;
        }
        return $fn;
    }

    /**
     * Update Class
     * 
     * @param type $id
     * @param type $data
     * @return type
     */
    function update_class($id, $data)
    {
        return $this->update_key_data($id, 'admission', $data);
    }

    function update_history($data)
    {
        $this->insert_key_data('history', $data);
        return $this->db->insert_id();
    }

    function count()
    {
        return $this->db->count_all_results('class_groups');
    }

    /**
     * Fetch Class Options
     * 
     * @return type
     */
    function get_classes()
    {
        $list = $this->db->select('id, class,stream')
                          ->where('status', 1)
                          ->order_by('class')
                          ->get('classes')
                          ->result();
        $cls = array();

        $class_name = $this->populate('class_groups', 'id', 'name');
        $stream_name = $this->populate('class_stream', 'id', 'name');
        foreach ($list as $l)
        {
            $ccname = (isset($class_name[$l->class])) ? $class_name[$l->class] : "Other";
            $strname = (isset($stream_name[$l->stream])) ? $stream_name[$l->stream] : "Other";

            $cls[$l->id] = $ccname . ' ' . $strname;
        }
        return $cls;
    }

    /**
     * Get List of Students Admitted in Specified Class
     * 
     * @param int $id the Class ID
     */
    function get_population($id)
    {
        $this->select_all_key('admission');
        $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
        return $this->db->where($this->dx('class') . '=' . $id, NULL, FALSE)
                                            ->where($this->dx('status') . '=1', NULL, FALSE)
                                            ->get('admission')
                                            ->result();
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('class_groups', $data);
    }

    function classes_update($id, $data)
    {
        return $this->db->where('id', $id)->update('classes', $data);
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
        //return $this->db->delete('class_groups', array('id' => $id));
    }

    /**
     * Fetch Current Invoice
     * 
     * @param type $student
     * @return type
     */
    function get_current_invoice($student)
    {
        $row = $this->db->where(array('student_id' => $student, 'term' => get_term(date('m')), 'year' => date('Y')))->get('invoices')->row();
        return $row ? $row->id : FALSE;
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
    function list_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('admission');

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
                    $this->db->order_by($this->dx('admission.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);
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
            $orstr = '';
            $or = ' OR ';
            $yx = 0;
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $prefx = $yx ? $or : '';
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $orstr .= $prefx . 'CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
                    $yx++;
                }
            }
            
            $outer_or = $or . 'CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
            $outer_or .= $or . 'CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.middle_name') . ')' . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
            $outer_or .= $or . 'CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.middle_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') LIKE '%{$sSearch}%' " . PHP_EOL;
            $this->db->where(" (" . $orstr . $outer_or . ")", NULL, FALSE);
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('admission');
        $this->db->order_by('admission.first_name', 'asc');
        if ($this->session->userdata('pop'))
        {
            $pop = $this->session->userdata('pop');
            $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
        }
        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
        $rResult = $this->db->get('admission');
        
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        if ($this->session->userdata('pop'))
        {
            $pop = $this->session->userdata('pop');
            $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
        }
        $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all_results('admission');

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

        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;

            $adm = '';
            if (!empty($iCol->old_adm_no))
            {
                $adm = $iCol->old_adm_no;
            }
            else
            {
                $adm = $iCol->admission_number;
            }
            $crow = $this->portal_m->fetch_class($iCol->class);
            if (!$crow)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
            }
            $aaData[] = array(
                $iCol->id,
                ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name),
                $sft . ' ' . $st,
                $adm,
                ''
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Datatable Server Side Data Fetcher
     * 
     * @param array $aColumns
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('classes');
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
                    $this->db->order_by($aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir));
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
                    $this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                }
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        //$this->db->where('status', 1);
        $rResult = $this->db->order_by('class', 'DESC')->get('classes');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->where('status', 1)->count_all('classes');

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

        $classes = $this->get_class_options();
        $streams = $this->populate('class_stream', 'id', 'name');

        foreach ($obData as $iCol)
        {

            $iCol = (object) $iCol;
            $size = $this->count_population($iCol->id);

            $ct = isset($classes[$iCol->class]) ? $classes[$iCol->class] : ' - ';
            $sft = isset($classes[$iCol->class]) ? $ct : ' - ';
            $st = isset($streams[$iCol->stream]) ? $streams[$iCol->stream] : '   ';
            $u = $this->ion_auth->get_user($iCol->class_teacher);
            $tr = '<i style="color:red">No Class Teacher </i>';
            if ($iCol->class_teacher > 0)
            {

                $tr = $u->first_name . ' ' . $u->last_name;
            }

            $studis = ' Students';
            if ($size == 1)
            {
                $studis = ' Student';
            }

            $rec = 'Marks ';
            if ($iCol->rec == 2)
            {
                $rec = 'Remarks ';
            }

            $aaData[] = array(
                $iCol->id,
                $sft . ' ' . $st,
                $tr,
                $size . ' ' . $studis,
                $rec,
                $iCol->status ? 'Active' : 'Disabled',
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * Fetch Class Row by ID
     * 
     * @class  int $id
     * @return object
     */
    function fetch_class($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    function count_population($class)
    {
        return $this->db->where($this->dx('class') . ' =' . $class, NULL, FALSE)
                               ->where($this->dx('status') . ' = 1', NULL, FALSE)
                              
                  ->count_all_results('admission');
    }

    /**
     * Fetch Classes
     * 
     * @return type
     */
    function get_class_options()
    {
        $list = $this->db->select('id, name')
                          ->where('status', 1)
                          ->order_by('id')
                          ->get('class_groups')
                          ->result();
        $cls = array();
        foreach ($list as $l)
        {
            $cls[$l->id] = $l->name;
        }
        return $cls;
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  class_groups (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");


        //$this->db->query("ALTER TABLE class_groups ADD COLUMN IF NOT EXISTS education_system VARCHAR(256)");
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);
        $this->db->where('status', 1);
        $this->db->order_by('class', 'desc');
        $query = $this->db->get('classes', $limit, $offset);

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

    //Teacher's Class
    function my_class($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $u = $this->ion_auth->get_user()->id;
        $this->db->where('status', 1);
        $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
        $res = array();
        if (!empty($cls->id))
        {
            $the_class = $cls->id;
            $this->db->where('id', $the_class);
            $this->db->order_by('class', 'desc');
            $res = $this->db->get('classes', $limit, $offset)->result();
        }
        return $res;
    }

    function paginate_cg($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('class_groups', $limit, $offset);

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

}
