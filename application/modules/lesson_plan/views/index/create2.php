<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            <b>Lesson Plan</b>
        </h3>
        <div class="pull-right">
            <?php echo anchor('lesson_plan/trs/create', '<i class="fa fa-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('lesson_plan/trs', '<i class="fa fa-list">
                </i> ' . lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"'); ?>
            <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>

        <div class="clearfix"></div>
        <hr>
    </div>




    <div class="block-fluid">

        <?php

        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo   form_open_multipart(current_url(), $attributes);
        ?>

        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Select Scheme of work*</div>
            <div class="col-md-8">
                <?php echo form_dropdown('scheme', ['' => 'Please select scheme'] + $schemes, (isset($result->scheme)) ? $result->scheme : '', 'class="select"') ?>

                <?php echo form_error('scheme'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Core Competences:</div>
            <div class="col-md-8">
                <textarea id="core_competences" style="height: 120px;" class=" summernote " name="core_competences" /><?php echo isset($result->core_competences) ? htmlspecialchars_decode($result->core_competences) : ''; ?></textarea>

                <?php echo form_error('core_competences'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Organization of Learning</div>
            <div class="col-md-8">
                <textarea id="organisation" style="height: 120px;" class=" summernote " name="organisation" /><?php echo isset($result->organisation) ? htmlspecialchars_decode($result->organisation) : ''; ?></textarea>

                <?php echo form_error('organisation'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Introduction (Assessment for learning)</div>
            <div class="col-md-8">
                <textarea id="introduction" style="height: 120px;" class=" summernote " name="introduction" /><?php echo isset($result->introduction) ? htmlspecialchars_decode($result->introduction) : ''; ?></textarea>

                <?php echo form_error('introduction'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Extended Activity</div>
            <div class="col-md-8">
                <textarea id="extended_activity" style="height: 120px;" class=" summernote " name="extended_activity" /><?php echo isset($result->extended_activity) ? htmlspecialchars_decode($result->extended_activity) : ''; ?></textarea>

                <?php echo form_error('extended_activity'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Conclusion</div>
            <div class="col-md-8">
                <textarea id="conclusion" style="height: 120px;" class=" summernote " name="conclusion" /><?php echo isset($result->conclusion) ? htmlspecialchars_decode($result->conclusion) : ''; ?></textarea>

                <?php echo form_error('conclusion'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Reflection on the lesson:</div>
            <div class="col-md-8">
                <textarea id="reflection" style="height: 120px;" class=" summernote " name="reflection" /><?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?></textarea>

                <?php echo form_error('reflection'); ?>
            </div>
        </div>


        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/lesson_plan', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<style>
    .phead {
        opacity: 0%;
    }
</style>