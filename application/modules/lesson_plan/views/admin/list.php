<div class="row">
	<div class="col-md-9">
		<div class="head">
			<div class="icon"><span class="icosg-target1"></span> </div>
			<h2> Lesson Plan </h2>
			<div class="right">
				<?php echo anchor('admin/lesson_plan/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>

				<?php echo anchor('admin/lesson_plan', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>

			</div>
		</div>


		<?php if ($lesson_plan): ?>
			<div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
					<thead>
						<th>#</th>
						<th>Teacher</th>
						<th>Subject</th>
						<th>Strand</th>
						<th>Substrand</th>
						<th>
							<?php echo lang('web_options'); ?>
						</th>
					</thead>
					<tbody>
						<?php
						$i = 0;
						// if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
						// 	$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
						// }
					
						foreach ($lesson_plan as $p):
							$sub = isset($subjects[$p->Scheme->subject]) ? $subjects[$p->Scheme->subject] : '';
							$i++;
							?>
							<tr>
								<td>
									<?php echo $i . '.'; ?>
								</td>
								<td>
									<?php echo isset($teachers[$p->created_by]) ? $teachers[$p->created_by] : '' ?>
								</td>
								<td>
									<?php echo $sub; ?>
								</td>
								<td>
									<?php echo $p->Scheme->strand; ?>
								</td>
								<td>
									<?php echo $p->Scheme->substrand; ?>
								</td>

								<td width='30'>
									<a class="btn btn-primary"
										href='<?php echo site_url('lesson_plan/trs/view/' . $p->id . '/' . $p->scheme); ?>'><i
											class='fa fa-file'></i> View </a>

								</td>
							</tr>
						<?php endforeach ?>
					</tbody>

				</table>
			</div>

		<?php else: ?>
			<p class='text'>
				<?php echo lang('web_no_elements'); ?>
			</p>
		<?php endif ?>
	</div>
	<div class="col-md-3">

		<div class="head">
			<div class="icon"><span class="icosg-target1"></span> </div>
			<h2> Select Teacher </h2>
		</div>

		<div class="block-fluid" style="display: flex; flex-direction: column; align-items: center;">
			<?php foreach ($teachers as $id => $teacher): ?>
				<a href="<?php echo base_url('admin/lesson_plan') . '/index/' . $id; ?>"
					style="display: flex; flex-direction: column; align-items: center; margin-bottom: 10px; text-align: center; width: 100%">
					<p style="
						border-bottom: 2px solid #ffd85b;
						width: 100%;
						position: relative;
						">
						<?php echo $teacher; ?>

						<span class="badge bg-success" style="position: absolute; top: 0; right: 0;"><?php echo $this->lesson_plan_m->count_for_teacher($id); ?></span>
					</p>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>