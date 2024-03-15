 <div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  Supporting Staff </h2>
             <div class="right"> 
                <?php echo anchor('admin/subordinate/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Staff')), 'class="btn btn-primary"'); ?>

			<?php echo anchor('admin/subordinate', '<i class="glyphicon glyphicon-list">
                </i> Staff Grid View', 'class="btn btn-success"'); ?> 
				
        <?php echo anchor('admin/subordinate/list_view', '<i class="glyphicon glyphicon-list">
                </i> Subordinate List View' , 'class="btn btn-info"'); ?>
				<?php echo anchor('admin/subordinate/inactive', '<i class="glyphicon glyphicon-list">
                </i> Inactive Staff' , 'class="btn btn-warning"'); ?>		
			
       </div>
 </div>
         	                    
   <div class="block-fluid">

        <div class="panel-body" style="display: block;">    
            <div class='clearfix'></div>
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
            ?>
			
			<div class='col-sm-6'>	
			      <div class='form-group'>
                    <label class=' col-sm-4 control-label' for='passport'>Upload Passport Photo </label>
					<div class="col-sm-5">
                    
                            	<input id='passport' type='file' name='passport'  <?php //if($updType == 'create'){ echo 'required="required';} ?>/>
							<br/><i style="color:red"><?php echo form_error('passport'); ?></i>
							<?php  echo ( isset($upload_error['passport'])) ?  $upload_error['passport']  : ""; ?>
							
						</div>
						<div class="col-md-3">
								<?php if ($updType == 'edit'): ?>
								<img src='<?php echo base_url()?>uploads/files/<?php echo $result->passport?>' height="40" width="40"/>
								<?php endif ?>

								<br/><?php echo form_error('passport'); ?>
								<?php  echo ( isset($upload_error['passport'])) ?  $upload_error['passport']  : ""; ?>
							</div>
					</div>
					</div>
					<div class='col-sm-6'>	
					<div class='form-group'>
                    <label class=' col-sm-4 control-label' for='id_doc'>National ID Copy </label>
					<div class="col-sm-8">
                        
                            	<input id='id_document' type='file' name='id_document'  <?php //if($updType == 'create'){ echo 'required="required';} ?>/>
							<i style="color:red"><?php echo form_error('id_document'); ?></i>
							<?php  echo ( isset($upload_error['id_document'])) ?  $upload_error['id_document']  : ""; ?>
							
								<?php if ($updType == 'edit'): ?>
								<a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $result->id_document?>'> Download Actual File </a>
								<?php endif ?>

							<?php echo form_error('id_document'); ?>
								<?php  echo ( isset($upload_error['id_document'])) ?  $upload_error['id_document']  : ""; ?>
							</div>
					</div>
                </div>
				
				 <div class='col-sm-12'>	<hr></div>	
			
            <div class='col-sm-6'>	
                <h3>Personal Details</h3>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='first_name'>First Name <span class='required'>*</span></label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            <?php echo form_input('first_name', $result->first_name, 'id="first_name_"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('first_name'); ?></i>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='middle_name'>Middle Name </label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user-following"></i>
                            </span>
                            <?php echo form_input('middle_name', $result->middle_name, 'id="middle_name_"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('middle_name'); ?></i>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='last_name'>Last Name <span class='required'>*</span></label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            <?php echo form_input('last_name', $result->last_name, 'id="last_name_"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('last_name'); ?></i>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='col-sm-3 control-label' for='gender'>Gender </label>
                    <div class="col-sm-9">
                        <?php
                        $gender = array('' => 'Select Gender', 'Male' => 'Male', 'Female' => 'Female');
                        echo form_dropdown('gender', $gender, (isset($result->gender)) ? $result->gender : '', ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"  placeholder="Member gender"');
                        ?> <i style="color:red"><?php echo form_error('gender'); ?></i>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='dob'>Date of Birth </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input id='dob_' type='text' name='dob' maxlength='' class='form-control datepicker' value="<?php echo $result->dob ? date('d M Y',$result->dob) : ''; ?>"  />
                            <i style="color:red"><?php echo form_error('dob'); ?></i>
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='email'>Religion </label><div class="col-sm-9">
                       
                         
                           <?php
                        $items = array('' => 'Select Option',
                            "Christian" => "Christian",
                            "Muslim" => "Muslim",
                            "Hindu" => "Hindu",
                            "Buddhist" => "Buddhist",
                            "Others" => "others",
                        );
                        echo form_dropdown('religion', $items, (isset($result->religion)) ? $result->religion : '', ' id="marital_status_" class="select2-multi-value" data-placeholder="Select Options..." ');
                        ?>
                            <i style="color:red"><?php echo form_error('religion'); ?></i>
                        
                    </div>
                </div>
                <div class='form-group'>
                    <label class='col-sm-3 control-label' for='marital_status'>Marital Status </label>
                    <div class="col-sm-9">
                        <?php
                        $items = array('' => 'Select Option',
                            "Married" => "Married",
                            "Single" => "Single",
                            "Separated" => "Separated",
                            "Divorced" => "Divorced",
                            "Single mom" => "Single Mom",
                            "Single dad" => "Single dad",
                            "Widow" => "Widow",
                            "Widower" => "Widower",
                            "Others" => "others",
                        );
                        echo form_dropdown('marital_status', $items, (isset($result->marital_status)) ? $result->marital_status : '', ' id="marital_status_" class="select2-multi-value" data-placeholder="Select Options..." ');
                        ?> <i style="color:red"><?php echo form_error('marital_status'); ?></i>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='last_name'>ID Number </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-user"></i> </span>
                            <?php echo form_input('id_no', $result->id_no, 'id="id_no"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('id_no'); ?></i>
                        </div>
                    </div>
                </div>
                

            </div>			
            <div class='col-sm-6'>			
                <h3>Employment Details</h3>
				
				 <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='email'>PIN Number </label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list"></i>
                            </span>
                            <?php echo form_input('pin', $result->pin, 'id="pin_"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('pin'); ?></i>
                        </div>
                    </div>
                </div>
				
				
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='date_joined'>
                        Date Joined 
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input id='date_joined_' type='text' name='date_joined' maxlength='' class='form-control datepicker' value="<?php echo $result->date_joined ? date('d M Y',$result->date_joined) : ''; ?>"  />
                            <i style="color:red"><?php echo form_error('date_joined'); ?></i>
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>	
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='contract_type'>Contract Type </label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list"></i>
                            </span>
                            <?php
                            echo form_dropdown('contract_type', array('' => 'Select') +$contracts, (isset($result->contract_type)) ? $result->contract_type : '', ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"');
                            ?>
                            <i style="color:red"><?php echo form_error('contract_type'); ?></i>
                        </div>
                    </div>
                </div>	

				<div class='form-group'>
                    <label class=' col-sm-3 control-label' for='department'>Department </label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list"></i>
                            </span>
                            <?php
                            echo form_dropdown('department', array('' => 'Select') + $departments, (isset($result->department)) ? $result->department : '', ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"');
                            ?>
                            <i style="color:red"><?php echo form_error('department'); ?></i>
                        </div>
                    </div>
                </div>
				
			
               
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='position'>Position </label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-edit"></i>
                            </span>
                            <?php echo form_input('position', $result->position, 'id="position"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('position'); ?></i>
                        </div>
                    </div>
                </div>	
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='position'>Qualification </label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-edit"></i>
                            </span>
                            <?php echo form_input('qualification', $result->qualification, 'id="qualification"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('qualification'); ?></i>
                        </div>
                    </div>
                </div>	
                          
                <div class='form-group'>
                    <label class=' col-sm-3 control-label'>
                        Proposed Leaving Date
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <?php
                            $ldt = '';
                            if ($result->date_left)
                            {
                                    if ((!preg_match('/[^\d]/', $result->date_left)))
                                    {
                                            $ldt = date('d M Y', $result->date_left);
                                    }
                                    else
                                    {
                                            $ldt = $result->date_left;
                                    }
                            }
                            echo form_input('date_left', $ldt, ' class="form-control datepicker" ');
                            ?>
                            <i style="color:red"><?php echo form_error('date_left'); ?></i>
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>	
            </div>	
          
		   <div class="col-sm-12">
            <div class="col-sm-6">	
                <hr>
                <h3>Contact Details</h3>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='phone'>Phone <span class='required'>*</span></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-phone-square"></i>
                            </span>
                            <?php echo form_input('phone', $result->phone, 'id="phone"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('phone'); ?></i>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='email'>Email </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <?php echo form_input('email', $result->email, 'id="email_"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('email'); ?></i>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='address'>Address </label><div class="col-sm-9">
                        <textarea id="address"  class="autosize-transition ckeditor form-control "  placeholder="E.g 123 456 - 00100, Nairobi, Kenya"  name="address"  /><?php echo set_value('address', (isset($result->address)) ? htmlspecialchars_decode($result->address) : ''); ?></textarea>
                        <i style="color:red"><?php echo form_error('address'); ?></i>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='additionals'>Additional </label><div class="col-sm-9">
                        <textarea id="additionals"  class="autosize-transition ckeditor form-control "  name="additionals"  /><?php echo set_value('additionals', (isset($result->additionals)) ? htmlspecialchars_decode($result->additionals) : ''); ?></textarea>
                        <i style="color:red"><?php echo form_error('additionals'); ?></i>
                    </div>
                </div>
            </div>

			<div class="col-sm-6">	
                <hr>
                <h3>Referee Details</h3>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='ref_name'>Full Name </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            <?php echo form_input('ref_name', $result->ref_name, 'id="ref_name"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('ref_name'); ?></i>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='ref_phone'>Phone </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <?php echo form_input('ref_phone', $result->ref_phone, 'id="email_"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('ref_phone'); ?></i>
                        </div>
                    </div>
                </div>
				<div class='form-group'>
                    <label class=' col-sm-3 control-label' for='ref_email'>Email </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <?php echo form_input('ref_email', $result->ref_email, 'id="email_"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('ref_email'); ?></i>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='ref_address'>Address </label><div class="col-sm-9">
                        <textarea id="ref_address"  class="autosize-transition ckeditor form-control " placeholder="E.g 123 456 - 00100, Nairobi, Kenya"  name="ref_address"  /><?php echo set_value('ref_address', (isset($result->ref_address)) ? htmlspecialchars_decode($result->ref_address) : ''); ?></textarea>
                        <i style="color:red"><?php echo form_error('ref_address'); ?></i>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='additionals'>Additional </label><div class="col-sm-9">
                        <textarea id="ref_additionals"  class="autosize-transition ckeditor form-control "  name="ref_additionals"  /><?php echo set_value('ref_additionals', (isset($result->ref_additionals)) ? htmlspecialchars_decode($result->ref_additionals) : ''); ?></textarea>
                        <i style="color:red"><?php echo form_error('ref_additionals'); ?></i>
                    </div>
                </div>
            </div>
            </div>
			
			
            <div class="col-sm-12">
                <hr>
                <div class='form-group'><label class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save Changes', (($updType == 'create') ? "id='submit' class=' btn btn-info''" : "id='submit' class='btn btn-info'")); ?>
                        <?php echo anchor('admin/subordinate', 'Cancel', 'class="btn btn-default btn-shadow"'); ?>
                    </div></div>
                <?php echo form_close(); ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div> 
 
