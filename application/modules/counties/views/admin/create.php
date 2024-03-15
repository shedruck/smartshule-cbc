<div class="col-md-12">
    <div class="panel panel-primary" >
        <div class="panel-heading">   
            Counties  
            <span class="tools pull-right">
                <a class="fa fa-chevron-down" href="javascript:;"></a>
            </span>
        </div>

        <div class="panel-body" style="display: block;">    <div class="widget-main">
                <div class="bs-example pull-right">
                    <?php echo anchor('admin/counties', '<i class="fa fa-list">
                </i> ' . lang('web_list_all', array(':name' => 'Counties')), 'class="btn btn-info icon-left"'); ?>                    </div>
                <div class='space-6'></div>

                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='name'>Name <span class='error'>*</span></label><div class="col-sm-5">
                        <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" '); ?>
                        <?php echo form_error('name'); ?>
                    </div>
                </div>

                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='description'>Description </label><div class="col-sm-5">
                        <textarea id="description"  class="autosize-transition form-control "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                        <?php echo form_error('description'); ?>
                    </div>
                </div>

                <div class='form-group'><label class="col-sm-3 control-label"></label><div class="col-sm-5">

                        <?php echo anchor('admin/counties', 'Back To Listing', 'class="btn  btn-success"'); ?>
                        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-info btn-small''" : "id='submit' class='btn  btn-info btn-small'")); ?>
                    </div></div>

                <?php echo form_close(); ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>