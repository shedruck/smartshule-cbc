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
        <?php echo theme_css('custom.css'); ?>   
        <?php echo theme_css('jquery.dataTables.css'); ?>   
        <?php echo theme_css('tableTools.css'); ?>   
        <?php echo theme_css('dataTables.colVis.min.css'); ?>   
        <?php echo theme_css('select2/select2.css'); ?>
        <?php echo theme_css('font-awesome/css/font-awesome.min.css'); ?>
        <!--[if lt IE 10]>
           <link href="css/ie.css" rel="stylesheet" type="text/css" />
       <![endif]-->        

        <?php echo theme_js('plugins/jquery/jquery.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-migrate-1.1.1.min.js'); ?>

        <?php echo theme_js('plugins/jquery/globalize.js'); ?>
        <?php echo theme_js('plugins/other/excanvas.js'); ?>

        <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>
        <?php echo theme_js('plugins/bootstrap/bootstrap.min.js'); ?>            

        <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
        <?php echo theme_js('plugins/fancybox/jquery.fancybox.pack.js'); ?>

        <?php echo theme_js('plugins/knob/jquery.knob.js'); ?>
        <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>

        <?php echo theme_js('plugins/datatables/media/js/jquery.dataTables.min.js'); ?>    
        <?php echo theme_js('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>    
        <?php echo theme_js('plugins/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>    
        <?php echo theme_js('jquery.dataTables.delay.min.js'); ?>

        <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>
        <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>

        <?php echo theme_js('plugins/tagsinput/jquery.tagsinput.min.js'); ?>
        <?php echo theme_js('plugins/maskedinput/jquery.maskedinput-1.3.min.js'); ?>
        <?php echo theme_js('plugins/multiselect/jquery.multi-select.min.js'); ?>    

        <?php echo theme_js('plugins/validationEngine/languages/jquery.validationEngine-en.js'); ?>
        <?php echo theme_js('plugins/validationEngine/jquery.validationEngine.js'); ?>        

        <?php echo theme_js('plugins/animatedprogressbar/animated_progressbar.js'); ?>
        <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>

        <?php echo theme_js('plugins/cleditor/jquery.cleditor.js'); ?>
        <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>  
        <?php echo theme_js('plugins/SmartWizard/jquery.smartWizard.js'); ?>  

        <script src="<?php echo plugin_path('bootstrap.daterangepicker/moment.js'); ?>" ></script>
        <script src="<?php echo plugin_path('bootstrap.daterangepicker/daterangepicker.js'); ?>" ></script> 
        <script src="<?php echo plugin_path('bootstrap.datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script>	 

        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('img/favicon.ico'); ?>" /> 

    </head>

    <body  class="ssRed">    
        <?php echo $template['partials']['top']; ?>
        <?php echo $template['partials'][$this->side]; ?>
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
        <div class="content">

            <div class="row">

                <div class="col-md-12">

                    <?php
                    if ($this->session->flashdata('warning'))
                    {
                        ?>
                        <div class="alert">
                            <button type="button" class="close" data-dismiss="alert">                                    
                                <i class="glyphicon glyphicon-remove"></i>                                
                            </button>
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
                            <?php //echo $this->session->flashdata('success'); ?>
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
                            <?php echo $str; //$this->session->flashdata('message'); ?>
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

                        <form action="#" role="form" class="smart-wizard form-horizontal" id="form"></form>
                            <div id="wanwizz" class="swMain">
                                <ul>
                                    <li>
                                        <a href="#step-1"  class="done" id="step1">
                                            <div class="stepNumber">  1 </div>
                                            <span class="stepDesc"> School Profile </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-2"  class="done" id="step2">
                                            <div class="stepNumber">  2 </div>
                                            <span class="stepDesc"> Class Teachers </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-3"  id="step3">
                                            <div class="stepNumber">   3 </div>
                                            <span class="stepDesc"> Classes </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-4"  id="step4">
                                            <div class="stepNumber">  4  </div>
                                            <span class="stepDesc">Subjects </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-5" id="step5">
                                            <div class="stepNumber"> 5 </div>
                                            <span class="stepDesc">Houses </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#step-6" id="step6">
                                            <div class="stepNumber"> 6 </div>
                                            <span class="stepDesc">Finish </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="progress progress-striped active progress-sm">
                                    <div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-success step-bar">
                                        <!--<span class="sr-only"> 0% Complete (success)</span>-->
                                    </div>
                                </div>
                                <?php echo $template['body']; ?>
                            </div>   
<!--                        </form>-->

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
        <?php echo theme_js('custom.js'); ?>
        <?php echo theme_js('include/jquery.ui.timepicker.js'); ?>
        <?php echo theme_js('ajaxfileupload.js'); ?>
        <?php echo theme_js('select2/select2.min.js'); ?>
        <?php echo theme_js('plugins/drag/jquery.dragtable.js'); ?>
        <script>
            var BASE_URL = '<?php echo base_url(); ?>';

            jQuery.extend({
                handleError: function(s, xhr, status, e) {
                    // If a local callback was specified, fire it
                    if (s.error)
                        s.error(xhr, status, e);
                    // If we have some XML response text (e.g. from an AJAX call) then log it in the console
                    else if (xhr.responseText)
                        console.log(xhr.responseText);
                }
            });

            $(".datepicker").datepicker({
                format: "dd MM yyyy",
            });

            $(document).ready(function() {

                $('.timepicker').timepicker({
                    showPeriod: true,
                    showLeadingZero: true
                });
                var val = $('#nexti').attr('title');
                var numberOfSteps = $('.swMain > ul > li').length;
                var valueNow = Math.floor(100 / numberOfSteps * val);
                $('.step-bar').css('width', valueNow + '%');
                for (i = 0; i <= val; i++)
                {
                    $('#step' + i).addClass('done');
                    $('#step' + val).removeClass('done').addClass('selected');
                }

            });

            //DatePicker
            $(".datetimepicker").datetimepicker({
                format: "dd MM yyyy - hh:ii",
                autoclose: true,
                todayBtn: true,
                startDate: "2013-02-14 10:00",
                minuteStep: 10,
            });

        </script>


    </body>
</html>
