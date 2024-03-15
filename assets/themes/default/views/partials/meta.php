<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php echo theme_css('bootstrap.min.css'); ?>
<?php echo theme_css('font-awesome.min.css'); ?>
<?php echo theme_css('select2/select2.css'); ?>
<?php echo theme_css('style.css'); ?>
<?php echo theme_css('responsive.css'); ?>
<?php echo theme_css('comm.css'); ?>
<?php echo theme_css('summernote.css'); ?>
<?php echo theme_css('custom.css'); ?>
<link href="<?php echo base_url('assets/themes/admin/css/jquery/jquery-ui-1.9.1.custom.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('assets/themes/trs/js/sweet-alert/sweetalert.min.css'); ?>" type="text/css" rel="stylesheet" />
<!-- Favicon and Apple Icons -->
<link rel="icon" type="image/png" href="<?php echo image_path('icons/icon.html'); ?>">
<link rel="icon" type="image/png" href="<?php echo image_path('icons/apple-glyphicon glyphicon-57x57.html'); ?>">
<link rel="icon" type="image/png" href="<?php echo image_path('icons/apple-glyphicon glyphicon-72x72.html'); ?>">
<script>
        var BASE_URL = '<?php echo base_url(); ?>';
</script>
<!--- jQuery -->
<script>window.jQuery || document.write('<script src="<?php echo js_path('jquery-1.11.0.min.js'); ?>"><\/script>')</script>
<script src="<?php echo base_url('assets/themes/admin/js/plugins/jquery/jquery-ui-1.10.1.custom.min.js'); ?>"></script>
<?php echo theme_js('summernote.js'); ?>
<?php echo theme_js('select2/select2.min.js'); ?>
<!--[if lt IE 9]>
<?php echo theme_js('html5shiv.js'); ?>
<?php echo theme_js('respond.min.js'); ?>
 <![endif]-->
<style id="custom-style">
    .ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year 
    {
        width: 35%;  
    }
</style>
