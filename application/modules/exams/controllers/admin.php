<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        if ($this->input->get('sb'))
        {
            $pop = $this->input->get('sb');
            $this->session->set_userdata('sub', $pop);
        }
        else
        {
            
        }
        $this->load->model('exams_m');
        $valid = $this->portal_m->get_class_ids();
        if ($this->input->get('sw'))
        {
            $pop = $this->input->get('sw');
            //limit to available classes only
            if (!in_array($pop, $valid))
            {
                $pop = $valid[0];
            }
            $this->session->set_userdata('pop', $pop);
        }
        else if ($this->session->userdata('pop'))
        {
            $pop = $this->session->userdata('pop');
        }
        else
        {
            //just list All
        }
    }

    /**
     * Student Appraisal
     */
    public function appraisal()
    {
        $result = new stdClass();
        if ($this->input->post())
        {
            $student = $this->input->post('student');
            $term = $this->input->post('term');
            $year = $this->input->post('year');

            if ($this->input->post('editt') && $student && $term && $year)
            {
                $result = $this->exams_m->get_appraisal($student, $term, $year);
            }
            else
            {
                $this->form_validation->set_rules($this->_ap_validation());
                if ($this->form_validation->run())
                {
                    $form = array(
                        'student' => $student,
                        'term' => $term,
                        'year' => $year,
                        'uniform' => $this->input->post('uniform'),
                        'shoes' => $this->input->post('shoes'),
                        'hygiene' => $this->input->post('hygiene'),
                        'neatness' => $this->input->post('neatness'),
                        'creativity' => $this->input->post('creativity'),
                        'swimming' => $this->input->post('swimming'),
                        'games' => $this->input->post('games'),
                        'clubs' => $this->input->post('clubs'),
                        'respect' => $this->input->post('respect'),
                        'polite' => $this->input->post('polite'),
                        'help' => $this->input->post('help'),
                        'discipline' => $this->input->post('discipline'),
                        'behaviour' => $this->input->post('behaviour'),
                        'confidence' => $this->input->post('confidence'),
                        'teamwork' => $this->input->post('teamwork'),
                        'parent_coop' => $this->input->post('parent_coop'),
                        'presentation' => $this->input->post('presentation'),
                        'handwriting' => $this->input->post('handwriting'),
                        'assignments' => $this->input->post('assignments'),
                        'homework' => $this->input->post('homework'),
                        'stationery' => $this->input->post('stationery'),
                        'diary' => $this->input->post('diary'),
                        'books' => $this->input->post('books'),
                        'created_by' => $this->user->id,
                        'created_on' => time()
                    );
                    $exists_id = $this->exams_m->check_appraisal($student, $term, $year);
                    if ($exists_id)
                    {
                        unset($form['student']);
                        //update
                        $this->exams_m->update_ap($exists_id, $form);

                        $details = implode(' , ', $this->input->post());
                        $user = $this->ion_auth->get_user();
                        $log = array(
                            'module' => $this->router->fetch_module(),
                            'item_id' => $exists_id,
                            'transaction_type' => $this->router->fetch_method(),
                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $exists_id,
                            'details' => $details,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $this->ion_auth->create_log($log);
                    }
                    else
                    {
                        $done = $this->exams_m->create_ap($form);

                        $details = implode(' , ', $this->input->post());
                        $user = $this->ion_auth->get_user();
                        $log = array(
                            'module' => $this->router->fetch_module(),
                            'item_id' => $done,
                            'transaction_type' => $this->router->fetch_method(),
                            'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $done,
                            'details' => $details,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );

                        $this->ion_auth->create_log($log);
                    }
                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Appraisal Saved Successfully'));
                    redirect('admin/exams/appraisal');
                }
            }
        }
        $range = range(date('Y') - 15, date('Y'));
        $yrs = array_combine($range, $range);
        krsort($yrs);
        $data['years'] = $yrs;
        $data['result'] = $result;
        $data['terms'] = array(1 => 'Term 1', 2 => 'Term 2', 3 => 'Term 3');

        //load view
        $this->template->title('Student Appraisal')->build('admin/appraisal', $data);
    }

    /**
     *  Index
     */
    public function index()
    {
        $config = $this->set_paginate_options();  //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['exams'] = $this->exams_m->paginate_all($config['per_page'], $page);
        //create pagination links
        $data['links'] = $this->pagination->create_links();
        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];
        $data['classes'] = $this->exams_m->list_classes();

        if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->template->title(' Exams ')
                              ->set_layout('teachers')
                              ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                              ->set_partial('teachers_top', 'partials/teachers_top.php')
                              ->build('admin/list', $data);
        }
        else
        {
            //load view
            $this->template->title('Exams ')->build('admin/list', $data);
        }
    }

    /**
     * Upload Excel sheet for filling marks 
     * 
     * @param int $exam_id
     * @param int $class_id
     */
    function put_excel_sheet($exam_id = 0, $class_id = 0)
    {
        $this->load->library('files_uploader');
        require_once APPPATH . 'libraries/xlsxreader.php';

        $subject = $this->input->post('subject_id');
        $count_units = 0;
        $grading = 0;

        if (!$subject)
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Please Select Subject'));
            redirect('admin/exams/rec_upper/' . $exam_id . "/" . $class_id);
        }
        if (!empty($_FILES['marks']['name']))
        {
            $path = "/var/www/web/sms-ke/uploads/files/";
            if (file_exists($path . $_FILES['marks']['name']))
            {
                unlink($path . $_FILES['marks']['name']);
            }
            $upload = (object) $this->files_uploader->upload_marks('marks');
            if ($upload->ok && isset($upload->data))
            {
                $file = $upload->data->full_path;

                $reader = new XLSXReader($file);
                $reader->decodeUTF8(true);
                $reader->read();
                $result = array();

                $sheets = $reader->getSheets();

                $i = 0;
                foreach ($sheets as $sheet)
                {
                    $i++;
                    $data = $reader->getSheetDatas($sheet["id"]);
                    $titles = $data[0];
                    unset($data[0]);

                    if (!in_array('sid', $titles) || !in_array('grading', $titles) || !in_array('units', $titles) || !in_array('adm_no', $titles))
                    {
                        $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'File not recognized. Please download from the System'));
                        redirect('admin/exams/rec_upper/' . $exam_id . "/" . $class_id);
                    }

                    foreach ($data as $rid => $marked)
                    {
                        $row = array();
                        $mkk = array();
                        foreach ($marked as $cid => $cell)
                        {
                            $title = $titles[$cid];

                            if (strpos($title, '_') !== FALSE)
                            {
                                $ttstr = explode('_', $title);
                                $title = $ttstr[0];
                                if ($title != 'adm')
                                {
                                    $mkk[$title] = $cell;
                                }
                                continue;
                            }

                            $row[$title] = $cell;
                        }
                        $row['marks'] = $mkk;

                        $count_units = $row['units'];
                        $grading = $row['grading'];

                        if ((!isset($row['student'])) || (!isset($row['sid'])) || (!isset($row['units'])))
                        {
                            continue;
                        }
                        $result[] = (object) $row;
                    }
                    break;
                }

                $user = $this->ion_auth->get_user();
                $new = 0;
                if (!$this->exams_m->rec_exists($exam_id, $class_id))
                {
                    $new = 1;
                    $form_data = array(
                        'exam_type' => $exam_id,
                        'class_id' => $class_id,
                        'created_by' => $user->id,
                        'created_on' => time()
                    );
                    $exam_mgt_id = $this->exams_m->create_ex($form_data);
                    $this->exams_m->set_grading($exam_id, $class_id, $subject, $grading, $user->id);
                }
                else
                {
                    $xm = $this->exams_m->fetch_rec($exam_id, $class_id);
                    $exam_mgt_id = $xm->id;
                }

                foreach ($result as $r)
                {
                    $list_id = $this->exams_m->create_list(array('student' => $r->sid, 'exams_id' => $exam_mgt_id));
                    if (!isset($r->marks))
                    {
                        $r->marks = array();
                        $r->marks[$subject] = 0;
                    }
                    $scored = isset($r->marks[$subject]) ? $r->marks[$subject] : 0;
                    if ($new)
                    {
                        $fvalues = array(
                            'exams_list_id' => $list_id,
                            'marks' => $scored,
                            'subject' => $subject,
                            'inc' => $scored > 0 ? 1 : 0,
                            'created_by' => $user->id,
                            'created_on' => time()
                        );
                        $this->exams_m->insert_marks($fvalues);
                    }
                    else
                    {
                        $mod = array(
                            'inc' => $scored > 0 ? 1 : 0,
                            'marks' => $scored,
                            'modified_by' => $user->id,
                            'modified_on' => time()
                        );
                        $this->exams_m->bulk_update_marks($list_id, $subject, $mod);
                    }
                    if ($count_units)
                    {
                        $i = 0;
                        foreach ($r->marks as $unit_id => $umarks)
                        {
                            $i++;
                            if ($i <= $count_units)
                            {
                                $values = array(
                                    'marks' => $umarks,
                                    'modified_by' => $user->id,
                                    'modified_on' => time()
                                );
                                $this->exams_m->update_sub_marks($list_id, $subject, $unit_id, $values);
                            }
                        }
                    }
                }

                //delete the file
                unlink($file);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Upload Complete'));
                redirect('admin/exams/bulk_edit/' . $exam_id . "/" . $class_id . "?sb=" . $subject);
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Error Uploading File'));
                redirect('admin/exams/rec_upper/' . $exam_id . "/" . $class_id);
            }
        }
    }

    /**
     * Download Excel sheet for filling marks 
     * 
     * @param int $exam_id
     * @param int $class_id
     */
    function get_excel_sheet($exam_id = 0, $class_id = 0)
    {
        $gd_id = $this->input->post('gd_id');
        $subject = $this->input->post('subject_id');

        if (!$gd_id || !$subject)
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => ' Please Select Grading System and Subject'));
            redirect(base_url('admin/exams/rec_upper/' . $exam_id . "/" . $class_id . "?exam=1"));
        }
        if ($this->exams_m->rec_exists($exam_id, $class_id))
        {
            //$this->session->set_flashdata('message', array('type' => 'error', 'text' => 'You have already Recorded Marks For that Class/Exam. Use Edit Marks Instead'));
            // redirect(base_url('admin/exams/rec_upper/' . $exam_id . "/" . $class_id . "?exam=1"));
        }

        $cls = $this->exams_m->get_stream($class_id);
        $exam = $this->exams_m->find($exam_id);
        $subjects = $this->exams_m->get_subjects($class_id, $exam->term);

        $selected = isset($subjects[$subject]) ? $subjects[$subject] : array();
        $sel = (object) $selected;

        $students = $this->exams_m->get_students($cls->class, $cls->stream);

        $post = array();
        $titles = array('student', 'adm_no', 'sid', 'units', 'grading');
        $units = 0;
        if (isset($sel->units))
        {
            $i = 0;
            $units = count($sel->units);
            foreach ($sel->units as $utk => $utt)
            {
                $i++;
                $titles[] = $utk . '_' . $utt;
            }
            $titles[] = $subject . '_' . $sel->full;
        }
        else
        {
            $titles[] = $subject . '_' . $sel->full;
        }

        // * ********** */
        $list = json_decode(json_encode($students), true);
        //sort 
        aasort($list, 'first_name');
        //return to object
        $srt_students = json_decode(json_encode($list));
        foreach ($srt_students as $s)
        {
            $name = $s->first_name . ' ' . $s->last_name;

            $post[] = (object) array('student' => $name, 'adm_no' => $s->old_adm_no ? $s->old_adm_no : $s->admission_number, 'sid' => $s->id, 'subject_id' => $subject, 'grading' => $gd_id);
        }

        $this->export_bulk($titles, $post, $units, $sel->full);
    }

    /**
     * export list to Excel
     * 
     * @param array $titles
     * @param array $students
     * @param int $units
     */
    function export_bulk($titles, $students, $units, $subject)
    {
        $this->load->library('Xlsx');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                          ->setCreator("smartshule.com")
                          ->setLastModifiedBy("user")
                          ->setTitle($subject . " Exam Results")
                          ->setSubject("Exam Results")
                          ->setDescription("Smartshule.com Exam Results .")
                          ->setKeywords("office 2007 openxml smartshule")
                          ->setCategory("Smartshule.com Exam Results");

        $alpha = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',);
        $end = $alpha[count($titles) - 1];

        $i = 2;
        $index = 0;
        $objPHPExcel->setActiveSheetIndex(0)->setTitle($subject);

        // Add Header
        $objPHPExcel->setActiveSheetIndex($index);

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A1'), 'A1:' . $end . '1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $end . '1')->applyFromArray(
                          array(
                              'font' => array(
                                  'size' => 10,
                                  'name' => 'Arial'
                              ),
                              'fill' => array(
                                  'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                  'color' => array('rgb' => '00008b')
                              )
                          )
        );

        $k = 0;
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        foreach ($titles as $title)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($alpha[$k] . '1', $title);

            if ($k > 1 && $k < 5)
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension($alpha[$k])->setWidth(7);
            }
            if ($k > 4)
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension($alpha[$k])->setWidth(14);
            }
            $k++;
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $end . '1')
                          ->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        foreach ($students as $rw)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $rw->student);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $rw->adm_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $rw->sid);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $units);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $rw->grading);

            $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $subject . '_' . date('d_m') . '.xlsx');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    /**
     * Record Exam Marks
     * 
     * @param int $exid Exam ID
     * @param int $id Class
     */
    function rec_upper($exid = 0, $id = 0)
    {
        if (!$exid || !$id)
        {
            redirect('admin/exams');
        }
        if ($this->exams_m->rec_exists($exid, $id))
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'You have already Recorded Marks For that Class/Exam. Use Edit Marks Instead'));
            redirect('admin/exams');
        }
        $students = array();
        $sb = 0;
        //push class name to next view
        $class_name = $this->exams_m->populate('class_groups', 'id', 'name');
        $exam = $this->exams_m->find($exid);
        $tar = $this->exams_m->get_stream($id);
        $class_id = $tar->class;
        $stream = $tar->stream;
        $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . '</span>';

        $subjects = $this->exams_m->get_subjects($id, $exam->term);
        $sel = 0;
        if ($this->input->get('sb'))
        {
            $sb = $this->input->get('sb');
            $data['selected'] = isset($subjects[$sb]) ? $subjects[$sb] : array();
            $row = $this->exams_m->fetch_subject($sb);
            $rrname = $row ? ' - ' . $row->name : '';
            $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . $rrname . '</span>';

            if ($row->is_optional == 2)
            {
                $sel = 1;
            }

            $students = $this->exams_m->get_students($class_id, $stream);
        }

        $data['list_subjects'] = $this->exams_m->list_subjects();
        $data['subjects'] = $subjects;
        $data['class_name'] = $heading;
        $data['assign'] = $sel;
        $data['count_subjects'] = $this->exams_m->count_subjects($class_id, $exam->term);
        $data['full_subjects'] = $this->exams_m->get_full_subjects();

        //create control variables
        $data['updType'] = 'create';
        $data['page'] = '';
        $data['exams'] = $this->exams_m->list_exams();
        $data['grading'] = $this->exams_m->get_grading_system();
        //Rules for validation
        $this->form_validation->set_rules($this->rec_validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            //Validation OK!
            if ($this->input->get('sb'))
            {
                $inc = array();
                $mkpost = $this->input->post();
                if (isset($mkpost['done']))
                {
                    $inc = $mkpost['done'];
                }
                $sb = $this->input->get('sb');
                $gd_id = $this->input->post('grading');
                $marks = $this->input->post('marks');
                $units = $this->input->post('units');

                $user = $this->ion_auth->get_user();
                $form_data = array(
                    'exam_type' => $exid,
                    'class_id' => $id,
                    'created_by' => $user->id,
                    'created_on' => time()
                );
                $ok = $this->exams_m->create_ex($form_data);
                $this->exams_m->set_grading($exid, $id, $sb, $gd_id, $user->id);
                $perf_list = $this->_prep_marks($sb, $ok, $marks, $units);

                foreach ($perf_list as $dat)
                {
                    $dat = (object) $dat;
                    $values = array(
                        'exams_id' => $dat->exams_id,
                        'student' => $dat->student,
                        // 'total' => $dat->total,
                        // 'remarks' => $dat->remarks,
                        'created_by' => $user->id,
                        'created_on' => time()
                    );
                    $list_id = $this->exams_m->create_list($values);

                    $mm = (object) $dat->marks;
                    $mkcon = $mm->marks ? $mm->marks : 0;

                    $fvalues = array(
                        'exams_list_id' => $list_id,
                        'marks' => $mkcon,
                        'subject' => $mm->subject,
                        'inc' => isset($inc[$dat->student]) ? 1 : 0,
                        'created_by' => $user->id,
                        'created_on' => time()
                    );
                    $this->exams_m->insert_marks($fvalues);

                    if (isset($dat->units) && count($dat->units))
                    {
                        foreach ($dat->units as $sm)
                        {
                            $sm = (object) $sm;
                            $svalues = array(
                                'marks_list_id' => $list_id,
                                'parent' => $sm->parent,
                                'unit' => $sm->unit,
                                'marks' => $sm->marks,
                                'created_by' => $user->id,
                                'created_on' => time()
                            );
                            $this->exams_m->insert_subs($svalues);
                        }
                    }
                }

                if ($ok)
                {
                    $details = implode(' , ', $form_data);
                    $user = $this->ion_auth->get_user();
                    $log = array(
                        'module' => $this->router->fetch_module(),
                        'item_id' => $ok,
                        'transaction_type' => $this->router->fetch_method(),
                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                        'details' => $details,
                        'created_by' => $user->id,
                        'created_on' => time()
                    );

                    $this->ion_auth->create_log($log);

                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
                }
                else
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                }
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Subject Not Specified'));
            }
            redirect('admin/exams/');
        }
        else
        {
            $get = new StdClass();
            foreach ($this->rec_validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['sb'] = $sb;
            $data['result'] = $get;
            $data['class_id'] = $id;
            $data['exam_id'] = $exid;
            $data['students'] = $students;

            $this->template->title('Record Exam Marks')->build('admin/upper_rec', $data);
        }
    }

    function _save_marks($mark_list, $inc)
    {
        $user = $this->ion_auth->get_user();
        foreach ($mark_list as $dat)
        {
            $dat = (object) $dat;
            $values = array(
                'exams_id' => $dat->exams_id,
                'student' => $dat->student,
                // 'total' => $dat->total,
                // 'remarks' => $dat->remarks,
                'created_by' => $user->id,
                'created_on' => time()
            );
            $list_id = $this->exams_m->create_list($values);

            $mm = (object) $dat->marks;
            $mkcon = $mm->marks ? $mm->marks : 0;

            $fvalues = array(
                'exams_list_id' => $list_id,
                'marks' => $mkcon,
                'subject' => $mm->subject,
                'inc' => isset($inc[$dat->student]) ? 1 : 0,
                'created_by' => $user->id,
                'created_on' => time()
            );
            $this->exams_m->insert_marks($fvalues);

            if (isset($dat->units) && count($dat->units))
            {
                foreach ($dat->units as $sm)
                {
                    $sm = (object) $sm;
                    $svalues = array(
                        'marks_list_id' => $list_id,
                        'parent' => $sm->parent,
                        'unit' => $sm->unit,
                        'marks' => $sm->marks,
                        'created_by' => $user->id,
                        'created_on' => time()
                    );
                    $this->exams_m->insert_subs($svalues);
                }
            }
        }
    }

    function _prep_marks($subject, $exm_mgmt_id, $marks = array(), $units = array())
    {
        $perf_list = array();
        $sub_marks = array();
        $user = $this->ion_auth->get_user();
        if ($units && !empty($units))
        {
            foreach ($units as $stid => $unmarks)
            {
                foreach ($unmarks as $uid => $mk)
                {
                    $sunits[] = array(
                        'parent' => $subject,
                        'unit' => $uid,
                        'marks' => $mk
                    );
                }
            }
        }

        foreach ($marks as $std => $score)
        {
            $sunits = array();
            $sub_marks = array(
                'subject' => $subject,
                'marks' => $score
            );
            if ($units && isset($units[$std]))
            {
                $mine = $units[$std];
                foreach ($mine as $uid => $mk)
                {
                    $sunits[] = array(
                        'parent' => $subject,
                        'unit' => $uid,
                        'marks' => $mk
                    );
                }
            }
            $perf_list[] = array(
                'exams_id' => $exm_mgmt_id,
                'student' => $std,
                'marks' => $sub_marks,
                'units' => $sunits,
                'created_by' => $user->id,
                'created_on' => time()
            );
        }
        return $perf_list;
    }

    /**
     * Generate Report Forms  - Bulk
     * 
     * @param $exam
     * @param $update
     */
    function bulk($exam, $update = 0)
    {
        $flag = FALSE;
        $exams = $this->exams_m->populate_exams('exams', 'id', 'title');
        $rank = $this->input->post('rank');
        $xm = $this->exams_m->find($exam);
        if ($this->input->post() && $this->input->post('student'))
        {
            $student = $this->input->post('student');
            $obst = $this->worker->get_student($student);
            $tar = $this->exams_m->get_stream($obst->class);

            $rec = $this->exams_m->is_recorded($exam);
            $has = TRUE;
            if (!$xm || !$rec)
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                $has = FALSE;
            }

            $data['report'] = $this->exams_m->get_report($exam, $student);
            $data['exam'] = $xm;
            $data['subjects'] = $this->exams_m->get_subjects($tar->id, $xm->term, 1);
            $data['full'] = $this->exams_m->list_subjects_alt(1);
            $st = $this->worker->get_student($student);
            $this->load->model('reports/reports_m');
            $dcl = $this->reports_m->get_class_by_year($student, $xm->year);
            $did = $this->exams_m->get_by_class($dcl->class, $dcl->stream);

            $streams = $this->exams_m->populate('class_stream', 'id', 'name');
            $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
            $data['student'] = $st;
            $data['proc'] = $has;
            $data['streams'] = $streams;
            $data['cls'] = $did;
        }
        else if ($this->input->post() && $this->input->post('class'))
        {
            $flag = 1;
            $class = $this->input->post('class');
            $sort = $this->input->post('sort');
            $list = $this->portal_m->list_students($class);

            $payload = array();
            $xm = $this->exams_m->find($exam);
            $rec = $this->exams_m->is_recorded($exam);
            $has = TRUE;
            if (!$xm || !$rec)
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                $has = FALSE;
            }
            $this->load->model('reports/reports_m');
            foreach ($list as $key => $sid)
            {
                $obst = $this->worker->get_student($sid);
                $tar = $this->exams_m->get_stream($obst->class);
                $report = $this->exams_m->get_report($exam, $sid, $class, $rank);
                $st = $this->worker->get_student($sid);
                $dcl = $this->reports_m->get_class_by_year($sid, $xm->year);
                $mcl = '';
                if (!empty($dcl))
                {
                    $mcl = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
                }
                $report['cls'] = $mcl;
                $report['student'] = $st;
                $payload[] = $report;
            }

            $streams = $this->exams_m->populate('class_stream', 'id', 'name');
            $data['proc'] = $has;
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

            $data['payload'] = ($sort == 1) ? sort_by_field($payload, 'total', 3) : sort_by_field($payload, 'mean', 3);
        }
        else
        {
            
        }
        $data['rank'] = $rank;
        $data['exam'] = $xm;
        $data['flag'] = $flag;
        $data['classes'] = $this->classlist;
        $range = range(date('Y') - 1, date('Y') + 1);
        $data['yrs'] = array_combine($range, $range);
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');

        $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');
        $data['subject_title'] = $this->exams_m->populate('subjects', 'id', 'short_name');
        $data['years_exams'] = $this->exams_m->years_exams();
        $data['exams_name'] = $this->exams_m->exam_details('exams', 'id', 'title');
        $data['exams_type_id'] = $this->exams_m->populate('exams_management', 'id', 'exam_type');

        //load the view and the layout
        $this->template->title('Generate Report Forms')->build('admin/bulk', $data);
    }

    /**
     * Generate Report Forms for stream
     * 
     * @param $exam
     */
    function bulk_group($exam)
    {
        $payload = array();
        if ($this->input->post() && $this->input->post('class'))
        {
            $class = $this->input->post('class');
            $sort = $this->input->post('sort');
            $list = $this->portal_m->fetch_students($class);

            $xm = $this->exams_m->find($exam);
            $rec = $this->exams_m->is_recorded($exam);
            $has = TRUE;
            if (!$xm || !$rec)
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                $has = FALSE;
            }
            $this->load->model('reports/reports_m');
            foreach ($list as $key => $sid)
            {
                $st = $this->worker->get_student($sid);
                $tar = $this->exams_m->get_stream($st->class);
                $report = $this->exams_m->get_report($exam, $sid, $st->class);
                $dcl = $this->reports_m->get_class_by_year($sid, $xm->year);
                $mcl = '';
                if (!empty($dcl))
                {
                    $mcl = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
                }
                $report['cls'] = $mcl;
                $report['student'] = $st;
                $payload[] = $report;
            }

            $streams = $this->exams_m->populate('class_stream', 'id', 'name');
            $data['proc'] = $has;
            $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
            $data['subjects'] = $this->exams_m->get_subjects($tar->id, $xm->term, 1);
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

            $payload = ($sort == 1) ? sort_by_field($payload, 'total', 3) : sort_by_field($payload, 'mean', 3);
        }
        $data['payload'] = $payload;
        $data['classes'] = $this->classlist;
        $range = range(date('Y') - 1, date('Y') + 1);
        $data['yrs'] = array_combine($range, $range);
        $data['grades'] = $this->exams_m->populate('grades', 'id', 'remarks');
        $data['grade_title'] = $this->exams_m->populate('grades', 'id', 'title');

        $data['subject_title'] = $this->exams_m->populate('subjects', 'id', 'short_name');
        $data['years_exams'] = $this->exams_m->years_exams();
        $data['exams_name'] = $this->exams_m->exam_details('exams', 'id', 'title');
        $data['exams_type_id'] = $this->exams_m->populate('exams_management', 'id', 'exam_type');
        //load the view and the layout
        if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->template
                              ->title('Generate Report Forms')
                              ->set_layout('teachers')
                              ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                              ->set_partial('teachers_top', 'partials/teachers_top.php')
                              ->build('admin/bulk_stream', $data);
        }
        else
        {
            $this->template->title('Generate Report Forms')->build('admin/bulk_stream', $data);
        }
    }

    /**
     * get_summary for recent exams
     * 
     * @param int $exam
     * @param int $class
     * @param int $sort
     * @return boolean
     */
    function get_summary($exam, $class, $sort, $update = 0)
    {
        $list = $this->portal_m->list_students($class);

        $payload = array();
        $xm = $this->exams_m->find($exam);
        $rec = $this->exams_m->is_recorded($exam);
        if (!$xm || !$rec)
        {
            return FALSE;
        }
        foreach ($list as $key => $sid)
        {
            $report = $this->exams_m->get_report($exam, $sid, $class);
            $st = $this->worker->get_student($sid);

            $report['student'] = $st;
            $payload[] = $report;
        }

        $subjects = $this->exams_m->get_subjects($class, $xm->term, 1);
        foreach ($payload as $kk => $p)
        {
            if (!isset($p['marks']))
            {
                unset($payload[$kk]);
            }
        }

        $payload_final = ($sort == 1) ? sort_by_field($payload, 'total', 3) : sort_by_field($payload, 'mean', 3);

        $grade_title = $this->exams_m->populate('grades', 'id', 'title');
        $j = 0;

        foreach ($payload_final as $row)
        {
            $j++;
            $rw = (object) $row;

            //Regular && Electives
            $i = 0;
            $gd = 0;
            $grading_to_use = 0;
            foreach ($rw->marks as $spms)
            {
                $sp = (object) $spms;
                if ($sp->opt == 1)
                {
                    continue; //skip Optional Subjects coz they have their own space at the bottom
                }
                if (!array_key_exists($sp->subject, $subjects))
                {
                    continue; //skip subjects where marks were recorded but subject later removed from class   
                }
                $i++;

                $gd += $sp->opt == 1 ? 0 : $sp->marks;

                $grading_to_use = $sp->grading;
            }
            $mn = $i ? number_format($gd / $i, 1) : 0;
            $trmks = $this->ion_auth->remarks($grading_to_use, $mn);
            $meangrade = isset($trmks->grade) && isset($grade_title[$trmks->grade]) ? $grade_title[$trmks->grade] : '';

            $exists = $this->exams_m->pf_exists($rw->student->id, $exam);
            if ($exists)
            {
                if ($update)
                {
                    $this->exams_m->update_key_data($exists->id, 'exam_pos', array(
                        'pos' => $j,
                        'outof' => count($payload),
                        'total' => $gd,
                        'mean' => $mn,
                        'grade' => $meangrade,
                        'modified_on' => time())
                    );
                }
            }
            else
            {
                $form = array(
                    'student' => $rw->student->id,
                    'exam' => $exam,
                    'pos' => $j,
                    'outof' => count($payload),
                    'total' => $gd,
                    'mean' => $mn,
                    'grade' => $meangrade,
                    'created_on' => time(),
                    'created_by' => $this->ion_auth->get_user()->id
                );
                $this->exams_m->insert_key_data('exam_pos', $form);
            }
        }
    }

    /**
     * Bulk Edit Exam Marks
     * 
     * @param int $exid Exam ID
     * @param int $id Class
     */
    function bulk_edit($exid = 0, $id = 0)
    {
        if (!$exid || !$id)
        {
            redirect('admin/exams');
        }
        if (!$this->exams_m->rec_exists($exid, $id))
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'You have Not Recorded Marks For that Class/Exam. Record Marks First'));
            redirect('admin/exams');
        }
        $students = array();
        $rest = array();
        $sb = 0;
        $class_name = $this->exams_m->populate('class_groups', 'id', 'name');
        $tar = $this->exams_m->get_stream($id);
        $exam = $this->exams_m->find($exid);
        $xm = $this->exams_m->fetch_rec($exid, $id);
        $xm OR redirect('admin/exams');
        $class_id = $tar->class;
        $stream = $tar->stream;
        $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . '</span>';
        $subjects = $this->exams_m->get_subjects($id, $exam->term);

        $gdd = 0;
        $sel = 0;
        if ($this->input->get('sb'))
        {
            $sb = $this->input->get('sb');
            $data['selected'] = isset($subjects[$sb]) ? $subjects[$sb] : array();
            $row_gd = $this->exams_m->fetch_grading($exid, $id, $sb);

            if (!empty($row_gd))
            {
                $gdd = $row_gd->grading;
            }
            $row = $this->exams_m->fetch_subject($sb);
            $rrname = $row ? ' - ' . $row->name : '';
            $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . $rrname . '</span>';
            if ($row->is_optional == 2)
            {
                $sel = 1;
            }

            $students = $this->exams_m->get_students($class_id, $stream);

            $list = $this->exams_m->fetch_list($exid, $id);
            if (!$list)
            {
                redirect('admin/exams');
            }

            $pps = $this->exams_m->fetch_student_list($list->id);

            foreach ($pps as $mk)
            {
                $marks = $this->exams_m->fetch_done_list($sb, $mk->id);
                $rest[$mk->student]['marks'] = $marks;
                $rest[$mk->student]['total'] = $mk->total;
                $rest[$mk->student]['remarks'] = $mk->remarks;
            }
        }
        $data['sel_gd'] = $gdd;
        $data['list_subjects'] = $this->exams_m->list_subjects();
        $data['subjects'] = $subjects;
        $data['count_subjects'] = $this->exams_m->count_subjects($class_id, $exam->term);
        $data['full_subjects'] = $this->exams_m->get_full_subjects();
        $data['grading'] = $this->exams_m->get_grading_system();
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = '';
        $data['exams'] = $this->exams_m->list_exams();
        //Rules for validation
        $this->form_validation->set_rules($this->rec_validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            if ($this->input->get('sb'))
            {
                $mkpost = $this->input->post();
                $sbj = $this->input->get('sb');

                $inc = array();
                if (isset($mkpost['done']))
                {
                    $inc = $mkpost['done'];
                }
                $marks = $this->input->post('marks');
                $gd_id = $this->input->post('grading');
                $units = $this->input->post('units');

                $user = $this->ion_auth->get_user();
                $this->exams_m->set_grading($exid, $id, $sbj, $gd_id, $user->id); //update grading system
                $perf_list = array();
                $sub_marks = array();

                if ($units)
                {
                    foreach ($units as $stid => $unmarks)
                    {
                        foreach ($unmarks as $uid => $mk)
                        {
                            $sunits[] = array(
                                'parent' => $sbj,
                                'unit' => $uid,
                                'marks' => $mk
                            );
                        }
                    }
                }

                foreach ($marks as $std => $score)
                {
                    $sunits = array();
                    $sub_marks = array(
                        'subject' => $sb,
                        'marks' => $score
                    );
                    if ($units && isset($units[$std]))
                    {
                        $mine = $units[$std];
                        foreach ($mine as $uid => $mk)
                        {
                            $sunits[] = array(
                                'parent' => $sbj,
                                'unit' => $uid,
                                'marks' => $mk
                            );
                        }
                    }
                    $perf_list[] = array(
                        'exams_id' => $xm->id,
                        'student' => $std,
                        'marks' => $sub_marks,
                        'units' => $sunits,
                                      // 'remarks' => isset($remarks[$std]) ? $remarks[$std] : ''
                    );
                }

                foreach ($perf_list as $dat)
                {
                    $dat = (object) $dat;
                    $list_id = $this->exams_m->get_update_target($dat->student, $dat->exams_id);
                    $mm = (object) $dat->marks;
                    $mkcon = $mm->marks ? $mm->marks : 0;

                    $mod = array(
                        'inc' => isset($inc[$dat->student]) ? 1 : 0,
                        'marks' => $mkcon,
                        'modified_by' => $user->id,
                        'modified_on' => time()
                    );

                    if ($this->exams_m->has_rec($list_id, $mm->subject))
                    {
                        $this->exams_m->update_marks($list_id, $mm->subject, $mod);

                        if (isset($dat->units) && count($dat->units))
                        {
                            foreach ($dat->units as $sm)
                            {
                                $sm = (object) $sm;
                                $svalues = array(
                                    'marks' => $sm->marks,
                                    'modified_by' => $user->id,
                                    'modified_on' => time()
                                );
                                $this->exams_m->update_sub_marks($list_id, $sm->parent, $sm->unit, $svalues);
                            }
                        }
                    }
                    else
                    {
                        $mklist = $this->_prep_marks($sb, $xm->id, $marks, $units);

                        foreach ($mklist as $dat)
                        {
                            $dat = (object) $dat;
                            $values = array(
                                'exams_id' => $dat->exams_id,
                                'student' => $dat->student,
                                // 'total' => $dat->total,
                                // 'remarks' => $dat->remarks,
                                'created_by' => $user->id,
                                'created_on' => time()
                            );
                            $list_id = $this->exams_m->create_list($values);

                            $mm = (object) $dat->marks;
                            $fvalues = array(
                                'exams_list_id' => $list_id,
                                'marks' => $mm->marks ? $mm->marks : 0,
                                'subject' => $mm->subject,
                                'inc' => isset($inc[$dat->student]) ? 1 : 0,
                                'created_by' => $user->id,
                                'created_on' => time()
                            );
                            $this->exams_m->insert_marks($fvalues);

                            if (isset($dat->units) && count($dat->units))
                            {
                                foreach ($dat->units as $sm)
                                {
                                    $sm = (object) $sm;
                                    $svalues = array(
                                        'marks_list_id' => $list_id,
                                        'parent' => $sm->parent,
                                        'unit' => $sm->unit,
                                        'marks' => $sm->marks,
                                        'created_by' => $user->id,
                                        'created_on' => time()
                                    );
                                    $this->exams_m->insert_subs($svalues);
                                }
                            }
                        }
                    }
                }

                if (TRUE)
                {
                    //$details = implode(' , ', $form_data);
                    $user = $this->ion_auth->get_user();
                    $log = array(
                        'module' => $this->router->fetch_module(),
                        'item_id' => $list_id,
                        'transaction_type' => $this->router->fetch_method(),
                        'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $list_id,
                        'details' => 'update done',
                        'created_by' => $user->id,
                        'created_on' => time()
                    );

                    $this->ion_auth->create_log($log);

                    $this->session->set_flashdata('message', array('type' => 'success', 'text' => 'Update Successful'));
                }
                else
                {
                    $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Update Failed'));
                }
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Subject Not Specified'));
            }
            redirect('admin/exams/');
        }
        else
        {
            $data['assign'] = $sel;
            $data['class_name'] = $heading;
            $data['result'] = $rest;
            $data['students'] = $students;
            $data['sb'] = $sb;
            $data['class_id'] = $id;
            $data['exam_id'] = $exid;

            $this->template->title('Update Exam Marks')->build('admin/upper_edit', $data);
        }
    }

    /**
     * Record Class Teacher's Remarks for Pre School Exams
     * 
     * @param int $exam_id Exam ID
     * @param int $id Class
     */
    function rec_lower($exam_id, $id)
    {
        $tar = $this->exams_m->get_stream($id);

        $class = $tar->class;
        $stream = $tar->stream;
        $data['students'] = $this->exams_m->get_students($class, $stream);

        //create control variables
        $data['updType'] = 'create';
        $data['page'] = '';
        $this->form_validation->set_rules($this->lower_validation());

        //validate the fields of form
        if ($this->form_validation->run())
        {
            //
        }
        else
        {
            $get = new StdClass();
            foreach ($this->validation() as $field)
            {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['result'] = $get;
            $data['class'] = $id;
            $data['exm'] = $exam_id;
            //load the view and the layout
            if ($this->ion_auth->is_in_group($this->user->id, 3))
            {
                $this->template
                                  ->title('Record Performance')
                                  ->set_layout('teachers')
                                  ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                  ->set_partial('teachers_top', 'partials/teachers_top.php')
                                  ->build('admin/rec_lower', $data);
            }
            else
            {
                $this->template->title('Record Performance')->build('admin/rec_lower', $data);
            }
        }
    }

    /**
     * Show Report Form
     * 
     * @param type $exam
     * @param type $student
     */
    public function report($exam, $student)
    {
        if (!$exam || !$student)
        {
            redirect('admin/exams');
        }
        $xm = $this->exams_m->find($exam);
        $obst = $this->worker->get_student($student);
        $tar = $this->exams_m->get_stream($obst->class);

        $rec = $this->exams_m->is_recorded($exam);
        $has = TRUE;
        if (!$xm || !$rec)
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
            $has = FALSE;
        }

        $data['report'] = $this->exams_m->get_report($exam, $student);
        $data['exam'] = $xm;
        $data['subjects'] = $this->exams_m->get_subjects($tar->class, $xm->term, 1);
        $data['full'] = $this->exams_m->list_subjects(1);
        $st = $this->worker->get_student($student);
        $this->load->model('reports/reports_m');
        $dcl = $this->reports_m->get_class_by_year($student, $xm->year);
        $did = $this->exams_m->get_by_class($dcl->class, $dcl->stream);

        $streams = $this->exams_m->populate('class_stream', 'id', 'name');
        $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
        $data['student'] = $st;
        $data['proc'] = $has;
        $data['streams'] = $streams;
        $data['cls'] = $did;

        if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->template
                              ->title('Report Form')
                              ->set_layout('teachers')
                              ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                              ->set_partial('teachers_top', 'partials/teachers_top.php')
                              ->build('admin/show', $data);
        }
        else
        {
            $this->template->title('Report Form ')->set_layout('print')->build('admin/show', $data);
        }
    }

    /**
     * Generate Report Forms
     * 
     * @param $exam
     */
    public function results($exam)
    {
        $get = new StdClass();

        $data['result'] = $get;
        $data['exam'] = $exam;
        $data['classes'] = $this->classlist;
        $range = range(date('Y') - 1, date('Y') + 1);
        $data['yrs'] = array_combine($range, $range);
        //load view
        if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->template
                              ->title('Generate Report Forms')
                              ->set_layout('teachers')
                              ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                              ->set_partial('teachers_top', 'partials/teachers_top.php')
                              ->build('admin/reports', $data);
        }
        else
        {
            $this->template->title('Generate Report Forms ')->build('admin/reports', $data);
        }
    }

    /**
     * Record Remarks
     * 
     * @param int $exam
     * @param int $id Class ID
     * @param int $student
     */
    function create_lower($exam, $id, $student)
    {
        $tar = $this->exams_m->get_stream($id);
        $this->load->model('reports/reports_m');
        $class = $tar->class;
        $stream = $tar->stream;
        $exm = $this->exams_m->find($exam);
        $data['students'] = $this->exams_m->get_students($class, $stream);
        $data['subjects'] = $this->exams_m->get_subjects($class, $exm->term);

        $dcl = $this->reports_m->get_class_by_year($student, $exm->year);

        $data['cls'] = $this->exams_m->get_by_class($dcl->class, $dcl->stream);
        $data['list_subjects'] = $this->exams_m->list_subjects();
        $data['subtests'] = $this->exams_m->fetch_sub_tests();
        $data['count_subjects'] = $this->exams_m->count_subjects($class, $exm->term);
        $data['full_subjects'] = $this->exams_m->get_full_subjects();
        //create control variables
        $data['updType'] = 'create';
        $data['exams'] = $this->exams_m->list_exams();
        $data['remarks'] = $this->exams_m->fetch_by_exam($exam, $student);
        $data['full'] = $this->exams_m->fetch_gen_remarks($exam, $student);
        $get = new StdClass();
        foreach ($this->validation() as $field)
        {
            $get->{$field['field']} = set_value($field['field']);
        }

        $data['result'] = $get;
        $data['student'] = $student;
        $data['class'] = $class;
        $data['id'] = $id;
        $data['row'] = $exm;
        $data['exam'] = $exam;
        $this->load->library('Dates');
        //load the view and the layout
        if ($this->ion_auth->is_in_group($this->user->id, 3))
        {
            $this->template
                              ->title('Record Performance')
                              ->set_layout('teachers')
                              ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                              ->set_partial('teachers_top', 'partials/teachers_top.php')
                              ->build('admin/lower', $data);
        }
        else
        {
            $this->template->title('Record Performance')->build('admin/lower', $data);
        }
    }

    /**
     * Process Quick Edits
     * 
     * @param int $exam
     */
    function push_lower($exam = 0)
    {
        $tarr = $this->input->post('name');
        $student = $this->input->post('pk');
        $dta = $this->input->post('value');
        $user = $this->ion_auth->get_user();
        if ($tarr && $exam && $student && $dta)
        {
            $dest = explode('_', $tarr);
            if (count($dest))
            {
                $par = $dest[1];
                if (count($dest) == 3)
                {
                    $subb = $dest[2];
                }
                elseif (count($dest) == 2)
                {
                    $subb = 9999;
                }
                else
                {
                    ///
                }
                $rmk = array(
                    'sub_id' => $subb,
                    'remarks' => $dta,
                    'student' => $student,
                    'exam' => $exam,
                    'parent' => $par,
                );
                $ex_id = $this->exams_m->rmak_exists($par, $subb, $exam, $student);
                if ($ex_id)
                {
                    //update marks
                    $this->exams_m->update_remarks($ex_id, $rmk + array('created_by' => $user->id, 'created_on' => time()));
                }
                else
                {
                    //fresh insert
                    $this->exams_m->save_remarks($rmk + array('modified_by' => $user->id, 'modified_on' => time()));
                }
            }
        }
    }

    function push_remarks($exam = 0)
    {
        $remk = $this->input->post('value');
        $student = $this->input->post('pk');
        $user = $this->ion_auth->get_user();

        if ($exam && $remk)
        {
            $rmk = array(
                'remarks' => $remk,
                'student' => $student,
                'exam' => $exam
            );
            $ex_id = $this->exams_m->gen_exists($exam, $student);
            if ($ex_id)
            {
                //update marks
                $this->exams_m->update_gen_remarks($ex_id, $rmk, array('created_by' => $user->id, 'created_on' => time()));
            }
            else
            {
                //fresh insert
                $this->exams_m->save_gen_remarks($rmk + array('modified_by' => $user->id, 'modified_on' => time()));
            }
        }
    }

    function push_attendance($exam = 0)
    {
        $att = $this->input->post('value');
        $student = $this->input->post('pk');
        $user = $this->ion_auth->get_user();

        if ($exam && $att)
        {
            $rmk = array(
                'att' => $att,
                'student' => $student,
                'exam' => $exam
            );
            $ex_id = $this->exams_m->gen_exists($exam, $student);
            if ($ex_id)
            {
                //update marks
                $this->exams_m->update_gen_remarks($ex_id, $rmk, array('modified_by' => $user->id, 'modified_on' => time()));
            }
            else
            {
                //fresh insert
                $this->exams_m->save_gen_remarks($rmk + array('created_by' => $user->id, 'created_on' => time()));
            }
        }
    }

    function save_total($exam = 0)
    {
        $out = $this->input->post('value');
        $student = $this->input->post('pk');
        $user = $this->ion_auth->get_user();

        if ($exam && $out)
        {
            $rmk = array(
                'out_of' => $out,
                'student' => $student,
                'exam' => $exam
            );
            $ex_id = $this->exams_m->gen_exists($exam, $student);
            if ($ex_id)
            {
                //update marks
                $this->exams_m->update_gen_remarks($ex_id, $rmk, array('modified_by' => $user->id, 'modified_on' => time()));
            }
            else
            {
                //fresh insert
                $this->exams_m->save_gen_remarks($rmk + array('created_by' => $user->id, 'created_on' => time()));
            }
        }
    }

    /**
     * Add New Exam
     * 
     * @param type $page
     */
    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $data['page'] = ( $this->uri->segment(4) ) ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());
        $range = range(date('Y') - 50, date('Y'));
        $data['yrs'] = array_combine($range, $range);
        //validate the fields of form
        if ($this->form_validation->run())
        {         //Validation OK!
            $user = $this->ion_auth->get_user();
            $form_data = array(
                'title' => $this->input->post('title'),
                'term' => $this->input->post('term'),
                'year' => $this->input->post('year'),
                'weight' => $this->input->post('weight'),
                'start_date' => strtotime($this->input->post('start_date')),
                'end_date' => strtotime($this->input->post('end_date')),
                'recording_end_date' => strtotime($this->input->post('recording_end_date')),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );
			
	

            $ok = $this->exams_m->create($form_data);

            if ($ok)
            {
                $details = implode(' , ', $this->input->post());
                $user = $this->ion_auth->get_user();
                $log = array(
                    'module' => $this->router->fetch_module(),
                    'item_id' => $ok,
                    'transaction_type' => $this->router->fetch_method(),
                    'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $ok,
                    'details' => $details,
                    'created_by' => $user->id,
                    'created_on' => time()
                );

                $this->ion_auth->create_log($log);

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            }
            else
            {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/exams/');
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
         
                $this->template->title('Add Exams')->build('admin/create', $data);
            
        }
    }
	
	 /**
         * Edit Exam 
         * 
         * @param type $id
         * @param type $page
         */
        function edit($id = FALSE, $page = 0)
        {
                //redirect if no $id
                if (!$id)
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/exams/');
                }
                if (!$this->exams_m->exists($id))
                {
                        $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
                        redirect('admin/exams');
                }
                //search the item to show in edit form
                $get = $this->exams_m->find($id);

                //Rules for validation
                $this->form_validation->set_rules($this->validation());

                //create control variables
                $data['updType'] = 'edit';
                $data['page'] = $page;

                if ($this->form_validation->run())  //validation has been passed
                {
                        $user = $this->ion_auth->get_user();
                        // build array for the model
                        $form_data = array(
                            'title' => $this->input->post('title'),
                            'term' => $this->input->post('term'),
                            'year' => $this->input->post('year'),
                            'weight' => $this->input->post('weight'),
                            'start_date' => strtotime($this->input->post('start_date')),
                            'end_date' => strtotime($this->input->post('end_date')),
                            'recording_end_date' => strtotime($this->input->post('recording_end_date')),
                            'description' => $this->input->post('description'),
                            'modified_by' => $user->id,
                            'modified_on' => time());

                        $done = $this->exams_m->update_attributes($id, $form_data);

                        if ($done)
                        {
                                $details = implode(' , ', $this->input->post());
								$user = $this->ion_auth->get_user();
									$log = array(
										'module' =>  $this->router->fetch_module(), 
										'item_id' => $done, 
										'transaction_type' => $this->router->fetch_method(), 
										'description' => base_url('admin').'/'.$this->router->fetch_module().'/'.$this->router->fetch_method().'/'.$done, 
										'details' => $details,   
										'created_by' => $user -> id,   
										'created_on' => time()
									);

								  $this->ion_auth->create_log($log);

							   $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                                redirect("admin/exams/");
                        }
                        else
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                                redirect("admin/exams/");
                        }
                }
                else
                {
                        foreach (array_keys($this->validation()) as $field)
                        {
                                if (isset($_POST[$field]))
                                {
                                        $get->$field = $this->form_validation->$field;
                                }
                        }
                }
                $range = range(date('Y') - 50, date('Y'));
                $data['yrs'] = array_combine($range, $range);
                $data['result'] = $get;
                //load the view and the layout

                if ($this->ion_auth->is_in_group($this->user->id, 3))
                {
                        $this->template
                                     ->title('Edit Exams')
                                     ->set_layout('teachers')
                                     ->set_partial('teachers_sidebar', 'partials/teachers_sidebar.php')
                                     ->set_partial('teachers_top', 'partials/teachers_top.php')
                                     ->build('admin/create', $data);
                }
                else
                {
                        $this->template->title('Edit Exams ')->build('admin/create', $data);
                }
        }



    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id)
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/exams');
        }

        //search the item to delete
        if (!$this->exams_m->exists($id))
        {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/exams');
        }

        //delete the item
        if ($this->exams_m->delete($id) == TRUE)
        {
            //$details = implode(' , ', $this->input->post());
            $user = $this->ion_auth->get_user();
            $log = array(
                'module' => $this->router->fetch_module(),
                'item_id' => $id,
                'transaction_type' => $this->router->fetch_method(),
                'description' => base_url('admin') . '/' . $this->router->fetch_module() . '/' . $this->router->fetch_method() . '/' . $id,
                'details' => 'Record Deleted',
                'created_by' => $user->id,
                'created_on' => time()
            );

            $this->ion_auth->create_log($log);

            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        }
        else
        {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/exams/");
    }

    /**
     * Validation for Record Remarks
     * 
     * @return array
     */
    private function lower_validation()
    {
        $config = array(
            array(
                'field' => 'student',
                'label' => 'Student',
                'rules' => '')
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    private function _ap_validation()
    {
        $config = array(
            array(
                'field' => 'student',
                'label' => 'Student Name',
                'rules' => 'required'),
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required'),
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'required'),
            array(
                'field' => 'uniform',
                'label' => 'Correct Uniform',
                'rules' => 'required'),
            array(
                'field' => 'shoes',
                'label' => 'Shoes',
                'rules' => 'required'),
            array(
                'field' => 'hygiene',
                'label' => 'Personal Hygiene',
                'rules' => 'required'),
            array(
                'field' => 'neatness',
                'label' => 'Neatness',
                'rules' => 'required'),
            array(
                'field' => 'creativity',
                'label' => 'Creativity',
                'rules' => 'required'),
            array(
                'field' => 'swimming',
                'label' => 'Swimming',
                'rules' => 'required'),
            array(
                'field' => 'games',
                'label' => 'Games / P.E',
                'rules' => 'required'),
            array(
                'field' => 'clubs',
                'label' => 'Clubs',
                'rules' => 'required'),
            array(
                'field' => 'respect',
                'label' => 'Respect For Teachers',
                'rules' => 'required'),
            array(
                'field' => 'polite',
                'label' => 'Polite To Schoolmates',
                'rules' => 'required'),
            array(
                'field' => 'help',
                'label' => 'Willingness to Help Others',
                'rules' => 'required'),
            array(
                'field' => 'discipline',
                'label' => 'Self Discipline',
                'rules' => 'required'),
            array(
                'field' => 'behaviour',
                'label' => 'Class Behaviour',
                'rules' => 'required'),
            array(
                'field' => 'confidence',
                'label' => 'Confidence',
                'rules' => 'required'),
            array(
                'field' => 'teamwork',
                'label' => 'Team Spirit',
                'rules' => 'required'),
            array(
                'field' => 'parent_coop',
                'label' => 'Parent Cooperation',
                'rules' => 'required'),
            array(
                'field' => 'presentation',
                'label' => 'Work Presentation',
                'rules' => 'required'),
            array(
                'field' => 'handwriting',
                'label' => 'Handwriting',
                'rules' => 'required'),
            array(
                'field' => 'assignments',
                'label' => 'Completion of Class Assignments',
                'rules' => 'required'),
            array(
                'field' => 'homework',
                'label' => 'Completion of Homework',
                'rules' => 'required'),
            array(
                'field' => 'stationery',
                'label' => 'Stationery',
                'rules' => 'required'),
            array(
                'field' => 'diary',
                'label' => 'School Diary',
                'rules' => 'required'),
            array(
                'field' => 'books',
                'label' => 'Exercise Books',
                'rules' => 'required')
        );
        $this->form_validation->set_error_delimiters("<span class='error'>", '</span>');
        return $config;
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]'),
            array(
                'field' => 'start_date',
                'label' => 'Start Date',
                'rules' => 'required|xss_clean'),
            array(
                'field' => 'end_date',
                'label' => 'End Date',
                'rules' => 'required|xss_clean'),

				array(
                'field' => 'recording_end_date',
                'label' => 'Recording end date',
                'rules' => 'trim|required'),
            array(
                'field' => 'weight',
                'label' => 'Weight',
                'rules' => 'xss_clean'),
            array(
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'trim|xss_clean|min_length[0]|max_length[500]'),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }

    /**
     * Get Datatable
     * 
     */
    public function get_table($id)
    {
        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);

        $output = $this->exams_m->list_results($id, $iDisplayStart, $iDisplayLength, $iSortCol_0, $iSortingCols, $sSearch, $sEcho);

        echo json_encode($output);
    }

    /**
     * Record Exams Validation
     * 
     * @return array
     */
    private function rec_validation()
    {

        $config = array(
            array(
                'field' => 'record_date',
                'label' => 'Record Date',
                'rules' => 'xss_clean'),
            array(
                'field' => 'exam_type',
                'label' => 'The Exam',
                'rules' => 'trim|xss_clean'),
            array(
                'field' => 'subject[]',
                'label' => 'Subject',
                'rules' => 'xss_clean'),
            array(
                'field' => 'student[]',
                'label' => 'student',
                'rules' => 'xss_clean'),
            array(
                'field' => 'total[]',
                'label' => 'Total',
                'rules' => 'xss_clean'),
            array(
                'field' => 'marks[]',
                'label' => 'Marks',
                'rules' => 'xss_clean'),
            array(
                'field' => 'grading',
                'label' => 'Grading',
                'rules' => 'required'),
            array(
                'field' => 'remarks[]',
                'label' => 'Remarks',
                'rules' => 'xss_clean'),
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/exams/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->exams_m->count();
        $config['uri_segment'] = 4;

        $config['first_link'] = lang('web_first');
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = lang('web_last');
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = FALSE;
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = FALSE;
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active">  <a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = "<li>";
        $config['num_tag_close'] = '</li>';
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul>';
        $config['full_tag_close'] = '</ul></div>';

        return $config;
    }

}
