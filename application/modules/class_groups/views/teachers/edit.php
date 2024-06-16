<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-uppercase"><b>EDIT CLASS TEACHER <span class="text-secondary"><?php echo $this->streams[$class_id]; ?></span></b></h6>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body p-0">

        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-6">
              <div class="card shadow-sm mt-5">
                <div class="card-body">
                  <?php
                  $attributes = array('class' => 'form-horizontal', 'id' => '');
                  echo form_open_multipart(current_url(), $attributes);
                  ?>

                  <div class="mb-3">
                    <label for="teacher-select_<?php echo $class_id; ?>" class="col-form-label">Select Teacher:</label> <br>
                    <select class="form-control js-example-basic-single" id="teacher-select_<?php echo $class_id; ?>" name="teacher_id">
                      <?php foreach ($trs as $teacher_id => $teacher_name) { ?>
                        <option value="<?php echo $teacher_id; ?>"><?php echo $teacher_name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="card-footer">
        <div class="mt-4 d-flex justify-content-end">

          <button type="submit" class="btn btn-primary mb-1 ms-2">
            <i class="fe fe-check-square me-1"></i>
            <?php echo ($updType == 'edit') ? 'Update' : 'Assign'; ?>
          </button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>


<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>