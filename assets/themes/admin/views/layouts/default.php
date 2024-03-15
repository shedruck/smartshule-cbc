<!DOCTYPE html>
<html lang="en">
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <!--[if gt IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <![endif]-->
        <title><?php echo $template['title']; ?></title>
        <link href="<?php echo base_url('assets/themes/default/css/comm.css'); ?>" type="text/css" rel="stylesheet" />
        <?php echo theme_css('sett.css'); ?>
        <?php echo theme_css('jquery.dataTables.css'); ?>
        <?php echo theme_css('tableTools.css'); ?>   
        <?php echo theme_css('dataTables.colVis.min.css'); ?>
        <?php echo theme_css('select2/select2.css'); ?>
        <?php echo theme_css('select2/multiselect.css'); ?>
        <?php echo theme_css('themes/default.css'); ?>
        <?php echo theme_css('themes/default.date.css'); ?>
        <?php echo theme_css('stylesheets.css'); ?>
        <?php echo theme_css('custom.css'); ?>
        <?php echo theme_css('output.css'); ?>
        <link href="<?php echo js_path('plugins/jeditable/bootstrap-editable.css'); ?>" rel="stylesheet">
        
        <!--[if lt IE 10]>
          <link href="css/ie.css" rel="stylesheet" type="text/css" />
      <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo plugin_path('boxer/jquery.fs.boxer.css'); ?>" />
        <script> var BASE_URL = '<?php echo base_url(); ?>';</script>
        
        <script type="text/javascript" src="<?php echo plugin_path('libs.js'); ?>"></script>
        <?php echo theme_js('plugins/jquery/jquery.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-migrate-1.1.1.min.js'); ?>
        <?php echo theme_js('plugins/jquery/globalize.js'); ?>
        <?php echo theme_js('plugins/other/excanvas.js'); ?>
        <script type="text/javascript" src="<?php echo plugin_path('boxer/jquery.fs.boxer.js'); ?>"></script>
        <?php echo theme_js('plugins/switch/js/switch.js'); ?> 
        <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>
        <?php echo theme_js('plugins/bootstrap/bootstrap.min.js'); ?>            
        <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
        <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>
        <?php echo theme_js('plugins/fullcalendar/fullcalendar.min.js'); ?>  
		
        <?php echo theme_js('plugins/datatables/jquery.dataTables.min.js'); ?>
        <?php echo theme_js('plugins/datatables/dataTables.buttons.min.js'); ?>
        <?php echo theme_js('plugins/datatables/jszip.min.js'); ?>
        <?php echo theme_js('plugins/datatables/buttons.html5.min.js'); ?>
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

        <?php echo theme_js('plugins/underscore/underscore-min.js'); ?>
        <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>
        <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>

        <?php echo theme_js('plugins/maskedinput/jquery.maskedinput-1.3.min.js'); ?>
        <?php echo theme_js('plugins/multiselect/jquery.multi-select.min.js'); ?>    

        <?php echo theme_js('plugins/validationEngine/languages/jquery.validationEngine-en.js'); ?>
        <?php echo theme_js('plugins/validationEngine/jquery.validationEngine.js'); ?>        
        <?php echo theme_js('plugins/stepywizard/jquery.stepy.js'); ?>

        <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>  
        <?php echo theme_js('plugins/SmartWizard/jquery.smartWizard.js'); ?>  
        <script src="<?php echo plugin_path('bootstrap.daterangepicker/moment.js'); ?>" ></script>
        <script src="<?php echo plugin_path('bootstrap.daterangepicker/daterangepicker.js'); ?>" ></script> 
        <script src="<?php echo plugin_path('bootstrap.datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script>	 
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('favicon.ico'); ?>" />

        <!-- Igcse Customizations -->
        <link href="<?php echo base_url('assets/themes/admin/plugins/font-awesome/css/font-awesome.min.css'); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/themes/admin/plugins/apexcharts/dist/apexcharts.css'); ?>" type="text/css" rel="stylesheet" />
    </head>
    <?php
    $ccls = 'ssRed';
    if ($this->ion_auth->is_in_group($this->user->id, 3))
    {
            $ccls = 'ssGreen';
    }
    ?>
	

    <body class="<?php echo $this->school->theme_color . ' ' . $this->school->background; ?>" 
    <?php
    if (
                 preg_match('/^(admin\/record_salaries\/slip)/i', $this->uri->uri_string()) ||
                 preg_match('/^(admin\/record_sales\/receipt)/i', $this->uri->uri_string()) ||
                 preg_match('/^(admin\/receipt\/receipt)/i', $this->uri->uri_string()) ||
                 preg_match('/^(admin\/fee_payment\/receipt)/i', $this->uri->uri_string()) ||
                 preg_match('/^(admin\/exams_management\/report)/i', $this->uri->uri_string()) ||
                 preg_match('/^(admin\/fee_payment\/statement)/i', $this->uri->uri_string())
    )
            echo 'id="bodi"';
    ?>>  
              <?php echo $template['partials']['top']; ?>
              <?php echo $template['partials'][$this->side]; ?>
        <div class="row hidden-print">
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
                            <span class="label label-success"><?php echo ucwords($gp->name); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($this->session->flashdata('warning'))
                    {
                            ?>
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert">                                    
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>
                                <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('success'))
                    {
                            ?>
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">  <i class="glyphicon glyphicon-remove"></i>  </button>
                                <?php //echo $this->session->flashdata('success');   ?>
                                <script>   $(document).ready(function ()
                                                {
                                                    notify('Success', " <?php echo $this->session->flashdata('success'); ?>");
                                                });</script>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('info'))
                    {
                            ?>
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">                                    
                                    <i class="glyphicon glyphicon-remove"></i></button>
                                <?php echo $this->session->flashdata('info'); ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('message'))
                    {
                            $message = $this->session->flashdata('message');
                            $str = is_array($message) ? $message['text'] : $message;
                            $type = is_array($message) ? $message['type'] : 'info';
                            $title = ucfirst($type);
                            ?>
                            <div class="alert alert-<?php echo $type; ?>">
                                <button type="button" class="close" data-dismiss="alert">                                   
                                    <i class="glyphicon glyphicon-remove"></i>  
                                </button>
                                <script> $(document).ready(function ()
                                                {
                                                    notify('<?php echo $title; ?>', " <?php echo $str; ?>");
                                                });</script>
                                <?php echo $str; ?>
                            </div>
                    <?php } ?>
                    <?php
                    if ($this->session->flashdata('error'))
                    {
                            $message = $this->session->flashdata('error');
                            $str = is_array($message) ? $message['text'] : $message;
                            $type = is_array($message) ? $message['type'] : 'error';
                            $title = ucfirst($type);
                            ?>
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">                                    
                                    <i class="glyphicon glyphicon-remove"></i></button>
                                <strong>Error!</strong>  <?php echo $str; ?>
                            </div>
                    <?php } ?>
                    <div class="widget">
                        <?php echo $template['body']; ?>
                    </div>
                </div>
            </div>
        </div>  

        <div id="fcAddEvent" class="modal hide fade hidden-print" tabindex="-1" role="dialog" aria-labelledby="fcAddEventLabel" aria-hidden="true">
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
        <?php echo theme_js('plugins/animatedprogressbar/animated_progressbar.js'); ?>
        <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>
        <?php echo theme_js('plugins/cleditor/jquery.cleditor.js'); ?>
        <?php echo theme_js('plugins/slidernav/slidernav-min.js'); ?>    
        <?php echo theme_js('plugins/isotope/jquery.isotope.min.js'); ?>    
        <?php echo theme_js('plugins/ibutton/jquery.ibutton.min.js'); ?>
        <?php echo theme_js('plugins.js'); ?>
        <?php echo theme_js('sweet-alert.min.js'); ?>
        <?php echo theme_js('actions.js'); ?>
        <?php echo theme_js('include/jquery.ui.timepicker.js'); ?>
        <?php echo theme_js('ajaxfileupload.js'); ?>
        <?php echo theme_js('select2/select2.min.js'); ?>
        <?php echo theme_js('plugins/jeditable/bootstrap-editable.js'); ?>
        <?php echo theme_js('plugins/raphael-min.js'); ?>
        <?php echo theme_js('plugins/morris.min.js'); ?>
        <?php echo theme_js('ng/lib-ng.js'); ?> 
        <?php echo theme_js('ng/ngsc.js'); ?>
		
        <!-- Igcse Customizations -->
        <script src="<?php echo base_url('assets/themes/admin/plugins/apexcharts/dist/apexcharts.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/themes/admin/plugins/qrcodejs/qrcode.min.js'); ?>"></script>

        <script>
                        $(document).ready(function ()
                        {
                            angular.bootstrap(document, ["Calc"]);
                            $(".boxer").boxer();
                            $('.timepicker').timepicker({
                                showPeriod: true,
                                showLeadingZero: true
                            });
                        });
                        jQuery.extend({
                            handleError: function (s, xhr, status, e)
                            {
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
                        $(".datedob").datepicker({
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "-30:-3"
                        });

                        //DatePicker
                        $(".datetimepicker").datetimepicker({
                            format: "dd MM yyyy - hh:ii",
                            autoclose: true,
                            todayBtn: true,
                            startDate: "<?php echo date('Y-m-d H:i'); ?>",
                            minuteStep: 10
                        });
                        $(document.body).delegate('select.ui-datepicker-year', 'mousedown', function ()
                        {
                            (function (sel)
                            {
                                var el = $(sel);
                                var ops = $(el).children().get();
                                if (ops.length > 0 && $(ops).first().val() < $(ops).last().val())
                                {
                                    $(el).html(ops.reverse());
                                }
                            })(this);
                        });
        </script>
    </body>
</html>