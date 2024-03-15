<?php
class Zoom_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        $this->db->insert('zoom', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('zoom')->row();
     }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('zoom') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('zoom');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('zoom', $data);
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
        return $this->db->delete('zoom', array('id' => $id));
     }

     /**
     * Setup DB Table Automatically
     * 
     */
     function db_set( )
     {
             $this->db->query(" 
             CREATE TABLE IF NOT EXISTS `zoom` (
               `id` int(11) NOT NULL,
               `title` varchar(50) DEFAULT NULL,
               `link` varchar(100) DEFAULT NULL,
               `time` int(11) DEFAULT NULL,
               `status` int(11) NOT NULL,
               `class` int(11) NOT NULL,
               `created_by` int(11) DEFAULT NULL,
               `modified_by` int(11) DEFAULT NULL,
               `created_on` int(11) DEFAULT NULL,
               `modified_on` int(11) DEFAULT NULL
             ) ENGINE=InnoDB DEFAULT CHARSET=utf8; ");
      }
      
    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->get('zoom', $limit, $offset);

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

    public function user_groups(){
        return $this->db
                ->get('groups')
                ->result();
    }

    public function get_students($class){
        $this->select_all_key('admission');
        return $this->db   
                    ->where($this->dx('class') . ' =' . $class, NULL, FALSE)
                    ->get('admission')
                    ->result();
    }

    function create_notification($z_data)
    {
        $this->db->insert('zoom_notifications', $z_data);
        return $this->db->insert_id();
    }

    function get_notifications(){
        $this->select('zoom_notifications.*');
        $this->select('zoom.*');
        return $this->db    
                    ->join('zoom_notifications','zoom_notifications.zoom_id=zoom.id')
                    ->get('zoom')
                    ->result();
    }

    function zoom_classes(){
        return $this->db   
                    ->order_by('id','DESC') 
                    ->where('created_by',$this->ion_auth->get_user()->id)
                    ->get('zoom')
                    ->result();
    }

    function zoom_classes_by_id($id){
        return $this->db   
                    ->where('id',$id) 
                    ->get('zoom')
                    ->result();
    }
}