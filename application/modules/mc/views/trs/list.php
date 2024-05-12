<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Multiple Choices </h6>
				<div class="btn-group btn-group-sm float-end" role="group">
					<a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
					<?php echo anchor('mc/trs/create/' . $this->session->userdata['session_id'], '<i class="fa fa-plus"></i> New Multiple Choices', 'class="btn btn-primary btn-sm pull-right"'); ?>
				</div>

			</div>
			<div class="card-body p-2">
				<?php if ($mc) : ?>
					<div class="table-responsive">
						<table id="datatable-basic" class="table table-bordered">
							<thead>
								<th>#</th>
								<th>Level</th>
								<th>Title</th>
								<th>Duration</th>
								<th>Subject</th>
								<th>Topic</th>
								<th>Questions</th>

								<th><?php echo lang('web_options'); ?></th>
							</thead>
							<tbody>
								<?php
								$i = 0;

								$classes = $this->portal_m->get_class_options();
								foreach ($mc as $p) :

									$mcs = $this->portal_m->count_records('mc', $p->id, 'mc_questions');
									$i++;
								?>
									<tr>
										<td><?php echo $i . '.'; ?></td>
										<td><?php echo $classes[$p->level]; ?></td>
										<td><?php echo $p->title; ?></td>
										<td><?php echo isset($p->hours) ? $p->hours : '0'; ?>hrs : <?php echo isset($p->minutes) ? $p->minutes : '00'; ?> mins</td>
										<td><?php echo $p->subject; ?></td>
										<td><?php echo $p->topic; ?></td>
										<td><span class="label label-info"><?php echo $mcs; ?></span></td>


										<td width=''>
											<!-- <div class='btn-group pull-right'>
												<a class="btn btn-success btn-sm" href='<?php echo site_url('mc/trs/manage/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-share'></i> Manage M.Choices </a>
												<a class="btn btn-primary btn-sm" href='<?php echo site_url('mc/trs/edit/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a>
												<?php if ($mcs > 0) { ?>
													<a class="btn btn-warning btn-sm" href='<?php echo site_url('mc/trs/view_mc/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-list'></i> View Details</a>
												<?php } else { ?>
													<a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('mc/trs/delete/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa  fa-times'></i> Trash</a>
												<?php } ?>
											</div> -->

											<div class="btn-group my-2">
                                                    <button type="button" class="btn btn-success-light dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                                                      Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item text-success" href='<?php echo site_url('mc/trs/manage/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a></li>
                                                        <li><a class="dropdown-item text-primary" href='<?php echo site_url('mc/trs/edit/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a></li>
														<?php if ($qs > 0) { ?>
															<li><a class="dropdown-item text-warning" href='<?php echo site_url('mc/trs/view_mc/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-list'></i> View</a></li>
														<?php } else { ?>	
															<li><a class="dropdown-item text-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('mc/trs/delete/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-trash'></i> Trash</a></li>
														<?php } ?>
                                                        
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