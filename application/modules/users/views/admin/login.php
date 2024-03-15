<div class="mainContainer">
    <div class="loginWrap">
         <?php //echo theme_image('loginLogo.png' );?> 
        <div class="loginContainer">
            <div class="loginHeader">
                <h5>  <?php echo theme_image('icons/14x14/lock3.png'); ?> System Login</h5>
                <ul class="titleButtons">
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo theme_image('icons/14x14/cog2.png'); ?></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#">Forgot password?</a></li>
                            <li><a href="#">Register new user</a></li>
                            <li><a href="#">Contact support</a></li>
                        </ul>
                    </li>
                </ul>
            </div>             
            <?php echo form_open("admin/login", 'class="mainForm" id="validateLogin" '); ?>
            <label for="email">Email</label>
            <div class="inputField">
                <input type="text" id="email" name="email" placeholder="Email">
                <?php echo theme_image('icons/14x14/member2.png'); ?>   
            </div>
            <label for="password">Password</label>
            <div class="inputField">
                <input type="password" id="password" name="password" value="12345678"  placeholder="password">
                <?php echo theme_image('icons/14x14/lock3.png'); ?>    
            </div>
            <div class="checkX">
                <label class="formButton"><input type="checkbox" name="check" checked> <span>Remember me</span></label>
            </div>
            <button type="submit" class="button noMargin sButton blockButton bSky">Log in</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>