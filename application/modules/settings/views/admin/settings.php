<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Institution Settings  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/settings/add_new/', '<i class="glyphicon glyphicon-plus"></i> Update Details', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/settings' , '<i class="glyphicon glyphicon-list">
                </i> Institution Details', 'class="btn btn-primary"');?> 
             
                </div>
                </div>


    <div class="block-fluid">

				
				<div class="row">
				<div class="col-md-12">
				
				 <div class='form-group'>
					<div class="col-md-5  strong  strong" for='document'></div>
					
					<div class="col-md-7">
					  <img src="<?php echo base_url('uploads/files/' . $result->document); ?>" width="100" height="100">
					</div>
				</div>

				                     
                <h3>Institution Details</h3>
				 <div class="col-md-6">
				 
				   <div class='form-group'>
                            <div class="col-md-4  strong" for='boarding_day'>School Name </div>
                            <div class="col-md-8">
                                <?php echo  $result->school;?>
                            </div>
                    </div>
					
					<div class='form-group'>
                            <div class="col-md-4  strong" for='boarding_day'>Registration Number </div>
                            <div class="col-md-8">
                               <?php echo $reg->registration_no ?>
                            </div>
                    </div>
					
					<div class='form-group'>
                            <div class="col-md-4  strong" for='boarding_day'>School Code </div>
                            <div class="col-md-8">
                               <?php echo $result->school_code ?>
                            </div>
                    </div>
						
				   <div class='form-group'>
                            <div class="col-md-4  strong" for='date_reg'>Registration Date </div>
                            <div class="col-md-8">
							 <?php echo date('d M Y',$reg->date_reg) ?>
								  
								 
                                </div>
                            </div>
                 
				 
                <div class="form-group">
                    <div class="col-md-4  strong">Institution Category</div>
                    <div class="col-md-8">
                       <?php echo $reg->institution_category; ?>	
                       
                    </div>
                
                </div>
				
				<div class="form-group">
                    <div class="col-md-4  strong">Institution Cluster </div>
                    <div class="col-md-8">
                       <?php echo isset($reg->institution_cluster) ? $reg->institution_cluster : ''; ?>	
                        
                    </div>
                </div>
				
                <div class="form-group">
                    <div class="col-md-4  strong">County: </div>
                    <div class="col-md-8">
                       <?php $counties = $this->portal_m->populate('counties','id','name');
								
							echo isset($counties[$reg->county]) ? $counties[$reg->county] : '';?>	
                    </div>
                </div> 
				
				<div class='form-group'>
					<div class="col-md-4  strong" for='sub_county'>Sub County </div>
					<div class="col-md-8">
					   <?php echo $reg->sub_county;	?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4  strong" for='ward'>Ward </div>
					<div class="col-md-8">
					   <?php  echo $reg->ward ?>
					</div>
				</div>
				
				 		
</div>
<div class="col-md-6">

            <div class="form-group">
                    <div class="col-md-4  strong">Institution Type </div>
                    <div class="col-md-8">
                       <?php
							echo isset($reg->institution_type) ? $reg->institution_type : '';?>	
                        
                    </div>
                </div>

             <div class="form-group">
                    <div class="col-md-4  strong">Education System: </div>
                    <div class="col-md-8">
                       <?php echo isset($reg->education_system) ? $reg->education_system : '';?>	
                    </div>
                </div>


               <div class="form-group">
                    <div class="col-md-4  strong">Education Level </div>
                    <div class="col-md-8">
                       <?php echo isset($reg->education_level) ? $reg->education_level : '';?>	
                        
                    </div>
                </div>

               <div class='form-group'>
					<div class="col-md-4  strong" for='knec_code'>KNEC Code </div>
					<div class="col-md-8">
					   <?php
						  echo  $reg->knec_code;
						?>
					</div>
				</div>
				
				<div class="form-group">
                    <div class="col-md-4  strong">Institution Accommodation</div>
                    <div class="col-md-8">
                       <?php
							
							echo isset($reg->institution_accommodation) ? $reg->institution_accommodation : '';
							?>	
                        
                    </div>
                </div>
				
				 <div class="form-group">
                    <div class="col-md-4  strong">Scholars Gender </div>
                    <div class="col-md-8">
                       <?php
							
							echo isset($reg->scholars_gender) ? $reg->scholars_gender : '';
							?>	
                        
                    </div>
                </div>
                
				 <div class='form-group'>
					<div class="col-md-4  strong" for='knec_code'>Locality </div>
					<div class="col-md-8">
					   <?php
						
							echo isset($reg->locality) ? $reg->locality : '';
						?>
					</div>
				</div>
				
				 <div class='form-group'>
					<div class="col-md-4  strong" for='knec_code'>KRA PIN </div>
					<div class="col-md-8">
					   <?php
						  echo $reg->kra_pin;
						?>
					</div>
				</div>
              

              </div>				
		</div> 				
		</div> 				

                <div class="col-md-12">
				 <h3>Ownership Details </h3>
                    <div class="col-md-6">
                       
						
				   <div class='form-group'>
						<div class="col-md-4  strong" for='knec_code'>Ownership </div>
						<div class="col-md-8">
						   <?php
							
								echo isset($own->ownership) ? $own->ownership : '';
							?>
						</div>
					</div>
						
				 <div class='form-group'>
					<div class="col-md-4  strong" for='knec_code'>Owner Details (Private) </div>
					<div class="col-md-8">
					   <?php
						  echo $own->proprietor;
						?>
					</div>
				</div>
				
				<div class='form-group'>
						<div class="col-md-4  strong" for='knec_code'>Ownership Type </div>
						<div class="col-md-8">
						   <?php
							
								echo isset($own->ownership_type) ? $own->ownership_type : '';
							?>
						</div>
					</div>
				 <div class='form-group'>
					<div class="col-md-4  strong" for='knec_code'>Incorporation Certificate No. </div>
					<div class="col-md-8">
					   <?php
						  echo $own->certificate_no;
						?>
					</div>
				</div>	
						
							

                    </div>
                    <div class="col-md-6">
                      
						 <div class='form-group'>
							<div class="col-md-4  strong" for='knec_code'>Nearest Town </div>
							<div class="col-md-8">
							   <?php
								  echo $own->town;
								?>
							</div>
						</div>
						
						<div class='form-group'>
							<div class="col-md-4  strong" for='knec_code'>Nearest Police Station </div>
							<div class="col-md-8">
							   <?php
								  echo$own->police_station;
								?>
							</div>
						</div>

						<div class='form-group'>
							<div class="col-md-4  strong" for='knec_code'>Nearest Health Facility </div>
							<div class="col-md-8">
							   <?php
								  echo $own->health_facility;
								?>
							</div>
						</div>
				
						
                    </div>

                </div>


        
               
				
				<div class="col-md-12">
				   <h3>Contacts Details</h3>
                    <div class="col-md-6">
					
                  <div class='form-group'>
            <div class="col-md-4 strong" for='postal_addr'>Address </div><div class="col-md-8">
                <?php
                echo $result->postal_addr;
                ?>
            </div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4 strong" for='email'>Email </div><div class="col-md-8">
						<?php echo $result->email; ?>
						
					</div>
				</div>
				<div class='form-group'>
					<div class="col-md-4 strong" for='email'>Telephone(landlines) </div><div class="col-md-8">
						<?php echo $result->tel; ?>
					</div>
				</div>
				<div class='form-group'>
					<div class="col-md-4 strong" for='email'>Cell Numbers </div><div class="col-md-8">
						<?php echo  $result->cell; ?>
					</div>
				</div>
				
					<div class='form-group'>
					<div class="col-md-4  strong" for='fax'>Fax </div><div class="col-md-8">
						<?php echo $result->fax; ?>
					</div>
				</div>
		
				
				</div>
				
				<div class="col-md-6">
				
				
				<div class='form-group'>
					<div class="col-md-4  strong" for='website'>Website </div><div class="col-md-8">
						<?php echo $result->website; ?>
					
					</div>
				</div>
			
				
				 <div class='form-group'>
							<div class="col-md-4  strong" for='knec_code'>Social Media Links </div>
							<div class="col-md-8">
							   <?php
								  echo $result->social_network;
								?>
							</div>
						</div>
				
				<div class='form-group'>
					<div class="col-md-4 strong" for='email'>School Motto </div><div class="col-md-8">
						<?php echo isset($result->motto) ? htmlspecialchars_decode($result->motto) : ''; ?>
					</div>
				</div>
				
				<div class='form-group'>
						<div class="col-md-4  strong" for='knec_code'>Vision </div>
						<div class="col-md-8">
						  <?php echo isset($result->vision) ? htmlspecialchars_decode($result->vision) : ''; ?>
								
						</div>
					</div>
						
				 <div class='form-group'>	
							<div class="col-md-4 strong" >Mission</div>
								<div class="col-md-8">
							    <?php echo $result->mission; ?>
							</div>
					</div>
				
				
				   </div>
				</div>
				
				<div class="row">
				<div class="col-sm-12">
				<hr>
				</div>
				
				<div class="col-sm-6">
					
					
					<div class='form-group'>
							<div class="col-md-4  strong  strong" for='school_code'>Employees Time In </div><div class="col-md-8">
								<?php echo $result->employees_time_in; ?>
								
							</div>
						</div>
						<div class='form-group'>
							<div class="col-md-4  strong  strong" for='school_code'>Employees Time Out </div><div class="col-md-8">
								<?php echo $result->employees_time_out; ?>
								
							</div>
						</div>
						
						 <div class='form-group'>
							<div class="col-md-4  strong  strong" for='pre_school'>Use Remarks for Pre-School</div><div class="col-md-8">
								<?php
							
								echo isset($result->pre_school) ? $result->pre_school : '';
							
								?>
							</div>
						</div>
						
						 <div class='form-group'>
							<div class="col-md-4  strong  strong" for='prefix'>Admission No. Prefix</div>
							<div class="col-md-8">
								<?php
								echo isset($result->prefix) ? $result->prefix : '';
								
								?>
							</div>
						</div>
						<div class='form-group'>
							<div class="col-md-4  strong  strong" for='relief'>Tax Relief</div>
							<div class="col-md-8">
								<?php
								echo isset($result->relief) ? $result->relief : '';
							
								?>
							</div>
						</div>
						
						
					
					</div>
					<div class="col-sm-6">
					
					<div class='form-group'>
						<div class="col-md-4  strong  strong" for='list_size'>Default Lists Size </div>
						<div class="col-md-8">
							<?php
							
							echo isset($result->list_size) ? $result->list_size : '';
							
							?>
						</div>
					</div>
					<div class='form-group'>
						<div class="col-md-4  strong  strong" for='message_initial'>Default Message Initial </div><div class="col-md-8">
							<?php echo $result->message_initial; ?>
						</div>
					</div>
					<div class='form-group'>
						<div class="col-md-4  strong  strong" for='currency'>Default Currency </div><div class="col-md-8">
							<?php echo $result->currency; ?>
						</div>
					</div>
					
					  <div class='form-group'>
						<div class="col-md-4  strong  strong" for='mobile_pay'>Mobile Payment Info </div>
						<div class="col-md-8">
							<?php
							  echo $result->mobile_pay;
							?>
							
						</div>
					</div>
					
					 <div class='form-group'>
						<div class="col-md-4  strong  strong" for='school_code'>Default SMS Sender ID </div><div class="col-md-8">
							<?php echo $result->sender_id; ?>
							
						</div>
					</div>
					
					</div>	
					
				
					
					
						<div class='form-group'>	
						
							<div class="col-md-12" >Map Location</div>
								<div class="col-md-12">
							       <?php echo isset($result->map) ? htmlspecialchars_decode($result->map) : ''; ?>
						        
							</div>
					</div>
					
					</div>	
 <div class='col-md-6'>
                <h3>Upload Documents</h3>

				
				<div class='form-group'>
					<div class="col-md-5  strong  strong" for='ownership_doc'>Ownership Document </div>
					<div class="col-md-7">
						
					<?php if ($docs->ownership_doc): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->ownership_doc); ?>' >Download actual file </a>
					<?php endif ?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-5  strong  strong" for='institution_cert'>Institution Certificate </div>
					<div class="col-md-7">
						<?php if ($docs->institution_cert): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->institution_cert); ?>' >Download actual file </a>
					
						<?php endif ?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-5  strong  strong" >Incorporation Certificate </div>
					<div class="col-md-7">
						<?php if ($docs->incorporation_doc): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->incorporation_doc); ?>' >Download actual file </a>
					
						<?php endif ?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-5  strong  strong" >Ministry Approval </div>
					<div class="col-md-7">
						<?php if ($docs->ministry_approval): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->ministry_approval); ?>' >Download actual file </a>
					
						<?php endif ?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-5  strong  strong" >Title Deed </div>
					<div class="col-md-7">
						<?php if ($docs->title_deed): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->title_deed); ?>' >Download actual file </a>
					     <?php endif ?>
						
					</div>
				</div>
		</div>
		
		
		<div class='col-md-6'>
                <h3>Contact Person</h3>

				 <div class='form-group'>
					<div class="col-md-4  strong  strong" for='document'>Name </div>
					
					<div class="col-md-8">
					<?php echo $contacts->name;?>
					</div>
				</div>

				<div class='form-group'>
					<div class="col-md-4  strong  strong" for='ownership_doc'>Designation </div>
					<div class="col-md-8">
					   <?php echo $contacts->designation;?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4  strong  strong" for='institution_cert'>Phone </div>
					<div class="col-md-8">
						 <?php echo $contacts->phone;?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4  strong  strong" >Email </div>
					<div class="col-md-8">
						 <?php echo $contacts->email;?>
					</div>
				</div>
				
				
		</div>


            <div class="clearfix"></div>
    </div>
</div>

