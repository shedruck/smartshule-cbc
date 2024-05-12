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
                <h6 class="float-start">Schemes of Work</h6>
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
                            <div class="col-md-3 control-label" for='topic'>Select Scheme of work</div>
                            <div class="col-md-9">
                                <?php echo form_dropdown('scheme', ['' => 'Please select scheme'] + $schemes, (isset($result->scheme)) ? $result->scheme : '', 'class="select form-control js-example-placeholder-exam"') ?>

                                <?php echo form_error('scheme'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Core Competences:</div>
                            <div class="col-md-9">
                                <textarea id="core_competences" style="height: 120px;" class=" summernote editor" name="core_competences" /><?php echo isset($result->core_competences) ? htmlspecialchars_decode($result->core_competences) : ''; ?></textarea>

                                <?php echo form_error('core_competences'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Organization of Learning</div>
                            <div class="col-md-9">
                                <textarea id="organisation" style="height: 120px;" class=" summernote editor" name="organisation" /><?php echo isset($result->organisation) ? htmlspecialchars_decode($result->organisation) : ''; ?></textarea>

                                <?php echo form_error('organisation'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Introduction (Assessment for learning)</div>
                            <div class="col-md-9">
                                <textarea id="introduction" style="height: 120px;" class=" summernote editor" name="introduction" /><?php echo isset($result->introduction) ? htmlspecialchars_decode($result->introduction) : ''; ?></textarea>

                                <?php echo form_error('introduction'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Extended Activity</div>
                            <div class="col-md-9">
                                <textarea id="extended_activity" style="height: 120px;" class=" summernote editor" name="extended_activity" /><?php echo isset($result->extended_activity) ? htmlspecialchars_decode($result->extended_activity) : ''; ?></textarea>

                                <?php echo form_error('extended_activity'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Conclusion</div>
                            <div class="col-md-9">
                                <textarea id="conclusion" style="height: 120px;" class=" summernote editor" name="conclusion" /><?php echo isset($result->conclusion) ? htmlspecialchars_decode($result->conclusion) : ''; ?></textarea>

                                <?php echo form_error('conclusion'); ?>
                            </div>
                        </div>

                        <div class='row m-2'>
                            <div class="col-md-3 control-label" for='topic'>Reflection on the lesson:</div>
                            <div class="col-md-9">
                                <textarea id="reflection" style="height: 120px;" class=" summernote editor" name="reflection" /><?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?></textarea>

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
                    <?php echo anchor('lesson_plan/trs', 'Cancel', 'class="btn  btn-default"'); ?>
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