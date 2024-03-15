
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>Purchase Order</h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/purchase_order/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> New Order ', 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/purchase_order/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
				<?php echo anchor( 'admin/purchase_order/voided' , '<i class="glyphicon glyphicon-list">
                </i> Voided Purchase Orders', 'class="btn btn-warning"');?>
                     </div>    					
                </div>
				 <div class="block-fluid">
<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	 <div class="col-md-2" for='purchase_date'>Purchase Date </div>
	 <div class="col-md-3">
	  <div id="datetimepicker1" class="input-group date form_datetime">
	<input id='purchase_date' type='text' name='purchase_date' maxlength='' class='form-control datepicker' value="<?php echo set_value('purchase_date', (isset($result->purchase_date)) ? $result->purchase_date : ''); ?>"  />
	<span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
 	
</div>
 	<?php echo form_error('purchase_date'); ?>
	
</div>
 <div class="col-md-1" for='due_date'>Due Date </div>
	 <div class="col-md-3">
	  <div id="datetimepicker1" class="input-group date form_datetime">
	<input id='due_date' type='text' name='due_date' maxlength='' class='form-control datepicker' value="<?php echo set_value('due_date', (isset($result->due_date)) ? $result->due_date : ''); ?>"  />
	<span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span>
 	
</div>
 	<?php echo form_error('due_date'); ?>
</div>
</div>

<div class='form-group'>
	 <div class="col-md-2" for='supplier'>Supplier <span class='required'>*</span></div>
	<div class="col-md-4">
    <?php echo form_dropdown('supplier',array(''=>'Select Supplier')+ $address_book,  (isset($result->supplier)) ? $result->supplier : ''     ,   ' class="select" data-placeholder="Select  Options..." ');
                            ?>		
 	<?php echo form_error('supplier'); ?>
</div>
</div>
 <div class="widget">
                <div class="head dark">
                    <div class="icon"><span class="icos-clipboard1"></span></div>
                    <h2>Purchase Details</h2>                    
                </div>                
                <div class="block-fluid">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="3%">
                                   #
                                </th>
								
                                <th width="60%">
                                   Description
                                </th>
								<th width="10%">
                                   Quantity
                                </th>
                                <th width="12%">
                                   Unit Price (Amount)
                                </th>
                              <th width="15%">
                                   Sub Total
                                </th>
                             
                               
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
											
											<td width="60%">
												<input type="text" name="description[]" id="description" class="description">
													
													<?php echo form_error('description'); ?>
											</td>
											<td width="10%">
												<input type="text" name="quantity[]" onblur="totals()" id="quantity" class="quantity">
													
												   <?php echo form_error('quantity'); ?>
											</td>
											<td width="12%">
												<input type="text" name="unit_price[]" onblur="totals()" id="unit_price" class="unit_price">
													
												<?php echo form_error('unit_price'); ?>
											</td>
											<td width="15%" class="sub_total" id="sub_total">  <?php echo number_format(0, 2); ?>   </td>
											
														   
											</tr> 
										
										</tbody>
								</table>
							</div>
							<div class="actions">
								<a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
								<a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
							</div>  
						<div class="left">
							<div class='form-group' style="border:none !important">
							 <textarea name="comment" cols="100" rows="5" class="" placeholder="Comment here..." style="resize:vertical;" id="comment"></textarea>
								<?php echo form_error('comment'); ?>
							</div>
						</div>
						<div class="right">
						<div class='form-group' style="border:none !important">
							 <div class="col-md-3" for='vat'>VAT </div><div class="col-md-9">
							 <input id='vat' type='radio' name='vat' checked="checked" value='1'  class="form-control" <?php echo preset_radio('vat', '1', (isset($result->vat)) ? $result->vat : ''  )?> />	<?php echo form_error('vat'); ?> Yes 
							 <input id='vat' type='radio' name='vat' value='2'  class="form-control" <?php echo preset_radio('vat', '2', (isset($result->vat)) ? $result->vat : ''  )?> />	<?php echo form_error('vat'); ?> No
							
							<?php echo form_error('vat'); ?>
						</div>
						</div>
						<div class='form-group' style="border:none !important">
							 <div class="col-md-3" for='total'>TOTAL  </div><div class="col-md-9">
								
							<?php echo form_input('total' ,$result->total , 'id="total_" readonly class="total" style="border:none !important" ' );?>
							<?php echo form_error('total'); ?>
						</div>
						</div>
						</div>
						
				
<div class='form-group'><label class="control-label"></div><div class="col-md-10">
   <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/purchase_order','Cancel','class="btn btn-default"');?>

</div></div>
 
		</div>   
		
	</div>


<?php echo form_close(); ?>


 

<script>

$(function () {
  $('.unit_price').live('blur',function(){
                        q = $(this).parent().prev().find('input.quantity').val();
                        p = $(this).val();
                        //alert(p);	 alert(q);
						var product = q*p;
						$('td:last', $(this).parents('tr')).html(number_to_currency(product));
						
						
			totals =0;
					$('td.sub_total').each(function()
					{
							amt=parseFloat($(this).text().replace(/,/g ,''));
							totals+=amt;
					});
		         $('input.total').val(totals);
						
                });          
});


  function number_to_currency(num){
                    return parseFloat(num).toFixed(2);
                }


$(function () {
    $('#btnAdd').click(function () {
	
	  //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
        var num     = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // the numeric ID of the new input field being added
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    // manipulate the name/id values of the input inside the new element
        // H2 - section
        newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

        // subject - select
       
         newElem.find('.quantity').attr('id', 'ID' + newNum + '_quantity').val('');

        // start date name - text
       
        newElem.find('.description').attr('id', 'ID' + newNum + '_description').val('');

        // end name - text
       
        newElem.find('.unit_price').attr('id', 'ID' + newNum + '_unit_price').val('');
		  newElem.find('.sub_total').attr('id', 'ID' + newNum + '_sub_total').html(number_to_currency(0));

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
                $('#entry' + num).slideUp('slow', function () {$(this).remove(); 
                // if only one element remains, disable the "remove" button
                    if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
                // enable the "add" button
                $('#btnAdd').attr('disabled', false).prop('value', "add section");});
            }
        return false;
             // remove the last element

    // enable the "add" button
        $('#btnAdd').attr('disabled', false);
    });

    $('#btnDel').attr('disabled', true);

});


</script> 