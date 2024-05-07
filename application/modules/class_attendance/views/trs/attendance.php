<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><b>Record Attendance</b></h5>

      </div>

      <div class="card-body p-2">
        <?php if ($classes) : ?>
          <!-- <table id="datatable-buttons" class="table table-striped table-bordered"> -->
          <table id="file-export" class="table table-bordered">
            <thead class="table-success">
              <th>#</th>
              <th>Class</th>
              <th>Population</th>
              <th class="text-center" width="25%"> Option </th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              foreach ($classes as $p) :
                $ppt = $this->portal_m->count_students_per_class($p->id);
                $studis = ' Students';
                if ($ppt == 1) {
                  $studis = ' Student';
                }

                $i++;
              ?>
                <tr>
                  <td><?php echo $i . '.'; ?></td>
                  <td><?php echo $p->name; ?> </td>
                  <td><?php echo $ppt . ' ' . $studis; ?> </td>
                  <td class="text-center">
                    <a href="<?php echo base_url('class_attendance/attendance/register/' . $p->id); ?>" class="btn btn-primary rounded-pill waves-effect"><i class="fa fa-plus-square me-2"></i> Add New </a>
                    <a href="<?php echo base_url('class_attendance/attendance/list_register/' . $p->id); ?>" class="btn btn-warning rounded-pill waves-effect"><i class="mdi mdi-account-search"></i> View </a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>

          </table>




        <?php else : ?>
          <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif ?>
      </div>
      <!-- <div class="card-footer">

      </div> -->
    </div>
  </div>
</div>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>