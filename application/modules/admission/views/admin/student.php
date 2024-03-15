<div class="col-md-12">
    <div class="widget">
        <div class="block invoice">
            <div class="row">
                <div class="col-md-2">			
                    <div class='btn btn-default btn-sm' >					
                        <?php
                        if (!empty($student->photo)):
                                if ($passport)
                                {
                                        ?> 
                                        <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
                         <?php } ?>	

                        <?php else: ?>   
                                <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                        <?php endif; ?>  
                        <br>					
                    </div>
					<center>
					Status:
					<?php 
					
						   //********* Status *******//
							if ($student->status == 1)
								$status = '<span class="label label-success">Active</span>';
							elseif ($student->status == 0)
								$status = '<span class="label label-danger">Inactive</span>';

							elseif ($student->status == 2)
								$status = '<span class="label label-primary">Alumni</span>';
							else
							   $status = '<span class="label label-warning">Unknown</span>';
							   
							   echo $status;
			   
					?>
					</center>
                </div>
				
                <div class="col-md-4">
                    <h4> <abbr><?php echo ucwords($student->first_name . ' ' .$student->middle_name . ' ' . $student->last_name); ?>. </abbr></h4>
                    <h4>					
                        <abbr>ADM NO. <?php
                            if (!empty($student->old_adm_no))
                            {
                                    echo $student->old_adm_no;
                            }
                            else
                            {
                                    echo $student->admission_number;
                            }
                            ?>
                        </abbr>
                    </h4>
					
					<h4>
					
                    <abbr>UPI NO. <?php echo $student->upi_number;?></abbr>
                   
						
                    </h4>
                    <span class="date">Admission Date: <?php echo $student->admission_date > 10000 ? date('M, d, Y', $student->admission_date) : ' - '; ?></span>
					 
                </div>

                <div class="col-md-6">
				
                    <div class="right">
                        <form name="student_post" id="student_post" action="<?php echo base_url('admin/admission/quick_nav/'); ?>" method="POST" >
                            <select name="student" class="select select2-offscreen" style="" tabindex="-1">
                                <option value="">Select Student</option>
                                <?php
                                $data = $this->ion_auth->students_full_details();
                                foreach ($data as $key => $value):
                                        ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-warning"  style="height:30px;" type="submit">View Profile</button>
                        </form>
                    </div>

                    <div class="right">
                        <br>
                        <br>
						<a class="print" href="<?php echo base_url('admin/admission/student_id/' . $student->id)?>"><button class="btn btn-success" ><span class="glyphicon glyphicon-user"></span> My ID Card  </button></a>
 
						<a class="print" href="<?php echo base_url('admin/leaving_certificate/create/' . $student->id)?>"><button class="btn btn-info" ><span class="glyphicon glyphicon-file"></span> Leaving Cert  </button></a>
						
							<?php
        if ($this->acl->is_allowed(array('admission', 'edit'), 1))
        {
                ?>
						<a class="print" href="<?php echo base_url('admin/admission/edit/' . $student->id)?>"><button class="btn btn-danger" ><span class="glyphicon glyphicon-edit"></span> Edit </button></a>

		<?php } ?>	
					<?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list">
                    </i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?>
					
					 <a class="print" href="<?php echo base_url('admin/students_certificates/my_certs/' . $student->id)?>"><button class="btn btn-info" ><span class="glyphicon glyphicon-file"></span> My Certificates  </button></a>
					   <?php 
					if($student->birth_certificate){
					$cert = $this->portal_m->birth_certificate($student->birth_certificate); ?>
					  <a target="_blank" href="<?php echo base_url('uploads/' . $cert->fpath . $cert->filename); ?>" >
					  <button class="btn btn-info" >
					  <span class="glyphicon glyphicon-download-alt"></span> Birth Certificate </button></a>
					 
					 <?php } ?>
									 
					 <a class="print" href="<?php echo base_url('admin/reports/student_report/' . $student->id)?>"><button class="btn btn-warning" ><span class="glyphicon glyphicon-file">
					 </span> My History  </button>
					 </a>
       
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <h4>Student Details</h4>

                    <address>
                        <b>Birthday:</b> <?php echo $student->dob > 10000 ? date('d M Y', $student->dob) : ''; ?>.<br>
                        <b>Birth Certificate No:</b> <?php echo $student->birth_cert_no?>.<br>
                        <b>Gender:</b> <?php
                        if ($student->gender == 1)
                                echo 'Male';
                        elseif($student->gender == 2)
                                echo 'Female';
						else echo $student->gender;
                        ?><br>
                       
                        
						 <b>Disabled:</b> <?php echo $student->disabled ?><br>
						 <b>Blood Grp:</b> <?php echo $student->blood_group ?><br>
						 <b>Student Phone:</b> <?php echo $student->student_phone ?><br>
						 <b>Status:</b> <?php echo $student->student_status ?><br>
						 <b>Citizenship:</b> 
						 <?php 
						 $cc = $this->ion_auth->populate('countries','id','name'); 
						
						 if($student->citizenship){
						     echo isset($cc[$student->citizenship]) ? $cc[$student->citizenship]:'Kenya'; 
						 }
						 ?>
						 <br>
						 <b>Home County:</b> <?php $hc = $this->ion_auth->populate('counties','id','name'); echo isset($hc[$student->county]) ? $hc[$student->county]:''; ?><br>
						 <b>Sub County:</b> <?php 
						  $sc = $this->ion_auth->populate('subcounties','id','subcounty'); 
						 echo isset($sc[$student->sub_county]) ? $sc[$student->sub_county] : ''; ?><br>
						  <b>Residence</b>
                         <?php echo $student->residence; ?><br>
                        <br>
                       
                    </address>
                </div>

                <div class="col-md-3">
                    <h4>Admission Details</h4>
                    <?php
                    $class = $this->ion_auth->list_classes();
                    $stream = $this->ion_auth->get_stream();

                    $u = $this->ion_auth->get_user($student->created_by);
                    ?>
                    <p><strong>Class:</strong> 
					
					<?php
                        $cls = isset($class[$cl->class]) ? $class[$cl->class] : ' -';
                        $strm = isset($stream[$cl->stream]) ? $stream[$cl->stream] : ' -';
                        echo $cls . ' ' . $strm;
                        ?>
						
						</p>

                    <p><strong>Emergency Phone:</strong> <?php echo $student->emergency_phone; ?></p>
					
                    <p><strong>Scholar:</strong> <?php echo $student->boarding_day; ?></p>
					<p><b>House:</b> <?php
                        $hse = $this->ion_auth->list_house();
                        if ($student->house && isset($hse[$student->house]))
                        {
                                echo $hse[$student->house];
                        }
                        ?>  
                      </p> 
                    <p><strong>Admitted By:</strong> <?php echo $u->first_name . ' ' . $u->last_name; ?></p>
                    <p><strong>Admitted On:</strong> <?php echo $student->admission_date > 10000 ? date('M, d, Y', $student->admission_date) : ' - '; ?></p>
                    <p><?php echo $student->email;?></p>
				
                    <?php
                    if (isset($student->list_id))
                    {
                            echo '<p>' . $student->list_id . '</p>';
                    }
                    else
                    {
                            echo '<p>&nbsp;</p>';
                    }
                    ?>
                
                    
                </div>

                <div class="col-md-3">
                    <h4>Other Details</h4> 
                   
                    <b>Religion:</b> <?php echo $student->religion; ?><br>
                    <b>Former School:</b> <?php echo $student->former_school; ?><br>
                    <b>Entry Marks:</b> <?php echo $student->entry_marks; ?><br>
                    <b>Allergies:</b> <?php echo $student->allergies; ?>.<br>
                    <b>Doctor:</b> <?php echo $student->doctor_name; ?>.<br>
                    <b>Dr. Phone:</b> <?php echo $student->doctor_phone; ?><br>
					
                </div>

                <div class="col-md-3">
                    <h4>Payment Details</h4>

                    <div class="highlight2">
                        <strong ><span >Fee Payable: </span> <?php echo $this->currency; ?> <?php
                            if ($fee && $student->status)
                            {
                                    echo number_format($fee->invoice_amt, 2);
                            }
                            else
                            {
                                    echo '0.00';
                            }
                            ?>  <em></em>
                        </strong>
                    </div> 
                    <div class="highlight ">
                        <strong ><span>Total Paid: </span><?php echo $this->currency; ?> <?php
                            if (!empty($fee) && $student->status)
                            {
                                    $amm = $fee->paid;
                                    if ($waiver)
                                    {
                                            $amm = $fee->paid - $waiver;
                                    }
                                    echo number_format($amm, 2);
                            }
                            else
                            {
                                    echo '0.00';
                            }
                            ?></strong>
                    </div>
                    <!---WAIVER--->
                    <?php if ($waiver && $student->status): ?>
                            <div class="highlight ">
                                <strong ><span>Fee Waived: </span> <?php echo $this->currency; ?> <?php
                                    echo number_format($waiver, 2);
                                    ?>  <em></em></strong>
                            </div>
                    <?php endif ?>
                    <div class="highlight3">
                        <strong > <?php
                            if (isset($fee) && isset($fee->balance))
                            {
                                    if ($fee->balance > 0)
                                    {
                                            echo '<span>Fee Balance: </span> ' . $this->currency . ' ' . number_format($fee->balance, 2);
                                    }
                                    elseif ($fee->balance < 0)
                                    {
                                            echo '<span>Overpay </span> ' . $this->currency . ' ' . number_format($fee->balance, 2);
                                    }
                                    elseif ($fee->balance == 0)
                                    {
                                            echo '<span>No Balance </span> ' . $this->currency . ' ' . number_format($fee->balance, 2);
                                    }
                            }
                            ?>   </strong>
                    </div><br>
                    <?php
                    if ($this->acl->is_allowed(array('fee_payment', 'statement'), 1))
                    {
                            ?>
                            <?php echo anchor('admin/fee_payment/statement/' . $student->id, '<i class="glyphicon glyphicon-folder-open"> </i> View Fee Statement', 'class="btn btn-primary"'); ?> 
                    <?php } ?> </div>
					
				
					<div class="clearfix"></div>
					
					<div class="">
					
				
			      <b>Scholarship:</b> <?php echo $student->scholarship; ?>
				   <table border="0">
					 <?php if($student->scholarship=='Yes'){ ?>
					 <tr>
						<td><b> Type:</b> <?php echo $student->scholarship_type; ?></td>
						<td><b> Details:</b><br> <?php echo $student->sponsor_details; ?></td>
						<td><b>Phone:</b><br> <?php echo $student->sponsor_phone; ?></td>
						<td><b>Location:</b><br> <?php echo $student->sponsor_location; ?></td>
						<td><b>Contact Person:</b><br> <?php echo $student->sponsor_contact_person; ?></td>
					  </tr>
					 <?php } ?>
                    </table>
					<br>
				
				
			</div>
            </div>
			
			<!--------- Hobbies and Favourites -------->
		
            <div class="widget">
                <div class="block-fluid tabbable">                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab7" data-toggle="tab">Parents Details</a></li>
                        <li ><a href="#hobbies" data-toggle="tab">Favourites and Hobbies</a></li>
                        <li class=""><a href="#tab1" data-toggle="tab">Payment History</a></li>
                        <li class=""><a href="#tab4" data-toggle="tab">Leadership Positions</a></li>
                        <li class=""><a href="#tab5" data-toggle="tab">Discipline</a></li>
                        <li class=""><a href="#tab6" data-toggle="tab">Transport</a></li>
                        <li class=""><a href="#tab3" data-toggle="tab">Rooms/Beds</a></li>
                    </ul>
                    <div class="tab-content">
					
					
                        <!--TAB 7 Parents-->
                        <div class="tab-pane active" id="tab7">
                            <div class="block-fluid">
                                <div class="col-md-4">
                                    <div class="widget">
                                        <div class="profile clearfix">
                                            <div class="info-s" style="text-align:center">
											<div class='btn btn-default btn-sm'>
											   <?php
													if (!empty($paro->father_photo)):
													$passport = $this->portal_m->parent_photo($paro->father_photo);
													  if ($passport)
															{
																	?> 
																	<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
													 <?php } ?>	

													<?php else: ?>   
															<?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
													<?php endif; ?> 
											</div>	
											
											
                                                <h5><?php echo isset($paro->f_title) ? $paro->f_title.' ' : '' ?> 
												<?php echo ucwords($paro->first_name . ' ' . $paro->f_middle_name . ' ' . $paro->last_name); ?></h5>
                                                <table border="0" width="250">
                                                   
                                                    <tr> <td><strong>Relation:</strong></td><td> <?php echo $paro->f_relation ?></td></tr>
                                                    <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $paro->phone ?></td></tr>
													 <tr> <td><strong>Email:</strong></td><td style="font-size:10px;"> <?php echo substr($paro->email,0,30).'..'; ?></td></tr>
                                                  
                                                    <tr> <td><strong>Occupation:</strong></td><td><?php echo $paro->occupation ?></td></tr>
													  <tr> <td><strong>ID No:</strong></td><td> <?php echo $paro->f_id ?></td></tr>
                                                    <tr> <td><strong>Address:</strong></td><td><?php echo $paro->address ?></td></tr>
                                                    <tr> <td><strong>Postal Code:</strong></td><td><?php echo $paro->f_postal_code ?></td></tr>
                                                </table>
												<br>
												<a class='btn btn-success ' href='<?php echo site_url('admin/parents/view/'.$paro->id);?>'> View Profile</a>
                                                <div class="status">First Parent/Guardian</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="col-md-4">
                                    <div class="widget">
                                        <div class="profile clearfix">                        
                                            <div class="info-s"  style="text-align:center">
											<div class='btn btn-default btn-sm'>
											<?php
													if (!empty($paro->mother_photo)):
													$mpp = $this->portal_m->parent_photo($paro->mother_photo);
													  if ($mpp)
															{
																	?> 
																	<image src="<?php echo base_url('uploads/' . $mpp->fpath . '/' . $mpp->filename); ?>" width="100" height="100" class="img-polaroid" style="align:left">
													 <?php } ?>	

													<?php else: ?>   
															<?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
													<?php endif; ?> 
											</div>		
										
                                                <h5><?php echo isset($paro->m_title) ? $paro->m_title.' ' : '' ?> 
												<?php echo ucwords($paro->mother_fname . ' ' .$paro->m_middle_name . ' ' . $paro->mother_lname); ?></h5>
																								
                                                <table border="0" width="250">
                                                    <tr> <td><strong>Relation:</strong></td><td> <?php echo $paro->m_relation ?></td></tr>
                                                    <tr><td><strong>Cell Phone:</strong></td><td> <?php echo $paro->mother_phone ?></td></tr>
													
													 <tr><td><strong>Email:</strong></td><td style="font-size:10px;"> <?php echo substr($paro->mother_email,0,20).'..'; ?></td></tr>
													 
                                                    <tr><td><strong>Occupation:</strong></td><td><?php echo $paro->mother_occupation; ?></td></tr>
													
													 <tr> <td><strong>ID No:</strong></td><td> <?php echo $paro->f_id ?></td></tr>
                                                    <tr><td><strong>Address:</strong></td><td><?php echo $paro->address ?></td></tr>
													 <tr> <td><strong>Postal Code:</strong></td><td><?php echo $paro->m_postal_code ?></td></tr>
													 <?php if($paro->mother_phone){ ?>
                                                    <tr>
													
                                                        <td><strong>SMS: <i class="glyphicon glyphicon-info-sign tip" title="Toggle to enable sending SMS to 2nd Parent/Guardian. First Parent will always receive SMS"></i></strong></td>
                                                      	<?php
        if ($this->acl->is_allowed(array('admission', 'edit'), 1))
        {
                ?>  <td>
                                                            <?php
                                                            $chk = '';
                                                            if (isset($paro->sms) && $paro->sms == 1)
                                                            {
                                                                    $chk = ' checked="checked" ';
                                                            }
                                                            ?>
                                                            <input type="checkbox" class="switchx" <?php echo $chk; ?>>
                                                        </td>
		<?php } ?>
                                                    </tr>
													 <?php } ?>
                                                </table>
                                                <div class="status">Second Parent/Guardian</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								 <div class="col-md-4">
                                    <div class="widget">
                                        <div class="profile clearfix">                        
                                            <div class="info-s" style="text-align:center">
											<h4>Emergency Contacts</h4>
											 <?php if($em_cont){?>
											 <h5> <?php echo ucwords($em_cont->name.' '.$em_cont->middle_name.' '.$em_cont->last_name); ?></h5>
                                                <table border="0" width="250">
                                                    <tr> <td><strong>Relation:</strong></td><td> <?php echo $em_cont->relation ?></td></tr>
                                                    <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $em_cont->phone ?></td></tr>
													 <tr> <td><strong>Email:</strong></td><td> <?php echo $em_cont->email ?></td></tr>
													  <tr> <td><strong>ID No:</strong></td><td> <?php echo $em_cont->id_no ?></td></tr>
                                                    <tr> <td><strong>Address:</strong></td><td><?php echo $em_cont->address ?></td></tr>
                                                    <tr> <td><strong>Provided By:</strong></td><td><?php echo $em_cont->provided_by ?></td></tr>
                                                </table>
																						 
                                              <?php }else{?>
												 No records uploaded at the moment
                                              <?php }?>									 
											
											 </div>
										 </div>  
									  </div>
								</div>
								
                            </div>
                        </div>
                        <!---End TAB-->
					
                        <div class="tab-pane " id="hobbies">
							        <?php if ($favourite_hobbies): ?>
											 <div class="block-fluid">
											<table class="table" cellpadding="0" cellspacing="0" width="100%">
								 <thead>
											<th>#</th>
											
											<th>Class</th>
											<th>Year</th>
											<th>Languages Spoken</th>
											<th>Hobbies</th>
											<th>Favourite Subjects</th>
											<th>Favourite Books</th>
											<th>Favourite Food</th>
											<th>Favourite Bible Verse</th>
											<th>Favourite Cartoon</th>
											<th>Favourite Career</th>
											<th>Others</th>	
										
									</thead>
									<tbody>
									<?php 
										$i=0;
										foreach ($favourite_hobbies as $p ): 
											 $i++;
												 ?>
								 <tr>
											<td><?php echo $i . '.'; ?></td>					
										
												<td>
												<?php 
												
												 $cls = isset($class[$p->class]) ? $class[$p->class] : ' -';
												
												 echo $cls;
												
												?>
												</td>
												<td><?php echo $p->year;?></td>
												<td><?php echo $p->languages_spoken;?></td>
												<td><?php echo $p->hobbies;?></td>
												<td><?php echo $p->favourite_subjects;?></td>
												<td><?php echo $p->favourite_books;?></td>
												<td><?php echo $p->favourite_food;?></td>
												<td><?php echo $p->favourite_bible_verse;?></td>
												<td><?php echo $p->favourite_cartoon;?></td>
												<td><?php echo $p->favourite_career;?></td>
												<td><?php echo $p->others;?></td>

										
											</tr>
										<?php endforeach ?>
									</tbody>

								</table>

								
							</div>

							<?php else: ?>
								<p class='text'><?php echo lang('web_no_elements');?></p>
							 <?php endif ?>
 
                            
                        </div>
                        <!--TAB2-->

						<!---End TAB-->
					
                        <div class="tab-pane " id="tab1">
                            <?php if (!empty($p)): ?>
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="3%">#</th>
                                                <th width="">Payment Date</th>
                                                <th width="">Description</th>
                                                <th width="">Payment Method</th>
                                                <th width="">Transaction No.</th>
                                                <th width="">Bank.</th>
                                                <th width="">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($p as $p):
                                                    $user = $this->ion_auth->get_user($p->created_by);
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo date('d/m/Y', $p->payment_date); ?></td>
                                                        <td><?php
                                                            if ($p->description == 0)
                                                                    echo 'Tuition Fee Payment';
                                                            elseif (is_numeric($p->description))
                                                                    echo $extras[$p->description];
                                                            else
                                                                    echo $p->description;
                                                            ?></td>
                                                        <td><?php echo $p->payment_method; ?></td>
                                                        <td><?php echo $p->transaction_no; ?></td>
                                                        <td><?php
                                                            if (!empty($p->bank_id))
                                                            {
                                                                    echo isset($banks[$p->bank_id]) ? $banks[$p->bank_id] : ' ';
                                                            }
                                                            ?></td>
                                                        <td><?php echo number_format($p->amount, 2); ?></td>
                                                    </tr>
                                            <?php endforeach ?>

                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="total">

                                                <div class="highlight">
                                                    <strong><span>Total Paid Including Waivers:</span> <?php echo $this->currency; ?>. <?php
                                                        if (!empty($fee))
                                                        {
                                                                echo number_format($fee->paid, 2);
                                                        }
                                                        else
                                                        {
                                                                echo '0.00';
                                                        }
                                                        ?>  <em></em></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php else: ?>
                                    <h5>No Payment has been recorded at the moment!!</h5>
                            <?php endif; ?>
                        </div>
                        <!--TAB2-->
                        <div class="tab-pane " id="tab2">
                            <?php if (!empty($exams)): ?>
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="3%">#</th>
                                                <th width="">Term/Semester</th>
                                                <th width="">Total Marks</th>
                                                <th width="">Remarks</th>
                                                <th width="">Recorded on</th>
                                                <th width="">Recorded By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            $av = 0;

                                            foreach ($exams as $p):
                                                    $user = $this->ion_auth->get_user($p->created_by);
                                                    $exams_id = 0; //$this->exams_management_m->find($p->exams_id);

                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php
                                                            if ($exams_id)
                                                            {
                                                                    echo ' Term ' . $term[$exams_id->exam_type] . ' - ';
                                                                    echo $type_details[$exams_id->exam_type];
                                                            }
                                                            else
                                                            {
                                                                    echo ' - ';
                                                            }
                                                            ?></td>
                                                        <td><?php echo $p->total; ?></td>
                                                        <td><?php echo $p->remarks; ?></td>
                                                        <td><?php echo date('d/m/Y', $p->created_on); ?></td>
                                                        <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                                    </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>

                            <?php else: ?>
                                    <h5>No exams has been recorded at the moment!!</h5>
                            <?php endif; ?>
                        </div> 
                        <!--TAB 3-->
                        <div class="tab-pane " id="tab3">
                            <?php if ($bed): ?>

                                    <table class="" cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                        <th>#</th>
                                        <th>Date Assigned</th>
                                        <th>Term</th>
                                        <th>Year</th>
                                        <th>Bed</th>
                                        <th>Comment</th>
                                        <th>Assigned By</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($bed as $p):
                                                    $u = $this->ion_auth->get_user($p->created_by);
                                                    $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i . '.'; ?></td>					
                                                        <td><?php echo date('d M Y', $p->date_assigned); ?></td>
                                                        <td><?php echo $this->terms[$p->term]; ?></td>
                                                        <td><?php echo $p->year; ?></td>
                                                        <td><?php echo $beds[$p->bed]; ?></td>
                                                        <td><?php echo $p->comment; ?></td>
                                                        <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                    </tr>
                                            <?php endforeach ?>
                                        </tbody>

                                    </table>
                            <?php else: ?>
                                    <p class='text'><?php echo lang('web_no_elements'); ?></p>
                            <?php endif ?>
                        </div>

                        <!--TAB 4 POSITIONS-->
                        <div class="tab-pane " id="tab4">
                            <?php if ($position): ?>              

                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                        <th>#</th>
                                        <th>Position</th>	
                                        <th>Representing</th>	
                                        <th>Start Date</th>	
                                        <th>Date upto</th>	
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;

                                            foreach ($position as $p):
                                                    $i++;

                                                    $class = $this->ion_auth->list_classes();
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i . '.'; ?></td>	
                                                        <td><?php echo $st_pos[$p->position]; ?></td>
                                                        <td><?php
                                                            if ($p->student_class == "Others")
                                                            {
                                                                    echo 'Others';
                                                            }
                                                            else
                                                            {
                                                                    echo isset($class[$p->student_class]) ? $class[$p->student_class] : ' - ';
                                                            }
                                                            ?></td>
                                                        <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                                        <td width="20%"><?php echo date('d/m/Y', $p->duration); ?></td>
                                                    </tr>
                                            <?php endforeach ?>
                                        </tbody>

                                    </table>

                            <?php else: ?>
                                    <p class='text'><?php echo lang('web_no_elements'); ?></p>
                            <?php endif ?>
                        </div>
                        <!---End Position-->

                        <!--TAB 5 POSITIONS-->
                        <div class="tab-pane " id="tab5">
                            <?php if ($disciplinary): ?>              

                                    <table  cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                        <th>#</th>
                                        <th>Reported on</th>
                                        <th>Reported By</th>
                                        <th>Reason</th>
                                        <th>Action Taken</th>
                                        <th>Taken On</th>
                                        <th>Comment</th> 
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;

                                            foreach ($disciplinary as $p):
                                                    $i++;

                                                    $user = $this->ion_auth->get_user($p->reported_by);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i . '.'; ?></td>					
                                                        <td><?php echo date('d/m/Y', $p->date_reported); ?></td>
                                                        <td><?php
                                                            if (!empty($p->reported_by))
                                                            {
                                                                    echo $user->first_name . ' ' . $user->last_name;
                                                            }
                                                            else
                                                            {
                                                                    echo $p->others;
                                                            }
                                                            ?></td>
                                                        <td><?php echo substr($p->description, 0, 30) . '...'; ?></td>
                                                        <td>
                                                            <?php echo $p->action_taken; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo date('d/m/Y', $p->modified_on); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $p->comment; ?>
                                                        </td> 
                                                    </tr>
                                            <?php endforeach ?>
                                        </tbody>

                                    </table>
                            <?php else: ?>
                                    <p class='text'><?php echo lang('web_no_elements'); ?></p>
                            <?php endif ?>
                        </div>
                        <!---End TAB-->

                        <!--TAB 6 Transport-->
                        <div class="tab-pane " id="tab6">
                        </div>
                        <!---End TAB-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        new DG.OnOffSwitchAuto({
            cls: '.switchx',
            textOn: "YES",
            height: 25,
            textOff: "NO",
            listener: function (name, checked)
            {
                console.log("Listener called for " + name + ", checked: " + checked);
                $.ajax({
                    url: "<?php echo base_url('admin/parents/sms_settings/' . $paro->id); ?>",
                    type: "post",
                    data: {name: name, val: checked},
                    success: function (data)
                    {

                    }
                });
            }
        });
</script>
<style>
    .tip 
    {
        top: 3px;
        font-size: 17px;
    }
    @media print
    {
        .navigation
        {
            display:none;
        }
        .head{
            display:none;
        }

        .tip{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; }
        .view-title h3{border:none !important; }

        .split{

            float:left;
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
    }
</style>
<style>
    .bglite{background-color: #fff;}
    .on-off-switch{
        position:relative;
        cursor:pointer;
        overflow:hidden;
        user-select:none;
    }

    .on-off-switch-track{
        position:absolute;
        border : solid #888;
        z-index:1;
        background-color: #fff;
        overflow:hidden;
    }

    /* semi transparent white overlay */
    .on-off-switch-track-white{
        background-color:#FFF;
        position:absolute;
        opacity:0.2;
        z-index:30;
    }
    /* Track for "on" state */
    .on-off-switch-track-on{
        background-color:#009966;
        border-color:#008844;
        position:absolute;
        z-index:10;
        overflow:hidden;
    }
    /* Track for "off" state */
    .on-off-switch-track-off{
        position:absolute;
        border-color:#CCC;
        z-index:1;
    }

    .on-off-switch-thumb{
        position:absolute;
        z-index:2;
        overflow:hidden;
    }

    .on-off-switch-thumb-shadow{
        opacity:0.5;
        border:1px solid #000;
        position:absolute;
    }

    .track-on-gradient, .track-off-gradient{

        background: -webkit-linear-gradient(180deg,rgba(0,0,0,0.2), rgba(0,0,0,0)); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(180deg, rgba(0,0,0,0.2), rgba(0,0,0,0)); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(180deg, rgba(0,0,0,0.2), rgba(0,0,0,0)); /* For Firefox 3.6 to 15 */
        background: linear-gradient(180deg, rgba(0,0,0,0.2), rgba(0,0,0,0)); /* Standard syntax */
        position:absolute;
        width:100%;
        height:5px;
    }


    .on-off-switch-thumb-color{
        background: -webkit-linear-gradient(45deg, #BBB, #FFF); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(45deg, #BBB, #FFF); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(45deg, #BBB, #FFF); /* For Firefox 3.6 to 15 */
        background: linear-gradient(45deg, #BBB, #FFF); /* Standard syntax */
        background-color:#F0F0F0;
        position:absolute;
    }

    .on-off-switch-thumb-off{
        border-color:#AAA;
        position:absolute;
    }
    .on-off-switch-thumb-on{
        border-color:#008855;
        z-index:10;
    }
    .on-off-switch-text{
        width:100%;
        position:absolute;
        font-family:arial;
        user-select:none;
        font-size:10px;
    }

    .on-off-switch-text-on{
        color:#FFF;
        text-align:left;
    }
    .on-off-switch-text-off{
        color:#000;
        text-align:right;
    }
    /* Mouse over thumb effect */
    .on-off-switch-thumb-over{
        background-color:#F5F5F5;
        background: -webkit-linear-gradient(45deg, #CCC, #FFF); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(45deg, #CCC, #FFF); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(45deg, #CCC, #FFF); /* For Firefox 3.6 to 15 */
        background: linear-gradient(45deg, #CCC, #FFF); /* Standard syntax */

    }
</style>