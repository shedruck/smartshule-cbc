<?php 
$maclasess = $classes;
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Given Quiz</h6>
				<div class="float-end">
				<button class="btn btn-success btn-sm off-canvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa fa-folder"></i> Post Quiz to Students <span class="caret"></span> </button>
					<?php echo anchor('qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "'); ?>
					<a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>

			</div>
			<div class="card-body p-2">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
					<div class="card text-center shadow-none border profile-cover__img">
                                    <div class="card-body">
                                        <div class="profile-img-1">
                                            <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="img" id="profile-img">
                                            
                                        </div>
                                        <div class="profile-img-content text-dark my-2">
                                            <div>
												<?php $u = $this->ion_auth->get_user($post->created_by); ?>
                                                <h5 class="mb-0"> BY: <?php echo strtoupper($u->first_name . ' ' . $u->last_name); ?></h5>
                                                <p class="text-muted mb-0">Educator / teacher</p>
                                            </div>
                                        </div>
                                       
                                    </div>
									
                                </div>
						<hr>
						<table class="table">
							<tr>
								<td><strong>TITLE :</strong></td>
								<td><?php echo $post->title; ?></td>
							</tr>

							<tr>
								<td><strong>LEVEL:</strong> </td>
								<td><?php $classes = $this->portal_m->get_class_options();
									echo  $classes[$post->level]; ?></td>
							</tr>
							<tr>
								<td><strong>SUBJECT :</strong></td>
								<td><?php echo $post->subject; ?></td>
							</tr>

							<tr>
								<td><strong>DURATION :</strong></td>
								<td><?php echo isset($post->hours) ? $post->hours : '0'; ?>hrs : <?php echo isset($post->minutes) ? $post->minutes : '00'; ?> mins</td>
							</tr>
							<tr>
								<td><strong>TOPIC :</strong></td>
								<td><?php echo $post->topic; ?></td>
							</tr>
							<tr>
								<td><strong>POSTED ON :</strong></td>
								<td><?php echo date('d M Y', $post->created_on); ?></td>
							</tr>
						</table>
						<hr>
						<h6>INSTRUCTIONS</h6>
						<p class="text-black font-13 m-t-20">
							<?php echo $post->instruction ?>
						</p>
					</div>
					<div class="col-lg-6 col-md-6 col-xl-6 col-sm-12">
						<div class="card">
							<div class="card-header">
								<h6>CLASSES / GRADES GIVEN</h6>
							</div>
							<div class="card-body">
								<?php $i = 0;
								if ($given) { ?>
										<div class="table-responsive">
									<table id="datatable-buttons" class="table table-striped table-bordered">
										<thead>
											<th>#</th>

											<th>Class</th>
											<th>Done</th>
											<th>Pending</th>

											<th>Checked</th>
											<th>Action</th>
										</thead>

										<?php
										$cl = $this->ion_auth->fetch_classes();
										foreach ($given as $p) {
											$i++; ?>

											<tbody>
												<tr>
													<td>
														<?php echo $i ?>.
													</td>
													<td>
														<?php echo strtoupper($cl[$p->class]); ?><br>
														<small><b> <i><?php echo date('d M Y', $p->created_on); ?></i></b></small>
													</td>
													<td>
														<span class="label label-success"><?php echo $this->portal_m->count_unique('qa_given', 'done', 1, 'created_on', $p->created_on); ?></span>
													</td>
													<td>
														<span class="label label-danger"><?php echo $this->portal_m->count_unique('qa_given', 'done', 0, 'created_on', $p->created_on); ?></span>
													</td>
													<td>
														<span class="label label-info"><?php echo $this->portal_m->count_unique('qa_given', 'remarks', 1, 'created_on', $p->created_on); ?></span>
													</td>
													<td width="">
														<div class="btn-group pull-right">
															<?php
															$d = $this->portal_m->count_unique('qa_given', 'done', 1, 'created_on', $p->created_on);
															if ($d > 0) {
															?>
																<a class="btn btn-success btn-sm" href='<?php echo site_url('qa/trs/qa_remarks/' . $p->created_on . '/' . $post->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-share'></i> Show All</a>
															<?php } else { ?>
																<a class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to revert this posted quiz? action irreversible')" href='<?php echo site_url('qa/trs/revert/' . $p->created_on . '/' . $post->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-times'></i> Revert</a>
															<?php } ?>
														</div>
													</td>
												</tr>
											</tbody>
										<?php  } ?>
									</table>
									</div>
								<?php } else { ?>
									No question has been added
								<?php } ?>
							</div>
						</div>

					</div>
				</div>

			</div>
			<div class="card-footer">

			</div>
		</div>
	</div>

	<!-- Offright Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-header">
            <h6 class="fw-bold offcanvas-title">My Classes</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fe fe-x fs-18"></i></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <h6 class="mb-3 fw-bold" id="class_name"></h6>
                <ul class="list-group list-group-flush border">
                    <div class=" mb-2" id="myload" style="display: none; border:none">
                        <div class="s-body d-flex justify-content-center align-items-center flex-wrap gap-1">
                            <span class="me-0">
                                <svg id="myloader" xmlns="http://www.w3.org/2000/svg" height="60" width="60" data-name="Layer 1" viewBox="0 0 24 24">
                                    <path fill="#05c3fb" d="M12 1.99951a.99974.99974 0 0 0-1 1v2a1 1 0 1 0 2 0v-2A.99974.99974 0 0 0 12 1.99951zM12 17.99951a.99974.99974 0 0 0-1 1v2a1 1 0 0 0 2 0v-2A.99974.99974 0 0 0 12 17.99951zM21 10.99951H19a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2zM6 11.99951a.99974.99974 0 0 0-1-1H3a1 1 0 0 0 0 2H5A.99974.99974 0 0 0 6 11.99951zM17.19629 8.99951a1.0001 1.0001 0 0 0 .86719.5.99007.99007 0 0 0 .499-.13428l1.73145-1a.99974.99974 0 1 0-1-1.73144l-1.73145 1A.9993.9993 0 0 0 17.19629 8.99951zM6.80371 14.99951a.99936.99936 0 0 0-1.36621-.36572l-1.73145 1a.99974.99974 0 1 0 1 1.73144l1.73145-1A.9993.9993 0 0 0 6.80371 14.99951zM15 6.80371a1.0006 1.0006 0 0 0 1.36621-.36621l1-1.73193a1.00016 1.00016 0 1 0-1.73242-1l-1 1.73193A1 1 0 0 0 15 6.80371zM3.70605 8.36523l1.73145 1a.99007.99007 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572l-1.73145-1a.99974.99974 0 1 0-1 1.73144zM9 17.1958a.99946.99946 0 0 0-1.36621.36621l-1 1.73194a1.00016 1.00016 0 0 0 1.73242 1l1-1.73194A1 1 0 0 0 9 17.1958zM20.294 15.63379l-1.73145-1a.99974.99974 0 1 0-1 1.73144l1.73145 1a.99.99 0 0 0 .499.13428.99977.99977 0 0 0 .501-1.86572zM16.36621 17.562a1.00016 1.00016 0 1 0-1.73242 1l1 1.73194a1.00016 1.00016 0 1 0 1.73242-1z"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div id="data-container">
					<?php
                        foreach ($maclasess as $cl) {
                        ?>
                            <a href="<?php echo base_url('qa/trs/post_qa/' . $post->id . '/' . $cl->id . '/' . $this->session->userdata['session_id']) ?>" onclick="return confirm('Are you sure you want to post this assignment for the learners?')">
                                <li class="list-group-item d-flex justify-content-between align-items-center pe-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="fe fe-check text-primary me-2" aria-hidden="true"></i><?php echo strtoupper($cl->name); ?></span>
                                    <div class="form-check form-switch</a>">

                                    </div>
                                </li>

                            <?php } ?>
                    </div>

                </ul>
            </div>

        </div>
    </div>
    <!-- Offright Canvas End-->
</div>

<style>
	.card-header {
		display: flex;
		justify-content: space-between;
	}
</style>