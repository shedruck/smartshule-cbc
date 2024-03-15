<?php

class Teachers_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        return $this->insert_key_data('teachers', $data);
    }

    function find($id)
    {
        $this->select_all_key('teachers');
        return $this->db->where(array('id' => $id))->get('teachers')->row();
    }

    function list_()
    {
        $this->select_all_key('teachers');
        return $this->db->order_by('id', 'desc')->group_by('status')->get('teachers')->result();
    }

    function filterbystatus($status)
    {
        $this->select_all_key('teachers');
                return  $this->db->where($this->dx('status'). '= "'.$status.'"', null, false )
                ->get('teachers')
                ->result();
    }

    function get($id)
    {
        $this->select_all_key('teachers');
        return $this->db->where($this->dx('user_id') . ' = ' . $id, NULL, FALSE)->get('teachers')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('teachers') > 0;
    }

    function exists_teacher($id)
    {
        return $this->db->where($this->dx('user_id') . ' = ' . $id, NULL, FALSE)->count_all_results('teachers') > 0;
    }

    function exists_email($email)
    {
        return $this->db->where($this->dx('email') . " = '" . $email . "'", NULL, FALSE)->count_all_results('users') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('teachers');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('teachers', $data);
    }

    /**
     * Update Teacher Record
     * 
     * @param int $id
     * @param array $data
     * @return boolean
     */
    function update_teacher($id, $data)
    {
        return $this->update_key_data($id, 'teachers', $data);
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
        return $this->db->delete('teachers', array('id' => $id));
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
        $aColumns = $this->db->list_fields('teachers');

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
                    $this->db->order_by($this->dx('teachers.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir)), FALSE);

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
                    $this->db->or_like('CONVERT(' . $this->dx('teachers.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->select_all_key('teachers');
        $this->db->order_by('created_on', 'DESC');
        $rResult = $this->db->get('teachers');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all('teachers');

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
            $u = $this->ion_auth->get_user($iCol->user_id);
            $st = isset($status[$iCol->status]) ? $status[$iCol->status] : ' - ';
            $status = 'Active';
            $path = base_url('uploads/files/' . $iCol->passport);
            $fake = base_url('uploads/files/member.png');

            if (!empty($iCol->passport))
            {
                $ppst = '<image src="' . $path . '" width="40" height="40" class="img-polaroid" >';
            }
            else
            {
                $ppst = '<image src="' . $fake . '" width="40" height="40" class="img-polaroid" >';
            }



            if ($st == 1)
            {
                $status = 'Inactive';
            }

            $aaData[] = array(
                $iCol->id,
                $ppst,
                $iCol->first_name . ' ' . $iCol->middle_name . ' ' . $iCol->last_name,
                $u->phone,
                $u->email,
                $u->active ? 'Active' : 'Suspended',
                $iCol->designation,
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function paginate_all($limit = 1000, $page)
    {
        $this->select_all_key('teachers');
        $this->db->where($this->dx('status') . ' = 1', NULL, FALSE);

        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('teachers', $limit, $offset);

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

    function paginate_inactive($limit = 1000, $page)
    {
        $this->select_all_key('teachers');
        $this->db->where($this->dx('status') . ' = 0', NULL, FALSE);

        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('teachers', $limit, $offset);

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

    function assign_unit($data)
    {
        $this->db->insert('units_assign', $data);
        return $this->db->insert_id();
    }

    function get_datatable_assign($sEcho, $id)
    {
        $teacher_data = $this->db->where('teacher', $id)->order_by('created_on', 'desc')->get('units_assign')->result();
        $levels = $this->populate('course_levels', 'id', 'name');
        $unit_title = $this->populate('course_units', 'id', 'unit_title');
        $unit_code = $this->populate('course_units', 'id', 'unit_code');

        $aaData = array();
        $classes = $this->ion_auth->fetch_classes();
        $i = 0;
        foreach ($teacher_data as $key => $value)
        {
            $aaData[] = array(
                $value->id,
                $unit_code[$value->unit] . ' ' . $unit_title[$value->unit],
                $classes[$value->course] . ' - <br/>' . $value->intake_month . ' ' . $value->intake_year . ' Intake',
            );
            $i++;
        }
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $i,
            'iTotalDisplayRecords' => $i,
            'aaData' => array()
        );

        $output['aaData'] = $aaData;

        return $output;
    }

    
    function get_teachers()
    {
        //$this->db->select('teachers.id as id ,' . $this->dxa('first_name') . ', ' . $this->dxa('last_name'), FALSE);
        $this->db->select('teachers.id as id ,' . $this->dx('teachers.first_name') . ' as first_name, ' . $this->dx('teachers.last_name') . ' as last_name', FALSE);
        return $this->db->where($this->dx('teachers.status') . ' != 0', NULL, FALSE)
                                            ->join('teachers', 'users.id=' . $this->dx('user_id'))
                                            ->get('users')
                                            ->result();
    }

    function list_teachers()
    {
        $list = $this->get_teachers();
        $options = array();
        foreach ($list as $r)
        {
            $options[$r->id] = $r->first_name . ' ' . $r->last_name;
        }
        return $options;
    }

    function make_assigned($teacher, $class, $mode)
    {
        $res = array();
        $classes = $this->get_teacher_classes($teacher);
        if (!$class)
        {
            return (object) array('mine' => $classes, 'subjects' => array());
        }

        $row = $this->portal_m->fetch_class($class);
        $subjects = $mode == 1 ? $this->get_subjects($row->class) : $this->get_cbc($row->class);

        $ids = [];
        foreach ($classes as $c)
        {
            if ($c->class == $class)
            {
                $ids[] = $c->subject;
            }
        }
        $titles = $this->populate('subjects', 'id', 'name');
        $cbc = $this->populate('cbc_subjects', 'id', 'name');

        foreach ($subjects as $ss)
        {
            $opts = $mode == 1 ? $titles : $cbc;
            $res[] = (object) ['id' => $ss, 'subject' => isset($opts[$ss]) ? $opts[$ss] : ' - ', 'has' => in_array($ss, $ids) ? 1 : 0];
        }

        return (object) ['mine' => $classes, 'subjects' => $res];
    }

    function get_teacher_classes($teacher, $class = 0, $mode = 0)
    {
        if ($class)
        {
            $this->db->where('class', $class);
        }
        if ($mode)
        {
            $this->db->where('type', $mode);
        }
        return $this->db->where('teacher', $teacher)
                                            ->get('subjects_assign')
                                            ->result();
    }

    function get_subjects($class)
    {
        $list = $this->db->where('class_id', $class)
                          ->get('subjects_classes')
                          ->result();
        $fcl = array();
        foreach ($list as $f)
        {
            $fcl[$f->subject_id] = $f->subject_id;
        }

        return $fcl;
    }

    function get_cbc($class)
    {
        $list = $this->db->where('class_id', $class)
                          ->get('cbc')
                          ->result();
        $fcl = [];
        foreach ($list as $f)
        {
            $fcl[$f->subject_id] = $f->subject_id;
        }

        return $fcl;
    }

    function assign($data)
    {
        $this->db->insert('subjects_assign', $data);
        return $this->db->insert_id();
    }

    function remove_assigned($teacher, $class, $subject, $mode)
    {
        return $this->db->delete('subjects_assign', ['teacher' => $teacher, 'class' => $class, 'type' => $mode, 'subject' => $subject]);
    }

    public function get_allocation_report(){
        $this->select_all_key('teachers');
        return $this->db
              ->select('subjects.*')
              ->select('subjects_classes.*')
              ->select('subjects_assign.class,subjects_assign.teacher,subjects_assign.created_on as date_Add')
              ->order_by('subjects_assign.id','desc')
              ->join('subjects','subjects.id=subjects_assign.subject')
              ->join('subjects_classes','subjects_classes.subject_id= subjects_assign.subject')
              ->join('teachers','teachers.id = subjects_assign.teacher')
              ->get('subjects_assign')
              ->result();

    }
    public function allocated_classes(){
        $this->select_all_key('teachers');
        return $this->db
              ->select('subjects.*')
              ->select('subjects_classes.*')
              ->select('subjects_assign.class,subjects_assign.teacher,subjects_assign.created_on as date_Add')
              ->order_by('subjects_assign.id','desc')
              ->join('subjects','subjects.id=subjects_assign.subject')
              ->join('subjects_classes','subjects_classes.subject_id= subjects_assign.subject')
              ->join('teachers','teachers.id = subjects_assign.teacher')
              ->group_by('subjects_assign.class')
              ->get('subjects_assign')
              ->result();

    }

    public function getTeachers(){
        $this->select_all_key('teachers');
        return $this->db
              ->select('subjects.*')
              ->select('subjects_classes.*')
              ->select('subjects_assign.class,subjects_assign.teacher,subjects_assign.created_on as date_Add')
              ->order_by('subjects_assign.id','desc')
              ->join('subjects','subjects.id=subjects_assign.subject')
              ->join('subjects_classes','subjects_classes.subject_id= subjects_assign.subject')
              ->join('teachers','teachers.id = subjects_assign.teacher')
              ->group_by('subjects_assign.teacher')
              ->get('subjects_assign')
              ->result();

    }

    public function getSubjects(){
        $this->select_all_key('teachers');
        return $this->db
              ->select('subjects.*')
              ->select('subjects_classes.*')
              ->select('subjects_assign.class,subjects_assign.teacher,subjects_assign.created_on as date_Add,subjects_assign.subject')
              ->order_by('subjects_assign.id','desc')
              ->join('subjects','subjects.id=subjects_assign.subject')
              ->join('subjects_classes','subjects_classes.subject_id= subjects_assign.subject')
              ->join('teachers','teachers.id = subjects_assign.teacher')
              ->group_by('subjects.id')
              ->get('subjects_assign')
              ->result();

    }

    public function filter_allocation($class, $subject){
        $this->select_all_key('teachers');
        return $this->db
              ->select('subjects.*')
              ->select('subjects_classes.*')
              ->select('subjects_assign.class,subjects_assign.teacher,subjects_assign.created_on as date_Add')
              ->order_by('subjects_assign.id','desc')
              ->join('subjects','subjects.id=subjects_assign.subject')
              ->join('subjects_classes','subjects_classes.subject_id= subjects_assign.subject')
              ->join('teachers','teachers.id = subjects_assign.teacher')
              ->where('subjects_assign.class',$class)
              ->where('subjects.id',$class)
            //   ->group_by('subjects_assign.class')
              ->get('subjects_assign')
              ->result();
    }

}
