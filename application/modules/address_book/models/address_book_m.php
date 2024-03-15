<?php
class Address_book_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('address_book', $data);
        return $this->db->insert_id();
    }

 function get_category(){
	
	$result=$this->db->select('address_book_category.*')
				->order_by('created_on','DESC')
				->get('address_book_category')
				->result();
				$arr=array();
				
				foreach($result as $res){
				$arr[$res->id]=$res->title;
				}
				
				return $arr;
	}
	
	
    function others()
    {
        return $this->db->where(array('address_book' => 'others'))->get('address_book')->result();
     }
function suppliers()
    {
        return $this->db->where(array('address_book' => 'supplier'))->get('address_book')->result();
     }
function customer()
    {
        return $this->db->where(array('address_book' => 'customer'))->get('address_book')->result();
     }
	 
function get_customer($id)
    {
        return $this->db->where(array('id' => $id))->get('address_book')->row();
     }

function find($id)
    {
        return $this->db->where(array('id' => $id))->get('address_book')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('address_book') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('address_book');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('address_book', $data);
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
        return $this->db->delete('address_book', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('address_book', $limit, $offset);

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