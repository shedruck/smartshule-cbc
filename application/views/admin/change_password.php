<div class="row">
    <div class="col-md-6">

        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-star3"></i></div>
                <h2>Change Password</h2>                        
                <ul class="buttons">                                                        
                    <li><a href="#" class="cblock"><span class="icos-menu"></span></a></li>
                </ul>
            </div>
            <div class="block" data-collapse="eblock_1" style="display: block;">
                <?php echo form_open("admin/change_password", 'class="form-horizontal" '); ?>
                <div class='control-group'>
                    <label class=' control-label' for='old_password'>Old Password: <span class='required'>*</span></label><div class="controls">
                        <?php echo form_input($old_password); ?>
                        <?php echo form_error('old', '<p class="required">', '</p>'); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <label class=' control-label' for='old_password'>New Password (at least <?php echo $min_password_length; ?> characters long): <span class='required'>*</span></label><div class="controls">
                        <?php echo form_input($new_password); ?>
                        <?php echo form_error('new', '<p class="required">', '</p>'); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <label class=' control-label' for='new_confirm'>Confirm New Password:<span class='required'>*</span></label>
                    <div class="controls">
                        <?php echo form_input($new_password_confirm); ?>
                        <?php echo form_error('new_confirm', '<p class="required">', '</p>'); ?>
                    </div>
                </div>
                <?php echo form_input($user_id); ?>
                <div class='control-group'><label class="control-label"></label>
                    <div class="controls">
                       
                        <?php echo form_submit('submit', 'Change', "id='submit' class='btn btn-primary btn-sm'"); ?>
						 <?php echo anchor('admin/', 'Cancel', 'class="btn  btn-sm btn-danger"'); ?>
                    </div></div>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>                  

</div>
