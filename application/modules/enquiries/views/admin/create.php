<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Enquiries  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/enquiries/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Enquiries')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/enquiries' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Enquiries')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='date'>Date <span class='required'>*</span></div><div class="col-md-6">
	<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php echo set_value('date', (isset($result->date)) ? $result->date : ''); ?>"  />
 	<?php echo form_error('date'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='first_name'>First Name <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('first_name' ,$result->first_name , 'id="first_name_"  class="form-control" ' );?>
 	<?php echo form_error('first_name'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='last_name'>Last Name <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('last_name' ,$result->last_name , 'id="last_name_"  class="form-control" ' );?>
 	<?php echo form_error('last_name'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='dob'>DOB <span class='required'>*</span></div><div class="col-md-6">
	<input id='dob' type='text' name='dob' maxlength='' class='form-control datepicker' value="<?php echo set_value('dob', (isset($result->dob)) ? $result->dob : ''); ?>"  />
 	<?php echo form_error('dob'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='gender'>Gender <span class='required'>*</span></div>
<div class="col-md-6">
                <?php $items = array('' =>'Selection', 
"male"=>"Male",
"female"=>"Female",
);		
     echo form_dropdown('gender', $items,  (isset($result->gender)) ? $result->gender : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('gender'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='phone'>Phone <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('phone' ,$result->phone , 'id="phone_"  class="form-control mask_mobile" placeholder="E.g 0720000000" ' );?>
 	<?php echo form_error('phone'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='email'>Email </div><div class="col-md-6">
	<?php echo form_input('email' ,$result->email , 'id="email_"  class="form-control" ' );?>
 	<?php echo form_error('email'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='class'>Class <span class='required'>*</span></div><div class="col-md-6">
	<?php  $classes = $this->ion_auth->fetch_classes();
     echo form_dropdown('class', array(''=>'Select Class')+$classes,  (isset($result->class)) ? $result->class : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
    ?>
 	<?php echo form_error('class'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='know_about'>How did you know about us</div><div class="col-md-6">
	<?php 
	  $items = array('' => 'Select Option',
                            "poster" => "Poster",
                            "radio" => "Radio",
                            "friend" => "Friend",
                            "career talk" => "Career Talk",
                            "facebook" => "Facebook",
                            "twitter" => "Twitter",
                            "others" => "Others",
                    );
	
	 echo form_dropdown('know_about', $items,  (isset($result->know_about)) ? $result->know_about : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
   ?>
 	<?php echo form_error('know_about'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Description </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/enquiries','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>