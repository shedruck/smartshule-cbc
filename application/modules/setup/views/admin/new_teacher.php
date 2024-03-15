<div class="block-fluid">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Teachers  </h2>
        <div class="right"> 
             <?php echo anchor('admin/setup/teachers', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='first_name'>First Name <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('first_name', $result->first_name, 'id="first_name_"  class="form-control" '); ?>
                <?php echo form_error('first_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='last_name'>Last Name <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('last_name', $result->last_name, 'id="last_name_"  class="form-control" '); ?>
                <?php echo form_error('last_name'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='email'>Email <span class='required'>*</span></div><div class="col-md-10">
                <?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
                <?php echo form_error('email'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='phone'>Phone </div><div class="col-md-10">
                <?php echo form_input('phone', $result->phone, 'id="phone_"  class="form-control" '); ?>
                <?php echo form_error('phone'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-2" for='status'>Status <span class='required'>*</span></div>
            <div class="col-md-10">
                <?php
                $items = array('' => '',
                    "0" => "Active",
                    "1" => "Inactive",
                );
                echo form_dropdown('status', $items, (isset($result->status)) ? $result->status : '', ' class="chzn-select" data-placeholder="Select Options..." ');
                echo form_error('status');
                ?>
            </div></div>

        <div class='form-group'>
            <div class="col-md-2" for='designation'>Designation </div><div class="col-md-10">
                <?php echo form_input('designation', $result->designation, 'id="designation_"  class="form-control" '); ?>
                <?php echo form_error('designation'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">

                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/setup/teachers', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
 </div>