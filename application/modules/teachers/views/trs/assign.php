<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-uppercase"><b>ASSIGN SUBJECTS</b></h6>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'form');
        echo form_open(current_url());
        ?>
        <div class="row">
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Class <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $options = array('' => 'Select Class') + $this->streams;
                $attributes = 'class="form-control js-example-basic-single" id="class"';
                echo form_dropdown('class', $options, $class, $attributes);
                ?>
                <?php echo form_error('class'); ?>

              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Teacher <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $options = array('' => 'Select Teacher') + $teachers;
                $attributes = 'class="form-control js-example-basic-single"';
                echo form_dropdown('teacher', $options, $teacher, $attributes);
                ?>
                <?php echo form_error('teacher'); ?>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for="title">System <span class="required">*</span></label>
              <div class="col-md-9">
                <?php
                $option = array('' => 'Select System', '1' => '8.4.4 / IGCSE', '2' => 'CBC');
                $attributes = 'class="form-control js-example-basic-single" id="type"';
                echo form_dropdown('type', $option, $type, $attributes);
                ?>
                <?php echo form_error('type'); ?>
              </div>
            </div>
          </div>


        </div>

        <div class="row">
          <!-- Second Row -->
          <div class="col-xl-12">
            <div class="row m-2 justify-content-end">

              <div class="col-auto">
                <button type="submit" class="btn btn-warning mb-1 d-inline-flex">
                  <i class="fas fa-filter me-1 lh-base"></i>
                  <?php echo ($updType == 'edit') ? 'Update' : 'filter'; ?>
                </button>
                <button class="btn btn-info" onclick="printInvoice(event)"> <i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>

      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>



<!-- card -->
<?php if ($this->input->post()) {

?>
  <div class="row">
    <div class="col-md-12">
      <div class="card">


        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0 text-uppercase"><b>ASSIGN <span class="text-secondary"> <?php echo $teachers[$teacher] ?> </span> SUBJECTS</b></h6>
          <div>

          </div>
        </div>

        <div class="card-body p-0">

          <div class="d-lg-flex d-block">
            <div class="p-4 border-end w-100">

              <?php
              $attributes = array('class' => 'form-horizontal', 'id' => '');
              echo   form_open_multipart(base_url('teachers/trs/save_assign/'), $attributes);
              ?>
              <div class="row justify-content-center">
                <div class="col-dm-9 col-xl-12 col-lg-9 col-sm-12 mt-3 mb-3">


                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tr class="bg-primary">
                        <th class="text-center tx-fixed-white">#</th>
                        <th class="text-center tx-fixed-white">Subject</th>
                        <th class="text-center tx-fixed-white">Assign</th>
                      </tr>
                      <tbody>
                        <?php
                        if (!empty($subs)) {
                          $i = 1;
                          foreach ($subs as $key => $sub) {
                            # code...

                        ?>
                            <tr>
                              <td><?php echo $i++ ?></td>
                              <td><?php echo $sub->name ?></td>
                              <td style="text-align:center"><?php
                                                            // Initialize a variable to track if the checkbox should be checked
                                                            $checked = '';
                                                            foreach ($result as $k => $rs) {
                                                              if ($rs->subject == $sub->id) {
                                                                $checked = 'checked';
                                                                break; // Exit the loop once a match is found
                                                              }
                                                            }
                                                            ?>
                                <div class="custom-checkbox-lg">
                                  <input class="form-check-input ms-2 checkbox-toggle" type="checkbox" id="checkbox-lg" data-subject-id="<?php echo $sub->id ?>" data-class="<?php echo $class ?>" data-teacher="<?php echo $teacher ?>" data-type="<?php echo $type ?>" data-term="<?php echo $this->school->term ?>" data-year="<?php echo $this->school->year ?>" name="assign_<?php echo $sub->id; ?>" value="1" <?php echo $checked; ?>>
                                </div>

                                <!-- Add hidden fields -->
                                <?php echo form_hidden('class', $class); ?>
                                <?php echo form_hidden('teacher', $teacher); ?>
                                <?php echo form_hidden('type', $type); ?>
                              </td>
                            </tr>


                          <?php   }
                        } else { ?>
                          <tr>
                            <td colspan="2">
                              <div class="alert alert-danger">No subjects Assigned to this Class !!!</div>
                            </td>
                          </tr>
                        <?php }

                        ?>
                      </tbody>
                    </table>
                  </div>

                </div>
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
                        <p class="card-text text-muted">Click the checkbox Buttons to Assign <span class="text-secondary"> <?php echo $teachers[$teacher] ?> </span> Subjects !!!</p>
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
          <!-- end of table  -->


        </div>

        <!-- end of card -->
      </div>
      <?php echo form_close(); ?>
    </div>
  <?php } ?>
  <style>
    .card-header {
      display: flex;
      justify-content: space-between;
    }

    .custom-checkbox-lg .form-check-input {
      width: 16px;
      height: 16px;
      transform: scale(1.5);
      margin-right: 10px;

    }

    /* Optionally, adjust the checkbox appearance for different states */
    .custom-checkbox-lg .form-check-input:checked {
      background-color: #00A5A3;
      /* Bootstrap primary color */
    }

    /* Loader CSS */
    .loader-container {
      display: none;
      position: absolute;
      top: 60%;
      left: 50%;
      transform: translate(-50%, -50%);
      /* Center the loader container horizontally and vertically */
      z-index: 1000;
      /* Ensure the loader is on top of other elements */
      border: none;
      /* Remove the border */
    }

    
  </style>


  <!-- Loader HTML -->
  <div class="loader-container text-center loading">
    <div class="lds-spinner">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('.checkbox-toggle').on('change', function() {
        // Extract data attributes
        var subjectId = $(this).data('subject-id');
        var classId = $(this).data('class');
        var teacherId = $(this).data('teacher');
        var typeId = $(this).data('type');
        var termId = $(this).data('term');
        var yearId = $(this).data('year');

        // Determine if checkbox is checked or unchecked
        var isChecked = $(this).prop('checked');

        // Show the loader
        $('.loading').show();

        // Send AJAX request
        $.ajax({
          url: '<?php echo base_url('teachers/trs/delete_assign'); ?>',
          type: 'POST',
          data: {
            subject_id: subjectId,
            class: classId,
            teacher: teacherId,
            type: typeId,
            year: yearId,
            term: termId,
            checked: isChecked ? 1 : 0
          },
          success: function(response) {
            console.log('Subject Teacher updated successfully');

            // Hide the loader and refresh the page after 2 seconds
            setTimeout(function() {
              $('.loading').hide();
              location.reload();
            }, 1000);
          },
          error: function() {
            alert('An error occurred while updating the database');
            $('.loading').hide();
          }
        });
      });
    });
  </script>