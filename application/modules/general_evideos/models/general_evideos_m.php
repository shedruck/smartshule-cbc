<?php
class General_evideos_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('general_evideos', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('general_evideos')->row();
     }


	 function get_sub844($id)
     {
		 
       return  $this->db->group_by('subject_id')->where(array('class_id' => $id))->get('subjects_classes')->result();
	   
	 
     }
	 
	 function get_cbc_subjects($id)
     {
       return $this->db->where(array('class_id' => $id))->get('cbc')->result();
     }

	 function get_all()
     {
        return $this->db->order_by('id','desc')->limit(15)->get('general_evideos')->result();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('general_evideos') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('general_evideos');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('general_evideos', $data);
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
        return $this->db->delete('general_evideos', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  general_evideos (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(256)  DEFAULT '' NOT NULL, 
	level  varchar(256)  DEFAULT '' NOT NULL, 
	type  varchar(32)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	topic  varchar(500)  DEFAULT '' NOT NULL, 
	subtopic  varchar(500)  DEFAULT '' NOT NULL, 
	preview_link  text  , 
	video_embed_code  text  , 
	description  text  , 
	status INT(11), 
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
            $query = $this->db->get('general_evideos', $limit, $offset);

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