<?php

class Class_attendance_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function create($data)
        {
                $this->db->insert('class_attendance', $data);
                return $this->db->insert_id();
        }

        function create_list($data)
        {
                $this->db->insert('class_attendance_list', $data);
                return $this->db->insert_id();
        }
		
		
		  function stud_att_counter($student,$state)
        {
			 $month = (int)date('m'); $year = date('Y');
			 
                return $this->db
				->select('class_attendance_list.id,class_attendance_list.attendance_id,class_attendance_list.student,class_attendance_list.status,class_attendance_list.remarks,class_attendance.id,class_attendance.attendance_date,class_attendance.title')
			 
			    ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
				->where(array('student' => $student,'status'=>$state))
				 ->where('MONTH(FROM_UNIXTIME(attendance_date))', $month)
                 ->where('YEAR(FROM_UNIXTIME(attendance_date))', $year)
				->count_all_results('class_attendance_list');
        }


        //Get students
        public function get_students($id)
        {
                $this->select_all_key('admission');
                $results = $this->db->where($this->dx('class') . '=' . $id, NULL, FALSE)->where($this->dx('status') . '=1', NULL, FALSE)->get('admission')->result();
                $arr = array();
                foreach ($results as $r)
                {
					  $adm = $r->admission_number;
					  if (!empty($r->old_adm_no))
						{
								$adm =  $r->old_adm_no;
						}
						
                        $arr[$r->id] = $r->first_name . ' ' . $r->last_name.'<br> ADM: <b>'.$adm .'</b>';
                }
                return $arr;
        }

        function find($id)
        {
                return $this->db->where(array('id' => $id))->get('class_attendance')->row();
        }

        function get_by_class($id)
        {
                return $this->db->where(array('class_id' => $id))->get('class_attendance')->row();
        }

        function get_row($id)
        {
                return $this->db->where(array('id' => $id))->get('class_attendance')->row();
        }

        function get($id, $filter = 0)
        {
                if ($filter)
                {
                        $this->db->where(array('created_by' => $this->user->id));
                }
                return $this->db->where(array('class_id' => $id))->order_by('created_on', 'DESC')->get('class_attendance')->result();
        }

        function get_register($id)
        {
                return $this->db->where(array('attendance_id' => $id))->get('class_attendance_list')->result();
        }
		
		function get_by_status($status,$id)
        {
                return $this->db->where(array('status'=>$status,'attendance_id' => $id))->get('class_attendance_list')->result();
        }

        function count_present($id)
        {
                return $this->db->where(array('attendance_id' => $id, 'status' => 'Present'))->get('class_attendance_list')->num_rows();
        }

        function count_absent($id)
        {
                return $this->db->where(array('attendance_id' => $id, 'status' => 'Absent'))->get('class_attendance_list')->num_rows();
        }

        function exists($id)
        {
                return $this->db->where(array('id' => $id))->count_all_results('class_attendance') > 0;
        }

        function count()
        {
                return $this->db->count_all_results('class_attendance');
        }

        function update_attributes($id, $data)
        {
                return $this->db->where('id', $id)->update('class_attendance', $data);
        }

        /**
         * update_list
         * 
         * @param type $id attendance_id
         * @param type $student
         * @param type $data
         * @return type
         */
        function update_list($id, $student, $data)
        {
                return $this->db->where('attendance_id', $id)->where('student', $student)->update('class_attendance_list', $data);
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
                return $this->db->delete('class_attendance', array('id' => $id));
        }

        function delete_list($id)
        {
                return $this->db->delete('class_attendance_list', array('attendance_id' => $id));
        }

        //Count records to be deleted
        function count_del($id)
        {
                return $this->db->where('attendance_id', $id)->count_all_results('class_attendance_list');
        }

        function get_class_stream()
        {
                return $this->db->select('classes.*')->order_by('class', 'DESC')->get('classes')->result();
        }

        /**
         * get_attendance 
         * 
         * @param int $student
         * @param int $month
         * @param int $year
         * @return type
         */
		 
		 function stud_get_trend($month,$year,$student)
        {
             $this->db->order_by('class_attendance.id','desc');
			 return $this->db->select('class_attendance_list.id,class_attendance_list.attendance_id,class_attendance_list.student,class_attendance_list.status,class_attendance_list.remarks,class_attendance.id,class_attendance.attendance_date,class_attendance.title')
			 
			->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
			->where(array('class_attendance_list.student' => $student))
			->where('MONTH(FROM_UNIXTIME(attendance_date))', $month)
            ->where('YEAR(FROM_UNIXTIME(attendance_date))', $year)
			->get('class_attendance_list')
			->result();
        }
       	
	function stud_get_trend_($student)
        {
             $this->db->order_by('class_attendance.id','desc');
			 return $this->db->select('class_attendance_list.id,class_attendance_list.attendance_id,class_attendance_list.student,class_attendance_list.status,class_attendance_list.remarks,class_attendance.id,class_attendance.attendance_date,class_attendance.title')
			 
			->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
			->where(array('class_attendance_list.student' => $student))
			//->where('MONTH(FROM_UNIXTIME(attendance_date))', $month)
            //->where('YEAR(FROM_UNIXTIME(attendance_date))', $year)
			//->limit(1)
			->get('class_attendance_list')
			->result();
        }

		/**
         * get_attendance 
         * 
         * @param int $student
         * @param int $month
         * @param int $year
         * @return type
         */
        function get_attendance($student, $month, $year)
        {
                $list = $this->db->select('attendance_date,DAY(FROM_UNIXTIME(attendance_date)) as day, class_attendance_list.status')
                             ->where('student', $student)
                             ->where('MONTH(FROM_UNIXTIME(attendance_date))', $month)
                             ->where('YEAR(FROM_UNIXTIME(attendance_date))', $year)
                             ->join('class_attendance', 'attendance_id = class_attendance.id')
                             ->get('class_attendance_list')
                             ->result();
                $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                $found = array();
                foreach ($list as $r)
                {
                        $found[$r->day] = $r->status == 'Present' ? 1 : 0;
                }

                for ($i = 1; $i <= $days_in_month; $i++)
                {
                        if (!array_key_exists($i, $found))
                        {
                                $found[$i] = 3; //not recorded
                                //$found[$i] = 0;
                        }
                }
                ksort($found);

                return $found;
        }

        function paginate_all($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get('class_attendance', $limit, $offset);
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

        //Teacher's Class
        function my_class($limit, $page)
        {
                $offset = $limit * ( $page - 1);
                $u = $this->ion_auth->get_user()->id;
                $cls = $this->db->where('class_teacher', $u)->get('classes')->row();
                $the_class = 0;
                if (!empty($cls->id))
                {
                        $the_class = $cls->id;
                }
                $this->db->where('id', $the_class);
                $this->db->order_by('class', 'desc');
                $query = $this->db->get('class_attendance', $limit, $offset);
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

        public function filter_attendances(){
                $this->select_all_key('admission');
                
                return $this->db
                             -> select('class_attendance.*')
                             ->select('class_attendance_list.*')
                             ->order_by('class_attendance_list.id','DESC')
                            ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
                            ->join('admission','admission.id=class_attendance_list.student')
                            ->get('class_attendance_list')
                            ->result();
        }

        public function filtering_attendance($date, $title){
                $this->select_all_key('admission');
                
                return $this->db
                             ->select('class_attendance.*')
                             ->select('class_attendance_list.*')
                             ->group_by('class_attendance.class_id')
                            ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
                            ->join('admission','admission.id=class_attendance_list.student')
                             ->where('class_attendance.attendance_date',$date)
                             ->where('class_attendance.title',$title)
                            ->get('class_attendance_list')
                            ->result();
        }

        public function filtering_attendance_by_status($date, $title, $status){
                $this->select_all_key('admission');
                return $this->db
                             -> select('class_attendance.*')
                             ->select('class_attendance_list.*')
                             ->group_by('class_attendance.class_id')
                            ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
                            ->join('admission','admission.id=class_attendance_list.student')
                             ->where('class_attendance.attendance_date',$date)
                        //      ->where("(class_attendance.title='$title' OR class_attendance_list.status='$status')", NULL, FALSE)
                             ->where('class_attendance.title',$title)
                             ->where('class_attendance_list.status',$status)
                            ->get('class_attendance_list')
                            ->result();
        }


        public function view_attendance($class, $date, $title){
                $ti = '%20';
                $trimmed = str_replace($ti, ' ', $title) ;
                $this->select_all_key('admission');
                return $this->db
                             ->select('class_attendance.*')
                             ->select('class_attendance_list.*')
                            ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
                            ->join('admission','admission.id=class_attendance_list.student')
                             ->where('class_attendance.attendance_date',$date)
                             ->where('class_attendance.title',$trimmed)
                             ->where('class_attendance.class_id',$class)
                            ->get('class_attendance_list')
                            ->result();
        }


        public function view_attendances_($class,$date, $title, $status){
                $ti = '%20';
                $trimmed = str_replace($ti, ' ', $title) ;
                $this->select_all_key('admission');
                return $this->db
                             -> select('class_attendance.*')
                             ->select('class_attendance_list.*')
                            ->join('class_attendance','class_attendance.id=class_attendance_list.attendance_id')
                            ->join('admission','admission.id=class_attendance_list.student')
                             ->where('class_attendance.attendance_date',$date)
                             ->where('class_attendance.title',$trimmed)
                             ->where('class_attendance_list.status',$status)
                             ->where('class_attendance.class_id',$class)
                            ->get('class_attendance_list')
                            ->result();
        }

}
