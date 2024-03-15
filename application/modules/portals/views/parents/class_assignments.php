<?php

$students = array();
foreach ($this->parent->kids as $k)
{
        $usr = $this->admission_m->find($k->student_id);
        $students[$k->student_id] = strtoupper(trim($usr->first_name . ' ' . $usr->middle_name. ' ' . $usr->last_name));
}


?>



<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive">
							<div class="card-header d-flex align-items-center justify-content-between">
									<h4 class="card-title mb-0 d-inline-block">Posted Assignment</h4>
								</div>
							<div class="col-sm-12">
							   <h6>&nbsp;</h6>
							 <?php echo form_open(current_url()); ?>
								 <div class="form-group row">
									  <div class="col-md-4">
										<?php echo form_dropdown('student', array('' => 'Select Student') + $students, $this->input->post('student'), 'class="xsel form-control " placeholder="Select Student"'); ?>
									 </div>
									  <div class="col-md-3">
										<button type="submit" class="form-control btn btn-primary   text-white text-center">Submit</button>
										 </div>
									 
								</div>
								
								<br>
								<br>
								<?php echo form_close(); ?>
		
								<?php if (count($assign)): ?>
											<div class="table-responsive">
											   <table class="table mb-0 thead-border-top-0 table-nowrap">
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
									
								<?php endif ?>
							</div>

					</div>
				</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
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