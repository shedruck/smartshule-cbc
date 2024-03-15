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
            <?php echo anchor('admin/salaries/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Salaries')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Salaries')), 'class="btn btn-primary"'); ?> 
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
            </div></div>
        <div class='form-group'>
            <div class="col-md-3" for='salary_method'>Salary Method <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php
                $items = array(
                    "Monthly" => "Monthly",
                    "Daily" => "Daily",
                    "Weekly" => "Weekly",
                );
                echo form_dropdown('salary_method', $items, (isset($result->salary_method)) ? $result->salary_method : '', ' class="chzn-select" data-placeholder="Select Options..." ');
                echo form_error('salary_method');
                ?>
            </div></div>
        <div class='form-group'>
            <div class="col-md-3" for='basic_salary'>Basic Salary <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('basic_salary', $result->basic_salary, 'id="basic_salary_"  class="form-control" '); ?>
                <?php echo form_error('basic_salary'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='basic_salary'>NHIF Amount <span class='required'>*</span></div>
            <div class="col-md-6">
                <?php echo form_input('nhif', $result->nhif, 'id="nhif"  class="form-control" placeholder="E.g 0" '); ?>
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
            <div class='col-md-3' for='groups'>Deductions  </div>
            <div class="col-md-6">
                <?php
                $deds = $this->salaries_m->get_emp_deductions($result->id);
                $dlist = array();
                foreach ($deds as $d)
                {
                        $dlist[] = $d->deduction_id;
                }
                echo form_dropdown('deductions[]', $deductions, $dlist, ' multiple="multiple" class="select"');
                ?>
            </div>
        </div> 
        <div class='form-group'>
            <div class='col-md-3' for='groups'>Allowances  </div>
            <div class="col-md-6">
                <?php
                $alls = $this->salaries_m->get_emp_allowances($result->id);
                $alist = array();
                foreach ($alls as $a)
                {
                        $alist[] = $a->allowance_id;
                }
                echo form_dropdown('allowances[]', $allowances, $alist, ' multiple="multiple" class="select "');
                ?>
            </div>
        </div> 
        <div class='form-group'>
            <div class="col-md-3" for='basic_salary'>Staff With Student Deduction </div><div class="col-md-6">
                <?php echo form_input('staff_deduction', $result->staff_deduction, 'id="nhif_"  class="form-control" '); ?>
                <?php echo form_error('staff_deduction'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='bank_name'>Bank Name </div><div class="col-md-6">
                <?php echo form_dropdown('bank_name', $banks, $result->bank_name, ' class="select "'); ?>
                <?php echo form_error('bank_name'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='bank_account_no'>Bank Account No </div>
            <div class="col-md-6">
                <?php echo form_input('bank_account_no', $result->bank_name, 'id="bank_name"  class="form-control" '); ?>
                <?php echo form_error('bank_account_no'); ?>
            </div>
        </div>
        <div class='form-group'>
            <div class="col-md-3" for='nhif_no'>NHIF Number </div><div class="col-md-6">
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