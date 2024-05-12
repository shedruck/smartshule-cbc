<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            Extra-Curricular Diary
        </h3>
        <div class="portlet-widgets">
            <?php echo anchor('trs/diary/extra', '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-primary"'); ?>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
    <div id="bg-default" class="panel-collapse collapse in">
        <div class="portlet-body">
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => 'dirr');
            echo form_open_multipart(current_url(), $attributes);
            ?>
            <div class='form-group'>
                <label class="col-md-3 control-label" for='student'>Student <span class='required'>*</span></label>
                <div class="col-md-6">
                    <?php
                    echo form_dropdown('student', ['' => ''] + (array) $students, $result->student, ' class="select" data-placeholder="Select Student..." ');
                    echo form_error('student');
                    ?> 
                </div>
            </div>

            <div class='form-group'>
                <label class="col-md-3 control-label" for='activity'>Activity <span class='required'>*</span></label>
                <div class="col-md-6">
                    <?php
                    echo form_dropdown('activity', ['' => ''] + $activities, $result->activity, ' class="select" data-placeholder="Select Activity..." ');
                    echo form_error('activity');
                    ?> 
                </div>
            </div>

            <div class='form-group'>
                <label class="col-md-3 control-label" for='date_'>Date  <span class='required'>*</span></label>
                <div class="col-md-6">
                    <?php
                    $date = '';
                    if (!empty($result->date_) && $result->date_ > 10000)
                    {
                        $date = date('d M Y', $result->date_);
                    }
                    else
                    {
                        $date = set_value('date_reported', (isset($result->date_)) ? $result->date_ : '');
                    }
                    echo form_input('date_', $date, 'id="date__"  class="form-control datepicker" autocomplete="off" ');
                    echo form_error('date_');
                    ?>
                </div>
            </div>
            <div class='form-group'>
                <label class="col-md-3 control-label">Teacher's  Comment  </label><div class="col-md-6">
                    <textarea id="teacher_comment"  rows="5" class=" form-control "  name="teacher_comment"  /><?php echo set_value('teacher_comment', (isset($result->teacher_comment)) ? htmlspecialchars_decode($result->teacher_comment) : ''); ?></textarea>
                    <?php echo form_error('teacher_comment'); ?>
                </div>
            </div>
            <div class="form-group">
                <label  class="col-sm-3 control-label">Upload Photos </label>
                <div class="col-sm-9">
                    <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    <div id="container">
                        <a id="pickfiles" href="javascript:;" class="btn btn-custom btn-rounded">Select files</a>
                    </div>
                    <input type="hidden" id="pids" name="fids" value="0"/>
                    <div id="console"></div>
                </div>
            </div>

            <hr>
            <div class='form-group'>
                <div class="col-md-3 control-label"></div>
                <div class="col-md-6">
                    <a href="<?php echo base_url('trs/diary/extra'); ?>" class="btn btn-default">  <i class="mdi mdi-close"></i> <span>Cancel</span></a>
                    <button  type="button" id="process" class="btn btn-pink"> <i class="mdi mdi-send"></i> <span> Submit &nbsp; </span> </button>
                </div>
            </div>

            <?php echo form_close(); ?>
            <div class="clearfix mb-5"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var str = '';
    var uploader = new plupload.Uploader({
        runtimes: 'html5,html4',
        browse_button: 'pickfiles',
        container: document.getElementById('container'),
        url: '<?php echo base_url('trs/diary/upload/2'); ?>',
        filters: {
            max_file_size: '20mb',
            mime_types: [
                {title: "Image files", extensions: "jpg,gif,png,jpeg,webp"}
            ]
        },
        init: {
            PostInit: function () {
                document.getElementById('filelist').innerHTML = '';
            },
            FilesAdded: function (up, files)
            {
                plupload.each(files, function (file)
                {
                    document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                });
            },
            UploadProgress: function (up, file)
            {
                document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
            },
            Error: function (up, err)
            {
                document.getElementById('console').appendChild(document.createTextNode("\nError #" + err.code + ": " + err.message));
            },
            FileUploaded: function (resp, status, headers)
            {
                if (headers.response == 'login')
                {
                    console.log('You are not Logged In..');
                    window.location.reload();
                }
                else
                {
                    var resp = $.parseJSON(headers.response);
                    str = str + resp.fid + '|';
                    $("#pids").val(str);
                }
            },
            UploadComplete: function (up, err)
            {
                $('#dirr').submit();
            }
        }
    });

    uploader.init();

    $('#process').on('click', function (e)
    {
        if (document.getElementById('filelist').innerHTML != '')
        {
            uploader.start();
        }
        else
        {
            $('#dirr').submit();
        }
    });
</script>