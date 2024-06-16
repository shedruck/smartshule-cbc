<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><b>E-NOTES</b></h5>
        <div>
          <?php echo anchor('enotes/trs', '<i class="fa fa-list"> </i> List All', 'class="btn btn-sm btn-primary mr-2"'); ?>
          <a class="btn btn-sm btn-secondary" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
      </div>



      <div class="card-body p-2">
        <?php
        $attributes = array('class' => 'form-horizontal', 'id' => '');
        echo   form_open_multipart(current_url(), $attributes);
        ?>
        <div class="row justify-content-center">
          <div class="col-dm-9 col-xl-9 col-lg-9 col-sm-12 mt-3 mb-3">
            <div class="row m-2">
              <label class="col-md-3 form-label" for='term'>Term <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $terms = array('1' => 'Term 1', '2' => 'Term 2', '3' => 'Term 3', '4' => 'Term 4');
                echo form_dropdown('term', array('' => 'Select Term') + $terms, (isset($result->term)) ? $result->term : '', ' class="form-control select" id="term" data-placeholder="" ');
                ?>
                <?php echo form_error('term'); ?>

              </div>
            </div>

            <?php
            $range = range(date('Y') - 5, date('Y') + 2);
            $yrs = array_combine($range, $range);
            krsort($yrs);
            ?>

            <div class="row m-2">
              <label class="col-md-3 form-label" for='year'>Year <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                echo form_dropdown('year', array('' => '') + $yrs, (isset($result->year) && !empty($result->year)) ? $result->year : date('Y'), ' class="form-control select" placeholder="Select Year" ');
                echo form_error('year');
                ?>

              </div>
            </div>

            <div class="row m-2">
              <label for='class' class="col-md-3 form-label">Class <span class='required'>*</span></label>
              <div class="col-md-9">
                <div class="input-group">

                  <?php
                  $classes = $this->portal_m->get_class_options();
                  echo form_dropdown('class', array('' => 'Select Class') + $classes + array('999' => 'Any class'), (isset($result->class)) ? $result->class : '', ' class="select form-control" id="class" data-placeholder="" ');
                  ?>
                  <?php echo form_error('class'); ?>
                </div>
              </div>
            </div>

            <div class="row m-2">
              <label class="col-md-3 form-label" for='subject'>Subject/Learning Area <span class='required'>*</span></label>
              <div class="col-md-9">
                <?php
                $items = array('' => 'Select Subject');
                echo form_dropdown('subject', $items, (isset($result->subject)) ? $result->subject : '', ' id="subject" class="form-control select" data-placeholder="Select Options..." ');
                echo form_error('subject');
                ?>
              </div>
            </div>

            <div class="row m-2">
              <label for='topic' class="col-sm-3 form-label">Topic</label>
              <div class="col-sm-9">
                <?php echo form_input('topic', $result->topic, 'id="topic"  class="form-control" '); ?>
                <?php echo form_error('topic'); ?>
              </div>
            </div>
            <div class="row m-2">
              <label for='subtopic' class="col-sm-3 form-label">Subtopic</label>
              <div class="col-sm-9">
                <?php echo form_input('subtopic', $result->subtopic, 'id="subtopic"  class="form-control" '); ?>
                <?php echo form_error('subtopic'); ?>
              </div>
            </div>
            <div class="row m-2">
              <label for='file' class="col-sm-3 form-label">Upload document (pdf/word/image)</label>
              <div class="col-sm-9">
                <input type="file" class="form-control" id="inputGroupFile02" name="file" accept="image/*">
                <br /><?php echo form_error('file'); ?>
                <?php echo (isset($upload_error['file'])) ?  $upload_error['file']  : ""; ?>
              </div>
            </div>
            <div class="row m-2">
              <label for='soft' class="col-sm-3 form-label">Soft (Paste Soft copy here if not attachment)</label>
              <div class="col-sm-9">
                <textarea id="editor" style="height: 120px;" class="form-control" name="soft"><?php echo isset($result->soft) ? htmlspecialchars_decode($result->soft) : ''; ?></textarea>

                <?php echo form_error('soft'); ?>
              </div>
            </div>
            <div class="row m-2">
              <label for='remarks' class="col-sm-3 form-label">Remarks</label>
              <div class="col-sm-9">
                <textarea id="remarks" style="height: 120px;" class="form-control editor" name="remarks" /><?php echo isset($result->remarks) ? htmlspecialchars_decode($result->remarks) : ''; ?></textarea>

                <?php echo form_error('remarks'); ?>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-footer">
        <div class="float-end">
          <?php echo anchor('enotes/trs', '<i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel', 'class="btn btn-secondary mb-1 d-inline-flex go_back"'); ?>
          <button type="submit" class="btn btn-info mb-1 d-inline-flex" id="auto-disappear-save"  onclick="return confirm('Are you sure?')">
            <i class="fe fe-check-square me-1 lh-base"></i>
            <?php echo ($updType == 'edit') ? 'Update' : 'Save'; ?>
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
</style>

<script>
  jQuery(function() {

    jQuery("#class").change(function() {
      jQuery('#subject').empty();

      var level = jQuery(".class").val();

      var options = '';
      jQuery('#subject').children().remove();

      jQuery.getJSON("<?php echo base_url('trs/list_subjects'); ?>", {
        id: jQuery(this).val()
      }, function(data) {


        for (var i = 0; i < data.length; i++) {

          options += '<option value="' + data[i].optionValue + '">' + data[i].optionDisplay + '</option>';
        }

        jQuery('#subject').append(options);

      });

      //alert(options);
    });

    $(".tsel").select2({
      'placeholder': 'Please Select',
      'width': '100%'
    });
  });
</script>