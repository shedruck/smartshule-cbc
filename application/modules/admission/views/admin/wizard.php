<div class="">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Admission  </h2>
        <div class="right"> 
            <?php echo anchor('admin/admission/create', '<i class="glyphicon glyphicon-plus">
                </i> New Admission ', 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Admission')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/admission/inactive/', '<i class="glyphicon glyphicon-question-sign"></i> Inactive Students', 'class="btn btn-warning"'); ?>
        </div>
    </div>
    <!--javascript:notify('Wizard','Form #wizard_validate submited')-->
    <div class="block-fluid">
        <form action="javascript:function(){}" method="POST" id="wizard_validate">

            <fieldset title="Student Details">                            
                <legend>Biodata</legend>
				
				 <div class="col-md-12"><hr></div>
			 
			 <div class="col-md-12">
			 <div class="col-md-2"></div>
			 <div class="col-md-6">
			       <div class="form-group">
						<div class="col-md-4"><strong> Student UPI Number: </strong> </div>
						<div class="col-md-8">
							<?php echo form_input('upi_number', $result->upi_number, 'class="validate[minSize[5]]"'); ?>
							
						</div>
					</div>
					</div>
			 </div>
			 
			  <div class="col-md-12"><hr></div>
				
				
			<div class="col-md-12">
			  <div class="col-md-6">
				 <div class = "form-group">
                            <div class = "col-md-5">Student Passport Photo</div>
                            <div class = "col-md-7">
                                <?php
                                echo form_upload('userfile', '', 'id="userfile" ');
                                echo form_input('photo', '', ' readonly="readonly" style="display:none" class="col-md-8" id="sphoto" ');
                                ?>
                            </div>
                        </div>
                   </div>
				    <div class="col-md-6">
					<div class='form-group'>
     							<div class="col-sm-5">Upload Birth Certificate</div>
								 <div class="col-sm-7">
								  
									<?php
									echo form_upload('birth_certificate', '', 'id="b_cert" ');
									echo form_input('birth_certificate', '', ' readonly="readonly" style="display:none" class="col-md-8" id="birth_certificate" ');
								?>
								</div>
							</div>
							
					
                   </div>
                </div>
				
				<div class="row">
				<div class="col-md-12">
				 <div class="col-md-6">
				 
				   <div class='form-group'>
                            <div class="col-md-3" for='boarding_day'>Boarding / Day Scholar <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php $dis = array('Day'=>'Day Scholar','Boarding'=>'Boarding');
								echo form_dropdown('boarding_day', $dis, (isset($result->boarding_day)) ? $result->boarding_day : '', ' class="" ');
                                ?>
                            </div>
                        </div>
				 
                <div class="form-group">
                    <div class="col-md-3">First Name: <span class='required'>*</span></div>
                    <div class="col-md-8">
                        <?php echo form_input('first_name', $result->first_name, 'class="validate[required,minSize[2]]"'); ?>
                        <span class="bottom">Required, minSize = 2</span>
                    </div>
                
                </div>

				<div class="form-group">
                    <div class="col-md-3">Middle Name: </div>
                    <div class="col-md-8">
                        <?php echo form_input('middle_name', $result->middle_name, 'class=""'); ?>
                    </div>
                
                </div>
                <div class="form-group">
                    <div class="col-md-3">Last Name: <span class='required'>*</span></div>
                    <div class="col-md-8">
                        <?php echo form_input('last_name', $result->last_name, 'class="validate[required,minSize[2]]"'); ?>
                        <span class="bottom">Required, minSize = 2</span>
                    </div>
                </div>                                
                <div class="form-group">
                    <div class="col-md-3">Date of Birth: <span class='required'>*</span></div>
                    <div class="col-md-8">
                        <div id="datetimepicker1" class="input-group date form_datetime">
                            <?php echo form_input('dob', $result->dob > 0 ? date('d M Y', $result->dob) : $result->dob, 'class=" form-control datepicker col-md-12"'); ?>
                            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                           
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3">Gender: </div>
                    <div class="col-md-8"> 
                        <?php
                        $st = '';
                        if ($result->gender == 1)
                        {
                                $st = 'checked="checked"';
                        }
                        $sf = '';
                        if ($result->gender == 2)
                        {
                                $sf = 'checked="checked"';
                        }
                        ?>
                        <div class = "radio"> <input type = "radio"  <?php echo $st; ?> name = "gender" class = "validate" value = "1"> </div>Male
                        <div class = "radio"> <input type = "radio" <?php echo $sf; ?> name = "gender" value = "2" class = "validate"> </div>Female
                    </div>
                </div>

				  <div class='form-group'>
                            <div class="col-md-3" for='student_status'>Student Status </div>
                            <div class="col-md-8">
                                <?php $st = array('Both Parents Alive'=>'Both Parents Alive','Total Orphan'=>'Total Orphan','Single Mother'=>'Single Mother','Single Father'=>'Single Father','Unknown'=>'Unknown');
								
								echo form_dropdown('student_status', $st, (isset($result->student_status)) ? $result->student_status : '', ' class="" ');
                                ?>
                            </div>
                        </div>

						<div class='form-group'>
                            <div class="col-md-3" for='disabled'>Special Need </div>
                            <div class="col-md-8">
                                <?php $dis = array('No'=>'No','Yes'=>'Yes');
								echo form_dropdown('disabled', $dis, (isset($result->disabled)) ? $result->disabled : '', ' class="" ');
                                ?>
                            </div>
                        </div>
						
						  <div class="form-group">
								<div class="col-md-3">Allergies:</div>
								<div class="col-md-8">
									<textarea name="allergies" class=""><?php echo isset($result) && !empty($result) ? $result->allergies : $this->input->post('allergies'); ?></textarea>
								
								</div>
							</div>
						
						<div class='form-group'>
                            <div class="col-md-3" for='blood_group'>Blood Group </div>
                            <div class="col-md-8">
                                <?php 
								$dis = array(''=>'Select Option',
								'O-positive'=>'O-positive',
								'O-negative'=>'O-negative',
								'A-positive'=>'A-positive',
								'A-negative'=>'A-negative',
								'B-positive'=>'B-positive',
								'B-negative'=>'B-negative',
								'AB-positive'=>'AB-positive',
								'AB-negative'=>'AB-negative',
								);
								echo form_dropdown('blood_group', $dis, (isset($result->blood_group)) ? $result->blood_group : '', ' class="" ');
                                ?>
                            </div>
                        </div>
						
					<!---
						<div class='form-group' style="display:none">
                            <div class="col-md-3" for='sub_county'>Emergency Phone </div>
                            <div class="col-md-8">
                                <?php 
								  echo form_input('emergency_phone', $result->emergency_phone, 'class="validate[minSize[10]] mask_mobile" id="smail" placeholder="Optional"');
                                ?>
                            </div>
                        </div>
						
						<div class='form-group' style="display:none">
                            <div class="col-md-3" for='student_phone'>Student Phone</div>
                            <div class="col-md-8">
                                <?php 
								  echo form_input('student_phone', $result->student_phone, 'class="validate[minSize[10]] mask_mobile" id="smail" placeholder="Optional"');
                                ?>
                                  <span class="bottom">Example: 0720002002 </span>
                            </div>
                        </div>
				-->		
						
						
						
						
						
						
						
</div>
<div class="col-md-6">
 
 
              <div class='form-group'>
                            <div class="col-md-3" for='citizenship'>Citizenship</div>
                            <div class="col-md-8">
                                <?php $country = $this->portal_m->populate('countries','id','name');
								
								echo form_dropdown('citizenship', array('114'=>'Kenya')+$country, (isset($result->citizenship)) ? $result->citizenship : '', ' class="select col-sm-8 " ');
                                ?>
                            </div>
							 <div class="col-md-1"></div>
                        </div>

                   <div class='form-group'>
                            <div class="col-md-3" for='county'> County</div>
                            <div class="col-md-8">
                                <?php $counties = $this->portal_m->populate('counties','id','name');
								
								echo form_dropdown('county', array(''=>'Select County')+$counties, (isset($result->county)) ? $result->county : '', ' class="select col-sm-12" ');
                                ?>	
                            </div>
                        </div>

              <div class='form-group'>
                            <div class="col-md-3" for='sub_county'>Sub County </div>
                            <div class="col-md-8">
                                <?php $dis = array('No'=>'No','Yes'=>'Yes');
								
								 echo form_input('sub_county', $result->sub_county, 'class="" id="smail" placeholder="Optional"');
                                ?>
                            </div>
                        </div>
						
						 <div class="form-group">
							<div class="col-md-3">Residence</div>
							<div class="col-md-8">
								<?php echo form_input('residence', $result->residence, 'class=""'); ?>
							   
							</div>
						</div> 
					
						
						

              <div class='form-group'>
                            <div class="col-md-3" for='blood_group'>Religion</div>
                            <div class="col-md-8">
                               <?php
									 $items = array(
											 'Christian' => 'Christian',
											 'Muslim' => 'Muslim',
											 'Hindu' => 'Hindu',
											 'Buddhist' => 'Buddhist',
											 'Others' => 'Others',
									 );
									 echo form_dropdown('religion', $items, (isset($result->religion)) ? $result->religion : '', ' class="form-control" data-placeholder="Select Options..." ');
									 ?>
									 <?php echo form_error('religion'); ?>
                            </div>
                        </div>

              <div class = "form-group">
                    <div class = "col-md-3">Student's E-mail: </div>
                    <div class = "col-md-8"> 
                        <?php
                        $addi = $updType == 'edit' ? '' : ',ajax[ajaxUserCallPhp]';
                        echo form_input('email', $result->email, 'class="validate[custom[email] ' . $addi . ']" id="smail" placeholder="Optional"');
                        ?>
                        <span class="bottom">Valid email - Will be used to Login</span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3">Former school:</div>
                    <div class="col-md-8">
                        <?php echo form_input('former_school', $result->former_school, 'class=""'); ?>
                       
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-md-3">Entry marks:</div>
                    <div class="col-md-8">
                        <?php echo form_input('entry_marks', $result->entry_marks, 'class=""'); ?>
                       
                    </div>
                </div> 
              
                <div class="form-group">
                    <div class="col-md-3">Doctor's Name:</div>
                    <div class="col-md-8">
                        <?php echo form_input('doctor_name', $result->doctor_name, ''); ?>
                       
                    </div>
                </div>
				
                <div class="form-group">
                    <div class="col-md-3">Doctor's Phone:</div>
                    <div class="col-md-8">
                        <?php echo form_input('doctor_phone', $result->doctor_phone, ''); ?>
                       
                    </div>
                </div>  
                <div class="form-group">
                    <div class="col-md-3">Preferred Hospital:</div>
                    <div class="col-md-8">
                        <?php echo form_input('hospital', $result->hospital, 'class=""'); ?>
                       
                    </div>
                </div> 

              </div>	

<div class="col-md-12">
			   <h4>Scholarship/Sponsorship</h4>
			 </div>
             <div class="col-md-12">
             <div class="col-md-6">
			          
						<div class='form-group'>
                            <div class="col-md-3" for='citizenship'>Scholarship </div>
                            <div class="col-md-8">
                                <?php $tems = array('No'=>'No','Yes'=>'Yes');
								
								echo form_dropdown('scholarship',$tems, (isset($result->scholarship)) ? $result->scholarship : '', ' class=" col-sm-12 " ');
                                ?>
                            </div>
							 <div class="col-md-1"></div>
                        </div>
						
						<div class='form-group'>
                            <div class="col-md-3" for='scholarship_type'>Type</div>
                            <div class="col-md-8">
                                <?php $types = array('Government'=>'Government','Organization'=>'Organization','Individual'=>'Individual','Others'=>'Others');
								
								echo form_dropdown('scholarship_type', array(''=>'Select Option')+$types, (isset($result->scholarship_type)) ? $result->scholarship_type : '', ' class=" col-sm-12" ');
                                ?>	
                            </div>
                        </div>
						
						
						  <div class="form-group">
                            <div class="col-md-3">Sponsor details </div>
                            <div class="col-md-8">
							 <textarea name="sponsor_details" class=" col-sm-12" placeholder="E.g Equity Bank, KCB, 072......."></textarea>
                            </div>
                        </div>
						
						  </div>
						<div class="col-sm-6">
						
						  <div class="form-group">
							<div class="col-md-3">Phone: </div>
							<div class="col-md-8">
								<?php echo form_input('sponsor_phone', $result->sponsor_phone, 'class="form-control" style="margin-left:18px;" '); ?>
							  
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-3">Location: </div>
							<div class="col-md-8">
								<?php echo form_input('sponsor_location', $result->sponsor_location, 'class="form-control" style="margin-left:18px;" '); ?>
							  
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-3">Contact Person: </div>
							<div class="col-md-8">
								<?php echo form_input('sponsor_contact_person', $result->sponsor_contact_person, 'class="form-control" style="margin-left:18px;" '); ?>
							  
							</div>
						</div>
						
                        </div>
						
                  </div>			  
		</div> 				
		</div> 				

            </fieldset>

            <fieldset title="Parent Details">
                <legend>Address & Contact </legend>
                <div class="form-group" id="swtch">
                    <div class="col-md-3">Parent:</div>
                    <div class="col-md-6"> 
                        <div class = "radio"> <input type = "radio" id="pnew"  name = "ptype" class = "validate[required] " <?php echo $updType == 'edit' ? 'disabled="disabled" ' : ''; ?> value = "1"> </div>New Parent
                        <div class = "radio"> <input type = "radio" id="pexists" name = "ptype" value = "2" class = "validate[required]" <?php echo $updType == 'edit' ? 'disabled="disabled" ' : ''; ?>> </div>Existing Parent
                    </div>
                </div>

                <div id="pdrop" style="display: none;">
                    <div class='form-group'>
                        <div class="col-md-3" for='parent_id'>Select Parent <span class='required'>*</span></div>
                        <div class="col-md-4">

                            <?php echo form_dropdown('parent_id', $parents, (isset($result->parent_id)) ? $result->parent_id : '', ' class="select" ');
                            ?><span class="bottom">Required</span>	
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 style="text-align:center"> 1st Parent's Details</h3>
						
						<div class='form-group'>
     							<div class="col-sm-4">Passport Photo</div>
								 <div class="col-sm-8">
								  
									 <?php
									echo form_upload('parent_photo', '', 'id="f_photo" ');
									echo form_input('father_photo', '', ' readonly="readonly" style="display:none" class="col-md-8" id="father_photo" ');
								?>
								</div>
							</div>
							
							<div class='form-group'>
     							<div class="col-sm-4">National ID Copy</div>
								 <div class="col-sm-8">
								  
								 <?php
									echo form_upload('parent_id_copy', '', 'id="f_id_copy" ');
									echo form_input('father_id_copy', '', ' readonly="readonly" style="display:none" class="col-md-8" id="father_id_copy" ');
								?>
								</div>
							</div>

							<div class='form-group'>
									<div class="col-md-3" for='blood_group'>Title </div>
									<div class="col-md-7">
									  <?php echo form_input('f_title', isset($pero) && !empty($pero) ? $pero->f_title : $this->input->post('f_title'), 'class="" placeholder="E.g Hon Eng, Dr, Mr, Mrs"'); ?>
									   <?php echo form_error('f_title');?>
									</div>
                             </div>	
						<div class='form-group'>
									<div class="col-md-3" for='blood_group'>Relation </div>
									<div class="col-md-8">
									   <?php
									$rels = array(
										"Father" => "Father",
										"Mother" => "Mother",
										"Brother" => "Brother",
										"Sister" => "Sister",
										"Grandparent" => "Grandparent",
										"Uncle" => "Uncle",
										"Auntie" => "Auntie",                               
										"Guardian" => "Guardian",
									);
									echo form_dropdown('f_relation', $rels, $this->input->post('f_relation'), 'id="frels1" class="validate[required] form-control" data-placeholder="Select Options..." ');
									echo form_error('f_relation');
									?>
									</div>
                             </div>
							 
                        <div class="form-group">
                            <div class="col-md-3"> First Name:<span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_fname', isset($pero) && !empty($pero) ? $pero->first_name : $this->input->post('parent_fname'), 'class="validate[required,minSize[1]]"'); ?>
                               
                            </div>
                        </div>
						<div class="form-group">
							<div class="col-md-3">Middle Name: </div>
							<div class="col-md-8">
								<?php echo form_input('f_middle_name', $pero->f_middle_name, 'class=""'); ?>
							</div>
						
						</div>
                        <div class="form-group">
                            <div class="col-md-3"> Last Name:<span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_lname', isset($pero) && !empty($pero) ? $pero->last_name : $this->input->post('parent_lname'), 'class="validate[required,minSize[1]]"'); ?>
                              
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="col-md-3" for='parent_email'> Email </div>
                            <div class="col-md-8">
                                <?php echo form_input('parent_email', isset($pero) && !empty($pero) ? $pero->email : $this->input->post('parent_email'), 'id="parent_email"  class="form-control" '); ?>
                               
                            </div>
                        </div>
                        <input style="display:none" class="mask_mobile" >    
                        <div class='form-group'>
                            <div class="col-md-3" for='phone'> Phone <span class='required'>*</span></div>
                            <div class="col-md-8">
                                <?php echo form_input('phone', isset($pero) && !empty($pero) ? $pero->phone : $this->input->post('phone'), 'id="phone"  class="form-control validate[required,minSize[10]] mask_mobile" '); ?>
                                <span class="bottom">Example: 0720-002-002 </span>
                            </div>
                        </div>
						
						 <div class="form-group">
                                <div class="col-md-3"> ID/Passport:</div>
                                <div class="col-md-8">
                                    <?php echo form_input('f_id', isset($pero) && !empty($pero) ? $pero->f_id : $this->input->post('f_id'), 'class=""'); ?>
                                   
                                </div>
                            </div>

                        <div class="form-group">
                            <div class="col-md-3"> Occupation:</div>
                            <div class="col-md-8">
                                <?php echo form_input('occupation', isset($pero) && !empty($pero) ? $pero->occupation : $this->input->post('occupation'), 'class=""'); ?>
                               
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3"> Address:</div>
                            <div class="col-md-8">
                                <textarea name="address" class=""><?php echo isset($pero) && !empty($pero) ? $pero->address : $this->input->post('address'); ?></textarea>
                               
                            </div>
                        </div>  
						
						 <div class="form-group">
                            <div class="col-md-3"> Postal Code:</div>
                            <div class="col-md-8">
                                <?php echo form_input('f_postal_code', isset($pero) && !empty($pero) ? $pero->f_postal_code : $this->input->post('f_postal_code'), 'class=""'); ?>
                               
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h3> 2nd Parent/Guardian</h3>
						
						<div class='form-group'>
     							<div class="col-sm-4">Passport Photo</div>
								 <div class="col-sm-8">
								  
									 <?php
									echo form_upload('parent_photo', '', 'id="m_photo" ');
									echo form_input('mother_photo', '', ' readonly="readonly" style="display:none" class="col-md-8" id="mother_photo" ');
								?>
								</div>
							</div>
							
							
							<div class='form-group'>
     							<div class="col-sm-4">National ID Copy</div>
								 <div class="col-sm-8">
								  
								 <?php
									echo form_upload('parent_id_copy', '', 'id="m_id_copy" ');
									echo form_input('mother_id_copy', '', ' readonly="readonly" style="display:none" class="col-md-8" id="mother_id_copy" ');
								?>
								</div>
							</div>
							
							
								<div class='form-group'>
									<div class="col-md-3" for='blood_group'>Title </div>
									<div class="col-md-8">
									
									 <?php echo form_input('m_title', isset($pero) && !empty($pero) ? $pero->m_title : $this->input->post('m_title'), 'class="" placeholder="E.g Hon Eng, Dr, Mr, Mrs"'); ?>
									   <?php echo form_error('m_title');?>
									   
									  
									</div>
                             </div>
							<div class='form-group'>
							     <div class="col-md-3" for='blood_group'>Relation </div>
									<div class="col-md-8">
									   <?php
									$rels = array(
										''=>'Select Option',
										"Mother" => "Mother",
										"Father" => "Father",
										"Brother" => "Brother",
										"Sister" => "Sister",
										"Grandparent" => "Grandparent",
										"Uncle" => "Uncle",
										"Auntie" => "Auntie",                               
										"Guardian" => "Guardian",
									);
									echo form_dropdown('m_relation', $rels, $this->input->post('m_relation'), 'class="form-control" data-placeholder="Select Options..." ');
									echo form_error('m_relation');
									?>
									</div>
                             </div>
							
                        <div class="form-group">
                            <div class="col-md-3"> First Name: </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_fname', isset($pero) && !empty($pero) ? $pero->mother_fname : $this->input->post('mother_fname'), 'class=""'); ?>
                                
                            </div>
                        </div>
						
						<div class="form-group">
							<div class="col-md-3">Middle Name: </div>
							<div class="col-md-8">
								<?php echo form_input('m_middle_name', $pero->m_middle_name, 'class=""'); ?>
							</div>
						
						</div>
						
                        <div class="form-group">
                            <div class="col-md-3"> Last Name: </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_lname', isset($pero) && !empty($pero) ? $pero->mother_lname : $this->input->post('mother_lname'), 'class=""'); ?>
                               
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="col-md-3" for='parent_email'> Email  </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_email', isset($pero) && !empty($pero) ? $pero->mother_email : $this->input->post('mother_email'), 'id="mother_email"  class=" form-control" '); ?>
                               
                            </div>
                        </div>
                        <input style="display:none" class="mask_mobile" >    
                        <div class='form-group'>
                            <div class="col-md-3" for='phone'> Phone </div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_phone', isset($pero) && !empty($pero) ? $pero->mother_phone : $this->input->post('mother_phone'), 'id="mother_phone"  class="form-control  mask_mobile" '); ?>
                                <span class="bottom">Example: 0720-002-002 </span>

                            </div>
                        </div>
						
						<div class="form-group">
                                <div class="col-md-3"> ID/Passport:</div>
                                <div class="col-md-8">
                                    <?php echo form_input('m_id', isset($pero) && !empty($pero) ? $pero->m_id : $this->input->post('m_id'), 'class=""'); ?>
                                   
                                </div>
                            </div>

                        <div class="form-group">
                            <div class="col-md-3"> Occupation:</div>
                            <div class="col-md-8">
                                <?php echo form_input('mother_occupation', isset($pero) && !empty($pero) ? $pero->mother_occupation : $this->input->post('mother_occupation'), 'class=""'); ?>
                               
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3"> Address:</div>
                            <div class="col-md-8">
                                <textarea name="mother_address" class=""><?php echo isset($pero) && !empty($pero) ? $pero->mother_address : $this->input->post('mother_address'); ?></textarea>
                               
                            </div>
                        </div> 
						
						 <div class="form-group">
                            <div class="col-md-3"> Postal Code:</div>
                            <div class="col-md-8">
                                <?php echo form_input('m_postal_code', isset($pero) && !empty($pero) ? $pero->m_postal_code : $this->input->post('m_postal_code'), 'class=""'); ?>
                               
                            </div>
                        </div>
						
                    </div>

                </div>

<div class="col-md-12">
					   <h4>Emergency Contact Details</h4>
					 </div>
						
					 <div class="col-md-12">
				          <div class='form-group'>
						        <input name="ec_id" value="<?php echo $ec->id?>" style="display:none">
								<div class="col-md-3" for='name'>Name </div>
								<div class="col-md-3">
									<?php echo form_input('contact_name' ,$ec->name , 'id="name_"  class="form-control " placeholder="First_name"' );?>
									<?php echo form_error('contact_name'); ?>
								</div>
								<div class="col-md-3">
									<?php echo form_input('contact_m_name' ,$ec->middle_name , 'id="name_"  class="form-control " placeholder="Middle Name"' );?>
									<?php echo form_error('contact_m_name'); ?>
								</div>
								<div class="col-md-3">
									<?php echo form_input('contact_l_name' ,$ec->last_name , 'id="name_"  class="form-control " placeholder="Last Name"' );?>
									<?php echo form_error('contact_l_name'); ?>
								</div>
							
							</div>

							<div class='form-group'>
								<div class="col-md-3" for='relation'>Relation </div>
									<div class="col-md-6">
									<?php $re_rels = array(
												"" => "Select Option",
												"Brother" => "Brother",
												"Sister" => "Sister",
												"Grandparent" => "Grandparent",
												"Uncle" => "Uncle",
												"Auntie" => "Auntie",                               
												"Guardian" => "Guardian",
												"Others" => "Others",
											);	
										 echo form_dropdown('contact_relation', $re_rels,  (isset($ec->relation)) ? $ec->relation : ''     ,   ' class="chzn-select " data-placeholder="Select Options..." ');
										 echo form_error('contact_relation'); ?>
									</div>
							  </div>

							<div class='form-group'>
								<div class="col-md-3" for='phone'>Phone </div>
									<div class="col-md-6">
										<?php echo form_input('contact_phone' ,$ec->phone , 'id="phone_"  class="form-control validate[minSize[10]] mask_mobile" ' );?>
										<?php echo form_error('contact_phone'); ?>
									</div>
							</div>

							<div class='form-group'>
								<div class="col-md-3" for='email'>Email </div><div class="col-md-6">
									<?php echo form_input('contact_email' ,$ec->email , 'id="email_"  class="form-control" ' );?>
									<?php echo form_error('contact_email'); ?>
							     </div>
							</div>
							
							<div class='form-group'>
								<div class="col-md-3" for='email'>ID Number </div><div class="col-md-6">
								<?php echo form_input('contact_id' ,$ec->id_no , 'id="email_"  class="form-control" ' );?>
								<?php echo form_error('contact_id'); ?>
							</div>
							</div>
							<!--
							<div class='form-group'>
							  <div class="col-md-3" for='email'>Address </div>
								  <div class="col-md-6">
									<textarea id="contact_address"   name="contact_address"  placeholder="E.g 456 458 - 00100, Nairobi, Kenya" /><?php echo set_value('contact_address', (isset($ec->address)) ? htmlspecialchars_decode($ec->address) : ''); ?></textarea>
									<?php echo form_error('contact_address'); ?>
								</div>
							</div>
                      -->
							
							<div class='form-group'>
								<div class="col-md-3" for='pb'>Info Provided By </div><div class="col-md-6">
								<?php echo form_input('contact_provided_by' ,$ec->provided_by , 'id="email_"  class="form-control" ' );?>
								<?php echo form_error('contact_provided_by'); ?>
							</div>
							</div>
							
							
				       </div>


                <div id="newp" <?php echo $updType == 'edit' ? '' : ' style="display: none;"'; ?>>



                    <input style="display:none" class="mask_mobile" >    
                    <div class='form-group'>
                        <div class="col-md-3" for='phone'></div>
                        <div class="col-md-4">

                        </div>
                    </div>


                </div>
            </fieldset>


            <fieldset title="Registration Details">
                <legend>Admission Details</legend>

                <div class="form-group">
                    <div class="col-md-3">Date of Admission:</div>
                    <div class="col-md-4">
                        <div id="datetimepicker1" class="input-group date form_datetime">
                            <?php echo form_input('admission_date', $result->admission_date > 0 ? date('d M Y', $result->admission_date) : $result->admission_date, 'class="validate[required] datepicker"'); ?>
                            <span class="input-group-addon "><i class="glyphicon glyphicon-calendar "></i></span></div>
                        <span class="bottom">Required, date</span>
                    </div>
                </div>

                <div class='form-group'>
                    <div class="col-md-3" for='class'>Class <span class='required'>*</span></div>
                    <div class="col-md-4">
                        <?php
                        $classes = $this->ion_auth->fetch_classes();
                        echo form_dropdown('class', array('' => 'Select Class') + $classes, (isset($result->class)) ? $result->class : '', ' class="select" data-placeholder="Select  Options..." ');
                        ?>		
                    </div>
                </div>

                <div class='form-group' style="">
                    <div class="col-md-3" for='stream'>Current Admission No.</div>
                    <div class="col-md-4">
                        <?php echo form_input('old_adm_no', $result->admission_number, 'class="validate[minSize[2]]"'); ?>
                    </div>
                </div>
                <div class='form-group' style="">
                    <div class="col-md-3" for='stream'>Student House</div>
                    <div class="col-md-4">
                        <?php
                        echo form_dropdown('house', $house, (isset($result->house)) ? $result->house : '', ' class="select" ');
                        ?>	
                    </div>
                </div>

            </fieldset>


            <?php
            if ($updType == 'edit')
            {
                    ?>
                    <span id='opr' title="<?php echo $rec; ?>"> </span>
            <?php } ?>
            <input type="submit" title="<?php echo $updType; ?>" id="ad_finish" class="btn btn-primary finish submit" value="Submit" />
            <?php if ($updType == 'edit'): ?>
                    <?php echo form_hidden('pid', $pid); ?>
            <?php endif ?>
            <?php echo form_close(); ?>

            <div class="clearfix"></div>
    </div>
</div>


<script>
        $(document).ready(
                function ()
                {
                    $('#swtch input[type="radio"]').on('click', function ()
                    {
                        var pt = $(this).attr('value');
                        if (pt == 1)
                        {
                            $('#pdrop').hide();
                            $('#newp').show();
                        }
                        if (pt == 2)
                        {
                            $('#newp').hide();
                            $('#pdrop').show();
                        }

                    });
                    $('#trswtch input[type="radio"]').on('click', function ()
                    {
                        var pt = $(this).attr('value');
                        if (pt == 1)
                        {
                            if ($("#tram_val").length > 0)
                            {
                                $('#tram_val').remove();
                            }
                            $('#trswtch span[class="bottom"]').after('<input name="tramount" type="text" class="validate[required]" id="tram_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount"  />')
                        }
                        if (pt == 0)
                        {
                            if ($("#tram_val").length > 0)
                            {
                                $('#tram_val').remove();
                            }
                        }

                    });

                    $('#smswtch input[type="radio"]').on('click', function ()
                    {
                        var pt = $(this).attr('value');
                        if (pt == 1)
                        {
                            if ($("#sm_val").length > 0)
                            {
                                $('#sm_val').remove();
                            }
                            $('#smswtch span[class="bottom"]').after('<input name="smamount" type="text" class="validate[required]" id="sm_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount"  />')
                        }
                        if (pt == 0)
                        {
                            if ($("#sm_val").length > 0)
                            {
                                $('#sm_val').remove();
                            }
                        }

                    });

                    $('#bdswtch input[type="radio"]').on('click', function ()
                    {
                        var pt = $(this).attr('value');
                        if (pt == 1)
                        {
                            if ($("#bd_val").length > 0)
                            {
                                $('#bd_val').remove();
                            }
                            $('#bdswtch span[class="bottom"]').after('<input name="bdamount" type="text" class="validate[required]" id="bd_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount"  />')
                        }
                        if (pt == 0)
                        {
                            if ($("#bd_val").length > 0)
                            {
                                $('#bd_val').remove();
                            }
                        }

                    });

                    $('#mlswtch input[type="radio"]').on('click', function ()
                    {
                        var pt = $(this).attr('value');
                        if (pt == 1)
                        {
                            if ($("#ml_val").length > 0)
                            {
                                $('#ml_val').remove();
                            }
                            $('#mlswtch span[class="bottom"]').after('<input name="mlamount" type="text" class="validate[required]" id="ml_val" style="opacity:100; float:left; width:140px; height:32px; display:block; placeholder="amount" />')
                        }
                        if (pt == 0)
                        {
                            if ($("#ml_val").length > 0)
                            {
                                $('#ml_val').remove();
                            }
                        }

                    });

                    $('input#userfile').ajaxfileupload({
                        'action': BASE_URL + 'admin/admission/save_photo/',
                        'params': {
                            'extra': 'info'
                        },
                        'onComplete': function (response) {
                            console.log(response);
                            if (response.status !== 'error')
                            {
                                //alert(response.status);
                                $('#files').html('<p>' + response.status + '.</p>');
                                $('#sphoto').val(response.pid);
                            }
                            //alert(JSON.stringify(response));
                        },
                        'onStart': function () {
                            //   if (weWantedTo)
                            //    return false; // cancels upload
                        },
                        'onCancel': function () {
                            console.log('no file selected');
                        }
                    });
					
					
					$('input#b_cert').ajaxfileupload({
						//alert('passport');
                        'action': BASE_URL + 'admin/admission/upload_certs/',
                        'params': {
                            'extra': 'info'
                        },
                        'onComplete': function (response)
                        {
                            console.log(response);
                            if (response.status !== 'error')
                            {
                                //alert(response.status);
                                $('#files').html('<p>' + response.status + '.</p>');
                                $('#birth_certificate').val(response.pid);
                            }
                            //alert(JSON.stringify(response));
                        },
                        'onStart': function ()
                        {
                            //   if (weWantedTo)
                            //    return false; // cancels upload
                        },
                        'onCancel': function ()
                        {
                            console.log('no file selected');
                        }
                    });
					
					$('input#f_photo').ajaxfileupload({
						//alert('passport');
                        'action': BASE_URL + 'admin/admission/save_parents_photo/',
                        'params': {
                            'extra': 'info'
                        },
                        'onComplete': function (response)
                        {
                            console.log(response);
                            if (response.status !== 'error')
                            {
                                //alert(response.status);
                                $('#files').html('<p>' + response.status + '.</p>');
                                $('#father_photo').val(response.pid);
                            }
                            //alert(JSON.stringify(response));
                        },
                        'onStart': function ()
                        {
                            //   if (weWantedTo)
                            //    return false; // cancels upload
                        },
                        'onCancel': function ()
                        {
                            console.log('no file selected');
                        }
                    });

					$('input#m_photo').ajaxfileupload({
						//alert('passport');
                        'action': BASE_URL + 'admin/admission/save_parents_photo/',
                        'params': {
                            'extra': 'info'
                        },
                        'onComplete': function (response)
                        {
                            console.log(response);
                            if (response.status !== 'error')
                            {
                                //alert(response.status);
                                $('#files').html('<p>' + response.status + '.</p>');
                                $('#mother_photo').val(response.pid);
                            }
                            //alert(JSON.stringify(response));
                        },
                        'onStart': function ()
                        {
                            //   if (weWantedTo)
                            //    return false; // cancels upload
                        },
                        'onCancel': function ()
                        {
                            console.log('no file selected');
                        }
                    });
					
					
					//********* National IDs Upload ************/

					$('input#m_id_copy').ajaxfileupload({
						//alert('passport');
                        'action': BASE_URL + 'admin/admission/upload_id_copies/',
                        'params': {
                            'extra': 'info'
                        },
                        'onComplete': function (response)
                        {
                            console.log(response);
                            if (response.status !== 'error')
                            {
                                //alert(response.status);
                                $('#files').html('<p>' + response.status + '.</p>');
                                $('#mother_id_copy').val(response.pid);
                            }
                            //alert(JSON.stringify(response));
                        },
                        'onStart': function ()
                        {
                            //   if (weWantedTo)
                            //    return false; // cancels upload
                        },
                        'onCancel': function ()
                        {
                            console.log('no file selected');
                        }
                    });
					
					
					$('input#f_id_copy').ajaxfileupload({
						//alert('passport');
                        'action': BASE_URL + 'admin/admission/upload_id_copies/',
                        'params': {
                            'extra': 'info'
                        },
                        'onComplete': function (response)
                        {
                            console.log(response);
                            if (response.status !== 'error')
                            {
                                //alert(response.status);
                                $('#files').html('<p>' + response.status + '.</p>');
                                $('#father_id_copy').val(response.pid);
                            }
                            //alert(JSON.stringify(response));
                        },
                        'onStart': function ()
                        {
                            //   if (weWantedTo)
                            //    return false; // cancels upload
                        },
                        'onCancel': function ()
                        {
                            console.log('no file selected');
                        }
                    });
					

                });


</script>