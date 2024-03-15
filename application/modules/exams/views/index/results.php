<div class="row " id="x-acts">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h6>Filter to View Exam Results</h6>
        <?php echo form_open(current_url()); ?>
        Student:
        <?php echo form_dropdown('student', array('' => 'Select Student') + $kids, $this->input->post('student'), 'class="tsel"'); ?>
        Exam:
        <?php echo form_dropdown('exam', array('' => '') + $exams, $this->input->post('exam'), 'class="tsel"'); ?>
        &nbsp;
        <button type="submit" class="btn btn-custom">Submit</button>
        <?php
        if (!empty($report))
        {
                ?>
                <button onClick="window.print();
                            return false" class="btn btn-custom" type="button" style="margin-left:5%;"> Print </button>
                        <?php
                }
                echo form_close();
                ?>
    </div><!-- End .col-md-12 -->
    <?php
    if (!$this->input->post('exam'))
    {
            ?>
            <h1 class="title">   &nbsp;</h1>
            <h1 class="title">   &nbsp;</h1>
            <h1 class="title">   &nbsp;</h1>
    <?php } ?>
</div>
<?php
if (!$proc)
{
        if ($this->input->post('exam'))
        {
                ?>
                <h1 class="title">   &nbsp;</h1>
                <div class="alert alert-danger alert-dismissable col-md-8">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Error!</strong> Exams Results  Not Found.
                </div><?php
        }
}
else
{
        $settings = $this->ion_auth->settings();
        if (isset($report) && !empty($report))
        {
                ?>
                <div class="col-md-12 col-sm-12 col-xs-12 ">

                    <div class="clearfix"></div>
                    <div class="xlg-margin  xs-margin"></div>
                    <div class="span"> 
                        <img  src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="left" align="left" style="margin-right:10px;" width="80" height="80" />
                    </div>
                    <div>
                        <b>Student: </b>
                        <span ><?php echo ucwords($student->first_name . ' ' . $student->last_name); ?> </span>
                        <span class="right">
                            <b>Reg. No. : </b>
                            <span><?php echo (!empty($student->old_adm_no)) ? $student->old_adm_no : $student->admission_number; ?>
                            </span>
                        </span>	
                        <br>
                        <b>Class : </b>
                        <span><?php
                            $crr = isset($this->classes[$cls->class]) ? $this->classes[$cls->class] : '';
                            $ctr = isset($streams[$cls->stream]) ? $streams[$cls->stream] : '';
                            echo $crr . ' ' . $ctr;
                            ?></span>
                        <br>
                        <b>Exam : </b>
                        <span><?php echo $exam->title . ' Term ' . $exam->term . ' ' . $exam->year; ?></span>
                    </div>

                    <div class="table-responsive col-md-9 col-sm-9 col-xs-9">
                        <div class=" xs-margin"></div>
                        <table class="tadble checkofut-table display"  >
                            <thead>
                                <tr>
                                    <th width='3%'>#</th>
                                    <th>SUBJECT</th>
                                    <th colspan="2">MARKS</th>
                                    <th>  </th>
                                </tr>
                            </thead>
                            <tbody  id="sort_1">
                                <?php
                                $i = 0;
                                $total = 0;
                                if ($report && isset($report['marks']))
                                {
                                        $mks = $report['marks'];

                                        foreach ($mks as $ps):
                                                $p = (object) $ps;
                                                $total += $p->marks;
                                                $i++;
                                                if (isset($p->units))
                                                {
                                                        foreach ($p->units as $key => $value)
                                                        {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i . '.'; ?></td>
                                                                    <td  ><?php echo isset($s_units[$key]) ? $s_units[$key] : ''; ?> </td>
                                                                    <td class="right"><?php echo $value; ?></td>
                                                                    <td> </td>
                                                                    <td> </td>
                                                                </tr>    
                                                                <?php
                                                                $i++;
                                                        }
                                                }
                                                ?>

                                                <tr class="new">
                                                    <td><?php echo $i . '.'; ?></td>
                                                    <td colspan="2"> 
                                                        <?php
                                                        echo isset($subjects[$p->subject]) ? $subjects[$p->subject] : '';
                                                        echo isset($p->units) ? ' TOTAL' : '';
                                                        ?>
                                                    </td>
                                                    <td class="right"><span class="strong" ><?php echo $p->marks; ?></span></td>
                                                    <td> </td>
                                                </tr>
                                                <?php
                                        endforeach;
                                }
                                ?>        
                                <tr class="new">
                                    <td> </td>
                                    <td> </td>
                                    <td class="rightb">  <strong>Total:</strong></td>
                                    <td class="rightb"><strong><?php echo $total; ?></strong></td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="lower" width="100%" border="0"  >
                            <tr><td class="nob" width="60%">
                                    <div> 
                                        <br> <?php
                                        if (!empty($grading))
                                        {
                                                $pass_mark = $grading->pass_mark;
                                                $rem = $pass_mark - $total;
                                                if ($total > $pass_mark)
                                                {
                                                        //echo '<span class="green">PASS: Proceed to next level</span>';
                                                }
                                                else
                                                {
                                                        // echo '<span style="color:red">Failed by ' . $rem . ' Marks </span>';
                                                }
                                        }
                                        ?>  
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <div class="center" style="border-top:1px solid #ccc">		
                            <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                                <?php
                                if (!empty($settings->tel))
                                {
                                        echo $settings->postal_addr . ' Tel:' . $settings->tel . ' ' . $settings->cell;
                                }
                                else
                                {
                                        echo $settings->postal_addr . ' Cell:' . $settings->cell;
                                }
                                ?></span>
                        </div>

                    </div>
                </div>
                <?php
        }
        elseif (isset($remarks))
        {
                ?>
                <div >
                    <div class="row">
                        <div class="col-md-2 hidden-xs">&nbsp;</div>
                        <div class="col-md-8 inner-doc">
                            <div class="clearfix">
                            </div>
                            <div class="block-fluid slip">
                                <div id="invoice-top">                                   
                                    <div class="xlcg-margin  xssss-margin"></div>
                                    <div class="span"> 
                                        <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="left" align="left" style="margin-right:10px;" width="100" height="100" />
                                    </div>
                                    <div class="titles">
                                        <h3><?php echo strtoupper($this->school->school); ?></h3>
                                        <p><?php echo $this->school->postal_addr; ?><br>
                                            Tel: <?php echo $this->school->tel; ?> <?php echo $this->school->cell; ?>
                                        </p>
                                        <hr>
                                    </div><!--End Title-->
                                </div>
                                <div class="clearfix"></div>
                                <div class="row">        
                                    <table class="topdets">
                                        <tr>
                                            <td><strong>Name : </strong>
                                                <abbr><?php echo $student->first_name . ' ' . $student->last_name; ?> </abbr>
                                            </td>
                                            <td><strong>Exam : </strong> <abbr><?php echo strtoupper($exam->title); ?></abbr>
                                            </td>
                                            <td><strong>Term : </strong> <abbr><?php echo $exam->term; ?></abbr> <strong> Year : </strong> <abbr><?php echo $exam->year; ?></abbr></td>
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
                                                <abbr><?php echo $student->cl->name; ?></abbr>
                                            </td>
                                            <td>
                                                <strong>Age : </strong> 
                                                <abbr>
                                                    <?php echo (!empty($student->dob) && $student->dob > 10000) ? $this->dates->createFromTimeStamp($student->dob)->diffInYears() : '-'; ?>
                                                </abbr>
                                            </td> 
                                            <td></td>
                                            <td><strong>Class Teacher : </strong>
                                                <abbr><?php
                                                    $cc = '';
                                                    if (!empty($student->cl->class_teacher))
                                                    {
                                                            $ctc = $this->ion_auth->get_user($student->cl->class_teacher);
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
                                    <hr>
                                </div>
                                <div class="col-md-9">
                                    <h4 align="center"> REPORT FORM </h4> 
                                </div>
                                <?php
                                $frm = array();
                                $frmw = array();
                                foreach ($remarks as $rm)
                                {
                                        if ($rm->sub_id == 9999)
                                        {
                                                $frmw[$rm->parent] = $rm->remarks;
                                        }
                                        else
                                        {
                                                $frm[$rm->parent][$rm->sub_id] = $rm->remarks;
                                        }
                                }
                                $attributes = array('class' => 'form-horizontal', 'id' => '');
                                echo form_open_multipart(current_url(), $attributes);
                                ?>

                                <?php
                                if (count($subjects) < 1)
                                {
                                        ?>
                                        <div class="col-md-6">
                                            <div class="alert alert-block">                
                                                <strong>Error!</strong> You Must Add All Subjects First Before Recording Exam Marks 
                                                <br><br>Add Subjects <?php echo anchor('admin/subjects', 'Here'); ?>
                                            </div>
                                        </div>
                                        <?php
                                }
                                else
                                {
                                        ?>
                                        <table class="table table-striped table-bordered" width="100%">
                                            <tr> 
                                                <th colspan="2" width="30%"><strong>SUBJECTS</strong></th>
                                                <th colspan="2" width="70%">
                                                    <strong>CLASS TEACHER'S REMARKS</strong></th>
                                            </tr>
                                            <?php
                                            foreach ($subjects as $key => $post):
                                                    $pp = (object) $post;
                                                    if ($pp->opt == 3)
                                                    {
                                                            continue;
                                                    }
                                                    ?>
                                                    <tr> 
                                                        <?php
                                                        if (isset($subtests[$key]))
                                                        {
                                                                $tts = $subtests[$key];
                                                                ?>
                                                                <td rowspan="<?php echo count($tts); ?>"> <?php echo $full_subjects[$key]; ?>  </td>
                                                                <?php
                                                                foreach ($tts as $tid => $ttl)
                                                                {
                                                                        $nm = 'rmk_' . $key . '_' . $tid;
                                                                        $srmk = isset($frm[$key]) && isset($frm[$key][$tid]) ? $frm[$key][$tid] : '';
                                                                        ?>
                                                                        <td><?php echo $ttl; ?></td><td colspan="2" class="bglite"><span class="editable remarks" id="<?php echo $nm; ?>" ><?php echo $srmk; ?></span></td> </tr>
                                                                    <?php
                                                            }
                                                    }
                                                    else
                                                    {
                                                            $nm = 'rmk_' . $key;
                                                            $mrmk = isset($frmw[$key]) ? $frmw[$key] : ' ';
                                                            ?>
                                                            <td colspan="2"> <?php echo $full_subjects[$key]; ?> </td>
                                                            <td colspan="2" class="bglite"><span  class="editable remarks" id="<?php echo $nm; ?>"><?php echo $mrmk; ?></span></td>
                                                            </tr>
                                                    <?php } ?>
                                            <?php endforeach; ?>
                                            <tr> 
                                                <td colspan="2"><strong>GENERAL REMARKS</strong></td>
                                                <td colspan="2"> <?php echo empty($full) ? '' : $full->remarks; ?></td>
                                            </tr>
                                        </table>
                                        <div class='form-group'>
                                            <div class="col-md-3 genn"> </div>
                                            <div class="col-md-9">

                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <div class="col-md-10">
                                            </div>
                                        </div>
                                <?php } ?> 
                                <?php echo form_close(); ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
        }
        else
        {
                ?>
                <h1 class="title">   &nbsp;</h1>
                <div class="alert alert-danger alert-dismissable col-md-8">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <strong>Error!</strong> Exams Results for Selected Student not Found.
                </div>
                <?php
        }
}
?>
<script>
        $(document).ready(function ()
        {
            $(".tsel").select2({'placeholder': 'Please Select', 'width': '270px'});

        });
</script>
<style>
    .inner-doc{padding: 40px; background: white; box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);}
    .titles{margin-left: 30%;}
    * { margin: 0; padding: 0; border: 0; }
    .info img{
        width:150px;
        height:80px;
    }
    .strong{font-weight: bold;}
    .right{text-align: right;}
    .rightb{text-align: right; border-bottom: 3px double #000 !important;}
    .center{text-align: center;}
    .green{color: green;}
    table td, table th {
        padding: 8px !important; font-size: 12px;
    }  .nob{border-right:0 !important;}
    @media print{
        body{background: #fff;font-family: OpenSans;}
        .topdets{width: 100%; border: 0 !important;}
        .topdets td{  border: 0 !important;}
        /**********/
        .ptable{ border: 1px solid #DDD;
                 border-collapse: collapse; }
        td, th {
            border: 1px solid #ccc;
        }
        th {
            background-color:  #ccc;
            border-color: #FFF;
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

        .right{
            float:right;
        }
        .header{display:none}

    }
    hr {
        margin-top: 1px;
        margin-bottom: 1px;
    }
</style>   
