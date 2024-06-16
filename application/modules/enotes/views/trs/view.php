<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>E-NOTES</b></h5>
        <div>
          <?php echo anchor('enotes/trs/new_enotes/' . $this->session->userdata['session_id'], '<i class="fa fa-plus"></i> New E-Notes', 'class="btn btn-primary btn-sm "'); ?>

          <?php echo anchor('enotes/trs/', '<i class="fa fa-list"></i> List All E-Notes', 'class="btn btn-success btn-sm "'); ?>
          <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>



      <div class="card-body p-2">
        <!-- ROW-1 -->
        <div class="row">
          <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-5">

            <!-- card one -->
            <div class="card text-center shadow-none border profile-cover__img">
              <div class="card-body">
                <div class="profile-img-1">
                  <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="140" height="140" class="img-circle img-thumbnail" alt="profile-image">
                  <!-- <i class="mdi mdi-star-circle member-star text-success" title="verified user"></i> -->
                </div>
                <div>
                  <div class="text-warning mb-0 mt-2">
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                    <i class="fa fa-star fs-20"></i>
                  </div>
                </div>
                <div class="profile-img-content text-dark my-2">
                  <div>
                    <?php $u = $this->ion_auth->get_user($post->created_by); ?>
                    <h5 class="mb-0">BY: <?php echo strtoupper($u->first_name . ' ' . $u->last_name); ?></h5>
                    <p class="text-muted mb-0">Educator / teacher</p>
                  </div>
                </div>

                <div class="d-flex btn-list btn-list-icon justify-content-center">
                  <?php
                  if (!empty($post->file_name)) {
                  ?>
                    <a class="btn btn-sm btn-primary" target="_blank" href='<?php echo base_url() ?><?php echo $post->file_path ?>/<?php echo $post->file_name ?>' /><i class='fa fa-download'></i> Download</a>
                  <?php } ?>

                </div>

              </div>
              <div class="card-footer">
                <div class="text-left">
                  <p class="text-black font-13"><strong>SUBJECT :</strong>
                    <?php

                    $sub = $this->portal_m->get_subject($post->class); ?>
                    <span class="m-l-15"><?php echo  isset($sub[$post->subject]) ? $sub[$post->subject] : '';; ?></span>
                  </p>

                  <p class="text-black font-13"><strong>TOPIC :</strong> <span class="m-l-15"><?php echo $post->topic; ?></span></p>

                  <p class="text-black font-13"><strong>SUBTOPIC :</strong> <span class="m-l-15"><?php echo $post->subtopic; ?></span></p>

                  <p class="text-black font-13"><strong>POSTED ON :</strong> <span class="m-l-15"><?php echo date('d M Y', $post->created_on); ?></span></p>




                </div>

                <hr>
                <h4>Comment / Remarks</h4>
                <p class="text-black font-13 m-t-20">
                  <?php echo $post->remarks ?>
                </p>
              </div>
            </div>


          </div>

          <!-- card two -->
          <div class="col-xxl-9 col-xl-8 col-lg-7 col-md-7">
            <div class="card">
              <div class="card-header">
                <h5 class="mb-0">E-Note - <?php echo  isset($sub[$post->subject]) ? $sub[$post->subject] : ''; ?></h5>
              </div>
              <div class="card-body p-0">
                <?php
                if ($post->file_name === null || $post->file_name === "") { ?>
                  <h6>No file uploaded</h6>
                <?php } else { ?>
                  <embed src="<?php echo base_url() ?><?php echo $post->file_path ?>/<?php echo $post->file_name ?>" width="100%" height="700" class="tr_all_hover" type='application/pdf'>
                <?php }

                ?>
              </div>
            </div>
          </div>
        </div>
        <!-- ROW-1 CLOSED -->

      </div>
      <div class="card-footer">


      </div>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>

<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>