<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);

$range = range(date('Y') - 1, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Record Of Work Covered</h6>
				<div class="btn-group btn-group-sm float-end">
					<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>
			</div>
			<div class="card-body p-3 mb-2">
				<div class="row justify-content-center">
					<div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
						<!-- Form Fields Start -->
						<div class='row m-2'>
							<div class="col-md-3  control-label" for='date'>Date </div>
							<div class="col-md-9">
								<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php if ($result->date) {
																																	echo isset($result->date) ? date('d M Y', $result->date) : '';
																																} ?>" />
								<?php echo form_error('date'); ?>
							</div>
						</div>




						<div class='row m-2'>
							<div class="col-md-3 control-label" for='topic'>Work Covered</div>
							<div class="col-md-9">
								<textarea id="work_covered" style="height: 120px;" class=" form-control editor" name="work_covered" /><?php echo isset($result->work_covered) ? htmlspecialchars_decode($result->work_covered) : ''; ?></textarea>

								<?php echo form_error('work_covered'); ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3 control-label" for='topic'>Reflection </div>
							<div class="col-md-9">
								<textarea id="reflection" style="height: 120px;" class=" form-control editor" name="reflection" /><?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?></textarea>

								<?php echo form_error('reflection'); ?>
							</div>
						</div>
						<!-- Form Fields End -->
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="form-check d-inline-block">
					<!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
				</div>
				<div class="float-end d-inline-block btn-list">
					<?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
					<?php echo anchor('trs/record_of_work_covered', 'Cancel', 'class="btn  btn-default"'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
<style>
	.card-header {
		display: flex;
		justify-content: space-between;
	}
</style>