<?php

class Record_sales_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
                $this->db_set();
        }

        function create($data)
        {
                $this->db->insert('record_sales', $data);
                return $this->db->insert_id();
        }

        function insert_rec($data)
        {
                $this->db->insert('sales_receipts', $data);
                return $this->db->insert_id();
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('record_sales')->row();
        }

        function get_receipt($id)
        {
                return $this->db->where(array('id' => $id))->get('sales_receipts')->row();
        }
		
		function get_qnty($id)
        {
                return $this->db->where(array('item_id' => $id))->order_by('created_on','DESC')->get('sales_items_stock')->row();
        }

        function get_total_qnty($id)
        {
                return $this->db->select('sum(quantity) as t_quantity')->where(array('receipt_id' => $id, 'status' => 1))->get('record_sales')->row();
        }

        function get_totals($id)
        {
                return $this->db->select('sum(total) as t_totals')->where(array('receipt_id' => $id, 'status' => 1))->get('record_sales')->row();
        }

        function get_items($id)
        {
                return $this->db->where(array('receipt_id' => $id, 'status' => 1))->get('record_sales')->result();
        }

        function rec_details($id)
        {
                return $this->db->where(array('id' => $id))->get('sales_receipts')->row();
        }

        function get_student($id)
        {
                $this->select_all_key('admission');
                return $this->db->where(array('id' => $id))->get('admission')->row();
        }

        function sales_details($id)
        {
                return $this->db->where(array('receipt_id' => $id, 'status' => 1))->get('record_sales')->result();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('record_sales') > 0;
        }

        function exists_rec($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('sales_receipts') > 0;
        }

        function count()
        {

                return $this->db->count_all_results('record_sales');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('record_sales', $data);
        }

        function update_fee_receipt($id, $data)
        {
                return $this->db->where('id', $id)->update('sales_receipts', $data);
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
                return $this->db->delete('record_sales', array('id' => $id));
        }

        /**
         * Setup DB Table Automatically
         * 
         */
        function db_set()
        {
                $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  record_sales (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	sales_date  INT(11), 
	item_id  varchar(256)  DEFAULT '' NOT NULL, 
	quantity  varchar(256)  DEFAULT '' NOT NULL, 
	units  varchar(256)  DEFAULT '' NOT NULL, 
	total  varchar(256)  DEFAULT '' NOT NULL, 
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
                //$this->db->where('receipt_id');
                $this->db->group_by('receipt_id');
                $this->db->order_by('sales_date', 'desc');
                $query = $this->db->get('record_sales', $limit, $offset);

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

        function manipulate($id)
        {

                $this->db->where('receipt_id', $id);
                $this->db->order_by('sales_date', 'desc');
                $query = $this->db->get('record_sales')->result();


                return $query;
        }

        function voided()
        {

                $this->db->where('status', 0);
                $this->db->order_by('sales_date', 'desc');
                $query = $this->db->get('record_sales')->result();

                return $query;
        }

}
