<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="float-start m-0">Change Password</h6>
        <div class="float-end">
          <?php echo anchor('trs/', '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-secondary"'); ?>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="row justify-content-center">
          <div class="col-dm-8 col-xl-8 col-lg-8 col-sm-12 mt-3 mb-3">
            <?php echo form_open(current_url(), 'class="form-horizontal" '); ?>
            <div class="row m-2">
              <label for="old_password" class="col-md-3 form-label">Old Password <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php echo form_input($old_password); ?>
                <?php echo form_error('old', '<p class="required">', '</p>'); ?>
              </div>
            </div>

            <div class="row m-2">
              <label for="new_password" class="col-md-3 form-label">New Password (at least <?php echo $min_password_length; ?> characters long): <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php echo form_input($new_password); ?>
                <?php echo form_error('new', '<p class="required">', '</p>'); ?>
              </div>
            </div>
            <div class="row m-2">
              <label for="new_confirm" class="col-md-3 form-label"> Confirm New Password <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php echo form_input($new_password_confirm); ?>
                <?php echo form_error('new_confirm', '<p class="required">', '</p>'); ?>
              </div>
            </div>
            <?php echo form_input($user_id); ?>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="form-check d-inline-block">

        </div>
        <div class="float-end d-inline-block btn-list">
          <!-- <button type="submit" class="btn btn-primary" id="submit"><i class="fe fe-check-square me-1 lh-base"></i>Submit</button> -->
          <?php echo form_submit('submit', 'Change', "id='submit' class='btn btn-primary btn-small'"); ?>
          <?php echo anchor('trs', '<i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel', 'class="btn  btn-secondary"'); ?>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>