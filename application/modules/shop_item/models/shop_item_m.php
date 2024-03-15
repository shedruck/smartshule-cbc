<?php
class Shop_item_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('shop_item', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('shop_item')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('shop_item') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('shop_item');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('shop_item', $data);
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
        return $this->db->delete('shop_item', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  shop_item (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	size_from  varchar(256)  DEFAULT '' NOT NULL, 
	size_to  varchar(256)  DEFAULT '' NOT NULL, 
	bp  varchar(256)  DEFAULT '' NOT NULL, 
	sp  varchar(256)  DEFAULT '' NOT NULL, 
	quantity  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('shop_item', $limit, $offset);

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

    function get_shop_items(){
        return $this->db
                    ->get('shop_item')
                    ->result();
    }

    function create_request($data)
    {
        $this->db->insert('shopped_items', $data);
        return $this->db->insert_id();
    }

    function requested_items(){
       return $this->db
                   ->join('shopped_items','shopped_items.item=shop_item.id')
                   ->order_by('shopped_items.id','DESC')
                   ->get('shop_item')
                   ->result();

    }
}