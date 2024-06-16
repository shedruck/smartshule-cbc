<div class="portlet mt-2">
	<div class="portlet-heading portlet-default border-bottom">
		<h3 class="portlet-title text-dark">
			<b> Record Of Work Covered </b>
		</h3>
		<div class="pull-right">

			 

			<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		</div>
		<div class="clearfix"></div>
		<hr>
	</div>



	<div class="block-fluid">

		<?php
		$attributes = array('class' => 'form-horizontal', 'id' => '');
		echo   form_open_multipart(current_url(), $attributes);
		?>
		<?php
		$range = range(date('Y') - 1, date('Y') + 1);
		$yrs = array_combine($range, $range);
		krsort($yrs);
		?>

	 

	 

		 
 
	 

		<div class='form-group'>
			<div class="col-md-3  control-label" for='date'>Date </div>
			<div class="col-md-6">
				<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php if ($result->date) {
																													echo isset($result->date) ? date('d M Y', $result->date) : '';
																												} ?>" />
				<?php echo form_error('date'); ?>
			</div>
		</div>

		 
  

		<div class='form-group'>
			<div class="col-md-3 control-label" for='topic'>Work Covered</div>
			<div class="col-md-6">
				<textarea id="work_covered" style="height: 120px;" class=" summernote " name="work_covered" /><?php echo isset($result->work_covered) ? htmlspecialchars_decode($result->work_covered) : ''; ?></textarea>

				<?php echo form_error('work_covered'); ?>
			</div>
		</div>

		<div class='form-group'>
			<div class="col-md-3 control-label" for='topic'>Reflection </div>
			<div class="col-md-6">
				<textarea id="reflection" style="height: 120px;" class=" summernote " name="reflection" /><?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?></textarea>

				<?php echo form_error('reflection'); ?>
			</div>
		</div>


		<div class='form-group'>
			<div class="col-md-3  control-label"></div>
			<div class="col-md-6">


				<?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
				<?php echo anchor('admin/record_of_work_covered', 'Cancel', 'class="btn  btn-default"'); ?>
			</div>
		</div>

		<?php echo form_close(); ?>
		<div class="clearfix"></div>
	</div>
</div>


<script>
	jQuery(function() {

 

		$(".tsel").select2({
			'placeholder': 'Please Select',
			'width': '100%'
		});
	});
</script>