<div class="col-md-8">
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2> Subject </h2> 
        <div class="right">
            <?php echo anchor('admin/subjects/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Subject')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/subjects/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>    					
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?> 
        <div class="form-group">
            <div class="col-md-12">
                <span class="top title">Select Class</span>
                <?php
                $classes = $this->ion_auth->list_classes();
                echo form_dropdown('class[]', $classes, (isset($result->class)) ? $result->class : '', ' multiple="multiple" id="msc"');
                echo form_error('class');
                ?> 
            </div>
        </div>      
        <div class='form-group'><div class="control-div"></div>
            <div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/subjects', 'Cancel', 'class="btn btn-danger"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>



