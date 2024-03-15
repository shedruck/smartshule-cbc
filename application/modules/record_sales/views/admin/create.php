<div class="col-md-12">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Record Sales  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/record_sales/create' , '<i class="glyphicon glyphicon-plus">
                </i> Record Sales', 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/record_sales' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Record Sales')), 'class="btn btn-primary"');?> 
             <?php echo anchor( 'admin/record_sales/voided' , '<i class="glyphicon glyphicon-list">
                </i> All Voided Sales', 'class="btn btn-warning"');?> 
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='sales_date'>Sales Date <span class='required'>*</span></div><div class="col-md-4">
	<div id="datetimepicker1" class="input-group date form_datetime">
	<?php echo form_input('sales_date', $result->sales_date > 0 ? date('d M Y', $result->sales_date) : $result->sales_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	
	 <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
 	<?php echo form_error('sales_date'); ?>
</div>
</div>

        <div class='form-group'>
            <div class="col-md-3" for='student'>Student Being Bought for <span class='required'>*</span></div><div class="col-md-6">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="select"');
                ?>
                <?php echo form_error('student'); ?>
            </div>
        </div>


        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <table cellpadding="0" cellspacing="0" width="100%">
                <!-- BEGIN -->
                <thead>
                    <tr role="row">
                        <th width="3%">#</th>
                        <th width="15%">Item</th>
                        <th width="15%">Quantity</th>
                        <th width="15%">Unit Price</th>
                        <th width="15%">Total</th>
                        <th width="15%">Method</th>
                        <th width="35%">Description</th>

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

                          
                           
                            <td width="15%">
                                <?php
                                
                                echo form_dropdown('item_id[]', $items, (isset($result->item_id)) ? $result->item_id : '', ' class="item_id" id="item_id" data-placeholder="Select Options..." ');
                                echo form_error('item_id');
                                ?>
                            </td>
							
							 <td width="15%">

                                <input type="text" name="quantity[]" id="quantity" class="quantity" value="<?php
                                if (!empty($result->quantity))
                                {
                                    echo $result->quantity;
                                }
                                ?>">
                                       <?php echo form_error('quantity'); ?>
                            </td>
							
                            <td width="15%">

                                <input type="text" name="unit_price[]" id="unit_price" class="unit_price" value="<?php
                                if (!empty($result->unit_price))
                                {
                                    echo $result->unit_price;
                                }
                                ?>">
                                       <?php echo form_error('unit_price'); ?>
                            </td>
							
							<td width="15%">

                                <input type="text" name="total[]" id="total" class="total" value="<?php
                                if (!empty($result->total))
                                {
                                    echo $result->total;
                                }
                                ?>">
                                       <?php echo form_error('total'); ?>
                            </td>
							
							 <td width="15%">
                                <?php
                                $items = array('Bank Slip' => 'Bank Slip', 'Cash' => 'Cash', 'Mpesa' => 'Mpesa', 'Cheque' => 'Cheque', 'Paybill' => 'Paybill');
                                echo form_dropdown('payment_method[]', array('' => 'Select Pay Method') + $items, (isset($result->payment_method)) ? $result->payment_method : '', ' class="payment_method" id="payment_method" data-placeholder="Select Options..." ');
                                ?>
                            </td>
                          
                            <td width="35%">
                                <textarea name="description[]" cols="25" rows="1" class="col-md-12 description  validate[required]" style="resize:vertical;" id="description"><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
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
                <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
                <?php echo anchor('admin/fee_payment', 'Cancel', 'class="btn  btn-default"'); ?>
            </div></div>

        <?php echo form_close(); ?>
        <div class="clearfix"></div>
    </div>
</div>

<script>

    $(function() {
        $('.unit_price').on('blur', function()
        {
            var total = 0;
			var units =$(this).closest('tr').find("input[class='unit_price']").val();
            $(this).closest('tr').find("input[class='quantity']").each(function()
            {
                total =parseFloat(units) * parseFloat($(this).val());
                $(this).closest('tr').find("input[class='total']").val(total);
            });

        });
    });

</script>

<script type="text/javascript">
     $(function() {
        $('#btnAdd').click(function() {

            //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
            var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                    newNum = new Number(num + 1), // the numeric ID of the new input field being added
                    newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
            // manipulate the name/id values of the input inside the new element
            // H2 - section
            newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

          

            newElem.find('.quantity').attr('id', 'ID' + newNum + '_quantity').val('');

            newElem.find('.item_id').attr('id', 'ID' + newNum + '_item_id').val('');
            newElem.find('.unit_price').attr('id', 'ID' + newNum + '_unit_price').val('');

            newElem.find('.total').attr('id', 'ID' + newNum + '_total').val('');
            newElem.find('.description').attr('id', 'ID' + newNum + '_description').val('');

            // insert the new element after the last "duplicatable" input field
            $('#entry' + num).after(newElem);



            // enable the "remove" button
            $('#btnDel').attr('disabled', false);

            // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
            if (newNum == 100)
                $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
        });

        $('#btnDel').click(function() {
            // confirmation
            if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
            {
                var num = $('.clonedInput').length;
                // how many "duplicatable" input fields we currently have
                $('#entry' + num).slideUp('slow', function() {
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

















