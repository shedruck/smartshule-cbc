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
                <!-- <div class="col-lg-3 col-md-3">
                    Select Thread
                    <?php
                    $gradings = $this->igcse_m->populate('grading_system', 'id', 'title');
                    echo form_dropdown('thread', array('' => 'Select') + $threads, $this->input->post('thread'), 'class ="tsel"');
                    ?>
                </div> -->
                <div class="col-lg-2 col-md-2">
                    <button class="btn btn-primary" type="submit">View Comments</button>
                </div>
            </div>

            <!-- <div class="pull-right">
                <a href="" onClick="window.print(); return false" class="btn btn-warning"><i class="icos-printer"></i> Print </a>
            </div> -->
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php
if (isset($results)) {
    // $subjects = $this->igcse_m->populate('subjects','id','name');
?>
    <div class="block invoice">
    <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo   form_open_multipart('admin/igcse/update_comments/'.$id, $attributes);
    ?>
        <table class="table" width="100">
            <thead>
                <tr>
                    <th>#</th>
                    <td>Student</td>
                    <td>Total</td>
                    <th>Mean Mark</th>
                    <th>Mean Grade</th>
                    <th>Class Teacher's Comment</th>
                    <th>Principal's Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $totals = 0;
                $means = 0;
                $gids = [];

                foreach ($results as $keey => $r) {
                    $i++;
                    // $subjects = $this->igcse_m->populate('subjects','id','name');
                    $stu = $this->worker->get_student($r->student);
                    $subscores = $this->igcse_m->student_scores($thread->id, $r->student);

                    $includedsubs = [];

                    foreach ($subscores as $subscore) {
                        $includedsubs[] = $subscore->subject;
                    }

                    //Load Gids 
                    $gids[] = $r->gid;

                ?>
                    <tr>
                        <td style="display: none;"><input type="number" name="mark[]" value="<?php echo $r->id ?>" id="mark"></td>
                        <td><?php echo $i ?></td>
                        <td><?php echo ucwords($stu->first_name . ' ' . $stu->last_name) . ' - ' . $stu->admission_number ?></td>
                        </td>
                        <td>
                            <?php
                            echo $r->total;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $r->mean_mark;
                            ?>
                        </td>
                        <td><?php echo $r->mean_grade ?></td>
                        <td>
                            <textarea name="classteachercomment[]" id="classteachercomment" class="form-control" cols="30" rows="5"><?php echo $r->trs_comment ?></textarea>
                        </td>
                        <td>
                            <textarea name="principalcomment[]" id="principalcomment" class="form-control" cols="30" rows="5"><?php echo $r->prin_comment ?></textarea>
                        </td>
                    </tr>
                <?php } ?>
                
            </tbody>
        </table>

    <h6 class="text-center"><button class="btn btn-primary" type="submit">Update Comments</button></h6>
    <?php echo form_close(); ?>   
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
        <?php
        foreach ($results as $key => $result) {
            $stu = $this->worker->get_student($result->student);
            //Prepare Class Means
            $submeans = [];
            foreach ($clssubjects as $subkey => $subdetails) {
                $submarks = $this->igcse_m->subscores($thread->id, $result->class_group, $subkey); //Whole Class
                $stusubscore = $this->igcse_m->compare_score($thread->id, $result->student, $subkey); //Student Score

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
                            echo $details['meanscores'] . ','
                        ?>

                        <?php } ?>
                    ]
                }, {
                    name: '<?php echo $stu->first_name ?>',
                    type: 'line',
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
                    type: 'line',
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
                        echo '"' . $details['title'] . '",'
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
    $(document).ready(function() {
        <?php
        foreach ($results as $key => $result) {
            $perfomances = $this->igcse_m->last_four_scores($result->student);

            $perfdata = [];
            foreach ($perfomances as $perf) {
                $term = $this->igcse_m->find($perf->tid);
                $perfdata[] = array(
                    'mean_mark' => $perf->mean_mark,
                    'class' => $this->classes[$perf->class_group] . ' T' . $term->term . ', ' . $term->year
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
                    height: 150,
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