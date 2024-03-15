<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
				 <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-9">		
								<h4 class="m-b-10">  
								 Multiple Choices - Question
								 </h4>
							</div>
             <div class="col-md-3">
                                <div class="pull-right">
								 <a class="btn btn-success btn-sm " href='<?php echo site_url('mc/trs/view_mc/'.$post.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-share'></i> View Details</a>
								 <?php echo anchor( 'mc/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-primary btn-sm "');?>
                 <a class="btn btn-sm btn-danger" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
           
				
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
     
<div class="block-fluid">
 <div class=' row'>
<div class="col-sm-6">

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>



	<div class='form-group'>
		<h5 class="col-md-12 bg-black text-center pad10" for='topic'>TYPE OR COPY AND PASTE YOUR QUESTION HERE BELOW </h5>
		<div class="col-md-12">
		 <textarea id="question"   style="height: 120px;" class=" summernote "  name="question"  /><?php echo isset($result->question) ? htmlspecialchars_decode($result->question) : ''; ?></textarea>
		<?php echo form_error('question'); ?>
		</div>
	</div>


     <!------------ START FILE UPLOAD -------------->

		<h5 class="col-md-12 bg-black text-center pad10" for='topic'>TYPE OR COPY AND PASTE YOUR CHOICES HERE BELOW  </h5>

 <div class='form-group '>
	
				  <div id="editable_wrapper" class="dataTables_wrapper form-inline " role="grid">

				<div id="entry1" class="clonedInput">
											
				<table class="table table-hover table-bordered "> 
					    <tbody>
										
							 <tr>
				  
								<td width="8%">
								  <span id="reference" name="reference" class="heading-reference">1</span>
								</td>
								
								<td width="70%">
								 <textarea id="choice" placeholder=" Type or copy & paste choice (Required)" rows="1" cols="45"  class="form-control slim choice"   name="choice[]"  /></textarea>
								
								</td>
								
								<td width="22%">
								  	<?php 

									 $items = array(  '0'=>'Wrong','1'=>'Correct');
								echo form_dropdown('state[]', $items,'', ' class=" form-control state" id="state"');
								?>
																		
								
								
								</td> 	
							 </tr>
										
						</tbody>
					</table>
				</div>
						   
					<br>	   
								
					<div class="actions">
						<a href="#" id="btnAdd" class="btn btn-success clone">Add Choice</a> 
						<a href="#" id="btnDel" class="btn btn-danger remove">Remove</a>
					</div>
				</div>
			</div>


<hr>

<div class='form-group row'><div class="col-md-2"></div><div class="col-md-8">
    

    <?php echo form_submit( 'submit', 'Save and Add' ,"id='submit' class='btn btn-sm btn-primary'"); ?>
	<?php echo form_submit( 'submit', 'Save and Review' ,"id='submit' class='btn btn-sm btn-success'"); ?>
    <?php echo form_submit( 'submit', 'Save and Exit' ,"id='submit' class='btn btn-sm btn-danger'"); ?>
	
</div>

</div>
 
<?php echo form_close(); ?>

 </div>
 
  <div class="col-md-6">
			 <h5 class=" text-center bg-blue pad10" > POSTED QUESTIONS  </h5>
			 
			  <?php $i=0; if($questions){ ?>
					
					  <table id="datatable-buttons" class="table table-striped table-bordered">
						<thead>
						<th>#</th>
					
						<th>Question</th>
						<th>Action</th>
						</thead>
			
					   <?php foreach($questions as $p){ $i++; ?>
					   
					   <tbody>
						   <tr>
								<td>
								<?php echo $i?>.
								</td>
								<td>
							  <?php $cc = count_chars($p->question); echo strip_tags(substr($p->question,0,250),'<p><img><br>'); if($cc < 250) echo '...';?>
							  </td>
							  <td width="">
							  <div class="btn-group pull-right" >
								  <a class="btn btn-primary btn-sm" href='<?php echo site_url('mc/trs/mc_edit_question/'.$post.'/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
						  
								 <!-- <a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('mc/trs/delete_question/'.$post->id.'/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-times'></i> Trash</a>-->
							  </div>
							  </td>
						  </tr>
						  </tbody>
					   <?php  } ?>
					 </table>
					  <?php }else{?>
					     No question has been added
					  <?php } ?>
			 
			 </div>
			
			
         </div>
        </div>
       </div>
      </div>
    </div>
 </div>
        
			
			
	<script type="text/javascript">

$(function () {
    $('#btnAdd').click(function () {
	
	 $('html, body').animate({scrollTop:$(document).height()}, 'slow');
	  //$('input.timepicker').eq(0).clone().removeClass("hasTimepicker").prependTo('#entry2');
        var num     = $('.clonedInput').length, // how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // the numeric ID of the new input field being added
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
    // manipulate the name/id values of the input inside the new element
        // H2 - section
        newElem.find('.heading-reference').attr('id', 'reference').attr('name', 'reference').html(' ' + newNum);

        // subject - select
		
		 newElem.find('.choice').attr('id', 'ID' + newNum + '_choice').val('');
         newElem.find('.state').attr('id', 'ID' + newNum + '_state').val('');
     
		
    // insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
       


    // enable the "remove" button
        $('#btnDel').attr('disabled', false);
		
		

    // right now you can only add 5 sections. change '5' below to the max number of times the form can be duplicated
        if (newNum == 1000)
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