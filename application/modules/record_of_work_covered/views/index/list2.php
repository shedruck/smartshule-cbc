<div class="portlet mt-2">
	<div class="portlet-heading portlet-default border-bottom">
		<h3 class="portlet-title text-dark">
			<b> Record Of Work Covered </b>
		</h3>
		<div class="pull-right">

		 

			<a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		</div>

		<div class="clearfix"></div>
		<hr>
	</div>


	<?php if ($payload) : ?>
		<div class="block-fluid">
			<table id="datatable-buttons" class="table table-striped table-bordered">
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
								<div class='btn-group center text-center'>
									<a class="btn btn-sm btn-success" href='<?php echo site_url('record_of_work_covered/trs/view/' . $p->plan . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a>
									<a class="btn btn-sm btn-primary" href='<?php echo site_url('record_of_work_covered/trs/edit/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a>
									<a class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('record_of_work_covered/trs/delete/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-trash'></i> Trash</a>
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