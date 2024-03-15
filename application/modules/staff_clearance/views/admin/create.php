<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Staff Clearance  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/staff_clearance/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Staff Clearance')), 'class="btn btn-primary"');?> 
				
				<?php echo anchor( 'admin/staff_clearance/bulk' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Bulk Clearance')), 'class="btn btn-warning"');?> 
				
              <?php echo anchor( 'admin/staff_clearance' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Staff Clearance')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='student'>Staff <span class='required'>*</span></div><div class="col-md-6">
	 <?php
           echo form_dropdown('staff', array('' => 'Select staff') + $all_staff, (isset($result->staff)) ? $result->staff : '', ' class="select"');
       ?>
 	<?php echo form_error('staff'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='date'>Date <span class='required'>*</span></div><div class="col-md-6">
	  <div class="input-group">
	<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php echo isset($result->date) ? date('d M Y',$result->date) : ''; ?>"  />
	<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        </div>
 	<?php echo form_error('date'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='department'>Department <span class='required'>*</span></div>
<div class="col-md-6">


	   
                <?php 
				$items = $this->ion_auth->populate('clearance_departments','id','name');
     echo form_dropdown('department', array(''=>'Select Department')+$items,  (isset($result->department)) ? $result->department : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('department'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='cleared'>Cleared <span class='required'>*</span></div><div class="col-md-6">
	<?php $tems = array('Yes'=>'Yes','No'=>'No');
		echo form_dropdown('cleared', array('' => 'Select') + $tems,  (isset($result->cleared)) ? $result->cleared : ''  , ' class="cleared" id="cleared" '); ?>
 	<?php echo form_error('cleared'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='charge'>Charge </div><div class="col-md-6">
	<?php echo form_input('charge' ,$result->charge , 'id="charge_"  class="form-control" ' );?>
 	<?php echo form_error('charge'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='student'>Confirmed By <span class='required'>*</span></div><div class="col-md-6">
	 <?php
           echo form_dropdown('confirmed_by', array('' => 'Select Staff') + $all_staff, (isset($result->confirmed_by)) ? $result->confirmed_by : '', ' class="select " style=""');
       ?>
 	<?php echo form_error('staff'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Description </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/staff_clearance','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>