  <div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h3> Class Assignments
             <div class="pull-right">  
	
				  <a  onclick="goBack()" href="#" class="btn btn-danger btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-caret-left"></i> Go Back</a>

            
                </div>
			</h3>	
	<hr>			
   </div>


  <div class="row">
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
													<?php $u = $this->ion_auth->get_user($p->created_by);?>
                                                        <h4 class="m-b-5">GIVEN BY: <?php echo strtoupper($u->first_name.' '.$u->last_name);?></h4>
                                                        <p class="text-black">Educator / teacher</p>
                                                    </div>
												<?php
													if (!empty($p->document))
													{
												?>
                                                    <a href="<?php echo base_url('uploads/files/' . $p->document); ?>" class="btn btn-success btn-sm w-sm waves-effect m-t-10 waves-light"><i class="fa fa-download"></i> Download Attachment</a>
							                   <?php } ?>
                                                    <hr/>

                                                    <div class="text-left">
                                                        <p class="text-black font-13"><strong>SUBJECT :</strong> 
														<?php 
														
														$sub = $this->portal_m->get_subject($class);?>
														<span class="m-l-15"><?php echo  $sub[$p->subject];?></span></p>

														<p class="text-black font-13"><strong>TOPIC :</strong> <span class="m-l-15"><?php echo $p->topic;?></span></p>
														
														<p class="text-black font-13"><strong>SUBTOPIC :</strong> <span class="m-l-15"><?php echo $p->subtopic;?></span></p>

														<p class="text-black font-13"><strong>START DATE :</strong> <span class="m-l-15"><?php echo date('d M Y',$p->start_date);?></span></p>

                                                        <p class="text-red font-13"><strong>END DATE:</strong><span class="m-l-15"><?php echo date('d M Y',$p->end_date);?></span></p>

                                                        <p class="text-black font-13"><strong>POSTED ON :</strong> <span class="m-l-15"><?php echo date('d M Y',$p->created_on);?></span></p>
                                                    </div>
													
													<hr>
                                                    <h4>Comment / Remarks</h4>
                                                    <p class="text-black font-13 m-t-20">
                                                       <?php echo $p->comment?>
                                                    </p>


                                                </div>

                                            </div> <!-- end card-box -->

                                        </div> <!-- end col -->
                                     
									 <div class="col-md-8 col-lg-9">
										<div class="col-md-6">	 
									 <h4>Assignments Given</h4>
													 <embed src="<?php echo base_url('uploads/files/' . $p->document); ?>" width="100%" height="550" class="tr_all_hover" type='application/pdf'>
													
											</div>
											<div class="col-md-6 ">
											 <h4>Done Assignments (<?php echo number_format(count($done))?>)</h4>
											 
			<div class="table-responsive card-box table-responsive">
			<?php if($done){?>
           <table id="datatable-buttons1" class="table table-striped table-bordered">
                <thead>
               
                <th>Student</th>
                <th>Submitted on</th>
                <th>Status</th>
               
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;

                    foreach ($done as $p):
					
					$st = $this->portal_m->find($p->student);
                            $i++;
                            ?>
                            <tr>
                               				
                                <td><?php echo $st->first_name.' '.$st->last_name; ?></td>
                                <td><?php echo date('d/m/Y', $p->date); ?></td>
                                <td><?php if($p->status==1) echo '<span class="label label-success">Marked</span>'; else echo '<span class="label label-warning">Pending</span>';?>  </td>
                              
                                <td width=''>
                                    <div class='btn-group'>
                                     <?php if($p->status==1){?>
                                          <a class="btn btn-sm btn-success" href='<?php echo site_url('trs/mark_assign/' . $p->id .'/'. $p->student .'/'. $class .'/'.$this->session->userdata['session_id'] ); ?>'><i class='fa fa-share'></i> View</a>
									 <?php }else{?>	 
									  <a class="btn btn-sm btn-primary" href='<?php echo site_url('trs/mark_assign/' . $p->id .'/'. $p->student .'/'. $class .'/'.$this->session->userdata['session_id'] ); ?>'><i class='fa fa-share'></i> View </a>
									 <?php }?>	 
                                         
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
			<?php } else{?>
				<h5>No posted assignment at the moment</h5>
			<?php } ?>
			</div>
                                            
											</div>
										</div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
						
						
						   <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
						   
						   	<?php 
									$attributes = array('class' => '', 'id' => '');
									echo   form_open_multipart('st/upload_assignment/'.$p->id.'/'.$this->session->userdata['session_id'], $attributes); 
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
                                                                <input  type='text' name='assignment' required="required" style="display:none" value="<?php echo $p->id?>"/>
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
