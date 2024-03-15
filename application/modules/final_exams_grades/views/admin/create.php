<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Final Exams Grades  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/final_exams_grades/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Final Exams Grades')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/final_exams_grades' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Final Exams Grades')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='certificate_id'>Certificate Id </div><div class="col-md-6">
	<?php echo form_input('certificate_id' ,$result->certificate_id , 'id="certificate_id_"  class="form-control" ' );?>
 	<?php echo form_error('certificate_id'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='subject'>Subject </div><div class="col-md-6">
	<?php echo form_input('subject' ,$result->subject , 'id="subject_"  class="form-control" ' );?>
 	<?php echo form_error('subject'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='grade'>Grade </div><div class="col-md-6">
	<?php echo form_input('grade' ,$result->grade , 'id="grade_"  class="form-control" ' );?>
 	<?php echo form_error('grade'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/final_exams_grades','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>