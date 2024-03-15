
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
                        <?php echo anchor('admin/students_clearance', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => ' Clearance')), 'class="btn btn-warning"'); ?> 

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
                        <h1><img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" width="100" height="100" />
                            <h4> <?php echo $this->school->school;?>
                                <br>
                                <span class="border">________________________</span>
                                <br>
                           <span style="font-size:11px;">
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
								</span>
                                <br>
                                <span class="border">________________________</span>
                            </h4>
                        </h1></span>


                    <h3>STUDENT CLEARANCE FORM</h3>		
                   <span class="center">
                     <h5>	
					 
					 <?php $student = $this->portal_m->find($stud->student);?>
					<p> <b>Student:</b> <?php echo $student->first_name . ' ' . $student->last_name; ?></p>
                       <br><b>ADM No.</b> <?php
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
                  &nbsp;&nbsp;&nbsp;&nbsp;
						<b>UPI Number:</b> <?php  echo $student->upi_number;?>
						</h5>
                    </span>						
                </div>
                <div class="col-md-12">
				    <table cellpadding="0" cellspacing="0" width="100%">
					  <!-- BEGIN -->
						<thead>
							<tr role="row">

							<th width="3%">#</th>
							<th width="20%" >Department</th>
							<th width="15%" >Date</th>
							
							<th width="15%">Clear</th>
							<th width="15%">Charge</th>
							<th width="30%">Comment</th>
							
							</tr>
						</thead>
					   </table>
                     <table cellpadding="0" cellspacing="0" width="100%">  
										<tbody>
										
										<?php
										$i=0;
											$items = $this->ion_auth->populate('clearance_departments','id','name');
											foreach($post as $pp){
												//echo $pp->id;
												$i++;
										 ?>
										
										<tr>
                  
											    <td width="3%">
												  <span id="reference" name="reference" class="heading-reference"><?php echo $i;?></span>
												</td>
												
												   <td width="20%">
										         <?php echo $pp->department;?>
													</td>
													
													 <td width="15%">
														<?php echo date('d M Y',$pp->date);?>
													</td>
													
												<td width="15%">
												<?php echo $pp->cleared;?>
													
												</td>
												
												<td width="15%">
												    <?php echo number_format($pp->charge,2);?>
													
												</td>
												
												<td width="30%">
												     <?php echo $pp->description;?>
													
												</td> 

											</tr>
											
											<?php } ?>
										
										</tbody>
								</table>
                    
                </div>

				 <div class="col-md-12"><br></div>
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

                            <br>
                            <br>
                            <strong class="right" style="border-top:1px solid #000"> Official Stamp </strong>
                        </div>
                    </div>


                </div>
                <div class="center" style="border-top:1px solid #ccc">		
                    <span class="center uppercase" style="font-size:0.8em !important;text-align:center !important;">
                        This document was issued without any erasure or alteration whatsoever
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

