<?php

class Add_stock_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $query = $this->db->insert('add_stock', $data);
                return $query;
        }

        //Get All and Group

        function get_all()
        {

                return $this->db->select('add_stock.*')
                                          ->group_by('product_id')
                                          ->get('add_stock')
                                          ->result();
        }

        //Calculate total paid Fees
        function total_stock()
        {
                return $this->db->select('sum(total) as total')
                                          ->get('add_stock')
                                          ->row();
        }

        //Calculate total quatity
        function total_quantity($id)
        {
                $dat = $this->db->select('sum(quantity) as quantity')
                             ->where('add_stock.product_id', $id)
                             ->get('add_stock')
                             ->row();
 
                return $dat;
        }

        //Calculate total cost
        function total_cost($id)
        {
                $dat = $this->db->select('sum(total) as totals')
                             ->where('product_id', $id)
                             ->get('add_stock')
                             ->row();
 
                return $dat;
        }

        //Get product QNTY of the selected product
        function total_closing_stock($id)
        {

                return $this->db->select('sum(closing_stock) as quantity')
                                          ->where('product_id', $id)
                                          ->get('stock_taking')
                                          ->row();
        }

        //Get a list of all projects

        function get_products()
        {

                $data = $this->db->select('items.*')
                             ->order_by('created_on', 'DESC')
                             ->get('items')
                             ->result();
                $arr = array();

                foreach ($data as $dat)
                {

                        $arr[$dat->id] = $dat->item_name;
                }
                return $arr;
        }

        function find($id)
        {
                $query = $this->db->get_where('add_stock', array('id' => $id));
                return $query->row();
        }

        function exists($id)
        {
                $query = $this->db->get_where('add_stock', array('id' => $id));
                $result = $query->result();

                if ($result)
                        return TRUE;
                else
                        return FALSE;
        }

        function count()
        {

                return $this->db->count_all_results('add_stock');
        }

        function update_attributes($id, $data)
        {
                $this->db->where('id', $id);
                $query = $this->db->update('add_stock', $data);

                return $query;
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
                $query = $this->db->delete('add_stock', array('id' => $id));

                return $query;
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('add_stock', $limit, $offset);

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
