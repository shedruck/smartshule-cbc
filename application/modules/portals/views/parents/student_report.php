

		<div class="user-info card-body bg-white text-center ctm-border-radius grow">

                <?php
                if (isset($student) && !empty($student))
                {
                        ?>
                        <div class="row ">

                            <div class="col-md-12 center">
                                <div class="image" >
                                    <img  src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center" align="center" style="" width="100" height="100" />    
                                </div>
                                <h5><?php echo ucwords($this->school->school); ?> 
								
							
									 <p>
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
									</p>
									
								</h5>

                            </div>

                            <?php
                            $stream = $this->ion_auth->get_stream();
                            ?>	
                            <div class="clearfix"></div>

                        </div>
					
                            <div class="col-md-12">
							<hr>
						    <h4 class="center"><?php echo ucwords($student->first_name . ' ' .$student->middle_name . ' ' . $student->last_name); ?> Full Report 
							<br> <small>Produced On: <?php echo date('d M Y H:i')?> </small></h4>
							<hr>
						   </div>
						
                            <div class="row">
							     
								 <div class="col-md-3">
								 
								  <div class="image" >
                                    <?php
                                    if (!empty($student->photo)):
                                            if ($passport)
                                            {
                                                    ?> 
                                                    <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100%" height="100%" class="img-polaroid" style="align:left">
                                            <?php } ?>	

                                    <?php else: ?>   
                                            <?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100%; height:100%; align:left")); ?>
                                    <?php endif; ?>      
                                </div>
								
								 <h5> 
										<abbr><b>ADM NO.</b> <?php
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
										<br>
										<hr>
										<abbr><b>UPI NO.</b> <?php echo $student->upi_number;?></abbr></h5>
								
                                   
                                 </div>
								 
								 
                                <div class="col-md-3">
                                    <h4>Student Details</h4>
									<hr>
                                    <?php
                                    $class = $this->ion_auth->list_classes();
                                    $stream = $this->ion_auth->get_stream();

                                    $u = $this->ion_auth->get_user($student->created_by);
                                    ?>
                                    <table class="">
										<tr><th>Birthday:</th><td> <?php echo $student->dob > 10000 ? date('d M Y', $student->dob) : ''; ?></td></tr>
									
										<tr><th> Gender:</th><td> <?php
										if ($student->gender == 1)
												echo 'Male';
										elseif($student->gender == 2)
												echo 'Female';
										else echo $student->gender;
										?></td></tr>
									   
										
										 <tr><th>Special Need:</th><td> <?php echo $student->disabled ?></td></tr>
										 <tr><th>Blood Grp:</th><td> <?php echo $student->blood_group ?></td></tr>
										 <tr><th> Phone:</th><td><?php echo $student->student_phone ?></td></tr>
										 <tr><th>Status:</th><td> <?php echo $student->student_status ?></td></tr>
										 
										 <tr><th>Citizenship:</th><td> <?php $cc = $this->ion_auth->populate('countries','id','name'); echo isset($cc[$student->citizenship]) ? $cc[$student->citizenship]:''; ?></td></tr>
										<tr><th>County:</th><td> <?php $hc = $this->ion_auth->populate('counties','id','name'); echo isset($hc[$student->county]) ? $hc[$student->county]:''; ?></td></tr>
										 <tr><th>Subcounty:</th><td> <?php $sb = $this->ion_auth->populate('subcounties','id','subcounty'); echo $sb[$student->sub_county] ?></td></tr>
										  <tr><th>Residence</th><td>  <?php echo $student->residence; ?></td></tr>
										
                                       									
									</table>

                                </div>

                              
								
								<div class="col-md-3">
								
								    <h4>Other Details</h4> 
                                  <hr>
									 <table class="">	
									     <tr><th>Religion:</th><td><?php echo $student->religion; ?></td></tr>
                                        <tr><th>Allergies/Needs:</th><td> <?php echo $student->allergies; ?></td></tr>
										
										 <tr><th>Former School:</th><td> <?php echo $student->former_school; ?></td></tr>
										 <tr><th>Entry Marks:</th><td> <?php echo $student->entry_marks; ?></td></tr>
										
										 <tr><th>Doctor:</th><td> <?php echo $student->doctor_name; ?></td></tr>
										 <tr><th>Dr. Phone:</th><td> <?php echo $student->doctor_phone; ?></td></tr>
										
										 <tr><th>Scholarship:</th><td><?php echo $student->scholarship; ?></td></tr>
										 <?php if($student->scholarship=='Yes'){ ?>
										 <tr><th>Scholarship Type:</th><td> <?php echo $student->scholarship_type; ?></td></tr>
										 <tr><th>Sponsor Details:</th><td> <?php echo $student->sponsor_details; ?></td></tr>
										 <?php } ?>
									</table>
                   
                                </div>
								
								  <div class="col-md-3">
                                      <h4>Admission Details</h4>
									  <hr>
												<?php
												$class = $this->ion_auth->list_classes();
												$stream = $this->ion_auth->get_stream();

												$u = $this->ion_auth->get_user($student->created_by);
												?>
												
											  <table class="">
												 <tr><th>Level:</th><td>
												
												<?php
													$cls = isset($class[$cl->class]) ? $class[$cl->class] : ' -';
													$strm = isset($stream[$cl->stream]) ? $stream[$cl->stream] : ' -';
													echo $cls . ' ' . $strm;
													?>
													
													</td></tr>

												 <tr><th><strong>Emergency Phone:</th><td> <?php echo $student->emergency_phone; ?></td></tr>
												
												 <tr><th><strong>Scholar:</th><td> <?php echo $student->boarding_day; ?></td></tr>
												 <tr><th>House:</b> <?php
													$hse = $this->ion_auth->list_house();
													if ($student->house && isset($hse[$student->house]))
													{
															echo $hse[$student->house];
													}
													?>  
												</td></tr>
												 <tr><th><strong>Admitted By:</th><td> <?php echo $u->first_name . ' ' . $u->last_name; ?></td></tr>
												 <tr><th><strong>Admitted On:</th><td> <?php echo $student->admission_date > 10000 ? date('d M Y', $student->admission_date) : ' - '; ?></td></tr>
												  <tr><th>
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
													</td></tr>
												</table>	
													
												<h4>Class Attendance</h4>
												<hr>
												<table >
												   <tr><th><b>Days Present:</b> </th><td> <?php echo $days_present;?></td></tr>
												   <tr><th><b>Days Absent:</b> </th><td> <?php echo $days_absent;?></td></tr>
												</table>
												
                                </div>

                                
                            </div>
                            <!------------PARENTS DETAILS--------------------->
							
			</div>
			</div>
	
				 
	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block">Classes History</h4>
								</div>
				

                              <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                    <thead>
                                    <th width="3%">#</th>
                                    <th>Class</th>
                                    <!--<th>Stream</th>-->
                                    <th>Year</th>
                                    <th>Updated On </th>
                                    <th>Updated By </th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php
										  $classes = $this->portal_m->get_class_options();
                                        foreach ($class_history as $p):
										
										$usr = $this->ion_auth->get_user($p->created_by);
                                                $i++;
                                                ?>
                                                <tr>
                                                    <td><?php echo $i . '.'; ?></td>	
                                                    <td><?php echo isset($classes[$p->class]) ? $classes[$p->class] : '-'; ?></td>
                                                   <!-- <td><?php echo isset($stream_name[$p->stream]) ? $stream_name[$p->stream] : '-'; ?></td>-->
                                                    <td><?php echo $p->year; ?></td>
                                                    <td><?php echo date('d M Y',$p->created_on); ?></td>
                                                    <td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>
                                                </tr>
                                        <?php endforeach ?>
                                    </tbody>

                                </table>

                            </div>
                            </div>
                           </div>
                      </div>
					  
					  
	  <div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block">Favourites & Hobbies </h4>
								</div>
							        <?php if ($favourite_hobbies): ?>
											<div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
								 <thead>
											<th>#</th>
											
											<th>Level</th>
											
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
												
												?><br>
												<?php echo $p->year;?>
												</td>
												
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
                     </div>
                 </div>
                        <!--TAB2-->

                            <!------------Leadership HISTORY--------------------->
      <div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block">Leadership Positions</h4>
								</div>
				

                                      <?php if ($position): ?>         

                                       <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Position</th>	
                                            <th>Representing</th>	
                                            <th>Start Date</th>	
                                            <th>Date upto</th>
                                           <th>Elected On </th>
                                           <th>Recorded By </th>											
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($position as $p):
                                                        $i++;
                                                  	$usr = $this->ion_auth->get_user($p->created_by);
                                                       
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
                                                                        echo isset($classes[$p->student_class]) ? $classes[$p->student_class] : ' - ';
                                                                }
                                                                ?></td>
                                                            <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                                            <td width="30"><?php echo date('d/m/Y', $p->duration); ?></td>
															<td><?php echo date('d M Y',$p->created_on); ?></td>
                                                             <td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>
                                                        </tr>
                                                 <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>

                              <?php else: ?>
                                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                            <?php endif ?>

                            </div>
                         </div>
                      </div>
				 
	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block">Discipline</h4>
								</div>
                           

                     <?php if ($disciplinary): ?>              

                                     <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Reported on</th>
                                            <th>Reported By</th>
                                            <th>Reason</th>
                                            <th>Action Taken</th>
                                            <th>Taken On</th>
                                            <th>Comment</th> 
                                            <th>Recorded By</th> 
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($disciplinary as $p):
                                                        $i++;
                                                 	$usr = $this->ion_auth->get_user($p->created_by);
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
                                                                ?>
															</td>
                                                            <td><?php echo $p->description; ?></td>
                                                            <td>
                                                                <?php
                                                                if (isset($p->action_taken))
                                                                        echo $p->action_taken;
                                                                else
                                                                        echo '<i>Still Pending</i>';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if (isset($p->modified_on)) echo date('d/m/Y', $p->modified_on); ?>
                                                            </td>
                                                            <td>
                                                        <?php echo $p->comment; ?>
                                                            </td> 

                                                         <td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>
                                                         
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
        <?php else: ?>
                                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif ?>

                            </div>
                      </div>
                 </div>

                            <!------------Medical HISTORY--------------------->
                 	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block">Medical Records</h4>
								</div>

                                     <?php if ($medical): ?>              

                                       <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Date</th>
                                            <th>Sickness Reported</th>
                                            <th>Action Taken</th>
                                            <th>Comment</th>	
                                            <th>Recorded by</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($medical as $p):
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo date('d M Y', $p->date); ?></td>
                                                            <td><?php echo $p->sickness; ?></td>
                                                            <td><?php echo $p->action_taken; ?></td>
                                                            <td><?php echo $p->comment; ?></td>
                                                            <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
        <?php else: ?>
                                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif ?>

                            </div>
                            </div>
                            </div>

                           
						   
						   
                            <!------------Medical HISTORY--------------------->
							
			        	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block"> Extra Curricular Activities</h4>
								</div>
								
						
                           
                                     <?php if ($extra_c): ?>              

                                      <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Activity</th>
                                            <th>Term</th>
                                            <th>Year</th>
                                            <th>Recorded On</th>	
                                            <th>Recorded by</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
												$acts = $this->ion_auth->populate('activities','id','name');
                                                foreach ($extra_c as $p):
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo $acts[$p->activity]; ?></td>
                                                            <td><?php echo $p->term; ?></td>
                                                            <td><?php echo $p->year; ?></td>                                                            
															<td><?php echo date('d M Y', $p->created_on); ?></td>
                                                            <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
									<?php else: ?>
											<p class='text'><?php echo lang('web_no_elements'); ?></p>
									<?php endif ?>

                            </div>
                        </div>
                   </div>

                            <!------------Book Funds HISTORY--------------------->
                         	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block"> Library Book Status</h4>
								</div>
								
                            <?php if ($borrowed_books): ?>              

                                      <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Book</th>
                                            <th>Borrowed Date</th>
                                            <th>Status</th>
                                            <th>Remarks</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($borrowed_books as $p):
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo isset($lib_books[$p->book]) ? $lib_books[$p->book] : ''; ?></td>
                                                            <td><?php echo date('d/m/Y', $p->borrow_date); ?></td>
                                                            <td>
                                                                <?php
                                                                if ($p->status == 2)
                                                                {
                                                                        echo '<span style="color:green">Book Returned</span>';
                                                                }
                                                                elseif ($p->status == 1)
                                                                {
                                                                        echo '<span style="color:red">Not Returned</span>';
                                                                }
                                                                ?> </td>
                                                            <td><?php echo $p->remarks; ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
										<?php else: ?>
												<p class='text'><?php echo lang('web_no_elements'); ?></p>
										<?php endif ?>

                            </div>
                            </div>
                            </div>


							<!------------Book Funds HISTORY--------------------->
       	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block">  Book Funds Status</h4>
								</div>

                               
                            <?php if ($student_books): ?>              

                                    <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Book</th>
                                            <th>Borrowed Date</th>
                                            <th>Status</th>
                                            <th>Remarks</th>	
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($student_books as $p):
                                                        $i++;
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>	
                                                            <td><?php echo isset($books[$p->book]) ? $books[$p->book] : ''; ?></td>
                                                            <td><?php echo date('d/m/Y', $p->borrow_date); ?></td>
                                                            <td>
                                                                <?php
                                                                if ($p->status == 2)
                                                                {
                                                                        echo '<span style="color:green">Book Returned</span>';
                                                                }
                                                                elseif ($p->status == 1)
                                                                {
                                                                        echo '<span style="color:red">Not Returned</span>';
                                                                }
                                                                ?> </td>
                                                            <td><?php echo $p->remarks; ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
										<?php else: ?>
												<p class='text'><?php echo lang('web_no_elements'); ?></p>
										<?php endif ?>

                            </div>
                            </div>
                            </div>

                            <!------------PAYMENT HISTORY--------------------->
							
						       	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block"> Hostel Beds</h4>
								</div>	
				
                           

                               <?php if ($bed): ?>

                                       <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
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
                                                        //$cld = $this->ion_auth->list_school_calendar();
                                                        $i++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>					
                                                            <td><?php echo date('d M Y', $p->date_assigned); ?></td>
                                                            <td><?php echo $p->term; ?></td>
                                                            <td><?php echo $p->year; ?></td>
                                                            <td><?php echo $beds[$p->bed]; ?></td>
                                                            <td><?php echo $p->comment; ?></td>
                                                            <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
									<?php else: ?>
											<p class='text'>No Bed Assigned at the moment</p>
									<?php endif ?>
                            </div>
                            </div>
                            </div>

                     
							<!------------Certificated --------------------->
    	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block"> My Certificates</h4>
								</div>	
				

                                <?php if ($national_exams): ?>
                                      <h5> National Exams Certificates</h5>
                                       <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Type</th>
                                            <th>Serial No.</th>
                                            <th>Mean Grade</th>
                                            <th>Points</th>
                                            <th>Certificate</th>
                                            <th>Recorded On</th>
                                            <th>Added By</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($national_exams as $p):
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        $i++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>
                                                            <td><?php echo $p->certificate_type; ?></td>				
                                                            <td><?php echo $p->serial_number; ?></td>				
                                                            <td><?php echo $p->mean_grade; ?></td>				
                                                            <td><?php echo $p->points; ?></td>				
                                                            <td>
															<a target="_blank" class="btn bt-sm btn-primary" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' />  Download File</a>
															</td>				
                                                            <td><?php echo date('d M Y', $p->created_on); ?></td>				
                                                            <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
                                <?php endif ?>

                                <?php if ($other_certs): ?>
                                      <h5> Other Certificates</h5>
                                       <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Date Issued</th>
                                            <th>Title</th>
                                            <th>Serial No.</th>
                                            <th>Certificate</th>
                                            <th>Recorded On</th>
                                            <th>Added By</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($other_certs as $p):
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        $i++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>
                                                            <td><?php echo date('d M Y',$p->date); ?></td>				
                                                            <td><?php echo $p->title; ?></td>				
                                                            <td><?php echo $p->certificate_number; ?></td>						
                                                            <td>
															<a target="_blank" class="btn bt-sm btn-primary"  href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' />  Download File</a>
															</td>				
                                                            <td><?php echo date('d M Y', $p->created_on); ?></td>				
                                                            <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
                                <?php endif ?>
								
								
								
                            </div>
                            </div>
                            </div>
                            <!--- END FLUID--->
							
							       <!------------PAYMENT HISTORY--------------------->
                             	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">

                            <!------------Classes HISTORY--------------------->
                            <div class="col-md-12">
								
								<div class="card-header">
									<h4 class="card-title mb-0 d-inline-block">  Transport History</h4>
								</div>	
				

                                <?php if ($transport): ?>

                                       <div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
                                            <thead>
                                            <th width="3%">#</th>
                                            <th>Facility</th>
                                            <th>Added on</th>
                                            <th>Added By</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;

                                                foreach ($transport as $p):
                                                        $u = $this->ion_auth->get_user($p->created_by);
                                                        $i++;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i . '.'; ?></td>
                                                            <td><?php echo ucwords($transport_facility[$p->transport_facility]); ?></td>				
                                                            <td><?php echo date('d M Y', $p->created_on); ?></td>				
                                                            <td><?php echo ucwords($u->first_name . ' ' . $u->last_name); ?></td>
                                                        </tr>
                                        <?php endforeach ?>
                                            </tbody>

                                        </table>
                                        </div>
                                     <?php else: ?>
                                        <p class='text'>No Transport Facility assigned at the moment</p>
                                <?php endif ?>
                            </div>

							
							
                        </div>

                        <?php
                }else
                {
                        ?>
                        <h3>Please Select Student First</h3>

                            <?php echo form_open('admin/reports/student_report'); ?> 
                        <select name="student" class="select" tabindex="-1">
                            <option value="">Select Student</option>
                            <?php
                            $data = $this->ion_auth->students_full_details();
                            foreach ($data as $key => $value):
                                    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value ?></option>
                        <?php endforeach; ?>
                        </select>
                        <button class="btn btn-warning"  style="height:30px;" type="submit">View Reports</button>

        <?php echo form_close(); ?>
<?php } ?>


            </div>
            <div class="footer">
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
