<?php

class Messages_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
                $this->db_set();
        }

        function create($data)
        {
                return $this->insert_key_data('messages', $data);
        }

        function create_convo($data)
        {
                return $this->insert_key_data('messages_link', $data);
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('messages')->row();
        }

        /**
         * Get Parent Messages
         * 
         * @param array $ids
         */
        function get_feed($ids)
        {
                $convos = $this->list_mine($ids);

                if (!$this->check_user_all())
                {
                        $mine = $this->db->where_in('id', $convos);
                }
                $this->select_all_key('messages');
                $mine = $this->db
                             ->order_by('id', 'DESC', FALSE)
                             ->get('messages')
                             ->result();
                foreach ($mine as $m)
                {
                        $to = $this->get_last($m->id);
                        switch ($to->recipient)
                        {
                                case 10000:
                                        $m->to = 'Headteacher';
                                        break;
                                case 10002:
                                        $m->to = 'Front Office';
                                        break;

                                default:
                                        $user = $this->ion_auth->get_user($to->recipient);
                                        $m->to = $to->recipient == $this->ion_auth->get_user()->id ? ' Me ' : $user->first_name . '  ' . $user->last_name;
                                        break;
                        }
                        $m->last = $to->created_on;
                        $m->seen = (($to->recipient == $this->ion_auth->get_user()->id) && ($to->seen == 0)) ? 0 : 1;
                        $from = $this->ion_auth->get_user($to->created_by);
                        $m->from = $to->created_by == $this->ion_auth->get_user()->id ? ' Me ' : $from->first_name . '  ' . $from->last_name;
                }
                return $mine;
        }

        /**
         * List ids for my messages
         * 
         * @param array $ids
         * @return array
         */
        function list_mine($ids)
        {
                $res = $this->db->select($this->dxa('convo_id'), FALSE)
                             ->where($this->dx('sender') . ' IN (' . implode(',', $ids) . ')', NULL, FALSE)
                             ->or_where($this->dx('recipient') . ' IN (' . implode(',', $ids) . ')', NULL, FALSE)
                             ->get('messages_link')
                             ->result();
                $cids = array();
                foreach ($res as $r)
                {
                        $cids[] = $r->convo_id;
                }
                $convos = array_unique($cids);
                if (empty($convos))
                {
                        $convos = array(0);
                }
                return $convos;
        }

        /**
         * Get last Message in conversation
         * 
         * @param int $message
         * @return type
         */
        function get_last($message)
        {
                $this->select_all_key('messages_link');
                $last = $this->db
                             ->where($this->dx('convo_id') . '=' . $message, NULL, FALSE)
                             ->order_by('id', 'DESC', FALSE)
                             ->get('messages_link')
                             ->row();

                return $last;
        }

        /**
         * Get Message
         * 
         * @param type $id
         * @return type
         */
        function get_message($id)
        {
                $this->select_all_key('messages');
                $row = $this->db
                             ->where('id', $id)
                             ->get('messages')
                             ->row();

                $this->select_all_key('messages_link');
                $row->items = $this->db
                             ->where($this->dx('convo_id') . '=' . $id, NULL, FALSE)
                             ->order_by('id', 'ASC', FALSE)
                             ->get('messages_link')
                             ->result();
                foreach ($row->items as $r)
                {
                        switch ($r->recipient)
                        {
                                case 10000:
                                        $r->to = 'Headteacher';
                                        break;
                                case 10002:
                                        $r->to = 'Front Office';
                                        break;

                                default:
                                        $user = $this->ion_auth->get_user($r->recipient);
                                        $r->to = $r->recipient == $this->ion_auth->get_user()->id ? ' Me ' : $user->first_name . '  ' . $user->last_name;
                                        break;
                        }
                        $sender = $this->ion_auth->get_user($r->sender);
                        $r->from = $r->sender == $this->ion_auth->get_user()->id ? ' Me ' : $sender->first_name . '  ' . $sender->last_name;
                }

                return $row;
        }

        /**
         * assign_user
         * 
         * @param int $user
         * @param int $role
         */
        function assign_user($user, $role)
        {
                $has = $this->db->where($this->dx('user') . '=' . $user, NULL, FALSE)
                             ->where($this->dx('role') . '=' . $role, NULL, FALSE)
                             ->where($this->dx('status') . '=1', NULL, FALSE)
                             ->get('messages_link_user')
                             ->row();
                if (empty($has))
                {
                        $form = array(
                            'user' => $user,
                            'role' => $role,
                            'status' => 1,
                            'created_by' => $this->user->id,
                            'created_on' => time()
                        );

                        $this->insert_key_data('messages_link_user', $form);
                }
                return TRUE;
        }

        /**
         * remove_user
         * 
         * @param int $id
         * @return type
         */
        function remove_user($id)
        {
                return $this->db->delete('messages_link_user', array('id' => $id));
        }

        /**
         * get_assign_users
         * 
         * @return type
         */
        function get_assign_users()
        {
                $roles = array(10000 => 'head', 10002 => 'front');
                $this->select_all_key('messages_link_user');
                $list = $this->db->where($this->dx('status') . '=1', NULL, FALSE)->get('messages_link_user')->result();

                $fn = array();
                foreach ($list as $l)
                {
                        $fn[$roles[$l->role]][] = $l;
                }
                return $fn;
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('messages') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('messages');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('messages', $data);
        }

        /**
         * update_link
         * 
         * @param int $id
         * @param type $data
         * @return type
         */
        function update_link($id, $data)
        {
                return $this->update_key_data($id, 'messages_link', $data);
        }

        /**
         * 
         * @param type $table
         * @param type $option_val
         * @param type $option_text
         * @return type
         */
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
                return $this->db->delete('messages', array('id' => $id));
        }

        /**
         * Setup DB Table Automatically
         * 
         */
        function db_set()
        {
                $this->db->query(" 
	CREATE TABLE IF NOT EXISTS  messages (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(255)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8; ");
        }

        /**
         * Get Messages for the user by Role
         */
        function get_by_user()
        {
                $this->select_all_key('messages_link_user');
                $rw = $this->db->where($this->dx('user') . '=' . $this->user->id, NULL, FALSE)
                             ->get('messages_link_user')
                             ->result();

                if (empty($rw))
                {
                        $roles = array($this->user->id);
                }
                else
                {
                        foreach ($rw as $r)
                        {
                                $roles[] = $r->role;
                        }
                }
                /**
                 * Allow headteacher to see all messages
                 */
                return $this->get_feed($roles);
        }

        /**
         * Check if User Allowed to see all Messages
         * 
         * @return type
         */
        function check_user_all()
        {
                $this->select_all_key('messages_link_user');
                $rw = $this->db->where($this->dx('user') . '=' . $this->user->id, NULL, FALSE)
                             ->get('messages_link_user')
                             ->result();
                $roles = array();
                if (empty($rw))
                {
                        $roles = array($this->user->id);
                }
                else
                {
                        foreach ($rw as $r)
                        {
                                $roles[] = $r->role;
                        }
                }

                return in_array(10000, $roles) ? TRUE : FALSE;
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ($page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('messages', $limit, $offset);

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
