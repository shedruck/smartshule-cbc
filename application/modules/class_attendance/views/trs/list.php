<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><b>Class Attendance</b></h5>

        <div class="pull-right">
          <?php echo anchor('class_attendance/attendance/list', '<i class="mdi mdi-reply"></i>Back', 'class="btn btn-secondary"'); ?>
        </div>

      </div>

      <div class="card-body p-2">
        <?php if ($class_attendance) : ?>
          <!-- <table id="datatable-buttons" class="table table-striped table-bordered"> -->
          <table id="grid-loading" class="table table-bordered">
            <thead class="bg-primary">
              <th class="tx-fixed-white" width="5%">#</th>
              <th class="tx-fixed-white" width="25%">Date</th>
              <th class="tx-fixed-white" width="25%">Type</th>
              <th class="tx-fixed-white" width="25%">Taken on</th>
              <th class="tx-fixed-white"><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              foreach ($class_attendance as $p) :

                $i++;
              ?>
                <tr>
                  <td><?php echo $i . '.'; ?></td>
                  <td><?php echo date('d M Y', $p->attendance_date); ?></td>
                  <td><?php echo $p->title; ?></td>
                  <td><?php echo date('d M Y', $p->created_on); ?></td>
                  <td width="34%">
                    <div class='btn-d'>
                      <a href="<?php echo site_url('class_attendance/attendance/view_register/' . $p->id); ?>" class="btn btn-primary-light rounded-pill"><i class="mdi mdi-account-search"></i> View</a>

                      <button class="btn btn-sm btn-icon btn-danger-light rounded-circle" data-target="#user-form-modal" data-bs-toggle="modal" type="button" onclick="location.href='<?php echo site_url('class_attendance/attendance/edit_register/' . $p->id); ?>'"><i class="bi bi-pencil-square"></i></button>

                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        <?php else : ?>
          <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif; ?>
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