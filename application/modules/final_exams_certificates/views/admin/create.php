<div class="col-md-12">
        <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Final Exams Certificates  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/final_exams_certificates/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Final Exams Certificates')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/final_exams_certificates' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Final Exams Certificates')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
               
<div class="block-fluid">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>


<div class='col-md-6'>
			<div class='form-group'>
				<div class="col-md-4" for='student'>Student <span class='required'>*</span></div><div class="col-md-6">
				 <?php
						$student=$this->ion_auth->students_full_details();
						echo form_dropdown('student',array(''=>'Select Student')+ $student, (isset($result->student)) ? $result->student : '', ' class="select" style="width:350px !important"');
						?>	
				<?php echo form_error('student'); ?>
				
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-4" for='certificate_type'>Certificate Type <span class='required'>*</span></div><div class="col-md-8">
				<?php 
				 $items = array('KCSE'=>'KCSE','KCPE'=>'KCPE','MOCK'=>'MOCK');
				 echo form_dropdown('certificate_type',array(''=>'Select Option')+ $items, (isset($result->certificate_type)) ? $result->certificate_type : '', ' class="" ');
				?>
				<?php echo form_error('certificate_type'); ?>
			</div>
			</div>

			<div class='form-group'>
				<div class="col-md-4" for='serial_number'>Serial Number <span class='required'>*</span></div><div class="col-md-8">
				<?php echo form_input('serial_number' ,$result->serial_number , 'id="serial_number_"  class="form-control" ' );?>
				<?php echo form_error('serial_number'); ?>
			</div>
			</div>
</div>
<div class='col-md-6'>

		<div class='form-group'>
			<div class="col-md-4" for='mean_grade'>Mean Grade <span class='required'>*</span></div><div class="col-md-8">
			<?php echo form_input('mean_grade' ,$result->mean_grade , 'id="mean_grade_"  class="form-control" ' );?>
			<?php echo form_error('mean_grade'); ?>
		</div>
		</div>

		<div class='form-group'>
			<div class="col-md-4" for='points'>Points </div><div class="col-md-8">
			<?php echo form_input('points' ,$result->points , 'id="points_"  class="form-control" ' );?>
			<?php echo form_error('points'); ?>
		</div>
		</div>

		<div class='form-group'>
			<div class="col-md-4" for='certificate'><?php echo lang( ($updType == 'edit')  ? "web_file_edit" : "web_file_create" )?> (certificate) <span class='required'>*</span></div>
		 <div class="col-md-8">
			<input id='certificate' type='file' name='certificate' required="required"/>

			<?php if ($updType == 'edit'): ?>
			<a href='<?php echo base_url();?>uploads/final_exams_certificates/<?php echo $result->certificate?>' />Download actual file (certificate)</a>
			<?php endif ?>

			<br/><?php echo form_error('certificate'); ?>
			<?php  echo ( isset($upload_error['certificate'])) ?  $upload_error['certificate']  : ""; ?>
		</div>
		</div><br>
</div>

<div class="clearfix"></div>

<div class="col-md-2"></div>
<div class="col-md-8">

	   <!-- BEGIN TABLE DATA -->
        <div id="editable_wrapper" class="dataTables_wrapper form-inline" role="grid">
		 <table cellpadding="0" cellspacing="0" width="100%">
		  <!-- BEGIN -->
            <thead>
                <tr role="row">
				
				
				<th width="3%">#</th>
				<th width="47%" >Subject Name</th>
				<th width="50%">Grade</th>
				
				</tr>
            </thead>
           </table>
		   
		   <div id="entry1" class="clonedInput">
							
							 <table cellpadding="0" cellspacing="0" width="100%">  
										<tbody>
									
										<?php $i=0; foreach($subjects as $s){ $i++;?>
										
										<tr>
                  
												 <td width="3%">
												  <span id="reference" name="reference" class="heading-reference"><?php echo $i?></span>
												</td>
												<td width="47%">
												<input type="text" name="subject[]" id="subject" class="subject" value="<?php echo $s->name?>">
												
												</td> 
												
												<td width="50%">
												<input type="text" name="grade[]" id="grade" class="grade" >
													
												</td>
										
												
											</tr>
										<?php } ?>
										</tbody>
								</table>
							</div>
		   
		   
				
					
		</div>

		
</div>
<div class="col-md-2"></div>

<div class="clearfix"></div>
<hr>
<div class="clearfix"></div>
<div class='form-group'><div class="col-md-4"></div><div class="col-md-8">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save Changes', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
	<?php echo anchor('admin/final_exams_certificates','Cancel','class="btn  btn-default"');?>
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
       
         newElem.find('.subject').attr('id', 'ID' + newNum + '_subject').val('');

		
        newElem.find('.grade').attr('id', 'ID' + newNum + '_grade').val('');
		
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