<div class="col-md-10">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Accounts  </h2>
        <div class="right"> 
            <?php echo anchor('admin/accounts/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Accounts')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/accounts', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Accounts')), 'class="btn btn-primary"'); ?> 

        </div>
    </div>
 
    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='name'>Name <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" '); ?>
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='code'>Code <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('code', $result->code, 'id="code_"  class="form-control" '); ?>
                <?php echo form_error('code'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='account_type'>Account Type <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php echo form_dropdown('account_type', $account_types, (isset($result->account_type)) ? $result->account_type : '', ' class="select"  ');
                ?>		
                <?php echo form_error('account_type'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='tax'>Tax <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php echo form_dropdown('tax', $tax_config, (isset($result->tax)) ? $result->tax : '', ' class="select" ');
                ?>		
                <?php echo form_error('tax'); ?>
            </div>
        </div>

       

        

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
 
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/accounts', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>