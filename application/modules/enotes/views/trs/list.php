<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>E-NOTES</b></h5>
        <div>
          <?php echo anchor('enotes/trs/new_enotes/' . $this->session->userdata['session_id'], '<i class="fa fa-plus"></i> New E-Notes', 'class="btn btn-primary btn-sm"'); ?>
          <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>


      <div class="card-body p-2">
        <?php if ($enotes) : ?>
          <!-- <table id="datatable-buttons" class="table table-striped table-bordered"> -->
          <table id="file-export" class="table table-bordered mt-3">
            <thead class="table-success">
              <th>#</th>
              <th>Term</th>
              <th>Class</th>
              <th>Subject</th>
              <th>File</th>
              <th>Status</th>
              <th><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
              <?php
              $i = 0;
              $classes = $this->portal_m->get_class_options();

              foreach ($enotes as $p) :
                $sub = $this->portal_m->get_subject($p->class);
                $i++;
              ?>
                <tr>
                  <td><?php echo $i . '.'; ?></td>
                  <td>
                    Term <?php echo $p->term; ?>
                    <p><?php echo $p->year; ?></p>

                  </td>
                  <td><?php echo $classes[$p->class]; ?></td>
                  <td>
                    <?php echo strtoupper($sub[$p->subject]); ?>
                    <br><b>Topic:</b> <?php echo $p->topic; ?>
                    <br><b>Subtopic:</b> <?php echo $p->subtopic; ?>
                  </td>
                  <td><a class="btn btn-sm btn-info-gradient" target="_blank" href='<?php echo base_url() ?><?php echo $p->file_path ?>/<?php echo $p->file_name ?>' /><i class='fa fa-download'></i> Download</a></td>
                  <td>
                    <?php
                    if ($p->status == 1) {
                    ?>
                      <a class="btn btn-sm btn-secondary-gradient" onClick="return confirm('Are you sure you want to unpublish this E-notes?')" href='<?php echo site_url('enotes/trs/update_status/' . $p->id . '/0'); ?>'><i class='fa fa-download'></i> Unpublish</a>

                    <?php } else { ?>

                      <a class="btn btn-sm btn-success-gradient" onClick="return confirm('Are you sure you want to publish this  E-notes?')" href='<?php echo site_url('enotes/trs/update_status/' . $p->id . '/1'); ?>'><i class='fa fa-upload'></i> Publish</a>
                    <?php } ?>
                  </td>



                  <td width='250'>
                    <div class='btn-group'>
                      <a class="btn btn-sm btn-success" href='<?php echo site_url('enotes/trs/view/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-share'></i> View</a>
                      <a class="btn btn-sm btn-primary" href='<?php echo site_url('enotes/trs/edit/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-edit'></i> Edit</a>
                      <a class="btn btn-sm btn-secondary" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('enotes/trs/delete/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'><i class='fa fa-trash'></i> Trash</a>

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