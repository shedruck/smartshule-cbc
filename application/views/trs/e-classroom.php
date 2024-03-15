<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> E-Classroom</b>
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
        <hr>
    </div>

        <div class="row">
           <div class="col-md-12">
		   
		             <div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('trs/diary'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-file-video widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Students Diary</p>
                                        <h2><span data-plugin="counterup">
										Academics
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
					

                            <div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('igcse/trs/record'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class="mdi mdi-chart-areaspline widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Exams Management ( 8.4.4 / IGCSE )</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('exams'); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b><i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->

                           

                            <div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('trs/cbc'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-receipt widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">CBC Assessments</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('cbc_assess','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b></p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->

							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('students_projects/trs'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-receipt widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Students Projects</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('students_projects','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b></p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->
							
								<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('trs/assignments'); ?>">
                                <div class="card-box widget-box-two widget-two-purple">
                                    <i class="mdi mdi-layers widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month"> Assignments</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('assignments','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b><i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b></p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->
							
							 <div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('qa/trs/'); ?>">
                                <div class="card-box widget-box-two widget-two-purple">
                                    <i class=" mdi mdi-sort-alphabetical widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Q & A QUIZZES</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('qa','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('mc/trs/'); ?>">
                                <div class="card-box widget-box-two widget-two-purple">
                                    <i class=" mdi mdi-table-edit widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Multiple Choices QUIZZES</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('mc','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>

							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('enotes/trs/'); ?>">
                                <div class="card-box widget-box-two widget-two-purple">
                                    <i class=" mdi mdi-animation widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">E-Notes</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('enotes','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('trs/evideos_landing'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-file-video widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">E-Videos</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('evideos'); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('lesson_materials/trs/'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-arrange-send-backward widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Lesson Materials</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('lesson_materials','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
								
						<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('trs/lesson_plan'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-file-video widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Lesson Plans</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('lesson_plan','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>


						  <div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('record_of_work_covered/trs'); ?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-file-video widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Record of Work Covered</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('record_of_work_covered','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>

							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('schemes_of_work/trs'); ?>">
                                <div class="card-box widget-box-two widget-two-purple">
                                    <i class=" mdi mdi-file-video widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Schemes of Work</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('schemes_of_work','created_by',$this->ion_auth->get_user()->id); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
							
							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('trs/past_papers/'); ?>">
                                <div class="card-box widget-box-two widget-two-purple">
                                    <i class=" mdi mdi-file-video widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Past Papers</p>
                                        <h2><span data-plugin="counterup">
										<?php echo $this->portal_m->count_items('past_papers'); ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
							
							<div class="col-lg-3 col-md-6">
							<a href="<?php echo base_url('trs/diary/extra'); ?>">
                                <div class="card-box widget-box-two widget-two-purple">
                                    <i class=" mdi mdi-file-video widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Students Diary</p>
                                        <h2><span data-plugin="counterup">
										Extra
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
						


                        </div>
                  </div>
           </div>