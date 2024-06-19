<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><b>EDIT SUBJECT</b></h6>
        <div>
          <a class="btn btn-sm btn-secondary" href="<?php echo base_url('cbc/trs/subjects'); ?>"><i class="fa fa-caret-left"></i> Go Back</a>
         
        </div>
      </div>

      <div class="card-body p-2">
        <h4 class="m-t-0 m-b-10 header-title text-center">Edit Subject</h4>
        <?php
        // Open the form with the desired attributes
        $attributes = array('class' => 'form-horizontal form-main', 'role' => 'form', 'action' => current_url(), 'method' => 'POST');
        echo form_open_multipart(current_url(), $attributes);
        ?>

        <div class="row justify-content-center">
          <div class="col-dm-9 col-xl-9 col-lg-9 col-sm-12 mt-3 mb-3">

            <!-- Form Group for Name -->
            <div class="row m-2">
              <label class="col-md-2 form-label" for="name_">Name <span class="required">*</span></label>
              <div class="col-md-10">
                <?php echo form_input('name', $post->name, 'id="name_" class="form-control" required'); ?>
                <?php echo form_error('name'); ?>
              </div>
            </div>

            <!-- Form Group for Type -->
            <div class="row m-2">
              <label class="col-md-2 form-label" for="cat">Type <span class="required">*</span></label>
              <div class="col-md-10">
                <?php
                $ifr = [
                  '' => 'Select Subject Type',
                  0 => "Regular Subject",
                  1 => "Optional Subject",
                  2 => "Elective Subject"
                ];
                echo form_dropdown('cat', $ifr, (isset($post->cat)) ? $post->cat : '', ' class="form-control js-example-basic-single" id="cat" required');
                echo form_error('cat');
                ?>
              </div>
            </div>

            <!-- Section Header for Class Assignment -->
            <div class="row m-2">
              <div class="col-md-12">
                <h4 class="text-center">Assign Subject to Classes</h4>
              </div>
            </div>

            <!-- Form Group for Class Assignment -->
            <div class="row m-2">
              <div class="col-md-9 offset-md-3">
                <div class="clonedInput">
                  <div class="form-group">
                    <?php
                    // Form Dropdown with Select2 integration
                    echo form_dropdown('class[]', $this->classes, $assigned, 'class="form-control js-example-placeholder-multiple" multiple="multiple" id="classes" required');
                    echo form_error('class');
                    ?>
                  </div>

                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
      <div class="card-footer">
        <div class="float-end">
          <a href="<?php echo base_url('cbc/trs/subjects') ?>" class="btn btn-secondary mb-1 d-inline-flex"><i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel</a>
          <button type="submit" class="btn btn-primary mb-1 d-inline-flex" onclick="return confirm('Are you sure?')">
            <i class="fe fe-check-square me-1 lh-base"></i> Submit
          </button>
        </div>
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

  .form-horizontal .form-group {
    margin-bottom: 1rem;
  }

  .form-horizontal .form-label {
    padding-top: calc(.375rem + 1px);
    padding-bottom: calc(.375rem + 1px);
  }
</style>
<script>
  $(document).ready(function() {
    
    $('#classes').select2({
      placeholder: "Select class", 
      allowClear: true 
    });
  });
</script>