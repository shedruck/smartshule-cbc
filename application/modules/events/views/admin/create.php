<div class="col-md-9">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Add Announcement</h2>
        <div class="right">
            <?php echo anchor('admin/events', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Events')), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <div class="block-fluid">
        <?php
        
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3">Title <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('stitle', isset($result->title) ? $result->title : '', ' class="form-control" '); ?>
                <?php echo form_error('stitle'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">Category <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $category = [1 => 'Announcements', 2 => 'NewsLetter', 3 => 'Event'];
                echo form_dropdown('cat', ['' => 'Select Category'] +  $category, $result->cat, 'class="form-control" '); ?>
                <?php echo form_error('cat'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">Upload file <span class='required'>*</span></div>
            <div class="col-md-6">
                <input type="file" class="form-control" id="inputGroupFile02" name="file[]" multiple accept=".pdf, .jpeg, .jpg, .png">
                <?php echo form_error('file'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Description<span class='required'>*</span></h2>
            </div>
            <div class="block-fluid editor">
                <textarea style="height: 300px;" class=" wysiwyg " name="desc" /><?php echo set_value('desc', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('desc'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('announce', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/events', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>