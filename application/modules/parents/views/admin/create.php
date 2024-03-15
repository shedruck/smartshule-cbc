<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Parents  </h2>
        <div class="right"> 
            <?php echo anchor('admin/parents/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Parents')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/parents', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Parents')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='first_name'>First Name <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('first_name', $result->first_name, 'id="first_name_"  class="form-control" '); ?>
                <?php echo form_error('first_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='last_name'>Last Name <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('last_name', $result->last_name, 'id="last_name_"  class="form-control" '); ?>
                <?php echo form_error('last_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='status'>Status <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $items = array('' => 'Select Status',
                    "0" => "Active",
                    "1" => "Inactive",
                );
                echo form_dropdown('status', $items, (isset($result->status)) ? $result->status : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('status');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='email'>Email <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='phone'>Phone <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('phone', $result->phone, 'id="phone_"  class="form-control" '); ?>
                <?php echo form_error('phone'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='phone'>Occupation </div><div class="col-md-6">
                <?php echo form_input('occupation', $result->occupation, 'id="occupation"  class="form-control" '); ?>
                <?php echo form_error('occupation'); ?>
            </div>
        </div>
        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Address <span class='required'>*</span></h2></div>
            <div class="block-fluid editor">
                <textarea id="address"   style="height: 300px;" class=" wysiwyg "  name="address"  /><?php echo set_value('address', (isset($result->address)) ? htmlspecialchars_decode($result->address) : ''); ?></textarea>
                <?php echo form_error('address'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/parents', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>