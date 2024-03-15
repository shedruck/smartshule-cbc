<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        /*$this->template->set_layout('default');
			$this->template->set_partial('sidebar','partials/sidebar.php')
                    -> set_partial('top', 'partials/top.php');*/
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/login');
        }
        $this->load->model('igcse_m');
        $this->load->model('exams/exams_m');
        $this->load->model('teachers/teachers_m');
    }

    public function index()
    {
        $config = $this->set_paginate_options(); //Initialize the pagination class
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $data['igcse'] = $this->igcse_m->paginate_all($config['per_page'], $page);

        //create pagination links
        $data['links'] = $this->pagination->create_links();
        $data['classes'] = $this->exams_m->list_classes();

        //page number  variable
        $data['page'] = $page;
        $data['per'] = $config['per_page'];

        //load view
        $this->template->title(' Igcse ')->build('admin/list', $data);
    }

    function create($page = NULL)
    {
        //create control variables
        $data['updType'] = 'create';
        $form_data_aux  = array();
        $data['page'] = ($this->uri->segment(4))  ? $this->uri->segment(4) : $page;

        //Rules for validation
        $this->form_validation->set_rules($this->validation());
        $range = range(date('Y') - 50, date('Y'));
        $data['yrs'] = array_combine($range, $range);

        //validate the fields of form
        if ($this->form_validation->run()) {         //Validation OK!
            // echo "<pre>";
            //     print_r($this->input->post());
            // echo "</pre>";
            // die;

            $user = $this->ion_auth->get_user();
            $form_data = array(
                'title' => $this->input->post('title'),
                'term' => $this->input->post('term'),
                'year' => $this->input->post('year'),
                'cats_weight' => $this->input->post('cats_weight'),
                'main_weight' => $this->input->post('main_weight'),
                'description' => $this->input->post('description'),
                'created_by' => $user->id,
                'created_on' => time()
            );

            $ok =  $this->igcse_m->create($form_data);

            if ($ok) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_create_success')));
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/igcse/');
        } else {
            $get = new StdClass();
            foreach ($this->validation() as $field) {
                $get->$field['field']  = set_value($field['field']);
            }

            $data['result'] = $get;
            //load the view and the layout
            $this->template->title('Add Igcse ')->build('admin/create', $data);
        }
    }

    function edit($id = FALSE, $page = 0)
    {

        //get the $id and sanitize
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        $page = ($page != 0) ? filter_var($page, FILTER_VALIDATE_INT) : NULL;

        //redirect if no $id
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/igcse/');
        }
        if (!$this->igcse_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));
            redirect('admin/igcse');
        }
        //search the item to show in edit form
        $get =  $this->igcse_m->find($id);
        //variables for check the upload
        $form_data_aux = array();
        $files_to_delete  = array();
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
                'cats_weight' => $this->input->post('cats_weight'),
                'main_weight' => $this->input->post('main_weight'),
                'description' => $this->input->post('description'),
                'modified_by' => $user->id,
                'modified_on' => time()
            );

            //add the aux form data to the form data array to save
            $form_data = array_merge($form_data_aux, $form_data);

            //find the item to update

            $done = $this->igcse_m->update_attributes($id, $form_data);

            if ($done) {
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => lang('web_edit_success')));
                redirect("admin/igcse/");
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => $done->errors->full_messages()));
                redirect("admin/igcse/");
            }
        } else {
            foreach (array_keys($this->validation()) as $field) {
                if (isset($_POST[$field])) {
                    $get->$field = $this->form_validation->$field;
                }
            }
        }
        $range = range(date('Y') - 50, date('Y'));
        $data['yrs'] = array_combine($range, $range);
        $data['result'] = $get;
        //load the view and the layout
        $this->template->title('Edit Igcse ')->build('admin/create', $data);
    }

    //Function to reciord exams
    function exams($id)
    {
        $thread = $this->igcse_m->find($id);

        if ($this->input->post()) {
            $user = $this->ion_auth->get_user();

            $form = [
                'tid' => $thread->id,
                'title' => $this->input->post('title'),
                'term' => $thread->term,
                'year' => $thread->year,
                'type' => $this->input->post('type'),
                'start_date' => strtotime($this->input->post('start_date')),
                'end_date' => strtotime($this->input->post('end_date')),
                'recording_end' => strtotime($this->input->post('recording_end_date')),
                'description' => $this->input->post('description'),
                'created_by' => $this->user->id,
                'created_on' => time()
            ];

            $ok = $this->igcse_m->create_exam($form);

            if ($ok) {
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
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
            }

            redirect('admin/igcse/exams/' . $id);
        }

        $range = range(date('Y') - 50, date('Y'));
        $data['yrs'] = array_combine($range, $range);
        $data['thread'] = $thread;
        $data['exams'] = $this->igcse_m->get_thread_exams($id);
        $data['classes'] = $this->exams_m->list_classes();
        $data['id'] = $id;

        $this->template->title('Igcse Exam Threads')->build('admin/exams', $data);
    }

    //Deal with comments
    public function comments($id = false) {
        $thread = $this->igcse_m->find($id);
        $data['thread'] = $thread;

        if ($this->input->post()) {
            $clsgroup = $this->input->post('group');
            $stream = $this->input->post('class');
            // $thread = $this->input->post('thread');
            // $tid = $this->igcse_m->find($thread);

            if (!empty($clsgroup)) {
                $students = $this->igcse_m->get_students_by_group($clsgroup);
                // $subjects = $this->igcse_m->get_class_subjects($clsgroup,$tid->term);
            } else {
                $students = $this->igcse_m->get_students_by_stream($stream);
                // $subjects = $this->igcse_m->get_subjects($stream,$tid->term);
            }
            
            //Retrieve Final Results
            if (empty($students)) {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No marks found for students in this Class'));
                redirect('admin/igcse/comments/'.$id);
            } else {

                $results = $this->igcse_m->results($id,$students);
                // $data['subjects'] = $subjects;
                $data['results'] = $results;
                $data['thread'] = $thread;
                $data['clsgroup'] = $clsgroup;
                $data['stream'] = $stream;
                $data['id'] = $id;
            }
        }

        $data['threads'] = $this->igcse_m->all_igcse();

        $this->template->title('Result Comments')->build('admin/comments', $data);
    }

    //Function to update comments
    public function update_comments($id = false) {
        $user = $this->ion_auth->get_user();

        $post = (object) $this->input->post();
        $marks = $post->mark;
        $classteachercomments = $post->classteachercomment;
        $principalcomments = $post->principalcomment;
        $k = 0;

        foreach ($marks as $key => $mark) {
            $form_data = array(
                'trs_comment' => $classteachercomments[$key],
                'prin_comment' => $principalcomments[$key],
                'commentedby' => $user->id
            );

            $done = $this->igcse_m->update_table($mark,'igcse_final_results',$form_data);

            if ($done) {
                $k++;
            }
        }

        $mess = $k.' Comments Updated';

        $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
        redirect('admin/igcse/comments/'.$id);
        
    }

    //Compute Marks
    public function compute($id)
    {
        $thread = $this->igcse_m->find($id);
        $exams = $this->igcse_m->get_thread_exams($id);
        $user = $this->ion_auth->get_user();

        if ($this->input->post()) {
            $clsgroup = $this->input->post('group');
            $cls = $this->input->post('class');
            $gid = $this->input->post('grading');

            $marks = $this->igcse_m->marks_by_group($id, $clsgroup);

            if (count($marks) == 0) {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No any marks recorded'));
            } else {
                $k = 0;
                $kk = 0;
                $totals = $this->generate_totals($id, $marks, $gid);

                //Create Marks for the Student
                foreach ($totals as $stu => $subject) {
                    foreach ($subject as $sub => $marko) {
                        //ChecK marks already computed
                        $checkmarks = $this->igcse_m->check_marks_availability($id,$sub,$stu);

                        if ($checkmarks) {
                            $updata = array(
                                'tid' => $id,
                                'class' => $marko['class'],
                                'class_group' => $marko['classgrp'],
                                'cats_score' => $marko['catscore'],
                                'main_score' => $marko['mainscore'],
                                'student' => $stu,
                                'subject' => $sub,
                                'total' => $marko['total'],
                                'points' => $marko['points'],
                                'grade' => $marko['grade'],
                                'grading' => $gid,
                                'comment' => $marko['comment'],
                                'modified_on' => time(),
                                'modified_by' => $user->id
                            );

                            //Update Marks
                            $done = $this->igcse_m->update_table($checkmarks->id,'igcse_computed_marks',$updata);

                            if ($done) {
                                $kk++;
                            }
                        } else {
                            $mdata = array(
                                'tid' => $id,
                                'class' => $marko['class'],
                                'class_group' => $marko['classgrp'],
                                'cats_score' => $marko['catscore'],
                                'main_score' => $marko['mainscore'],
                                'student' => $stu,
                                'subject' => $sub,
                                'total' => $marko['total'],
                                'points' => $marko['points'],
                                'grade' => $marko['grade'],
                                'grading' => $gid,
                                'comment' => $marko['comment'],
                                'created_on' => time(),
                                'created_by' => $user->id
                            );

                            $ok = $this->igcse_m->create_rec('igcse_computed_marks',$mdata);

                            if ($ok) {
                                $k++;
                            }
                        }
                    }
                }

                // die;

                //Update Subject Rankings
                $updone = $this->rank_marks($clsgroup,$id);

                //Work on populating final results
                $resultsdone = $this->compute_results($clsgroup,$id,$gid);
                
                $mess = $k.' Records Compiled Successfully. '.$kk.' Records updated.';
                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                redirect('admin/igcse/exams/' . $id);
            }
        }

        $data['thread'] = $thread;
        $data['exams'] = $exams;
        $data['id'] = $id;

        $this->template->title('Compute Marks')->build('admin/compute', $data);
    }

    //Function rank 
    public function rank_marks($classgrp = false,$tid = false) {
        $marks = $this->igcse_m->get_computed_marks($classgrp,$tid);
        
        $subjects = [];
        $classes = [];

        foreach ($marks as $key => $mark) {
            $subjects[] = $mark->subject;
            $classes[] = $mark->class;
        }

        $subjects = array_unique($subjects);
        $classes = array_unique($classes);

        //Overall Positions Ranking
        $subjectstuscores = [];

        foreach ($subjects as $sub) {
            $studentmarks = [];

            foreach ($marks as $marko) {
                if ($marko->subject == $sub) {
                    $studentmarks[$marko->id] = $marko->total;
                }
            }

            $subjectstuscores[$sub] = $studentmarks;
        }

        $positions = $this->generate_positions($subjectstuscores);

        //Update Overall Positions
        foreach ($positions as $sub => $pos) {
            foreach ($pos as $id => $position) {
                $rank_data = array(
                    'ovr_rank' => $position['position'].'/'.count($pos)
                );

               $done = $this->igcse_m->update_table($id,'igcse_computed_marks',$rank_data);
            }
        }

        //Stream positions ranking
        $classmarks = [];
        $classstudents = [];

        foreach ($classes as $class) {
            //Loop through subjects
            $studentmarks = [];

            foreach ($subjects as $ky => $sub) {
                $markss = [];
                foreach ($marks as $key => $marko) {
                    if ($marko->subject == $sub && $class == $marko->class) {
                        $markss[$marko->id] = $marko->total;
                    }
                }

                $studentmarks[$sub] = $markss;
            }

            $classmarks[$class] = $studentmarks;

            //Push Class Students
            $clsstus = [];
            foreach ($marks as $key => $marko) {
                if ($marko->class == $class) {
                    $clsstus[$marko->id] = $marko->student;
                }
            }

            $classstudents[$class] = array_unique($clsstus);
        }


        //Loop through classes
        foreach ($classmarks as $cls => $classmark) {
            $positions = $this->generate_positions($classmark);

            $count = count($classstudents[$cls]);
            
            //Update Overall Positions
            foreach ($positions as $sub => $pos) {
                foreach ($pos as $id => $position) {
                    $rank_data = array(
                        'stream_rank' => $position['position'].'/'.$count
                    );
                    
                    $done = $this->igcse_m->update_table($id,'igcse_computed_marks',$rank_data);
                }
            }
        }

        // die;
        return true;
    }

    //Work on Final Marks
    public function compute_results($classgrp = false,$tid = false,$gid = false) {
        $marks = $this->igcse_m->get_computed_marks($classgrp,$tid);

        $students = [];
        $stuclsgrps = [];
        $stustreams = [];
        $studentids = [];
        // $gids = [];

        foreach ($marks as $key => $mark) {
            $students[$mark->id] = $mark->student;
            $stuclsgrps[$mark->id] = $mark->class_group;
            $stustreams[$mark->id] = $mark->class;
            $studentids[] = $mark->student;
            // $gids[] = $mark->grading;
        }

        $students = array_unique($students);
        $studentids = array_unique($studentids);
        // $gid = array_unique($gids);

        //Retrive marks for each student
        $studentmarks = [];
        foreach ($students as $ky => $stu) {
            $stumarks = [];
            $stupoints = [];

            foreach ($marks as $mark) {
                if ($stu == $mark->student) {
                    $stumarks[] = $mark->total;
                    $stupoints[] = $mark->points;
                }
            }

            $total = array_sum($stumarks);
            $totalpoints = array_sum($stupoints);
            $avg = round($total / count($stumarks));
            $outof = count($stumarks) * 100;
            $pointsoufof = count($stupoints) * 8;

            //Find grade
            $grading = $this->igcse_m->retrieve_grading($gid);
            foreach ($grading as $gy => $grad) {
                if ($avg >= $grad->minimum_marks && $avg <= $grad->maximum_marks) {
                    $grade = $grad->grade;
                    // $points = $grade->points;
                    $comment = $grad->comment;
                }
            }
            

            $studentmarks[$stu] = [
                'class_group' => $stuclsgrps[$ky],
                'class' => $stustreams[$ky],
                'total' => $total,
                'points' => $totalpoints,
                'points_outof' => $pointsoufof,
                'avg' => $avg,
                'outof' => $outof,
                'grade' => $grade,
                'gid' => $gid,
                'comment' => $comment
            ];
        }

        //Insert Computed Results
       foreach ($studentmarks as $stu => $tot) {
        
            // foreach ($total as $tot) {
                $check = $this->igcse_m->check_results($tid,$stu);
                if ($check) {
                    $rupdata = array(
                        'tid' => $tid,
                        'class_group' => $tot['class_group'],
                        'class' => $tot['class'],
                        'total' => $tot['total'],
                        'points' => $tot['points'],
                        'points_outof' => $tot['points_outof'],
                        'mean_mark' => $tot['avg'],
                        'mean_grade' => $tot['grade'],
                        'outof' => $tot['outof'],
                        'student' => $stu,
                        'gid' => $tot['gid'],
                        'modified_on' => time(),
                        'modified_by' => $this->user->id
                    );

                    $done = $this->igcse_m->update_table($check->id,'igcse_final_results',$rupdata);
                } else {
                    $rdate = array(
                        'tid' => $tid,
                        'class_group' => $tot['class_group'],
                        'class' => $tot['class'],
                        'total' => $tot['total'],
                        'points' => $tot['points'],
                        'points_outof' => $tot['points_outof'],
                        'mean_mark' => $tot['avg'],
                        'mean_grade' => $tot['grade'],
                        'outof' => $tot['outof'],
                        'student' => $stu,
                        'gid' => $tot['gid'],
                        'created_on' => time(),
                        'created_by' => $this->user->id
                    );

                    $ok = $this->igcse_m->create_rec('igcse_final_results',$rdate);
                }
                
            // }
       }
        
       //Rank Computed Results
       $results = $this->igcse_m->results($tid,$studentids);
       $positions = $this->get_result_positions($results);

       //Update Positions
        foreach ($results as $key => $result) {    
            //Get Current Positions
            foreach ($positions as $keeey => $posi) {
    
                if ($keeey === 'ovrpositions') {
                    foreach ($posi as $posikey => $pos) {
                        if ($posikey == $key) {
                            $ovrpos = $pos;
                        }
                    }
                } elseif ($keeey === 'strpositions') {
                    foreach ($posi as $posikey => $pos) {
                        if ($posikey == $key) {
                            $strpos = $pos;
                        }
                    }
                }
            }

            $form_data = array(
                'ovr_pos' => $ovrpos,
                'str_pos' => $strpos
            );

            //Update Positions
            $done = $this->igcse_m->update_table($result->id,'igcse_final_results',$form_data);
            
        }

       
    //    die;

       return true;
    }

    //Rank Results

    //Function to assign postions
    function generate_positions($marks) {
        foreach ($marks as &$subject) {
            // Sort marks in descending order
            arsort($subject);

            // Initialize variables
            $prevMark = null;
            $position = 0;

            // Assign positions
            foreach ($subject as $student => &$mark) {
                if ($mark !== $prevMark) {
                    $position++;
                    $prevMark = $mark;
                }
                $mark = ['position' => $position, 'mark' => $mark];
            }
        }

        return $marks;
    }

    //Generate Totals for each
    public function generate_totals($tid, $marks, $gid)
    {
        $exids = [];
        $students = [];
        $subjects = [];

        foreach ($marks as $key => $mk) {
            $students[] = $mk->student;
            $subjects[] = $mk->subject;
        }

        $filteredstudents = array_unique($students);
        $filteredsubs = array_unique($subjects);

        $stusubs = [];

        foreach ($filteredstudents as $keey => $stu) {
            $sbs = [];

            foreach ($filteredsubs as $sub) {
                $sbs[] = $sub;
            }

            $stusubs[$stu] = $sbs;
        }

        //Now populate marks 
        $studentmks = [];

        foreach ($stusubs as $ky => $stusub) {
            $subjects = $stusub;
            $submarks = [];

            foreach ($marks as $yk => $mark) {
                //Loop through Subjects
                foreach ($subjects as $subkey => $sub) {
                    if ($sub == $mark->subject && $ky == $mark->student) {
                        $exam = $this->igcse_m->find_igcse_exam($mark->exams_id);

                        $submarks[$sub][] = [
                            'class' => $mark->class,
                            'classgrp' => $mark->class_group,
                            'exam' => $mark->exams_id,
                            'type' => $exam->type,
                            'mark' => $mark->marks,
                            'outof' => $mark->out_of
                        ];
                    }
                }
            }

            $studentmks[$ky] = $submarks;
        }

        // echo "<pre>";
        //     print_r($studentmks);
        // echo "</pre>";
        // die;

        $combinedmarks = $this->combine_marks($tid, $studentmks, $gid);

        return $combinedmarks;
    }

    //Generate Subject scores


    //Combine the marks
    public function combine_marks($tid, $studentmks, $gid)
    {
        $exthread = $this->igcse_m->find($tid);
        $catsweight = $exthread->cats_weight;
        $mainweight = $exthread->main_weight;

        //Check 
        $totalscores = [];
        $substuscores = [];
        foreach ($studentmks as $key => $sub) {
            $subjects = $sub;

            $subscores = [];
            foreach ($subjects as $ky => $marks) {
                $marks = $marks;
                $cats = [];
                $mains = [];

                foreach ($marks as $yk => $mark) {
                    if ($mark['type'] == 2) {
                        $cats[] = [
                            'score' => $mark['mark'],
                            'outof' => $mark['outof']
                        ];
                    } elseif ($mark['type'] == 1) {
                        $mains[] = [
                            'score' => $mark['mark'],
                            'outof' => $mark['outof']
                        ];
                    }
                }

                //Get the Convertions
                $totalRatio = 0;
                $totalOutOf = 0;

                // Iterate through each element in the array
                foreach ($cats as $cat) {
                    $totalRatio += $cat['score'];
                    $totalOutOf += $cat['outof'];
                }

                $totalCatRatio = $totalRatio / $totalOutOf;

                if ($totalCatRatio > $catsweight) {
                    $totalCatRatio = $catsweight;
                }

                $catstotal = round($totalCatRatio * $catsweight);
                $actualcattotal = $catstotal > $catsweight ? $catsweight : $catstotal;

                //Work on Compressing the Mains
                $totalmainRatio = 0;
                $totalmainOutof = 0;

                foreach ($mains as $main) {
                    $totalmainRatio += $main['score'];
                    $totalmainOutof += $main['outof'];
                }

                $totalMainRatio = $totalmainRatio / $totalmainOutof;

                if ($totalMainRatio > $mainweight) {
                    $totalMainRatio = $mainweight;
                }
                // Multiply the total ratio by 30
                $maintotal = round($totalMainRatio * $mainweight);
                $actualmaintotal = $maintotal > $mainweight ? $mainweight : $maintotal;

                //Get the total Score
                $totalscore = $actualcattotal + $actualmaintotal;

                $actualtotal = $totalscore > $catsweight + $mainweight ? $catsweight + $mainweight : $totalscore;

                //Match Score with the grades
                $grading = $this->igcse_m->retrieve_grading($gid);
                foreach ($grading as $gy => $grad) {
                    if ($actualtotal >= $grad->minimum_marks && $actualtotal <= $grad->maximum_marks) {
                        $grade = $grad->grade;
                        $points = $grad->points;
                        $comment = $grad->comment;
                    }
                }

                $subscores[$ky] = [
                    'class' => $mark['class'],
                    'classgrp' => $mark['classgrp'],
                    'catscore' => $actualcattotal,
                    'mainscore' => $actualmaintotal,
                    'total' => $actualtotal,
                    'points' => $points,
                    'grade' => $grade,
                    'comment' => $comment
                ];
            }

            $totalscores[$key] = $subscores;
        }

        // $gradedscores = $this->generate_ranks($totalscores);

        return $totalscores;
    }

    //Generate Ranks
    public function generate_ranks($totalscores)
    {
        $overall_positions = [];
        $stream_positions = [];

        // Loop through the main array to calculate positions
        foreach ($totalscores as $student_id => $scores) {
            // Extract scores for sorting
            $scoresToSort = [];
            foreach ($scores as $subject_id => $score_details) {
                $scoresToSort[$subject_id] = $score_details['total'];
            }

            // Sort the scores for the current student
            arsort($scoresToSort);

            // Calculate positions for the stream
            $stream_positions[$student_id] = $this->calculatePositions($scores, 'total');

            // Merge the scores for the current student with overall scores
            $overall_positions = array_merge($overall_positions, $scoresToSort);
        }

        // Calculate overall positions
        $overall_positions = $this->calculatePositions($overall_positions, 'total');

        // Loop through the main array to add positions
        foreach ($totalscores as $student_id => &$scores) {
            // Loop through scores for each student
            foreach ($scores as $subject_id => &$score_details) {
                // Add new keys for stream and overall positions
                $score_details['ovr_pos'] = $overall_positions[$score_details['total']];
                $score_details['str_pos'] = $stream_positions[$student_id][$score_details['total']];
            }
        }

        echo "<pre>";
        print_r($totalscores);
        echo "</pre>";

        die;
    }


    //Function to generate rank
    function calculatePositions($array, $key)
    {
        uasort($array, function ($a, $b) use ($key) {
            return $b[$key] <=> $a[$key];
        });
    
        // Initialize variables
        $position = 0;
        $prev_value = null;
        $positions = [];
    
        // Iterate through the sorted array
        foreach ($array as $value) {
            // Increment position if the current value is different from the previous value
            if ($value[$key] !== $prev_value) {
                $position++;
            }
    
            // Set the position for the current value
            $positions[$value[$key]] = $position;
    
            // Update the previous value
            $prev_value = $value[$key];
        }
    
        return $positions;
    }

    public function record($thid, $exid, $id)
    {
        $students = [];
        $sb = 0;
        //push class name to next view
        $class_name = $this->exams_m->populate('class_groups', 'id', 'name');
        $exam = $this->igcse_m->find1($thid);
        $tar = $this->igcse_m->get_stream($id);
        $class_id = $tar->class;
        $stream = $tar->stream;
        $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . '</span>';
        $exam_type = $this->igcse_m->get_exams_by_tid($thid);


        $subjects = $this->exams_m->get_subjects($id, $exam->term);

        $sel = 0;
        if ($this->input->get('sb')) {
            $sb = $this->input->get('sb');
            $data['selected'] = isset($subjects[$sb]) ? $subjects[$sb] : [];
            $row = $this->igcse_m->fetch_subject($sb);
            $rrname = $row ? ' - ' . $row->name : '';
            $heading = 'Exam Marks For: <span style="color:blue">' . $class_name[$class_id] . $rrname . '</span>';

            if ($row->is_optional == 2) {
                $sel = 1;
            }

            $data['checkmarks'] = $this->igcse_m->check_marks($thid, $exid, $sb);
            $students = $this->exams_m->get_students($class_id, $stream);
        }

        $data['list_subjects'] = $this->exams_m->list_subjects();
        $data['subjects'] = $subjects;
        $data['class_name'] = $heading;
        $data['assign'] = $sel;
        $data['count_subjects'] = $this->exams_m->count_subjects($class_id, $exam->term);
        $data['full_subjects'] = $this->exams_m->get_full_subjects();
        $data['thid'] = $thid;
        $data['exid'] = $exid;
        $data['sb'] = $sb;

        //create control variables
        $data['updType'] = 'create';
        $data['page'] = '';
        $data['exams'] = $this->exams_m->list_exams();
        $data['grading'] = $this->exams_m->get_grading_system();
        //Rules for validation
        $this->form_validation->set_rules($this->rec_validation());

        //validate the fields of form
        if ($this->form_validation->run()) {
            if ($this->input->get('sb')) {
                $user = $this->ion_auth->get_user();
                $inc = [];
                $mkpost = $this->input->post();
                if (isset($mkpost['done'])) {
                    $inc = $mkpost['done'];
                }
                $sb = $this->input->get('sb');
                // $gd_id = $this->input->post('grading');
                $marks = $this->input->post('marks');
                $units = $this->input->post('units');
                $gid = $this->input->post('grading');
                $k = 0;
                $kk = 0;

                // $this->exams_m->set_grading($exid, $id, $sb, $gd_id, $user->id);
                $perf_list = $this->_prep_marks($sb, $exid, $marks, $units);

                // echo "<pre>";
                //     print_r($this->input->post());
                //     // print_r($perf_list);
                // echo "</pre>";
                // die;

                foreach ($perf_list as $dat) {
                    $dat = (object) $dat;

                    $mm = (object) $dat->marks;
                    $mkcon = $mm->marks ? $mm->marks : 0;

                    $fvalues = [
                        'tid' => $thid,
                        'class' => $id,
                        'class_group' => $class_id,
                        'exams_id' => $dat->exams_id,
                        'student' => $dat->student,
                        'marks' => $mkcon,
                        'type' =>  $exam_type->id,
                        'out_of' =>  $dat->outof,
                        'gid' => $gid,
                        'subject' => $mm->subject,
                        'created_by' => $dat->created_by,
                        'created_on' => time()
                    ];

                    //Check if marks Exists to Update
                    $ckmarks = $this->igcse_m->check_student_marks($thid, $exid, $sb, $dat->student);

                    if ($ckmarks) {
                        $k++;
                        $done = $this->igcse_m->update_marks_attributes($ckmarks->id, ['out_of' => $dat->outof,'gid' => $gid,'marks' => $mkcon, 'modified_on' => time(), 'modified_by' => $user->id]);
                    } else {
                        $kk++;
                        $ok = $this->exams_m->insert_marks1($fvalues);
                    }
                }

                // die;
                // if ($ok) {
                // $this->acl->audit($ok, implode(' , ', $svalues));
                $mess = $kk . ' Records Created Successfully. ' . $k . ' Records Updated';

                $this->session->set_flashdata('message', array('type' => 'success', 'text' => $mess));
                // } else {
                //     $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_create_failed')));
                // }
            } else {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'Subject Not Specified'));
            }
            redirect('admin/igcse/exams/' . $thid);
        } else {
            $get = new StdClass();
            foreach ($this->rec_validation() as $field) {
                $get->{$field['field']} = set_value($field['field']);
            }

            $data['sb'] = $sb;
            $data['result'] = $get;
            $data['class_id'] = $id;
            $data['exam_id'] = $exid;
            $data['students'] = $students;
            $data['igcse_exam'] = $this->igcse_m->find_igcse_exam($exid);

            $this->template->title('Record Exam Marks')->build('admin/records', $data);
        }
    }


    function _prep_marks($subject, $exm_mgmt_id, $marks = [], $units = [])
    {
        $perf_list = [];
        $sub_marks = [];
        $user = $this->ion_auth->get_user();
        $outof = $this->input->post('outof');


        // print_r($marks);
        // die;
        if ($units && !empty($units)) {
            foreach ($units as $stid => $unmarks) {
                foreach ($unmarks as $uid => $mk) {
                    $sunits[] = array(
                        'parent' => $subject,
                        'unit' => $uid,
                        'marks' => $mk
                    );
                }
            }
        }

        foreach ($marks as $std => $score) {
            $sunits = [];
            $sub_marks = array(
                'subject' => $subject,
                'marks' => $score
            );
            if ($units && isset($units[$std])) {
                $mine = $units[$std];
                foreach ($mine as $uid => $mk) {
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
                'outof' => $outof,
                'created_by' => $user->id,
                'created_on' => time()
            );
        }
        return $perf_list;
    }

    public function view(){

        $this->template->title('View Reports')->build('admin/reports');

    }


    //Function to show Report Forms
    public function bulk($id) {
        $thread = $this->igcse_m->find($id);
        $exams = $this->igcse_m->get_thread_exams($id);
        $user = $this->ion_auth->get_user();

        if ($this->input->post()) {
            $clsgroup = $this->input->post('group');
            $stream = $this->input->post('class');
            $comparewith = $this->input->post('thread');

            if (!empty($clsgroup)) {
                $students = $this->igcse_m->get_students_by_group($clsgroup);
            } else {
                $students = $this->igcse_m->get_students_by_stream($stream);
            }
            
            //Retrieve Final Results
            if (empty($students)) {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No marks found for students in this Class'));
                redirect('admin/igcse/bulk/' . $id);
            } else {
                $results = $this->igcse_m->results($id,$students);
                $compareresults = $this->igcse_m->results($comparewith,$students);
                $computedmarks = $this->igcse_m->get_student_computed_marks($id,$students);

                // $resultpositions = $this->get_result_positions($results);
                // $comparepositions = $this->get_result_positions($compareresults); 

                // $data['comparepositions'] = $comparepositions;
                // $data['resultpositions'] = $resultpositions;
                $data['comparison'] = $comparewith;
                $data['results'] = $results;
                $data['computedmarks'] = $computedmarks;
                $data['compareresults'] = $compareresults;
            }
        }

        
        $data['threads'] = $this->igcse_m->list_exams($id);
        $data['thread'] = $thread;
        $data['exams'] = $exams;
        $data['id'] = $id;

        $this->template->title('Report Forms')->build('admin/bulk', $data);
    }

    //Function to show Report Forms
    public function report($id = false) {
        $user = $this->ion_auth->get_user();

        if ($this->input->post()) {
            $clsgroup = $this->input->post('group');
            $stream = $this->input->post('class');
            $thread = $this->input->post('thread');
            $tid = $this->igcse_m->find($thread);

            if (!empty($clsgroup)) {
                $students = $this->igcse_m->get_students_by_group($clsgroup);
                $subjects = $this->igcse_m->get_class_subjects($clsgroup,$tid->term);
            } else {
                $students = $this->igcse_m->get_students_by_stream($stream);
                $subjects = $this->igcse_m->get_subjects($stream,$tid->term);
            }
            
            //Retrieve Final Results
            if (empty($students)) {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No marks found for students in this Class'));
                redirect('admin/igcse/report/');
            } else {

                $results = $this->igcse_m->results($thread,$students);
                $data['subjects'] = $subjects;
                $data['results'] = $results;
                $data['thread'] = $this->igcse_m->find($thread);
                $data['clsgroup'] = $clsgroup;
                $data['stream'] = $stream;
            }
        }

        
        // $data['threads'] = $this->igcse_m->list_exams($id);
        // $data['thread'] = $thread;
        // $data['exams'] = $exams;
        // $data['id'] = $id;
        $data['threads'] = $this->igcse_m->all_igcse();

        $this->template->title('Results Report')->build('admin/report', $data);
    }

    //Function to show Report Forms
    public function sub_report($id = false) {
        $user = $this->ion_auth->get_user();

        if ($this->input->post()) {
            $clsgroup = $this->input->post('group');
            $stream = $this->input->post('class');
            $thread = $this->input->post('thread');
            $subject = $this->input->post('subject');
            $tid = $this->igcse_m->find($thread);

            if (!empty($clsgroup)) {
                $students = $this->igcse_m->get_students_by_group($clsgroup);
                $subjects = $this->igcse_m->get_class_subjects($clsgroup,$tid->term);
            } else {
                $students = $this->igcse_m->get_students_by_stream($stream);
                $subjects = $this->igcse_m->get_subjects($stream,$tid->term);
            }
            
            //Retrieve Final Results
            if (empty($students)) {
                $this->session->set_flashdata('message', array('type' => 'error', 'text' => 'No marks found for students in this Class'));
                redirect('admin/igcse/sub_report/');
            } else {
                $exams = $this->igcse_m->get_thread_exams($thread);
                $marks = $this->igcse_m->marks_list($thread,$subject,$students);
                $data['subjects'] = $subjects;
                $data['marks'] = $marks;
                $data['thread'] = $this->igcse_m->find($thread);
                $data['clsgroup'] = $clsgroup;
                $data['stream'] = $stream;
                $data['exams'] = $exams;
                $data['subject'] = $this->igcse_m->get_subject($subject);
            }
        }

        
        // $data['threads'] = $this->igcse_m->list_exams($id);
        // $data['thread'] = $thread;
        // $data['exams'] = $exams;
        // $data['id'] = $id;
        $data['threads'] = $this->igcse_m->all_igcse();

        $this->template->title('Results Report')->build('admin/subreport', $data);
    }

    //Get Subjects by Class Group
    function class_subjects($cls,$thread) {
        $tid = $this->igcse_m->find($thread);

        $subjects = $this->igcse_m->get_class_subjects2($cls,$tid->term);

        echo json_encode($subjects);
    }

    //Get Subjects by Class Group
    function stream_subjects($stream,$thread) {
        $tid = $this->igcse_m->find($thread);

        $subjects = $this->igcse_m->get_subjects2($stream,$tid->term);

        echo json_encode($subjects);
    }

    //Get result Positions
    function get_result_positions($marks){
        $classes = [];

        foreach ($marks as $key => $mark) {
            $classes[] = $mark->class;
        }

        $classes = array_unique($classes);

        //Overall Positions Ranking
        $scores = [];

        foreach ($marks as $ky => $mark) {
            $scores[$ky] = $mark->total;
        }

        $ovrpositions = $this->result_positions($scores);

        //Stream positions ranking
        $studenstscores = [];
        foreach ($classes as $class) {
            //Loop through subjects
                $scores = [];
                foreach ($marks as $key => $marko) {
                    if ($marko->class == $class) {
                        $scores[$key] = $marko->total;
                    }
                }

            $studenstscores[$class] = $scores;
        }

        //Loop through classes
        $strscores = [];
        foreach ($studenstscores as $cls => $scores) {
            $positions = $this->result_positions($scores);

            $poses = [];

            $k = 0;
            foreach ($scores as $yk => $scr) {
                $poses[$yk] = $positions[$k];
                $k++;
            }

            $strscores[$cls] = $poses; 
        }

        //Combine Stream Positions
        $result = [];
        foreach ($strscores as $innerArray) {
            $result = array_merge($result, $innerArray);
        }

       $allposes = [
            'ovrpositions' => $ovrpositions,
            'strpositions' => $result
       ];

    //    echo "<pre>";
    //         print_r($marks);
    //         print_r($allposes);
    //    echo "</pre>";
    //    die;

       return $allposes;
    }


    //Get result positions
    function result_positions($marks) {
        rsort($marks);

        $position = 1;
        $previous_mark = null;
        
        // Array to store positions
        $positions = [];
        
        foreach ($marks as $index => $mark) {
            // If the current mark is different from the previous mark, increment the position
            if ($mark !== $previous_mark) {
                $position = $index + 1;
            }
        
            // Assign the position to the current mark
            $positions[$index] = $position;
        
            // Update the previous mark
            $previous_mark = $mark;
        }

        return $positions;
    }

    private function rec_validation()
    {

        $config = array(
            array(
                'field' => 'record_date',
                'label' => 'Record Date',
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'exam_type',
                'label' => 'The Exam',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'subject[]',
                'label' => 'Subject',
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'student[]',
                'label' => 'student',
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'total[]',
                'label' => 'Total',
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'marks[]',
                'label' => 'Marks',
                'rules' => 'xss_clean'
            ),
            array(
                'field' => 'grading',
                'label' => 'Grading',
                'rules' => 'required'
            ),
            array(
                'field' => 'remarks[]',
                'label' => 'Remarks',
                'rules' => 'xss_clean'
            ),
        );
        $this->form_validation->set_error_delimiters("<br/><span class='error'>", '</span>');
        return $config;
    }

    function delete($id = NULL, $page = 1)
    {
        //filter & Sanitize $id
        $id = ($id != 0) ? filter_var($id, FILTER_VALIDATE_INT) : NULL;

        //redirect if its not correct
        if (!$id) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/igcse');
        }

        //search the item to delete
        if (!$this->igcse_m->exists($id)) {
            $this->session->set_flashdata('message', array('type' => 'warning', 'text' => lang('web_object_not_exist')));

            redirect('admin/igcse');
        }

        //delete the item
        if ($this->igcse_m->delete($id) == TRUE) {
            $this->session->set_flashdata('message', array('type' => 'sucess', 'text' => lang('web_delete_success')));
        } else {
            $this->session->set_flashdata('message', array('type' => 'error', 'text' => lang('web_delete_failed')));
        }

        redirect("admin/igcse/");
    }

    private function validation()
    {
        $config = array(
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]',
            ),
            array(
                'field' => 'term',
                'label' => 'Term',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]',
            ),
            array(
                'field' => 'year',
                'label' => 'Year',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]',
            ),
            array(
                'field' => 'cats_weight',
                'label' => 'CATs Weight',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]',
            ),
            array(
                'field' => 'main_weight',
                'label' => 'Main Exam Weight',
                'rules' => 'required|trim|xss_clean|min_length[0]|max_length[60]',
            ),
        );
        $this->form_validation->set_error_delimiters("<br /><span class='error'>", '</span>');
        return $config;
    }


    private function set_paginate_options()
    {
        $config = array();
        $config['base_url'] = site_url() . 'admin/igcse/index/';
        $config['use_page_numbers'] = TRUE;
        $config['per_page'] = 10;
        $config['total_rows'] = $this->igcse_m->count();
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
        $choice = $config["total_rows"] / $config["per_page"];
        //$config["num_links"] = round($choice);

        return $config;
    }
}
