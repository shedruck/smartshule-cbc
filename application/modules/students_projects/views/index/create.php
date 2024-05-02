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
					<div class="col-dm-8 col-xl-6 col-lg-6 col-sm-12">
						<div class="row m-2">
                        <label for="inputName" class="col-md-3 form-label">User Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="inputName" placeholder="Name" autocomplete="username">
                        </div>
                        </div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div class="form-check d-inline-block">
					<input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label>
				</div>
				<div class="float-end d-inline-block btn-list">
					<button type="submit" class="btn btn-primary" id="submitButton"><i class="fe fe-check-square me-1 lh-base"></i>Submit</button>
					<a class="btn btn-secondary" id="cancelButton"><i class="fe fe-arrow-left-circle me-1 lh-base"></i>Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>