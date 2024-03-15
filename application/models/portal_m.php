<?php

class Portal_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function fetch_user_ids($table)
        {

              
                if ($table == "parents") {
                        return $this->db->select($this->dxa('user_id') . ', ' . $this->dxa('first_name') . ', ' . $this->dxa('phone') . ', ' . $this->dxa('mother_phone'), FALSE)
                                ->where($this->dx('status') . ' = 1', NULL, FALSE)
                                ->get($table)
                                ->result();
                } else {
                        return $this->db->select($this->dxa('user_id') . ', ' . $this->dxa('first_name') . ', ' . $this->dxa('phone'), FALSE)
                                ->where($this->dx('status') . ' = 1', NULL, FALSE)
                                ->get($table)
                                ->result();
                }
        }


        function count_pop($class, $scholar, $gender)
        {
                $r1 = array();
                $r2 = array();

                if ($scholar == "Day Scholar") {

                        $r1 =  $this->db
                                ->where($this->dx('class') . ' =' . $class, NULL, FALSE)
                                ->where($this->dx('status') . ' = 1', NULL, FALSE)
                                ->where($this->dx('gender') . ' = ' . $gender, NULL, FALSE)
                                ->where($this->dx('boarding_day') . ' = "Day"', NULL, FALSE)
                                ->count_all_results('admission');

                        $r2 = $this->db
                                ->where($this->dx('class') . ' =' . $class, NULL, FALSE)
                                ->where($this->dx('status') . ' = 1', NULL, FALSE)
                                ->where($this->dx('boarding_day') . ' = "' . $scholar . '"', NULL, FALSE)
                                ->where($this->dx('gender') . ' = ' . $gender, NULL, FALSE)
                                ->count_all_results('admission');


                        return $r1 + $r2;
                } else {

                        return $this->db
                                ->where($this->dx('class') . ' =' . $class, NULL, FALSE)
                                ->where($this->dx('status') . ' = 1', NULL, FALSE)
                                ->where($this->dx('boarding_day') . ' = "' . $scholar . '"', NULL, FALSE)
                                ->where($this->dx('gender') . ' = ' . $gender, NULL, FALSE)
                                ->count_all_results('admission');
                }
        }


        function banks()
        {
                return $this->db->get('bank_accounts')->result();
        }


        function get_groups($id)
        {
                return $this->db->select($this->dx('users_groups.group_id') . ' as id, groups.name, groups.description', FALSE)
                        ->where($this->dx('users_groups.user_id') . ' =' . $id, NULL, FALSE)
                        ->join('groups', $this->dx('users_groups.group_id') . ' = groups.id')
                        ->get('users_groups')
                        ->result();
        }

        function upi_checker($id)
        {
                $this->select_all_key('admission');
                $query = $this->db->where($this->dx('upi_number') . '="' . $id . '"', NULL, FALSE)->get('admission')->row();
                return $query;
        }

        function slug($string)
        {
                $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
                return $slug;
        }

        function check_invoiced($term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->count_all_results('invoices') > 0;
        }

        function get_my_class($id)
        {
                return $this->db->where(array('id' => $id))->get('classes')->row();
        }

        function get_period($id, $day)
        {
                return $this->db->where(array('class_id' => $id, 'day_of_the_week' => $day))->order_by('start_time', 'desc')->get('class_timetable_list')->result();
        }


        function get_sub844($id)
        {

                $dropdowns =   $this->db->group_by('subject_id')->where(array('class_id' => $id))->get('subjects_classes')->result();

                $subs = $this->populate('subjects', 'id', 'name');

                foreach ($dropdowns as $dropdown) {
                        $options[$dropdown->subject_id] = strtoupper($subs[$dropdown->subject_id]);
                }
                return $options;
        }

        function get_cls($class)
        {

                return $this->db->where('class', $class)->where('status', 1)->get('classes')->result();
        }

        function get_cbc_subjects($id)
        {
                $dropdowns = $this->db->where(array('class_id' => $id))->get('cbc')->result();

                $subs = $this->ion_auth->populate('cbc_subjects', 'id', 'name');

                foreach ($dropdowns as $dropdown) {
                        $options[$dropdown->subject_id] = strtoupper($subs[$dropdown->subject_id]);
                }
                return $options;
        }

        function class_teacher($id)
        {
                return $this->db->where(array('class_teacher' => $id))->count_all_results('classes') > 0;
        }


        function get_joint_remarks($term, $year, $student, $exams)
        {
                return $this->db->where('term', $term)
                        ->where('year', $year)
                        ->where('student', $student)
                        ->where('exams', $exams)
                        ->get('remarks_joint')
                        ->row();
        }

        /**
         * Determine if Student is Invoiced for current term
         * 
         * @param type $student
         * @param type $term
         * @return type
         */
        function is_invoiced($student, $term, $year = 0)
        {
                if (!$year) {
                        $year = date('Y');
                }
                return $this->db->where('term', $term)->where('year', $year)->where('student_id', $student)->count_all_results('invoices') > 0;
        }

        function is_invoiced__($student, $term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->where('student_id', $student)->count_all_results('invoices') > 0;
        }

        function get_invoice($student, $term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->where('student_id', $student)->count_all_results('invoices');
        }

        /**
         * Best way to determine if term is in the future or past
         * 
         * @param int $term
         * @return boolean
         */
        function has_invoices($term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->count_all_results('invoices') > 0;
        }

        /**
         * Get Student Invoices for current Term
         * 
         * @param type $student
         * @param type $term
         * @return type
         */
        function get_my_invoices($student, $term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->where('student_id', $student)->get('invoices')->result();
        }

        function get_subject_teacher($class, $subject)
        {
                return $this->db->select('teacher')->order_by('id', 'desc')->where(array('class' => $class, 'subject' => $subject))->get('subjects_assign')->row();
        }

        function get_row($term)
        {
                return $this->db->where('term', $term)->where('year', date('Y'))->get('invoices')->row();
        }

        function find($id)
        {
                $this->select_all_key('admission');
                return $this->db->where(array('id' => $id))->get('admission')->row();
        }

        function by_upi($id)
        {
                $this->select_all_key('admission');
                return $this->db->where($this->dx('upi_number') . '="' . $id . '"', NULL, FALSE)->get('admission')->row();
                //return $this->db->where($this->dx('upi_number').'='. $id,NULL,FALSE)->get('admission')->row();
        }

        /**
         * Fetch All Active Students in the school
         * as per admissions Table
         * 
         * @param type $sus
         * @return type
         */
        function get_all_students($sus = TRUE)
        {
                $this->db->select('id');
                if ($sus) {
                        $this->db->where($this->dx('status') . '=1', NULL, FALSE);
                }
                $list = $this->db->get('admission')->result();
                $students = array();
                foreach ($list as $l) {
                        $students[] = $l->id;
                }
                return $students;
        }

        function history_exists($student, $class, $stream)
        {
                return $this->db->where($this->dx('student') . " = '" . $student . "'", NULL, FALSE)
                        ->where($this->dx('class') . " = '" . $class . "'", NULL, FALSE)
                        ->where($this->dx('stream') . " = '" . $stream . "'", NULL, FALSE)
                        ->where($this->dx('year') . " = '" . date('Y') . "'", NULL, FALSE)
                        ->count_all_results('history') > 0;
        }
        function exists_($table, $field, $id)
        {
                $this->db->where('created_by', $this->ion_auth->get_user()->id);
                return $this->db->where(array($field => $id))->count_all_results($table) > 0;
        }

        function history_current($student)
        {
                $row = $this->db->where($this->dx('student') . " = '" . $student . "'", NULL, FALSE)
                        ->where($this->dx('year') . " = '" . date('Y') . "'", NULL, FALSE)
                        ->get('history')
                        ->row();
                return empty($row) ? FALSE : $row;
        }

        function key_exists($key)
        {
                $this->select_all_key(lang('active'));
                return $this->db->where($this->dx('license') . " = '" . $key . "'", NULL, FALSE)
                        ->count_all_results(lang('active')) > 0;
        }

        function count_ivs()
        {
                return $this->db->count_all_results('invoices');
        }

        function count_records($field, $id, $table)
        {
                return $this->db->where($field, $id)->count_all_results($table);
        }

        function get_max_invoice()
        {
                $size = $this->count_ivs();
                $max = 0;
                if ($size) {
                        $res = $this->db->select('max(id) as max', FALSE)->get('invoices')->row();
                        $max = $res->max;
                }

                return $max;
        }

        /**
         * Insert History For Students already In Admission Table
         * 
         * @return string
         */
        function make_history()
        {
                //get all students , zero flag to include suspended
                $pop = $this->get_all_students(0);

                $i = 0;
                foreach ($pop as $kid) {
                        $row = $this->find($kid);
                        $cls = $this->fetch_class($row->class);
                        //Check if history for this kid is made
                        $made = $this->history_exists($row->id, $cls->class, $cls->stream);

                        if (!$made) {
                                $hiss = array(
                                        'student' => $row->id,
                                        'class' => $cls->class,
                                        'stream' => $cls->stream,
                                        'year' => date('Y'),
                                        'created_on' => time(),
                                        'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->insert_key_data('history', $hiss);
                                $i++;
                        }
                }
                return 'Found ' . count($pop) . ' Student(s). Made History for ' . $i . ' Students';
        }

        /**
         * Sync History Changes Within the Current Year
         * 
         * @return string
         */
        function sync_history()
        {
                //get all students , zero flag to include suspended
                $pop = $this->get_all_students(0);

                $i = 0;
                $s = 0;
                $f = 0;
                $fids = [];
                foreach ($pop as $kid) {
                        $row = $this->find($kid);
                        $cls = $this->fetch_class($row->class);
                        if (empty($cls)) {
                                $f++;
                                $fids[] = $kid;
                        }
                        //Check if history for this kid is made for current year
                        $has = $this->history_current($row->id);
                        if ($has && isset($cls->class)) {
                                $upd = array(
                                        'class' => $cls->class,
                                        'stream' => $cls->stream,
                                        'modified_on' => time(),
                                        'modified_by' => $this->ion_auth->get_user()->id
                                );

                                $this->update_key_data($has->id, 'history', $upd);
                                $s++;
                        } else {
                                $hiss = array(
                                        'student' => $row->id,
                                        'class' => $cls->class,
                                        'stream' => $cls->stream,
                                        'year' => date('Y'),
                                        'created_on' => time(),
                                        'created_by' => $this->ion_auth->get_user()->id
                                );
                                $this->insert_key_data('history', $hiss);
                                $i++;
                        }
                }
                $nf = '';
                if (count($fids)) {
                        $nf = print_r($fids, TRUE) . ' no class(' . $f . ')!';
                }
                return 'Found ' . count($pop) . ' Student(s). Made History for ' . $i . ' Students, Sync ' . $s . ' Existing ' . $nf;
        }

        function save_key($data)
        {
                if (!$this->key_exists($data['license'])) {
                        $this->update_key_all(lang('active'), array('status' => 0));
                        $this->insert_key_data(lang('active'), $data);
                }
        }

        function get_active_key()
        {
                $this->select_all_key(lang('active'));
                return $this->db->where($this->dx('status') . '=1', NULL, FALSE)
                        ->get(lang('active'))
                        ->row();
        }

        function fetch_keys()
        {
                $this->select_all_key(lang('active'));
                return $this->db->get(lang('active'))
                        ->result();
        }

        /**
         * Insert Class Details to History Table
         * e.g. upon Promotion to new Class
         * 
         * @param int $student
         * @return boolean
         */
        function insert_history($student)
        {
                $row = $this->find($student);

                //Check if history for this kid is made
                $made = $this->history_exists($row->id, $row->class, $row->stream);

                if (!$made) {
                        //insert history
                        $hiss = array(
                                'student' => $row->id,
                                'class' => $row->class,
                                'stream' => $row->stream,
                                'year' => date('Y'),
                                'created_on' => time(),
                                'created_by' => $this->ion_auth->get_user()->id
                        );
                        $this->insert_key_data('history', $hiss);
                        return TRUE;
                } else {
                        return FALSE;
                }
        }

        /**
         * Fetch Class by class_id & Stream 
         * 
         * @param type $class
         * @param type $stream
         * @return type
         */
        function get_class_stream($class, $stream)
        {
                return $this->db->where(array('class' => $class, 'stream' => $stream))->get('classes')->row();
        }

        function get_fee_structure($class, $term)
        {
                $res = $this->db->select('id, amount')
                        ->where('class_id', $class)
                        ->where('term', $term)
                        ->get('fee_class')
                        ->row();

                if (!empty($res)) {
                        return $res;
                } else {
                        return FALSE;
                }
        }

        /**
         * Fetch Current Students in Specified Class  (All Streams)
         * 
         * @param int $class
         * @param bool $sus
         * @return type
         */
        function fetch_students($class, $sus = FALSE)
        {
                if (!$class) {
                        return array();
                }
                $cid = $this->db->where('class', $class)->get('classes')->result();

                $clist = array();
                foreach ($cid as $c) {
                        $clist[] = $c->id;
                }

                if (!count($clist)) {
                        return array();
                }

                $this->db->select('id');
                $wh = ' ( ';
                $i = 0;
                foreach ($clist as $cc) {
                        $i++;
                        $wh .= $this->dx('class') . '=' . $cc;
                        if ($i != count($clist)) {
                                $wh .= ' OR ';
                        }
                }
                $this->db->where($wh . ' ) ', NULL, FALSE);

                if ($sus) {
                        $this->db->where($this->dx('admission.status') . ' != 1', NULL, FALSE);
                } else {
                        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                }

                $list = $this->db->get('admission')->result();

                $students = array();
                foreach ($list as $l) {
                        $students[] = $l->id;
                }
                return $students;
        }

        /**
         * Fetch Current Students in Specified Class  (Single Stream)
         * 
         * @param type $id
         * @param type $sus
         */
        function list_students($id, $sus = FALSE)
        {
                if (!$id) {
                        return array();
                }

                $this->db->select('id')->where($this->dx('class') . '=' . $id, NULL, FALSE);
                if ($sus) {
                        $this->db->where($this->dx('admission.status') . ' != 1', NULL, FALSE);
                } else {
                        $this->db->where($this->dx('admission.status') . ' = 1', NULL, FALSE);
                }

                $list = $this->db->get('admission')->result();

                $students = array();
                foreach ($list as $l) {
                        $students[] = $l->id;
                }
                return $students;
        }

        /**
         * Count Current Students in Specified Class  
         * 
         * @param int $class
         * @return type
         */
        function count_students($class)
        {
                return $this->db->where($this->dx('class') . '=' . $class, NULL, FALSE)
                        ->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all_results('admission');
        }

        function fetch_class($id)
        {
                return $this->db->where(array('id' => $id))->get('classes')->row();
        }

        /**
         * Fetch Classes
         * 
         * @return array
         */
        function get_all_classes()
        {
                $scl = $this->get_class_options();
                $strms = $this->populate('class_stream', 'id', 'name');
                $list = $this->db->select('id, class, stream')
                        ->where('status', 1)
                        ->order_by('class')
                        ->get('classes')
                        ->result();
                $cls = array();
                foreach ($list as $l) {
                        $size = $this->count_students($l->id);

                        $name = isset($scl[$l->class]) ? $scl[$l->class] : ' -';
                        $strr = isset($strms[$l->stream]) ? $strms[$l->stream] : ' ';
                        $cls[$l->id] = array('name' => $name . ' ' . $strr, 'size' => $size);
                }
                return $cls;
        }

        function get_class_teachers()
        {

                // $scl = $this->get_class_options();
                // $this->select_all_key('users');
                $list = $this->db->select($this->dxa('first_name') . ', ' . $this->dxa('last_name') . ', classes.id as class_id', FALSE)
                        ->join('classes', 'classes.class_teacher=users.id')
                        ->get('users')
                        ->result();
                $cls = array();
                foreach ($list as $l) {


                        $cls[$l->class_id] = $l->first_name . ' ' . $l->last_name;
                }
                return $cls;
        }

        function get_present_stds()
        {
                $list = $this->db->select('status, class_id')
                        ->join('class_attendance', 'class_attendance.id= class_attendance_list.attendance_id')
                        ->where('status', 'Present')
                        ->get('class_attendance_list')
                        ->result();
                $cls = array();
                foreach ($list as $l) {

                        $cls[$l->class_id] = $l->status;
                }
                return $cls;
        }

        function get_balances()
        {
                // $list = $this->db->select('id, student','balance')
                $list = $this->db->select($this->dxa('invoice_amt') . ', ' . $this->dxa('student') . ', ' . $this->dxa('balance') . ', id', FALSE)
                        ->get('new_balances')
                        ->result();
                $bals = array();
                foreach ($list as $l) {
                        $bals[$l->student] = $l->balance;
                }
                return $bals;
        }

        function get_f_descriptions()
        {
                $list = $this->db->select($this->dxa('term') . ', ' . $this->dxa('id') . ', ' . $this->dxa('amount') . ', id', FALSE)
                        ->get('fee_payment')
                        ->result();
                $desc = array();
                foreach ($list as $l) {
                        $desc[$l->id] = $l->term;
                }
                return $desc;
        }

        function get_fee_extras()
        {
                $list = $this->db->select('id, amount')
                        ->get('fee_extras')
                        ->result();
                $extras = array();
                foreach ($list as $l) {
                        $extras[$l->id] = $l->amount;
                }
                return $extras;
        }

        function get_std()
        {
                $list = $this->db->select($this->dxa('admission_number') . ',' . $this->dxa('old_adm_no') . ', ' . $this->dxa('last_name') . ',id', FALSE)
                        ->get('admission')
                        ->result();
                $stds = array();
                foreach ($list as $l) {

                        $stds[trim($l->admission_number)] = $l->id;
                }

                return $stds;
        }

        function get_routes()
        {
                $list = $this->db
                        ->get('transport_routes')
                        ->result();
                $routes = array();
                foreach ($list as $l) {

                        $routes[trim($l->name)] = $l->id;
                }

                return $routes;
        }

        function get_absent_stds()
        {
                $list = $this->db->select('status, class_id')
                        ->join('class_attendance', 'class_attendance.id= class_attendance_list.attendance_id')
                        ->where('status', 'Absent')
                        ->get('class_attendance_list')
                        ->result();
                $cls = array();
                foreach ($list as $l) {

                        $cls[$l->class_id] = $l->status;
                }
                return $cls;
        }

        function get_all_streams()
        {
                $ops = array();
                $list = $this->get_all_classes();
                foreach ($list as $key => $obj) {
                        $obj = (object) $obj;
                        $ops[$key] = $obj->name;
                }
                return $ops;
        }

        function list_all_classes()
        {
                $out = array();
                $list = $this->get_all_classes();
                foreach ($list as $key => $obj) {
                        $obj = (object) $obj;
                        $out[$key] = $obj->name;
                }
                return $out;
        }



        function populate($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get($table);
                $dropdowns = $query->result();
                $options = array();
                foreach ($dropdowns as $dropdown) {
                        $options[$dropdown->$option_val] = $dropdown->$option_text;
                }
                return $options;
        }

        /**
         * E-videos Queries
         * 
         */
        function get_per_subject($class, $subject)
        {

                $res =  $this->db->where(array('level' => $class, 'subject' => $subject, 'status' => 1))->get('evideos')->result();
                return $res;
        }



        function count_general_evideos()
        {

                return $this->db->where('status', 1)->count_all_results('general_evideos');
        }

        function get_general_evideos()
        {

                return $this->db->order_by('id', 'desc')->where('status', 1)->get('general_evideos')->result();
        }

        function class_students($class)
        {

                return $this->db->select('id')->where($this->dx('class') . ' = ' . $class, NULL, FALSE)->get('admission')->result();
        }

        function find_general_vid($id)
        {

                return $this->db->where('id', $id)->where('status', 1)->get('general_evideos')->row();
        }

        function count_video_files($class, $subject)
        {

                $res =  $this->db->where(array('level' => $class, 'subject' => $subject, 'status' => 1))->count_all_results('evideos');
                return $res;
        }
        function get_last_video($level, $sub)
        {

                return $this->db->order_by('id', 'desc')->where(array('subject' => $sub, 'level' => $level, 'status' => 1))->get('evideos')->row();
        }

        function get_video_comments($id, $type)
        {

                return $this->db->order_by('id', 'asc')->where(array('video_id' => $id, 'status' => 1, 'type' => $type))->get('evideo_comments')->result();
        }

        function get_last_gvideo()
        {
                return $this->db->order_by('id', 'desc')->where(array('status' => 1))->get('general_evideos')->row();
        }

        /**
         * Fetch Class Options
         * 
         * @return type
         */
        function get_class_options()
        {
                $list = $this->db->select('id, name')
                        ->where('status', 1)
                        ->order_by('id')
                        ->get('class_groups')
                        ->result();
                $cls = array();
                foreach ($list as $l) {
                        $cls[$l->id] = $l->name;
                }
                return $cls;
        }

        function invoice_me($data)
        {
                $this->db->insert('invoices', $data);
                return $this->db->insert_id();
        }

        function class_group_row($class)
        {

                return $this->db->where('id', $class)->get('classes')->row();
        }


        function get_classes()
        {
                $list = $this->db->select('id')->get('class_groups')->result();
                $classes = array();
                foreach ($list as $l) {
                        $classes[] = $l->id;
                }
                return $classes;
        }

        function get_class_ids()
        {
                $list = $this->db->select('id')->get('classes')->result();
                $classes = array();
                foreach ($list as $l) {
                        $classes[] = $l->id;
                }
                return $classes;
        }

        function update_check($id, $data)
        {
                return $this->db->where('id', $id)->update('invoices', $data);
        }

        /**
         * Update_receivables
         * 
         * @param float $bal Update Array
         */
        function add_receivables($bal)
        {
                $acc = 610;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid) {
                        $id = $acid->id;
                        $rcv = array('balance' => ($bal + $acid->balance), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                } else {
                        return FALSE;
                }
        }

        /**
         * Fetch List of Parents
         * 
         * @return string
         */
        function fetch_parent_details()
        {
                $res = $this->db->select($this->dxa('first_name') . ', ' . $this->dxa('last_name') . ', ' . $this->dxa('phone') .  ', ' . $this->dxa('user_id') . ', id', FALSE)
                        //->where($this->dx('status') . ' =  0', NULL, FALSE)
                        ->order_by($this->dx('first_name'), 'ASC', FALSE)
                        ->get('parents')
                        ->result();
                $options = array();

                foreach ($res as $r) {
                        $options[$r->id] = $r->first_name . ' ' . $r->last_name . ' - ' . $r->phone;
                }
                return $options;
        }

        /**
         * Update_receivables -Decrement
         * 
         * @param float $bal Update Array
         */
        function dec_receivables($bal)
        {
                $acc = 610;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid) {
                        $id = $acid->id;
                        $rcv = array('balance' => ($acid->balance - $bal), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                } else {
                        return FALSE;
                }
        }

        /**
         * Update Sales Account (Fees)
         * @param type $bal
         * @return boolean
         */
        function add_sales($bal)
        {
                $acc = 200;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid) {
                        $id = $acid->id;
                        $rcv = array('balance' => ($bal + $acid->balance), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                } else {
                        return FALSE;
                }
        }

        /**
         * Update Sales Account (Fees) decrement
         * @param type $bal
         * @return boolean
         */
        function dec_sales($bal)
        {
                $acc = 200;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . ' =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid) {
                        $id = $acid->id;
                        $rcv = array('balance' => ($acid->balance - $bal), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                } else {
                        return FALSE;
                }
        }

        /**
         * Update Sales Account (Fees) decrement
         * @param type $bal
         * @return boolean
         */
        function update_waiver($bal)
        {
                $acc = 450;
                $acid = $this->db->select('id,' . $this->dxa('balance'), FALSE)->where($this->dx('code') . '  =' . $acc, NULL, FALSE)->get('accounts')->row();
                if ($acid) {
                        $id = $acid->id;
                        $rcv = array('balance' => ($acid->balance + $bal), 'modified_by' => 1, 'modified_on' => time());
                        return $this->update_key_data($id, 'accounts', $rcv);
                } else {
                        return FALSE;
                }
        }

        /**
         * Fetch all students Sponsored by This Parent
         * 
         * @param int $parent The Parent id
         * @return object
         */
        function get_kids($parent)
        {
                if (!$parent) {
                        return array();
                }
                $this->select_all_key('parents');
                $pid = $this->db->where($this->dx('user_id') . '=' . $parent, NULL, FALSE)->get('parents')->row();
                $res = $this->db->where('parent_id', $pid->id)->get('assign_parent')->result();

                foreach ($res as $r) {
                        $row = $this->worker->fetch_balance($r->student_id);
                        $r->balance = $row ? $row->balance : 0;
                        $r->invoice_amt = $row ? $row->invoice_amt : 0;
                        $r->paid = $row ? $row->paid : 0;
                }

                return $res;
        }

        /**
         * Fetch Parent Profile From Parents Table
         * 
         * @param int $parent
         * @return object
         */
        function get_profile($parent)
        {
                $this->select_all_key('parents');
                return $this->db
                        ->where($this->dx('user_id') . ' = ' . $parent, NULL, FALSE)
                        ->get('parents')
                        ->row();
        }

        /**
         * Fetch Parent Profile From Parents Table
         * 
         * @param int $parent
         * @return object
         */
        function get_parent($parent)
        {
                $this->select_all_key('parents');
                return $this->db
                        ->where('id', $parent)
                        ->get('parents')
                        ->row();
        }

        /**
         * Monthly Admissions Graph
         * 
         * @return object
         */
        function get_monthly_admissions()
        {
                return $this->db->select('MONTH(FROM_UNIXTIME(' . $this->dx('admission_date') . ' )) as mt, count(*) as total', FALSE)
                        ->where('YEAR(FROM_UNIXTIME(' . $this->dx('admission_date') . ')) =' . date('Y'), NULL, FALSE)
                        ->group_by('mt')
                        ->order_by('mt', 'ASC', FALSE)
                        ->get('admission')
                        ->result();
        }

        /**
         * Fetch Admission Row
         * 
         * @param int $id
         * @return object
         */
        function get_student($id)
        {

                $this->select_all_key('admission');
                return $this->db->where($this->dx('user_id') . '=' . $id, NULL, FALSE)->get('admission')->row();
        }

        function get_reg()
        {
                $id = $this->ion_auth->get_user()->id;
                $query = $this->db->get('admission');
                return $query->result_array();
        }

        /**
         * Log Invoice Cron Run
         * 
         * @param type $data
         * @return type
         */
        function log_exec($data)
        {
                return $this->insert_key_data('crontab', $data);
        }

        function log_statement($data)
        {
                return $this->insert_key_data('statement', $data);
        }

        /**
         * Fetch SMS Status
         * @return boolean
         */
        function get_text_status()
        {
                $row = $this->db->select($this->dxa('can_text'), FALSE)
                        ->where('id', 1)
                        ->get('config')
                        ->row();
                if ($row) {
                        return $row->can_text == 1;
                } else {
                        return FALSE;
                }
        }

        /** check if config row exists
         * 
         * @return type
         */
        function check_config()
        {
                return $this->db->count_all_results('config') > 0;
        }

        function has_exec()
        {
                return $this->db->where($this->dx('exec') . '=1', NULL, FALSE)
                        ->where("DATE_FORMAT(FROM_UNIXTIME(" . $this->dx('created_on') . "), '%d %b %Y') ='" . date('d M Y') . "'", NULL, FALSE)
                        ->count_all_results('crontab') > 0;
        }

        /**
         * Check if Automatic Promotion has been Done
         * 
         * @return type
         */
        function check_movement()
        {
                return $this->db->where($this->dx('moved') . ' = 1', NULL, FALSE)
                        ->where($this->dx('year') . '=' . date('Y'), NULL, FALSE)
                        ->count_all_results('movements') > 0;
        }

        /**
         * Fetch Population to move
         * 
         * @return type
         */
        function fetch_moving_targets()
        {
                $list = $this->db->select('id,' . $this->dxa('class'), FALSE)
                        ->where($this->dx('status') . '=1', NULL, FALSE)
                        ->get('admission')
                        ->result();
                $pops = array();
                foreach ($list as $l) {
                        $pops[$l->id] = $l->class;
                }
                return $pops;
        }

        function create_unenc($table, $data)
        {
                $this->db->insert($table, $data);
                return $this->db->insert_id();
        }

        function update_unenc($table, $id, $data)
        {
                return $this->db->where('id', $id)->update($table, $data);
        }

        function notifactions()
        {

                $st = $this->get_student($this->user->id);
                $this->db->order_by('created_on', 'desc');
                $this->db->where('student', $st->id);
                $this->db->where('status', 1);
                $ass = $this->db->limit(10)->get('assignments_tracker')->result();
                return $ass;
        }


        /**
         * Shows a Sane File Size 
         * 
         * @param double $kb
         * @param int $precision
         * @return double
         */
        function file_sizer($kb, $precision = 2)
        {
                $base = log($kb) / log(1024);
                $suffixes = array('', ' kb', ' MB', ' GB', ' TB');

                return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        function get_subject($class)
        {

                $sys = $this->ion_auth->populate('class_groups', 'id', 'education_system');

                if ($sys[$class] == 1) {

                        return $this->ion_auth->populate('subjects', 'id', 'name');
                } elseif ($sys[$class] == 2) {

                        return $this->ion_auth->populate('cbc_subjects', 'id', 'name');
                }
        }

        function count_done_attachments($id)
        {

                return $this->db->where(array('assignment' => $id))->count_all_results('assignments_done');
        }

        function get_subject_assigned($class, $teacher)
        {

                $res =  $this->db->where(array('class' => $class, 'teacher' => $teacher))->get('subjects_assign')->result();

                $cbc = $this->ion_auth->populate('cbc_subjects', 'id', 'name');
                $s844  = $this->ion_auth->populate('subjects', 'id', 'name');

                $dp = array();
                foreach ($res as $p) {
                        $name = $cbc;
                        if ($p->type == 1) {
                                $name = $s844;
                        }

                        $dp[$p->subject] = $name[$p->subject];
                }

                return $dp;
        }


        /**
         * Insert a new Class
         * 
         * @param array $data
         * @return int
         */
        function make_class($data)
        {
                $this->db->insert('classes', $data);
                return $this->db->insert_id();
        }

        /**
         * Log promotion
         * 
         * @param type $data
         * @return type
         */
        function log_movement($data)
        {
                return $this->insert_key_data('movements', $data);
        }

        function put_config()
        {
                $q1 = 'TRUNCATE `config`';
                $sts = 'INSERT INTO `config` VALUES
	(1, _binary 0x9E0C3309C8FB9A2C9E37ECDA3339171B, _binary 0xD2E2A642D748763BB80322744FE09E4A, NULL, NULL, NULL);';
                $this->db->query($q1);
                return $this->db->query($sts);
        }

        /**
         * Update Student Info
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function upd_student($id, $data)
        {
                return $this->update_key_data($id, 'admission', $data);
        }

        /**
         * Void Current Invoice
         * 
         * @param int $id
         * @param array $data
         * @return boolean
         */
        function void_invoice($id, $data)
        {
                return $this->update_key_data($id, 'invoices', $data);
        }

        //Calculate total paid Fees
        function total_stock()
        {
                return $this->db->select('sum(total) as total')
                        ->get('add_stock')
                        ->row();
        }

        //Calculate total quatity
        function total_quantity($id)
        {
                $dat = $this->db->select('sum(quantity) as quantity')
                        ->where('add_stock.product_id', $id)
                        ->get('add_stock')
                        ->row();

                return $dat;
        }

        //Calculate total quatity
        function total_given($id)
        {
                $dat = $this->db->select('sum(quantity) as quantity')
                        ->where('item', $id)
                        ->get('give_items')
                        ->row();

                return $dat;
        }

        //Calculate total cost
        function total_cost($id)
        {
                $dat = $this->db->select('sum(total) as totals')
                        ->where('product_id', $id)
                        ->get('add_stock')
                        ->row();

                return $dat;
        }

        //Get product QNTY of the selected product
        function total_closing_stock($id)
        {
                return $this->db->select('sum(closing_stock) as quantity')
                        ->where('product_id', $id)
                        ->get('stock_taking')
                        ->row();
        }

        /**
         * get_events
         * 
         * @param int $type Event type
         * @return type
         */
        function get_events($type = 0)
        {
                if ($type) {
                        $this->db->where('cat', 1);
                }
                return $this->db->order_by('date', 'DESC')->limit(50)->get('events')->result();
        }

        function school_events()
        {
                $this->db->order_by('start_date', 'DESC');
                $all = $this->db->where('visibility', 'All')->get('school_events')->result();
                $paro = $this->db->where('visibility', '6')->get('school_events')->result();

                return $all + $paro;
        }

        function student_exams($student)
        {
                return $this->db->where('student', $student)->order_by('created_on', 'ASC')->get('exams_management_list')->result();
        }


        function paginate_notices($limit, $page)
        {
                $offset = $limit * ($page - 1);

                $this->db->order_by('created_on', 'desc');
                $query = $this->db->get('notice_board', $limit, $offset);

                $result = [];
                foreach ($query->result() as $row) {
                        $result[] = $row;
                }

                return $result;
        }

        function count_notices()
        {
                return $this->db->count_all_results('notice_board');
        }

        function newsletters()
        {
                return $this->db->order_by('created_on', 'desc')->where('status', 0)->get('newsletters')->result();
        }


        function assigned_kids($id)
        {
                return $this->db->order_by('created_on', 'asc')->where('parent_id', $id)->get('assign_parent')->result();
        }


        function rules_regulations()
        {
                return $this->db->order_by('created_on', 'desc')->get('notice_board')->result();
        }


        //Passport
        function birth_certificate($id)
        {
                return $this->db->where(array('id' => $id))->get('certificates')->row();
        }

        //Passport
        function parent_photo($id)
        {
                return $this->db->where(array('id' => $id))->get('parents_passports')->row();
        }

        //Passport
        function file_folders($id)
        {
                return $this->db->where(array('folder' => $id))->count_all_results('past_papers');
        }
        //Passport
        function student_passport($id)
        {
                return $this->db->where(array('id' => $id))->get('passports')->row();
        }


        //Passport
        function parents_ids($id)
        {
                return $this->db->where(array('id' => $id))->get('parents_ids')->row();
        }

        function get_recs()
        {

                $kids = $this->parent->kids;

                $recs = array();

                foreach ($kids as $p) {

                        $this->select_all_key('fee_payment');
                        $this->db->where($this->dx('status') . '=1', NULL, FALSE);
                        $this->db->where($this->dx('reg_no') . '=' . $p->student_id, NULL, FALSE);

                        $rec =  $this->db
                                ->order_by('payment_date', 'desc')
                                ->get('fee_payment')
                                ->result();

                        $recs[] = $rec;
                }
                //print_r($recs);die;
                return $recs;
        }



        function fee_waivers()
        {

                $kids = $this->parent->kids;

                $recs = array();

                foreach ($kids as $p) {

                        $rec =  $this->db
                                ->order_by('date', 'desc')
                                ->where('student', $p->student_id)
                                ->get('fee_waivers')
                                ->result();

                        if ($rec) {
                                $recs[] = $rec;
                        }
                }
                //print_r($recs);die;
                return $recs;
        }

        function count_items($table, $field = NULL, $id = NULL)
        {

                if (isset($field) && isset($id)) {

                        $this->db->where($field, $id);
                }

                return $this->db->count_all_results($table);
        }

        function count_unique($table, $field1 = NULL, $id1 = NULL, $field2 = NULL, $id2 = NULL)
        {

                if (isset($field1) && isset($id1)) {

                        $this->db->where($field1, $id1);
                }

                if (isset($field2) && isset($id2)) {

                        $this->db->where($field2, $id2);
                }

                return $this->db->count_all_results($table);
        }


        function national_exams()
        {

                $kids = $this->parent->kids;

                $recs = array();

                foreach ($kids as $p) {

                        $rec =  $this->db
                                ->order_by('id', 'asc')
                                ->where('student', $p->student_id)
                                ->get('final_exams_certificates')
                                ->result();
                        if ($rec) {
                                $recs[] = $rec;
                        }
                }
                //print_r($recs);die;
                return $recs;
        }

        function other_certificates()
        {

                $kids = $this->parent->kids;

                $recs = array();

                foreach ($kids as $p) {

                        $rec =  $this->db
                                ->order_by('id', 'asc')
                                ->where('student', $p->student_id)
                                ->get('students_certificates')
                                ->result();
                        if ($rec) {
                                $recs[] = $rec;
                        }
                }
                //print_r($recs);die;
                return $recs;
        }



        /**
         * Fetch Item Row
         * 
         * @param int $id
         * @return object
         */
        function get_enc_row($field, $item, $table)
        {
                $this->select_all_key($table);
                return $this->db->where($this->dx($field) . '=' . $item, NULL, FALSE)->get($table)->row();
        }

        /**
         * Fetch Item Row
         * 
         * @param int $id
         * @return object
         */
        function get_unenc_row($field, $item, $table)
        {
                return $this->db->where($field, $item)->get($table)->row();
        }

        function count_students_per_class($class)
        {
                return $this->db->where($this->dx('class') . ' =' . $class, NULL, FALSE)
                        ->where($this->dx('status') . ' = 1', NULL, FALSE)->count_all_results('admission');
        }



        function get_teacher_profile($id)
        {
                $this->select_all_key('teachers');
                return $this->db->where($this->dx('user_id') . ' =' . $id, NULL, FALSE)->get('teachers')->row();
        }

        function get_teacher_details($id)
        {
                $this->select_all_key('teachers');
                return $this->db->where('id', $id)->get('teachers')->row();
        }

        /**
         * Fetch Item Row
         * 
         * @param int $id
         * @return object
         */
        function get_unenc_result($field, $item, $table)
        {
                return $this->db->order_by('id', 'desc')->where($field, $item)->get($table)->result();
        }

        /**
         * Fetch Item Row
         * 
         * @param int $id
         * @return object
         */
        function get_payment_log($id)
        {
                $this->select_all_key('mpesa_payment_logs');
                return $this->db->where('id', $id)->get('mpesa_payment_logs')->row();
        }

        function payment_options($table, $option_val, $option_text)
        {
                $query = $this->db->select('*')->order_by($option_text)->get('payment_options');
                $dropdowns = $query->result();
                $options = array();
                foreach ($dropdowns as $dropdown) {
                        $options[$dropdown->$option_val] = $dropdown->account . ' - ' . $dropdown->business_number;
                }

                return $options;
        }


        function update_code($id, $field, $table, $data)
        {
                return $this->db->where($field, $id)->update($table, $data);
        }

        function delete_code($table, $field, $id)
        {
                return $this->db->delete($table, array($field => $id));
        }

        function count_posted_answers($student, $table, $field, $id)
        {
                return $this->db->where(array('student' => $student, $field => $id))->count_all_results($table);
        }


        function mc_done($id, $st)
        {
                return $this->db->where(array('mc_id' => $id, 'student' => $st))->get('mc_given')->row();
        }

        function qa_done($id, $st)
        {
                return $this->db->where(array('qa_id' => $id, 'student' => $st))->get('qa_given')->row();
        }

        function given_qa($id, $st)
        {
                return $this->db->where(array('id' => $id, 'student' => $st))->get('qa_given')->row();
        }

        public function mpesa_bank()
        {
                $phone = $this->input->post('phone');
                $mpesa_amount = $this->input->post('amount');
                $customer_refrence = $this->input->post('reg_no');
                $account_info = $this->input->post('api_key');
                $account_split = explode('.', $account_info);

                // $account_name= $account_split[0];
                $ap_name = $account_split[1];
                $ap_key = $account_split[2];
                // $account_number=$account_split[3];

                $mydata = array(
                        'phone' => $phone,
                        'amount' => $mpesa_amount,
                        'refrence' => $customer_refrence
                );

                $api_key = $ap_key;
                $username = $ap_name;

                $amount = $mpesa_amount; //provide amount here
                $customer_phone = $phone; //provide customer phone here
                $payment_reference = $customer_refrence; //privide payment reference here.

                # code...send request to pay hero kenya
                $data = array(
                        'api_key' => $api_key, //provide api keyhere
                        'username' => $username, //provide username here
                        'amount' => $amount, //provide amount here
                        'phone' => $customer_phone, //provide phone number here
                        'user_reference' => $payment_reference //provide user reference here
                );

                $jdata = json_encode($data);
                $response = sendRequest("https://payherokenya.com/sps/portal/app/mtb", $jdata); //send request to initiate stk.
                print_r($response); //print the response from sps.
                print_r($mydata);
                // return $this->db->insert('payments', $mydata);
        }

        public function get_bank_accounts()
        {
                return $this->db
                        //  ->where('api_key is not null')
                        ->get('bank_accounts')
                        ->result();
        }

        function get_zoom_notifications()
        {
                $user = $this->ion_auth->get_user()->id;

                $this->select('zoom_notifications.*');
                $this->select('zoom.*');
                return $this->db
                        ->join('zoom_notifications', 'zoom_notifications.zoom_id=zoom.id')
                        ->where('zoom_notifications.user_id', $user)
                        ->get('zoom')
                        ->result();
        }

        function zoom_notifications()
        {
                $user = $this->ion_auth->get_user()->id;
                $this->select('zoom_notifications.*');
                $this->select('zoom.*');
                $res =  $this->db
                        ->join('zoom_notifications', 'zoom_notifications.zoom_id=zoom.id')
                        ->where('zoom_notifications.user_id', $user)
                        ->where('zoom_notifications.status', 0)
                        ->get('zoom')
                        ->result();

                if ($res) {
                        return $res;
                } else {
                        return false;
                }
        }

        function zoom_noti()
        {
                $st = $this->get_student($this->user->id);
                $this->db->order_by('created_on', 'desc');
                $this->db->where('student', $st->id);
                $this->db->where('status', 0);
                $ass = $this->db->limit(10)->get('zoom_notifications')->result();
                return $ass;
        }

        function mark_as_read($user_id, $zoom_id, $data)
        {
                return  $this->db
                        ->where('user_id', $user_id)
                        ->where('zoom_id', $zoom_id)
                        ->update('zoom_notifications', $data);
        }

        function get_shop_items()
        {
                return $this->db
                        ->get('shop_item')
                        ->result();
        }


        function settings()
        {
                return $this->db->select('settings.*')->get('settings')->row();
        }

        function checkLicense()
        {
                $this->select('settings.status');
                $res = $this->db

                        ->get('settings')
                        ->result();
                foreach ($res as $s) {
                        $status = $s->status;
                }
                return $status;
        }

        function update_license($data)
        {
                return $this->db->where('id', 1)->update('settings', $data);
        }



        function change_db()
        {
                $mess = [];

                $subj_ass = $this->db->query('ALTER TABLE `subjects_assign` ADD `term` INT NULL AFTER `type`, ADD `year` INT NULL AFTER `term`;');

                if ($subj_ass) 
                {
                        $mess[] = ['mess' => 'Updated subj_ass'];
                } 
                else 
                {
                        $mess[] = ['mess' => 'Opps, something happened subj_ass'];
                }


                $exams = $this->db->query('ALTER TABLE `exams`
                                                        ADD COLUMN `type` INT(11) NULL DEFAULT NULL AFTER `year`,
                                                        ADD COLUMN `parent` INT(11) NULL DEFAULT NULL AFTER `type`;
                                                        ');

                if ($exams) 
                {
                        $mess[] = ['mess' => 'Updated Exams'];
                } 
                else 
                {
                        $mess[] = ['mess' => 'Opps, something happened exams'];
                }




                $exams_management =  $this->db->query('ALTER TABLE `exams_management`
                                                        ADD COLUMN `level` INT(11) NULL DEFAULT NULL AFTER `class_id`,
                                                        ADD COLUMN `term` INT(11) NULL DEFAULT NULL AFTER `level`,
                                                        ADD COLUMN `year` INT(11) NULL DEFAULT NULL AFTER `term`,
                                                        ADD COLUMN `stream` TEXT NULL  AFTER `year`;
                                                        ');

                if ($exams_management) 
                {
                        $mess[] = ['mess' => 'Updated Exam Management'];
                } 
                else 
                {
                        $mess[] = ['mess' => 'Opps, something happened exams_management'];
                }




                $alter_exams_management =  $this->db->query('ALTER TABLE `exams_management` CHANGE `stream` `stream` 
                                                            VARCHAR(255) NULL DEFAULT NULL;
                                                        ');

                if ($alter_exams_management) 
                {
                        $mess[] = ['mess' => 'Updated Alter Exam Management'];
                }
                 else 
                {
                        $mess[] = ['mess' => 'Opps, something happened alter exams_management'];
                }


                $exams_UP1 =  $this->db->query(' UPDATE `exams_management` AS U1, exams AS U2 
                                                        SET U1.term = U2.term,
                                                        U1.year = U2.year
                                                        WHERE U2.id = U1.exam_type;
                                                        ');



                if ($exams_UP1) 
                {
                        $mess[] = ['mess' => 'Updated Exam Management UP1'];
                } 
                else 
                {
                        $mess[] = ['mess' => 'Opps, something happened UP1'];
                }



                $exams_marks_list =  $this->db->query('ALTER TABLE `exams_marks_list`
                                                        ADD COLUMN `exams_id` INT(11) NULL DEFAULT NULL AFTER `marks`,
                                                        ADD COLUMN `student` INT(11) NULL DEFAULT NULL AFTER `exams_id`;
                                                        ');


                if ($exams_marks_list) 
                {
                        $mess[] = ['mess' => 'Updated exams_marks_list'];
                } 
                else 
                {
                        $mess[] = ['mess' => 'Opps, something happened exams_marks_list'];
                }


                $exams_marks_list_UP2 =  $this->db->query(' UPDATE exams_marks_list AS U1, exams_management_list AS U2 
                                                        SET U1.exams_id = U2.exams_id,
                                                        U1.student = U2.student
                                                        WHERE U2.id = U1.exams_list_id;
                                                        ');


                if ($exams_marks_list_UP2) 
                {
                        $mess[] = ['mess' => 'Updated exams_marks_list UP2'];
                } 
                else 
                {
                        $mess[] = ['mess' => 'Opps, something happened exams_marks_list exams_marks_list'];
                }

                return $mess;
        }

        function _create_dbs()
        {
                $mess = [];
                $exam_gs = $this->db->query("CREATE TABLE IF NOT EXISTS `exam_gs` (
                                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                                        `exam` INT(11) NULL ,
                                        `level` INT(11) NULL ,
                                        `grading` INT(11) NULL COMMENT 'Grading System',
                                        `created_by` INT(11) NULL ,
                                        `modified_by` INT(11) NULL ,
                                        `created_on` INT(11) NULL ,
                                        `modified_on` INT(11) NULL ,
                                        PRIMARY KEY (`id`) USING BTREE
                                        )
                                        COLLATE='utf8_general_ci'
                                        ENGINE=InnoDB
                                        ROW_FORMAT=DYNAMIC
                                        ;");

                if($exam_gs)
                {
                        $mess['Create Tables'] = ['mess' => 'Added exam_gs tbl'];
                }
                else
                {
                        $mess['Create Tables'] = ['mess' => 'Failed adding exam_gs tbl'];
                }

                $exam_pos = $this->db->query("CREATE TABLE IF NOT EXISTS `exam_pos` (
                                                `id` INT(11) NOT NULL AUTO_INCREMENT,
                                                `exam` INT(11) NULL DEFAULT NULL,
                                                `level` INT(11) NULL DEFAULT NULL,
                                                `student` INT(11) NULL DEFAULT NULL,
                                                `gender` INT(11) NULL DEFAULT NULL,
                                                `stream` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                                                `total_r1_overall` INT(11) NULL DEFAULT NULL,
                                                `total_r1_gender` INT(11) NULL DEFAULT NULL,
                                                `total_r1_stream` INT(11) NULL DEFAULT NULL,
                                                `total_r2_overall` INT(11) NULL DEFAULT NULL,
                                                `total_r2_gender` INT(11) NULL DEFAULT NULL,
                                                `total_r2_stream` INT(11) NULL DEFAULT NULL,
                                                `total_r3_overall` INT(11) NULL DEFAULT NULL,
                                                `total_r3_gender` INT(11) NULL DEFAULT NULL,
                                                `total_r3_stream` INT(11) NULL DEFAULT NULL,
                                                `points_r1_overall` INT(11) NULL DEFAULT NULL,
                                                `points_r1_gender` INT(11) NULL DEFAULT NULL,
                                                `points_r1_stream` INT(11) NULL DEFAULT NULL,
                                                `points_r2_overall` INT(11) NULL DEFAULT NULL,
                                                `points_r2_stream` INT(11) NULL DEFAULT NULL,
                                                `points_r2_gender` INT(11) NULL DEFAULT NULL,
                                                `points_r3_overall` INT(11) NULL DEFAULT NULL,
                                                `points_r3_stream` INT(11) NULL DEFAULT NULL,
                                                `points_r3_gender` INT(11) NULL DEFAULT NULL,
                                                `created_by` INT(11) NULL DEFAULT NULL,
                                                `modified_by` INT(11) NULL DEFAULT NULL,
                                                `created_on` INT(11) NULL DEFAULT NULL,
                                                `modified_on` INT(11) NULL DEFAULT NULL,
                                                PRIMARY KEY (`id`) USING BTREE
                                        )
                                        COLLATE='utf8_general_ci'
                                        ENGINE=InnoDB
                                        ROW_FORMAT=DYNAMIC;");

                if ($exam_pos) 
                {
                        $mess['Create Tables'] = ['mess' => 'Added exam_pos tbl'];
                } 
                else 
                {
                        $mess['Create Tables'] = ['mess' => 'Failed adding exam_pos tbl'];
                }


                $exam_trend = $this->db->query("CREATE TABLE IF NOT EXISTS `exam_trend` (
                                                `id` INT(11) NOT NULL AUTO_INCREMENT,
                                                `exam` INT(11) NULL DEFAULT NULL,
                                                `level` INT(11) NULL DEFAULT NULL,
                                                `student` INT(11) NULL DEFAULT NULL COMMENT 'Grading System',
                                                `term` INT(11) NULL DEFAULT NULL,
                                                `year` INT(11) NULL DEFAULT NULL,
                                                `mean` INT(11) NULL DEFAULT NULL,
                                                `created_by` INT(11) NULL DEFAULT NULL,
                                                `modified_by` INT(11) NULL DEFAULT NULL,
                                                `created_on` INT(11) NULL DEFAULT NULL,
                                                `modified_on` INT(11) NULL DEFAULT NULL,
                                                PRIMARY KEY (`id`) USING BTREE
                                        )
                                        COLLATE='utf8_general_ci'
                                        ENGINE=InnoDB
                                        ROW_FORMAT=DYNAMIC
                                        ;");


                if ($exam_trend) 
                {
                        $mess['Create Tables'] = ['mess' => 'Added exam_trend tbl'];
                } 
                else 
                {
                        $mess['Create Tables'] = ['mess' => 'Failed adding exam_trend tbl'];
                }

                return $mess;
        }


        

        function update_tbl($table, $id, $data)
        {
                return $this->db->where('class_id', $id)->update($table, $data);
        }


        function update_exams_mgt_levl()
        {
                //fetch streams from exams_management

                $list = $this->db->get('exams_management')->result();
                $i = 0;
                foreach($list as $p)
                {
                        $streams = $this->get_all_streams();
                        $strm = isset($streams[$p->class_id]) ? $streams[$p->class_id] : '';
                        $class = $this->db->where('id', $p->class_id)->get('classes')->row();

                       $up =  $this->update_tbl('exams_management', $p->class_id, ['level' => $class->class,'stream' => $strm]);

                       if($up)
                       {
                        $i++;
                       }
                }


                echo '<pre>Updated<br>';
                print_r($i);
                echo ' Records</pre>';
                die();

        }
}
