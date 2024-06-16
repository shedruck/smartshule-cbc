<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><b>Record Attendance</b></h5>
        <div class="float-end">
          <?php echo anchor('class_attendance/trs/list', '<i class="mdi mdi-reply"></i> List All', 'class="btn btn-secondary"'); ?>
        </div>
      </div>

      <div class="card-body p-2">

        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo form_open_multipart(current_url(), $attributes);
        ?>
        <div class="row mb-4">
          <label for="attendance_date" class="col-md-2 form-label">Attendance Date <span class='required'>*</span></label>
          <div class="col-md-6">
            <div class="input-group">
              <div class="input-group-text">
                <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
              </div>
              <?php echo form_input('attendance_date', $result->attendance_date > 0 ? date('d M Y', $result->attendance_date) : $result->attendance_date, 'id="attendance_date" class="validate[required] form-control datepicker " placeholder="Choose date" required'); ?>
            </div>
            <?php echo form_error('attendance_date'); ?>
          </div>
        </div>

        <div class="row mb-4">
          <label for="title" class="col-md-2 form-label">Attendance For <span class='required'>*</span></label>
          <div class="col-md-6">
            <?php
            $items = array(
              'Whole Day' => 'Whole Day',
              "Morning" => "Morning Classes",
              "Evening" => "Evening Classes",
              "Class Time" => "Class Time",
            );
            echo form_dropdown('title', $items, (isset($result->title)) ? $result->title : '', 'class="form-select form-control" id="inputGroupSelect02"');
            echo form_error('title');
            ?>
          </div>
        </div>



        <?php if ($students) : ?>
          <!-- <table id="datatable-buttons" class="table table-striped table-bordered"> -->
          <div class="table-responsive">
            <table id="grid-example1" class="table table-bordered">
              <thead>
                <tr class="table-primary bg-primary">
                  <th class="tx-fixed-white" width="3">#</th>
                  <th class="tx-fixed-white">Student</th>
                  <th class="tx-fixed-white">
                    <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top secondary">
                      <input class="custom-control-input checks" id="user1" type="checkbox" name="present">
                      <label class="custom-control-label" for="user1">Present</label>
                    </div>


                  </th>
                  <th class="tx-fixed-white">
                    <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top secondary">
                      <input class="custom-control-input checkall" id="user2" type="checkbox" name="absent">
                      <label class="custom-control-label" for="user2">Absent</label>
                    </div>
                  </th>
                  <th class="tx-fixed-white">Temperature</th>
                  <th class="tx-fixed-white">Remarks</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($students as $post => $val) :
                ?>
                  <tr>
                    <td>
                      <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?></span>
                    </td>
                    <td>
                      <?php echo $val; ?>
                    </td>
                    <td>
                      <div class="form-check form-check-md">
                        <?php echo form_radio('status[' . $post . ']', 'Present', $result->status, 'class="switchx check-le form-check-input" id="Radio-md" style="margin: 0 auto;display: inline-block;"') ?>
                      </div>
                    </td>
                    <td style="text-align:center;">
                      <div class="form-check form-check-md">
                        <?php echo form_radio('status[' . $post . ']', 'Absent', $result->status, 'class="switchx check form-check-input" id="Radio-md" style="margin: 0 auto;display: inline-block;"') ?>
                        <?php echo form_error('status'); ?>
                      </div>
                    </td>
                    <td>
                      <input type="number" name="temperature[<?php echo $post ?>]" class="col-md-12 form-control" placeholder="Daily Temperature">
                    </td>
                    <td>
                      <textarea name="remarks[<?php echo $post; ?>]" cols="25" rows="1" class="col-md-12 form-control remarks  validate[required]" style="resize:vertical;" id="remarks"><?php echo set_value('remarks', (isset($result->remarks)) ? htmlspecialchars_decode($result->remarks) : ''); ?></textarea>
                    </td>
                  </tr>
                <?php
                  $i++;
                endforeach;
                ?>
              </tbody>

            </table>
          </div>


      </div>
      <div class="card-footer">
        <div class='form-group'>
          <div class="col-md-12 text-md-end">
            <?php echo anchor('class_attendance/trs/list', '<i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel', 'class="btn btn-secondary mb-1 d-inline-flex go_back"'); ?>
            <span></span>
            <?php
            $button_text = ($updType == 'edit') ? 'Update' : '<i class="fe fe-check-square me-1 lh-base"></i> Save';
            $button_attributes = ($updType == 'create') ? " id='submit' class='btn btn-info mb-1 d-inline-flex' onclick='return confirm(\"Are you sure?\")'" : "id='submit' class='btn btn-info mb-1 d-inline-flex' onclick='return confirm(\"Are you sure?\")'";
            ?>

            <button type="submit" <?php echo $button_attributes ?>><?php echo $button_text ?></button>

          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    <?php else : ?>
      <p class='text'><?php echo lang('web_no_elements'); ?></p>
    <?php endif ?>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("user1").addEventListener("change", function() {
      updatePresentRadioButtons(this.checked);
    });

    document.getElementById("user2").addEventListener("change", function() {
      updateAbsentRadioButtons(this.checked);
    });

    function updatePresentRadioButtons(isChecked) {
      var presentRadioButtons = document.querySelectorAll('.switchx.check-le[value="Present"]');
      presentRadioButtons.forEach(function(radioButton) {
        radioButton.checked = isChecked;
      });
    }

    function updateAbsentRadioButtons(isChecked) {
      var absentRadioButtons = document.querySelectorAll('.switchx.check[value="Absent"]');
      absentRadioButtons.forEach(function(radioButton) {
        radioButton.checked = isChecked;
      });
    }
  });
</script>
<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }

  /* style radio button */
  .custom-control-input:checked+.custom-control-label::before {
    border-color: #000000 !important;
    background-color: #000000 !important;
  }
</style>

<script>
  (function() {
    'use strict';

    function setOnClick(id, callback) {
      var element = document.getElementById(id);
      if (element) {
        element.onclick = callback;
      } else {
        console.warn(`Element with id "${id}" not found.`);
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      setOnClick('iisubmit', function() {
        var attendanceDate = document.getElementById('attendance_date').value;
        if (!attendanceDate) {
          console.warn('Attendance date field is empty.');
          return;
        }

        let timerInterval;
        Swal.fire({
          title: 'Saved!',
          text: 'Your changes have been saved.',
          icon: 'success',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: () => {
            const b = Swal.getHtmlContainer().querySelector('b');
            timerInterval = setInterval(() => {
              if (b) b.textContent = Swal.getTimerLeft();
            }, 100);
          },
          willClose: () => {
            clearInterval(timerInterval);
          }
        });
      });

      // Your existing SweetAlert functions here...

    });
  })();
</script>