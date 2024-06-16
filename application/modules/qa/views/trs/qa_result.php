<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">
					<?php $st = $this->portal_m->find($student);
					echo $p->title; ?> Result for : <?php echo $st->first_name; ?> <?php echo $st->middle_name; ?> <?php echo $st->last_name; ?>
				</h6>
				<div class="btn-group btn-group-sm float-end" role="group">
					<?php echo anchor('qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "'); ?>
					<a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>

			</div>
			<div class="card-body p-2">
				<!-- Content Start Here -->
				<div class="row">
					<div class="col-lg-5 col-xl-5 col-sm-12 col-md-5">
						<!-- Preview Start -->
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
								<td><?php echo $p->title; ?></td>
							</tr>

							<tr>
								<td><strong>LEVEL:</strong> </td>
								<td><?php $classes = $this->portal_m->get_class_options();
									echo  $classes[$p->level]; ?></td>
							</tr>
							<tr>
								<td><strong>SUBJECT :</strong></td>
								<td><?php echo $p->subject; ?></td>
							</tr>

							<tr>
								<td><strong>DURATION :</strong></td>
								<td><?php echo isset($p->hours) ? $p->hours : '0'; ?>hrs : <?php echo isset($p->minutes) ? $p->minutes : '00'; ?> mins</td>
							</tr>
							<tr>
								<td><strong>TOPIC :</strong></td>
								<td><?php echo $p->topic; ?></td>
							</tr>
							<tr>
								<td><strong>POSTED ON :</strong></td>
								<td><?php echo date('d M Y', $p->created_on); ?></td>
							</tr>
						</table>
						<!-- <hr> -->
					</div>
						<!-- Preview End -->
					
					<div class="col-lg-7 col-xl-7 col-sm-12 col-md-7">
						<!-- Table Part -->
						<table class="table bg-default">
                        <tbody>

                            <tr class="profile-th">
                                <td class="">
                                    <p><strong>STUDENT</strong></p>
                                </td>
                                <td class="" colspan="7">
                                    <p class="text-center"><b>
                                        <?php echo strtoupper($st->first_name); ?> <?php echo  strtoupper($st->middle_name); ?> <?php echo  strtoupper($st->last_name); ?>
                                        --
                                        ADM NO:
                                        <?php
                                           if (!empty($st->old_adm_no)) {
                                               echo $st->old_adm_no;
                                           } else {
                                               echo $st->admission_number;
                                           }
                                           ?>
										   </b>
                                    </p>
                                </td>
                            </tr>


                            <tr class="profile-th">
                                <td class="">
                                    <p><strong>Date Submitted </strong></p>
                                </td>
                                <td class="">
                                    <p class="">
                                        <?php echo isset($given->modified_on) ? date('d/m/Y', $post->modified_on) : ''; ?>

                                    </p>
                                </td>
                                <td class="">
                                    <p><strong>Time </strong></p>
                                </td>
                                <td class="">
                                    <p class="">
                                        <?php echo isset($given->modified_on) ? date('H:s', $given->modified_on) : ''; ?>

                                    </p>
                                </td>
                                <td class="">
                                    <p><strong>Date Marked </strong></p>
                                </td>
                                <td class="">
                                    <p class="">
                                        <?php echo isset($post->created_on) ? date('d/m/Y', $post->created_on) : ''; ?>

                                    </p>
                                </td>
                                <td class="">
                                    <p><strong>Time </strong></p>
                                </td>
                                <td class="">
                                    <p class="">
                                        <?php echo isset($post->created_on) ? date('H:i', $post->created_on) : ''; ?>

                                    </p>
                                </td>
                            </tr>

                            <tr class="profile-th">
                                <td class="">
                                    <p><strong>No. of Questions </strong></p>
                                </td>
                                <td class="" colspan="3">
                                    <p class=""><?php echo number_format(count($results)); ?></p>
                                </td>

                                <td class="">
                                    <p><strong>Attempted </strong></p>
                                </td>
                                <td class="" colspan="3">
                                    <p class=""><?php echo $count_done; ?></p>
                                </td>
                            </tr>

                            <tr class="profile-th">
                                <td class="">
                                    <p><strong>Correct answers </strong></p>
                                </td>
                                <td class="" colspan="3">
                                    <p class=""><?php echo $qa_correct; ?></p>
                                </td>

                                <td class="">
                                    <p><strong>Wrong answers </strong></p>
                                </td>
                                <td class="" colspan="3">
                                    <p class=""><?php echo $qa_wrong; ?></p>
                                </td>
                            </tr>

                            <tr class="profile-th">
                                <td class="">
                                    <p><strong>Unanswered </strong></p>
                                </td>
                                <td class="" colspan="3">
                                    <p class=""><?php echo (count($results) - $count_done); ?></p>
                                </td>

                                <td class="">
                                    <p><strong>Score </strong></p>
                                </td>
                                <td class="" colspan="3">
                                    <p class=""><b class=""><?php $pt = (float) ($sum_awarded_points * 100) / $sum_qa_points;
                                                                   echo round($pt, 2) ?>% </b> </p>

                                </td>
                            </tr>

                            <tr class="profile-th">
                                <td class="">
                                    <p><strong>Grade </strong></p>
                                </td>
                                <td class="" colspan="3">
                                    <p><?php  ?></p>
                                </td>

                                <td class="">
                                    <p><strong>Marks </strong></p>
                                </td>
                                <td class=" required">
                                    <p class=""><?php  //echo $qa_correct;
                                                       ?></p>
                                </td>
                                <td class="">
                                    <p><strong>Out of </strong></p>
                                </td>
                                <td class=" required" colspan="">
                                    <p class=""><?php  //echo $count_qstns;
                                                       ?></p>
                                </td>
                            </tr>

                            <tr class="profile-th">
                                <td class="">
                                    <p><strong>Educator's Remarks </strong></p>
                                </td>
                                <td class="" colspan="7">
                                    <p id="rmk_<?php echo $given->id; ?>">
                                        <?php
                                           $rmk = $this->portal_m->given_qa($given->id, $student);
                                           echo isset($rmk->remarks) ? $rmk->remarks . ' - <small><i>( Posted on ' . date('d M Y', $rmk->rmk_date) . ' )</i></small>' : "<i>Awaiting Remarks</i>";
                                           ?>

                                    </p>



                                </td>


                            </tr>




                        </tbody>
                    </table>
						<!-- Table Part -->
					</div>
				</div>

				<hr>

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
												<div class="panel " id="panel_<?php echo $p->id; ?>" <?php if ($p->status == 1) echo 'style="background:#E1F0AC; width: 100%;"'; ?>>
													<div class="timeline-box ">
														<span class="arrow"></span>
														<!-- <span class="timeline-icon  <?php if ($p->status == 1) echo 'bg-success' ?> "><i class="mdi mdi-checkbox-blank-circle-outline"></i></span> -->
														<h6 class=""><b class="text-green"><?php echo $i; ?> ) Question: </b><?php echo $qq; ?></h6>
														<p class="timeline-date pull-right"><small class="text-blue">(<?php echo $mks[$p->question]; ?> Marks)</small></p>
														<!-- <hr> -->
														<p class="text-blue"><b class="text-blue">Student's Answer: </b> <?php echo $p->answer; ?></p>

														<?php if ($p->status == 0) { ?>

															<p class="pad10">

															<h5 id="btn_list_<?php echo $p->id ?>">

																<button class="modal-effect btn btn-success btn-sm waves-effect waves-light" data-bs-effect="effect-flip-vertical" data-bs-toggle="modal" href="#correct_<?php echo $p->id ?>"><i class="fa fa-check"></i> CORRECT </button>

																<button class="btn btn-danger btn-sm waves-effect waves-light" data-bs-toggle="modal" href="#wrong_<?php echo $p->id ?>"><i class="fa fa-check"></i> WRONG </button>

																<button class="btn btn-sm btn-primary" id="scheme_<?php echo $p->id ?>"> MARKING SCHEME</button>

															</h5>
															</p>
															<hr>
														<?php } elseif ($p->status == 1) { ?>
															<!-- <hr> -->
															<?php if ($ans[$p->question]) { ?>
																<p class="text-blue"><b class="text-green">Correct Answer: </b> <?php echo $ans[$p->question]; ?></p>
															<?php } ?>

															<span> <i class='label label-<?php if ($p->points > 0) echo 'success';
																							else echo 'danger'; ?> '> Marks Awarded: (<?php echo $p->points; ?>)</i></span>
															<!-- <hr> -->
															<p>
																<b class="text-green">Educator's Remarks: </b> <?php echo $p->comment; ?>


																<span class="pull-right"> 
																	<i class=" label label-success">Marked</i>
																	<button class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" href="#correct_<?php echo $p->id ?>"><i class="fa fa-edit"></i> Edit </button>

															</p>

															<hr>

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

								<div class="card">
									<div class="card-header bg-default">
										<h6>Educator's / Teacher's General Remarks</h6>
										<!-- <a href="#" class="btn btn-success w-lg">Educator's / Teacher's General Remarks </a> -->
									</div>
									<div class="card-body">
										<?php $rmk = $this->portal_m->given_qa($given->id, $student); ?>

										<div class="row m-2">
											<textarea id="gencomment_<?php echo $given->id; ?>" class="form-control" name="comment" placeholder="Type Remarks here..."><?php echo isset($rmk->remarks) ? $rmk->remarks : ''; ?></textarea>
										</div>
										<div class="form-group">
														<div class="checkbox checkbox-primary">
															<input id="marked_<?php echo $given->id; ?>" value="1" checked type="checkbox" name="marked">
															<label for="marked_<?php echo $given->id; ?>">
																Set as marked
															</label>
														</div>
										</div>
									</div>
									<div class="card-footer">
										<input type="submit" id="submt_<?php echo $given->id; ?>" class="btn btn-danger pull-right" value="Submit Remarks">
									</div>
								</div>

								


								<script>
									$(document).ready(function() {

										//******   POST THE COMMENT ON REPLIES ******//

										$("#submt_<?php echo $given->id; ?>").click(function() {
											//alert(<?php echo $student; ?>);
											var id = <?php echo $given->id; ?>;

											var st = <?php echo $student; ?>;
											var comment = $('#gencomment_<?php echo $given->id; ?>').val();
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