<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Question and Answers</h6>
				<div class="float-end">
					<a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
					<?php echo anchor('qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-primary btn-sm pull-right"'); ?>
				</div>
			</div>
			<div class="card-body p-0 mb-2">
				<div class="row justify-content-center">
					<div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
						<div class='row m-2'>
							<div class="col-md-3 control-label" for='title'>Level <span class='required'>*</span></div>
							<div class="col-md-9">
								<?php

								$classes = $this->portal_m->get_class_options();
								echo form_dropdown('level', array('' => 'Select Class') + $classes, (isset($result->level)) ? $result->level : '', ' class="select js-example-placeholder-exam form-control" data-placeholder="Select  Options..." ');

								?>
								<?php echo form_error('level'); ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3 control-label" for='title'>Q&A Title <span class='required'>*</span></div>
							<div class="col-md-9">
								<?php echo form_input('title', $result->title, 'id="title_"  class="form-control" placeholder="E.g Opener Test One"'); ?>
								<?php echo form_error('title'); ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3 control-label" for='subject'>Subject <span class='required'>*</span></div>
							<div class="col-md-9">
								<?php echo form_input('subject', $result->subject, 'id="subject_"  class="form-control" '); ?>
								<?php echo form_error('subject'); ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3 control-label" for='topic'>Topic </div>
							<div class="col-md-9">
								<?php echo form_input('topic', $result->topic, 'id="topic_"  class="form-control" '); ?>
								<?php echo form_error('topic'); ?>
							</div>
						</div>


						<div class='row m-2'>
							<div class="col-md-3 control-label" for='hours'>Duration <span class='required'>*</span></div>
							<div class="col-md-1"><span class="pull-right">Hours</span></div>
							<div class="col-md-3">
								<input id='hours' type='number' name='hours' placeholder="E.g 1, 2 etc" maxlength='' class='form-control ' value="<?php echo isset($result->hours) ? $result->hours : ''; ?>" />
								<?php echo form_error('hours'); ?>
								<br>

							</div>
							<div class="col-md-2 "><span class="pull-right">Minutes</span></div>
							<div class="col-md-3">
								<input id='minutes' type='number' name='minutes' placeholder="E.g 15, 30, 45 etc" maxlength='' class='form-control' value="<?php echo isset($result->minutes) ? $result->minutes : ''; ?>" />
								<?php echo form_error('minutes'); ?>
							</div>
						</div>

						<div class='row mb-2'>
							<div class="col-md-3 control-label" for='topic'>Instruction </div>
							<div class="col-md-9">
								<textarea id="instruction" style="height: 120px;" class=" summernote form-control editor" name="instruction" /><?php echo isset($result->instruction) ? htmlspecialchars_decode($result->instruction) : ''; ?></textarea>

								<?php echo form_error('instruction'); ?>
							</div>
						</div>

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
						<?php echo anchor('qa/trs', 'Cancel', 'class="btn  btn-default"'); ?>
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