<div class="col-md-8">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Bank Accounts  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/bank_accounts/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Bank Accounts')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/bank_accounts' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Bank Accounts')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-2" for='bank_name'>Bank Name <span class='required'>*</span></div>
<div class="col-md-6">
                <?php $banks = array('ABC Bank (Kenya)'=>'ABC Bank (Kenya)',
'Bank of Africa'=>'Bank of Africa',
'Bank of Baroda'=>'Bank of Baroda',
'Bank of India'=>'Bank of India',
'Barclays Bank'=>'Barclays Bank',
'Century Deposit Taking Microfinance Limited'=>'Century Deposit Taking Microfinance Limited',
'CFC Stanbic Bank'=>'CFC Stanbic Bank',
'Chase Bank (Kenya)'=>'Chase Bank (Kenya)',
'Citibank'=>'Citibank',
'Commercial Bank of Africa'=>'Commercial Bank of Africa',
'Consolidated Bank of Kenya'=>'Consolidated Bank of Kenya',
'Cooperative Bank of Kenya'=>'Cooperative Bank of Kenya',
'Credit Bank'=>'Credit Bank',
'Development Bank of Kenya'=>'Development Bank of Kenya',
'Diamond Trust Bank'=>'Diamond Trust Bank',
'Dubai Bank Kenya'=>'Dubai Bank Kenya',
'Ecobank'=>'Ecobank',
'Equatorial Commercial Bank'=>'Equatorial Commercial Bank',
'Equity Bank'=>'Equity Bank',
'Family Bank'=>'Family Bank',
'Faulu Kenya DTM Limited'=>'Faulu Kenya DTM Limited',
'Fidelity Commercial Bank Limited'=>'Fidelity Commercial Bank Limited',
'Fina Bank'=>'Fina Bank',
'First Community Bank'=>'First Community Bank',
'Giro Commercial Bank'=>'Giro Commercial Bank',
'Guardian Bank'=>'Guardian Bank',
'Gulf African Bank'=>'Gulf African Bank',
'Habib Bank AG Zurich'=>'Habib Bank AG Zurich',
'Habib Bank'=>'Habib Bank',
'Housing Finance Company of Kenya'=>'Housing Finance Company of Kenya',
'I&M Bank'=>'I&M Bank',
'Imperial Bank Kenya'=>'Imperial Bank Kenya',
'Jamii Bora Bank'=>'Jamii Bora Bank',
'Kenya Commercial Bank'=>'Kenya Commercial Bank',
'Kenya Women Finance Trust DTM Limited'=>'Kenya Women Finance Trust DTM Limited',
'K-Rep Bank'=>'K-Rep Bank',
'Middle East Bank Kenya'=>'Middle East Bank Kenya',
'National Bank of Kenya'=>'National Bank of Kenya',
'NIC Bank'=>'NIC Bank',
'Oriental Commercial Bank'=>'Oriental Commercial Bank',
'Paramount Universal Bank'=>'Paramount Universal Bank',
'Prime Bank (Kenya)'=>'Prime Bank (Kenya)',
'Rafiki Deposit Taking Microfinance'=>'Rafiki Deposit Taking Microfinance',
'Remu DTM Limited'=>'Remu DTM Limited',
'SMEP Deposit Taking Microfinance Limited'=>'SMEP Deposit Taking Microfinance Limited',
'Standard Chartered Kenya'=>'Standard Chartered Kenya',
'SUMAC DTM Limited'=>'SUMAC DTM Limited',
'Trans National Bank Kenya'=>'Trans National Bank Kenya',
'U&I Deposit Taking Microfinance Limited'=>'U&I Deposit Taking Microfinance Limited',
'United Bank for Africa'=>'United Bank for Africa',
'UWEZO Deposit Taking Microfinance Limited'=>'UWEZO Deposit Taking Microfinance Limited',
'Victoria Commercial Bank'=>'Victoria Commercial Bank',
'M-Pesa'=>'M-Pesa'
);



     echo form_dropdown('bank_name', $banks,  (isset($result->bank_name)) ? $result->bank_name : ''     ,   ' class="select" data-placeholder="Select Options..." ');
     echo form_error('bank_name'); ?>
</div></div>

<div class='form-group'>
	<div class="col-md-2" for='account_name'>Account Name <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('account_name' ,$result->account_name , 'id="account_name_"  class="form-control" ' );?>
 	<?php echo form_error('account_name'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='account_number'>Account Number <span class='required'>*</span></div><div class="col-md-6">
	<?php echo form_input('account_number' ,$result->account_number , 'id="account_number_"  class="form-control" ' );?>
 	<?php echo form_error('account_number'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='api_username'>API Username </div><div class="col-md-6">
	<?php echo form_input('api_username' ,$result->api_username , 'id="api_username_"  class="form-control" ' );?>
 	<?php echo form_error('api_username'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='api_key'>API Key </div><div class="col-md-6">
	<?php echo form_input('api_key' ,$result->api_key , 'id="api_key_"  class="form-control" ' );?>
 	<?php echo form_error('api_key'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='secret_key'>Secret Key </div><div class="col-md-6">
	<?php echo form_input('secret_key' ,$result->secret_key , 'id="secret_key_"  class="form-control" ' );?>
 	<?php echo form_error('secret_key'); ?>
</div>
</div>

<div class='form-group'>
	<div class="col-md-2" for='branch'>Branch </div><div class="col-md-6">
	<?php echo form_input('branch' ,$result->branch , 'id="branch_"  class="form-control" ' );?>
 	<?php echo form_error('branch'); ?>
</div>
</div>

<div class="widget">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="wysiwyg"  name="description" style="height: 300px;">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
	<?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 

<div class='form-group'><div class="col-md-2"></div><div class="col-md-6">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/bank_accounts','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>