<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><b>EDIT STRAND</b></h6>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-7">
          <div class="card" >
            <div class="card-body p-2">
              <div class="head">
                <div class="icon"><span class="icosg-target1"></span></div>
                <h4 class="text-center"><b>Edit Strand</b></h4>
                <div class="right"></div>
              </div>

              <div class="block-fluid">
                <?php
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                echo form_open_multipart(current_url(), $attributes);
                ?>
                <div class='row m-1'>
                  <label for='name' class="col-md-4 form-label"> Strand Name <span class='required'>*</span></label>
                  <div class="col-md-8">
                    <div class="input-group">
                      <?php echo form_input('name', $result->name, 'id="name_"  class="form-control" autocomplete="off" '); ?>
                      <?php echo form_error('name'); ?>
                    </div>
                  </div>
                </div>

                <div class="row m-2">
                  <div class="col-md-3"></div>
                  <div class="col-md-9 text-end">

                  </div>
                </div>

                <div class="clearfix"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-footer">
        <div class="form-group m-b-0">
          <div class="col-sm-offset-3 col-sm-12 text-end">
            <button type="submit" class="btn btn-info"> <i class="fe fe-check-square me-1 lh-base"></i> Submit</button>
          </div>
        </div>
      </div>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>