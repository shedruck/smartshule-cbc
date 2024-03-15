
<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b>   Schemes of Work    </b>
        </h3>
		<div class="pull-right">
		 
		  <?php echo anchor( 'schemes_of_work/trs' , '<i class="fa fa-list">
                </i> '.lang('web_list_all', array(':name' => 'Schemes of work')), 'class="btn btn-primary"');?>
				
<a class="btn  btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>				
      </div>
        <div class="clearfix"></div>
        <hr>
    </div>


         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<?php
$range = range(date('Y') - 1, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);
?>

<div class='form-group'>
	<div class="col-md-3  control-label " for='day'>Select Year  <span class="required">*</span> </div><div class="col-md-6">
	<?php 

	 echo form_dropdown('year', array(date('Y')=>date('Y')) + $yrs , (isset($result->year)) ? $result->year : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('year'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3  control-label " for='day'>Term  <span class="required">*</span> </div><div class="col-md-6">
	<?php 
	
	 $settings = $this->ion_auth->settings();
	 
	$items =array(
	'1'=>'Term 1',
	'2'=>'Term 2',
	'3'=>'Term 3',

	);
	 echo form_dropdown('term', array($settings->term => 'Term '. $settings->term) + $items, (isset($result->term)) ? $result->term : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('term'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3  control-label" for='class'>Class/Level <span class='required'>*</span></div><div class="col-md-6">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo form_dropdown('level',array(''=>'Select Level')+ $classes + array('999'=>'Any level'), (isset($result->level)) ? $result->level : '', ' class="select class" id="class" data-placeholder="" ');
		?>
 	<?php echo form_error('level'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3  control-label" for='week'>Week <span class='required'>*</span></div><div class="col-md-6">
		<input type="number" name="week" class="form-control" value="<?php echo $result->week  ?>">
 	<?php echo form_error('week'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3  control-label" for='subject'>Subject/Learning Area <span class='required'>*</span></div><div class="col-md-6">
	<?php 
		 $items = array('' =>'Select Subject');		
		 echo form_dropdown('subject', $items,  (isset($result->subject)) ? $result->subject : '',' id="subject" class="select" data-placeholder="Select Options..." ');
		 echo form_error('subject'); 
	 ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3  control-label" for='strand'>Strand <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('strand' ,$result->strand , 'id="strand_"  class="form-control" ' );?>
 	<?php echo form_error('strand'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3  control-label  control-label" for='substrand'>Sub-strand </div><div class="col-md-6">
	<?php echo form_input('substrand' ,$result->substrand , 'id="substrand_"  class="form-control" ' );?>
 	<?php echo form_error('substrand'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3  control-label control-label" for='topic'>Lesson</div><div class="col-md-6">
	 <textarea id="lesson"   style="height: 120px;" class=" summernote "  name="lesson"  /><?php echo isset($result->lesson) ? htmlspecialchars_decode($result->lesson) : ''; ?></textarea>
	
	<?php echo form_error('lesson'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Specific Learning Outcomes</div><div class="col-md-6">
	 <textarea id="specific_learning_outcomes"   style="height: 120px;" class=" summernote "  name="specific_learning_outcomes"  /><?php echo isset($result->specific_learning_outcomes) ? htmlspecialchars_decode($result->specific_learning_outcomes) : ''; ?></textarea>
	
	<?php echo form_error('specific_learning_outcomes'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Key Inquiry Question</div><div class="col-md-6">
	 <textarea id="key_inquiry_question"   style="height: 120px;" class=" summernote "  name="key_inquiry_question"  /><?php echo isset($result->key_inquiry_question) ? htmlspecialchars_decode($result->key_inquiry_question) : ''; ?></textarea>
	
	<?php echo form_error('key_inquiry_question'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Learning Experiences</div><div class="col-md-6">
	 <textarea id="learning_experiences"   style="height: 120px;" class=" summernote "  name="learning_experiences"  /><?php echo isset($result->learning_experiences) ? htmlspecialchars_decode($result->learning_experiences) : ''; ?></textarea>
	
	<?php echo form_error('learning_experiences'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Learning Resources</div><div class="col-md-6">
	 <textarea id="learning_resources"   style="height: 120px;" class=" summernote "  name="learning_resources"  /><?php echo isset($result->learning_resources) ? htmlspecialchars_decode($result->learning_resources) : ''; ?></textarea>
	
	<?php echo form_error('learning_resources'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Assessment</div><div class="col-md-6">
	 <textarea id="assessment"   style="height: 120px;" class=" summernote "  name="assessment"  /><?php echo isset($result->assessment) ? htmlspecialchars_decode($result->assessment) : ''; ?></textarea>
	
	<?php echo form_error('assessment'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Reflection</div><div class="col-md-6">
	 <textarea id="reflection"   style="height: 120px;" class=" summernote "  name="reflection"  /><?php echo isset($result->reflection) ? htmlspecialchars_decode($result->reflection) : ''; ?></textarea>
	
	<?php echo form_error('reflection'); ?>
</div>
</div>





<div class='form-group'><div class="col-md-3  control-label"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/schemes_of_work','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			
						
						<script>
    jQuery(function () {

        jQuery("#class").change(function () {
            jQuery('#subject').empty();

            var level = jQuery(".class").val();
           
            var options = '';
            jQuery('#subject').children().remove();

            jQuery.getJSON("<?php echo base_url('admin/evideos/list_subjects'); ?>", {id: jQuery(this).val()}, function (data) {


                for (var i = 0; i < data.length; i++) {
					
                    options += '<option value="' + data[i].optionValue + '">' + data[i].optionDisplay + '</option>';
                }

                jQuery('#subject').append(options);

            });

            //alert(options);
        });

        $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
    });

</script>	