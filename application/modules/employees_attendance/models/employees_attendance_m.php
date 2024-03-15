<?php
class Employees_attendance_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('employees_attendance', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('employees_attendance')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('employees_attendance') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('employees_attendance');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('employees_attendance', $data);
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
        return $this->db->delete('employees_attendance', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  employees_attendance (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	date  INT(11), 
	teacher  varchar(32)  DEFAULT '' NOT NULL, 
	time_in  varchar(256)  DEFAULT '' NOT NULL, 
	time_out  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function by_date($date)
    {
          
            $this->db->order_by('id', 'desc');
		
            $query = $this->db->where_in("DATE_FORMAT(FROM_UNIXTIME(date),'%d-%m-%Y')", $date)->get('employees_attendance')->result();
			
			return $query;

    }

    function by_employee($employee)
    {
        
            return $this->db->where(array('employee' => $employee))->get('employees_attendance')->result();
    }

	function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('employees_attendance', $limit, $offset);

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