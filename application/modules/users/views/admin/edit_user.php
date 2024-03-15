
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Users Management</h2> 
    <div class="right">                            

        <?php echo anchor('admin/users/create/', '<i class="glyphicon glyphicon-plus"></i>' . lang('web_add_t', array(':name' => 'New User')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/users/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
    </div>    					
</div>

<div class="block-fluid">
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
	
	 <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='passport'> Passport Photo </label>
					<div class="col-sm-3">
                    
                            	<input id='passport' type='file' name='passport' />
							<br/><i style="color:red"><?php echo form_error('passport'); ?></i>
							<?php  echo ( isset($upload_error['passport'])) ?  $upload_error['passport']  : ""; ?>
							
						</div>
						<div class="col-md-3">
								<?php if ($the_user->passport): ?>
								<img src='<?php echo base_url()?>uploads/files/<?php echo $the_user->passport?>' height="40" width="40"/>
								<?php endif ?>

								
							</div>
						
					</div>
					
					
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
    <input style="display:none" class="mask_mobile" >  
    <div class='form-group'>
        <div class=' col-md-3' for='phone'>Phone Number <span class=' mask_mobile'></span></div>
        <div class="col-md-4">
            <?php echo form_input($phone, '', 'class="mask_mobile"'); ?>  
            <?php echo form_error('phone', '<p class="required">', '</p>'); ?>
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

    <div class='form-group'>
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
</div>
</div>

</div>
