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
                <h5 class="mb-0">Recent Payslips</h5>
              </div>
              <div class="card-body pr-3">

                <div class="table-responsive ml-2">
                  <?php
                  if (!empty($slips)) {
                  ?>
                    <table id="grid-pagination" class="table table-bordered">
                      <thead class="table-success">
                        <th> #</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Bank</th>
                        <th>
                          Date Processed
                        </th>
                        <th class="text-center" width="20%"> Option </th>
                      </thead>

                      <?php
                      $i = 0;
                      foreach ($slips as $p) {
                        $i++;
                        $u = $this->ion_auth->get_user($p->employee);
                      ?>
                        <tbody>
                          <tr class="">
                            <td><?php echo $i ?>. </td>
                            <td> <?php echo $p->month ?></td>
                            <td><?php echo $p->year ?></td>
                            <td><?php echo $p->bank_details ?></td>
                            <td class="hide-phone">
                              <p class="font-13 m-b-0"> <?php echo date('jS M, Y', $p->salary_date); ?></p>
                            </td>
                            <td class="text-center"><a href="<?php echo base_url('trs/slip/' . $p->id) ?>" class="btn btn-primary-light rounded-pill"> <i class="mdi mdi-account-search m-r-5"></i> View</a>
                            </td>
                          </tr>
                        <?php }
                    } else { ?>
                        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                      <?php }
                      ?>
                        </tbody>

                    </table>
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