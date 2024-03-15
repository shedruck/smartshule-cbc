<?php
class Disciplinary_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('disciplinary', $data);
        return $this->db->insert_id();
    }

    function get($id)
    {
        return $this->db->where(array('culprit' => $id))->get('disciplinary')->result();
     }
  function find($id)
    {
        return $this->db->where(array('id' => $id))->get('disciplinary')->row();
     }

   function get_all()
    {
        return $this->db->order_by('created_on','DESC')->get('disciplinary')->result();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('disciplinary') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('disciplinary');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('disciplinary', $data);
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
        return $this->db->delete('disciplinary', array('id' => $id));
     }
	 //Teacher's Class
	function my_class($limit, $page)
    {
        $offset = $limit * ( $page - 1);
		
		 $u = $this->ion_auth->get_user()->id;
        $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
        $the_class = 0;
        if (!empty($cls->id))
        {
            $the_class = $cls->id;
        }
		
		$this->select_all_key('admission');
        
		$stds = $this->db->select('admission.id')->where($this->dx('admission.class') . ' = ' . $the_class, NULL, FALSE)->get('admission')->result();
		
		$arr = array();
		
		foreach($stds as $r){
		  $arr[$r->id]=$r->id;
		}
 		
        $this->db->where_in('culprit',$arr);
        $this->db->order_by('created_on', 'desc');
        $query = $this->db->get('disciplinary', $limit, $offset);

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

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('disciplinary', $limit, $offset);

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