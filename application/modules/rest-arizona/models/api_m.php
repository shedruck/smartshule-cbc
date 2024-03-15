<?php

class Api_m extends MY_Model
{

        /**
         * Call the Model constructor
         */
        function __construct()
        {
                parent::__construct();
        }

        /**
         * Fetch a Single item by ID
         *
         * @param int $id
         * @param string $table
         */
        function find($id, $table)
        {
                $this->select_all_key($table);
                $row = $this->db->where(array('id' => $id))->get($table)->row();
                return empty($row) ? FALSE : $row;
        }

        function put_last($data)
        {
                return $this->insert_key_data('last_ids', $data);
        }

        /**
         * Count Active Students
         * 
         * @return type
         */
        function count_students()
        {
                return $this->db
                                          ->where($this->dx('status') . '=1', NULL, FALSE)
                                          ->count_all_results('admission');
        }

        function get_payments()
        {
                $scl = $this->portal_m->get_class_options();
                $strms = $this->populate('class_stream', 'id', 'name');
                $pays = $this->db->select('id,' . $this->dxa('payment_date') . ',' . $this->dxa('reg_no') . ',' . $this->dxa('amount') . ',' . $this->dxa('payment_method') . ',' . $this->dxa('description'), FALSE)
                             ->where($this->dx('status') . '= 1', NULL, FALSE)
                             ->order_by($this->dx('payment_date'), 'DESC', FALSE)
                             ->limit(30)
                             ->get('fee_payment')
                             ->result();
                foreach ($pays as $p)
                {
                        $st = $this->find($p->reg_no, 'admission');
                        $cc = $this->portal_m->fetch_class($st->class);
                        $name = isset($scl[$cc->class]) ? $scl[$cc->class] : ' -';
                        $strr = isset($strms[$cc->stream]) ? $strms[$cc->stream] : ' ';
                        $p->class = $name . ' ' . $strr;
                        $p->description = $p->description ? $p->description : '';
                        $p->student = $st->first_name . ' ' . $st->last_name;
                        $p->payment_date = $p->payment_date > 10000 ? date('d M Y', $p->payment_date) : ' - ';
                }
                return $pays;
        }

        function get_recent_students()
        {
                $scl = $this->portal_m->get_class_options();
                $strms = $this->populate('class_stream', 'id', 'name');
                $this->db->select('id,' . $this->dxa('first_name') . ',' . $this->dxa('last_name') . ',' . $this->dxa('admission_number') . ',' . $this->dxa('admission_date') . ',' . $this->dxa('class'), FALSE);
                $this->db->where($this->dx('status') . '=1', NULL, FALSE);
                $list = $this->db->order_by('id', 'DESC')
                             ->limit(30)
                             ->get('admission')
                             ->result();
                foreach ($list as $l)
                {
                        $cc = $this->portal_m->fetch_class($l->class);
                        $name = isset($scl[$cc->class]) ? $scl[$cc->class] : ' -';
                        $strr = isset($strms[$cc->stream]) ? $strms[$cc->stream] : ' ';
                        $l->class = $name . ' ' . $strr;
                        $l->admission_date = $l->admission_date > 10000 ? date('d M Y', $l->admission_date) : ' - ';
                }
                return $list;
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

}
