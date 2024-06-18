<?php
$settings = $this->ion_auth->settings();

echo "<pre>";
print_r($summary);
echo "</pre>";


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
                                        <thead class="table-success">
                                            <tr>
                                                <th>Class</th>
                                                <th>Mean Marks</th>
                                                <th>Mean Points</th>
                                                <th>Mean Grade</th>
                                                <th>Dev</th>
                                                <th>No. of Students</th>
                                            </tr>
                                        </thead>
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
                                                            $grade = (object) $this->cbc_tr->get_grade($mk->gid,$mk->ovrmarksavg);
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

                <?php
                }
                ?>
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
                series: [
                    {
                        // data: [44, 55, 41, 64, 22, 43, 21]
                        name: '<?php echo $threads[$tid] ?>',
                        data: [
                            <?php 
                                foreach ($thesummary as $cls => $marks) {
                                    $mk = (object) $marks;
                                    echo $mk->ovrmarksavg.',';
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
                                    echo $mk->ovrmarksavg.',';
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
                                        echo "'".$this->classes[$level]."'".",";
                                    } else {
                                        echo "'".$this->streams[$cls]."'".",";
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