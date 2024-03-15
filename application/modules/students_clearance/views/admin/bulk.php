<div class="col-md-12">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Students Clearance  </h2>
             <div class="right"> 
            
				
				<?php echo anchor( 'admin/students_clearance/bulk' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Bulk Clearance')), 'class="btn btn-warning"');?> 
				
				
              <?php echo anchor( 'admin/students_clearance' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Clearance')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
			<div class="block-fluid">

				<?php 
				$attributes = array('class' => 'form-horizontal', 'id' => '');
				echo   form_open_multipart(current_url(), $attributes); 
				?>


        <div class='form-group'>
            <div class="col-md-3" for='student'>Student <span class='required'>*</span></div><div class="col-md-4">
                <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="select"');
                ?>
                <?php echo form_error('student'); ?> 
            </div>
        </div>
		
				<div class='form-group'>
	<div class="col-md-3" for='department'>Student Card Returned<span class='required'>*</span></div>
	<div class="col-md-4">
					<?php $items = array('No' =>'No', 
										"Yes"=>"Yes",
										"No card was given"=>"No card was given",
										);		
		 echo form_dropdown('student_card', $items,  (isset($result->student_card)) ? $result->student_card : '',' class="chzn-select" data-placeholder="Select Options..." ');
		 echo form_error('student_card'); ?>
	</div>
</div>
		
		
		
  <!-- END ADVANCED SEARCH EXAMPLE -->
        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
		 <table cellpadding="0" cellspacing="0" width="100%">
		  <!-- BEGIN -->
            <thead>
                <tr role="row">

				<th width="3%">#</th>
				<th width="20%" >Department</th>
				<th width="10%" >Date</th>
				
				<th width="10%">Clear</th>
				<th width="10%">Charge</th>
				<th width="25%">Comment</th>
				<th width="20%">Confirmed By</th>
				
				</tr>
            </thead>
           </table>
		   
		   <div id="entry1" class="clonedInput">
							
							 <table cellpadding="0" cellspacing="0" width="100%">  
										<tbody>
										
										<?php
										$i=0;
											$items = $this->ion_auth->populate('clearance_departments','id','name');
											foreach($depts as $pp){
												//echo $pp->id;
												$i++;
										 ?>
										
										<tr>
                  
											    <td width="3%">
												  <span id="reference" name="reference" class="heading-reference"><?php echo $i;?></span>
												</td>
												
												   <td width="20%">
										          <input type="text" name="department[]" id="department" class="department" value="<?php echo $items[$pp->id];?>">
													</td>
													
													 <td width="10%">
														<input id='date_<?php echo $pp->id;?>' type='text' name='date[]' style="" class='date   datepicker' />
													</td>
													
												<td width="10%">
													<?php
													$tems = array('Yes'=>'Yes','No'=>'No');
													echo form_dropdown('cleared[]', array('' => 'Select') + $tems,  '', ' class="cleared" id="cleared" ');
													?>
												</td>
												
												<td width="10%">
													<input type="text" name="charge[]" id="charge" class="charge" value="0">
												</td>
												
												<td width="25%">
													<textarea id="description"   style="height: 30px;" class="description"  name="description[]"  /></textarea>
												</td>

												<td width="20%">
													 <?php
													
														echo form_dropdown('confirmed_by[]', array('' => 'Select Staff') + $all_staff, (isset($result->confirmed_by)) ? $result->confirmed_by : '', ' class=" " style=""');
														?>
												</td> 

											</tr>
											
											<?php } ?>
										
										</tbody>
								</table>
							</div>
		   
		   
				<!--
					<div class="actions">
						<a href="#" id="btnAdd" class="btn btn-success clone">Add New Line</a> 
						<a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
					</div>
					-->
		</div>
		
	


<div class='form-group'><div class="col-md-3"></div><div class="col-md-6">
 
    <br>

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save Changes', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/students_clearance','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			
			<script type="text/javascript">
			
			$(function ()
           {
			 <?php foreach($depts as $pp){?>
				$('#date_<?php echo $pp->id?>').change(function ()
				{
				  $('#date_<?php echo $pp->id?>').removeClass("hasDatepicker").datepicker({
                    format: "dd MM yyyy";
					});
				});
			 <?php } ?>
		   });
	
        $(function ()
        {
            var amtts = 0;
            $('#btnAdd').click(function ()
            {
                var num = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
                        newNum = new Number(num + 1), // the numeric ID of the new input field being added
                        newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
                // manipulate the name/id values of the input inside the new element
                // H2 - section
                newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);
                // sum departments
                var val = parseFloat($('#entry' + num).find('.department').val());
                amtts += isNaN(val) ? 0 : val;
                console.log(amtts);
                // subject - select
                newElem.find('.date').attr('id', 'ID' + newNum + '_date').val('').removeClass("hasDatepicker").datepicker({
                    format: "dd MM yyyy",
                }).focus();

                newElem.find('.department').attr('id', 'ID' + newNum + '_department').val('');

                newElem.find('.cleared').attr('id', 'ID' + newNum + '_cleared').val('');
                newElem.find('.charge').attr('id', 'ID' + newNum + '_charge').val('');

               // newElem.find('.bank_id').attr('id', 'ID' + newNum + '_bank_id').val('');
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
                        // sum departments
                        var val = parseFloat($('#entry' + num).find('.department').val());
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
        });

</script>