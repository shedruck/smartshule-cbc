 <div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php $st = $this->portal_m->find($student); echo $p->title ;?> Result for :  <?php echo $st->first_name;?> <?php echo $st->middle_name;?> <?php echo $st->last_name;?> </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'mc/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "');?>
		  <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
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
                                                        <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="140" height="140"  class="img-circle img-thumbnail" alt="profile-image">
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
										<?php echo isset($post->created_on) ? date('d/m/Y',$post->created_on) : '';?>
									
										</p>
									 </td>
									 <td  class="bg-black">
										<p><strong>Time </strong></p>
									 </td>
									 <td  class="bg-green">
										<p class="font16">
										<?php echo isset($post->created_on) ? date('H:s',$post->created_on) :'';?>
									
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
										<p class="font18"><?php  echo $count_qstns;?></p>
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
										<p class="font18"><?php  echo $mc_correct;?></p>
									 </td>

									 <td  class="bg-black">
										<p><strong>Wrong answers </strong></p>
									 </td>
									 <td class="bg-green" colspan="3">
										<p class="font18"><?php  echo $mc_wrong;?></p>
									 </td>
								  </tr>
								  
								  <tr class="profile-th">
									 <td class="bg-black" >
										<p><strong>Unanswered </strong></p>
									 </td>
									 <td  class="bg-green" colspan="3">
										<p class="font18"><?php  echo ($count_qstns - $count_done);?></p>
									 </td>

									 <td  class="bg-black">
										<p><strong>Score  </strong></p>
									 </td>
									 <td  class="bg-red" colspan="3">
										<p class="font18"><b class=""><?php  $ppt = (float) ($mc_correct*100)/$count_qstns; echo round($ppt,2)?>% </b> </p>
										
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
										<p class="font18"><?php  echo $mc_correct;?></p>
									 </td>
									 <td class="bg-black" >
										<p><strong>Out of  </strong></p>
									 </td>
									 <td  class="bg-green required" colspan="">
										<p class="font18"><?php  echo $count_qstns;?></p>
									 </td>
								  </tr>
								  
								  <tr class="profile-th">
									 <td  class="bg-black">
										<p><strong>Educator's Remarks </strong></p>
									 </td>
									 <td  class="bg-green" colspan="7">
										<p id="rmk_<?php echo $p->id;?>">
										<?php  
										$rmk = $this->portal_m->mc_done($p->id,$student);
										echo isset($rmk ->remarks) ? $rmk ->remarks.' - <small><i>( Posted on'.date('d M Y',$rmk ->rmk_date).' )</i></small>' : "<i>Give your Remarks here</i>";
										?>
										<?php if(!isset($rmk ->remarks) ){?>
										
										<div class="form-group">
									
											<textarea id="comment_<?php echo $p->id;?>" class="form-control" name="comment" placeholder="Type Remarks here..."></textarea>
											</div>
											<div class="form-group">
                                                    <input type="submit" id="submt_<?php echo $p->id;?>"  class="btn btn-danger pull-right" value="Submit Remarks">
                                                </div>
											<?php } ?>
										</p>
										
										 <script>
											$(document).ready(function ()
											{
													
												  //******   POST THE COMMENT ON REPLIES ******//
												  
													$("#submt_<?php echo $p->id;?>").click(function () {	
																							
															var id = <?php echo $p->id;?>;
															
															var st = <?php echo $student;?>;
															var comment = $('#comment_<?php echo $p->id;?>').val();
															
															var dataString = '&comment='+ comment + '&id='+ id + '&st='+st;
															
															if(comment==''||id=='')
															{
															   alert("Atleast write something before submitting !");
															}
															else
															{ 
														//alert(comment);
																// AJAX Code To Submit Form.
																$.ajax({
																type: "POST",
																url: "<?php echo base_url('mc/trs/post_comment');?>",
																data: dataString,
																cache: false,
																success: function(result){
																
																 
																	document.getElementById("rmk_<?php echo $p->id;?>").innerHTML += "<span>"+comment+"</span>"; 
																	document.getElementById('comment_<?php echo $p->id;?>').value = ''
																	
																	 $('.form-group').hide('fast');
																  

																	}
																}); 
																	
															}
																							
																						
														});
											})
														

									</script>
				
									 </td>

									
								  </tr>
								  
								 

								  
							</tbody>	  
						</table>
						
						<!-------- LOOP THRU ANSWERS -------->
						
						 <?php if ($results): ?>
										 <div class="block-fluid">

									
									<div class=" card">
									<div class=" card-block ">
									<div class="row  ">
									<table class="table" >
												 <thead>
													 
														<th style="width:40%"> <div class="col-sm-6" >Question</div></th>
														<th style="width:25%" > <div class="col-sm-2" >Correct Answer</div></th>
														<th style="width:25%"> <div class="col-sm-3">Your Choice</div></th>
														<th style="width:10%" > <div class="col-sm-1">Score</div></th>
														
												</thead>
											
											
									<tbody>
									
										<?php 
												 $i = 0;
												 $j = 1;
											$qn = $this->st_m->populate('mc_questions','id','question');
											$choices = $this->st_m->populate('mc_choices','id','choice');
											
												
											foreach ($results as $p ):
												 $correct = $this->st_m->correct_mc($p->question_id);
												 $i++;
													 ?>
												<tr>
                                                   <td>
												
													<?php echo $qn[$p->question_id];?>
													</td>	
													
													<td >
													<?php if($p->state != 1){?>
													<span class="required"><?php echo $correct->choice;?></span>
													<?php } ?>
													</td>	
													
													<td >
													<span style="color:#0083C4"><b><?php echo $choices[$p->choice_id];?></b></span>
													</td>
													<td>
													
													<?php 
													if($p->state == 1) echo "<span class='btn btn-sm btn-success'><i class='fa fa-check'></i><span>";
													else echo "<span class='btn btn-sm btn-danger'><i class='fa fa-times'></i><span>";
													
													?>
													
													</td>
												</tr>
												
											<?php endforeach ?>
									
									
									</tbody>
									</table>

									
								</div>
								</div>
								</div>
								</div>


								<?php else: ?>
									<p class='text'><?php echo lang('web_no_elements');?></p>
								 <?php endif ?> 
							
											
					 </div>
					<!-- end col -->
					
				</div>
			</div>
		</div>
       </div>
      <!-- End row -->
