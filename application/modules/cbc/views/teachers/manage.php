<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->


<?php if ($this->session->flashdata('created_message')) : ?>
  <div class="alert-container inserted-alert">
    <div class="alert alert-solid-success" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
      <i class="fa fa-check-circle-o me-2" aria-hidden="true"></i><?php echo $this->session->flashdata('created_message')['text']; ?>
    </div>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">

        <h6 class="float-start text-uppercase"><b><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings" style="margin-top:-5px;">
              <circle cx="12" cy="12" r="3"></circle>
              <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg><?php echo $result->exam . ' EXAM SETTINGS' ?></b></h6>
        <div class="float-end">
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body p-3 mb-2">
        <div class="table-responsive">
          <table class="table table-bordered" id="grid-example1">
            <thead>
              <tr>
                <th>#</th>
                <th>Class</th>
                <th>Lock/Unlock</th>
                <th>Publish</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              foreach ($classes as $s) {
                $i++;
              ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $s->name; ?></td>
                  <td><button class="btn btn-success btn-sm"> <i class="fas fa-lock"></i> Lock</button></td>
                  <td><button class="btn btn-warning btn-sm"> <i class="fas fa-upload"></i> Publish</button></td>
                  <td>
                    <?php
                    $this->load->model('cbc_tr');

                    $result =  $this->cbc_tr->get_settings($s->id, $exam);

                    if (empty($result)) { ?>
                      <button class="btn btn-primary btn-sm off-canvas" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_<?php echo $s->id ?>" aria-controls="offcanvasRight_<?php echo $s->id ?>">
                        <i class="ri-settings-4-line label-btn-icon me-2"></i> Settings <span class="caret"></span>
                      </button>
                    <?php  } else { ?>
                      <button class="btn btn-link btn-info btn-sm" style="min-width:88px" type="button" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse_<?php echo $s->id; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $s->id; ?>" onclick="toggleAccordion('<?php echo $s->id; ?>')">
                        <i class="fas fa-eye"></i> View
                      </button>

                    <?php }

                    ?>

                  </td>
                </tr>

                <tr id="accordion_row_<?php echo $s->id ?>" style="display: none;">
                  <?php

                  if ($result->rubric == 1) {
                    $rubic = "Rubric";
                  } else {
                    $rubic = "";
                  }
                  if ($result->marks == 1) {
                    $marks = "Marks";
                  } else {
                    $marks = "";
                  }
                  if ($result->comments == 1) {
                    $comment = "Comments";
                  } else {
                    $comment = "";
                  }
                  if ($result->teacher == 1) {
                    $teacher = "Teacher";
                  } else {
                    $teacher = "";
                  }
                  if ($result->grade == 1) {
                    $grade = "Grade";
                  } else {
                    $grade = "";
                  }
                  if ($result->position == 1) {
                    $position = "Position";
                  } else {
                    $position = "";
                  }

                  ?>
                  <td colspan="5">
                    <div class="collapse" id="collapse_<?php echo $s->id ?>">
                      <div class="card">
                        <div class="card-header">
                          <h6 class="mb-0"><b>Exam Setting</b></h6>
                        </div>
                        <div class="card-body">
                          <table id="table-bordered" class="table-bordered">
                            <thead>
                              <th>Exam Type</th>
                              <th>Report Items</th>
                              <th>Grading</th>
                              <th>Action</th>
                            </thead>
                            <tbody>
                              <tr>
                                <td><?php
                                    if ($result->type == 1) {
                                      echo "Rubric";
                                    } else {
                                      echo "Marks";
                                    }
                                    ?></td>
                                <td>
                                  <?php
                                  echo $rubic . ',' . $marks . ',' . $comment . ',' . $teacher . ',' . $grade . ',' . $position;
                                  ?>
                                </td>
                                <td><?php echo $gradings[$result->gs_system] ?></td>
                                <td> <a href="<?php echo base_url('cbc/trs/edit_settings') . '/' . $result->id . '/' . $exam . '/' . $s->id; ?>" class="btn btn-primary btn-sm"> <i class="ri-settings-4-line label-btn-icon me-2"></i> Edit <span class="caret"></span></a>

                                </td>
                              </tr>
                            </tbody>

                          </table>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>

                <!-- Offright Canvas -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight_<?php echo $s->id ?>">
                  <div class="offcanvas-header">
                    <h6 class="fw-bold offcanvas-title"><span id="cls"></span> Exam Setting </h6>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fe fe-x fs-18"></i></button>
                  </div>
                  <div class="offcanvas-body">
                    <div>
                      <h6 class="mb-3 fw-bold" id="class_name"></h6>
                      <ul class="list-group list-group-flush border">
                        <div class="mb-2" id="myload" style="display: none; border:none">
                          <div class="s-body d-flex justify-content-center align-items-center flex-wrap gap-1"></div>
                        </div>
                        <div id="data-container" style="bottom:0">
                          <?php
                          $attributes = array('class' => 'form-horizontal', 'id' => 'form_' . $s->id);
                          echo form_open(base_url('cbc/trs/save_setting/' . $exam . '/' . $s->id), $attributes);
                          ?>
                          <div class="mb-3 m-2">
                            <label class="form-label"><b>Exam Type</b></label>
                            <div class="form-check form-check-inline">
                              <?php
                              echo form_radio(array(
                                'name' => 'type_' . $s->id,
                                'id' => 'rubric_' . $s->id,
                                'value' => 1,
                                'class' => 'form-check-input',
                                'checked' => (isset($result->type) && $result->type == 'rubric') ? TRUE : FALSE,
                                'onclick' => "toggleComputeAverageDiv({$s->id})"
                              ));
                              ?>
                              <label class="form-check-label" for="rubric_<?php echo $s->id; ?>">Rubric</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <?php
                              echo form_radio(array(
                                'name' => 'type_' . $s->id,
                                'id' => 'marks_' . $s->id,
                                'value' => 2,
                                'class' => 'form-check-input',
                                'checked' => (isset($result->type) && $result->type == 'marks') ? TRUE : FALSE,
                                'onclick' => "toggleComputeAverageDiv({$s->id})"
                              ));
                              ?>
                              <label class="form-check-label" for="marks_<?php echo $s->id; ?>">Marks</label>
                            </div>
                            <?php echo form_error('type_' . $s->id); ?>
                          </div>

                         
                          <div class="mb-3 m-2">
                            <label class="form-label"><b>Report Elements</b></label>
                            <div class="mb-3 m-2">
                              <label class="form-label">Report Options</label>
                              <div class="form-check">
                                <?php
                                echo form_checkbox(array(
                                  'name' => 'rubric_' . $s->id,
                                  'id' => 'rubric_' . $s->id,
                                  'value' => '1',
                                  'class' => 'form-check-input',
                                  'checked' => (isset($result->rubric) && $result->rubric == '1') ? TRUE : FALSE,
                                ));
                                ?>
                                <label class="form-check-label" for="rubric_<?php echo $s->id; ?>">Rubric</label>
                              </div>
                              <div class="form-check">
                                <?php
                                echo form_checkbox(array(
                                  'name' => 'marks_' . $s->id,
                                  'id' => 'marks_' . $s->id,
                                  'value' => '1',
                                  'class' => 'form-check-input',
                                  'checked' => (isset($result->marks) && $result->marks == '1') ? TRUE : FALSE,
                                ));
                                ?>
                                <label class="form-check-label" for="marks_<?php echo $s->id; ?>">Marks</label>
                              </div>
                              <div class="form-check">
                                <?php
                                echo form_checkbox(array(
                                  'name' => 'comments_' . $s->id,
                                  'id' => 'comments_' . $s->id,
                                  'value' => '1',
                                  'class' => 'form-check-input',
                                  'checked' => (isset($result->comments) && $result->comments == '1') ? TRUE : FALSE,
                                ));
                                ?>
                                <label class="form-check-label" for="comments_<?php echo $s->id; ?>">Comments</label>
                              </div>
                              <div class="form-check">
                                <?php
                                echo form_checkbox(array(
                                  'name' => 'teacher_' . $s->id,
                                  'id' => 'teacher_' . $s->id,
                                  'value' => '1',
                                  'class' => 'form-check-input',
                                  'checked' => (isset($result->teacher) && $result->teacher == '1') ? TRUE : FALSE,
                                ));
                                ?>
                                <label class="form-check-label" for="teacher_<?php echo $s->id; ?>">Teacher</label>
                              </div>
                              <div class="form-check">
                                <?php
                                echo form_checkbox(array(
                                  'name' => 'grade_' . $s->id,
                                  'id' => 'grade_' . $s->id,
                                  'value' => '1',
                                  'class' => 'form-check-input',
                                  'checked' => (isset($result->grade) && $result->grade == '1') ? TRUE : FALSE,
                                ));
                                ?>
                                <label class="form-check-label" for="grade_<?php echo $s->id; ?>">Grade</label>
                              </div>
                              <div class="form-check">
                                <?php
                                echo form_checkbox(array(
                                  'name' => 'position_' . $s->id,
                                  'id' => 'position_' . $s->id,
                                  'value' => '1',
                                  'class' => 'form-check-input',
                                  'checked' => (isset($result->position) && $result->position == '1') ? TRUE : FALSE,
                                ));
                                ?>
                                <label class="form-check-label" for="position_<?php echo $s->id; ?>">Position</label>
                              </div>
                            </div>
                            <?php echo form_error('exam_types[]'); ?>
                          </div>
                          <div class="m-2 float-end d-inline-block">
                            <button type="submit" class="btn btn-info mb-1 d-inline-flex" onclick="return confirm('Are you sure?')">
                              <i class="fe fe-check-square me-1 lh-base"></i>
                              <?php echo ($updType == 'edit') ? 'Update' : 'Save'; ?>
                            </button>
                          </div>
                          <?php echo form_close(); ?>
                        </div>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- Offright Canvas End-->
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card-footer">
        <div class="form-check d-inline-block">
          <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
        </div>
        <div class="float-end d-inline-block btn-list">

        </div>
      </div>
    </div>
  </div>

  < </div>
    <style>
      .card-header {
        display: flex;
        justify-content: space-between;
      }

      .inserted-alert {
        position: fixed;
        top: 20px;
        /* Adjust as needed */
        right: 20px;
        /* Adjust as needed */
        z-index: 1000;
        /* Ensure it appears above other content */
      }

      .updated-alert {
        position: fixed;
        top: 70px;
        /* Adjust as needed */
        right: 20px;
        /* Adjust as needed */
        z-index: 1000;
        /* Ensure it appears above other content */
      }


      .alert {
        position: relative;
      }

      .btn-link {
        text-decoration: none !important;
        /* Remove underline */
      }

      tr {
        margin: 0;
        padding: 0;
      }
    </style>

    <script>
      $(document).ready(function() {
        $('[data-bs-target="#offcanvasRight"]').click(function() {
          var id = $(this).data('id');
          $("#cls").text(id);
          // Now you can use the 'id' variable to perform further actions
          console.log('Button clicked with id:', id);
        });
      });
    </script>

    <script>
      function toggleAccordion(id) {
        var accordionRow = document.getElementById('accordion_row_' + id);
        accordionRow.style.display = accordionRow.style.display === 'none' ? 'table-row' : 'none';
      }
    </script>

    <script>
      function toggleComputeAverageDiv(id) {
        if (document.getElementById('marks_' + id).checked) {
          document.getElementById('computeAverageDiv_' + id).style.display = 'block';
        } else {
          document.getElementById('computeAverageDiv_' + id).style.display = 'none';
        }
      }

      // Initial check on page load
      document.addEventListener('DOMContentLoaded', function() {
        var id = <?php echo $s->id; ?>;
        toggleComputeAverageDiv(id);
      });
    </script>