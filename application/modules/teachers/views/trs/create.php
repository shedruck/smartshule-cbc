<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0"><b>Add Teacher</b></h6>
        <div class="float-end">
          <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>

      <div class="card-body p-3">
        <?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal')); ?>

        <!-- Teaching Staff Section -->
        <h5><b>Personal Documents</b></h5>
        <div class="row" style="padding-left:30px">
          <div class="col-xl-6">
            <!-- Passport Photo -->
            <div class="form-group row">
              <label for="passport" class="col-sm-4 col-form-label">Passport Photo</label>
              <div class="col-sm-9">
                <?php
                $passport_value = set_value('passport', isset($result->passport) ? $result->passport : '');
                ?>
                <div class="d-flex align-items-center">
                  <?php echo form_upload(array('name' => 'passport', 'class' => 'form-control flex-grow-1', 'id' => 'passport'), $passport_value); ?>
                  <?php echo form_error('passport', '<span class="text-danger">', '</span>'); ?>
                  <?php if ($updType == 'edit') {
                  ?>
                    <img src="<?php echo base_url('uploads/files/' . $result->passport); ?>" alt="Passport Image" width="50" height="50" class="ms-2">
                  <?php } ?>
                </div>
              </div>
            </div>



            <!-- National ID Copy -->
            <div class="form-group row">
              <label for="id_document" class="col-sm-4 col-form-label">National ID Copy</label>
              <div class="col-sm-9">
                <?php
                $id_document_value = set_value('id_document', isset($result->id_document) ? $result->id_document : '');
                ?>

                <!-- Apply the same format -->
                <div class="d-flex align-items-center">
                  <?php echo form_upload(array('name' => 'id_document', 'class' => 'form-control flex-grow-1', 'id' => 'id_document'), $id_document_value); ?>
                  <?php echo form_error('id_document', '<span class="text-danger">', '</span>'); ?>

                  <?php if ($updType == 'edit') {
                  ?>
                    <img src="<?php echo base_url('uploads/files/' . $result->id_document); ?>" alt="National ID Copy" width="50" height="50" class="ms-2">
                  <?php } ?>

                </div>
              </div>
            </div>

          </div>

          <div class="col-xl-6">
            <!-- Credential Certificate -->
            <div class="form-group row">
              <label for="credential_cert" class="col-sm-4 col-form-label">Credential Certificate</label>
              <div class="col-sm-9">
                <?php
                $credential_cert_value = set_value('credential_cert', isset($result->credential_cert) ? $result->credential_cert : '');
                ?>
                <div class="d-flex align-items-center">
                  <?php echo form_upload(array('name' => 'credential_cert', 'class' => 'form-control flex-grow-1', 'id' => 'credential_cert'), $credential_cert_value); ?>
                  <?php echo form_error('credential_cert', '<span class="text-danger">', '</span>'); ?>

                  <?php if ($updType == 'edit') {
                  ?>
                    <img src="<?php echo base_url('uploads/files/' . $result->credential_cert); ?>" alt="Credential Certificate" width="50" height="50" class="ms-2">
                  <?php } ?>

                </div>
              </div>
            </div>


            <!-- TSC Letter -->
            <div class="form-group row">
              <label for="tsc_letter" class="col-sm-4 col-form-label">TSC Letter</label>
              <div class="col-sm-9">
                <?php
                $tsc_letter_value = set_value('tsc_letter', isset($result->tsc_letter) ? $result->tsc_letter : '');
                ?>

                <div class="d-flex align-items-center">
                  <?php echo form_upload(array('name' => 'tsc_letter', 'class' => 'form-control flex-grow-1', 'id' => 'tsc_letter'), $tsc_letter_value); ?>
                  <?php echo form_error('tsc_letter', '<span class="text-danger">', '</span>'); ?>
                  <?php if ($updType == 'edit') {
                  ?>
                    <img src="<?php echo base_url('uploads/files/' . $result->tsc_letter); ?>" alt="TSC Letter" width="50" height="50" class="ms-2">
                  <?php } ?>

                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Personal Details Section -->
        <h5 class="mt-4"><b>Personal Details</b></h5>
        <div class="row" style="padding-left:30px">
          <div class="col-xl-6">
            <!-- First Name -->
            <div class="form-group row">
              <label for="first_name" class="col-sm-4 col-form-label">First Name <b><span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php echo form_input(array('name' => 'first_name', 'class' => 'form-control', 'id' => 'first_name', 'value' => set_value('first_name', isset($result->first_name) ? $result->first_name : ''))); ?>
                <?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>


            <!-- Middle Name -->
            <div class="form-group row">
              <label for="middle_name" class="col-sm-4 col-form-label">Middle Name</label>
              <div class="col-sm-8">
                <?php echo form_input(array('name' => 'middle_name', 'class' => 'form-control', 'id' => 'middle_name', 'value' => set_value('middle_name', isset($result->middle_name) ? $result->middle_name : ''))); ?>
                <?php echo form_error('middle_name', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>

            <!-- Last Name -->
            <div class="form-group row">
              <label for="last_name" class="col-sm-4 col-form-label">Last Name <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php echo form_input(array('name' => 'last_name', 'class' => 'form-control', 'id' => 'last_name', 'value' => set_value('last_name', isset($result->last_name) ? $result->last_name : ''))); ?>
                <?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>

            <!-- Gender -->
            <div class="form-group row">
              <label for="gender" class="col-sm-4 col-form-label">Gender <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php echo form_dropdown('gender', array('' => 'Select Gender', 'Male' => 'Male', 'Female' => 'Female'), set_value('gender', isset($result->gender) ? $result->gender : ''), 'class="form-control js-example-basic-single" id="gender"'); ?>
                <?php echo form_error('gender', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>

            <!-- Date of Birth -->
            <div class="form-group row">
              <label for="dob" class="col-sm-4 col-form-label">Date of Birth <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <div class="input-group">
                  <div class="input-group-text">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
                  <?php echo form_input('dob', isset($result->dob) ? date('Y-m-d', $result->dob) : '', 'class="form-control datepicker" id="dob" placeholder="Choose date" required'); ?>
                </div>
                <?php echo form_error('dob', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>

            <!-- Status -->
            <div class="form-group row">
              <label for="status" class="col-sm-4 col-form-label">Status <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php
                $status_items = array(
                  1 => "Active",
                  0 => "Inactive",
                ); ?>
                <?php
                echo form_dropdown('status', $status_items, set_value('status', isset($result->status) ? $result->status : ''), 'class="form-control js-example-basic-single" data-placeholder="Select Options..."');
                echo form_error('status', '<div class="text-danger">', '</div>'); ?>
              </div>
            </div>
          </div>

          <div class="col-xl-6">
            <!-- Religion -->
            <div class="form-group row">
              <label for="religion" class="col-sm-4 col-form-label">Religion</label>
              <div class="col-sm-8">
                <?php
                $religion_items = array(
                  '' => 'Select Option',
                  "Christian" => "Christian",
                  "Muslim" => "Muslim",
                  "Hindu" => "Hindu",
                  "Buddhist" => "Buddhist",
                  "Others" => "Others",
                );
                $selected_religion = isset($result->religion) ? $result->religion : '';
                echo form_dropdown('religion', $religion_items, $selected_religion, 'id="religion" class="form-control js-example-basic-single" data-placeholder="Select Options..."');
                ?>

              </div>
            </div>

            <!-- Marital Status -->
            <div class="form-group row">
              <label for="marital_status" class="col-sm-4 col-form-label">Marital Status <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php
                $marital_status_items = array(
                  '' => 'Select Option',
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
                ?>
                <?php echo form_dropdown('marital_status', $marital_status_items, set_value('marital_status', isset($result->marital_status) ? $result->marital_status : ''), 'class="form-control js-example-basic-single" id="marital_status"'); ?>
                <?php echo form_error('marital_status', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>


            <!-- ID Number -->
            <div class="form-group row">
              <label for="id_no" class="col-sm-4 col-form-label">ID Number <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php echo form_input(array('name' => 'id_no', 'class' => 'form-control', 'id' => 'id_no', 'value' => set_value('id_no', isset($result->id_no) ? $result->id_no : ''))); ?>
                <?php echo form_error('id_no', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>

            <!-- PIN Number -->
            <div class="form-group row">
              <label for="pin" class="col-sm-4 col-form-label">PIN Number <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php echo form_input(array('name' => 'pin', 'class' => 'form-control', 'id' => 'pin', 'value' => set_value('pin', isset($result->pin) ? $result->pin : ''))); ?>
                <?php echo form_error('pin', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>

            <!-- Disabled -->
            <div class="form-group row">
              <label for="disability" class="col-sm-4 col-form-label">Disabled <b> <span class='required'>*</span></b></label>
              <div class="col-sm-8">
                <?php echo form_dropdown('disability', array('' => 'Select Option', 'Yes' => 'Yes', 'No' => 'No'), set_value('disability', isset($result->disability) ? $result->disability : ''), 'class="form-control js-example-basic-single" id="disability"'); ?>
                <?php echo form_error('disability', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>

            <!-- Disability Type -->
            <div class="form-group row">
              <label for="disability_type" class="col-sm-4 col-form-label">Disability Type</label>
              <div class="col-sm-8">
                <?php echo form_input(array('name' => 'disability_type', 'class' => 'form-control', 'id' => 'disability_type', 'value' => set_value('disability_type', isset($result->disability_type) ? $result->disability_type : ''))); ?>
                <?php echo form_error('disability_type', '<span class="text-danger">', '</span>'); ?>
              </div>
            </div>


          </div>

          <!-- Employment Details Section -->
          <h5 class="mt-4"><b>Employment Details</b></h5>
          <div class="row" style="padding-left:30px">
            <div class="col-xl-6">
              <!-- TSC Employee -->
              <div class="form-group row">
                <label for="tsc_employee" class="col-sm-4 col-form-label">TSC Employee <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_dropdown('tsc_employee', array('' => 'Select Option', 'Yes' => 'Yes', 'No' => 'No'), set_value('tsc_employee', isset($result->tsc_employee) ? $result->tsc_employee : ''), 'class="form-control js-example-basic-single" id="tsc_employee"'); ?>
                  <?php echo form_error('tsc_employee', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- TSC Number -->
              <div class="form-group row">
                <label for="tsc_number" class="col-sm-4 col-form-label">TSC Number</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'tsc_number', 'class' => 'form-control', 'id' => 'tsc_number', 'value' => set_value('tsc_number', isset($result->tsc_number) ? $result->tsc_number : ''))); ?>
                  <?php echo form_error('tsc_number', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- KNUT Member -->
              <div class="form-group row">
                <label for="knut_member" class="col-sm-4 col-form-label">KNUT Member <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_dropdown('knut_member', array('' => 'Select Option', 'Yes' => 'Yes', 'No' => 'No'), set_value('knut_member', isset($result->knut_member) ? $result->knut_member : ''), 'class="form-control js-example-basic-single" id="knut_member"'); ?>
                  <?php echo form_error('knut_member', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- KNUT Number -->
              <div class="form-group row">
                <label for="knut_number" class="col-sm-4 col-form-label">KNUT Number</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'knut_number', 'class' => 'form-control', 'id' => 'knut_number', 'value' => set_value('knut_number', isset($result->knut_number) ? $result->knut_number : ''))); ?>
                  <?php echo form_error('knut_number', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- KUPPET Member -->
              <div class="form-group row">
                <label for="kuppet_member" class="col-sm-4 col-form-label">KUPPET Member <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_dropdown('kuppet_member', array('' => 'Select Option', 'Yes' => 'Yes', 'No' => 'No'), set_value('kuppet_member', isset($result->kuppet_member) ? $result->kuppet_member : ''), 'class="form-control js-example-basic-single" id="kuppet_member"'); ?>
                  <?php echo form_error('kuppet_member', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- KUPPET Number -->
              <div class="form-group row">
                <label for="kuppet_number" class="col-sm-4 col-form-label">KUPPET Number</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'kuppet_number', 'class' => 'form-control', 'id' => 'kuppet_number', 'value' => set_value('kuppet_number', isset($result->kuppet_number) ? $result->kuppet_number : ''))); ?>
                  <?php echo form_error('kuppet_number', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Subjects Specialized in -->
              <div class="form-group row">
                <label for="subjects" class="col-sm-4 col-form-label">Subjects Specialized in</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'subjects', 'class' => 'form-control', 'id' => 'subjects', 'value' => set_value('subjects', isset($result->subjects) ? $result->subjects : ''))); ?>
                  <?php echo form_error('subjects', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>

            <div class="col-xl-6">

              <!-- Date Employed -->
              <div class="form-group row">
                <label for="date_joined" class="col-sm-4 col-form-label">Date Employed <span class='required'>*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <div class="input-group-text">
                      <iclass="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                    <?php echo form_input('date_joined', isset($result->date_joined) ? date('Y-m-d', $result->date_joined) : '', 'class="form-control datepicker" id="date_joined" placeholder="Choose date" required'); ?>
                  </div>
                  <?php echo form_error('date_joined', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>


              <!-- Contract Type -->
              <div class="form-group row">
                <label for="contract_type" class="col-sm-4 col-form-label">Contract Type <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_dropdown('contract_type', $contracts, set_value('contract_type', isset($result->contract_type) ? $result->contract_type : ''), 'class="form-control" id="contract_type"'); ?>
                  <?php echo form_error('contract_type', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Department -->
              <div class="form-group row">
                <label for="department" class="col-sm-4 col-form-label">Department <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_dropdown('department', array('' => 'Select Department') + $departments, set_value('department', isset($result->department) ? $result->department : ''), 'class="form-control js-example-basic-single" id="department"'); ?>
                  <?php echo form_error('department', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Position -->
              <div class="form-group row">
                <label for="position" class="col-sm-4 col-form-label">Position <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'position', 'class' => 'form-control', 'id' => 'position', 'value' => set_value('position', isset($result->position) ? $result->position : ''))); ?>
                  <?php echo form_error('position', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Qualification -->
              <div class="form-group row">
                <label for="qualification" class="col-sm-4 col-form-label">Qualification <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'qualification', 'class' => 'form-control', 'id' => 'qualification', 'value' => set_value('qualification', isset($result->qualification) ? $result->qualification : ''))); ?>
                  <?php echo form_error('qualification', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Proposed Leaving Date -->
              <div class="form-group row">
                <label for="date_left" class="col-sm-4 col-form-label">Proposed Leaving Date</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <div class="input-group-text">
                      <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                    </div>
                    <?php echo form_input('date_left', isset($result->date_left) ? date('Y-m-d', $result->date_left) : '', 'class="form-control datepicker" id="date_left" placeholder="Choose date"'); ?>
                  </div>
                  <?php echo form_error('date_left', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Details Section -->
          <h5 class="mt-4"><b>Contact Details</b></h5>
          <div class="row" style="padding-left:30px">
            <div class="col-xl-6">
              <!-- Citizenship -->
              <div class="form-group row">
                <label for="citizenship" class="col-sm-4 col-form-label">Citizenship <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php
                  $this->load->models('portal_m');
                  $country = $this->portal_m->populate('countries', 'id', 'name');
                  $citizenship_value = isset($result->citizenship) ? $result->citizenship : '';
                  echo form_dropdown('citizenship', array('114' => 'Kenya') + $country, $citizenship_value, 'class="form-control js-example-basic-single" style="width:270px !important;" data-style="btn-white" data-live-search="true"');
                  ?>
                </div>
              </div>

              <!-- Phone -->
              <div class="form-group row">
                <label for="phone" class="col-sm-4 col-form-label">Phone <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'phone', 'class' => 'form-control', 'id' => 'phone', 'value' => set_value('phone', isset($result->phone) ? $result->phone : ''))); ?>
                  <?php echo form_error('phone', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Phone Two -->
              <div class="form-group row">
                <label for="phone2" class="col-sm-4 col-form-label">Phone Two</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'phone2', 'class' => 'form-control', 'id' => 'phone2', 'value' => set_value('phone2', isset($result->phone2) ? $result->phone2 : ''))); ?>
                  <?php echo form_error('phone2', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <!-- Home County -->
              <div class="form-group row">
                <label for="home_county" class="col-sm-4 col-form-label">Home County <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php
                  $counties = $this->portal_m->populate('counties', 'id', 'name');
                  $county_value = isset($result->county) ? $result->county : '';
                  echo form_dropdown('county', array('' => 'Select County') + $counties, $county_value, 'class="select county js-example-basic-single" style="width:270px !important;" id="county"');
                  ?>
                </div>
              </div>

              <!-- Address -->
              <div class="form-group row">
                <label for="address" class="col-sm-4 col-form-label">Address</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'address', 'class' => 'form-control', 'id' => 'address', 'value' => set_value('address', isset($result->address) ? $result->address : 'E.g 123 456 - 00100, Nairobi, Kenya'))); ?>
                  <?php echo form_error('address', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
              <!-- Email -->
              <div class="form-group row">
                <label for="email" class="col-sm-4 col-form-label">Email <b> <span class='required'>*</span></b></label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'email', 'type' => 'email', 'class' => 'form-control', 'id' => 'email', 'value' => set_value('email', isset($result->email) ? $result->email : ''))); ?>
                  <?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Additional Info Section -->
          <h5 class="mt-4"><b>Additional Info</b></h5>
          <div class="row" style="padding-left:30px">
            <div class="col-xl-6">
              <!-- Referee Full Name -->
              <div class="form-group row">
                <label for="ref_name" class="col-sm-4 col-form-label">Ref eree Full Name</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'ref_name', 'class' => 'form-control', 'id' => 'ref_name', 'value' => set_value('ref_name', isset($result->ref_name) ? $result->ref_name : ''))); ?>
                  <?php echo form_error('ref_name', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Referee Phone -->
              <div class="form-group row">
                <label for="ref_phone" class="col-sm-4 col-form-label">Referee Phone</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'ref_phone', 'class' => 'form-control', 'id' => 'ref_phone', 'value' => set_value('ref_phone', isset($result->ref_phone) ? $result->ref_phone : ''))); ?>
                  <?php echo form_error('ref_phone', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>

            <div class="col-xl-6">
              <!-- Referee Email -->
              <div class="form-group row">
                <label for="ref_email" class="col-sm-4 col-form-label">Referee Email</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'ref_email', 'type' => 'email', 'class' => 'form-control', 'id' => 'ref_email', 'value' => set_value('ref_email', isset($result->ref_email) ? $result->ref_email : ''))); ?>
                  <?php echo form_error('ref_email', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>

              <!-- Referee Address -->
              <div class="form-group row">
                <label for="ref_address" class="col-sm-4 col-form-label">Referee Address</label>
                <div class="col-sm-8">
                  <?php echo form_input(array('name' => 'ref_address', 'class' => 'form-control', 'id' => 'ref_address', 'value' => set_value('ref_address', isset($result->ref_address) ? $result->ref_address : 'E.g 123 456 - 00100, Nairobi, Kenya'))); ?>
                  <?php echo form_error('ref_address', '<span class="text-danger">', '</span>'); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Additional Info Section -->
          <h5 class="mt-4"><b>Special Role</b></h5>
          <div class="row" style="padding-left:30px">
            <div class="col-xl-6">
              <div class="form-group row">
                <label for="special" class="col-sm-4 col-form-label">Special</label>
                <div class="col-sm-8">
                  <div class="form-check">
                    <?php
                    $special_checked = isset($result->special) && $result->special == '1' ? true : false;
                    echo form_checkbox('special', '1', $special_checked, 'class="form-check-input" id="special"');
                    ?>
                    <label class="form-check-label" for="special">Check this box to assign teacher special Roles</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6">

            </div>
          </div>


        </div>
        <div class="card-footer">
          <!-- Submit Button -->
          <div class="form-group row mt-1 float-end">
            <div class="col-sm-12 text-center">
              <button type="submit" class="btn btn-info mb-1 d-inline-flex">
                <i class="fe fe-check-square me-1 lh-base"></i>
                <?php echo ($updType == 'edit') ? 'Update' : 'Save'; ?>
              </button>
            </div>
          </div>

          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>

  <style>
    .card-header {
      display: flex;
      justify-content: space-between;
    }

    .text-red {
      color: #FF0000;
    }
  </style>