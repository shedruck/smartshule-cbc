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
				<h6 class="float-start">Lesson Materials</h6>
				<div class="btn-group btn-group-sm float-end">
					<a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
					<?php echo anchor('lesson_materials/trs/', '<i class="fa fa-plus"></i> All Lesson Materials', 'class="btn btn-primary btn-sm pull-right"'); ?>
				</div>
			</div>
			<div class="card-body p-3 mb-2">
				<div class="row justify-content-center">
					<div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
						<!-- Form Fields Start -->
						<div class='row m-2'>
							<div class="col-md-3 control-label" for='year'>Year <span class='required'>*</span></div>
							<div class="col-md-9">
								<?php
								echo form_dropdown('year', array('' => '') + $yrs, (isset($result->year) && !empty($result->year)) ? $result->year : date('Y'), ' class="form-control js-example-placeholder-exam" placeholder="Select Year" ');
								echo form_error('year');
								?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3 control-label" for='class'>Class <span class='required'>*</span></div>
							<div class="col-md-9">
								<?php
								$classes = $this->portal_m->get_class_options();
								echo form_dropdown('class', array('' => 'Select Class') + $classes + array('999' => 'Any class'), (isset($result->class)) ? $result->class : '', ' class="form-control class" id="class" data-placeholder="" ');
								?>
								<?php echo form_error('class'); ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3 control-label" for='subject'>Subject/Learning Area <span class='required'>*</span></div>
							<div class="col-md-9">
								<?php
								$items = array('' => 'Select Subject');
								echo form_dropdown('subject', $items, (isset($result->subject)) ? $result->subject : '', ' id="subject" class="form-control js-example-placeholder-exam" data-placeholder="Select Options..." ');
								echo form_error('subject');
								?>
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
							<div class="col-md-3 control-label" for='subtopic'>Subtopic </div>
							<div class="col-md-9">
								<?php echo form_input('subtopic', $result->subtopic, 'id="subtopic_"  class="form-control" '); ?>
								<?php echo form_error('subtopic'); ?>
							</div>
						</div>

						<div class='row m-2'>
							<div class="col-md-3 control-label" for='file'>Upload a attachment (pdf/word/image) </div>
							<div class="col-md-9">
								<input id='file' type='file' class="form-control" name='file' />

								<?php if ($updType == 'edit') : ?>
									<a target="_blank" href='<?php echo base_url() ?><?php echo $result->file_path ?><?php echo $result->file_name; ?>' />Download actual file</a>
								<?php endif ?>

								<br /><?php echo form_error('file'); ?>
								<?php echo (isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
							</div>
						</div>


						<div class='row m-2'>
							<div class="col-md-3 control-label" for='topic'>Soft (Paste Soft copy here if not attachment) </div>
							<div class="col-md-9">
								<textarea id="soft" style="height: 120px;" class="form-control editor" name="soft" /><?php echo isset($result->soft) ? htmlspecialchars_decode($result->soft) : ''; ?></textarea>

								<?php echo form_error('soft'); ?>
							</div>
						</div>


						<div class='row m-2'>
							<div class="col-md-3 control-label " for='topic'>Comment</div>
							<div class="col-md-9">
								<textarea id="comment" style="height: 120px;" class="form-control editor" name="comment" /><?php echo isset($result->comment) ? htmlspecialchars_decode($result->comment) : ''; ?></textarea>

								<?php echo form_error('comment'); ?>
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
					<?php echo anchor('trs/lesson_materials', 'Cancel', 'class="btn  btn-default"'); ?>
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

		$(".tsel").select2({
			'placeholder': 'Please Select',
			'width': '100%'
		});
	});
</script>