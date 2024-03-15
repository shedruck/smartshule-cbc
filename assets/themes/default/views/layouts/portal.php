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
		<link rel="stylesheet" href="assets/css/lnr-icon.css">
		<?php echo theme_css('lnr-icon.css'); ?>		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<?php echo theme_css('font-awesome.min.css'); ?>		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
		<?php echo theme_css('bootstrap-datetimepicker.min.css'); ?>	
		<!-- Custom CSS -->
		
		<?php echo theme_css('style.css'); ?>	
		
	 <title><?php echo $template['title']; ?></title>
	 
	 <!-- Favicon -->
		
		

		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
	</head>
	<body class="<?php echo $this->school->theme_color . ' ' . $this->school->background; ?>">
	  <?php $settings = $this->ion_auth->settings(); ?>
		<!-- Inner wrapper -->
		<div class="inner-wrapper">
				
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

			<!-- Header -->
			<header class="header">
			 <?php echo $template['partials']['header']; ?>
			</header>
			<!-- /Header -->
			
			<!-- Content -->
			<div class="page-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-3 col-lg-4 col-md-12 theiaStickySidebar">
							<aside class="sidebar sidebar-user">
	
							 <?php echo $template['partials']['sidebar']; ?>
								
							</aside>
						</div>

						<div class="col-xl-9 col-lg-8  col-md-12">
							  <?php echo $template['body']; ?>
						</div>
					</div>
				</div>
			</div>
			<!--/Content-->
			
		</div>
		<!-- Inner Wrapper -->
		
		<div class="sidebar-overlay" id="sidebar_overlay"></div>
		
		<!-- New Team The Modal -->
		<div class="modal fade" id="addNewType">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title mb-3">Create New Date Type</h4>
						<div class="form-group">
							<div class="input-group mb-3">
								<input class="form-control date-enter" type="text" placeholder="Date Type">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<input class="form-control datetimepicker date-enter" type="text" placeholder="Key Date">
							</div>
						</div>
						<button type="button" class="btn btn-danger ctm-border-radius float-right ml-3" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn text-white ctm-border-radius btn-theme float-right">Add</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Add Basic Information The Modal -->
		<div class="modal fade" id="add_basicInformation">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title mb-3">Basic Information</h4>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Preferred Name">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="First Name">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Last Name">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Nationality">
						</div>
						<div class="input-group mb-3">
							<input class="form-control datetimepicker date-enter" type="text" placeholder="Add Date of Birth">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Gender">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Blood Group">
						</div>
						<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-theme text-white ctm-border-radius float-right button-1">Add</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Edit Basic Information The Modal -->
		<div class="modal fade" id="edit_basicInformation">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title mb-3">Edit Basic Information</h4>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Preferred Name" value="Maria">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="First Name" value="Maria">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Last Name" value="Cotton">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Nationality" value="American">
						</div>
						<div class="input-group mb-3">
							<input class="form-control datetimepicker date-enter" type="text" placeholder="Add Date of Birth" value="05-07-1990">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Gender" value="Female">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Blood Group" value="A+">
						</div>
						<button type="button" class="btn btn-danger float-right ml-3" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-theme text-white ctm-border-radius float-right button-1">Save</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Edit Contact The Modal -->
		<div class="modal fade" id="edit_Contact">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title mb-3">Edit Contact</h4>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Phone Number" value="987654321">
						</div>
						<div class="input-group mb-3">
							<input type="email" class="form-control" placeholder="Login Email" value="mariacotton@example.com">
						</div>
						<div class="input-group mb-3">
							<input type="email" class="form-control" placeholder="Add Personal Email" value="maria@example.com">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Seconary Phone Number" value="986754231">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Web Site" value="www.focustechnology.com">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Connect Your Linkedin" value="#mariacotton">
						</div>
						<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-theme text-white ctm-border-radius float-right button-1">Save</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Add Contact The Modal -->
		<div class="modal fade" id="add_Contact">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title mb-3">Add Contact</h4>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Phone Number">
						</div>
						<div class="input-group mb-3">
							<input type="email" class="form-control" placeholder="Login Email">
						</div>
						<div class="input-group mb-3">
							<input type="email" class="form-control" placeholder="Add Personal Email">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Seconary Phone Number">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Add Web Site">
						</div>
						<div class="input-group mb-3">
							<input type="text" class="form-control" placeholder="Connect Your Linkedin">
						</div>
						<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-theme text-white ctm-border-radius float-right button-1">Save</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Add a Key Date Modal-->
		<div class="modal fade" id="addKeyDate">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title mb-3">Add New Date</h4>
						<div class="form-group">
							<div class="input-group mb-1">
								<input class="form-control datetimepicker date-enter" type="text" placeholder="Date Type">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<input class="form-control datetimepicker date-enter" type="text" placeholder="Key Date">
							</div>
						</div>
						<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-theme text-white ctm-border-radius float-right button-1">Add</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Edit Date Modal-->
		<div class="modal fade" id="edit_Dates">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title mb-3">Edit Date</h4>
						<div class="form-group">
							<div class="input-group mb-1">
								<input class="form-control datetimepicker date-enter" type="text" placeholder="Start Date" value="06-07-2017">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group mb-3">
								<input class="form-control datetimepicker date-enter" type="text" placeholder="Visa Expiry Date" value="06 -07-2020">
							</div>
						</div>
						<button type="button" class="btn btn-danger text-white ctm-border-radius float-right ml-3" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-theme text-white ctm-border-radius float-right button-1">Add</button>
					</div>
				</div>
			</div>
		</div>
				
		<!-- jQuery -->
		
				<!-- jQuery -->
		<?php echo theme_js('jquery-3.2.1.min.js'); ?>
		
		<!-- Bootstrap Core JS -->
		<?php echo theme_js('popper.min.js'); ?>
		<?php echo theme_js('bootstrap.min.js'); ?>
		
		<?php echo theme_js('plugins/select2/moment.min.js'); ?>
		<?php echo theme_js('bootstrap-datetimepicker.min.js'); ?>
		
		<!-- Sticky sidebar JS -->
		<?php echo theme_js('plugins/theia-sticky-sidebar/ResizeSensor.js'); ?>	
		<?php echo theme_js('plugins/theia-sticky-sidebar/theia-sticky-sidebar.js'); ?>	
					
		<!-- Custom Js -->
		<?php echo theme_js('script.js'); ?>

	</body>

</html>