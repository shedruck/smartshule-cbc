<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    /**
     * Class Constructor
     */
    function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }

        $this->load->model('reports_m');
        $this->load->model('exams/exams_m');
    }

    /**
     * activities
     * 
     */
    public function activities()
    {
        $act = $this->input->post('act');
        $yr = $this->input->post('year');
        $term = $this->input->post('term');
        $class = $this->input->post('class');

        if (!$yr)
        {
            $yr = date('Y');
        }
        if (!$term)
        {
            $term = get_term(date('m'));
        }
        $roster = [];
        if ($this->input->post())
        {
            $roster = $this->reports_m->get_by_activity($act, $class, $term, $yr);
        }

        $range = range(date('Y') - 15, date('Y'));
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['class'] = $class;
        $data['yr'] = $yr;
        $data['term'] = $term;
        $data['roster'] = $roster;
        $data['list'] = $this->admission_m->populate('activities', 'id', 'name');
        //load view
        $this->template->title('Extra Curricular Activites')->build('admin/activities', $data);
    }
	
	
		public function export_waivers()
        {
			    $this->load->model('fee_waivers/fee_waivers_m');
                $range = range(date('Y') - 7, date('Y') + 1);
				$yrs = array_combine($range, $range);
				krsort($yrs);
				$data['yrs'] = $yrs;
				
				 $yr = $this->input->post('year');
				 $term = $this->input->post('term');
				
					
					if (!$yr)
					{
						$yr = date('Y');
					}
					if (!$term)
					{
						$set = $this->ion_auth->settings();
						$term = $set->term;
					}

                $data['fee_waivers'] = $this->fee_waivers_m->get_all($yr,$term);
				$data['yr'] = $yr;
				$data['term'] = $term;

                //load view
                $this->template->title(' Fee Waivers ')->set_layout('export')->build('admin/fee_waivers', $data);
        }

    public function index()
    {
        redirect('admin/reports/fee');
        $data[''] = '';
        //load view
        $this->template->title('Reports')->build('admin/hm_stats', $data);
    }
	

	
	
    /**
     * sales_ledger Report
     */
    function sales_ledger()
    {
        $option = $this->input->post('mode');
        $date = $this->input->post('date');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $exp = $this->input->post('export');

        $post = [];
        if ($option == 2 && !$year)
        {
            $year = date('Y');
        }
        if ($this->input->post())
        {
            switch ($option)
            {
                case 1:
                    $post = $this->reports_m->get_daily_invoices($date, $exp);
                    break;
                case 2:
                    $post = $this->reports_m->get_monthly_invoices($month, $year, $exp);
                    break;
                case 3:
                    $post = $this->reports_m->get_range_invoices($from, $to, $exp);
                    break;

                default:
                    $post = [];
                    break;
            }

            if ($this->input->post('export'))
            {
                return $this->export_invoices($post, $option, $date, $month, $year, $from, $to);
            }
        }
        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;

        $data['months'] = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
        $data['post'] = $post;
        $data['year'] = $year;
        //load view
        $this->template->title('Income/Fee Report')->build('admin/income', $data);
    }

    function export_invoices($post, $option, $date, $month, $year, $from, $to)
    {
        $this->load->library('EXLS');
        $months = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];

        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $spreadsheet->getProperties()
                          ->setCreator("smartshule.com")
                          ->setLastModifiedBy("user")
                          ->setTitle("Office 2007 XLSX  Document")
                          ->setSubject("Office 2007 XLSX  Document")
                          ->setDescription("Document for Office 2007 .")
                          ->setKeywords("office 2007 openxml php")
                          ->setCategory("Excel Reports");

        $index = 0;
        $spreadsheet->setActiveSheetIndex(0)->setTitle('SALES LEDGER');

        $spreadsheet->setActiveSheetIndex($index);
        $sheet = $spreadsheet->getActiveSheet();

        if ($option == 1)
        {
            $a_date = $date ? date('d M Y', strtotime($date)) : ' - ';
            $title = 'Sales Ledger - Date: ' . $a_date;
        }
        if ($this->input->post('mode') == 2)
        {
            $mt = $month ? $months[$month] : ' - ';
            $title = 'Sales Ledger - Month: ' . $mt . ' ' . $year;
        }
        if ($this->input->post('mode') == 3)
        {
            $frr = $from ? date('d M Y', strtotime($from)) : ' - ';
            $to__ = $to ? date('d M Y', strtotime($to)) : ' - ';
            $title = 'Sales Ledger - Date Range: ' . $frr . ' - ' . $to__ . ' ';
        }
        $sheet->setCellValue('B2', $title);
        $spreadsheet->getActiveSheet()->mergeCells('B2:G2');
        $spreadsheet->getActiveSheet()->getStyle('B2:G2')
                          ->getFont()->setSize(15)->getColor()
                          ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);

        $sheet->setCellValue('A4', 'Name');
        $sheet->setCellValue('B4', 'Class');
        $sheet->setCellValue('C4', 'Adm. No.');
        $sheet->setCellValue('D4', 'Tuition Fee');

        $w = 'D';
        $w_map = [];
        foreach ($post->map as $c_id => $c_title)
        {
            $w++;
            $w_map[$c_id] = $w;
            $sheet->setCellValue($w . '4', $c_title);
            $sheet->getColumnDimension($w)->setAutoSize(true);
        }

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $sheet->getStyle('A4:' . $w . '4')
                          ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A4:' . $w . '4')->applyFromArray(
                          [
                              'font' => [
                                  'size' => 11,
                                  'name' => 'Arial',
                                  'bold' => true
                              ]
                          ]
        );
        $styles = [
            'font' => [
                'size' => 11,
                'name' => 'Arial'
        ]];
        $i = 5;
        foreach ($post->post as $p => $fees)
        {
            $st = $this->worker->get_student($p);

            $sheet->getStyle('A' . $i . ':Z' . $i)->applyFromArray($styles);

            $sheet->SetCellValue('A' . $i, $st->first_name . ' ' . $st->last_name);
            $sheet->SetCellValue('B' . $i, $st->cl->name);
            $sheet->SetCellValue('C' . $i, $st->old_adm_no ? $st->old_adm_no : $st->admission_number);

            foreach ($fees as $f)
            {
                if ($f->cat == 'extras')
                {
                    continue;
                }
                $sheet->SetCellValue('D' . $i, number_format($f->amount, 2));
                break;
            }
            foreach ($fees as $f)
            {
                if ($f->cat == 'tuition')
                {
                    continue;
                }
                $t = $w_map[$f->fee_id];
                $sheet->setCellValue($t . $i, number_format($f->amount, 2));
            }

            $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Sales_ledger' . date('d_m_H:i:s') . '.xls" ');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
	

    /**
     * Load student report
     *
     */
    function student_report($id = Null)
    {
        
		$st= $this->input->post('student');
		
		if(!empty($st)){
			$id = $st;
		}
		//redirect if no $id
		
		if($id){
      

        $this->load->model('admission/admission_m');

        if (!$this->admission_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/admission');
        }



        $this->load->model('borrow_book_fund/borrow_book_fund_m');
        $this->load->model('borrow_book/borrow_book_m');
        $this->load->model('medical_records/medical_records_m');
        $this->load->model('fee_payment/fee_payment_m');
        $this->load->model('fee_waivers/fee_waivers_m');
        $this->load->model('assign_bed/assign_bed_m');
        $this->load->model('hostel_beds/hostel_beds_m');
        $this->load->model('students_placement/students_placement_m');
        $this->load->model('disciplinary/disciplinary_m');

        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        if (!$this->admission_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/reports/student_report');
        }
        $stud = $this->admission_m->find($id);
        $data['passport'] = $this->admission_m->passport($stud->photo);
        $student = $this->admission_m->find($id);
        $data['student'] = $student;

        $parent_id = $this->admission_m->find($id);
        $data['parent_details'] = $this->admission_m->get_parent($parent_id->parent_id);
        $data['cl'] = $this->admission_m->fetch_class($parent_id->class);
        $data['title'] = 'Fee Statement';

        $data['em_cont'] = $this->admission_m->get_emergency_contacts($id);
        $data['extra_c'] = $this->reports_m->get_extras($id);
        $data['other_certs'] = $this->reports_m->other_certs($id);
        $data['national_exams'] = $this->reports_m->national_exams($id);

        $data['p'] = $this->fee_payment_m->get_receipts($id);
        //Beds
        $data['bed'] = $this->assign_bed_m->get($id);
        $data['beds'] = $this->assign_bed_m->get_hostel_beds();
        //Placement position
        $data['position'] = $this->students_placement_m->get($id);
        $data['st_pos'] = $this->students_placement_m->get_positions();
        //Exams Results
        $exams = []; //$this->exams_management_m->get_by_student($id);

        $data['exams'] = $exams;
        //Exams Type
        $data['type'] = $this->admission_m->populate('exams', 'id', 'year');
        $data['term'] = $this->admission_m->populate('exams', 'id', 'term');
        $data['type_details'] = $this->admission_m->populate('exams', 'id', 'title');

        //Disciplinary
        $data['disciplinary'] = $this->disciplinary_m->get($id);
        //Medical Records
        $data['medical'] = $this->medical_records_m->by_student($id);

        $tm = get_term(date('m'));
        $data['waiver'] = $this->admission_m->get_waiver($id, $tm);
        //Transport Details
        $data['transport'] = []; //$this->assign_transport_facility_m->get($id);
        $data['transport_facility'] = []; // $this->assign_transport_facility_m->get_transport_facility();
        $data['amt'] = $this->admission_m->total_fees($student->class);
        $data['post'] = $this->fee_payment_m->get_row($id);
        $data['banks'] = $this->fee_payment_m->banks();
        $this->worker->calc_balance($id);
        // $data['paid'] = $this->fee_payment_m->fetch_balance($student->id);
        $data['fee'] = $this->fee_payment_m->fetch_balance($student->id);
        $data['paro'] = $this->admission_m->get_paro($stud->parent_id);

        //Book Fund
        $data['books'] = $this->reports_m->populate('book_fund', 'id', 'title');
        $data['student_books'] = $this->borrow_book_fund_m->by_student($id);

        // Library Books
        $data['lib_books'] = $this->reports_m->populate('books', 'id', 'title');
        $data['borrowed_books'] = $this->borrow_book_m->by_student($id);

        $data['class_history'] = $this->reports_m->class_history($id);

        $data['classes_groups'] = $this->reports_m->populate('class_groups', 'id', 'name');
        $data['classes'] = $this->reports_m->populate('classes', 'id', 'class');
        $data['class_str'] = $this->reports_m->populate('classes', 'id', 'stream');
        $data['stream_name'] = $this->reports_m->populate('class_stream', 'id', 'name');

        $data['days_present'] = $this->reports_m->days_present($id);
        $data['days_absent'] = $this->reports_m->days_absent($id);
		
		$data['favourite_hobbies'] = $this->portal_m->get_unenc_result('student',$id,'favourite_hobbies');
		
		}
		
		$data['st'] = '';
		
        $this->template->title('View Student')->build('admin/student_report', $data);
    }

    /**
     * Admission Report
     */
    function school_population()
    {
       
        $data['adm'] = $this->reports_m->fetch_school_population();
		$data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
        //load view
        $this->template->title('School Population Report ')->build('admin/population', $data);
    }

	/**
     * Admission Report
     */
    function admission()
    {
        $class = $this->input->post('class');
        $year = $this->input->post('year');
        $new = $this->input->post('new');
        $cols = [];
        if (!$year)
        {
            $year = date('Y');
        }
        if ($this->input->post())
        {
            $cols = $this->input->post('cols');
        }
        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['str_opts'] = $this->reports_m->populate('class_stream', 'id', 'name');
        $data['year'] = $year;
        $data['class'] = $class;
        $data['cols'] = $cols;
        $data['houses'] = $this->reports_m->populate('house', 'id', 'name');
        $data['adm'] = $this->reports_m->fetch_adm_history($class, $year);
        //load view
        $this->template->title('Admission Report ')->build('admin/adm', $data);
    }

    /**
     * Houses Report
     */
    function houses()
    {
        $class = $this->input->post('class');
        $house = $this->input->post('house');

        $data['str_opts'] = $this->reports_m->populate('class_stream', 'id', 'name');
        $data['class'] = $class;
        $data['house'] = $house;
        $data['houses'] = $this->reports_m->populate('house', 'id', 'name');
        $data['result'] = $this->input->post() ? $this->reports_m->get_by_house($house, $class) : [];
        //load view
        $this->template->title('Houses Report ')->build('admin/house', $data);
    }

    /**
     * fee_status Report
     */
    function fee_status()
    {
        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        $sus = $this->input->post('sus');
        $min = $this->input->post('min');
        $max = $this->input->post('max');
        if ($min == 999999){
            $min = 1; //coz filter_bal >=
        }
        krsort($yrs);
        $data['str_opts'] = $this->reports_m->populate('class_stream', 'id', 'name');

        $data['yrs'] = $yrs;
        $data['fee'] = $this->reports_m->fetch_fee_status(0, $sus,$min,$max);
        //load view
        $this->template->title('Fee Status Report')->build('admin/balance', $data);
    }

    /**
     * Payments Report
     */
    function paid()
    {
        $from = 0;
        $to = 0;
        $bank = $this->input->post('bank');
        $method = $this->input->post('method');
        $for = $this->input->post('for');
        if ($this->input->post('from'))
        {
            $from = strtotime($this->input->post('from'));
        }
        if ($this->input->post('to'))
        {
            $to = strtotime($this->input->post('to'));
        }

        $paid = ($this->input->post()) ? $this->reports_m->fetch_payments($from, $to, $bank, $method, $for) : [];
        if ($this->input->post('export'))
        {
            if (empty($paid))
            {
                return FALSE;
            }
            return $this->export($paid);
        }

        $data['paid'] = $paid;
        $data['bank'] = $this->fee_payment_m->list_banks();
        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        //load view
        $this->template->title('Fee Payments Report')->build('admin/paid', $data);
    }


    function detailed_paid()
    {
     
        $for = $this->input->post('for');
        $term= $this->input->post('term');
        $year= $this->input->post('year');
        $data['for']=$for;
        

        $paid = ($this->input->post()) ? $this->reports_m->fetch_payments_repo($term ,$year, $for) : [];
        if ($this->input->post('export'))
        {
            if (empty($paid))
            {
                return FALSE;
            }
            return $this->export($paid);
        }
        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['paid'] = $paid;
        $data['bank'] = $this->fee_payment_m->list_banks();
        $data['extras'] = $this->fee_payment_m->all_fee_extras();
        //load view
        $this->template->title('Fee Payments Report')->build('admin/detailed', $data);
    }
    /**
     * Fee Payment Summary Per Class Report
     * 
     */
    function fee()
    {
        $yr = date('Y');
        $term = get_term(date('m'));
        $keep = 0;
        if ($this->input->post())
        {
            $term = $this->input->post('term');
            $yr = $this->input->post('year');
            if ($yr && $term)
            {
                $keep = 1;
            }
        }

        $data['classes'] = $this->portal_m->get_class_options();
        $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
        $range = range(date('Y'), date('Y') - 10);
        $data['yrs'] = array_combine($range, $range);
        $pool = $this->reports_m->fee_summary($term, $yr, $keep);

        $data['payload'] = $pool;
        $this->template->title('School Fee Status Report')->build('admin/fees', $data);
    }

    /**
     * Exam Report
     * 
     */
    function exam()
    {
        $hide = 1;
        $exam = $this->input->post('exam');
        $group = $this->input->post('group');
        $class = $this->input->post('class');
        $show = $this->input->post('grade');
        $rank = $this->input->post('rank');

        $subs = [];
        if ($exam && $group)
        {
            $tar = $this->exams_m->get_by_group($group);

            

            $res = $this->reports_m->fetch_exam_results($exam, $group, true, $rank, $group);
            $ex = $this->reports_m->get_exam($exam);
            $subs = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);
        }
        else if ($exam && $class)
        {
            $tar = $this->exams_m->get_stream($class);

          
            $res = $this->reports_m->fetch_exam_results($exam, $class, false, $rank, $tar->class);
            $ex = $this->reports_m->get_exam($exam);
            $subs = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);
        }
        else
        {
            $res = [];
            $ex = FALSE;
        }
        $ccc = [];
        foreach ($this->classlist as $key => $value)
        {
            $sp = (object) $value;
            $ccc[$key] = $sp->name;
        }

        $data['ccc'] = $ccc;
        $data['ex'] = $ex;
        $data['res'] = $res;
        $data['points'] = $this->map_grades();

        $data['subjects'] = $subs;
        $data['rank'] = $rank;
        $data['class'] = $class;
        $data['show'] = $show ? 1 : 0;
        $data['classes'] = $this->portal_m->get_class_options();
        $data['subtots'] = $this->reports_m->populate('sub_cats', 'id', 'title');
        $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
        $data['exams'] = $this->reports_m->populate_exams();
        $data['subs'] = $this->reports_m->populate('subjects', 'id', 'short_name');
        $data['adm'] = $this->reports_m->populate_admission();
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'title');
        $this->template->title('Exam Results Report')->build('admin/result', $data);
    }


    function exam_report()
    {
        if($this->input->post())
        {
            $exam = $this->input->post('exam');
            $group = $this->input->post('group');
            $class = $this->input->post('class');

            if($exam && $group)
            {
                // get exams by group'
                $payload = $this->reports_m->get_exam_report_by_grp($group, $exam);

                echo '<pre>';
                print_r($payload);
                echo '</pre>';
                die();
            }
        }

        $data['exams'] = $this->reports_m->populate_exams();
        $this->template->title('Exam Results Report')->build('admin/exam_report', $data);
    }

    /**
     * Exam Report
     * 
     */
    function sms_exam()
    {
        $hide = 1;
        $exam = $this->input->post('exam');
        $class = $this->input->post('class');
        $group = $this->input->post('group');
        $show = $this->input->post('grade');
        $rank = $this->input->post('rank');

        $subs = [];
        $ex = $this->reports_m->get_exam($exam);
        if ($exam && $group)
        {
            $tar = $this->exams_m->get_by_group($group);

            $res = $this->reports_m->fetch_exam_results($exam, $group, true, $rank);
            $subs = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);
        }
        else if ($exam && $class)
        {
            $tar = $this->exams_m->get_stream($class);
            $res = $this->reports_m->fetch_exam_results($exam, $class, false, $rank);
            $subs = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);
        }
        else
        {
            $res = [];
            $ex = FALSE;
        }

        $ccc = [];
        foreach ($this->classlist as $key => $value)
        {
            $sp = (object) $value;
            $ccc[$key] = $sp->name;
        }

        $data['ccc'] = $ccc;
        $data['ex'] = $ex;
        $data['res'] = $res;

        $data['subjects'] = $subs;
        $data['show'] = $show ? 1 : 0;
        $data['rank'] = $rank;
        $data['classes'] = $this->portal_m->get_class_options();
        $data['subtots'] = $this->reports_m->populate('sub_cats', 'id', 'title');
        $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
        $data['exams'] = $this->reports_m->populate_exams();
        $data['subs'] = $this->reports_m->populate('subjects', 'id', 'short_name');
        $data['adm'] = $this->reports_m->populate_admission();
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'title');
        $this->template->title('Exam Results Report ')->build('admin/sms', $data);
    }

    /**
     * grade_analysis Report
     * 
     */
    function grade_analysis()
    {
        $hide = 1;
        $exam = $this->input->post('exam');
        $class = $this->input->post('class');
        $rank = $this->input->post('rank');

        $points = $this->map_grades();
        $grades = $this->exams_m->populate('grades', 'id', 'title');

        $final = [];
        $size = 0;
        $ipoints = 0;
        $lastgs = 0;

        $gp = [];
        if ($exam)
        {
            $tar = $this->exams_m->get_stream($class);
            $res = $this->reports_m->fetch_exam_results($exam, $class, FALSE, $rank);

            $ex = $this->reports_m->get_exam($exam);
            $subjects = $hide ? $this->exams_m->get_subjects_alt($tar->id, $ex->term) : $this->exams_m->get_subjects($tar->id, $ex->term);
            $subtt = [];
            foreach ($subjects as $kkk => $sss)
            {
                $subtt[$kkk] = isset($sss['title']) ? $sss['title'] : '';
            }

            $i = 1;
            if (isset($res['xload']) && isset($res['max']))
            {
                $xload = $res['xload'];
                $sorter = $rank == 1 ? 'tots' : 'total_ranked';
                aasort($xload, $sorter, TRUE);

                $i = 0;
                $size = count($xload);
                foreach ($xload as $student => $results)
                {
                    $rw = (object) $results;
                    $i++;

                    $jj = 0;

                    $my_subs = 0;
                    $hs_points = 0;

                    foreach ($subjects as $ksub => $mkkd)
                    {
                        $hap = isset($rw->mks[$ksub]) ? $rw->mks[$ksub] : [];
                        if (empty($hap))
                        {
                            $fav[$ksub][$jj] = 'n'; //mark the blanks
                            //no results put a blank
                            if (isset($mkkd['units']) && count($mkkd['units']))
                            {
                                foreach ($mkkd['units'] as $fkey => $ffmk)
                                {
                                    $fav[$fkey . '000'][$jj] = 0;
                                }
                            }
                        }
                        else
                        {
                            $mkf = (object) $hap;
                            if ($mkf->opt == 2 && $mkf->inc)
                            {
                                $my_subs++;
                            }
                            else
                            {
                                if ($mkf->opt == 0)
                                {
                                    $my_subs++;
                                }
                            }

                            $rgd = $this->ion_auth->remarks($mkf->grading, $mkf->marks);
                            $hs_grade = isset($rgd->grade) && isset($grades[$rgd->grade]) ? $grades[$rgd->grade] : '';

                            $mk_grade = str_replace(' ', '', $hs_grade);
                            $pt = !empty($mk_grade) && isset($points[$mk_grade]) ? $points[$mk_grade] : 0;
                            $hs_points += $pt;

                            $final[$subtt[$ksub]][$hs_grade][] = $mkf->marks;
                            $lastgs = $mkf->grading;
                        }
                    }
                    $mnmaks = $rank == 2 ? round($rw->total_ranked / count($rw->ranked), 2) : round($rw->tots / $my_subs, 2);
                    $mrgd = $this->ion_auth->remarks($lastgs, $mnmaks);

                    $ms_grade = isset($mrgd->grade) && isset($grades[$mrgd->grade]) ? $grades[$mrgd->grade] : '';
                    $ipoints += $mnmaks;

                    $gp[] = $ms_grade;

                    $jj++;
                }
            }
        }
        else
        {
            $res = [];
            $ex = FALSE;
        }

        $ccc = [];
        foreach ($this->classlist as $key => $value)
        {
            $sp = (object) $value;
            $ccc[$key] = $sp->name;
        }

        $spr = [];
        $sfill = [];
        foreach ($grades as $sk)
        {
            $spr[$sk] = count(array_keys($gp, $sk));
        }

        foreach ($grades as $g)
        {
            foreach ($final as $subb => $res)
            {
                $sfill[$subb][$g] = isset($res[$g]) ? $res[$g] : [];
            }
        }

        $data['ccc'] = $ccc;
        $data['class'] = $class;
        $data['ex'] = $ex;
        $data['rank'] = $rank;
        $data['res'] = $sfill;
        $data['titles'] = $grades;
        $data['points'] = $points;
        $data['ipoints'] = $ipoints;
        $data['summary'] = $spr;
        $data['size'] = $size;
        $data['grading'] = $lastgs;

        $data['classes'] = $this->portal_m->get_class_options();
        $data['streams'] = $this->reports_m->populate('class_stream', 'id', 'name');
        $data['exams'] = $this->reports_m->populate_exams();
        $data['subs'] = $this->reports_m->populate('subjects', 'id', 'short_name');
        $this->template->title('Exam Results Report')->build('admin/grade', $data);
    }

    /**
     *  Book Fund Reports
     * 
     */
    public function book_fund()
    {
        $this->load->model('book_fund/book_fund_m');
        $data['book_fund'] = $this->book_fund_m->get_all();
        $data['category'] = $this->book_fund_m->populate('books_category', 'id', 'name');

        //load view
        $this->template->title('Book Fund')->build('admin/book_fund', $data);
    }

    /**
     * Join Exams Report
     * 
     */
    public function joint()
    {
        $exams = $this->input->post('exams');
        $class = $this->input->post('class');
        $group = $this->input->post('group');
        $show = $this->input->post('show');
        $rank = $this->input->post('rank');

        $subjr = [];
        $subfn = [];
        $mks = [];
        $fn = [];
        $xnames = [];
        $sub_avgs = [];
        $class_avg = [];
        //for determining term/year for remarks
        $Same = FALSE;
        $xterm = 0;
        $xyear = 0;

        if ($exams && ($class || $group))
        {
            sort($exams);
            $termx = [];
            $yearx = [];
            foreach ($exams as $x)
            {
                $xm = $this->exams_m->find($x);

                $xnames[] = $xm;
                $termx[] = $xm->term;
                $yearx[] = $xm->year;
                $subjr[] = $group ? $this->exams_m->get_subjects($group, $xm->term, 1, 1) : $this->exams_m->get_subjects($class, $xm->term, 1);
            }

            $Same = (count(array_unique($termx)) === 1) && (count(array_unique($yearx)) === 1);
            //   if ($Same)
            //    {
            $tt = array_unique($termx);

            $yy = array_unique($yearx);
            $xterm = array_shift($tt);
            $xyear = array_shift($yy);
            // }

            foreach ($subjr as $wk => $xsubs)
            {
                foreach ($xsubs as $sib => $sdets)
                {
                    $subfn[$sib] = $sdets;
                }
            }

            $list = $group ? $this->portal_m->fetch_students($group) : $this->portal_m->list_students($class);
            $map = [];

            foreach ($list as $sud)
            {
                foreach ($exams as $exam_id)
                {
                    $map[$sud][$exam_id] = $this->reports_m->map_ranking($exam_id, $sud, $rank);
                }
            }
            if (count($exams) > 1 && $rank > 1)
            {
                foreach ($map as $stt_id => $exx_list)
                {
                    $av_total = 0;
                    foreach ($exx_list as $exx_id => $exx_rank)
                    {
                        $xr = (object) $exx_rank;
                        $av_total += $xr->total_ranked;
                    }
                    $map[$stt_id][999999]['total_ranked'] = round(($av_total / count($exams)), 2);
                }
            }

            $tempavg = [];
            foreach ($list as $key => $sid)
            {
                foreach ($subfn as $skey => $sbdet)
                {
                    $units = [];
                    $sr = $this->exams_m->fetch_subject($skey);

                    $sn = empty($sr) ? ' -- ' : $sr->name;
                    $mks[$sid][$sn]['subject'] = $sn;

                    foreach ($exams as $xx)
                    {
                        $fsmark = $this->exams_m->get_subject_result($xx, $sid, $skey);
                        $h = (object) $fsmark;

                        /*
                          //exclude if dropped from ranking
                          if ($rank > 1)
                          {
                          if (!in_array($skey, $map[$sid][$xx]['dropped']))
                          {
                          }
                          $tempavg[] = $fsmark['marks'];
                          }
                          else
                          { */
                        if (($h->opt == 2 && $h->inc == 1) || ($h->opt == 0))
                        {
                            //store Subject averages
                            $tempavg[$xx][$skey][] = $h->marks;
                        }
                        //}


                        $mks[$sid][$sn]['maks'][$xx] = $fsmark;
                        $units[$xx] = isset($fsmark['units']) ? $fsmark['units'] : [];
                    }

                    $g_d = $exams[0];
                    $sgrade = $this->exams_m->fetch_grading($g_d, $class, $skey);
                    $mks[$sid][$sn]['grading'] = empty($sgrade) ? 0 : $sgrade->grading;
                    $mks[$sid][$sn]['sub_id'] = $skey;
                    $wun = [];
                    foreach ($units as $wx => $desc)
                    {
                        $b = 0;
                        $ut = [];
                        $wn = [];
                        foreach ($desc as $ix => $un)
                        {
                            if (!isset($ut[$un['name']]))
                            {
                                $ut[$un['name']] = 0;
                            }
                            $b++;
                            $wun[$un['name']][] = $un['marks'];
                            $ut[$un['name']] += $un['marks'];
                            $wn[] = $un['name'];
                        }
                        if ($b)
                        {
                            foreach ($wn as $www)
                            {
                                $uvg = $b ? round($ut[$www] / $b) : 0;
                            }
                        }
                    }
                    $wfinal = [];
                    if (count($wun))
                    {
                        foreach ($wun as $wkey => $wx)
                        {
                            $untot = 0;
                            $t = 0;
                            foreach ($wx as $mx)
                            {
                                $t++;
                                $untot += $mx;
                            }
                            $uvg = $t ? round($untot / $t) : 0;
                            $wx[] = $uvg;
                            $wfinal[$wkey] = $wx;
                        }
                    }
                    $mks[$sid][$sn]['units'] = $wfinal;
                }
            }

            foreach ($tempavg as $exam_iid => $mk_subjects)
            {
                foreach ($mk_subjects as $ksub_id => $av_marks)
                {
                    $sub_avgs[$exam_iid][$ksub_id] = number_format(array_sum($av_marks) / count($av_marks), 2);
                }
            }

            $tm_avg = [];
            foreach ($sub_avgs as $exam_iid => $mk_avg)
            {
                foreach ($mk_avg as $mk_sub_id => $avg_mk)
                {
                    $tm_avg[$mk_sub_id][] = $avg_mk;
                }
            }
            foreach ($tm_avg as $ss_id => $avgs)
            {
                $class_avg[$ss_id] = number_format(array_sum($avgs) / count($avgs), 2);
            }

            $data['list'] = $xnames;
            foreach ($mks as $student => $subdesc)
            {
                foreach ($subdesc as $subject => $desc)
                {
                    $i = 0;
                    $rg = 0;
                    $sb = '';
                    $sub_id = 0;
                    $opt = 0;
                    $incc = 0;
                    foreach ($desc['maks'] as $exam => $det)
                    {
                        $i++;
                        $rg += $det['marks'];
                        $sb = isset($det['subject']) ? $det['subject'] : '';
                        $opt = $det['opt'];
                        $incc = $det['inc'];
                        $sub_id = isset($det['sub_id']) ? $det['sub_id'] : $desc['sub_id'];
                    }
                    $svg = round($rg / $i);
                    $desc['maks'][999999] = array('subject' => $sb, 'sub_id' => $sub_id, 'marks' => $svg, 'opt' => $opt, 'inc' => $incc);
                    $fn[$student][$subject] = $desc;
                }
            }
            $data['ranked'] = $map;
        }

        $wmks = $this->_analyze_marks($fn, $xnames, $rank);

        if ($exams && count($exams) > 1 && $rank > 1)
        {
            foreach ($wmks['marks'] as $pid => $pmarks)
            {
                $wmks['marks'][$pid]['avg'] = $map[$pid][999999]['total_ranked'];
            }
        }
		
		
         $this->load->library('Dates');
        $data['mks'] = aasort($wmks['marks'], 'avg', SORT_DESC);
        $data['class_avg'] = $class_avg;

        $data['xterm'] = $xterm;
        $data['xyear'] = $xyear;

        $data['exlist'] = $exams;
        $data['tot_avg'] = $wmks['avg'];
        $data['show'] = $show == 1;
        $data['exams'] = $this->reports_m->populate_exams();
        $data['titles'] = $this->reports_m->get_labels();
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');
        $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');
        $data['class_details'] = $this->reports_m->populate('classes', 'class', 'class_teacher');
        $data['rank'] = $rank;

        $this->template->title('Joint Exam Report')->build('admin/joint', $data);
    }
		/**
         * Join Exams Report
         * 
         */
        public function igcse_joint()
        {
                $exams = $this->input->post('exams');
                $class = $this->input->post('class');
                $group = $this->input->post('group');
                $show = $this->input->post('show');
                $rank = $this->input->post('rank');

                $subjr = array();
                $subfn = array();
                $mks = [];
                $fn = array();
                $xnames = array();
                $sub_avgs = array();
                $class_avg = array();
                //for determining term/year for remarks
                $Same = FALSE;
                $xterm = 0;
                $xyear = 0;
				
				

                if ($exams && ($class || $group))
                {
                        sort($exams);
                        $termx = array();
                        $yearx = array();
                        foreach ($exams as $x)
                        {
                                $xm = $this->exams_m->find($x);

                                $xnames[] = $xm;
                                $termx[] = $xm->term;
                                $yearx[] = $xm->year;
                                $subjr[] = $group ? $this->exams_m->get_subjects($group, $xm->term, 1, 1) : $this->exams_m->get_subjects($class, $xm->term, 1);
                        }

                        $Same = (count(array_unique($termx)) === 1) && (count(array_unique($yearx)) === 1);
                        //   if ($Same)
                        //    {
                                $tt = array_unique($termx);

                                $yy = array_unique($yearx);
                                $xterm = array_shift($tt);
                                $xyear = array_shift($yy);
                        // }

                        foreach ($subjr as $wk => $xsubs)
                        {
                                foreach ($xsubs as $sib => $sdets)
                                {
                                        $subfn[$sib] = $sdets;
                                }
                        }

                        $list = $group ? $this->portal_m->fetch_students($group) : $this->portal_m->list_students($class);
                        $map = array();

                        foreach ($list as $sud)
                        {
                                foreach ($exams as $exam_id)
                                {
                                        $map[$sud][$exam_id] = $this->reports_m->map_ranking($exam_id, $sud, $rank);
                                }
                        }
                        if (count($exams) > 1 && $rank > 1)
                        {
                                foreach ($map as $stt_id => $exx_list)
                                {
                                        $av_total = 0;
                                        foreach ($exx_list as $exx_id => $exx_rank)
                                        {
                                                $xr = (object) $exx_rank;
                                                $av_total += $xr->total_ranked;
                                        }
                                        $map[$stt_id][999999]['total_ranked'] = round(($av_total / count($exams)), 2);
                                }
                        }

                        $tempavg = array();
                        foreach ($list as $key => $sid)
                        {
                                foreach ($subfn as $skey => $sbdet)
                                {
                                        $units = array();
                                        $sr = $this->exams_m->fetch_subject($skey);

                                        $sn = empty($sr) ? ' -- ' : $sr->name;
                                        $mks[$sid][$sn]['subject'] = $sn;
                                         
                                        foreach ($exams as $xx)
                                        {
                                             $fsmark = $this->exams_m->get_subject_result($xx, $sid, $skey);
                                                $h = (object) $fsmark;

                                                /*
                                                  //exclude if dropped from ranking
                                                  if ($rank > 1)
                                                  {
                                                  if (!in_array($skey, $map[$sid][$xx]['dropped']))
                                                  {
                                                  }
                                                  $tempavg[] = $fsmark['marks'];
                                                  }
                                                  else
                                                  { */
                                                if (($h->opt == 2 && $h->inc == 1) || ($h->opt == 0))
                                                {
                                                        //store Subject averages
                                                        $tempavg[$xx][$skey][] = $h->marks;
                                                }
                                                //}


                                                $mks[$sid][$sn]['maks'][$xx] = $fsmark;
                                                $units[$xx] = isset($fsmark['units']) ? $fsmark['units'] : array();
                                        }
                                         
                                        $g_d = $exams[0];
                                         $sgrade = $this->exams_m->fetch_grading($g_d, $class, $skey);
                                        $mks[$sid][$sn]['grading'] = empty($sgrade) ? 0 : $sgrade->grading;
                                        $mks[$sid][$sn]['sub_id'] = $skey;
                                        $wun = array();
                                        foreach ($units as $wx => $desc)
                                        {
                                                $b = 0;
                                                $ut = array();
                                                $wn = array();
                                                foreach ($desc as $ix => $un)
                                                {
                                                        if (!isset($ut[$un['name']]))
                                                        {
                                                                $ut[$un['name']] = 0;
                                                        }
                                                        $b++;
                                                        $wun[$un['name']][] = $un['marks'];
                                                        $ut[$un['name']] += $un['marks'];
                                                        $wn[] = $un['name'];
                                                }
                                                if ($b)
                                                {
                                                        foreach ($wn as $www)
                                                        {
                                                                $uvg = $b ? round($ut[$www] / $b) : 0;
                                                        }
                                                }
                                        }
                                        $wfinal = array();
                                        if (count($wun))
                                        {
                                                foreach ($wun as $wkey => $wx)
                                                {
                                                        $untot = 0;
                                                        $t = 0;
                                                        foreach ($wx as $mx)
                                                        {
                                                                $t++;
                                                                $untot += $mx;
                                                        }
                                                        $uvg = $t ? round($untot / $t) : 0;
                                                        $wx[] = $uvg;
                                                        $wfinal[$wkey] = $wx;
                                                }
                                        }
                                        $mks[$sid][$sn]['units'] = $wfinal;
                                }
                        }

                        foreach ($tempavg as $exam_iid => $mk_subjects)
                        {
                                foreach ($mk_subjects as $ksub_id => $av_marks)
                                {
                                        $sub_avgs[$exam_iid][$ksub_id] = number_format(array_sum($av_marks) / count($av_marks), 2);
                                }
                        }

                        $tm_avg = array();
                        foreach ($sub_avgs as $exam_iid => $mk_avg)
                        {
                                foreach ($mk_avg as $mk_sub_id => $avg_mk)
                                {
                                        $tm_avg[$mk_sub_id][] = $avg_mk;
                                }
                        }
                        foreach ($tm_avg as $ss_id => $avgs)
                        {
                                $class_avg[$ss_id] = number_format(array_sum($avgs) / count($avgs), 2);
                        }

                        $data['list'] = $xnames;
                        foreach ($mks as $student => $subdesc)
                        {
							
                                foreach ($subdesc as $subject => $desc)
                                {
									  
                                        $i = 0;
                                        $rg = 0;
                                        $sb = '';
                                        $sub_id = 0;
                                        $opt = 0;
                                        $incc = 0;
                                        foreach ($desc['maks'] as $exam => $det)
                                        {
											
                                                $i++;
                                                $rg += $det['marks'];
                                                $sb = isset($det['subject']) ? $det['subject'] : '';
                                                $opt = $det['opt'];
                                                $incc = $det['inc'];
                                                $sub_id = $det['sub_id'];
                                        }
                                        $svg = round($rg / $i);
                                        $desc['maks'][999999] = array('subject' => $sb, 'sub_id' => $sub_id, 'marks' => $svg, 'opt' => $opt, 'inc' => $incc);
                                        $fn[$student][$subject] = $desc;
                                }
                        }
                        $data['ranked'] = $map;
                }
                 
                $wmks = $this->_analyze_marks($fn, $xnames, $rank);

                if ($exams && count($exams) > 1 && $rank > 1)
                {
                        foreach ($wmks['marks'] as $pid => $pmarks)
                        {
                                $wmks['marks'][$pid]['avg'] = $map[$pid][999999]['total_ranked'];
                        }
                }

                $this->load->library('Dates');
                $data['mks'] = aasort($wmks['marks'], 'avg', SORT_DESC);
                $data['class_avg'] = $class_avg;

                $data['xterm'] = $xterm;
                $data['xyear'] = $xyear;

                $data['class_group'] = $group;
                $data['class'] = $class;
				
				
                $data['exlist'] = $exams;
                $data['tot_avg'] = $wmks['avg'];
                $data['show'] = $show == 1;
                $data['exams'] = $this->reports_m->populate_exams();
                $data['titles'] = $this->reports_m->get_labels();
                $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');
                $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');
                $data['class_details'] = $this->reports_m->populate('classes', 'class', 'class_teacher');
				
                $data['effort'] = $this->reports_m->effort();
                $data['igcse_grading'] = $this->reports_m->igcse_grading();
				
                $data['rank'] = $rank;

                $this->template->title('Joint Exam Report')->build('admin/igcse-joint', $data);
        }

      
     

    /**
     * Process & analyze
     * 
     * @param array $marks
     * @param array $list
     */
    function _analyze_marks($marks, $list, $rank = 1)
    {
        $mklist = [];
        $maintot = [];

        $cats = $this->reports_m->populate('subject_categories', 'subject', 'category');
        $cat_groups = [];

        foreach ($marks as $student => $smarks)
        {
            $tot = [];
            $bars = [];
            $tf = 0;
            foreach ($list as $l)
            {
                $tf++;
                $tot[$l->id] = 0;
            }

            $tot[999999] = 0;

            $i = 0;
            foreach ($smarks as $sub => $spms)
            {
                $sp = (object) $spms;

                $i++;
                if (isset($sp->units) && !empty($sp->units))
                {
                    $k = 0;
                    foreach ($sp->maks as $xid => $xres)
                    {
                        if (!isset($bars[$xid]))
                        {
                            $bars[$xid] = 0;
                        }
                        $k++;
                        $rs = (object) $xres;
                        if ($rs->opt == 2)
                        {
                            if ($rs->inc)
                            {
                                $cat_groups[$xid][$cats[$rs->sub_id]][] = array('subject' => $rs->sub_id, 'marks' => $rs->marks);
                                $tot[$xid] += $rs->marks;
                                $bars[$xid] += $rs->marks;
                            }
                            else
                            {
                                unset($smarks[$sub]);
                            }
                        }
                        else
                        {
                            $tot[$xid] += $rs->opt == 1 ? 0 : $rs->marks;
                            $bars[$xid] += $rs->opt == 1 ? 0 : $rs->marks;
                        }
                    }
                }
                else
                {
                    $k = 0;

                    foreach ($sp->maks as $xid => $xres)
                    {
                        if (!isset($bars[$xid]))
                        {
                            $bars[$xid] = 0;
                        }
                        $k++;
                        $rs = (object) $xres;

                        if ($rs->opt == 2)
                        {
                            if ($rs->inc)
                            {
                                $cat_groups[$xid][$cats[$rs->sub_id]][] = array('subject' => $rs->sub_id, 'marks' => $rs->marks);
                                $tot[$xid] += $rs->marks;
                                $bars[$xid] += $rs->marks;
                            }
                            else
                            {
                                unset($smarks[$sub]);
                            }
                        }
                        else
                        {
                            if (!$rs->opt && isset($rs->sub_id))
                            {
                                if (isset($cats[$rs->sub_id]))
                                {
                                    $cat_groups[$xid][$cats[$rs->sub_id]][] = array('subject' => $rs->sub_id, 'marks' => $rs->marks);
                                }
                            }
                            $tot[$xid] += $rs->opt == 1 ? 0 : $rs->marks;
                            $bars[$xid] += $rs->opt == 1 ? 0 : $rs->marks;
                        }
                    }
                }
            }

            $mklist[$student]['res'] = $smarks;
            $mklist[$student]['tots'] = $tot;
            $mklist[$student]['bars'] = $bars;
            $mklist[$student]['avg'] = $tot[999999];
            $maintot[] = $tot;
        }
        $s = 0;
        $holder = [];
        $tot_avg = [];
        foreach ($maintot as $single)
        {
            foreach ($single as $xam => $score)
            {
                $s++;
                $holder[$xam][] = $single[$xam];
            }
        }
        foreach ($holder as $m => $range)
        {
            $tot_avg[$m] = round(array_sum($range) / count($range));
        }

        return ['marks' => $mklist, 'avg' => $tot_avg];
    }

    function _get_exam_class($exam, $class)
    {
        $list = $this->portal_m->list_students($class);
        $payload = [];
        $xm = $this->exams_m->find($exam);
        $rec = $this->exams_m->is_recorded($exam);
        $has = TRUE;
        if (!$xm || !$rec)
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
            $has = FALSE;
        }

        foreach ($list as $key => $sid)
        {
            $st = $this->worker->get_student($sid);
            $tar = $this->exams_m->get_stream($st->class);

            $report = $this->exams_m->get_report($exam, $sid);
            $dcl = $this->reports_m->get_class_by_year($sid, $xm->year);

            $did = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
            $report['cls'] = $did;
            $report['student'] = $st;
            $payload[] = $report;
        }

        $streams = $this->exams_m->populate('class_stream', 'id', 'name');
        $data['proc'] = $has;
        $data['grading'] = $xm ? $this->exams_m->get_grading($xm->grading) : [];
        $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
        $data['subjects'] = $this->exams_m->get_subjects($class, $xm->term, 1);

        $data['exam'] = $xm;
        $data['full'] = $this->exams_m->list_subjects_alt(1);
        $data['streams'] = $streams;
        foreach ($payload as $kk => $p)
        {
            if (!isset($p['marks']))
            {
                unset($payload[$kk]);
            }
        }

        return sort_by_field($payload, 'total', 3);
    }

    /**
     * Fee Extras Roster Report
     * 
     */
    function fee_extras()
    {
        $fee = $this->input->post('fee');
        $yr = $this->input->post('year');
        $term = $this->input->post('term');
        $class = $this->input->post('class');
        $show = $this->input->post('show');
        $bals = $this->input->post('bals');

        if (!$yr)
        {
            $yr = date('Y');
        }
        $paid = [];
        if (!$fee)
        {
            $roster = [];
        }
        else
        {
            $fee_extras = $this->reports_m->get_fee_extras($fee, $class, $term, $yr, $show);
            $roster = $fee_extras['roster'];
            if ($show)
            {
                $paid = $fee_extras['paid'];
            }
        }

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['fee'] = $fee;
        $data['class'] = $class;
        $data['yr'] = $yr;
        $data['term'] = $term;
        $data['roster'] = $roster;
        $data['paid'] = $paid;
        $data['show'] = $show;
        $data['bals'] = $bals;
        $data['list'] = $this->reports_m->populate('fee_extras', 'id', 'title');
        $data['adm'] = $this->reports_m->populate_admission();
        $this->template->title('Fee Extras Report ')->build('admin/fee_extras', $data);
    }

    function all_extras()
    {
        $class = $this->input->post('class');

        if (!$class)
        {
            $roster = [];
        }
        else
        {
            $roster = $this->reports_m->get_due_extras($class);
        }

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['class'] = $class;

        $data['roster'] = $roster;
        $data['list'] = $this->reports_m->populate('fee_extras', 'id', 'title');
        $data['adm'] = $this->reports_m->populate_admission();
        $this->template->title('Fee Extras Report ')->build('admin/all_extras', $data);
    }

    function arrears()
    {
        $streams = [];
        foreach ($this->classlist as $key => $clasl)
        {
            $cl = (object) $clasl;
            $streams[$key] = $cl->name;
        }

        $yr = $this->input->post('year');
        $term = $this->input->post('term');
        $class = $this->input->post('class');
        $sus = $this->input->post('sus');
        if (!$yr)
        {
            $yr = date('Y');
        }
        $rearr = $this->reports_m->get_arrears($class, $term, $yr, $sus);

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['class'] = $class;
        $data['streams'] = $streams;
        $data['yr'] = $yr;
        $data['term'] = $term;
        $data['rearr'] = $rearr;
        $data['adm'] = $this->reports_m->populate_admission();
        $this->template->title('Fee Arrears Report ')->build('admin/feerears', $data);
    }

    /**
     *   Wages Report
     *  
     */
    public function wages()
    {
        $post = $this->reports_m->get_salaries();

        foreach ($post as $p)
        {
            $basic = $this->reports_m->total_basic($p->salary_date);
            $no_employees = $this->reports_m->count_employees($p->salary_date);
            $deductions = $this->reports_m->total_deductions($p->salary_date);

            $allowances = $this->reports_m->total_allowances($p->salary_date);
            $nhif = $this->reports_m->total_nhif($p->salary_date);
            $advance = $this->reports_m->total_advance($p->salary_date);

            $total_paid = (($basic->basic + $allowances->allws ) - $advance->advs);
            $fully_paid = ($basic->basic + $allowances->allws );

            $p->total_paid = $fully_paid;
            $p->no_employees = $no_employees;
            $p->advance = $advance->advs;
            $p->nhif = $nhif->nhif;
            $p->all_deductions = $deductions->ded;
        }
        $data['post'] = $post;
        $this->template->title('Wages Reports ')->build('admin/wages', $data);
    }

    /**
     * Expenses Summary Report
     * 
     */
    public function expenses()
    {
        $yr = $this->input->post('year');
        $term = $this->input->post('term');

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['yr'] = $yr;
        $data['term'] = $term;

        $post = $this->reports_m->get_expenses($term, $yr);
        foreach ($post as $p)
        {
            $expense_total = $this->reports_m->total_expense_amount($p->category, $term, $yr);
            $p->expense_total = $expense_total->total;
        }
        $data['post'] = $post;
        $data['cats'] = $this->reports_m->expense_categories();
        $this->template->title('Expense Summary Report')->build('admin/expenses', $data);
    }

    /**
     * Detailed Expenses Report
     * 
     */
    public function expense_trend()
    {
        $cat = $this->input->post('cat');
        $yr = $this->input->post('year');
        $term = $this->input->post('term');

        $range = range(date('Y') - 15, date('Y') + 1);
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['yrs'] = $yrs;
        $data['yr'] = $yr;
        $data['term'] = $term;
        $post = $this->reports_m->fetchx_by_category($cat, $term, $yr);

        $data['post'] = $post;
        $data['cats'] = $this->reports_m->expense_categories();
        $this->template->title('Detailed Expenses Report ')->build('admin/ex_trend', $data);
    }

    /**
     * Assets Report
     * 
     */
    function assets()
    {
        if ($this->ion_auth->logged_in())
        {
            $this->load->model('add_stock/add_stock_m');

            //find all the categories with paginate and save it in array to past to the view
            $data['add_stock'] = $this->add_stock_m->get_all();
            $data['product'] = $this->add_stock_m->get_products();
            $this->template->title('School Inventory')->set_layout('default.php')->build('admin/inventory', $data);
        }
    }

    /**
     * Student Appraisal Report
     */
    function appraisal()
    {
        $class = $this->input->post('class');
        $year = $this->input->post('year');
        $term = $this->input->post('term');
        $res = [];
        if ($class && $year && $term)
        {
            $res = $this->reports_m->fetch_appraisal($class, $year, $term);
        }

        $range = range(date('Y') - 15, date('Y'));
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $ccc = [];
        foreach ($this->classlist as $key => $value)
        {
            $sp = (object) $value;
            $ccc[$key] = $sp->name;
        }

        $data['res'] = $res;
        $data['yrs'] = $yrs;
        $data['year'] = $year;
        $data['term'] = $term;
        $data['classes'] = $ccc;
        $data['app'] = '';
        $this->template->title('Student Appraisal Report')->build('admin/appr', $data);
    }

    /**
     * Classes Report
     * 
     */
    public function classes()
    {
        $id = $this->input->post('class');
        if ($id && !$this->reports_m->such_class($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/reports/classes', 'refresh');
        }
        if (!$id)
        {
            $id = 1;
            if (!$this->reports_m->such_class($id))
            {
                $id = $id + 1;
            }
        }
        $streams = $this->reports_m->populate('class_stream', 'id', 'name');
        $cnames = $this->reports_m->get_class_names();
        if (!$streams)
        {
            $streams = FALSE;
        }
        $data['classes'] = $this->reports_m->get_classes($cnames, $streams);

        $get = $this->reports_m->get_class($id);

        $data['streams'] = $streams;
        $data['post'] = $get;
        if (!isset($get->stream))
        {
            $get->stream = FALSE;
        }
        $data['size'] = $this->reports_m->count_population($id, $get->stream);
        $data['students'] = $this->reports_m->get_population($id, $get->stream);
        $data['teachers'] = $this->ion_auth->get_teachers();
        $data[''] = '';
        //load view
        $this->template->title('Class Report ')->build('admin/classes', $data);
    }

    /**
     * export list to Excel
     * 
     * @param array $payments Data
     */
    function export($payments)
    {
        $this->load->library('Xlsx');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                          ->setCreator("User")
                          ->setLastModifiedBy("user")
                          ->setTitle("Office 2007 XLSX  Document")
                          ->setSubject("Office 2007 XLSX  Document")
                          ->setDescription("Document for Office 2007 .")
                          ->setKeywords("office 2007 openxml php")
                          ->setCategory("Results Excel");

        $i = 6;
        $index = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Payments');

        // Add Header
        $objPHPExcel->setActiveSheetIndex($index);

        $objPHPExcel->getActiveSheet()->setCellValue('B4', '#');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'DATE');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'STUDENT');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'ADM No.');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'CLASS');
        $objPHPExcel->getActiveSheet()->setCellValue('G4', 'DESCRIPTION');
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'TRANSACTION');
        $objPHPExcel->getActiveSheet()->setCellValue('I4', 'METHOD');
        $objPHPExcel->getActiveSheet()->setCellValue('J4', 'AMOUNT');
        $objPHPExcel->getActiveSheet()->setCellValue('K4', 'RECEIPT ');
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('B4'), 'B4:K4');

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(11);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(21);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(19);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()
                          ->getStyle('J4:K4')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $objPHPExcel->getActiveSheet()->getStyle('B4:K4')
                          ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B4:K4')->applyFromArray(
                          array(
                              'font' => array(
                                  'size' => 10,
                                  'name' => 'Arial'
                              ),
                              'fill' => array(
                                  'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                  'color' => array('rgb' => '#f0ad4e')
                              ),
                              'borders' => array(
                                  'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                                  'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
                              )
                          )
        );
        $styles = array(
            'font' => array(
                'size' => 10,
                'name' => 'Arial'
        ));

        $extras = $this->fee_payment_m->all_fee_extras();

        $j = 0;
        $op = 0;
        foreach ($payments as $p)
        {
            $j++;
            $op += $p->amount;
            $stu = $this->worker->get_student($p->reg_no);

            if ($p->description == 0)
            {
                $desc = 'Tuition Fee Payment';
            }
            elseif (is_numeric($p->description))
            {
                $desc = isset($extras[$p->description]) ? $extras[$p->description] : ' ';
            }
            else
            {
                $desc = $p->description;
            }

            $objPHPExcel->getActiveSheet()
                              ->getStyle('I' . $i . ':J' . $i)
                              ->getAlignment()
                              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()
                              ->getStyle('B' . $i)
                              ->getAlignment()
                              ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $objPHPExcel->getActiveSheet()
                              ->getStyle('I' . $i)
                              ->getNumberFormat()
                              ->setFormatCode('#,##0.00');

            $objPHPExcel->getActiveSheet()->getStyle('B' . $i . ':J' . $i)->applyFromArray($styles);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $j . '. ');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $p->payment_date > 10000 ? date('d M Y', $p->payment_date) : '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $stu->first_name . ' ' . $stu->last_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, isset($stu->old_adm_no) ? $stu->old_adm_no : $stu->admission_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $stu->cl->name);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $i, $desc);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $i, $p->transaction_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $i, $p->payment_method);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $i, number_format($p->amount, 2));
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $i, $p->receipt_id);

            $i++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Payments.xls" ');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    /**
     * Class Average Report
     * 
     */
    public function class_average()
    {
        $exams = $this->input->post('exams');
        $class = $this->input->post('class');

        $subjr = [];
        $subfn = [];

        $xnames = [];
        $sub_avgs = [];
        $class_avg = [];
        $s_names = [];
        //for determining term/year for remarks
        $same = FALSE;
        $xterm = 0;
        $xyear = 0;
        
         $tm_avg = [];
        if ($exams && $class)
        {
            sort($exams);
            $termx = [];
            $yearx = [];
            foreach ($exams as $x)
            {
                $xm = $this->exams_m->find($x);

                $xnames[] = $xm;
                $termx[] = $xm->term;
                $yearx[] = $xm->year;
                $subjr[] = $this->exams_m->get_subjects($class, $xm->term, 1);
            }

            $same = (count(array_unique($termx)) === 1) && (count(array_unique($yearx)) === 1);

            $tt = array_unique($termx);

            $yy = array_unique($yearx);
            $xterm = array_shift($tt);
            $xyear = array_shift($yy);

            foreach ($subjr as $wk => $xsubs)
            {
                foreach ($xsubs as $sib => $sdets)
                {
                    $subfn[$sib] = $sdets;
                }
            }

            $list = $this->portal_m->list_students($class);

            $tempavg = [];
            foreach ($list as $key => $sid)
            {
                foreach ($subfn as $skey => $sbdet)
                {
                    $sr = $this->exams_m->fetch_subject($skey);

                    $sn = empty($sr) ? ' -- ' : $sr->name;
                    $s_names[$skey] = $sn;

                    foreach ($exams as $xx)
                    {
                        $fsmark = $this->exams_m->get_subject_result($xx, $sid, $skey);
                        $h = (object) $fsmark;

                        if (($h->opt == 2 && $h->inc == 1) || ($h->opt == 0))
                        {
                            //store subject averages
                            $tempavg[$xx][$skey][$sid] = $h->marks;
                        }
                    }
                }
            }

            foreach ($tempavg as $exam_iid => $mk_subjects)
            {
                foreach ($mk_subjects as $ksub_id => $av_marks)
                {
                    $sub_avgs[$exam_iid][$ksub_id] = number_format(array_sum($av_marks) / count($av_marks), 2);
                }
            }

            foreach ($sub_avgs as $exam_iid => $mk_avg)
            {
                foreach ($mk_avg as $mk_sub_id => $avg_mk)
                {
                    $tm_avg[$mk_sub_id][] = $avg_mk;
                }
            }

            foreach ($tm_avg as $ss_id => $avgs)
            {
                $class_avg[$ss_id] = number_format(array_sum($avgs) / count($avgs), 2);
            }

            $data['list'] = $xnames;
        }

        //$this->load->library('Dates');
        $data['sub_avgs'] = $tm_avg;
        $data['class_avg'] = $class_avg;
        $data['matrix'] = $sub_avgs;

        $data['xterm'] = $xterm;
        $data['xyear'] = $xyear;
        $data['class'] = $class;

        $data['exlist'] = $exams;
        $data['exams'] = $this->reports_m->populate_exams();
        $data['titles'] = $s_names;
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');
        $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');

        $this->template->title('Class Average Report')->build('admin/c_avg', $data);
    }

    /**
     * List Balances Breakdown
     * 
     * @param int $class
     * @param int $stream
     */
    function list_bals($class, $stream)
    {
        $row = $this->reports_m->get_class_stream($class, $stream);
        if ($row)
        {
            $pool = $this->reports_m->fetch_stream_students($row->id);
            $qbal = [];

            foreach ($pool as $student)
            {
                $sb = $this->reports_m->get_bal_status($student);
                $qbal[] = array('student' => $student, 'amount' => $sb->balance);
            }
        }

        $data['bals'] = $qbal;
        $this->template->title('Fee Balances Breakdown Report ')->build('admin/balist', $data);
    }

    /**
     * Fix Arrears
     * 
     */
    function fix_arrears()
    {
        $get = $this->reports_m->fetch_starting_balances();
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Fix Arrears ')->build('admin/arfix', $data);
    }

    /**
     * Suspended Students with Balance
     * 
     */
    function inactive_balance()
    {
        $data['result'] = $this->reports_m->fetch_sus_balances();

        //load the view and the layout
        $this->template->title('Inactive/Suspended Students with Balance ')
                          ->build('admin/inactive_balance', $data);
    }

    /**
     * save remarks
     * 
     * @param type $term
     * @param type $year
     * @param type $type
     * @return boolean
     */
    function save_remarks($term, $year, $exams, $type)
    {
        if (!$term || !$year || !$type)
        {
            return FALSE;
        }
        $remrk = $this->input->post('value');
        $student = $this->input->post('pk');
        $user = $this->ion_auth->get_user();

        file_put_contents(FCPATH . "uploads/notes.txt", $student . "," . $exams . "," . $term . "," . $year . "," . $remrk . "\r\n", FILE_APPEND);
        if (!empty($remrk))
        {
            $cols = [1 => 'conduct', 2 => 'tr_remarks', 3 => 'ht_remarks'];
            if (!isset($cols[$type]))
            {
                echo json_encode(['error' => 'Invalid Type']);
                return FALSE;
            }

            $form = array(
                'student' => $student,
                'term' => $term,
                'exams' => $exams,
                'year' => $year
            );
            $form[$cols[$type]] = $remrk;

            $ex_id = $this->reports_m->remark_exists($term, $year, $student, $exams);
            if ($ex_id)
            {
                //update marks
                $this->reports_m->update_remarks($ex_id, $form, array('modified_by' => $user->id, 'modified_on' => time()));
            }
            else
            {
                //fresh insert
                $this->reports_m->save_remarks($form + array('created_by' => $user->id, 'created_on' => time()));
            }
        }
    }

    /**
     * Save Arrears ajax
     */
    function put_arrear()
    {
        $tarr = $this->input->post('name');
        $amt = $this->input->post('value');
        $user = $this->ion_auth->get_user();
        if ($tarr && $amt)
        {
            $dest = explode('_', $tarr);
            if (count($dest))
            {
                $sid = $dest[1];
                $rmk = array(
                    'amount' => $amt,
                    'modified_on' => time(),
                    'modified_by' => $user->id,
                );

                //update marks
                $this->reports_m->update_arrears($sid, $rmk);
            }
        }
    }

    function new_arrear($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $amt = $this->input->post('amount');
            $tm = $this->input->post('term');
            $yr = $this->input->post('year');

            $reg = $this->input->post('student');
            $rear = array(
                'student' => $reg,
                'amount' => $amt,
                'term' => $tm,
                'year' => $yr,
                'created_by' => $user->id,
                'created_on' => time()
            );

            $rec = $this->reports_m->insert_rear($rear);

            if ($rec)
            {
                //update student Balance
                $this->worker->calc_balance($reg);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/reports/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Fee Arrear ')->build('admin/new_rear', $data);
        }
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'student',
                'label' => 'Student',
                'rules' => 'required'),
            array(
                'field' => 'term',
                'label' => 'term',
                'rules' => 'required'),
            array(
                'field' => 'year',
                'label' => 'year',
                'rules' => 'required'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

}
