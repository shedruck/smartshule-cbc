<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>Teacher Profile</b></h5>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body p-2">
        <div class="row mb-3">
          <!-- Profile Picture Section -->
          <div class="col-md-3 text-center">
            <?php
            // echo "<pre>";
            // print_r($teacher);
            // echo "<pre>";
            $path = base_url('uploads/files/' . $teacher->passport);
            $fake = base_url('uploads/files/member.png');

            if (!empty($teacher->passport)) {
              $ppst = '<img src="' . $path . '" alt="Profile Picture" class="img-fluid rounded-circle mb-2 profile-img">';
            } else {
              $ppst = '<img src="' . $fake . '" alt="Profile Picture" class="img-fluid rounded-circle mb-2 profile-img">';
            }
            echo $ppst;
            ?>
            <p><b><?php echo $teacher->first_name . ' ' . $teacher->last_name ?></b></p>
          </div>
          <div class="col-md-9">
            <div class="row">
              <!-- Personal Details Column -->
              <div class="col-md-3">
                <h6 class="text-primary"><b>Personal Details</b></h6>
                <p><b>Gender:</b> <?php echo $teacher->gender ?></p>
                <p><b>Birthday:</b> <?php echo date("F j, Y", $teacher->dob) ?></p>
                <p><b>Marital Status:</b><?php echo $teacher->marital_status ?></p>
                <p><b>ID/Passport No.:</b><?php echo $teacher->id_no ?></p>
                <p><b>PIN No.:</b><?php echo $teacher->pin ?></p>
                <p><b>Religion:</b><?php echo $teacher->religion ?></p>
                <p><b>Disability:</b><?php echo $teacher->disability ?></p>
                <p><b>Disability Type:</b><?php echo $teacher->disability_type ?></p>
              </div>

              <!-- Contact Details Column -->
              <div class="col-md-3">
                <h6 class="text-primary"><b>Contact Details</b></h6>
                <p><b>Citizenship:</b> <?php
                                        $country = $this->portal_m->populate('countries', 'id', 'name');
                                        echo $country[$teacher->citizenship] ?></p>
                <p><b>Home County:</b> <?php
                                        $counties = $this->portal_m->populate('counties', 'id', 'name');
                                        echo $counties[$teacher->county] ?></p>
                <p><b>Phone:</b> <?php echo $teacher->phone ?></p>
                <p><b>Phone2:</b><?php echo $teacher->phone2 ?></p>
                <p><b>Email:</b> <?php echo $teacher->email ?></p>
                <p><b>Address:</b> <?php echo $teacher->address ?></p>
                <h6 class="text-primary"><b>Additional / Former Schools</b></h6>
                <!-- Add school details here if any -->
              </div>

              <!-- Employment Details Column -->
              <div class="col-md-3">
                <h6 class="text-primary"><b>Employment Details</b></h6>
                <p><b>TSC Employee:</b><?php echo $teacher->tsc_employee ?></p>
                <p><b>TSC Number:</b> <?php echo $teacher->tsc_number ?></p>
                <p><b>KUPPET Member:</b><?php echo $teacher->kuppet_member ?></p>
                <p><b>KUPPET Number:</b><?php echo $teacher->kuppet_number ?></p>
                <p><b>KNUT Member:</b><?php echo $teacher->knut_number ?></p>
                <p><b>KNUT Number:</b><?php echo $teacher->knut_member ?></p>
                <p><b>Staff Number:</b> <?php echo $teacher->staff_no ?></p>
                <p><b>Date Employed:</b><?php echo date("F j, Y", $teacher->date_joined) ?></p>
                <p><b>Contract Type:</b><?php echo $teacher->contract_type ?></p>
                <p><b>Position:</b> <?php echo $teacher->position ?></p>
                <p><b>Qualification:</b> <?php echo $teacher->qualification ?></p>
              </div>

              <!-- Referee Details & Documents Column -->
              <div class="col-md-3">
                <h6 class="text-primary"><b>Referee Details</b></h6>
                <p><b>Name:</b><?php echo $teacher->ref_name ?></p>
                <p><b>Phone:</b><?php echo $teacher->ref_phone ?></p>
                <p><b>Email:</b><?php echo $teacher->ref_email ?></p>
                <p><b>Additional Details:</b><?php echo $teacher->ref_additionals ?></p>
                <h6 class="text-primary"><b>Documents</b></h6>
                <p><b>ID/Passport Copy:</b>
                  <?php if (!empty($teacher->id_document)) : ?>
                    <a href="<?php echo base_url('uploads/files/' .$teacher->id_document); ?>" class="text-decoration-none">Download</a>
                  <?php else : ?>
                    No ID uploaded
                  <?php endif; ?>
                </p>
                <p><b>TSC Letter:</b>
                  <?php if (!empty($teacher->tsc_letter)) : ?>
                    <a href="<?php echo base_url('uploads/files/' .$teacher->tsc_letter); ?>" class="text-decoration-none">Download</a>
                  <?php else : ?>
                    No letter uploaded
                  <?php endif; ?>
                </p>
                <p><b>Credential Cert:</b>
                  <?php if (!empty($teacher->credential_cert)) : ?>
                    <a href="<?php echo base_url('uploads/files/' .$teacher->credential_cert); ?>" class="text-decoration-none">Download</a>
                  <?php else : ?>
                    No credential certificate uploaded
                  <?php endif; ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo form_close(); ?>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }

  .card-body p {
    margin: 0;
    padding: 0.25rem 0;
  }

  .text-primary {
    color: #007bff;
  }

  .profile-img {
    width: 120px;
    height: 120px;
    border: 2px solid #ddd;
    padding: 3px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

  }

  .rounded-circle {
    border-radius: 50%;
  }

  .col-md-3.text-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
  }
</style>

<script>
  function goBack() {
    window.history.back();
  }
</script>