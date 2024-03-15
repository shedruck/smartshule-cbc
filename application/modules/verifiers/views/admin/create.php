<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Verifiers  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/verifiers/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Verifiers')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/verifiers' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Verifiers')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='upi_number'>Upi Number <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('upi_number' ,$result->upi_number , 'id="upi_number_"  class="form-control" ' );?>
 	<?php echo form_error('upi_number'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='name'>Name <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" ' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='phone'>Phone <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('phone' ,$result->phone , 'id="phone_"  class="form-control" ' );?>
 	<?php echo form_error('phone'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='email'>Email <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('email' ,$result->email , 'id="email_"  class="form-control" ' );?>
 	<?php echo form_error('email'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='code'>Code </div><div class="col-md-6">
	<?php echo form_input('code' ,$result->code , 'id="code_"  class="form-control" ' );?>
 	<?php echo form_error('code'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Reason </h2></div>
	 <div class="block-fluid editor">
	<textarea id="reason"   style="height: 300px;" class=" wysiwyg "  name="reason"  /><?php echo set_value('reason', (isset($result->reason)) ? htmlspecialchars_decode($result->reason) : ''); ?></textarea>
	<?php echo form_error('reason'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/verifiers','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>