<div class="col-md-12">
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Teachers</h2> 
    <div class="right">                            

        <?php echo anchor('admin/teachers/create/', '<i class="glyphicon glyphicon-plus"></i>' . lang('web_add_t', array(':name' => 'New Teacher')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/teachers/', '<i class="glyphicon glyphicon-list">
                </i> List All Teachers', 'class="btn btn-primary"'); ?>
     </div>    					
</div>

<div class="block-fluid">

    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
    <div class='form-group'>
        <div class='col-md-3' for='first_name'>First Name <span class='required'>*</span></div>
        <div class="col-md-4">
            <?php echo form_input($first_name); ?>
            <?php echo form_error('first_name', '<p class="required">', '</p>'); ?>
        </div>
    </div>

    <div class='form-group'>
        <div class='col-md-3' for='last_name'>Last Name <span class='required'>*</span></div>
        <div class="col-md-4">
            <?php echo form_input($last_name); ?>
            <?php echo form_error('last_name', '<p class="required">', '</p>'); ?>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-md-3' for='email'>Email <span class='required'>*</span></div>
        <div class="col-md-4">
            <?php echo form_input($email); ?>
            <?php echo form_error('email', '<p class="required">', '</p>'); ?>
        </div>
    </div>
	
        <div class='form-group'>
            <div class="col-md-3" for='phone'>Phone </div><div class="col-md-4">
                 <?php echo form_input($phone); ?>
				<?php echo form_error('phone', '<p class="required">', '</p>'); ?>
             
            </div>
        </div>
  <div class='form-group'>
            <div class="col-md-3" for='designation'>Designation </div><div class="col-md-4">
                <?php echo form_input('designation', $result->designation, 'id="designation_"  class="form-control" '); ?>
                <?php echo form_error('designation'); ?>
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
            </div></div>

    <div class='form-group'>
        <div class='col-md-3' for='password'>Password <br> (if changing password) </div><div class="col-md-4">
            <?php echo form_input($password); ?> <?php echo form_error('password', '<p class="required">', '</p>'); ?>
        </div>
    </div>
    <div class='form-group'>
        <div class='col-md-3' for='password_confirm'>Confirm Password<br> (if changing password)  </div><div class="col-md-4">
            <?php echo form_input($password_confirm); ?>
            <?php echo form_error('password_confirm', '<p class="required">', '</p>'); ?>
        </div>
    </div>

    <div class='form-group' style="display:none">
        <div class='col-md-3' for='groups'>Groups  </div>
        <div class="col-md-4">
            <?php echo form_dropdown('groups[]', $groups_list, $selected, '  class="select"'); ?>
        </div>
    </div> 

    <div class='form-group'><div class="control-div"></div><div class="col-md-4">
             <?php echo form_submit('submit', 'Update', "id='submit' class='btn btn-primary'"); ?> 
            <?php echo anchor('admin/users', 'Cancel', 'class="btn  btn-default"'); ?>
        </div></div>


    <?php echo form_close(); ?>
    <div class="clearfix"></div>
</div>
</div>
