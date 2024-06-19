<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>CBC SUBJECTS</b></h5>
        <div>
          <!-- <a href="<?php echo base_url('cbc/trs/fix_class') ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-cog"></i>Manage Subjects</a> -->
          <?php echo anchor('cbc/trs/add_subject', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Subjects')), 'class="btn btn-primary btn-sm"'); ?>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>

      <div class="card-body p-2">

        <?php if ($subjects) : ?>
          <?php echo form_open(current_url()); ?>
          <div class="table-responsive">
            <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Classes</th>
                  <th>Category</th>
                  <th>check</th>
                  <th width="30%"><?php echo lang('web_options'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
                  $i = ($this->uri->segment(4) - 1) * $per;
                }
                foreach ($subjects as $p) :
                  $i++;
                ?>
                  <tr>
                    <td><?php echo $i . '.'; ?></td>
                    <td><?php echo $p->name; ?></td>
                    <td>
                      <?php
                      $counter = 0;
                      foreach ($p->classes as $title) {
                        echo '<span class="badge bg-primary text-white">' . $title . '</span> ';
                        $counter++;

                        if ($counter % 5 == 0) {
                          echo '<br>';
                        }
                      }
                      ?>
                    </td>

                    <td><?php echo isset($cats[$p->cat]) ? $cats[$p->cat] : ' - '; ?></td>
                    <td class="text-center checkmark-cell"><input type="checkbox" name="subjects[<?php echo $p->id ?>]" value="<?php echo $p->id ?>" class="form-check-input custom-checkbox"></td>
                    <td width='20%'>
                      <div class="btn-group">
                        <a class="btn btn-warning btn-sm" href="<?php echo site_url('cbc/trs/edit_subject/' . $p->id); ?>"> <i class="fe fe-edit me-2"></i> Edit</a>
                        <a class="btn btn-warning btn-sm" href="<?php echo site_url('admin/cbc/fx_class/' . $p->id); ?>" style="display:none"><i class="fe fe-edit me-2"></i> Classes</a>
                        <a class="btn btn-success btn-sm" href="<?php echo site_url('cbc/trs/learning_areas/' . $p->id); ?>"><i class="fe fe-list me-2"></i> Strands</a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="d-flex float-end">
              <button class="btn btn-secondary btn-sm" onclick="return confirm('Are you sure to delete?? THIS IS PERMANENT!!')" type="submit">Remove</button>
            </div>
          </div>
          <?php echo form_close() ?>
        <?php else : ?>
          <p class='text'><?php echo lang('web_no_elements'); ?></p>
        <?php endif ?>
      </div>

    </div>
  </div>
</div>

<style>
  .custom-checkbox {
    width: 1.2em;
    /* Set the width of the checkbox */
    height: 1.2em;
    /* Set the height of the checkbox */
  }

  .custom-checkbox:checked {
    transform: scale(1.2);

  }

  .text-center {
    text-align: center;
  }

  .checkmark-cell {
    vertical-align: middle;

  }
</style>