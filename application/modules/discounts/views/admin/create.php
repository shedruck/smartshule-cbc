<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Discount Groups </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/discounts/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Discounts')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/discounts' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Discounts')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='name'>Name </div><div class="col-md-6">
	<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" placeholder="Group Name"' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>


<div class='form-group'>
    <div class="col-md-3" for='name'>Percentage </div><div class="col-md-6">
    <?php echo form_input('percentage' ,$result->percentage , 'id="name_"  class="form-control"  placeholder="e.g 30"' );?>
    <?php echo form_error('percentage'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/discounts','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>