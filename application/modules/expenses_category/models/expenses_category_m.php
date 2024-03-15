<?php
class Expenses_category_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('expenses_category', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('expenses_category')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('expenses_category') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('expenses_category');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('expenses_category', $data);
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
        return $this->db->delete('expenses_category', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('expenses_category', $limit, $offset);

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

    function get_accounts(){
        $this->select_all_key('accounts');
        $this->db
            ->where($this->dx('code') . '<600', NULL, FALSE)
            ->where($this->dx('code') . '>300', NULL, FALSE)
            ->order_by($this->dx('code'), 'ASC', FALSE);
        $result = $this->db->get('accounts')->result();
        $options= array();
        foreach($result as $r){
            $options[$r->id] = $r->name;
        }
        return $options;
    }

    function get_rt_stages(){
        $list = $this->db->select('stage_name,id')
        ->get('transport_stages')
        ->result();
        $stages= array();
        foreach($list as $l){
                $stages[$l->id] = $l->stage_name;
        }
        return $stages;
}
}