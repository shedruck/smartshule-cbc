<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>Past Papers</b></h5>
        <div>
          <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>


      <div class="card-body p-2">
        <div class="col-xxl-12 col-xl-12 col-sm-12">
          <div class="row">
            <?php if ($past_papers) : ?>

              <?php
              $i = 0;

              foreach ($past_papers as $p) :
                $i++;
                $counter = $this->portal_m->file_folders($p->id);
              ?>


                <!-- start of new Folder -->
                <div class="col-xl-3 col-sm-6">
                  <div class="card file-manager">
                    <a href='<?php echo site_url('past_papers/trs/view_past_papers/' . $p->id . '/' . $this->session->userdata['session_id']); ?>'>
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="folder-file">
                            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24">
                              <path fill="#00a5a2" d="M19.97586,10V9a3,3,0,0,0-3-3H10.69678l-.31622-.94868A3,3,0,0,0,7.53451,3H3.97586a3,3,0,0,0-3,3V19a2,2,0,0,0,2,2H3.3067a2,2,0,0,0,1.96774-1.64223l1.40283-7.71554A2,2,0,0,1,8.645,10Z"></path>
                              <path fill="#9dd1d0" d="M22.02386,10H8.645a2,2,0,0,0-1.96777,1.64221L5.27441,19.35773A2,2,0,0,1,3.3067,21H19.55292a2,2,0,0,0,1.96771-1.64227l1.48712-8.17884A1,1,0,0,0,22.02386,10Z"></path>
                            </svg>
                          </span>

                        </div>
                    </a>
                    <h6 class="fw-semibold my-1"><a href='<?php echo site_url('past_papers/trs/view_past_papers/' . $p->id . '/' . $this->session->userdata['session_id']); ?>' class=""><?php echo $p->title; ?></a></h6>

                  </div>
                </div>
          </div>
          <!-- end of a new folder -->

        <?php endforeach ?>


      <?php else : ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
      <?php endif ?>

        </div>
      </div>


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