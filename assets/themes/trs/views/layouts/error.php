<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Smartshule"> 
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <title>Smartshule - <?php echo $template['title']; ?></title> 
        <!-- css -->
        <?php echo theme_css('fullcalendar.min.css'); ?>
        <?php echo theme_css('bootstrap.min.css'); ?>
        <?php echo theme_css('core.css'); ?>
        <?php echo theme_css('components.css'); ?>
        <?php echo theme_css('icons.css'); ?>
        <?php echo theme_css('pages.css'); ?>
        <?php echo theme_css('menu.css'); ?>
        <?php echo theme_css('responsive.css'); ?>

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <?php echo theme_js('modernizr.min.js'); ?>
        <script> var BASE_URL = '<?php echo base_url(); ?>';</script>
        <?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
        <style>.card-box { padding: 10px;} .card-box{min-height: 430px;}</style>
    </head>
    <body>
        <!-- Navigation Bar-->
      
        <!-- End Navigation Bar-->
        <div class="wrapper">
            <div class="clearfix m-b-10"></div>
            <div class="container">

              
                
                <!-- end page title end breadcrumb -->              
                <?php echo $template['body']; ?>

                <!-- Footer -->
                <footer class="footer text-right">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                &COPY; Smartshule <?php echo date('Y'); ?>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- End Footer -->

            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->
        <!-- jQuery  -->
        <?php echo theme_js('jquery.min.js'); ?>
        <?php echo theme_js('bootstrap.min.js'); ?>
        <?php echo theme_js('detect.js'); ?>
        <?php echo theme_js('fastclick.js'); ?>
        <?php echo theme_js('jquery.blockUI.js'); ?>
        <?php echo theme_js('waves.js'); ?>
        <?php echo theme_js('jquery.slimscroll.js'); ?>
        <?php echo theme_js('jquery.scrollTo.min.js'); ?>
        <?php echo theme_js('moment/moment.js'); ?>
        <?php echo theme_js('fullcalendar.min.js'); ?>
        <?php echo theme_js('jquery.fullcalendar.js'); ?>
        <?php echo theme_js('jquery.app.js'); ?>

    </body>
</html>