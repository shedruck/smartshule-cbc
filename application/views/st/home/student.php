<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h4 class="m-b-12">My Profile </h4>
                            </div>
                            <div class="col-md-9">
                              
                                </div>
                            </div>
                        </div>
                    </div>
            
				<hr>
				
<div class="row">
<div class="col-md-12">
   <div class="block-fluid">
		  <?php $settings = $this->ion_auth->settings();?>
		  
  <div class="image text-center" >
			<img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" class="text-center" align="center" style="" width="120" height="120" />    
		</div>

                
				<h3 style="text-align: center;"><?php echo $settings->school;?></h3>
<ul style="text-align: center;">
<li><?php echo $settings->postal_addr;?></li>
</ul>
<p style="text-align: center;">Tel: <?php echo $settings->tel;?> <?php echo $settings->cell;?>&nbsp; &nbsp;&nbsp;&nbsp; Email: <?php echo $settings->email;?></p>

<h3 style="text-align: center;"><strong><u>STUDENT PROFILE</u></strong></h3>

<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr style="height: 47px;" class=" ">
						<td style="height: 382.188px;" rowspan="7" width="191" class="text-center img-area" >
							 <div class="image text-center img-area" >
                                    <?php
									if (!empty($student->photo)):
											if ($passport)
											{
													?> 
													<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>"  class="text-center" width="250" height="250" >
									 <?php } ?>	

									<?php else: ?>   
											<?php echo theme_image("thumb.png", array('class' => "text-center img-radius","width"=>"250","height"=>"250")); ?>
									<?php endif; ?>     
                                </div>
						</td>
						<td style="height: 41px;" colspan="4" width="544" class="title-bg">
								<h3 style="text-align: center;"><strong>ADMISSION PERSONAL DETAILS</strong></h3>
						</td>
				</tr>
				<tr style="height: 35.1875px;" class="profile-th">
						<td style="text-align: center; height: 35.1875px;" width="181">
								<p><strong>First Name</strong></p>
						</td>
						<td style="text-align: center; height: 35.1875px;" width="181">
								<p><strong>Middle name</strong></p>
						</td>
						<td style="text-align: center; height: 35.1875px;" colspan="2" width="181">
								<p><strong>Surname</strong></p>
						</td>
				</tr>
				
				<tr style="height: 35px;">
						<td style="text-align: center; height: 35px;" width="181">
								<p><?php echo ucwords($student->first_name); ?> </p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><?php echo ucwords($student->middle_name); ?> </p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p><?php echo ucwords($student->last_name); ?> </p>
						</td>
				</tr>
				
				<tr style="height: 41px;" class="profile-th">
						<td style="text-align: center; height: 41px;" width="181">
								<p><strong>Date of Birth</strong></p>
						</td>
						<td style="text-align: center; height: 41px;" width="181">
								<p><strong>Gender</strong></p>
						</td>
						<td style="text-align: center; height: 41px;" colspan="2" width="181">
								<p><strong>Blood Group</strong></p>
						</td>
				</tr>
		
				<tr style="height: 35px;">
						<td style="text-align: center; height: 35px;" width="181">
								<p><?php echo $student->dob > 10000 ? date('d M Y', $student->dob) : ''; ?></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p>
									  <?php
											if ($student->gender == 1)
													echo 'Male';
											elseif($student->gender == 2)
													echo 'Female';
											else echo $student->gender;
										?>
								</p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p><?php echo $student->blood_group ?></p>
						</td>
				</tr>
				
				<tr style="height: 41px;" class="profile-th">
						<td style="text-align: center; height: 41px;" width="181">
								<p><strong>Student Phone</strong></p>
						</td>
						<td style="text-align: center; height: 41px;" width="181">
								<p><strong>Emergency Phone</strong></p>
						</td>
						<td style="text-align: center; height: 41px;" width="181">
								<p><strong>Religion</strong></p>
						</td>
						<td style="text-align: center; height: 41px;" colspan="2" width="181">
								<p><strong>Disabled</strong></p>
						</td>
				</tr>
				
				<tr style="height: 35px;">
						<td style="text-align: center; height: 35px;" width="181">
								<p>
								<?php echo $student->student_phone ?>
								</p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p>
								<?php echo $student->emergency_phone; ?>
								</p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><?php echo $student->religion; ?></p>
						</td>
						<td style="text-align: center; height: 35px;" width="91">
								<p> <?php echo $student->disabled ?> </p>
						</td>
						
				</tr>
				
				<tr style="height: 43px;">
						<td style="text-align: center; height: 43px;" width="181" class="profile-th">
								<p><strong>Type of Disability</strong></p>
						</td>
						<td style="text-align: center; height: 43px;" colspan="4" width="363">
								<p>&nbsp;</p>
						</td>
				</tr>
				
				<tr style="height: 35px;" class="profile-th">
						<td style="text-align: center; height: 35px;" width="181">
						        <p><strong>Class</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><strong>Admission number</strong></p>
						</td>
						<td style="text-align: center; height: 35px;"  width="181">
								<p><strong>Date of Admission</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p><strong>Admitted By</strong></p>
						</td>
				</tr>
				
				<tr style="height: 35px;">
						<td style="text-align: center; height: 35px;" width="181" >
								<p>
								
												<?php
												   $class = $this->ion_auth->list_classes();
											    	$stream = $this->ion_auth->get_stream();
												
													$cls = isset($class[$cl->class]) ? $class[$cl->class] : ' -';
													$strm = isset($stream[$cl->stream]) ? $stream[$cl->stream] : ' -';
													echo $cls . ' ' . $strm;
													?>
								</p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p>
								  <?php
												if (!empty($student->old_adm_no))
												{
														echo $student->old_adm_no;
												}
												else
												{
														echo $student->admission_number;
												}
											?>
								</p>
						</td>
						<td style="text-align: center; height: 35px;"  width="181">
								<p><?php echo $student->admission_date > 10000 ? date('M, d, Y', $student->admission_date) : ' - '; ?></p>
						</td>
                       <td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p> 
								<?php 
								$u = $this->ion_auth->get_user($student->created_by);
								 echo $u->first_name . ' ' . $u->last_name;
								 ?>
								</p>
						</td>
				</tr>
				
				<tr style="height: 35px;" class="profile-th">
						<td style="height: 35px; text-align: center;" width="191">
								<p><strong>UPI Number</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><strong>House</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><strong>Clubs</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p><strong>Hostel</strong></p>
						</td>
				</tr>
		
				<tr style="height: 35px;">
						<td style="height: 35px; text-align: center;" width="191">
								<p><?php echo $student->upi_number;?></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p>
								<?php
									$hse = $this->ion_auth->list_house();
									if ($student->house && isset($hse[$student->house]))
									{
											echo $hse[$student->house];
									}
									?>  
								</p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p>&nbsp;</p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p>&nbsp;</p>
						</td>
				</tr>
				
				<tr style="height: 35px;" class="profile-th">
						<td style="height: 35px; text-align: center;" width="191">
								<p><strong>Former School</strong></p>
						</td>
						<td style="height: 35px; text-align: center;" width="191">
								<p><strong>Entry Marks</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><strong>Type of scholar</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2"  width="181">
								<p><strong>Residence</strong></p>
						</td>
						
				</tr>
				
				<tr style="height: 35px;">
						<td style="height: 35px; text-align: center;" width="191">
								<p> <?php echo $student->former_school; ?></p>
						</td>
						<td style="height: 35px; text-align: center;" width="191">
								<p><?php echo $student->entry_marks; ?></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p> <?php echo $student->boarding_day; ?></p>
						</td>
						
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p> <?php echo $student->residence; ?></p>
						</td>
				</tr>
				
				<tr style="height: 35px;" class="profile-th">
						<td style="height: 35px; text-align: center;" width="191">
								<p><strong>Citizen</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><strong>Home County</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><strong>Sub County</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p><strong>Ward</strong></p>
						</td>
				</tr>
		
				<tr style="height: 35px;">
						<td style="height: 35px; text-align: center;" width="191">
								<p>
								<?php $cc = $this->ion_auth->populate('countries','id','name'); echo isset($cc[$student->citizenship]) ? $cc[$student->citizenship]:''; ?>
								</p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><?php $hc = $this->ion_auth->populate('counties','id','name'); echo isset($hc[$student->county]) ? $hc[$student->county]:''; ?></p>
						</td>
						<td style="text-align: center; height: 35px;" width="181">
								<p><?php echo $student->sub_county ?></p>
						</td>
						<td style="text-align: center; height: 35px;" colspan="2" width="181">
								<p>&nbsp;</p>
						</td>
				</tr>
		</tbody>
</table>

<p style="text-align: left;">&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr>
						<td colspan="6" width="734" class="title-bg">
								<h3 style="text-align: center;"><strong>PREVIOUS SCHOOLS</strong></h3>
						</td>
				</tr>
				
				<tr class="profile-th">
						<td width="48">
								<p style="text-align: center;"><strong>No.</strong></p>
						</td>
						<td style="text-align: center;" width="326">
								<p><strong>Name of School (ECD - Nursery)</strong></p>
						</td>
						<td style="text-align: center;" width="90">
								<p><strong>County</strong></p>
						</td>
						<td style="text-align: center;" width="108">
								<p><strong>Year joined</strong></p>
						</td>
						<td style="text-align: center;" width="85">
								<p><strong>Year left</strong></p>
						</td>
						<td style="text-align: center;" width="78">
								<p><strong>Level</strong></p>
						</td>
				</tr>
				
				<tr>
						<td width="48">
								<p>&nbsp;</p>
						</td>
						<td width="326">
								<p>&nbsp;</p>
						</td>
						<td width="90">
								<p>&nbsp;</p>
						</td>
						<td width="108">
								<p>&nbsp;</p>
						</td>
						<td width="85">
								<p>&nbsp;</p>
						</td>
						<td width="78">
								<p>&nbsp;</p>
						</td>
				</tr>
		</tbody>
</table>

	<p>&nbsp;</p>
		<table style="width: 100%;" border="1" class="profile-table profile-text">
				<tbody>
						<tr>
								<td  colspan="4" class="title-bg">
								<h3 style="text-align: center;"><strong>MEDICAL REPORTS SUMMARY</strong></p>
								</td>
						</tr>
						<tr class="bg-blue profile-th">
								<td colspan="2" width="345" >
										<p><strong>Allergies</strong></p>
								</td>
								<td colspan="2" width="342">
										<p><strong>Known Existing Diseases</strong></p>
								</td>
						</tr>
						<tr>
								<td colspan="2" width="345">
										<p><?php echo $medical_report->allergies;?></p>
								</td>
								<td colspan="2" width="342">
										<p><?php echo $medical_report->existing_diseases;?></p>
								</td>
						</tr>
						
						<tr class="bg-blue profile-th">
								<td width="175">
										<p><strong>Tuberculosis</strong></p>
								</td>
								<td width="170">
										<p><strong>Malaria</strong></p>
								</td>
								<td width="170">
										<p><strong>Headaches</strong></p>
								</td>
								<td width="172">
										<p><strong>Common cold</strong></p>
								</td>
						</tr>
						<tr>
								<td width="175">
										<p><?php echo $medical_report->tuberculosis;?></p>
								</td>
								<td width="170">
										<p><?php echo $medical_report->malaria;?></p>
								</td>
								<td width="170">
										<p><?php echo $medical_report->headache;?></p>
								</td>
								<td width="172">
										<p><?php echo $medical_report->common_cold;?></p>
								</td>
						</tr>
						<tr class="bg-blue profile-th">
								<td width="175">
										<p><strong>Skin rashes</strong></p>
								</td>
								<td width="170">
										<p><strong>Anaemia</strong></p>
								</td>
								<td width="170">
										<p><strong>Asthma</strong></p>
								</td>
								<td width="172">
										<p><strong>Eye</strong></p>
								</td>
						</tr>
						<tr>
								<td width="175">
										<p><?php echo $medical_report->skin_rashes;?></p>
								</td>
								<td width="170">
										<p><?php echo $medical_report->anaemia;?></p>
								</td>
								<td width="170">
										<p><?php echo $medical_report->asthma;?></p>
								</td>
								<td width="172">
										<p><?php echo $medical_report->eye_problem;?></p>
								</td>
						</tr>
						<tr class="bg-blue profile-th">
								<td width="175">
										<p><strong>Known injuries</strong></p>
								</td>
								<td width="170">
										<p><strong>Heart</strong></p>
								</td>
								<td width="170">
										<p><strong>Kidney</strong></p>
								</td>
								<td width="172">
										<p><strong>Blood Group</strong></p>
								</td>
						</tr>
						<tr>
								<td width="175">
										<p><?php echo $medical_report->known_injuries;?></p>
								</td>
								<td width="170">
										<p><?php echo $medical_report->heart_problems;?></p>
								</td>
								<td width="170">
										<p><?php echo $medical_report->kidney;?></p>
								</td>
								<td width="172">
										<p><?php echo $student->blood_group;?></p>
								</td>
						</tr>
						<tr class="bg-blue profile-th">
								<td  width="345">
										<p><strong>Doctor's name</strong></p>
								</td>
								<td width="170">
										<p><strong>Mobile Number</strong></p>
								</td>
								<td width="172">
										<p><strong>Preferred Hospital</strong></p>
								</td>
								
								<td width="172">
										<p><strong>Remarks</strong></p>
								</td>
						</tr>
						<tr>
								<td width="345">
							
										<p><?php echo $student->doctor_name; ?></p>
								</td>
								<td width="170">
										<p><?php echo $student->doctor_phone; ?></p>
								</td>
								<td width="172">
										<p><?php echo $student->hospital; ?></p>
								</td>
								
								<td width="172">
										<p><?php echo $medical_report->comment;?></p>
								</td>
						</tr>
				</tbody>
		</table>
				<p>&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr>
						<td colspan="4" width="734" class="title-bg">
								<h3 style="text-align: center;"><strong>FATHER&rsquo;S CONTACTS</strong></h3>
						</td>
				</tr>
				<tr >
						<td rowspan="8" width="184" class="text-center img-area">
								<table>
										<tbody>
												<tr>
														<td width="181">
															
															<?php
															if (!empty($paro->father_photo)):
															$passport = $this->portal_m->parent_photo($paro->father_photo);
															  if ($passport)
																	{
																	?> 
																	<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="250" height="250"  class="text-center ">
															 <?php } ?>	

															<?php else: ?>   
																	<?php echo theme_image("member.png", array('class' => "text-center ", 'width' => "250", 'height'=>'250')); ?>
															<?php endif; ?> 
																					
																		
														&nbsp;
														</td>
												</tr>
										</tbody>
								</table>
						</td>
						
						<td style="text-align: center;" width="184" class="profile-th">
								<p><strong>First Name</strong></p>
						</td>
						<td style="text-align: center;" width="184" class="profile-th">
								<p><strong>Middle name</strong></p>
						</td>
						<td style="text-align: center;" width="184" class="profile-th">
								<p><strong>Surname</strong></p>
						</td>
				</tr>
				
				<tr>
						<td width="184">
								<p><?php echo isset($paro->f_title) ? $paro->f_title.'.' : '' ?> <?php echo ucwords($paro->first_name); ?></p>
						</td>
						<td width="184">
								<p><?php echo ucwords($paro->f_middle_name); ?></p>
						</td>
						<td width="184">
								<p><?php echo ucwords($paro->last_name); ?></p>
						</td>
				</tr>
				
				<tr class="profile-th">
						<td style="text-align: center;" width="184">
								<p><strong>Mobile number 1</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Mobile number 2</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Email address</strong></p>
						</td>
				</tr>
				
				<tr>
						<td style="text-align: center;" width="184">
								<p><?php echo $paro->phone ?></p>
						</td>
						<td style="text-align: center;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="text-align: center;" width="184">
								<p><?php echo substr($paro->email,0,50); ?></p>
						</td>
				</tr>
				
				
				<tr class="profile-th">
						<td style="text-align: center;" width="184">
								<p><strong>ID number</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Type of ID</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Occupation</strong></p>
						</td>
				</tr>
				
				<tr>
						<td style="text-align: center;" width="184">
								<p><?php echo $paro->f_id ?></p>
						</td>
						<td style="text-align: center;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="text-align: center;" width="184">
								<p><?php echo $paro->occupation ?></p>
						</td>
				</tr>
				
				
				<tr class="profile-th">
						<td style="text-align: center;" width="184">
								<p><strong>Place of work</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Work location</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Work telephone</strong></p>
						</td>
				</tr>
				
				
				<tr>
						<td style="text-align: center;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="text-align: center;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="text-align: center;" width="184">
								<p>&nbsp;</p>
						</td>
				</tr>
				
				<tr class="profile-th">
						<td style="text-align: center;" width="184">
								<p><strong>Relationship</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Address</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Residence</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Town</strong></p>
						</td>
				</tr>
				
				
				<tr>
						<td width="184">
								<p><?php echo $paro->f_relation ?></p>
						</td>
						<td width="184">
								<p><?php echo $paro->address ?> <?php echo $paro->f_postal_code ?></p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
				</tr>
		</tbody>
</table>

<p style="text-align: left;">&nbsp;</p>

<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr style="height: 56px;" class="title-bg">
						<td style="height: 56px;" colspan="4" width="734">
						<h3 style="text-align: center;"><strong>MOTHER&rsquo;S CONTACTS</strong></h3>
						</td>
				</tr>
				
				<tr style="height: 35px;">
						<td style="height: 298.188px;" rowspan="8" width="184">
								<table>
										<tbody>
												<tr>
														<td width="181">
																<table width="100%">
																		<tbody>
																				<tr class="text-center">
																						<td class="text-center img-area">
									
									<?php
									if (!empty($paro->mother_photo)):
									$mpp = $this->portal_m->parent_photo($paro->mother_photo);
									  if ($mpp)
											{
										?> 
										<image src="<?php echo base_url('uploads/' . $mpp->fpath . '/' . $mpp->filename); ?>" width="250" height="250" class="text-center" >
									 <?php } ?>	

									<?php else: ?>   
											<?php echo theme_image("member.png", array('class' => "text-center ", 'width' => "250", 'height' => "250")); ?>
									<?php endif; ?> 
																						</td>
																				</tr>
																				  <tr>
                                                        <td><b>Send SMS Mother <i class="fa fa-info-sign tip" title="Toggle to enable sending SMS to 2nd Parent/Guardian. First Parent will always receive SMS"></i></b></td>
                                                        <td>
                                                            <?php
                                                            $chk = '';
                                                            if (isset($paro->sms) && $paro->sms == 1)
                                                            {
                                                                    $chk = ' checked="checked" ';
                                                            }
                                                            ?>
                                                            <input type="checkbox" class="switchx" <?php echo $chk; ?>>
                                                        </td>
                                                    </tr>
																		</tbody>
																</table>
														&nbsp;
														</td>
												</tr>
										</tbody>
								</table>
						</td>
						
						<td style="height: 35px;" width="184" class="profile-th">
								<p style="text-align: center;"><strong>First Name</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="184" class="profile-th">
								<p><strong>Middle name</strong></p>
						</td>
						<td style="text-align: center; height: 35px;" width="184" class="profile-th">
								<p><strong>Surname</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 35px;">
						<td style="height: 35px;" width="184">
								<p><?php echo isset($paro->m_title) ? $paro->m_title.'.' : '' ?> <?php echo ucwords($paro->mother_fname); ?></p>
						</td>
						<td style="height: 35px;" width="184">
								<p><?php echo ucwords($paro->m_middle_name); ?></p>
						</td>
						<td style="height: 35px;" width="184">
								<p><?php echo ucwords($paro->mother_lname); ?></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 41px;" class="profile-th">
						<td style="height: 41px;" width="184">
								<p><strong>Mobile number 1</strong></p>
						</td>
						<td style="height: 41px;" width="184">
								<p><strong>Mobile number 2</strong></p>
						</td>
						<td style="height: 41px;" width="184">
								<p><strong>Email address</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 35px;">
						<td style="height: 35px;" width="184">
								<p><?php echo $paro->mother_phone ?></p>
						</td>
						<td style="height: 35px;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="height: 35px;" width="184">
								<p><?php echo substr($paro->mother_email,0,20).'..'; ?></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 41px;" class="profile-th">
						<td style="height: 41px;" width="184">
								<p><strong>ID number</strong></p>
						</td>
						<td style="height: 41px;" width="184">
								<p><strong>Type of ID</strong></p>
						</td>
						<td style="height: 41px;" width="184">
								<p><strong>Occupation</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 35px;">
						<td style="height: 35px;" width="184">
								<p><?php echo $paro->f_id ?></p>
						</td>
						<td style="height: 35px;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="height: 35px;" width="184">
								<p><?php echo $paro->mother_occupation; ?></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 41px;" class="profile-th">
						<td style="height: 41px;" width="184">
								<p><strong>Place of work</strong></p>
						</td>
						<td style="height: 41px;" width="184">
								<p><strong>Work location</strong></p>
						</td>
						<td style="height: 41px;" width="184">
								<p><strong>Work telephone</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 35.1875px;">
						<td style="height: 35.1875px;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="height: 35.1875px;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="height: 35.1875px;" width="184">
								<p>&nbsp;</p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 35px;" class="profile-th">
						<td style="height: 35px;" width="184">
								<p><strong>Relationship</strong></p>
						</td>
						<td style="height: 35px;" width="184">
								<p><strong>Address</strong></p>
						</td>
						<td style="height: 35px;" width="184">
								<p><strong>Residence</strong></p>
						</td>
						<td style="height: 35px;" width="184">
								<p><strong>Town</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center; height: 35px;">
						<td style="height: 35px;" width="184">
								<p><?php echo $paro->m_relation ?></p>
						</td>
						<td style="height: 35px;" width="184">
								<p><?php echo $paro->address ?></</p>
						</td>
						<td style="height: 35px;" width="184">
								<p>&nbsp;</p>
						</td>
						<td style="height: 35px;" width="184">
								<p>&nbsp;</p>
						</td>
				</tr>
				
		</tbody>
</table>


<p style="text-align: left;">&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr class="title-bg">
						<td colspan="4" width="734" >
						<h3 style="text-align: center;"><strong>EMERGENCY CONTACTS</strong></h3>
						</td>
				</tr>
				<tr >
						<td rowspan="8" width="184">
								<table>
										<tbody>
												<tr>
														<td width="182">
																<table width="100%">
																		<tbody>
																			<tr>
																				<td>&nbsp;</td>
																			</tr>
																		</tbody>
																</table>
														&nbsp;
														</td>
												</tr>
										</tbody>
								</table>
						</td>
						
						<td width="184" class="profile-th">
								<p style="text-align: center;"><strong>First Name</strong></p>
						</td>
						<td style="text-align: center;" width="184" class="profile-th">
								<p><strong>Middle name</strong></p>
						</td>
						<td style="text-align: center;" width="184" class="profile-th">
								<p><strong>Surname</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center;">
						<td width="184">
								<p><?php echo ucwords($em_cont->name); ?></p>
						</td>
						<td width="184">
								<p><?php echo ucwords($em_cont->middle_name); ?></p>
						</td>
						<td width="184">
								<p><?php echo ucwords($em_cont->last_name); ?></p>
						</td>
				</tr>
				
				<tr style="text-align: center;" class="profile-th">
						<td width="184">
								<p><strong>Mobile number 1</strong></p>
						</td>
						<td width="184">
								<p><strong>Mobile number 2</strong></p>
						</td>
						<td width="184">
								<p><strong>Email address</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center;">
						<td width="184">
								<p><?php echo $em_cont->phone ?></p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
						<td width="184">
								<p> <?php echo $em_cont->email ?></p>
						</td>
				</tr>
				
				<tr style="text-align: center;" class="profile-th">
						<td width="184">
								<p><strong>ID number</strong></p>
						</td>
						<td width="184">
								<p><strong>Type of ID</strong></p>
						</td>
						<td width="184">
								<p><strong>Occupation</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center;">
						<td width="184">
								<p><?php echo $em_cont->id_no ?></p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
				</tr>
				
				<tr style="text-align: center;" class="profile-th">
						<td width="184">
								<p><strong>Place of work</strong></p>
						</td>
						<td width="184">
								<p><strong>Work location</strong></p>
						</td>
						<td width="184">
								<p><strong>Work telephone</strong></p>
						</td>
				</tr>
				
				<tr style="text-align: center;">
						<td width="184">
								<p>&nbsp;</p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
				</tr>
				
				<tr class="profile-th">
						<td style="text-align: center;" width="184">
								<p><strong>Contact provided by</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Relationship</strong></p>
						</td>
						<td style="text-align: center;" width="184">
								<p><strong>Residence</strong></p>
						</td>
						<td width="184">
								<p style="text-align: center;"><strong>Address</strong></p>
						</td>
				</tr>
				
				<tr >
						<td width="184">
								<p style="text-align: center;"><?php echo $em_cont->provided_by ?></p>
						</td>
						<td width="184">
								<p style="text-align: center;"><?php echo $em_cont->relation ?></p>
						</td>
						<td width="184">
								<p>&nbsp;</p>
						</td>
						<td width="184">
								<p><?php echo $em_cont->address ?></p>
						</td>
				</tr>
				
		</tbody>
</table>
<p style="text-align: left;">&nbsp;</p>	

<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr class="title-bg">
						<td colspan="4" width="734">
						<h3 style="text-align: center;"><strong>SPONSORSHIP</strong></h3>
						</td>
				</tr>
				<tr class="profile-th">
						<td style="text-align: center;" width="214">
								<p><strong>Sponsor/Details</strong></p>
						</td>
						<td style="text-align: center;" width="220">
								<p><strong>Contact Person</strong></p>
						</td>
						<td style="text-align: center;" width="144">
								<p><strong>Mobile number</strong></p>
						</td>
						<td style="text-align: center;" width="157">
								<p><strong>Sponsorship type</strong></p>
						</td>
				</tr>
				
				<tr>
						<td width="214">
								<p> <?php echo $student->sponsor_details; ?></p>
						</td>
						<td width="220">
								<p><?php echo $student->sponsor_contact_person; ?></p>
						</td>
						<td width="144">
								<p><?php echo $student->sponsor_phone; ?></p>
						</td>
						<td width="157">
								<p><?php echo $student->scholarship_type; ?></p>
						</td>
				</tr>
				
				
		</tbody>
</table>

<p style="text-align: left;">&nbsp;</p>

<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr style="height: 56px;" class="title-bg">
						<td style="height: 56px;" colspan="6" width="734">
								<h3 style="text-align: center;"><strong>CLASSES AND PERFORMANCE HISTORY</strong></h3>
						</td>
				</tr>
				<tr style="height: 35.1875px;" class="profile-th">
						<td style="text-align: center; height: 35.1875px;" width="61">
								<p><strong>No</strong></p>
						</td>
						<td style="text-align: center; height: 35.1875px;" width="90">
								<p><strong>Year</strong></p>
						</td>
						<td style="text-align: center; height: 35.1875px;" width="102">
								<p><strong>Class</strong></p>
						</td>
						<td style="text-align: center; height: 35.1875px;" width="160">
								<p><strong>Position Term I</strong></p>
						</td>
						<td style="text-align: center; height: 35.1875px;" width="160">
								<p><strong>Position Term II</strong></p>
						</td>
						<td style="text-align: center; height: 35.1875px;" width="160">
								<p><strong>Position Term III</strong></p>
						</td>
				</tr>
				
				<?php $i = 0; ?>
                                        <?php
										  $classes = $this->ion_auth->fetch_classes();
                                        foreach ($class_history as $p):
										
										$usr = $this->ion_auth->get_user($p->created_by);
                                                $i++;
                                                ?>
				
							<tr style="height: 35px;">
									<td style="height: 35px;" width="61">
											<p>	<?php echo $i . '.'; ?></p>
									</td>
									<td style="height: 35px;" width="90">
											<p>	<?php echo $p->year; ?></p>
									</td>
									<td style="height: 35px;" width="102">
											<p>	<?php echo isset($classes[$p->class]) ? $classes[$p->class] : '-'; ?> </p>
									</td>
									<td style="height: 35px;" width="160">
											<p>	</p>
									</td>
									<td style="height: 35px;" width="160">
											<p>	</p>
									</td>
									<td style="height: 35px;" width="160">
											<p>	</p>
									</td>
							</tr>
				
				  <?php endforeach ?>
		</tbody>
</table>


<p style="text-align: left;">&nbsp;</p>
<p style="text-align: left;">&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr class="title-bg">
				<td colspan="6" width="734">
						<h3 style="text-align: center;"><strong>HOSTELS AND BEDS</strong></h3>
				</td>
				</tr>
				
				<tr class="profile-th">
						<td style="text-align: center;" width="61">
								<p><strong>No</strong></p>
						</td>
						<td style="text-align: center;" width="114">
								<p><strong>Date Assigned</strong></p>
						</td>
						
						<td style="text-align: center;" width="114">
								<p><strong>Year</strong></p>
						</td>
						<td style="text-align: center;" width="114">
								<p><strong>Term/Semester</strong></p>
						</td>
						<td style="text-align: center;" width="396">
								<p><strong>Hostel & Bed</strong></p>
						</td>
						
						<td style="text-align: center;" width="163">
								<p><strong>Remarks</strong></p>
						</td>
				</tr>
				
				 <?php
					$i = 0;
					foreach ($bed as $p):
							$u = $this->ion_auth->get_user($p->created_by);
							//$cld = $this->ion_auth->list_school_calendar();
							$i++;
				 ?>
				
				<tr>
						<td width="61">
								<p>	<?php echo $i . '.'; ?></p>
						</td>
						<td width="114">
								<p>	<?php echo date('d M Y', $p->date_assigned); ?> </p>
						</td>
						
						<td width="114">
								<p>	<?php echo $p->year; ?></p>
						</td>
						<td width="396">
								<p><?php echo $p->term; ?>	</p>
						</td>
						<td width="163">
								<p>	<?php echo $beds[$p->bed]; ?></p>
						</td>
						 <td><p><?php echo $p->comment; ?></p></td>
				</tr>
				
				   <?php endforeach ?>
		</tbody>
</table>


<p style="text-align: left;">&nbsp;</p>

<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr class="title-bg">
						<td style="width: 735px;" colspan="6">
						<h3 style="text-align: center;"><strong>CLUBS AND EXTRA CURRICULAR ACTIVITIES</strong></h3>
						</td>
				</tr>
				<tr class="profile-th">
						<td style="text-align: center; width: 51px;">
								<p><strong>No.</strong></p>
						</td>
						<td style="text-align: center; width: 84px;">
								<p><strong>Year</strong></p>
						</td>
						<td style="text-align: center; width: 125px;">
								<p><strong>Club Activity</strong></p>
						</td>
						<td style="text-align: center; width: 102px;">
								<p><strong>Position</strong></p>
						</td>
						<td style="text-align: center; width: 102px;">
								<p><strong>Term</strong></p>
						</td>
						<td style="text-align: center; width: 271px;">
								<p><strong>Achievements</strong></p>
						</td>
				</tr>
				
				  <?php
                                                $i = 0;
												$acts = $this->ion_auth->populate('activities','id','name');
                                                foreach ($extra_c as $p):
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
				
				<tr>
						<td style="width: 51px;">
								<p><?php echo $i . '.'; ?></p>
						</td>
						<td style="width: 84px;">
								<p><?php echo $p->year; ?></p>
						</td>
						<td style="width: 125px;">
								<p><?php echo $acts[$p->activity]; ?></p>
						</td>
						<td style="width: 102px;">
								<p></p>
						</td>
						<td style="width: 102px;">
								<p>Term <?php echo $p->term; ?></p>
						</td>
						<td style="width: 271px;">
								<p></p>
						</td>
				</tr>
				 <?php endforeach ?>
		</tbody>
</table>


<p style="text-align: left;">&nbsp;</p>

<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
		<tr class="title-bg">
				<td colspan="6" width="734">
					<h3 style="text-align: center;"><strong>DISCIPLINE</strong></h3>
				</td>
		</tr>
		<tr class="profile-th">
				<td  width="51">
						<p style="text-align: center;"><strong>No.</strong></p>
				</td>
				<td style="text-align: center;" width="79">
						<p><strong>Date</strong></p>
				</td>
				<td style="text-align: center;" width="98">
						<p><strong>Reported By</strong></p>
				</td>
				<td style="text-align: center;" width="256">
						<p><strong>Reported Disciplinary issue</strong></p>
				</td>
				<td width="250">
						<p style="text-align: center;"><strong>Action Taken</strong></p>
				</td>
		</tr>
		
		 <?php
			$i = 0;

			foreach ($disciplinary as $p):
					$i++;
				$usr = $this->ion_auth->get_user($p->created_by);
				 $user = $this->ion_auth->get_user($p->reported_by);
					?>
		
					<tr>
							<td width="49">
									<p><?php echo $i . '.'; ?></p>
							</td>
							<td  width="81">
									<p><?php echo date('d/m/Y', $p->date_reported); ?></p>
							</td>
							<td width="98">
									<p>
									  <?php
											if (!empty($p->reported_by))
											{
													echo $user->first_name . ' ' . $user->last_name;
											}
											else
											{
													echo $p->others;
											}
										?>
									</p>
							</td>
							<td width="256">
									<p><?php echo $p->description; ?></p>
							</td>
							<td width="250">
									<p> <?php
                                                                if (isset($p->action_taken))
                                                                        echo $p->action_taken;
                                                                else
                                                                        echo '<i>Still Pending</i>';
                                                                ?></p>
							</td>
					</tr>
		  <?php endforeach ?>
	
		</tbody>
</table>
<p style="text-align: left;">&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr class="title-bg">
						<td colspan="6" width="734">
								<h3 style="text-align: center;"><strong>SICKNESSES</strong></h3>
						</td>
				</tr>
				<tr class="profile-th">
						<td style="text-align: center;"  width="51">
								<p><strong>No.</strong></p>
						</td>
						<td style="text-align: center;" width="79">
								<p><strong>Date</strong></p>
						</td>
						
						<td style="text-align: center;" width="256">
								<p><strong>Reported Sickness</strong></p>
						</td>
						<td style="text-align: center;" width="250">
								<p><strong>Action Taken</strong></p>
						</td>
						<td style="text-align: center;" width="98">
								<p><strong>Remarks</strong></p>
						</td>
				</tr>
				
				 <?php
					$i = 0;

					foreach ($medical as $p):
							$i++;
							$u = $this->ion_auth->get_user($p->created_by);
				  ?>
				
				<tr>
						<td width="49">
								<p><?php echo $i . '.'; ?></p>
						</td>
						<td  width="81">
								<p><?php echo date('d M Y', $p->date); ?></p>
						</td>
					
						<td width="256">
								<p><?php echo $p->sickness; ?></p>
						</td>
						<td width="250">
								<p><?php echo $p->action_taken; ?></p>
						</td>
						<td width="250">
								<p><?php echo $p->comment; ?></p>
						</td>
				</tr>
            <?php endforeach ?>
		</tbody>

</table>

<p style="text-align: left;">&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr class="title-bg">
						<td colspan="6" width="734">
								<h3 style="text-align: center;"><strong>National Exams Certificates</strong></h3>
						</td>
				</tr>
				<tr class="profile-th">
						<td> <p><strong>No.</strong></p> </td>
						<td> <p><strong>Type</strong></p> </td>
						<td> <p><strong>Serial No.</strong></p> </td>
						<td> <p><strong>Mean Grade</strong></p> </td>
						<td> <p><strong>Points</strong></p> </td>
						<td> <p><strong>Download Certificate</strong></p> </td>
				</tr>
				
				  <?php
                                                $i = 0;

                                                foreach ($national_exams as $p):
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        $i++;
                                                        ?>
                                                        <tr>
                                                            <td><p><?php echo $i . '.'; ?></p> </td>
                                                            <td><a target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' /><p><?php echo $p->certificate_type; ?></p></a> </td>				
                                                            <td><p><a target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' /><?php echo $p->serial_number; ?></a></p> </td>				
                                                            <td>
															<a target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' /><p><?php echo $p->mean_grade; ?></p></a>

															</td>				
                                                            <td><a target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' /><p><?php echo $p->points; ?></p></a> </td>				
                                                            <td><p>
															<a target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' /> <i class="fa fa fa fa-download"></i> Download File</a>
															</p> 
															</td>				
                                                          
                                                        </tr>
                                        <?php endforeach ?>
		</tbody>
</table>


<p style="text-align: left;">&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr class="title-bg">
						<td colspan="6" width="734">
								<h3 style="text-align: center;"><strong>Other Certificates</strong></h3>
						</td>
				</tr>
				<tr class="profile-th">
						<td> <p><strong>No.</strong></p> </td>
						 <td> <p><strong>Date Issued</strong></p> </td>
						<td> <p><strong>Title</strong></p> </td>
						<td> <p><strong>Serial No.</strong></p> </td>
						<td> <p><strong>Certificate</strong></p> </td>
				</tr>
				
                  <?php
							$i = 0;

							foreach ($other_certs as $p):
									$u = $this->ion_auth->get_user($p->created_by);
									$i++;
									?>
									<tr>
										<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /><p><?php echo $i . '.'; ?></p> </a></td>
										<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /><p><?php echo date('d M Y',$p->date); ?></p> </a> </td>				
										<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /><p><?php echo $p->title; ?></p> </a> </td>				
										<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /><p><?php echo $p->certificate_number; ?></p> </a> </td>				
													
										<td><p>
										<a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /> <i class="fa fa fa fa-download"></i> Download File</a>
										</p> 
										</td>				
									  
									</tr>
					<?php endforeach ?>
		</tbody>
</table>

<p style="text-align: left;">&nbsp;</p>
<table style="width: 100%; float: left;" border="1" class="profile-text">
		<tbody>
				<tr style="height: 56px;" class="title-bg">
						<td style="height: 56px;" colspan="6" width="734">
								<h3 style="text-align: center;"><strong>CLEARANCE</strong></h3>
						</td>
				</tr>
				<tr class="profile-th">
						<td widtd="3%">#</td>
							<td ><p><strong>Department</strong></p></td>
							<td  ><p><strong>Date</strong></p></td>							
							<td ><p><strong>Clear</strong></p></td>
							<td ><p><strong>Charge</strong></p></td>
							<td ><p><strong>Comment</strong></p></td>
				</tr>
				
				
						<?php
										$i=0;
											$items = $this->ion_auth->populate('clearance_departments','id','name');
											foreach($clearance as $pp){
												//echo $pp->id;
												$i++;
										 ?>
										
										<tr style="height: 48px;">
                  
											   <td><p>
												  <p><?php echo $i;?></p>
												</td>
												
												  <td><p>
										         <?php echo $pp->department;?></p>
													</td>
													
													<td><p>
														<?php echo date('d M Y',$pp->date);?></p>
													</td>
													
												<td><p>
												<?php echo $pp->cleared;?></p>
													
												</td>
												
												<td><p>
												    <?php echo number_format($pp->charge,2);?></p>
													
												</td>
												
												<td><p>
												     <?php echo $pp->description;?></p>
													
												</td> 

											</tr>
											
											<?php } ?>
			
		</tbody>
</table>

<p style="text-align: left;"><br />&nbsp;</p>

<table style="width: 100%; float: left;">
		<tbody>
		<tr>
		<td width="734">
		<h3 style="text-align: center;"><strong>PRINCIPAL&rsquo;S REMARKS</strong></h3>
		</td>
		</tr>
		</tbody>
</table>

<p>The student has proved to be very dependable and can be trusted to perform difficult tasks without any supervision.</p>
<p>He has been a good Team Leader and a Team Player. I will not hesitate to recommend him for any position in any organization. The only problem he has is that he is always hungry.</p>
		

<p style="text-align: left;">&nbsp;</p>
<p style="text-align: center;"><strong>_________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; __________________________</strong></p>
<p style="text-align: center;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Principal&rsquo;s Signature</strong></p>

                 </div>
                 </div>
                 </div>
           </div>
       </div>
     </div>
<style>
    .fless{width:100%; border:0;}

    @media print{
        td.nob{  border:none !important; background-color:#fff !important;}
        .stt td, th {
            border: 1px solid #ccc;
        } 
        table tr{
            border:1px solid #666 !important;
        }
        table th{
            border:1px solid #666 !important;
        }
        table td{
            border:1px solid #666 !important;
        }	
        .highlight{
            background-color:#000 !important;
            color:#fff !important;
        }	
        image{
            width:150px  !important; 
            height:150px  !important; 
            
        }
		
		.col-md-2{
            width:150px  !important; 
            float:left  !important;
        }
		 .col-md-4{
            width:250px  !important; 
            float:left  !important;
        }
		
		.col-md-3{
            width:200px  !important; 
            float:left  !important;
        }
        .col-md-6{
            width:500px  !important; 
            float:left  !important;
        }
        .col-md-5{
            width:400px  !important; 
            float:left  !important;
        }
        .col-md-12{
            width:960px  !important; 
            float:left  !important;
        }
        .h4{
            border:none  !important; 	width:800px;
        }
        .h3{
            border:none  !important; 
            width:800px;
        }
        .h5{
            border:none  !important; 	width:800px;
        }

    }
</style>

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

  <script>
				$(document).ready(function(){
						
					$("#select_stud").change(function(e){
						
					var slug = $(".select_stud").val();
					
					//alert(slug);
					
					 window.location.href = "<?php echo base_url('admin/admission/view/');?>/" + slug;
				  
					  
					});
				});
					  
	</script>
				
