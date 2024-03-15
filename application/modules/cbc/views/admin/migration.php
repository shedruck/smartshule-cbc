<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Cbc </h2>
        <div class="right">
            <?php echo anchor('admin/cbc/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Cbc')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/cbc', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Cbc')), 'class="btn btn-primary"'); ?>
        </div>
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='name'>Class <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_dropdown('class', ['' => ''] + $pop, '', 'id="name_"  class="select select-2" '); ?>
                <?php echo form_error('class'); ?>
            </div>
        </div>

       

        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button class="btn btn-primary" type="submit" onclick="return confirm('Are you sure?')">Process</button>
                <?php echo anchor('admin/cbc', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>