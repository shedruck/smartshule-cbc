<div class="row col-lg-12 col-md-12 col-sm-12">


<div class="col-md-3"></div>


    <div class="login col-md-6 col-sm-12" id="forgot">
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
				<script>
                    
                </script>
        <div class="wrap">
                <h3 style="text-align:center">Forgot your password?</h3>
                <?php echo form_open("index/forgotPassword", ' class="form-login" ');
                    ?> 
                <div class="row-fluid">
                    <p style="text-align:center">Please Enter Email to confirm account ownership</p>
                    <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="email" class="form-control" name="email" required="required" placeholder="Email address *"/>
                    </div>  
                    <br>
                    <div class="col-md-8"></div>
                    <div class="col-md-4 pull-right" >
                        <button class="btn btn-block btn-primary" type="submit" name="f_btn">Recover</button>
                    </div>
                    <br>
                
                    <div class="dr"><span></span></div>    
                    
                </div> 
                <?php echo form_close();?>

           
		
                <div class="row-fluid">
                    <div class="col-md-6">                    
                        <button class="btn btn-block" onClick="window.location='<?php echo base_url()?>login'">Back to Login</button>
                    </div>                                
                    <div class="col-md-2"></div>
                    <div class="col-md-4 TAR"></div>
                    
                    <br>
                    <br>
                </div>                                  
        </div>
    </div>  
</div>

<!-- sweet alert -->
<link rel="stylesheet" href="<?php echo base_url()?>assets/themes/trs/js/sweet-alert/sweet-alert.min.css">
<script src="<?php echo base_url()?>assets/themes/trs/js/sweet-alert.min.js"></script>
<script src="<?php echo base_url()?>assets/themes/trs/js/jquery.min.js"></script>
    
  




