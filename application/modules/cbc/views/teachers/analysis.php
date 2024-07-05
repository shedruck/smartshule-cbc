<?php
$settings = $this->ion_auth->settings();



?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" id="cardheaderdiv">
                <h6 class="float-start"><?php echo $thread->name ?> <b>Analysis</b> for <b><?php echo $this->classes[$level] ?></b></h6>
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
                        <button type="submit" class="btn btn-success">View Analysis</button>
                        <!-- <button type="button" class="btn btn-info mb-1 d-inline-flex" onclick="javascript:window.print();"><i class="si si-printer me-1 lh-base"></i> Print Report</button> -->
                    </div>

                </div>
                <?php echo form_close(); ?>
                <hr>
                <!-- </div> -->

                <!-- Report Cards Start Here -->
                <?php
                if (isset($summary)) {
                    $types = array(
                        1 => 'RUBRICS',
                        2 => 'MARKS'
                    );

                    $exams = $this->cbc_tr->populate('cbc_threads', 'id', 'exam');


                ?>
                    <div class="card">
                        <div class="card-header bg-light">
                            Perfomance Summary
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-xl-7 col-sm-7">
                                    <div id="summarydiv">

                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-xl-5 col-sm-5">
                                    <table class="table border table-bordered">
                                        <tr class="table-success">

                                            <th>Class</th>
                                            <th>Mean Marks</th>
                                            <th>Mean Points</th>
                                            <th>Mean Grade</th>
                                            <th>Dev</th>
                                            <th>No. of Students</th>
                                        </tr>
                                        <tbody>
                                            <?php
                                            $thesummary =  $summary['summary'];
                                            $thecomparison = $summary['comparisonsummary'];
                                            foreach ($thesummary as $cls => $marks) {
                                                $mk = (object) $marks;
                                                $compa = (object) $thecomparison[$cls];
                                            ?>
                                                <tr style="font-weight: <?php echo $cls == 0 ? 'bold' : '' ?>;">
                                                    <td><?php echo $cls == 0 ? $this->classes[$level] : $this->streams[$cls] ?></td>
                                                    <td><?php echo $mk->ovrmarksavg ?></td>
                                                    <td><?php echo $mk->ovrptsavg ?></td>
                                                    <td>
                                                        <?php
                                                        $grade = (object) $this->cbc_tr->get_grade($mk->gid, $mk->ovrmarksavg);
                                                        echo $grade->grade;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $diff = $mk->ovrmarksavg - $compa->ovrmarksavg;
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

                                                        echo '<span>' . $dig . '</span> ' . $icon;
                                                        // echo $diff;
                                                        ?>
                                                    </td>
                                                    <td><?php echo $mk->studentcount ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="card">
                        <div class="card-header bg-light">
                            Performance Per Subject
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                    <table class="table border table-bordered">
                                        <tr class="table-success">
                                            <th>Subject</th>
                                            <th>Overall Mean </th>
                                            <?php foreach ($streamwise as $classData) : ?>
                                                <th> <?php echo $this->streams[$classData['class']]; ?> Mean</th>
                                            <?php endforeach; ?>
                                            <th>Mean Points</th>
                                            <th>Grade</th>
                                            <th width="8%">Dev</th>
                                            <th>Rank</th>
                                            <th>No. of Students</th>
                                        </tr>
                                        <tbody>
                                            <?php
                                             $i = 1;
                                            foreach ($subjectwise as $key => $sub) {

                                            ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($subjects[$sub['subject']]); ?></td>
                                                    <td style="text-align:center"><strong><?php echo htmlspecialchars(number_format($sub['mean_combinedmarks'], 2)); ?></strong></td>

                                                    <?php foreach ($streamwise as $classData) :
                                                        // Find the subject in the current class
                                                        $found = false;
                                                        foreach ($classData['subjects'] as $subjectData) {
                                                            if ($subjectData['subject'] == $sub['subject']) {
                                                                $found = true;
                                                                echo "<td style='text-align:center'>" . number_format($subjectData['mean_combinedmarks'], 2) . "</td>";
                                                                break;
                                                            }
                                                        }

                                                        if (!$found) {
                                                            echo "<td>--</td>";
                                                        }
                                                    endforeach; ?>

                                                    <td style="text-align:center"><?php
                                                                                    $this->load->model('cbc_tr');

                                                                                    // Get the grade details
                                                                                    $gradeDetails = $this->cbc_tr->getGradeDetails($sub['mean_combinedmarks'], $gradingSystem);

                                                                                    if ($gradeDetails) {
                                                                                        echo $gradeDetails['points'];
                                                                                    } else {
                                                                                        echo "--";
                                                                                    }

                                                                                    ?></td>
                                                    <td style="text-align:center"><?php
                                                                                    $this->load->model('cbc_tr');

                                                                                    // Get the grade details
                                                                                    $gradeDetails = $this->cbc_tr->getGradeDetails($sub['mean_combinedmarks'], $gradingSystem);

                                                                                    if ($gradeDetails) {
                                                                                        echo $gradeDetails['grade'];
                                                                                    } else {
                                                                                        echo "--";
                                                                                    }

                                                                                    ?></td>
                                                    <td style="text-align:center">
                                                        <?php
                                                        foreach ($compare as $comp) {
                                                            if ($comp['subject'] === $sub['subject']) {

                                                                $dif = $sub['mean_combinedmarks'] - $comp['mean_combinedmarks'];
                                                                $diff = number_format($dif, 2);


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

                                                                echo '<span> <b>' . $dig . '</b> </span> ' . $icon;
                                                                // echo $diff;
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align:center"><?php echo $i++ ?></td>
                                                    <td style="text-align:center"><?php echo htmlspecialchars($sub['student_count']); ?></td>

                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>

                <hr>
                <div class="card">
                    <div class="card-header bg-light">
                        Mean Marks Per Subject
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                <div id="chart">

                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
                                <div id="chart2">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <hr>

                <!-- //Overall Performance -->
                <div class="card">
                    <div class="card-header bg-light">
                        Overall Performance
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                <table class="table border table-bordered">
                                    <tr class="table-success">
                                        <th>#</th>
                                        <th>Adm. No</th>
                                        <th>Name</th>
                                        <th>Stream</th>
                                        <th>Gender</th>
                                        <th>ST. POS</th>
                                        <th>OV. POS</th>
                                        <th>Mean</th>
                                        <th>DEV</th>
                                        <th>Marks</th>
                                        <th>Points</th>
                                        <th>Grade</th>
                                    </tr>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($overal as $key => $over) {
                                            $stu = $this->worker->get_student($over->student);

                                        ?>

                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td class="text-primary"><b><?php echo $stu->admission_number ?></b></td>
                                                <td><?php echo $stu->first_name . ' ' . $stu->last_name  ?></td>
                                                <td><?php echo $stu->cl->name  ?></td>
                                                <td><?php
                                                    if ($stu->gender == 1) {
                                                        echo "Male";
                                                    } else {
                                                        echo "Female";
                                                    }
                                                    ?></td>
                                                <td><?php echo $over->stream_rank  ?></td>
                                                <td><?php echo $over->class_rank  ?></td>
                                                <td><?php echo $over->average_marks  ?></td>
                                                <td>
                                                    <?php
                                                    foreach ($overalc as $overc) {
                                                        if ($overc->student === $over->student) {
                                                            if (!empty($overc->student)) {
                                                                $dev = $over->total_marks - $overc->total_marks;
                                                            } else {
                                                                $dev = "--";
                                                            }

                                                            if ($dev === "--") {
                                                                $icon = '';
                                                                $dig = $dev;
                                                            } elseif ($dev < 0) {
                                                                $icon = '<span style="color: red;"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                                $dig = $dev;
                                                            } elseif ($dev == 0) {
                                                                $icon = '<span style="color: blue;"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                                $dig = 0;
                                                            } elseif ($dev > 0) {
                                                                $icon = '<span style="color: #00cc00;"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                                $dig = '+' . $dev;
                                                            }

                                                            echo '<span> <b>' . $dig . '</b> </span> ' . $icon;
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <td><?php echo $over->total_marks  ?></td>
                                                <td><?php echo $over->total_points  ?></td>
                                                <td><?php echo $over->mean_grade  ?></td>
                                            </tr>


                                        <?php  } ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
                <hr>
                <!-- //Best performers Boys -->
                <div class="card">
                    <div class="card-header bg-light">
                        Top 10 Boys
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                <table class="table border table-bordered">
                                    <tr class="table-success">
                                        <th>#</th>
                                        <th>Adm. No</th>
                                        <th>Name</th>
                                        <th>Stream</th>
                                        <th>ST. POS</th>
                                        <th>OV. POS</th>
                                        <th>Mean</th>
                                        <th>DEV</th>
                                        <th>Marks</th>
                                        <th>Points</th>
                                        <th>Grade</th>
                                    </tr>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($overal_gender as $key => $over) {
                                            $stu = $this->worker->get_student($over->student);

                                            if ($stu->gender == 1) {

                                        ?>

                                                <tr>
                                                    <td><?php echo $i++ ?></td>
                                                    <td class="text-primary"><b><?php echo $stu->admission_number ?></b></td>
                                                    <td><?php echo $stu->first_name . ' ' . $stu->last_name  ?></td>
                                                    <td><?php echo $stu->cl->name  ?></td>
                                                    <td><?php echo $over->stream_rank  ?></td>
                                                    <td><?php echo $over->class_rank  ?></td>
                                                    <td><?php echo $over->average_marks  ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($overalc as $overc) {
                                                            if ($overc->student === $over->student) {
                                                                if (!empty($overc->student)) {
                                                                    $dev = $over->total_marks - $overc->total_marks;
                                                                } else {
                                                                    $dev = "--";
                                                                }

                                                                if ($dev === "--") {
                                                                    $icon = '';
                                                                    $dig = $dev;
                                                                } elseif ($dev < 0) {
                                                                    $icon = '<span style="color: red;"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                                    $dig = $dev;
                                                                } elseif ($dev == 0) {
                                                                    $icon = '<span style="color: blue;"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                                    $dig = 0;
                                                                } elseif ($dev > 0) {
                                                                    $icon = '<span style="color: #00cc00;"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                                    $dig = '+' . $dev;
                                                                }

                                                                echo '<span> <b>' . $dig . '</b> </span> ' . $icon;
                                                            }
                                                        }
                                                        ?>
                                                    </td>

                                                    <td><?php echo $over->total_marks  ?></td>
                                                    <td><?php echo $over->total_points  ?></td>
                                                    <td><?php echo $over->mean_grade  ?></td>
                                                </tr>


                                        <?php
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
                <hr>

                <!-- //Best performers Girls -->
                <div class="card">
                    <div class="card-header bg-light">
                        Top 10 Girls
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xl-12 col-sm-12">
                                <table class="table border table-bordered">
                                    <tr class="table-success">
                                        <th>#</th>
                                        <th>Adm. No</th>
                                        <th>Name</th>
                                        <th>Stream</th>
                                        <th>ST. POS</th>
                                        <th>OV. POS</th>
                                        <th>Mean</th>
                                        <th>DEV</th>
                                        <th>Marks</th>
                                        <th>Points</th>
                                        <th>Grade</th>
                                    </tr>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($overal_gender as $key => $over) {
                                            $stu = $this->worker->get_student($over->student);

                                            if ($stu->gender == 2) {

                                        ?>

                                                <tr>
                                                    <td><?php echo $i++ ?></td>
                                                    <td class="text-primary"><b><?php echo $stu->admission_number ?></b></td>
                                                    <td><?php echo $stu->first_name . ' ' . $stu->last_name  ?></td>
                                                    <td><?php echo $stu->cl->name  ?></td>
                                                    <td><?php echo $over->stream_rank  ?></td>
                                                    <td><?php echo $over->class_rank  ?></td>
                                                    <td><?php echo $over->average_marks  ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($overalc as $overc) {
                                                            if ($overc->student === $over->student) {
                                                                if (!empty($overc->student)) {
                                                                    $dev = $over->total_marks - $overc->total_marks;
                                                                } else {
                                                                    $dev = "--";
                                                                }

                                                                if ($dev === "--") {
                                                                    $icon = '';
                                                                    $dig = $dev;
                                                                } elseif ($dev < 0) {
                                                                    $icon = '<span style="color: red;"><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span>';
                                                                    $dig = $dev;
                                                                } elseif ($dev == 0) {
                                                                    $icon = '<span style="color: blue;"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>';
                                                                    $dig = 0;
                                                                } elseif ($dev > 0) {
                                                                    $icon = '<span style="color: #00cc00;"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></span>';
                                                                    $dig = '+' . $dev;
                                                                }

                                                                echo '<span> <b>' . $dig . '</b> </span> ' . $icon;
                                                            }
                                                        }
                                                        ?>
                                                    </td>

                                                    <td><?php echo $over->total_marks  ?></td>
                                                    <td><?php echo $over->total_points  ?></td>
                                                    <td><?php echo $over->mean_grade  ?></td>
                                                </tr>


                                        <?php
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div id="chart">

</div>
<?php
$subjects = array_map(function ($subjectCode) use ($subjects) {
    return $subjects[$subjectCode];
}, array_column($subjectwise, 'subject'));

$meanMarks = array_column($subjectwise, 'mean_combinedmarks');

?>

<script>
    // PHP arrays encoded as JSON
    var subjects = <?php echo json_encode($subjects); ?>;
    var meanMarks = <?php echo json_encode($meanMarks); ?>;

    // Chart options
    var options = {
        series: [{
            name: 'Mean Combined Marks',
            data: meanMarks
        }],
        chart: {
            height: 350,
            type: 'bar',
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                columnWidth: '50%', // Reduce the bar width
                dataLabels: {
                    position: 'top', // top, center, bottom
                },
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val.toFixed(2); // Display marks with 2 decimal places
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
        },
        xaxis: {
            categories: subjects, // Use the names for categories
            position: 'bottom', // Move x-axis to the bottom
            axisBorder: {
                show: true // Show x-axis border
            },
            axisTicks: {
                show: true // Show x-axis ticks
            },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: {
                enabled: true,
            }
        },
        yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: true,
                formatter: function(val) {
                    return val.toFixed(2); // Display marks with 2 decimal places
                }
            }
        },
        title: {
            text: 'Mean Combined Marks by Subject',
            floating: false,
            offsetY: 10,
            align: 'center',
            style: {
                color: '#444'
            }
        }
    };

    // Render the chart
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<!-- second graph -->

<?php
// Prepare data for the chart
$categories = $subs; // Subject names
$series = [];

// Extract series data for each class
foreach ($streamwise as $classData) {
    $className = $classData['class'];
    $classSeries = [
        'name' => $this->streams[$className],
        'data' => []
    ];

    // Collect mean marks for each subject
    foreach ($categories as $subjectId => $subjectName) {
        $meanMarks = 0;

        // Find the subject data in $classData['subjects'] based on subject ID
        foreach ($classData['subjects'] as $subjectData) {
            if ($subjectData['subject'] == $subjectId) {
                $meanMarks = $subjectData['mean_combinedmarks'];
                break;
            }
        }

        $classSeries['data'][] = $meanMarks;
    }

    $series[] = $classSeries;
}
?>
<script>
    // PHP arrays encoded as JSON
    var categories = <?php echo json_encode(array_values($categories)); ?>;
    var series = <?php echo json_encode($series); ?>;

    // Chart options
    var options = {
        series: series,
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
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
            categories: categories,
            position: 'bottom',
            axisBorder: {
                show: true
            },
            axisTicks: {
                show: true
            },
            tooltip: {
                enabled: true
            }
        },
        yaxis: {
            title: {
                text: ''
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(2); // Show y-axis labels with 2 decimal places
                }
            }
        },
        title: {
            text: 'Subject Comparison per Stream',
            floating: false,
            offsetY: 10,
            align: 'center',
            style: {
                color: '#444'
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val.toFixed(2); // Show tooltip values with 2 decimal places
                }
            }
        }
    };

    // Render the chart
    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();
</script>

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
<script>
    $(document).ready(function() {
        //Draw Summary Analysis Graph
        <?php
        if (isset($summary)) {
            $thesummary =  $summary['summary'];
            $thecomparison = $summary['comparisonsummary'];
        ?>
            var options = {
                series: [{
                        // data: [44, 55, 41, 64, 22, 43, 21]
                        name: '<?php echo $threads[$tid] ?>',
                        data: [
                            <?php
                            foreach ($thesummary as $cls => $marks) {
                                $mk = (object) $marks;
                                echo $mk->ovrmarksavg . ',';
                            ?>

                            <?php } ?>
                        ]
                    },
                    {
                        // data: [53, 32, 33, 52, 13, 44, 32]
                        name: '<?php echo $threads[$comparison] ?>',
                        data: [
                            <?php
                            foreach ($thecomparison as $cls => $marks) {
                                $mk = (object) $marks;
                                echo $mk->ovrmarksavg . ',';
                            ?>

                            <?php } ?>
                        ]
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 300
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                xaxis: {
                    // categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
                    categories: [
                        <?php
                        foreach ($thecomparison as $cls => $marks) {
                            $mk = (object) $marks;

                            if ($cls == 0) {
                                echo "'" . $this->classes[$level] . "'" . ",";
                            } else {
                                echo "'" . $this->streams[$cls] . "'" . ",";
                            }

                        ?>

                        <?php } ?>
                    ],
                },
            };

            var chart = new ApexCharts(document.querySelector("#summarydiv"), options);
            chart.render();

        <?php } ?>
    });
</script>