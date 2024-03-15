<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Edit Unit </h2>

        <div class="right">
             <?php echo anchor('admin/subjects', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?>
        </div>
    </div>

    <div class="block-fluid">
         <?php
             $attributes = array('class' => 'form-horizontal', 'id' => '');
             echo form_open_multipart(current_url(), $attributes);
         ?>
        <div class='form-group'>
            <div class="col-md-3" for='title'>Title <span class='required'>*</span></div>
            <div class="col-md-6">
                 <?php echo form_input('title', $unit->title, 'id="title"  class="form-control" '); ?>
                 <?php echo form_error('title'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='out_of'>Out of</div>
            <div class="col-md-6">
                 <?php echo form_input('out_of', $unit->out_of, 'id="out_of"  class="form-control" '); ?>
                 <?php echo form_error('out_of'); ?>
            </div>
        </div> 

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                 <?php echo form_submit('submit', 'Update', "id='submit' class='btn btn-primary'"); ?>
                 <?php echo anchor('admin/subjects', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
