 <div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> Result for :   <?php echo $p->title ;?> </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'qa/trs/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "');?>
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
                                                    <div class="thumb-md member-thumb center-block">
                                                        <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="150" height="150"  class="img-circle img-thumbnail" alt="profile-image">
                                                      
                                                    </div>
                                                    <div class="">
													<?php $u = $this->ion_auth->get_user($p->created_by);?>
                                                        <h4 class="m-b-5"> BY: <?php echo strtoupper($u->first_name.' '.$u->last_name);?></h4>
                                                        <p class="text-black">Educator / teacher</p>
                                                    </div>
												
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
													<!--
													<hr>
                                                    <h4>INSTRUCTIONS</h4>
                                                    <p class="text-black font-13 m-t-20">
                                                       <?php echo $p->instruction?>
                                                    </p>
-->

                                                </div>

                                            </div> <!-- end card-box -->

                                        </div> <!-- end col -->
                            
				      <div class="col-md-7">
					   
						<table  class="table" >
							   <tbody>

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
										<p class="font18"><?php  echo $sum_awarded_points;?></p>
									 </td>
									 <td class="bg-black" >
										<p><strong>Out of  </strong></p>
									 </td>
									 <td  class="bg-green required" colspan="">
										<p class="font18"><?php  echo $sum_qa_points;?></p>
									 </td>
								  </tr>
								  
								  <tr class="profile-th">
									 <td  class="bg-black">
										<p><strong>Educator's Remarks </strong></p>
									 </td>
									 <td  class="bg-green" colspan="7">
										<p>
										<?php  
										$rmk = $this->portal_m->qa_done($p->id,$this->student->id);
										echo isset($rmk ->remarks) ?  $rmk ->remarks.' - <small><i>( Posted on '.date('d M Y',$rmk ->rmk_date).' )</i></small>' : "<i>Awaiting educator's remarks.....</i>";
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
										
											
										foreach ($results as $p ):
											$qq = preg_replace("/<p.*?>(.*)?<\/p>/im","$1",$qn[$p->question]); 
											 $i++;
											 
										 ?>
								
                                    <article class="timeline-item ">
                                        <div class="timeline-desk">
                                            <div class="panel" <?php if($p->state==1) echo 'style="background:#E1F0AC"'; else echo 'style="background:#FFCCCC"'; ?>>
                                                <div class="timeline-box ">
                                                    <span class="arrow"></span>
                                                    <span class="timeline-icon  <?php if($p->status==1) echo 'bg-success'?> " ><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>
                                                    <h4 class=""><b class="text-green"><?php echo $i;?> ) Question: </b><?php echo $qq;?></h4>
                                                    <p class="timeline-date pull-right"><small class="text-blue">(<?php echo $mks[$p->question]; ?> Marks)</small></p>
													<hr>
                                                    <p class="text-blue"><b class="text-blue">Your Answer: </b><br> <?php echo $p->answer;?></p>
                                              
												<?php if($p->status==0){?>
												  <p class="pad10">
												  <span class="label label-danger ">Awaiting Marking</span>
												  </p>
												<?php }elseif($p->status==1){ ?>
												  <hr>
												  <?php if($ans[$p->question]){?>
                                                  <p class="text-blue"><b class="text-green">Correct Answer: </b> <?php echo $ans[$p->question];?></p>
												  <?php } ?>
												
												 <i class="text-red"> Marks Awarded: (<?php echo $p->points; ?> Marks)</i>
												    <hr>
												   <p><b class="text-green">Educator Remarks: </b> <?php echo $p->comment;?></p>
												<?php }?> 
												</div>
                                            </div>
                                        </div>
                                    </article>
	
									<?php endforeach ?>
								
								</div>
							
							

					<?php else: ?>
						<p class='text'><?php echo lang('web_no_elements');?></p>
					 <?php endif ?> 
						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
       </div>
      <!-- End row -->
