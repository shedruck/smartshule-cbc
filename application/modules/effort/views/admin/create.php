<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Effort  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/effort/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Effort')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/effort' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Effort')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='value'>Value <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('value' ,$result->value , 'id="value_"  class="form-control" ' );?>
 	<?php echo form_error('value'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='remarks'>Remarks <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('remarks' ,$result->remarks , 'id="remarks_"  class="form-control" ' );?>
 	<?php echo form_error('remarks'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/effort','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>