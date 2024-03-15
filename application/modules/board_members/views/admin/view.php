<div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Board Members  </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/board_members/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => ' board_members Staff')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/board_members' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => ' board_members')), 'class="btn btn-primary"');?> 
             	<?php echo anchor('admin/board_members/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive board_members' , 'class="btn btn-warning"'); ?>	
                </div>
                </div>
         	                     
               
				   <div class="block-fluid">
		
                 
				 
                   <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <div class="uprofile-image">
										  <?php
											if (!empty($post->file)):
												 
											?> 
											<image src="<?php echo base_url('uploads/files/' . $post->file); ?>" width="200" height="200" class="img-polaroid  img-thumbnail" >
										   
											<?php else: ?>   
													 <image src="<?php echo base_url('uploads/files/member.png'); ?>" width="200" height="200" class="img-polaroid img-thumbnail" >
											<?php endif; ?>  
                                           
                                        </div>
                                        <div class="uprofile-name">
                                            <h3>
                                               <?php   echo $post->title?> <?php echo $post->first_name.' '.$post->last_name?>
                                                <!-- Available statuses: online, idle, busy, away and offline -->
                                                <span class="uprofile-status online"></span>
                                            </h3>
                                           
                                           
                                        </div>
                                         
                                    </div>
									 <div class="col-md-4 col-sm-4 col-xs-12">
									 <h3>Personal Details</h3>
									  <div class="uprofile-info">
									 <ul class="list-unstyled">
                                               
                                                <li><b>Gender: </b><?php echo $post->gender?></li>
                                                
									             <li><b>Phone: </b><?php echo $post->phone?></li>
                                                <li><b>Email: </b><?php echo $post->email?></li>
												
                                                <li><b>Position </b><?php $pos = $this->ion_auth->populate('positions','id','name'); echo $pos [$post->position];?> </li>
                                                <li><b>Work Place </b><?php echo $post->work_place?></li>
                                                <li><b>Date Joined </b><?php echo date('d M y',$post->date_joined);?></li>
                                               
                                            </ul>
									 </div>
									 </div>

									
									 <div class="col-md-4 col-sm-4 col-xs-12" style=" text-align:center">
											  <h3>ID/Passport Copy</h3>
												<?php 
													if($post->national_id){
													 ?>
													  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->national_id); ?>">
													  <embed src="<?php echo base_url('uploads/files/' . $post->national_id); ?>" width="100%" style="min-height:230px;" class="tr_all_hover" type='application/pdf'>
													  </a>
													  
													  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->national_id); ?>"><i class="glyphicon glyphicon-download"></i> Download File</a>
													  <br>
													 <?php }else{ ?>  
														<h5> No ID uploaded at the moment</h5>
													 <?php } ?> 		 
														 
										 </div>
									 
									

									 
									
					</div>
				
					 <div class="col-md-8 col-sm-8 col-xs-12">
					 <hr>
									 <h3> Profile Details</h3>
									 <hr>
									  <div class="uprofile-info">
									     <?php echo $post->profile?>
									 </div>
									 <br>
									 <br>
									 <br>
									 <br>
									 </div>
					
					
			</div>
                        
