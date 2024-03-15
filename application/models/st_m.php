<?php

class St_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
               
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
	
	
    function student_final_exam($stud)
    {
		  $this->db->order_by('created_on','DESC');
        return $this->db->where(array('student' => $stud))->get('final_exams_certificates')->row();
    }
	
	function get_class_rep($id){
		
		 return $this->db->where(array('id' => $id))->get('classes')->row();
		 
	}
	
	
	function count_attendance($type,$id){
		
		 return $this->db->where(array('status' => $type,'student'=>$id))->count_all_results('class_attendance_list');
		 
	}
	
	
	function count_borrowed_books($id){
		
		 return $this->db->where(array('student'=>$id))->count_all_results('borrow_book');
		 
	}
	
	function count_unecrypted($table,$field,$id,$status=NULL){
		
		 if($status !=NULL)
		 
		 return $this->db->where(array($field=>$id,'status'=>$status))->count_all_results($table);
		 
		 else
		 
		  return $this->db->where(array($field=>$id))->count_all_results($table);
		 
	}
	
	
	
	
	
	function count_rows_unenc($table){

		  return $this->db->count_all_results($table);
		 
	}
	
	function get_unenc_erecords($subject,$class,$table){

		  return $this->db->order_by('id','desc')->where(array('status'=>1,'subject'=>$subject,'class'=>$class))->get($table)->result();
		 
	}
	
	function count_educators($class){

		  $res =  $this->db->group_by('teacher')->where('class', $class)->get('subjects_assign')->result();
		 return count($res);
	}
	
	
	function get_educators($class){

		  $res =  $this->db->group_by('teacher')->where('class', $class)->get('subjects_assign')->result();
		 return $res;
	}
	
	function get_per_subject($class,$subject){

		  $res =  $this->db->where(array('level'=>$class,'subject'=>$subject,'status' => 1))->get('evideos')->result();
		  return $res;
	}
	
	 function get_last_video($level,$sub)
     {
		 
        return $this->db->order_by('id','desc')->where(array('subject' => $sub,'level' => $level,'status' => 1))->get('evideos')->row();
     }

	 function get_video_comments($id,$type)
     {
		 
        return $this->db->order_by('id','asc')->where(array('video_id' => $id,'status' => 1,'type' => $type))->get('evideo_comments')->result();
     }

	 function get_last_gvideo()
     {
        return $this->db->order_by('id','desc')->where(array('status' => 1))->get('general_evideos')->row();
     }

	
	
	function get_level_pp($class){
        
		 $cl = $this->db->where('id',$class)->get('classes')->row();
		 $res =  $this->db->where('class', $cl->class)->get('past_papers')->result();
		 return $res;
	}
	
	function count_evideos($class){
        
		 $cl = $this->db->where('id',$class)->get('classes')->row();
		 $level =  $this->db->where('status', 1)->where('level', $class)->count_all_results('evideos');
		 $gen =  $this->db->where('status', 1)->count_all_results('general_evideos');
		 
		 return $level+$gen;
	}

	function count_enotes($class){
        
		return  $this->db->where('status', 1)->where('class', $class)->count_all_results('enotes');
		 
	}
	
	function count_general_evideos(){

		 return $this->db->where('status', 1)->count_all_results('general_evideos');

	}
	
	function get_general_evideos(){

		return $this->db->order_by('id','desc')->where('status', 1)->get('general_evideos')->result();

	}
	
	function find_general_vid($id){

		 return $this->db->where('id', $id)->where('status', 1)->get('general_evideos')->row();

	}
	
	function count_video_files($class,$subject){
		
		 $res =  $this->db->where(array('level'=>$class,'subject'=>$subject,'status'=>1))->count_all_results('evideos');
		 return $res;
	}
	
	function count_files($field,$class,$subject,$table){
		
		 $res =  $this->db->where(array($field=>$class,'subject'=>$subject,'status'=>1))->count_all_results($table);
		 return $res;
	}
	
	
	
	function count_done_exams($st){

		  $res =  $this->db->group_by('exams_id')->where('student', $st)->get('exams_management_list')->result();
		  return count($res);
	}
	
			function st_national_exams($st){


			 $recs =  $this->db	
					->order_by('id','asc')
					->where('student',$st)
				     ->get('final_exams_certificates')
				     ->result();
			return $recs;
   
			
		}
		
		function st_other_certificates($st){


			 $recs =  $this->db	
					->order_by('id','asc')
					->where('student',$st)
				     ->get('students_certificates')
				     ->result();

			return $recs;
   
			
		}
	
	function done_cbc($st){

		  $res =  $this->db->where('student', $st)->get('cbc_summ')->result();
		  return count($res);
	}
	
	function count_returned_books($id){
		
		 return $this->db->where(array('student'=>$id))->count_all_results('return_book');
		 
	}
	
	function student_receipts(){
			
			
				 
			 $this->select_all_key('fee_payment');	
			 $this->db->where($this->dx('status') . '=1', NULL, FALSE);
		     $this->db->where($this->dx('reg_no') . '='.$this->student->id, NULL, FALSE);
			 
			 $rec =  $this->db	
					->order_by('payment_date','desc')
				   ->get('fee_payment')
				   ->result();
				  
         //print_r($rec);die;

			return $rec;
   
			
		}
	
	
	function count_assignments($class,$date){
		
		 return $this->db->where(array('class' => $class))->where('created_on >='.$date)->count_all_results('assignment_list');
		 
	}	
	
	function count_cbc_subjects($class){
		
		$cbc = $this->db->where(array('class_id' => $class))->count_all_results('cbc');
		$subs = $this->db->where(array('class_id' => $class))->count_all_results('subjects_classes');
		
		return $cbc+$subs;
		 
	}
	
    function get_cbc_sub($class){
		
		 return $this->db->where(array('class_id' => $class))->get('cbc')->result();
	}

	function get_strands($subject){
		
		 return $this->db->where(array('subject' => $subject))->get('cbc_la')->result();
	}
	
	function get_sub_strands($strand){
		
		 return $this->db->where(array('strand' => $strand))->get('cbc_topics')->result();
	}


    function get_cbc_topics($tp){
		
		 return $this->db->where(array('topic' => $tp))->get('cbc_tasks')->result();
	}

    function get_subjects($class){
		
		 return $this->db->group_by('term')->where(array('class_id' => $class))->get('subjects_classes')->result();
	}		
	
	
	function get_term_subjects($class,$term){
		
		 return $this->db->where(array('class_id' => $class,'term'=>$term))->get('subjects_classes')->result();
	}	
	
	function get_done_assgn($student,$id){
		
		 return $this->db->where(array('student' => $student,'assignment'=>$id))->get('assignments_done')->row();
	}		
	
	function class_assignments($class,$date,$limit=NULL){

		 $this->db->order_by('assignment_list.created_on','desc');
		 
		 if($limit){
			 $this->db->limit($limit);
		 }
		 
		 $res =  $this->db->select('assignment_list.assgn_id,assignment_list.class,assignment_list.created_on,assignments.*')
					->join('assignments','assignment_list.assgn_id = assignments.id')
					->where('assignment_list.class', $class)
					->where('assignment_list.created_on >='.$date)	
					->get('assignment_list')
					->result();
					
					//print_r($res);die;
					
					if(!empty($res))
							return $res;
						else
							return false;
						
								 
	}	
	
	function count_exams($date){
		
		 return $this->db->where('created_on >='.$date)->count_all_results('exams');
		 
	}

	function all_exams($date,$limit){
		 $this->db->order_by('created_on','desc');
		 return $this->db->where('created_on >='.$date)->limit($limit)->get('exams')->result();
		 
	}	
	
    function student_pledges($stud)
    {
		  $this->db->order_by('created_on','DESC');
        return $this->db->where(array('student' => $stud))->get('fee_pledge')->result();
    }

      function passport($id)
        {
                return $this->db->where(array('id' => $id))->get('passports')->row();
        }


 function hostels()
		{
			return $this->db
						->where(array('student' => $this->student->id))
						->order_by('id','DESC')
						->get('assign_bed')
						->result();
		 }


		function loan_statement()
		{
			return $this->db
						->where(array('member' => $this->student->id))
						->order_by('id','asc')
						->get('loans_tracker')
						->result();
		 }
		
	  /**
         * Datatable Server Side Data Fetcher
         * 
         * @param int $iDisplayStart
         * @param int $iDisplayLength
         * @param type $iSortCol_0
         * @param int $iSortingCols
         * @param string $sSearch
         * @param int $sEcho
         */
        function get_datatable($iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho)
        {
                $aColumns = $this->db->list_fields('fee_payment');

                // Paging
                if (isset($iDisplayStart) && $iDisplayLength != '-1')
                {
                        $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
                }

                // Ordering
                if (isset($iSortCol_0))
                {
                        for ($i = 0; $i < intval($iSortingCols); $i++)
                        {
                                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                                if ($bSortable == 'true')
                                {
                                        if ($aColumns[$i] == 'reg_no')
                                        {
                                                $this->db->join('admission', 'reg_no=admission.id');
                                                $this->db->order_by('CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1') ", $this->db->escape_str($sSortDir), FALSE);
                                        }
                                        else
                                        {
                                                $this->db->_protect_identifiers = FALSE;
                                                $this->db->order_by('fee_payment.' . $aColumns[intval($this->db->escape_str($iSortCol))], $this->db->escape_str($sSortDir), FALSE);
                                                $this->db->_protect_identifiers = TRUE;
                                        }
                                }
                        }
                }

                /*
                 * Filtering
                 * NOTE this does not match the built-in DataTables filtering which does it
                 * word by word on any field. It's possible to do here, but concerned about efficiency
                 * on very large tables, and MySQL's regex functionality is very limited
                 */
                if (isset($sSearch) && !empty($sSearch))
                {
                        $where = '';
                        for ($i = 0; $i < count($aColumns); $i++)
                        {
                                $bSearchable = $this->input->get_post('bSearchable_' . $i, true);

                                // Individual column filtering
                                if (isset($bSearchable) && $bSearchable == 'true')
                                {
                                        $sSearch = $this->db->escape_like_str($sSearch);
                                        if ($aColumns[$i] == 'reg_no')
                                        {
                                                $this->db->join('admission', $this->dx('reg_no') . '=admission.id');
                                                $where = ' CONVERT(' . $this->dx('admission.first_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                                                $where .= ' CONVERT(' . $this->dx('admission.last_name') . " USING 'latin1') LIKE '%" . $sSearch . "%'  OR ";
                                                $where .= ' CONVERT(CONCAT(' . $this->dx('admission.first_name') . '," ",' . $this->dx('admission.last_name') . ')' . " USING 'latin1')  LIKE '%" . $sSearch . "%'  ";
                                        }
                                        else
                                        {
                                                $where .= 'OR CONVERT(' . $this->dx('fee_payment.' . $aColumns[$i]) . " USING 'latin1') LIKE '%" . $sSearch . "%'  ";
                                        }
                                        //$sSearch = $this->db->escape_like_str($sSearch);
                                        // $this->db->or_like('CONVERT(' . $this->dx('fee_payment.' . $aColumns[$i]) . " USING 'latin1') ", $sSearch, 'both', FALSE);
                                }
                        }
                        if (isset($where) && !empty($where))
                        {
                                $this->db->where('(' . $where . ')', NULL, FALSE);
                        }
                }

                // Select Data
                $this->db->select(' SQL_CALC_FOUND_ROWS now()', FALSE);
                $this->select_all_key('fee_payment');
                $this->db->where($this->dx('fee_payment.status') . ' = 1', NULL, FALSE);
               // $this->db->where($this->dx('fee_payment.reg_no') . ' = '.$this->student->id, NULL, FALSE);
                $this->db->order_by($this->dx('payment_date'), 'DESC', false);
                $rResult = $this->db->get('fee_payment');

                // Data set length after filtering
                $this->db->select('FOUND_ROWS() AS found_rows ');
                $iFilteredTotal = $this->db->get()->row()->found_rows;

                // Total data set length
                $iTotal = $this->db->where($this->dx('fee_payment.status') . ' = 1', NULL, FALSE)->count_all_results('fee_payment');

                // Output
                $output = array(
                    'sEcho' => intval($sEcho),
                    'iTotalRecords' => $iTotal,
                    'iTotalDisplayRecords' => $iFilteredTotal,
                    'aaData' => array()
                );

                $aaData = array();
                $obData = array();
                foreach ($rResult->result_array() as $aRow)
                {
                        $row = array();

                        foreach ($aRow as $Key => $Value)
                        {
                                if ($Key && $Key !== ' ')
                                {
                                        $row[$Key] = $Value;
                                }
                        }
                        $obData[] = $row;
                }
                $classes = $this->ion_auth->list_classes();
                $bank = $this->fee_payment_m->list_banks();
                $streams = $this->ion_auth->get_stream();
                $extras = $this->all_fee_extras();

                foreach ($obData as $iCol)
                {
                        $iCol = (object) $iCol;

                        $bk = isset($bank[$iCol->bank_id]) ? $bank[$iCol->bank_id] : ' - ';
                        $ccc = $this->get_student($iCol->reg_no);
                        $std = '';
                        if (!empty($ccc))
                        {
                                $stud = $ccc->first_name . ' ' . $ccc->last_name;
                                $std = isset($stud) ? $stud : ' ';
                        }
                        if (!isset($ccc->class))
                        {
                                $sft = ' - ';
                                $st = ' - ';
                        }
                        else
                        {
                                $crow = $this->portal_m->fetch_class($ccc->class);
                                if (!$crow)
                                {
                                        $sft = ' - ';
                                        $st = ' - ';
                                }
                                else
                                {
                                        $ct = isset($classes[$crow->class]) ? $classes[$crow->class] : ' - ';
                                        $sft = isset($classes[$crow->class]) ? class_to_short($ct) : ' - ';
                                        $st = isset($streams[$crow->stream]) ? $streams[$crow->stream] : ' - ';
                                }
                        }

                        if ($iCol->description == 0)
                                $desc = 'Tuition Fee Payment';
                        elseif (is_numeric($iCol->description))
                                $desc = $extras[$iCol->description];
                        else
                                $desc = $iCol->description;

                        $aaData[] = array(
                            $iCol->id,
                            $iCol->payment_date ? date('d M Y ', $iCol->payment_date) : ' ',
                            $std . ' ' . $sft . ' ' . $st,
                            $iCol->amount > 0 ? number_format($iCol->amount, 2) : $iCol->amount,
                            $bk,
                            $iCol->payment_method,
                            $desc,
                            $iCol->receipt_id
                        );
                }
                $output['aaData'] = $aaData;

                return $output;
        }


   function student_sms()
        {
             
			  
                $country_code = '254';
                $studp = $this->student->student_phone;
                $parop = $this->student->phone;

                $student_phone = substr_replace($studp, $country_code, 0, ($studp[0] == '0'));
                $parent_phone = substr_replace($parop, $country_code, 0, ($parop[0] == '0'));
               
			   
                $this->db->order_by('id', 'desc');
				$this->select_all_key('text_log');
                $stud = $this->db->where($this->dx('dest') . '=' . $student_phone, NULL, FALSE)->get('text_log')->result(); 
				
				$this->select_all_key('text_log');
                $paro = $this->db->where($this->dx('dest') . '='.$parent_phone , NULL, FALSE)->get('text_log')->result();
				
				//print_r($paro);die;
				
				return $stud+$paro;
        }
		
		
  function get_diary($limit, $page)
    {
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
        $this->db->where('student', $this->student->id);
        $query = $this->db->get('diary', $limit, $offset);

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

    function get_extra_diary($limit, $page)
    {
        $activities = $this->populate('activities', 'id', 'name');
        $offset = $limit * ( $page - 1);

        $this->db->order_by('id', 'desc');
		 $this->db->where('student', $this->student->id);
        $query = $this->db->get('diary_extra', $limit, $offset);

        $result = array();

        foreach ($query->result() as $row)
        {
            $name = isset($activities[$row->activity]) ? $activities[$row->activity] : ' - ';
            $row->activity = $name;
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
		
			
	//****** MC QUASTIONS *****
		
    		
		function mc_count_qstns($id)
        {
			
            return $this->db->where(array('mc'=>$id))->count_all_results('mc_questions');
			
        }
		
		function get_post($id,$stud)
        {
			
            return $this->db->order_by('created_on','asc')->where(array('student'=>$stud,'mc_id'=>$id))->get('mc_answers')->row();
			
        }
		
		function get_qa_post($id,$stud)
        {
			
            return $this->db->order_by('created_on','asc')->where(array('student'=>$stud,'qa_id'=>$id))->get('qa_answers')->row();
			
        }
		
		
		function mc_correct_mc($id)
        {
			
            return $this->db->where(array('question_id'=>$id,'state'=>1))->get('mc_choices')->row();
			
        }

		function mc_count_done($id,$stud)
        {
			
            return $this->db->where(array('student'=>$stud,'mc_id'=>$id))->count_all_results('mc_answers');
			
        }
		
		function qa_count_done($id,$stud)
        {
			
            return $this->db->where(array('student'=>$stud,'qa_id'=>$id))->count_all_results('qa_answers');
			
        }
		
		function qa_correct($id,$stud)
        {
			
            return $this->db->where(array('student'=>$stud,'qa_id'=>$id,'state'=>1))->count_all_results('qa_answers');
			
        }
		
		function qa_wrong($id,$stud)
        {
			
            return $this->db->where(array('student'=>$stud,'qa_id'=>$id,'state'=>0))->count_all_results('qa_answers');
			
        }
		
		 
		 function sum_qa_points($id){
			 
			$rec = $this->db->select('sum(marks) as marks')->where(array('qa' => $id))->get('qa_questions')->row();
			
			return $rec->marks;
		 }

		 function sum_awarded_points($id,$stud){
			 
			$rec = $this->db->select('sum(points) as points')->where(array('student'=>$stud,'qa_id'=>$id))->get('qa_answers')->row();
			
			return $rec->points;
		 }
		
		
		
		function mc_get_post($id,$stud)
        {
			
            return $this->db->order_by('created_on','asc')->where(array('student'=>$stud,'mc_id'=>$id))->get('mc_answers')->row();
			
        }
		function mc_correct($id,$stud)
        {
			
            return $this->db->where(array('student'=>$stud,'mc_id'=>$id,'state'=>1))->count_all_results('mc_answers');
			
        }
		function mc_wrong($id,$stud)
        {
			
            return $this->db->where(array('student'=>$stud,'mc_id'=>$id,'state'=>0))->count_all_results('mc_answers');
			
        }
		
		function count_qstns($id)
        {
			
            return $this->db->where(array('mc'=>$id))->count_all_results('mc_questions');
			
        }
		
		function count_qa_qstns($id)
        {
			
            return $this->db->where(array('qa'=>$id))->count_all_results('qa_questions');
			
        }
		
	

		function count_done($id,$stud)
        {
			
            return $this->db->where(array('student'=>$stud,'mc_id'=>$id))->count_all_results('mc_answers');
			
        }
		
				
	function get_mc_answers($id,$stud,$order)
        {
			$this->db->order_by('question_id',$order);
            return $this->db->where(array('student'=>$stud,'mc_id'=>$id))->get('mc_answers')->result();
			
        }
		
		function get_qa_answers($id,$stud,$order)
        {
			$this->db->order_by('question',$order);
            return $this->db->where(array('student'=>$stud,'qa_id'=>$id))->get('qa_answers')->result();
			
        }
		
		function get_mc_ans($stud,$mc_id,$question)
        {

            return $this->db->where(array('student'=>$stud,'mc_id'=>$mc_id,'question_id'=>$question))->get('mc_answers')->row();
			
        }
		
		function get_qa_ans($stud,$qa_id,$question)
        {

            return $this->db->where(array('student'=>$stud,'qa_id'=>$qa_id,'question'=>$question))->get('qa_answers')->row();
			
        }
		
		function mc_answers_checker($stud,$mc_id)
        {

            return $this->db->where(array('student'=>$stud,'mc_id'=>$mc_id))->get('mc_answers')->result();
			
        }
		
	  function get_choices($id)
        {
			$this->db->order_by('id','asc');
            return $this->db->where(array('question_id'=>$id))->get('mc_choices')->result();
			
        }
		
		function mc_done($student,$mc)
        {
                return $this->db->where(array('student' => $student,'mc_id'=>$mc,'done'=>1))->get('mc_given')->row();
        }
		
		function qa_done($student,$qa)
        {
                return $this->db->where(array('student' => $student,'qa_id'=>$mc,'done'=>1))->get('qa_given')->row();
        }
		
		 function delete_notification($student, $item, $type)
        {
                return $this->db->delete('assignments_tracker', array('student' => $student,'item_id'=>$item,'type'=>$type));
        }

		
	function correct_mc($id)
        {
			
            return $this->db->where(array('question_id'=>$id,'state'=>1))->get('mc_choices')->row();
			
        }
		
	function get_mc_comment($mc_id, $student)
        {
			
            return $this->db->where(array('mc_id'=>$mc_id,'student'=>$student))->get('mc_teacher_remarks')->row();
			
        }

   
		

		
}






