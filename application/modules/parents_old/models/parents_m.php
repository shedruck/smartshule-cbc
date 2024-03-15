<?php

class Parents_m extends MY_Model
{

        function __construct()
        {
// Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
               return $this->insert_key_data('parents', $data);
        }

        function find($id)
        {
                $this->select_all_key('parents');
                return $this->db->where(array('id' => $id))->get('parents')->row();
        }
		
		
		//Passport
        function emergency_contacts($id)
        {        
                 $this->select_all_key('emergency_contacts');		
                return $this->db ->where($this->dx('parent_id') . '='.$id, NULL, FALSE)->get('emergency_contacts')->row();
        }

        function list_()
        {
                $this->select_all_key('parents');
                return $this->db->order_by('id', 'desc')->group_by('status')->get('parents')->result();
        }

        function filterbystatus($status)
        {
                $this->select_all_key('parents');
                        return  $this->db->where($this->dx('status'). '= "'.$status.'"', null, false )
                        ->get('parents')
                        ->result();
        }

        function get($id)
        {
                $this->select_all_key('parents');
                return $this->db->where($this->dx('user_id') . ' = ' . $id, NULL, FALSE)->get('parents')->row();
        }

		function my_children($id)
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('parent_id') . ' = ' . $id, NULL, FALSE)->get('admission')->result();
        }

        function parent_details($id)
        {
                $this->select_all_key('parents');
                return $this->db->where($this->dx('identity') . ' = ' . $id, NULL, FALSE)->get('parents')->row();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('parents') > 0;
        }

        function exists_parent($id)
        {
                return $this->db->where($this->dx('user_id') . ' = ' . $id, NULL, FALSE)->count_all_results('parents') > 0;
        }

        function count()
        {

                return $this->db->count_all_results('parents');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('parents', $data);
        }

        /**
         * Update Parent Record
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function update_parent($id, $data)
        {
                return $this->update_key_data($id, 'parents', $data);
        }

    function update_adm($id, $data)
    {
        return $this->update_key_data($id, 'admission', $data);
    }

        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get($table);
                $dropdowns = $query->result();

                foreach ($dropdowns as $dropdown)
                {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        function delete($id)
        {
                return $this->db->delete('parents', array('id' => $id));
        }

    function remove_assign($parent, $student)
    {
        return $this->db->where('parent_id', $parent)->where('student_id', $student)->delete('assign_parent');
    }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->select_all_key('parents');
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('parents', $limit, $offset);

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

    function get_parents()
    {
        $this->select_all_key('parents');
        $results = $this->db
                          ->where($this->dx('status') . '=1', NULL, FALSE)
                          ->get('parents')
                          ->result();
        $arr = array();

        foreach ($results as $res)
        {
            $arr[$res->id] = $res->first_name . ' ' . $res->last_name . ' (' . $res->phone . ')';
        }

        return $arr;
    }
 

    function get_users()
    {
        $this->select_all_key('users');
        $results = $this->db
                          ->join('users_groups', $this->dx('user_id') . '= users.id')
                          ->where($this->dx('active') . '=1', NULL, FALSE)
                          ->where($this->dx('users_groups.group_id') . '!=8', NULL, FALSE)
                          ->where($this->dx('users_groups.group_id') . '!=1', NULL, FALSE)
                          ->get('users')
                          ->result();
        $arr = array();

        foreach ($results as $res)
        {
            $arr[$res->id] = $res->first_name . ' ' . $res->last_name;
        }

        return $arr;
    }

    /**
     * Assign Parent
     * 
     * @param type $data
     * @return void
     */
    function assign_parent($data)
    {
        return $this->db->insert('assign_parent', $data);
    }

        function no_account()
        {

                $this->select_all_key('parents');
                $this->db->order_by('id', 'desc');
                $query = $this->db->where($this->dx('user_id') . '= ""', NULL, FALSE)->get('parents');

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

        /**
         *  Messaging Stuff
         * 
         * 
         */

        /**
         * Check if Conversation Exists
         * 
         * @param int $user_1
         * @param int $user_2
         */
        function has_talked($user_1, $user_2)
        {
                $row = $this->db->where($this->dx('user_1') . '=' . $user_1, NULL, FALSE)
                             ->where($this->dx('user_2') . '= ' . $user_2, NULL, FALSE)
                             ->get('message_converse')
                             ->row();

                return $row ? $row->id : FALSE;
        }

        /**
         * New Conversation
         * 
         * @param type $data
         * @return type
         */
        function make_converse($data)
        {
                return $this->insert_key_data('message_converse', $data);
        }

        /**
         * New Message
         * 
         * @param type $data
         * @return type
         */
        function save_chat($data)
        {
                return $this->insert_key_data('messages', $data);
        }

        /**
         * Fetch Recent Messages Posted in conversation
         * 
         * @param type $conversation
         */
        function fetch_latest($conversation)
        {
                $this->select_all_key('messages');
                return $this->db->where($this->dx('conversation') . '=' . $conversation, NULL, FALSE)
                                          ->order_by($this->dx('created_on'), 'ASC', FALSE)
                                          ->limit(10)
                                          ->get('messages')
                                          ->result();
        }

        /**
         * Fetch Newest Chats
         * 
         * @param type $recipient
         * @param type $last
         */
        function fetch_new($recipient, $last)
        {
                $me = $this->ion_auth->get_user();
                return $this->db->where($this->dx('receiver') . '=' . $recipient, NULL, FALSE)
                                          ->where($this->dx('sender') . '=' . $me->id, NULL, FALSE)
                                          ->where('id >', $last)
                                          ->get('messages')
                                          ->result();
        }

}
