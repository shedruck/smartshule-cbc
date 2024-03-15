<div class="row hidden-print">
    <hr />
    <div class="col-md-12">
        <div class="card-bsox">
            <h2 class="header-title m-t-0 m-b-20">Exam Results
                <div class="pull-right">
                    <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </h2>
        </div>
    </div>
</div>
<div class="col-md-2"></div>
<div class="col-sm-8 widget card-box table-responsive">
    <?php
    $haspos = 1;
    $this->load->library('Dates');
    $pref = '';

    $post = (object) $post;
    $xm = [
        1 => '<span class="label label-info">Opener</span>',
        2 => '<span class="label label-success">Midterm</span>',
        3 => '<span class="label label-primary">Endterm</span>'
    ];

    $j = 0;
    $student_id = 0;
    foreach ($payload as $stu => $row) :
        $j++;
        $rw = (object) $row;
        $student_id = $stu;
        $st = $this->worker->get_student($stu);
        $clss = isset($this->streams[$post->class]) ? $this->streams[$post->class] : '';

    ?>
        <div class="row page-break ">
            <div class="row-fluid text-center">
                <?php
                $file = FCPATH . '/uploads/joint-header.png';
                if (file_exists($file)) {
                ?>
                    <span class="col-sm-2" style="text-align:center"></span>
                    <span class="col-sm-8" style="text-align:center">
                        <img src="<?php echo base_url('uploads/joint-header.png'); ?>" class="center" />
                    </span>
                    <span class="col-sm-2" style="text-align:center">
                        <?php
                        if (!empty($st->photo)) :
                            $passport = $this->ion_auth->passport($st->photo);
                            if ($passport) {
                        ?>
                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                                <?php } ?>

                            <?php else : ?>
                                <?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                            <?php endif; ?>
                    </span>
                <?php
                } else {
                ?>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <span class="" style="text-align:center">
                            <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" width="100" height="100" />
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
                        <br>
                        <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">Student Performance Terminal Report</small>
                    </div>
                    <div class="col-sm-2">
                        <?php
                        if (!empty($st->photo)) :
                            $passport = $this->ion_auth->passport($st->photo);
                            if ($passport) {
                        ?>
                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                                <?php } ?>

                            <?php else : ?>
                                <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                            <?php endif; ?>
                    </div>
                <?php } ?>
            </div>

            <hr>
            <div class="row  text-center">
                <div class="col-md-12">
                    <table class="topdets table ">
                        <tr>
                            <td><strong>Name : </strong>
                                <abbr><?php echo $st->first_name . ' ' . $st->middle_name . ' ' . $st->last_name; ?> </abbr>
                            </td>
                            <td><strong>Term : </strong> <abbr><?php echo $post->term; ?></abbr></td>
                            <td><strong>Year : </strong> <abbr><?php echo $post->year; ?></abbr></td>
                            <td><strong>ADM No : </strong>
                                <abbr><?php
                                        echo  $st->admission_number;
                                        ?>
                                </abbr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Class : </strong>
                                <abbr><?php echo $clss; ?>
                                </abbr>
                            </td>
                            <td>
                                <strong>Age : </strong>
                                <abbr>
                                    <?php echo (!empty($st->dob) && $st->dob > 10000) ? $this->dates->createFromTimeStamp($st->dob)->diffInYears() : '-'; ?>
                                </abbr>
                            </td>
                            <td><strong>Exam : </strong> <abbr><?php echo isset($xm[$post->exam]) ? $xm[$post->exam] : '' ?></abbr></td>
                            <td> <strong>Class Teacher : </strong>
                                <abbr><?php
                                        $cc = '';
                                        if (!empty($rw->cls->class_teacher)) {
                                            $ctc = $this->ion_auth->get_user($rw->cls->class_teacher);
                                            if ($ctc) {
                                                $cc = $ctc->first_name . ' ' . $ctc->last_name;
                                            }
                                        }
                                        echo $cc;
                                        ?>
                                </abbr>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Subject</th>
                        <th width="20%">Marks</th>
                        <th width="20%">Grade</th>
                        <th colspan="">Remarks</th>
                        <th colspan="">Teacher</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $ind = 0;
                    $gd = 0;

                    foreach ($row as $sb => $marks) {
                        $ind++;
                        foreach ($marks as $mkk) {
                            $gd += $mkk['marks'];

                            $grade = $this->cbc_exams_m->calculateGradeAndRemarks($mkk['marks']);
                    ?>
                            <tr>
                                <td class="text-center"><?php echo $ind ?></td>
                                <td><i><?php echo isset($subjects[$sb]) ? $subjects[$sb] : '-'; ?></i></td>
                                <td><small><?php echo $mkk['marks']; ?> </small></td>
                                <td><?php echo $grade['grade'] ?></td>
                                <td><?php echo $grade['remarks'] ?></td>
                                <td><?php echo $mkk['tr'] ?></td>
                            </tr>
                    <?php }
                    } ?>


                    <tr class="rttbx">
                        <td class="text-center"> </td>
                        <td> TOTAL</td>
                        <td class="text-center"><?php echo $gd; ?></td>
                        <td>MEAN: &nbsp;&nbsp;&nbsp;<?php
                                                    $mn = number_format($gd / $ind, 1);
                                                    echo $mn;

                                                    $rmks = $this->cbc_exams_m->calculateGradeAndRemarks(round($mn));
                                                    echo ' (' . $rmks['grade'] . ')';
                                                    ?>
                        </td>
                        <td> <?php echo $rmks['remarks'] ?></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>

            <table class="lower" width="100%" style="border:none !important">
                <tr>
                    <td class="nob" width="60%">
                        <div>
                            <div class="foo"> </div>
                            <div class="foo">
                                <strong><span style="text-decoration:underline">Teacher's Remarks:</span></strong>
                                <br><span><?php echo isset($rw->report['remarks']) && $rw->report['remarks'] != '' ? $rw->report['remarks'] : '<hr style="border-top: 2px dotted black"/>'; ?> </span>
                            </div>
                            <strong><span style="text-decoration:underline">Additional Remarks:</span></strong>
                            <hr style="border-top: 2px dotted black" />
                        </div>
                    </td>
                    <td class="nob">
                        <div class="right">
                            <br>
                            <?php
                            if (!empty($grading)) { /*
                              ?>
                              <strong style="font-size:.8em"><?php echo $grading->title; ?> <br>
                              Pass Mark: <?php echo $grading->pass_mark; ?> </strong>
                              <?php */
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="center" style="border-top:1px solid #ccc">
                <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                    <?php
                    if (!empty($this->school->tel)) {
                        echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                    } else {
                        echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                    }
                    ?></span>
            </div>
        </div>
        <div class="page-break"></div>
    <?php
    endforeach;
    if (empty($payload)) {
    ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>No Results found kindly record results first !!
            </strong>
        </div>
    <?php } ?>
</div>
<div class="col-md-2"></div>
<style>
    .amt {
        text-align: right;
    }

    .fless {
        width: 100%;
        border: 0;
    }

    .slip {
        margin: 12px;
        padding: 14px;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .actions {
        background-color: #fff;
        padding: 8px
    }

    .lower {
        margin-top: 6px;
    }

    .lethead {
        border: 0;
        width: 96%;
    }

    .topdets {
        width: 100%;
        margin: 0 auto;
        border: 0;
    }

    .topdets th,
    .topdets td,
    .topdets {
        border: 0;
    }

    .toppa img {
        width: 150px;
        height: 80px;
    }

    .toppa {
        text-align: center;
        color: #66B0EA;
        padding-top: 0;
    }

    .toppa span.stitle {
        font-size: 30.5px;
        font-family: serif;
        font-weight: bold;
    }

    .redtop {
        color: #f00;
        font-size: 20px;
        text-decoration: underline;
    }

    .bltop {
        color: #0000ff;
        font-size: 20px;
    }

    .tocent {
        text-align: center;
    }

    .celll {
        margin: 0;
    }

    * {
        margin: 0;
        padding: 0;
        border: 0;
    }

    .slip {
        background-color: #fff;
    }

    .strong {
        font-weight: bold;
    }

    .right {
        text-align: right;
    }

    .rightb {
        text-align: right;
        border-bottom: 3px double #000;
    }

    .center {
        text-align: center;
    }

    .green {
        color: green;
    }

    table td,
    table th {
        padding: 4px;
        font-size: 12px;
    }

    .nob {
        border-right: 0 !important;
    }

    @media print {

        .page-break {
            page-break-before: always;
        }

        .page-break:last-child {
            page-break-before: avoid;
        }

        img {
            width: 80px !important;
            height: 80px !important;
        }

        .slip {
            width: 100%;
            padding: 0;
            margin: 0;
            border: initial;
        }

        .lethead img {
            width: 96%;
        }

        .lethead,
        .lethead td.toppa,
        .lethead th {
            border: 0;
        }

        td.toppa {
            border-right: none !important;
            border-bottom: none !important;
        }

        .toppa img {
            width: 150px;
            height: 80px;
        }

        body {
            background: #fff;
            font-family: OpenSans;
        }

        /**********/
        .ptable {
            border: 1px solid #DDD;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #ccc;
        }

        th {
            background-color: #ccc;
            text-align: center;
        }

        td.nob {
            border: none !important;
            background-color: #fff !important;
        }

        /**********/
        .navigation {
            display: none;
        }

        .alert {
            display: none;
        }

        .alert-success {
            display: none;
        }

        .img {
            align: center !important;
        }

        .print {
            display: none !important;
        }

        .bank {
            float: right;
        }

        .view-title h1 {
            border: none !important;
            text-align: center
        }

        .view-title h3 {
            border: none !important;
        }

        .split {
            float: left;
        }

        .right {
            float: right;
        }

        #scrollUp {
            display: none
        }

        .header {
            display: none
        }

        .center,
        .slip {
            width: 100%;
            margin: 15px !important;
            padding: 0px !important;
        }

        .smf .content {
            margin-left: 0px;
        }

        .table {
            width: 92%;
            margin: 15px auto;
        }
    }

    .table {
        width: 92%;
        margin: 15px auto;
    }

    table.table-bordered th:last-child,
    table.table-bordered td:last-child {
        border-right-width: 1px;
    }
</style>