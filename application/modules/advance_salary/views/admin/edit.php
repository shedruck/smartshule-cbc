<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Advance Salary  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/advance_salary/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Advance Salary')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/advance_salary' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Advance Salary')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>

<div class='form-group'>
	<div class="col-md-3" for='advance_date'> Date <span class='required'>*</span></div><div class="col-md-4">
	<div id="datetimepicker1" class="input-group date form_datetime">
	  <?php echo form_input('advance_date', $result->advance_date > 0 ? date('d M Y', $result->advance_date) : $result->advance_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	
	 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
	  </div>
 	<?php echo form_error('advance_date'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3" for='employee'>Employee <span class='required'>*</span></div><div class="col-md-4">
	 <?php 	
			
     echo form_dropdown('employee',  array('' => 'Select Employee') + $employees,  (isset($result->employee)) ? $result->employee : ''     ,   ' class="select " ');
     echo form_error('employee'); ?>
</div>
</div>


<div class='form-group'>
	<div class="col-md-3" for='amount'>Amount <span class='required'>*</span></div><div class="col-md-4">
	<?php echo form_input('amount' ,$result->amount , 'id="amount_"  class="form-control" ' );?>
 	<?php echo form_error('amount'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Comment </h2></div>
	 <div class="block-fluid editor">
	<textarea id="comment"  style="height: 300px;" class=" wysiwyg "  name="comment"  /><?php echo set_value('comment',(isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
	<?php echo form_error('comment'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-4">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/advance_salary','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>