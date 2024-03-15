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
<?php echo theme_css('card.css'); ?>		

        
        <?php echo theme_css('font-awesome/css/font-awesome.min.css'); ?>
        <!--[if lt IE 10]>
           <link href="css/ie.css" rel="stylesheet" type="text/css" />
       <![endif]-->

<link href="https://fonts.googleapis.com/css?family=Ranga" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lobster|Ranga" rel="stylesheet">	   

        <?php echo theme_js('plugins/jquery/jquery.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>
        <?php echo theme_js('plugins/jquery/jquery-migrate-1.1.1.min.js'); ?>

        <?php echo theme_js('plugins/jquery/globalize.js'); ?>
        <?php echo theme_js('plugins/other/excanvas.js'); ?>

        <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>
        <?php echo theme_js('plugins/bootstrap/bootstrap.min.js'); ?>            

        <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
        <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>

        <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>
        <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>

        <?php echo theme_js('plugins/tagsinput/jquery.tagsinput.min.js'); ?>
        <?php echo theme_js('plugins/multiselect/jquery.multi-select.min.js'); ?>    

        <?php echo theme_js('plugins/animatedprogressbar/animated_progressbar.js'); ?>
        <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>
        <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>  

        <script src="<?php echo plugin_path('bootstrap.daterangepicker/moment.js'); ?>" ></script>
        <script src="<?php echo plugin_path('bootstrap.daterangepicker/daterangepicker.js'); ?>" ></script> 
        <script src="<?php echo plugin_path('bootstrap.datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script>	 

        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('img/favicon.ico'); ?>" /> 

    </head>

    <body  class="<?php echo $this->school->theme_color .' '. $this->school->background; ?>">    
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
                                   ?><small>Logged in as:</small>
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
                        <?php echo $template['body']; ?>

                    </div>  

                </div>

            </div>

        </div>  
        <script type="text/javascript">  var flist = '<?php echo $this->list_size; ?>';</script>
        <?php echo theme_js('plugins.js'); ?>
        <?php echo theme_js('actions.js'); ?>
        <?php echo theme_js('include/jquery.ui.timepicker.js'); ?>
        <?php echo theme_js('ajaxfileupload.js'); ?>
        <?php echo theme_js('select2/select2.min.js'); ?>
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
                format: "dd MM yyyy",
            });

            $(document).ready(function () {
                $("body").removeClass('smf');
                $('.timepicker').timepicker({
                    showPeriod: true,
                    showLeadingZero: true
                });

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
