<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           Subjects / Learning Areas
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
        <hr>
    </div>
	  <div class="content">
	  <div class="row">
	  <div class="col-sm-12">
	  
	       <ul class="nav nav-tabs">
				<li class="active">
					<a href="#cbc" data-toggle="tab" aria-expanded="true">
						<span class="visible-xs"><i class="fa fa-home"></i></span>
						<span class="hidden-xs">CBC Learning Areas</span>
					</a>
				</li>
				<li class="">
					<a href="#subjects" data-toggle="tab" aria-expanded="false">
						<span class="visible-xs"><i class="fa fa-user"></i></span>
						<span class="hidden-xs">Class Subjects</span>
					</a>
				</li>
		     </ul>
			 
			 	
                        				
			
			<div class="tab-content">
				<div class="tab-pane active" id="cbc">
					
					  <div class="portlet-body">
						
						<div class="custom-dd dd" id="nestable_list_1">
				
				<?php if ($cbc): ?>
				
				
								<ol class="dd-list">
									
									<?php
										$i = 0;
										$subs = $this->st_m->populate('cbc_subjects','id','name');
										//$strands = $this->st_m->populate('cbc_la','id','name');
										foreach ($cbc as $p):
											$i++;			
									?>
									<li class="dd-item" data-id="2">
										<div class="dd-handle bg-green">
											LEARNING AREA: --- <?php echo $subs[$p->subject_id]; ?>
										</div>
										
										
										<ol class="dd-list">
										<?php 
										$strnd = $this->st_m->get_strands($p->subject_id);
										foreach ($strnd as $str):
											$i++;	
										?>
											
											<li class="dd-item" data-id="5">
												<div class="dd-handle bg-black">
													STRAND: --- <?php echo $str->name?>
												</div>
												<ol class="dd-list">
												<?php 
													$sub_strnd = $this->st_m->get_sub_strands($str->id);
													foreach ($sub_strnd as $substr):
														$i++;	
													?>
													<li class="dd-item" data-id="6">
														<div class="dd-handle">
															<b class="text-red">Sub Strand:</b> ---	<?php echo $substr->name?>
															
														</div>
														
														<ol class="dd-list">
																<?php 
																	$topics = $this->st_m->get_cbc_topics($substr->id);
																	foreach ($topics as $tp):
																		$i++;	
																	?>
																	<li class="dd-item" data-id="6">
																		<div class="dd-handle">
																				<?php echo $tp->name?>
																		</div>
																	</li>
																	<?php endforeach ?>
																</ol>
												<hr>
													</li>
													<?php endforeach ?>
												</ol>
											</li>
											<?php endforeach ?>
										</ol>
										
									</li>
									
										<?php endforeach ?>

								</ol>
						
						<?php else: ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
						<?php endif ?>
												
											</div>
						
					</div>
					
				</div>
				
				
				<div class="tab-pane " id="subjects">
					 <div class="portlet-body">
            <?php 
			
			if ($subjects): 
			$subj = $this->st_m->populate('subjects','id','name');
			 foreach ($subjects as $p):
			?>
              <div class="col-sm-4">
			  <h3 class="portlet-title text-dark">
                  Term: <?php echo $p->term; ?>  </h3>
                <div class="table-responsive">
                    <table id="datatable-buttons1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
								<th>Subject </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
							$sb = $this->st_m->get_term_subjects($this->student->class,$p->term);
                            foreach ($sb as $s):
                                $i++;
                                ?>
								<tr>
                                <td><?php echo $i . '.'; ?></td>					
								<td><?php echo $subj[$s->subject_id]; ?></td>
												
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                </div>
 <?php endforeach ?>
 
            <?php else: ?>
                <p class='text'><?php echo lang('web_no_elements'); ?></p>
            <?php endif ?>
        </div>
				</div>
			   
			</div>
									
									
  
      
    </div>
</div>

