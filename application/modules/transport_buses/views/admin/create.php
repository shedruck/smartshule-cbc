<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Transport Buses  </h2>
        <div class="right"> 
            <?php echo anchor('admin/transport_buses/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Buses')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/transport_buses', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Buses')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='reg_no'>Reg No <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('reg_no', $result->reg_no, 'id="reg_no_"  class="form-control" '); ?>
                <?php echo form_error('reg_no'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='capacity'>Capacity <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('capacity', $result->capacity, 'id="capacity_"  class="form-control" '); ?>
                <?php echo form_error('capacity'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Description </h2></div>
            <div class="block-fluid editor">
                <textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description" /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/transport_buses', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>