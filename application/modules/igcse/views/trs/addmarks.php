<?php
$this->load->model('igcse/igcse_m');
$teachers = $this->igcse_m->list_teachers();
$classes_with_teachers = $this->igcse_m->get_class_with_teacher();
$subs = $this->igcse_m->populate('subjects', 'id', 'name');
$examsid = $this->igcse_m->get_examstable($exam);
?>

<div class="portlet mt-2">
  <div class="portlet-heading portlet-default border-bottom">
    <h3 class="portlet-title text-dark">
      <b>Record Exam Marks - <?php echo $subs[$subject] ?> <?php echo $this->streams[$class] ?> <?php echo ucwords($examsid->title) ?></b>
    </h3>
    <div class="pull-right">


      <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
    </div>

    <div class="clearfix"></div>
    <hr>
  </div>
  <?php

  if ($marks) { ?>
    <div class="alert alert-danger" style="margin-right: 70px; margin-left: 70px;">
      <p> <strong>Alert!</strong> Some previously Added Marks were found for <?php echo count($marks); ?> Students. You can only Edit.</p>

    </div>

  <?php }
  ?>

  <?php echo form_open(base_url('igcse/trs/submit_marks'), array('id' => 'marksForm')); ?>
  <div class="container" id="dataTable" style="padding-bottom: 20px;">
    <div class="col-md-12 mt-2 mb-3 " style="margin-bottom: 20px;">

      <div class="col-md-6">
        <div class="form-group row">
          <label for="outof2" class="col-md-4 col-form-label">Exam Out_of:</label>
          <div class="col-md-8">
            <input type="number" name="outof" id="outof2" value="<?php echo isset($outof->out_of) ? $outof->out_of : ''; ?>" class="form-control" placeholder="Exam Out_of" required>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group row">
          <div class="col-md-4"><strong>Grading System </strong><span class='required'>*</span></div>
          <div class="col-md-8">
            <?php
            echo form_dropdown('grading', array('' => '') + $grading, isset($sel_gd) ? $sel_gd : '', ' class="select" data-placeholder="Select Grading System" required');
            echo form_error('grading');
            ?>
          </div>
        </div>
      </div>
    </div>



    <table class="table table-bordered table-striped">
      <thead>
        <tr>

          <th scope="col" style="width: 33.33%;">ADM NO</th>
          <th scope="col" style="width: 33.33%;">STUDENT</th>
          <th scope="col" style="width: 33.33%;">MARKS</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($students) {
          foreach ($students as $key => $student) {

        ?>

            <tr>

              <td><?php echo $student->admission_number ?>

              </td>
              <td><?php echo $student->first_name . "  " . $student->last_name ?></td>
              <td>
                <input type="hidden" name="class" value="<?php echo $class; ?>">
                <input type="hidden" name="thread" value="<?php echo $thread; ?>">
                <input type="hidden" name="exam" value="<?php echo $exam; ?>">
                <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                <input type="hidden" name="student[]" value="<?php echo $student->id ?>">
                <?php
                $foundMark = false;
                foreach ($marks as $mark) :
                  if ($mark->student == $student->id) :
                    $foundMark = true;
                ?>
                    <input type="text" name="marksnew[<?php echo $student->id ?>]" value="<?php echo $mark->marks; ?>" class="form-control" required>
                  <?php
                    break;
                  endif;
                endforeach;
                if (!$foundMark) :
                  ?>
                  <input type="number" name="marks[<?php echo $student->id ?>]" value="" id="marks_<?php echo $student->id ?>" class="form-control" placeholder="Enter Marks" required>
                <?php endif; ?>
              </td>


            </tr>

        <?php
          }
        } ?>
      </tbody>
    </table>
    <div><button type="submit" class="btn btn-primary pull-right">Submit Marks</button>
      <?php echo form_close(); ?></div>



  </div>



</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('input[name^="marks"]').on('change', function() {
      var marksInput = $(this);
      var marksValue = parseFloat(marksInput.val());
      var outofValue = parseFloat($('#outof2').val());

      if (marksValue > outofValue) {
        alert('Marks cannot be greater than Out_of');
        marksInput.val(''); // Clear the invalid value
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#thread-dropdown').change(function() {
      var selectedThreadId = $(this).val();

      var url = `<?php echo base_url("igcse/trs/fetch_exams/") ?>/${selectedThreadId}`;

      console.log(url);
      // console.log('Selected Thread ID:', selectedThreadId);
      $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
          populateExamDropdown(response);

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });

      $.ajax({
        url: url2,
        type: 'GET',
        success: function(response) {
          // Process response for the second data retrieval
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });

    function populateExamDropdown(examData) {
      var examDropdown = $('#exam-dropdown');
      examDropdown.empty(); // Clear existing options
      examDropdown.append($('<option>').text('Select an exam').val('')); // Add default option
      $.each(JSON.parse(examData), function(index, exam) {
        examDropdown.append($('<option>').text(exam.title).val(exam.id));
      });
    }
  });
</script>

<script>
  $(document).ready(function() {
    // Attach change event listener to the class dropdown
    $('#class-dropdown').change(function() {
      var selectedClassId = $(this).val();
      var url2 = `<?php echo base_url("igcse/trs/fetch_data/") ?>/${selectedClassId}`;

      $.ajax({
        url: url2,
        type: 'GET',
        success: function(response) {
          displaySubjects(response);

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });


  function displaySubjects(response) {
    var subjectsDropdown = $('#sub-dropdown');

    subjectsDropdown.empty();

    subjectsDropdown.append($('<option>').text('Select a subject').attr('value', ''));

    var dataArray = JSON.parse(response);

    dataArray.forEach(function(item) {
      // Check if the item has a 'subject' property
      if (item.subject) {
        subjectsDropdown.append($('<option>').text(item.subject).attr('value', item.value));
      }
    });
  }
</script>

<script>
  $(document).ready(function() {
    $('form').submit(function(event) {
      var error = false;

      // Loop through each marks input field
      $('[name^="marksnew"]').each(function() {
        var marks = parseInt($(this).val()); // Get the value of the current marks input
        var outof = parseInt($('#outof2').val()); // Get the value of the outof input

        // Check if marks is greater than outof
        if (marks > outof) {
          error = true;
          return false; // Exit the loop early
        }
      });

      // If no marksnew input fields found, check the initial marks input field
      if (!$('[name^="marksnew"]').length) {
        var marks = parseInt($('[name^="marks"]').val()); // Get the value of the initial marks input field

        // Check if marks is greater than outof
        if (marks > outof) {
          error = true;
        }
      }

      if (error) {
        event.preventDefault(); // Prevent form submission
        alert('Marks cannot be more than Out_of'); // Show error message
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#marksForm').submit(function(e) {
      var marks = parseInt($('.marks').val());
      var outof = parseInt($('.outof').val());

      if (marks > outof) {
        alert('Marks cannot be greater than out of');
        e.preventDefault(); // Prevent form submission
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#marksForm').submit(function() {
      // Disable the form submission button to prevent multiple submissions
      $(this).find(':submit').attr('disabled', 'disabled');
    });
  });
</script>