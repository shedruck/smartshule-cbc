<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-uppercase"><b>ASSIGN CLASS TEACHER</b></h6>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="d-lg-flex d-block">
          <div class="p-4 border-end w-100">
            <div class="table-responsive">
              <table class="table border text-nowrap text-md-nowrap table-bordered mb-0">
                <thead>
                  <tr class="bg-primary">
                    <th class="tx-fixed-white">#</th>
                    <th class="tx-fixed-white">Teacher</th>
                    <th class="tx-fixed-white">Class Teacher</th>
                    <th class="tx-fixed-white"> Action</th>
                  </tr>
                </thead>
                <?php

                $i = 1;
                foreach ($classes as $key => $cls) {

                ?>
                  <tr>
                    <td><?php echo $i++ ?></td>
                    <td><?php echo $cls ?></td>

                    <td>
                      <?php foreach ($all_streams as $y => $vl) { ?>
                        <?php if ($key == $vl->id) { ?>
                          <?php if ($vl->class_teacher === "" || $vl->class_teacher === null) { ?>

                            <span class="badge bg-secondary-gradient ">Not Assigned</span>

                          <?php } else { ?>
                            <?php echo $profile[$vl->class_teacher]; ?>

                          <?php } ?>


                        <?php } ?>
                      <?php } ?>
                    </td>

                    <td> <?php foreach ($all_streams as $y => $vl) { ?>
                        <?php if ($key == $vl->id) { ?>
                          <?php if ($vl->class_teacher === "" || $vl->class_teacher === null) { ?>
                            <button class="btn btn-primary btn-sm off-canvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_<?php echo $vl->id; ?>" aria-controls="offcanvas_<?php echo $vl->id; ?>">
                              <i class="fe fe-plus "></i> Add 
                            </button>

                          <?php } else { ?>

                            <a href="<?php echo base_url('class_groups/trs/edit_teacher/' . $vl->id); ?>" class="btn btn-warning btn-sm">
                              <i class="bi bi-pencil-square"></i> Edit
                            </a>


                          <?php } ?>

                          <!-- Offcanvas for each item -->
                          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas_<?php echo $vl->id; ?>">
                            <div class="offcanvas-header">
                              <h6 class="fw-bold offcanvas-title">Assign Teacher to <span class="text-secondary"><?php echo $this->streams[$vl->id]; ?></span></h6>
                              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fe fe-x fs-18"></i></button>
                            </div>
                            <div class="offcanvas-body">
                              <div class="card">
                                <div class="card-body">
                                  <div class="m-2">

                                  </div>
                                  <?php
                                  $attributes = array('class' => 'form-horizontal', 'id' => '');
                                  echo form_open_multipart(base_url('class_groups/trs/save_teacher'), $attributes);
                                  ?>

                                  <div class="mb-3">
                                    <label for="teacher-select_<?php echo $vl->id; ?>" class="col-form-label">Select Teacher:</label> <br>
                                    <select class="form-control" id="teacher-select_<?php echo $vl->id; ?>" name="teacher_id">
                                      <?php foreach ($trs as $teacher_id => $teacher_name) { ?>
                                        <option value="<?php echo $teacher_id; ?>"><?php echo $teacher_name; ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                  <input type="hidden" name="stream_id" value="<?php echo $vl->id; ?>">
                                  <div class="mt-4 d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mb-1" data-bs-dismiss="offcanvas">
                                      <i class="fas fa-times me-1"></i>
                                      Close
                                    </button>
                                    <button type="submit" class="btn btn-primary mb-1 ms-2">
                                      <i class="fe fe-check-square me-1"></i>
                                      <?php echo ($updType == 'edit') ? 'Update' : 'Assign'; ?>
                                    </button>
                                  </div>

                                  <?php echo form_close(); ?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--/Right Offcanvas-->
                        <?php } ?>
                      <?php } ?>
                    </td>
                  </tr>
                <?php  } ?>
              </table>
            </div>
          </div>
          <div class="p-6">
            <div class="tab-content terms" id="vertical-tabContent">
              <div class="tab-pane fade show active" id="vertical-terms" role="tabpanel" aria-labelledby="vertical-terms-tab" tabindex="0">
                <div class="col-md-12 col-lg-12 col-xl-12">
                  <div class="card border-top border-info">
                    <div class="card-body text-center">
                      <span class="avatar avatar-lg bg-info rounded-circle"><i class="fe fe-bell" aria-hidden="true"></i></span>
                      <h4 class="fw-semibold mb-1 mt-3">Alert</h4>
                      <p class="card-text text-muted">Click the settings Buttons to assign ClassTeacher !!!</p>
                    </div>
                    <div class="card-footer text-center border-0 pt-0">
                      <div class="row">
                        <div class="text-center">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>