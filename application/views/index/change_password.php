 <?php
    $u = $this->ion_auth->get_user();
    $user = $this->ion_auth->parent_profile($u->id);
    ?> 





<div class="card shadow-sm ctm-border-radius grow">

<div class="card-body align-center">

<!-- Tab2-->
        <div class="widget-body">    
            <div class="widget-main">
                <?php echo form_open("change_password", 'class="form-horizontal" '); ?>
                <div class='control-group'>
                    <label class=' control-label' for='old_password'>Old Password: <span class='text-error'>*</span></label><div class="controls">
                        <?php echo form_input($old_password); ?>
                        <?php echo form_error('old', '<p class="text-error">', '</p>'); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <label class=' control-label' for='old_password'>New Password (at least <?php echo $min_password_length; ?> characters long): <span class='text-error'>*</span></label><div class="controls">
                        <?php echo form_input($new_password); ?>
                        <?php echo form_error('new', '<p class="text-error">', '</p>'); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <label class=' control-label' for='new_confirm'>Confirm New Password:<span class='text-error'>*</span></label>
                    <div class="controls">
                        <?php echo form_input($new_password_confirm); ?>
                        <?php echo form_error('new_confirm', '<p class="text-error">', '</p>'); ?>
                    </div>
                </div>
                <?php echo form_input($user_id); ?>
                <div class='control-group'><label class="control-label"></label>
                    <div class="controls">
                        <?php echo form_submit('submit', 'Change', "id='submit' class='btn btn-primary'"); ?>
						
                    </div></div>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>
