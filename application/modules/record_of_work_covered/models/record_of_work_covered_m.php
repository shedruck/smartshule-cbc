<?php
class Record_of_work_covered_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('record_of_work_covered', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('record_of_work_covered')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('record_of_work_covered') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('record_of_work_covered');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('record_of_work_covered', $data);
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
        return $this->db->delete('record_of_work_covered', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  record_of_work_covered (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	year  varchar(256)  DEFAULT '' NOT NULL, 
	term  varchar(256)  DEFAULT '' NOT NULL, 
	level  varchar(256)  DEFAULT '' NOT NULL, 
	week  varchar(256)  DEFAULT '' NOT NULL, 
	subject  INT(11), 
	date  INT(11), 
	strand  varchar(256)  DEFAULT '' NOT NULL, 
	substrand  varchar(256)  DEFAULT '' NOT NULL, 
	work_covered  text  , 
	reflection  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page, $plan = false)
    {
        $offset = $limit * ($page - 1);
        $user = $this->ion_auth->get_user();

        if ($plan) {
            $this->db->where('plan', $plan);
        }

        

        $this->db->order_by('id', 'desc');
        $list = $this->db->get('record_of_work_covered', $limit, $offset)->result();

        $result = [];
        foreach ($list as $p) {
            $p->plans = $this->get_rec('lesson_plan', $p->plan);
            $p->schemes = $this->get_rec('schemes_of_work', $p->scheme);
            $result[] = $p;
        }


        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    function paginate_trs($limit, $page, $plan = false)
    {
            $offset = $limit * ( $page - 1) ;
			 $user = $this -> ion_auth -> get_user();

             if($plan)
             {
                $this->db->where('plan', $plan);
             }

			$this->db->where('created_by',$user->id);
            
            $this->db->order_by('id', 'desc');
            $list = $this->db->get('record_of_work_covered', $limit, $offset)->result();

            $result = [];
            foreach($list as $p)
            {
                $p->plans = $this->get_rec('lesson_plan',$p->plan);
                $p->schemes = $this->get_rec('schemes_of_work', $p->scheme);
                $result[] = $p;
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

    function find_rec( $plan)
    {

        // $user = $this->ion_auth->get_user();
        // $this->db->where('created_by', $user->id);
        if ($plan) {
            $this->db->where('plan', $plan);
        }
       

        $this->db->order_by('id', 'desc');
        $list = $this->db->get('record_of_work_covered')->result();

        $result = [];
        foreach ($list as $p) {
            $p->plans = $this->get_rec('lesson_plan', $p->plan);
            $p->schemes = $this->get_rec('schemes_of_work', $p->scheme);
            $result[] = $p;
        }


        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }

    function single_row($plan = false)
    {

        // $user = $this->ion_auth->get_user();
        // $this->db->where('created_by', $user->id);
        if ($plan) 
        {
            $this->db->where('plan', $plan);
        }

       
         

        $this->db->order_by('id', 'desc');
        $p = $this->db->get('record_of_work_covered')->row();

            $p->plans = $this->get_rec('lesson_plan', $p->plan);
            $p->schemes = $this->get_rec('schemes_of_work', $p->scheme);


        if ($p) {
            return $p;
        } else {
            return FALSE;
        }
    }

    function get_trs()
    {
        $this->select_all_key('teachers');
        $list =  $this->db->where($this->dx('status') . '=1', NULL, FALSE)->get('teachers')->result();
        $teachers = [];
        foreach ($list as $l) {
            $teachers[$l->user_id] = $l->first_name . ' ' . $l->middle_name . ' ' . $l->last_name;
        }
        return $teachers;
    }

    function get_rec($table, $id)
    {
        return $this->db->where(array('id' => $id))->get($table)->row();
    }


}





