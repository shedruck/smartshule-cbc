<?php $cl = $this->portal_m->get_class_options(); ?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">
					<?php $cl = $this->portal_m->get_class_options();
					echo strtoupper($cl[$post->level]); ?> - Multiple Choices Given Quiz
				</h6>
				<div class="float-end">
					<?php echo anchor('mc/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "'); ?>
					<a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>

			</div>
			<div class="card-body p-2">
				<!-- Content Here for remarks -->
				<div class="row">
					<!-- <div class="col-sm-12"> -->

					<h6>TITLE: <?php echo $post->title ?> </h6>
					<hr>

					<?php $i = 0;
					if ($given) { ?>
						<div class="table-responsive">
						<table id="" class="table table-bordered">
							<thead>
								<th>Photo</th>
								<th>Student</th>
								<th>ADM No.</th>
								<th>Submitted On</th>
								<th>Status</th>

								<th>Checked</th>
								<th>Action</th>
							</thead>

							<?php

							foreach ($given as $p) {
								$i++;
								$st = $this->portal_m->find($p->student); ?>

								<tbody>
									<tr>
										<td class="text-center">
											<?php
											if (!empty($st->photo)) :
												if ($passport = $this->portal_m->student_passport($st->photo)) {
											?>
													<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="50" height="50" class="img-circle img-thumbnail1">
													<?php } ?>

												<?php else : ?>
													<image src="<?php echo base_url('uploads/files/member.png'); ?>" width="60" height="60" class=" text-center">

													<?php endif; ?>
										</td>
										<td>
											<?php echo $st->first_name; ?> <?php echo $st->middle_name; ?> <?php echo $st->last_name; ?>
										</td>
										<td>
											<br>
											<?php
											if (!empty($st->old_adm_no)) {
												echo $st->old_adm_no;
											} else {
												echo $st->admission_number;
											}
											?>
										</td>
										<td>
											<?php echo isset($p->modified_on) ? date('d M Y', $p->modified_on) : ''; ?>
										</td>
										<td>
											<?php
											if ($p->done == 1) {
											?>
												<span class="label label-success">Done</span>
											<?php } else { ?>
												<span class="label label-danger">Pending</span>
											<?php } ?>
										</td>

										<td>
											<?php
											if ($p->rmk_date) {
											?>
												<span class="label label-info">Yes</span>
											<?php } else { ?>
												<span class="label label-warning">Pending</span>
											<?php } ?>
										</td>

										<td id="rmk_<?php echo $p->id ?>">
											<div class="btn-group">
												<?php
												if ($p->done == 1) {
												?>
													<?php
													if (!$p->rmk_date) {
													?>
														<a class="btn btn-success btn-sm" href='<?php echo site_url('mc/trs/mc_result/' . $post->id . '/' . $p->student . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-edit'></i> Give Remarks</a>
													<?php } ?>
													<a class="btn btn-primary btn-sm" href='<?php echo site_url('mc/trs/mc_result/' . $post->id . '/' . $p->student . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-folder-open'></i> View Results</a>
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
					<!-- end col -->


					<!-- Content Here for remarks -->
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
	<script>
		$(function() {
			$(".checks").on('change', function() {
				$("input.check-lef").each(function() {
					$(this).prop("checked", !$(this).prop("checked"));
				});
			});

			$(".checkall").on('change', function() {
				$("input.check").each(function() {
					$(this).prop("checked", !$(this).prop("checked"));
				});
			});
		});
	</script>