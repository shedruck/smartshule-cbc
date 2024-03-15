<div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Subordinate Staff </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/subordinate/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => ' Subordinate Staff')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/subordinate' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => ' Subordinate')), 'class="btn btn-primary"');?> 
             	<?php echo anchor('admin/subordinate/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive Subordinate' , 'class="btn btn-warning"'); ?>	
                </div>
                </div>
         	                     
               
				   <div class="block-fluid">
		
                 
				 
                   <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="uprofile-image">
										  <?php
											if (!empty($post->passport)):
												 
											?> 
											<image src="<?php echo base_url('uploads/files/' . $post->passport); ?>" width="150" height="150" class="img-polaroid  img-thumbnail" >
										   
											<?php else: ?>   
													 <image src="<?php echo base_url('uploads/files/member.png'); ?>" width="150" height="150" class="img-polaroid img-thumbnail" >
											<?php endif; ?>  
                                           
                                        </div>
                                        <div class="uprofile-name">
                                            <h3>
                                                   <?php echo $post->first_name.' '.$post->middle_name.' '.$post->last_name?>
                                                <!-- Available statuses: online, idle, busy, away and offline -->
                                                <span class="uprofile-status online"></span>
                                            </h3>
                                           
                                           
                                        </div>
                                         
                                    </div>
									 <div class="col-md-3 col-sm-3 col-xs-12">
									 <h3>Personal Details</h3>
									  <div class="uprofile-info">
									 <ul class="list-unstyled">
                                               
                                                <li><b>Gender: </b><?php echo $post->gender?></li>
                                                <li><b>Birthday: </b><?php  if(!empty($post->dob)) echo date('d M Y',$post->dob);?></li>
                                                <li><b>Marital Status </b><?php echo $post->marital_status?></li>
                                                <li><b>ID/Passport No.:</b><?php echo $post->id_no?></li>
												  <li><b>PIN No.: </b><?php echo $post->pin?></li>
                                                <li><b>Religion: </b><?php echo $post->religion?></li>
                                               
												
                                            </ul>
									 </div>
									 </div>

									 <div class="col-md-3 col-sm-3 col-xs-12">
									 <h3> Contacts Details</h3>
									  <div class="uprofile-info">
									 <ul class="list-unstyled">
									            
									             <li><b>Phone: </b><?php echo $post->phone?></li>
                                                <li><b>Email: </b><?php echo $post->email?></li>
												
                                                <li><b>Address </b><?php echo $post->address?></li>
                                                <li><b>Additional Details </b><?php echo $post->additionals?></li>
											
                                            </ul>
									 </div>
									 
									 </div>

									 <div class="col-md-3 col-sm-3 col-xs-12">
									 <h3>Employment Details</h3>
									  <div class="uprofile-info">
									 <ul class="list-unstyled">
									           <li><b>Staff Number: </b><?php echo $post->staff_no?></li>
                                                <li><b>Date Joined: </b><?php  if(!empty($post->date_joined)) echo date('d M Y',$post->date_joined);?></li>
                                                <li><b>Contract type: </b><?php echo $contracts[$post->contract_type]?></li>
                                              
                                                <li><b>Position: </b> <?php echo $post->position?></li>
                                                <li><b>Qualification:</b> <?php echo $post->qualification?></li>
												
                                              
                                            </ul>
									 </div>
									 
									 </div>
									
					</div>
					
					 <div class="col-sm-12"><hr></div>
					 <div class="col-md-4 col-sm-4 col-xs-12" style=" text-align:center">
						  <h3>ID/Passport Copy</h3>
							<?php 
								if($post->id_document){
								 ?>
								  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->id_document); ?>">
								  <embed src="<?php echo base_url('uploads/files/' . $post->id_document); ?>" width="250" style="min-height:230px;" class="tr_all_hover" type='application/pdf'>
								  </a>
								  
								  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->id_document); ?>"><i>Download File</i></a>
								  <br>
								 <?php }else{ ?>  
									<h5> No ID uploaded at the moment</h5>
								 <?php } ?> 		 
									 
					 </div>

									 <div class="col-md-6 col-sm-6 col-xs-12" >
									 <h3>Referee Details</h3>
									  <div class="uprofile-info">
									 <ul class="list-unstyled" >
									             <li><b>Name: </b><?php echo $post->ref_name?></li>
									             <li><b>Phone: </b><?php echo $post->ref_phone?></li>
                                                <li><b>Email: </b><?php echo $post->ref_email?></li>
												<?php if(isset($post->ref_address) && !empty($post->ref_address)){?>
                                                <li><b>Address </b><?php echo $post->ref_address?></li>
												<?php } ?>
                                                <li><b>Additional Details: </b><?php echo $post->ref_additionals?></li>
                                               
                                            </ul>
									 </div>
									 
									 </div>
					
					
					
			</div>
                        
