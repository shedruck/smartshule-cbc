<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>EXAM SETUP</b></h5>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>



      <div class="card-body p-2">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo   form_open_multipart(current_url(), $attributes);
        ?>
        <div class="row justify-content-center">
          <div class="col-dm-9 col-xl-9 col-lg-9 col-sm-12 mt-3 mb-3">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Title <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php echo form_input('exam', $result->exam, 'id="exam"  class="form-control" required'); ?>
                <?php echo form_error('exam'); ?>

              </div>
            </div>


            <div class="row m-2">
              <label for='term' class="col-md-3 form-label"> Term <span class='required'>*</span></label>
              <div class="col-md-9">
                <div class="input-group">
                  <?php
                  $terms = array('1' => 'Term 1', '2' => 'Term 2', '3' => 'Term 3');
                  echo form_dropdown('term', array('' => 'Select Term') + $terms, (isset($result->term)) ? $result->term : '', ' class="form-control select" id="term" data-placeholder="" required');
                  ?>
                  <?php echo form_error('term'); ?>
                </div>
              </div>
            </div>

            <div class="row m-2">
              <label for='year' class="col-md-3 form-label"> Year <span class='required'>*</span></label>
              <div class="col-md-9">
                <div class="input-group">
                  <?php

                  $currentYear = date('Y');
                  $years = range(2022, $currentYear);
                  $years = array_reverse($years);


                  $yearsAssoc = array_combine($years, $years);

                      // Add default option
                  $options = array('' => 'Select Year') + $yearsAssoc;
                  
                  echo form_dropdown('year', array('' => 'Select Year') + $options, (isset($result->year)) ? $result->year : '', ' class="form-control select" id="term" data-placeholder="" required');
                  ?>
                  <?php echo form_error('year'); ?>
                </div>
              </div>
            </div>

            <div class="row m-2">
              <label class="col-md-3 form-label" for='sdate'>Start Date <span class='required'>*</span></label>
              <div class="col-md-9">
                <div class="input-group">
                  <div class="input-group-text">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
                  <?php echo form_input('sdate', $result->sdate > 0 ? date('d M Y', $result->sdate) : $result->sdate, 'class="validate[required] form-control datepicker" placeholder="Choose date" required'); ?>
                </div>
              </div>
              <?php echo form_error('sdate'); ?>
            </div>

            <div class="row m-2">
              <label class="col-md-3 form-label" for='edate'>End Date <span class='required'>*</span></label>
              <div class="col-md-9">
                <div class="input-group">
                  <div class="input-group-text">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
                  <?php echo form_input('edate', $result->edate > 0 ? date('d M Y', $result->edate) : $result->edate, 'class="validate[required] form-control datepicker" placeholder="Choose date" required'); ?>
                </div>
              </div>
              <?php echo form_error('edate'); ?>
            </div>

            <div class="row m-2">
              <label class="col-md-3 form-label" for='rdate'>Recording Deadline <span class='required'>*</span></label>
              <div class="col-md-9">
                <div class="input-group">
                  <div class="input-group-text">
                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                  </div>
                  <?php echo form_input('rdate', $result->rdate > 0 ? date('d M Y', $result->rdate) : $result->rdate, 'class="validate[required] form-control datepicker" placeholder="Choose date" required'); ?>
                </div>
              </div>
              <?php echo form_error('rdate'); ?>
            </div>


          </div>
        </div>

      </div>
      <div class="card-footer">
        <div class="float-end">
          <?php echo anchor('trs', '<i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel', 'class="btn btn-secondary mb-1 d-inline-flex go_back"'); ?>
          <button type="submit" class="btn btn-info mb-1 d-inline-flex" onclick="return confirm('Are you sure?')">
            <i class="fe fe-check-square me-1 lh-base"></i>
            <?php echo ($updType == 'edit') ? 'Update' : 'Save'; ?>
          </button>

        </div>

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