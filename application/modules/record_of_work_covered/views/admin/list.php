<div class="head">
	<div class="icon"><span class="icosg-target1"></span> </div>
	<h2> Record Of Work Covered </h2>
	<div class="right">
	 
		<?php echo anchor('admin/record_of_work_covered', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Record Of Work Covered')), 'class="btn btn-primary"'); ?>

	</div>
</div>


<?php if ($payload) : ?>
	<div class="block-fluid">
		<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
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