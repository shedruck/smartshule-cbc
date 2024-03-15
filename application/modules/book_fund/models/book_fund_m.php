<?php
class Book_fund_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('book_fund', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('book_fund')->row();
     }
	 
	 //Borrowed books
    function borrowed($id)
    {
        return $this->db->where(array('book' => $id,'status'=>1))->count_all_results('borrow_book_fund');
     }
	 //Get by Book ID
 function get($id)
    {
        return $this->db->where(array('book_id' => $id))->get('book_fund')->row();
     }
 //Get Book stock Quantity
 function total_quantity($id)
    {
        return $this->db->select('sum(quantity) as t_quantity')->where(array('book_id' => $id))->get('book_fund_stock')->row();
    }
 //Get Book stock total
 function total_totals($id)
    {
        return $this->db->select('sum(total) as t_total')->where(array('book_id' => $id))->get('book_fund_stock')->row();
    }
	 
	 //Get All books
 function get_all()
    {
        return $this->db->order_by('title','ASC')->get('book_fund')->result();
    }
	 
	 
	 


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('book_fund') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('book_fund');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('book_fund', $data);
    }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();
  $options = array();
    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('book_fund', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('book_fund', $limit, $offset);

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