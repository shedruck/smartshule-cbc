
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0"><b>Class Attendance</b></h5>

        <div class="pull-right">
          <?php echo anchor('class_attendance/trs/list', '<i class="mdi mdi-reply"></i>Back', 'class="btn btn-secondary"'); ?>
        </div>

      </div>

      <div class="card-body p-2">
        <div class="col-xl-9">
          <div id='calendar2'></div>
        </div>
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