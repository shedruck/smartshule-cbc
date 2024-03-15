<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Grants  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/grants/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Grants')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/grants' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Grants')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='grant_type'>Grant Type <span class='required'>*</span></div>
<div class="col-md-6">
                <?php $items = array('' =>'Select Option', 
"National Government"=>"National Government",
"County Government"=>"County Government",
"NGO"=>"NGO",
"Others"=>"Others",
);		
     echo form_dropdown('grant_type', $items,  (isset($result->grant_type)) ? $result->grant_type : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('grant_type'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='date'>Date <span class='required'>*</span></div><div class="col-md-6">
	 <div class="input-group form_dadtetime">
	<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php echo $result->date ? date('d M Y',$result->date) : ''; ?>"  />
	 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
 	<?php echo form_error('date'); ?>
</div>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='amount'>Amount <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('amount' ,$result->amount , 'id="amount_"  class="form-control" ' );?>
 	<?php echo form_error('amount'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='payment_method'>Payment Method <span class='required'>*</span></div>
<div class="col-md-6">
                <?php  
			$items = array('Bank Slip' => 'Bank Slip', 'Cash' => 'Cash', 'M-Pesa' => 'M-Pesa', 'Cheque' => 'Cheque','Bank Transfer'=>'Bank Transfer','Money Order'=>'Money Order');
     echo form_dropdown('payment_method', $items,  (isset($result->payment_method)) ? $result->payment_method : ''     ,   ' class="chzn-select" data-placeholder="Select Options..." ');
     echo form_error('payment_method'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='payment_method'>Bank Deposited </div>
<div class="col-md-6">
                <?php
				
					echo form_dropdown('bank', array('' => 'Select Bank Account') + $bank, (isset($result->bank)) ? $result->bank : '', ' class="chzn-select" id="Select Options..." ');
					?>
    <?php echo form_error('bank'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-3" for='payment_method'>Purpose <span class='required'>*</span></div>
<div class="col-md-6">
	<textarea id="purpose"    class="  "  name="purpose"  /><?php echo set_value('purpose', (isset($result->purpose)) ? htmlspecialchars_decode($result->purpose) : ''); ?></textarea>
	<?php echo form_error('purpose'); ?>

</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='school_representative'>School Representative </div><div class="col-md-6">
	<?php echo form_input('school_representative' ,$result->school_representative , 'id="school_representative_"  class="form-control" ' );?>
 	<?php echo form_error('school_representative'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='file'><?php echo lang( ($updType == 'edit')  ? "web_file_edit" : "web_file_create" )?> (file) </div>
 <div class="col-md-6">
	<input id='file' type='file' name='file' />

	<?php if ($updType == 'edit'): ?>
	<a href='/public/uploads/grants/files/<?php echo $result->file?>' />Download actual file (file)</a>
	<?php endif ?>

	<br/><?php echo form_error('file'); ?>
	<?php  echo ( isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='contact_person'>Contact Person </div><div class="col-md-6">
	<?php echo form_input('contact_person' ,$result->contact_person , 'id="contact_person_"  class="form-control" ' );?>
 	<?php echo form_error('contact_person'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='contact_details'>Contact Details </div><div class="col-md-6">
	<?php echo form_input('contact_details' ,$result->contact_details , 'id="contact_details_"  class="form-control" ' );?>
 	<?php echo form_error('contact_details'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/grants','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>