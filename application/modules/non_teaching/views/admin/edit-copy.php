<section class="box ">
        <div class="panel panel-default"> 
        <header class="panel_header">
                                <h2 class="title pull-left"><?php echo   ($updType == 'edit') ? 'Edit ' : 'Add ';?>Non_teaching </h2>
                               <div class="actions panel_actions pull-right">
                                    <?php echo anchor( 'admin/non_teaching/create' , '<span><i class="fa fa-plus white"></i> Add Staff Non_teaching</span>', 'class="btn btn-success" ');?> 
                        <?php echo anchor( 'admin/non_teaching' , '<span><i class="fa fa-list white"></i> All Non_teaching' .'</span>', 'class="btn btn-info"');?> 
                                </div>
                            </header>
          	                    
               <div class="panel-body" style="display: block;">    
                
              
                   <div class='clearfix'></div>

                <?php 
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo   form_open_multipart(current_url(), $attributes); 
                ?>
		<div class='form-group'>
				<label class=' col-sm-3 control-label' for='first_name'>First Name <span class='required'>*</span></label><div class="col-sm-5">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-user"></i>
					</span>
				<?php echo form_input('first_name' ,$result->first_name , 'id="first_name_"  class="form-control" ' );?>
				<i style="color:red"><?php echo form_error('first_name'); ?></i>
				</div>
		</div>
		</div>
		
		<div class='form-group'>
				<label class=' col-sm-3 control-label' for='middle_name'>Middle Name </label><div class="col-sm-5">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-user-following"></i>
					</span>
				<?php echo form_input('middle_name' ,$result->middle_name , 'id="middle_name_"  class="form-control" ' );?>
				<i style="color:red"><?php echo form_error('middle_name'); ?></i>
				</div>
		</div>
		</div>
		
		<div class='form-group'>
				<label class=' col-sm-3 control-label' for='last_name'>Last Name <span class='required'>*</span></label><div class="col-sm-5">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-user"></i>
					</span>
				<?php echo form_input('last_name' ,$result->last_name , 'id="last_name_"  class="form-control" ' );?>
				<i style="color:red"><?php echo form_error('last_name'); ?></i>
		</div>
		</div>
		</div>
		
			<div class='form-group'>
	<label class='col-sm-3 control-label' for='gender'>Gender</label>
<div class="col-sm-5">
                <?php	
				$gender = array(''=>'Select Gender', 'Male'=>'Male','Female'=>'Female');
     echo form_dropdown('gender', $gender,  (isset($result->gender)) ? $result->gender : ''     ,   ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"  placeholder="Member gender"');
    ?> <i style="color:red"><?php echo form_error('gender'); ?></i>
</div></div>

<div class='form-group'>
				<label class=' col-sm-3 control-label' for='dob'>Date of Birth <span class='required'>*</span></label>
				<div class="col-sm-9">
				<div class="input-group">
				
				<input id='dob_' type='text' name='dob' maxlength='' class='form-control datepicker' value="<?php echo set_value('dob', (isset($result->dob)) ? $result->dob : ''); ?>"  />
				<i style="color:red"><?php echo form_error('dob'); ?></i>
				<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
			</div>
			</div>
		</div>
		
		<div class='form-group'>
		<label class=' col-sm-3 control-label' for='phone'>Phone <span class='required'>*</span></label>
		<div class="col-sm-5">
		<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-phone-square"></i>
					</span>
				<?php echo form_input('phone' ,$result->phone , 'id="phone1"  class="form-control" ' );?>
				<i style="color:red"><?php echo form_error('phone'); ?></i>
		</div>
		</div>
		</div>
		
		<div class='form-group'>
				<label class=' col-sm-3 control-label' for='email'>Email </label><div class="col-sm-5">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-envelope"></i>
					</span>
				<?php echo form_input('email' ,$result->email , 'id="email_"  class="form-control" ' );?>
				<i style="color:red"><?php echo form_error('email'); ?></i>
		</div>
		</div>
		</div>
		
		<div class='form-group'>
				<label class=' col-sm-3 control-label' for='email'>PIN Number </label><div class="col-sm-5">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list"></i>
					</span>
				<?php echo form_input('pin' ,$result->pin , 'id="pin_"  class="form-control" ' );?>
				<i style="color:red"><?php echo form_error('pin'); ?></i>
		</div>
		</div>
		</div>
		
		<div class='form-group'>
	<label class='col-sm-3 control-label' for='member_groups'>Add to Group </label>
<div class="col-sm-5">
                <?php	
     echo form_dropdown('member_groups',$groups,(isset($result->group_id)) ? $result->group_id : ''    , ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"  placeholder="Member Groups"');
    ?> <i style="color:red"><?php echo form_error('member_groups'); ?></i>
</div></div>
		
		
		
                                                
<div class='form-group'>
	<label class=' col-sm-3 control-label' for='address'>Address </label><div class="col-sm-5">
	<textarea id="address"  class="autosize-transition ckeditor form-control "  name="address"  /><?php echo set_value('address', (isset($result->address)) ? htmlspecialchars_decode($result->address) : ''); ?></textarea>
	<i style="color:red"><?php echo form_error('address'); ?></i>
</div>
</div>

<div class='form-group'>
	<label class=' col-sm-3 control-label' for='additionals'>Additionals </label><div class="col-sm-5">
	<textarea id="additionals"  class="autosize-transition ckeditor form-control "  name="additionals"  /><?php echo set_value('additionals', (isset($result->additionals)) ? htmlspecialchars_decode($result->additionals) : ''); ?></textarea>
	<i style="color:red"><?php echo form_error('additionals'); ?></i>
</div>
</div>

<div class='form-group'><label class="col-sm-3 control-label"></label><div class="col-sm-5">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save Changes', (($updType == 'create') ? "id='submit' class=' btn btn-info''" : "id='submit' class='btn btn-info'")); ?>
	
	<?php echo anchor('admin/non_teaching','Cancel','class="btn btn-default btn-shadow"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
        </div> 
        </section>