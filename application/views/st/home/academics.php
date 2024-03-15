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
            

						 <div class="col-lg-3 col-md-6">
							 <a href="<?php echo base_url('st/diary')?>">
                                <div class="card-box widget-box-two widget-two-inverse">
                                    <i class="mdi mdi-book-open widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">School Diary</</p>
                                        <h2><span data-plugin="counterup">
										<?php 
										$d1 = $this->st_m->count_unecrypted('diary','student',$student,1);
										$d2 = $this->st_m->count_unecrypted('diary_extra','student',$student,1);
										echo number_format($d1+$d2);
										?>
										<?php ?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
                           	<div class="col-lg-3 col-md-6">
							 <a href="<?php echo base_url('st/exams')?>">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class=" mdi mdi-file-multiple widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Exams Results</p>
                                        <h2><span data-plugin="counterup">
										<?php echo number_format($count_exams)?> 
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>


							<div class="col-lg-3 col-md-6">
							 <a href="<?php echo base_url('st/attendance_register')?>">
                                <div class="card-box widget-box-two widget-two-success">
                                    <i class=" mdi mdi-calendar-multiple-check widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Attendance</p>
                                        <h2><span data-plugin="counterup">
										<small class="font14">Present: <?php echo number_format($count_present)?> </small> <small class="text-red font14">- Absent: <?php echo number_format($count_absent)?></small>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>

                       	   <div class="col-lg-3 col-md-6">
							 <a href="#">
                                <div class="card-box widget-box-two widget-two-warning">
                                    <i class=" mdi mdi-table-edit widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">CBC Assessment</p>
                                        <h2><span data-plugin="counterup">
										0
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>

							<div class="col-lg-3 col-md-6">
							 <a href="<?php echo base_url('st/certificates')?>">
                                <div class="card-box widget-box-two widget-two-danger">
                                    <i class=" mdi mdi-file-document widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">My Certificates</p>
                                        <h2><span data-plugin="counterup">
										<?php 
										$xmc = $this->st_m->count_unecrypted('final_exams_certificates','student',$student);
										$other = $this->st_m->count_unecrypted('students_certificates','student',$student);
									?>
										 <?php echo number_format($xmc+$other)?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
						   <div class="col-lg-3 col-md-6">
							 <a href="<?php echo base_url('st/class_subjects')?>">
                                <div class="card-box widget-box-two widget-two-warning">
                                    <i class=" mdi mdi-blur-linear widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Subjects / Learning Areas</p>
                                        <h2><span data-plugin="counterup">
										<?php echo number_format($count_cbc_subjects);?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>


							<div class="col-lg-3 col-md-6">
							  <a href="<?php echo base_url('st/grading_system')?>">
                                <div class="card-box widget-box-two widget-two-default">
                                    <i class=" mdi mdi-altimeter widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Grading Systems</p>
                                        <h2><span data-plugin="counterup">
										<?php echo number_format(count($grading_systems))?>
										</span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b> <i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i>  VIEW  DETAILS</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div>
							
							
							<div class="col-lg-3 col-md-6">
							   <a href="<?php echo base_url('st/educators')?>">
                                <div class="card-box widget-box-two widget-two-info">
                                    <i class=" mdi mdi-account-card-details widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Teachers / Educators</p>
                                        <h2><span data-plugin="counterup">
										<?php echo number_format($count_educators)?>
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
						
						
						
						
						
						
						
						
						