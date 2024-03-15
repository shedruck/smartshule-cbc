 <div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php $cl = $this->portal_m->get_class_options(); echo strtoupper($cl[$post->level]);?> - Q and A Given Quiz   </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "');?>
		  <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
       
    </div>
 <hr>

 <?php echo form_open('qa/trs/post_marked/'.$created.'/'.$qa_id.'/'.$this->session->userdata['session_id'], 'class="form-inline" id="fextra"'); ?>
  <div class="row">
		<div class="col-sm-12 card">
	
					<h4>TITLE:  <?php echo $post->title ?> </h4>
					<hr>
					
					 <?php $i=0; if($given){ ?>
					
					  <table id="datatable-buttons" class="table table-striped table-bordered">
						<thead>
						<th>Photo</th>
						<th>Student</th>
						<th>ADM No.</th>
						<th>Submitted On</th>
						<th>Status</th>
						<th>Checked</th>
						<th>Results</th>
						<th ><input type="checkbox" class="checks" />  </th>
						<th>Action</th>
						</thead>
			
					   <?php 
					  
					   foreach($given as $p){ $i++; $st = $this->portal_m->find($p->student); ?>
					   
					   <tbody>
						   <tr>
								 <td class="text-center">
								 <?php
									if (!empty($st->photo)):
											if ($passport= $this->portal_m->student_passport($st->photo))
											{
													?> 
													<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="50" height="50" class="img-circle img-thumbnail1" >
									 <?php } ?>	

									<?php else: ?> 
											<image src="<?php echo base_url('uploads/files/member.png'); ?>" width="60" height="60" class=" text-center" >

									<?php endif; ?>  
								</td>
								<td>
							     <?php echo $st->first_name;?> <?php echo $st->middle_name;?> <?php echo $st->last_name;?>
								 </td>
								 <td>
								 <br>
							    <?php
										if (!empty($st->old_adm_no))
										{
												echo $st->old_adm_no;
										}
										else
										{
												echo $st->admission_number;
										}
										?>
							  </td>
							  <td>
									<?php echo isset($p->modified_on) ? date('d M Y',$p->modified_on) : '';?>
							  </td>
							  <td>
								   <?php 
										 if($p->done ==1){
									?>
											<span class="label label-success">Done</span>
									 <?php }else{ ?>
										<span class="label label-danger">Pending</span>
									 <?php }?>
							  </td>

							  <td>
								   <?php 
										 if($p->marked==1){
									?>
										<span class="label label-info">Yes</span>
									 <?php }else{ ?>
										<span class="label label-warning">No</span>
									 <?php }?>
							  </td>
							    <td>
								   <?php 
										 if($p->status ==1){
									?>
											<span class="label label-success">Posted</span>
									 <?php }else{ ?>
										<span class="label label-inverse">Pending</span>
									 <?php }?>
							  </td>
							  
							  <td class="text-center">
							    <?php echo form_checkbox('students[]', $st->id, '', 'class="switchx check-lef"') ?>
							  </td>
							  
							  <td id="rmk_<?php echo $p->id?>">
							  <div class="btn-group pull-right">
						         <?php 
										 if($p->done ==1){
									?>
									
									<?php 
										 if($p->status !=1){
									?>
								
								 <a class="btn btn-success btn-sm"  href='<?php echo site_url('qa/trs/qa_result/'.$post->id.'/'.$p->student.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-edit'></i> <?php if($p->marked ==1) echo 'Edit Marks'; else echo 'Mark Quiz</a>';?>
								 <?php }?>
							       <a class="btn btn-primary btn-sm"  href='<?php echo site_url('qa/trs/qa_result/'.$post->id.'/'.$p->student.'/'.$this->session->userdata['session_id']);?>'><i class='fa  fa-folder-open'></i> View Results</a>
							 <?php }?>
							  </div>
							  
							  
							  </td>
						  </tr>
						  </tbody>
					   <?php  } ?>
					 </table>
					 <div class="col-sm-5">
					  </div>
					  <div class="col-sm-7">
					   <?php echo form_submit('submit', 'POST RESULTS TO  STUDENTS', "id='submit' class='btn btn-success' "); ?>
					   
					  </div>
					  <br>
					  <br>
					  
					  <?php }else{?>
					     No question has been added
					  <?php } ?>
										
											
					 </div>
					<!-- end col -->
					
				</div>
				
				 <?php echo form_close(); ?>
			</div>
		</div>
       </div>
      <!-- End row -->
	  
	  
	  
	  <script>
        $(function ()
        {
            $(".checks").on('change', function ()
            {
                $("input.check-lef").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });

            $(".checkall").on('change', function ()
            {
                $("input.check").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });
        });
</script>


