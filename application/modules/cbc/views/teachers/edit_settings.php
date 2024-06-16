<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 d-flex align-items-center">
          <b>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings" style="margin-top:-5px;">
              <circle cx="12" cy="12" r="3"></circle>
              <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <span> EDIT EXAM SETTINGS</span>

          </b>
        </h6>

        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>

      <?php
      // echo "<pre>";
      // print_r($result);
      // echo "<pre>";
      
      ?>

      <div class="card-body p-2">

        <div class="row justify-content-center">
          <div class="col-dm-9 col-xl-6 col-lg-9 col-sm-12 mt-3 mb-3">

            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => 'form');
            echo form_open(current_url());
            ?>
            <div class="mb-3 m-2">
              <label class="form-label"><b>Exam Type</b></label>
              <div class="form-check form-check-inline">
                <?php
                echo form_radio(array(
                  'name' => 'type',
                  'id' => 'rubric',
                  'value' => 1,
                  'class' => 'form-check-input',
                  'checked' => (isset($result->type) && $result->type == '1') ? TRUE : FALSE,
                  'onclick' => "toggleComputeAverageDiv()"
                ));
                ?>
                <label class="form-check-label" for="rubric">Rubric</label>
              </div>
              <div class="form-check form-check-inline">
                <?php
                echo form_radio(array(
                  'name' => 'type',
                  'id' => 'marks',
                  'value' => 2,
                  'class' => 'form-check-input',
                  'checked' => (isset($result->type) && $result->type == '2') ? TRUE : FALSE,
                  'onclick' => "toggleComputeAverageDiv()"
                ));
                ?>
                <label class="form-check-label" for="marks">Marks</label>
              </div>
              <?php echo form_error('type'); ?>
            </div>

            
            <div class="mb-3 m-2">
              <label class="form-label"><b>Report Elements</b></label>
              <div class="mb-3 m-2">
                <label class="form-label">Report Options</label>
                <div class="form-check">
                  <?php
                  echo form_checkbox(array(
                    'name' => 'rubric',
                    'id' => 'rubric',
                    'value' => '1',
                    'class' => 'form-check-input',
                    'checked' => (isset($result->rubric) && $result->rubric == '1') ? TRUE : FALSE,
                  ));
                  ?>
                  <label class="form-check-label" for="rubric">Rubric</label>
                </div>
                <div class="form-check">
                  <?php
                  echo form_checkbox(array(
                    'name' => 'marks',
                    'id' => 'marks',
                    'value' => '1',
                    'class' => 'form-check-input',
                    'checked' => (isset($result->marks) && $result->marks == '1') ? TRUE : FALSE,
                  ));
                  ?>
                  <label class="form-check-label" for="marks">Marks</label>
                </div>
                <div class="form-check">
                  <?php
                  echo form_checkbox(array(
                    'name' => 'comments',
                    'id' => 'comments',
                    'value' => '1',
                    'class' => 'form-check-input',
                    'checked' => (isset($result->comments) && $result->comments == '1') ? TRUE : FALSE,
                  ));
                  ?>
                  <label class="form-check-label" for="comments">Comments</label>
                </div>
                <div class="form-check">
                  <?php
                  echo form_checkbox(array(
                    'name' => 'teacher',
                    'id' => 'teacher',
                    'value' => '1',
                    'class' => 'form-check-input',
                    'checked' => (isset($result->teacher) && $result->teacher == '1') ? TRUE : FALSE,
                  ));
                  ?>
                  <label class="form-check-label" for="teacher">Teacher</label>
                </div>
                <div class="form-check">
                  <?php
                  echo form_checkbox(array(
                    'name' => 'grade',
                    'id' => 'grade',
                    'value' => '1',
                    'class' => 'form-check-input',
                    'checked' => (isset($result->grade) && $result->grade == '1') ? TRUE : FALSE,
                  ));
                  ?>
                  <label class="form-check-label" for="grade">Grade</label>
                </div>
                <div class="form-check">
                  <?php
                  echo form_checkbox(array(
                    'name' => 'position',
                    'id' => 'position',
                    'value' => '1',
                    'class' => 'form-check-input',
                    'checked' => (isset($result->position) && $result->position == '1') ? TRUE : FALSE,
                  ));
                  ?>
                  <label class="form-check-label" for="position">Position</label>
                </div>
              </div>
              <?php echo form_error('exam_types[]'); ?>
            </div>


          </div>

        </div>
      </div>
      <div class="card-footer">
        <div class="m-2 float-end d-inline-block">
          <button type="submit" class="btn btn-primary mb-1 d-inline-flex" onclick="return confirm('Are you sure?')">
            <i class="fe fe-check-square me-1 lh-base"></i>
            <?php echo ($updType == 'edit') ? 'Update' : 'Save'; ?>
          </button>
        </div>
        <?php echo form_close(); ?>
      </div>


    </div>
  </div>
</div>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }

  .d-flex {
    display: flex;
  }

  .align-items-center {
    align-items: center;
  }
</style>

<script>
  function toggleComputeAverageDiv() {
    // Check if the "Marks" radio button is selected
    if (document.getElementById('marks').checked) {
      // Show the compute average div
      document.getElementById('computeAverageDiv').style.display = 'block';
    } else {
      // Hide the compute average div
      document.getElementById('computeAverageDiv').style.display = 'none';
    }
  }

  // Initial check on page load
  document.addEventListener('DOMContentLoaded', function() {
    toggleComputeAverageDiv();
  });
</script>