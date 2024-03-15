<?php
$range = range(date('Y') - 5, date('Y') + 2);
$yrs = array_combine($range, $range);
krsort($yrs);
?>
<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Fee Payment  </h2>
        <div class="right"> 
            <?php echo anchor('admin/fee_payment/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/fee_payment', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Payment')), 'class="btn btn-primary"'); ?> 

        </div>
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-2" for='reg_no'>Student Details</div><div class="col-md-6">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo '<b>' . $data[$result->reg_no] . '</b>';
                ?>
                <?php echo form_error('reg_no'); ?>
            </div>
        </div>

        <div class='form-group'style="display:none">
            <div class="col-md-3" for='reg_no'>Student Registration Number <span class='required'>*</span></div><div class="col-md-6">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('reg_no', array('' => 'Select Student') + $data, (isset($result->reg_no)) ? $result->reg_no : '', ' class="select"');
                ?>
                <?php echo form_error('reg_no'); ?>
            </div>
        </div>

        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="10%">Payment Date</th>
                        <th width="10%">Amount</th>
                        <th width="15%">Payment Method</th>
                        <th width="15%">Transaction No.</th>
                        <th width="20%">Bank</th>
                        <th width="47%">Description</th>

                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>
                        <tr>
                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>

                            <td width="10%">
                                <input id='payment_date' type='text' name='payment_date' style="" class='payment_date  payment_date datepicker' value="<?php
                                echo $result->payment_date > 0 ? date('d M Y', $result->payment_date) : $result->payment_date;
                                ?>"  />
                                       <?php echo form_error('payment_date'); ?>
                                <hr>
                                <?php
                                echo form_dropdown('term', array('' => '') + $this->terms, (isset($result->term)) ? $result->term : '', ' class="Qsel" placeholder="Select Term" ');
                                echo form_error('term');
                                ?>
                                <hr><?php
                                echo form_dropdown('year', array('' => '') + $yrs, (isset($result->year) && !empty($result->year)) ? $result->year : date('Y'), ' class="Qsel" placeholder="Select Year" ');
                                echo form_error('year');
                                ?>

                            </td>
                            <td width="10%">

                                <input type="text" name="amount" id="amount" class="amount" value="<?php
                                if (!empty($result->amount))
                                {
                                    echo $result->amount;
                                }
                                ?>">
                                       <?php echo form_error('amount'); ?>
                            </td>
                            <td width="15%">

                                <input type="text" name="payment_method" id="payment_method" class="payment_method" value="<?php
                                if (!empty($result->payment_method))
                                {
                                    echo $result->payment_method;
                                }
                                ?>">
                                       <?php echo form_error('payment_method'); ?>

                            </td>
                            <td width="15%">

                                <input type="text" name="transaction_no" id="transaction_no" class="transaction_no" value="<?php
                                if (!empty($result->transaction_no))
                                {
                                    echo $result->transaction_no;
                                }
                                ?>">
                                       <?php echo form_error('transaction_no'); ?>
                            </td>
                            <td width="20%">
                                <?php
                                echo form_dropdown('bank_id', array('' => 'Select Bank Accout') + $bank, (isset($result->bank_id)) ? $result->bank_id : '', ' class="bank_id" id="bank_id" ');
                                echo form_error('bank_id');
                                ?>
                            </td>
                            <td width="47%">
                                <textarea name="description" cols="25" rows="1" class="col-md-12 description  validate[required]" style="resize:vertical;" id="description"><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class='form-group'>
            <div class="col-md-12">
                <br>
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_payment', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>
<script type="text/javascript">

    $(function () {
        $(".Qsel").select2({'placeholder': 'Select Students', 'width': '100%'});
        $('#btnAdd').click(function ()
        {
            var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                    newNum = new Number(num + 1), // the numeric ID of the new input field being added
                    newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
            // manipulate the name/id values of the input inside the new element
            // H2 - section
            newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

            // subject - select
            newElem.find('.payment_date').attr('id', 'ID' + newNum + '_payment_date').val('').removeClass("hasDatepicker").datepicker({
                format: "dd MM yyyy",
            }).focus();

            newElem.find('.amount').attr('id', 'ID' + newNum + '_amount').val('');

            newElem.find('.payment_method').attr('id', 'ID' + newNum + '_payment_method').val('');
            newElem.find('.transaction_no').attr('id', 'ID' + newNum + '_transaction_no').val('');

            newElem.find('.bank_id').attr('id', 'ID' + newNum + '_bank_id').val('');
            newElem.find('.description').attr('id', 'ID' + newNum + '_description').val('');

            // insert the new element after the last "duplicatable" input field
            $('#entry' + num).after(newElem);

            // enable the "remove" button
            $('#btnDel').attr('disabled', false);

            // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
            if (newNum == 100)
                $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
        });

        $('#btnDel').click(function () {
            // confirmation
            if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
            {
                var num = $('.clonedInput').length;
                // how many "duplicatable" input fields we currently have
                $('#entry' + num).slideUp('slow', function () {
                    $(this).remove();
                    // if only one element remains, disable the "remove" button
                    if (num - 1 === 1)
                        $('#btnDel').attr('disabled', true);
                    // enable the "add" button
                    $('#btnAdd').attr('disabled', false).prop('value', "add section");
                });
            }
            return false;
            // remove the last element

            // enable the "add" button
            $('#btnAdd').attr('disabled', false);
        });

        $('#btnDel').attr('disabled', true);
    });
</script> 
<style>
    hr {
        margin-top: 2px;
        margin-bottom: 2px;
    }
</style>
