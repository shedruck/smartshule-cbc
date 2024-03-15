<?php
class Other_revenue_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('other_revenue', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('other_revenue')->row();
     }

     function void($id, $data)
     {
          return $this->db->where('id', $id)->update('other_revenue', $data);

     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('other_revenue') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('other_revenue');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('other_revenue', $data);
    }

    function list_categories()
        {

                $result = $this->db->select('revenue_categories.*')
                             ->order_by('created_on', 'DESC')
                             ->get('revenue_categories')
                             ->result();

                $rr = array();
                foreach ($result as $res)
                {
                        $rr[$res->id] = $res->name;
                }

                return $rr;
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
        return $this->db->delete('other_revenue', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  other_revenue (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  payment_date INT(11),
  category varchar(256) DEFAULT '' NOT NULL,
  item varchar(256) DEFAULT '' NOT NULL,
  amount varchar(256) DEFAULT '' NOT NULL,
  description varchar(400) DEFAULT '' NOT NULL,
  bank_id INT(11),
  transaction_code varchar(256),
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
            $query = $this->db->where('status' , 1)->get('other_revenue', $limit, $offset);

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

    function paginate_voided($limit , $page)
    {
      $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->where('status' , 0)->get('other_revenue', $limit, $offset);

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