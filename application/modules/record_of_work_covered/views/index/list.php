<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Record Of Work Covered</h6>
				<div class="btn-group btn-group-sm float-end">
					<a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>
			</div>
			<div class="card-body p-3 mb-2">
				<div class="table-responsive">
					<table id="datatable-basic" class="table table-bordered">
						<thead>
							<th>#</th>
							<th>Level</th>
							<th>Period</th>
							<th>Week</th>
							<th>Learning Area</th>
							<th>Strand</th>
							<th>Sub-strand</th>
							<th>Work Covered</th>
							<th><?php echo lang('web_options'); ?></th>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$classes = $this->portal_m->get_class_options();

							foreach ($payload as $p) :
								$i++;
							?>
								<tr>
									<td><?php echo $i . '.'; ?></td>
									<td><?php echo isset($this->classes[$p->schemes->level]) ? $this->classes[$p->schemes->level] : ''; ?></td>

									<td>Term <?php echo $p->schemes->term; ?> <br><?php echo $p->schemes->year; ?> </td>

									<td><?php echo $p->schemes->week; ?> </td>
									<td><?php echo isset($subjects[$p->schemes->subject]) ? strtoupper($subjects[$p->schemes->subject]) : ''; ?></td>
									<td><?php echo $p->schemes->strand; ?></td>
									<td><?php echo $p->schemes->substrand; ?></td>
									<td><?php echo $p->work_covered; ?></td>


									<td width='220'>
										<div class="btn-group my-2">
                                            <button type="button" class="btn btn-success-light dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item btn btn-sm text-success" href='<?php echo site_url('record_of_work_covered/trs/view/' . $p->plan . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a></li>

                                                <li><a class="dropdown-item btn btn-sm text-primary" href='<?php echo site_url('record_of_work_covered/trs/edit/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a></li>

                                                <li><a class="dropdown-item btn btn-sm text-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('record_of_work_covered/trs/delete/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-trash'></i> Trash</a></li>
                                            </ul>
                                        </div>
									</td>


								</tr>
							<?php endforeach ?>
						</tbody>
					</table>


				</div>
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