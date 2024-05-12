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
                <h6 class="float-start">LESSON DEVELOPMENT STEPS</h6>
                <div class="btn-group btn-group-sm float-end">
                    <?php echo anchor('lesson_plan/trs/create', '<i class="fa fa-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>
                    <?php echo anchor('lesson_plan/trs', '<i class="fa fa-list">
                </i> ' . lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>
                    <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
                </div>
            </div>
            <div class="card-body p-3 mb-2">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-8 col-lg-8 col-sm-12">
                        <!-- Form Fields Start -->
                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Step</div>
                            <div class="col-md-9">
                                <input type="number" name="step" class="form-control" placeholder="eg.1" required>
                            </div>
                        </div>


                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Description</div>
                            <div class="col-md-9">
                                <textarea id="description" style="height: 120px;" class=" summernote editor form-control" name="description" placeholder="Describe the step above" required /><?php echo isset($result->description) ? htmlspecialchars_decode($result->description) : ''; ?></textarea>


                            </div>
                        </div>

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <label for="stay_here"> Stay on this page after saving ?
                                <input type="checkbox" name="stay_here" id="stay_here" value="1">
                            </label>
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
                    <button class="btn btn-primary pull-right">Save</button>
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