<?php
class Sales_items_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('sales_items', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('sales_items')->row();
     }
	 
function get_quantity($id)
    {
       $results =  $this->db->select('sum(quantity) as total')->where(array('item_id' => $id))->get('sales_items_stock')->row();
	   if(!empty($results)){
		 return $results;
	   }
	   else{
	   return 0;
	   }
	   
     }
	function get_sold($id)
    {
       $results =  $this->db->select('sum(quantity) as total')->where(array('item_id' => $id))->get('record_sales')->row();
	   if(!empty($results)){
		 return $results;
	   }
	   else{
	   return 0;
	   }
	   
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('sales_items') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('sales_items');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('sales_items', $data);
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
        return $this->db->delete('sales_items', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  sales_items (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	item_name  varchar(256)  DEFAULT '' NOT NULL, 
	category  varchar(32)  DEFAULT '' NOT NULL, 
	description  text  , 
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
            $query = $this->db->get('sales_items', $limit, $offset);

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