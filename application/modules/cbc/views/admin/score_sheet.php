<?php
$map_grades = [
    1 => 'BE',
    2 => 'AE',
    3 => 'ME',
    4 => 'EE'
];

$total_students = count($payload);


?>
<div class="tools hidden-print">
    <div class="panel panel-primary">
        <div class="panel-heading">Score sheet</div>
        <div class="panel-body">
            <?php echo form_open(current_url()) ?>
            <table class="table table-bordered">
                <tr>
                    <th>Class</th>
                    <th>Term</th>
                </tr>
                <tr>
                    <td>
                        <?php echo form_dropdown('class', ['' => ''] +  $this->streams, $this->input->post('class'), 'class="select"') ?>
                    </td>
                    <td>
                        <?php echo form_dropdown('term', ['' => ''] +  $this->terms, $this->input->post('term'), 'class="select"') ?>
                    </td>
                </tr>
                <tr>

                    <th>Year</th>
                    <th>Exam</th>
                </tr>

                <tr>
                    <td>

                        <?php
                        $range = range(date('Y') - 5, date('Y'));
                        $yrs = array_combine($range, $range);
                        krsort($yrs);
                        echo form_dropdown('year', ['' => ''] + $yrs, $this->input->post('year'), 'class="select"') ?>
                    </td>

                    <td>
                        <?php
                        $exm = [1 => 'Opener Exam', 2 => 'Mid Term', 3 => 'End Term'];
                        echo form_dropdown('exam', ['' => ''] + $exm, $this->input->post('exam'), 'class="select"') ?>
                        <button class="btn btn-primary" type="submit">Filter</button>

                        <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                    </td>
                </tr>
            </table>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<div class="invoice">

    <?php

    if ($marks) {
    ?>
        <div class="row">
            <div class="col-xm-12">
                <div class="col-xm-4"></div>
                <div class="col-xm-4">
                    <center>
                        <img src="<?php echo base_url('uploads/files/' . $this->school->document) ?>" style="width:80px">
                        <h4><?php echo $this->school->school ?></h4>
                        <h3>SCORE SHEET</h3>
                        <h5> <?php echo isset($this->streams[$this->input->post('class')]) ? $this->streams[$this->input->post('class')] : '' ?> Term <?php echo $this->input->post('term') ?> <?php echo $this->input->post('year') ?></h5>
                    </center>
                </div>
                <div class="col-xm-3"></div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <?php
                    foreach ($subjects as $sb => $sub) {
                    ?>
                        <th class="mks"><?php echo $sub ?></th>
                    <?php } ?>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $index = 1;
                $prev = null;
                $out_of = count($subjects) * 4;
                $sum = [];

            
                foreach ($payload as $p) 
                {
                    $st = $this->worker->get_student($p['data']['student']);
                    $mks = isset($marks[$p['data']['student']]) ? $marks[$p['data']['student']] : [];
                    $score =  $p['data']['score'];


                ?>
                    <tr>
                        <td><?php
                            if ($score != $prev)
                            {
                                echo $index;
                                $tie = $index;
                            } else {
                                echo $tie;
                            }
                        ?></td>
                        <td><?php echo $st->first_name . ' ' . $st->middle_name . ' ' . $st->last_name ?></td>
                        <?php


                     
                        foreach ($subjects as $sb => $sub) {
                            $mk = isset($mks[$sb]) ? $mks[$sb] : 0;
                            $sum[$sb] += $mk;
                        ?>
                            <td class="mks"><?php echo $mk ?> <?php echo isset($map_grades[$mk]) ? $map_grades[$mk] : '' ?></td>
                        <?php } ?>

                        <td><?php echo $score ?> / <?php echo $out_of ?></td>

                    </tr>
                <?php $index++;
                    $prev = $score;
                } ?>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold; ">Mean Score</td>
                    <?php
                    foreach ($subjects as $sb => $sub) {
                        $tt = isset($sum[$sb]) ? $sum[$sb] : 0;
                        $avg = ($tt / $total_students)

                    ?>
                        <td style="text-align: center; font-weight: bold; width:10%  "><?php echo number_format($avg, 2) ?> <?php echo isset($map_grades[$avg]) ? $map_grades[$avg] : '' ?></td>
                    <?php } ?>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <hr>

        <h4>Grade Analysis</h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Grade</th>
                    <?php
                    foreach ($grade_count as $gr => $vl) {
                    ?>
                        <th><?php echo  isset($map_grades[$gr]) ? $map_grades[$gr] : '' ?></th>

                    <?php } ?>
                </tr>
            </thead>
            <tr>
                <td>Count</td>
                <?php
                foreach ($grade_count as $gr => $vl) {
                ?>
                    <td><?php echo  $vl ?></td>
                <?php } ?>
            </tr>
        </table>

        <hr>
        <br>
        <h4>Graphical Representation of Grade Analysis</h4>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="col-md-5 col-xs-5">
                    <canvas id="subject_ln"></canvas>
                </div>

                <div class="col-sm-2 col-xs-2"></div>

                <div class="col-md-5 col-xs-5">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

        </div>

        <hr>
        <h1>Subject Analysis</h1>

        <table class="table">
            <tr>
                <th>#</th>
                <th>SUBJECT</th>
                <?php
                foreach ($map_grades as $gr => $value) {
                ?>
                    <th><?php echo $value ?></th>
                <?php } ?>
            </tr>
            <?php
            $index = 1;
            foreach ($subjects as $sb => $sub) {
                $analysis =  isset($subject_analysis[$sb]) ? $subject_analysis[$sb] : [];


            ?>
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo $sub ?></td>

                    <?php
                    foreach ($map_grades as $gr => $value) {
                        $analy =  isset($analysis[$gr]) ? $analysis[$gr] : [];

                        echo '<td>' . count($analy) . '</td>';
                    }
                    ?>
                </tr>

            <?php $index++;
            } ?>
        </table>

        <hr>
        <h4>Subject Ranking</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Subject</th>
                    <th>Mean Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rank = 1;
                $prevScore = null;
                $subject_analysiss = [];
                foreach ($sum as $sb => $mss) {
                    $mean = ($mss / $total_students);
                    $subject_analysiss[] = [
                        'subject' => isset($subjects[$sb]) ? $subjects[$sb] : '',
                        'mss' => number_format($mss)
                    ];
                }

                $totals = [];
                foreach ($subject_analysiss as $item) {
                    $total = $item['mss'];
                    $totals[] = ['data' => $item, 'total' => $total];
                }

                // Sort the array based on the 'total' values in descending order
                usort($totals, function ($a, $b) {
                    return $b['total'] - $a['total'];
                });

                ?>
                <?php
                foreach ($totals as $t) {
                    $ms = number_format($t['data']['mss'], 2);


                ?>
                    <tr>
                        <td><?php

                            if ($ms != $prevScore) {
                                echo $rank;
                                $tie = $rank;
                            } else {
                                echo $tie;
                            }
                            ?></td>
                        <td><?php echo $t['data']['subject'] ?></td>
                        <td><?php echo number_format($ms / $total_students, 2) ?></td>
                    </tr>

                <?php
                    $rank++;
                    $prevScore = $ms;
                } ?>
            </tbody>
        </table>



        <hr>
        <h4>Graphical Representation</h4>
       

        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="charttt" style="width:80%"></div>

            </div>

        </div>


    <?php } else { ?>
        <pre>No data!!</pre>
    <?php } ?>
</div>

<style>
    .mks {
        text-align: center;
        width: 5%
    }



    @media print {
        #scrollUp {
            display: none;
        }
    }
</style>

<?php
$line_graph = [];
foreach ($grade_count as $grd => $tt) {
    $line_graph[] = [
        'grade' => isset($map_grades[$grd]) ? $map_grades[$grd] : '',
        'value' => $tt
    ];
}


$Subject_analysiss = [];
// $sum = [];
foreach ($sum as $sb => $mss) {
    $Subject_analysiss[] = [
        'subject' => isset($subjects[$sb]) ? $subjects[$sb] : '',
        'mss' => number_format($mss / $total_students, 2)
        // 'mss' => $mss
    ];
}


?>

<script>
    // line
    var totalMarks = <?php echo json_encode($line_graph); ?>;

    var ctx = document.getElementById('subject_ln').getContext('2d');

    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: totalMarks.map(item => item.grade),
            datasets: [{
                label: 'Total Grades',
                data: totalMarks.map(item => item.value),
                borderColor: 'blue',
                fill: false
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Grade Analyis'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Grades'
                    }
                }
            }
        }
    });


    //  bar graph 

    var maksItems = <?php echo json_encode($line_graph); ?>;

    var cttx = document.getElementById('barChart').getContext('2d');

    var barChart = new Chart(cttx, {
        type: 'bar',
        data: {
            labels: maksItems.map(item => item.grade),
            datasets: [{
                label: 'Total Grades',
                data: maksItems.map(item => item.value),
                backgroundColor: 'blue',
                borderColor: 'blue',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Grade Analysis'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Grades'
                    }
                }
            }
        }
    });






    //subject analysis bar graph

    var sbt = <?php echo json_encode($Subject_analysiss); ?>;

    var ccttx = document.getElementById('sb_ana_ln').getContext('2d');

    var barChart = new Chart(ccttx, {
        type: 'bar',
        data: {
            labels: sbt.map(item => item.subject),
            datasets: [{
                label: 'Mean Score',
                data: sbt.map(item => item.mss),
                backgroundColor: 'blue',
                borderColor: 'blue',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Subject Analysis'
            },


            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Grades'
                    },
                    ticks: {
                        maxRotation: 90,
                        minRotation: 90
                    },

                }
            }
        }
    });
</script>

<head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
</head>

<?php
$sbss = [];
foreach ($subjects as $sb => $sb_name) {
    $sbss[] = $sb_name;
}

$ssum = [];

foreach($sum as $s => $mk)
{
    $ssum[] = number_format($mk/$total_students,2);
}
?>

<script>
    // Sample data for the bar graph
    var options = {
        chart: {
            type: 'bar',
        },
        series: [{
            name: 'Mean Score',
            data: <?php echo json_encode($ssum)?>,
        }, ],
        xaxis: {
            categories: <?php echo json_encode($sbss) ?>,
        },
    };

    // Create and render the chart
    var chart = new ApexCharts(document.querySelector('#charttt'), options);
    chart.render();
</script>