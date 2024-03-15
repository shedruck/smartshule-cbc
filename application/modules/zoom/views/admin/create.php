<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Zoom  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/zoom/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Zoom')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/zoom' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Zoom')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>


<div class="form-group">
<div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<input id='title' type='text' placeholder="Title of the meeting" name='title' maxlength='' class='form-control' value="<?php echo set_value('title', (isset($result->title)) ? $result->title : ''); ?>"  />
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class="form-group">
<div class="col-md-3" for='link'>Meeting Link <span class='required'>*</span></div><div class="col-md-6">
	<textarea name="link" placeholder="Please enter the meeting link here"><?php echo set_value('link', (isset($result->link)) ? $result->link : ''); ?></textarea>
  <?php echo form_error('link'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='time'>Time <span class='required'>*</span></div><div class="col-md-6">
  <input type="datetime-local" name="time" class="form-control"  value="<?php echo set_value('time', (isset($result->time)) ? $result->time : ''); ?>" required>
 	<?php echo form_error('time'); ?>
</div>
</div>


        <div class='form-group'>
            <div class="col-md-3" for='class'>Class <span class='required'>*</span></div>
            <div class="col-md-4">
                <?php
                $classes = $this->ion_auth->fetch_classes();
                echo form_dropdown('class', $classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select  Options..." ');
                ?>		
            </div>
        </div>                       
<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/zoom','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>