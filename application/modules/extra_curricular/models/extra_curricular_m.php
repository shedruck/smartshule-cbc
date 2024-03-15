<?php

class Extra_curricular_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                return $this->insert_key_data('extras', $data);
        }
		
		
    function exists($id)
    {
          return $this->db->where( array('activity' => $id))->count_all_results('extras') >0;
    }
	
	  function delete($id)
    {
        return $this->db->delete('extras', array('id' => $id));
     }

        /**
         * Get Current Students in Various Activities
         * 
         * @param int $term
         * @param int $year
         */
        function by_activity($id)
        {
                $this->select_all_key('extras');
                return $this->db ->where($this->dx('activity').'='.$id, NULL, FALSE)->order_by('created_on', 'DESC')
                                          ->get('extras')
                                          ->result();
        }

		/**
         * Get Current Students in Various Activities
         * 
         * @param int $term
         * @param int $year
         */
        function get_extras()
        {
                $this->select_all_key('extras');
                return $this->db ->order_by('created_on', 'DESC')
                                          ->get('extras')
                                          ->result();
        }

		/**
         * Get Current Students in Various Activities
         * 
         * @param int $term
         * @param int $year
         */
        function get_current($term, $year, $activity = 0)
        {
                $this->select_all_key('extras');
                if ($activity)
                {
                        $this->db->where($this->dx('activity') . '=' . $activity, NULL, FALSE);
                }
                return $this->db
				                        ->where($this->dx('term') . '=' . $term, NULL, FALSE)
                                          ->where($this->dx('year') . '=' . $year, NULL, FALSE)
                                          ->order_by('created_on', 'DESC')
                                          ->get('extras')
                                          ->result();
        }

        function get_parent($student)
        {
                return $this->db->where('student_id', $student)
                                          ->where('status', 1)
                                          ->get('assign_parent')
                                          ->result();
        }

        function get_activity($id)
        {
                return $this->db->where(array('id' => $id))->get('activities')->row();
        }

        function fetch_full_students($class)
        {
                $list = $this->db->select('id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name'), FALSE)
                             ->where($this->dx('class') . '=' . $class, NULL, FALSE)
                             ->where($this->dx('status') . ' = 1', NULL, FALSE)
                             ->get('admission')
                             ->result();
                $fnlist = array();
                foreach ($list as $l)
                {
                        $fnlist[] = array('id' => (int) $l->id, 'text' => $l->first_name . ' ' . $l->last_name);
                }
                return $fnlist;
        }

        /**
         * populate
         * 
         * @param type $table
         * @param type $option_val
         * @param type $option_text
         * @return type
         */
        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by('created_on', 'DESC')->get($table);
                $dropdowns = $query->result();
                $options = array();
                foreach ($dropdowns as $dropdown)
                {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        /**
         * Fetch activities for Student
         * 
         * @param type $student
         * @return type
         */
        function get_student_activities($student, $activity = 0)
        {
                $this->select_all_key('extras');
                if ($activity)
                {
                        $this->db->where($this->dx('activity') . '=' . $activity, NULL, FALSE);
                }
                return $this->db->where($this->dx('student') . '=' . $student, NULL, FALSE)
                                          ->get('extras')
                                          ->result();
        }

        /**
         * remove_activity
         * 
         * @param type $id
         * @return type
         */
        function remove_activity($id)
        {
                return $this->db->delete('extras', array('id' => $id));
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
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $sSearch = $this->db->escape_like_str($sSearch);
                                        $this->db->or_like('CONVERT(' . $this->dx('admission.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                }


                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('admission');
                $this->db->order_by($this->dx('admission.first_name'), 'ASC', FALSE);
                //$this->db->order_by('admission.id', 'desc');
                if ($this->session->userdata('cc'))
                {
                        $pop = $this->session->userdata('cc');
                        $this->db->where($this->dx('admission.class') . ' =' . $pop, NULL, FALSE);
                }

                $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                $rResult = $this->db->get('admission');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                if ($this->session->userdata('cc'))
                {
                        $pop = $this->session->userdata('cc');
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

}
