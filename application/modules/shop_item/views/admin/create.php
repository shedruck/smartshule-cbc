<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Shop Item  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/shop_item/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Shop Item')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/shop_item' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Shop Item')), 'class="btn btn-primary"');?> 
             
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
	<div class="col-md-3" for='size_from'>Size From </div><div class="col-md-6">
	<?php echo form_input('size_from' ,$result->size_from , 'id="size_from_"  class="form-control" ' );?>
 	<?php echo form_error('size_from'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='size_to'>Size To </div><div class="col-md-6">
	<?php echo form_input('size_to' ,$result->size_to , 'id="size_to_"  class="form-control" ' );?>
 	<?php echo form_error('size_to'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='bp'>Bp </div><div class="col-md-6">
	<?php echo form_input('bp' ,$result->bp , 'id="bp_"  class="form-control" ' );?>
 	<?php echo form_error('bp'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='sp'>Sp <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('sp' ,$result->sp , 'id="sp_"  class="form-control" ' );?>
 	<?php echo form_error('sp'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='quantity'>Quantity <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('quantity' ,$result->quantity , 'id="quantity_"  class="form-control" ' );?>
 	<?php echo form_error('quantity'); ?>
</div>
</div>



<div class="form-group">
	<div class="col-md-3" for="description">Description</div>
	<div class="col-md-6">
		<textarea id="description"    class="form-control"  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
	</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/shop_item','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>