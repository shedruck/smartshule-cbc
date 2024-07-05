<?php
$settings = $this->ion_auth->settings();

if (isset($results)) {
    $exs = [];
    foreach ($results as $res) {
        $subscores = $this->cbc_tr->student_scores($thread->id, $res->student);

        $masomo = [];
        foreach ($subscores as $key => $sub) {
            $ex = explode(',', $sub->involvedexams);
            $masomo[$sub->subject] = array(
                'exams' => $ex,
                'scores' => explode(',', $sub->involvedscores),
                'weights' => explode(',', $sub->involvedweights)
            );
        }

        $exs[$res->student] = $masomo;
    }

    $newresults = [];
    $mitihani = $this->cbc_m->populate('cbc_exam_threads', 'id', 'name');
    $actualexams = $this->cbc_m->populate('cbc_threads', 'id', 'exam');

    foreach ($exs as $studentId => $masomo) {
        foreach ($masomo as $subjectId => $details) {
            foreach ($details['exams'] as $examIndex => $examId) {
                $newresults[$studentId][$examId] = isset($newresults[$studentId][$examId])
                    ? $newresults[$studentId][$examId] + $details['scores'][$examIndex]
                    : $details['scores'][$examIndex];
            }
        }
    }

    // echo "<pre>";
    //     print_r($newresults);
    // echo "</pre>";

    //Prepare Arrray for Plotting Comparison Graph Start
    $studentmarks = [];
    foreach ($results as $res) {
        $subscores = $this->cbc_tr->student_scores($thread->id, $res->student);
        $theexams = explode(',', $res->examsids);

        $theexamsscores = [];

        foreach ($theexams as $exkey => $theexam) {
            $subsmarks = [];
            $subjectstots = 0;

            foreach ($subscores as $scorekey => $sub) {
                $involvedmarkids = explode(',', $sub->involvedmarkids);
                $involvedweights = explode(',', $sub->involvedweights);
                $involvedexams = explode(',', $sub->involvedexams);
                $involvedscores = explode(',', $sub->involvedscores);

                foreach ($involvedexams as $inexamkey => $inexam) {
                    if ($theexam == $inexam) {
                        $onescore = $involvedscores[$inexamkey];
                        $examscore = $this->cbc_tr->find_mark($involvedmarkids[$inexamkey]);

                        if ($sub->type == 1) {
                            $convertedscore =  $examscore->score;
                        } else {
                            $convertedscore =  round(($examscore->score * $involvedweights[$inexamkey]) / $examscore->outof, 0);
                        }

                        $subjectstots += $convertedscore;
                    }
                }
            }

            //Check if its rubric or marks to assign total scores appropriately
            $theexamsscores[$theexam] = $sub->type == 2 ? $subjectstots : round($subjectstots / count($subscores), 0);
        }

        $studentmarks[$res->student] = $theexamsscores;
    }

    //Prepare Arrray for Plotting Comparison Graph End

}


?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" id="cardheaderdiv">
                <h6 class="float-start"><?php echo $thread->name ?> Report Forms for <b><?php echo $this->classes[$level] ?></b></h6>
                <div class="btn-group btn-group-sm float-end" role="group">
                    <a href="<?php echo base_url('cbc/trs/joint_reports') ?>" class="btn btn-sm btn-primary">All Threads</a>
                    <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'filterform');
                echo   form_open_multipart(current_url(), $attributes);
                ?>
                <input type="hidden" name="level" value="<?php echo $level ?>" id="level">
                <!-- <div class="row justify-content-center"> -->
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <?php
                        echo form_dropdown('class', array('0' => 'All Streams') + $streams, $this->input->post('class'), ' class="form-control select" id="class" data-placeholder="" ');
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <?php
                        echo form_dropdown('compare', array('' => 'Select Exam for Compare') + $threads, $this->input->post('compare'), ' class="form-control select" id="compare" data-placeholder="" ');
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <button type="submit" class="btn btn-success">Show Results</button>
                        <button type="button" class="btn btn-info mb-1 d-inline-flex" onclick="javascript:window.print();"><i class="si si-printer me-1 lh-base"></i> Print Report</button>
                    </div>

                </div>
                <?php echo form_close(); ?>
                <hr>
                <!-- </div> -->

                <!-- Report Cards Start Here -->
                <?php
                if (isset($results)) {
                    $types = array(
                        1 => 'RUBRICS',
                        2 => 'MARKS'
                    );

                    $exams = $this->cbc_tr->populate('cbc_threads', 'id', 'exam');

                    foreach ($results as $key => $result) {
                        $stu = $this->worker->get_student($result->student);
                        $paro = $this->portal_m->get_parent($stu->parent_id);
                        $userparo = $this->ion_auth->get_user($paro->user_id);

                        $prevresults = $this->cbc_tr->prev_score($comparison, $result->student);

                        $subscores = $this->cbc_tr->student_scores($thread->id, $result->student);

                        $clssubjects = $this->exams_m->get_subjects($result->class, $thread->term);


                        $subscount = 0;
                        $scoreoutof = 0;
                        $totoutof = 0;

                        //Work on Checking TOTAL MARKS
                        if ($result->type == 1) {
                            $totoutof = count($subscores) * 4;
                        } elseif ($result->type == 2) {
                            $subsweights = explode(',', $result->subjectsweights);
                            if ($result->operation == 1) {
                                $totoutof = count($subscores) * round(array_sum($subsweights) / count($subsweights), 0);
                            } elseif ($result->operation == 2) {
                                $totoutof = count($subscores) * array_sum($subsweights);
                            }
                        }


                ?>
                        <div class="row page-break" id="SingleReportForm">
                            <div class="col-md-12">
                                <div class="card-body p-10">
                                    <div class="row" id="headerdiv">
                                        <div class="col-md-3 col-lg-3 col-sm-3 col-xl-3">
                                            <img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6">
                                            <h5 class="blue-text text-center"><b><?php echo strtoupper($this->school->school) ?></b></h5>
                                            <h6 class="text-center"><?php echo strtoupper($this->school->postal_addr) ?></b></h6>
                                            <h6 class="text-center"><?php echo $this->school->tel ?> - <?php echo $this->school->email ?></h6>

                                        </div>
                                        <div class="col-md-3 col-lg-3 col-sm-3 col-xl-3 text-right">
                                            <?php
                                            $passport = $this->admission_m->passport($stu->photo);
                                            $fake = base_url('uploads/files/member.png');

                                            if (count($passport) !== 0) {
                                                $path = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
                                            }

                                            ?>
                                            <img src="<?php echo $fake ?>" alt="Student Profile" class="img-fluid img-thumbnail">
                                        </div>
                                    </div>

                                    <h6 class="text-center blue-bg mt-3">ACADEMIC TRANSCRIPT FOR - <?php echo $this->classes[$result->classgrp] ?> - <?php echo $thread->name ?> - (<?php echo $thread->year ?>/Term <?php echo $thread->term ?>) - <?php echo $types[$result->type] ?></h6>

                                    <div class="row" id="studentsdiv">
                                        <div class="col-md-4 col-lg-4 col-sm-4 col-xl-4">
                                            <h6>STUDENT NAME : <?php echo ucwords($stu->first_name . ' ' . $stu->last_name) ?></h6>
                                            <h6>ADM NO : <?php echo $stu->admission_number ?></h6>
                                            <h6>CLASS : <?php echo $this->streams[$stu->class] ?></h6>
                                        </div>
                                        <div class="col-md-8 col-lg-8 col-sm-8 col-xl-8 text-right">
                                            <div id="performance_<?php echo $result->id ?>" class="graphdiv">

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Position Div Here -->
                                    <div class="row mb-2 justify-content-center pt-1 mt-2" id="positionsdiv">
                                        <!-- MEAN Section -->
                                        <div class="col-md-2 col-lg-2 col-sm-2 position-box">
                                            <div class="horizontal-align">
                                                <div class="mean-grade">
                                                    <h6 class="text-center">MEAN</h6>
                                                </div>
                                                <h5 class="diff-container">
                                                    <?php
                                                    if ($prevresults) {
                                                        $diff = $result->average_marks - $prevresults->average_marks;
                                                        if ($diff < 0) {
                                                            $icon = '<span class="arrow-down"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                            $dig = $diff;
                                                        } elseif ($diff == 0) {
                                                            $icon = '<span class="arrow-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                            $dig = 0;
                                                        } else {
                                                            $icon = '<span class="arrow-up"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                            $dig = '+' . $diff;
                                                        }
                                                        echo '<span class="diff-number">' . $dig . '</span> ' . $icon;
                                                    } else {
                                                        echo "___";
                                                    }
                                                    ?>
                                                </h5>
                                            </div>
                                            <div class="mean-diff">
                                                <h6 class="text-center"><b><?php echo $result->mean_grade ?>|<?php echo $result->average_marks ?></b></h6>
                                            </div>
                                        </div>

                                        <!-- TOTAL Section -->
                                        <div class="col-md-2 col-lg-2 col-sm-2 position-box">
                                            <div class="horizontal-align">
                                                <div class="total-marks">
                                                    <h6 class="text-center">TOTAL</h6>
                                                </div>
                                                <h5 class="diff-container">
                                                    <?php
                                                    if ($prevresults) {
                                                        $diff = $result->total_marks - $prevresults->total_marks;
                                                        if ($diff < 0) {
                                                            $icon = '<span class="arrow-down"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                            $dig = $diff;
                                                        } elseif ($diff == 0) {
                                                            $icon = '<span class="arrow-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                            $dig = 0;
                                                        } else {
                                                            $icon = '<span class="arrow-up"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                            $dig = '+' . $diff;
                                                        }
                                                        echo '<span class="diff-number">' . $dig . '</span> ' . $icon;
                                                    } else {
                                                        echo "___";
                                                    }
                                                    ?>
                                                </h5>
                                            </div>
                                            <div class="marks-diff">
                                                <h6 class="text-center"><b><?php echo $result->total_marks ?>/<?php echo $totoutof; ?></b></h6>
                                            </div>
                                        </div>

                                        <!-- TOTAL PTS Section -->
                                        <div class="col-md-2 col-lg-2 col-sm-2 position-box">
                                            <div class="horizontal-align">
                                                <div class="total-points">
                                                    <h6 class="text-center">TOTAL PTS</h6>
                                                </div>
                                                <h5 class="diff-container">
                                                    <?php
                                                    if ($prevresults) {
                                                        $diff = $result->total_points - $prevresults->total_points;
                                                        if ($diff < 0) {
                                                            $icon = '<span class="arrow-down"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                            $dig = $diff;
                                                        } elseif ($diff == 0) {
                                                            $icon = '<span class="arrow-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                            $dig = 0;
                                                        } else {
                                                            $icon = '<span class="arrow-up"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                            $dig = '+' . $diff;
                                                        }
                                                        echo '<span class="diff-number">' . $dig . '</span> ' . $icon;
                                                    } else {
                                                        echo "___";
                                                    }
                                                    ?>
                                                </h5>
                                            </div>
                                            <div class="points-diff">
                                                <h6 class="text-center"><b><?php echo $result->total_points ?></b></h6>
                                            </div>
                                        </div>

                                        <!-- OVR POS Section -->
                                        <div class="col-md-2 col-lg-2 col-sm-2 position-box">
                                            <div class="horizontal-align">
                                                <div class="class-rank">
                                                    <h6 class="text-center">OVR POS</h6>
                                                </div>
                                                <h5 class="diff-container">
                                                    <?php
                                                    if ($prevresults) {
                                                        $diff = explode('/', $result->class_rank)[0] - explode('/', $prevresults->class_rank)[0];
                                                        if ($diff < 0) {
                                                            $icon = '<span class="arrow-down"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                            $dig = $diff;
                                                        } elseif ($diff == 0) {
                                                            $icon = '<span class="arrow-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                            $dig = 0;
                                                        } else {
                                                            $icon = '<span class="arrow-up"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                            $dig = '+' . $diff;
                                                        }
                                                        echo '<span class="diff-number">' . $dig . '</span> ' . $icon;
                                                    } else {
                                                        echo "___";
                                                    }
                                                    ?>
                                                </h5>
                                            </div>
                                            <div class="rank-diff">
                                                <h6 class="text-center"><b><?php echo $result->class_rank ?></b></h6>
                                            </div>
                                        </div>

                                        <!-- STR POS Section -->
                                        <div class="col-md-2 col-lg-2 col-sm-2 position-box">
                                            <div class="horizontal-align">
                                                <div class="stream-rank">
                                                    <h6 class="text-center">STR POS</h6>
                                                </div>
                                                <h5 class="diff-container">
                                                    <?php
                                                    if ($prevresults) {
                                                        $diff = explode('/', $result->stream_rank)[0] - explode('/', $prevresults->stream_rank)[0];
                                                        if ($diff < 0) {
                                                            $icon = '<span class="arrow-down"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                            $dig = $diff;
                                                        } elseif ($diff == 0) {
                                                            $icon = '<span class="arrow-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                            $dig = 0;
                                                        } else {
                                                            $icon = '<span class="arrow-up"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                            $dig = '+' . $diff;
                                                        }
                                                        echo '<span class="diff-number">' . $dig . '</span> ' . $icon;
                                                    } else {
                                                        echo "___";
                                                    }
                                                    ?>
                                                </h5>
                                            </div>
                                            <div class="stream-diff">
                                                <h6 class="text-center"><b><?php echo $result->stream_rank ?></b></h6>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Table Div Here -->

                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-lg-12 col-md-12">
                                            <table class="table border table-bordered" cellpadding="0" cellspacing="0" width="100%">
                                                <tr class="table-success">
                                                    <th></th>
                                                    <th class="text-center" colspan="<?php echo count(explode(',', $result->examsids)) ?>"><b>EXAMS INVOLVED</b></th>
                                                    <th colspan="5"></th>
                                                </tr>
                                                <tr class="table-success">
                                                    <th>LEARNING AREAS</th>
                                                    <?php
                                                    $exids = explode(',', $result->examsids);
                                                    foreach ($exids as $exkey => $mtihani) {
                                                    ?>
                                                        <th><?php echo $actualexams[$mtihani] ?></th>
                                                    <?php } ?>
                                                    <th>SCORE</th>
                                                    <th>DEV.</th>
                                                    <th>GRADE</th>
                                                    <th>COMMENT</th>
                                                    <th>TEACHER</th>
                                                </tr>
                                                <tbody>
                                                    <?php
                                                    foreach ($subscores as $key => $score) {
                                                        $subscount++;
                                                        $scoreoutof += $score->combinedmarks;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $subjects[$score->subject] ?></td>
                                                            <?php
                                                            $markids = explode(',', $score->involvedmarkids);
                                                            $thescores = explode(',', $score->involvedscores);
                                                            $theweights = explode(',', $score->involvedweights);
                                                            $exids = explode(',', $result->examsids);

                                                            foreach ($exids as $exkey => $mtihani) {
                                                                $examscore = $this->cbc_tr->find_mark($markids[$exkey]);

                                                                if ($score->type == 1) {
                                                                    $convertedscore = $examscore->score;
                                                                } else {
                                                                    $convertedscore =  $examscore ? round(($examscore->score * $theweights[$exkey]) / $examscore->outof, 0) : '_';
                                                                }
                                                            ?>
                                                                <td style="text-align:center"><?php echo $convertedscore ?></td>
                                                            <?php } ?>
                                                            <td style="text-align:center"><?php echo $score->combinedmarks ?></td>
                                                            <td style="text-align:center">
                                                                <?php
                                                                $compscore = $this->cbc_tr->compare_score($comparison, $result->student, $score->subject);

                                                                if ($compscore) {
                                                                    $diff = $score->combinedmarks - $compscore->combinedmarks;
                                                                    if ($diff < 0) {
                                                                        $icon = '<span style="color: red;"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                                        $dig = $diff;
                                                                    } elseif ($diff == 0) {
                                                                        $icon = '<span style="color: blue;"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                                        $dig = 0;
                                                                    } elseif ($diff > 0) {
                                                                        $icon = '<span style="color: #00cc00;"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                                        $dig = '+' . $diff;
                                                                    }

                                                                    echo '<span><b>' . $dig . '</b></span> ' . $icon;
                                                                } else {
                                                                    echo "_";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td style="text-align:center"><?php echo $score->grade ?></td>
                                                            <td><?php echo $score->remarks ?></td>
                                                            <td>
                                                                <?php
                                                                $teacherassigned = $this->cbc_tr->teacher_assigned($result->class, $score->subject, $thread->term, $thread->year);
                                                                $teacher = $this->teachers_m->find($teacherassigned->teacher);

                                                                echo ucwords($teacher->first_name . ' ' . $teacher->last_name);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="row" id="footerdiv">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xl-6">
                                            <h6><b>Perfomance Over Time</b></h6>
                                            <div id="performancewithtime_<?php echo $result->id ?>">

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xl-6">
                                            <h6><b>Exams Comparison</b></h6>
                                            <div id="examscomparison_<?php echo $result->student ?>">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xl-6">
                                            <div style="display: flex; align-items: center;">
                                                <div style="width: 60%; text-align: center;">
                                                    <h6 class="slim-text">Scan to Access your Smartshule Portal to view more details of your child.</h6>
                                                    <h6 class="slim-text"><b>Username: <u><?php echo $userparo->email ?></u></b></h6>
                                                </div>
                                                <div style="width: 40%; display: flex; justify-content: center;">
                                                    <input style="display: none;" type="text" name="loginlink" id="loginlink_<?php echo $result->id ?>" value="<?php echo base_url('login') ?>">
                                                    <div id="qrcode_<?php echo $result->id ?>" class="qrcode" style="width: 150px;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xl-6">
                                            <table style="width: 100%; border: none;">
                                                <tr>
                                                    <th style="border: none; width: 70%;">Remarks</th>
                                                    <th style="border: none; width: 30%;">Signature</th>
                                                </tr>
                                                <tbody>
                                                    <tr>
                                                        <td style="border: none; width: 70%;">
                                                            <b>Class Teacher </b>
                                                            <p><b><?php echo $result->trs_comment ?></b></p>
                                                        </td>
                                                        <td style="border-bottom: 1px solid black; width: 30%;"><u><span style="visibility: hidden;">Signature</span></u></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: none; width: 70%;">
                                                            <b>Principal</b>
                                                            <p><b><?php echo $result->prin_comment ?></b></p>
                                                        </td>
                                                        <td style="border-bottom: 1px solid black; width: 30%;"><u><span style="visibility: hidden;">Signature</span></u></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- <div class="page-break"></div> -->
                            <!-- COL-END -->
                        </div>
                <?php }
                } ?>
                <!-- Report Cards End Here -->

            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">

                </div>
                <div class="float-end d-inline-block btn-list">

                </div>
            </div>
        </div>
    </div>


</div>

<style>
    .qrcode {
        width: 120px;
        height: auto;
        padding: 6px;
        text-align: center;
    }

    .slim-text {
        font-size: 14px;
        font-weight: normal;
        /* margin: 5px 0; */

    }

    u {
        text-decoration: none;

    }

    .resultslip-card {
        /* margin: 10px; */
    }

    #positionsdiv {
        background-color: #e6f7ff;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
    }

    .text-right {
        text-align: right;
    }

    .blue-text {
        color: #00aaff;
    }

    .blue-bg {
        background-color: #00aaff;
        color: white;
        padding: 8px;
    }

    .page-break {
        page-break-after: always;
    }

    #SingleReportForm {
        box-shadow: 0px 4px 8px 2px rgba(0, 0, 0, 0.1);
        margin: 10px;
    }


    #studentsdiv h6 {
        font-size: 1.0em;
        font-weight: bold;
        color: #333;
    }

    .graphdiv {
        margin-top: 10px;
    }

    .position-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;
        gap: 3px;

    }

    .horizontal-align {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        /* Reduces the space between number and arrow */
    }

    .position-box h6 {
        font-size: 0.9em;
        margin: 2px 0;
        /* Reduced margin */
        color: #555;
    }

    .position-box h5 {
        font-size: 0.9em;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .diff-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2px;
        /* Reduced space between number and icon */
    }

    .diff-number {
        font-size: 0.9em;
        font-weight: bold;
    }

    .arrow-down {
        color: red;
    }

    .arrow-up {
        color: #00cc00;
    }

    .arrow-right {
        color: blue;
    }

    .total-points,
    .points-diff,
    .stream-rank,
    .stream-diff,
    .mean-grade,
    .total-marks,
    .class-rank {
        margin-bottom: 3px;
        /* Reduced space between upper and lower divs */
    }

    .table {
        width: 100%;
        margin-bottom: 3rem;
        background-color: transparent;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 6px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .table th {
        font-weight: bold;
    }



    .table td {
        white-space: nowrap;
        /* Prevent text wrapping */
    }


    .fa {
        margin-left: 3px;

    }


    @media (max-width: 768px) {

        .table th,
        .table td {
            padding: 6px;
            font-size: 0.9em;
            /* Slightly smaller font size */
        }
    }

    @media print {

        .text-right {
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

        #positionsdiv {
            background-color: #e6f7ff;
        }

        #cardheaderdiv {
            display: none;
        }

        #filterform {
            display: none;
        }

        hr {
            display: none;
        }

        #headerdiv::after {
            content: "";
            display: table;
            clear: both;
        }

        #headerdiv .col-md-6,
        #headerdiv .col-lg-6 {
            float: left;
            width: 50%;
        }



    }
</style>
<script>
    $(document).ready(function() {
        <?php
        foreach ($results as $key => $r) {
        ?>
            // Create QRCode instance for each element
            var qrcode_<?php echo $r->id ?> = new QRCode("qrcode_<?php echo $r->id ?>", {
                width: 100, // Default width
                height: 100, // Default height
                colorDark: "#80b3ff"
            });

            function makeCode_<?php echo $r->id ?>() {
                var elText_<?php echo $r->id ?> = $("#loginlink_<?php echo $r->id ?>").val();
                if (!elText_<?php echo $r->id ?>) {
                    alert("Input a text");
                    return;
                }
                qrcode_<?php echo $r->id ?>.makeCode(elText_<?php echo $r->id ?>);
            }

            // Initial QR code generation
            makeCode_<?php echo $r->id ?>();

            // Update QR code on input blur or enter key press
            $("#loginlink_<?php echo $r->id ?>").on("blur keydown", function(e) {
                if (e.type === 'blur' || e.keyCode === 13) {
                    makeCode_<?php echo $r->id ?>();
                }
            });

        <?php } ?>
    });
</script>
<script>
    $(document).ready(function() {
        <?php
        foreach ($results as $key => $result) {
            $stu = $this->worker->get_student($result->student);
            //Prepare Class Means
            $submeans = [];
            foreach ($clssubjects as $subkey => $subdetails) {
                $submarks = $this->cbc_tr->subscores($thread->id, $result->classgrp, $subkey); //Whole Class
                $stusubscore = $this->cbc_tr->compare_score($thread->id, $result->student, $subkey); //Student Score

                $scoredmarks = [];

                foreach ($submarks as $submark) {
                    $scoredmarks[] = $submark->combinedmarks;
                }

                $submeans[$subkey] = array(
                    'title' => $subdetails['title'],
                    'meanscores' => !empty($scoredmarks) ? round(array_sum($scoredmarks) / count($submarks)) : 0,
                    'studentscore' => $stusubscore->combinedmarks ? $stusubscore->combinedmarks : 0
                );
            }


        ?>

            var container = document.querySelector("#performance_<?php echo $result->id ?>");
            var containerWidth = container.clientWidth;
            var containerHeight = container.offsetHeight;

            var options = {
                series: [{
                    name: "<?php echo $this->classes[$result->classgrp] ?>",
                    type: 'column',
                    data: [
                        <?php foreach ($submeans as $sub => $details) {
                            echo $details['meanscores'] . ','
                        ?>

                        <?php } ?>
                    ]
                }, {
                    name: "<?php echo $stu->first_name ?>",
                    type: "line",
                    data: [
                        <?php foreach ($submeans as $sub => $details) {
                            echo $details['studentscore'] . ','
                        ?>

                        <?php } ?>
                    ]
                }],
                chart: {
                    height: 200,
                    width: '80%',
                    type: "line",
                    zoom: {
                        enabled: false
                    }
                },
                stroke: {
                    width: [0, 2]
                },
                title: {
                    text: "<?php echo $stu->first_name ?> vs <?php echo $this->classes[$result->class_group] ?> Perfomance subjectwise"
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [1]
                },
                // labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
                labels: [
                    <?php foreach ($submeans as $sub => $details) {
                        echo '"' . $details['title'] . '",'
                    ?>

                    <?php } ?>
                ],
                xaxis: {
                    type: 'category',
                },
                yaxis: [{
                        title: {
                            text: "<?php echo $this->classes[$result->classgrp] ?> Means",
                        },

                    },
                    {
                        opposite: true,
                        title: {
                            text: "<?php echo $stu->first_name ?> Scores"
                        }
                    }
                ]
            };

            var chart = new ApexCharts(document.querySelector("#performance_<?php echo $result->id ?>"), options);
            chart.render();

            //Area Chart
        <?php } ?>

        //Plot Periodic Performance
    });
</script>

<script>
    $(document).ready(function() {
        <?php
        foreach ($results as $key => $result) {
            $perfomances = $this->cbc_tr->last_four_scores($result->student, $result->type);

            $perfdata = [];
            foreach ($perfomances as $perf) {
                // $term = $this->igcse_m->find($perf->tid);
                $perfdata[] = array(
                    'mean_mark' => $perf->average_marks,
                    'class' => $this->classes[$perf->classgrp] . ' T' . $thread->term . ', ' . $thread->year
                );
            }
        ?>

            var options = {
                series: [{
                    name: 'Mean Score',
                    data: [
                        <?php
                        foreach ($perfdata as $yk => $pdata) {
                            echo $pdata['mean_mark'] . ','
                        ?>

                        <?php } ?>
                    ]
                }, ],
                chart: {
                    type: 'bar',
                    height: 180,
                    width: '65%',
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [
                        <?php
                        foreach ($perfdata as $yk => $pdata) {
                            echo '"' . $pdata['class'] . '",'
                        ?>

                        <?php } ?>
                    ],
                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "" + val + ""
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#performancewithtime_<?php echo $result->id ?>"), options);
            chart.render();

            //Area Chart
        <?php } ?>

        //Plot Periodic Performance
    });
</script>
<script>
    $(document).ready(function() {
        <?php
        foreach ($studentmarks as $stu => $examscores) {
            $exxs = [];
            $scrss = [];
            foreach ($examscores as $exa => $scr) {
                $scrss[] = $scr;
                $exxs[] = "'" . $actualexams[$exa] . "'";
            }
        ?>

            // Prepare data for the area chart for each student
            let seriesData_<?php echo $stu ?> = [{
                name: "Scores",
                data: [<?php echo implode(',', $scrss); ?>]
            }];

            // Area chart options for each student
            let options_<?php echo $stu ?> = {
                chart: {
                    type: 'area', // Changed from 'line' to 'area'
                    height: 180,
                    zoom: {
                        enabled: false
                    }
                },
                series: seriesData_<?php echo $stu ?>,
                xaxis: {
                    categories: [<?php echo implode(',', $exxs) ?>]
                },
                yaxis: {
                    title: {
                        text: 'Totals',
                        style: {
                            fontSize: '12px', // Adjust font size
                            fontWeight: 'bold',
                            color: '#263238'
                        },
                        offsetX: 0, // Horizontal offset
                        offsetY: 0, // Vertical offset
                    },
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0); // Formatting to avoid decimal overlap
                        }
                    },
                    tickAmount: 6, // Number of ticks in the y-axis to spread out the labels
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth' // Ensures smooth curves
                },
                fill: {
                    colors: ['#008FFB'], // Set the fill color for the area
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.7, // Adjust to match the given example
                        opacityTo: 0.2, // Adjust to match the given example
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#008FFB'], // Set the line color to match the fill
                grid: {
                    show: true,
                    borderColor: '#e7e7e7',
                    strokeDashArray: 0,
                    xaxis: {
                        lines: {
                            show: false // Disable horizontal lines
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false // Disable vertical lines
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    }
                }
            };

            // Render the area chart for each student
            let chart_<?php echo $stu ?> = new ApexCharts(document.querySelector("#examscomparison_<?php echo $stu ?>"), options_<?php echo $stu ?>);
            chart_<?php echo $stu ?>.render();

        <?php } ?>
    });
</script>