<?php
$settings = $this->ion_auth->settings();

$exoutofs = [];

foreach ($marks as $mark) {
    $outofs = [];

    foreach ($exams as $ex) {
        $stumark = $this->igcse_m->get_stu_mark($mark->student,$mark->subject,$ex->id);

        if ($stumark) {
            $outofs[$ex->id] = $stumark->out_of;
        } 
    }

   $exoutofs = $outofs;
}


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
                    Select Thread
                    <?php
                    $gradings = $this->igcse_m->populate('grading_system', 'id', 'title');
                    echo form_dropdown('thread', array('' => 'Select') + $threads, $this->input->post('thread'), 'class ="tsel" id="thread"');
                    ?>
                </div>
                <div class="col-lg-3 col-md-3">
                    Class
                    <?php echo form_dropdown('group', array("" => " Select ") + $this->classes, $this->input->post('group'), 'class ="tsel" id="clsgroup"'); ?>
                </div>
                <div class="col-lg-1 col-md-1">
                    OR
                </div>
                <div class="col-lg-3 col-md-3">
                    Stream
                    <?php echo form_dropdown('class', array('' => 'Select') + $sslist, $this->input->post('class'), 'class ="tsel" id="stream"'); ?>
                </div>
                <div class="col-lg-3 col-md-3">
                    Subject
                    <!-- <?php echo form_dropdown('subject', array('' => 'Select'), $this->input->post('subject'), 'class ="tsel" id="subject'); ?> -->
                    <select name="subject" class="tsel" id="subject">

                    </select>
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
if (isset($marks)) {
    // $subjects = $this->igcse_m->populate('subjects','id','name');
    // echo "<pre>";
    //     print_r($exams);
    // echo "</pre>";
?>
    <div class="block invoice">
        <div class="row-fluid center">
            <div class="col-sm-12">
                <span class="" style="text-align:center">
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" width="50" height="50" />
                </span>
                <h3>
                    <span style="text-align:center !important;font-size:15px;"><?php echo strtoupper($this->school->school); ?></span>
                </h3>
                <small style="text-align:center !important;font-size:12px; line-height:2px;">
                    <?php
                    if (!empty($this->school->tel)) {
                        echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                    } else {
                        echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                    }
                    ?>
                </small>
                <h3>
                    <span style="text-align:center !important;font-size:13px; font-weight:700; border:double; padding:5px;">MOTTO: <?php echo strtoupper($this->school->motto); ?></span>
                </h3>
                
                
                <h4>
                    <?php
                    // echo $this->classes[$clsgroup];
                    // $c_t = '';
                    if ($clsgroup) {
                        $c_t = isset($clsgroup) ? $this->classes[$clsgroup] : $this->streams[$stream];
                    }
                    if ($thread) {
                        echo '<b>'.$subject->name.'</b> - '.$c_t . ' - ' . $thread->title . ' - Term ' . $thread->term . ' ' . $thread->year;
                    }
                    ?>
                </h4>
                
            </div>
        </div>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>YR</th>
                    <th>Gender</th>
                    <th>TM</th>
                    <th>TG</th>
                    <?php 
                        foreach ($exams as $ex) {
                            if ($ex->type == 1) {
                                continue;
                            }
                    ?>
                        <td><?php echo "X/".$exoutofs[$ex->id] ?></td>
                        <td><?php echo $ex->title ?>%</td>
                        <td>GR</td>
                    <?php } ?>
                    <td>AVG RAW</td>
                    <td>AV %</td>
                    <td>GR</td>
                    <?php 
                        foreach ($exams as $ex) {
                            if ($ex->type == 2) {
                                continue;
                            }
                    ?>
                        <td><?php echo "X/".$exoutofs[$ex->id] ?></td>
                    <?php } ?>
                    <th>EOT%</th>
                    <th>GR</th>
                    <th>TOTAL</th>
                    <th>GR</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 0;
                    foreach ($marks as $key => $mark) {
                        $i++;
                        $stu = $this->worker->get_student($mark->student);
                 ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo ucwords($stu->first_name . ' ' . $stu->last_name) . ' - ' . $stu->admission_number ?></td>
                        <td><?php echo $this->streams[$stu->class]; ?></td>
                        <td>
                            <?php 
                                if ($stu->gender == 1) {
                                    echo 'Male';
                                } elseif($stu->gender == 1) {
                                    echo 'Female';
                                } else {
                                    echo '';
                                }
                            ?>
                        </td>
                        <td></td>
                        <td></td>
                        <?php 
                        $cattots = 0;
                        $catcount = 0;
                        $percs  = 0;

                        foreach ($exams as $ex) {
                            if ($ex->type == 1) {
                                continue;
                            }

                            $stumark = $this->igcse_m->get_stu_mark($stu->id,$mark->subject,$ex->id);

                            if ($stumark) {
                                $score = $stumark->marks;
                                $perc = round($score / $stumark->out_of * 100);
                                $grading = $this->igcse_m->retrieve_grading($stumark->gid);
                                $outof = $stumark->out_of;

                                foreach ($grading as $gy => $grad) {
                                    if ($perc >= $grad->minimum_marks && $perc <= $grad->maximum_marks) {
                                        $grade = $grad->grade;
                                    }
                                }

                                $cattots += $score;
                                $catcount += 1;
                                $percs += $perc;
                            } else {
                                
                            }
                            
                           
                        ?>
                        <td><?php echo $score; ?></td>
                        <td><?php echo $perc ?>%</td>
                        <td><?php echo $grade ?></td>
                        <?php } ?>
                        <td><?php echo round($cattots / $catcount) ?></td>
                        <td><?php echo round($percs / $catcount) ?></td>
                        <td>
                            <?php 
                                $grading = $this->igcse_m->retrieve_grading($mark->grading);
                                $percavg = round($percs / $catcount); 

                                foreach ($grading as $gy => $grad) {
                                    if ($percavg >= $grad->minimum_marks && $percavg <= $grad->maximum_marks) {
                                        $grade = $grad->grade;
                                    }
                                }

                                echo $grade;
                            ?>
                        </td>
                        <?php 
                        foreach ($exams as $ex) {
                            if ($ex->type == 2) {
                                continue;
                            }

                            $stumark = $this->igcse_m->get_stu_mark($stu->id,$mark->subject,$ex->id);

                            if ($stumark) {
                                $score = $stumark->marks;
                                $perc = round($score / $stumark->out_of * 100);
                                $grading = $this->igcse_m->retrieve_grading($stumark->gid);

                                foreach ($grading as $gy => $grad) {
                                    if ($perc >= $grad->minimum_marks && $perc <= $grad->maximum_marks) {
                                        $grade = $grad->grade;
                                    }
                                }

                                $cattots += $score;
                                $catcount += 1;
                                $percs += $perc;
                            } else {
                                
                            }
                        ?>
                        <td><?php echo $score?></td>
                        <td><?php echo $perc ?></td>
                        <td><?php echo $grade ?></td>
                        <?php } ?>
                        <td><?php echo $mark->total ?></td>
                        <td>
                            <?php 
                                $grading = $this->igcse_m->retrieve_grading($mark->grading);
                                $total = $mark->total;

                                foreach ($grading as $gy => $grad) {
                                    if ($total >= $grad->minimum_marks && $total <= $grad->maximum_marks) {
                                        $grade = $grad->grade;
                                    }
                                }

                                echo $grade;
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-9">

            </div>
            <div class="col-md-3"> <small><?php echo 'Report Generated at:' . date('d M Y H:i:s'); ?></small></div>
        </div>

    </div>
<?php

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
    $(document).ready(function() {
        //Subjects by Class Group
        $("#clsgroup").change(function() {
            var val = $(this).val();
            var tid = $("#thread").val();

            var url = `<?php echo base_url('admin/igcse/class_subjects') ?>/${val}/${tid}`;

            $.ajax({
                method: 'GET',
                url: `${url}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res) {
                    // console.log(res);

                    var rooms = JSON.parse(res);
                    $('#subject').html('');
                    var html = '';

                    html += '<option value="">Select Subject</option>';

                    for (var key in rooms) {
                        if (rooms.hasOwnProperty(key)) {
                            var value = rooms[key];
                            html += '<option value="' + key + '">' + value + '</option>';
                        }
                        $('#subject').html(html);
                    }

                }
            })
        });

        //Subjects by Class Stream
        $("#stream").change(function() {
            var val = $(this).val();
            var tid = $("#thread").val();

            var url = `<?php echo base_url('admin/igcse/stream_subjects') ?>/${val}/${tid}`;

            $.ajax({
                method: 'GET',
                url: `${url}`,
                contentType: false,
                processData: false,
                //dataType: 'json',
                success: function(res) {
                    console.log(res);

                    var rooms = JSON.parse(res);
                    $('#subject').html('');
                    var html = '';

                    html += '<option value="">Select Subject</option>';

                    for (var key in rooms) {
                        if (rooms.hasOwnProperty(key)) {
                            var value = rooms[key];
                            html += '<option value="' + key + '">' + value + '</option>';
                        }
                        $('#subject').html(html);
                    }

                }
            })
        });
    });
</script>


<style>
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