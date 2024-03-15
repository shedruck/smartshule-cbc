<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Qa  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/qa/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Qa')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/qa' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Qa')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='subject'>Subject <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('subject' ,$result->subject , 'id="subject_"  class="form-control" ' );?>
 	<?php echo form_error('subject'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='topic'>Topic </div><div class="col-md-6">
	<?php echo form_input('topic' ,$result->topic , 'id="topic_"  class="form-control" ' );?>
 	<?php echo form_error('topic'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Instruction </h2></div>
	 <div class="block-fluid editor">
	<textarea id="instruction"   style="height: 300px;" class=" wysiwyg "  name="instruction"  /><?php echo set_value('instruction', (isset($result->instruction)) ? htmlspecialchars_decode($result->instruction) : ''); ?></textarea>
	<?php echo form_error('instruction'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/qa','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>