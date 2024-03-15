<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
				 <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-4">		
								<h4 class="m-b-10">  Loan Application  </h4>
							</div>
             <div class="col-md-8">
                                <div class="pull-right">
         <?php echo anchor( 'st/loan_application/' , '<i class="fa fa-plus"></i> New Application', 'class="btn btn-primary"');?> 
         <?php echo anchor( 'st/loan_statement/' , '<i class="fa fa-file"></i> Statement', 'class="btn btn-success"');?> 
		 
         <?php echo anchor( 'st/finance' , '<i class="fa fa-caret-left"></i> Exit ', 'class="btn btn-danger"');?> 
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
			<hr>      
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>



<div class='form-group row'>
	<div class="col-md-3" for='date'>Date <span class='required'>*</span></div>
	<div class="col-md-4 ">

	<input id='date' type='text' name='date' maxlength='' class='form-control datepicker' value="<?php echo set_value('date', (isset($result->date)) ? $result->date : ''); ?>"  /> 
 	<?php echo form_error('date'); ?>
	


</div>
</div>

<div class='form-group row'>
	<div class="col-md-3" for='amount'>Amount <span class='required'>*</span></div><div class="col-md-5">
	<?php echo form_input('amount' ,$result->amount , 'id="amount_"  class="form-control" ' );?>
 	<?php echo form_error('amount'); ?>
</div>
</div>

<div class='form-group row'>
	<div class="col-md-3" for='loan_type'>Loan Type <span class='required'>*</span></div>
<div class="col-md-5">
                <?php $items = array('' =>'Select Options', 
"school fee"=>"School Fee",
"emergency loan"=>"Emergency Loan",
);		
     echo form_dropdown('loan_type', $items,  (isset($result->loan_type)) ? $result->loan_type : ''     ,   ' class=" select form-control" data-placeholder="Select Options..." ');
     echo form_error('loan_type'); ?>
</div></div>



<div class='form-group row'>
	<div class="col-md-3" for='repayment_period'>Repayment Period </div><div class="col-md-5">
  <?php $items = array('' =>'Select Options', 
"1 Month"=>"1 Month",
"2 Months"=>"2 Months",
"3 Months"=>"3 Months",
"6 Months"=>"6 Months",
"1 Year"=>"1 Year",
);		
     echo form_dropdown('repayment_period', $items,  (isset($result->repayment_period)) ? $result->repayment_period : ''     ,   ' class=" select form-control" data-placeholder="Select Options..." ');
     ?>
	 
 	<?php echo form_error('repayment_period'); ?>
</div>

</div>

 <div class='form-group row'>
        <div class="col-md-3">
	Reason </div>
	 <div class="col-md-5">
	<textarea id="reason"  class=" form-control " rows="5"  name="reason"  /><?php echo set_value('reason', (isset($result->reason)) ? htmlspecialchars_decode($result->reason) : ''); ?></textarea>
	<?php echo form_error('reason'); ?>
    </div>
</div>

<div class='form-group row'><div class="col-md-3"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Submit Application', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('st/loans','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
            </div>
            </div>
            </div>