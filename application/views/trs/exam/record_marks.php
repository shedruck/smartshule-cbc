<div class="portlet mt-2">
  <div class="portlet-heading portlet-default border-bottom">
    <h3 class="portlet-title text-dark">
      <b>Record Exam Marks</b>
    </h3>
    <div class="pull-right">
      <a class="btn btn-danger" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
    </div>
    <div class="clearfix"></div>
    <hr>
  </div>
  <div id="step1">
    <div class="panel panel-primary">
      <div class="panel-heading">Record Marks</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <?php echo form_open(base_url('trs/cbc_exams/assess_init'), ['id' => 'assess_initial']) ?>
            <div class="col-sm-3">
              <label>Exam Thread</label>
              <?php
              $options = array('' => '');
              foreach ($thread as $exam) {
                // Add each exam title to the options array
                $options[$exam->id] = $exam->title;
              }
              echo form_dropdown('thread', $options, $this->input->post('thread'), 'class="select" id="thread-dropdown" required');
              ?>
            </div>

            <div class="col-sm-4">
              <label>Class</label>
              <?php echo form_dropdown('class', ['' => ''] + $this->streams, $this->input->post('class'), 'class="select" required') ?>
            </div>

            <div class="col-sm-4">
              <label>Exam</label>
              <select name="exam" id="exam-dropdown" class="select" required>
                <option value="">Select an exam</option>
              </select>
            </div>

            <div style="float: right;">
              <br>
              <button type="submit" class="btn btn-primary">Record</button>
            </div>
            <?php echo form_close() ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="step2">
    <!-- Here -->
  </div>
</div>