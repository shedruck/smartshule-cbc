<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Students Projects  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/students_projects/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Students Projects')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/students_projects' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Projects')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='class'>Class/Level <span class='required'>*</span></div><div class="col-md-6">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo form_dropdown('level',array(''=>'Select Level')+ $classes + array('999'=>'Any level'), (isset($result->level)) ? $result->level : '', ' class="select class" id="class" data-placeholder="" ');
		?>
 	<?php echo form_error('level'); ?>
</div>
</div>



<div class='form-group'>
	<div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
	 <select name="student" class="select select_stud" id="select_stud" style="" tabindex="-1">
										<option value="">Search Student</option>
										<?php
										$data = $this->ion_auth->students_full_details();
										foreach ($data as $key => $value):
												?>
												<option value="<?php echo $key; ?>"><?php echo $value ?></option>
										<?php endforeach; ?>
										
										<?php echo form_error('student'); ?>
									</select>
									
 	<?php echo form_error('student'); ?>
</div>
</div>
<?php
$range = range(date('Y') - 1, date('Y') + 1);
$yrs = array_combine($range, $range);
krsort($yrs);
?>

<div class='form-group'>
	<div class="col-md-3 " for='day'>Select Year  <span class="required">*</span> </div><div class="col-md-6">
	<?php 

	 echo form_dropdown('year', array(date('Y')=>date('Y')) + $yrs , (isset($result->year)) ? $result->year : '', ' class="select" data-placeholder="Select Options..." ');
	
	?>
 	<?php echo form_error('year'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3 " for='day'>Term  <span class="required">*</span> </div><div class="col-md-6">
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
	<div class="col-md-3" for='subject'>Subject/Learning Area <span class='required'>*</span></div><div class="col-md-6">
	<?php 
		 $items = array('' =>'Select Subject');		
		 echo form_dropdown('subject', $items,  (isset($result->subject)) ? $result->subject : '',' id="subject" class="select" data-placeholder="Select Options..." ');
		 echo form_error('subject'); 
	 ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='strand'>Strand </div><div class="col-md-6">
	<?php echo form_input('strand' ,$result->strand , 'id="strand_"  class="form-control" ' );?>
 	<?php echo form_error('strand'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='file'>Upload Picture</div>
 <div class="col-md-6">
	<input id='file' type='file' name='file' />

	<?php if ($updType == 'edit'): ?>
	<a href='/public/uploads/students_projects/files/<?php echo $result->file?>' />Download actual file (file)</a>
	<?php endif ?>

	<br/><?php echo form_error('file'); ?>
	<?php  echo ( isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Remarks </h2></div>
	 <div class="block-fluid editor">
	<textarea id="remarks"   style="height: 300px;" class=" wysiwyg "  name="remarks"  /><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
	<?php echo form_error('remarks'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/students_projects','Cancel','class="btn  btn-default"');?>
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