 <div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> Result for :   <?php echo $p->title ;?> </b>
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
                                                    <div class="thumb-xl member-thumb center-block">
                                                        <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="80" height="80"  class="img-circle img-thumbnail" alt="profile-image">
                                                        <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>
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
										<p>
										<?php  
										$rmk = $this->portal_m->mc_done($p->id,$this->student->id);
										echo isset($rmk ->remarks) ?  $rmk ->remarks.' - <small><i>( Posted on'.date('d M Y',$rmk ->rmk_date).' )</i></small>' : "<i>Awaiting educator's remarks.....</i>";
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
										 <div class="block-fluid">

									
									<div class=" card">
									<div class=" card-block ">
									<div class="row  ">
									<table class="table" >
										 <thead>
											 
												<th style=""> <div class="" >#</div></th>
												<th style=""> <div class="" >Question</div></th>
												<th style="" > <div class="" >Correct Answer</div></th>
												<th style=""> <div class="">Your Choice</div></th>
												<th style="" > <div class="">Score</div></th>
												
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
													<?php echo $i;?> ) 
													</td>
													
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
			</div>
		</div>
       </div>
      <!-- End row -->
