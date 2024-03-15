<div class="col-md-8">
 <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Placement Positions</h2> 
                     <div class="right">                            
           <?php echo anchor( 'admin/placement_positions/'.$page, '<i class="glyphicon glyphicon-plus"></i> List All', 'class="btn btn-primary"');?>
			
                     </div>    					
                </div>
   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<label class='col-md-3' for='title'>Title </label><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
     <textarea id="wysiwyg"  name="description" style="height: 300px;"><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 
<div class='form-group'><label class="col-md-3"></label><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/placement_positions','Cancel','class="btn btn-danger"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
       