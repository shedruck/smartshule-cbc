<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Given Quiz</h6>
				<div class="float-end">
					<div class="btn-group">
						<button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-folder"></i> Post Quiz to Students <span class="caret"></span> </button>
						<ul class="dropdown-menu">
							<h5 class="text-center"> MY CLASSES</h5>
							<?php
							foreach ($classes as $cl) {
							?>
								<li>

									<button class="btn  col-md-12 btn-sm " id="post_<?php echo $cl->id; ?>" value="<?php echo base_url('qa/trs/post_qa/' . $post->id . '/' . $cl->id . '/' . $this->session->userdata['session_id']) ?>"><i class='fa fa-caret-right'></i> <?php echo strtoupper($cl->name); ?></button>
									<hr>
								</li>


								<script>
									$(document).ready(function() {
										$("#post_<?php echo $cl->id; ?>").click(function() {

											var url = $("#post_<?php echo $cl->id; ?>").val();


											swal({
													title: "Post Assignemnt",
													text: "Are you sure you want to Post this assignment to the learners?",
													icon: "warning",
													buttons: true,
													dangerMode: true,
												})
												.then((willDelete) => {
													if (willDelete) {
														window.location = url;
														swal("Posting assignment please wait....");
													} else {
														//swal("Your imaginary file is safe!");
													}
												});

										});



									})
								</script>

							<?php } ?>
						</ul>
					</div>


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
</div>

<style>
	.card-header {
		display: flex;
		justify-content: space-between;
	}
</style>