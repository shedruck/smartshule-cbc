<?php 
$cls = $this->input->post('class');
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" id="cardheaderdiv">
                <h6 class="float-start"><?php echo $thread->name ?> Marks Sheet for <b><?php echo $this->classes[$level] ?></b></h6>
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
                    <!-- <div class="col-lg-3 col-md-3 col-xl-3">
                        <?php
                        echo form_dropdown('compare', array('' => 'Select Exam for Compare') + $threads, $this->input->post('compare'), ' class="form-control select" id="compare" data-placeholder="" ');
                        ?>
                    </div> -->
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <button type="submit" class="btn btn-success">Show Results</button>
                        <button type="button" class="btn btn-info mb-1 d-inline-flex" onclick=""><i class="si si-printer me-1 lh-base"></i> Export Excel</button>
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
                ?>
                <div class="table-responsive">
                    <table class="table border table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th rowspan="3"></th>
                                <th colspan="<?php echo count($subjects) + 8 ?>" class="text-center"><?php echo strtoupper($thread->name) ?></th>
                                <th rowspan="3"></th>
                            </tr>
                            <tr>
                                <th colspan="<?php echo count($subjects) + 8 ?>" class="text-center"><?php echo 'TERM '.$thread->term.','.$thread->year ?></th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-center">
                                    <?php 
                                        if ($cls == 0) {
                                            echo "_";
                                        } else {
                                            $clsteacher = $this->cbc_tr->get_teacher($cls);
                                            echo $clsteacher;
                                        }
                                        
                                    ?>
                                </th>
                                <th colspan="<?php echo count($subjects) + 2 ?>" class="text-center"><?php echo $cls == 0 ? $this->classes[$level] : $this->streams[$cls] ?> MARK LIST</th>
                                <th colspan="3" class="text-center"><?php echo date('d-m-Y') ?></th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Adm</th>
                                <th>Name</th>
                                <th>CLASS</th>
                                <th>STR POS</th>
                                <th>CLASS POS</th>
                                <?php 
                                    foreach ($subjects as $skey => $sdetails) {
                                        $sub = (object) $sdetails;
                                        ${'sub_' . $skey} = 0;
                                ?>
                                <th><?php echo $sub->short_name; ?></th>
                                <?php } ?>
                                <th>GRAND</th>
                                <th>AVERAGE</th>
                                <th>AVERAGE PTS</th>
                                <th>MEAN GRADE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 0;
                                $grand = 0; 
                                $grandavgs = 0;
                                $avgpts = 0;
                                $gid = 0;
                                $type = 0;
                                foreach ($results as $key => $result) {
                                    $stu = $this->worker->get_student($result->student);
                                    $i++;
                                    $grand += $result->total_marks;
                                    $grandavgs += $result->average_marks;
                                    $avgpts += $result->average_points;
                                    $gid = $result->gid;
                                    $type = $result->type;
                                    // echo "<pre>";
                                    //     print_r($result);
                                    // echo "</pre>";
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $stu->admission_number; ?></td>
                                    <td><?php echo ucwords($stu->first_name.' '.$stu->last_name); ?></td>
                                    <td><?php echo $this->streams[$stu->class] ?></td>
                                    <th><?php echo $result->stream_rank ?></th>
                                    <td><?php echo $result->class_rank ?></td>
                                    <?php 
                                        foreach ($subjects as $skey => $sdetails) {
                                            $score = $this->cbc_tr->get_subject_scores($thread->id,$stu->id,$skey);
                                            
                                            if ($score) {
                                                $subscore = $score->combinedmarks;
                                                ${'subb_' . $skey}++;
                                                ${'sub_' . $skey} += $subscore;
                                            } else {
                                                $subscore = "_";
                                            }
                                            
                                    ?>
                                    <td><?php echo $subscore ?></td>
                                    <?php } ?>
                                    <td><b><?php echo $result->total_marks ?></b></td>
                                    <td><b><?php echo $result->average_marks ?></b></td>
                                    <td><b><?php echo $result->average_points ?></b></td>
                                    <td><b><?php echo $result->mean_grade ?></b></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="<?php echo count($subjects) + 10 ?>"></td>
                            </tr>
                            <tr>
                                <td rowspan="2"></td>
                                <td colspan="5">TOTAL</td>
                                <?php 
                                    foreach ($subjects as $skey => $sdetails) {
                                            
                                    ?>
                                    <td><?php echo ${'sub_' . $skey} ?></td>
                                <?php } ?>
                                <td><b><?php echo $grand ?></b></td>
                                <td><b><?php echo $grandavgs ?></b></td>
                                <td><b><?php echo $avgpts ?></b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5">MEAN</td>
                                <?php 
                                    foreach ($subjects as $skey => $sdetails) {
                                            
                                    ?>
                                    <td>
                                    <?php 
                                        $submean = round(${'sub_' . $skey} / ${'subb_' . $skey},2);
                                        $subjectsmeans[$skey] = $submean;
                                        echo $submean;
                                    ?>
                                    </td>
                                <?php } ?>
                                <td><b><?php echo round($grand / count($results),2) ?></b></td>
                                <td><b><?php echo round($grandavgs / count($results),2) ?></b></td>
                                <td><b><?php echo round($avgpts / count($results),2) ?></b></td>
                                <td>
                                    <b>
                                        <?php 
                                            $avg = round($grandavgs / count($results),0);

                                            if ($type == 1) {
                                                if ($avg == 4) {
                                                    $grade = 'EE';
                                                    echo $grade;
                                                } elseif ($avg == 3) {
                                                    $grade = 'ME';
                                                    echo $grade;
                                                } elseif ($avg == 2) {
                                                    $grade = 'AE';
                                                    echo $grade;
                                                } elseif ($avg == 1) {
                                                    $grade = 'BE';
                                                    echo $grade;
                                                }
                                            } elseif ($type == 2) {
                                                $avg = round($grandavgs / count($results),2);
                                                echo $this->cbc_tr->get_grade($gid,$avg)['grade'];
                                            }
                                        ?>
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="<?php echo count($subjects) + 10 ?>"></td>
                            </tr>
                           <tr>
                            <td></td>
                            <td colspan="3"></td>
                            <td colspan="2" class="text-center">MEAN</td>
                            <td colspan="3" class="text-center">TEACHER</td>
                            <td rowspan="<?php echo count($subjects) + 1 ?>" colspan="<?php echo count($subjects) + 1 ?>"></td>
                           </tr>
                            <?php 
                                $ii = 0;
                                foreach ($subjects as $skey => $sdetails) {
                                    $ii++;

                                    $sub = (object) $sdetails;  
                            ?>
                                    <tr>
                                        <td><?php echo $ii ?></td>
                                        <td colspan="3"><?php echo $sub->name ?></td>
                                        <td colspan="2">
                                        <?php 
                                        if ($type == 1) {
                                            $submean = round(${'sub_' . $skey} / ${'subb_' . $skey},0);
                                            $subjectsmeans[$skey] = $submean;
                                            echo $submean;
                                        } else {
                                            $submean = round(${'sub_' . $skey} / ${'subb_' . $skey},2);
                                            $subjectsmeans[$skey] = $submean;
                                            echo $submean;
                                        }   
                                        ?>
                                        </td>
                                        <td colspan="3"></td>
                                    </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                        
                    <?php
                     
                    } 
                ?>
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
            width: 150px;
            height: auto;
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

        @media print {
            /* .card {
            padding: 10px;
            width: 100%;
            border: none !important;
            box-shadow: none !important;
        } */

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
    