<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>PROFILE</b></h5>
        <div>

          <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>



      <div class="card-body p-2">
        <!-- ROW-1 -->
        <div class="row">
          <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-5">

            <!-- card one -->
            <div class="card text-center shadow-none border profile-cover__img">
              <div class="card-body">
                <div class="profile-img-1">

                  <?php
                  if (isset($pass->passport) && $pass->passport !== null) { ?>
                    <img src="<?php echo base_url('uploads/files/' . $pass->passport); ?>" alt="user-img" width="150" height="150" class="img-circle">
                  <?php } else { ?>
                    <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="150" class="img-circle">
                  <?php }
                  ?>

                </div>
                <div>
                  <div class="text-warning mb-0 mt-2">
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                  </div>
                </div>
                <div class="profile-img-content text-dark my-2">
                  <div>
                    <?php $u = $this->ion_auth->get_user($post->created_by); ?>
                    <h5 class="mb-0"><?php echo strtoupper($this->user->first_name . ' ' . $this->user->last_name) ?></h5>
                    <p class="text-muted mb-0">Educator / Teacher</p>
                  </div>
                </div>

                <div class="d-flex btn-list btn-list-icon justify-content-center">
                  <a href="<?php echo base_url('trs/change_password'); ?>" class="btn btn-sm btn-primary">Change Password</a>
                </div>

              </div>
              <div class="card-footer">
                <div class="text-left" style="text-align: left;">
                  <p class="text-black font-13"><strong>MOBILE:</strong>

                    <span class="m-l-15"><?php echo $this->user->phone; ?></span>
                  </p>

                  <p class="text-black font-13"><strong>EMAIL :</strong> <span class="m-l-15"><?php echo $this->user->email; ?></span></p>

                  <p class="text-black font-13"><strong>JOINED :</strong> <span class="m-l-15"><?php echo $this->user->created_on > 10000 ? date('d M Y', $this->user->created_on) : ' - '; ?></span></p>


                </div>

              </div>
            </div>


          </div>

          <!-- card two -->
          <div class="col-xxl-9 col-xl-8 col-lg-7 col-md-7">
            <div class="card">
              <div class="card-header">
                <h5 class="mb-0">About</h5>
              </div>
              <div class="card-body p-0">

                <?php
                // echo "<pre>";
                // print_r($this->profile);
                // echo "<pre>";
                ?>

                <div class="table-responsive p-5">
                  <h5 class="mb-3">Personal Info</h5>
                  <div class="row">
                    <div class="col-xl-8 ms-3">
                      <div class="row row-sm">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">First Name : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->first_name ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Last Name : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->last_name ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Gender : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->gender ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Phone : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->phone ?></span>
                        </div>
                      </div>

                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Email : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->email ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Address : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->address ?></span>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="border-top"></div>
                <div class="table-responsive p-5">
                  <h5 class="mb-3">Identification and Documentation</h5>
                  <div class="row">
                    <div class="col-xl-8 ms-3">
                      <div class="row row-sm">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">ID Number : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->id_no ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Huduma Number : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->huduma_number ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">TSC Number : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->tsc_number ?></span>
                        </div>
                      </div>

                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Staff NO: </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->staff_no ?></span>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
                <div class="border-top"></div>
                <div class="table-responsive p-5">
                  <h5 class="mb-3">Employment Details</h5>
                  <div class="row">
                    <div class="col-xl-8 ms-3">
                      <div class="row row-sm">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Position : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->position ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Department : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->department ?></span>
                        </div>
                      </div>
                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Division : </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->division ?></span>
                        </div>
                      </div>

                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Qualification: </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->qualification ?></span>
                        </div>
                      </div>

                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Contract Type: </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo $this->profile->contract_type ?></span>
                        </div>
                      </div>

                      <div class="row row-sm mt-3">
                        <div class="col-md-3">
                          <span class="fw-semibold fs-14">Date Joined: </span>
                        </div>
                        <div class="col-md-9">
                          <span class="fs-15 text-primary"><?php echo date("d M Y", $this->profile->date_joined) ?></span>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ROW-1 CLOSED -->

      </div>
      <div class="card-footer">


      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>