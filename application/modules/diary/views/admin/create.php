<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Diary  </h2>
        <div class="right"> 
            
            <?php echo anchor('admin/diary', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Diary')), 'class="btn btn-primary"'); ?> 

        </div>
    </div>


    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('student', $result->student, 'id="student_"  class="form-control" '); ?>
                <?php echo form_error('student'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='activity'>Activity <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('activity', $result->activity, 'id="activity_"  class="form-control" '); ?>
                <?php echo form_error('activity'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='date_'>Date  <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('date_', $result->date_, 'id="date__"  class="form-control" '); ?>
                <?php echo form_error('date_'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='teacher'>Teacher <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('teacher', $result->teacher, 'id="teacher_"  class="form-control" '); ?>
                <?php echo form_error('teacher'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='status'>Status </div><div class="col-md-6">
                <?php echo form_input('status', $result->status, 'id="status_"  class="form-control" '); ?>
                <?php echo form_error('status'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='verified'>Verified </div><div class="col-md-6">
                <?php echo form_input('verified', $result->verified, 'id="verified_"  class="form-control" '); ?>
                <?php echo form_error('verified'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Teacher Comment </h2></div>
            <div class="block-fluid editor">
                <textarea id="teacher_comment"   style="height: 300px;" class=" wysiwyg "  name="teacher_comment"  /><?php echo set_value('teacher_comment', (isset($result->teacher_comment)) ? htmlspecialchars_decode($result->teacher_comment) : ''); ?></textarea>
                <?php echo form_error('teacher_comment'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Parent Comment </h2></div>
            <div class="block-fluid editor">
                <textarea id="parent_comment"   style="height: 300px;" class=" wysiwyg "  name="parent_comment"  /><?php echo set_value('parent_comment', (isset($result->parent_comment)) ? htmlspecialchars_decode($result->parent_comment) : ''); ?></textarea>
                <?php echo form_error('parent_comment'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-3"></div><div class="col-md-6">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/diary', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>