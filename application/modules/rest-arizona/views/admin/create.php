<section>
    <div class="panel panel-success" data-sortable-id="ui-widget-16"> 
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <div class="btn-group">
                    <?php echo anchor('admin/adverts/create', '<span> Add Adverts</span>', 'class="btn btn-primary" '); ?> 
                    <?php echo anchor('admin/adverts', '<span> All Adverts' . '</span>', 'class="btn btn-warning"'); ?>
                </div>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default " data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title"> <?php echo ($updType == 'edit') ? 'Edit ' : 'Add '; ?> Adverts</h4>
        </div>
        <div class="panel-body" >    
            <div class='clearfix'><br/></div>
            <?php
            $attributes = array('class' => 'form-horizontal', 'id' => '');
            echo form_open_multipart(current_url(), $attributes);
            ?>
            <div class='form-group'>
                <label class=' col-sm-3 control-label' for='start'>Start <span class='required'>*</span></label>
                <div class="col-sm-5 ">
                    <?php
                    if ($result->start)
                    {
                            if ((!preg_match('/[^\d]/', $result->start)))//if it contains digits only
                            {
                                    $dt = date('d M Y', $result->start);
                            }
                            else
                            {
                                    $dt = $result->start;
                            }
                    }
                    ?>
                    <input type='text' name='from' maxlength='' class='form-control datepicker' value="<?php echo set_value('from', $dt); ?>"  />
                    <i style="color:red"><?php echo form_error('from'); ?></i>
                    <span class="icon-calendar"> </span>
                </div>
            </div>
            <div class='form-group'>
                <label class=' col-sm-3 control-label' for='end'>End <span class='required'>*</span></label>
                <div class="col-sm-5 ">
                    <?php
                    if ($result->end)
                    {
                            if ((!preg_match('/[^\d]/', $result->end)))//if it contains digits only
                            {
                                    $dit = date('d M Y', $result->end);
                            }
                            else
                            {
                                    $dit = $result->end;
                            }
                    }
                    ?>
                    <input type='text' name='end' maxlength='' class='form-control datepicker' value="<?php echo set_value('end', $dit); ?>"  />
                    <i style="color:red"><?php echo form_error('end'); ?></i>

                </div>
            </div>

            <div class='form-group'>
                <label class=' col-sm-3 control-label' for='brand'>Brand <span class='required'>*</span></label>
                <div class="col-sm-5">
                    <?php
                    echo form_dropdown('brand', array('' => '') + $brands, (isset($result->brand)) ? $result->brand : '', 'data-placeholder="Select" class="form-control default-select2" ');
                    ?>		
                    <i style="color:red"><?php echo form_error('brand'); ?></i>
                </div>
            </div>

            <div class='form-group'>
                <label class=' col-sm-3 control-label' for='brand_id'>Brand Id <span class='required'>*</span></label>
                <div class="col-sm-5">
                    <?php echo form_input('brand_id', $result->brand_id, ' class="form-control" '); ?>
                    <i style="color:red"><?php echo form_error('brand_id'); ?></i>
                </div>
            </div>

            <div class='form-group'>
                <label class=' col-sm-3 control-label' for='type'>Type </label>
                <div class="col-sm-5">
                    <?php
                    echo form_dropdown('type', array('' => '') + $types, (isset($result->type)) ? $result->type : '', ' id="typlist" data-placeholder="Select" class="form-control" ');
                    ?>		
                    <i style="color:red"><?php echo form_error('type'); ?></i>
                </div>
            </div>

            <div class='form-group'>
                <label class=' col-sm-3 control-label' for='billboard'>Billboard <span class='required'>*</span></label>
                <div class="col-sm-5">
                    <?php
                    echo form_dropdown('billboard', array('' => '') + $billboards, (isset($result->billboard)) ? $result->billboard : '', 'id="billist" data-placeholder="Select" class="form-control" ');
                    ?>		
                    <i style="color:red"><?php echo form_error('billboard'); ?></i>
                </div>
            </div>

            <div class='form-group'>
                <label class=' col-sm-3 control-label'><?php echo lang(($updType == 'edit') ? "web_file_edit" : "web_file_create" ) ?> </label>
                <div class="col-sm-9">
                    <div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    <div id="container">
                        <a id="picker" class="btn btn-round btn-default" href="javascript:;">Day Image </a> 
                    </div>
                    <pre id="console" style="width: 67%; margin: 0; padding: 0; border: 0; color:red;"></pre>
                </div>
            </div> 
            <div class='form-group'>
                <label class=' col-sm-3 control-label' ><?php echo lang(($updType == 'edit') ? "web_file_edit" : "web_file_create" ) ?> </label>
                <div class="col-sm-9">
                    <div id="lister">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    <div id="container">
                        <a id="night" class="btn btn-round btn-default" href="javascript:;">Night Image </a> 
                    </div>
                    <pre id="console" style="width: 67%; margin: 0; padding: 0; border: 0; color:red;"></pre>
                </div>
            </div> 

            <div class='form-group'>
                <label class=' col-sm-3 control-label' for='description'>Description </label><div class="col-sm-5">
                    <textarea id="description"  class="autosize-transition ckeditor form-control "  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
                    <i style="color:red"><?php echo form_error('description'); ?></i>
                </div>
            </div>

            <div class='form-group'><label class="col-sm-3 control-label"></label><div class="col-sm-5"> 
                    <?php echo anchor('admin/adverts', 'Cancel', 'class="btn btn-default btn-shadow"'); ?>
                    <?php echo form_submit('submit', ($updType == 'edit') ? 'Update' : 'Submit', (($updType == 'create') ? "id='submit' class=' btn btn-info''" : "id='submit' class='btn btn-info'")); ?>
                </div></div>
            <input type="hidden" id="pids" title = "" name="pids" value="0"/>
            <input type="hidden" id="nids" title = "" name="nids" value="0"/>
            <?php echo form_close(); ?>
            <div class="clearfix"></div>
        </div>
    </div> 
</section>
<script type="text/javascript">
        $(function ()
        {
            $("#typlist,#billist").chosen();
            $("#typlist").on('change', function (e)
            {
                var sel = $("#typlist").val();
                var href = "<?php echo base_url('admin/adverts/filter'); ?>" + '/' + sel;
                $.ajax({
                    type: "POST",
                    url: href,
                    data: {sel: sel},
                    success: function (data)
                    {
                        var obj = $.parseJSON(data);
                        var $items = [];

                        $.each(obj, function (index, item)
                        {
                            $items.push($("<option/>", {value: item.id, text: item.text}));
                        });
                        $("#billist").empty().append($items).trigger("chosen:updated");
                    }
                });

            });
        });

        $(document).ready(function ()
        {
            var base_url = '<?php echo base_url(); ?>';
            var str = '';
            var uploader = new plupload.Uploader({
                runtimes: 'html5,flash,silverlight,html4',
                browse_button: 'picker',
                container: document.getElementById('container'),
                url: base_url + 'admin/adverts/do_upload/',
                flash_swf_url: '<?php echo js_path('plupload/Moxie.swf'); ?>',
                silverlight_xap_url: '<?php echo js_path('plupload/Moxie.xap'); ?>',
                filters: {
                    max_file_size: '10mb',
                    mime_types: [{title: "Clips", extensions: "jpg,png"}]
                },
                init: {
                    PostInit: function ()
                    {
                        document.getElementById('filelist').innerHTML = '';
                        document.getElementById('console').innerHTML = '';
                    },
                    FilesAdded: function (up, files)
                    {
                        plupload.each(files, function (file)
                        {
                            document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                        });
                        uploader.start();
                    },
                    UploadProgress: function (up, file)
                    {
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
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
                            str = str + resp.precord + '|';
                            $("#pids").val(str);
                        }
                        console.log(str);
                    },
                    Error: function (up, err)
                    {
                        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                    }
                }
            });
            uploader.init();
            /*Night*/
            var nitstr = '';
            var niteup = new plupload.Uploader({
                runtimes: 'html5,flash,silverlight,html4',
                browse_button: 'night',
                container: document.getElementById('container'),
                url: base_url + 'admin/adverts/do_upload/',
                flash_swf_url: '<?php echo js_path('plupload/Moxie.swf'); ?>',
                silverlight_xap_url: '<?php echo js_path('plupload/Moxie.xap'); ?>',
                filters: {
                    max_file_size: '10mb',
                    mime_types: [{title: "Clips", extensions: "jpg,png"}]
                },
                init: {
                    PostInit: function ()
                    {
                        document.getElementById('lister').innerHTML = '';
                        document.getElementById('console').innerHTML = '';
                    },
                    FilesAdded: function (up, files)
                    {
                        plupload.each(files, function (file)
                        {
                            document.getElementById('lister').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                        });
                        niteup.start();
                    },
                    UploadProgress: function (up, file)
                    {
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
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
                            nitstr = nitstr + resp.precord + '|';
                            $("#nids").val(nitstr);
                        }
                        console.log(nitstr);
                    },
                    Error: function (up, err)
                    {
                        document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
                    }
                }
            });
            niteup.init();
        });

</script>