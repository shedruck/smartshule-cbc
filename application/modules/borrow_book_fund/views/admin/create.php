<div class="col-md-9">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Give out  Book Fund  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/borrow_book_fund/create' , '<i class="glyphicon glyphicon-plus">
                </i> Give out  Book Fund', 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/borrow_book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Borrowed Books')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
				   <div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
	<div class="col-md-3" for='borrow_date'>Borrow Date <span class='required'>*</span></div><div class="col-md-6">
	<div id="datetimepicker1" class="input-group date form_datetime">
	 <?php echo form_input('borrow_date', $result->borrow_date > 0 ? date('d M Y', $result->borrow_date) : $result->borrow_date, 'class="validate[required] form-control datepicker col-md-4"'); ?>
	<span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
	</div>
 	<?php echo form_error('borrow_date'); ?>
</div>
</div>
<div class='form-group'>
	<div class="col-md-3" for='student'>Student </div><div class="col-md-6">
	   <?php
                $data = $this->ion_auth->students_full_details();
                echo form_dropdown('student', array('' => 'Select Student') + $data, (isset($result->student)) ? $result->student : '', ' class="select" data-placeholder="Select Options..." ');
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
                        <th width="45%">Book</th>
                        <th width="52%">Remarks</th>
                    </tr>
                </thead>
            </table>

            <div id="entry1" class="clonedInput">

                <table cellpadding="0" cellspacing="0" width="100%">  
                    <tbody>

                        <tr >

                            <td width="3%">
                                <span id="reference" name="reference" class="heading-reference">1</span>
                            </td>

                            <td width="40%">

                               <?php
                               echo form_dropdown('book[]', $books, (isset($result->book)) ? $result->book : '', ' class="book " id="book" data-placeholder="Select Options..." ');
                                ?>
                                       <?php echo form_error('book'); ?>
                            </td>
                       
                            <td width="57%">
                                <textarea name="remarks[]" cols="25" rows="1" class="col-md-12 remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
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
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/borrow_book_fund','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
			
			
			<div class="col-md-3">

     <div class="widget">
          <div class="head dark">
               <div class="icon"><span class="icosg-newtab"></span></div>
               <h2>Give out books per class</h2>
          </div>

          <div class="block-fluid">
		
               <ul class="list tickets">
                    <?php
                    $i = 0;
                    foreach ($this->classlist as $cid => $cl)
                    {
                         $i++;
                         $cc = (object) $cl;
                         $cll =  $cid ;
                         ?> 
                         <li class = "<?php echo $cll; ?> clearfix" >
                              <div class = ""> 
							  <a href ="<?php echo base_url('admin/borrow_book_fund/per_class/'.$cid); ?>">
							 
								   <span class="glyphicon glyphicon-share"></span> <?php echo $cc->name; ?> 
								  <span style="background:#B1B1B1;float:right; color:#fff; padding:5px;"><b> <?php echo $cc->size; ?> Students</b> </span>
								  
								  </a>
								 
                                 
                              </div>
                         </li>
                    <?php } ?>
               </ul>
          </div>
     </div>


</div>
			

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

            newElem.find('.book').attr('id', 'ID' + newNum + '_book').val('');

            newElem.find('.remarks').attr('id', 'ID' + newNum + '_remarks').val('');

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