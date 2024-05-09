<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">
					<?php $st = $this->portal_m->find($student);
					echo $p->title; ?> Result for : <?php echo $st->first_name; ?> <?php echo $st->middle_name; ?> <?php echo $st->last_name; ?>
				</h6>
				<div class="float-end">
					<?php echo anchor('mc/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "'); ?>
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
						<div class="table-responsive">
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
										<p class=""><?php echo $mc_correct; ?></p>
									</td>

									<td class="">
										<p><strong>Wrong answers </strong></p>
									</td>
									<td class="" colspan="3">
										<p class=""><?php echo $mc_wrong; ?></p>
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
										<p class=""><b class=""><?php $ppt = (float) ($mc_correct * 100) / $count_qstns;
																echo round($ppt, 2) ?>% </b> </p>

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
										<p class=""><?php echo $mc_correct;
													?></p>
									</td>
									<td class="">
										<p><strong>Out of </strong></p>
									</td>
									<td class=" required" colspan="">
										<p class=""><?php echo $count_qstns;
													?></p>
									</td>
								</tr>

								<tr class="profile-th">
									<td class="">
										<p><strong>Educator's Remarks </strong></p>
									</td>
									<td class="" colspan="7">
										<p id="rmk_<?php echo $p->id; ?>">
											<?php
											$rmk = $this->portal_m->mc_done($p->id, $student);
											echo isset($rmk->remarks) ? $rmk->remarks . ' - <small><i>( Posted on' . date('d M Y', $rmk->rmk_date) . ' )</i></small>' : "<i>Give your Remarks here</i>";
											?>
											<?php if (!isset($rmk->remarks)) { ?>

										<div class="form-group">

											<textarea id="comment_<?php echo $p->id; ?>" class="form-control" name="comment" placeholder="Type Remarks here..."></textarea>
										</div>
										<div class="form-group">
											<input type="submit" id="submt_<?php echo $p->id; ?>" class="btn btn-danger pull-right" value="Submit Remarks">
										</div>
									<?php } ?>
									</p>

									<script>
										$(document).ready(function() {

											//******   POST THE COMMENT ON REPLIES ******//

											$("#submt_<?php echo $p->id; ?>").click(function() {

												var id = <?php echo $p->id; ?>;

												var st = <?php echo $student; ?>;
												var comment = $('#comment_<?php echo $p->id; ?>').val();

												var dataString = '&comment=' + comment + '&id=' + id + '&st=' + st;

												if (comment == '' || id == '') {
													alert("Atleast write something before submitting !");
												} else {
													//alert(comment);
													// AJAX Code To Submit Form.
													$.ajax({
														type: "POST",
														url: "<?php echo base_url('mc/trs/post_comment'); ?>",
														data: dataString,
														cache: false,
														success: function(result) {


															document.getElementById("rmk_<?php echo $p->id; ?>").innerHTML += "<span>" + comment + "</span>";
															document.getElementById('comment_<?php echo $p->id; ?>').value = ''

															$('.form-group').hide('fast');


														}
													});

												}


											});
										})
									</script>

									</td>


								</tr>




							</tbody>
						</table>
						</div>
						<!-- Table Part -->
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-lg-4 col-xl-4 col-sm-12 col-md-4">
						<div class="card">
							<div class="card-header bg-default">
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
						<!-- Questions starts -->
						<?php if ($results) : ?>
							<!-- <div class="block-fluid"> -->


								<div class="card">
									<!-- <div class=" card-block "> -->
										<div class="table-responsive ">
											<table class="table">
												<thead class="bg-default">

													<th style="width:40%">
														<div class="">Question</div>
													</th>
													<th style="width:25%">
														<div class="">Correct Answer</div>
													</th>
													<th style="width:25%">
														<div class="">Your Choice</div>
													</th>
													<th style="width:10%">
														<div class="">Score</div>
													</th>

												</thead>


												<tbody>

													<?php
													$i = 0;
													$j = 1;
													$qn = $this->st_m->populate('mc_questions', 'id', 'question');
													$choices = $this->st_m->populate('mc_choices', 'id', 'choice');


													foreach ($results as $p) :
														$correct = $this->st_m->correct_mc($p->question_id);
														$i++;
													?>
														<tr>
															<td>

																<?php echo $qn[$p->question_id]; ?>
															</td>

															<td>
																<?php if ($p->state != 1) { ?>
																	<span class="required"><?php echo $correct->choice; ?></span>
																<?php } ?>
															</td>

															<td>
																<span style="color:#0083C4"><b><?php echo $choices[$p->choice_id]; ?></b></span>
															</td>
															<td>

																<?php
																if ($p->state == 1) echo "<span class='btn btn-sm btn-success'><i class='fa fa-check'></i><span>";
																else echo "<span class='btn btn-sm btn-danger'><i class='fa fa-times'></i><span>";

																?>

															</td>
														</tr>

													<?php endforeach ?>


												</tbody>
											</table>
										</div>
									<!-- </div> -->
								</div>
							<!-- </div> -->


						<?php else : ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
						<?php endif ?>
						<!-- Questions End -->
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