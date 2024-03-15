<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            TRANSITION PROFILE
        </h3>
        <div class="portlet-widgets">
            <?php echo anchor('trs/transition_profile', '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-primary"'); ?>
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
            <div class='form-group col-md-4'>
                <label class="col-md-3 control-label" for='student'>Student <span class='required'>*</span></label>
                <div class="col-md-6">
                    <?php
                    echo form_dropdown('student', ['' => ''] + (array) $students, $result->student, ' class="select" data-placeholder="Select Student..." ');
                    echo form_error('student');
                    ?> 
                </div>
            </div>

             <div class='form-group col-md-4'>
                <label class="col-md-3 control-label" for='class'>class <span class='required'>*</span></label>
                <div class="col-md-6">
                    <?php
                    echo form_dropdown('class', ['' => ''] + (array) $classes, $result->class, ' class="select" data-placeholder="Select Class..." ');
                    echo form_error('class');
                    ?> 
                </div>
            </div>

            <div class='form-group col-md-4'>
                <label class="col-md-3 control-label" for='Year'>Year <span class='required'>*</span></label>
                <div class="col-md-6">
                    <?php
                    $settings = $this->ion_auth->settings();
                     $year = $settings->year;
                    if(!$year){
                        $year = date('Y');
                    }
                   
                   
                    echo form_dropdown('year', [$year => $year] + (array) $yrs, $result->year, ' class="select" data-placeholder="Year..." ');
                    echo form_error('year');
                    ?> 
                </div>
            </div>


            


            <table class="table">
                <tr>
                    <th>Key Areas</th>
                    <th>Comments</th>
                </tr>
                <tr>
                    <td>Allergies</td>
                    <td>
                        <div class="form-group">
                            <textarea id="allergy" class="form-control"    name="allergy"  /><?php echo set_value('allergy', (isset($result->allergy)) ? htmlspecialchars_decode($result->allergy) : ''); ?></textarea>
                            <?php echo form_error('allergy'); ?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>General Health comment</td>
                    <td>
                        <div class="form-group">
                            <textarea id="general_health"   class=" form-control "  name="general_health"  /><?php echo set_value('general_health', (isset($result->general_health)) ? htmlspecialchars_decode($result->general_health) : ''); ?></textarea>
                            <?php echo form_error('general_health'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>General Academic Performance</td>
                    <td>
                        <div class="form-group">
                            <textarea id="general_academic"    class=" form-control "  name="general_academic"  /><?php echo set_value('general_academic', (isset($result->general_academic)) ? htmlspecialchars_decode($result->general_academic) : ''); ?></textarea>
                                <?php echo form_error('general_academic'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Feeding Habit</td>
                    <td>
                        <div class="form-group">
                            <textarea id="feeding_habit"    class=" form-control "  name="feeding_habit"  /><?php echo set_value('feeding_habit', (isset($result->feeding_habit)) ? htmlspecialchars_decode($result->feeding_habit) : ''); ?></textarea>
                            <?php echo form_error('feeding_habit'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Behavior</td>
                    <td>
                        <div class="form-group">
                            <textarea id="behaviour"    class=" form-control "  name="behaviour"  /><?php echo set_value('behaviour', (isset($result->behaviour)) ? htmlspecialchars_decode($result->behaviour) : ''); ?></textarea>
                                <?php echo form_error('behaviour'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Co-curriculum Activities</td>
                    <td>
                        <div class="form-group">
                            <textarea id="co_curriculum "     class=" form-control "  name="co_curriculum"  /><?php echo set_value('co_curriculum ', (isset($result->co_curriculum )) ? htmlspecialchars_decode($result->co_curriculum ) : ''); ?></textarea>
                                <?php echo form_error('co_curriculum '); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Parental involvement</td>
                    <td>
                        <div class="form-group">
                            <textarea id="parental_involvement"     class=" form-control "  name="parental_involvement"  /><?php echo set_value('parental_involvement', (isset($result->parental_involvement)) ? htmlspecialchars_decode($result->parental_involvement) : ''); ?></textarea>
                            <?php echo form_error('parental_involvement'); ?>
                        </div>
                    </td>
                </tr>

                    <td>Transport</td>
                    <td>
                        <div class='form-group'>
                             <div class='col-md-3 inline' for='transport_0'> Private transport </div><input type='radio' name='transport' id='transport_0' value='private' <?php echo preset_radio('transport', 'private', (isset($result->transport)) ? $result->transport : 'private'  );?> >

                        </div>
                        <div class="form-group">
                             <div class='col-md-3 inline' for='transport_1'> School transport </div>
                             <input type='radio' name='transport' id='transport_1' value='school' <?php echo preset_radio('transport', 'school', (isset($result->transport)) ? $result->transport : 'private'  );?> > 
                        </div>
   
    
    <?php echo form_error('transport'); ?>
</div>
</div>
                    </td>
                </tr>

                <tr>
                    <td>Any other information</td>
                    <td>
                        <div class="form-group">
                            <textarea id="any_info"     class=" form-control "  name="any_info"  /><?php echo set_value('any_info', (isset($result->any_info)) ? htmlspecialchars_decode($result->any_info) : ''); ?></textarea>
                            <?php echo form_error('any_info'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                
            </table>
            <hr>
            <div class='form-group'>
                <div class="col-md-3 control-label"></div>
                <div class="col-md-6">
                    <a href="<?php echo base_url('trs/transition_profile'); ?>" class="btn btn-default">  <i class="mdi mdi-close"></i> <span>Cancel</span></a>
                    <button  type="submit" id="process" class="btn btn-pink"> <i class="mdi mdi-send"></i> <span> Submit &nbsp; </span> </button>
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