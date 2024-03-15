<?php
$range = range(date('Y') - 5, date('Y') + 2);
$yrs = array_combine($range, $range);
krsort($yrs);

 $settings = $this->ion_auth->settings();
?>
<div class="col-md-12">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2> Fee Payment </h2>
        <div class="right"> 
            <?php echo anchor('admin/fee_payment', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block-fluid">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'fpaym');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class='form-group'>
            <div class="col-md-3" for='reg_no'>Student <span class='required'>*</span></div>
            <div class="col-md-4">  
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('reg_no', array('' => 'Select Student') + $data, (isset($result->reg_no)) ? $result->reg_no : '', ' class="select reg_no" id="reg_no"');
                echo form_error('reg_no');
                ?>
            </div>
            <div class="col-md-3">
                <?php
				
                echo form_dropdown('term', array($settings->term => 'Term '. $settings->term) + $this->terms, (isset($result->term)) ? $result->term : '', ' class="tsel" placeholder="Select Term" ');
                echo form_error('term');
                ?>
            </div>
            <div class="col-md-2">
                <?php
                echo form_dropdown('year', array('' => '') + $yrs, (isset($result->year) && !empty($result->year)) ? $result->year : date('Y'), ' class="tsel" placeholder="Select Year" ');
                echo form_error('year');
                ?>
                <span class="pull-right">Receipt #: <?php echo number_format($next); ?></span>
            </div>
        </div>

        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
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
                <?php echo validation_errors(); ?>
                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>
                        <tr>
                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>
                            <td width="10%">
                                <input id='payment_date' type='text' name='payment_date[]' style="" class='payment_date   datepicker' value="<?php
                                if (!empty($result->payment_date))
                                {
                                    echo date('d/m/Y', $result->payment_date);
                                }
                                else
                                {
                                    echo set_value('payment_date', (isset($result->payment_date)) ? $result->payment_date : '');
                                }
                                ?>"  />
                            </td>
                            <td width="10%">
                                <input type="text" name="amount[]" id="amount" class="amount" value="<?php
                                if (!empty($result->amount))
                                {
                                    echo $result->amount;
                                }
                                ?>" class="amount"> 
                            </td>
                            <td width="15%">
                                <?php
                                $items = array('Bank Slip' => 'Bank Slip', 'Cash' => 'Cash', 'Mpesa' => 'Mpesa', 'Cheque' => 'Cheque', 'Paybill' => 'Paybill');
                                echo form_dropdown('payment_method[]', array('' => 'Select Pay Method') + $items, (isset($result->payment_method)) ? $result->payment_method : '', ' class="payment_method" id="payment_method" data-placeholder="Select Options..." ');
                                ?>
                            </td>
                            <td width="15%">

                                <input type="text" name="transaction_no[]" id="transaction_no" class="validate[required,ajax[ajaxTransactionCallPhp]] transaction_no" value="<?php
                                if (!empty($result->transaction_no))
                                {
                                        echo $result->transaction_no;
                                }
                                ?>">
                                       <?php echo form_error('transaction_no'); ?>
                            </td>
                            <td width="20%">
                                <?php
                                echo form_dropdown('bank_id[]', array('' => 'Select Bank Account') + $bank, (isset($result->bank_id)) ? $result->bank_id : '', ' class="bank_id" id="bank_id" ');
                                ?>
                            </td>
                            <td width="47%">
                                <?php
                                echo form_dropdown('description[]', array('' => 'Select option', '0' => 'Tuition Fee Payment') + $extras, (isset($result->description)) ? $result->description : '', ' class="description validate[required]" id="description" ');
                                ?>
                            </td> 
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="actions">
                <a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
                <a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
            </div>
        </div>

        <div class='form-group'><div class="col-md-2"></div><div class="col-md-10">
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Process Payment', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_payment', 'Cancel', 'class="btn  btn-default"'); ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
		<div class="col-md-6">
		</div>
		
		<div class="col-md-6">
		<center>
		   <h4 ><b>CURRENT FEE BALANCE: <span id="bals"></span></b> </h4>
		   <h4 ><b>NEW FEE BALANCE: <span id="new_bals"></span></b> </h4>
		</center>   
		   
		   <table class="table bordered" id="invoices">
	
			  <!--- LIST STUDENT INVOICES -->
			</table>
			
			
		</div>
    </div>
	
	
	
</div>
<script type="text/javascript">
    $(function ()
    {
        var amtts = 0;
        $('#btnAdd').click(function ()
        {
            var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                    newNum = new Number(num + 1), // the numeric ID of the new input field being added
                    newElem = $('#entry' + num).clone(true, true).attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
            // manipulate the name/id values of the input inside the new element
            // H2 - section
            newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);
            // sum amounts
            var val = parseFloat($('#entry' + num).find('.amount').val());
            amtts += isNaN(val) ? 0 : val;
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
                    // sum amounts
                    var val = parseFloat($('#entry' + num).find('.amount').val());
                    amtts -= isNaN(val) ? 0 : val;
                    console.log(amtts);
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

        $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
    });

</script>


<script>
    jQuery(function () {

        jQuery("#reg_no").change(function () {
           
        jQuery('#invoices').empty();
        jQuery('#bals').empty();
            var reg_no = jQuery(".reg_no").val();
            // alert(data);
            var options = '';
            var th = '<tr><th>#</th><th><b>THIS TERM INVOICES </b></th><th><b>AMOUNT</b></th>zzz</tr>';
           

            jQuery.getJSON("<?php echo base_url('admin/fee_payment/list_invoices'); ?>", {id: jQuery(this).val()}, function (data) {

        var j=0;
                for (var i = 0; i < data.length; i++) {
					j+=1
                    options += '<tr><td>'+ j +'</td><td>'+data[i].optionValue + '</td><td>' + data[i].optionDisplay +'</td></tr>';
					
                }

                jQuery('#invoices').append(th+options);

            });

            var bal='';
			jQuery.getJSON("<?php echo base_url('admin/fee_payment/f_bal'); ?>", {id: jQuery(this).val()}, function (data) {
				bal = data[0].optionDisplay;
				
                jQuery('#bals').append(bal);

            });

            
            //
        });

        jQuery(".amount").on('keyup',function () {
            
          var amount=  $(this).closest('table').find(".amount").val();
         
             var balance;
            var bal;
            var new_bal;
           
            jQuery.getJSON("<?php echo base_url('admin/fee_payment/f_bal'); ?>", {id: jQuery(this).val()}, function (data) {
				bal = data[0].optionDisplay;
            });

            balance= $("#bals").text();
            bal=balance.replace(",", "")
            new_bal=Number(bal)-Number(amount);
            jQuery('#new_bals').html(new_bal);


        });

        
    });

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
</script>




<script>
        $(document).ready(function () {
            $("#fpaym").validationEngine('attach', {promptPosition: "topLeft"});
        });
</script>