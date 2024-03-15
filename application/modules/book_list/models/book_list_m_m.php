<?php
class Book_list_m_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('book_list', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('book_list')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('book_list') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('book_list');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('book_list', $data);
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
        return $this->db->delete('book_list', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  book_list (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	thumbnail  varchar(256)  DEFAULT '' NOT NULL, 
	class  varchar(32)  DEFAULT '' NOT NULL, 
	subject  varchar(32)  DEFAULT '' NOT NULL, 
	book_name  varchar(256)  DEFAULT '' NOT NULL, 
	publisher  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('book_list', $limit, $offset);

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

    public function getClasses(){
        return $this->db->order_by('id','DESC')->get('class_rooms')->result();
    }

    public function getSubjects(){
        return $this->db->order_by('id','DESC')->get('subjects')->result();
    }

    public function view(){
         $res =  $this->db
        ->select('book_list.id,book_list.thumbnail, book_list.book_name, book_list.publisher, book_list.price,
		subjects.name AS subject_name, class_groups.name AS class_name')
        ->order_by('book_list.id','desc')
        ->join('class_groups', 'class_groups.id=book_list.class')
        ->join('subjects','subjects.id=book_list.subject')
        ->get('book_list')
        ->result();
		
		if($res){
			return  $res;
		}else{
			return false;
		} 
    }

    public function drpDownClass(){
        return $this->db
        ->select('book_list.id,book_list.thumbnail, book_list.book_name, book_list.publisher, book_list.price,
		subjects.name AS subject_name, class_rooms.name AS class_name')
        ->order_by('book_list.id','desc')
        ->group_by('book_list.class')
        ->join('class_rooms', 'class_rooms.id=book_list.class')
        ->join('subjects','subjects.id=book_list.subject')
        ->get('book_list')
        ->result();
    }

    public function drpDownSubject(){
        return $this->db
        ->select('book_list.id,book_list.thumbnail, book_list.book_name, book_list.publisher, book_list.price,
		subjects.name AS subject_name, class_rooms.name AS class_name')
        ->order_by('book_list.id','desc')
        ->group_by('book_list.subject')
        ->join('class_rooms', 'class_rooms.id=book_list.class')
        ->join('subjects','subjects.id=book_list.subject')
        ->get('book_list')
        ->result();
    }

    public function filterbyclass($class){
        return $this->db
        ->select('book_list.id,book_list.thumbnail, book_list.book_name, book_list.publisher, book_list.price,
		subjects.name AS subject_name, class_rooms.name AS class_name')
        ->order_by('book_list.id','desc')
        ->join('class_rooms', 'class_rooms.id=book_list.class')
        ->join('subjects','subjects.id=book_list.subject')
        ->where('class_rooms.name',$class)
        ->get('book_list')
        ->result();
    }
    public function filterbysubject($subject){
        return $this->db
        ->select('book_list.id,book_list.thumbnail, book_list.book_name, book_list.publisher, book_list.price,
		subjects.name AS subject_name, class_rooms.name AS class_name')
        ->order_by('book_list.id','desc')
        ->join('class_rooms', 'class_rooms.id=book_list.class')
        ->join('subjects','subjects.id=book_list.subject')
        ->where('subjects.name',$subject)
        ->get('book_list')
        ->result();
    }
}