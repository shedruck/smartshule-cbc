<?php 
$settings = $this->ion_auth->settings(); 
?>
<div class="head">
    <div class="icon"></div>
    <h2><?php echo $thread->title . ' - (Term ' . $thread->term . ' ' . $thread->year . ')' ?></h2>
    <div class="right"></div>
</div>
<?php
$sslist = array();
foreach ($this->classlist as $ssid => $s) {
    $sslist[$ssid] = $s['name'];
}

// $s1 = $rank ? '' : ' checked="checked" ';
// $s2 = '';
// $s3 = '';
// if ($rank)
// {
//     $s1 = $rank == 1 ? ' checked="checked" ' : '';
//     $s2 = $rank == 2 ? ' checked="checked" ' : '';
//     $s3 = $rank == 3 ? ' checked="checked" ' : '';
// }
?>
<div class="toolbar">
    <div class="row row-fluid">
        <div class="col-md-12 span12">
            <?php echo form_open(current_url()); ?>
            <div class="row mb-3">
                <div class="col-lg-3 col-md-3">
                    Class
                    <?php echo form_dropdown('group', array("" => " Select ") + $this->classes, $this->input->post('group'), 'class ="tsel"'); ?>
                </div>
                <div class="col-lg-1 col-md-1">
                    OR
                </div>
                <div class="col-lg-3 col-md-3">
                    Stream
                    <?php echo form_dropdown('class', array('' => 'Select') + $sslist, $this->input->post('class'), 'class ="tsel" '); ?>
                </div>
                <div class="col-lg-3 col-md-3">
                    Compare With (For Deviation)
                    <?php
                    $gradings = $this->igcse_m->populate('grading_system', 'id', 'title');
                    echo form_dropdown('thread', array('' => 'Select') + $threads, $this->input->post('thread'), 'class ="tsel"');
                    ?>
                </div>
                <div class="col-lg-2 col-md-2">
                    View <br>
                    <button class="btn btn-primary" type="submit">View Results</button>
                </div>
            </div>

            <div class="pull-right">
                <a href="" onClick="window.print(); return false" class="btn btn-warning"><i class="icos-printer"></i> Print </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php
if (isset($results)) {

    $subjects = $this->igcse_m->populate('subjects','id','name');
   

    foreach ($results as $key => $result) {
        $stu = $this->worker->get_student($result->student);
        $paro = $this->portal_m->get_parent($stu->parent_id);
        $userparo = $this->ion_auth->get_user($paro->user_id);

        // echo "<pre>";
        //     print_r($userparo);
        // echo "</pre>";

        $clssubjects = $this->exams_m->get_subjects($result->class,$thread->term);
       
        //Get Current Positions
        // foreach ($resultpositions as $keeey => $posi) {

        //     if ($keeey === 'ovrpositions') {
        //         foreach ($posi as $posikey => $pos) {
        //             if ($posikey == $key) {

        //                 $ovrpos = $pos;
        //                 $ovroutof = count($posi);
        //             }
        //         }
        //     } elseif ($keeey === 'strpositions') {
        //         foreach ($posi as $posikey => $pos) {
        //             if ($posikey == $key) {
        //                 $strpos = $pos;
        //             }
        //         }
        //     }
        // }

        //Get Previous Positions

        $stroutof = count($this->igcse_m->student_count($thread->id,$result->class));

        $subscores = $this->igcse_m->student_scores($thread->id,$result->student);

        $prevresults = $this->igcse_m->prev_score($comparison,$result->student);

?>
        <div class="invoice">
            <!-- Transcript Start -->
            <div class="row" id="headerdiv">
                <div class="col-md-6 col-lg-6">
                    <img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />
                </div>
                <div class="col-md-6 col-lg-6 text-right">
                    <h5 class="blue-text"><b><?php echo strtoupper($this->school->school) ?></b></h5>
                    <h6><b><?php echo strtoupper($this->school->postal_addr) ?></b></h6>
                    <h6><b><?php echo $this->school->tel ?></b></h6>
                    <h6><b><?php echo $this->school->email ?></b></h6>
                </div>
            </div>

            <h5 class="text-center blue-bg">ACADEMIC TRANSCRIPT FOR - <?php echo $this->classes[$result->class_group] ?> - <?php echo $thread->title ?> - (<?php echo $thread->year ?>/Term <?php echo $thread->term ?>)</h5>

            <div class="row" id="studentsdiv">
                <div class="col-md-3 col-lg-3">
                    <?php
                    $passport = $this->admission_m->passport($stu->photo);
                    $fake = base_url('uploads/files/member.png');

                    if (count($passport) !== 0) {
                        $path = base_url('uploads/' . $passport->fpath . '/' . $passport->filename);
                    }

                    ?>
                    <img src="<?php echo $fake ?>" alt="Student Profile" class="img-fluid img-thumbnail">
                </div>
                <div class="col-md-3 col-lg-3">
                    <h6><b>Name : <?php echo ucwords($stu->first_name . ' ' . $stu->last_name) ?></b></h6>
                    <h6><b>ADM NO : <?php echo $stu->admission_number ?></b></h6>
                    <h6><b>CLASS : <?php echo $this->streams[$stu->class] ?></b></h6>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div id="performance_<?php echo $result->id ?>" class="graphdiv">

                    </div>
                </div>
            </div>

            <div class="row mb-2" id="positionsdiv">
                <div class="col-md-2 col-lg-2" style="display: flex;">
                    <div style="width: 60%;">
                        <h6 class="text-center"><b>Mean</b></h6>
                        <h6 class="text-center"><b><?php echo  $result->mean_grade ?>|<?php echo  $result->mean_mark ?>%</b></h6>
                    </div>
                    <div style="width: 40%;">
                        <h5>
                            <?php 
                                if ($prevresults) {
                                    $diff = $result->mean_mark - $prevresults->mean_mark;
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
                                    echo "___";
                                }
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3" style="display: flex;">
                    <div style="width: 70%;">
                        <h6 class="text-center"><b>Total</b></h6>
                        <h6 class="text-center"><b><?php echo  $result->total ?>/<?php echo  $result->outof ?></b></h6>
                    </div>
                    <div style="width: 30%;">
                        <h5>
                            <?php 
                                if ($prevresults) {
                                    $diff = $result->total - $prevresults->total;
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
                                    echo "___";
                                }
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2" style="display: flex;">
                    <div style="width: 70%;">
                        <h6 class="text-center"><b>Total Points</b></h6>
                        <h6 class="text-center"><b><?php echo  $result->points ?>/<?php echo  $result->points_outof ?></b></h6>
                    </div>
                    <div style="width: 30%;">
                        <h5>
                            <?php 
                                if ($prevresults) {
                                    $diff = $result->points - $prevresults->points;
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
                                    echo "___";
                                }
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-md-2 col-lg-2" style="display: flex;">
                    <div style="width: 70%;">
                        <h6 class="text-center"><b>OVR Pos</b></h6>
                        <h6 class="text-center"><b><?php echo $result->ovr_pos ?>/<?php echo count($results) ?></b></h6>
                    </div>
                    <div style="width: 30%;">
                        <h5>
                            <?php 
                                if ($prevresults) {
                                    $diff = $result->ovr_pos - $prevresults->ovr_pos;
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
                                    echo "___";
                                }
                            ?>
                        </h5>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3" style="display: flex;">
                    <div style="width: 70%;">
                        <h6 class="text-center"><b>Stream Pos</b></h6>
                        <h6 class="text-center"><b><?php echo $result->str_pos  ?>/<?php echo $stroutof ?></b></h6>
                    </div>
                    <div style="width: 30%;">
                        <h5>
                            <?php 
                                if ($prevresults) {
                                    $diff = $result->str_pos - $prevresults->str_pos;
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
                                    echo "___";
                                }
                            ?>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="col-lg-12 col-md-12">
                    <table class="table" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <th>SUBJECTS</th>
                            <th>MARKS (%)</th>
                            <th>DEV.</th>
                            <th>GRADE</th>
                            <th>CLASS RANK</th>
                            <th>STREAM RANK</th>
                            <th>COMMENT</th>
                            <th>TEACHER</th>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($subscores as $key => $score) {
                            ?>
                                <tr>
                                    <td><?php echo $subjects[$score->subject] ?></td>
                                    <td><?php echo $score->total ?></td>
                                    <td>
                                        <?php
                                            $compscore = $this->igcse_m->compare_score($comparison,$result->student,$score->subject);

                                            if ($compscore) {
                                                $diff = $score->total - $compscore->total;
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
                                    <td><?php echo $score->ovr_rank ?></td>
                                    <td><?php echo $score->stream_rank ?></td>
                                    <td><?php echo $score->comment ?></td>
                                    <td>
                                        <?php 
                                            $teacherassigned = $this->igcse_m->teacher_assigned($result->class,$score->subject);
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
                <div class="col-lg-6 col-md-6">
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
                <div class="col-lg-6 col-md-6">
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
            <!-- Transcript Start -->
        </div>
        <div class="page-break"></div>
<?php
    }
}
?>
<script>
    $(document).ready(
        function() {
            $(".tsel").select2({
                'placeholder': 'Please Select',
                'width': '200px'
            });
            $(".tsel").on("change", function(e) {
                notify('Select', 'Value changed: ' + e.added.text);
            });
            $(".fsel").select2({
                'placeholder': 'Please Select',
                'width': '400px'
            });
            $(".fsel").on("change", function(e) {
                notify('Select', 'Value changed: ' + e.added.text);
            });
        });
</script>

<script>
    $(document).ready(function(){
        <?php 
            foreach ($results as $key => $result) {
                $stu = $this->worker->get_student($result->student);
                //Prepare Class Means
                $submeans = [];
                foreach ($clssubjects as $subkey => $subdetails) {
                    $submarks = $this->igcse_m->subscores($thread->id,$result->class_group,$subkey); //Whole Class
                    $stusubscore = $this->igcse_m->compare_score($thread->id,$result->student,$subkey); //Student Score

                    $scoredmarks = [];

                    foreach ($submarks as $submark) {
                        $scoredmarks[] = $submark->total;
                    }

                    $submeans[$subkey] = array(
                        'title' => $subdetails['title'],
                        'meanscores' => !empty($scoredmarks) ? round(array_sum($scoredmarks) / count($submarks)) : 0,
                        'studentscore' => $stusubscore->total ? $stusubscore->total : 0
                    );
                }

                
        ?>

        var container = document.querySelector("#performance_<?php echo $result->id ?>");
        var containerWidth = container.clientWidth;
        var containerHeight = container.offsetHeight;

        var options = {
          series: [{
          name: '<?php echo $this->classes[$result->class_group] ?>',
          type: 'column',
          data: [
            <?php foreach ($submeans as $sub => $details) { 
                echo $details['meanscores'].','    
            ?>

            <?php } ?>
            ]
        }, {
          name: '<?php echo $stu->first_name ?>',
          type: 'line',
          data: [
            <?php foreach ($submeans as $sub => $details) { 
                echo $details['studentscore'].','    
            ?>

            <?php } ?>
        ]
        }],
          chart: {
            height: 200,
            width: '80%',
            type: 'line',
            zoom : {
                enabled: false
            }
        },
        stroke: {
          width: [0, 2]
        },
        title: {
          text: '<?php echo $stu->first_name ?> vs <?php echo $this->classes[$result->class_group] ?> Perfomance subjectwise'
        },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [1]
        },
        // labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
        labels: [
            <?php foreach ($submeans as $sub => $details) { 
                echo '"'.$details['title'].'",'    
            ?>

            <?php } ?>
        ],
        xaxis: {
          type: 'category',
        },
        yaxis: [{
          title: {
            text: '<?php echo $this->classes[$result->class_group] ?> Means',
          },
         
        }, 
            {
            opposite: true,
            title: {
                text: '<?php echo $stu->first_name ?> Scores'
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
    $(document).ready(function(){
        <?php 
            foreach ($results as $key => $result) {
                $perfomances = $this->igcse_m->last_four_scores($result->student);

                $perfdata = [];
                foreach ($perfomances as $perf) {
                    $term = $this->igcse_m->find($perf->tid);
                    $perfdata[] = array(
                        'mean_mark' => $perf->mean_mark,
                        'class' => $this->classes[$perf->class_group].' T'.$term->term.', '.$term->year
                    );
                }  
        ?>

var options = {
          series: [{
          name: 'Mean Score',
          data: [
            <?php 
                foreach ($perfdata as $yk => $pdata) {
                echo $pdata['mean_mark'].','
             ?>

            <?php } ?>
            ]
        }, 
    ],
          chart: {
          type: 'bar',
          height: 150,
          width : '65%',
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
                echo '"'.$pdata['class'].'",'
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
            formatter: function (val) {
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

<!-- <script>
    $(document).ready(function(){
        <?php 
            foreach ($results as $key => $r) {
            # code...
         ?>
            var qrcode = new QRCode("qrcode_<?php echo $r->id ?>");

            function makeCode () {		
                var elText = document.getElementById("loginlink_<?php echo $r->id ?>");
                
                if (!elText.value) {
                    alert("Input a text");
                    elText.focus();
                    return;
                }
                
                qrcode.makeCode(elText.value);
            }

            makeCode();

            $("#loginlink_<?php echo $r->id ?>").
                on("blur", function () {
                    makeCode();
                }).
                on("keydown", function (e) {
                    if (e.keyCode == 13) {
                        makeCode();
                    }
            });

        <?php } ?>
    });
</script> -->
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

<style>
    .qrcode {
        width: 150px;
        height: auto;
    }

    .blue-text {
        color: #00aaff;
    }

    .blue-bg {
        background-color: #00aaff;
        color: white;
        padding: 8px;
    }

    #positionsdiv {
        background-color: #e6f7ff;
    }

    .xxd,
    .editableform textarea {
        height: 150px !important;
    }

    .editable-container.editable-inline {
        width: 89%;
    }

    .col-sm-2 {
        width: 16.66666667%;
    }

    .col-sm-8 {
        width: 66.66666667%;
    }

    .editable-input {
        display: inline;
        width: 89%;
    }

    .editableform .form-control {
        width: 89%;
    }

    .invoice {
        padding: 20px;
    }

    .topdets {
        width: 85%;
        margin: 6px auto;
        border: 0;
    }

    .topdets th,
    .topdets td,
    .topdets {
        border: 0;
    }

    .morris-hover {
        position: absolute;
        z-index: 1000;
    }

    .morris-hover.morris-default-style {
        border-radius: 10px;
        padding: 6px;
        color: #666;
        background: rgba(255, 255, 255, 0.8);
        border: solid 2px rgba(230, 230, 230, 0.8);
        font-family: sans-serif;
        font-size: 12px;
        text-align: center;
    }

    .morris-hover.morris-default-style .morris-hover-row-label {
        font-weight: bold;
        margin: 0.25em 0;
    }

    .morris-hover.morris-default-style .morris-hover-point {
        white-space: nowrap;
        margin: 0.1em 0;
    }

    .tablex {
        width: 95% !important;
        margin: auto 15px !important;
        border: 1px solid #000 !important;
    }

    .tablex tr {
        border: 1px solid #000 !important;
    }

    .tablex td {
        border: 1px solid #000;
    }

    .tablex th {
        border: 1px solid #000 !important;
    }

    .page-break {
        margin-bottom: 15px;
    }

    .dropped {
        border-bottom: 3px solid silver !important;
    }

    legend {
        width: auto;
        padding: 4px;
        margin-bottom: 0;
        border: 0;
        font-size: 11px;
    }

    fieldset {
        padding: 5px;
        border: 1px solid silver;
        border-radius: 7px;
    }

    @media print {
        .invoice {
            padding: 20px !important;
        }

        /* .graphdiv {
            width: 100%;
            overflow: hidden;
        } */

        /* .graphdiv {
            width: 50%;
        } */

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

        #studentsdiv::after {
            content: "";
            display: table;
            clear: both;
        }

        #studentsdiv .col-md-3,
        #studentsdiv .col-lg-3,
        #studentsdiv .col-md-6,
        #studentsdiv .col-lg-6 {
            float: left;
        }

        #studentsdiv .col-md-3,
        #studentsdiv .col-lg-3 {
            width: 25%;
        }

        #studentsdiv .col-md-6,
        #studentsdiv .col-lg-6 {
            width: 50%;
        }

        #positionsdiv::after {
            content: "";
            display: table;
            clear: both;
        }

        #positionsdiv .col-md-3,
        #positionsdiv .col-lg-3,
        #positionsdiv .col-md-2,
        #positionsdiv .col-lg-2 {
            float: left;
        }

        #positionsdiv .col-md-3,
        #positionsdiv .col-lg-3 {
            width: 25%;
        }

        #positionsdiv .col-md-2,
        #positionsdiv .col-lg-2 {
            width: 16.66667%;
        }

        #footerdiv::after {
            content: "";
            display: table;
            clear: both;
        }
        #footerdiv .col-md-6,
        #footerdiv .col-lg-6 {
            float: left;
            width: 50%;
        }

        .topdets {
            width: 85% !important;
            margin: auto 15px !important;
            border: 0;
        }

        .tablex {
            width: 100%;
        }

        .page-break {
            display: block;
            page-break-after: always;
            position: relative;
        }

        table td,
        table th {
            padding: 4px;
        }

        .editable-click,
        a.editable-click,
        a.editable-click:hover {
            text-decoration: none;
            border-bottom: none !important;
        }

        .dropped {
            border-bottom: 3px solid silver !important;
        }
    }
</style>
