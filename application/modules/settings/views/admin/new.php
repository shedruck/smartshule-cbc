 <div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Institution Settings  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/settings/add_new/', '<i class="glyphicon glyphicon-plus"></i> Update Details', 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/settings' , '<i class="glyphicon glyphicon-list">
                </i> Institution Details', 'class="btn btn-primary"');?> 
             
                </div>
                </div>
 
 <!--javascript:notify('Wizard','Form #wizard_validate submited')-->
    <div class="block-fluid">
	
	 <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'wizard_validate');
        echo form_open_multipart(current_url(), $attributes);
        ?>
	
            <fieldset title="Institution Details">                            
                <legend>Biodata</legend>
				
				
			<div class="col-md-12">
			     <hr>
			</div>
				
				<div class="row">
				<div class="col-md-12">
				 <div class="col-md-6">
				 
				   <div class='form-group'>
                            <div class="col-md-3" for='boarding_day'>School Name <span class='required'>*</span></div>
                            <div class="col-md-9">
                                <?php echo form_input('school', $result->school, 'id="school_"  class="form-control" '); ?>
                                 <?php echo form_error('school'); ?>
                            </div>
                    </div>
					
					<div class='form-group'>
                            <div class="col-md-3" for='boarding_day'>Registration Number </div>
                            <div class="col-md-9">
                               <?php echo form_input('registration_no', $reg->registration_no, 'id="registration_no"  class="form-control" '); ?>
                             <?php echo form_error('registration_no'); ?>
                            </div>
                    </div>
					
					  <div class='form-group'>
							<div class="col-md-3" for='school_code'>School Code </div><div class="col-md-9">
								<?php echo form_input('school_code', $result->school_code, 'id="school_code_"  class="form-control" '); ?>
								<?php echo form_error('school_code'); ?>
							</div>
						</div>
						
				   <div class='form-group'>
                            <div class="col-md-3" for='date_reg'>Registration Date </div>
                            <div class="col-md-9">
							 <div class="input-group form_dadtetime">
                             <input id='date_reg' type='text' name='date_reg' maxlength='' class='form-control datepicker' value="<?php echo $reg->date_reg ? date('d M Y',$reg->date_reg) : ''; ?>"  />
 	                              <?php echo form_error('date_reg'); ?>
								  
								   <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                  </div>
				 
                <div class="form-group">
                    <div class="col-md-3">Institution Category</div>
                    <div class="col-md-8">
                       <?php
							$items=array(
									'Integrated'=>'Integrated',
									'Regular'=>'Regular',
									'Regular with special units'=>'Regular with special units',
									'Special School'=>'Special School',
									
									);
							echo form_dropdown('institution_category',array(''=>'Select Option')+ $items, (isset($reg->institution_category)) ? $reg->institution_category : '', ' class="select" ');
							?>	
                        <span class="bottom">Required</span>
                    </div>
                
                </div>
				
				<div class="form-group">
                    <div class="col-md-3">Institution Cluster </div>
                    <div class="col-md-8">
                       <?php
							$items=array('County'=>'County','Extra County'=>'Extra County', 'National'=>'National','Primary'=>'Primary','Sub County'=>'Sub County');
							echo form_dropdown('institution_cluster',array(''=>'Select Option')+ $items, (isset($reg->institution_cluster)) ? $reg->institution_cluster : '', ' class="select" ');
							?>	
                        <span class="bottom">Required</span>
                    </div>
                </div>
				
                <div class="form-group">
                    <div class="col-md-3">County: <span class='required'>*</span></div>
                    <div class="col-md-8">
                       <?php $counties = $this->portal_m->populate('counties','id','name');
								
							echo form_dropdown('county', array(''=>'Select County')+$counties, (isset($reg->county)) ? $reg->county : '', ' class="select " ');
						?>	
                    </div>
                </div> 
				
				<div class='form-group'>
					<div class="col-md-3" for='sub_county'>Sub County </div>
					<div class="col-md-9">
					   <?php $dis = array('No'=>'No','Yes'=>'Yes');
						
						  echo form_input('sub_county', $reg->sub_county, 'class="form-control" style="" id="smail" placeholder="Optional"');
						?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-3" for='ward'>Ward </div>
					<div class="col-md-9">
					   <?php $dis = array('No'=>'No','Yes'=>'Yes');
						
						  echo form_input('ward', $reg->ward, 'class="form-control" style="" id="smail" placeholder="Optional"');
						?>
					</div>
				</div>
				
				 		
</div>
<div class="col-md-6">

            <div class="form-group">
                    <div class="col-md-3">Institution Type <span class='required'>*</span></div>
                    <div class="col-md-8">
                       <?php
							$items=array('Public'=>'Public','Private'=>'Private');
							echo form_dropdown('institution_type',array(''=>'Select Option')+ $items, (isset($reg->institution_type)) ? $reg->institution_type : '', ' class="select" ');
							?>	
                        <span class="bottom">Required</span>
                    </div>
                </div>

             <div class="form-group">
                    <div class="col-md-3">Education System: <span class='required'>*</span></div>
                    <div class="col-md-8">
                       <?php 
					         $items = array('8.4.4'=>'8.4.4', 'IGSCE'=>'IGSCE','Both 8.4.4 & IGSCE'=>'Both 8.4.4 & IGSCE','TVET'=>'TVET');
								
							echo form_dropdown('education_system', array(''=>'Select Option')+$items, (isset($reg->education_system)) ? $reg->education_system : '', ' class="select " ');
						?>	
                    </div>
                </div>


               <div class="form-group">
                    <div class="col-md-3">Education Level <span class='required'>*</span></div>
                    <div class="col-md-8">
                       <?php
							$items=array('A-level'=>'A-level','ECDE'=>'ECDE', 'Primary'=>'Primary','Secondary'=>'Secondary','TTC'=>'TTC','TVET'=>'TVET','College'=>'College','University'=>'University');
							echo form_dropdown('education_level',array(''=>'Select Option')+ $items, (isset($reg->education_level)) ? $reg->education_level : '', ' class="select" ');
							?>	
                        <span class="bottom">Required</span>
                    </div>
                </div>

               <div class='form-group'>
					<div class="col-md-3" for='knec_code'>KNEC Code </div>
					<div class="col-md-9">
					   <?php
						  echo form_input('knec_code', $reg->knec_code, 'class="form-control" style="" id="smail" placeholder="Optional"');
						?>
					</div>
				</div>
				
				<div class="form-group">
                    <div class="col-md-3">Institution Accommodation</div>
                    <div class="col-md-8">
                       <?php
							$items=array('Day'=>'Day','Boarding'=>'Boarding', 'Day and Boarding'=>'Day and Boarding');
							echo form_dropdown('institution_accommodation',array(''=>'Select Option')+ $items, (isset($reg->institution_accommodation)) ? $reg->institution_accommodation : '', ' class="select" ');
							?>	
                        <span class="bottom">Required</span>
                    </div>
                </div>
				
				 <div class="form-group">
                    <div class="col-md-3">Scholars Gender </div>
                    <div class="col-md-8">
                       <?php
							$items=array('Boys'=>'Boys','Girls'=>'Girls', 'Mixed'=>'Mixed');
							echo form_dropdown('scholars_gender',array(''=>'Select Option')+ $items, (isset($reg->scholars_gender)) ? $reg->scholars_gender : '', ' class="select" ');
							?>	
                        <span class="bottom">Required</span>
                    </div>
                </div>
                
				 <div class='form-group'>
					<div class="col-md-3" for='knec_code'>Locality </div>
					<div class="col-md-8">
					   <?php
						$items=array('Rural'=>'Rural','Urban'=>'Urban','Semi-Urban'=>'Semi-Urban');
							echo form_dropdown('locality',array(''=>'Select Option')+ $items, (isset($reg->locality)) ? $reg->locality : '', ' class="select" ');
						?>
					</div>
				</div>
				
				 <div class='form-group'>
					<div class="col-md-3" for='knec_code'>KRA PIN </div>
					<div class="col-md-9">
					   <?php
						  echo form_input('kra_pin', $reg->kra_pin, 'class="form-control" style="" id="smail" placeholder="Optional"');
						?>
					</div>
				</div>
              

              </div>				
		</div> 				
		</div> 				

            </fieldset>

            <fieldset title="Institution Ownership">
                <legend>Ownership Details </legend>
                
				<div class="col-md-12">
					 <hr>
				</div>

                <div class="col-md-12">
                    <div class="col-md-6">
                       
						
				   <div class='form-group'>
						<div class="col-md-3" for='knec_code'>Ownership </div>
						<div class="col-md-8">
						   <?php
							$items=array('Government'=>'Government','Mission'=>'Mission','Private'=>'Private');
								echo form_dropdown('ownership',array(''=>'Select Option')+ $items, (isset($own->ownership)) ? $own->ownership : '', ' class="select" ');
							?>
						</div>
					</div>
						
				 <div class='form-group'>
					<div class="col-md-3" for='knec_code'>Owner Details (Private) </div>
					<div class="col-md-9">
					   <?php
						  echo form_input('proprietor', $own->proprietor, 'class="form-control" style="" id="smail" placeholder="Optional"');
						?>
					</div>
				</div>
				
				<div class='form-group'>
						<div class="col-md-3" for='knec_code'>Ownership Type </div>
						<div class="col-md-8">
						   <?php
							$items=array('Lease'=>'Lease','Agreement'=>'Agreement','Title Deed'=>'Title Deed');
								echo form_dropdown('ownership_type',array(''=>'Select Option')+ $items, (isset($own->ownership_type)) ? $own->ownership_type : '', ' class="select" ');
							?>
						</div>
					</div>
				 <div class='form-group'>
					<div class="col-md-3" for='knec_code'>Incorporation Certificate No. </div>
					<div class="col-md-9">
					   <?php
						  echo form_input('certificate_no', $own->certificate_no, 'class="form-control" style="" id="smail" placeholder="Optional"');
						?>
					</div>
				</div>	
						
							

                    </div>
                    <div class="col-md-6">
                      
						 <div class='form-group'>
							<div class="col-md-3" for='knec_code'>Nearest Town </div>
							<div class="col-md-9">
							   <?php
								  echo form_input('town', $own->town, 'class="form-control" style="" id="smail" placeholder="Optional"');
								?>
							</div>
						</div>
						
						<div class='form-group'>
							<div class="col-md-3" for='knec_code'>Nearest Police Station </div>
							<div class="col-md-9">
							   <?php
								  echo form_input('police_station', $own->police_station, 'class="form-control" style="" id="smail" placeholder="Optional"');
								?>
							</div>
						</div>

						<div class='form-group'>
							<div class="col-md-3" for='knec_code'>Nearest Health Facility </div>
							<div class="col-md-9">
							   <?php
								  echo form_input('health_facility', $own->health_facility, 'class="form-control" style="" id="smail" placeholder="Optional"');
								?>
							</div>
						</div>
				
						
                    </div>

                </div>


                <div id="newp" <?php echo $updType == 'add_new' ? '' : ' style="display: none;"'; ?>>

                    <input style="display:none" class="mask_mobile" >    
                    <div class='form-group'>
                        <div class="col-md-3" for='phone'></div>
                        <div class="col-md-4">

                        </div>
                    </div>


                </div>
            </fieldset>


            <fieldset title="Institution Setup">
                <legend>Contacts Details</legend>
				
				<div class="col-md-12">
                    <div class="col-md-6">
					
                  <div class='form-group'>
            <div class="col-md-4" for='postal_addr'>Address <span class='required'>*</span></div><div class="col-md-8">
                <?php
                $data = array(
                    'name' => 'postal_addr',
                    'id' => 'postal_addr_',
                    'value' => $this->input->post('postal_addr') ? $this->input->post('postal_addr') : $result->postal_addr,
                    'rows' => '2',
                    'cols' => '10',
                    'class' => 'form-control',
                );
                echo form_textarea($data);
                ?>
                <?php echo form_error('postal_addr'); ?>
            </div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4" for='email'>Email <span class='required'>*</span></div><div class="col-md-8">
						<?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
						<?php echo form_error('email'); ?>
					</div>
				</div>
				<div class='form-group'>
					<div class="col-md-4" for='email'>Telephone(landlines) </div><div class="col-md-8">
						<?php echo form_input('tel', $result->tel, 'id="tel" placeholder="E.g 020 89758" class="form-control" '); ?>
						<?php echo form_error('tel'); ?>
					</div>
				</div>
				<div class='form-group'>
					<div class="col-md-4" for='email'>Cell Numbers <span class='required'>*</span></div><div class="col-md-8">
						<?php echo form_input('cell', $result->cell, 'id="cell"  placeholder="E.g 0721341214,0720000 etc" class="form-control" '); ?>
						<?php echo form_error('cell'); ?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4" for='fax'>Fax </div><div class="col-md-8">
						<?php echo form_input('fax', $result->fax, 'id="fax_"  class="form-control" '); ?>
						<?php echo form_error('fax'); ?>
					</div>
				</div>
				
				</div>
				
				<div class="col-md-6">
				
				 <div class='form-group'>
					<div class="col-md-4" for='website'>Website </div><div class="col-md-8">
						<?php echo form_input('website', $result->website, 'id="website_"  class="form-control" '); ?>
						<?php echo form_error('website'); ?>
					</div>
				</div>
				
				
				 <div class='form-group'>
							<div class="col-md-4" for='knec_code'>Social Media Links </div>
							<div class="col-md-8">
							   <?php
								  echo form_input('social_network', $result->social_network, 'class="form-control" style="" id="smail" placeholder="Optional"');
								?>
							</div>
						</div>
						
						<div class='form-group'>
					<div class="col-md-4" for='email'>School Motto <span class='required'>*</span></div><div class="col-md-8">
						<textarea name="motto"  rows="3"  class=" motto  validate[required]"  id="motto"><?php echo set_value('motto', (isset($result->motto)) ? htmlspecialchars_decode($result->motto) : ''); ?></textarea>
					</div>
				</div>

						<div class='form-group'>
							<div class="col-md-4" for='knec_code'>Vision </div>
							<div class="col-md-8">
							   <textarea  name="vision" rows="3" placeholder="School Vision" /><?php echo set_value('vision', (isset($result->vision)) ? htmlspecialchars_decode($result->vision) : ''); ?></textarea>
						        	<?php echo form_error('vision'); ?>
							</div>
						</div>
						
						 <div class='form-group'>	
							<div class="col-md-4" >Mission</div>
								<div class="col-md-8">
							        <textarea  name="mission" rows="3" placeholder="School Mission" /><?php echo set_value('mission', (isset($result->mission)) ? htmlspecialchars_decode($result->mission) : ''); ?></textarea>
						        	<?php echo form_error('mission'); ?>
							</div>
					</div>
						
				   </div>
				</div>
				
				<div class="row">
				<div class="col-sm-12">
				<div class="col-sm-6">
		
					<div class='form-group'>
							<div class="col-md-4" for='school_code'>Employees Time In <span class='required'>*</span></div><div class="col-md-8">
								<?php echo form_input('employees_time_in', $result->employees_time_in, 'id="employees_time_in"  class="form-control time_in col-md-12 input_ed timepicker" '); ?>
								<?php echo form_error('employees_time_in'); ?>
							</div>
						</div>
						
						<div class='form-group'>
							<div class="col-md-4" for='school_code'>Employees Time Out <span class='required'>*</span></div><div class="col-md-8">
								<?php echo form_input('employees_time_out', $result->employees_time_out, 'id="employees_time_out"  class="form-control time_in col-md-12 input_ed timepicker" '); ?>
								<?php echo form_error('employees_time_out'); ?>
							</div>
						</div>
						
						 <div class='form-group'>
							<div class="col-md-4" for='pre_school'>Use Remarks for Pre-School<span class='required'>*</span></div><div class="col-md-8">
								<?php
								$ops = array('1' => 'Yes', '0' => 'No');
								echo form_dropdown('pre_school', $ops, (isset($result->pre_school)) ? $result->pre_school : '', ' id="pre_school" class="" ');
								echo form_error('pre_school');
								?>
							</div>
						</div>
						
						 <div class='form-group'>
							<div class="col-md-4" for='prefix'>Admission No. Prefix<span class='required'>*</span></div>
							<div class="col-md-8">
								<?php
								echo form_input('prefix', (isset($result->prefix)) ? $result->prefix : '', ' id="prefix" class="form-control" ');
								echo form_error('prefix');
								?>
							</div>
						</div>
						<div class='form-group'>
							<div class="col-md-4" for='relief'>Tax Relief<span class='required'>*</span></div>
							<div class="col-md-8">
								<?php
								echo form_input('relief', (isset($result->relief)) ? $result->relief : '', ' id="relief" class="form-control" ');
								echo form_error('relief');
								?>
							</div>
						</div>
						
						
					
					</div>
					<div class="col-sm-6">
					
					<div class='form-group'>
						<div class="col-md-4" for='list_size'>Default Lists Size </div>
						<div class="col-md-8">
							<?php
							$tems = array('' => 'Select Option', '10' => '10', '25' => '25', '50' => '50', '100' => '100', '200' => '200', '300' => '300');
							echo form_dropdown('list_size', $tems, (isset($result->list_size)) ? $result->list_size : '', ' id="list_size_" class="" ');
							echo form_error('list_size');
							?>
						</div>
					</div>
					<div class='form-group'>
						<div class="col-md-4" for='message_initial'>Default Message Initial <span class='required'>*</span></div><div class="col-md-8">
							<?php echo form_input('message_initial', $result->message_initial, 'id="message_initial" placeholder=" E.g Hello, Hi, A.A, Habari e.t.c" class="form-control" '); ?>
							<?php echo form_error('message_initial'); ?>
						</div>
					</div>
					<div class='form-group'>
						<div class="col-md-4" for='currency'>Default Currency <span class='required'>*</span></div><div class="col-md-8">
							<?php echo form_input('currency', $result->currency, 'id="currency" placeholder=" E.g Ksh., Tsh., USD, EURO e.t.c" class="form-control" '); ?>
							<?php echo form_error('currency'); ?>
						</div>
					</div>
					
					  <div class='form-group'>
						<div class="col-md-4" for='mobile_pay'>Mobile Payment Info </div>
						<div class="col-md-8">
							<?php
							$arr = array(
								'name' => 'mobile_pay',
								'id' => 'mobile_pay',
								'value' => $this->input->post('mobile_pay') ? $this->input->post('mobile_pay') : $result->mobile_pay,
								'rows' => '2',
								'cols' => '10',
								'class' => 'form-control'
							);
							echo form_textarea($arr);
							?>
							<?php echo form_error('mobile_pay'); ?>
						</div>
					</div>
					
					 <div class='form-group'>
						<div class="col-md-4" for='school_code'>Default SMS Sender ID </div><div class="col-md-8">
							<?php echo form_input('sender_id', $result->sender_id, 'id="school_code_"  class="form-control" '); ?>
							<?php echo form_error('sender_id'); ?>
						</div>
					</div>
					
					</div>	
					
					<div class="row">
						<div class="col-sm-12">
						    <hr>
						</div>	
					</div>	
					
					
						<div class='form-group'>	
						
							<div class="col-md-3" >Map Location</div>
								<div class="col-md-9">
							        <textarea  name="map" style="height:150px;" rows="3" placeholder="Embede Google here" /><?php echo set_value('map', (isset($result->map)) ? htmlspecialchars_decode($result->map) : ''); ?></textarea>
						        	<?php echo form_error('map'); ?>
							</div>
					</div>
					
					
					</div>	
					</div>	

            </fieldset>


			
            <fieldset title="Documents Upload">
             <legend>Upload Documents</legend>
				
				 <div class="row">
				<div class="col-sm-12">
				  <div class='col-md-6'>
				  
				  				 <div class='col-md-12'>
				 
								 <h4>Upload Documents</h4>
								  <hr>
								 </div>
				 
				 
				 <div class='form-group'>
					<div class="col-md-4" for='document'>Institution Logo </div>
					<div class="col-md-4">
						<input id='document' type='file' name='document' />
						
					</div>
					<div class="col-md-4">
					  <img src="<?php echo base_url('uploads/files/' . $result->document); ?>" width="70" height="70">
					</div>
				</div>

				<div class='form-group'>
					<div class="col-md-4" for='ownership_doc'>Ownership Document </div>
					<div class="col-md-8">
						<input id='ownership_doc' type='file' name='ownership_doc' />
						<?php if ($docs->ownership_doc): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->ownership_doc); ?>' >Download actual file </a>
						<?php endif ?>
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4" for='institution_cert'>Institution Certificate </div>
					<div class="col-md-8">
						<input id='institution_cert' type='file' name='institution_cert' />
						<?php if ($docs->institution_cert): ?>
								<a  target="_blank" href='<?php echo base_url('uploads/files/' . $docs->institution_cert); ?>' >Download actual file </a>
						<?php endif ?>
						
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4" >Incorporation Certificate </div>
					<div class="col-md-8">
						<input id='incorporation_doc' type='file' name='incorporation_doc' />
						<?php if ($docs->incorporation_doc): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->incorporation_doc); ?>' >Download actual file </a>
						<?php endif ?>
						
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4" >Ministry Approval </div>
					<div class="col-md-8">
						<input id='ministry_approval' type='file' name='ministry_approval' />
						<?php if ($docs->ministry_approval): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->ministry_approval); ?>' >Download actual file </a>
						<?php endif ?>
						
					</div>
				</div>
				
				<div class='form-group'>
					<div class="col-md-4" >Title Deed </div>
					<div class="col-md-8">
						<input id='title_deed' type='file' name='title_deed' />
						<?php if ($docs->title_deed): ?>
								<a target="_blank" href='<?php echo base_url('uploads/files/' . $docs->title_deed); ?>' >Download actual file </a>
						<?php endif ?>
						
					</div>
				</div>
				</div>
				
				 <div class='col-md-6'>
				<div class='col-md-12'>
				<h4>Contact Person</h4>
				<hr>
				 </div>
				<div class='form-group'>
					<div class="col-md-3" for='name'>Name <span class='required'>*</span></div><div class="col-md-6">
					<?php echo form_input('name' ,$contacts->name , 'id="name_"  class="form-control" ' );?>
					<?php echo form_error('name'); ?>
				</div>
				</div>

				<div class='form-group'>
					<div class="col-md-3" for='phone'>Phone <span class='required'>*</span></div><div class="col-md-6">
					<?php echo form_input('phone' ,$contacts->phone , 'id="phone_"  class="form-control" ' );?>
					<?php echo form_error('phone'); ?>
				</div>
				</div>

				<div class='form-group'>
					<div class="col-md-3" for='designation'>Designation <span class='required'>*</span></div><div class="col-md-6">
					<?php echo form_input('designation' ,$contacts->designation , 'id="designation_"  class="form-control" ' );?>
					<?php echo form_error('designation'); ?>
				</div>
				</div>

				<div class='form-group'>
					<div class="col-md-3" for='email'>Email </div><div class="col-md-6">
					<?php echo form_input('contact_email' ,$contacts->email , 'id="email_"  class="form-control" ' );?>
					<?php echo form_error('contact_email'); ?>
				</div>
				</div>
			</div>
			</div>
			</div>

            </fieldset>


           
            <input type="submit" title="Update Record" id="ad_finish" class="btn btn-primary finish" value="Update Record" />
          
            <?php echo form_close(); ?>

            <div class="clearfix"></div>
    </div>
</div>

