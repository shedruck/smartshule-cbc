<?php
class Return_book_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('return_book', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('return_book')->row();
     }
 function get_borrowed()
    {
        return $this->db->where(array('status' => 1))->group_by('student')->order_by('created_on','DESC')->get('borrow_book')->result();
     }
  function count_borrowed_per_student($id)
    {
        return $this->db->where(array('student' => $id,'status'=>1))->count_all_results('borrow_book');
     }
 function student_books($id)
    {
        return $this->db->select('borrow_book.*')->where(array('student' => $id,'status'=>1))->get('borrow_book')->result();
    }

    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('return_book') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('return_book');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('return_book', $data);
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
        return $this->db->delete('return_book', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('return_book', $limit, $offset);

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