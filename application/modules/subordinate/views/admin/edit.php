<section class="box ">
    <div class="panel panel-default"> 
        <header class="panel_header">
            <h2 class="title pull-left"><?php echo ($updType == 'edit') ? 'Edit ' : 'Add '; ?> Staff </h2>
            <div class="actions panel_actions pull-right">
                <?php echo anchor('admin/users/create', '<span><i class="fa fa-plus white"></i> Add Staff Member</span>', 'class="btn btn-success" '); ?> 
                <?php echo anchor('admin/subordinate', '<span><i class="fa fa-list white"></i> All Staff Subordinate' . '</span>', 'class="btn btn-info"'); ?> 
            </div>
        </header>
        <div class="panel-body" style="display: block;">    
            <div class='clearfix'></div>
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
            ?>
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
                    <label class='col-sm-3 control-label' for='gender'>Gender</label>
                    <div class="col-sm-9">
                        <?php
                        $gender = array('' => 'Select Gender', 'Male' => 'Male', 'Female' => 'Female');
                        echo form_dropdown('gender', $gender, (isset($result->gender)) ? $result->gender : '', ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"  placeholder="Member gender"');
                        ?> <i style="color:red"><?php echo form_error('gender'); ?></i>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='dob'>Date of Birth <span class='required'>*</span></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <?php
                            $dt = '';
                            if ($result->dob)
                            {
                                    if ((!preg_match('/[^\d]/', $result->dob)))
                                    {
                                            $dt = date('d M Y', $result->dob);
                                    }
                                    else
                                    {
                                            $dt = $result->dob;
                                    }
                            }
                            echo form_input('dob', $dt, ' class="form-control datepicker" ');
                            ?>
                            <i style="color:red"><?php echo form_error('dob'); ?></i>
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='email'>Religion </label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-group"></i>
                            </span>
                            <?php echo form_input('religion', $result->religion, 'id="religion"  class="form-control" '); ?>
                            <i style="color:red"><?php echo form_error('religion'); ?></i>
                        </div>
                    </div>
                </div>
				
				
                <div class='form-group'>
                    <label class='col-sm-3 control-label' for='marital_status'>Marital Status <span class='required'>*</span></label>
                    <div class="col-sm-9">
                        <?php
                        $items = array('' => '',
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
               
            </div>			
            <div class='col-sm-6'>			
                <h3>Employment Details</h3>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='date_joined'>
                        Date Joined <span class='required'>*</span>
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <?php
                            $jdt = '';
                            if ($result->date_joined)
                            {
                                    if ((!preg_match('/[^\d]/', $result->date_joined)))
                                    {
                                            $jdt = date('d M Y', $result->date_joined);
                                    }
                                    else
                                    {
                                            $jdt = $result->date_joined;
                                    }
                            }
                            echo form_input('date_joined', $jdt, ' class="form-control datepicker" ');
                            ?>
                            <i style="color:red"><?php echo form_error('date_joined'); ?></i>
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                        </div>
                    </div>
                </div>	
				
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='contract_type'>Contract Type <span class='required'>*</span></label><div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list"></i>
                            </span>
                            <?php
                            echo form_dropdown('contract_type', array('' => 'Select') + $contracts, (isset($result->contract_type)) ? $result->contract_type : '', ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"');
                            ?>
                            <i style="color:red"><?php echo form_error('contract_type'); ?></i>
                        </div>
                    </div>
                </div>	
				
				<div class='form-group'>
                    <label class=' col-sm-3 control-label' for='department'>Department <span class='required'>*</span></label><div class="col-sm-9">
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
                    <label class=' col-sm-3 control-label' for='position'>Position <span class='required'>*</span></label><div class="col-sm-9">
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
                    <label class=' col-sm-3 control-label' for='position'>Qualification <span class='required'>*</span></label><div class="col-sm-9">
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
                    <label class='col-sm-3 control-label' for='member_groups'>Add to Group </label>
                    <div class="col-sm-9">
                        <?php
                        echo form_dropdown('member_groups', $groups, (isset($result->group_id)) ? $result->group_id : '', ' id="form-field-select-1"  class="select2-multi-value" data-style="btn-white" data-live-search="true"  placeholder="Member Groups"');
                        ?> <i style="color:red"><?php echo form_error('member_groups'); ?></i>
                    </div>
				</div>
				
				<div class='form-group'>
                    <label class='col-sm-3 control-label' for='salary_status'>Salary Status <span class='required'>*</span></label>
                    <div class="col-sm-9">
                        <?php
                        $items = array('' => 'Select Option',
                            "1" => "Active",
                            "0" => "Inactive",
                           
                        );
                        echo form_dropdown('salary_status', $items, (isset($result->salary_status)) ? $result->salary_status : '', ' id="marital_status_" class="select2-multi-value" data-placeholder="Select Options..." ');
                        ?> <i style="color:red"><?php echo form_error('salary_status'); ?></i>
                    </div>
                </div>
				
                <div class='form-group'>
                    <label class=' col-sm-3 control-label'>
                        Date of Leaving
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <?php
                            $ldt = '';
                            if ($result->date_left > 10000)
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
                <hr>
                <h3>Contact Details</h3>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='phone'>Phone <span class='required'>*</span></label>
                    <div class="col-sm-5">
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
                    <div class="col-sm-5">
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
                    <label class=' col-sm-3 control-label' for='address'>Address </label><div class="col-sm-5">
                        <textarea id="address"  class="autosize-transition ckeditor form-control "  name="address"  /><?php echo set_value('address', (isset($result->address)) ? htmlspecialchars_decode($result->address) : ''); ?></textarea>
                        <i style="color:red"><?php echo form_error('address'); ?></i>
                    </div>
                </div>
                <div class='form-group'>
                    <label class=' col-sm-3 control-label' for='additionals'>Additionals </label><div class="col-sm-5">
                        <textarea id="additionals"  class="autosize-transition ckeditor form-control "  name="additionals"  /><?php echo set_value('additionals', (isset($result->additionals)) ? htmlspecialchars_decode($result->additionals) : ''); ?></textarea>
                        <i style="color:red"><?php echo form_error('additionals'); ?></i>
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
</section>