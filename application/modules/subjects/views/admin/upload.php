<div class="col-md-8">
    <div class="head"> 
        <div class="icon"><span class="icosg-target1"></span></div>		
        <h2>  Upload Question Paper  </h2>
        <div class="right"> 
            <?php echo anchor('admin/subjects/create', '<i class="glyphicon glyphicon-plus">
                </i> ' . lang('web_add_t', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/subjects', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Subjects')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>

    <div class="block">
        <div class="widget">
            <?php echo form_open(current_url(), 'id="form"'); ?>
            
            <div class='form-group'>
                <div class="col-md-3" for='file'>File <span class='required'>*</span></div>
                <div class="col-md-6">
                    <?php echo form_error('filename'); ?>
                    <?php echo ( isset($upload_error['filename'])) ? $upload_error['filename'] : ""; ?>
                    <?php echo form_upload('filename', '', 'id="filename"'); ?>
                    <?php echo (isset($error)) ? $error : ''; ?>
                </div>
            </div>
            <div class='form-group'>
                <div class="col-md-3" for='class'>Class <span class='required'>*</span></div>
                <div class="col-md-6">
                    <?php echo form_dropdown('class', $this->classes, $this->input->post('class'), ' class="qsel form-control" id="class" placeholder="Exam" '); ?>
                </div>
            </div>
            <div class='form-group'>
                <div class="col-md-3" for='exam'>Exam <span class='required'>*</span></div>
                <div class="col-md-6">
                    <?php echo form_dropdown('exam', $exams, $this->input->post('exam'), ' class="qsel form-control" id="exam" placeholder="Exam" '); ?>
                </div>
            </div>
            <input type="button" value="Submit" id="batch" />
            <?php echo form_close(); ?> 
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
// Initialize the widget when the DOM is ready
        $(function () {
            $(".qsel").select2({'placeholder': 'Please Select', 'width': '190px'});
            $(".qsel").on("change", function (e) {
                notify('Select', 'Value changed: ' + e.val);
            });
            var base_url = '<?php echo base_url(); ?>';
            var sid = '<?php echo $sid; ?>';
            $('#filename').uploadify({
                'debug': false,
                'auto': false,
                'swf': '<?php echo plugin_path('uploadify/uploadify.swf'); ?>',
                'uploader': base_url + 'admin/subjects/do_upload/' + sid,
                'cancelImg': '<?php echo plugin_path('uploadify/uploadify-cancel.png'); ?>',
                'fileTypeExts': '*.jpg;*.png;',
                'fileTypeDesc': 'Image (.jpg)',
                'fileSizeLimit': '10MB',
                'fileObjName': 'filename',
                'buttonText': 'Browse',
                'multi': true,
                'removeCompleted': false,
                'onUploadError': function (file, errorCode, errorMsg, errorString)
                {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                },
                'onUploadComplete': function (MsgString)
                {

                },
                'onUploadSuccess': function (obj, file, status)
                {
                    if (file == 'login')
                    {
                        console.log('You are not Logged In..');
                        window.location.reload();
                    }
                    else {
                        var resp = $.parseJSON(file);
                        var exm = $("#exam").val();
                        var cls = $("#class").val();
                        var tid = resp.pid;

                        $.ajax({
                            type: 'POST',
                            url: base_url + 'admin/subjects/update_paper/' + tid,
                            data: {exam: exm, id: tid},
                            success: function (data)
                            {
                                notify('Success', 'Upload Successfully Completed' + data);
                                window.location.href = BASE_URL + 'admin/subjects/past_papers/' + sid;
                            },
                            error: function ()
                            {
                                notify('Error', '<p class="error"><strong>Oops!</strong> Try that again in a few moments.</p>');
                            }
                        });
                    }

                }
            });

            $("#batch").on("click", function ()
            {
                var exm = $("#exam").val();
                var cls = $("#class").val();
                 $('#filename').uploadify('upload', '*');
            });

        });
</script>