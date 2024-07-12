
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Schemes of Work</h6>
				<div class="btn-group btn-group-sm float-end" role="group">
					<?php echo anchor('schemes_of_work/trs/create/' . $page, '<i class="fa fa-square-plus">
                    </i> ' . lang('web_add_t', array(':name' => 'Schemes of work')), 'class="btn btn-primary"'); ?>
					<?php echo anchor('schemes_of_work/trs/upload_excel/', '<i class="fa fa-square-plus">
                    </i> ' . lang('web_add_t', array(':name' => 'Upload')), 'class="btn btn-info"'); ?>
					<a class="btn btn-warning" href="<?php echo base_url('schemes_of_work/trs/report') ?>"> Report</a>
					<a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>
			</div>
			<div class="card-body p-3 mb-2">
				<!-- <div class="row justify-content-center"> -->
					<div class="table-responsive">
						<table id="datatable-basic" class="table table-bordered">
							<thead class="bg-default">
								<th>#</th>

								<th>Level</th>

								<th>subject</th>
								<th>Lesson</th>
								<th>Strand</th>
								<th>Specific Learning Outcomes</th>
								<th>Key Inquiry Question</th>

								<th><?php echo lang('web_options'); ?></th>
							</thead>
							<tbody>
								<?php
								$i = 0;
								$classes = $this->portal_m->get_class_options();
								foreach ($schemes_of_work as $p) :
									$sub = $this->portal_m->get_subject($p->level);
									$i++;
								?>
									<tr>
										<td><?php echo $i . '.'; ?></td>
										<td><?php echo $classes[$p->level]; ?> <br> Term <?php echo $p->term; ?> <?php echo $p->year; ?><br> <b>Week:</b><?php echo $p->week; ?></td>
										<td>
											<?php 
												// echo $p->subject;
												echo strtoupper($sub[$p->subject]); 
											?>
										</td>
										<td><?php echo $p->lesson; ?></td>
										<td><?php echo $p->strand; ?><br> <b>Sub-strand:</b> <?php echo $p->substrand; ?></td>
										<td><?php echo $p->specific_learning_outcomes; ?></td>
										<td><?php echo $p->key_inquiry_question; ?></td>


										<td width='220'>
											<div class="btn-group my-2">
                                                    <button type="button" class="btn btn-success-light dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item text-success" href='<?php echo site_url('schemes_of_work/trs/view_scheme/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a></li>
                                                        <li><a class="dropdown-item text-primary" href='<?php echo site_url('schemes_of_work/trs/edit/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a></li>
                                                        <li><a class="dropdown-item text-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('schemes_of_work/trs/delete/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-trash'></i> Trash</a></li>
                                                    </ul>
                                            </div>
										</td>


									</tr>
								<?php endforeach ?>
							</tbody>

						</table>


					</div>
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