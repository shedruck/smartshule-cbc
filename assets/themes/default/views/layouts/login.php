<!DOCTYPE html>
<html lang="en">

<head>
	

		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Favicon -->
		
		<link rel="icon" type="image/png" href="<?php echo image_path('icons/icon.html'); ?>">
	
		
		<!-- Bootstrap CSS -->
		<?php echo theme_css('bootstrap.min.css'); ?>
		
		<!-- Linearicon Font -->
		<?php echo theme_css('lnr-icon.css'); ?>
				
		<!-- Fontawesome CSS -->
        <?php echo theme_css('font-awesome.min.css'); ?>
		
		
		<!-- Custom CSS -->
		<?php echo theme_css('style.css'); ?>
		
	  <title><?php echo $template['title']; ?></title>
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
	</head>
	<body class="<?php echo $this->school->theme_color . ' ' . $this->school->background; ?>">
			
			<!-- Loader -->
			<div id="loader-wrapper">
				
				<div class="loader">
				  <div class="dot"></div>
				  <div class="dot"></div>
				  <div class="dot"></div>
				  <div class="dot"></div>
				  <div class="dot"></div>
				</div>
			</div>


		<!-- Main Wrapper -->
		<div class="inner-wrapper login-body">
			<div class="login-wrapper">
				<div class="container">
				
				       <?php echo $template['body']; ?>
					
				</div>
			</div>
		</div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
		<?php echo theme_js('jquery-3.2.1.min.js'); ?>
		
		<!-- Bootstrap Core JS -->
		<?php echo theme_js('popper.min.js'); ?>
		<?php echo theme_js('bootstrap.min.js'); ?>
		
		<!-- Sticky sidebar JS -->
		<?php echo theme_js('plugins/theia-sticky-sidebar/ResizeSensor.js'); ?>	
		<?php echo theme_js('plugins/theia-sticky-sidebar/theia-sticky-sidebar.js'); ?>	
					
		<!-- Custom Js -->
		<?php echo theme_js('script.js'); ?>
		
	</body>


</html>