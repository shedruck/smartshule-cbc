<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');
/**
 * Name:  Ion Auth Model
 *
 * Author:  Ben Edmunds
 * ben.edmunds@gmail.com
 * @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
//  CI 2.0 Compatibility
if (!class_exists('CI_Model'))
{

        class CI_Model extends Model
        {
                
        }

}

class Ion_auth_model extends MY_Model
{

        /**
         * Holds an array of tables used
         *
         * @var string
         * */
        public $tables = array();

        /**
         * activation code
         *
         * @var string
         * */
        public $activation_code;

        /**
         * forgotten password key
         *
         * @var string
         * */
        public $forgotten_password_code;

        /**
         * new password
         *
         * @var string
         * */
        public $new_password;

        /**
         * Where
         *
         * @var array
         * */
        public $_ion_where = array();

        /**
         * Select
         *
         * @var string
         * */
        public $_ion_select = array();

        /**
         * Like
         *
         * @var string
         * */
        public $_ion_like = array();

        /**
         * Limit
         *
         * @var string
         * */
        public $_ion_limit = NULL;

        /**
         * Offset
         *
         * @var string
         * */
        public $_ion_offset = NULL;

        /**
         * Order By
         *
         * @var string
         * */
        public $_ion_order_by = NULL;

        /**
         * Order
         *
         * @var string
         * */
        public $_ion_order = NULL;

        /**
         * Hooks
         *
         * @var object
         * */
        protected $_ion_hooks;

        /**
         * Response
         *
         * @var string
         * */
        protected $response = NULL;

        /**
         * message (uses lang file)
         *
         * @var string
         * */
        protected $messages;

        /**
         * error message (uses lang file)
         *
         * @var string
         * */
        protected $errors;

        /**
         * error start delimiter
         *
         * @var string
         * */
        protected $error_start_delimiter;

        /**
         * error end delimiter
         *
         * @var string
         * */
        protected $error_end_delimiter;

        /**
         * caching of users and their groups
         *
         * @var array
         * */
        public $_cache_user_in_group = array();

        /**
         * caching of groups
         *
         * @var array
         * */
        protected $_cache_groups = array();

        /**
         * Identity
         *
         * @var string
         * */
        public $identity;

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
                $this->load->config('ion_auth', TRUE);
                $this->load->helper('cookie');
                $this->load->helper('date');
                $this->load->library('session');
                $this->load->model('groups/groups_m');
                $this->tables = $this->config->item('tables', 'ion_auth');
                $this->columns = $this->config->item('columns', 'ion_auth');
                $this->identity_column = $this->config->item('identity', 'ion_auth');
                $this->store_salt = $this->config->item('store_salt', 'ion_auth');
                $this->salt_length = $this->config->item('salt_length', 'ion_auth');
                $this->meta_join = $this->config->item('join', 'ion_auth');
                $this->min_password_length = $this->config->item('min_password_length', 'ion_auth');
                /**
                 * Checks if salt length is at least the length
                 * of the minimum password length.
                 * */
                if ($this->salt_length < $this->min_password_length)
                {
                        $this->salt_length = $this->min_password_length;
                }
        }

        /**
         * Misc functions
         *
         * Hash password : Hashes the password to be stored in the database.
         * Hash password db : This function takes a password and validates it
         * against an entry in the users table.
         * Salt : Generates a random salt value.
         *
         * @author Mathew
         */

        /**
         * Hashes the password to be stored in the database.
         *
         * @return void
         * @author Mathew
         * */
        public function hash_password($password, $salt = false)
        {
                if (empty($password))
                {
                        return FALSE;
                }
                if ($this->store_salt && $salt)
                {
                        return sha1($password . $salt);
                }
                else
                {
                        $salt = $this->salt();
                        return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
                }
        }

        /**
         * This function takes a password and validates it
         * against an entry in the users table.
         *
         * @return void
         * @author Mathew
         * */
        public function hash_password_db($identity, $password)
        {
                if (empty($identity) || empty($password))
                {
                        return FALSE;
                }
                $query = $this->db->select($this->dxa('password') . ',' . $this->dxa('salt'), FALSE)
                             ->where($this->dx($this->identity_column) . '= ' . $this->db->escape($identity), NULL, FALSE)
                             // ->where($this->ion_auth->_extra_where)
                             ->limit(1)
                             ->get($this->tables['users']);
                $result = $query->row();
                if ($query->num_rows() !== 1)
                {
                        return FALSE;
                }
                if ($this->store_salt)
                {
                        return sha1($password . $result->salt);
                }
                else
                {
                        $salt = substr($result->password, 0, $this->salt_length);
                        return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
                }
        }

        /**
         * Fetch all logged in users.
         *
         * @return array
         * @author Ben Ssyde
         * */
        function fetch_logged_in()
        {
                $res = $this->db->where('user_data !=', '')->get('o_sessions')->result();
                $users = array();
                foreach ($res as $row)
                {
                        $user = (object) unserialize($row->user_data);
                        if (!empty($user->user_id))
                                $users[$user->user_id] = $user->user_id;
                }
                return $users;
        }

        /**
         * Generates a random salt value.
         *
         * @return void
         * @author Mathew
         * */
        public function salt()
        {
                return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
        }

        /**
         * Activation functions
         *
         * Activate : Validates and removes activation code.
         * Deactivae : Updates a users row with an activation code.
         *
         * @author Mathew
         */

        /**
         * activate
         *
         * @return void
         * @author Mathew
         * */
        public function activate($id, $code = false)
        {
                if ($code !== false)
                {
                        $query = $this->db->select($this->identity_column)
                                     ->where('activation_code', $code)
                                     ->limit(1)
                                     ->get($this->tables['users']);
                        $result = $query->row();
                        if ($query->num_rows() !== 1)
                        {
                                return FALSE;
                        }
                        $identity = $result->{$this->identity_column};
                        $data = array(
                            'activation_code' => '',
                            'active' => 1
                        );
                        $this->db->where($this->ion_auth->_extra_where);
                        $this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));
                }
                else
                {
                        $data = array(
                            'activation_code' => '',
                            'active' => 1
                        );
                        $this->db->where($this->ion_auth->_extra_where);
                        $this->db->update($this->tables['users'], $data, array('id' => $id));
                }
                return $this->db->affected_rows() == 1;
        }

        /**
         * Deactivate
         *
         * @return void
         * @author Mathew
         * */
        public function deactivate($id = 0)
        {
                if (empty($id))
                {
                        return FALSE;
                }
                $activation_code = sha1(md5(microtime()));
                $this->activation_code = $activation_code;
                $data = array(
                    'activation_code' => $activation_code,
                    'active' => 0
                );
                $this->db->where($this->ion_auth->_extra_where);
                $this->db->update($this->tables['users'], $data, array('id' => $id));
                return $this->db->affected_rows() == 1;
        }

        /**
         * change password
         *
         * @return bool
         * @author Mathew
         * */
        public function change_password($identity, $old, $new)
        {
                $query = $this->db->select($this->dxa('password') . ' ,' . $this->dxa('salt'), FALSE)
                             ->where($this->dx($this->identity_column) . "= '" . $identity . "'", NULL, FALSE)
                             ->where($this->ion_auth->_extra_where)
                             ->limit(1)
                             ->get($this->tables['users']);
                $result = $query->row();
                $db_password = $result->password;
                //  $old = $this->db->escape($old);
                //$new = $this->db->escape($new);
                $old = $this->hash_password_db($identity, $old);
                $new = $this->hash_password($new, $result->salt);
                if ($db_password === $old)
                {
                        //store the new password and reset the remember code so all remembered instances have to re-login
                        $data = array(
                            'password' => $new,
                            'remember_code' => '',
                            'changed_on' =>1
                        );
                        //$this->db->where($this->ion_auth->_extra_where);
                        $this->update_key_where($this->dx($this->identity_column) . "= '" . $identity . "'", $this->tables['users'], $data);
                        //$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));
                        return $this->db->affected_rows() == 1;
                }
                return FALSE;
        }

        /**
         * reset password
         *
         * @return bool
         * @author Mathew
         * */
        public function reset_password($identity, $new)
        {


                $query = $this->db->select('id, password, salt')
                             ->where('id', $identity)
                             ->limit(1)
                             ->order_by('id', 'desc')
                             ->get($this->tables['users'])
                             ->row();


                $new = $this->hash_password($new, $query->salt);

                //store the new password and reset the remember code so all remembered instances have to re-login
                //also clear the forgotten password code
                $data = array(
                    'password' => $new,
                    'remember_code' => NULL,
                    'forgotten_password_code' => NULL,
                );


                $res = $this->update_key_data($identity, 'users', $data);
                //print_r($res);die;
                return $res;
        }

        /**
         * update_password
         *  
         * @author Ben
         * @param type $identity
         * @param type $new
         * @return type
         */
        public function update_password($identity, $new)
        {
                $row = $this->db->select($this->dxa('salt'), FALSE)
                             ->where($this->dx($this->identity_column) . "= '" . $identity . "'", NULL, FALSE)
                             ->where($this->ion_auth->_extra_where)
                             ->limit(1)
                             ->get($this->tables['users'])
                             ->row();

                $newpass = $this->hash_password($new, $row->salt);

                //store the new password and reset the remember code so all remembered instances have to re-login
                $data = array(
                    'password' => $newpass,
                    'remember_code' => '',
                    'forgotten_password_code' => '',
                );

                return $this->update_key_where($this->dx($this->identity_column) . "= '" . $identity . "'", $this->tables['users'], $data);
        }

        /**
         * Checks username
         *
         * @return bool
         * @author Mathew
         * */
        public function username_check($username = '')
        {
                if (empty($username))
                {
                        return FALSE;
                }
                return $this->db->where($this->dx('username') . ' = ' . $this->db->escape($username), NULL, FALSE)
                                          //->where($this->ion_auth->_extra_where)
                                          ->count_all_results($this->tables['users']) > 0;
        }

        /**
         * Checks email
         *
         * @return bool
         * @author Mathew
         * */
        public function email_check($email = '')
        {
                if (empty($email))
                {
                        return FALSE;
                }
                $res = $this->db->where($this->dx('email') . ' = ' . $this->db->escape($email), NULL, FALSE)
                                          //->where($this->ion_auth->_extra_where)
                                          ->count_all_results($this->tables['users']) > 0;
                return $res;
        }

        /**
         * Identity check
         *
         * @return bool
         * @author Mathew
         * */
        protected function identity_check($identity = '')
        {
                if (empty($identity))
                {
                        return FALSE;
                }
                /*
                  if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
                  {
                  $this->db->where($this->ion_auth->_extra_where);
                  }
                 */
                return $this->db->where($this->dx($this->identity_column) . "= '" . $identity . "'", NULL, FALSE)
                                          ->count_all_results($this->tables['users']) > 0;
        }

        public function clear_forgotten_password_code($code)
        {
                if (empty($code))
                {
                        return FALSE;
                }
                $this->db->where('forgotten_password_code', $code);
                if ($this->db->count_all_results($this->tables['users']) > 0)
                {
                        $data = array(
                            'forgotten_password_code' => NULL,
                            'forgotten_password_time' => NULL
                        );

                        $this->update_key_where($this->dx('forgotten_password_code') . "= '" . $code . "'", $this->tables['users'], $data);
                        //$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));
                        return TRUE;
                }
                return FALSE;
        }

        /**
         * Insert a forgotten password key.
         *
         * @return bool
         * @author Mathew
         * */
        public function forgotten_password($email = '')
        {
                if (empty($email))
                {
                        return FALSE;
                }
                $key = $this->hash_password(microtime() . $email);

                $this->forgotten_password_code = $key;
                $this->db->where($this->ion_auth->_extra_where);
                //$this->db->update($this->tables['users'], array('forgotten_password_code' => $key), array('email' => $email));
                $this->update_key_where($this->dx('email') . "= '" . $email . "'", $this->tables['users'], array('forgotten_password_code' => $key));
                //return $this->db->affected_rows() == 1;
                return $key;
        }

        /**
         * Forgotten Password Complete
         *
         * @return string
         * @author Mathew
         * */
        public function forgotten_password_complete($code, $salt = FALSE)
        {
                if (empty($code))
                {
                        return FALSE;
                }
                $this->db->where('forgotten_password_code', $code);
                if ($this->db->count_all_results($this->tables['users']) > 0)
                {
                        $password = $this->salt();
                        $data = array(
                            'password' => $this->hash_password($password, $salt),
                            'forgotten_password_code' => '0',
                            'active' => 1,
                        );
                        //$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));
                        $this->update_key_where($this->dx('forgotten_password_code') . "= '" . $code . "'", $this->tables['users'], $data);
                        return $password;
                }
                return FALSE;
        }

        /**
         * profile
         *
         * @return void
         * @author Mathew
         * */
        public function profile($identity = '', $is_code = false)
        {
                if (empty($identity))
                {
                        return FALSE;
                }
                $this->db->select(array(
                    $this->tables['users'] . '.*',
                    $this->tables['groups'] . '.name AS ' . $this->db->protect_identifiers('group'),
                    $this->tables['groups'] . '.description AS ' . $this->db->protect_identifiers('group_description')
                ));
                if (!empty($this->columns))
                {
                        foreach ($this->columns as $field)
                        {
                                $this->db->select($this->tables['users'] . '.' . $field);
                        }
                }
                //$this->db->join($this->tables['meta'], $this->tables['users'] . '.id = ' . $this->tables['meta'] . '.' . $this->meta_join, 'left');
                $this->db->join($this->tables['groups'], $this->tables['users'] . '.group_id = ' . $this->tables['groups'] . '.id', 'left');
                if ($is_code)
                {
                        $this->db->where($this->tables['users'] . '.forgotten_password_code', $identity);
                }
                else
                {
                        $this->db->where($this->tables['users'] . '.' . $this->identity_column, $identity);
                }
                $this->db->where($this->ion_auth->_extra_where);
                $this->db->limit(1);
                $i = $this->db->get($this->tables['users']);
                return ($i->num_rows > 0) ? $i->row() : FALSE;
        }

        /**
         * Basic functionality
         *
         * Register
         * Login
         *
         * @author Mathew
         */

        /**
         * register
         *
         * @return bool
         * @author Mathew
         * */
        public function register($username, $password, $email, $additional_data = false, $group_name = false)
        {
                if ($this->identity_column == 'email' && $this->email_check($email))
                {
                        $this->ion_auth->set_error('account_creation_duplicate_email');
                        return FALSE;
                }
                elseif ($this->identity_column == 'username' && $this->username_check($username))
                {
                        $this->ion_auth->set_error('account_creation_duplicate_username');
                        return FALSE;
                }
                // If username is taken, use username1 or username2, etc.
                if ($this->identity_column != 'username')
                {
                        for ($i = 0; $this->username_check($username); $i ++)
                        {
                                if ($i > 0)
                                {
                                        $username .= $i;
                                }
                        }
                }
                // If a group ID was passed, use it
                if (isset($additional_data['group_id']))
                {
                        $group_id = $additional_data['group_id'];
                        unset($additional_data['group_id']);
                }
                // Otherwise use the group name if it exists
                else
                {
                        // Group ID
                        if (!$group_name)
                        {
                                $group_name = $this->config->item('default_group', 'ion_auth');
                        }
                        $group_id = $this->db->select('id')
                                                  ->where('name', $group_name)
                                                  ->get($this->tables['groups'])
                                                  ->row()->id;
                }
                // IP Address
                $ip_address = $this->input->ip_address();
                $salt = $this->store_salt ? $this->salt() : FALSE;
                $password = $this->hash_password($password, $salt);
                // Users table.
                $data = array(
                    'first_name' => $additional_data['first_name'],
                    'last_name' => $additional_data['last_name'],
                    'passport' => isset($additional_data['passport']) ? $additional_data['passport'] : '',
                    'phone' => isset($additional_data['phone']) ? $additional_data['phone'] : '',
                    //'admission_number' => isset($additional_data['regno']) ? $additional_data['regno'] : '',
                    'username' => $username,
                    'password' => $password,
                    'email' => $email,
                    'group_id' => $group_id,
                    'ip_address' => $ip_address,
                    'created_on' => now(),
                    'last_login' => now(),
                    'active' => 1,
                    'created_by' => $additional_data['me'],
                    'changed_on'=>0
                );
                if ($this->store_salt)
                {
                        $data['salt'] = $salt;
                }
                if ($this->ion_auth->_extra_set)
                {
                        $this->db->set($this->ion_auth->_extra_set);
                }
                $id = $this->insert_key_data($this->tables['users'], $data);
                return $id > 0 ? $id : false;
        }

        /**
         * login
         *
         * @return bool
         * @author Mathew
         * */
        public function login($identity, $password, $remember = FALSE)
        {
                if (empty($identity) || empty($password) || !$this->identity_check($identity))
                {
                        return FALSE;
                }
                $query = $this->db->select($this->dxa($this->identity_column) . ', id,' . $this->dxa('password') . ' ,' . $this->dxa('group_id'), FALSE)
                             ->where($this->dx($this->identity_column) . ' =' . $this->db->escape($identity), NULL, FALSE)
                             ->where($this->dx('active') . '= 1', NULL, FALSE)
                             // ->where($this->ion_auth->_extra_where)
                             ->limit(1)
                             ->get($this->tables['users']);
                $result = $query->row();
                if ($query->num_rows() == 1)
                {
                        $password = $this->hash_password_db($identity, $password);
                        if ($result->password === $password)
                        {
                                $this->update_last_login($result->id);
                                $group_row = $this->db->select('name')->where('id', $result->group_id)->get($this->tables['groups'])->row();
                                $session_data = array(
                                    $this->identity_column => $result->{$this->identity_column},
                                    'id' => $result->id, //kept for backwards compatibility
                                    'user_id' => $result->id, //everyone likes to overwrite id so we'll use user_id
                                    'group_id' => $result->group_id,
                                             //'group' => $group_row->name
                                );
                                $this->session->set_userdata($session_data);
                                if ($remember && $this->config->item('remember_users', 'ion_auth'))
                                {
                                        $this->remember_user($result->id);
                                }
                                return TRUE;
                        }
                }
                return FALSE;
        }

        /**
         * user
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function user($id = NULL)
        {
                $this->trigger_events('user');
                //if no id was passed use the current users id
                $id || $id = $this->session->userdata('user_id');
                $this->select_all_key('users');
                return $this->db->limit(1)->where($this->tables['users'] . '.id', $id)->get('users');
        }

        /**
         * get_users
         *
         * @return object Users
         * @author Ben Edmunds
         * */
        public function get_users($group = false, $limit = NULL, $offset = NULL)
        {
                $this->select_all_key($this->tables['users']);
                $this->db->select(array(
                    //  $this->tables['users'] . '.*',
                    $this->tables['groups'] . '.name AS ' . $this->db->protect_identifiers('group'),
                    $this->tables['groups'] . '.description AS ' . $this->db->protect_identifiers('group_description')
                ));
                if (!empty($this->columns))
                {
                        // foreach ($this->columns as $field)
                        // {
                        //$this->db->select($this->tables['users'] . '.' . $field);
                        // }
                }
                $this->db->join($this->tables['users_groups'], $this->tables['users'] . '.id = ' . $this->dx($this->tables['users_groups'] . '.' . $this->meta_join), 'left');
                $this->db->join($this->tables['groups'], $this->dx($this->tables['users'] . '.group_id') . ' = ' . $this->tables['groups'] . '.id', 'left');
                if (is_string($group))
                {
                        $this->db->where($this->tables['groups'] . '.name', $group);
                }
                else if (is_array($group))
                {
                        $this->db->where_in($this->tables['groups'] . '.name', $group);
                }
                if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
                {
                        $this->db->where($this->ion_auth->_extra_where);
                }
                if (isset($limit) && isset($offset))
                        $this->db->limit($limit, $offset);
                return $this->db->get($this->tables['users']);
        }

        /**
         * get_users_count
         *
         * @return int Number of Users
         * @author Sven Lueckenbach
         * */
        public function get_users_count($group = false)
        {
                if (is_string($group))
                {
                        $this->db->where($this->tables['groups'] . '.name', $group);
                }
                else if (is_array($group))
                {
                        $this->db->where_in($this->tables['groups'] . '.name', $group);
                }
                if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
                {
                        $this->db->where($this->ion_auth->_extra_where);
                }
                $this->db->from($this->tables['users']);
                return $this->db->count_all_results();
        }

        /**
         * get_active_users
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_active_users($group_name = false)
        {
                $this->db->where($this->tables['users'] . '.active', 1);
                return $this->get_users($group_name);
        }

        /**
         * get_inactive_users
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_inactive_users($group_name = false)
        {
                $this->db->where($this->tables['users'] . '.active', 0);
                return $this->get_users($group_name);
        }

        /**
         * get_user
         *
         * @return object
         * @author Phil Sturgeon
         * */
        public function get_user($id = false)
        {
                //if no id was passed use the current users id
                if (empty($id))
                {
                        $id = $this->session->userdata('user_id');
                }
                //$this->select_all_key($this->tables['users']);
                $this->db->where($this->tables['users'] . '.id', $id);
                $this->db->limit(1);
                return $this->get_users();
        }

        /**
         * get_user_by_email
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_user_by_email($email)
        {
                $this->db->limit(1);
                return $this->get_users_by_email($email);
        }

        /**
         * get_users_by_email
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_users_by_email($email)
        {
                $this->db->where($this->tables['users'] . '.email', $email);
                return $this->get_users();
        }

        public function get_by_email($email)
        {
                $this->select_all_key('users');
                return  $this->db->where($this->dx($this->tables['users'] . '.email')."='". $email."'", null, false )
                ->get('users')
                ->row();
         
         }


         public function get_by_code($code)
        {
                $this->select_all_key('users');
                return  $this->db->where($this->dx($this->tables['users'] . '.forgotten_password_code')."='". $code."'", null, false )
                ->get('users')
                ->row();
         
         }

         public function get_by_id($id)
         {
                 $this->select_all_key('users');
                 return  $this->db->where($this->dx($this->tables['users'] . '.forgotten_password_code')."='". $code."'", null, false )
                 ->get('users')
                 ->row();
          
          }

        /**
         * get_user_by_username
         *
         * @return object
         * @author Kevin Smith
         * */
        public function get_user_by_username($username)
        {
                $this->db->limit(1);
                return $this->get_users_by_username($username);
        }

        /**
         * get_users_by_username
         *
         * @return object
         * @author Kevin Smith
         * */
        public function get_users_by_username($username)
        {
                $this->db->where($this->tables['users'] . '.username', $username);
                return $this->get_users();
        }

        /**
         * get_user_by_identity
         *                                      //copied from above ^
         * @return object
         * @author jondavidjohn
         * */
        public function get_user_by_identity($identity)
        {
                $this->db->where($this->dx($this->tables['users'] . '.' . $this->identity_column) . "='" . $identity . "'", NULL, FALSE);
                $this->db->limit(1);
                return $this->get_users();
        }

        /**
         * get_user_by_code
         *   
         * @return object
         * @author jondavidjohn
         * */
        public function get_user_by_code($code)
        {
                $this->db->where($this->dx($this->tables['users'] . '.forgotten_password_code') . "='" . $code . "'", NULL, FALSE);
                $this->db->limit(1);
                return $this->get_users()->row();
        }

        /**
         * get_newest_users
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_newest_users($limit = 10)
        {
                $this->db->order_by($this->tables['users'] . '.created_on', 'desc');
                $this->db->limit($limit);
                return $this->get_users();
        }

        /**
         * add_to_group
         *
         * @return bool
         * @author Ben Edmunds
         * */
        public function add_to_group($group_id, $user_id = false)
        {
                $this->trigger_events('add_to_group');
                $belongs = $this->get_users_groups($user_id)->result();
                $grps = array();
                foreach ($belongs as $b)
                {
                        $grps[] = $b->id;
                }
                if (in_array($group_id, $grps))
                {
                        return TRUE;
                }
                //if no id was passed use the current users id
                $user_id || $user_id = $this->session->userdata('user_id');
                /* Enc Fix */
                $dtt = array('group_id' => (int) $group_id, 'user_id' => (int) $user_id);
                if ($return = $this->insert_key_data($this->tables['users_groups'], $dtt))
                /* Enc Fix */
                //if ($return = $this->db->insert($this->tables['users_groups'], array('group_id' => (int) $group_id, 'user_id' => (int) $user_id)))
                {
                        if (isset($this->_cache_groups[$group_id]))
                        {
                                $group_name = $this->_cache_groups[$group_id];
                        }
                        else
                        {
                                $group = $this->group($group_id)->result();
                                $group_name = $group[0]->name;
                                $this->_cache_groups[$group_id] = $group_name;
                        }
                        $this->_cache_user_in_group[$user_id][$group_id] = $group_name;
                }
                return $return;
        }

        public function trigger_events($events)
        {
                if (is_array($events) && !empty($events))
                {
                        foreach ($events as $event)
                        {
                                $this->trigger_events($event);
                        }
                }
                else
                {
                        if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events))
                        {
                                foreach ($this->_ion_hooks->$events as $name => $hook)
                                {
                                        $this->_call_hook($events, $name);
                                }
                        }
                }
        }

        public function set_hook($event, $name, $class, $method, $arguments)
        {
                $this->_ion_hooks->{$event}[$name] = new stdClass;
                $this->_ion_hooks->{$event}[$name]->class = $class;
                $this->_ion_hooks->{$event}[$name]->method = $method;
                $this->_ion_hooks->{$event}[$name]->arguments = $arguments;
        }

        public function remove_hook($event, $name)
        {
                if (isset($this->_ion_hooks->{$event}[$name]))
                {
                        unset($this->_ion_hooks->{$event}[$name]);
                }
        }

        public function remove_hooks($event)
        {
                if (isset($this->_ion_hooks->$event))
                {
                        unset($this->_ion_hooks->$event);
                }
        }

        protected function _call_hook($event, $name)
        {
                if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method))
                {
                        $hook = $this->_ion_hooks->{$event}[$name];
                        return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);
                }
                return FALSE;
        }

        /**
         * get_users_groups
         *
         * @return array
         * @author Ben Edmunds
         * */
        public function get_users_groups($id = FALSE)
        {
                $this->trigger_events('get_users_group');
                //if no id was passed use the current users id
                $id || $id = $this->session->userdata('user_id');
                return $this->db->select($this->dx($this->tables['users_groups'] . '.group_id') . ' as id, ' . $this->tables['groups'] . '.name'
                                                       . ' as name,' . $this->tables['groups'] . '.description' . ' as description', FALSE)
                                          ->where($this->dx($this->tables['users_groups'] . '.user_id') . ' = ' . $id, NULL, FALSE)
                                          ->join('`'.$this->tables['groups'].'`', $this->dx($this->tables['users_groups'] . '.group_id') . '=' . $this->tables['groups'] . '.id')
                                          ->get($this->tables['users_groups']) ;
        }

        /**
         * remove_from_group
         *
         * @return bool
         * @author Ben Edmunds
         * */
        public function remove_from_group($group_ids = false, $user_id = false)
        {
                $this->trigger_events('remove_from_group');
                // user id is required
                if (empty($user_id))
                {
                        return FALSE;
                }
                // if group id(s) are passed remove user from the group(s)
                if (!empty($group_ids))
                {
                        if (!is_array($group_ids))
                        {
                                $group_ids = array($group_ids);
                        }
                        foreach ($group_ids as $group_id)
                        {
                                $this->db->where($this->dx('group_id') . ' = ' . (int) $group_id, NULL, FALSE);
                                $this->db->where($this->dx('user_id') . ' = ' . (int) $user_id, NULL, FALSE);
                                $this->db->delete($this->tables['users_groups']);
                                if (isset($this->_cache_user_in_group[$user_id]) && isset($this->_cache_user_in_group[$user_id][$group_id]))
                                {
                                        unset($this->_cache_user_in_group[$user_id][$group_id]);
                                }
                        }
                        $return = TRUE;
                }
                // otherwise remove user from all groups
                else
                {
                        if ($return = $this->db->where($this->dx('user_id') . ' = ' . (int) $user_id, NULL, FALSE)->delete($this->tables['users_groups']))
                        {
                                $this->_cache_user_in_group[$user_id] = array();
                        }
                }
                return $return;
        }

        /**
         * get_users_group
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_users_group($id = false)
        {
                //if no id was passed use the current users id
                $id || $id = $this->session->userdata('user_id');
                $user = $this->db->select('group_id')
                             ->where('id', $id)
                             ->get($this->tables['users'])
                             ->row();
                return $this->db->select('name, description')
                                          ->where('id', $user->group_id)
                                          ->get($this->tables['groups'])
                                          ->row();
        }

        /**
         * get_groups
         *
         * @return object
         * @author Phil Sturgeon
         * */
        public function get_groups()
        {
                return $this->db->get($this->tables['groups'])
                                          ->result();
        }

        /**
         * get_group
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_group($id)
        {
                $this->db->where('id', $id);
                return $this->db->get($this->tables['groups'])
                                          ->row();
        }

        public function is_in_group($user_id, $group_id)
        {
                $this->db->where($this->dx('user_id') . ' = ' . $user_id, NULL, FALSE);
                $this->db->where($this->dx('group_id') . ' = ' . $group_id, NULL, FALSE);
                $groups = $this->db->get('users_groups')->result();
                return count(($groups)) ? TRUE : FALSE;
        }

        /**
         * get_group_by_name
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function get_group_by_name($name)
        {
                $this->db->where('name', $name);
                return $this->db->get($this->tables['groups'])
                                          ->row();
        }

        /**
         * group
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function group($id = NULL)
        {
                $this->trigger_events('group');
                if (isset($id))
                {
                        $this->db->where($this->tables['groups'] . '.id', $id);
                }
                $this->limit(1);
                return $this->groups();
        }

        /**
         * groups
         *
         * @return object
         * @author Ben Edmunds
         * */
        public function groups()
        {
                $this->trigger_events('groups');
                //run each where that was passed
                if (isset($this->_ion_where))
                {
                        foreach ($this->_ion_where as $where)
                        {
                                $this->db->where($where);
                        }
                        $this->_ion_where = array();
                }
                if (isset($this->_ion_limit) && isset($this->_ion_offset))
                {
                        $this->db->limit($this->_ion_limit, $this->_ion_offset);
                        $this->_ion_limit = NULL;
                        $this->_ion_offset = NULL;
                }
                else if (isset($this->_ion_limit))
                {
                        $this->db->limit($this->_ion_limit);
                        $this->_ion_limit = NULL;
                }
                //set the order
                if (isset($this->_ion_order_by) && isset($this->_ion_order))
                {
                        $this->db->order_by($this->_ion_order_by, $this->_ion_order);
                }
                $this->response = $this->db->get($this->tables['groups']);
                return $this;
        }

        /**
         * update_user
         *
         * @return bool
         * @author Phil Sturgeon
         * */
        public function update_user($id, $data)
        {
                ///$this->select_all_key($this->tables['users']);
                $user = $this->get_user($id)->row();
                $this->db->trans_begin();
                if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column])
                {
                        $this->db->trans_rollback();
                        $this->ion_auth->set_error('account_creation_duplicate_' . $this->identity_column);
                        return FALSE;
                }
                if (!empty($this->columns))
                {
                        //filter the data passed by the columns in the config
                        $meta_fields = array();
                        foreach ($this->columns as $field)
                        {
                                if (is_array($data) && isset($data[$field]))
                                {
                                        $meta_fields[$field] = $data[$field];
                                        unset($data[$field]);
                                }
                        }
                        //update the meta data
                        if (count($meta_fields) > 0)
                        {
                                $this->update_key_data($id, $this->tables['users'], $meta_fields);
                                //$this->db->where('id', $id);
                                // 'user_id' = $id
                                // $this->db->where($this->meta_join, $id);
                                // $this->db->set($meta_fields);
                                //$this->db->update($this->tables['users']);
                        }
                }
                if (array_key_exists('username', $data) || array_key_exists('password', $data) || array_key_exists('email', $data) || array_key_exists('group_id', $data))
                {
                        if (array_key_exists('password', $data))
                        {
                                $data['password'] = $this->hash_password($data['password'], $user->salt);
                        }
                        //$this->db->where($this->ion_auth->_extra_where);
                        // $this->db->update($this->tables['users'], $data, array('id' => $id));
                        $this->update_key_data($id, $this->tables['users'], $data);
                }
                if ($this->db->trans_status() === FALSE)
                {
                        $this->db->trans_rollback();
                        return FALSE;
                }
                $this->db->trans_commit();
                return TRUE;
        }

        /**
         * delete_user
         *
         * @return bool
         * @author Phil Sturgeon
         * */
        public function delete_user($id)
        {
                $this->db->trans_begin();
                // $this->db->delete($this->tables['meta'], array($this->meta_join => $id));
                $this->db->delete($this->tables['users'], array('id' => $id));
                if ($this->db->trans_status() === FALSE)
                {
                        $this->db->trans_rollback();
                        return FALSE;
                }
                $this->db->trans_commit();
                return TRUE;
        }

        /**
         * update_last_login
         *
         * @return bool
         * @author Ben Edmunds
         * */
        public function update_last_login($id)
        {
                $this->load->helper('date');
                if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
                {
                        $this->db->where($this->ion_auth->_extra_where);
                }
                $this->update_key_data($id, $this->tables['users'], array('last_login' => now()));
                //$this->db->update($this->tables['users'], array('last_login' => now()), array('id' => $id));
                return $this->db->affected_rows() == 1;
        }

        /**
         * set_lang
         *
         * @return bool
         * @author Ben Edmunds
         * */
        public function set_lang($lang = 'en')
        {
                set_cookie(array(
                    'name' => 'lang_code',
                    'value' => $lang,
                    'expire' => $this->config->item('user_expire', 'ion_auth') + time()
                ));
                return TRUE;
        }

        public function row()
        {
                $this->trigger_events('row');
                $row = $this->response->row();
                $this->response->free_result();
                return $row;
        }

        public function row_array()
        {
                $this->trigger_events(array('row', 'row_array'));
                $row = $this->response->row_array();
                $this->response->free_result();
                return $row;
        }

        public function result()
        {
                $this->trigger_events('result');
                $result = $this->response->result();
                $this->response->free_result();
                return $result;
        }

        public function limit($limit)
        {
                $this->trigger_events('limit');
                $this->_ion_limit = $limit;
                return $this;
        }

        public function offset($offset)
        {
                $this->trigger_events('offset');
                $this->_ion_offset = $offset;
                return $this;
        }

        public function where($where, $value = NULL)
        {
                $this->trigger_events('where');
                if (!is_array($where))
                {
                        $where = array($where => $value);
                }
                array_push($this->_ion_where, $where);
                return $this;
        }

        public function like($like, $value = NULL)
        {
                $this->trigger_events('like');
                if (!is_array($like))
                {
                        $like = array($like => $value);
                }
                array_push($this->_ion_like, $like);
                return $this;
        }

        public function select($select)
        {
                $this->trigger_events('select');
                $this->_ion_select[] = $select;
                return $this;
        }

        public function order_by($by, $order = 'desc')
        {
                $this->trigger_events('order_by');
                $this->_ion_order_by = $by;
                $this->_ion_order = $order;
                return $this;
        }

        public function result_array()
        {
                $this->trigger_events(array('result', 'result_array'));
                $result = $this->response->result_array();
                $this->response->free_result();
                return $result;
        }

        public function num_rows()
        {
                $this->trigger_events(array('num_rows'));
                $result = $this->response->num_rows();
                $this->response->free_result();
                return $result;
        }

        /**
         * login_remembed_user
         *
         * @return bool
         * @author Ben Edmunds
         * */
        public function login_remembered_user()
        {
                //check for valid data
                if (!get_cookie('identity') || !get_cookie('remember_code') || !$this->identity_check(get_cookie('identity')))
                {
                        return FALSE;
                }
                //get the user
                if (isset($this->ion_auth->_extra_where) && !empty($this->ion_auth->_extra_where))
                {
                        $this->db->where($this->ion_auth->_extra_where);
                }
                $query = $this->db->select($this->identity_column . ', id, group_id')
                             ->where($this->identity_column, get_cookie('identity'))
                             ->where('remember_code', get_cookie('remember_code'))
                             ->limit(1)
                             ->get($this->tables['users']);
                //if the user was found, sign them in
                if ($query->num_rows() == 1)
                {
                        $user = $query->row();
                        $this->update_last_login($user->id);
                        $group_row = $this->db->select('name')->where('id', $user->group_id)->get($this->tables['groups'])->row();
                        $session_data = array(
                            $this->identity_column => $user->{$this->identity_column},
                            'id' => $user->id, //kept for backwards compatibility
                            'user_id' => $user->id, //everyone likes to overwrite id so we'll use user_id
                            'group_id' => $user->group_id,
                            'group' => $group_row->name
                        );
                        $this->session->set_userdata($session_data);
                        //extend the users cookies if the option is enabled
                        if ($this->config->item('user_extend_on_login', 'ion_auth'))
                        {
                                $this->remember_user($user->id);
                        }
                        return TRUE;
                }
                return FALSE;
        }

        /**
         * remember_user
         *
         * @return bool
         * @author Ben Edmunds
         * */
        private function remember_user($id)
        {
                if (!$id)
                {
                        return FALSE;
                }
                $user = $this->get_user($id)->row();
                $salt = sha1($user->password);
                $this->db->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));
                if ($this->db->affected_rows() > -1)
                {
                        set_cookie(array(
                            'name' => 'identity',
                            'value' => $user->{$this->identity_column},
                            'expire' => $this->config->item('user_expire', 'ion_auth'),
                        ));
                        set_cookie(array(
                            'name' => 'remember_code',
                            'value' => $salt,
                            'expire' => $this->config->item('user_expire', 'ion_auth'),
                        ));
                        return TRUE;
                }
                return FALSE;
        }

        //List All Subjects **Select all classes**
        function list_subjects()
        {
                $result = $this->db->select('subjects.*')
                             ->get('subjects')
                             ->result();
                $arr = array();
                foreach ($result as $res)
                {
                        if (!empty($res->short_name))
                        {
                                $arr[$res->id] = $res->short_name;
                        }
                        else
                        {
                                $arr[$res->id] = $res->title;
                        }
                }
                return $arr;
        }

        //Get students
        public function get_students()
        {
                $this->select_all_key('admission');
                $results = $this->db->where($this->dx('status') . '= 1', NULL, FALSE)->get('admission')->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->first_name . ' ' . $res->last_name;
                }
                return $arr;
        }

        //administration
        public function count_administration()
        {
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('group_id') . '= 7', NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                if (!count($results))
                {
                        return 0;
                }
                $rr = array();
                foreach ($results as $r)
                {
                        $rr[] = $r->user_id;
                }
                return $this->db->where_in('id', $rr)->count_all_results('users');
        }

        public function get_teachers()
        {
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('users_groups.group_id') . '= 3', NULL, FALSE)
                             ->where($this->dx('users.active') . '= 1', NULL, FALSE)
                             ->join('users', 'users.id=' . $this->dx('user_id'))
                             ->get('users_groups')
                             ->result();
                $arr = array();
                foreach ($results as $res)
                {
                        if ($this->user_exists($res->user_id))
                        {
                                $user = $this->ion_auth->get_user($res->user_id);
                                if ($user)
                                {
                                        $arr[$res->user_id] = $user->first_name . ' ' . $user->last_name;
                                }
                        }
                }
                return $arr;
        }

        function user_exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('users') > 0;
        }

        public function get_teacher()
        {
                $tid = $this->config->item('teachers');
                $this->select_all_key('users_groups');
                $results = $this->db->where($this->dx('users_groups.group_id') . '= ' . $tid, NULL, FALSE)
                             ->where($this->dx('users.active') . '= 1', NULL, FALSE)
                             ->join('users', 'users.id=' . $this->dx('user_id'))
                             ->get('users_groups')
                             ->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $arr[] = $res->user_id;
                }
                $this->select_all_key('users');
                return $this->db->where_in('users.id', $arr)->get('users')->result();
        }

        //Get admins
        public function get_admins()
        {
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('group_id') . '= 1', NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                $arr = array();
                if (!empty($results))
                {
                        foreach ($results as $res)
                        {
                                $user = $this->ion_auth->get_user($res->user_id);
                                $group = $this->groups_m->find(1);
                                $arr[$res->user_id] = $user->first_name . ' ' . $user->last_name . ' - (' . $group->name . ')';
                        }
                        return $arr;
                }
                return array();
        }

        //Members
        public function get_members()
        {
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('group_id') . '!= 8', NULL, FALSE)
                             ->where($this->dx('group_id') . '!= 6', NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                $arr2 = array();
                foreach ($results as $res)
                {
                        $user = $this->ion_auth->get_user($res->user_id);
                        $group = $this->groups_m->find($res->group_id);
                        $arr2[$res->user_id] = $user->first_name . ' ' . $user->last_name . ' - (' . $group->name . ')';
                }
                return $arr2;
        }

        public function get_teachers_and_title()
        {
                //Teachers		
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('users_groups.group_id') . '= 3', NULL, FALSE)
                             ->where($this->dx('users.active') . '= 1', NULL, FALSE)
                             ->join('users', 'users.id=' . $this->dx('user_id'))
                             ->get('users_groups')
                             ->result();
                $arr3 = array();
                foreach ($results as $res)
                {
                        $user = $this->ion_auth->get_user($res->user_id);
                        $group = $this->groups_m->find(3);
                        $arr3[$res->user_id] = $user->first_name . ' ' . $user->last_name . ' - (' . $group->name . ')';
                }
                return $arr3;
        }

        //Head Teachers	
        public function get_headteachers()
        {
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('group_id') . '= 4', NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                $arr4 = array();
                foreach ($results as $res)
                {
                        $user = $this->ion_auth->get_user($res->user_id);
                        $group = $this->groups_m->find(4);
                        $arr4[$res->user_id] = $user->first_name . ' ' . $user->last_name . ' - (' . $group->name . ')';
                }
                return $arr4;
        }

        //Management Board
        public function get_managers()
        {
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('group_id') . '= 7', NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                $arr5 = array();
                foreach ($results as $res)
                {
                        $user = $this->ion_auth->get_user($res->user_id);
                        $group = $this->groups_m->find(7);
                        $arr5[$res->user_id] = $user->first_name . ' ' . $user->last_name . ' - (' . $group->name . ')';
                }
                return $arr5;
        }

        public function get_usr($id)
        {
                $this->select_all_key('users');
                return $this->db->where('id', $id)->where($this->dx('users.active') . '= 1', NULL, FALSE)->get('users')->row();
        }

        public function list_staff()
        {
                $std = $this->config->item('students');
                $pern = $this->config->item('parents');
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('group_id') . '!= ' . $std, NULL, FALSE)
                             ->where($this->dx('group_id') . '!= ' . $pern, NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                $arr5 = array();
                foreach ($results as $res)
                {
                        $user = $this->get_usr($res->user_id);
                        if ($user)
                        {
                                $group = $this->groups_m->find($res->group_id);
                                $arr5[$res->user_id] = $user->first_name . ' ' . $user->last_name . ' - (' . $group->name . ')';
                        }
                }
                return $arr5;
        }

        //List All Classes **Select all classes**
        function get_stream()
        {
                $stream = $this->db->select('class_stream.*')
                             ->get('class_stream')
                             ->result();
                $st = array();
                foreach ($stream as $r)
                {
                        $st[$r->id] = $r->name;
                }
                return $st;
        }

        public function list_classes()
        {
                $list = $this->db->select('id, name')
                             //->where('status', 1)
                             ->order_by('id')
                             ->get('class_groups')
                             ->result();
                $cls = array();
                foreach ($list as $l)
                {
                        $cls[$l->id] = $l->name;
                }
                return $cls;
        }

        public function list_students()
        {
                $this->select_all_key('admission');
                $this->db->where($this->dx('status') . '= 1', NULL, FALSE);
                $this->db->_protect_identifiers = FALSE;
                $this->db->order_by($this->dx('created_on'), 'DESC', FALSE);
                $this->db->_protect_identifiers = TRUE;
                return $this->db->limit(6)->get('admission')->result();
        }

        public function count_students()
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('status') . '=1', NULL, FALSE)->count_all_results('admission');
        }

        public function count_teachers()
        {
                $this->select_all_key('users_groups');
                $results = $this->db //->select('users_groups.*')
                             ->where($this->dx('group_id') . '= 3', NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                if (!count($results))
                {
                        return 0;
                }
                $rr = array();
                foreach ($results as $r)
                {
                        $rr[] = $r->user_id;
                }
                return $this->db->where_in('id', $rr)->where($this->dx('active') . '= 1', NULL, FALSE)->count_all_results('users');
        }

        public function count_parents()
        {
                $this->select_all_key('users_groups');
                $results = $this->db
                             ->where($this->dx('group_id') . '= 6', NULL, FALSE)
                             ->get('users_groups')
                             ->result();
                if (!count($results))
                {
                        return 0;
                }
                $rr = array();
                foreach ($results as $r)
                {
                        $rr[] = $r->user_id;
                }
                return $this->db->where_in('id', $rr)->count_all_results('users');
        }

        //Count All Class Rooms
        function count_class_rooms()
        {
                return $this->db->count_all_results('class_rooms');
        }

        //Count All Hostels
        function count_hostels()
        {
                return $this->db->count_all_results('hostels');
        }

        //Count All Hostel rooms
        function count_hostel_rooms()
        {
                return $this->db->count_all_results('hostel_rooms');
        }

        //Count All Subjects
        function count_subjects()
        {
                return $this->db->count_all_results('subjects');
        }

        //Count All Classes
        function count_classes()
        {
                return $this->db->count_all_results('classes');
        }

        public function get_user_list()
        {
                $this->select_all_key('users');
                $results = $this->db->get('users')->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->first_name . ' ' . $res->last_name;
                }
                return $arr;
        }

        public function get_user_details()
        {
                $this->select_all_key('users');
                $results = $this->db->get('users')->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->first_name . ' ' . $res->last_name . ' (' . $res->email . ')';
                }
                return $arr;
        }

        public function get_parent_details()
        {
                $this->select_all_key('parents');
                $results = $this->db->get('parents')->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->first_name . ' ' . $res->last_name . ' (' . $res->email . ')';
                }
                return $arr;
        }

        //Get Student House
        public function list_house()
        {
                $results = $this->db
                             ->get('house')
                             ->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $arr[$res->id] = $res->name;
                }
                return $arr;
        }

        public function classes_and_stream()
        {
                $u = $this->ion_auth->get_user()->id;
                $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
                $the_class = 0;
                if (!empty($cls->id))
                {
                        $the_class = $cls->id;
                }
                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $result = $this->db->select('classes.*')
                                     ->where('status', 1)
                                     //->where('id', $the_class)
                                     ->get('classes')
                                     ->result();
                }
                else
                {
                        $result = $this->db->select('classes.*')
                                     ->where('status', 1)
                                     ->get('classes')
                                     ->result();
                }
                $arr = array();
                foreach ($result as $res)
                {
                        $stream = $this->get_stream();
                        $class = $this->list_classes();
                        $str = isset($stream[$res->stream]) ? $stream[$res->stream] : ' ';
                        $cls = isset($class[$res->class]) ? $class[$res->class] : ' ';
                        $arr[$res->id] = $cls . ' ' . $str;
                }
                return $arr;
        }

        public function fetch_classes()
        {
                $this->db->order_by('class', 'ASC');
                $result = $this->db->where('status', 1)->get('classes')->result();
                $arr = array();
                foreach ($result as $res)
                {
                        $stream = $this->get_stream();
                        $class = $this->list_classes();
                        $strm = strtolower($stream[$res->stream]);
                        $str = $res->class < 4 ? '' : ' ';
                        $scl = isset($class[$res->class]) ? class_to_short($class[$res->class]) : ' - ';
                        if ($strm == 'none')
                        {
                                $arr[$res->id] = $str . $scl;
                        }
                        else
                        {
                                $arr[$res->id] = $str . $scl . ' ' . $stream[$res->stream];
                        }
                }
                return $arr;
        }

        //Get student full details including class and stream	
        public function students_full_details()
        {
                $this->select_all_key('admission');
                $results = $this->db->where($this->dx('status') . '=1', NULL, FALSE)
                                          ->order_by($this->dx('first_name'), 'ASC', FALSE)
                                          ->order_by($this->dx('last_name'), 'ASC', FALSE)
                                          ->get('admission')->result();
                $arr = array();
                foreach ($results as $res)
                {
                        $llll = $this->portal_m->fetch_class($res->class);
                        if (empty($llll))
                        {
                                continue;
                        }
                        $class = $this->list_classes();
                        $stream = $this->get_stream();
                        $ccc = isset($class[$llll->class]) ? $class[$llll->class] : ' - ';
                        $stt = isset($stream[$llll->stream]) ? $stream[$llll->stream] : '';
                        if ($llll->stream == 'None')
                        {
                                $stt = '';
                        }
                        $adm_no= $res->admission_number;
                        $name= empty($res->middle_name)? $res->first_name. ' ' . $res->last_name : $res->first_name . ' ' . $res->middle_name. ' ' . $res->last_name ;
                        $arr[$res->id] =  $adm_no.'-'. $name . ' (' . $ccc . ' ' . $stt . ')';

                }
                return $arr;
        }

        //Get all parents
        function get_parent()
        {
                $this->select_all_key('parents');
                return $results = $this->db->get('parents')
                             ->result();
        }

        //Get single parents
        function get_single_parent($id)
        {
                $this->select_all_key('parents');
                return $results = $this->db
                             ->where('parents.id', $id)
                             ->get('parents')
                             ->row();
        }

        //Get single parents
        function parent_profile($id)
        {
                $this->select_all_key('parents');
                return $this->db
                                          ->where($this->dx('parents.user_id') . '=' . $id, NULL, FALSE)
                                          ->get('parents')
                                          ->row();
        }

        public function list_student($id = false)
        {
                $this->select_all_key('admission');
                $this->db->where('id', $id);
                return $this->db->get('admission')->row();
        }

        //Use Subject ID to list its details
        public function subject_details($id = false)
        {
                $this->db->where('subjects.id', $id);
                return $this->db->get('subjects')->row();
        }

        //Count All Subjects
        function count_addresses()
        {
                return $this->db->count_all_results('address_book');
        }

        //Count Students 
        function count_students_per_class($id, $stream)
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('status') . '=1', NULL, FALSE)->where($this->dx('class') . '=' . $id, NULL, FALSE)->where($this->dx('stream') . '=' . $stream, NULL, FALSE)->count_all_results('admission');
        }

        //Students per Class only
        function students_per_class($id)
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('status') . '=1', NULL, FALSE)->where($this->dx('class') . '=' . $id, NULL, FALSE)->count_all_results('admission');
        }

        //Count SMS 
        function count_sms()
        {
                return $this->db->where('status', 'sent')->count_all_results('sms');
        }

        //Emails
        function count_emails()
        {
                return $this->db->where('status', 'sent')->count_all_results('emails');
        }

        //Files
        function count_files()
        {
                return $this->db->count_all_results('files');
        }

//Folders
        function count_folders()
        {
                return $this->db->count_all_results('folders');
        }

        //Hostel Beds
        function count_hostel_beds()
        {
                return $this->db->count_all_results('hostel_beds');
        }

//Hostel users
        function count_users()
        {
                return $this->db->count_all_results('users');
        }

//Hostel user groups
        function count_groups()
        {
                return $this->db->count_all_results('groups');
        }

//Hostel user groups
        function count_blog()
        {
                return $this->db->count_all_results('blog');
        }

//Hostel user groups
        function count_forum()
        {
                return $this->db->count_all_results('forum');
        }

        //Hostel user groups
        function count_events()
        {
                return $this->db->count_all_results('school_events');
        }

        //Hostel user groups
        function settings()
        {
                return $this->db->select('settings.*')->get('settings')->row();
        }

        //Passport
        function passport($id)
        {
                return $this->db->where(array('id' => $id))->get('passports')->row();
        }

        //count books
        function count_books()
        {
                return $this->db->select('sum(quantity) as total')->get('books_stock')->row();
        }

//borrowed books
        function count_borrowed_books()
        {
                return $this->db->where('status', 1)->count_all_results('borrow_book');
        }

//borrowed books
        function count_books_category()
        {
                return $this->db->count_all_results('books_category');
        }

        function teachers_class_details()
        {
                //get class ID that belongs to the logged in teacher
                $u = $this->ion_auth->get_user()->id;
                $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
                return $cls;
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

        function remarks($gs, $marks)
        {
                $fmarks = (float) ceil($marks);
				 $fmarks = floor($fmarks);

                                 if (is_nan($fmarks))
                                 {
                                     $fmarks=0;    
                                 }
                $this->db->where('grading_id', $gs);

                if ($fmarks == 0)
                {
                        $found = $this->db->where('minimum_marks =', 0)->get('grading_records')->result();
                }
                else
                {
                        $found = $this->db->where('maximum_marks >=', $fmarks)->order_by('maximum_marks', 'ASC')->get('grading_records')->result();

                        if (empty($found))
                        {
                                $found = $this->db->where('minimum_marks <=', $fmarks)->order_by('minimum_marks', 'DESC')->get('grading_records')->result();
                        }
                }


                $row = array();
                foreach ($found as $f)
                {
                        if ($this->between($fmarks, $f->minimum_marks, $f->maximum_marks))//|| $fmarks == $f->minimum_marks || $fmarks == $f->maximum_marks)
                        {
                                $row = $f;
                                break;
                        }
                }

                return $row;
        }

        function remarks__($gs, $marks)
        {
                $fmarks = (float) $marks;
                if ($fmarks == 80)
                {
                        $this->db->where('grading_id', $gs);
                }
                else
                {
                        $this->db->where('grading_id', $gs);
                }

                if ($fmarks == 0)
                {
                        $found = $this->db->where('minimum_marks =', 0)->get('grading_records')->result();
                }
                else
                {
                        $found = $this->db->where('maximum_marks >=', $fmarks)->order_by('maximum_marks', 'ASC')->get('grading_records')->result();

                        if (empty($found))
                        {
                                $found = $this->db->where('minimum_marks <', $fmarks)->order_by('minimum_marks', 'DESC')->get('grading_records')->result();
                        }
                }

                $row = array();

                foreach ($found as $f)
                {
                        if ($this->between($fmarks, $f->minimum_marks, $f->maximum_marks))
                        {
                                $row = $f;
                                break;
                        }
                }

                return $row;
        }

        /**
         * Check if no. between min & max values
         * 
         * @param float $val
         * @param float $min
         * @param float $max
         * @return boolean
         */
        function between($val, $min, $max)
        {
                return ($val >= $min && $val <= $max);
        }

        function create_log($data)
        {
                $this->db->insert('audit_logs', $data);
                return $this->db->insert_id();
        }

        function user_by_phone($phone)
        {
                $this->select_all_key('users');
                return $this->db->where($this->dx('phone') . '=' . $phone, NULL, FALSE)->get('users')->row();
        }

        /**
         * get_user
         *
         * @return object
         * @author Phil Sturgeon
         * */
        function similar($input_type, $item_type)
        {

                $this->select_all_key('users');
                $this->db->limit(1);
                $res = $this->db->where($this->dx($input_type) . ' = ' . $this->db->escape($item_type), NULL, FALSE)->get('users')->row();
                return $res;
        }

        function ref_no($length)
        {
                $chars = "1234EFGH56789ABCDJKLMNPQRSTUVW";
                $thepassword = '';
                for ($i = 0; $i < $length; $i++)
                {
                        $thepassword .= $chars[rand() % (strlen($chars) - 1)];
                }
                return $thepassword;
        }

        /**
         * Send SMS
         * 
         * @param string $phone
         * @param string $message
         * @return boolean
         */
        function send_sms($phone, $message)
        {
                $this->load->library('Req');
                $this->load->library('Fone');

                if (empty($this->config->item('sms_pass')) || empty($this->config->item('sms_id')))
                {
                        $st = 'SMS Module is not configured';
                        $this->session->set_flashdata('error', array('type' => 'error', 'text' => $st));
                        return 'SMS Module is not configured';
                }

                $userid = $this->config->item('sms_id');
                $token = md5($this->config->item('sms_pass'));
                $from = empty($this->config->item('sender')) ? 'KEYPAD' : $this->config->item('sender');

                if (empty($phone))
                {
                        return FALSE;
                }

                if (strpos($phone, ',') !== false)
                {
                        $data = explode(',', $phone);
                        $phone = $data[0];
                }

                $util = \libphonenumber\PhoneNumberUtil::getInstance();
                $no = $util->parse($phone, 'KE', null, true);
                $req = FALSE;

                $is_valid = $util->isValidNumber($no);
                if ($is_valid == 1)
                {
                        $code = $no->getcountryCode();
                        $nat = $no->getNationalNumber();
                        $phone = $code . $nat;

                        $url = 'http://197.248.4.47/smsapi/submit.php';
                        $stamp = date('YmdHis');
                        $json = '{
                                "AuthDetails": [{
                                        "UserID": "' . $userid . '",
                                        "Token": "' . $token . '",
                                        "Timestamp": "' . $stamp . '"
                                }],
                                "MessageType": ["2"],
                                "BatchType": ["0"],
                                "SourceAddr": ["' . $from . '"],
                                "MessagePayload": [
                                {
                                          "Text":"' . $message . '"  
                                }],
                                "DestinationAddr": [
                                {
                                        "MSISDN": "' . $phone . '",
                                        "LinkID": ""
                                }]
                           }';

                        /* if (!$sock = @fsockopen('www.google.com', 80))
                          {
                          return FALSE;
                          } */

                        $parts = array(
                            'source' => $from,
                            'dest' => $phone,
                            'relay' => $message,
                            'created_on' => time(),
                            'created_by' => 1,
                        );
                        $this->log_text($parts);

                        $headers = array('Content-Type' => 'application/json');
                        try
                        {
                                $req = $this->req->post($url, $headers, $json);
                        }
                        catch (Exception $exc)
                        {
                                $req = $exc->getMessage();
                        }
                }

                return $req;
        }

        /**
         * Log Text to DB
         * 
         * @param array $data
         * @return int
         */
        function log_text($data)
        {
                return $this->insert_key_data('text_log', $data);
        }
		
		
				
	function count_attendance($student,$state,$month,$year)
        {
                return $this->db
				->select('class_attendance_list.id,class_attendance_list.attendance_id,class_attendance_list.student,class_attendance_list.status,class_attendance_list.remarks,class_attendance.id,class_attendance.attendance_date,class_attendance.title')
			 
			    ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
				->where(array('student' => $student,'status'=>$state))
				->where('MONTH(FROM_UNIXTIME(attendance_date))', $month)
                ->where('YEAR(FROM_UNIXTIME(attendance_date))', $year)
			
				->count_all_results('class_attendance_list');
        }

		
	function get_attendance($student,$status,$day,$month,$year)
        {
                return $this->db
				->select('class_attendance_list.id,class_attendance_list.attendance_id,class_attendance_list.student,class_attendance_list.status,class_attendance_list.remarks,class_attendance.id,class_attendance.attendance_date,class_attendance.title')
			 
			    ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
				->where(array('student' => $student,'status'=>$status))
				->where('DAY(FROM_UNIXTIME(attendance_date))', $day)
				->where('MONTH(FROM_UNIXTIME(attendance_date))', $month)
                ->where('YEAR(FROM_UNIXTIME(attendance_date))', $year)
				->get('class_attendance_list')
				->row();
        }

        //updates the forgotten_password_code generated
        public function updateforgotten_password_code($id,$code){
                $data=array(
                        'forgotten_password_code' => $code
                );

                return $this->update_key_data($id, 'users', $data);
        }
}
