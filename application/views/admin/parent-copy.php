

<div class="quicklink-sidebar-menu ctm-border-radius shadow-sm bg-white card grow">
									<div class="card-body">
										<div class="flex-row list-group list-group-horizontal-lg" id="v-pills-tab" role="tablist" aria-orientation="vertical">
											
											<a class=" active list-group-item" id="payments-tab" data-toggle="pill" href="#payments-tab-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Recent Payments</a>
											
											<a class="list-group-item" id="assignments-tab" data-toggle="pill" href="#assignments-tab-home" role="tab" aria-controls="v-pills-profile" aria-selected="false">Recent Assignments</a>
											
											<a class="list-group-item" id="sms-tab" data-toggle="pill" href="#sms-tab-home" role="tab" aria-controls="v-pills-profile" aria-selected="false">SMS Notifications</a>
											
										
											
											<a class="list-group-item" id="events-tab" data-toggle="pill" href="#events-tab-home" role="tab" aria-controls="v-pills-profile" aria-selected="false">Events Update</a>
											
											<a class="list-group-item" id="options-tab" data-toggle="pill" href="#options-tab-home" role="tab" aria-controls="v-pills-profile" aria-selected="false">Fee Payment Options</a>
											
										</div>
									</div>
								</div>
<div class="card shadow-sm ctm-border-radius grow">

<div class="card-body align-center">
		<div class="tab-content" id="v-pills-tabContent">
		
			<!-- Tab1-->
			<div class="tab-pane fade show active" id="payments-tab-home" role="tabpanel" aria-labelledby="payments-tab">
				<div class="employee-office-table">
				<div class="card-header d-flex align-items-center justify-content-between">
						<h4 class="card-title mb-0 d-inline-block">Recent Payments</h4>
					
					</div>
					<div class="table-responsive">
					
							<table class="table bordered custom-table table-hover">
							<thead>
								<tr>
									<th>Date</th>
									<th>Student</th>
									<th>Amount</th>
									<th>Bank</th>
									<th>Reference</th>
									<th>Type</th>
									<th>Details</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$j = count($this->parent->kids);
								$i=0;
								
								$banks = $this->ion_auth->populate('bank_accounts','id','bank_name');
								$fee = $this->ion_auth->populate('fee_extras','id','title');
							
						
								
							foreach($rec as $re){
								
								foreach($re as $p){
									
									$st = $this->portal_m->find($p->reg_no);
									
									if($i==8) break;
								
								?>
								<tr>
									<td><?php echo date('d M Y',$p->payment_date);?></td>
									<td>
										<?php echo $st->first_name.' '.$st->last_name;?>
									</td>
									<td><?php echo $p->amount;?></td>
									<td><?php echo $banks[$p->bank_id];?></td>
									<td><?php echo $p->transaction_no;?></td>
									<td><?php echo $p->payment_method;?></td>
									<td><?php 
									if($p->description==0) echo 'Tuition Fee';
									else  echo $fee[$p->description];?></td>
									
									
									<td>
										<div class="table-action">
											<a href="<?php echo base_url('fee_payment/receipt/'.$p->receipt_id)?>" class="btn btn-sm btn-outline-success">
												<span class="fa fa-folder-open"></span> View Receipt
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
			</div>
			<!--/Tab 1-->
			
			<!-- Tab2-->
			<div class="tab-pane fade" id="assignments-tab-home" role="tabpanel" aria-labelledby="assignments-tab">
				<div class="employee-office-table">
					<div class="table-responsive">
							<div class="card-header d-flex align-items-center justify-content-between">
									<h4 class="card-title mb-0 d-inline-block">Posted Assignment</h4>
								</div>
							<div class="col-sm-12">
								
								<?php if (count($assign)): ?>
										<div class="block-fluid">
											<table cellpadding="0" cellspacing="0" width="100%" class="bordered" style="">
												<thead>
													<tr>
														<th>#</th>
														<th>Title</th>
														<th>Start Date</th>
														<th>Due Date</th>
														<th>Assignment</th>	
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
															//if($i==8) break
															?>
															<tr>
																<td><?php echo $i . '.'; ?></td>					
																<td><?php echo $p->title; ?></td>
																<td>
																<?php echo $p->start_date > 10000 ? date('d M Y', $p->start_date) : ' - '; ?>
																</td>
																
																<td>
																<?php echo $p->end_date > 10000 ? date('d M Y', $p->end_date) : ' - '; ?>
																</td>
																
																<td >
																<?php echo substr($p->assignment, 0, $len) . $suff; ?></td>
																
																<td >
																 <a href="<?php echo site_url('assignments/view/' . $p->id); ?>" class="btn btn-sm btn-outline-success">
																		<span class="fa fa-folder-open"></span> View Details
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
				</div>
			</div>
			<!-- /Tab 2 -->
			
			<!-- Tab3-->
			<div class="tab-pane fade" id="sms-tab-home" role="tabpanel" aria-labelledby="sms-tab">
				<div class="employee-office-table">
					<div class="table-responsive">
					
						  <div class="widget">                    
								 <div class="card-header d-flex align-items-center justify-content-between">
									<h4 class="card-title mb-0 d-inline-block">Messages</h4>
								</div>                                               
							  <div class="block-fluid">
									<?php if ($sms): ?>

											<table class="table bordered" cellpadding="0" cellspacing="0">
												<thead>
													<tr>
														
														<th >Date/Time</th>
														<th>Source - Dest</th>

														<th width="40%"  >Message</th>
														
													</tr>
												</thead>
												<tbody>
													<?php
													$i = 1;
													foreach ($sms as $sms_m): 
													 if($i==8) break;
															//$user = $this->ion_auth->get_user($sms_m->created_by)
															?>
															<tr class="new">
																<td><?php echo time_ago($sms_m->created_on); ?></td>
																
																<td><?php echo $sms_m->source.' - '.$sms_m->dest; ?></td>
																<td width="40%"><?php echo substr($sms_m->relay,0,30); ?>...
																 <a  href="#" data-toggle="modal" data-target="#view_sms_<?php echo $sms_m->id?>" class="pull-right">
																		<i>Read More <span class="fa fa-caret-right"></span></i>
																	</a>
																</td>
																
															</tr>
															<?php
															$i++;
													endforeach
													?>                                                                       
												</tbody>
											</table>
											<div class="toolbar bottom">

											</div>
									<?php else: ?>
											<p class='text'><?php echo lang('web_no_elements'); ?></p>
									<?php endif ?> 
								</div>
								
								
								<?php foreach ($sms as $p):?>	
	
								<!-- add office The Modal -->
							<div class="modal fade " id="view_sms_<?php echo $p->id?>">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
									
										<!-- Modal body -->
										<div class="modal-body">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title mb-3 text-center">SMS DETAILS</h4>
											<hr>
											<div class="row">
												
												
											   <div class="col-md-12"><?php echo wordwrap($p->relay,55,'<br>'); ?></div>
											</div>

											<hr>
											<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Close</button>
											
										</div>
									</div>
								</div>
							</div>
						
							<?php endforeach ?>

							</div>

					</div>
				</div>
			</div>
			<!-- /Tab 3-->
			

			<!-- Tab4-->
			<div class="tab-pane fade" id="events-tab-home" role="tabpanel" aria-labelledby="events-tab">
				<div class="employee-office-table">
					<div class="table-responsive">
					
					 <?php if ($events): ?>              
							<div class="block-fluid">

								<table class="table bordered" cellpadding="0" cellspacing="0" width="100%">

									<thead> 
									<th>#</th>
									<th>Title</th>
									<th>Date From</th>
									<th>Date To</th>
									<th>Venue</th>
									<th>Description</th>
									<th></th>
									</thead>
									<tbody>
										<?php
										$i = 0;
										if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
										{
												$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
										}

										foreach ($events as $p):

												$i++;
												?>
												<tr>
													<td><?php echo $i . '.'; ?></td>					
													<td><?php echo $p->title; ?></td>
													<td><?php echo date('d/m/Y', $p->start_date); ?></td>
													<td><?php echo date('d/m/Y', $p->end_date); ?></td>
													<td><?php echo $p->venue; ?></td>
													<td><?php echo substr($p->description, 0, 30) . '...'; ?></td>
													<td >
													 <a href="#" data-toggle="modal" data-target="#view_event_<?php echo $p->id?>" class="btn btn-sm btn-outline-success">
															<span class="fa fa-folder-open"></span> View Details
														</a>
								
													</td>


												</tr>
												
										
										
							<?php endforeach ?>
									</tbody>

								</table>
							</div>
							
							<?php else: ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
					   <?php endif ?>
					   
					   
					   <?php foreach ($events as $p):?>	
	
			<!-- add office The Modal -->
										<div class="modal fade" id="view_event_<?php echo $p->id?>">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
												
													<!-- Modal body -->
													<div class="modal-body">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title mb-3 text-center">EVENT DETAILS</h4>
														<hr>
														<div class="row">
															<div class="col-md-3 "><strong class="pull-right">TITLE:</strong></div>
															<div class="col-md-9"><?php echo $p->title; ?></div>
															
															<div class="col-md-3 "><strong class="pull-right">STARTS:</strong></div>
															<div class="col-md-9"><?php echo date('d/m/Y', $p->start_date); ?></div>
															
															<div class="col-md-3 "><strong class="pull-right">ENDS:</strong></div>
															<div class="col-md-9"><?php echo date('d/m/Y', $p->end_date); ?></div>
															
															<div class="col-md-3 "><strong class="pull-right">VENUE:</strong></div>
															<div class="col-md-9"><?php echo $p->venue; ?></div>
															
															<div class="col-md-12">DESCRIPTION</div>
														   <div class="col-md-12"><?php echo wordwrap($p->description, 70, "<br />\n"); ?></div>
														   
														</div>
														
														
														<hr>
														<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Close</button>
														
													</div>
												</div>
											</div>
										</div>
	
		                     <?php endforeach ?>

					</div>
				</div>
			</div>
			<!-- /Tab 4-->
			
			<!-- Tab2-->
			<div class="tab-pane fade show " id="options-tab-home" role="tabpanel" aria-labelledby="options-tab">
				<div class="employee-office-table">
				<div class="card-header d-flex align-items-center justify-content-between">
						<h4 class="card-title mb-0 d-inline-block">Fee Payment Options</h4>
					
					</div>
					<div class="table-responsive">
					
					     <?php
                                if ($banks_acc)
                                {
                                        ?>
                                      
                                       <table class="table bordered custom-table table-hover">
                                            <tr >
                                                <th  width="3%">#</th>
                                                <th >Bank Name</th>
                                                <th >Account Name</th>
                                                <th>Branch</th>
                                                <th >Account No.</th>
                                                <th >Description.</th>
                                            </tr>
                                            <?php
                                            $i = 0;
                                            foreach ($banks_acc as $b)
                                            {
                                                    $i++;
                                                    ?>
                                                    <tr >
                                                        <td style=""><?php echo $i; ?></td>
                                                        <td style=""><?php echo $b->bank_name ?></td>
                                                        <td ><?php echo $b->account_name ?></td>
                                                        <td ><?php echo $b->branch ?></td>
                                                        <td ><?php echo $b->account_number ?></td>
                                                        <td ><?php echo $b->description ?></td>
                                                    </tr>
                                            <?php } ?>
                                    <?php } ?>
									
					</div>
				</div>
			</div>
			<!--/Tab 2-->
			
		</div>
	</div>
						
	</div>
	

		
		