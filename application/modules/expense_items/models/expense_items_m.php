<?php

class Expense_items_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('expense_items', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('expense_items')->row();
    }

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('expense_items') > 0;
    }

    function count()
    {

        return $this->db->count_all_results('expense_items');
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('expense_items', $data);
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
    function get_datatable($aColumns, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
    {
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
        $rResult = $this->db->order_by('id', 'DESC')->get('expense_items');

        // Data set length after filtering
        $this->db->select('FOUND_ROWS() AS found_rows ');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length
        $iTotal = $this->db->count_all('expense_items');

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );

        foreach ($rResult->result_array() as $aRow)
        {
            $row = array();

            foreach ($aColumns as $col)
            {
                if ($col && $col !== ' ')
                {
                    $row[] = $aRow[$col];
                }
            }

            $output['aaData'][] = $row;
        }

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
        return $this->db->delete('expense_items', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  expense_items (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
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
        $query = $this->db->get('expense_items', $limit, $offset);

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
