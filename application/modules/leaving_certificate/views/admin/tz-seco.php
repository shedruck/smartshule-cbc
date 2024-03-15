
<?php
 $settings=$this->ion_auth->settings();
?>
           
                <div class="widget">
			    <div class="col-md-12">
<div class="col-md-4"></div>
<div class="col-md-4">
<div class="right print">
			  <button onClick="window.print();
                return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
				 <?php echo anchor( 'admin/leaving_certificate' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Leaving Certificate')), 'class="btn btn-primary"');?> 
        
	</div>
</div>
<div class="col-md-4"></div>
</div>
				<div class="clear"></div>
   <div class="col-md-1"></div>
    <div class="slip col-md-10">
	 <div class="slip-content">
                        <div class="row">
                           <div class="col-md-12 view-title">
							 <span class="center">
                              <h1><img src="<?php echo base_url('uploads/files/emblem.jpg'); ?>" width="100" height="100" />
								<h5>United Republic of Tanzania
								<br>
								<span class="border">________________________</span>
								  <br>
								
								  Ministry of Education and Vacational Training
								  <br>
								  <span class="border">________________________</span>
								</h5>
						</h1></span>
							
                               
                              		  <h3>Secondary School Leaving Certificate</h3>			
                            </div>
							 <div class="col-md-12">
							 
							   <address class="uppercase tz"  style="margin-right:18px;">
							   
							  <b> SCHOOL NAME: </b><abbr title="Name"><?php echo $this->school->school; ?></abbr> <BR>
							  <b> SCHOOL'S POSTAL ADDRESS:</b> <abbr title="Name"><?php echo $this->school->postal_addr.', Tel '.$this->school->tel.' Cell '.$this->school->cell.', '.$this->school->email; ?></abbr>  <div class="clearfix"></div>
							   
							    <div class="col-md-5"><b> 1. Pupil's name in full:</b> </div>
									 <div class="col-md-5 details">
									   <?php echo $student->first_name . ' ' . $student->last_name; ?>
									 </div> 
									 
		               	<div class="col-md-5"> <b> 2. School admission number:</b> </div>
							 
									 <div class="col-md-5 details">
									   <?php
									if (!empty($student->old_adm_no)){echo $student->old_adm_no; }
									else
									{ if ($student->admission_number > 99){ echo $student->admission_number; }
										else{ echo '0' . $student->admission_number;} }
									?>
									 </div> 
							
									 <div class="col-md-5 "> <b>  3. Sex (M or F): </b>  </div>
									 
									 <div class="col-md-5 details">
									
									   <?php
											if ($student->gender == 1)
													echo 'Male';
											else
												echo 'Female';
										?>
									
									</div> 
							 
									 <div class="col-md-5"> <b> 4. Nationality:</b> </div>
									 
									 <div class="col-md-5 details"></b> Tanzania</b> </div> 
							
									 <div class="col-md-5">  <b> 5. Date or year of birth: </b> </div>
									 <div class="col-md-5 details"> 
									 <?php echo date('d M Y', $student->dob); ?>
									 </div> 
							 
									 <div class="col-md-5"> <b> 6. Date of admission: </b> </div>
									 <div class="col-md-5 details">  
							        <?php echo date('d M Y', $student->admission_date); ?>
								
									   </div> 
						
									 <div class="col-md-5 ">  <b> 7. Form to which admitted: </b>  </div>
									 <div class="col-md-5 details">
										
									   <?php   $class = $this->ion_auth->list_classes(); echo isset($class[$student->class]) ? $class[$student->class] : ' '; ?>
								
									  </div> 
							
									 <div class="col-md-5"><b>  8. Highest form reach: </b> </div>
									 <div class="col-md-5 details">
										   <?php
											$class = $this->ion_auth->list_classes();
										$cls = isset($class[$student->class]) ? $class[$student->class] : ' -';
														echo $cls;
										  
											?>
									 </div> 
							
									 <div class="col-md-5"><b> 9. Date of leaving school:</b>  </div>
									 <div class="col-md-5 details"> <?php echo date('d M Y',$post->leaving_date);?></div> 
						
									 <div class="col-md-3"> <b> 10. Remarks: </b> </div>
									 <div class="col-md-8 details"><?php echo $post->ht_remarks;?></div> 
							
							    </address> 
							 </div>
							  <div class="clearfix"></div>
						<div class="row">
		                  <div class="col-md-12">
							<div class="col-md-6">
							
							<br>
							<br>
							 <strong style="border-top:1px solid #000"> Pupil's Signature </strong>
							
							</div>
							<div class="col-md-6">
							
							<br>
							<br>
								<strong class="right" style="border-top:1px solid #000"> Headteacher's Signature </strong>
							</div>
						</div>
						</div>
						<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
							
							<br>
							<?php echo date('d M Ys',time());?><br>
							 <strong style="border-top:1px solid #000"> Date of Issue  </strong>
							
							</div>
							<div class="col-md-6">
							
							<br>
							<br>
								<strong class="right" style="border-top:1px solid #000"> Official Stamp </strong>
							</div>
						</div>
			
		
        </div>
		<div class="center" style="border-top:1px solid #ccc">		
	 <span class="center uppercase" style="font-size:0.8em !important;text-align:center !important;">
	 This Certificate was issued without any erasure or alteration whatsoever
	 </span>
	 </div>		 
					
                        </div>
						
						
						 
			</div>
			</div>
		 <div class="col-md-1"></div>    
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
		.col-md-5{
		width:250px  !important;
			float:right !important;
		}
		.col-md-3{
		width:150px  !important;
			float:right !important;
		}
		.col-md-8{
		width:400px  !important;
			float:right !important;
		}
		.details{
			clear:both;
		}
		.clearfix{
			clear:both;
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

