<?php
$teacher = $this->user->id;
$trs = $this->igcse_m->get_teacher($teacher);

?>

<div class="portlet mt-2">
  <div class="portlet-heading portlet-default border-bottom">
    <h3 class="portlet-title text-dark">
      <b>Final Exam Results</b>
    </h3>
    <div class="pull-right">

      <a class="btn btn-success " href="<?php echo base_url('igcse/trs/record'); ?>"><i class="fa fa-edit"></i> Edit Marks</a>
      <a class="btn btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
    </div>

    <div class="clearfix"></div>
    <hr>
  </div>

  <div id="step1">
    <?php if ($this->session->flashdata('update_success')) : ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $this->session->flashdata('update_success'); ?>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('insertion_success')) : ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $this->session->flashdata('insertion_success'); ?>
      </div>
    <?php endif; ?>


    <div class="panel panel-primary">
      <div class="panel-heading">
        <strong> Results
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
            echo form_open(current_url()); ?>

            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-2">
                  <label>Exam:</label>
                </div>
                <div class="col-sm-10">
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


            <div style="float: right;">
              <br>
              <button type="submit" class="btn btn-primary">View</button>
            </div>
            <?php echo form_close() ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  if (isset($thread)) {
    $tidfound = $this->igcse_m->tidfound($thread);
    $count = count($tidfound);

    if ($count != 0) { ?>
      <?php echo form_open(base_url('igcse/trs/submit_comment/' . $thread . '/' . $class)); ?>
      <div class="container" id="dataTable" style="padding-bottom: 20px;">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col">STUDENT</th>
              <th scope="col">ADM NO</th>
              <th scope="col">TOTAL</th>
              <th scope="col">GRADE</th>
              <th scope="col">STREAM POSITION</th>
              <th scope="col">OVERALL POSITION</th>
              <th scope="col">COMMENT</th>
            </tr>
          </thead>
          <tbody>

            <?php
            if (isset($marks)) {
              $i = 1;
              foreach ($marks as $key => $mark) {
                $student = $this->igcse_m->get_st($mark->student); // Fetch student information beforehand
            ?>
                <tr>
                  <td style="text-align: center;"><?php echo $student->first_name . "  " . $student->last_name; ?></td>
                  <td style="text-align: center;"><?php echo $student->admission_number; ?></td>
                  <td style="text-align: center;"><?php echo $mark->total ?></td>
                  <td style="text-align: center;"><?php echo $mark->mean_grade ?></td>
                  <td style="text-align: center;"><?php echo $mark->str_pos ?></td>
                  <td style="text-align: center;"><?php echo $mark->ovr_pos ?></td>
                  <td style="text-align: center;">
                    <?php if ($mark->trs_comment != '') { ?>
                      <input type="text" name="comment[<?php echo $mark->student ?>]" value="<?php echo $mark->trs_comment; ?>" class="form-control" required>
                    <?php } else { ?>
                      <input type="text" name="commentnew[<?php echo $mark->student ?>]" value="" id="marks_<?php echo $mark->id ?>" class="form-control" placeholder="Enter Comment" required>
                    <?php } ?>
                  </td>
                </tr>
              <?php
              }
            } else { ?>
              <tr>
                <td colspan="5">No results Found</td>
              </tr>
            <?php }  ?>

          </tbody>
        </table>
        <div><button type="submit" id="add-comment-button" class="btn btn-primary pull-right">Add Comment</button></div>
      </div>
      <?php echo form_close(); ?>
    <?php } else { ?>
      <div class="alert alert-danger">
        <p><strong>No Results for the Selected Exam. </strong></p>
      </div>
  <?php }
  } ?>


  <!-- Assuming jQuery library is included -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      // Define count variable to hold the count of $marks
      var marksCount = <?php echo count($marks); ?>;

      // Check if $marksCount is zero
      if (marksCount === 0) {
        // If $marksCount is zero, hide the button with id "add-comment-button"
        $('#add-comment-button').hide();
      }
    });
  </script>