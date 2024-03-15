<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h4 class="m-b-12"><?php echo strtoupper($title)?> </h4>
                            </div>
                            <div class="col-md-9">
                              
                                </div>
                            </div>
                        </div>
                    </div>
            

							   <div class="col-lg-3 col-md-4 col-sm-6">
									<a href="<?php echo base_url('st/assignments')?>">
                               <div class="card-box widget-box-two widget-two-danger">
                                   <i class="mdi mdi-download widget-two-icon"></i>
                                    <div class="wigdet-one-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Total Users">Attachment Assignments</p>
                                        <h2><?php echo number_format($count_assignments)?> </h2>
                                        <p class="text-muted m-0"><b>View Records</b></p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->
							
							
							
							<div class="col-lg-3 col-md-6">
								<a href="<?php echo base_url('st/evideos')?>">
									<div class="card-box widget-box-two widget-two-success">
										<i class="mdi mdi-inbox widget-two-icon"></i>
										<div class="wigdet-two-content">
											<p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Request Per Minute">E - Videos</p>
											<h2><span data-plugin="counterup"><?php echo number_format($count_videos)?></span> </h2>
											<p class="text-muted m-0"><b>Last update:</b> <?php echo date('d M Y')?></p>
										</div>
									</div>
                                </a>
                            </div>
							
							<div class="col-lg-3 col-md-6">
								<a href="<?php echo base_url('st/enotes')?>">
									<div class="card-box widget-box-two widget-two-purple">
										<i class="mdi mdi-file widget-two-icon"></i>
										<div class="wigdet-two-content">
											<p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Request Per Minute">E - NOTES</p>
											<h2><span data-plugin="counterup"><?php echo number_format($count_enotes)?></span> </h2>
											<p class="text-muted m-0"><b>Last update:</b> <?php echo date('d M Y')?></p>
										</div>
									</div>
                                </a>
                            </div>
							
							
                            <div class="col-lg-3 col-md-4 col-sm-6">
							<a href="<?php echo base_url('st/past_papers/')?>">
								<div class="card-box widget-box-two widget-two-primary">
                                    <i class="mdi mdi-chart-areaspline widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">E - Past Papers</p>
                                        <h2><span data-plugin="counterup"><?php echo number_format($this->st_m->count_rows_unenc('past_papers'))?></span> </h2>
                                        <p class="text-muted m-0"><b>Last update:</b> <?php echo date('d M Y')?></p>
                                    </div>
                                </div>
								</a>
                            </div><!-- end col -->
							
							<div class="col-lg-3 col-md-4 col-sm-6">
							<a href="<?php echo base_url('mc/st/')?>">
								<div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-table-edit widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Multiple Choice Quizzes</p>
                                       <h2><?php echo $this->portal_m->count_items('mc_given','student',$this->student->id); ?> </h2>
                                        <p class="text-muted m-0"><b>View Records</b> </p>
                                    </div>
                                </div>
								</a>
                            </div><!-- end col -->
							
						
						
							 <div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('qa/st/'); ?>">
                                <div class="card-box widget-box-two widget-two-warning">
                                    <i class=" mdi mdi-sort-alphabetical widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Q & A QUIZZES</p>
                                        <h2><span data-plugin="counterup">
										<?php //echo $this->portal_m->count_items('qa_given','student',$this->student->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>

							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('st/library_books'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-book-open-variant widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Library (Borrowed Books)</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('qa_given','student',$this->student->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('qa/st/'); ?>">
                                <div class="card-box widget-box-two widget-two-success">
                                    <i class=" mdi mdi-library-books widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">E-Books</p>
                                        <h2><span data-plugin="counterup">
										<?php //echo $this->portal_m->count_items('qa_given','student',$this->student->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
						
                        </div>
					</div>
				</div>
			</div>
						
						
						
						
						
						
						
						
						