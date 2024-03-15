<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parents extends Public_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('cbc_m');
        if (!$this->ion_auth->logged_in())
        {
            redirect('/login');
        }
        if (!$this->ion_auth->is_in_group($this->user->id, 6))
        {
            redirect('login');
        }
        $this->template
                          ->set_layout('default.php')
                          ->set_partial('meta', 'partials/meta.php')
                          ->set_partial('header', 'partials/header.php')
                          ->set_partial('sidebar', 'partials/sidebar.php')
                          ->set_partial('footer', 'partials/footer.php');
        $this->load->library('Dates');
    }

    public function assessment()
    {
        $kids = [];
        foreach ($this->parent->kids as $k)
        {
            $kids[] = $k->student_id;
        }

        $assess = [];
        $summ = $this->cbc_m->get_summative_list($kids);

        $list = $this->cbc_m->get_assess_list($kids);
        foreach ($list as $s)
        {
            $assess['assess'][$s->student][$s->class][$s->year][$s->term][] = $s->subject;
        }
        foreach ($summ as $sm)
        {
            $assess['summ'][$sm->student][$sm->class][$sm->year][$sm->term][] = $sm->gen_remarks;
        }

        $res = [];
        foreach ($this->classlist as $k => $v)
        {
            $res[$k] = $v['name'];
        }
        $result = [];

        foreach ($assess as $type => $rubrk)
        {
            foreach ($rubrk as $st => $classes)
            {
                $sn = $this->worker->get_student($st);
                foreach ($classes as $class => $yrs)
                {
                    foreach ($yrs as $yr => $terms)
                    {
                        foreach ($terms as $tm => $mk)
                        {
                            $result[] = [
                                'sid' => $st,
                                'student' => $sn->first_name . ' ' . $sn->last_name,
                                'class' => isset($res[$class]) ? $res[$class] : ' - ',
                                'year' => $yr,
                                'term' => $tm,
                                'cat' => $type == 'assess' ? 1 : 2,
                                'subs' => $type == 'assess' ? $mk : [],
                            ];
                        }
                    }
                }
            }
        }

        $data['assess'] = aasort($result, 'year', 1);
        $data['classes'] = $res;
        $data['subjects'] = $this->cbc_m->populate('cbc_subjects', 'id', 'name');
        //load view
        $this->template->title('CBC Assessment Report')->build('parent/list', $data);
    }

    public function report($student = 0, $subject = 0, $term = 0, $year = 0)
    {
        $options = $this->cbc_m->populate('cbc_subjects', 'id', 'name');
        if ($this->input->post())
        {
            $subj = $this->input->post('subject');
            $s_term = $this->input->post('term');
            $s_year = $this->input->post('year');

            redirect('parents/cbc/report/' . $student . '/' . $subj . '/' . $s_term . '/' . $s_year . '?p=1');
        }

        $kids = [];
        foreach ($this->parent->kids as $k)
        {
            $kids[] = $k->student_id;
        }
        $f_subs = [];
        $list = $this->cbc_m->get_assess_list($kids);
        foreach ($list as $s)
        {
            $f_subs[$s->subject] = isset($options[$s->subject]) ? $options[$s->subject] : '-';
        }

        $res = [];
        foreach ($this->classlist as $k => $v)
        {
            $res[$k] = $v['name'];
        }

        $data['classes'] = $res;
        $data['subjects'] = $f_subs;
        $data['sel'] = $subject;
        $data['student'] = $student;
        $data['term'] = $term;
        $data['year'] = $year;

        $assess = [];
        if ($subject && $student && $term && $year)
        {
            $fn = $this->cbc_m->get_assess_st($student, $subject, $term, $year);

            $sv = [];
            if (!empty($fn))
            {
                $strands = $this->cbc_m->get_assess_strands($fn->id);
                $subs = $this->cbc_m->get_assess_subs($fn->id);
                $tasks = $this->cbc_m->get_assess_tasks($fn->id);

                if (empty($strands))
                {
                    if (empty($subs))
                    {
                        if (!empty($tasks))
                        {
                            //build 2 upper levels for $strand & $substrand
                            $fnw = [];
                            foreach ($tasks as $k)
                            {
                                $sv[$student][$k->strand]['rating'] = '';
                                $fnw[] = ['task' => $k->task, 'rating' => $k->rating];
                                $sv[$student][$k->strand]['subs'][$k->sub_strand] = ['remarks' => '', 'rating' => ''];
                                $sv[$student][$k->strand]['subs'][$k->sub_strand]['tasks'] = $fnw;
                            }
                        }
                        //all empty  - return empty array
                    }
                    else
                    {
                        //has $subs & maybe $tasks
                        $rt = [];
                        foreach ($subs as $sb)
                        {
                            $sv[$student][$sb->strand]['rating'] = $sb->rating;
                            $sv[$student][$sb->strand]['subs'][$sb->sub_strand] = ['remarks' => $sb->remarks, 'rating' => $sb->rating];

                            $fnw = [];
                            foreach ($tasks as $t)
                            {
                                $sv[$student][$t->strand]['subs'][$t->sub_strand]['tasks'][$t->task] = ['task' => $t->task, 'rating' => $t->rating];
                            }
                        }
                    }
                }
                else
                {
                    foreach ($strands as $str)
                    {
                        $sv[$student][$str->strand]['rating'] = $str->rating;
                        $rt = [];

                        if (empty($subs))
                        {
                            //handle empty subs when tasks not empty
                        }
                        else
                        {
                            foreach ($subs as $sb)
                            {
                                $sv[$student][$str->strand]['subs'][$sb->sub_strand] = ['remarks' => $sb->remarks, 'rating' => $sb->rating];

                                foreach ($tasks as $t)
                                {
                                    $sv[$student][$t->strand]['subs'][$t->sub_strand]['tasks'][$t->task] = ['task' => $t->task, 'rating' => $t->rating];
                                }
                            }
                        }
                    }
                }

                $las = $this->cbc_m->populate('cbc_la', 'id', 'name');
                $substrands = $this->cbc_m->populate('cbc_topics', 'id', 'name');
                $task_opts = $this->cbc_m->populate('cbc_tasks', 'id', 'name');
                foreach ($sv as $student => $p_assess)
                {
                    $tm = [];
                    $ppl = $this->worker->get_student($student);
                    $name = $ppl->first_name . ' ' . $ppl->last_name;
                    $age = $ppl->dob > 10000 ? $this->dates->createFromTimeStamp($ppl->dob)->diffInYears() : '-';

                    foreach ($p_assess as $strd => $rated)
                    {
                        $stw = isset($las[$strd]) ? $las[$strd] : ' - ';
                        $rmk = [];
                        if (isset($rated['subs']))
                        {
                            foreach ($rated['subs'] as $k_s => $r)
                            {
                                $sub_name = isset($substrands[$k_s]) ? $substrands[$k_s] : ' - ';
                                $fn = [];
                                if (isset($r['tasks']))
                                {
                                    foreach ($r['tasks'] as $tk)
                                    {
                                        $t_name = isset($task_opts[$tk['task']]) ? $task_opts[$tk['task']] : ' - ';
                                        $fn[] = (object) ['task' => $t_name, 'rating' => $tk['rating']];
                                    }
                                }
                                $rmk[] = (object) ['name' => $sub_name, 'rating' => isset($r['rating']) ? $r['rating'] : '', 'remarks' => isset($r['remarks']) ? $r['remarks'] : '', 'tasks' => $fn];
                            }
                        }
                        $tm[] = (object) ['name' => $stw, 'rating' => isset($rated['rating']) ? $rated['rating'] : '', 'subs' => $rmk];
                    }

                    $assess = (object) ['student' => $name, 'class' => $ppl->cl->name, 'adm' => $ppl->admission_number, 'age' => $age, 'strands' => $tm];
                }
            }
        }
        $data['assess'] = $assess;
        //load view
        $this->template->title('View CBC Assessment Report')->build('parent/assess_report', $data);
    }

    public function summative($student = 0, $term = 0, $year = 0)
    {
        if (!$student || !$term || !$year)
        {
            redirect('parents/cbc/assessment');
        }
        if ($this->input->post())
        {
            $s_term = $this->input->post('term');
            $s_year = $this->input->post('year');

            redirect('parents/cbc/summative/' . $student . '/' . $s_term . '/' . $s_year . '?p=1');
        }

        $assess = [];
        $summ = $this->cbc_m->get_summ_st($student, $term, $year);
        if (!empty($summ))
        {
            $rw = $this->cbc_m->fetch_class($summ->class);

            if (empty($rw))
            {
                redirect('parents/cbc/assessment');
            }

            $subjects = $this->cbc_m->get_subjects($rw->class);

            $fsub = [];
            $ids = [];
            foreach ($subjects as $s)
            {
                $fsub[$s->subject] = $s->name;
                $ids[] = $s->subject;
            }

            $ex = [];
            $saved = [];
            $merged = [];

            $subs = $this->cbc_m->get_summ_ratings($summ->id);

            foreach ($subs as $s)
            {
                $ex[$s->exam] = $s->exam;
                $saved[$student][$s->subject][$s->exam] = $s->rating;
            }

            foreach ($saved as $st => $fs)
            {
                foreach ($ids as $id)
                {
                    if (!isset($fs[$id]))
                    {
                        foreach ($ex as $ex_id)
                        {
                            $fs[$id][$ex_id] = '';
                        }
                    }
                }
                $nw_mk = [];
                foreach ($fs as $sub_id => $exams)
                {
                    foreach ($ex as $ex_id)
                    {
                        if (!isset($exams[$ex_id]))
                        {
                            $exams[$ex_id] = '';
                        }
                    }
                    ksort($exams);
                    $nw_mk[$sub_id] = $exams;
                }
                ksort($nw_mk);
                $merged[$st] = $nw_mk;
            }

            foreach ($merged as $student => $rbk)
            {
                foreach ($rbk as $sid => $mk)
                {
                    $subj = isset($fsub[$sid]) ? $fsub[$sid] : ' - ';
                    $rmk = [];
                    foreach ($mk as $k_m => $m)
                    {
                        $rmk['exam_' . $k_m] = $m;
                    }
                    $assess[] = ['subject' => $subj, 'exams' => $rmk];
                }
            }
        }
        $data['summ'] = $summ;
        $data['assess'] = $assess;

        $rw_student = $this->worker->get_student($student);
        $rw_student->age = $rw_student->dob > 10000 ? $this->dates->createFromTimeStamp($rw_student->dob)->diffInYears() : '-';
        $data['student'] = $rw_student;

        $data['term'] = $term;
        $data['year'] = $year;
        $this->template->title('View CBC Assessment Report')->build('parent/summative', $data);
    }

    public function summative_bk($student = 0, $term = 0, $year = 0)
    {
        if ($this->input->post())
        {
            $s_term = $this->input->post('term');
            $s_year = $this->input->post('year');

            redirect('parents/cbc/summative/' . $student . '/' . $s_term . '/' . $s_year . '?p=1');
        }

        $summ = [];
        $assess = [];
        if ($student && $term && $year)
        {
            $summ = $this->cbc_m->get_summ_st($student, $term, $year);
            $fscore = $this->cbc_m->get_summ_ratings($summ->id);
            foreach ($fscore as $f)
            {
                $assess[$f->exam][$f->subject] = $f->rating;
            }
            ksort($assess);
        }

        $data['summ'] = $summ;
        $data['assess'] = $assess;

        $rw_student = $this->worker->get_student($student);
        $rw_student->age = $rw_student->dob > 10000 ? $this->dates->createFromTimeStamp($rw_student->dob)->diffInYears() : '-';
        $data['student'] = $rw_student;

        $data['term'] = $term;
        $data['year'] = $year;
        $data['subjects'] = $this->cbc_m->populate('cbc_subjects', 'id', 'name');
        $this->template->title('View CBC Assessment Report')->build('parent/summative', $data);
    }

}
