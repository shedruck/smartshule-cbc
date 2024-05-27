<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h6><b>Assign Educators Subjects</b></h6>
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
                $options = array('' => 'Select Teacher') + $subjects;
                $attributes = 'class="form-control js-example-basic-single"';
                echo form_dropdown('subject', $options, '', $attributes);
                ?>
                <?php echo form_error('subject'); ?>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='title'>System <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $option = array('1' => 'Term 1', '2' => 'Term 2', '3' => 'Term 3');
                $attributes = 'class="form-control"';
                echo form_dropdown('term', $option, '', $attributes);
                ?>
                <?php echo form_error('term'); ?>
              </div>
            </div>
          </div>

        </div>

      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>