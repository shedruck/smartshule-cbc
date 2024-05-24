<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes);
?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="float-start m-0">Academic Diary</h6>
        <div class="float-end">
          <?php echo anchor('trs/diary', '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-secondary"'); ?>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="row justify-content-center">
          <div class="col-dm-8 col-xl-8 col-lg-8 col-sm-12 mt-3 mb-3">
            <div class="row m-2">
              <label for="student" class="col-md-3 form-label">Student <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                echo form_dropdown('student', ['' => ''] + (array) $students, $result->student, 'class="form-control select" data-placeholder="Select Student..."');
                echo form_error('student');
                ?>
              </div>
            </div>

            <div class="row m-2">
              <label for="activity" class="col-md-3 form-label">Activity <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php echo form_input('activity', $result->activity, 'id="activity_" autocomplete="off" class="form-control" '); ?>
                <?php echo form_error('activity'); ?>
              </div>
            </div>

            <div class="row m-2">
              <label for="date_" class="col-md-3 form-label">Date <span class='required'>*</span></label>
              <div class="col-md-9">
                <div class="input-group">
                  <div class="input-group-text">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
                  <?php
                  $date = '';
                  if (!empty($result->date_) && $result->date_ > 10000) {
                    $date = date('d M Y', $result->date_);
                  } else {
                    $date = set_value('date_', (isset($result->date_)) ? $result->date_ : '');
                  }
                  echo form_input('date_', $date, 'class="form-control datepicker" placeholder="Choose date" autocomplete="off"');
                  echo form_error('date_');
                  ?>
                </div>
              </div>
            </div>

            <div class="row m-2">
              <label class="col-md-3 form-label">Teacher's Comment</label>
              <div class="col-md-9">
                <textarea id="teacher_comment" rows="5" class="form-control" name="teacher_comment"><?php echo set_value('teacher_comment', (isset($result->teacher_comment)) ? htmlspecialchars_decode($result->teacher_comment) : ''); ?></textarea>
                <?php echo form_error('teacher_comment'); ?>
              </div>
            </div>

            <div class="row m-2">
              <label for="photos" class="col-sm-3 form-label">Upload Photos</label>
              <div class="col-sm-9">
                <div class="input-group mb-3">
                  <input type="file" class="form-control" id="inputGroupFile02" name="file[]" accept="image/*" multiple>
                </div>
                <div id="container">
                  <!-- <a id="pickfiles" href="javascript:;" class="btn btn-custom btn-rounded">Select files</a> -->
                </div>
                <input type="hidden" id="pids" name="fids" value="0" />
                <div id="console"></div>
              </div>
            </div>


          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="form-check d-inline-block">

        </div>
        <div class="float-end d-inline-block btn-list">
          <button type="submit" class="btn btn-primary" id="auto-disappear-save"><i class="fe fe-check-square me-1 lh-base"></i>Submit</button>
          <a class="btn btn-secondary" id="cancelButton"><i class="fe fe-arrow-left-circle me-1 lh-base"></i>Cancel</a>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<?php echo form_close(); ?>