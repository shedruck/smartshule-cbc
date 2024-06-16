<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Record Of Work Covered  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/record_of_work_covered/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Record Of Work Covered')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/record_of_work_covered' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Record Of Work Covered')), 'class="btn btn-primary"');?> 
             
                </div>
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
	<div class="col-md-3" for='class'>Class/Level <span class='required'>*</span></div><div class="col-md-6">
	<?php 
	    $classes = $this->portal_m->get_class_options();
		echo form_dropdown('level',array(''=>'Select Level')+ $classes + array('999'=>'Any level'), (isset($result->level)) ? $result->level : '', ' class="select class" id="class" data-placeholder="" ');
		?>
 	<?php echo form_error('level'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='week'>Week <span class='required'>*</span></div><div class="col-md-6">
		<input type="number" name="week" class="form-control" value="<?php echo $result->week  ?>">
 	<?php echo form_error('week'); ?>
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
	<div class="col-md-3" for='date'>Date </div><div class="col-md-6">
	<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php if($updType == 'edit') echo isset($result->date) ? date('d M Y',$result->date) : '';  ?>"  />
 	<?php echo form_error('date'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='strand'>Strand </div><div class="col-md-6">
	<?php echo form_input('strand' ,$result->strand , 'id="strand_"  class="form-control" ' );?>
 	<?php echo form_error('strand'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='substrand'>Substrand </div><div class="col-md-6">
	<?php echo form_input('substrand' ,$result->substrand , 'id="substrand_"  class="form-control" ' );?>
 	<?php echo form_error('substrand'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Work Covered </h2></div>
	 <div class="block-fluid editor">
	<textarea id="work_covered"   style="height: 300px;" class=" wysiwyg "  name="work_covered"  /><?php echo set_value('work_covered', (isset($result->work_covered)) ? htmlspecialchars_decode($result->work_covered) : ''); ?></textarea>
	<?php echo form_error('work_covered'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Reflection </h2></div>
	 <div class="block-fluid editor">
	<textarea id="reflection"   style="height: 300px;" class=" wysiwyg "  name="reflection"  /><?php echo set_value('reflection', (isset($result->reflection)) ? htmlspecialchars_decode($result->reflection) : ''); ?></textarea>
	<?php echo form_error('reflection'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/record_of_work_covered','Cancel','class="btn  btn-default"');?>
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