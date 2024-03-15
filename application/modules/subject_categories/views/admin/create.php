<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Subject Categories </h2>
        <div class="right">
            <?php echo anchor('admin/subject_categories', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subject Categories')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <div class='form-group'>
            <div class="col-md-3" for='category'>Category <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('category', array('' => '') + $categories, (isset($result->category)) ? $result->category : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('category');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='category'>Class <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('classes[]', $this->classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select Options" multiple');
                echo form_error('classes');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='subject'>Subject <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                echo form_dropdown('subjects[]',  $subjects, (isset($result->subject)) ? $result->subject : '', ' class="select" data-placeholder="Select  Options..." multiple');
                echo form_error('subject');
                ?>
            </div>
        </div>


        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/subject_categories', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>