<?php

class Trs_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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
	
	
        function update_qa($id, $data)
        {
                return $this->db->where('id', $id)->update('qa_answers', $data);
        } 
		

    function check_sub($tr, $id)
    {

        return $this->db->where(array('teacher' => $tr, 'subject' => $id))->get('subjects_assign')->row();
    }

    /**
     * Get Current Students in Various Activities
     * 
     * @param int $term
     * @param int $year
     */
    function get_current($term, $year)
    {
        $this->select_all_key('extras_teacher');
        $res = $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE)
                          ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                          ->where($this->dx('teacher') . '=' . $this->user->id, NULL, FALSE)
                          ->join('activities', $this->dx('activity') . ' = activities.id')
                          ->order_by('created_on', 'DESC')
                          ->get('extras_teacher')
                          ->result();

        $final = array();
        foreach ($res as $e)
        {
            $act = $this->get_activity($e->activity);
            $students = $this->get_students($e->activity, $term, $year);
            $final[] = (object) array('id' => $e->activity, 'title' => $act->name, 'count' => count($students));
        }

        return $final;
    }

    function all_classes()
    {
        $classids = $this->get_assigned();
        $cls = $this->db->where('class_teacher', $this->user->id)->where('status', 1)->get('classes')->result();

        foreach ($cls as $c)
        {
            $classids[] = $c->id;
        }

        return $classids;
    }

    function get_assigned()
    {
        if (!isset($this->profile->id))
        {
            return [];
        }
        $clss = $this->db->select('class')->where('teacher', $this->profile->id)->get('subjects_assign')->result();
        $list = [];
        foreach ($clss as $c)
        {
            $list[] = $c->class;
        }

        return $list;
    }

    function get_subjects_assigned()
    {
        if (!isset($this->profile->id))
        {
            return [];
        }
        $clss = $this->db->select('class, subject, type')->where('teacher', $this->profile->id)->get('subjects_assign')->result();
        $list = [];
        foreach ($clss as $c)
        {
            $list[$c->class][] = ['subject' => $c->subject, 'type' => $c->type];
        }

        return $list;
    }

    /**
     * List My classes as Class teacher
     * 
     * @return type
     */
    function get_teacher_classes($all = false)
    {
        $cls = $all ?
                          $this->db->get('classes')->result() :
                          $this->db->where('class_teacher', $this->user->id)
                                            ->get('classes')
                                            ->result();
        $classids = [];

        foreach ($cls as $c)
        {
            $classids[] = $c->id;
        }

        return $classids;
    }

    /**
     * List My classes as Class teacher
     * 
     * @return type
     */
    function list_my_classes($activity = 0, $all = false)
    {
        $ast = $this->get_subjects_assigned();

        $subjects = $this->populate('subjects', 'id', 'name');
        $cbc = $this->populate('cbc_subjects', 'id', 'name');
        $map = [];
        foreach ($ast as $k => $sbs)
        {
            if (!isset($map[$k]))
            {
                $map[$k] = '';
            }
            foreach ($sbs as $s)
            {
                $opts = $s['type'] == 1 ? $subjects : $cbc;
                $map[$k] .= isset($opts[$s['subject']]) ? '<li class="text-black">' . strtoupper($opts[$s['subject']]) . '</li>' : '';
            }
        }

        $classids = $this->get_teacher_classes($all);
        $assigned = $this->get_assigned();
        $ids = array_merge($classids, $assigned);

        $fn = [];
        $res = [];
	

        if (empty($ids))
        {
            return [];
        }
        if ($activity == 9999999999999999)
        {
            $roster = $this->get_students($activity, get_term(date('m')), date('Y'));

            $rids = array();
            foreach ($roster as $r)
            {
                $rids[] = $r->student;
            }
            if (empty($rids))
            {
                $rids = array(0);
            }
            $ls = $this->db->select('id,' . $this->dxa('class'), FALSE)
                              ->where('id  IN  (' . implode(',', $rids) . ')', NULL, FALSE)
                              ->where($this->dx('admission.status') . '= 1', NULL, FALSE)
                              ->get('admission')
                              ->result();
        }
        else
        {
            $ls = $this->db->select('id,' . $this->dxa('class'), FALSE)
                              ->where($this->dx('admission.class') . ' IN  (' . implode(',', $ids) . ')', NULL, FALSE)
                              ->where($this->dx('admission.status') . '= 1', NULL, FALSE)
                              ->get('admission')
                              ->result();
        }

        foreach ($ls as $ll)
        {
            $fn[$ll->class][] = $ll->id;
        }
        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();
        foreach ($fn as $ci => $list)
        {
            $rw = $this->fetch_class($ci);

            if (!$rw)
            {
                $sft = ' - ';
                $st = ' - ';
            }
            else
            {
                $sft = isset($classes[$rw->class]) ? $classes[$rw->class] : ' - ';
                $st = isset($streams[$rw->stream]) ? $streams[$rw->stream] : ' - ';
            }

            //$res[] = (object) array('id' => $rw->id, 'name' => $sft . ' ' . $st, 'count' => count($list), 'title' => isset($map[$rw->id]) ? $map[$rw->id] : '<span class="bg-red">Class Teacher</span>', 'rec' => $rw->rec);
			
            $res[] = (object) array('id' => $rw->id, 'name' => $sft . ' ' . $st, 'count' => count($list), 'title' => isset($map[$rw->id]) ? $map[$rw->id] : '');

        }

        return $res;
    }

    function my_students()
    {
        $classids = $this->get_teacher_classes(false);

        $res = array();

        if (empty($classids))
        {
            return array();
        }

        $ls = $this->db->select('id,' . $this->dxa('class') . ',' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
                          ->where($this->dx('admission.class') . ' IN  (' . implode(',', $classids) . ')', NULL, FALSE)
                          ->where($this->dx('admission.status') . '= 1', NULL, FALSE)
                          ->get('admission')
                          ->result();
        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();

        foreach ($ls as $st)
        {
            $clm = $this->portal_m->fetch_class($st->class);

            if (empty($clm))
            {
                continue;
            }
            $class_name = isset($classes[$clm->class]) ? $classes[$clm->class] : ' - ';
            $strm = isset($streams[$clm->stream]) ? $streams[$clm->stream] : '';

            $res[$st->id] = $st->first_name . ' ' . $st->last_name . ' (' . $class_name . ' ' . $strm . ')';
        }

        return $res;
    }

     function my_kids()
    {
        $classids = $this->get_teacher_classes(false);

        $res = array();

        if (empty($classids))
        {
            return array();
        }

        return $this->db->select('id,' . $this->dxa('class') . ',' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
                          ->where($this->dx('admission.class') . ' IN  (' . implode(',', $classids) . ')', NULL, FALSE)
                          ->where($this->dx('admission.status') . '= 1', NULL, FALSE)
                          ->get('admission')
                          ->result();
        }

    /**
     * get_students
     * 
     * @param int $activity
     * @param int $term
     * @param int $year
     * @return type
     */
    function get_students($activity, $term, $year)
    {
        $this->select_all_key('extras');
        return $this->db->where($this->dx('term') . '=' . $term, NULL, FALSE)
                                            ->where($this->dx('activity') . '=' . $activity, NULL, FALSE)
                                            ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                                            ->order_by('id', 'ASC')
                                            ->get('extras')
                                            ->result();
    }

    function get_activity($id)
    {
        return $this->db->where(array('id' => $id))->get('activities')->row();
    }

    function list_class_parents()
    {
        $cls = $this->db->where('class_teacher', $this->user->id)->get('classes')->result();
        $classids = array();

        foreach ($cls as $c)
        {
            $classids[] = $c->id;
        }
        if (empty($classids))
        {
            return array();
        }

        $ls = $this->db->select('id,' . $this->dxa('class'), FALSE)
                          ->where($this->dx('admission.class') . ' IN  (' . implode(',', $classids) . ')', NULL, FALSE)
                          ->where($this->dx('admission.status') . '= 1', NULL, FALSE)
                          ->get('admission')
                          ->result();

        $final = array();
        foreach ($ls as $st)
        {
            $student = $this->worker->get_student($st->id);
            $parents = $this->get_parent($st->id);

            foreach ($parents as $p)
            {
                if ($p->user)
                {
                    $final[$p->user] = $p->name . ' (' . $student->first_name . ' ' . $student->last_name . ')';
                }
            }
        }
        return $final;
    }

    /**
     * List Parent(s) for selected Student
     * 
     * @param int $id
     * @return type
     */
    function get_parent($id)
    {
        $list = $this->db->where(array('student_id' => $id))->get('assign_parent')->result();
        $pids = array();
        foreach ($list as $p)
        {
            $parent = $this->find_parent($p->parent_id);

            $pids[] = (object) array('id' => $parent->id, 'user' => $parent->user_id, 'name' => $parent->first_name . ' ' . $parent->last_name);
        }
        return $pids;
    }

    function find_parent($id)
    {
        $this->select_all_key('parents');
        return $this->db->where('id', $id)
                                            ->get('parents')
                                            ->row();
    }

    function fetch_class($id)
    {
        return $this->db->where(array('id' => $id))->get('classes')->row();
    }

    /** STUDENTS PER CLASS TEACHER
     * Datatable Server Side Data Fetcher
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_extras_students($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $this->select_all_key('admission');

        $activity = $this->session->userdata('extrra');
        if (!$activity)
        {
            return array(
                'sEcho' => intval($sEcho),
                'iTotalRecords' => 0,
                'iTotalDisplayRecords' => 0,
                'aaData' => array()
            );
        }
        $roster = $this->get_students($activity, get_term(date('m')), date('Y'));

        $rids = array();
        foreach ($roster as $r)
        {
            $rids[] = $r->student;
        }
        if (empty($rids))
        {
            $rids = array(0);
        }

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
        $colsearch = array();
        if (isset($sSearch) && !empty($sSearch))
        {
            for ($ix = 0; $ix < count($aColumns); $ix++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $ix, true);
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $colsearch[] = $aColumns[$ix]; // store searchable cols only
                }
            }
        }

        if (isset($sSearch) && !empty($sSearch))
        {
            $schstr = '';
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    if ($i == 1)
                    {
                        $schstr .= ' ( CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'";
                    }
                    else
                    {
                        $schstr .= ' OR CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'";
                    }
                    $schstr .= $i == count($colsearch) ? ')' : '';
                }
            }
            if (!empty($schstr))
            {
                $this->db->where($schstr, NULL, FALSE);
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('admission');
        $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname, ' . $this->dx('parents.email') . ' as parent_email, ' . $this->dx('parents.address') . ' as address, ' . $this->dx('parents.phone') . ' as phone, ', FALSE);
        $this->db->join('parents', 'parents.id = ' . $this->dx('parent_id'));
        $this->db->order_by('admission.id', 'desc');
        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
        $this->db->where('admission.id  IN  (' . implode(',', $rids) . ')', NULL, FALSE);
        $rResult = $this->db->get('admission');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)
                          ->where('admission.id  IN  (' . implode(',', $rids) . ')', NULL, FALSE)
                          ->count_all_results('admission');

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
            //$output['aaData'][] = $row;
            $obData[] = $row;
        }

        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;


            $passport = $this->portal_m->student_passport($iCol->photo);
            $fake = base_url('uploads/files/member.png');
            $ppst = '<image src="' . $fake . '" width="80" height="80" class="thumb-sm img-circle" >';

            if ($passport)
            {
                $path = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
                $ppst = '<image src="' . $path . '" width="80" height="80" class="thumb-sm img-circle" >';
            }


            $adm = '';
            if (!empty($iCol->old_adm_no))
            {
                $adm = $iCol->old_adm_no;
            }
            else
            {
                $adm = $iCol->admission_number;
            }
            $crow = $this->fetch_class($iCol->class);
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
                $iCol->gender,
                '<h5 class="m-0">' . ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name) . '</h5>',
                $adm,
                $sft . ' ' . $st
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /** STUDENTS PER CLASS TEACHER
     * Datatable Server Side Data Fetcher
     * 
     * @param int $iDisplayStart
     * @param int $iDisplayLength
     * @param type $iSortCol_0
     * @param int $iSortingCols
     * @param string $sSearch
     * @param int $sEcho
     */
    function get_per_class($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho, $class)
    {
        $cls = $this->db->where('class_teacher', $this->user->id)->where('status', 1)->get('classes')->result();
        $classids = $this->get_assigned();

        foreach ($cls as $c)
        {
            $classids[] = $c->id;
        }
        if (empty($classids))
        {
            return array(
                'sEcho' => intval($sEcho),
                'iTotalRecords' => 0,
                'iTotalDisplayRecords' => 0,
                'aaData' => array()
            );
        }

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
        $colsearch = array();
        if (isset($sSearch) && !empty($sSearch))
        {
            for ($ix = 0; $ix < count($aColumns); $ix++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $ix, true);
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $colsearch[] = $aColumns[$ix]; // store searchable cols only
                }
            }
        }
        if (isset($sSearch) && !empty($sSearch))
        {
            $schstr = '';
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    if ($i == 1)
                    {
                        $schstr .= ' ( CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'";
                    }
                    else
                    {
                        $schstr .= ' OR CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'";
                    }
                    $schstr .= $i == count($colsearch) ? ')' : '';
                }
            }
            if (!empty($schstr))
            {
                $this->db->where($schstr, NULL, FALSE);
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
        $this->select_all_key('admission');
        $this->db->select($this->dx('parents.first_name') . ' as parent_fname, ' . $this->dx('parents.last_name') . ' as parent_lname, ' . $this->dx('parents.email') . ' as parent_email, ' . $this->dx('parents.address') . ' as address, ' . $this->dx('parents.phone') . ' as phone, ', FALSE);
        $this->db->join('parents', 'parents.id = ' . $this->dx('parent_id'));
        $this->db->order_by('admission.id', 'desc');
        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
        $this->db->where($this->dx('admission.class') . ' = ' . $class, NULL, FALSE);
        $this->db->where($this->dx('admission.class') . ' IN  (' . implode(',', $classids) . ')', NULL, FALSE);
        $rResult = $this->db->get('admission');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->where($this->dx('status') . ' = 1', NULL, FALSE)
                          ->where($this->dx('admission.class') . ' IN  (' . implode(',', $classids) . ')', NULL, FALSE)
                          ->count_all_results('admission');

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
            //$output['aaData'][] = $row;
            $obData[] = $row;
        }

        $classes = $this->ion_auth->list_classes();
        $streams = $this->ion_auth->get_stream();

        foreach ($obData as $iCol)
        {
            $iCol = (object) $iCol;


            $passport = $this->portal_m->student_passport($iCol->photo);
            $fake = base_url('uploads/files/member.png');
            $ppst = '<image src="' . $fake . '" width="80" height="80" class="thumb-sm img-circle" >';

            if ($passport)
            {
                $path = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
                $ppst = '<image src="' . $path . '" width="80" height="80" class="thumb-sm img-circle" >';
            }


            $adm = '';
            if (!empty($iCol->old_adm_no))
            {
                $adm = $iCol->old_adm_no;
            }
            else
            {
                $adm = $iCol->admission_number;
            }
            $crow = $this->fetch_class($iCol->class);
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
                $ppst,
                '<h5 class="m-0">' . ucwords($iCol->first_name) . ' ' . ucwords($iCol->last_name) . '</h5>',
                $adm,
                $sft . ' ' . $st
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    /**
     * get_assignments
     * 
     * @param type $id
     * @return type
     */
    function get_assignments($id)
    {
        $ids = $this->db->select('assgn_id')->where('created_by', $this->user->id)
                          ->where('class', $id)
                          ->get('assignment_list')
                          ->result();
        $list = array();
        foreach ($ids as $i)
        {
            $list[] = $i->assgn_id;
        }
        if (empty($list))
        {
            $list = array(0);
        }
        return $this->db
                                            ->where_in('id', $list)
                                            ->order_by('created_on', 'DESC')
                                            ->get('assignments')
                                            ->result();
    }

    /**
     * get_extras_assignments
     * 
     * @param type $id
     * @return type
     */
    function get_extras_assignments($id)
    {
        $ids = $this->db->select('assgn_id')->where('created_by', $this->user->id)
                          ->where('activity', $id)
                          ->get('assignment_extras')
                          ->result();
        $list = array();
        foreach ($ids as $i)
        {
            $list[] = $i->assgn_id;
        }
        if (empty($list))
        {
            $list = array(0);
        }
        return $this->db
                                            ->where_in('id', $list)
                                            ->order_by('created_on', 'DESC')
                                            ->get('assignments')
                                            ->result();
    }

    public function trCreateHobby($data){
        return $this->db->insert('favourite_hobbies', $data);
    }

    public function teacherViewHobbies(){
        $id=$this->ion_auth->get_user()->id;
        //$this->select_all_key('admission');
        return $this->db->select('favourite_hobbies.*')
            ->where('favourite_hobbies.created_by',$id)
            ->join('admission', 'admission.id = favourite_hobbies.student')
            ->get('favourite_hobbies')
            ->result();
    }

    public function appraisalresults($year,$term){
        $user_id= $this->ion_auth->get_user()->id;
        $this->select_all_key('teachers');
        $this->select('appraisal_results.*');
        $this->select('appraisal_targets.*');
        return $this->db
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->where('appraisal_results.user_id',$user_id)
                    ->where('appraisal_targets.year',$year)
                    ->where('appraisal_targets.term',$term)
                    ->get('appraisal_results')
                    ->result();
    }

    public function appraisalyears(){
        $user_id= $this->ion_auth->get_user()->id;
        // $this->select('appraisal_results.*');
        $this->select('appraisal_targets.year');
        return $this->db
                    ->group_by('appraisal_targets.year')
                    ->order_by('year','desc')
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->where('appraisal_results.user_id',$user_id)
                    ->get('appraisal_results')
                    ->result();
    }

     public function appraisalterms($year){
        $user_id= $this->ion_auth->get_user()->id;
        // $this->select('appraisal_results.*');
        $this->select('appraisal_targets.term');
        return $this->db
                    ->group_by('appraisal_targets.term')
                    ->order_by('appraisal_targets.term','asc')
                    ->join('appraisal_targets','appraisal_targets.id=appraisal_results.target')
                    ->join('teachers','teachers.id=appraisal_results.teacher')
                    ->where('appraisal_results.user_id',$user_id)
                    ->where('appraisal_targets.year',$year)
                    ->get('appraisal_results')
                    ->result();
    }

    public function checkpast_date(){
        // $today=date('m/d/y', time());
        $this->load->helper('date');
        $format = "%Y-%m-%d";
        $today =mdate($format);
        return $this->db->order_by('target','ASC')->where('end_date >',$today)->get('appraisal_targets')->result();
    }

    public function insertresults($data)
    {
        return  $this->db->insert('appraisal_results', $data);
    }

    public function getteacher(){
        $user_id= $this->ion_auth->get_user()->id;
        $this->select_all_key('teachers');
        return $this->db
                    ->where($this->dx('user_id') . '=' . $user_id, NULL, FALSE)
                    ->get('teachers')
                    ->result();
    }

    /*this method checks if the current teacher has already submitted his or
    her appraisal ratings*/
   public function limitteacher($t_id,$teacher){
    return $this->db
                ->limit(1)
                ->where('teacher',$teacher)
                ->where('target',$t_id)
                ->get('appraisal_results')
                ->result();
    }

    public  function checkappraisee_rate(){
        $user_id=$this->ion_auth->get_user()->id;

        $this->select('appraisal_targets.id');
        return $this->db    
                    ->where('NOT EXISTS(SELECT target FROM appraisal_results
                    WHERE appraisal_results.target = 
                    appraisal_targets.id AND user_id = "'.$user_id.'")', '', FALSE)
                    ->get('appraisal_targets')
                    ->result();
    }

    public function get_target_by_id($target){
        return $this->db    
                    ->where('id',$target)
                    ->get('appraisal_targets')
                    ->result();
    }

    public function get_assigned_subjects(){
        $id=$this->ion_auth->get_user()->id;
        $this->select_all_key('teachers');
        $this->select('subjects.*');
        $this->select('subjects_assign.*');
        return $this->db   
                    
                    ->join('teachers','teachers.id=subjects_assign.teacher')
                    ->join('subjects','subjects.id = subjects_assign.subject')
                    ->where($this->dx('teachers.user_id') . '=' . $id, NULL, FALSE)
                    // ->where('teachers.user_id',$id)
                    ->get('subjects_assign')
                    ->result();
    }

   

}
