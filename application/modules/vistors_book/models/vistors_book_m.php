<?php
class Vistors_book_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('vistors_book', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('vistors_book')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('vistors_book') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('vistors_book');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('vistors_book', $data);
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
        return $this->db->delete('vistors_book', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  vistors_book (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('vistors_book', $limit, $offset);

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

    function filter($cat)
    {
        return $this->db->where('category', $cat)->get('vistors_book')->result();
    }

    function get_users()
    {
        $this->select_all_key('users_groups');
        $list = $this->db->get('users_groups')->result();
        $grp= [];
        $gr =  $this->populate('groups','id','name');
        foreach($list as $l)
        {
            // if($l->group_id !=8 || $l->group_id !=6)
            // {
                $grp[$l->user_id] = isset($gr[$l->group_id]) ? $gr[$l->group_id] : '';
            // }
        }

        $this->select_all_key('users');
        $users  = $this->db
                        ->where($this->dx('active') . '= 1', NULL, FALSE)
                        ->order_by($this->dx('first_name'), 'ASC', FALSE)
                        ->get('users')->result();

        $user = [];
        foreach($users as $u)
        {
            $desc = isset($grp[$u->id]) ? $grp[$u->id] : ''; 
             
             // if (in_array($u->id, $grp)) 
             // {
                 $user[$u->id] = $u->first_name.' '.$u->last_name.' (<span class="label label-info">'.$desc.'</span>)';
             // }
                
        }

        return $user;
    }

}