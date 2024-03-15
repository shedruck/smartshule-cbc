<?php

$students = array();
foreach ($this->parent->kids as $k)
{
        $usr = $this->admission_m->find($k->student_id);
        $students[$k->student_id] = trim($usr->first_name . ' ' . $usr->last_name);
}


?>


<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">Messages & Feedback
									
									
									</h4>
									<div class="pull-right">
									 <a class="btn btn-success " href="<?php echo base_url('messages/create'); ?>"> 
											<i class="fa  fa-plus"></i>
											&nbsp;&nbsp; Start New Message
										</a>
										</div>
							  </div>		
							
						</div>
								
		<div class="col-sm-12">
		
		
		
					 <?php if ($messages): ?>              
							 <div class="table-responsive"
                                 data-toggle="lists"
                                 data-lists-sort-by="js-lists-values-from"
                                 data-lists-sort-desc="true"
                                 data-lists-values='["js-lists-values-name", "js-lists-values-status", "js-lists-values-policy", "js-lists-values-reason", "js-lists-values-days", "js-lists-values-available", "js-lists-values-from", "js-lists-values-to"]'>

								<table class="table bordered" cellpadding="0" cellspacing="0" width="100%">

									<thead> 
									<th>#</th>
									<th>Title</th>
									<th>Sent To</th>
									<th>Date Sent</th>
									<th>#</th>
								
									</thead>
									<tbody>
										<?php
										$i = 0;
										

										foreach ($messages as $m):

												$i++;
												?>
												<tr>
													<td><?php echo $i . '.'; ?></td>					
													<td> 
															<a href="<?php echo base_url('messages/view/' . $m->id); ?>">
															<p class="title"><?php echo $m->title; ?></p>
															</a>
													</td>
													<td> <?php echo $m->to; ?> </td>
													<td><?php echo date('d-m-Y h:i A', $m->last); ?></td>
													
													<td >
													 <a href="<?php echo base_url('messages/view/' . $m->id); ?>"  class="btn btn-sm btn-outline-primary">
															<span class="fa fa-folder-open"></span> &nbsp; View Details
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
					   <p>&nbsp;</p>
					   
	</div>
	</div>
	</div>
	</div>
	</div>







