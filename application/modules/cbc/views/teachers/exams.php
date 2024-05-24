<?php if ($this->session->flashdata('created_message')) : ?>
  <div class="alert-container inserted-alert">
    <div class="alert alert-solid-success" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
      <i class="fa fa-check-circle-o me-2" aria-hidden="true"></i><?php echo $this->session->flashdata('created_message')['text']; ?>
    </div>
  </div>
<?php endif; ?>

<?php if ($this->session->flashdata('delete_message')) : ?>
  <div class="alert-container inserted-alert">
    <div class="alert alert-solid-secondary" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
      <i class="fa fa-check-circle-o me-2" aria-hidden="true"></i><?php echo $this->session->flashdata('delete_message')['text']; ?>
    </div>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6 class="float-start">ALL EXAMS</h6>
        <div class="float-end">
          <?php echo anchor('cbc/trs/set_exam', '<i class="fa fa-plus">
                    </i> ' . lang('web_add_t', array(':name' => 'Exam')), 'class="btn btn-primary btn-sm"'); ?>
          <?php echo anchor('cbc/trs/all_exams', '<i class="fa fa-list">
                    </i> ' . lang('web_list_all', array(':name' => 'Exams')), 'class="btn btn-info btn-sm"'); ?>
          <a class="btn btn-danger btn-sm" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body p-3 mb-2">
        <!-- <div class="row justify-content-center"> -->
        <div class="table-responsive">
          <table id="datatable-basic" class="table table-bordered">
            <thead>
              <th>#</th>
              <th>Title</th>
              <th>Term</th>
              <th>Year</th>
              <th>Start Date</th>
              <th>End Date</th>
              <th>Recording Deadline</th>
              <th><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              if ($this->uri->segment(4) && ((int) $this->uri->segment(4) > 0)) {
                $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
              }

              foreach ($exams as $p) :
                $i++;
              ?>
                <tr>
                  <td><?php echo $i . '.'; ?></td>
                  <td><?php echo $p->exam; ?></td>
                  <td><?php echo $p->term; ?></td>
                  <td><?php echo $p->year; ?></td>
                  <td><?php echo date('d M Y', $p->sdate); ?></td>
                  <td><?php echo date('d M Y', $p->edate); ?></td>
                  <td><?php echo date('d M Y', $p->rdate); ?></td>
                  <td width='30'>
                    <div class="btn-group my-2">
                      <button type="button" class="btn btn-primary-light dropdown-toggle rounded-pill" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-success" href='<?php echo site_url('cbc/trs/manage_exams/' . $p->id); ?>'><i class='fa fa-share'></i> Manage</a></li>
                        <li><a class="dropdown-item text-primary" href='<?php echo site_url('cbc/trs/edit/' . $p->id); ?>'><i class='fa fa-edit'></i> Edit</a></li>
                        <li><a class="dropdown-item text-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('cbc/trs/delete/' . $p->id); ?>''><i class=' fa fa-trash'></i> Trash</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>

          </table>


        </div>
        <!-- </div> -->
      </div>
      <div class="card-footer">
        <div class="form-check d-inline-block">
          <!-- <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
					<label class="form-check-label" for="flexCheckChecked">
						Confirm
					</label> -->
        </div>
        <div class="float-end d-inline-block btn-list">

        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }

  .inserted-alert {
    position: fixed;
    top: 20px;
    /* Adjust as needed */
    right: 20px;
    /* Adjust as needed */
    z-index: 1000;
    /* Ensure it appears above other content */
  }

  .updated-alert {
    position: fixed;
    top: 70px;
    /* Adjust as needed */
    right: 20px;
    /* Adjust as needed */
    z-index: 1000;
    /* Ensure it appears above other content */
  }


  .alert {
    position: relative;
  }
</style>