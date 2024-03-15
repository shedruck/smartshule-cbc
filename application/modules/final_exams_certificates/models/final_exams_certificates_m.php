<?php
class Final_exams_certificates_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('final_exams_certificates', $data);
        return $this->db->insert_id();
    }
	
	function create_grades($data)
    {
        $this->db->insert('final_exams_grades', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('final_exams_certificates')->row();
    }
	 
	function get_grades($id)
    {
        return $this->db->where(array('certificate_id' => $id))->get('final_exams_grades')->result();
    }

    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('final_exams_certificates') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('final_exams_certificates');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('final_exams_certificates', $data);
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

function get_subjects()
{
    $res = $this->db->where('is_optional !=1')->order_by('priority','asc')->get('subjects')->result();
    
    return $res;
}

    function delete($id)
    {
        return $this->db->delete('final_exams_certificates', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  final_exams_certificates (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	certificate_type  varchar(256)  DEFAULT '' NOT NULL, 
	serial_number  varchar(256)  DEFAULT '' NOT NULL, 
	mean_grade  varchar(256)  DEFAULT '' NOT NULL, 
	points  varchar(256)  DEFAULT '' NOT NULL, 
	certificate  varchar(256)  DEFAULT '' NOT NULL, 
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
            $query = $this->db->get('final_exams_certificates', $limit, $offset);

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