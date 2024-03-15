<div class="col-md-8">
<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>  Class Rooms </h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/class_rooms/create/'.$page, '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => 'Class Room')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/class_rooms/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			
                     </div>    					
                </div>
         	                  
               <div class="block-fluid">


<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='name'>Name <span class='required'>*</span></div><div class="col-md-10">
	<?php echo form_input('name' ,$result->name , 'id="name_"  class="form-control" ' );?>
 	<?php echo form_error('name'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='capacity'>Capacity </div><div class="col-md-10">
	<?php echo form_input('capacity' ,$result->capacity , 'id="capacity_"  class="form-control" ' );?>
 	<?php echo form_error('capacity'); ?>
</div>
</div>

<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="wysiwyg"  name="description" style="height: 300px;">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 

<div class='form-group'><div class="control-div"></div>
<div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/class_rooms','Cancel','class="btn btn-danger"');?>
</div>
</div>
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
        </div>
    </div>