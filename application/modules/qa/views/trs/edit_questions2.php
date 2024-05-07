<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php echo $post->title?> - Question and Answers</b>
        </h3>
		 <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
		 <?php echo anchor( 'qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-primary btn-sm pull-right"');?>
      
        <div class="clearfix"></div>
        <hr>
    </div>
         	                    
               
<div class="row">


<div class="col-md-12">
			<div class="col-md-6">
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
			
				<div class='form-group'>
				<h5 class="col-md-12 bg-black text-center pad10" for='marks'>ALLOCATE MARKS (POINTS) </h5>
				<div class="col-md-12">
				<?php echo form_input('marks' ,$result->marks , 'id="marks" placeholder="E.g 5, 10, 20 etc" class="form-control" ' );?>
				<?php echo form_error('marks'); ?>
			</div>
			</div>


			<div class='form-group'>
				<h5 class="col-md-12 bg-black text-center pad10" for='topic'>TYPE OR COPY AND PASTE YOUR ANSWER HERE BELOW
<br><small class=" bg-black">(FOR MARKING SCHEME ONLY - NOT VISIBLE TO LEARNERS)</small></h5>
				<div class="col-md-12">
				 <textarea id="answer"   style="height: 120px;" class=" summernote "  name="answer"  /><?php echo isset($result->answer) ? htmlspecialchars_decode($result->answer) : ''; ?></textarea>
				
				<?php echo form_error('answer'); ?>
			</div>
			</div>


		

			<div class='form-group'><div class="col-md-2 "></div><div class="col-md-9">
				

				  <?php echo form_submit( 'submit', 'Update Changes' ,"id='submit' class='btn btn-sm btn-primary'"); ?>
				
			</div></div>
			 
			<?php echo form_close(); ?>
			<div class="clearfix"></div>
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
							  <?php $cc = count_chars($p->question); echo strip_tags(substr($p->question,0,50)); if($cc < 50) echo '...';?>
							  </td>
							   <td width="">
							  <div class="btn-group pull-right">
								  <a class="btn btn-primary btn-sm" href='<?php echo site_url('qa/trs/edit_questions/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa fa-edit'></i> Edit</a>
						  
								<!--  <a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('qa/trs/delete_question/'.$post->id.'/'.$p->id.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-times'></i> Trash</a>-->
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
    
			
			
			
			
			
			
			