<div class="col-md-6">
    <div class="widget-box centered" style="opacity: 1; z-index: 0;">   
        <div class="widget-header"> <h3>  Reset Password </h3>
            <div class="widget-toolbar"> 
            </div>
        </div>

        <div class="widget-body">    
            <div class="widget-main">
                <?php echo form_open(current_url(), 'class="form-horizontal" '); ?>
                 <div class='control-group'>
                    <label class=' control-label' for='old_password'>New Password (at least 8 characters long): <span class='text-error'>*</span></label><div class="controls">
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
                
                <div class='control-group'>
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php //echo anchor('/', 'Cancel', 'class="btn  btn-small"'); ?>
                        <?php echo form_submit('submit', 'Submit', "id='submit' class='btn btn-custom'"); ?>
                    </div></div>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style>
    .text-error{color:#f00;}</style>