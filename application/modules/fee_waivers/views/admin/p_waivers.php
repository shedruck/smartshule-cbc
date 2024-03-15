<div class="head"> 
        <div class="icon"><span class="icosg-target1"></span> </div>
        <h2> Fee Waivers Pending Tray  </h2>
        
    </div>
<div class="block-fluid">
	<div class="table-responsive">
		<?php echo form_open(current_url())?>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Student</th>
					<th>Term</th>
					<th>Year</th>
					<th>Amount</th>
					<th>Description</th>
					<th>Recorded By</th>
					<th>Recorded On</th>
					<th width="5%"><input type="checkbox" class="checkall"/></th>
				</tr>
			</thead>
			<tbody>
				<?php
				   $index = 1;
					foreach($pending as $p)
					{
						$student = $this->ion_auth->list_student($p->student);
						$user = $this->ion_auth->get_user($p->created_by);

				?>

				<tr>
					<td><?php echo $index ?></td>
					<td><?php echo ucwords($student->first_name.' '.$student->last_name)?></td>
					<td><?php echo $p->term?></td>
					<td><?php echo $p->year?></td>
					<td><?php echo number_format($p->amount,2)?></td>
					<td><?php echo  $p->remarks?></td>
					<td><?php echo ucwords($user->first_name.' '.$user->last_name)?></td>
					<td><?php echo date('dS m, Y',$p->created_on)?></td>
					<td><input type="checkbox" name="items[]" value="<?php echo $p->id ?>"/></td>
					
				</tr>
			<?php $index++; }?>
			</tbody>
		</table>
		<button class="btn btn-primary pull-right" type="submit">Approve Selected</button>
		<?php echo form_close() ?>
	</div>
</div>