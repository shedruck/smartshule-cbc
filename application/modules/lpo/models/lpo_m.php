<?php

class Lpo_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('lpo')->row();
    }

    function find_supplier($id)
    {
        return $this->db->where(['id' => $id])->get('lpo_suppliers')->row();
    }

    function get_items($id)
    {
        return $this->db->select('lpo_items.*')
                                            ->select('expense_items.name')
                                            ->join('expense_items', 'expense_items.id=item')
                                            ->where(['lpo' => $id])
                                            ->get('lpo_items')
                                            ->result();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('lpo') > 0;
    }

    function count()
    {
        return $this->db->count_all_results('lpo');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('lpo', $data);
    }

    function get_suppliers($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('lpo_suppliers');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        /*
         * Filtering
         */
        if (isset($sSearch) && !empty($sSearch))
        {
            $where = '';
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like($aColumns[$i], $sSearch, 'both', FALSE);
                }
            }
            if (isset($where) && !empty($where))
            {
                $this->db->where('(' . $where . ')', NULL, FALSE);
            }
        }

        $this->db->select('SQL_CALC_FOUND_ROWS lpo_suppliers.*', false);

        $rResult = $this->db->order_by('id', 'DESC')->get('lpo_suppliers');
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all_results('lpo_suppliers');
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
            $aaData[] = [
                $iCol->id,
                $iCol->name,
                $iCol->phone,
                $iCol->email,
                ''
            ];
        }
        $output['aaData'] = $aaData;

        return $output;
    }

    function get_lpo($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
        $aColumns = $this->db->list_fields('lpo');

        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1')
        {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }
        /*
         * Filtering
         */
        if (isset($sSearch) && !empty($sSearch))
        {
            $where = '';
            for ($i = 0; $i < count($aColumns); $i++)
            {
                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                // Individual column filtering
                if (isset($bSearchable) && $bSearchable == 'true')
                {
                    $sSearch = $this->db->escape_like_str($sSearch);
                    $this->db->or_like($aColumns[$i], $sSearch, 'both', FALSE);
                }
            }
            if (isset($where) && !empty($where))
            {
                $this->db->where('(' . $where . ')', NULL, FALSE);
            }
        }

        $this->db->select('SQL_CALC_FOUND_ROWS lpo.*', false);
        $rResult = $this->db->where('status', 1)->order_by('id', 'DESC')->get('lpo');
        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->where('status', 1)->count_all_results('lpo');
        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
        $suppliers = $this->populate('lpo_suppliers', 'id', 'name');
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
            $by = $this->ion_auth->get_user($iCol->created_by);
            $name = isset($suppliers[$iCol->supplier]) ? $suppliers[$iCol->supplier] : ' - ';
            $aaData[] = [
                $iCol->id,
                $name,
                $iCol->lpo_date > 10000 ? date('d M Y', $iCol->lpo_date) : ' - ',
                $iCol->total > 0 ? number_format($iCol->total, 2) : $iCol->total,
                $by->first_name . ' ' . $by->last_name,
                ''
            ];
        }
        $output['aaData'] = $aaData;

        return $output;
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
        return $this->db->delete('lpo', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     *
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  lpo (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(255)  DEFAULT '' NOT NULL, 
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
        $query = $this->db->get('lpo', $limit, $offset);

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
