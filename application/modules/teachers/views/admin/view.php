<div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Teachers Staff </h2>
             <div class="right"> 
             <?php echo anchor('admin/teachers/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Teachers')), 'class="btn btn-primary"'); ?>

			<?php echo anchor('admin/teachers', '<i class="glyphicon glyphicon-list">
                </i> Teachers Grid View', 'class="btn btn-success"'); ?> 
				
        <?php echo anchor('admin/teachers/list_view', '<i class="glyphicon glyphicon-list">
                </i> Teachers List View' , 'class="btn btn-info"'); ?>
				
                </div>
                </div>
         	                     
               
				   <div class="block-fluid">
		
                 
				 
                   <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="uprofile-image">
										  <?php
											if (!empty($post->passport)):
												 
											?> 
											<image src="<?php echo base_url('uploads/files/' . $post->passport); ?>" width="180" height="180" class="img-polaroid img-thumbnail" >
										   
											<?php else: ?>   
													 <image src="<?php echo base_url('uploads/files/member.png'); ?>" width="180" height="180" class="img-polaroid img-thumbnail" >
											<?php endif; ?>  
                                           
                                        </div>
                                        <div class="uprofile-name">
								<h4>
									<?php echo $post->first_name.' '.$post->middle_name.' '.$post->last_name?>
									<!-- Available statuses: online, idle, busy, away and offline -->
									<br>
									<br>
									<p><?php echo anchor('admin/teachers/assign/', '<i class="glyphicon glyphicon-file"> </i> Assign Units' , 'class="btn btn-success btn-sm"'); ?></p>
									<span class="uprofile-status online"></span>
									<hr>
					
					
					<a  class="btn btn-warning btn-sm" onClick="return confirm('Are you sure you want to send login credentials to <?php echo $post->first_name;?>')" href='<?php echo site_url('admin/teachers/send_logins/' . $post->id . '/' . $page); ?>'><i class='glyphicon glyphicon-share'></i> SMS Logins</a>
					
					<a  class="btn btn-danger btn-sm" onClick="return confirm('Are you sure you want to send login credentials to <?php echo $post->first_name;?>')" href='<?php echo site_url('admin/teachers/email_logins/' . $post->id . '/' . $page); ?>'><i class='glyphicon glyphicon-envelope'></i> Email Logins</a>
					
					
								</h4>
                                           
                                           
                                        </div>
                                         
                                    </div>
									 <div class="col-md-3 col-sm-3 col-xs-12">
									 <h4>Personal Details</h4>
									  <div class="uprofile-info">
									 <ul class="list-unstyled">
                                               
                                                <li><b>Gender: </b><?php echo $post->gender?></li>
                                                <li><b>Birthday: </b><?php  if(!empty($post->dob)) echo date('d M Y',$post->dob);?></li>
                                                <li><b>Marital Status </b><?php echo $post->marital_status?></li>
                                                <li><b>ID/Passport No.:</b><?php echo $post->id_no?></li>
												  <li><b>PIN No.: </b><?php echo $post->pin?></li>
                                                <li><b>Religion: </b><?php echo $post->religion?></li>
                                                <li><b>Disability: </b><?php echo $post->disability?></li>
                                                <li><b>Disability Type: </b><?php echo $post->disability_type?></li>
                                               
												
                                            </ul>
									 </div>
									 <br>
									  <h4> Specialized Subjects</h4>
									  <?php echo $post->subjects?>
									 </div>

									 <div class="col-md-3 col-sm-3 col-xs-12">
									 <h4> Contacts Details</h4>
									  <div class="uprofile-info">
									 <ul class="list-unstyled">
									             <li><b>Citizenship: </b><?php $country = $this->portal_m->populate('countries','id','name');  echo $country[$post->citizenship]?></li>
                                                <li><b>Home County: </b>
												<?php $counties = $this->portal_m->populate('counties','id','name'); echo isset($counties[$post->county]) ? $counties[$post->county] : '';?></li>
									             <li><b>Phone: </b><?php echo $post->phone?></li>
									             <li><b>Phone2: </b><?php echo $post->phone2?></li>
                                                <li><b>Email: </b><?php echo $post->email?></li>
												
                                                <li><b>Address </b><?php echo $post->address?></li>
                                                <li><b>Additional / Former Schools </b><br><?php echo $post->additionals?></li>
											
                                            </ul>
									 </div>
									 
									 </div>

									 <div class="col-md-3 col-sm-3 col-xs-12">
									 <h4>Employment Details</h4>
									  <div class="uprofile-info">
									 <ul class="list-unstyled">
											   <li><b>TSC Employee: </b><?php echo $post->tsc_employee?></li>
											   <li><b>TSC Number: </b><?php echo $post->tsc_number?></li>
											   <li><b>KUPPET Member : </b><?php echo $post->kuppet_member?></li>
											   <li><b>KUPPET Number : </b><?php echo $post->kuppet_number?></li>
											   <li><b>KNUT Member : </b><?php echo $post->knut_member?></li>
											   <li><b>KNUT Number : </b><?php echo $post->knut_number?></li>
											   <li><b>Staff Number: </b><?php echo $post->staff_no?></li>
                                                <li><b>Date Employed: </b><?php  if(!empty($post->date_joined)) echo date('d M Y',$post->date_joined);?></li>
                                                <li><b>Contract type: </b>
												<?php $contracts = $this->ion_auth->populate('contracts','id','name'); 
												echo isset($contracts[$post->contract_type]) ? $contracts[$post->contract_type] :'';?>
												</li>
                                                <li><b>Position: </b> <?php echo $post->position?></li>
                                                <li><b>Qualification:</b> <?php echo $post->qualification?></li>	
                                              
                                            </ul>
									 </div>
									 
									 </div>
									
					</div>
					
					 <div class="col-sm-12"><hr></div>
					 
					  <div class="col-md-3 col-sm-3 col-xs-12" >
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
									 
									 
					 <div class="col-md-3 col-sm-3 col-xs-12" style=" text-align:center">
						  <h3>ID/Passport Copy </h3>
							<?php 
								if($post->id_document){
								 ?>
								  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->id_document); ?>">
								  <embed src="<?php echo base_url('uploads/files/' . $post->id_document); ?>" width="100%" style="min-height:230px;" class="tr_all_hover" type='application/pdf'>
								  </a>
								  
								  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->id_document); ?>"><i class="glyphicon glyphicon-download"></i> Download File</a>
								  <br>
								 <?php }else{ ?>  
									<h5> No ID uploaded at the moment</h5>
								 <?php } ?> 		 
									 
					 </div>
					 
					 <div class="col-md-3 col-sm-3 col-xs-12" style=" text-align:center">
						  <h3>TSC letter</h3>
							<?php 
								if($post->tsc_letter){
								 ?>
								  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->tsc_letter); ?>">
								  <embed src="<?php echo base_url('uploads/files/' . $post->tsc_letter); ?>" width="100%" style="min-height:230px;" class="tr_all_hover" type='application/pdf'>
								  </a>
								  
								  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->tsc_letter); ?>"><i class="glyphicon glyphicon-download"></i> Download File</a>
								  <br>
								 <?php }else{ ?>  
									<h5> No letter uploaded at the moment</h5>
								 <?php } ?> 		 
									 
					 </div>
					 
					 <div class="col-md-3 col-sm-3 col-xs-12" style=" text-align:center">
						  <h3>Credential Cert</h3>
							<?php 
								if($post->credential_cert){
								 ?>
								  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->credential_cert); ?>">
								  <embed src="<?php echo base_url('uploads/files/' . $post->credential_cert); ?>" width="100%" style="min-height:230px;" class="tr_all_hover" type='application/pdf'>
								  </a>
								  
								  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $post->credential_cert); ?>"><i class="glyphicon glyphicon-download"></i> Download File</a>
								  <br>
								 <?php }else{ ?>  
									<h5> No credential certificate uploaded at the moment</h5>
								 <?php } ?> 		 
									 
					 </div>

									
					
					
					
			</div>
                        
