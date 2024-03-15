<?php
class Items_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('items', $data);
        return $this->db->insert_id();
    }
	
	function get_add_totals($id){
	
		$data = $this->db->select_sum('quantity')
				->where('product_id',$id)
				->get('add_stock')
				->row();
		    if(!empty($data)) return $data;
			else return 0;
	}
	function get_remove_totals($id){
	
		$data = $this->db->select('sum(stock_taking.closing_stock) as closing_totals')
				->where('product_id',$id)
				->get('stock_taking')
				->row();
			if(!empty($data)) return $data;
			else return 0;
	}
	
	
		//Get a list of all Items
	
    function get_category()
    {

        $data = $this->db->select('items_category.*')
                ->order_by('created_on','DESC')
				->get('items_category')
                ->result();
        $arr = array();

        foreach ($data as $dat)
        {

            $arr[$dat->id] = $dat->name;
        }
        return $arr;
    }
	

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('items')->row();
     }
  function get_add($id)
    {
        return $this->db->where(array('product_id' => $id))->get('add_stock')->result();
     }
function get_take($id)
    {
        
		$this->db->where(array('product_id' => $id));
		$this->db->order_by('created_on','DESC');
		return $this->db->get('stock_taking')->result();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('items') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('items');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('items', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();

    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('items', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('items', $limit, $offset);

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