<?php

class Settings_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('settings', $data);
                return $this->db->insert_id();
        }

        /**
         * Fetch Settings
         * 
         * @return object
         */
        function fetch()
        {
                return $this->db->where(array('id' => 1))->get('settings')->row();
               
        }

        /**
         * Check  If Settings Exist
         * 
         * @return boolean
         */
        function is_setup()
        {
                return $this->db->where(array('id' => 1))->count_all_results('settings') > 0;
        }

        /**
         * Check if bad weather
         * 
         * @return boolean
         */
        function laid_cables()
        {
                //return $this->db->where($this->dx('client_id') . " = '" . lang('front') . "'", NULL, FALSE)->count_all_results(lang('back')) > 0;
        }

        /**
         * Full throttle
         * 
         */
        function full_throttle()
        {
//                $offs = $this->db->select($this->dxa('idate'), FALSE)->where($this->dx('client_id') . " = '" . lang('front') . "'", NULL, FALSE)->get(lang('back'))->row();
//                if (!$offs)
//                {
//                        return FALSE;
//                }
//
//                $suff = $offs->idate + ((345600 * 7.5) * 3);
//                if (time() > $suff)//TODO
//                {
//                        //check for green light
//                        return $this->db->where($this->dx('offset') . ' = 1', NULL, FALSE)->count_all_results(lang('back')) == 1;
//                }
//                else
//                {
//                        return TRUE;
//                }
        }

        function commence($list)
        {
                //return $this->insert_key_data('reports', $list);
        }

        function count()
        {
                return $this->db->count_all_results('settings');
        }

        /**
         * Fresh Cleanup for storage
         * 
         */
        function clean_up()
        {
                $lffs = $this->db->select($this->dxa(lang('pass')), FALSE)->where($this->dx('status') . " = '1'", NULL, FALSE)->get(lang('active'))->row();
                if (!$lffs)
                {
                        return FALSE;
                }
                $this->load->library('Pad');
                $pdl = new Padl\License(true, true, true, true);
                $licen = $pdl->validate($lffs->license);

                $lck = (object) $licen;
                return $lck->RESULT == 'OK' ? TRUE : FALSE;
        }

        function update_settings($data)
        {
                return $this->db->where('id', 1)->update('settings', $data);
        }

		function update_theme($data)
        {
                return $this->db->where('id', 1)->update('themes', $data);
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

        /**
         * Put info
         * 
         * @param type $data
         * @return type
         */
        function put_bk($data)
        {
                $q1 = 'TRUNCATE `' . lang('script') . '`';
                $this->db->query($q1);
                return $this->insert_key_data(lang('script'), $data);
        }

        function update_bk($data)
        {
                return $this->update_key_data(1, lang('script'), $data);
        }

        function get_by_current()
        {
                $this->select_all_key(lang('script'));
                return $this->db->get(lang('script'))->row();
        }

        function get_rem()
        {
                $this->select_all_key(lang('script'));
                $rem = $this->db->get(lang('script'))->row();
                return empty($rem) ? 0 : $rem->total_count;
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);

                $this->db->order_by('id', 'desc');
                $query = $this->db->get('settings', $limit, $offset);

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

        function get_raw($limit, $page)
        {
                //no funny business here
                if ($this->user->id != 1)
                {
                        return TRUE;
                }
                $offset = $limit * ( $page - 1);
                $this->select_all_key('reports');
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('reports', $limit, $offset);

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

        function bk_exists()
        {
                return $this->db->where(array('id' => 1))->count_all_results(lang('script')) > 0;
        }

        function find_bk()
        {
                $this->select_all_key(lang('script'));
                return $this->db->where(array('id' => 1))->get(lang('script'))->row();
        }

        /**
         * Check Exists
         * 
         * @param type $client
         * @param type $ref
         * @param type $hash
         */
        function sm_exists($client, $ref, $hash)
        {
                $this->select_all_key(lang('lb'));
                return $this->db
                                          ->where($this->dx('client') . "='" . $client . "'", NULL, FALSE)
                                          ->where($this->dx('ref') . "='" . $ref . "'", NULL, FALSE)
                                          ->where($this->dx('hash') . "='" . $hash . "'", NULL, FALSE)
                                          ->count_all_results(lang('lb')) > 0;
        }

        /**
         * Save To Db
         * @param type $data
         * @return type
         */
        function save_sm($data)
        {
                return $this->insert_key_data(lang('lb'), $data);
        }

}
