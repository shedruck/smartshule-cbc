<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Grades  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/grades/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_list_all', array(':name' => 'Grades')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/grades' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Grades')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='title'>Title <span class='required'>*</span></div><div class="col-md-10">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='remarks'>Remarks <span class='required'>*</span></div><div class="col-md-10">
	<?php echo form_input('remarks' ,$result->remarks , 'id="remarks_"  class="form-control" ' );?>
 	<?php echo form_error('remarks'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/grades','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
        </div>