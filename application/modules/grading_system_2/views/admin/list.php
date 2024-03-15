<div class="head">
	<div class="icon"><span class="icosg-target1"></span></div>
	<h2> Grading System </h2>
	<div class="right">
		<?php echo anchor('admin/grading_system/create/' . $page, '<i class="glyphicon glyphicon-plus">                </i>' . lang('web_add_t', array(':name' => 'Grading System')), 'class="btn btn-primary"'); ?>

		<?php echo anchor('admin/grading_system', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => ' Grading Systems')), 'class="btn btn-primary"'); ?>


		<?php echo anchor('admin/effort', '<i class="glyphicon glyphicon-list">
                </i> Manage  Grading Effort', 'class="btn btn-warning"'); ?>

	</div>
</div>

<?php if ($grading_system) : ?>
	<div class="block-fluid">
		<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<th>#</th>
				<th>Title</th>
				<th>Pass Mark</th>
				<th>Created By</th>
				<th>Created on</th>
				<th>Description</th>
				<th><?php echo lang('web_options'); ?></th>
			</thead>
			<tbody>
				<?php
				$i = 0;
				if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}

				foreach ($grading_system as $p) :
					$i++;
					$user = $this->ion_auth->get_user($p->created_by);
				?>
					<tr>
						<td><?php echo $i . '.'; ?></td>
						<td><?php echo $p->title; ?></td>
						<td><?php echo $p->pass_mark; ?></td>
						<td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
						<td><?php echo date('d/m/Y', $p->created_on); ?></td>
						<td><?php
							echo $p->description;

							?></td>
						<td width="20%">
							<div class="btn-group">

								<a class='btn btn-primary' href="<?php echo site_url('admin/grading_system/edit/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>


								<a class='btn btn-success' href="<?php echo site_url('admin/grading_system/grades_add/' . $p->id); ?>"><i class="glyphicon glyphicon-plus"></i> Add Grades</a>
								<!--a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/grading_system/delete/' . $p->id . '/' . $page); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a-->
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>

		</table>
	</div>

	<?php echo $links; ?>
	</div>
	</div>
	</div>
	</div>

	</div>

<?php else : ?>
	<p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>