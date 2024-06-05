<?php

$rankings = array('1' => 'BE', '2' => 'AE', '3' => 'ME', '4' => 'EE');

$comments = array('1' => 'Below Expectation', '2' => 'Approaching Expectation', '3' => 'Meeting Expectation', '4' => 'Exceeding Expectation');

$this->load->model('cbc_tr');


?>

<div class="row hidden-print">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6><b>CBC Summative Report</b></h6>
      </div>
      <div class="card-body">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'form');
        echo form_open(current_url());

        $selected_exam = isset($exam) ? $exam : '';
        $selected_class = isset($class) ? $class : '';
        $selected_student = isset($student) ? $student : '';
        ?>
        <div class="row">
          <div class="col-md-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Exam <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $exams = array('' => 'Select Exam') + $exams;
                $attributes = 'class="form-control js-example-basic-single"';
                echo form_dropdown('exam', $exams, $selected_exam, $attributes);
                ?>
                <?php echo form_error('exam'); ?>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="row m-2">
              <label class="col-md-4 form-label" for='title'>Class <span class='required'>*</span></label>
              <div class="col-md-8">
                <?php
                $options = array('' => 'Select Class') + $this->streams;
                $attributes = 'class="form-control js-example-basic-single"  id="classDropdown"';
                echo form_dropdown('class', $options, $selected_class, $attributes);
                ?>
                <?php echo form_error('class'); ?>
              </div>
            </div>
          </div>

          <div class="col-md-1 text-center d-flex align-items-center justify-content-center">
            <label class="form-label mb-0" for='title'>OR</label>
          </div>

          <div class="col-md-4">
            <div class="row m-2">
              <label class="col-md-4 form-label" for='title'>Student <span class='required'>*</span></label>
              <div class="col-md-8">
                <?php
                $options = array('' => 'Select Student');
                $attributes = 'class="form-control js-example-basic-single" id="studentDropdown"';
                echo form_dropdown('student', $options, $selected_student, $attributes);
                ?>
                <?php echo form_error('student'); ?>
              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-xl-12">
            <div class="row m-2 justify-content-end">
              <div class="col-auto">
                <button type="submit" class="btn btn-warning mb-1 d-inline-flex me-2">
                  <i class="fas fa-filter me-1 lh-base"></i>
                  <?php echo ($updType == 'edit') ? 'Update' : 'Filter'; ?>
                </button>
                <button class="btn btn-info" onclick="printPage()">
                  <i class=" fas fa-print"></i> Print
                </button>
              </div>
            </div>
          </div>
        </div>



      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- // Display the grouped results -->

<?php if ($ex->type == 1) {
  if ($this->input->post()) {
    if ($grouped_marks) {

      $total_students = count($grouped_marks); // Count the total number of students
      $current_student = 0; // Initialize the current student counter

      foreach ($grouped_marks as $ky => $st) {
        $current_student++; // Increment the current student counter
?>
        <div class="invoice-box main-content app-content mt-0">
          <table cellpadding="0" cellspacing="0">
            <tr class="top">
              <td colspan="2">
                <table>
                  <tr>
                    <td class="title" style="width: 16%;">
                      <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" style="height:68px;" alt="header">
                    </td>
                    <td style="width: 66%;" class="text-center">
                      <?php
                      $stu = $this->worker->get_student($ky);
                      $birthdateTimestamp = $stu->dob;

                      $birthDateTime = new DateTime();
                      $birthDateTime->setTimestamp($birthdateTimestamp);

                      $currentDateTime = new DateTime();

                      $ageInterval = $currentDateTime->diff($birthDateTime);

                      $age = $stu->dob === "" ? "---" : $ageInterval->y;

                      $this->load->model('cbc_tr');
                      ?>
                      <h4>SUMMATIVE REPORT</h4>
                      <h6 class="upper-case"><b>NAME:</b> <u><?php echo $stu->first_name . ' ' . $stu->last_name ?> </u>&nbsp; <b>ADM NO:</b> <u><?php echo $stu->admission_number ?> </u> &nbsp; <b>AGE:</b> <u><?php echo  $age; ?></u></h6>
                      <span class="upper-case"><?php echo strtoupper($stu->cl->name) . ", TERM " . $term . ' ' . $year ?></span><br>

                      <div class="key-container">
                        <div class="key-item key-title">Key:</div>
                        <div class="key-item">4 = EE</div>
                        <div class="key-item">3 = ME</div>
                        <div class="key-item">2 = AE</div>
                        <div class="key-item">1 = BE</div>
                      </div>
                    </td>
                    <td style="width: 16%;">
                      <?php if ($passport) { ?>
                        <div class="img-container right">
                          <img src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" style="height:68px;" alt="header">
                        </div>
                      <?php } ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <table class="table table-bordered">
            <tr class="table-success">
              <th>#</th>
              <th>Subject</th>
              <th>Score</th>
              <th>Comment</th>
              <th>Teacher</th>
            </tr>
            <tbody>
              <?php
              $i = 1;
              foreach ($st as $sub => $subs) {
                foreach ($subs as $kety => $v) { ?>
                  <tr style="font-size: 14px; text-align:center">
                    <td><?php echo $i++ ?></td>
                    <td style="text-align:left"><?php echo $subjects[$sub] ?></td>
                    <td style="text-align:center"><?php echo $v['score'] . " (" . $rankings[$v['score']] . ' )'; ?></td>
                    <td style="text-align:left"><?php echo $comments[$v['score']]; ?></td>
                    <td><?php
                        $this->load->model('teachers/teachers_m');
                        $trs = $this->cbc_tr->get_teachers($class, $term, $year, $sub);
                        $td = $this->teachers_m->find($trs->teacher);
                        echo $td->first_name . ' ' . $td->last_name;
                        ?></td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>

          <hr>
          <div class="col-xl-12 mt-2">
            <?php
            $updated_value = $this->cbc_tr->get_field($ky, $exam);
            $teacher_comment = $this->cbc_tr->get_tr_remarks($ky, $exam);
            ?>
            <div class="row">
              <div class="col-xl-7">
                <h6 style="font-size:13px;"><strong>GENERAL REMARKS ON SUMMATIVE ASSESSMENT</strong></h6>
                <p>
                  <textarea class="inputField dotted-underline" data-ky="<?php echo $ky; ?>" placeholder="Type remarks here..." style="max-width: 400px; width: 100%; overflow: hidden; resize: none; height: auto; line-height: 1.5;"><?php echo $updated_value ?></textarea>
                </p>
              </div>
              <div class="col-xl-5">
                <h6 style="font-size:13px;"><strong>Signiture</strong></h6>
              </div>

            </div>

          </div>

          <div class="col-xl-12">
            <h6 style="font-size:13px;"><strong>Class teacher’s comments:</strong></h6>
            <p>
              <textarea class="commentField dotted-underline" data-ky="<?php echo $ky; ?>" placeholder="Type your comment..." style="max-width: 400px; width: 100%; overflow: hidden; resize: none; height: auto; line-height: 1.5;"><?php echo $teacher_comment ?></textarea>
            </p>
          </div>

        </div>
        <?php if ($current_student < $total_students) { ?>
          <p class="page-break"></p>
        <?php } ?>

      <?php }
    } else { ?>
      <div class="row">
        <p class="alert alert-danger">No results found !</p>
      </div>
      <?php }
  }
} else {
  if ($this->input->post()) {
    if ($reports) {

      $total_students = count($reports);
      $current_student = 0;

      foreach ($reports as $ky => $st) {
        $current_student++;
      ?>
        <!-- Marks report -->
        <div class="invoice-box main-content app-content mt-0">
          <table cellpadding="0" cellspacing="0">
            <tr class="top">
              <td colspan="2">
                <table>

                  <tr>
                    <td class="title" style="width: 16%;">
                      <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" style="height:68px;" alt="header">
                    </td>

                    <td style=" width: 66%;" class="text-center  justify-content-center">
                      <?php
                      $stu = $this->worker->get_student($ky);
                      $birthdateTimestamp = $stu->dob;

                      $scl = $this->cbc_tr->get_exam($exams[0]);

                      $birthDateTime = new DateTime();
                      $birthDateTime->setTimestamp($birthdateTimestamp);

                      $currentDateTime = new DateTime();

                      // Calculate the difference
                      $ageInterval = $currentDateTime->diff($birthDateTime);


                      if ($stu->dob === "") {
                        $age = "---";
                      } else {
                        $age = $ageInterval->y;
                      }

                      $this->load->model('cbc_tr');


                      ?>
                      <h4>SUMMATIVE REPORT</h4>
                      <h6 class="upper-casr"><b>NAME:</b> <u><?php echo $stu->first_name . ' ' . $stu->last_name ?> </u>&nbsp; <b>ADM NO:</b> <u><?php echo $stu->admission_number ?> </u> &nbsp; <b>AGE:</b> <u><?php echo  $age; ?></u></h6>
                      <span class="upper_case"><?php echo strtoupper($stu->cl->name) . ", TERM " . $term . ' ' . $year ?></span><br>

                      <div class="key-container">
                        <div class="key-item key-title">Key:</div>
                        <div class="key-item">4 = EE</div>
                        <div class="key-item">3 = ME</div>
                        <div class="key-item">2 = AE</div>
                        <div class="key-item">1 = BE</div>
                      </div>
                    </td>

                    <td style=" width: 16%;">
                      <?php if ($passport) { ?>
                        <div class="img-container right">
                          <img src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" style="height:68px;" alt="header">
                        </div>
                      <?php } ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>


          <table class="table table-bordered">
            <tr class="table-success">
              <th>#</th>
              <th>Subject</th>
              <th>Score <?php ?></th>

              <?php
              $cls = $this->cbc_tr->get_classes($class);
              $set = $this->cbc_tr->get_settings($cls->class, $exam);
              if ($set->grade == 1) { ?>
                <th>Grade</th>
              <?php  }

              ?>
              <?php
              $cls = $this->cbc_tr->get_classes($class);
              $set = $this->cbc_tr->get_settings($cls->class, $exam);
              if ($set->comments == 1) { ?>
                <th>Comment</th>
              <?php  }

              ?>
              <th>Teacher</th>
            </tr>
            <tbody>
              <?php
              $i = 1;
              foreach ($st as $sub => $subs) {
                foreach ($subs as $kety => $v) {
                  # code...

                  $m0 = $m1 = $m2 = $ot0 = $ot1 = $ot2 = null;

              ?>
                  <tr style="font-size: 14px; text-align:center">
                    <td><?php echo $i++ ?></td>
                    <td style="text-align:left"><?php echo $subjects[$sub] ?></td>
                    <td><?php

                        $m1 = $v['score'];
                        $ot1 = $v['outof'];


                        $quarterSize = $ot1 / 4;
                        $firstQuarterEnd = $quarterSize;
                        $secondQuarterEnd = $quarterSize * 2;
                        $thirdQuarterEnd = $quarterSize * 3;
                        $fourthQuarterEnd = $ot1;

                        if ($m1 <= $firstQuarterEnd) {
                          $cm = "BE";
                        } elseif ($m1 <= $secondQuarterEnd) {
                          $cm = "AE";
                        } elseif ($m1 <= $thirdQuarterEnd) {
                          $cm = "ME";
                        } elseif ($m1 <= $fourthQuarterEnd) {
                          $cm = "EE";
                        } else {
                          $cm = "Value out of range";
                        }


                        $cls = $this->cbc_tr->get_classes($class);
                        $set = $this->cbc_tr->get_settings($cls->class, $exam);

                        if ($set->marks == 1 && $set->rubric == 1) {
                          echo $m1 . " (" . $cm . ")";
                        } elseif ($set->marks == 0 && $set->rubric == 1) {
                          echo $cm;
                        } elseif ($set->marks == 1 && $set->rubric == 0) {
                          echo $m1;
                        }
                        ?></td>



                    <!-- GRades -->
                    <?php
                    $cls = $this->cbc_tr->get_classes($class);
                    $set = $this->cbc_tr->get_settings($cls->class, $exam);
                    if ($set->grade == 1) { ?>
                      <td>
                        <?php
                        $grades = $this->cbc_tr->get_grades($set->gs_system);
                        $score = $m1;
                        foreach ($grades as $grade) {
                          if (
                            $score >= $grade->minimum_marks && $score <= $grade->maximum_marks
                          ) {
                            echo $grade->grade;
                          }
                        }

                        ?>
                      </td>
                    <?php  }

                    ?>

                    <!-- comments -->
                    <?php
                    $cls = $this->cbc_tr->get_classes($class);
                    $set = $this->cbc_tr->get_settings($cls->class, $exam);
                    if ($set->comments == 1) { ?>
                      <td style="text-align:left">
                        <?php
                        $grades = $this->cbc_tr->get_grades($set->gs_system);
                        $score = $m1;
                        foreach ($grades as $grade) {
                          if (
                            $score >= $grade->minimum_marks && $score <= $grade->maximum_marks
                          ) {
                            echo $grade->comment;
                          }
                        }

                        ?>
                      </td>
                    <?php  }

                    ?>

                    <td> <?php
                          $this->load->model('teachers/teachers_m');
                          $trs = $this->cbc_tr->get_teachers($class, $term,  $year, $sub);
                          $td = $this->teachers_m->find($trs->teacher);
                          echo $td->first_name . ' ' . $td->last_name;

                          ?></td>
                  </tr>
              <?php
                }
              }
              ?>
            </tbody>
          </table>


          <hr>
          <div class="col-xl-12 mt-2">
            <?php
            $updated_value = $this->cbc_tr->get_field($ky, $exam);

            $teacher_comment = $this->cbc_tr->get_tr_remarks($ky, $exam);
            ?>
            <div class="row">
              <div class="col-xl-7">
                <h6 style="font-size:13px;"><strong>GENERAL REMARKS ON SUMMATIVE ASSESSMENT</strong></h6>
                <p>
                  <textarea class="inputField dotted-underline" data-ky="<?php echo $ky; ?>" placeholder="Type remarks here..." style="max-width: 400px; width: 100%; overflow: hidden; resize: none; height: auto; line-height: 1.5;"><?php echo $updated_value ?></textarea>
                </p>
              </div>
              <div class="col-xl-5">
                <h6 style="font-size:13px;"><strong>Signiture</strong></h6>
              </div>

            </div>
          </div>

          <div class="col-xl-12">
            <h6 style="font-size:13px;"><strong>Class teacher’s comments:</strong></h6>
            <p>
              <textarea class="commentField dotted-underline" data-ky="<?php echo $ky; ?>" placeholder="Type your comment..." style="max-width: 400px; width: 100%; overflow: hidden; resize: none; height: auto; line-height: 1.5;"><?php echo $teacher_comment ?></textarea>
            </p>
          </div>
        </div>
        <?php if ($current_student < $total_students) { ?>
          <p class="page-break"></p>
        <?php } ?>
      <?php
      }
    } else {
      ?>
      <div class="row">
        <p class="alert alert-danger">No results found !</p>
      </div>
<?php
    }
  }
}
?>

<style>
  body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    padding: 20px;
  }

  .invoice-box {
    max-width: 900px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    font-size: 16px;
    color: #555;
    background-color: #fff;
    margin-bottom: 20px;
  }

  .invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
    border-collapse: collapse;
  }

  .invoice-box table td {
    padding: 5px;
    vertical-align: top;
  }

  .invoice-box table tr td:nth-child(2) {
    text-align: right;
  }

  .invoice-box table tr.top table td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
  }

  .invoice-box table tr.information table td {
    padding-bottom: 40px;
  }

  .invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
  }

  .invoice-box table tr.details td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.item td {
    border-bottom: 1px solid #eee;
  }

  .invoice-box table tr.item.last td {
    border-bottom: none;
  }

  .invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
  }

  .key-container {
    display: flex;
    justify-content: center;
    align-items: center;
    border: 4px double #00A5A3;
    padding: 10px;
    width: fit-content;
    margin-top: 20px;
    background-color: #f9f9f9;
    padding-right: 50px;
    padding-left: 50px;
  }

  .key-item {
    margin: 0 15px;
    font-size: 16px;
    color: #00A5A3;
    font-family: Arial, sans-serif;
  }

  .key-title {
    font-weight: bold;
    margin-right: 30px;
    /* Extra space between the title and the key items */
  }

  /* Hide input field borders */
  .inputField {
    border: none;
    outline: none;
    background-color: transparent;
    font-size: 13px;
    color: black;
    width: 400px;

  }

  .commentField {
    border: none;
    outline: none;
    background-color: transparent;
    font-size: 13px;
    color: black;
    width: 400px;

  }

  .dotted-underline {
    border: none;
    border-bottom: 1px dotted black;
    outline: none;
    padding-bottom: 2px;
    background: transparent;
    /* Ensures no background color */
  }

  .dotted-underline:focus {
    border-bottom: 1px solid black;

  }


  @media print {
    .hidden-print {
      display: none !important;
    }

    .bg-primary {
      background-color: #007bff !important;
      color: white !important;
    }

    .tx-fixed-white {
      color: white !important;
      font-size: 50px;
    }

    body {
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      /* Firefox */
    }

    .invoice-box {
      box-shadow: none;
      margin: 0;
      border: none;
      page-break-inside: avoid;
      margin: auto;
      min-width: 1000px;

    }

    .invoice-box:last-child {
      page-break-after: auto;
    }

    .invoice-box table {
      width: 100%;
    }

    .invoice-box .top img {
      height: auto;
    }

    .invoice-box h4,
    .invoice-box h6 {
      margin: 0;
    }

    .row {
      display: flex;
      width: 100%;
      margin-top: 20px;
    }

    .col-xl-7 {
      width: 70%;
      padding-right: 10px;
    }

    .col-xl-5 {
      width: 30%;
      padding-left: 10px;
    }

    .page-break {
      page-break-before: always;
    }

    .key-container {
      display: flex;
      justify-content: center;
      align-items: center;
      border: 4px double #00A5A3;
      padding: 10px 50px;
      width: fit-content;
      margin: 20px auto;
      background-color: #f9f9f9;
    }

  }
</style>

<script>
  function printInvoice(event) {
    event.preventDefault(); // Prevent the default form submission behavior
    window.print(); // Trigger the print dialog
  }
</script>


<script>
  $(document).ready(function() {
    $('.js-example-basic-single').select2();

    $('#classDropdown').change(function() {
      var selectedClass = $(this).val();

      if (selectedClass) {
        $.ajax({
          url: '<?php echo site_url('cbc/trs/fetch_students'); ?>',
          type: 'POST',
          data: {
            class: selectedClass
          },
          dataType: 'json',
          success: function(data) {
            var studentDropdown = $('#studentDropdown');
            studentDropdown.empty();
            studentDropdown.append('<option value="">Select Student</option>');
            $.each(data, function(key, value) {
              studentDropdown.append('<option value="' + key + '">' + value + '</option>');
            });
            studentDropdown.trigger('change'); // Update the dropdown
          },
          error: function() {
            alert('An error occurred while fetching students.');
          }
        });
      } else {
        $('#studentDropdown').empty().append('<option value="">Select Student</option>').trigger('change');
      }
    });
  });
</script>


<script>
  $(document).ready(function() {
    // Debounce function to limit the rate of AJAX requests
    function debounce(func, delay) {
      let debounceTimer;
      return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
      };
    }

    // Function to update field in the database
    function updateColumnInDatabase(input, ky, exam, term, year, fieldType) {
      $.ajax({
        url: '<?php echo base_url("cbc/trs/save_input"); ?>',
        method: 'POST',
        data: {
          input: input,
          ky: ky,
          exam: exam,
          term: term,
          year: year,
          field: fieldType
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (fieldType === 'input') {
            $('.inputField[data-ky="' + ky + '"]').val(data.updated_value);
          } else if (fieldType === 'comment') {
            $('.commentField[data-ky="' + ky + '"]').val(data.updated_value);
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX Error: ' + status + error);
        }
      });
    }

    // Apply debounce to input and comment fields
    $('.inputField, .commentField').on('change', debounce(function() {
      var input = $(this).val();
      var ky = $(this).data('ky');
      var exam = '<?php echo $exam; ?>';
      var term = '<?php echo $term; ?>';
      var year = '<?php echo $year; ?>';
      var fieldType = $(this).hasClass('inputField') ? 'input' : 'comment';

      updateColumnInDatabase(input, ky, exam, term, year, fieldType);
    }, 0)); // Set delay to 0 for no delay
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea.commentField');

    textareas.forEach(textarea => {
      // Adjust the height of the textarea based on its content
      function adjustHeight() {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
      }

      // Initial adjustment on page load
      adjustHeight();

      // Adjust height on input
      textarea.addEventListener('input', adjustHeight);
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('textarea.inputField');

    textareas.forEach(textarea => {
      // Adjust the height of the textarea based on its content
      function adjustHeight() {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
      }

      adjustHeight();

      // Adjust height on input
      textarea.addEventListener('input', adjustHeight);
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const editableDivs = document.querySelectorAll('div.inputField');

    editableDivs.forEach(div => {
      // Function to adjust the height of the div based on its content
      function adjustHeight() {
        div.style.height = 'auto';
        div.style.height = div.scrollHeight + 'px';
      }

      // Initial adjustment on page load
      adjustHeight();

      // Adjust height on input
      div.addEventListener('input', adjustHeight);

      // Add underline styling on input
      div.addEventListener('input', function() {
        // Wrap the text with underline styling
        const text = div.innerText;
        div.innerHTML = text.replace(/(.)/g, '<span style="text-decoration: underline;">$1</span>');
      });
    });
  });
</script>