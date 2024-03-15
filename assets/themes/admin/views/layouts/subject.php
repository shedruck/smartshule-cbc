<!DOCTYPE html>
<html lang="en">

    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <!--[if gt IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->        

        <title><?php echo $template['title']; ?></title>

        <?php echo theme_css('stylesheets.css'); ?>     
        <?php echo theme_css('jquery.dataTables.css'); ?>   
        <?php echo theme_css('tableTools.css'); ?>   
        <?php echo theme_css('dataTables.colVis.min.css'); ?>   
        <?php echo theme_css('select2/select2.css'); ?>
        <?php echo theme_css('themes/default.css'); ?>
        <?php echo theme_css('themes/default.date.css'); ?>
        <?php echo theme_css('custom.css'); ?>   
        <link href="<?php echo js_path('plugins/jeditable/bootstrap-editable.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo plugin_path('uploadify/uploadify.css'); ?>" type="text/css" />
        <!--[if lt IE 10]>
          <link href="css/ie.css" rel="stylesheet" type="text/css" />
      <![endif]-->        
        <link rel="stylesheet" type="text/css" href="<?php echo plugin_path('boxer/jquery.fs.boxer.css'); ?>" />
        <?php echo theme_js('plugins/jquery/jquery.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-migrate-1.1.1.min.js'); ?>

        <?php echo theme_js('plugins/jquery/globalize.js'); ?>
        <?php echo theme_js('plugins/other/excanvas.js'); ?>
        <script type="text/javascript" src="<?php echo plugin_path('boxer/jquery.fs.boxer.js'); ?>"></script>

        <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>
        <?php echo theme_js('plugins/bootstrap/bootstrap.min.js'); ?>            

        <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
        <?php echo theme_js('plugins/fancybox/jquery.fancybox.pack.js'); ?>

        <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>

        <?php echo theme_js('plugins/datatables/media/js/jquery.dataTables.min.js'); ?>    
        <?php echo theme_js('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>    
        <?php echo theme_js('plugins/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>    
        <?php echo theme_js('jquery.dataTables.delay.min.js'); ?>

        <?php echo theme_js('amct/amcharts.js'); ?>
        <?php echo theme_js('amct/pie.js'); ?>
        <?php echo theme_js('amct/serial.js'); ?>
        <?php echo theme_js('amct/exporting/amexport.js'); ?>
        <?php echo theme_js('amct/exporting/rgbcolor.js'); ?>
        <?php echo theme_js('amct/exporting/canvg.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.js'); ?>
        <?php echo theme_js('amct/exporting/filesaver.js'); ?>
        <?php echo theme_js('amct/exporting/jspdf.plugin.addimage.js'); ?>

        <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>
        <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>

        <?php echo theme_js('plugins/maskedinput/jquery.maskedinput-1.3.min.js'); ?>
        <?php echo theme_js('plugins/multiselect/jquery.multi-select.min.js'); ?>    

        <?php echo theme_js('plugins/validationEngine/languages/jquery.validationEngine-en.js'); ?>
        <?php echo theme_js('plugins/validationEngine/jquery.validationEngine.js'); ?>        

        <?php echo theme_js('plugins/animatedprogressbar/animated_progressbar.js'); ?>
        <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>

        <?php echo theme_js('plugins/isotope/jquery.isotope.min.js'); ?>    
        <?php echo theme_js('plugins/jnotes/jquery-notes_1.0.8_min.js'); ?>

        <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>  
        <script type="text/javascript" src="<?php echo plugin_path('uploadify/jquery.uploadify.min.js'); ?>"></script>
        <script type="text/javascript" >

                /* repeatString() returns a string which has been repeated a set number of times */
                function repeatString(str, num) {
                    out = '';
                    for (var i = 0; i < num; i++) {
                        out += str;
                    }
                    return out;
                }

                function dump(v, howDisplay, recursionLevel) {
                    howDisplay = (typeof howDisplay === 'undefined') ? "alert" : howDisplay;
                    recursionLevel = (typeof recursionLevel !== 'number') ? 0 : recursionLevel;


                    var vType = typeof v;
                    var out = vType;

                    switch (vType) {
                        case "number":
                            /* there is absolutely no way in JS to distinguish 2 from 2.0
                             so 'number' is the best that you can do. The following doesn't work:
                             var er = /^[0-9]+$/;
                             if (!isNaN(v) && v % 1 === 0 && er.test(3.0))
                             out = 'int';*/
                        case "boolean":
                            out += ": " + v;
                            break;
                        case "string":
                            out += "(" + v.length + '): "' + v + '"';
                            break;
                        case "object":
                            //check if null
                            if (v === null) {
                                out = "null";

                            }
                            else if (Object.prototype.toString.call(v) === '[object Array]') {
                                out = 'array(' + v.length + '): {\n';
                                for (var i = 0; i < v.length; i++) {
                                    out += repeatString('   ', recursionLevel) + "   [" + i + "]:  " +
                                            dump(v[i], "none", recursionLevel + 1) + "\n";
                                }
                                out += repeatString('   ', recursionLevel) + "}";
                            }
                            else { //if object    
                                sContents = "{\n";
                                cnt = 0;
                                for (var member in v) {
                                    sContents += repeatString('   ', recursionLevel) + "   " + member +
                                            ":  " + dump(v[member], "none", recursionLevel + 1) + "\n";
                                    cnt++;
                                }
                                sContents += repeatString('   ', recursionLevel) + "}";
                                out += "(" + cnt + "): " + sContents;
                            }
                            break;
                    }

                    if (howDisplay == 'body') {
                        var pre = document.createElement('pre');
                        pre.innerHTML = out;
                        document.body.appendChild(pre)
                    }
                    else if (howDisplay == 'alert') {
                        alert(out);
                    }

                    return out;
                }
        </script>
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('img/favicon.ico'); ?>" /> 

    </head>

    <body class="ssRed" 
    <?php
          if (
                      preg_match('/^(admin\/record_salaries\/slip)/i', $this->uri->uri_string()) ||
                      preg_match('/^(admin\/record_sales\/receipt)/i', $this->uri->uri_string()) ||
                      preg_match('/^(admin\/receipt\/receipt)/i', $this->uri->uri_string()) ||
                      preg_match('/^(admin\/fee_payment\/receipt)/i', $this->uri->uri_string()) ||
                      preg_match('/^(admin\/exams_management\/report)/i', $this->uri->uri_string()) ||
                      preg_match('/^(admin\/fee_payment\/statement)/i', $this->uri->uri_string())
          )
                  echo 'id="bodi"'; ?>> 
    
              <?php
                    if ($this->ion_auth->is_in_group($this->user->id, 3))
                    {
                            ?>	

                      <?php
              }
              else
              {
                      ?>
                      <?php echo $template['partials']['top']; ?>
                      <?php echo $template['partials'][$this->side]; ?>
              <?php } ?>
         <div class="row">

               <div class="col-md-12">
                    <div class="breadCrumb clearfix">    
                         <div>
                              <div style="display: inline-block; width:40%"> 
                                   <span > <?php echo anchor('/', 'Home'); ?> > </span>
                                   <?php
                                   if ($this->uri->segment(2))
                                   {
                                        ?>
                                        <span ><?php echo anchor('admin/' . $this->uri->segment(2), humanize($this->uri->segment(2))); ?> > </span>
                                   <?php } ?>
                                   <span ><?php echo $template['title']; ?></span>
                              </div>
                              <div style="display: inline-block; width:40%"><?php
                                   $user = $this->ion_auth->get_user();
                                   $gp = $this->ion_auth->get_users_groups($user->id)->row();
                                   ?><small>&nbsp;</small>
                                   <span class="label label-success"  ><?php echo ucwords($gp->name); ?></span>
                                   </span></div>
                         </div>

                    </div>
               </div>

          </div>
        <div class="content" >

            <div class="row">

                <div class="col-md-12">

                    <?php
                          if ($this->session->flashdata('warning'))
                          {
                                  ?>
                                  <div class="alert">
                                      <button type="button" class="close" data-dismiss="alert">                                    
                                          <i class="glyphicon glyphicon-remove"></i>                                </button>
                                      <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                                  </div>
                          <?php } ?> 
                    <?php
                          if ($this->session->flashdata('warning'))
                          {
                                  ?>
                                  <div class="alert">
                                      <button type="button" class="close" data-dismiss="alert">                                    
                                          <i class="glyphicon glyphicon-remove"></i>                                </button>
                                      <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                                  </div>
                          <?php } ?>
                    <?php
                          if ($this->session->flashdata('success'))
                          {
                                  ?>
                                  <div class="alert alert-success">
                                      <button type="button" class="close" data-dismiss="alert">  <i class="glyphicon glyphicon-remove"></i>  </button>
                                      <?php //echo $this->session->flashdata('success');  ?>
                                      <script>  notify('Success', ' <?php echo $this->session->flashdata('success'); ?>');</script>
                                  </div>
                          <?php } ?>
                    <?php
                          if ($this->session->flashdata('info'))
                          {
                                  ?>
                                  <div class="alert alert-info">
                                      <button type="button" class="close" data-dismiss="alert">                                    
                                          <i class="glyphicon glyphicon-remove"></i>                                </button>
                                      <?php echo $this->session->flashdata('info'); ?>
                                  </div>
                          <?php } ?>
                    <?php
                          if ($this->session->flashdata('message'))
                          {
                                  $message = $this->session->flashdata('message');
                                  $str = is_array($message) ? $message['text'] : $message;
                                  ?>
                                  <div class="alert alert-success">
                                      <button type="button" class="close" data-dismiss="alert">                                   
                                          <i class="glyphicon glyphicon-remove"></i>  
                                      </button>
                                      <script>  notify('Success', ' <?php echo $str; ?>');</script>
                                      <?php echo $str; ?>
                                  </div>
                          <?php } ?>
                    <?php
                          if ($this->session->flashdata('error'))
                          {
                                  ?>
                                  <div class="alert alert-error">
                                      <button type="button" class="close" data-dismiss="alert">                                    
                                          <i class="glyphicon glyphicon-remove"></i>      </button>
                                      <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                                  </div>
                          <?php } ?>

                    <div class="widget">
                        <div class="col-md-4">

                            <div class="widget">
                                <div class="profile clearfix">
                                    <div class="image">
                                    </div>                        
                                    <div class="info-s">
                                        <h2> <?php echo $this->get->name; ?></h2>
                                        <p><strong>Title:</strong>  <?php echo $this->get->name; ?></p>
                                        <p><strong>Shortname:</strong>  <?php echo $this->get->short_name; ?></p>
                                        <p><strong>Code:</strong>  <?php echo $this->get->code; ?></p>
                                        <div class="status">Active </div>
                                    </div>
                                    <div class="stats">
                                        <div class="item">
                                            <div class="title"><?php echo count($this->get->subs); ?></div>
                                            <div class="descr">Sub Units</div>                                
                                        </div>                            
                                        <div class="item">
                                            <div class="title">&nbsp;</div>
                                            <div class="descr">&nbsp;</div>                                
                                        </div>                                                        
                                        <div class="item">
                                            <div class="title">&nbsp;</div>
                                            <div class="descr">&nbsp;</div>                                
                                        </div>                            
                                        <div class="item pull-right">
                                            <div class="title"><?php echo count($this->get->classign); ?></div>
                                            <div class="descr">Classes</div>
                                        </div>
                                    </div>

                                </div>

                                <div class="block-fluid users">
                                                                                                                    
                                </div>   
                            </div>
                        </div>
                        <?php echo $template['body']; ?>
                    </div>

                </div>

            </div>

        </div>  

        <div id="fcAddEvent" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="fcAddEventLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="fcAddEventLabel">Add new event</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3">Title:</div>
                    <div class="col-md-9"><input type="text" id="fcAddEventTitle"/></div>
                </div>
            </div>
            <div class="modal-footer">            
                <button class="btn btn-primary" id="fcAddEventButton">Add</button>            
            </div>
        </div>
        <script type="text/javascript">  var flist = '<?php echo $this->list_size; ?>';</script>
        <?php echo theme_js('plugins.js'); ?>
        <?php echo theme_js('actions.js'); ?>
        <?php echo theme_js('include/jquery.ui.timepicker.js'); ?>
        <?php echo theme_js('ajaxfileupload.js'); ?>
        <?php echo theme_js('select2/select2.min.js'); ?>
        <?php echo theme_js('plugins/jeditable/bootstrap-editable.js'); ?>
        <?php echo theme_js('plugins/drag/jquery.dragtable.js'); ?>

        <script>
                var BASE_URL = '<?php echo base_url(); ?>';

                jQuery.extend({
                    handleError: function (s, xhr, status, e) {
                        // If a local callback was specified, fire it
                        if (s.error)
                            s.error(xhr, status, e);
                        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
                        else if (xhr.responseText)
                            console.log(xhr.responseText);
                    }
                });

                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true
                });

                $(document).ready(function () {
                    $(".boxer").boxer();
                });
        </script>

    </body>
</html>
