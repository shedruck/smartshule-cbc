<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            Student Academic  Diary for: <?php echo $this->student->first_name.' '. $this->student->last_name; ?> 
			
			
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
					<a href="#academic" data-toggle="tab" aria-expanded="true">
						<span class="visible-xs"><i class="fa fa-home"></i></span>
						<span class="hidden-xs">Academic Diary</span>
					</a>
				</li>
				<li class="">
					<a href="#profile" data-toggle="tab" aria-expanded="false">
						<span class="visible-xs"><i class="fa fa-user"></i></span>
						<span class="hidden-xs">Extra Curricular Diary</span>
					</a>
				</li>
		     </ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="academic">
					
					  <div class="portlet-body">
						<?php if ($diary): ?>
							<div class="table-responsive">
								 <table id="datatable-buttons" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Date </th>
										  
											<th>Activity</th>
											<th width="24%">Teacher Comment</th>
											<th width="24%">Parent Comment</th>
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
												<td><?php echo $p->date_ > 10000 ? date('d M Y', $p->date_) : ' - '; ?></td>
											   
												<td><?php echo $p->activity; ?></td>
												<td><?php echo $p->teacher_comment; ?></td>
												<td><?php echo $p->parent_comment; ?></td>
												<td width='30'>
													<div class='btn-group'>
														<a href="#" class='btn btn-primary btn-sm' ><i class='fa  fa-eye'></i> View </a>
														
													</div>
												</td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
								
								<?php echo $links; ?>
								
							</div>

						<?php else: ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
						<?php endif ?>
					</div>
					
				</div>
				<div class="tab-pane " id="profile">
					 <div class="portlet-body">
            <?php if ($extra_diary): ?>
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date </th>
                              
                                <th>Activity</th>
                                <th width="24%">Teacher Comment</th>
                                <th width="24%">Parent Comment</th>
                                <th><?php echo lang('web_options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                          

                            foreach ($extra_diary as $p):
                                $i++;
                                
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>					
                                    <td><?php echo $p->date_ > 10000 ? date('d M Y', $p->date_) : ' - '; ?></td>
                                   
                                    <td><?php echo $p->activity; ?></td>
                                    <td><?php echo $p->teacher_comment; ?></td>
                                    <td><?php echo $p->parent_comment; ?></td>
                                    <td width='30'>
                                        <div class='btn-group'>
                                           <a href="#" class='btn btn-primary btn-sm' ><i class='fa  fa-eye'></i> View </a>
                                        </div>
                                    </td>
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
									
									
  
      
    </div>
</div>

