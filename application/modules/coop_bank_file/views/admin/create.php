<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Coop Bank File  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/coop_bank_file/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Coop Bank File')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/coop_bank_file' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Coop Bank File')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='transaction_date'>Transaction Date </div><div class="col-md-6">
	<?php echo form_input('transaction_date' ,$result->transaction_date , 'id="transaction_date_"  class="form-control" ' );?>
 	<?php echo form_error('transaction_date'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='value_date'>Value Date </div><div class="col-md-6">
	<?php echo form_input('value_date' ,$result->value_date , 'id="value_date_"  class="form-control" ' );?>
 	<?php echo form_error('value_date'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='channel_ref'>Channel Ref </div><div class="col-md-6">
	<?php echo form_input('channel_ref' ,$result->channel_ref , 'id="channel_ref_"  class="form-control" ' );?>
 	<?php echo form_error('channel_ref'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='transaction_ref'>Transaction Ref </div><div class="col-md-6">
	<?php echo form_input('transaction_ref' ,$result->transaction_ref , 'id="transaction_ref_"  class="form-control" ' );?>
 	<?php echo form_error('transaction_ref'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='narative'>Narative </div><div class="col-md-6">
	<?php echo form_input('narative' ,$result->narative , 'id="narative_"  class="form-control" ' );?>
 	<?php echo form_error('narative'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='debit'>Debit </div><div class="col-md-6">
	<?php echo form_input('debit' ,$result->debit , 'id="debit_"  class="form-control" ' );?>
 	<?php echo form_error('debit'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='credit'>Credit </div><div class="col-md-6">
	<?php echo form_input('credit' ,$result->credit , 'id="credit_"  class="form-control" ' );?>
 	<?php echo form_error('credit'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='running_bal'>Running Bal </div><div class="col-md-6">
	<?php echo form_input('running_bal' ,$result->running_bal , 'id="running_bal_"  class="form-control" ' );?>
 	<?php echo form_error('running_bal'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='transaction_no'>Transaction No </div><div class="col-md-6">
	<?php echo form_input('transaction_no' ,$result->transaction_no , 'id="transaction_no_"  class="form-control" ' );?>
 	<?php echo form_error('transaction_no'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='admission_no'>Admission No </div><div class="col-md-6">
	<?php echo form_input('admission_no' ,$result->admission_no , 'id="admission_no_"  class="form-control" ' );?>
 	<?php echo form_error('admission_no'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='student'>Student </div><div class="col-md-6">
	<?php echo form_input('student' ,$result->student , 'id="student_"  class="form-control" ' );?>
 	<?php echo form_error('student'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-3" for='phone'>Phone </div><div class="col-md-6">
	<?php echo form_input('phone' ,$result->phone , 'id="phone_"  class="form-control" ' );?>
 	<?php echo form_error('phone'); ?>
</div>
</div>

<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/coop_bank_file','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>