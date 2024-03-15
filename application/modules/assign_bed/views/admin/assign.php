<div class="col-sm-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Assign Bed  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/assign_bed/create' , '<i class="icon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Assign Bed')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/assign_bed' , '<i class="icon-list">
                </i> '.lang('web_list_all', array(':name' => 'Assign Bed')), 'class="btn btn-primary"');?> 
             
                </div>
        </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-sm-3" for='date_assigned'>Date Assigned <span class='required'>*</span></div><div class="col-sm-6">
	<div id="datetimepicker1" class="input-append date form_datetime">
	<input id='date_assigned' type='text' name='date_assigned' maxlength='' class='form-control datepicker' value="<?php echo set_value('date_assigned', (isset($result->date_assigned)) ? $result->date_assigned : ''); ?>"  />
	  <span class="add-on "><i class="icon-calendar "></i></span>
	  </div>
 	<?php echo form_error('date_assigned'); ?>

</div>
</div>

<div class='form-group'>
	<div class="col-sm-3" for='student'>Student <span class='required'>*</span></div><div class="col-sm-6">
	<?php $data=$this->ion_auth->students_full_details(); 
	echo form_dropdown('student' ,array(''=>'Select Student')+$data ,(isset($result->student)) ? $result->student : ''     ,   ' class="select " ');?>
 	<?php echo form_error('student'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-sm-3" for='student'>Term <span class='required'>*</span></div><div class="col-sm-6">
	 <?php
                echo form_dropdown('term', array('' => 'Select Term') + $this->terms, (isset($result->term)) ? $result->term : '', ' class="select" ');
                echo form_error('term');
                ?>
	
</div>
</div>

<div class='form-group'>
            <div class="col-md-3" for='year'>Year<span class='required'>*</span></div><div class="col-md-9">
                <?php
                krsort($yrs);
                echo form_dropdown('year', array('' => 'Select Year') + $yrs, (isset($result->year)) ? $result->year : '', ' class="select" ');
                echo form_error('year');
                ?>
            </div>
        </div>


<div class='form-group'>
	<div class="col-sm-3" for='student'> Comment </div>
	<div class="col-sm-6">
	<textarea id="comment"   style="" class="  "  name="comment"  /><?php echo set_value('comment', (isset($result->comment)) ? htmlspecialchars_decode($result->comment) : ''); ?></textarea>
	<?php echo form_error('comment'); ?>
</div>
</div>


<div class='form-group'><div class="col-sm-3"></div><div class="col-sm-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/assign_bed','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
