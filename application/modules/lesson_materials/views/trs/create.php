		
<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> Lesson Materials    </b>
        </h3>
		 <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		 <?php echo anchor( 'lesson_materials/trs/', '<i class="fa fa-plus"></i> All Lesson Materials', 'class="btn btn-primary btn-sm pull-right"');?>
      
        <div class="clearfix"></div>
        <hr>
    </div>
         	                    
               
<div class="block-fluid">
				   
<?php
$range = range(date('Y') - 5, date('Y') + 2);
$yrs = array_combine($range, $range);
krsort($yrs);
?>



<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>


<div class='form-group'>
	<div class="col-md-3 control-label" for='year'>Year <span class='required'>*</span></div><div class="col-md-6">
	  <?php
			echo form_dropdown('year', array('' => '') + $yrs, (isset($result->year) && !empty($result->year)) ? $result->year : date('Y'), ' class="select" placeholder="Select Year" ');
			echo form_error('year');
		?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='class'>Class <span class='required'>*</span></div><div class="col-md-6">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo form_dropdown('class',array(''=>'Select Class')+ $classes + array('999'=>'Any class'), (isset($result->class)) ? $result->class : '', ' class="select class" id="class" data-placeholder="" ');
		?>
 	<?php echo form_error('class'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subject'>Subject/Learning Area <span class='required'>*</span></div><div class="col-md-6">
	<?php 
		 $items = array('' =>'Select Subject');		
		 echo form_dropdown('subject', $items,  (isset($result->subject)) ? $result->subject : '',' id="subject" class="select" data-placeholder="Select Options..." ');
		 echo form_error('subject'); 
	 ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Topic </div><div class="col-md-6">
	<?php echo form_input('topic' ,$result->topic , 'id="topic_"  class="form-control" ' );?>
 	<?php echo form_error('topic'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='subtopic'>Subtopic </div><div class="col-md-6">
	<?php echo form_input('subtopic' ,$result->subtopic , 'id="subtopic_"  class="form-control" ' );?>
 	<?php echo form_error('subtopic'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3 control-label" for='file'>Upload a attachment (pdf/word/image) </div>
 <div class="col-md-6">
	<input id='file' type='file' name='file' />

	<?php if ($updType == 'edit'): ?>
	<a target="_blank" href='<?php echo base_url()?><?php echo $result->file_path?><?php echo $result->file_name;?>' />Download actual file</a>
	<?php endif ?>

	<br/><?php echo form_error('file'); ?>
	<?php  echo ( isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3 control-label" for='topic'>Soft (Paste Soft copy here if not attachment) </div><div class="col-md-6">
	 <textarea id="soft"   style="height: 120px;" class=" summernote "  name="soft"  /><?php echo isset($result->soft) ? htmlspecialchars_decode($result->soft) : ''; ?></textarea>
	
	<?php echo form_error('soft'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3 control-label " for='topic'>Comment</div><div class="col-md-6">
	 <textarea id="comment"   style="height: 120px;" class=" summernote "  name="comment"  /><?php echo isset($result->comment) ? htmlspecialchars_decode($result->comment) : ''; ?></textarea>
	
	<?php echo form_error('comment'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3 control-label"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/lesson_materials','Cancel','class="btn  btn-default"');?>
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