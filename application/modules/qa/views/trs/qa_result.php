 <div class="portlet mt-2">
 
  <div class="row" >
                            <div class="col-sm-12">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php $st = $this->portal_m->find($student); echo $p->title ;?> Result for :  <?php echo $st->first_name;?> <?php echo $st->middle_name;?> <?php echo $st->last_name;?> </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "');?>
		  <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
       
    </div>
    </div>
    </div>
 <hr>


  <div class="row" >
                            <div class="col-sm-12">
                                <div class="card-box1">
                                    <div class="row">
                                        <div class=" col-md-5">
                                            <div class="text-center card-box">
                                                <div class="member-card">
                                                    <div class="thumb-xl member-thumb m-b-10 center-block">
                                                        <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="100" height="100"  class="img-circle img-thumbnail" alt="profile-image">
                                                        <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>

                                                    </div>
                                            <br>
                                                    <div class="">
													<?php $u = $this->ion_auth->get_user($p->created_by);?>
                                                        <h4 class="m-b-5"> BY: <?php echo strtoupper($u->first_name.' '.$u->last_name);?></h4>
                                                        <p class="text-black">Educator / teacher</p>
                                                    </div>
												
                                                    <hr/>

                                                    <div class="text-left">
													   <table class="table">
															<tr>
																<td><strong>TITLE :</strong></td>
																<td><?php echo $p->title ;?></td>
															</tr>
															
															<tr>
																<td><strong>LEVEL:</strong> </td>
																<td><?php  $classes = $this->portal_m->get_class_options();    echo  $classes[$p->level];?></td>
															</tr>
															<tr>
																<td><strong>SUBJECT :</strong></td>
																<td><?php echo $p->subject;?></td>
															</tr>
															
															<tr>
																<td><strong>DURATION :</strong></td>
																<td><?php echo isset($p->hours) ? $p->hours : '0';?>hrs : <?php echo isset($p->minutes) ? $p->minutes : '00';?> mins</td>
															</tr>
															<tr>
																<td><strong>TOPIC :</strong></td>
																<td><?php echo $p->topic;?></td>
															</tr>
															<tr>
																<td><strong>POSTED ON :</strong></td>
																<td><?php echo date('d M Y',$p->created_on);?></td>
															</tr>
													   </table>
													   
                                                   
                                                      
                                                    </div>
													
													<hr>
                                                    <h4>INSTRUCTIONS</h4>
                                                    <p class="text-black font-13 m-t-20">
                                                       <?php echo $p->instruction?>
                                                    </p>


                                                </div>

                                            </div> <!-- end card-box -->

                                        </div> <!-- end col -->
                            
				      <div class="col-md-7">
					   
						<table  class="table" >
							   <tbody>
							   
							    <tr class="profile-th">
									 <td  class="bg-black">
										<p><strong>STUDENT</strong></p>
									 </td>
									 <td  class="bg-blue" colspan="7">
										<p class="text-center">
										 <?php echo strtoupper($st->first_name);?> <?php echo  strtoupper($st->middle_name);?> <?php echo  strtoupper($st->last_name);?>
										 --
										 ADM NO:
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
										</p>
									 </td>
								  </tr>

								  
								  <tr class="profile-th">
									 <td  class="bg-black">
										<p><strong>Date Submitted </strong></p>
									 </td>
									 <td  class="bg-green">
										<p class="font16">
										<?php echo isset($given->modified_on) ? date('d/m/Y',$post->modified_on) : '';?>
									
										</p>
									 </td>
									 <td  class="bg-black">
										<p><strong>Time </strong></p>
									 </td>
									 <td  class="bg-green">
										<p class="font16">
										<?php echo isset($given->modified_on) ? date('H:s',$given->modified_on) :'';?>
									
										</p>
									 </td>
									 <td  class="bg-black">
										<p><strong>Date Marked </strong></p>
									 </td>
									 <td  class="bg-green">
										<p class="font16">
										<?php echo isset($post->created_on) ? date('d/m/Y',$post->created_on) : '';?>
									
										</p>
									 </td>
									 <td  class="bg-black">
										<p><strong>Time </strong></p>
									 </td>
									 <td  class="bg-green">
										<p class="font16">
										<?php echo isset($post->created_on) ? date('H:i',$post->created_on) : '';?>
									
										</p>
									 </td>
								  </tr>

								  <tr class="profile-th">
									 <td  class="bg-black">
										<p ><strong>No. of Questions </strong></p>
									 </td>
									 <td class="bg-green" colspan="3">
										<p class="font18"><?php  echo number_format(count($results));?></p>
									 </td>

									 <td class="bg-black">
										<p><strong>Attempted </strong></p>
									 </td>
									 <td  class="bg-green" colspan="3">
										<p class="font18"><?php  echo $count_done;?></p>
									 </td>
								  </tr>

								  <tr class="profile-th">
									 <td  class="bg-black">
										<p ><strong>Correct answers </strong></p>
									 </td>
									 <td class="bg-green" colspan="3">
										<p class="font18"><?php  echo $qa_correct;?></p>
									 </td>

									 <td  class="bg-black">
										<p><strong>Wrong answers </strong></p>
									 </td>
									 <td class="bg-green" colspan="3">
										<p class="font18"><?php  echo $qa_wrong;?></p>
									 </td>
								  </tr>
								  
								  <tr class="profile-th">
									 <td class="bg-black" >
										<p><strong>Unanswered </strong></p>
									 </td>
									 <td  class="bg-green" colspan="3">
										<p class="font18"><?php  echo (count($results) - $count_done);?></p>
									 </td>

									 <td  class="bg-black">
										<p><strong>Score  </strong></p>
									 </td>
									 <td  class="bg-red" colspan="3">
										<p class="font18"><b class=""><?php  $pt = (float) ($sum_awarded_points*100)/$sum_qa_points; echo round($pt,2)?>% </b> </p>
										
									 </td>
								  </tr>

								  <tr class="profile-th">
									 <td  class="bg-black">
										<p><strong>Grade </strong></p>
									 </td>
									 <td  class="bg-green" colspan="3">
										<p><?php  ?></p>
									 </td>

									 <td class="bg-black" >
										<p><strong>Marks  </strong></p>
									 </td>
									 <td  class="bg-green required" >
										<p class="font18"><?php  //echo $qa_correct;?></p>
									 </td>
									 <td class="bg-black" >
										<p><strong>Out of  </strong></p>
									 </td>
									 <td  class="bg-green required" colspan="">
										<p class="font18"><?php  //echo $count_qstns;?></p>
									 </td>
								  </tr>
								  
								  <tr class="profile-th">
									 <td  class="bg-black">
										<p><strong>Educator's Remarks </strong></p>
									 </td>
									 <td  class="bg-green" colspan="7">
										<p id="rmk_<?php echo $given->id;?>">
										<?php  
										$rmk = $this->portal_m->given_qa($given->id,$student);
										echo isset($rmk ->remarks) ? $rmk ->remarks.' - <small><i>( Posted on '.date('d M Y',$rmk ->rmk_date).' )</i></small>' : "<i>Awaiting Remarks</i>";
										?>
										
										</p>
										
										
				
									 </td>

									
								  </tr>
								  
								 

								  
							</tbody>	  
						</table>
						
						
							
											
					 </div>
					<!-- end col -->
					
						
					<div class="col-sm-12">
					
					<!-------- LOOP THRU ANSWERS -------->
						
						 <?php if ($results): ?>

						<div class="timeline timeline-left">
                                    <article class="timeline-item alt">
                                        <div class="text-left">
                                            <div class="time-show first">
                                                <a href="#" class="btn btn-danger w-lg">Questions </a>
                                            </div>
                                        </div>
                                    </article>
								
									
										<?php 
											 $i = 0;
											 $j = 1;
										$qn = $this->st_m->populate('qa_questions','id','question');
										$mks = $this->st_m->populate('qa_questions','id','marks');
										$ans = $this->st_m->populate('qa_questions','id','answer');
										$points = $this->trs_m->populate('qa_questions','id','marks');
										$pnts = 0;
											
										foreach ($results as $p ):
											$qq = preg_replace("/<p.*?>(.*)?<\/p>/im","$1",$qn[$p->question]); 
											$the_ans = strip_tags($ans[$p->question]);
											 $i++;
											 $pnts = (int) $points[$p->question];
										 ?>
								
                                    <article class="timeline-item ">
                                        <div class="timeline-desk">
                                            <div class="panel " id="panel_<?php echo $p->id;?>" <?php if($p->status==1) echo 'style="background:#E1F0AC"'; ?> >
                                                <div class="timeline-box ">
                                                    <span class="arrow"></span>
                                                    <span class="timeline-icon  <?php if($p->status==1) echo 'bg-success'?> " ><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>
                                                    <h4 class=""><b class="text-green"><?php echo $i;?> ) Question: </b><?php echo $qq;?></h4>
                                                    <p class="timeline-date pull-right"><small class="text-blue">(<?php echo $mks[$p->question]; ?> Marks)</small></p>
													<hr>
                                                    <p class="text-blue"><b class="text-blue">Student's Answer: </b><br> <?php echo $p->answer;?></p>
                                              
												<?php if($p->status==0){?>
												
												<p class="pad10">
												
												   <h5 id="btn_list_<?php echo $p->id?>">
															
															  <button class="btn btn-success btn-sm waves-effect waves-light" data-toggle="modal" data-target="#correct_<?php echo $p->id?>"><i class="fa fa-check"></i> CORRECT </button>

															  <button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target="#wrong_<?php echo $p->id?>"><i class="fa fa-check"></i> WRONG </button>
															  
															 <button class="btn btn-sm btn-primary" id="scheme_<?php echo $p->id?>"  > MARKING SCHEME</button>

													  </h5>
												  </p>
												  
												<?php }elseif($p->status==1){ ?>
												
												  <hr>
												  <?php if($ans[$p->question]){?>
                                                  <p class="text-blue"><b class="text-green">Correct Answer: </b> <?php echo $ans[$p->question];?></p>
												  <?php } ?>
												
												 <span> <i class='label label-<?php if($p->points >0) echo 'success';else echo 'danger'; ?> '> Marks Awarded: (<?php echo $p->points; ?>)</i></span>
												    <hr>
													<p>
															<b class="text-green">Educator's Remarks: </b> <?php echo $p->comment;?>
												
													
												   <span class="pull-right"> <i class=" label label-success">Marked</i> 
												    <button class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#correct_<?php echo $p->id?>"><i class="fa fa-edit"></i> Edit </button>
													
												   </p>
												   
												   
												   
												<?php }?> 
												
												
												 <p id="marked_list_<?php echo $p->id?>" style="display:none">
													  <span class="label label-primary font-15">Marked</span>
													  <span id="given_points_<?php echo $p->id?>" class="">
													  
													  </span>
													  <br>
													  <span id="trs_comment<?php echo $p->id?>" class=""> </span>
													  
													 
												  </p>
												
												</div>
                                            </div>
                                        </div>
                                    </article>
									
									
									
										<!-- sample modal content -->
                                    <div id="correct_<?php echo $p->id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Correct" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title" id="myModalLabel">Mark Question No. <?php echo $i?> - (<?php echo $mks[$p->question]; ?> Marks)</h4>
                                                </div>
                                                <div class="modal-body">
                                                      <div class='form-group row'>
													  <div class="col-md-3">Mark * </div>
														  <div class="col-md-7"> 
														   <input name="points" class="form-control" type="text" id="points_<?php echo $p->id?>">
															
														  </div>
													  </div>
														  
													<div class='form-group row'>
													  <div class="col-md-3">Comment: </div>
														  <div class="col-md-7"> 
															 <textarea id="comment_<?php echo $p->id?>" placeholder="Add remarks..." style="color:red; " rows="2" cols="50"  class="form-control comment font-17"   name="comment"  /></textarea>
													</div>
													 </div>

                                                </div>
                                                                              
                                                  <div class="modal-footer">
												  <button  type="submit" id="c_<?php echo $p->id?>" data-dismiss="modal" class="btn btn-success waves-effect waves-light">Submit</button>
										
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                 
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
									
									
										<!-- Right Answer ----->		
						
						
						<!-- Wrong Answer ----->
						
						  <div id="wrong_<?php echo $p->id?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Wrong" aria-hidden="true">
                              <div class="modal-dialog">
								
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">Mark Question No. <?php echo $i?></h4>
								</div>
								<div class="modal-body">				
								<div class='form-group row'>
									  <div class="col-md-3">Comment: </div>
										  <div class="col-md-7"> 
										<textarea placeholder="Remarks / Comment ..." rows="2" cols="50" style="color:red; "  class="form-control comment" id="comm_<?php echo $p->id?>"  name="comment"  /></textarea>
									</div>
									 </div>
									 
									 <div class="modal-footer">
						                <button type="submit" id="w_<?php echo $p->id?>" data-dismiss="modal" class="btn btn-danger md-close">Submit</button>
										 <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
									</div>
								</div>

							  </div>
						   </div> 
						</div> 
									
									
										<script>
							$(document).ready(function ()
							{
								
								 $("#scheme_<?php echo $p->id?>").click(function () {
									
									 swal({
												  title: "Given correct answer is",
												  text: "<?php echo $the_ans?>",
												  icon: "success",
												  button: "Close",
												})
												
									});
								
								
								$("#points_<?php echo $p->id?>").change(function() { 

									
									var pnts = 0;
									pnts = $("#points_<?php echo $p->id?>").val();
									var avail_points = <?php echo $pnts?>;
									
									if(pnts > avail_points ){
										
										swal({
												  title: "Sorry maximum marks is <?php echo $pnts?>",
												  text: "Marks awarded is higher than set marks",
												  icon: "warning",
												  button: "Close",
												})
												
										$(this).css("border", "3px  solid #DC3545"); 
										
									}else{
										
									$(this).css("background-color", "#7FFF00"); 
									$('#c_<?php echo $p->id?>').show('fast');
									
									}
									
								}); 
								
								//************ MARK AS CORRECT **********//
								
								$("#c_<?php echo $p->id?>").click(function () {
									
									
									document.getElementById("given_points_<?php echo $p->id?>").innerHTML = "";
									document.getElementById("trs_comment<?php echo $p->id?>").innerHTML = "";
									 
									 $("#given_points_<?php echo $p->id?>").empty();
									 $("#trs_comment<?php echo $p->id?>").empty();
									 
									var id =  <?php echo $p->id?>;
									var state =  1;
									var points =  $("#points_<?php echo $p->id?>").val();
									var comment =  $("#comment_<?php echo $p->id?>").val();
									
                                  if(points != ""){
									  
									$.getJSON("<?php echo base_url('qa/trs/update_qa/'); ?>", {id: id,state: state, points:points, comment:comment}, function (data) {
										
										if(data===0){
											
												swal({
												  title: "Sorry something went wrong",
												  text: "Try again later",
												  icon: "warning",
												  button: "Close",
												})
											
											
										}else{
											//location.reload();
										   /*  swal({
												  title: "Successfully Marked",
												  text: "Question was successfully marked",
												  icon: "success",
												  button: "Close",
												}) */
												
											$('#marked_list_<?php echo $p->id?>').show('fast');
											$('#btn_list_<?php echo $p->id?>').hide();
											
											 document.getElementById("given_points_<?php echo $p->id?>").innerHTML += "<span class='label label-success font-15'>Awarded Marks "+points+"</span>";
											 
											 document.getElementById("panel_<?php echo $p->id;?>").style.background="#E1F0AC";
											 
											 document.getElementById("trs_comment<?php echo $p->id?>").innerHTML += "<b>Educator's remarks:</b> <span class='required'>"+comment+"</span>";
										}
										
										
									});
									
								}else{
										alert('Marks must be awarded');
									}

								});
							})

					   </script>
					   
					   
						<script>
							$(document).ready(function ()
							{
								$("#w_<?php echo $p->id?>").click(function () {
									
									 document.getElementById("given_points_<?php echo $p->id?>").innerHTML = "";
									 document.getElementById("trs_comment<?php echo $p->id?>").innerHTML = "";
									 
									 $("#given_points_<?php echo $p->id?>").empty();
									 $("#trs_comment<?php echo $p->id?>").empty();
									
									var id =  <?php echo $p->id?>;
									var state =  0;
									var points =  0;
									var comment =  $("#comm_<?php echo $p->id?>").val();
									
									$.getJSON("<?php echo base_url('qa/trs/update_qa/'); ?>", {id: id,state: state, points:points, comment:comment}, function (data) {
										
										if(data===0){
											
											swal({
												  title: "Sorry something went wrong",
												  text: "Try again later",
												  icon: "warning",
												  button: "Close",
												})
											
											
										}else{
											
											
											/* swal({
												  title: "Successfully Update",
												  text: "Your update was successfully submitted",
												  icon: "success",
												  button: "Close",
												}) */

											$('#marked_list_<?php echo $p->id?>').show('fast');
											$('#btn_list_<?php echo $p->id?>').hide();
											
											 document.getElementById("given_points_<?php echo $p->id?>").innerHTML += "<span class='label label-danger font-15'>Awarded Marks 0 </span>";
											 
											 document.getElementById("panel_<?php echo $p->id;?>").style.background="#E1F0AC";
											
											 document.getElementById("trs_comment<?php echo $p->id?>").innerHTML += "<b>Educator's remarks:</b> <span class='required'> "+comment+"</span>";
										}
										
										
									});

								});
							})

					   </script>
					   
	
									<?php endforeach ?>
								
								</div>
								
								
						<div class="timeline timeline-left">
							<article class="timeline-item alt">
								<div class="text-left">
									<div class="time-show first">
										<a href="#" class="btn btn-success w-lg">Educator's / Teacher's General Remarks </a>
									</div>
								</div>
							</article>

                             <article class="timeline-item ">
								<div class="timeline-desk">
									<div class="panel " >
										<div class="timeline-box ">
											<span class="arrow"></span>
											<span class="timeline-icon  " ><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>							
								
								<?php $rmk = $this->portal_m->given_qa($given->id,$student); ?>
										
								<div class="form-group">
							
									<textarea id="comment_<?php echo $given->id;?>" class="form-control" name="comment" placeholder="Type Remarks here..."><?php echo isset($rmk ->remarks) ? $rmk ->remarks : ''; ?></textarea>
									</div>
									
									
									
									     <div class="form-group">
	                                                <div class="checkbox checkbox-primary">
	                                                    <input id="marked_<?php echo $given->id;?>" value="1" checked type="checkbox" name="marked">
	                                                    <label for="marked_<?php echo $given->id;?>">
	                                                        Set as marked
	                                                    </label>
	                                                </div>
	                                            </div>
												
									<div class="form-group">
											<input type="submit" id="submt_<?php echo $given->id;?>"  class="btn btn-danger pull-right" value="Submit Remarks">
										</div>
									
									</div>
								</div>
							</div>
						</article >
					</div>
						
									
									 <script>
											$(document).ready(function ()
											{
													
												  //******   POST THE COMMENT ON REPLIES ******//
												  
													$("#submt_<?php echo $given->id;?>").click(function () {	
																							//alert(<?php echo $student;?>);
															var id = <?php echo $given->id;?>;
															
															var st = <?php echo $student;?>;
															var comment = $('#comment_<?php echo $given->id;?>').val();
															var marked = 0;
															var status= 0;
															
															if($('#marked_<?php echo $given->id;?>').is(":checked")){
																marked = 1;
																status = 1;
															}
															
															if(comment==''||id=='')
															{
															   	swal({
																	  title: "Sorry",
																	  text: "Atleast write something before submitting !",
																	  icon: "warning",
																	  button: "Close",
																	})
															}
															else
															{ 
															
												$.getJSON("<?php echo base_url('qa/trs/post_comment/'); ?>", {id: id,st: st, comment:comment, marked:marked, status:status}, function (data) {
										
														if(data===0){
															
															swal({
																  title: "Sorry something went wrong",
																  text: "Try again later",
																  icon: "warning",
																  button: "Close",
																})
															
															
														}else{
															
															
															swal({
																  title: "Successfully Update",
																  text: "Your update was successfully submitted",
																  icon: "success",
																  button: "Close",
																}) 

																			document.getElementById("rmk_<?php echo $given->id;?>").innerHTML += "<span>"+comment+"</span>"; 
															}
							
															});
															
															}
													    });
													})
								
														

									</script>
											
									
							

					<?php else: ?>
						<p class='text'><?php echo lang('web_no_elements');?></p>
					 <?php endif ?> 
						</div>
						
						
					
				</div>
			</div>
		</div>
       </div>
      <!-- End row -->
	  
	  