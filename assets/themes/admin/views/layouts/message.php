<!DOCTYPE html>
<html lang="en">

     <head>        
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

          <!--[if gt IE 8]>
              <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <![endif]-->        

          <title><?php echo $template['title']; ?></title>
           <link href="<?php echo base_url('assets/themes/default/css/tok-style.css'); ?>" type="text/css" rel="stylesheet" />     
          <?php echo theme_css('stylesheets.css'); ?>     
          <?php echo theme_css('custom.css'); ?>   
          <?php echo theme_css('jquery.dataTables.css'); ?>   
          <?php echo theme_css('tableTools.css'); ?>   
          <?php echo theme_css('dataTables.colVis.min.css'); ?>   
          
          <!--[if lt IE 10]>
              <link href="css/ie.css" rel="stylesheet" type="text/css" />
          <![endif]-->        

          <?php echo theme_js('plugins/jquery/jquery.min.js'); ?>
          <?php echo theme_js('plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>
          <?php echo theme_js('plugins/jquery/jquery-migrate-1.2.1.min.js'); ?>

          <?php echo theme_js('plugins/jquery/globalize.js'); ?>
          <?php echo theme_js('plugins/other/excanvas.js'); ?>

          <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>

          <?php echo theme_js('plugins/bootstrap/bootstrap.min.js'); ?>            

          <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
          <?php echo theme_js('plugins/fancybox/jquery.fancybox.pack.js'); ?>

          <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>

          <?php echo theme_js('plugins/datatables/media/js/jquery.dataTables.min.js'); ?>    
          <?php echo theme_js('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>    
          <?php echo theme_js('plugins/datatables/extensions/ColVis/js/dataTables.colVis.min.js'); ?>    
          <?php echo theme_js('jquery.dataTables.delay.min.js'); ?>    

          <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>

          <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>
          <?php echo theme_js('plugins/select/select2.min.js'); ?>

          <?php echo theme_js('plugins/tagsinput/jquery.tagsinput.min.js'); ?>
          <?php echo theme_js('plugins/maskedinput/jquery.maskedinput-1.3.min.js'); ?>
          <?php echo theme_js('plugins/multiselect/jquery.multi-select.min.js'); ?>    

          <?php echo theme_js('plugins/stepywizard/jquery.stepy.js'); ?>

          <?php echo theme_js('plugins/animatedprogressbar/animated_progressbar.js'); ?>
          <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>

          <?php echo theme_js('plugins/cleditor/jquery.cleditor.js'); ?>

          <?php echo theme_js('plugins/shbrush/XRegExp.js'); ?>
          <?php echo theme_js('plugins/shbrush/shCore.js'); ?>
          <?php echo theme_js('plugins/shbrush/shBrushXml.js'); ?>
          <?php echo theme_js('plugins/shbrush/shBrushJScript.js'); ?>
          <?php echo theme_js('plugins/shbrush/shBrushCss.js'); ?>    

          <?php echo theme_js('plugins/slidernav/slidernav-min.js'); ?>     
          <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>   	 

          <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('img/favicon.ico'); ?>" /> 

          <style>
               .caption.purple {
                    background: #553285;
                    border: 1px solid #36175E;
                    -moz-box-shadow: inset 0px 1px 2px #7B52AB, 0px 1px 3px rgba(0,0,0,0.15);
                    -webkit-box-shadow: inset 0px 1px 2px #7B52AB, 0px 1px 3px rgba(0,0,0,0.15);
                    box-shadow: inset 0px 1px 2px #7B52AB, 0px 1px 3px rgba(0,0,0,0.15);
               }
          </style>

     </head>

     <body class="ssRed">    

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
                                   <?php echo $this->session->flashdata('success'); ?>
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
                                        <i class="glyphicon glyphicon-remove"></i>                                </button>
                                   <?php echo $str; //$this->session->flashdata('message');   ?>
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

          <script>
               var BASE_URL = '<?php echo base_url(); ?>';
               var admin_side = 1;
          </script>
          <script type="text/javascript">
               var flist = '<?php echo $this->list_size; ?>';
                         </script>
          <?php echo theme_js('plugins.js'); ?>
          
          <?php echo theme_js('actions.js'); ?>
          <?php echo theme_js('include/jquery.ui.timepicker.js'); ?>
          
          <script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/talk/jquery.nicescroll.min.js'); ?>"></script>
          <script type="text/javascript" src="<?php echo base_url('assets/themes/default/js/talk/jquery.messages.js'); ?>"></script>
          <script>

               $(document).ready(function()
               {
                    $(".datepicker").datepicker({
                         format: "dd MM yyyy",
                    });
               });

          </script>

     </body>
</html>
