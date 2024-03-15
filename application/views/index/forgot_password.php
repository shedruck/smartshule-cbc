 
<div class="login-form">
    <div class="login-content"><?php
        $str = is_array($message) ? $message['text'] : $message;
        echo (isset($message) && !empty($message)) ? '
                        <div class="alert alert-danger "> 
                <button type="button" class="close" data-dismiss="alert">
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
                <strong>   <i class="glyphicon glyphicon-comment"></i>
                  </strong>' . $str . '   
            </div>' : '';
        ?> 
        <?php echo form_open(current_url(), 'role="form" class="form-horizontal" id="form_login" '); ?>
        <hr>
        <p class="description">Please Enter Your Email Address to Receive Instructions on how to reset your Password</p>
        <div class="input-group">
            <span class="input-group-addon">
                <span class="input-text">Email&#42;</span></span>
            <input type="text" name="email" id="password" class="form-control input-lg" placeholder="Your Email" autocomplete="off">
        </div>

        <div class="form-group">
            <div class="control-label col-md-2">&nbsp;</div>
            <button type="submit" class="btn btn-primary">
                Send Me
                <i class="entypo-login"></i>
            </button>
        </div>

        <?php echo form_close(); ?> 

        <div class="login-bottom-links">
            <a href="<?php echo base_url('login'); ?>" class="link">Back To Login</a>
            <br />

        </div>

    </div>

</div>
