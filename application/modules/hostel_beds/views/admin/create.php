<div class="col-md-8">
 <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Hostel Beds  </h2> 
                     <div class="right">                            
                <?php echo anchor( 'admin/hostel_beds/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Hostel Bed')), 'class="btn btn-primary"');?>
				 <a class="btn btn-primary" href="<?php echo base_url('admin/hostel_beds'); ?>"><i class="glyphicon glyphicon-list"></i> List All Beds</a>
			
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
         	                      
               <div class="block-fluid">
			 <?php $attributes = array('class' => 'form-horizontal', 'id' => ''); echo   form_open_multipart(current_url(), $attributes); ?>
			   
			   <!-- END ADVANCED SEARCH EXAMPLE -->
        <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
		 <table cellpadding="0" cellspacing="0" width="100%">
		  <!-- BEGIN -->
            <thead>
                <tr role="row">
				
				
				<th width="3%">#</th>
				<th width="50" >Hostel Room</th>
				<th width="50">Bed Number</th>
				
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
													<td width="50">
													
													<?php 	
														 echo form_dropdown('room_id[]', $hostel_rooms,  (isset($result->room_id)) ? $result->room_id : ''     ,   ' class="room_id" id="room_id" data-placeholder="Select Options..." ');
														 echo form_error('room_id'); ?>
													</td> 
													
													<td width="50">
													<input type="text" name="bed_number[]" id="bed_number" class="bed_number" value="<?php 
															if(!empty($result->bed_number)){
																	echo $result->bed_number;}
															?>">
														<?php echo form_error('bed_number'); ?>
													
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
	<?php echo anchor('admin/hostel_beds','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
</div>

  <div class="col-md-4">
	  
	       <div class="widget">
                    <div class="head dark">
                        <div class="icon"></div>
                        <h2>Add Hostel Room</h2>
                    </div>
					
                    <div class="block-fluid">
                       <?php echo form_open('admin/hostel_rooms/quick_add','class=""'); ?>
                        <div class="form-group">
                            <div class="col-md-3">Hostel:<span class='required'>*</span></div>
                            <div class="col-md-9">                                      
                                 <?php echo form_dropdown('hostel_id',$hostel, 'id="hostel_id" ' );?>
 	                           <?php echo form_error('hostel_id'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-3">Room Name:<span class='required'>*</span></div>
                            <div class="col-md-9">                                      
                                 <?php echo form_input('room_name','', 'id="room_name"  placeholder=" e.g Buffalo"' );?>
 	                           <?php echo form_error('room_name'); ?>
                            </div>
                        </div>
                                                    
                        <div class="form-group">
						 <div class="col-md-3">Description:</div>
                            <div class="col-md-9">
                                <textarea name="description"></textarea> 
                            </div>
                        </div>                        
                   
                    <div class="toolbar TAR">
                        <button class="btn btn-primary">Save </button>
                    </div>
					   <?php echo form_close(); ?> 
					   </div>
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
       
         newElem.find('.room_id').attr('id', 'ID' + newNum + '_room_id').val('');

		
        newElem.find('.bed_number').attr('id', 'ID' + newNum + '_bed_number').val('');
		
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