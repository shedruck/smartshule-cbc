<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">
					<?php $st = $this->portal_m->find($student);
					echo $p->title; ?> Result for : <?php echo $st->first_name; ?> <?php echo $st->middle_name; ?> <?php echo $st->last_name; ?>
				</h6>
				<div class="float-end">
					<?php echo anchor('qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "'); ?>
					<a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>

			</div>
			<div class="card-body p-2">
				<!-- Content Start Here -->
				<div class="row">
					<div class="col-lg-6 col-xl-6 col-sm-12 col-md-6">

					</div>
					<div class="col-lg-6 col-xl-6 col-sm-12 col-md-6">

					</div>
				</div>

				<div class="row">
					<div class="col-lg-4 col-xl-4 col-sm-12 col-md-4">
						<div class="card">
							<div class="card-header">
								<b>INSTRUCTIONS</b>
							</div>
							<div class="card-body">
								<p class="text-black font-10">
									<?php echo $p->instruction ?>
								</p>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-xl-8 col-sm-12 col-md-8">
						<?php if ($results) : ?>
							<div class="card">
								<div class="card-header">
									<a href="#" class="btn btn-danger w-lg">Questions </a>
								</div>
								<div class="card-body">
									<!-- Questions Markings Start -->
									<?php
									$i = 0;
									$j = 1;
									$qn = $this->st_m->populate('qa_questions', 'id', 'question');
									$mks = $this->st_m->populate('qa_questions', 'id', 'marks');
									$ans = $this->st_m->populate('qa_questions', 'id', 'answer');
									$points = $this->trs_m->populate('qa_questions', 'id', 'marks');
									$pnts = 0;

									foreach ($results as $p) :
										$qq = preg_replace("/<p.*?>(.*)?<\/p>/im", "$1", $qn[$p->question]);
										$the_ans = strip_tags($ans[$p->question]);
										$i++;
										$pnts = (int) $points[$p->question];
									?>

										<article class="timeline-item ">
											<div class="timeline-desk">
												<div class="panel " id="panel_<?php echo $p->id; ?>" <?php if ($p->status == 1) echo 'style="background:#E1F0AC"'; ?>>
													<div class="timeline-box ">
														<span class="arrow"></span>
														<!-- <span class="timeline-icon  <?php if ($p->status == 1) echo 'bg-success' ?> "><i class="mdi mdi-checkbox-blank-circle-outline"></i></span> -->
														<h6 class=""><b class="text-green"><?php echo $i; ?> ) Question: </b><?php echo $qq; ?></h6>
														<p class="timeline-date pull-right"><small class="text-blue">(<?php echo $mks[$p->question]; ?> Marks)</small></p>
														<!-- <hr> -->
														<p class="text-blue"><b class="text-blue">Student's Answer: </b><br> <?php echo $p->answer; ?></p>

														<?php if ($p->status == 0) { ?>

															<p class="pad10">

															<h5 id="btn_list_<?php echo $p->id ?>">

																<button class="modal-effect btn btn-success btn-sm waves-effect waves-light" data-bs-effect="effect-flip-vertical" data-bs-toggle="modal" href="#correct_<?php echo $p->id ?>"><i class="fa fa-check"></i> CORRECT </button>

																<button class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" href="#wrong_<?php echo $p->id ?>"><i class="fa fa-check"></i> WRONG </button>

																<button class="btn btn-sm btn-primary" id="scheme_<?php echo $p->id ?>"> MARKING SCHEME</button>

															</h5>
															</p>

														<?php } elseif ($p->status == 1) { ?>

															<hr>
															<?php if ($ans[$p->question]) { ?>
																<p class="text-blue"><b class="text-green">Correct Answer: </b> <?php echo $ans[$p->question]; ?></p>
															<?php } ?>

															<span> <i class='label label-<?php if ($p->points > 0) echo 'success';
																							else echo 'danger'; ?> '> Marks Awarded: (<?php echo $p->points; ?>)</i></span>
															<hr>
															<p>
																<b class="text-green">Educator's Remarks: </b> <?php echo $p->comment; ?>


																<span class="pull-right"> <i class=" label label-success">Marked</i>
																	<button class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#correct_<?php echo $p->id ?>"><i class="fa fa-edit"></i> Edit </button>

															</p>



														<?php } ?>


														<p id="marked_list_<?php echo $p->id ?>" style="display:none">
															<span class="label label-primary font-15">Marked</span>
															<span id="given_points_<?php echo $p->id ?>" class="">

															</span>
															<br>
															<span id="trs_comment<?php echo $p->id ?>" class=""> </span>


														</p>

													</div>
												</div>
											</div>
										</article>



										<!-- sample modal content -->
										<div class="modal fade efect-flip-horizontal effect-flip-vertical" id="correct_<?php echo $p->id ?>">
											<div class="modal-dialog modal-dialog-centered text-center" role="document">
												<div class="modal-content modal-content-demo">
													<div class="modal-header">
														<h6 class="modal-title">Mark Question No. <?php echo $i ?> - (<?php echo $mks[$p->question]; ?> Marks)</h6><button aria-label="Close" class="btn-close"
															data-bs-dismiss="modal"></button>
													</div>
													<div class="modal-body">
														<div class='row mb-2'>
															<div class="col-md-3">Mark * </div>
															<div class="col-md-9">
																<input name="points" class="form-control" type="text" id="points_<?php echo $p->id ?>">

															</div>
														</div>

														<div class='row m-2'>
															<div class="col-md-3">Comment: </div>
															<div class="col-md-9">
																<textarea id="comment_<?php echo $p->id ?>" placeholder="Add remarks..." style="color:red; " rows="2" cols="50" class="form-control comment font-17" name="comment" /></textarea>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<!-- <button class="btn btn-primary">Save changes</button>  -->
														<button type="submit" id="c_<?php echo $p->id ?>" data-bs-dismiss="modal" class="btn btn-primary">Submit</button>
														<button class="btn btn-light" data-bs-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div><!-- /.modal -->
										<!-- Right Answer ----->


										<!-- Wrong Answer ----->
										<div class="modal fade efect-flip-horizontal effect-flip-vertical" id="wrong_<?php echo $p->id ?>">
											<div class="modal-dialog modal-dialog-centered text-center" role="document">
												<div class="modal-content modal-content-demo">
													<div class="modal-header">
														<h6 class="modal-title">Mark Question No. <?php echo $i ?> - (<?php echo $mks[$p->question]; ?> Marks)</h6><button aria-label="Close" class="btn-close"
															data-bs-dismiss="modal"></button>
													</div>
													<div class="modal-body">
														<div class='row row'>
															<div class="col-md-3">Comment: </div>
															<div class="col-md-9">
																<textarea placeholder="Remarks / Comment ..." rows="2" cols="50" style="color:red; " class="form-control comment" id="comm_<?php echo $p->id ?>" name="comment" /></textarea>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<!-- <button class="btn btn-primary">Save changes</button>  -->
														<button type="submit" id="w_<?php echo $p->id ?>" data-bs-dismiss="modal" class="btn btn-danger md-close">Submit</button>
														<button class="btn btn-light" data-bs-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>


										<script>
											$(document).ready(function() {

												$("#scheme_<?php echo $p->id ?>").click(function() {

													swal({
														title: "Given correct answer is",
														text: "<?php echo $the_ans ?>",
														icon: "success",
														button: "Close",
													})

												});


												$("#points_<?php echo $p->id ?>").change(function() {


													var pnts = 0;
													pnts = $("#points_<?php echo $p->id ?>").val();
													var avail_points = <?php echo $pnts ?>;

													if (pnts > avail_points) {

														swal({
															title: "Sorry maximum marks is <?php echo $pnts ?>",
															text: "Marks awarded is higher than set marks",
															icon: "warning",
															button: "Close",
														})

														$(this).css("border", "3px  solid #DC3545");

													} else {

														$(this).css("background-color", "#7FFF00");
														$('#c_<?php echo $p->id ?>').show('fast');

													}

												});

												//************ MARK AS CORRECT **********//

												$("#c_<?php echo $p->id ?>").click(function() {


													document.getElementById("given_points_<?php echo $p->id ?>").innerHTML = "";
													document.getElementById("trs_comment<?php echo $p->id ?>").innerHTML = "";

													$("#given_points_<?php echo $p->id ?>").empty();
													$("#trs_comment<?php echo $p->id ?>").empty();

													var id = <?php echo $p->id ?>;
													var state = 1;
													var points = $("#points_<?php echo $p->id ?>").val();
													var comment = $("#comment_<?php echo $p->id ?>").val();

													if (points != "") {

														$.getJSON("<?php echo base_url('qa/trs/update_qa/'); ?>", {
															id: id,
															state: state,
															points: points,
															comment: comment
														}, function(data) {

															if (data === 0) {

																swal({
																	title: "Sorry something went wrong",
																	text: "Try again later",
																	icon: "warning",
																	button: "Close",
																})


															} else {
																//location.reload();
																/*  swal({
                                             title: "Successfully Marked",
                                             text: "Question was successfully marked",
                                             icon: "success",
                                             button: "Close",
                                           }) */

																$('#marked_list_<?php echo $p->id ?>').show('fast');
																$('#btn_list_<?php echo $p->id ?>').hide();

																document.getElementById("given_points_<?php echo $p->id ?>").innerHTML += "<span class='label label-success font-15'>Awarded Marks " + points + "</span>";

																document.getElementById("panel_<?php echo $p->id; ?>").style.background = "#E1F0AC";

																document.getElementById("trs_comment<?php echo $p->id ?>").innerHTML += "<b>Educator's remarks:</b> <span class='required'>" + comment + "</span>";
															}


														});

													} else {
														alert('Marks must be awarded');
													}

												});
											})
										</script>


										<script>
											$(document).ready(function() {
												$("#w_<?php echo $p->id ?>").click(function() {

													document.getElementById("given_points_<?php echo $p->id ?>").innerHTML = "";
													document.getElementById("trs_comment<?php echo $p->id ?>").innerHTML = "";

													$("#given_points_<?php echo $p->id ?>").empty();
													$("#trs_comment<?php echo $p->id ?>").empty();

													var id = <?php echo $p->id ?>;
													var state = 0;
													var points = 0;
													var comment = $("#comm_<?php echo $p->id ?>").val();

													$.getJSON("<?php echo base_url('qa/trs/update_qa/'); ?>", {
														id: id,
														state: state,
														points: points,
														comment: comment
													}, function(data) {

														if (data === 0) {

															swal({
																title: "Sorry something went wrong",
																text: "Try again later",
																icon: "warning",
																button: "Close",
															})


														} else {


															/* swal({
															      title: "Successfully Update",
															      text: "Your update was successfully submitted",
															      icon: "success",
															      button: "Close",
															    }) */

															$('#marked_list_<?php echo $p->id ?>').show('fast');
															$('#btn_list_<?php echo $p->id ?>').hide();

															document.getElementById("given_points_<?php echo $p->id ?>").innerHTML += "<span class='label label-danger font-15'>Awarded Marks 0 </span>";

															document.getElementById("panel_<?php echo $p->id; ?>").style.background = "#E1F0AC";

															document.getElementById("trs_comment<?php echo $p->id ?>").innerHTML += "<b>Educator's remarks:</b> <span class='required'> " + comment + "</span>";
														}


													});

												});
											})
										</script>


									<?php endforeach ?>

								</div>


								<div class="timeline timeline-left">
									<article class="timeline-item alt">
										<div class="text-left">
											<div class="time-show first">
												<a href="#" class="btn btn-success w-lg">Educator's / Teacher's General Remarks </a>
											</div>
										</div>
									</article>

									<article class="timeline-item ">
										<div class="timeline-desk">
											<div class="panel ">
												<div class="timeline-box ">
													<span class="arrow"></span>
													<span class="timeline-icon  "><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>

													<?php $rmk = $this->portal_m->given_qa($given->id, $student); ?>

													<div class="form-group">

														<textarea id="comment_<?php echo $given->id; ?>" class="form-control" name="comment" placeholder="Type Remarks here..."><?php echo isset($rmk->remarks) ? $rmk->remarks : ''; ?></textarea>
													</div>



													<div class="form-group">
														<div class="checkbox checkbox-primary">
															<input id="marked_<?php echo $given->id; ?>" value="1" checked type="checkbox" name="marked">
															<label for="marked_<?php echo $given->id; ?>">
																Set as marked
															</label>
														</div>
													</div>

													<div class="form-group">
														<input type="submit" id="submt_<?php echo $given->id; ?>" class="btn btn-danger pull-right" value="Submit Remarks">
													</div>

												</div>
											</div>
										</div>
									</article>
								</div>


								<script>
									$(document).ready(function() {

										//******   POST THE COMMENT ON REPLIES ******//

										$("#submt_<?php echo $given->id; ?>").click(function() {
											//alert(<?php echo $student; ?>);
											var id = <?php echo $given->id; ?>;

											var st = <?php echo $student; ?>;
											var comment = $('#comment_<?php echo $given->id; ?>').val();
											var marked = 0;
											var status = 0;

											if ($('#marked_<?php echo $given->id; ?>').is(":checked")) {
												marked = 1;
												status = 1;
											}

											if (comment == '' || id == '') {
												swal({
													title: "Sorry",
													text: "Atleast write something before submitting !",
													icon: "warning",
													button: "Close",
												})
											} else {

												$.getJSON("<?php echo base_url('qa/trs/post_comment/'); ?>", {
													id: id,
													st: st,
													comment: comment,
													marked: marked,
													status: status
												}, function(data) {

													if (data === 0) {

														swal({
															title: "Sorry something went wrong",
															text: "Try again later",
															icon: "warning",
															button: "Close",
														})


													} else {


														swal({
															title: "Successfully Update",
															text: "Your update was successfully submitted",
															icon: "success",
															button: "Close",
														})

														document.getElementById("rmk_<?php echo $given->id; ?>").innerHTML += "<span>" + comment + "</span>";
													}

												});

											}
										});
									})
								</script>
								<!-- Questions Markings End -->
							</div>
					</div>
				<?php else : ?>
					<p class='text'><?php echo lang('web_no_elements'); ?></p>
				<?php endif ?>
				</div>
			</div>
			<!-- Content End Here -->
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