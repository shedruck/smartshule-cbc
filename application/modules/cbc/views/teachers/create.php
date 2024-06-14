<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>CBC SUBJECTS</b></h5>
        <div>
          <?php echo anchor('cbc/trs/subjects', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn btn-primary btn-sm"'); ?>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>

      <div class="card-body p-2">
        <?php echo form_open('cbc/trs/add_subject', array('class' => 'form-horizontal', 'id' => '')); ?>
        <div class="row justify-content-center">
          <div class="col-md-9 col-xl-9 col-lg-9 col-sm-12 mt-3 mb-3">

            <div class="row m-2">
              <label class="col-md-3 col-form-label text-md-right" for='name'>Name <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php echo form_input('name', $result->name ?? '', 'id="name_" class="form-control"'); ?>
                <?php echo form_error('name'); ?>
              </div>
            </div>

            <div class="row m-2">
              <label class="col-md-3 col-form-label text-md-right" for='cat'>Type <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $ifr = [
                  '' => '',
                  0 => "Regular Subject",
                  1 => "Optional Subject",
                  2 => "Elective Subject"
                ];
                echo form_dropdown('cat', $ifr, $result->cat ?? '', 'class="form-control qsel" placeholder="Select Subject Type"');
                echo form_error('cat');
                ?>
              </div>
            </div>


            <div id="entry1" class="clonedInput">
              <div class="row m-2">
                <label class="col-md-3 col-form-label text-md-right" for='class'>Classes</label>
                <div class="col-md-9">
                  <?php echo form_multiselect('class[]', $this->classes, set_value('class[]', isset($result->class) ? $result->class : ''), 'class="form-control js-example-placeholder-multiple xsel" placeholder="Select Classes" multiple="multiple" id="classes"'); ?>
                  <?php echo form_error('class'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="float-end">
            <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save', 'class="btn btn-primary"'); ?>
            <?php echo anchor('teachers/cbc/subjects', 'Cancel', 'class="btn btn-default"'); ?>
          </div>
        </div>

        <?php echo form_close(); ?>
      </div>

    </div>
  </div>
</div>



<style>
  .card-header {
    display: flex;
    justify-content: space-between;
  }

  .form-group .form-label {
    text-align: right;
    /* Right-aligns labels for better alignment with inputs */
  }

  .form-group .form-control {
    width: 100%;
    /* Ensures inputs take full width within their column */
  }

  .row.m-2 {
    margin: 0.5rem 0;
    /* Adds vertical spacing between rows for better readability */
  }

  .form-control,
  .form-control:focus {
    box-shadow: none;
    /* Optional: Removes shadow on focus for a cleaner look */
  }

  .clonedInput {
    margin-bottom: 1rem;
    /* Adds spacing between cloned input groups */
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