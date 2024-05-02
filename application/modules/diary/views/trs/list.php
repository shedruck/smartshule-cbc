<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6 class="float-start">ALL STUDENT DIARY</h6>
        <div class="float-end">
          <?php echo anchor('trs/diary/create', '<i class="mdi mdi-plus"></i>  Add Entry Per Student', 'class="btn btn-primary"'); ?>
          <div class="btn-group">
            <button type="button" class="btn btn-success " data-toggle="dropdown"><i class="fa fa-edit"></i> Add Entry Per Level <span class="caret"></span> </button>
            <ul class="dropdown-menu">
              <h5 class="text-center"> MY CLASSES</h5>
              <?php
              foreach ($classes as $cl) {
              ?>
                <li>

                  <button class="btn btn-default col-sm-12" style="width:100% !important" width="100%" id="post_<?php echo $cl->id; ?>" value="<?php echo base_url('trs/diary/per_level/' . $cl->id . '/' . $this->session->userdata['session_id']) ?>"><i class='fa fa-caret-right'></i> <?php echo strtoupper($cl->name); ?></button>

                </li>


                <script>
                  $(document).ready(function() {
                    $("#post_<?php echo $cl->id; ?>").click(function() {

                      var url = $("#post_<?php echo $cl->id; ?>").val();


                      swal({
                          title: "Diary Entry for <?php echo strtoupper($cl->name); ?>",
                          text: "",
                          icon: "warning",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((willDelete) => {
                          if (willDelete) {
                            window.location = url;
                            swal("Listing students please wait....");
                          } else {
                            //swal("Your imaginary file is safe!");
                          }
                        });

                    });



                  })
                </script>

              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
     
      <div class="card-body p-2">
        <?php if ($diary) : ?>
          <!-- <table id="datatable-buttons" class="table table-striped table-bordered"> -->
          <table id="responsiveDataTable" class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Date </th>
              <th>Student</th>
              <th>Activity</th>
              <th width="24%">Teacher Comment</th>
              <th width="24%">Parent Comment</th>
              <th><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
                $i = ($this->uri->segment(4) - 1) * $per;
              }

              foreach ($diary as $p) :
                $i++;
                $student = $this->worker->get_student($p->student);
              ?>
                <tr>
                  <td><?php echo $i . '.'; ?></td>
                  <td><?php echo $p->date_ > 10000 ? date('d M Y', $p->date_) : ' - '; ?></td>
                  <td><?php echo $student->first_name . ' ' . $student->last_name; ?></td>
                  <td><?php echo $p->activity; ?></td>
                  <td><?php echo $p->teacher_comment; ?></td>
                  <td><?php echo $p->parent_comment; ?></td>
                  <td width='30'>
                    <div class='btn-group'>
                      <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='mdi mdi-chevron-down'></i></button>
                      <ul class='dropdown-menu pull-right'>
                        <li><a href='<?php echo site_url('trs/diary/edit/' . $p->id . '/' . $page); ?>'><i class='mdi mdi-pencil'></i> Edit</a></li>
                        <li><a onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('trs/diary/delete/' . $p->id . '/' . $page); ?>'><i class='mdi mdi-delete-forever'></i> Trash</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>

          </table>




        <?php else : ?>
          <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif ?>
      </div>
      <div class="card-footer">

      </div>
    </div>
  </div>
</div>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>