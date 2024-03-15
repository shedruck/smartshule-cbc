<?php

use LDAP\Result;

class supplier_invoices_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($table,$data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('supplier_invoices')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('supplier_invoices') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('supplier_invoices');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('supplier_invoices', $data);
    }

    function update_table($table, $id, $data)
    {
        return  $this->db->where('id', $id)->update($table, $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();
       $options=array();
    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('supplier_invoices', array('id' => $id));
     }

    function unlink_payment($id)
    {
        return $this->db->delete('supplier_payments', array('id' => $id));
    }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  supplier_invoices (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	supplier  varchar(256)  DEFAULT '' NOT NULL, 
	supplier_email  varchar(256)  DEFAULT '' NOT NULL, 
	supplier_phone  varchar(256)  DEFAULT '' NOT NULL, 
	item  varchar(256)  DEFAULT '' NOT NULL, 
	quantity  varchar(256)  DEFAULT '' NOT NULL, 
	unit_price  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('supplier_invoices', $limit, $offset);

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

     function get_items($id)
    {
        return $this->db->select('supplier_invoice_items.*')
                                            // ->select('expense_items.name')
                                            // ->join('expense_items', 'expense_items.id=item')
                                            ->where(['receipt' => $id])
                                            ->get('supplier_invoice_items')
                                            ->result();
    }

    function supplier(){
        $list = $this->db->get('supplier_invoices')->result();
        $supp = [];
        foreach($list as $l){
            $supp[$l->id] = $l->supplier;
        }
        return $supp;
    }

    function supplier_balance($id){
        $result = $this->db->where('id', $id)->get('supplier_invoices')->row();
        $amount = $result->balance;
        return $amount;
    }

    function supplier_paid($id){
        $result = $this->db->where('id', $id)->get('supplier_invoices')->row();
        $amount = $result->paid;
        return $amount;
    }

    function item_amount_due($id){
        $result = $this->db->where('id', $id)->get('supplier_invoice_items')->row();
        $amount = $result->amount_due;
        return $amount;
    }

    function update_bals($id, $data, $table)
    {
         return  $this->db->where('id', $id) ->update($table, $data);
    }

    function receipt($ref)
    {
       return $this->db
                    ->group_by('ref')
                    ->where('ref', $ref)
                    ->get('supplier_payments')
                    ->row();
    }

    function get_payments()
    {
        return $this->db
                    // ->group_by('ref')
                    ->order_by('id','DESC')
                    ->get('supplier_payments')
                    ->result();
    }

    function total_receipt($ref)
    {
         return  $this->db->select("sum(amount) as total ", false)
                            ->where('ref', $ref)
                            ->get('supplier_payments')
                            ->row();
    }

    function get_receipt_data($ref){
        return $this->db
                    ->where('ref', $ref)
                    ->get('supplier_payments')
                    ->result();
    }

    function receipt_items()
    {
        $list = $this->db->get('supplier_invoice_items')->result();
        $item = [];
        foreach($list as $l){
            $item[$l->id] = $l->item;
        }
        return $item;
    }

    function suppliers($min, $max)

    {

        $list = $this->db->order_by('created_on', 'ASC')->where('balance !=0')->get('supplier_invoices')->result();
       
        $data = [];
        foreach($list as $l)
        {
            $created_on = date('Y-m-d', $l->created_on);
            $now = date('Y-m-d');

            $create_dt = date_create($created_on);
            $noww = date_create($now);
            $diff = date_diff($create_dt, $noww );
            $dd =  $diff->format("%R%a");
            $dif = str_replace("+","",$dd);
            if(($dif >= $min) && ($dif <= $max))
            {
               $data[] = array('supplier' => $l->supplier, 
                               'balance' => $l->balance,
                               'paid' => $l->paid,
                               'created_on' => $l->created_on,
                               'created_by' => $l->created_by,
                               'total' => $l->total,
                               'age' => $dif,
                               'id' => $l->id,
                        );
            }

        }

        return $data;

 

     }

     function expense_catyegories()
     {
        return $this->db->order_by('title','ASC')->get('expenses_category')->result();
     }

     function get_accounts()
     {
        $this->select_all_key('accounts');
        $list =  $this->db->get('accounts')->result();

        $accounts = [];
        foreach($list as $l)
        {
            $accounts[$l->id] = $l->name;
        }

        return $accounts;
     }


     function all_suppliers()
     {
        return $this->db
                    ->group_by('supplier_phone')
                    ->order_by('supplier','ASC')
                    ->get('supplier_invoices')
                    ->result();
     }

     function the_suppliers($id)
     {
        $row = $this->find($id);

       return  $this->db->where(['supplier_phone' => $row->supplier_phone])->get('supplier_invoices')->result();

     }

     function get_invoices($id, $from,$to)
     {

        if (($from && $to) && $from == $to) {
            $this->db->where("created_on = $from");
        } else {
            if ($from) {
                $this->db->where('created_on >= ', $from);
            }
            if ($to) {
                $this->db->where('created_on <= ', $to);
            }
        }
        return $this->db->where('receipt',$id)->get('supplier_invoice_items')->result();
     }


    function _get_payments($id,$from, $to)
    {

        if (($from && $to) && $from == $to) {
            $this->db->where("created_on = $from");
        } else {
            if ($from) {
                $this->db->where('created_on >= ', $from);
            }
            if ($to) {
                $this->db->where('created_on <= ', $to);
            }
        }
        return $this->db->where('invoice', $id)->get('supplier_payments')->result();
    }



     function get_statement($id,$from = false, $to = false )
     {
        $suppliers =  $this->the_suppliers($id);
        $payload = [];
        $items =  $this->receipt_items();
        foreach($suppliers as $s)
        {
            $invoices = $this->get_invoices($s->id, $from, $to);
            foreach($invoices as $p)
            {
                $payload[$p->created_on][] = ['description' => $p->item, 'date' => $p->created_on, 'dr' => $p->amount,'cr' => 0,'ref' => 'INV'. str_pad($p->receipt, 3, '0', 0)];
            }


            $payments  = $this->_get_payments($s->id, $from, $to);

            foreach ($payments as $k) 
            {
                $dd = isset($items[$k->item]) ? $items[$k->item] : '';
                $payload[$k->created_on][] = ['description' => 'Payment:'.$dd, 'date' => $k->created_on, 'dr' => 0, 'cr' => $k->amount, 'ref' => ($k->check_no) ? $k->check_no : $k->ref];
            }
        }

        krsort($payload);

        return $payload;
     }

     function get_payment($id)
     {
        return $this->db->where('id', $id)->get('supplier_payments')->row();
     }


    function item_row($id)
    {
        return $this->db->where('id', $id)->get('supplier_invoice_items')->row();
    }
}