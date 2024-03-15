<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Setup  </h2>
        <div class="right"> 
            <?php echo anchor('admin/setup/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Setup')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/setup', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Setup')), 'class="btn btn-primary"'); ?> 

        </div>
    </div>


    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='name'>Name </div><div class="col-md-10">
                <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" '); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='dayt'>Dayt </div><div class="col-md-10">
                <input id='dayt' type='text' name='dayt' maxlength='' class='form-control datepicker' value="<?php echo set_value('dayt', (isset($result->dayt)) ? $result->dayt : ''); ?>"  />
                <?php echo form_error('dayt'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-10"><input id='public' type='checkbox' name='public' value='1'  class="form-control" <?php echo preset_checkbox('public', '1', (isset($result->public)) ? $result->public : '' ) ?> />&nbsp;<div class='col-md-2inline' for='public'>Is public? </div>
                <?php echo form_error('public'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/setup', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>