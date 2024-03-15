


<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">School Events</h4>
							  </div>		
							
						</div>
								
		<div class="col-sm-12">
		  
					
					 <?php if ($events): ?>              
							<div class="table-responsive">											
	 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">

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
													 <a href="#" data-toggle="modal" data-target="#view_event_<?php echo $p->id?>" class="pull-right btn btn-sm btn-outline-info">
															<span class="fa fa-folder-open"></span>&nbsp;  View 
														</a>
								
													</td>


												</tr>
												
										
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
														   <div class="col-md-12"><?php echo $p->description; ?></div>
														</div>
														
														
														<hr>
														<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Close</button>
														
													</div>
												</div>
											</div>
										</div>
	
	
							<?php endforeach ?>
									</tbody>

								</table>
							</div>
							
							<?php else: ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
					   <?php endif ?>
					   


			</div>
		</div>
    <p>&nbsp;</p>

</div>
</div>
</div>
