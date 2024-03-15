<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Students Clearance  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/students_clearance/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Students Clearance')), 'class="btn btn-primary"');?>

				<?php echo anchor( 'admin/students_clearance/bulk' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Bulk Clearance')), 'class="btn btn-warning"');?> 
				
              <?php echo anchor( 'admin/students_clearance' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Clearance')), 'class="btn btn-primary"');?> 
             
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
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="select"');
                ?>
                <?php echo form_error('student'); ?> 
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
                <?php $items = $this->ion_auth->populate('clearance_departments','id','name');		
     echo form_dropdown('department', array(''=>'Select Option')+$items,  (isset($result->department)) ? $result->department : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
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
	<div class="col-md-3" for='charge'>Charge <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('charge' ,$result->charge , 'id="charge_"  class="form-control" ' );?>
 	<?php echo form_error('charge'); ?>
</div>
</div>
<!--
<div class='form-group'>
	<div class="col-md-3" for='department'>Student Card Returned<span class='required'>*</span></div>
	<div class="col-md-6">
					<?php $items = array('No' =>'No', 
										"Yes"=>"Yes",
										"No card was given"=>"No card was given",
										);		
		 echo form_dropdown('student_card', $items,  (isset($result->student_card)) ? $result->student_card : '',' class="chzn-select" data-placeholder="Select Options..." ');
		 echo form_error('student_card'); ?>
	</div>
</div>
-->

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
	<h2>Pending Items </h2></div>
	 <div class="block-fluid editor">
	<textarea id="description"   style="height: 300px;" class=" wysiwyg "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/students_clearance','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>