 				<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> E-notes   </b>
        </h3>
		<div class="pull-right">
		
		 <?php echo anchor( 'enotes/trs/new_enotes/'.$this->session->userdata['session_id'], '<i class="fa fa-plus"></i> New E-Notes', 'class="btn btn-primary btn-sm "');?>

		 <?php echo anchor( 'enotes/trs/', '<i class="fa fa-list"></i> List All E-Notes', 'class="btn btn-success btn-sm "');?>
       <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
       
    </div>
 <hr>

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
                                                        <h4 class="m-b-5"> BY: <?php echo strtoupper($u->first_name.' '.$u->last_name);?></h4>
                                                        <p class="text-black">Educator / teacher</p>
                                                    </div>
												<?php
													if (!empty($post->file_name))
													{
												?>
                                                    <a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url()?><?php echo $post->file_path?>/<?php echo $post->file_name?>' /><i class='fa fa-arrow-down'></i> Download</a>
							                   <?php } ?>
                                                    <hr/>

                                                    <div class="text-left">
                                                        <p class="text-black font-13"><strong>SUBJECT :</strong> 
														<?php 
														
														$sub = $this->portal_m->get_subject($post->class);?>
														<span class="m-l-15"><?php echo  isset($sub[$post->subject]) ? $sub[$post->subject]: ''; ;?></span></p>

														<p class="text-black font-13"><strong>TOPIC :</strong> <span class="m-l-15"><?php echo $post->topic;?></span></p>
														
														<p class="text-black font-13"><strong>SUBTOPIC :</strong> <span class="m-l-15"><?php echo $post->subtopic;?></span></p>

														<p class="text-black font-13"><strong>POSTED ON :</strong> <span class="m-l-15"><?php echo date('d M Y',$post->created_on);?></span></p>

                                                        

                                                      
                                                    </div>
													
													<hr>
                                                    <h4>Comment / Remarks</h4>
                                                    <p class="text-black font-13 m-t-20">
                                                       <?php echo $post->remarks?>
                                                    </p>


                                                </div>

                                            </div> <!-- end card-box -->

                                        </div> <!-- end col -->
                            
                                        <div class="col-md-8 col-lg-9">
                                            <h4>E-Note</h4>
										
													 <embed src="<?php echo base_url()?><?php echo $post->file_path?>/<?php echo $post->file_name?>" width="100%" height="700" class="tr_all_hover" type='application/pdf'>
											
										 </div>
                                        <!-- end col -->
										
                                    </div>
                                </div>
                            </div>
       </div>
      <!-- End row -->
