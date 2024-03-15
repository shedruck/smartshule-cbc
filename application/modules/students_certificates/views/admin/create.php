<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Students Certificates  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/students_certificates/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Students Certificates')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/students_certificates' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Certificates')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>

<div class='form-group'>
	<div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
	 <?php
			$student=$this->ion_auth->students_full_details();
			echo form_dropdown('student',array(''=>'Select Student')+ $student, (isset($result->student)) ? $result->student : '', ' class="select" ');
			?>	
 	<?php echo form_error('student'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3" for='date'>Date <span class='required'>*</span></div>
	<div class="col-md-6">
	  <div id="datetimepicker1" class="input-group date form_datetime">
	<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php if($updType == 'edit') echo isset($result->date) ? date('d M Y',$result->date) : ''; ?>"  />
	 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
 	<?php echo form_error('date'); ?>
</div>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='title'>Certificate number <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('certificate_number' ,$result->certificate_number , 'id="title_"  class="form-control" ' );?>
 	<?php echo form_error('certificate_number'); ?>
</div>
</div>



<div class='form-group'>
	<div class="col-md-3" for='file'>Upload Certificate <span class='required'>*</span></div>
 <div class="col-md-6">
	<input id='file' type='file' name='file' <?php if ($updType == 'create'): ?>required="required"<?php endif ?> />

	<?php if ($updType == 'edit'): ?>
	<a href='/public/uploads/students_certificates/files/<?php echo $result->file?>' />Download actual file (file)</a>
	<?php endif ?>

	<br/><?php echo form_error('file'); ?>
	<?php  echo ( isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Description </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 500px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/students_certificates','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>