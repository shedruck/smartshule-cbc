<div class="row hidden-print">
    <hr/>
    <div class="col-md-12">
        <div class="card-bsox">
            <h2 class="header-title m-t-0 m-b-20">Transition Profile
                <div class="pull-right">                            
                    <?php echo anchor('trs/transition_profile/', '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-primary"'); ?>
                    <a href="" onClick="window.print();
                                return false" class="btn btn-purple hidden-print"><i class="mdi mdi-printer"></i> Print
                    </a>
                </div> 
            </h2>
        </div>
    </div>
</div>
 
<div class="col-sm-2"></div>
<div class="col-sm-8  widget card-box table-responsive">
    <?php
    $haspos = 1;
    $this->load->library('Dates');
    $pref = '';

    $j = 0;
    $student_id = 0;
    
            $student_id = $get->student;
            ?>
            <div class="slip">
                  <div class="row-fluid text-center">
                    <?php
                    $file = FCPATH . '/uploads/joint-header.png';
                    if (file_exists($file))
                    {
                            ?>
                            <span class="col-sm-2" style="text-align:center"></span>
                            <span class="col-sm-12" style="text-align:center">
                                <img src="<?php echo base_url('uploads/joint-header.png'); ?>" class="center"    />
                            </span>
                            <span class="col-sm-2" style="text-align:center">
                                <?php
                                if (!empty($student->photo)):
                                       
                                        if ($passport)
                                        {
                                                ?> 
                                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                                        <?php } ?>	

                                <?php else: ?>   
                                        <?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                                <?php endif; ?>
                            </span>
                            <?php
                    }
                    else
                    {
                            ?>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <span class="" style="text-align:center">
                                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="100" />
                                </span>
                                <h3>
                                    <span style="text-align:center !important;font-size:15px;"><?php echo strtoupper($this->school->school); ?></span>
                                </h3>
                                <small style="text-align:center !important;font-size:12px; line-height:2px;">
                                    <?php
                                    if (!empty($this->school->tel))
                                    {
                                            echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                    }
                                    else
                                    {
                                            echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                    }
                                    ?>
                                </small>
                                <h3>
                                    <span style="text-align:center !important;font-size:13px; font-weight:700; border:double; padding:5px;">MIDDLE SCHOOL</span>
                                </h3>
								<br>
                                <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">END OF YEAR LEARNERS TRANSITION PROFILE</small>
                            </div>	
                            <div class="col-sm-2" hidden>
                                <?php
                                if (!empty($rw->student->photo)):
                                        $passport = $this->ion_auth->passport($rw->student->photo);
                                        if ($passport)
                                        {
                                                ?> 
                                                <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                                        <?php } ?>	

                                <?php else: ?>   
                                        <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                                <?php endif; ?>
                            </div>	
                    <?php } ?>                              
                </div>
				
                <hr>
                <div class="row  text-center">
                <div class="col-md-12">

                    <table class="topdets table " width="100%">
                        <tr>
                            <td><strong>Name : </strong>
                                <abbr><?php echo $student->first_name . ' ' . $student->last_name; ?> </abbr>
                            </td>
                            <td><strong>Age : </strong> <abbr>
                                <?php 

                                     $date = $student->dob > 10000 ? date('Y-m-d', $student->dob) : 0;
                                     $age = $date && $student->dob > 10000 ? date_diff(date_create($date), date_create('today'))->y : '';
                                     if($age == 0){
                                        $age = '';
                                     }

                                     echo $age;
                                ?>
                                
                            </abbr></td>
                             
                        </tr>
                        <tr>
                            <td>
                                <strong>Class : </strong>
                                <abbr><?php
                                $streams = $this->streams;
                                   
                                    $ctr = isset($streams[$get->class]) ? $streams[$get->class] : '';
                                    echo   $ctr;
                                    ?>
                                </abbr>
                            </td>
                            <td>
                                <strong>Date : </strong> 
                                <abbr>
                                    <?php echo date("d M, Y", $get->created_on)?>
                                </abbr>
                            </td>
                             
                        </tr>
                    </table>
					
                </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30%"><strong>Key Areas</strong></th>
                            <th><strong>Comment</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Allergies</td>
                            <td><?php echo $get->allergy?></td>
                        </tr>
                         <tr>
                            <td>General Health comment</td>
                            <td><?php echo $get->general_health ?></td>
                        </tr>

                        <tr>
                            <td>General Academic Performance</td>
                            <td><?php echo $get->general_academic ?></td>
                        </tr>

                        <tr>
                            <td>Feeding habit</td>
                            <td><?php echo $get->feeding_habit ?></td>
                        </tr>

                        <tr>
                            <td>Behavior</td>
                            <td><?php echo $get->behaviour ?></td>
                        </tr>

                        <tr>
                            <td>Co-curriculum Activities</td>
                            <td><?php echo $get->co_curriculum ?></td>
                        </tr>

                         <tr>
                            <td>Parental involvement</td>
                            <td><?php echo $get->parental_involvement ?></td>
                        </tr>

                        <tr>
                            <td>Transport - Private Transport</td>
                            <td><?php if($get->transport == "private"){ ?> <i class="fa fa-check btn btn-pink btn-circle"></i><?php }?></td>
                        </tr>
                        <tr>
                            <td>&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            School Transport</td>
                            <td><?php if($get->transport == "school") { ?> <i class="fa fa-check btn btn-pink btn-circle"></i><?php }?></td>
                        </tr>
                        <tr>
                            <td>Any other information</td>
                            <td><?php echo $get->any_info?></td>
                        </tr>
                         
                    </tbody>
                </table>

                <table class="lower" width="100%" style="border:none !important"  >
                    <tr>
                        <td>Prepared By</td>
                        <td>
                            <abbr>
                                <strong>
                                <?php 
                                    $user =  $this->ion_auth->get_user($get->created_by);
                                    echo ucwords($user->first_name.' '.$user->last_name);
                                ?>
                                </strong>
                            </abbr>
                        </td>

                        <td>Sign</td>
                        <td>_____________________</td>
                    </tr>

                    <tr>
                        <td>Received By</td>
                        <td>
                            <abbr>
                                <strong>
                                 _______________________
                                </strong>
                            </abbr>
                        </td>

                        <td>Sign</td>
                        <td>_____________________</td>
                    </tr>
                </table>
                 
            </div>
            <div class="page-break"></div>
          
 
     
</div>
<div class="col-md-2"></div>
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
        border: 0;width: 96%;
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
        text-align: center;
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
		img{
			width:80px !important;
			height:80px !important;
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
    table.table-bordered th:last-child, table.table-bordered td:last-child {
        border-right-width: 1px;  
    }
</style>