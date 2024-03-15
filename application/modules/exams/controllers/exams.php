<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Exams extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->template->set_layout('default');
                $this->template
                             ->set_layout('default.php')
                             ->set_partial('meta', 'partials/meta.php')
                             ->set_partial('header', 'partials/header.php')
                             ->set_partial('sidebar', 'partials/sidebar.php')
                             ->set_partial('footer', 'partials/footer.php');
                $this->load->library('Dates');
                $this->load->model('exams_m');
        }

        function results()
        {
                if (!$this->parent)
                {
                        redirect('account');
                }
                $has = TRUE;
                $remk = FALSE;
                if ($this->input->post('student') && $this->input->post('exam'))
                {
                        $student = $this->input->post('student');
                        $exam = $this->input->post('exam');
                        $xm = $this->exams_m->find($exam);
                        $rec = $this->exams_m->is_recorded($exam);

                        $st = $this->worker->get_student($student);
                        $cls = $this->exams_m->get_stream($st->class);
                        $data['subjects'] = $this->exams_m->get_subjects($cls->class, $xm->term);
                        if ($cls->rec == 2)
                        {
                                $remk = TRUE;
                        }

                        if (!$xm || !$rec)
                        {
                                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Marks Not Found'));
                                $has = FALSE;
                        }
                        if ($remk)
                        {
                                $data['remarks'] = $this->exams_m->fetch_by_exam($exam, $student);
                                $data['full'] = $this->exams_m->fetch_gen_remarks($exam, $student);
                        }
                        else
                        {
                                $mine = $this->exams_m->get_report($exam, $student);
                                $data['report'] = $mine;
                        }

                        $data['grading'] = $xm ? $this->exams_m->get_grading($xm->grading) : array();

                        $data['exam'] = $xm;
                        $data['full_subjects'] = $this->exams_m->get_full_subjects();

                        $streams = $this->exams_m->populate('class_stream', 'id', 'name');
                        $data['s_units'] = $this->exams_m->populate('sub_cats', 'id', 'title');
                        $data['student'] = $st;
                        $data['streams'] = $streams;
                        $data['cls'] = $cls;
                }
                else
                {
                        $has = FALSE;
                }
                $data['proc'] = $has;
                $fks = array();
                $this->load->model('admission/admission_m');

                foreach ($this->parent->kids as $k)
                {
                        $usr = $this->admission_m->find($k->student_id);

                        $fks[$k->student_id] = trim($usr->first_name . ' ' . $usr->last_name);
                }

                $data['kids'] = $fks;
                $data['remk'] = $remk;
                $data['exams'] = $this->exams_m->fetch_all_exams();
                $this->template->title(' View Exam Results')->build('index/results', $data);
        }

}
