<div class="col-sm-8">
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  System Users   </h2>
    <div class="right">                           
                       
             <?php echo anchor( 'admin/users/create/', '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => 'New User')), 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/users/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
             
                     </div>    					
                </div>
				
		 <div class="block-fluid">

                    <?php
                        $attributes = array('class' => 'form-horizontal', 'id' => '');
                        echo form_open_multipart('admin/users/create', $attributes);
                    ?>
					
			      <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='passport'> Passport Photo </label>
					<div class="col-sm-6">
                    
                            	<input id='passport' type='file' name='passport' />
							<br/><i style="color:red"><?php echo form_error('passport'); ?></i>
							<?php  echo ( isset($upload_error['passport'])) ?  $upload_error['passport']  : ""; ?>
							
						</div>
						
					</div>
		
			
                    <div class='form-group'>
                        <div class=' col-md-3' for='username'>First Name<span class='required'>*</span></div>
						<div class="col-md-6">
                            <?php echo form_input($first_name); ?>
                            <?php echo form_error('first_name', '<p class="required">', '</p>'); ?>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class=' col-md-3' for='last_name'>Last Name <span class='required'>*</span></div>
						<div class="col-md-6">
                            <?php echo form_input($last_name); ?>  
                            <?php echo form_error('last_name', '<p class="required">', '</p>'); ?>
                        </div>
                    </div>
					<input style="display:none" class="mask_mobile" >  
					<div class='form-group'>
                        <div class=' col-md-3' for='phone'>Phone Number <span class='required'>*</span></div>
						<div class="col-md-6">
                            <?php echo form_input($phone,'','class="mask_mobile"'); ?>  
                            <?php echo form_error('phone', '<p class="required">', '</p>'); ?>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class=' col-md-3' for='email'>Email <span class='required'>*</span></div>
                        <div class="col-md-6">
                            <?php echo form_input($email); ?>
                            <?php echo form_error('email', '<p class="required">', '</p>'); ?>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class=' col-md-3' for='password'>Password <span class='required'>*</span></div>
                        <div class="col-md-6">
                            <?php echo form_input($password); ?>
                            <?php echo form_error('password', '<p class="required">', '</p>'); ?>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class=' col-md-3' for='password_confirm'>Confirm Password <span class='required'>*</span></div>
                        <div class="col-md-6">
                            <?php echo form_input($password_confirm); ?>
                            <?php echo form_error('password_confirm', '<p class="required">', '</p>'); ?>
                        </div>
                    </div>
                    <?php
                        $selected = isset($this->input->post['groups']) ? $this->input->post['groups'] : array('');
                    ?>
                    <div class='form-group'>
                        <div class=' col-md-3' for='groups'>Groups <span class='required'>*</span></div>
                        <div class="col-md-6">
                            <?php echo form_dropdown('groups[]',array(''=>'Select Group')+ $groups_list, $selected, ' class="select"'); ?>
                            <?php echo form_error('groups', '<p class="required">', '</p>'); ?>
                        </div>
                    </div>

                    <div class='form-group'><div class="col-md-3"></div>
                        <div class="col-md-6">
                             <?php echo form_submit('submit', 'Save Changes', "id='submit' class='btn btn-primary' "); ?>
		  <?php echo anchor('admin/users', 'Cancel', 'class="btn btn-default"'); ?>
                        </div>
						</div>

                    <?php echo form_hidden('page', set_value('page', 1)); ?>

                    <?php echo form_close(); ?>
                    <div class="clearfix"></div>
</div>
</div>
