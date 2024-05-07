<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start"><?php echo $post->title ?> - Question and Answers</h6>
				<div class="float-end">
					<a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
					<?php echo anchor('qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-primary btn-sm pull-right"'); ?>
					<a class="btn btn-success btn-sm pull-right" href='<?php echo site_url('qa/trs/view_qa/' . $post->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View Details</a>
				</div>
			</div>
			<div class="card-body mb-2">
				<div class="row">
					<div class="col-lg-6 col-xl-6 col-md-6">
						<?php
							$attributes = array('class' => 'form-horizontal', 'id' => '');
							echo   form_open_multipart(current_url(), $attributes);
						?>
						<div class="card">
							<div class="card-header">
								
							</div>
							<div class="card-body">
								<div class="card">
									<div class="card-header">
										TYPE OR COPY AND PASTE YOUR QUESTION HERE BELOW
									</div>
									<div class="card-body">
										<textarea id="question" style="height: 120px;" class=" summernote form-control editor" name="question" /><?php echo isset($result->question) ? htmlspecialchars_decode($result->question) : ''; ?></textarea>
                        				<?php echo form_error('question'); ?>
									</div>
								</div>
								<div class="card">
									<div class="card-header">
										ALLOCATE MARKS (POINTS)
									</div>
									<div class="card-body">
										<?php echo form_input('marks', $result->marks, 'id="marks" placeholder="E.g 5, 10, 20 etc" class="form-control" '); ?>
                        				<?php echo form_error('marks'); ?>
									</div>
								</div>
								<div class="card">
									<div class="card-header">
											TYPE OR COPY AND PASTE YOUR ANSWER HERE BELOW
                        					<br><small class="">(FOR MARKING SCHEME ONLY - NOT VISIBLE TO LEARNERS)</small>
                    					<!-- </h5> -->
									</div>
									<div class="card-body">
										<textarea id="answer" style="height: 120px;" class=" summernote form-control editor" name="answer" /><?php echo isset($result->answer) ? htmlspecialchars_decode($result->answer) : ''; ?></textarea>

										<?php echo form_error('answer'); ?>
									</div>
								</div>
							</div>
							<div class="card-footer text-center">
								<?php echo form_submit( 'submit', 'Update Changes' ,"id='submit' class='btn btn-sm btn-primary'"); ?>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="col-lg-6 col-xl-6 col-md-6">
						<div class="card">
							<div class="card-header">
								<h6 class=""> POSTED QUESTIONS </h6>
							</div>
							<div class="card-body">
								<?php $i = 0;
								if ($questions) { ?>

									<table id="" class="table table-bordered">
										<thead>
											<th>#</th>
											<th>Question</th>
											<th>Action</th>
										</thead>

										<?php foreach ($questions as $p) {
											$i++; ?>

											<tbody>
												<tr>
													<td>
														<?php echo $i ?>.
													</td>
													<td>
														<?php $cc = count_chars($p->question);
														echo strip_tags(substr($p->question, 0, 250), '<p><img><br>');
														if ($cc < 250) echo '...'; ?>
													</td>
													<td width="">
														<div class="btn-group pull-right">
															<a class="btn btn-primary btn-sm" href='<?php echo site_url('qa/trs/edit_questions/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a>

															<!--  <a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('qa/trs/delete_question/' . $post->id . '/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-times'></i> Trash</a> -->
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