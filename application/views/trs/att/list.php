
        <div class="card-box table-responsive ">
		
		 <h2> Class Attendance 
			<div class="pull-right">
				<?php echo anchor('trs/attendance', '<i class="mdi mdi-reply"></i>Back', 'class="btn btn-primary"'); ?>
			</div>    					
		</h2> 
	<hr>
	
	<?php if ($class_attendance): ?>
            <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Taken on</th>
                        <th width="22%"><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($class_attendance as $p):

                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo date('d M Y', $p->attendance_date); ?></td>
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                <td width="34%">
                                    <div class='btn-d'>
                                        <a href="<?php echo site_url('trs/view_register/' . $p->id); ?>" class="btn btn-success"><i class="mdi mdi-account-search"></i> View Register</a>
                                        <a href="<?php echo site_url('trs/edit_register/' . $p->id); ?>" class="btn btn-purple"><i class="mdi mdi-pencil"></i> Edit</a>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
       
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?> 
</div>