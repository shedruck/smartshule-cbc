	<!-- Tab2-->
	<div class="row" >
	
	<div class="col-sm-6" >
			 <div class="page-separator">
                            <div class="page-separator__text">Posted Assignments</div>
                        </div> 
								        <div class="card mb-32pt">
										
								<?php if (count($assign)): ?>
								
										       <div class="table-responsive"
                                 data-toggle="lists"
                                 data-lists-sort-by="js-lists-values-from"
                                 data-lists-sort-desc="true"
                                 data-lists-values='["js-lists-values-name", "js-lists-values-status", "js-lists-values-policy", "js-lists-values-reason", "js-lists-values-days", "js-lists-values-available", "js-lists-values-from", "js-lists-values-to"]'>

                                <table class="table mb-0 thead-border-top-0 table-nowrap">
												<thead>
													<tr>
														      <th style="width: 18px;"
																class="pr-0">
																<div class="custom-control custom-checkbox">
																	<input type="checkbox"
																		   class="custom-control-input js-toggle-check-all"
																		   data-target="#leaves"
																		   id="customCheckAll">
																	<label class="custom-control-label"
																		   for="customCheckAll"><span class="text-hide">Toggle all</span></label>
																</div>
															</th>
														<th>Title</th>
														<th>Start Date</th>
															
														<th><?php echo lang('web_options'); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php
													$i = 0;
													$len = 21;
													foreach ($assign as $p):
															$i++;
															$suff = '';
															if (strlen($p->assignment) > $len)
															{
																	$suff = '...';
															}
															if($i==5) break
															?>
															<tr>
																<td class="pr-0">
																	<div class="custom-control custom-checkbox">
																		<input type="checkbox"
																			   class="custom-control-input js-check-selected-row"
																			   id="customCheck1_1">
																		<label class="custom-control-label"
																			   for="customCheck1_1"><span class="text-hide">Check</span></label>
																	</div>
																</td>
																
																<td><?php echo substr($p->title,0,15); ?>...</td>
																<td>
																<?php echo $p->start_date > 10000 ? date('d M Y', $p->start_date) : ' - '; ?>
																</td>
																<td>
																
																
																 <a href="<?php echo site_url('assignments/view/' . $p->id); ?>" class="btn btn-sm btn-outline-primary">
																		<i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>&nbsp; View
																	</a>
											
																</td>
															</tr>
													<?php endforeach ?>
												</tbody>
											</table>
										</div>
								<?php else: ?>
										<p class='text'>No Assignments Available</p>
								<?php endif ?>
							</div>
							</div>


	 <div class="col-lg-6"> 
						 
						 <div class="page-separator">
                            <div class="page-separator__text">Academic Diary</div>
                        </div>
						      <div class="card">
                                            <div class="card-header">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex">
                                                        <strong>Today's Academics Diary</strong>
                                                    </div>
                                                    <i class="material-icons text-50">more_horiz</i>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert alert-soft-success mb-0 p-8pt">
                                                    <div class="d-flex align-items-start">
                                                        <div class="mr-8pt">
                                                            <i class="material-icons">card_giftcard</i>
                                                        </div>
                                                        <div class="flex">
														<?php $ct = count($this->parent->kids); ?>
                                                            <small class="text-100">Take a minute and walk through your <?php echo $ct == 1 ? "Child" : 'Children'; ?>'s Academic Diary posted by the teacher</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-group list-group-flush border-top">
											
											 <?php
 
													foreach ($this->parent->kids as $k)
													 {
														 $st = $this->portal_m->find($k->student_id);
												  ?>

                                                <div class="list-group-item p-16pt">
                                                    <div class="d-flex align-items-center"
                                                         style="white-space: nowrap;">

                                                        <div class="avatar avatar-32pt mr-8pt">
														
														   <?php
															if (!empty($st->photo)):
																 $passport = $this->portal_m->student_passport($st->photo);
																	if ($passport)
																	{
																			?> 
																			<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" class="avatar-img rounded-circle" width="" >
															 <?php } ?>	

															<?php else: ?>   
																	<?php echo theme_image("member.png", array('class' => "avatar-img rounded-circle", 'width' => "")); ?>
															<?php endif; ?> 
						


                                                        </div>

                                                        <div class="flex ml-4pt">
                                                            <div class="d-flex flex-column">
                                                                <p class="mb-0"><strong><?php echo $st->first_name.' '.substr($st->middle_name,0,1).' '.$st->last_name?></strong></p>
                                                                <span class="text-100">
																
																<?php
																		if (!empty($st->old_adm_no))
																		{
																				echo $st->old_adm_no;
																		}
																		else
																		{
																				echo $st->admission_number;
																		}
																  ?>
																</span>
                                                            </div>
                                                        </div>
                                                        <a href="<?php echo base_url('portals/parents/diary/'.$st->id)?>" class="btn btn-primary btn-sm"> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>&nbsp; View</a> 
                                                    </div>
                                                </div>
												
											<?php } ?>
                                               

                                            </div>
                                        </div>
                                        </div>
			
			
			            

		 <div class="col-lg-12">
			
			

                        <div class="row">
						
							<div class="col-sm-6" >
			 <div class="page-separator">
                            <div class="page-separator__text">Payment Receipts</div>
                        </div> 
								        <div class="card mb-32pt">
										
						<table class="table bordered custom-table table-hover">
							<thead>
								<tr>
								
															
									<th>Date</th>
									<th>Student</th>
									<th>Amount</th>
									
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$j = count($this->parent->kids);
								
								
								$banks = $this->ion_auth->populate('bank_accounts','id','bank_name');
								$fee = $this->ion_auth->populate('fee_extras','id','title');
							
						
								
							foreach($rec as $re){
								
								
								$i=0;
								foreach($re as $p){
									
									$st = $this->portal_m->find($p->reg_no);
									$i++;
									if($i==3) break;
								
								?>
								<tr>
								 
									<td><?php echo date('d M Y',$p->payment_date);?></td>
									<td>
										<?php echo $st->first_name.' '.$st->last_name;?>
									</td>
									<td><small></small><b><?php echo number_format($p->amount);?></b></td>

									<td>
										<div class="table-action">
											<a href="<?php echo base_url('fee_payment/receipt/'.$p->receipt_id)?>" class="btn btn-sm btn-primary">
												<span class="fa fa-print"></span>&nbsp; Print 
											</a>
										
										</div>
									</td>
								</tr>
							
							<?php } ?>
							<?php } ?>
							</tbody>
						</table>
						
				</div>
			</div>
			
			
						
										
                          
                            <div class="col-lg-6">
							
							
							<div class="page-separator">
								<div class="page-separator__text">Events Calendar </div>
							</div>
							
                                <div class="card mb-lg-0">
                                    <div class="card-body">
                                        <div class="form-group">
                                            
                                            <input id="flatpickrSample02" type="hidden" placeholder="School Events Calendar" data-toggle="flatpickr"  data-flatpickr-mode="range" data-flatpickr-inline="true" value="Demo">
                                        </div>
                                        <div class="alert alert-soft-warning mb-0 p-8pt">
                                            <div class="d-flex align-items-start">
                                                <div class="mr-8pt">
                                                    <i class="material-icons">error_outline</i>
                                                </div>
                                                <div class="flex">
                                                    <small class="text-100">On <strong><?php echo date('F d')?></strong>, Calendar of school events.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
						<div class="col-lg-12" style="display:none">	


	 <?php
							$attributes = array('class' => 'form-horizontal');
							echo form_open_multipart('messages/create', $attributes);
							$teachers = array();
							foreach ($this->parent->kids as $k)
							{
									$rw = $this->worker->get_student($k->student_id);

									$tch = $this->ion_auth->get_user($rw->cl->class_teacher);
									//$teachers[$rw->cl->class_teacher] = $tch->first_name . ' ' . $tch->last_name . ' (' . $rw->cl->name . ')';
									$teachers[$rw->cl->class_teacher] = 'Class Teacher (' . $rw->cl->name . ')';
							}
							?>
							
							 <div class="page-separator">
								<div class="page-separator__text">Send Message </div>
							</div>
                                <form >
								   <div class="form-group mb-24pt">
                                     
											    <?php echo form_input('title', '', 'id="title" class="form-control " placeholder="MESSAGE TITLE" '); ?>
                                        
                                    </div>
									
									
									
                                    <div class="form-group">
                                        <label for="leave_type"
                                               class="form-label">Send to</label>
										 <select  name="to" class="form-control  ">
												<option value="10000">Headteacher</option>
												<option value="10002">Front Office</option>
												<?php
												foreach ($teachers as $user_id => $name)
												{
														?>
														<option value="<?php echo $user_id ?>"> <?php echo $name; ?></option>
												<?php } ?>
											</select>
                                    </div>
                                    
									
									<div class="form-group mb-24pt">
                                    
                                       <textarea name="message" placeholder="Type Message Here....." class="summernote form-control" rows="4"></textarea>
                                    </div>

                                    <button type="submit"
                                            class="btn btn-accent">Submit Message</button>
                                  <?php echo form_close(); ?>
						</div>
						
							
							
							
                        </div>
                    </div>

			
			<!-- /Tab 2 -->
			
			</div>