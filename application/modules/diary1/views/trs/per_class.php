<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Student Diary
        <div class="pull-right">
            <?php echo anchor('trs/diary/', '<i class="fa fa-caret-left"></i> Back', 'class="btn btn-danger"'); ?>
        </div>
    </h2>
</div>
<div class="block-fluid card-box table-responsive">
    <?php
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    echo form_open_multipart(current_url(), $attributes);
    ?>
    <div class='form-group '>
        <div class="col-md-3 control-label" for='activity'> Date <span class='required'>*</span></div>
        <div class="col-md-4">
            <div id="datetimepicker1" class="input-group date form_datetime">
                <?php echo form_input('date_', $result->date_ > date('d M Y') ? date('d M Y', $result->date_) : date('d M Y'), 'class="validate[required] form-control datepicker col-md-4"'); ?>
                <span class="input-group-addon "><i class="mdi mdi-calendar"></i></span>
            </div><?php echo form_error('date_'); ?>
        </div>
    </div>
     <div class='form-group '>
		<label class="col-md-3 control-label" for='activity'>Activity <span class='required'>*</span></label>
		<div class="col-md-4">
			<?php echo form_input('activity', $result->activity, 'id="activity_" autocomplete="off" class="form-control" '); ?>
			<?php echo form_error('activity'); ?>
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
			
			
    <table class="table table-striped table-bordered  " >
        <!-- BEGIN -->
        <thead>
            <tr >
                <th width="3">#</th>
                <th >Student</th>
                <th  >Teacher's Comment</th>
            </tr>
        </thead>
        <tbody role="alert">
            <?php
            $i = 1;
            foreach ($students as $post => $val):
                    ?>  
                    <tr >
                        <td >
                            <span id="reference" name="reference" class="heading-reference"><?php echo $i; ?></span>
                        </td> 
                        <td>
                            <?php echo $val; ?>
                        </td>
                       
                        <td>
                            <textarea name="teacher_comment[<?php echo $post; ?>]" cols="25" rows="5" class="form-control teacher_comment  " style="resize:vertical;" id="teacher_comment"><?php echo set_value('teacher_comment', (isset($result->teacher_comment)) ? htmlspecialchars_decode($result->teacher_comment) : ''); ?></textarea>
                        </td>
                    </tr>
                    <?php
                    $i++;
            endforeach;
            ?>		
        </tbody>
    </table>
    <div class='form-group'>
        <div class="col-md-5"></div>
        <div class="col-md-6">
          
            <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Save Changes', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
			  <?php echo anchor('trs/attendance', 'Cancel', 'class="btn btn-default"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
    <div class="clearfix"></div>
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
