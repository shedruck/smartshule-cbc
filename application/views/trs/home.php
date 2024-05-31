<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- CONTAINER -->
<div class="main-container container-fluid">

  <!-- ROW-1 -->
  <div class="row">
    <div class="col-xxl-2 col-xl-3 col-sm-4">
      <div class="card mt-1">
        <!-- <span class="ribbone-info-left">
          <span><i class="fe fe-zap"></i></span>
        </span> -->
        <div class="card-body py-2 filemanager-list text-center mt-3">
          <div class="profile-img-1">
            <?php if (isset($pass->passport) && $pass->passport !== null) { ?>
              <img src="<?php echo base_url('uploads/files/' . $pass->passport); ?>" alt="user-img" width="110" height="110" class="rounded-circle border border-primary border-3" style="border-width: 20px;">
            <?php } else { ?>
              <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img" width="115" class="rounded-circle">
            <?php } ?>

          </div>
          <div class="text-center m-1">
            <div class="text-success mb-0 mt-2">
              <!-- <i class="fa fa-star fs-20"></i> -->
              <!-- <i class="fa fa-star fs-20"></i> -->
              <i class="fa fa-star fs-20"></i>
              <i class="fa fa-star fs-20"></i>
              <i class="fa fa-star fs-20"></i>
            </div>
          </div>
          <div class="profile-img-content text-dark my-2">
            <div>
              <?php $u = $this->ion_auth->get_user($post->created_by); ?>
              <h6 class="mb-2"><?php echo strtoupper($this->user->first_name . ' ' . $this->user->last_name) ?></h6>
              <p class="text-muted mb-1">Educator / Teacher</p>
            </div>
          </div>


        </div>
        <div class="card-footer px-4 mb-2">
          <div class="d-flex btn-list btn-list-icon justify-content-center">
            <a href="<?php echo base_url('trs/account'); ?>" class="btn btn-info-gradient" style="min-width:130px;"> <i class="mdi mdi-account-circle"></i> View Profile</a>
          </div>
          <div class="d-flex btn-list btn-list-icon justify-content-center mt-3">
            <a href="<?php echo base_url('teachers/trs/subjectAssigned'); ?>" target="" class="btn btn-success-gradient">Subject Assigned</a>
          </div>
          <div class="d-flex justify-content-center mt-3">
            <a href="trs/zoom" class="btn btn-primary-gradient"><i class="mdi mdi-spin mdi-camcorder" aria-hidden="true"></i> Zoom Meeting</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-10 col-xl-9 col-sm-8">
      <div class="row">
        <h5 class="fw-semibold mb-3 ml-1"><img src="assets/themes/default/img/grid.svg" alt="Icon description"> Dashboard</h5>
        <div class="col-xl-3 col-sm-6">
          <a href="<?php echo base_url('class_groups/trs/myclasses'); ?>" class="card-link d-block">
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
                    <img src="assets/themes/default/img/today.svg" alt="Icon description">
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
          <a href="<?php echo base_url('school_events/trs/events'); ?>" class="card-link d-block">
            <div class="card">
              <div class="card-body">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                  <div class="icon-container" style="background: linear-gradient(135deg, #00008B, #ADD8E6);">
                    <img src="assets/themes/default/img/calender.svg" alt="Icon description">
                  </div>
                  <div class="mt-2">
                    <h6>Calender</h6>
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

  <?php
  $user = $this->ion_auth->get_user();

  $this->load->model('cbc/cbc_tr');

  $cls =  $this->cbc_tr->get_class($user->id);

  $att = $this->cbc_tr->get_by_class($cls->id);

  $attnd = $this->cbc_tr->get_by_class1($cls->id);

  $myids = [];

  foreach ($att as $key => $at) {
    $myids[] = $at->id;
  }

  $myids1 = [];

  foreach ($attnd  as $keyyy => $at) {
    $myids1[] = $at->id;
  }

  $presentCounts = $this->cbc_tr->get_class_att($myids);

  $attendanceDateCount = [];

  foreach ($att as $detail) {
    $attendanceId = $detail->id;
    $attendanceDate = date('M-d', $detail->attendance_date); // Convert timestamp to readable date format

    $presentCount = isset($presentCounts[$attendanceId]) ? $presentCounts[$attendanceId] : 0;
    $attendanceDateCount[$attendanceDate] = $presentCount;
  }

  $reversedArray = array_reverse($attendanceDateCount, true);

  $attendanceDateCountJson = json_encode($reversedArray);

  // table data

  $stu = $this->cbc_tr->get_class_at($myids1);

  $count = count($myids1);

  ?>


  <!-- ROW 2 -->
  <?php if (!empty($cls)) { ?>

    <div class="row p-2 mt-2">
      <div class="col-xl-7">
        <div class="card custom-card">
          <div class="card-header">
            <div class="card-title"><span class="text-primary"><?php echo $this->streams[$cls->id] ?> </span> - Attendance Report</div>
          </div>
          <div class="card-body">
            <!-- <canvas id="chart" ></canvas> -->
            <div id="chart" class="chartjs-chart"></div>
          </div>
        </div>
      </div>

      <div class="col-xxl-2 col-xl-5 col-sm-4">
        <div class="card">
          <div class="card-status bg-green br-te-7 br-ts-7"></div>
          <div class="card-header">
            <h3 class="card-title">Top 5 Attendants</h3>
            <div class="card-options">
              <!-- <a href="javascript:void(0);" class="card-options-remove" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a> -->
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover card-table mb-0">

                <tbody>
                  <?php

                  foreach ($stu as $keyy => $st) {

                    $stud = $this->worker->get_student($keyy);

                    $name = $stud->first_name . ' ' . $stud->last_name;

                    $p = ($st / $count) * 100;

                  ?>
                    <tr>
                      <td class="ps-3">
                        <div class="d-flex align-items-center position-relative">
                          <img class="avatar brround avatar-md me-3" alt="avatra-img" src="../assets/images/users/18.jpg">
                          <div class="flex-grow-1">
                            <p class="mb-0"> <?php echo ucwords($name) ?></p>
                          </div>
                        </div>
                      </td>

                      <td>
                        <span class="badge rounded-pill bg-primary-transparent"><?php echo number_format($p, 1) ?> %</span>
                      </td>

                      <td>
                        <span><strong><?php echo $st ?></strong> days</span>
                      </td>
                    </tr>

                  <?php

                  }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  <?php  } ?>
  <!-- ROW-1 -->

  

  <script>
    // Get the PHP variable containing the JSON-encoded array
    const attendanceDateCount = <?php echo $attendanceDateCountJson; ?>;

    // Convert JSON data into arrays for ApexCharts
    const keys = Object.keys(attendanceDateCount);
    const values = Object.values(attendanceDateCount);

    // Chart configuration
    const options = {
      chart: {
        type: 'area',
        height: 250,
        foreColor: '#999',
        // Add padding to the chart area
        redrawOnParentResize: true,
        toolbar: {
          autoSelected: 'pan',
          show: false
        }
      },
      series: [{
        name: 'Attendance',
        data: values
      }],
      xaxis: {
        categories: keys
      },
      fill: {
        type: 'solid',
        colors: ['#b7f7d1'], // Light green color
        opacity: 0.4 // Faint opacity
      },
      yaxis: {
        title: {
          text: ''
        },
        labels: {
          formatter: function(val) {
            return val.toFixed(0);
          }
        },
        min: 0, // Minimum value on y-axis
        max: 5, // Maximum value on y-axis
        tickAmount: 6 // Number of intervals (including 0 to 5)
      },
      stroke: {
        width: 2,
        curve: 'smooth',
        colors: ['#1dd871'] // Upper line border color
      },
      plotOptions: {
        area: {
          dataLabels: {
            enabled: false
          }
        }
      },
      dataLabels: {
        enabled: false
      },
      markers: {
        size: 0
      },
      legend: {
        show: false
      }
    };

    // Initialize the chart
    const chart = new ApexCharts(document.querySelector("#chart"), options);

    // Render the chart
    chart.render();
  </script>


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

    .rounded-circle {
      border-radius: 50%;
    }
  </style>