<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Sms Templates  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/sms_templates/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Sms Templates')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/sms_templates' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Sms Templates')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='name'>Name <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" ' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Sms Body <span class='required'>*</span></h2></div>
	 <div class="block-fluid editor">
	<textarea id="sms_body"   style="height: 300px;" class=" wysiwyg "  name="sms_body"  /><?php echo set_value('sms_body', (isset($result->sms_body)) ? htmlspecialchars_decode($result->sms_body) : ''); ?></textarea>
	<?php echo form_error('sms_body'); ?>
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
	<?php echo anchor('admin/sms_templates','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>