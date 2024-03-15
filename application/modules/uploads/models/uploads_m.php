<?php

class Uploads_m extends MY_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db_set();
    }

    function create($data)
    {
        return $this->insert_key_data('admission', $data);
    }

    function delete_assigned_parent($id)
    {
        $query = $this->db->delete('student_id', array('id' => $id));

        return $query;
    }

    function delete_parent($id)
    {
        $query = $this->db->delete('parents', array('id' => $id));

        return $query;
    }

    function delete_user($id)
    {
        $query = $this->db->delete('users', array('id' => $id));

        return $query;
    }

    function delete_users_group($user_id)
    {
        if (!empty($user_id) && isset($user_id))
        {
            $this->db->where($this->dx('user_id') . '=' . $user_id, NULL, FALSE);
            $query = $this->db->delete('users_groups');
            return $query;
        }
        else
        {
            return 0;
        }
    }

    function get_all_students()
    {

        $this->select_all_key('admission');
        $this->db->order_by('id', 'desc');
        //$this->db->where($this->dx('status') . ' = 1', NULL, FALSE);
        $query = $this->db->get('admission')->result();

        return $query;
    }

    function get_list()
    {
        return $this->db->select('id,' . $this->dxa('email'), FALSE)
                                            ->get('admission')->result();
    }

    function get_all_parents()
    {

        $this->select_all_key('parents');
        $query = $this->db->get('parents')->result();

        return $query;
    }

    //Assign
    function assign_parent($data)
    {
        $this->db->insert('assign_parent', $data);
        return $this->db->insert_id();
    }

    function create_logins($data)
    {
        $this->db->insert('parents_logins', $data);
        return $this->db->insert_id();
    }

    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('uploads')->row();
    }

    function get_student($id)
    {
        $this->select_all_key('admission');
        return $this->db->where(array('id' => $id))->get('admission')->row();
    }

    function find_parent($id)
    {
        $this->select_all_key('parents');
        return $this->db->where(array('id' => $id))->get('parents')->row();
    }

    function get_plogins()
    {
        return $this->db->get('parents_logins')->result();
    }

    function parent_id($id)
    {
        $this->select_all_key('admission');
        return $this->db->where($this->dx('parent_id') . '=' . $id, NULL, FALSE)->get('admission')->row();
    }

    function get_class_stream($class_group, $stream)
    {
        $sr = $this->db->where(['name' => trim($stream)])->get('class_stream')->row();
        if (!$sr)
        {
            echo '<pre>';
            print_r('no stream');
            echo '</pre>';
            die();
        }
        $rw = $this->db->where(['class' => $class_group, 'stream' => $sr->id])->get('classes')->row();
        if (!$rw)
        {
            echo '<pre>';
            print_r('no class!');
            echo '</pre>';
            echo '<pre>';
            echo 'class => ' . $class_group . '.stream => ' . $stream;
            echo '</pre>';
            die();
            $data = array('class' => $class_group, 'stream' => $stream, 'status' => 1, 'created_on' => time(), 'created_by' => 1);
            $this->db->insert('classes', $data);
            return $this->db->insert_id();
        }
        return $rw->id;
    }

    function get_class_create($class_group, $stream)
    {
        $cc = $this->db->where(array('class' => $class_group, 'stream' => $stream))->get('classes')->row();

        if (empty($cc))
        {
            //create_class
            $data = array('class' => $class_group, 'stream' => $stream, 'status' => 1, 'created_on' => time(), 'created_by' => 1);
            $this->db->insert('classes', $data);
            return $this->db->insert_id();
        }
        return $cc->id;
    }

    function get_class($class_group, $stream_name)
    {
        $stream = $this->db->where(array('name' => $stream_name))->get('class_stream')->row();
        if (empty($stream))
        {
            die('stream not found ' . $stream_name);
        }
        $grp = $this->db->where(array('name' => $class_group))->get('class_groups')->row();
        if (empty($grp))
        {
            die('Group not found ' . $class_group);
        }
        $cc = $this->db->where(array('class' => $grp->id, 'stream' => $stream->id))->get('classes')->row();

        if (empty($cc))
        {
            //create_class
            $data = array('class' => $grp->id, 'stream' => $stream->id, 'status' => 1, 'created_on' => time(), 'created_by' => 1);
            $this->db->insert('classes', $data);
            return $this->db->insert_id();
        }
        return $cc->id;
    }

    function all_parents()
    {
        $this->select_all_key('parents');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('parents');

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

    function exists($id)
    {
        return $this->db->where(array('id' => $id))->count_all_results('uploads') > 0;
    }

    function exists_paro($email)
    {
        $this->select_all_key('users');
        return $this->db->where($this->dx('email') . '=' . $email, NULL, FALSE)->count_all_results('users') > 0;
    }

    function parent_phone_exists($phone)
    {
        $this->select_all_key('users');
        $row = $this->db->where($this->dx('phone') . "='" . $phone . "'", NULL, FALSE)->get('users')->row();
        if (empty($row))
        {
            return FALSE;
        }
        else
        {
            $this->select_all_key('parents');
            $prt = $this->db->where($this->dx('user_id') . '=' . $row->id, NULL, FALSE)->get('parents')->row();
            if (empty($prt))
            {
                die('User found but no Parent');
            }
        }
        return array('ps_id' => $prt->id, 'pid' => $row->id);
    }

    function count()
    {

        return $this->db->count_all_results('uploads');
    }

    /**
     * Fetch List of Parents
     * 
     * @return string
     */
    function fetch_parent_options()
    {
        $res = $this->db->select($this->dxa('first_name') . ', ' . $this->dxa('last_name') . ', ' . $this->dxa('phone') . ', ' . $this->dxa('user_id') . ', id', FALSE)
                          //->where($this->dx('status') . ' =  0', NULL, FALSE)
                          ->order_by($this->dx('first_name'), 'ASC', FALSE)
                          ->get('parents')
                          ->result();
        $options = array();

        foreach ($res as $r)
        {
            $options[$r->id] = $r->first_name . ' ' . $r->last_name . ' - ' . $r->phone . ' - (PID-' . $r->id . ') - (UID - ' . $r->user_id . ')';
        }
        return $options;
    }

    function update_attributes($id, $data)
    {
        return $this->db->where('id', $id)->update('uploads', $data);
    }

    function update_pst($id, $data)
    {
        //print_r($id);
        //print_r($data);die;
        return $this->db->where('student_id', $id)->update('assign_parent', $data);
    }

    function update_logins($id, $data)
    {
        return $this->db->where('parent_id', $id)->update('parents_logins', $data);
    }

    //-------------------------------

    function update_status($id, $data)
    {
        return $this->update_key_data($id, 'admission', $data);
    }

    function populate($table, $option_val, $option_text)
    {
        $query = $this->db->select('*')->order_by($option_text)->get($table);
        $dropdowns = $query->result();
        $options = array();
        foreach ($dropdowns as $dropdown)
        {
            $options[$dropdown->$option_val] = $dropdown->$option_text;
        }
        return $options;
    }

    function delete($id)
    {
        return $this->db->delete('uploads', array('id' => $id));
    }

    /**
     * Setup DB Table Automatically
     * 
     */
    function db_set()
    {
        $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  uploads (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
    }

    function get_all()
    {
        //$offset = $limit * ( $page - 1);
        $this->select_all_key('admission');
        $this->db->order_by('id', 'desc');
        //$this->db->where($this->dx('status') . ' = 3', NULL, FALSE);
        $query = $this->db->get('admission');

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
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $query = $this->db->get('uploads', $limit, $offset);

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
