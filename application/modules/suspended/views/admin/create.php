<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Suspended  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/suspended/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Suspended')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/suspended' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Suspended')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<h4>You are about to suspend "<?php echo $ps->first_name.' '.$ps->last_name; ?>"</h4>
<div class='form-group'>
	<div class="col-md-3" for='date'>Suspension Date <span class='required'>*</span></div>
	<div class="col-md-6">
	 <div id="datetimepicker1" class="input-group date form_datetime">
	<input id='date' type='text' name='date' maxlength='' class='form-control datepicker col-md-6' value="<?php echo set_value('date', (isset($result->date)) ? $result->date : ''); ?>"  />
	<span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
 	<?php echo form_error('date'); ?>
</div>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
	<h2>Reason <span class='required'>*</span></h2></div>
	 <div class="block-fluid editor">
	<textarea id="reason"   style="height: 300px;" class=" wysiwyg "  name="reason"  /><?php echo set_value('reason', (isset($result->reason)) ? htmlspecialchars_decode($result->reason) : ''); ?></textarea>
	<?php echo form_error('reason'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/suspended','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>