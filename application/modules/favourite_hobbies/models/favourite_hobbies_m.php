<?php
class Favourite_hobbies_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('favourite_hobbies', $data);
        return $this->db->insert_id();
    }

   
    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('favourite_hobbies')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('favourite_hobbies') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('favourite_hobbies');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('favourite_hobbies', $data);
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
        return $this->db->delete('favourite_hobbies', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  favourite_hobbies (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  INT(11), 
	class  INT(11), 
	year  varchar(256)  DEFAULT '' NOT NULL, 
	languages_spoken  text  , 
	hobbies  text  , 
	favourite_subjects  text  , 
	favourite_books  text  , 
	favourite_food  text  , 
	favourite_bible_verse  text  , 
	favourite_cartoon  text  , 
	favourite_career  text  , 
	others  text  , 
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
            $query = $this->db->get('favourite_hobbies', $limit, $offset);

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

    public function teacherViewHobbies(){
        $id=$this->ion_auth->get_user->id;
        return $this->db->order_by('id', 'desc')->where('created_by',$id)->get('favourite_hobbies')->result();
    }
}