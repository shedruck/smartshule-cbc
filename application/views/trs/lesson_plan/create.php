<div class=""> 

<div class="col-md-12 card-box table-responsive">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h3> Add New Lesson Plan 
             <div class="pull-right"> 
            
              <?php echo anchor( 'trs/lesson_plan' , '<i class="mdi mdi-list">
                </i> '.lang('web_list_all', array(':name' => 'Lesson Plan')), 'class="btn btn-primary"');?> 
             
                </div> 
				</h3>
				<hr>
                </div>
         	                    
               
			

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>

<div class='form-group'>
	<div class="col-md-3 control-label" for='day'>Class/Level  <span class="required">*</span> </div><div class="col-md-6">
	<?php

                                $classes = $this->ion_auth->fetch_classes();
                                echo form_dropdown('class',array(''=>'Select Class')+ $classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select  Options..." ');

                                ?>
 	<?php echo form_error('class'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='day'>Term  <span class="required">*</span> </div><div class="col-md-6">
	<?php 
	$items =array(
	'1'=>'Term 1',
	'2'=>'Term 2',
	'3'=>'Term 3',

	);
	 echo form_dropdown('term', array('' => 'Select term') + $items, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('term'); ?>
</div>
</div>

<?php
$range = range(date('Y') - 1, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);
?>

<div class='form-group'>
	<div class="col-md-3 control-label" for='day'>Select Year  <span class="required">*</span> </div><div class="col-md-6">
	<?php 

	 echo form_dropdown('year', array('' => 'Select year') + $yrs, (isset($result->year)) ? $result->year : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('year'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='week'>Week of the Term <span class="required">*</span></div><div class="col-md-6">
	<input type="number" name="week" class="form-control" value="<?php echo $result->week  ?>">
	
 	<?php echo form_error('week'); ?>
</div>
</div>



<div class='form-group'>
	<div class="col-md-3 control-label" for='day'>Day of the week  <span class="required">*</span> </div><div class="col-md-6">
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
	 echo form_dropdown('day', array('' => 'Select day') + $items, (isset($result->day)) ? $result->day : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('day'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Subject (Learning Area)  <span class="required">*</span></div><div class="col-md-6">
	<?php echo form_input('subject' ,$result->subject , 'id="subject_"  class="form-control" ' );?>
 	<?php echo form_error('subject'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Lesson <span class="required">*</span> </div><div class="col-md-8">
	<textarea id="lesson"   class=" summernote "  name="lesson"  /><?php echo set_value('lesson', (isset($result->lesson)) ? htmlspecialchars_decode($result->lesson) : ''); ?></textarea>
	<?php echo form_error('lesson'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Activity </div><div class="col-md-8">
	<textarea id="activity"   style="height: 80px;" class=" summernote "  name="activity"  /><?php echo set_value('activity', (isset($result->activity)) ? htmlspecialchars_decode($result->activity) : ''); ?></textarea>
	<?php echo form_error('activity'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Objective </div><div class="col-md-8">
	<textarea id="objective"   style="height: 80px;" class=" summernote "  name="objective"  /><?php echo set_value('objective', (isset($result->objective)) ? htmlspecialchars_decode($result->objective) : ''); ?></textarea>
	<?php echo form_error('objective'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Materials </div><div class="col-md-8">
	<textarea id="materials"   style="height: 80px;" class=" summernote "  name="materials"  /><?php echo set_value('materials', (isset($result->materials)) ? htmlspecialchars_decode($result->materials) : ''); ?></textarea>
	<?php echo form_error('materials'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Assignment </div><div class="col-md-8">
	<textarea id="assignment"   style="height: 80px;" class=" summernote "  name="assignment"  /><?php echo set_value('assignment', (isset($result->assignment)) ? htmlspecialchars_decode($result->assignment) : ''); ?></textarea>
	<?php echo form_error('assignment'); ?>
</div>
</div>


<div class='form-group'><div class="col-md-3 control-label"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/lesson_plan','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
          
            </div>