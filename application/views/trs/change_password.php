<div class="row">
    <div class="col-md-6">

        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-star3"></i></div>
                <h2>Change Password</h2>                        

            </div>
            <div class="block" data-collapse="eblock_1" style="display: block;">
                <?php echo form_open(current_url(), 'class="form-horizontal" '); ?>
                <div class="form-group">
                    <label class="col-md-4 control-label">Old Password <span class='required'>*</span></label>
                    <div class="col-md-8">
                        <?php echo form_input($old_password); ?>
                        <?php echo form_error('old', '<p class="required">', '</p>'); ?>
                    </div>
                </div>

                <div class='form-group'>
                    <label class=' col-md-4 control-label' for='old_password'>New Password (at least <?php echo $min_password_length; ?> characters long): <span class='required'>*</span></label>
                    <div class="col-md-8">
                        <?php echo form_input($new_password); ?>
                        <?php echo form_error('new', '<p class="required">', '</p>'); ?>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='col-md-4 control-label' for='new_confirm'>Confirm New Password:<span class='required'>*</span></label>
                    <div class="col-md-8">
                        <?php echo form_input($new_password_confirm); ?>
                        <?php echo form_error('new_confirm', '<p class="required">', '</p>'); ?>
                    </div>
                </div>
                <?php echo form_input($user_id); ?>
                <div class='form-group'><label class="col-md-6 control-label">&nbsp;</label>
                    <div class="col-md-6">
                        <?php echo anchor('trs', 'Cancel', 'class="btn  btn-inverse"'); ?>
                        <?php echo form_submit('submit', 'Change', "id='submit' class='btn btn-primary btn-small'"); ?>
                    </div></div>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>                  

</div>
