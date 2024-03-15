<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Audit Logs  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/audit_logs/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Audit Logs')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/audit_logs' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Audit Logs')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='module'>Module <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('module' ,$result->module , 'id="module_"  class="form-control" ' );?>
 	<?php echo form_error('module'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='item_id'>Items Id <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('item_id' ,$result->item_id , 'id="item_id_"  class="form-control" ' );?>
 	<?php echo form_error('item_id'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='transaction_type'>Transaction Type </div><div class="col-md-6">
	<?php echo form_input('transaction_type' ,$result->transaction_type , 'id="transaction_type_"  class="form-control" ' );?>
 	<?php echo form_error('transaction_type'); ?>
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
	<?php echo anchor('admin/audit_logs','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>