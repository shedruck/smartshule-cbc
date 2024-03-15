<div class="row card-group-row mb-lg-8pt">

  <?php
 
	foreach ($this->parent->kids as $k)
	 {
		 $st = $this->portal_m->find($k->student_id);
  ?>
    <div class="col-lg-4">
  <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <div class="flex">
                                                <strong>
												<?php
												if (!empty($st->old_adm_no))
												{
														echo $st->old_adm_no;
												}
												else
												{
														echo $st->admission_number;
												}
										  ?></strong>
                                              
                                            </div>
											 <?php $bg = ''; if($st->status==1) $bg = 'green'; else $bg='red';?>
                                                <i style="color:<?php echo $bg;?>" class=" fa fa-check-circle"></i>
                                           
                                        </div>

                                    </div>

                                    <div class="list-group list-group-flush">

                                        <div class="list-group-item d-flex align-items-start p-16pt">
                                              
                                            <div class="flex">
											
											<center> <?php
												if (!empty($st->photo)):
													 $passport = $this->portal_m->student_passport($st->photo);
														if ($passport)
														{
																?> 
																<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" class="rounded-circle1 mr-8pt" width="120" style="border-radius:10%" >
												 <?php } ?>	

												<?php else: ?>   
														<?php echo theme_image("member.png", array('class' => "rounded-circle mr-8pt", 'width' => "120")); ?>
												<?php endif; ?> 
						                    
											  
                                                <div>
												
												<strong style="margin-top:5px;"><?php echo strtoupper($st->first_name)?>	 <?php echo strtoupper(substr($st->middle_name,0,1))?> <?php echo strtoupper($st->last_name)?></strong>
												<hr>
												</div>

                                                <div class="lh-1 mb-16pt">
													<p>
													 <strong class="text-60">Class/Level: </strong> 
															
															<?php $classes = $this->ion_auth->fetch_classes();
																$cls = isset($classes[$st->class]) ? $classes[$st->class] : ' -';
															   
																echo $cls;
																?>
													</p>
													
													
													<p><strong>Admission No. </strong>
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
				
													
												</div>
  </center>

                                            </div>
                                        </div>

                                        <div class="list-group-item d-flex align-items-start p-16pt">
                                          
                                            <div class="flex">
                                              <center>  <a  href="<?php echo base_url('portals/parents/student_report/'.$st->id)?>"  class="btn btn-sm btn-dark"> View History</a></center>
                                            </div>
                                        </div>

                                    </div>

                                </div>
								
                          
                  </div>         
	
<?php } ?>						
							
                           
                        </div>