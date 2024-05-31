<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-uppercase"><b>ASSIGN SUBJECTS</b></h6>
        <div>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>
      <div class="card-body">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => 'form');
        echo form_open(current_url());
        ?>
        <div class="row">
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Class <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $options = array('' => 'Select Class') + $this->streams;
                $attributes = 'class="form-control js-example-basic-single"';
                echo form_dropdown('class', $options, '', $attributes);
                ?>
                <?php echo form_error('class'); ?>

              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>Teacher <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $options = array('' => 'Select Teacher') + $teachers;
                $attributes = 'class="form-control js-example-basic-single"';
                echo form_dropdown('teacher', $options, '', $attributes);
                ?>
                <?php echo form_error('teacher'); ?>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>System <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $option = array('1' => '8.4.4 / IGCSE', '2' => 'CBC');
                $attributes = 'class="form-control"';
                echo form_dropdown('type', $option, '', $attributes);
                ?>
                <?php echo form_error('type'); ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <!-- Second Row -->
          <div class="col-xl-12">
            <div class="row m-2 justify-content-end">

              <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-1 d-inline-flex">
                  <i class="fe fe-check-square me-1 lh-base"></i>
                  <?php echo ($updType == 'edit') ? 'Update' : 'Submit'; ?>
                </button>
                <button class="btn btn-info" onclick="printInvoice(event)"> <i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>

      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>



<!-- card -->
<?php if (!empty($subs)  && $this->input->post()) {

?>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0 text-uppercase"><b>ASSIGN <span class="text-secondary"> <?php echo $teachers[$teacher] ?> </span> SUBJECTS</b></h6>
          <div>

          </div>
        </div>



        <div class="card-body p-2">
          <?php
          $attributes = array('class' => 'form-horizontal', 'id' => '');
          echo   form_open_multipart(base_url('teachers/trs/save_assign/'), $attributes);
          ?>
          <div class="row justify-content-center">
            <div class="col-dm-9 col-xl-9 col-lg-9 col-sm-12 mt-3 mb-3">



              <table class="table table-bordered">
                <tr class="bg-primary">
                  <th class="text-center tx-fixed-white">#</th>
                  <th class="text-center tx-fixed-white">Subject</th>
                  <th class="text-center tx-fixed-white">Assign</th>
                </tr>
                <tbody>
                  <?php
                  if (!empty($subs)) {
                    $i = 1;
                    foreach ($subs as $key => $sub) {
                      # code...

                  ?>
                      <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $sub->name ?></td>
                        <td style="text-align:center"> <input class="form-check-input ms-2" type="checkbox" name="assign_<?php echo $sub->id; ?>" value="1">
                          <!-- Add hidden fields -->
                          <?php echo form_hidden('class', $class); ?>
                          <?php echo form_hidden('teacher', $teacher); ?>
                          <?php echo form_hidden('type', $type); ?>
                        </td>
                      </tr>
                    <?php   }
                  } else { ?>
                    <tr>
                      <td colspan="2">
                        <div class="alert alert-danger">No subjects Assigned to this Class !!!</div>
                      </td>
                    </tr>
                  <?php }

                  ?>
                </tbody>
              </table>


            </div>
          </div>

        </div>
        <div class="card-footer">
          <div class="float-end">
            <?php echo anchor('trs', '<i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel', 'class="btn btn-secondary mb-1 d-inline-flex go_back"'); ?>
            <button type="submit" class="btn btn-info mb-1 d-inline-flex" onclick="return confirm('Are you sure?')">
              <i class="fe fe-check-square me-1 lh-base"></i>
              <?php echo ($updType == 'edit') ? 'Update' : 'Save'; ?>
            </button>

          </div>

        </div>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
<?php } ?>
<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }
</style>