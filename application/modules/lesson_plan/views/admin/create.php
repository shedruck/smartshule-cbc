<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Lesson Plan  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/lesson_plan/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/lesson_plan' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='teacher'>Teacher </div><div class="col-md-6">
	 <?php
	$items = $this->ion_auth->get_teachers();
	 echo form_dropdown('teacher', array('' => 'Select Teacher') + (array) $items, (isset($class->teacher)) ? $class->teacher : '', ' class="select" data-placeholder="Select Options..." ');
	echo form_error('teacher');
	?>
 
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='week'>Week </div><div class="col-md-6">
	<input type="number" name="week" class="form-control" value="<?php echo $result->week  ?>">
	
 	<?php echo form_error('week'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='day'>Day of the week </div><div class="col-md-6">
	<?php 
	$items =array(
	'Monday'=>'Monday',
	'Tuesday'=>'Tuesday',
	'Wednesday'=>'Wednesday',
	'Thursday'=>'Thursday',
	'Friday'=>'Friday',
	'Saturday'=>'Saturday',
	'Sunday'=>'Sunday',
	);
	 echo form_dropdown('day', array('' => 'Select day') + (array) $items, (isset($class->day)) ? $class->day : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('day'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='subject'>Subject </div><div class="col-md-6">
	<?php echo form_input('subject' ,$result->subject , 'id="subject_"  class="form-control" ' );?>
 	<?php echo form_error('subject'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Lesson </h2></div>
	 <div class="block-fluid editor">
	<textarea id="lesson"   style="height: 80px;" class="  "  name="lesson"  /><?php echo set_value('lesson', (isset($result->lesson)) ? htmlspecialchars_decode($result->lesson) : ''); ?></textarea>
	<?php echo form_error('lesson'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Activity </h2></div>
	 <div class="block-fluid editor">
	<textarea id="activity"   style="height: 80px;" class="  "  name="activity"  /><?php echo set_value('activity', (isset($result->activity)) ? htmlspecialchars_decode($result->activity) : ''); ?></textarea>
	<?php echo form_error('activity'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Objective </h2></div>
	 <div class="block-fluid editor">
	<textarea id="objective"   style="height: 80px;" class="  "  name="objective"  /><?php echo set_value('objective', (isset($result->objective)) ? htmlspecialchars_decode($result->objective) : ''); ?></textarea>
	<?php echo form_error('objective'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Materials </h2></div>
	 <div class="block-fluid editor">
	<textarea id="materials"   style="height: 80px;" class="  "  name="materials"  /><?php echo set_value('materials', (isset($result->materials)) ? htmlspecialchars_decode($result->materials) : ''); ?></textarea>
	<?php echo form_error('materials'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Assignment </h2></div>
	 <div class="block-fluid editor">
	<textarea id="assignment"   style="height: 80px;" class="  "  name="assignment"  /><?php echo set_value('assignment', (isset($result->assignment)) ? htmlspecialchars_decode($result->assignment) : ''); ?></textarea>
	<?php echo form_error('assignment'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/lesson_plan','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>