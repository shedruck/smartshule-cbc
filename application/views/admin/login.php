<div class="login" style="text-align:center" id="login">


				 <?php if (!empty($settings)): ?>
				   
					
				
				

   <?php if (!empty($settings)): ?>
            <img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="150" height="150" style="border-radius:15%" />
    <?php else: ?>	
            <img src="<?php echo base_url('assets/themes/default/img/logo.png/'); ?>" width="150" height="150" style="border-radius:15%" />
    <?php endif; ?> 
	 
<div style="text-align:center; color:#fff">
	<h5 class="centralize" style="text-align:center; color:#fff; text-transform:uppercase">
					<?php echo $settings->school;?> 
					</h5>
					 <?php else: ?>	
					<a href="#" class="centralize" style="text-align:center; color:#fff">Demo School</a>
					 <?php endif; ?>
	
	</div>  
	
    <div class="wrap">
        <h1>Welcome. Please Log In</h1>
        <?php
        $str = is_array($message) ? $message['text'] : $message;
        echo (isset($message) && !empty($message)) ? '
                        <div class="alert alert-info "> 
                <button type="button" class="close" data-dismiss="alert">
                    <i class="glyphicon glyphicon-remove"></i>
                </button> ' . $str . '   
            </div>' : '';
        ?> 
		
		<?php
$settings = $this->ion_auth->settings();
echo form_open("admin/login", ' class="form-login" ');
?> 
       
        <div class="row">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" name="email" required="required" placeholder="Email (or) Phone Number" class="form-control ">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-record"></i></span>
                <input type="password" name="password" required="required" placeholder="Password" class="form-control">
            </div>          
            <div class="dr"><span></span></div>                                
        </div>                
        <div class="row">
            <div class="col-md-8 remember">                    
                <input type="checkbox" name="rem"/> Remember me                    
            </div>
            <div class="col-md-4 TAR">
                <input type="submit" class="btn btn-block btn-primary" value="Login"/>
            </div>
        </div>
		
		<?php echo form_close();?>
      
	    <div class="dr"><span></span></div>
            <div class="row-fluid">
                <div class="col-md-7">       
                    <a ><button class="btn btn-block" onClick="window.location='<?php echo base_url()?>index/forgotPassword'">Forgot your password?</button></a>             
                    <!-- <button class="btn btn-block">Forgot your password?</button> -->
                </div>
                <div class="col-md-5">
                    <button class="btn btn-warning btn-block" > Branches</button>
                </div>
            </div>  
			<br>
			<br>
		
    </div>
	

</div>





  <div class="login" id="forgot">
      <div style="text-align:center; color:#fff">
				 <?php $settings = $this->ion_auth->settings(); if (!empty($settings)): ?>
				   
					<h5 class="centralize" style="text-align:center; color:#fff; text-transform:uppercase">
					<?php echo $settings->school;?> 
					</h5>
					 <?php else: ?>	
					<a href="#" class="centralize" style="text-align:center; color:#fff">Demo School</a>
					 <?php endif; ?>
				
				   <?php if (!empty($settings)): ?>
            <img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="60" height="60" />
			<?php else: ?>	
					<img src="<?php echo base_url('assets/themes/default/img/logo.png/'); ?>" width="60" height="60" />
			<?php endif; ?>
	</div>
				
        <div class="wrap">
            <h1 style="text-align:center">Forgot your password?</h1>
				<?php
				
				echo form_open("admin/update_password", ' class="form-login" ');
				?> 
            <div class="row-fluid">
                <p style="text-align:center">Please enter Phone number or Email</p>
               <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                
                    <input type="text" class="form-control" name="identity" required="required" placeholder="Email (or) Phone Number*"/>
                </div>  
				<br>
				   <div class="col-md-8"></div>
                  <div class="col-md-4 pull-right" >
                    <button class="btn btn-block btn-primary">Recover</button>
                </div>
				<br>
			
                <div class="dr"><span></span></div>    
				
            </div> 
		<?php echo form_close();?>
		
            <div class="row-fluid">
                <div class="col-md-6">                    
                    <button class="btn btn-block" onClick="loginBlock('#login');">Back to Login</button>
                </div>                                
                <div class="col-md-2"></div>
                <div class="col-md-4 TAR"></div>
				
				<br>
				<br>
            </div>                                  
        </div>
    </div>  

    
    <!-- <div class="modal fade"  id="forgot_password" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Forgot Password</h4>
            </div>
          
            <div class="modal-body" id="here">
body here
            
       
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->




