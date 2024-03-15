<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Appraisal Targets  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/appraisal_targets/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/appraisal_targets' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='term'>Term <span class='required'>*</span></div>
<div class="col-md-6">
               <select class="select select2" name="term">
                  <option value="">Select Term</option>
                  <option value="term1">Term 1</option>
                  <option value="term2">Term 2</option>
                  <option value="term3">Term 3</option>
               </select>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='year'>Year <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('year' ,$result->year , 'id="year_"  class="form-control" ' );?>
 	<?php echo form_error('year'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='target'>Target <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('target' ,$result->target , 'id="target_"  class="form-control" ' );?>
 	<?php echo form_error('target'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='target'>Start Date <span class='required'>*</span></div><div class="col-md-6">
    <input type="date" id="date" name="start_date" class="form-control" required>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='target'>End Date <span class='required'>*</span></div><div class="col-md-6">
    <input type="date" id="date" name="end_date" class="form-control" required>
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
	<?php echo anchor('admin/appraisal_targets','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>