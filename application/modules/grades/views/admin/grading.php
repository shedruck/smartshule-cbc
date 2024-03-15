<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> Edit Grading </h2>
        <div class="right">
            <?php echo anchor('admin/grading/view/' . $grading, '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Grades')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='title'>Minimum Marks <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php echo form_input('minimum_marks', $result->minimum_marks, 'id="title_"  class="form-control" '); ?>
                <?php echo form_error('minimum_marks'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-2" for='title'>Maximum Marks <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('maximum_marks', $result->maximum_marks, 'id="title_"  class="form-control" '); ?>
                <?php echo form_error('maximum_marks'); ?>
            </div>
        </div>
        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                <?php echo form_submit('submit', 'Save', "id='submit' class='btn btn-primary'"); ?>
                <?php echo anchor('admin/grading/view/' . $grading, 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
</div>