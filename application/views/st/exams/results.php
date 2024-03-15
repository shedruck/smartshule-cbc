<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
				 <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-7">		
							 <h5 class="text-18-bold">  
							Learner Report
							 </h5>
								 
							</div>
                            <div class="col-md-5">
                                <div class="pull-right">
								 <a href="" onClick="window.print();return false" class="btn btn-primary">
							   <i class="icos-printer"></i> Print Report
								</a>
							  <a href="<?php echo base_url('admin#academics'); ?>" class="btn btn-danger"><i class="fa fa-caret-left">
							  </i> Exit</a>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
			<hr>      
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
                  <img src="<?php echo base_url('uploads/files/' . $result->document); ?>" width="100" height="100">

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
					   
                             <table class="table table-details">
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
                                        <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                                <?php endif; ?>
                            </div>	
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
                                                        <tr style="display:none">
                                                            <td class="text-center"></td>
                                                            <td><i><?php echo isset($bs->units[$uxid]) ? $bs->units[$uxid] : ''; ?></i></td>
                                                            <td><small><?php echo $uxres; ?></small></td>
                                                            <td> </td>
                                                            <td> </td>
                                                        </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="strong"><?php echo $bs->full; ?> </td>
                                                    <td class="text-right strong"><?php echo $sp->marks; ?></td>
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
                                                    <td class="strong" ><?php echo $bs->full; ?></td>
                                                    <td class="text-right strong"><?php echo $sp->marks; ?></td>
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
                                    <td class="strong"> <span class="pull-right">TOTAL </span></td>
                                    <td class="text-right strong"><?php echo $gd; ?></td>  
                                    <td colspan="2"> </td>
                                </tr>
                            </tbody>
                        </table>
                       <div>						 
                <div class="foo"> <br> </div>
                <div class="foo col-sm-12">
                    <strong><span ><b style="text-decoration:underline">Next Term Commences on:</b> &nbsp;&nbsp; _______________________ &nbsp;&nbsp; </span></strong>

                    <span  ><strong>&nbsp;&nbsp; Attendance:&nbsp;&nbsp; ___________ &nbsp;&nbsp; Out of  &nbsp;&nbsp; ____________ &nbsp;&nbsp; Sessions</strong></span>
                    <br>
                </div>

                <div class="foo col-sm-12">
                    <strong><span style="text-decoration:underline">Student's Conduct:</span></strong>
                    <br>
                    <span class="editable ht editable-wrap" e-style="width:100%">-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </span>
                </div>
                <div class="foo col-sm-12">
                    <strong><span style="text-decoration:underline">Class Teacher's Comment:</span></strong>
                    <br>
                    <span class="editable ht editable-wrap" e-style="width:100%">
                     -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    </span>
                </div>
                <div class="foo col-sm-12">
                    <strong><span style="text-decoration:underline" >Head Teacher's Comment:</span></strong><br/>

                    <span class="editable ht editable-wrap" e-style="width:100%">
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
</div>
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
    .strong{font-weight: bold;}
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