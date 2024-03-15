


<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">SMS Messages</h4>
							  </div>		
							
						</div>
								
		<div class="col-sm-12">
		  
					
					<div class="table-responsive">
									<?php if ($sms): ?>

											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 ">
												<thead>
													<tr>
														
														<th >Date/Time</th>
														<th>Source - Dest</th>

														<th width=""  >Message</th>
														
													</tr>
												</thead>
												<tbody>
													<?php
													$i = 1;
													foreach ($sms as $sms_m): 
													
															?>
															<tr class="new">
																<td><?php echo time_ago($sms_m->created_on); ?></td>
																
																<td><?php echo $sms_m->source.' - '.$sms_m->dest; ?></td>
																<td width=""><?php echo $sms_m->relay; ?>...
																 
																</td>
																
															</tr>
															
																<!-- add office The Modal -->
															<div class="modal fade" id="view_sms_<?php echo $sms_m->id?>">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																	
																		<!-- Modal body -->
																		<div class="modal-body">
																			<button type="button" class="close" data-dismiss="modal">&times;</button>
																			<h4 class="modal-title mb-3 text-center">SMS DETAILS</h4>
																			<hr>
																			<div class="row">
																				
																				
																			   <div class="col-md-12"><?php echo $sms_m->relay; ?></div>
																			</div>

																			<hr>
																			<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Close</button>
																			
																		</div>
																	</div>
																</div>
															</div>

															<?php
															$i++;
													endforeach
													?>                                                                       
												</tbody>
											</table>
											
									<?php else: ?>
											<p class='text'><?php echo lang('web_no_elements'); ?></p>
									<?php endif ?> 
								</div>


			</div>
		</div>
    <p>&nbsp;</p>

</div>
</div>
</div>








<style>
    table.calendar{ border-left:1px solid #999;     width: 100%;}
    table.calendar   td.calendar-day-head
    { 
        font-weight:bold; text-align:center; width:14.3%;  
        text-transform: uppercase;
        font-size: 12px;
        padding-top: 20px;
        color: rgba(255,255,255,0.2);
    }
    /* shared */
    table.calendar  td.calendar-day, td.calendar-day-np {  padding:5px; }
</style>