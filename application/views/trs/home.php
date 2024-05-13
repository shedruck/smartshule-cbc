<!-- CONTAINER -->
<div class="main-container container-fluid">

  <!-- ROW-1 -->
  <div class="row">
    <div class="col-xxl-2 col-xl-3 col-sm-4">
      <div class="card">
        <span class="ribbone-info-left">
          <span><i class="fe fe-zap"></i></span>
        </span>
        <div class="card-body py-2 filemanager-list text-center mt-3">
          <div class="profile-img-1">
            <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="120" class="img-circle">
          </div>
          <div class="text-center m-1">
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
              <h5 class="mb-2"><?php echo strtoupper($this->user->first_name . ' ' . $this->user->last_name) ?></h5>
              <p class="text-muted mb-1">Educator / Teacher</p>
            </div>
          </div>


        </div>
        <div class="card-footer px-4 mb-2">
          <div class="d-flex btn-list btn-list-icon justify-content-center">
            <a href="<?php echo base_url('trs/account'); ?>" class="btn btn-info-gradient" style="min-width:130px;"> <i class="mdi mdi-account-circle"></i> View Profile</a>
          </div>
          <div class="d-flex btn-list btn-list-icon justify-content-center mt-3">
            <a href="<?php echo base_url('trs/subjectAssigned'); ?>" target="" class="btn btn-success-gradient">Subject Assigned</a>
          </div>
          <div class="d-flex justify-content-center mt-3">
            <a href="trs/zoom" class="btn btn-primary-gradient"><i class="mdi mdi-spin mdi-camcorder" aria-hidden="true"></i> Zoom Meeting</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-10 col-xl-9 col-sm-8">
      <div class="row">
        <h5 class="fw-semibold mb-3">Dashboard</h5>
        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('class_groups/trs/myclasses'); ?>" class="card-link">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style="background: linear-gradient(135deg, #FF4500, #FFDAB9);">
                    <img src="assets/themes/default/img/users.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>My Students</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('cbc/trs'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style="background: linear-gradient(135deg, #4169E1, #87CEEB);">
                    <img src="assets/themes/default/img/exam1.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Assessments</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('class_attendance/trs/list'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style="background: linear-gradient(135deg, #800080, #D8BFD8);">
                    <img src="assets/themes/default/img/calender.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Rollcall</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>


        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('diary/trs'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style=" background: linear-gradient(135deg, #FF0000, #FFC0CB);">
                    <img src="assets/themes/default/img/assign.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Diary</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('messages/trs'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style=" background: linear-gradient(135deg, #4B0082, #E6E6FA);">
                    <img src="assets/themes/default/img/message.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Messages</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('newsletters/trs/newsletters'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style="background: linear-gradient(135deg, #3D1B00, #D2B48C);">
                    <img src="assets/themes/default/img/news.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Newsletters</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('assignments/trs'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container">
                    <img src="assets/themes/default/img/diary.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Assignments</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('schemes_of_work/trs'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style="background: linear-gradient(135deg, #00008B, #ADD8E6);">
                    <img src="assets/themes/default/img/book.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Schemes</h6>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>


      </div>
    </div>
  </div>
  <!-- ROW-1 CLOSED -->

</div>
<!-- CONTAINER CLOSED -->

<style>
  .icon-container {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    background: linear-gradient(135deg, #008000, #90EE90);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .icon-container svg {
    width: 80%;
    height: auto;
    fill: white;
    /* Adjust icon color as needed */
  }

  .icon-container img {
    max-width: 100%;
    /* Ensure the image fits inside the container */
  }

  .card-body {
    min-height: 140px;
    width: 100%;
  }
</style>