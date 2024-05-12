<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0"><b>Extra-Curricular Diary</b></h6>
        <div class="float-end">
          <?php echo anchor('diary/trs/create_ex', '<i class="mdi mdi-plus"></i>  New Entry', 'class="btn btn-primary"'); ?>

        </div>
      </div>

      <div class="card-body p-2">
        <?php if ($diary) : ?>
          <div class="table-responsive">
            <table id="datatable-basic" class="table table-bordered">
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

                        <!-- button dropdowns -->
                        <div class="btn-group my-2">
                          <button type="button" class="btn btn-outline-primary dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                          </button>
                          <ul class="dropdown-menu" style="width: 50px; ">
                            <li><a class="dropdown-item text-primary" href='<?php echo site_url('diary/trs/edit_ex/' . $p->id . '/' . $page); ?>'><i class='fa fa-edit'></i> Edit</a></li>
                            <li><a class="dropdown-item text-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('diary/trs/delete/' . $p->id . '/2'); ?>'><i class=' fa fa-trash'></i> Trash</a></li>
                          </ul>

                        </div>
                    </td>
                  </tr>
                <?php endforeach ?>
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