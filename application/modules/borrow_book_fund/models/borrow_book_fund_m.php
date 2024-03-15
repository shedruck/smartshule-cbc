<?php
class Borrow_book_fund_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('borrow_book_fund', $data);
        return $this->db->insert_id();
    }
	
	//students
	
	 function fetch_full_students($class)
          {
              $list = $this->db->select('id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name'). ',' . $this->dxa('admission_number'), FALSE)
                      ->where($this->dx('class') . '=' . $class, NULL, FALSE)
                      ->get('admission')
                      ->result();
            
              return $list;
          }
	
		
//Get a list of all Books
	
    function list_books()
    {

        $data = $this->db->select('book_fund_stock.*')
                ->order_by('created_on','DESC')
				->group_by('book_id')
				->get('book_fund_stock')
                ->result();
        $arr = array();

        foreach ($data as $dat)
        {
            $title=$this->populate('book_fund','id','title');
            $arr[$dat->book_id] = $title[$dat->book_id];
        }
        return $arr;
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('borrow_book_fund')->row();
     }  

	 function by_student($id)
    {
        return $this->db->where(array('student' => $id))->get('borrow_book_fund')->result();
     }  
	 
function count_book_per_student($id)
    {
        return $this->db->where(array('student' => $id,'status'=>1))->count_all_results('borrow_book_fund');
     }
//Get library settings
 function lib_settings()
    {
        return $this->db->get('library_settings')->row();
    }
	 //Get Book stock Quantity
 function total_quantity($id)
    {
        return $this->db->select('sum(quantity) as t_quantity')->where(array('book_id' => $id))->get('book_fund_stock')->row();
    }
	//get borrowed book_fund_stocks
	 function borrowed($id)
     {
        
		 $res= $this->db->where(array('book' => $id,'status'=>1))->count_all_results('borrow_book_fund');
		if($res>0){
		return $res;
		}
		else{
		 return 0;
		}
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('borrow_book_fund') >0;
    }

    function exists_student_book($stud, $book)
    {
          return $this->db->where( array('student' => $stud,'book'=>$book))->count_all_results('borrow_book_fund') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('borrow_book_fund');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('borrow_book_fund', $data);
    } 
	function update_status($id, $data)
    {
         return  $this->db->where('id', $id) ->update('borrow_book_fund', $data);
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
        return $this->db->delete('borrow_book_fund', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('borrow_book_fund', $limit, $offset);

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