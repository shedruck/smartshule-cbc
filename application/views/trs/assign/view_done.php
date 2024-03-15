   <?php $st = $this->portal_m->find($stud); ?>
  
  <div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3> <b><?php echo $st->first_name.' '.$st->middle_name.' '.$st->last_name; ?></b>  
									 <b>ADM No:</b> <?php echo isset($st->old_adm_no) ? $st->old_adm_no : $st->admission_number; ?>
									 <b class="pull-right1">Posted on:</b> <?php echo date('d/m/Y', $p->date); ?>
             <div class="pull-right">  
	
				  <a  onclick="goBack()" href="#" class="btn btn-primary btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-edit"></i> Mark Next</a>

				  <a  onclick="goBack()" href="#" class="btn btn-danger btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-caret-left"></i> Go Back</a>

            
                </div>
			</h3>	
	<hr>			
   </div>


  <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <div class="row">

									 <div class="col-md-12">
									 
									 <?php if($p->status==1){?> 
									 
									 	<div class="col-md-3 ">
										 <h4>DONE  ASSIGNMENTS</h4>
										 <embed src="<?php echo base_url('uploads/'.$p->path.''.$p->file); ?>" width="100%" height="400" class="tr_all_hover" type='application/pdf'>
										</div>
										
										<div class="col-md-3 ">
										 <h4> MARKED ASSIGNMENTS</h4>
										 <?php if($p->result){?>
										 <embed src="<?php echo base_url('uploads/'.$p->result_path.''.$p->result); ?>" width="100%" height="400" class="tr_all_hover" type='application/pdf'>
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
														<td> <?php echo $p->points?>	</td>
											       </tr>
												   <tr>
														<td><strong>Out of</strong></td>
														<td> <?php echo $p->out_of?>	</td>
											       </tr>
												   <tr>
														<td><strong>Percentage</strong></td>
														<td> <b class="text-red"><?php  echo round(((float)$p->points*100/(float)$p->out_of),2)?> %</b>		</td>
											       </tr>
										       </table>
									
											 </div>
											 
											  <div class='form-group row'>
												   <div class="col-md-12"><strong>Educator Comment: </strong></div>
												   <hr>
													  <div class="col-md-12">
													   <?php echo $p->comment?>
													  </div>
											  </div>
									  
										</div>
									 
									  <?php } else{?>	
										<div class="col-md-9">	 
									 <h4> 
									Done Assignments
									 </h4>
										  <embed src="<?php echo base_url('uploads/'.$p->path.''.$p->file); ?>" width="100%" height="550" class="tr_all_hover" type='application/pdf'>
													
									   </div>
									 <?php } ?>			   
									   
				<div class="col-md-3 ">
				
				 <?php if($p->status==0){?>
				 <h4>GIVE MARKS</h4>
				 <?php } else{?>	
				  <h4>UPDATE MARKS</h4>
				 <?php } ?>							 
										
					<?php 
						$attributes = array('class' => '', 'id' => '');
						echo   form_open_multipart('trs/set_as_marked/'.$p->id.'/'.$st->id.'/'.$class.'/'.$this->session->userdata['session_id'], $attributes); 
					?>
							<div class="md-content">
							

								<div>
									
									 <div class='form-group row'>
									
									  <div class="col-md-12">Upload Marked: (Optional)</div>
									  <hr>
										  <div class="col-md-12">
										   <input id='file' type='file' name='file'  />
										  </div>
									  </div>
									  <hr>
									 <div class='form-group row'>
									
										  <div class="col-md-6">Points Awarded</div>
										  <div class="col-md-6">
										   <input  type='text' name='points' id="points" value="<?php echo $p->points?>" placeholder="E.g 20" class="form-control" required="required" />										   
										  </div>
										<hr>
										  <div class="col-md-6">Out of </div>
										  
										  <div class="col-md-6">
										   <input  type='text' id="out_of" name='out_of' value="<?php echo $p->out_of?>" placeholder="" class="form-control" required="required" />										   
										  </div>
										
										  
									  </div>
								 
								   <div class='form-group row'>
									
									  
									  <div class="col-md-12">Comment: </div>
										  <div class="col-md-12">
										   <input  type='text' name='ass_id' required="required" style="display:none" value="<?php echo $p->id?>"/>
										   <input  type='text' name='student' required="required" style="display:none" value="<?php echo $p->student?>"/>
										    <textarea id="comment"  rows="5"  class="form-control " style="color:red"  name="comment"  /><?php echo $p->comment?></textarea>
										  </div>
										  
									  </div>
									  
									 </div>
									<div class="text-center">
								  <?php if($p->status==1){?>
									<button type="submit1" class="btn btn-primary waves-effect ">Update</button>
								  <?php }else{?>
								  <button type="submit1" class="btn btn-success waves-effect ">Submit</button>
								  <?php }?>
										
									</div>
								</div>
								
							<?php echo form_close(); ?>
                                            
											</div>
										</div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
						
				
									
									
																
		<script> 

			$(document).ready(function ()
				{
					$("form").submit(function() {
					  var points = $('#points').val();
					  var out_of = $('#out_of').val();
					 
					  if (points > out_of)
					  { 
					 
						swal({
							  title: "Hey Sorry!! ",
							  text: "Marks awaded can not be greater the total marks",
							  icon: "warning",
							  button: "Close",
							}); 
							
						 return false;
					  }
					  else
					  {
						 var chk = confirm('Are you sure you want to submit your assignment?');
									if(chk==true){
										return true;
									}else{
										return false;
									}										
						
					  }
					});

					
				})

		</script>  
