<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Emergency Contacts  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/emergency_contacts/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Emergency Contacts')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/emergency_contacts' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Emergency Contacts')), 'class="btn btn-primary"');?> 
             
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

<div class='form-group'>
	<div class="col-md-3" for='relation'>Relation <span class='required'>*</span></div>
<div class="col-md-6">
                <?php $re_rels = array(
										"" => "Select Option",
										"Brother" => "Brother",
										"Sister" => "Sister",
										"Grandparent" => "Grandparent",
										"Uncle" => "Uncle",
										"Auntie" => "Auntie",                               
										"Guardian" => "Guardian",
										"Others" => "Others",
									);	
     echo form_dropdown('relation', $re_rels,  (isset($result->relation)) ? $result->relation : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('relation'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='phone'>Phone <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('phone' ,$result->phone , 'id="phone_"  class="form-control" ' );?>
 	<?php echo form_error('phone'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='email'>Email </div><div class="col-md-6">
	<?php echo form_input('email' ,$result->email , 'id="email_"  class="form-control" ' );?>
 	<?php echo form_error('email'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Address </h2></div>
	 <div class="block-fluid editor">
	<textarea id="address"   style="height: 300px;" class=" wysiwyg "  name="address"  /><?php echo set_value('address', (isset($result->address)) ? htmlspecialchars_decode($result->address) : ''); ?></textarea>
	<?php echo form_error('address'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/emergency_contacts','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>