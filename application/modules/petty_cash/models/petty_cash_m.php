<?php

class Petty_cash_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('petty_cash', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('petty_cash')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('petty_cash') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('petty_cash');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('petty_cash', $data);
    }

    public function list_staff()
    {
        $this->select_all_key('users_groups');
        $results = $this->db
                ->where($this->dx('group_id') . ' != 6', NULL, FALSE)
                ->where($this->dx('group_id') . '!= 8', NULL, FALSE)
                ->get('users_groups')
                ->result();

        $arr = array();
		
         foreach ($results as $res)
        {
            if(!empty($res->user_id)){
				$user = $this->ion_auth->get_user($res->user_id);
				$arr[$res->user_id] = $user->first_name . ' ' . $user->last_name;
			}
        }
        return $arr;
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
        return $this->db->delete('petty_cash', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS `petty_cash` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`petty_date` INT(11) NULL DEFAULT NULL,
	`description` VARCHAR(1000) NOT NULL DEFAULT '',
	`amount` FLOAT NOT NULL,
	`person` INT(9) NOT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
                )
                COLLATE='utf8_general_ci'
                ENGINE=InnoDB;");
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
        $aColumns = $this->db->list_fields('petty_cash');

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
                    $this->db->order_by('petty_cash.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);

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
                    $this->db->or_like('CONVERT(petty_cash.' . $aColumns[$i] . " USING 'latin1') ", $sSearch, 'both', FALSE);
                }
            }
        }

        // Select Data
        $this->db->select(' SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $rResult = $this->db->order_by('petty_date', 'DESC')->get('petty_cash');
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all('petty_cash');

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
            $std = $this->ion_auth->get_user($iCol->person);
            $by = $this->ion_auth->get_user($iCol->created_by);
            $sname = $std->first_name . ' ' . $std->last_name;
            $byname = $by->first_name . ' ' . $by->last_name;
             $aaData[] = array(
                $iCol->id,
                $iCol->petty_date ? date('d M Y', $iCol->petty_date) : ' ',
                $iCol->description,				
				$iCol->amount ? number_format($iCol->amount, 2) : $iCol->amount,
              
                $sname,
                $byname,
            );
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function paginate_all($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('petty_cash', $limit, $offset);

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
