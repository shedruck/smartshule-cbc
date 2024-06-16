<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b> Upload files to "<?php $f = $this->ion_auth->populate('folders', 'id', 'title');
                                              echo $f[$folder] ?>" folder</b></h5>
        <div>
          <?php echo anchor('past_papers/trs/past_papers', '<i class="fa fa-list"></i> List All Folders', 'class="btn btn-primary btn-sm "'); ?>
          <a class="btn btn-sm btn-secondary mr-2" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>


      <div class="card-body p-2">
        <div class="col-xxl-12 col-xl-12 col-sm-12">
          <div class="row">
            <?php if ($pp) : ?>

              <?php
              $i = 0;

              $path = $this->ion_auth->populate('folders', 'id', 'slug');
              foreach ($pp as $p) :
                $i++;
              ?>

                <div class="col-xl-4 col-md-6">
                  <div class="card">
                    <div class="card-body text-center" style="overflow: hidden;">

                      <?php
                      if ($p->file === null || $p->file === "") { ?>
                        <h6>No file</h6>
                      <?php } else { ?>
                        <a href='<?php echo base_url('uploads/past_papers/' . $path[$folder] . '/' . $p->file); ?>'>
                          <embed src="<?php echo base_url('uploads/past_papers/' . $path[$folder] . '/' . $p->file); ?>" style="width: 100%; height: auto; min-height: 200px;" class="tr_all_hover" type='application/pdf'>
                        </a>
                      <?php }

                      ?>

                    </div>

                    <div class="card-footer">
                      <a target="_blank" href='<?php echo base_url('uploads/past_papers/' . $path[$folder] . '/' . $p->file); ?>' class="btn btn-primary btn-block">Year <?php echo $p->year; ?><br>
                        <?php echo $p->name ?>
                      </a>

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