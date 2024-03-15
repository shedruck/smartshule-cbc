<?php
$banks = array('ABC Bank (Kenya)' => 'ABC Bank (Kenya)',
    'Bank of Africa' => 'Bank of Africa',
    'Bank of Baroda' => 'Bank of Baroda',
    'Bank of India' => 'Bank of India',
    'Barclays Bank' => 'Barclays Bank',
    'Century Deposit Taking Microfinance Limited' => 'Century Deposit Taking Microfinance Limited',
    'CFC Stanbic Bank' => 'CFC Stanbic Bank',
    'Chase Bank (Kenya)' => 'Chase Bank (Kenya)',
    'Citibank' => 'Citibank',
    'Commercial Bank of Africa' => 'Commercial Bank of Africa',
    'Consolidated Bank of Kenya' => 'Consolidated Bank of Kenya',
    'Cooperative Bank of Kenya' => 'Cooperative Bank of Kenya',
    'Credit Bank' => 'Credit Bank',
    'Development Bank of Kenya' => 'Development Bank of Kenya',
    'Diamond Trust Bank' => 'Diamond Trust Bank',
    'Dubai Bank Kenya' => 'Dubai Bank Kenya',
    'Ecobank' => 'Ecobank',
    'Equatorial Commercial Bank' => 'Equatorial Commercial Bank',
    'Equity Bank' => 'Equity Bank',
    'Family Bank' => 'Family Bank',
    'Faulu Kenya DTM Limited' => 'Faulu Kenya DTM Limited',
    'Fidelity Commercial Bank Limited' => 'Fidelity Commercial Bank Limited',
    'Fina Bank' => 'Fina Bank',
    'First Community Bank' => 'First Community Bank',
    'Giro Commercial Bank' => 'Giro Commercial Bank',
    'Guardian Bank' => 'Guardian Bank',
    'Gulf African Bank' => 'Gulf African Bank',
    'Habib Bank AG Zurich' => 'Habib Bank AG Zurich',
    'Habib Bank' => 'Habib Bank',
    'Housing Finance Company of Kenya' => 'Housing Finance Company of Kenya',
    'I&M Bank' => 'I&M Bank',
    'Imperial Bank Kenya' => 'Imperial Bank Kenya',
    'Jamii Bora Bank' => 'Jamii Bora Bank',
    'Kenya Commercial Bank' => 'Kenya Commercial Bank',
    'Kenya Women Finance Trust DTM Limited' => 'Kenya Women Finance Trust DTM Limited',
    'K-Rep Bank' => 'K-Rep Bank',
    'Middle East Bank Kenya' => 'Middle East Bank Kenya',
    'National Bank of Kenya' => 'National Bank of Kenya',
    'NIC Bank' => 'NIC Bank',
    'Oriental Commercial Bank' => 'Oriental Commercial Bank',
    'Paramount Universal Bank' => 'Paramount Universal Bank',
    'Prime Bank (Kenya)' => 'Prime Bank (Kenya)',
    'Rafiki Deposit Taking Microfinance' => 'Rafiki Deposit Taking Microfinance',
    'Remu DTM Limited' => 'Remu DTM Limited',
    'SMEP Deposit Taking Microfinance Limited' => 'SMEP Deposit Taking Microfinance Limited',
    'Standard Chartered Kenya' => 'Standard Chartered Kenya',
    'SUMAC DTM Limited' => 'SUMAC DTM Limited',
    'Trans National Bank Kenya' => 'Trans National Bank Kenya',
    'U&I Deposit Taking Microfinance Limited' => 'U&I Deposit Taking Microfinance Limited',
    'United Bank for Africa' => 'United Bank for Africa',
    'UWEZO Deposit Taking Microfinance Limited' => 'UWEZO Deposit Taking Microfinance Limited',
    'Victoria Commercial Bank' => 'Victoria Commercial Bank',
);
?>
<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Salaries  </h2>
        <div class="right">  
            <?php echo anchor('admin/salaries/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Employee to Salary')), 'class="btn btn-primary"'); ?>
            <?php echo anchor('admin/salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Salaried Employees')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='employee'>Employee <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $staff = $this->ion_auth->list_staff();
                echo form_dropdown('employee', array('' => 'Select Employee') + $staff, (isset($result->employee)) ? $result->employee : '', ' class="select " ');
                echo form_error('employee');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='salary_method'>Salary Method <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $items = array(
                    "Monthly" => "Monthly",
                    "Daily" => "Daily",
                    "Weekly" => "Weekly",
                );
                echo form_dropdown('salary_method', $items, (isset($result->salary_method)) ? $result->salary_method : '', ' class="select" data-placeholder="Select Options..." ');
                echo form_error('salary_method');
                ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='basic_salary'>Basic Salary <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('basic_salary', $result->basic_salary, 'id="basic_salary_"  class="form-control" '); ?>
                <?php echo form_error('basic_salary'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">NHIF Amount <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('nhif', $result->nhif, 'id="nhif_"  class="form-control" '); ?>
                <?php echo form_error('nhif'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">NSSF Amount <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('nssf', $result->nssf, 'id="nssf_"  class="form-control" '); ?>
                <?php echo form_error('nssf'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class='col-md-3'>Deductions  </div>
            <div class="col-md-6">
                <?php echo form_dropdown('deductions[]', $deductions, '', ' multiple="multiple" class="select "'); ?>
            </div>
        </div> 
        <div class='form-group'>
            <div class='col-md-3'>Allowances  </div>
            <div class="col-md-6">
                <?php echo form_dropdown('allowances[]', $allowances, '', ' multiple="multiple" class="select "'); ?>
            </div>
        </div> 
        <div class='form-group'>
            <div class="col-md-3" for='basic_salary'>Staff With Student Deduction </div><div class="col-md-6">
                <?php echo form_input('staff_deduction', $result->staff_deduction, 'id="nhif_"  class="form-control" '); ?>
                <?php echo form_error('staff_deduction'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3">Bank Name </div>
            <div class="col-md-6">
                <?php echo form_dropdown('bank_name', array('' => 'Select Bank') + $banks, $result->bank_name, ' class="select "'); ?>
                <?php echo form_error('bank_name'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='bank_account_no'>Bank Account No </div>
            <div class="col-md-6">
                <?php echo form_input('bank_account_no', $result->bank_account_no, 'id="bank_account_no_"  class="form-control" '); ?>
                <?php echo form_error('bank_account_no'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='nhif_no'>NHIF Number </div>
            <div class="col-md-6">
                <?php echo form_input('nhif_no', $result->nhif_no, 'id="nhif_no_"  class="form-control" '); ?>
                <?php echo form_error('nhif_no'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='nssf_no'>NSSF Number </div><div class="col-md-6">
                <?php echo form_input('nssf_no', $result->nssf_no, 'id="nssf_no_"  class="form-control" '); ?>
                <?php echo form_error('nssf_no'); ?>
            </div>
        </div>
        <div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/salaries', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-4">
    <?php if ($post): ?>
            <div class="head"> 
                <div class="icon"><span class="icosg-target1"></span></div>		
                <h2>  Salaried Employees </h2>
            </div>
            <div class="slip">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr class="">
                            <th><div class="checker"><span class=""><input type="checkbox" class="checkall"></span></div></th>
                    <th width="50%">Employee</th>
                    <th width="35%">Basic Salary</th>
                    <th width="15%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($post as $p): $u = $this->ion_auth->get_user($p->employee); ?>
                                <tr>
                                    <td><div class="checker"><span class=""><input type="checkbox" name="ch[]"></span></div></td>
                                    <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                    <td><a href="#"><?php echo number_format($p->basic_salary, 2); ?></a></td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?php echo site_url('admin/salaries/edit/' . $p->id . '/' . $page); ?>" class="tip" title="" data-original-title="Edit"><span class="glyphicon glyphicon-pencil"></span></a> 
                                            <a onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/salaries/delete/' . $p->id . '/' . $page); ?>' class="remove tip" title="" data-original-title="Remove"><span class="glyphicon glyphicon-remove"></span></a>
                                        </div>
                                    </td>
                                </tr>
                        <?php endforeach; ?>                                                         
                    </tbody>
                </table>
            </div>   
    <?php endif; ?>
</div>