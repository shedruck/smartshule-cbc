<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">

<!-- Include Dropzone.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

<div class="row ">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <!-- <h6 class="float-start m-0">Academic Diary</h6> -->
        <h5 class="mb-0"><b>Academic Diary</b></h5>
        <div class="float-end">
          <?php echo anchor('trs/diary', '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-secondary"'); ?>
        </div>
      </div>

      <div class="card-body p-0">
        <div class="d-lg-flex d-block">
          <div class="table-responsive push">
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
            ?>

            <!-- // fields  -->
            <div class="row justify-content-center">
              <div class="col-dm-8 col-xl-8 col-lg-8 col-sm-12 mt-3 mb-3">

                <div class="row m-2">
                  <label for="date_" class="col-md-3 form-label">Date <span class='required'>*</span></label>
                  <div class="col-md-9">
                    <div class="input-group">
                      <div class="input-group-text">
                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                      </div>
                      <?php echo form_input('date_', $result->date_ > date('d M Y') ? date('d M Y', $result->date_) : date('d M Y'), 'class="validate[required] form-control datepicker col-md-12" placeholder="Choose date"'); ?>
                      <?php echo form_error('date_'); ?>
                    </div>
                    </div>
                  </div>

                  <div class="row m-2">
                    <label for="activity" class="col-md-3 form-label">Activity <span class='required'>*</span></label>
                    <div class="col-md-9">
                      <?php echo form_input('activity', $result->activity, 'id="activity_" autocomplete="off" class="form-control" '); ?>
                      <?php echo form_error('activity'); ?>
                    </div>
                  </div>


                  <div class="row m-2">
                    <label class="col-md-3 form-label">Upload Photos</label>
                    <div class="col-md-9">
                      <!-- <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    <div id="container">
                      <a id="pickfiles" href="javascript:;" class="btn btn-custom btn-rounded">Select files</a>
                    </div>
                    <input type="hidden" id="pids" name="fids" value="0" />
                    <div id="console"></div> -->

                      <div class="input-group mb-3">
                        <input type="file" class="form-control" id="inputGroupFile02" name="file[]" multiple>
                      </div>
                    </div>

                  </div>
                </div>
                <table class="table table-bordered text-nowrap">
                  <thead>
                    <tr class="table-primary bg-primary">
                      <th class="text-center tx-fixed-white">#</th>
                      <th class="text-center tx-fixed-white">Student</th>
                      <th class="text-center tx-fixed-white">Teacher's Comment</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- new table  -->
                    <?php
                    $i = 1;
                    foreach ($students as $post => $val) :
                    ?>
                      <tr>
                        <td class="text-center">
                          <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?></span>
                        </td>
                        <td>
                          <?php echo $val; ?>
                        </td>

                        <td>
                          <textarea name="teacher_comment[<?php echo $post; ?>]" cols="25" rows="3" class="form-control teacher_comment  " style="resize:vertical;" id="teacher_comment"><?php echo set_value('teacher_comment', (isset($result->teacher_comment)) ? htmlspecialchars_decode($result->teacher_comment) : ''); ?></textarea>
                        </td>
                      </tr>
                    <?php
                      $i++;
                    endforeach;
                    ?>
                    <!-- end of new changes  -->

                  </tbody>
                </table>


                <div class="card-footer">
                  <div class="form-check d-inline-block">
                  </div>
                  <div class="float-end d-inline-block btn-list">
                    <?php echo form_submit('submit', ($updType == 'edit') ? '<i class="fe fe-check-square me-1 lh-base"></i> Update' : ' Save', (($updType == 'create') ? "id='submit' class='btn btn-primary'" : "id='submit' class='btn btn-primary' onclick=\"return confirm('Are you sure?')\"")); ?>
                    <?php echo anchor('class_attendance/attendance/list', '<i class="fe fe-arrow-left-circle me-1 lh-base"></i> Cancel', 'class="btn btn-secondary mb-1 d-inline-flex go_back"'); ?>
                  </div>
                </div>

                <?php echo form_close() ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script type="text/javascript">
      var str = '';
      var uploader = new plupload.Uploader({
        runtimes: 'html5,html4',
        browse_button: 'pickfiles',
        container: document.getElementById('container'),
        url: '<?php echo base_url('trs/diary/upload/1'); ?>',
        filters: {
          max_file_size: '20mb',
          mime_types: [{
            title: "Image files",
            extensions: "jpg,gif,png,jpeg,webp"
          }]
        },
        init: {
          PostInit: function() {
            document.getElementById('filelist').innerHTML = '';
          },
          FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
              document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
            });
          },
          UploadProgress: function(up, file) {
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
          },
          Error: function(up, err) {
            document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
          },
          FileUploaded: function(resp, status, headers) {
            if (headers.response == 'login') {
              console.log('You are not Logged In..');
              window.location.reload();
            } else {
              var resp = $.parseJSON(headers.response);
              str = str + resp.fid + '|';
              $("#pids").val(str);
            }
          },
          UploadComplete: function(up, err) {
            $('#dirr').submit();
          }
        }
      });

      uploader.init();

      $('#process').on('click', function(e) {
        if (document.getElementById('filelist').innerHTML != '') {
          uploader.start();
        } else {
          $('#dirr').submit();
        }
      });
    </script>