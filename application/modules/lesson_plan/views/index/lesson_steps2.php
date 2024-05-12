<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            <b>LESSON DEVELOPMENT STEPS</b>
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
            <div class="col-md-3 control-label" for='topic'>Step</div>
            <div class="col-md-8">
                <input type="number" name="step" class="form-control" placeholder="eg.1" required>
            </div>
        </div>


        <div class='form-group'>
            <div class="col-md-3 control-label" for='topic'>Description</div>
            <div class="col-md-8">
                <textarea id="description" style="height: 120px;" class=" summernote " name="description" placeholder="Describe the step above" required /><?php echo isset($result->description) ? htmlspecialchars_decode($result->description) : ''; ?></textarea>


            </div>
        </div>

        <div class="col-md-3"></div>
        <div class="col-md-6">
            <label for="stay_here"> Stay on this page after saving ?
                <input type="checkbox" name="stay_here" id="stay_here" value="1">
            </label>
        </div>
        <div class="col-md-3"></div>
        <hr>
        <button class="btn btn-primary pull-right">Save</button>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

