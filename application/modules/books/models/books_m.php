<?php
class Books_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('books', $data);
        return $this->db->insert_id();
    }
	
//Get a list of all Items
	
    function get_category()
    {

        $data = $this->db->select('books_category.*')
                ->order_by('created_on','DESC')
				->get('books_category')
                ->result();
        $arr = array();

        foreach ($data as $dat)
        {

            $arr[$dat->id] = $dat->name;
        }
        return $arr;
    }
//Find
    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('books')->row();
     }
//Borrowed books
    function borrowed($id)
    {
        return $this->db->where(array('book' => $id,'status'=>1))->count_all_results('borrow_book');
     }
	 //Get by Book ID
 function get($id)
    {
        return $this->db->where(array('book_id' => $id))->get('books')->row();
     }
 //Get Book stock Quantity
 function total_quantity($id)
    {
        return $this->db->select('sum(quantity) as t_quantity')->where(array('book_id' => $id))->get('books_stock')->row();
    }
 //Get Book stock total
 function total_totals($id)
    {
        return $this->db->select('sum(total) as t_total')->where(array('book_id' => $id))->get('books_stock')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('books') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('books');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('books', $data);
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
        return $this->db->delete('books', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('books', $limit, $offset);

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