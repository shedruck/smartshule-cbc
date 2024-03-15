


<div class="row1 " id="x-acts">
			<div class="card shadow-sm ctm-border-radius grow">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h4 class="card-title mb-0 d-inline-block">Exam Results
				<hr>
				
				<a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				 <a onClick="window.print();
                            return false" class="btn btn-primary btn-sm pull-right" type="button" style="margin-left:5%;"><i class="fa fa-print"></i> Print Report</a>
						
				</h4>
				


				
			
			</div>
		
		

    <div class="col-md-12">
    <div class="col-md-1"></div>
    <div class="col-md-9 card-box">

<?php
if (!$proc)
{
        if ($this->input->post('exam'))
        {
                ?>
                <h1 class="title">   &nbsp;</h1>
                <div class="alert alert-danger alert-dismissable ">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Error!</b> Exams Results  Not Found.
                </div><?php
        }
}
else
{
        $settings = $this->ion_auth->settings();
        if (isset($report) && !empty($report))
        {
                ?>
              
                    			   <div class="block-fluid">
				   


<div class="widget">
    <?php
    $haspos = $this->input->post('pos');
    $this->load->library('Dates');
    $pref = '';
      //single
            if (isset($report) && !empty($report))
            {
                    ?>
                    <div class="slip ">
                        
        <div class="row">
                  <?php $result = $this->ion_auth->settings();?>
                <div class="col-md-12 text-center">
                  <img src="<?php echo base_url('uploads/files/' . $result->document); ?>" width="80" height="80">

                    <h4><?php echo $result->school;?></h4>
                    <h6><?php echo $result->postal_addr;?></h6>
                    <h6>Tel: <?php echo $result->tel;?> <?php echo $result->cell;?>&nbsp; &nbsp;&nbsp;&nbsp; Email: <?php echo $result->email;?></h6>
                    <br>
                    <h4><b><u> PERFORMANCE REPORT  </u></b></h4>
                    <br>
					
			
                </div>
           </div>
          <div class="row">
                       <div class="col-sm-12 center">
					   
                             <table class="table table-bordered">
                                <tr>
                                    <td><b>NAME : </b>
                                        <abbr><?php echo strtoupper($student->first_name . ' ' . $student->last_name); ?> </abbr>
                                    </td>
                                    <td> <b>TERM : </b> <abbr><?php echo strtoupper($exam->term); ?></abbr>
                                    </td>
                                    <td><b>YEAR : </b> <abbr><?php echo strtoupper($exam->year); ?></abbr> 
                                    </td>
                                    <td><b>ADM NO : </b>
                                        <abbr><?php
                                            echo (!empty($student->old_adm_no)) ? strtoupper($student->old_adm_no) : strtoupper($student->admission_number);
                                            ?>
                                        </abbr>
                                    </td>
                                    <td rowspan="2">
									
									 <div class="pull-right">
                                <?php
                                if (!empty($student->photo)):
                                        $passport = $this->ion_auth->passport($student->photo);
                                        if ($passport)
                                        {
                                                ?> 
                                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                                        <?php } ?>	

                                <?php else: ?>   
                                        <?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                                <?php endif; ?>
                            </div>	
                                    </td>
									
                                </tr>
                                <tr>
                                    <td>
                                        <b>LEVEL: </b>
                                        <abbr><?php
                                            $crr = isset($this->classes[$cls->class]) ? $this->classes[$cls->class] : '';
                                            $ctr = isset($streams[$cls->stream]) ? $streams[$cls->stream] : '';
                                            echo strtoupper($crr . ' ' . $ctr);
                                            ?>
                                        </abbr>
                                    </td>
                                    <td>
                                        <b>AGE: </b> <abbr>
                                            <?php
                                            $this->load->library('Dates');
                                            echo (!empty($student->dob) && $student->dob > 10000) ? $this->dates->createFromTimeStamp($student->dob)->diffInYears() : '-';
                                            ?></abbr>
                                    </td>
                                    <td><b>EXAM: </b> <abbr><?php echo strtoupper($exam->title); ?></abbr> 
                                    </td>
                                    <td> <b>CLASS TEACHER <br> </b>
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
                                            echo strtoupper($cc);
                                            ?></abbr>
                                    </td>
                                </tr> 
                            </table>
                        </div>
                  </div>
				  
				  
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-bordered text-center" style="background:#DFEBF5; text-transform:uppercase;">
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
                                $mks = $report['marks'];
								$sbjs = $this->ion_auth->populate('subjects','id','name');
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
                                                $stitle = isset($sbjs[$sp->subject]) ? $sbjs[$sp->subject] : '-';
                                                $stb = array('full' => $stitle, 'opt' => $sp->opt, 'title' => $stitle);
                                        }
                                        $bs = (object) $stb;
                                        $gd += $sp->opt == 1 ? 0 : $sp->marks;
                                        if (isset($sp->units) && !empty($sp->units))
                                        {
                                                foreach ($sp->units as $uxid => $uxres)
                                                {
                                                        ?>
                                                        <tr style="display:none" class="text-center">
                                                            <td class="text-center"></td>
                                                            <td class="text-center"><i><?php echo isset($bs->units[$uxid]) ? $bs->units[$uxid] : ''; ?></i></td>
                                                            <td><small><?php echo $uxres; ?></small></td>
                                                            <td> </td>
                                                            <td> </td>
                                                        </tr>
                                                <?php } ?>
                                                <tr class="text-center">
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="b text-center"><?php echo $bs->full; ?> </td>
                                                    <td class="text-center b "><?php echo $sp->marks; ?></td>
                                                    <td class="text-center">
                                                        <?php

                                                        $rmks = $this->ion_auth->remarks($exam->grading, $sp->marks);
														
                                                        echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                                        ?>
                                                    </td>
													<td colspan="2" class="text-center">
                                                        <?php
															
                                                           echo isset($rmks->grade) && isset($grades[$rmks->grade]) ? $grades[$rmks->grade] : '';
                                                        ?>
                                                    </td >
                                                </tr>
                                                <?php
                                        }
                                        else
                                        {
                                                ?>
                                                <tr style="text-center">
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="b text-center"><?php echo $bs->full; ?></td>
                                                    <td class="b text-center"><?php echo $sp->marks; ?></td>
                                                    <td class="text-center">
                                                        <?php
														
                                                        $rmks = $this->ion_auth->remarks($exam->grading, $sp->marks);
														//print_r($rmks);
                                                        echo isset($rmks->grade) && isset($grade_title[$rmks->grade]) ? $grade_title[$rmks->grade] : '';
                                                        ?>
                                                    </td>
													<td colspan="2" class="text-center">
                                                        <?php
														
                                                       
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
                                    <td class="b"> <span class="pull-right">TOTAL </span></td>
                                    <td class="text-right b"><?php echo $gd; ?></td>  
                                    <td colspan="2"> </td>
                                </tr>
                            </tbody>
                        </table>
                       <div>						 
                <div class="foo"> <br> </div>
                <div class="foo col-sm-12">
                    <b><span ><b style="text-decoration:underline">Next Term Commences on:</b> &nbsp;&nbsp; ___________________________ &nbsp;&nbsp; </span></b>

                    <span  ><b>&nbsp;&nbsp; Attendance Register:&nbsp;&nbsp; <b style="border-bottom:dotted"><?php echo $days_present?></b> &nbsp;&nbsp; Out of  &nbsp;&nbsp; <b style="border-bottom:dotted"><?php echo $days_present+$days_absent;?></b> &nbsp;&nbsp; Sessions</b></span>
                    <br>
                </div>

                <div class="foo col-sm-12">
                    <b><span style="text-decoration:underline">Student's Conduct:</span></b>
                    <br>
                    <span class="editable ht editable-wrap" e-style="width:100%"><br>
					-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </span>
                </div>
                <div class="foo col-sm-12">
                    <b><span style="text-decoration:underline">Class Teacher's Comment:</span></b>
                    <br>
                    <span class="editable ht editable-wrap" e-style="width:100%">
					<br>
                     -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </span>
                </div>
                <div class="foo col-sm-12">
                    <b><span style="text-decoration:underline" >Head Teacher's Comment:</span></b><br/>

                    <span class="editable ht editable-wrap" e-style="width:100%"><br>
					---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					
					<br>
                        <?php
                        $file = FCPATH . '/uploads/files/headteacher-signature.jpg';
                        if (file_exists($file))
                        {
                                ?>
								<?php echo '<img src="data:' . $type . ';base64,' . $gen . '" width="110" class = "pull-left" />'; ?>
                                <img class = "pull-right" src = "<?php echo base_url('uploads/files/headteacher-signature.jpg'); ?>" width = "200" height = "80" class = "img-polaroid" >
                        <?php } ?>
                    </span>



                </div>
            </div>
            <div class="clearfix" style="clear:both"></div>
            <div class="center" style="border-top:1px solid #ccc">		
                <span class="center" style="font-size:0.8em !important;text-align:center !important;">
                    This document was produced without any alteration. For any question please contact our office 
                    <?php
                    echo ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                    ?>
                </span>
            </div>
            <div class="margin"></div>    

                    </div>
                    <?php
            }
            else
            {
                    ?>

                    <?php
            }

    ?>
</div>
</div>
</div>

  <div class="col-md-1"></div>
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
                                            <td><b>Name : </b>
                                                <abbr><?php echo $student->first_name . ' ' . $student->last_name; ?> </abbr>
                                            </td>
                                            <td><b>Exam : </b> <abbr><?php echo strtoupper($exam->title); ?></abbr>
                                            </td>
                                            <td><b>Term : </b> <abbr><?php echo $exam->term; ?></abbr> <b> Year : </b> <abbr><?php echo $exam->year; ?></abbr></td>
                                            <td><b>ADM No : </b>
                                                <abbr><?php
                                                    echo (!empty($student->old_adm_no)) ? $student->old_adm_no : $student->admission_number;
                                                    ?>
                                                </abbr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Class : </b>
                                                <abbr><?php echo $student->cl->name; ?></abbr>
                                            </td>
                                            <td>
                                                <b>Age : </b> 
                                                <abbr>
                                                    <?php echo (!empty($student->dob) && $student->dob > 10000) ? $this->dates->createFromTimeStamp($student->dob)->diffInYears() : '-'; ?>
                                                </abbr>
                                            </td> 
                                            <td></td>
                                            <td><b>Class Teacher : </b>
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
                                        <div class="col-md-12">
                                            <div class="alert alert-danger alert-dismissable">                
                                                <b>Sorry !</b> Seems examination results  for the selected class and student has not been recorded
                                                
                                            </div>
                                        </div>
                                        <?php
                                }
                                else
                                {
                                        ?>
                                        <table class="table table-striped table-bordered" width="100%">
                                            <tr> 
                                                <th colspan="2" width="30%"><b>SUBJECTS</b></th>
                                                <th colspan="2" width="70%">
                                                    <b>CLASS TEACHER'S REMARKS</b></th>
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
                                                <td colspan="2"><b>GENERAL REMARKS</b></td>
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
                    <b>Sorry!</b> Exams Results for Selected Student not Found.
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
	.table-details{
		border:none !important;
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
    .b{font-weight: bold;}
    .right{text-align: right;}
    .rightb{text-align: right; border-bottom: 3px double #000;}
    .center{text-align: center;}
    .green{color: green;}
    table td, table th {
        padding: 4px; font-size: 15px;
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
		
		.card-header {
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








