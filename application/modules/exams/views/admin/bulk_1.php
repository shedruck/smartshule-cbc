<div class="row actions">
    <h3>Generate Per Class Or Per Student</h3>
    <?php echo form_open(current_url()); ?>
    <div class="form-group">
        <div class="col-md-2"><span class="help-block">&nbsp;</span>&nbsp;</div>
        <div class="col-md-5">
            <span class="help-block">Select Class</span>
            <?php echo form_dropdown('class', array('' => 'Select Class') + $this->streams, $this->input->post('class'), 'class="select"') ?> 
            &nbsp; &nbsp; &nbsp; or  
        </div>                    
        <div class="col-md-5">
            <span class="help-block">Select Student</span>
            <select name="student" class="select">
                <option value="">Select Student</option>
                <?php
                $data = $this->ion_auth->students_full_details();
                foreach ($data as $key => $value):
                        ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php endforeach; ?>
            </select> 
        </div>                    
    </div>
    <div class="form-group">
        <div class="col-md-2"><span class="help-block">&nbsp;</span> </div>
        <div class="col-md-2"><span class="help-block">&nbsp;</span> Show Positions <input type="checkbox" checked="checked" name="pos" value="1"/></div>
        <div class="col-md-3"><span class="help-block">Ranking</span>
            <?php
            $ranks = array('' => 'Select', 1 => 'Total Marks', 2 => 'Mean Marks');
            echo form_dropdown('sort', $ranks, $this->input->post('sort'), 'class="fsel"');
            ?>
        </div>
        <div class="col-md-4 col-md-offset-1">
            <span class="help-block">&nbsp;</span>
            <button class="btn btn-warning"  style="height:30px;" type="submit">View Report Forms</button>
            <a href="" onClick="window.print();
                        return false" class="btn btn-primary"><i class="icos-printer"></i> Print
            </a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<div class="widget">
    <?php
    $haspos = $this->input->post('pos');
    $this->load->library('Dates');
    $pref = '';
    if ($flag)
    {//multiple
            $j = 0;
            $student_id = 0;

            foreach ($payload as $row):
                    $j++;
                    $rw = (object) $row;
                    $student_id = $rw->student->id;
                    ?>
                    <div class="slip">
                        <div class="row center">
                            <table class="lethead" style="border:none !important">
                                <?php
                                $file = FCPATH . '/uploads/report.png';
                                if (file_exists($file))
                                {
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <img src="<?php echo base_url('uploads/report.png'); ?>" class="left" alt="logo"/>
                                                <p class="redtop">REPORT FORM</p>
                                            </td>
                                        </tr>
                                        <?php
                                }
                                else
                                {
                                        ?>
                                        <tr width="100%">
                                            <td class="toppa">
                                                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  alt="img" width="100" height="80" />
                                                <div style="clear: right"></div> 
                                            </td>
                                            <td class="toppa">
                                                <span class="stitle"><?php echo strtoupper($this->school->school); ?></span>
                                                <p class="redtop stitle">REPORT FORM</p>
                                            </td>
                                        </tr>
                                <?php } ?>                            
                            </table>
                        </div>
                        <hr>
                        <div class="row">
                            <table class="topdets">
                                <tr>
                                    <td><strong>Name : </strong>
                                        <abbr><?php echo $rw->student->first_name . ' ' . $rw->student->last_name; ?> </abbr>
                                    </td>
                                    <td><strong>Term : </strong> <abbr><?php echo $exam->term; ?></abbr></td>
                                    <td><strong>Year : </strong> <abbr><?php echo $exam->year; ?></abbr></td>
                                    <td><strong>ADM No : </strong>
                                        <abbr><?php
                                            echo (!empty($rw->student->old_adm_no)) ? $rw->student->old_adm_no : $rw->student->admission_number;
                                            ?>
                                        </abbr>
                                        <span class="hidden">&nbsp;&nbsp;&nbsp; <strong>KCPE MARKS:  </strong><?php echo $rw->student->entry_marks; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Class : </strong>
                                        <abbr><?php
                                            $crr = isset($this->classes[$rw->cls->class]) ? $this->classes[$rw->cls->class] : '';
                                            $ctr = isset($streams[$rw->cls->stream]) ? $streams[$rw->cls->stream] : '';
                                            echo $crr . ' ' . $ctr;
                                            ?>
                                        </abbr>
                                    </td>
                                    <td>
                                        <strong>Age : </strong> 
                                        <abbr>
                                            <?php echo (!empty($rw->student->dob) && $rw->student->dob > 10000) ? $this->dates->createFromTimeStamp($rw->student->dob)->diffInYears() : '-'; ?>
                                        </abbr>
                                    </td>
                                    <td><strong>Exam : </strong> <abbr><?php echo $exam->title; ?></abbr></td>
                                    <td> <strong>Class Teacher : </strong>
                                        <abbr><?php
                                            $cc = '';
                                            if (!empty($rw->cls->class_teacher))
                                            {
                                                    $ctc = $this->ion_auth->get_user($rw->cls->class_teacher);
                                                    if ($ctc)
                                                    {
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Subject</th>
                                    <th width="20%">Marks</th>
                                    <th width="20%">Grade</th>
                                    <th colspan="2">Remarks.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $gd = 0;
                                $grading_to_use=0;
                                foreach ($rw->marks as $spms)
                                {
                                        $sp = (object) $spms;

                                        $i++;
                                        if (isset($subjects[$sp->subject]))
                                        {
                                                $stb = $subjects[$sp->subject];
                                        }
                                        else
                                        {
                                                $stitle = isset($full[$sp->subject]) ? $full[$sp->subject] : '-';
                                                $stb = array('full' => $stitle, 'opt' => $sp->opt, 'title' => $stitle);
                                        }
                                        $bs = (object) $stb;
                                        $gd += $sp->opt == 1 ? 0 : $sp->marks;
                                        $rmks = $this->ion_auth->remarks($sp->grading, $sp->marks);
                                        if (isset($sp->units) && !empty($sp->units))
                                        {
                                                foreach ($sp->units as $uxid => $uxres)
                                                {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"></td>
                                                            <td><i><?php echo isset($bs->units[$uxid]) ? $bs->units[$uxid] : '-'; ?></i></td>
                                                            <td><small><?php echo $uxres; ?></small></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="strong"><?php echo $bs->full; ?> TOTAL</td>
                                                    <td class="text-center"><?php echo $sp->marks; ?></td>
                                                    <td class="text-center"><?php echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : ''; ?></td>
                                                    <td colspan="2">
                                                        <?php echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : ''; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                        }
                                        else
                                        {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td><?php echo $bs->full; ?></td>
                                                    <td class="text-center"><?php echo $sp->marks; ?></td>
                                                    <td class="text-center"><?php echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : ''; ?></td>
                                                    <td colspan="2">
                                                        <?php
                                                        echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                        }
                                        $grading_to_use = $sp->grading;
                                }
                                ?>
                                <tr class="rttbx">
                                    <td class="text-center"> </td>
                                    <td> TOTAL</td>
                                    <td class="text-center"><?php echo $gd; ?></td>  
                                    <td>MEAN: &nbsp;&nbsp;&nbsp;<?php
                                        $mn = number_format($gd / $i, 1);
                                        echo $mn;
                                        $trmks = $this->ion_auth->remarks($grading_to_use, $mn);
                                        ?>
                                        &nbsp;(<?php
                                        echo isset($trmks->grade) && isset($grade_title[$trmks->grade]) ? $grade_title[$trmks->grade] : '';
                                        ?>)</td>
                                    <td> </td>
                                </tr>
                                <?php
                                if ($haspos)
                                {
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td class="rttb"> <strong>POSITION:</strong></td>
                                            <td class="bltop"> <strong><?php echo $j; ?></strong>  </td>
                                            <td class="rttb"> <strong>Out of:</strong></td>
                                            <td class="bltop"> <?php echo count($payload); ?></td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <table class="lower" width="100%" style="border:none !important">
                            <tr><td class="nob" width="60%">
                                    <div>						 
                                        <div class="foo"> </div>
                                        <div class="foo">
                                            <strong><span style="text-decoration:underline">Teacher's Remarks:</span></strong>
                                            <br><span><?php echo isset($rw->report['remarks']) && $rw->report['remarks'] != '' ? $rw->report['remarks'] : '<hr style="border-top: 2px dotted black"/>'; ?> </span>
                                        </div>
                                        <strong><span style="text-decoration:underline">Additional Remarks:</span></strong>
                                        <hr style="border-top: 2px dotted black"/>
                                    </div>
                                </td>
                                <td class="nob">
                                    <div class="right">  
                                        <br>
                                        <?php
                                        if (!empty($grading))
                                        { /*
                                          ?>
                                          <strong style="font-size:.8em"><?php echo $grading->title; ?> <br>
                                          Pass Mark: <?php echo $grading->pass_mark; ?> </strong>
                                          <?php */
                                        }
                                        ?></div>
                                </td>
                            </tr>
                        </table>
                        <div class="center" style="border-top:1px solid #ccc">		
                            <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                                <?php
                                if (!empty($this->school->tel))
                                {
                                        echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                }
                                else
                                {
                                        echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                }
                                ?></span>
                        </div>
                    </div>
                    <div class="page-break"></div>
                    <?php
            endforeach;
    }
    else
    {      //single
            if (isset($report) && !empty($report))
            {
                    ?>
                    <div class="slip ">
                        <div class="row center"> 
                            <table class="lethead" >
                                <?php
                                $file = FCPATH . '/uploads/report.png';
                                if (file_exists($file))
                                {
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <img src="<?php echo base_url('uploads/report.png'); ?>" class="left"  alt="img"/>
                                                <p class="redtop">REPORT FORM</p>
                                            </td>
                                        </tr>
                                        <?php
                                }
                                else
                                {
                                        ?>
                                        <tr width="100%">
                                            <td class="toppa">
                                                <span class="stitle"><?php echo strtoupper($this->school->school); ?></span>
                                            </td>
                                            <td class="toppa">
                                                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="80"  alt="img"/>
                                                <div style="clear: right"> </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tocent" >
                                                <span class="centre"><?php echo nl2br($this->school->postal_addr); ?></span>
                                                <p class="celll"><?php echo $this->school->cell; ?></p>
                                                <p class="redtop">REPORT FORM</p>
                                            </td>
                                        </tr>
                                <?php } ?>                            
                            </table>
                        </div>
                        <div class="row">
                            <table class="topdets">
                                <tr>
                                    <td><strong>Name : </strong>
                                        <abbr><?php echo $student->first_name . ' ' . $student->last_name; ?> </abbr>
                                    </td>
                                    <td> <strong>Term : </strong> <abbr><?php echo $exam->term; ?></abbr>
                                    </td>
                                    <td><strong>Year : </strong> <abbr><?php echo $exam->year; ?></abbr> 
                                    </td>
                                    <td><strong>ADM No : </strong>
                                        <abbr><?php
                                            echo (!empty($student->old_adm_no)) ? $student->old_adm_no : $student->admission_number;
                                            ?>
                                        </abbr>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Class : </strong>
                                        <abbr><?php
                                            $crr = isset($this->classes[$cls->class]) ? $this->classes[$cls->class] : '';
                                            $ctr = isset($streams[$cls->stream]) ? $streams[$cls->stream] : '';
                                            echo $crr . ' ' . $ctr;
                                            ?>
                                        </abbr>
                                    </td>
                                    <td>
                                        <strong>Age : </strong> <abbr>
                                            <?php
                                            $this->load->library('Dates');
                                            echo (!empty($student->dob) && $student->dob > 10000) ? $this->dates->createFromTimeStamp($student->dob)->diffInYears() : '-';
                                            ?></abbr>
                                    </td>
                                    <td><strong>Exam : </strong> <abbr><?php echo $exam->title; ?></abbr> 
                                    </td>
                                    <td> <strong>Class Teacher : </strong>
                                        <abbr><?php
                                            $cc = '';
                                            if (!empty($cls->class_teacher))
                                            {
                                                    $ctc = $this->ion_auth->get_user($cls->class_teacher);
                                                    if ($ctc)
                                                    {
                                                            $cc = $ctc->first_name . ' ' . $ctc->last_name;
                                                    }
                                            }
                                            echo $cc;
                                            ?></abbr>
                                    </td>
                                </tr> 
                            </table>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Subject</th>
                                    <th width="20%">Marks</th>
                                    <th colspan="2">Remarks.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $gd = 0;
                                $mks = $report['marks'];
                                foreach ($mks as $spms)
                                {
                                        $sp = (object) $spms;
                                        $i++;

                                        if (isset($subjects[$sp->subject]))
                                        {
                                                $stb = $subjects[$sp->subject];
                                        }
                                        else
                                        {
                                                $stitle = isset($full[$p->subject]) ? $full[$p->subject] : '-';
                                                $stb = array('full' => $stitle, 'opt' => $sp->opt, 'title' => $stitle);
                                        }
                                        $bs = (object) $stb;
                                        $gd += $sp->opt == 1 ? 0 : $sp->marks;
                                        if (isset($sp->units) && !empty($sp->units))
                                        {
                                                foreach ($sp->units as $uxid => $uxres)
                                                {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"></td>
                                                            <td><i><?php echo isset($bs->units[$uxid]) ? $bs->units[$uxid] : ''; ?></i></td>
                                                            <td><small><?php echo $uxres; ?></small></td>
                                                            <td> </td>
                                                            <td> </td>
                                                        </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="strong"><?php echo $bs->full; ?> TOTAL</td>
                                                    <td class="text-right"><?php echo $sp->marks; ?></td>
                                                    <td colspan="2">
                                                        <?php
                                                        $rmks = $this->ion_auth->remarks($exam->grading, $sp->marks);
                                                        echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                        }
                                        else
                                        {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td><?php echo $bs->full; ?></td>
                                                    <td class="text-right"><?php echo $sp->marks; ?></td>
                                                    <td colspan="2">
                                                        <?php
                                                        $rmks = $this->ion_auth->remarks($exam->grading, $sp->marks);
                                                        echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                        }
                                }
                                ?>
                                <tr class="rttbx">
                                    <td class="text-center"> </td>
                                    <td> </td>
                                    <td class="text-right"><?php echo $gd; ?></td>  
                                    <td colspan="2"> </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="lower nonborder" width="100%" style="border:none !important"  >
                            <tr><td class="nob" width="60%">
                                    <div>						 
                                        <div class="foo"> </div>
                                        <div class="foo">
                                            <strong><span style="text-decoration:underline">Teacher's Remarks:</span></strong>
                                            <br><?php echo isset($report['remarks']) && $report['remarks'] != '' ? $report['remarks'] : '<hr style="border-top: 2px dotted black"/>'; ?>
                                        </div>
                                        <strong><span style="text-decoration:underline">Additional Remarks:</span></strong>
                                        <hr style="border-top: 2px dotted black"/>
                                    </div>
                                </td>
                                <td class="nob">
                                    <div class="right">  
                                        <br>
                                        <?php
                                        if (!empty($grading))
                                        {/*
                                          ?>
                                          <strong style="font-size:.8em"><?php echo $grading->title; ?> <br>
                                          Pass Mark: <?php echo $grading->pass_mark; ?> </strong>
                                          <?php */
                                        }
                                        ?> </div>
                                </td></tr>
                        </table>
                        <div class="center" style="border-top:1px solid #ccc">		
                            <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                                <?php
                                if (!empty($this->school->tel))
                                {
                                        echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                }
                                else
                                {
                                        echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                }
                                ?></span>
                        </div>

                    </div>
                    <?php
            }
            else
            {
                    ?>

                    <?php
            }
    }
    ?>
</div>
<style>
    .amt{text-align: right;}
    .fless{width:100%; border:0;}
    .slip {margin: 12px;
           padding: 14px;
           border-radius: 5px;
           background: white;
           box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .actions{background-color: #fff; padding: 8px}
    .lower{margin-top: 6px;}
    .lethead
    {
        border: 0;
    }
    .topdets {
        width:100%;
        margin: 0 auto;
        border: 0;
    }
    .topdets th,  .topdets td ,.topdets 
    {
        border: 0;
    }

    .toppa img{
        width:150px;
        height:80px;
    }

    .toppa{
        text-align: right;
        color: #66B0EA;
        padding-top: 0;
    }
    .toppa span.stitle{font-size: 30.5px; font-family:  serif; font-weight: bold;}
    .redtop{color: #f00;
            font-size: 20px;
            text-decoration: underline;}
    .bltop{color: #0000ff; font-size: 20px;}
    .tocent{text-align: center;}
    .celll{margin: 0;}
    * { margin: 0; padding: 0; border: 0; }
    .slip{ background-color: #fff; }
    .strong{font-weight: bold;}
    .right{text-align: right;}
    .rightb{text-align: right; border-bottom: 3px double #000;}
    .center{text-align: center;}
    .green{color: green;}
    table td, table th {
        padding: 4px; font-size: 12px;
    }  .nob{border-right:0 !important;}

    @media print{
        .page-break{page-break-before: always; }
        .page-break:last-child {
            page-break-before: avoid;
        }
        .slip{
            width:100%;
            padding: 0;
            margin: 0;
            border: initial;
        }
        .lethead img {width: 96%;}
        .lethead,    .lethead td.toppa ,    .lethead th
        {
            border: 0;
        }
        td.toppa 
        {
            border-right: none !important;
            border-bottom: none !important;
        }
        .toppa img{
            width:150px;
            height:80px;
        }
        body{background: #fff;font-family: OpenSans;}

        /**********/
        .ptable{ border: 1px solid #DDD;
                 border-collapse: collapse; }
        td, th {
            border: 1px solid #ccc;
        }
        th {
            background-color:  #ccc;
            text-align: center;
        }
        td.nob{  border:none !important; background-color:#fff !important;}
        /**********/
        .navigation{
            display:none;
        }
        .alert{
            display:none;
        }
        .alert-success{
            display:none;
        } 
        .img{
            align:center !important;
        } 
        .print{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; text-align:center }
        .view-title h3{border:none !important; }

        .split{
            float:left;
        }
        .right{
            float:right;
        }
        #scrollUp{display:none}
        .header{display:none}
        .center, .slip {
            width:100%;
            margin: 15px !important;
            padding: 0px !important;
        }

        .smf .content {
            margin-left: 0px;
        }
        .table{width: 92%; margin: 15px auto;}
    } .table{width: 92%; margin: 15px auto;}
</style>