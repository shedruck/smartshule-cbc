  <div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3> Class Assignments
             <div class="pull-right">  
	
				 
                 <?php if(!$done){?>

				   <a target="_blank" href="<?php echo base_url('uploads/files/' . $post->document); ?>" class="btn btn-primary btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-download"></i> Attempt Assignment Now</a>
				   
				   <a href="#" data-toggle="modal" data-target="#con-close-modal" class="btn btn-success btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-upload"></i> Upload Done Assignment</a>
				  <?php } ?>

				  <a  onclick="goBack()" href="#" class="btn btn-danger btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-caret-left"></i> Go Back</a>

            
                </div>
			</h3>	
	<hr>			
   </div>

  <div class="row" id="pending">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4">
                                            <div class="text-center card-box">
                                                <div class="member-card">
                                                    <div class="thumb-xl member-thumb m-b-10 center-block">
                                                        <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="140" height="140"  class="img-circle img-thumbnail" alt="profile-image">
                                                        <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>
														

                                                    </div>
<br>
                                                    <div class="">
													<?php $u = $this->ion_auth->get_user($post->created_by);?>
                                                        <h4 class="m-b-5">GIVEN BY: <?php echo strtoupper($u->first_name.' '.$u->last_name);?></h4>
                                                        <p class="text-black">Educator / teacher</p>
                                                    </div>
												<?php
													if (!empty($post->document))
													{
												?>
                                                    <a href="<?php echo base_url('uploads/files/' . $post->document); ?>" class="btn btn-success btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-download"></i> Download Attachment</a>
							                   <?php } ?>
                                                    <hr/>

                                                    <div class="text-left">
                                                        <p class="text-black font-13"><strong>SUBJECT :</strong> 
														<?php 
														
														$sub = $this->portal_m->get_subject($class);?>
														<span class="m-l-15"><?php echo  isset($sub[$post->subject]) ? $sub[$post->subject]: ''; ;?></span></p>

														<p class="text-black font-13"><strong>TOPIC :</strong> <span class="m-l-15"><?php echo $post->topic;?></span></p>
														
														<p class="text-black font-13"><strong>SUBTOPIC :</strong> <span class="m-l-15"><?php echo $post->subtopic;?></span></p>

														<p class="text-black font-13"><strong>START DATE :</strong> <span class="m-l-15"><?php echo date('d M Y',$post->start_date);?></span></p>

                                                        <p class="text-red font-13"><strong>END DATE:</strong><span class="m-l-15"><?php echo date('d M Y',$post->end_date);?></span></p>

                                                        <p class="text-black font-13"><strong>POSTED ON :</strong> <span class="m-l-15"><?php echo date('d M Y',$post->created_on);?></span></p>
                                                    </div>
													
													<hr>
                                                    <h4>Comment / Remarks</h4>
                                                    <p class="text-black font-13 m-t-20">
                                                       <?php echo $post->comment?>
                                                    </p>


                                                </div>

                                            </div> <!-- end card-box -->

                                        </div> <!-- end col -->
                                       <?php if($done){?>
									 <div class="col-md-8 col-lg-9">
										<div class="col-md-6">	 
									 <h4>Assignments Given  <hr></h4>
													 <embed src="<?php echo base_url('uploads/files/' . $post->document); ?>" width="100%" height="550" class="tr_all_hover" type='application/pdf'>
													
											</div>
											<div class="col-md-6 ">
											 <h4>Done Assignments 
                                             <?php if($done->status==0){?>											 
											
											 <a  href="#" class="btn btn-primary btn-sm pull-right"><i class="fa fa-file"></i> Pending Marking</a>
											 
											   <?php }else{ ?>
											    <a href="#marked"  class="pull-right btn btn-success btn-sm"><i class="fa fa-caret-right"></i> View Marked  Assignment</a>
											   
											   <?php } ?>
											   <hr>
											 </h4>
											 
											
													 <embed src="<?php echo base_url('uploads/'.$done->path.''.$done->file); ?>" width="100%" height="550" class="tr_all_hover" type='application/pdf'>
											</div>
										</div>

										
									   <?php }else{ ?>
											  
											 
                                        <div class="col-md-8 col-lg-9">
                                            <h4>Assignments Content</h4>
											 <?php
											if (!empty($post->document))
											{
													?>
													 <embed src="<?php echo base_url('uploads/files/' . $post->document); ?>" width="100%" height="700" class="tr_all_hover" type='application/pdf'>
													<?php
											}
											else
											{
													?>
											<?php echo $post->assignment?>
											<?php } ?>
										 </div>
                                        <!-- end col -->
										
										 <?php } ?>

                                    </div>
                                </div>
                            </div>
       </div>
      <!-- End row -->
	    <?php if($done){?>
	      <?php if($done->status==1){?>
	    <div class="card-box" id="marked">
			<div class="row">

			 <div class="col-md-12">
			 
				<div class="col-md-3 ">
				 <h4>GIVEN  ASSIGNMENTS</h4>
				 <embed src="<?php echo base_url('uploads/files/' . $post->document); ?>" width="100%" height="400" class="tr_all_hover" type='application/pdf'>
				</div>
				
				<div class="col-md-3 ">
				 <h4>DONE  ASSIGNMENTS</h4>
				 <embed src="<?php echo base_url('uploads/'.$done->path.''.$done->file); ?>" width="100%" height="400" class="tr_all_hover" type='application/pdf'>
				</div>
				
				<div class="col-md-3 ">
				 <h4> MARKED ASSIGNMENTS</h4>
				 <?php if($done->result){?>
				 <embed src="<?php echo base_url('uploads/'.$done->result_path.''.$done->result); ?>" width="100%" height="400" class="tr_all_hover" type='application/pdf'>
				 <?php }else{ ?>
				 <i> No file attached </i>
				 <?php } ?>
				</div>


				<div class="col-md-3 ">
				 <h4>POINTS AWARDED</h4>
				   <div class='form-group row'>
					   <table class="table">
						   <tr>
								<td><strong>Points Awarded</strong></td>
								<td> <?php echo $done->points?>	</td>
						   </tr>
						   <tr>
								<td><strong>Out of</strong></td>
								<td> <?php echo $done->out_of?>	</td>
						   </tr>
						   <tr>
								<td><strong>Percentage</strong></td>
								<td> <b class="text-red"><?php  echo round(((float)$done->points*100/(float)$done->out_of),2)?> %</b>		</td>
						   </tr>
					   </table>
			
					 </div>
					 
					  <div class='form-group row'>
						   <div class="col-md-12"><strong>Educator Comment: </strong></div>
						   <hr>
							  <div class="col-md-12">
							   <?php echo $done->comment?>
							  </div>
					  </div>
			  
				</div>
	        </div>
		</div>
</div>
	  <?php } ?>					
	  <?php } ?>					
						
						
						
						
						   <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
						   
						   	<?php 
									$attributes = array('class' => '', 'id' => '');
									echo   form_open_multipart('st/upload_assignment/'.$post->id.'/'.$class.'/'.$this->session->userdata['session_id'], $attributes); 
									?>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">SUBMIT YOUR ASSIGNMENT</h4>
                                                </div>
                                                <div class="modal-body">
                                                   
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="field-3" class="control-label">Click button below to upload assignment</label>
																<hr>
                                                                <input  type='text' name='assignment' required="required" style="display:none" value="<?php echo $post->id?>"/>
										                       <input id='document' type='file' name='document' required="required" />
															   <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                 
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group no-margin">
                                                                <label for="field-7" class="control-label">Comment / Remarks</label>
                                                                <textarea class="form-control autogrow" name="comment" id="comment" placeholder="Any Comment / Remarks" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                 
                                                    <button type="submit" class="btn btn-info waves-effect waves-light">Save changes</button>
													<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
										<?php echo form_close(); ?>	
										
                                    </div><!-- /.modal -->
