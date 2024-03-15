 
                        <div class="row">

                           

                            <div class="col-lg-3 col-md-6">
							  <a href="<?php echo base_url('st/exams')?>">
                                <div class="card-box widget-box-two widget-two-warning">
                                    <i class="mdi mdi-layers widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">All EXAMS </p>
                                        <h2><span data-plugin="counterup"><?php echo number_format($count_exams)?> </span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0">
										<b style="color:green">
										Done - Exams:  <?php if($done_exams > $count_exams) echo number_format($count_exams); else echo number_format($done_exams);?> - CBC:  <?php  echo number_format($done_cbc);?>
										</b>
										
										</p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->

                            <div class="col-lg-3 col-md-6">
							  <a href="<?php echo base_url('st/assignments')?>">
                                <div class="card-box widget-box-two widget-two-danger">
                                    <i class="mdi mdi-access-point-network widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">ALL Assignments Given</p>
                                        <h2><span data-plugin="counterup"> <?php echo number_format($count_assignments)?></span> <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                                        <p class="text-muted m-0"><b style="color:green">Done Assignments: 0</b> </p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->

                            <div class="col-lg-3 col-md-6">
							 <a href="<?php echo base_url('st/attendance_register')?>">
                                <div class="card-box widget-box-two widget-two-success">
                                    <i class="mdi mdi-account-convert widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">Days Present</p>
                                        <h2><span data-plugin="counterup"> <?php echo number_format($count_present)?> </span> <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                                        <p class="text-muted m-0"><b style="color:red">Days Absent:  <?php echo number_format($count_absent)?></b></p>
                                    </div>
                                </div>
                                </a>
                            </div><!-- end col -->
							
							 <div class="col-lg-3 col-md-6">
                                <div class="card-box widget-box-two widget-two-primary">
                                    <i class="mdi fa fa-money widget-two-icon"></i>
                                    <div class="wigdet-two-content">
                                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">All Borrowed Books</p>
                                        <h2><span data-plugin="counterup"> <?php echo number_format($borrowed_books)?> </span> <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                                        <p class="text-muted m-0"><b style="color:green">Returned: <?php echo number_format($returned_books)?></b>  </p>
                                    </div>
                                </div>
                            </div><!-- end col -->
							
							

                        </div>
                        <!-- end row -->


                <div class="row">
                    <div class=" col-lg-3">
					<div class="text-center card-box">
						<div class="member-card">
							<div class="thumb-xl member-thumb m-b-10 center-block">
							
							  <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="110" height="110"  class="img-circle img-thumbnail" alt="profile-image">
							
								<i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>
							</div>

							<div class="">
								<h4 class="m-b-5"><?php echo $class_rep->first_name.' '.$class_rep->middle_name.' '.$class_rep->last_name?></h4>
								<p class="text-muted">Class Representative/Teacher</p>
							</div>

							<button type="button" class="btn btn-primary btn-sm w-sm waves-effect m-t-10 waves-light">Send Message</button>
                           
                             <a href="<?php echo base_url();?>st/zoom_classes"  class="btn btn-primary btn-rounded waves-effect m-t-10 m-b-10 waves-light"><i class="mdi mdi-spin mdi-camcorder" aria-hidden="true"></i>Zoom Meeting</a>
							
							<hr/>

							<div class="text-left">
								
								<p class=" font-13"><strong>Gender :</strong> <span class="m-l-15"><?php echo $class_rep->gender ?></span></p>
								<p class="font-13"><strong>Mobile 1:</strong><span class="m-l-15"><?php echo $class_rep->phone ?></span></p>
								<p class=" font-13"><strong>Mobile 2:</strong><span class="m-l-15"><?php echo $class_rep->phone2 ?></span></p>

								<p class="y font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $class_rep->email?> </span></p>

								
							</div>


						</div>

					</div> <!-- end card-box -->

				</div> <!-- end col -->


                    <div class="col-lg-9">
                         <div class="col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30"> Assignments <span class="pull-right"><a href="<?php echo base_url('st/assignments')?>" class="btn btn-primary btn-sm w-sm waves-effect waves-light"> <i class="fa fa-share"></i> See All</a> </span> 
							<hr>
							</h4>

                            <div class="table-responsive">
							<?php 
									if($class_assignments){
									
									?>
                                <table class="table table table-hover m-0">
                                    <thead>
                                        <tr>
                                          
                                            <th>Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th></th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
								
									foreach($class_assignments as $p){
									?>
									
                                        <tr>
                                          
                                            <td> <a href="<?php echo site_url('st/assignments_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>"><?php echo substr($p->title,0,15);?>.. </a></td>
                                            <td><a href="<?php echo site_url('st/assignments_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>"><?php echo date('d/m/y',$p->start_date);?></a></td>
                                            <td><a href="<?php echo site_url('st/assignments_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>"><?php echo date('d/m/y',$p->end_date);?></a></td>
                                            <td>
											<a href="<?php echo site_url('st/assignments_view/'.$p->id.'/'.$this->session->userdata['session_id']);?>">
											<i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> </a>
											</td>
										
                                        </tr>
									
									<?php } ?>
									
                                    </tbody>
                                </table>
								
								<?php }else{ ?>
									 <h4>No assignments given at the moment</h4>
									<?php } ?>

                            </div> <!-- table-responsive -->
                        </div> <!-- end card -->
                    </div><!-- end col -->
					
					    <div class="col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Examinations Set  
							<span class="pull-right"><a href="<?php echo base_url('st/exams')?>" class="btn btn-primary btn-sm w-sm waves-effect waves-light"> <i class="fa fa-share"></i> See All</a> </span> 
								<hr>
							</h4>
							
                            <div class="table-responsive">
                                <table class="table table table-hover m-0">
                                    <thead>
                                        <tr>
                                       
                                            <th>Title </th>
                                            <th>Term</th>
                                            <th>Start Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php 
									
											foreach($all_exams as $p){
										?>
                                        <tr>
                                           
                                           
                                            <td><a href="<?php echo base_url('st/results/'.$p->id.'/'.$this->session->userdata['session_id'])?>"><?php echo $p->title;?></a></td>
                                            <td><a href="<?php echo base_url('st/results/'.$p->id.'/'.$this->session->userdata['session_id'])?>">Term <?php echo $p->term;?></a></td>
                                            <td><a href="<?php echo base_url('st/results/'.$p->id.'/'.$this->session->userdata['session_id'])?>"><?php echo date('d M Y',$p->start_date);?></a></td>
											 <td><a href="<?php echo base_url('st/results/'.$p->id.'/'.$this->session->userdata['session_id'])?>"><i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> </a></td>
                                        </tr>

                                    	<?php } ?>  

                                    </tbody>
                                </table>

                            </div> <!-- table-responsive -->
                        </div> <!-- end card -->
                    </div>
                    <!-- end col -->

             

                </div>
                <!-- end row -->

