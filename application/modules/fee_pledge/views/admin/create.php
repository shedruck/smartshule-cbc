<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Fee Pledge  </h2>
        <div class="right"> 
            <?php echo anchor('admin/fee_pledge/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Fee Pledge')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/fee_pledge', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Pledge')), 'class="btn btn-primary"'); ?> 

        </div>
    </div>


    <div class="block-fluid">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
                <?php
                $student = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $student, (isset($result->student)) ? $result->student : '', ' class="select" ');
                ?>	
                <?php echo form_error('student'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='pledge_date'>Pledge Date </div><div class="col-md-6">
                <div id="datetimepicker1" class="input-group date form_datetime">
                    <?php echo form_input('pledge_date', $result->pledge_date > 0 ? date('d M Y', $result->pledge_date) : $result->pledge_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
                    <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>

                </div>
                <?php echo form_error('pledge_date'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='amount'>Amount <span class='required'>*</span></div><div class="col-md-6">
                <?php echo form_input('amount', $result->amount, 'id="amount_"  class="form-control" '); ?>
                <?php echo form_error('amount'); ?>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-3" for='status'>Status </div><div class="col-md-6">
                <?php
                $status = array(
                    'pending' => 'Pending',
                    'paid' => 'Paid'
                );
                echo form_dropdown('status', $status, (isset($result->status)) ? $result->status : '', ' class="select" ');
                ?>
<?php echo form_error('status'); ?>
            </div>
        </div>

        <div class='widget'>
            <div class='head dark'>
                <div class='icon'><i class='icos-pencil'></i></div>
                <h2>Remark </h2></div>
            <div class="block-fluid editor">
                <textarea id="remark"   style="height: 300px;" class=" wysiwyg "  name="remark"  /><?php echo set_value('remark', (isset($result->remark)) ? htmlspecialchars_decode($result->remark) : ''); ?></textarea>
<?php echo form_error('remark'); ?>
            </div>
        </div>

        <div class='form-group'><div class="col-md-3"></div><div class="col-md-6">


                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
<?php echo anchor('admin/fee_pledge', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

<?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>