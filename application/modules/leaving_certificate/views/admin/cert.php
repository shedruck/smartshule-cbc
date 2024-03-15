
<?php
$settings = $this->ion_auth->settings();
?>

<div class="widget">
    <div class="col-md-12">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="right print">
                <button onClick="window.print();
                            return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                        <?php echo anchor('admin/leaving_certificate', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Leaving Certificate')), 'class="btn btn-primary"'); ?> 

            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="clear"></div>
    <div class="col-md-2"></div>
    <div class="slip col-md-8">
        <div class="slip-content">
            <div class="row">
                <div class="col-md-12 view-title">
                    <span class="center">
                        <h1><img src="<?php echo base_url('uploads/files/emblem.png'); ?>" width="100" height="100" />
                            <h5> Republic of Kenya
                                <br>
                                <span class="border">________________________</span>
                                <br>

                                State Department of Education
                                <br>
                                <span class="border">________________________</span>
                            </h5>
                        </h1></span>


                    <h3>School Leaving Certificate</h3>			
                </div>
                <div class="col-md-12">

                    <address class="uppercase"  style="margin-right:18px;">
                        This is to certify that <abbr title="Name"><?php echo $student->first_name . ' ' . $student->last_name; ?></abbr>
                        admission number. <abbr  title="ADM" > <?php
                            if (!empty($student->old_adm_no))
                            {
                                    echo $student->old_adm_no;
                            }
                            else
                            {
                                    if ($student->admission_number > 99)
                                    {
                                            echo $student->admission_number;
                                    }
                                    else
                                    {
                                            echo '0' . $student->admission_number;
                                    }
                            }
                            ?>
                        </abbr>
                       
                        date of birth  <abbr  title="DOB" ><?php echo date('d M Y', $student->dob); ?></abbr>
                        entered <abbr  title="SCH"><?php echo $settings->school; ?></abbr>  and was enrolled on   <abbr  title="ADM Date"><?php echo date('d M Y', $student->admission_date); ?></abbr>
                        in  <abbr title="Class" > <?php
                            $class = $this->ion_auth->list_classes();
                            echo isset($class[$student->class]) ? $class[$student->class] : ' ';
                            ?></abbr> 
                        and left on   <abbr title="LEFT" > <?php echo date('d M Y', $post->leaving_date); ?></abbr> from   <abbr title="FROM" > <?php echo isset($class[$student->class]) ? $class[$student->class] : ' '; ?></abbr> having satisfactorily completed the approved course for  <abbr class="" title="" ><?php  echo isset($class[$student->class]) ? $class[$student->class] : ' '; ?></abbr>
                        <br>
                       <b> Headteacher's report on pupil's ability,Industry and conduct:</b> <br> <abbr title="Remark" ><?php echo $post->ht_remarks; ?></abbr>
                        <br>
                        <b>Student's participation in co-curricular activities:</b> <br> <abbr title="activities" ><?php echo $post->co_curricular; ?></abbr>
                    </address> 
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">

                            <br>
                            <strong style="border-top:1px solid #000"> Student's Signature </strong>

                        </div>
                        <div class="col-md-6">

                            <br>
                            <strong class="right" style="border-top:1px solid #000"> Headteacher's Signature </strong>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <br>
                            <?php echo date('d M Y', time()); ?><br>
                            <strong style="border-top:1px solid #000"> Date of Issue  </strong>
                        </div>
                       
                        <div class="col-md-6">

                          <span class="pull-right">  <?php echo theme_image('leaving-cert.png',array('width'=>'100','height'=>'100'))?></span>
                           
                        </div>
                    </div>


                </div>
                <div class="center" style="border-top:1px solid #ccc">		
                    <span class="center uppercase" style="font-size:.8em !important;text-align:center !important;">
                        This Certificate was issued without any erasure or alteration whatsoever
						
						<div style="border-top:1px solid #ccc; font-size:1em">
						
						<b>To verify this document</b> 
						School Code: <b><?php echo $this->school->school_code?></b>
						Serial No: <b><?php echo $post->verification_code; ?></b>
						</div>
                    </span>
                </div>		 

            </div>



        </div>
    </div>
    <div class="col-md-2"></div>    
</div>



<style>
    @media print{

        .navigation{
            display:none;
        }
        .alert{
            display:none;
        }
        .alert-success{
            display:none;
        }

     .tawk{
            display:none !important;
        }

		#tawkchat-status-text-container{
            display:none;
        }

        .img{
            align:center !important;
        } 
        .print{
            display:none !important;
        } 
        .col-md-4{
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
        .header{display:none}
        .invoice { 
            width:100%;
            margin: auto !important;
            padding: 0px !important;
        }
        .invoice table{padding-left: 0; margin-left: 0; }

        .smf .content {
            margin-left: 0px;
        }
        .content {
            margin-left: 0px;
            padding: 0px;
        }
        .slip{
            margin-top:0;}
    }
</style>     

