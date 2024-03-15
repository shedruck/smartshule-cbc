<?php

$students = array();
foreach ($this->parent->kids as $k)
{
        $usr = $this->admission_m->find($k->student_id);
       $students[$k->student_id] = strtoupper(trim($usr->first_name . ' ' . $usr->middle_name. ' ' . $usr->last_name));
}


?>

<div class="row card-group-row mb-lg-8pt">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-6">
									<h4 class="card-title mb-0 d-inline-block">
									<?php 
									 $usr = $this->admission_m->find($stud);
									echo strtoupper(trim($usr->first_name . ' ' . $usr->middle_name. ' ' . $usr->last_name));
									?>
									- Academics Diary </h4>
							  </div>		
							<div class="col-sm-6 ">
										<?php echo form_open(current_url()); ?>
									 <div class="form-group row">
										  <div class="col-md-8">
											<?php echo form_dropdown('student', array('' => 'Select Student') + $students, $this->input->post('student'), 'class="xsel form-control " placeholder="Select Student"'); ?>
										 </div>
										  <div class="col-md-4">
											<button type="submit" class="form-control btn btn-primary   text-white text-center">Submit</button>
											 </div>
										 
									</div>
									
									<?php echo form_close(); ?>
							</div>
						</div>
								
		<div class="col-sm-12">
		  

			<?php if ($diary || $ex_diary): ?>
		
			
                                <div class="card dashboard-area-tabs p-relative o-hidden mb-0">
                                    <div class="card-header p-0 nav">
                                        <div class="row no-gutters"
                                             role="tablist">
                                            <div class="col-auto">
                                                <a id="class-tab"  href="#class-tab-home"
                                                   data-toggle="tab"
                                                   role="tab"
                                                   aria-selected="true"
                                                   class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start active">
                                                    <span class="h2 mb-0 mr-3">1</span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="card-title">Class Diary</strong>
                                                        <small class="card-subtitle text-50">Click here to view</small>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="col-auto border-left border-right">
                                                <a  id="ex-tab" href="#ex-tab-home" 
                                                   data-toggle="tab"
                                                   role="tab"
                                                   aria-selected="false"
                                                   class="dashboard-area-tabs__tab card-body d-flex flex-row align-items-center justify-content-start">
                                                    <span class="h2 mb-0 mr-3">2</span>
                                                    <span class="flex d-flex flex-column">
                                                        <strong class="card-title">Extracurricular Diary</strong>
                                                        <small class="card-subtitle text-50">Click here to view</small>
                                                    </span>
                                                </a>
                                            </div>
										
                                        </div>
                                    </div>
			
			<div class="tab-content" id="v-pills-tabContent">
			<!-- Tab1-->
			<div class="tab-pane fade show active" id="class-tab-home" role="tabpanel" aria-labelledby="class-tab">
				<div class="employee-office-table">
			
									<?php if ($diary ): ?>
										<div class="table-responsive">
											   <table class="table mb-0 thead-border-top-0 table-nowrap">
												<thead>
													<tr>
														<th>#</th>
														<th>Activity</th>
														<th>Date</th>
														<th>Teacher Comment</th>
														<th>Parent Comment</th>	
														<th><?php echo lang('web_options'); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php
													
													$i = 0;
													
													foreach ($diary as $p):
															$i++;
															
															?>
															<tr>
																<td><?php echo $i . '.'; ?></td>					
																<td width="15%"><?php echo $p->activity; ?></td>
																<td width="5%">
																<?php echo $p->date_ > 10000 ? date('d/m/Y', $p->date_) : ' - '; ?>
																</td>
																<td width="35%">
																<?php echo $p->teacher_comment; ?>
																</td>																
																<td width="35%">
																<?php echo $p->parent_comment; ?>
																</td>
																
																<td width="10%" >
																<?php if($p->parent_comment){?>
																 <a  href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#post_paro_comment_<?php echo $p->id?>" class="pull-right">
																		<i>Update Comment </i>
																	</a>
																	<?php }else{ ?>
																	
																	  <a  href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#post_paro_comment_<?php echo $p->id?>" class="pull-right">
																		<i>Post Comment </i>
																	</a>
																	<?php } ?>
																</td>
																
															</tr>
															
																<!-- add office The Modal -->
													<div class="modal fade" id="post_paro_comment_<?php echo $p->id?>">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
															 <?php echo form_open(current_url()); ?>
																<!-- Modal body -->
																<div class="modal-body">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title mb-3 text-center">Post your comment</h4>
																	<hr>
																	<div class="row1">
																	<div class="form-group">
																	   <input name="student" value="<?php echo $stud;?>" style="display:none" hidden>
																	   <input name="item" value="<?php echo $p->id;?>" style="display:none" hidden>
																		<textarea name="parent_comment" placeholder="Comment here...." class="form-control"><?php echo $p->parent_comment; ?></textarea>
																		
																	  </div>
																	</div>

																	<hr>
																	<button type="submit" class="btn btn-primary text-white ctm-border-radius float-right ml-3" >Post Comment</button>
																	
																</div>
																<?php echo form_close(); ?>
															</div>
														</div>
													</div>
		
		
													<?php endforeach ?>
												</tbody>
											</table>
										</div>
								<?php else: ?>
									<?php if(isset($stud)){ ?>
										No post at the moment
									<?php } ?>	
								<?php endif ?>
							</div>
						</div>
						
					<div class="tab-pane fade show " id="ex-tab-home" role="tabpanel" aria-labelledby="ex-tab">
				        <div class="employee-office-table">
						
						    <?php if ($ex_diary ): ?>
							 <div class="table-responsive">
											   <table class="table mb-0 thead-border-top-0 table-nowrap">
												<thead>
													<tr>
														<th>#</th>
														<th>Activity</th>
														<th>Date</th>
														<th>Teacher Comment</th>
														<th>Parent Comment</th>	
														<th><?php echo lang('web_options'); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php
													
													$i = 0;
													$ct  = $this->ion_auth->populate('activities','id','name');
													foreach ($ex_diary as $p):
															$i++;
															
															?>
															<tr>
																<td><?php echo $i . '.'; ?></td>					
																<td width="15%"><?php echo $ct[$p->activity]; ?></td>
																<td width="5%">
																<?php echo $p->date_ > 10000 ? date('d/m/Y', $p->date_) : ' - '; ?>
																</td>
																<td width="35%">
																<?php echo $p->teacher_comment; ?>
																</td>
																
																<td width="35%">
																<?php echo $p->parent_comment; ?>
																</td>
																
																<td width="10%" >
																<?php if($p->parent_comment){?>
																 <a  href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#xpost_paro_comment_<?php echo $p->id?>" class="pull-right">
																		<i>Update Comment </i>
																	</a>
																	<?php }else{ ?>
																	
																	  <a  href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#xpost_paro_comment_<?php echo $p->id?>" class="pull-right">
																		<i>Post Comment </i>
																	</a>
																	<?php } ?>
																</td>
																
															</tr>
															
																<!-- add office The Modal -->
													<div class="modal fade" id="xpost_paro_comment_<?php echo $p->id?>">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
															 <?php echo form_open(current_url()); ?>
																<!-- Modal body -->
																<div class="modal-body">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title mb-3 text-center">Post your comment</h4>
																	<hr>
																	<div class="row1">
																	<div class="form-group">
																	   <input name="student" value="<?php echo $stud;?>" style="display:none" hidden>
																	   <input name="item" value="<?php echo $p->id;?>" style="display:none" hidden>
																		<textarea name="xparent_comment" placeholder="Comment here...." class="form-control"><?php echo $p->parent_comment; ?></textarea>
																		
																	  </div>
																	</div>

																	<hr>
																	<button type="submit" class="btn btn-primary text-white ctm-border-radius float-right ml-3" >Post Comment</button>
																	
																</div>
																<?php echo form_close(); ?>
															</div>
														</div>
													</div>
		
		
													<?php endforeach ?>
												</tbody>
											</table>
										</div>
										
										<?php else: ?>
									<?php if(isset($stud)){ ?>
										No post at the moment
									<?php } ?>	
								<?php endif ?>
							</div>
					
					
					</div>
					
				</div>
			</div>
					
						<?php else: ?>
						<?php if(isset($stud)){ ?>
							No post at the moment
						<?php } ?>	
					<?php endif ?>

					</div>
				</div>
		<p>&nbsp;</p>
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