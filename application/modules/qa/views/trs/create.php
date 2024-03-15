<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> Question and Answers </b>
        </h3>
		 <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		 <?php echo anchor( 'qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-primary btn-sm pull-right"');?>
      
        <div class="clearfix"></div>
        <hr>
    </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3 control-label" for='title'>Level <span class='required'>*</span></div><div class="col-md-6">
	<?php

		$classes = $this->portal_m->get_class_options();
		echo form_dropdown('level',array(''=>'Select Class')+ $classes, (isset($result->level)) ? $result->level : '', ' class="select" data-placeholder="Select  Options..." ');

		?>
 	<?php echo form_error('level'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='title'>Q&A Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" placeholder="E.g Opener Test One"' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Subject <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('subject' ,$result->subject , 'id="subject_"  class="form-control" ' );?>
 	<?php echo form_error('subject'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Topic </div><div class="col-md-6">
	<?php echo form_input('topic' ,$result->topic , 'id="topic_"  class="form-control" ' );?>
 	<?php echo form_error('topic'); ?>
</div>
</div>


<div class='form-group '>
	<div class="col-md-3 control-label" for='hours'>Duration <span class='required'>*</span></div>
	<div class="col-md-1"><span class="pull-right">Hours</span></div>
	<div class="col-md-2">
		<input id='hours' type='number' name='hours' placeholder="E.g 1, 2 etc"  maxlength='' class='form-control ' value="<?php echo isset($result->hours) ? $result->hours :'' ;?>"  />
		<?php echo form_error('hours'); ?>
		<br>
		
	</div>
	<div class="col-md-1 "><span class="pull-right">Minutes</span></div>
	<div class="col-md-2">
		<input id='minutes' type='number' name='minutes' placeholder="E.g 15, 30, 45 etc" maxlength='' class='form-control' value="<?php echo isset($result->minutes) ? $result->minutes : '';?>"  />
		<?php echo form_error('minutes'); ?>
	</div>
	</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Instruction </div><div class="col-md-6">
	 <textarea id="instruction"   style="height: 120px;" class=" summernote "  name="instruction"  /><?php echo isset($result->instruction) ? htmlspecialchars_decode($result->instruction) : ''; ?></textarea>
	
	<?php echo form_error('instruction'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3 control-label"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/qa','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>