<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Multiple Choices </h6>
				<div class="btn-group btn-group-sm float-end" role="group">
					<?php echo anchor('mc/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-primary btn-sm "'); ?>
					<a class="btn btn-sm btn-danger" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
					<?php echo anchor('mc/trs/', '<i class="fa fa-home"> </i> Exit', 'class="btn btn-sm btn-warning"'); ?>
				</div>
			</div>
			<div class="card-body mb-2">
				<div class="row">
					<div class="col-lg-6 col-xl-6 col-md-6">
						<?php
						$mcs = $this->ion_auth->populate('mc_questions', 'id', 'question');
						$attributes = array('class' => 'form-horizontal', 'id' => '');
						echo   form_open_multipart(current_url(), $attributes);
						?>
						<div class="card">
							<div class="card-header">

							</div>
							<div class="card-body">
								<div class="card">
									<div class="card-header bg-default">
										TYPE OR COPY AND PASTE YOUR QUESTION HERE BELOW
									</div>
									<div class="card-body">
										<textarea id="ckeditor1" class=" summernote form-control" name="question" /><?php echo isset($mcs[$id]) ? htmlspecialchars_decode($mcs[$id]) : ''; ?></textarea>
										<?php echo form_error('question'); ?>
									</div>
								</div>
								<div class="card">
									<div class="card-header bg-default">
										TYPE OR COPY AND PASTE YOUR CHOICES HERE BELOW
										<!-- </h5> -->
									</div>
									<div class="card-body">
										<!-- Choices Start -->
										<table class="table table-hover table-bordered ">
											<tbody>


												<?php $i = 0;
												foreach ($choices as $c) {
													$i++; ?>
													<tr>

														<td width="8%">
															<span id="reference" name="reference" class="heading-reference"><?php echo $i; ?>.</span>
															<input name="counter[]" type="hidden" value="<?php echo $i; ?>">
															<input name="ids[]" type="hidden" value="<?php echo $c->id; ?>">
														</td>

														<td width="50%">
															<textarea class="form-control slim choice" rows="1" cols="45" name="choice[]" /><?php echo set_value('choice', (isset($c->choice)) ? htmlspecialchars_decode($c->choice) : ''); ?></textarea>

														</td>

														<td width="42%">
															<?php

															$items = array('0' => 'Wrong', '1' => 'Correct');
															echo form_dropdown('state[]', $items, (isset($c->state)) ? $c->state : '', ' class=" form-control state" ');
															?>

														</td>
													</tr>
												<?php } ?>

											</tbody>
										</table>
										<!-- Choices End -->
									</div>
								</div>
							</div>
							<div class="card-footer text-center">
								<?php echo form_submit('submit', 'Update Changes', "id='submit' class='btn btn-sm btn-primary'"); ?>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="col-lg-6 col-xl-6 col-md-6">
						<div class="card">
							<div class="card-header bg-default">
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
															<a class="btn btn-primary btn-sm" href='<?php echo site_url('mc/trs/mc_edit_question/' . $post . '/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a>

															<!-- <a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('mc/trs/delete_question/' . $post->id . '/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-times'></i> Trash</a>-->
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