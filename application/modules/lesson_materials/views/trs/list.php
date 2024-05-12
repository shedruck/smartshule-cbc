<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Lesson Materials</h6>
				<div class="btn-group btn-group-sm float-end" role="group">
					<a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
					<?php echo anchor('lesson_materials/trs/new_lesson_materials/' . $this->session->userdata['session_id'], '<i class="fa fa-plus"></i> New Lesson Material', 'class="btn btn-primary btn-sm pull-right"'); ?>
				</div>
			</div>
			<div class="card-body p-3 mb-2">
				<!-- <div class="row justify-content-center"> -->
				<?php if ($lesson_materials) : ?>
					<div class="table-responsive">
						<table id="datatable-basic" class="table table-bordered">
							<thead>
								<th>#</th>
								<th>Class</th>
								<th>Subject</th>
								<th>Topic</th>
								<th>Subtopic</th>
								<th>File</th>
								<th>Status</th>

								<th><?php echo lang('web_options'); ?></th>
							</thead>
							<tbody>
								<?php
								$i = 0;

								$classes = $this->portal_m->get_class_options();
								foreach ($lesson_materials as $p) :
									$sub = $this->portal_m->get_subject($p->class);
									$i++;
								?>
									<tr>
										<td><?php echo $i . '.'; ?></td>
										<td><?php echo $classes[$p->class]; ?></td>
										<td><?php echo strtoupper($sub[$p->subject]); ?></td>
										<td><?php echo $p->topic; ?></td>
										<td><?php echo $p->subtopic; ?></td>
										<td><a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url() ?><?php echo $p->file_path ?><?php echo $p->file_name; ?>' /><i class='fa fa-arrow-down'></i> Download</a></td>

										<td>
											<?php
											if ($p->status == 1) {
											?>
												<a class="btn btn-sm btn-danger" onClick="return confirm('Are you sure you want to unpublish this lesson material?')" href='<?php echo site_url('lesson_materials/trs/update_status/' . $p->id . '/0'); ?>'><i class='fa fa-download'></i> Unpublish</a>

											<?php } else { ?>

												<a class="btn btn-sm btn-success" onClick="return confirm('Are you sure you want to publish this lesson material?')" href='<?php echo site_url('lesson_materials/trs/update_status/' . $p->id . '/1'); ?>'><i class='fa fa-upload'></i> Publish</a>
											<?php } ?>
										</td>



										<td width=''>
											<div class="btn-group my-2">
												<button type="button" class="btn btn-success-light dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
													Action
												</button>
												<ul class="dropdown-menu">
													<li><a class="dropdown-item btn btn-sm text-success" href='<?php echo site_url('lesson_materials/trs/view/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a></li>

													<li><a class="dropdown-item btn btn-sm text-primary" href='<?php echo site_url('lesson_materials/trs/edit/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a></li>

													<li><a class="dropdown-item btn btn-sm text-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('lesson_materials/trs/delete/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-trash'></i> Trash</a></li>
												</ul>
											</div>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>

						</table>


					</div>

				<?php else : ?>
					<p class='text'><?php echo lang('web_no_elements'); ?></p>
				<?php endif ?>
				<!-- </div> -->
			</div>
			<div class="card-footer">
				<div class="form-check d-inline-block">
					<!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
				</div>
				<div class="float-end d-inline-block btn-list">

				</div>
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