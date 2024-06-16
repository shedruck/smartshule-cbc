<div class="row">

  <?php

  if (count($classes)  > 0) {
    foreach ($classes as $cl => $row) {
      $obj = (object) $row;

  ?>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xl-4">
        <div class="card">
          <div class="card-header">
            <h6> Social Behaviour Report - <span class="text-primary"><?php echo $obj->name ?> </span>
            </h6>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-start">
              <div class="flex-grow-1">
                <p class="mb-0 text-gray-600"><?php echo $obj->name ?></p>
                <span class="fs-5"><?php echo $obj->total ?></span>
                <span class="fs-12 text-success ms-1">Student(s)</span>
              </div>
              <div class="ms-1">
                <div class="icon-container">
                  <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="white">
                    <path d="M38.67-160v-100q0-34.67 17.83-63.17T105.33-366q69.34-31.67 129.67-46.17 60.33-14.5 123.67-14.5 63.33 0 123.33 14.5T611.33-366q31 14.33 49.17 42.83T678.67-260v100h-640Zm706.66 0v-102.67q0-56.66-29.5-97.16t-79.16-66.84q63 7.34 118.66 22.5 55.67 15.17 94 35.5 34 19.34 53 46.17 19 26.83 19 59.83V-160h-176ZM358.67-480.67q-66 0-109.67-43.66Q205.33-568 205.33-634T249-743.67q43.67-43.66 109.67-43.66t109.66 43.66Q512-700 512-634t-43.67 109.67q-43.66 43.66-109.66 43.66ZM732-634q0 66-43.67 109.67-43.66 43.66-109.66 43.66-11 0-25.67-1.83-14.67-1.83-25.67-5.5 25-27.33 38.17-64.67Q578.67-590 578.67-634t-13.17-80q-13.17-36-38.17-66 12-3.67 25.67-5.5 13.67-1.83 25.67-1.83 66 0 109.66 43.66Q732-700 732-634ZM105.33-226.67H612V-260q0-14.33-8.17-27.33-8.16-13-20.5-18.67-66-30.33-117-42.17-51-11.83-107.66-11.83-56.67 0-108 11.83-51.34 11.84-117.34 42.17-12.33 5.67-20.16 18.67-7.84 13-7.84 27.33v33.33Zm253.34-320.66q37 0 61.83-24.84Q445.33-597 445.33-634t-24.83-61.83q-24.83-24.84-61.83-24.84t-61.84 24.84Q272-671 272-634t24.83 61.83q24.84 24.84 61.84 24.84Zm0 320.66Zm0-407.33Z" />
                  </svg>
                </div>
              </div>
            </div>
          </div>



          <div class="card-footer d-flex justify-content-between">

            <a href="<?php echo base_url('cbc/trs/social_report/' . $cl) ?>" class="btn btn-primary"><i class="bi bi-plus-square"></i> Create/Edit</a>

            <a href="<?php echo base_url('cbc/trs/social_print/' . $cl) ?>" class="btn btn-info"><i class="bi bi-printer"></i> Print </a>

            
          </div>

        </div>
      </div>

    <?php }
  } else { ?>
    <div class="col-md-2 col-lg-3 col-xl-3"></div>
    <div class="col-md-8 col-lg-8 col-xl-5">
      <div class="card">
        <div class="card-header border-0 bg-danger-transparent">
          <div class="alert-icon-style"><span class="avatar avatar-lg bg-danger rounded-circle"><i class="fe fe-info" aria-hidden="true"></i></span></div>
          <div class="card-options">
            <a href="javascript:void(0);" class="card-options-remove z-index1 text-danger go_back" data-bs-toggle="card-"><i class="fe fe-x"></i></a>
          </div>
        </div>
        <div class="card-body text-center">
          <h4 class="fw-semibold mb-1 mt-3">Warning</h4>
          <p class="card-text text-muted">Class allocation for Term <?php echo $this->school->term . ' ' . $this->school->year ?> not available</p>
        </div>
        <div class="card-footer text-center border-0 pt-0">
          <div class="row">
            <div class="text-center">
              <a href="javascript:void(0);" class="btn btn-danger me-2 go_back">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>


</div>




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
    min-height: ;
    width: 100%;
  }

  .rounded-circle {
    border-radius: 50%;
  }
</style>