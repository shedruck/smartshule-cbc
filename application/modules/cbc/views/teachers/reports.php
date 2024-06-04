<?php 
$settings = $this->ion_auth->settings(); 
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
                        foreach ($results as $key => $result) {
                            $stu = $this->worker->get_student($result->student);
                            $paro = $this->portal_m->get_parent($stu->parent_id);
                            $userparo = $this->ion_auth->get_user($paro->user_id);

                            $prevresults = $this->cbc_tr->prev_score($comparison,$result->student);

                            $subscores = $this->cbc_tr->student_scores($thread->id,$result->student);

                            $subscount = 0;
                            $scoreoutof = 0;
                        
                ?>
                <div class="row page-break" id="SingleReportForm">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- <div class="card-header">

                            </div> -->
                            <div class="card-body p-10">
                                <div class="row" id="headerdiv">
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6">
                                        <img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6 text-right">
                                        <h5 class="blue-text"><b><?php echo strtoupper($this->school->school) ?></b></h5>
                                        <h6><?php echo strtoupper($this->school->postal_addr) ?></b></h6>
                                        <h6><?php echo $this->school->tel ?></h6>
                                        <h6><?php echo $this->school->email ?></h6>
                                    </div>
                                </div>

                                <h6 class="text-center blue-bg">ACADEMIC TRANSCRIPT FOR - <?php echo $this->classes[$result->classgrp] ?> - <?php echo $thread->name ?> - (<?php echo $thread->year ?>/Term <?php echo $thread->term ?>)</h6>

                                <div class="row" id="studentsdiv">
                                    <div class="col-md-3 col-lg-3 col-sm-3 col-xl-3">
                                        <?php
                                        $passport = $this->admission_m->passport($stu->photo);
                                        $fake = base_url('uploads/files/member.png');

                                        if (count($passport) !== 0) {
                                            $path = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
                                        }

                                        ?>
                                        <img src="<?php echo $fake ?>" alt="Student Profile" class="img-fluid img-thumbnail">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-sm-3 col-xl-3">
                                        <h6>Name : <?php echo ucwords($stu->first_name . ' ' . $stu->last_name) ?></h6>
                                        <h6>ADM NO : <?php echo $stu->admission_number ?></h6>
                                        <h6>CLASS : <?php echo $this->streams[$stu->class] ?></h6>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xl-6">
                                        <div id="performance_<?php echo $result->id ?>" class="graphdiv">

                                        </div>
                                    </div>
                                </div>

                                <!-- Position Div Here -->
                                            
                                <!-- Position Div Here -->

                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-lg-12 col-md-12">
                                        <table class="table" cellpadding="0" cellspacing="0" width="100%">
                                            <thead class="bg-light">
                                                <th>SUBJECTS</th>
                                                <th>SCORE</th>
                                                <th>DEV.</th>
                                                <th>GRADE</th>
                                                <!-- <th>CLASS RANK</th> -->
                                                <!-- <th>STREAM RANK</th> -->
                                                <th>COMMENT</th>
                                                <th>TEACHER</th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    
                                                    foreach ($subscores as $key => $score) {
                                                        
                                                        $subscount++;
                                                        $scoreoutof += $score->total;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $subjects[$score->subject] ?></td>
                                                        <td><?php echo $score->combinedmarks ?></td>
                                                        <td>
                                                            <?php
                                                                $compscore = $this->cbc_tr->compare_score($comparison,$result->student,$score->subject);

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
                                                                        $dig = '+'.$diff;
                                                                    }

                                                                    echo '<span><b>'.$dig.'</b></span> '.$icon;
                                                                } else {
                                                                    echo "_";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $score->grade ?></td>
                                                        <!-- <td><?php echo $score->ovr_rank ?></td> -->
                                                        <!-- <td><?php echo $score->stream_rank ?></td> -->
                                                        <td><?php echo $score->remarks ?></td>
                                                        <td>
                                                            <?php 
                                                                $teacherassigned = $this->cbc_tr->teacher_assigned($result->class,$score->subject);
                                                                $teacher = $this->teachers_m->find($teacherassigned->teacher);
                                                                
                                                                echo ucwords($teacher->first_name.' '.$teacher->last_name);
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
                                        
                                        <div style="display: flex;">
                                        <div style="width: 60%;">
                                            <h6 class="text-center">Scan to Access your Smartshule Portal to view more details of your child.</h6>
                                            <h6 class="text-center"><b>Username : <u><?php echo $userparo->email ?></u></b></h6>
                                        </div>
                                        <div style="width: 40%">
                                            <input style="display: none;" type="text" name="loginlink" id="loginlink_<?php echo $result->id ?>" value="<?php echo base_url('login') ?>">
                                            <div id="qrcode_<?php echo $result->id ?>" class="qrcode" style="width: 150px;">
                                                
                                            </div>
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
                            <!-- <div class="card-footer text-end">

                            </div> -->
                        </div>
                    </div>
                    <!-- COL-END -->
                </div>
                <?php } } ?>
                <!-- Report Cards End Here -->

            </div>
            <div class="card-footer">
                <div class="form-check d-inline-block">
                    <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
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

    @media print {
        .text-right {
            text-align: right;
        }

        .page-break {
            page-break-after: always;
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
$(document).ready(function(){
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
        $("#loginlink_<?php echo $r->id ?>").on("blur keydown", function (e) {
            if (e.type === 'blur' || e.keyCode === 13) {
                makeCode_<?php echo $r->id ?>();
            }
        });

    <?php } ?>
});
</script>