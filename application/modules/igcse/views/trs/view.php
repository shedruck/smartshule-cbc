<?php
$this->load->model('igcse/igcse_m');
$teachers = $this->igcse_m->list_teachers();
$classes_with_teachers = $this->igcse_m->get_class_with_teacher();
$subs = $this->igcse_m->populate('subjects', 'id', 'name');

?>

<div class="portlet mt-2">
  <div class="portlet-heading portlet-default border-bottom">
    <h3 class="portlet-title text-dark">
      <b>View Exam Marks</b>
    </h3>
    <div class="pull-right">

      <a class="btn btn-success " href="<?php echo base_url('igcse/trs/record'); ?>"><i class="fa fa-edit"></i> Edit Marks</a>
      <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
    </div>

    <div class="clearfix"></div>
    <hr>
  </div>
  <div id="step1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <strong>Marks
          <?php
          if (isset($class) && isset($this->streams[$class])) {
            echo $this->streams[$class];
          }
          ?>

          <?php
          if (isset($subject) && isset($subs[$subject])) {
            echo " " . ucfirst($subs[$subject]);
          }
          ?>
        </strong>
      </div>



      <div class="panel-body">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <?php
            $subject = $this->input->post('subject');
            echo form_open(current_url()); ?>
            <div class="col-sm-3">
              <div class="row">
                <div class="col-sm-3">
                  <label>Class:</label>
                </div>
                <div class="col-sm-9">
                  <?php
                  // Initial options for the dropdown
                  $options = ['' => ''];
                  foreach ($classes_with_teachers as $class) {
                    if (isset($this->streams[$class->class])) {
                      $options[$class->class] = $this->streams[$class->class];
                    }
                  }
                  echo form_dropdown('class', $options, $this->input->post('class'), 'class="select" id="class-dropdown" required');
                  ?>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="row">
                <div class="col-sm-3">
                  <label>Exam:</label>
                </div>
                <div class="col-sm-9">
                  <?php
                  $options = array('' => '');
                  foreach ($threads as $exam) {
                    // Add each exam title to the options array
                    $options[$exam->id] = $exam->title;
                  }
                  echo form_dropdown('thread', $options, $this->input->post('thread'), 'class="select" id="thread-dropdown" required');
                  ?>
                </div>
              </div>
            </div>


            <div class="col-sm-3">
              <div>
                <div class="col-sm-3">
                  <label>Category:</label><br>
                  <p><i>(*Main,Cats)</i></p>
                </div>
                <div class="col-sm-9">
                  <?php
                  $options = array('' => '');
                  echo form_dropdown('exam', $options, $this->input->post('exam'), 'class="select" id="exam-dropdown" required');
                  ?>
                </div>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="row">
                <div class="col-sm-3">
                  <label>Subject:</label>
                </div>
                <div class="col-sm-9">
                  <?php
                  $options = array('' => '');
                  echo form_dropdown('subject', $options, $this->input->post('subject'), 'class="select" id="sub-dropdown" required');
                  ?>
                </div>
              </div>
            </div>



            <div style="float: right; margin-right:12px">
              <br>
              <button type="submit" class="btn btn-primary">View</button>
            </div>
            <?php echo form_close() ?>

          </div>
        </div>
      </div>

    </div>
  </div>


  <div class="container" id="dataTable" style="padding-bottom: 20px;">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col" style="width: 33.33%;">ADM NO</th>
          <th scope="col" style="width: 33.33%;">STUDENT</th>
          <th scope="col" style="width: 33.33%;">MARKS</th>
        </tr>
      </thead>
      <tbody>
        <?php if (isset($marks)) {
          foreach ($marks as $key => $mark) { ?>
            <tr>
              <td style="text-align: center;"><?php
                                              $student = (object) $this->igcse_m->get_st($mark->student);
                                              echo $student->admission_number;
                                              ?></td>
              <td style="text-align: center;"><?php
                                              $student = (object) $this->igcse_m->get_st($mark->student);
                                              echo $student->first_name . "  " . $student->last_name;
                                              ?></td>
              <td style="text-align: center;"><?php echo $mark->marks ?></td>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td colspan="3">No Marks found.</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>


</div>
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
      examDropdown.append($('<option>').text('').val('')); // Add default option
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

    subjectsDropdown.append($('<option>').text('').attr('value', ''));

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
    $('#myForm').submit(function(event) {
      event.preventDefault(); // Prevent form submission and page reload

      // Your form processing code here

      // Show the table
      $('#dataTable').show();

      // Optionally, you can populate the table here if needed
      // fetchDataAndPopulateTable();
    });
  });
</script>