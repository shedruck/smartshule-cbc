<div class="head">
	<div class="icon"><span class="icosg-target1"></span> </div>
	<h2> Igcse Threads </h2>
	<div class="right">
		<?php echo anchor('admin/igcse/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Igcse')), 'class="btn btn-primary"'); ?>

		<?php echo anchor('admin/igcse', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Igcse')), 'class="btn btn-primary"'); ?>

	</div>
</div>


<?php if ($igcse) : ?>
	<div class="block-fluid">
		<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<th>#</th>
				<th>Exam Thread</th>
				<th>Term</th>
				<th>Year</th>
				<th>CATS Weight</th>
				<th>Main Exam Weight</th>
				<th>Description</th>
				<th><?php echo lang('web_options'); ?></th>
			</thead>
			<tbody>
				<?php
				$i = 0;
				if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}

				foreach ($igcse as $p) :
					$i++;
				?>
					<tr>
						<td><?php echo $i . '.'; ?></td>
						<td><?php echo $p->title; ?></td>
						<td><?php echo isset($this->terms[$p->term]) ? $this->terms[$p->term] : ' '; ?></td>
                        <td><?php echo $p->year; ?></td>
						<td><?php echo $p->cats_weight ?></td>
						<td><?php echo $p->main_weight ?></td>
						<td><?php echo $p->description ?></td>
						<td width=''>
							<?php echo anchor('admin/igcse/exams/' . $p->id, 'Thread Exams', 'class="btn btn-success"'); ?>  
							<?php echo anchor('admin/igcse/compute/' . $p->id, 'Compute Marks', 'class="btn btn-info mt-2 text-center"'); ?>
							<?php echo anchor('admin/igcse/bulk/' . $p->id, 'Report Forms', 'class="btn btn-success"'); ?>
                                    <div class="btn-group">
                                        <a  class="btn btn-primary " href="<?php echo site_url('admin/igcse/edit/' . $p->id . '/' . $page); ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <?php
                                        if ($this->ion_auth->is_in_group($this->user->id, 1))
                                        {
                                                ?>
                                                <a  class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/igcse/delete/' . $p->id . '/' . $page); ?>'><span class="glyphicon glyphicon-remove"></span> </a>
                                        <?php } ?>
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