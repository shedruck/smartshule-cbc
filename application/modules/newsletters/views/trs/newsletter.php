<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b> Newsletters</b></h5>
        <div>

          <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>


      <div class="card-body p-2">
        <div class="col-xxl-12 col-xl-12 col-sm-12">
          <div class="row">
            <?php if ($newsletters) : ?>
              <div class="row people-grid-row">

                <?php
                $i = 0;


                foreach ($newsletters as $p) :

                  $i++;
                ?>

                  <div class="col-xl-4 col-md-6">
                    <div class="card">
                      <div class="card-body text-center" style="overflow: hidden;">
                        <?php
                        if ($p->file === null || $p->file === "") { ?>
                          <h6>No file</h6>
                        <?php } else { ?>
                          <a href="<?php echo base_url() ?>uploads/files/<?php echo $p->file ?>" class="booking-doc-img" style="display: block; overflow: auto; width: 100%; height: 100%;">
                            <iframe src="<?php echo base_url() ?>uploads/files/<?php echo $p->file ?>" class="tr_all_hover" style="width: calc(100% + 17px); height: 100%; overflow-y: scroll; margin-right: -17px;"></iframe>
                          </a>

                        <?php }

                        ?>

                      </div>

                      <div class="card-footer" style="display: flex; justify-content: space-between;">
                        <div>
                          <h6 class="text-white"><a target="_blank" href="<?php echo base_url() ?>uploads/files/<?php echo $p->file ?>" class="text-primary"><?php echo $p->title; ?></a></h6>
                        </div>
                        <div>
                          <p class="mb-0"><a target="_blank" href="<?php echo base_url() ?>uploads/files/<?php echo $p->file ?>" class="text-primary"><i class="fa fa-caret-right"></i><i class="fa fa-caret-right"></i> Read More</a></p>
                        </div>
                      </div>

                    </div>
                  </div>

                <?php endforeach ?>


              <?php else : ?>
                <p class='text'><?php echo lang('web_no_elements'); ?></p>
              <?php endif ?>


              </div>
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
  </style>