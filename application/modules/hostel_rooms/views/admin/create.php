<div class="col-md-12">
<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Hostel Rooms </h2> 
                     <div class="right">                            
                <?php echo anchor( 'admin/hostel_rooms/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Hostel Rooms')), 'class="btn btn-primary"');?>
			 <a class="btn btn-primary"  href="<?php echo base_url('admin/hostel_rooms'); ?>"><i class="glyphicon glyphicon-list"></i> Hostel Rooms</a>
			
			 <div class="btn-group">
					<button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>
					
					<ul class="dropdown-menu pull-right">
					  <li><a class=""  href="<?php echo base_url('admin/hostel_rooms'); ?>"><i class="glyphicon glyphicon-check"></i> Manage Hostel Rooms</a></li>
					
					  <li><a href="<?php echo base_url('admin/hostel_beds'); ?>"><i class="glyphicon glyphicon-share"></i> Manage Hostel Beds</a></li>
					<li class="divider"></li>
					  <li><a href="<?php echo base_url('admin/hostels'); ?>"><i class="glyphicon glyphicon-home"></i> Back to Hostels</a></li>
					   
					</ul>
				</div>
			
                     </div>    					
                </div>
				
<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
         	                 
               <div class="block-fluid">
			   
			   
			   
			   <!-- END ADVANCED SEARCH EXAMPLE -->
        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
		 <table cellpadding="0" cellspacing="0" width="100%">
		  <!-- BEGIN -->
            <thead>
                <tr role="row">
				
				
				<th width="3%">#</th>
				<th width="20%" >Hostel</th>
				<th width="20%">Room Name </th>
				<th width="57%">Description</th>
				
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
													<td width="20%">
													<?php 		
													 echo form_dropdown('hostel_id[]', $hostel,  (isset($result->hostel_id)) ? $result->hostel_id : ''     ,   ' class=" hostel_id"  id="hostel_id"');
													 echo form_error('hostel_id'); ?>
													</td> 
													
													<td width="20%">
													<input type="text" name="room_name[]" id="room_name" class="room_name" value="<?php 
															if(!empty($result->room_name)){
																	echo $result->room_name;}
															?>">
													
													</td>
													<td width="57%">
													<input type="text" name="description[]" id="description" class="description" value="<?php 
															if(!empty($result->description)){
																	echo $result->description;}
															?>">
													
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

<div class='form-group'><div class="control-div"></div><div class="col-md-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/hostel_rooms','Cancel','class="btn btn-danger"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
 </div>
<script type="text/javascript">

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
       
         newElem.find('.hostel_id').attr('id', 'ID' + newNum + '_hostel_id').val('');

     
		
        newElem.find('.room_name').attr('id', 'ID' + newNum + '_room_name').val('');
		
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
