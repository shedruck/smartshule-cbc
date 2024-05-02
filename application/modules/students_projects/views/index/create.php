<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h6 class="float-start">Student Projects</h6>
				<div class="float-end">
					<?php echo anchor('students_projects/trs', '<i class="fa fa-list">
                </i> ' . lang('web_list_all', array(':name' => 'Students Projects')), 'class="btn btn-primary"'); ?>

					<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
				</div>
			</div>
			<div class="card-body p-0">
				<div class="row justify-content-center">
					<div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
						<div class="row m-2">
							<label for="inputName" class="col-md-3 form-label">Class/Level <span class='required'>*</span></label>
							<div class="col-md-9">
								<?php
								$classes = $this->portal_m->get_class_options();
								echo form_dropdown('level', array('' => 'Select Level') + $classes + array('999' => 'Any level'), (isset($result->level)) ? $result->level : '', ' class="select form-control" id="class" data-placeholder="" ');
								?>
								<!-- <input type="text" class="form-control" id="inputName" placeholder="Name" autocomplete="username"> -->
							</div>
						</div>
						<div class='row m-2'>
							<div class="col-md-3 form-label" for='student'>Student <span class='required'>*</span></div>
							<div class="col-md-9">
								<select name="student" class="select select_stud form-control js-example-basic-single" id="select_stud" style="" tabindex="-1">
									<option value="">Search Student</option>
									<?php
									$data = $this->ion_auth->students_full_details();
									foreach ($data as $key => $value) :
									?>
										<option value="<?php echo $key; ?>"><?php echo $value ?></option>
									<?php endforeach; ?>

									<?php echo form_error('student'); ?>
								</select>

								<?php echo form_error('student'); ?>
							</div>
						</div>
						<?php
						$range = range(date('Y') - 1, date('Y') + 1);
						$yrs = array_combine($range, $range);
						krsort($yrs);
						?>

						<div class='row m-2'>
							<div class="col-md-3 " for='day'>Select Year <span class="required">*</span> </div>
							<div class="col-md-9">
								<?php

								echo form_dropdown('year', array(date('Y') => date('Y')) + $yrs, (isset($result->year)) ? $result->year : '', ' class="select form-control js-example-basic-single" data-placeholder="Select Options..." ');

								?>
								<?php echo form_error('year'); ?>
							</div>
						</div>


						<div class='row m-2'>
							<div class="col-md-3 " for='day'>Term <span class="required">*</span> </div>
							<div class="col-md-9">
								<?php

								$settings = $this->ion_auth->settings();

								$items = array(
									'1' => 'Term 1',
									'2' => 'Term 2',
									'3' => 'Term 3',

								);
								echo form_dropdown('term', array($settings->term => 'Term ' . $settings->term) + $items, (isset($result->term)) ? $result->term : '', ' class="select form-control js-example-basic-single" data-placeholder="Select Options..." ');

								?>
								<?php echo form_error('term'); ?>
							</div>
						</div>


						<div class='row m-2'>
							<div class="col-md-3" for='subject'>Subject/Learning Area <span class='required'>*</span></div>
							<div class="col-md-9">
								<?php
								$items = array('' => 'Select Subject');
								echo form_dropdown('subject', $items, (isset($result->subject)) ? $result->subject : '', ' id="subject" class="select form-control js-example-basic-single" data-placeholder="Select Options..." ');
								echo form_error('subject');
								?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3" for='strand'>Strand </div>
							<div class="col-md-9">
								<?php echo form_input('strand', $result->strand, 'id="strand_"  class="form-control" '); ?>
								<?php echo form_error('strand'); ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3" for='file'>Upload Picture</div>
							<div class="col-md-9">
								<input id='file' type='file' name='file' />

								<?php if ($updType == 'edit') : ?>
									<a target="_blank" href='<?php echo base_url() ?><?php echo $result->file_path ?>/<?php echo $result->file_name ?>' />Download actual file (file)</a>
								<?php endif ?>

								<br /><?php echo form_error('file'); ?>
								<?php echo (isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="control-label" for='topic'>Remarks</div>
							<div class="col-md-12">
								<textarea id="editor" style="height: 120px;" class=" summernote form-control" name="remarks" /><?php echo isset($result->remarks) ? htmlspecialchars_decode($result->remarks) : ''; ?></textarea>

								<?php echo form_error('remarks'); ?>
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
					<!-- <button type="submit" class="btn btn-primary" id="submitButton"><i class="fe fe-check-square me-1 lh-base"></i>Submit</button> -->
					<!-- <a class="btn btn-secondary" id="cancelButton"><i class="fe fe-arrow-left-circle me-1 lh-base"></i>Cancel</a> -->
					<?php echo anchor('admin/students_projects', 'Cancel', 'class="btn  btn-secondary"'); ?>
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
<script>
	jQuery(function() {

		jQuery("#class").change(function() {
			jQuery('#subject').empty();

			var level = jQuery(".class").val();

			var options = '';
			jQuery('#subject').children().remove();

			jQuery.getJSON("<?php echo base_url('admin/evideos/list_subjects'); ?>", {
				id: jQuery(this).val()
			}, function(data) {


				for (var i = 0; i < data.length; i++) {

					options += '<option value="' + data[i].optionValue + '">' + data[i].optionDisplay + '</option>';
				}

				jQuery('#subject').append(options);

			});

			//alert(options);
		});

		// $(".tsel").select2({
		// 	'placeholder': 'Please Select',
		// 	'width': '100%'
		// });
	});
</script>