      <div id="content" class="col-md-10">
    <!-- content starts -->

    <div>
        <ul class="breadcrumb">
            <li>
                <a href="#">Home</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Forgot Password</a>
            </li>
        </ul>
    </div>
  

    <div class="row">
        <div class="w-box col-md-12">
            <div class="w-box-header well">
                <h2><i class="glyphicon glyphicon-info-sign"></i>Forgot Password</h2>
                <div class="box-icon">
                   
                    
                    
                </div>
            </div>
            <div class="box-content">
              
<p>Please enter your <?php echo $identity_human;?> so we can send you an email to reset your password.</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("admin/users/forgot_password");?>

      <p><?php echo $identity_human;?>:<br />
      <?php echo form_input($identity);?>
      </p>
      
      <p><?php echo form_submit('submit', 'Submit', 'class="btn btn-success"');?></p>
      
<?php echo form_close();?>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- content ends -->
</div><!--/#content.col-md-10-->