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
        <?php echo theme_css('select2/select2.css'); ?>
        <?php echo theme_css('themes/default.css'); ?>
        <?php echo theme_css('custom.css'); ?>   
        <?php echo theme_css('fancybox/global.css'); ?>   
        <?php echo theme_css('fancybox/jquery.fancybox.css'); ?>   

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

        <?php echo theme_js('plugins/other/jquery.mousewheel.min.js'); ?>
        <?php echo theme_js('plugins/bootstrap/bootstrap.min.js'); ?>            
        <?php echo theme_js('plugins/cookies/jquery.cookies.2.2.0.min.js'); ?>
        <?php echo theme_js('plugins/pnotify/jquery.pnotify.min.js'); ?>

        <?php echo theme_js('plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'); ?>
        <?php echo theme_js('plugins/uniform/jquery.uniform.min.js'); ?>

        <?php echo theme_js('plugins/animatedprogressbar/animated_progressbar.js'); ?>
        <?php echo theme_js('plugins/hoverintent/jquery.hoverIntent.minified.js'); ?>
        <?php echo theme_js('plugins/scrollup/jquery.scrollUp.min.js'); ?>  
        <script type="text/javascript" src="<?php echo plugin_path('uploadify/jquery.uploadify.min.js'); ?>"></script>
        <script type="text/javascript" >
                var skul = '<?php echo $this->school->school; ?> ';
                var logo = '<?php echo $this->img->rimg(base_url('uploads/files/' . $this->school->document), array('width' => 75, 'height' => 60, 'alt' => 'alt text')); ?> ';
                var tm = '<?php echo date("l F d, Y"); ?> ';
                var spath = '<?php echo base_url(); ?>';
        </script>

        <?php echo theme_js('plugins/fancybox/jquery.fancybox.pack.js'); ?>  
        <?php echo theme_js('plugins/fancybox/fancy-custom.js'); ?>  
 
        <link rel="shortcut icon" type="image/ico" href="<?php echo image_path('img/favicon.ico'); ?>" /> 

    </head>

    <body class="ssRed 
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
    ?>"> 

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
                                   ?><small>Logged in as:</small>
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
                                      <?php //echo $this->session->flashdata('success');    ?>
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
                                    <div class="item">
                                        <?php echo theme_image('examples/users/bull.png', array('class' => "img-polaroid")); ?>
                                        <a href="<?php echo base_url('admin/subjects/view/' . $this->get->id); ?>">Overview</a>
                                        <div class="caption">&nbsp;</div>
                                    </div>                                                                                  
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
        <?php //echo theme_js('plugins.js'); ?>
        <?php echo theme_js('actions.js'); ?>
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
                    changeMonth: true,
                    changeYear: true
                });

                $(document).ready(function () {

                });
        </script>

    </body>
</html>
