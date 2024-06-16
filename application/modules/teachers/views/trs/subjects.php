<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0"><b>Subject Assigned</b></h6>
        <div class="float-end">
          <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>

        </div>
      </div>

      <div class="card-body p-2">
        <?php if ($subjects) : ?>
          <div class="table-responsive">
            <table id="datatable-basic" class="table table-bordered">
              <thead>
                <th>#</th>
                <th>Subject Code </th>
                <th>Subject Name</th>
                <th>Type</th>
                <th>Class</th>
              </thead>
              <tbody>
                <?php
                $index = 1;
                foreach ($subjects as $value) {
                  $class_id = $value->class;
                  $class = $this->streams[$class_id];
                ?>
                  <tr>
                    <td><?php echo $index; ?></td>
                    <td><?php echo $value->code ?></td>
                    <td><?php echo ucfirst($value->name) ?></td>
                    <td><?php 
                    if ($value->type == 1) {
                     echo "IGCSE/8.4.4";
                    }else {
                          echo "CBC";
                    } ?></td>
                    <td><?php echo $class ?></td>

                  </tr>
                <?php $index++;
                } ?>
              </tbody>

            </table>
          </div>
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