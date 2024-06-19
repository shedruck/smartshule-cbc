<?php
$task_arr = [];
$top_arr = [];
?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><b> STRAND: <span class="text-secondary"> <?php echo $post->name; ?></span></b></h6>
        <div>
          <a href="<?php echo base_url('cbc/trs/learning_areas/' . $post->subject); ?>" class="pull-right btn btn-secondary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
        </div>
      </div>

      <div class="row justify-content-center"> <!-- Centering the content horizontally -->
        <div class="col-md-7"> <!-- Taking 7 columns in medium-sized screens -->
          <div class="card">
            <div class="card-body p-2">
              <!-- Form Section -->
              <h5 class="m-t-0 m-b-10 header-title text-center text-uppercase">Add Sub-Strands</h5>
              <form class="form-horizontal form-main" role="form" action="<?php echo current_url(); ?>" method="POST">
                <div class="form-group" id="clone">
                  <label class="col-sm-6 control-label"> <B>SUB-STRAND NAME</B></label>
                  <div class="col-sm-12 rows">
                    <input type="text" name="topic[]" class="form-control m-b-10 mt-2" placeholder="Name">
                    <input type="text" name="topic[]" class="form-control m-b-10 mt-2" placeholder="Name">
                  </div>
                  <div class="text-center"><a href="javascript:" id="adder" class="btn-link"><strong>+ Add New Row </strong></a></div>
                </div>
            </div>
          </div>
        </div>
      </div>


      <div class="card-footer">
        <div class="form-group m-b-0">
          <div class="col-sm-offset-3 col-sm-12 text-end"> <!-- Changed to text-end for Bootstrap 5, float-end for Bootstrap 4 -->
            <button type="submit" class="btn btn-info"> <i class="fe fe-check-square me-1 lh-base"></i> Submit</button>
          </div>
        </div>
      </div>

      </form>
    </div>
  </div>
</div>


<div class="row mt-4">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0"><b>SUBJECT: <span class="text-primary"><?php echo $subject->name; ?></span></b></h6>
      </div>
      <div class="card-body p-2">
        <div class="block-fluid">
          <div class="tasks-section">
            <div class="tasks-header-w bg-e">
              <h5 class="tasks-header text-uppercase">
                <strong><?php echo $post->name; ?></strong>
              </h5>
            </div>
            <div class="tasks-list-w">
              <?php
              $j = 0;
              foreach ($post->topics as $s) {
                $top_arr[$s->id] = $s->name;
                $j++;
              ?>
                <div class="pb">

                  <!-- Adjusted button to trigger modal with data-id attribute -->
                  <div class="table-success" style="height: 40px; padding-right: 15px; padding-left: 15px; padding-top: 10px; padding-bottom: 10px;">
                    <b style="margin-left:10px;"><?php echo '1.' . $j . " &nbsp; &nbsp; &nbsp;" . $s->name; ?></b>
                    <a class="pull-right prl btn-link add-indicators" href="javascript:" data-id="<?php echo $s->id; ?>" data-toggle="modal" data-target="#addIndicatorsModal"><strong>+ Add Indicators </strong></a>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="addIndicatorsModal" tabindex="-1" role="dialog" aria-labelledby="addIndicatorsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="addIndicatorsModalLabel">Add Indicators for: <span id="modalTopicName"></span></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h4>Add Tasks</h4>
                          <form id="addIndicatorsForm" action="<?php echo base_url('cbc/trs/tasks/' . $post->id); ?>" method="post">
                            <input type="hidden" id="topic_id" name="topic_id">
                            <div id="tasksContainer">
                              <div class="form-group">
                                <input type="text" class="form-control task-name" name="tasks[]" placeholder="Task Name">
                              </div>
                            </div>
                            <a href="javascript:" class="btn btn-link" @click="addTaskField">+ Add Task</a>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" form="addIndicatorsForm" class="btn btn-primary">Save</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>


                  <?php if (count($s->tasks)) { ?>
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                        <tbody>
                          <?php
                          $ii = 0;
                          foreach ($s->tasks as $t) {
                            $task_arr[$t->id] = $t->name;
                            $ii++;
                          ?>
                            <tr>
                              <td><?php echo $ii; ?>.</td>
                              <td width="70%"><?php echo $t->name; ?></td>
                              <td>
                                <!-- <div class="btn-group hidden-print"> -->
                                <a class="btn btn-success btn-sm" onclick="add_remarks('<?php echo $post->subject ?>','<?php echo $s->id ?>','<?php echo $t->id ?>')" href="javascript:;">
                                  <span>Remarks</span>
                                </a>

                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $t->id ?>" onclick="prepareSubmit('<?php echo $item['id']; ?>')">Edit</button>
                                <!-- </div> -->
                                <a class="btn btn-danger btn-sm" href="<?php echo base_url('cbc/trs/remove_task/' . $t->id . "/" . $post->id); ?>" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')"><span>Delete</span></a>
                    </div>
                    </td>
                    </tr>


                    <!-- edit modal -->
                    <div class="modal fade" id="exampleModal<?php echo $t->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <h4>Edit Tasks</h4>
                            <form action="<?php echo base_url('cbc/trs/update_task/' . $t->id . '/' . $post->id); ?>" method="post">
                              <input type="hidden" id="topic_id" name="topic_id">
                              <div class="form-group"><input type="text" class="form-control task-name" name="task" value="<?php echo $t->name ?>"></div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  </tbody>
                  </table>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>




<!-- Modal -->
<div class="modal fade" id="addIndicatorsModal" tabindex="-1" role="dialog" aria-labelledby="addIndicatorsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addIndicatorsModalLabel">Add Indicators for: <span id="modalTopicName"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <h4>Add Tasks</h4>
        <form id="addIndicatorsForm" action="<?php echo base_url('cbc/trs/tasks/' . $s->id); ?>" method="post">
          <input type="hidden" id="topic_id" name="topic_id">
          <div id="tasksContainer">
            <!-- Task fields will be dynamically added here -->
          </div>
          <a href="javascript:" class="btn btn-link" @click="addTaskField">+ Add Task</a>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" form="addIndicatorsForm" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" id="customCloseButton">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Updated Modal Structure -->
<div class="modal fade" id="add_remarks" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="subby-header">
          <span>SUBJECT: <?php echo $subject->name; ?></span>
        </h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <b>Topic:</b> <span id="topic_vl"></span><br>
        <b>Task:</b> <span id="task_val"></span><br>
        <?php echo form_open(base_url('cbc/trs/add_remarks'), ['id' => 'remarks_form']) ?>

        <input type="hidden" name="subject" id="sbj">
        <input type="hidden" name="topic" id="tpc">
        <input type="hidden" name="task" id="tsk">
        <input type="hidden" name="la" value="<?php echo $post->id ?>">
        <table class="table">
          <tr>
            <td>EE</td>
            <td><textarea style="min-height: 89px;" name="ee_remarks" class="form-control" id="ee_val"></textarea></td>
          </tr>

          <tr>
            <td>ME</td>
            <td><textarea style="min-height: 89px;" name="me_remarks" class="form-control" id="me_val"></textarea></td>
          </tr>

          <tr>
            <td>AE</td>
            <td><textarea style="min-height: 89px;" name="ae_remarks" class="form-control" id="ae_val"></textarea></td>
          </tr>

          <tr>
            <td>BE</td>
            <td><textarea style="min-height: 89px;" name="be_remarks" class="form-control" id="be_val"></textarea></td>
          </tr>
        </table>

        <hr>
        <div class="right">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-success" type="submit">Save Remarks</button>
        </div>
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>



<style>
  input.form-control {
    height: 36px !important;
  }

  .card-footer .text-end {}


  .card-footer .btn {
    margin-left: 10px;

  }
</style>
<script>
  // Function to close the modal
  function closeModal() {
    // Select the modal element
    var modal = document.getElementById('addIndicatorsModal');

    var bootstrapModal = bootstrap.Modal.getInstance(modal);
    if (bootstrapModal) {
      bootstrapModal.hide();
    } else {

      bootstrapModal = new bootstrap.Modal(modal);
      bootstrapModal.hide();
    }
  }
  document.getElementById('customCloseButton').addEventListener('click', closeModal);
</script>

<script>
  $('#adder').click(function() {
    var clone = $('#clone .rows input.form-control:first').clone();
    clone.val('');
    $('#clone .rows').append(clone);
  });
</script>

<script>
  let tsk_arr = <?php echo json_encode($task_arr); ?>;
  let top_arr = <?php echo json_encode($top_arr); ?>;

  $(document).ready(function() {
    // Handle click on +Add Indicators link
    $('.add-indicators').click(function() {
      var topicId = $(this).data('id');
      var topicName = top_arr[topicId];

      // Set modal content dynamically
      $('#topic_id').val(topicId);
      $('#addIndicatorsModalLabel').text('Add Indicators for: ' + topicName);
      $('#addIndicatorsModal').modal('show');
    });

    // Handle adding new task field in modal
    var taskField = '<div class="form-group"><input type="text" class="form-control task-name" name="tasks[]" placeholder="Task Name"></div>';
    $('#addIndicatorsForm').on('click', '.btn-link', function() {
      $('#tasksContainer').append(taskField);
    });
  });

  function notify(title, message) {
    alert(title + ": " + message); // Simple alert for notifications
  }

  function add_remarks(subject, topic, task) {
    $('#add_remarks').modal('toggle');

    var task_name = tsk_arr[task];
    var topic_name = top_arr[topic];

    $('#topic_vl').html(topic_name);
    $('#task_val').html(task_name);
    $('#sbj').val(subject);
    $('#tpc').val(topic);
    $('#tsk').val(task);

    $.ajax({
      type: "POST",
      url: "<?php echo base_url('cbc/trs/get_remarks'); ?>",
      data: {
        'subject': subject,
        'topic': topic,
        'task': task
      },
      dataType: "json",
      success: function(response) {
        $('#ee_val').val(response.ee_remarks);
        $('#me_val').val(response.me_remarks);
        $('#ae_val').val(response.ae_remarks);
        $('#be_val').val(response.be_remarks);
      },
      error: function(error) {
        console.error("Error submitting form:", error);
      }
    });
  }

  $(document).ready(function() {
    $("#remarks_form").submit(function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('cbc/trs/add_remarks'); ?>",
        data: formData,
        dataType: "json",
        success: function(response) {
          if (response.status == 200) {
            notify('Success', response.message);
          } else {
            notify('Error', response.message);
          }
          setTimeout(function() {
            location.reload();
          }, 1000);
        },
        error: function(error) {
          console.error("Error submitting form:", error);
        }
      });
    });
  });
</script>

<script>
  function prepareSubmit(itemId) {
    // Set the value of the hidden input field in the form inside the modal
    document.getElementById('itemId').value = itemId;
  }
</script>