<!DOCTYPE html>
<html lang="en"
      dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible"
              content="IE=edge">
        <meta name="viewport"
              content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $template['title']; ?></title>

        <!-- Prevent the demo from appearing in search engines -->
        <meta name="robots"
              content="noindex">

        <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7COswald:300,400,500,700%7CRoboto:400,500%7CExo+2:600&display=swap"
              rel="stylesheet">

        <!-- Perfect Scrollbar -->
        <link type="text/css"
              href="<?php echo base_url('assets/default/vendor/perfect-scrollbar.css')?>"
              rel="stylesheet">

        <!-- Material Design Icons -->
        <link type="text/css"
              href="<?php echo base_url('assets/default/css/material-icons.css')?>"
              rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link type="text/css"
              href="<?php echo base_url('assets/default/css/fontawesome.css')?>"
              rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css"
              href="<?php echo base_url('assets/default/vendor/spinkit.css')?>"
              rel="stylesheet">
        <link type="text/css"
              href="<?php echo base_url('assets/default/css/preloader.css')?>"
              rel="stylesheet">


<link type="text/css"
              href="<?php echo base_url('assets/default/js/lib/main.css')?>"
              rel="stylesheet">

        <!-- App CSS -->
        <link type="text/css"
              href="<?php echo base_url('assets/default/css/app.css')?>"
              rel="stylesheet">

        <!-- Dark Mode CSS (optional) -->
        <link type="text/css"
              href="<?php echo base_url('assets/default/css/dark-mode.css')?>"
              rel="stylesheet">

        <!-- Flatpickr -->
        <link type="text/css"
              href="<?php echo base_url('assets/default/css/flatpickr.css')?>"
              rel="stylesheet">
        <link type="text/css"
              href="<?php echo base_url('assets/default/css/flatpickr-airbnb.css')?>"
              rel="stylesheet">
			  
			    <!-- jQuery -->
        <script src="<?php echo base_url('assets/default/vendor/jquery.min.js')?>"></script>

    </head>

    <body class="layout-app layout-sticky-subnav ">
	
	  <?php $settings = $this->ion_auth->settings(); ?>

      
            <!--   <div class="preloader">
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
<div class="sk-bounce">
    <div class="sk-bounce-dot"></div>
    <div class="sk-bounce-dot"></div>
  </div> -->

           
        </div>

        <div class="mdk-drawer-layout js-mdk-drawer-layout"
             data-push
             data-responsive-width="992px">
            <div class="mdk-drawer-layout__content page-content">

                <!-- Header -->

                <div class="navbar navbar-expand navbar-shadow px-0  pl-lg-16pt navbar-light bg-body"
                     id="default-navbar"
                     data-primary>

                    <!-- Navbar toggler -->
                    <button class="navbar-toggler d-block d-lg-none rounded-0"
                            type="button"
                            data-toggle="sidebar">
                        <span class="material-icons">menu</span>
                    </button>

                    <!-- Navbar Brand -->
                    <a href="<?php echo base_url();?>"
                       class="navbar-brand mr-16pt d-lg-none">
					   
                        <img class="navbar-brand-icon mr-0 mr-lg-8pt"
                             src="<?php echo base_url('uploads/files/' . $settings->document); ?>"
                             width="32"
                             >
                        <span class="d-none d-lg-block"><?php echo $settings->school; ?></span>
                    </a>

                    <!-- <button class="btn navbar-btn mr-16pt" data-toggle="modal" data-target="#apps">Apps <i class="material-icons">arrow_drop_down</i></button> -->

                    <form class="search-form navbar-search d-none d-md-flex mr-16pt"
                          action="index.html">
                        <button class="btn"
                                type="submit"><i class="material-icons">search</i></button>
                        <input type="text"
                               class="form-control"
                               placeholder="Search ...">
                    </form>

                    <div class="flex"></div>

                 

                    <div class="nav navbar-nav flex-nowrap d-flex ml-0 mr-16pt">
                       

                        <!-- Notifications dropdown -->
                        <div class="nav-item ml-16pt dropdown dropdown-notifications">
                            <button class="nav-link btn-flush dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown"
                                    data-dropdown-disable-document-scroll
                                    data-caret="false">
                                <i class="material-icons">notifications</i>
                                <span class="badge badge-notifications badge-accent">0</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div data-perfect-scrollbar
                                     class="position-relative">
                                    <div class="dropdown-header"><strong>System notifications</strong></div>
                                    <div class="list-group list-group-flush mb-0">

                                       <!-- <a href="javascript:void(0);"
                                           class="list-group-item list-group-item-action unread">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">3 minutes ago</small>

                                                <span class="ml-auto unread-indicator bg-accent"></span>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <span class="avatar-title rounded-circle bg-light">
                                                        <i class="material-icons font-size-16pt text-accent">account_circle</i>
                                                    </span>
                                                </span>
                                                <span class="flex d-flex flex-column">

                                                    <span class="text-black-70">Your profile information has not been synced correctly.</span>
                                                </span>
                                            </span>
                                        </a> -->

                                      

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // END Notifications dropdown -->

                        <!-- Notifications dropdown -->
                        <div class="nav-item ml-16pt dropdown dropdown-notifications">
                            <button class="nav-link btn-flush dropdown-toggle"
                                    type="button"
                                    data-toggle="dropdown"
                                    data-dropdown-disable-document-scroll
                                    data-caret="false">
                                <i class="material-icons icon-24pt">mail_outline</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div data-perfect-scrollbar
                                     class="position-relative">
                                    <div class="dropdown-header"><strong>Messages</strong></div>
                                    <div class="list-group list-group-flush mb-0">
                                 <!--
                                        <a href="javascript:void(0);"
                                           class="list-group-item list-group-item-action unread">
                                            <span class="d-flex align-items-center mb-1">
                                                <small class="text-black-50">5 minutes ago</small>

                                                <span class="ml-auto unread-indicator bg-accent"></span>

                                            </span>
                                            <span class="d-flex">
                                                <span class="avatar avatar-xs mr-2">
                                                    <img src="<?php echo base_url('assets/default/images/people/110/woman-5.jpg')?>"
                                                         alt="people"
                                                         class="avatar-img rounded-circle">
                                                </span>
                                                <span class="flex d-flex flex-column">
                                                    <strong class="text-black-100">Michelle</strong>
                                                    <span class="text-black-70">Clients loved the new design.</span>
                                                </span>
                                            </span>
                                        </a>

                                    -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- // END Notifications dropdown -->
						 <?php
								if ($this->ion_auth->logged_in())
								{
							?>
						 <div class="nav-item dropdown d-none d-sm-flex">
                            <a href="#"
                               class="nav-link d-flex align-items-center dropdown-toggle"
                               data-toggle="dropdown">
							   	<?php
								$u = $this->ion_auth->get_user();
								$user = $this->ion_auth->parent_profile($u->id);
								?> 
								
									 <?php
									if (!empty($user->father_photo)):
									$passport = $this->portal_m->parent_photo($user->father_photo);
									  if ($passport)
											{
													?> 
										<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" class="rounded-circle mr-8pt" width="32" >
									 <?php } ?>	

									<?php else: ?>   
										<?php echo theme_image("member.png", array('class' => "rounded-circle mr-8pt", 'width' => "32")); ?>
								<?php endif; ?>
													
                              
                                <span class="flex d-flex flex-column mr-8pt">
                                    <span class="navbar-text-100"><?php echo strtoupper($this->user->first_name . ' ' . $this->user->last_name); ?></span>
                                    <small class="navbar-text-50">Parent Portal</small>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header"><strong>Account</strong></div>
                                <a class="dropdown-item"
                                   href="<?php echo base_url('parent_profile'); ?>">Profile</a>
                                <a class="dropdown-item"
                                   href="<?php echo base_url('change_password'); ?>">Change Password</a>
                                <a class="dropdown-item"
                                   href="<?php echo base_url('portals/parents/mpesa_payment')?>">Make Payments</a>
                                <a class="dropdown-item"
                                   href="<?php echo base_url('logout'); ?>">Logout</a>
                            </div>
                        </div>
						 <?php } ?>
						
                    </div>

                  

                </div>

                <!-- // END Header -->

                <div class="border-bottom-2 py-32pt position-relative z-1">
                    <div class="container-fluid page__container d-flex flex-column flex-md-row align-items-center text-center text-sm-left">
                        <div class="flex d-flex flex-column flex-sm-row align-items-center mb-24pt mb-md-0">
						
						 <?php
										$ct = count($this->parent->kids);
										$bal = 0;
										foreach ($this->parent->kids as $pp)
										{
												$bal += $pp->balance;
										}
									?>

                          <?php
								if (preg_match('/^(account)$/i', $this->uri->uri_string())) {
							?>
                            <div class="mb-24pt mb-sm-0 mr-sm-24pt">
                                <h2 class="mb-0">DASHBOARD</h2>

                                <ol class="breadcrumb p-0 m-0">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>

                                    <li class="breadcrumb-item active">

                                       <?php echo $template['title']; ?>

                                    </li>

                                </ol>

                            </div>
							
							 <div class="row" role="tablist">
                            <div class="col-auto d-flex flex-column">
                                <div class="card card-group-row__card">
										<div class="card-body d-flex flex-row align-items-center bg-green">
											<div class="flex">
												<p class="d-flex align-items-center mb-0 text-white">
													<strong >My  Students</strong>
													
													<i class="material-icons text-success ml-4pt icon-16pt">keyboard_arrow_up</i>
												</p>
												<span class="h3 m-0 text-white">
													 <?php echo $ct; ?> <?php echo $ct == 1 ? 'STUDENT' : 'STUDENTS'; ?>
												</span>
											</div>
											<i class="material-icons icon-32pt text-20 ml-8pt text-white">contacts</i>
										</div>
										<div class="progress" style="height: 3px;">
											<div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
                            </div>

							<div class="col-auto d-flex flex-column">
                                <div class="card card-group-row__card">
										<div class="card-body d-flex flex-row align-items-center bg-red">
											<div class="flex">
												<p class="d-flex align-items-center mb-0 text-white">
													<strong >Current Fee Balance</strong>
													
													<i class="material-icons text-accent ml-4pt icon-16pt">keyboard_arrow_up</i>
												</p>
												<span class="h3 m-0 text-white">
													<?php echo $this->currency; ?> <?php echo number_format($bal); ?> 
												</span>
											</div>
											<i class="material-icons icon-32pt text-20 ml-8pt text-white">business_center</i>
										</div>
										<div class="progress" style="height: 3px;">
											<div class="progress-bar bg-accent" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
                            </div>
							
							
                        </div>
						
						<div class="col-auto border-left">
                                <a href="<?php echo base_url('messages')?>"
                                   class="btn btn-accent">Send Message</a>
                                  
                                   <button  class="btn btn-warning"  data-toggle="modal"  data-target="#req">Uniform Requisition</button>
                        </div>

							
						<?php }else{?>	
						
						
							<div class="col-md-8">
                                <h2 class="mb-0"> <?php echo $template['title']; ?></h2>

                                <ol class="breadcrumb p-0 m-0">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>

                                    <li class="breadcrumb-item active">

                                       <?php echo $template['title']; ?>

                                    </li>

                                </ol>
								
								

                            </div>
							<div class="col-sm-4">
							<a  onclick="goBack()" href="#" class="btn btn-danger w-sm waves-effect m-t-10 waves-light pull-right"><i class="fa fa-caret-left"></i>&nbsp;&nbsp; Go Back</a>
                            </div>
						
							
							<?php } ?>
							
							   <?php
										$ct = count($this->parent->kids);
										$bal = 0;
										foreach ($this->parent->kids as $pp)
										{
												$bal += $pp->balance;
										}
									?>

							

                       
                           
                            
                        </div>

                    </div>
                </div>
				
				

                <div class="container-fluid page__container">
                    <div class="page-section">
					
                         <?php echo $template['body']; ?>


                       
                    </div>
                </div>

              

            </div>
            <!-- // END drawer-layout__content -->

            <!-- drawer -->
            <div class="mdk-drawer js-mdk-drawer"
                 id="default-drawer">
                <div class="mdk-drawer__content">
                    <div class="sidebar sidebar-left ps ps--active-y sidebar-light sidebar-light-dodger-blue" data-perfect-scrollbar>

                        <!-- Navbar toggler -->
                        <a href="<?php echo base_url()?>"
                           class="navbar-toggler navbar-toggler-right navbar-toggler-custom d-flex align-items-center justify-content-center position-absolute right-0 top-0"
                           data-toggle="tooltip"
                           data-title="Switch to Compact Vertical Layout"
                           data-placement="right"
                           data-boundary="window">
                            <span class="material-icons">sync_alt</span>
                        </a>

                        <a href="<?php echo base_url()?>" class="sidebar-brand " >
						   
                            <img width="80" src="<?php echo base_url('uploads/files/' . $settings->document); ?>" alt="SCHOOL LOGO" style="background:#fff; border-radius:10%">
							
                            <center class="text-white" style="margin-top:10px">
							<small>
							<?php echo $settings->school; ?>

							</small>
							
							</center>
                        </a>
<a href="<?php echo base_url()?>portals/parents/malipo" class="text-center center">
<img src="<?php echo base_url('assets/default/images/ss/kcb.png')?>" width="25%">
<img src="<?php echo base_url('assets/default/images/ss/equity.png')?>" width="25%">
<img src="<?php echo base_url('assets/default/images/ss/coop.png')?>" width="25%">
</a>
<br>
                        <div class="sidebar-account mx-16pt mb-16pt dropdown bg-white" style="background:#fff !important">
						
                            <a href="<?php echo base_url('portals/parents/mpesa_payment')?>"
                               class="nav-link d-flex align-items-center " >
							   
                                <img width="25"
								
                                     height="25"
                                     class="rounded-circle mr-8pt"
                                     src="<?php echo base_url('assets/default/images/ss/mpesa.png')?>"
                                     alt="account" />
                                <span class="flex d-flex  flex-column mr-8pt" >
                                   
                                    <small class="text-black-60" style="color:#000 !important">LIPA NA M-PESA</small>
                                </span>
                                <i class="material-icons text-black-20 icon-16pt" style="color:#000 !important">keyboard_arrow_down</i>
                            </a>
                            
                        </div>

                        <div class="sidebar-heading">NAVIGATION MENU</div>
                        <ul class="sidebar-menu">
						
						<?php
						$active = '';
							if (preg_match('/^(account)$/i', $this->uri->uri_string())) {$active = 'active';}
						?>
									
                            <li class="sidebar-menu-item <?php echo $active;?>">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url();?>">
                                    <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left fa fa-home"></span>
                                    <span class="sidebar-menu-text">DASHBOARD</span>
                                </a>
                            </li>
							
							<?php 
								   $finance = '';
								      if (
										  preg_match('/^(portals\/parents\/mpesa_payment)/i', $this->uri->uri_string()) ||
										  preg_match('/^(portals\/parents\/check_payment)/i', $this->uri->uri_string()) ||
										  preg_match('/^(fee_payment)/i', $this->uri->uri_string())
									  ){ $finance = 'active';}
								  ?>
							
							<li class="sidebar-menu-item <?php echo $finance; ?>">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('fee_payment/fee');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left fa fa-briefcase"></span>
                                    <span class="sidebar-menu-text">FINANCE</span>
                                </a>

                            </li>
							
							 <?php 
								   $acc = '';
								      if (
									  preg_match('/^(portals\/parents\/class_attendance)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/assignments)/i', $this->uri->uri_string()) ||
									  preg_match('/^(parents\/cbc)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/results)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/student_certificates)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/pgs\/academics)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/diary)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/national_exam_cert)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/other_certificates)/i', $this->uri->uri_string()) ||
									  preg_match('/^(assignments)/i', $this->uri->uri_string())
									  ){ $acc = 'active';}
								  ?>
							<li class="sidebar-menu-item <?php echo $acc;?>">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('portals/parents/pgs/academics');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left fa fa-book-reader"></span>
                                    <span class="sidebar-menu-text">ACADEMICS</span>
                                </a>
                            </li>
							
							 <?php 
								   $comm = '';
								      if (
									  preg_match('/^(portals\/parents\/newsletters)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/events)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/sms)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/pgs\/communication)/i', $this->uri->uri_string()) ||
									  preg_match('/^(messages)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/notices)/i', $this->uri->uri_string()) ||
									  preg_match('/^(portals\/parents\/rules_regulations)/i', $this->uri->uri_string()) 
									  ){ $comm = 'active';}
								  ?>
							
							<li class="sidebar-menu-item <?php echo $comm;?> ">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('portals/parents/pgs/communication');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left fa fa-envelope"></span>
                                    <span class="sidebar-menu-text">COMMUNICATION</span>
                                </a>
                            </li>
							
							 <?php 
										   $kds = '';
											  if (
											  preg_match('/^(students)/i', $this->uri->uri_string()) ||
											   preg_match('/^(portals\/parents\/student_report)/i', $this->uri->uri_string()) 
											
											  ){ $kds = 'active';}
										  ?>
										  
							
							<li class="sidebar-menu-item <?php echo $kds;?> ">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('students');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left fa fa-users"></span>
                                    <span class="sidebar-menu-text">STUDENT(S) PROFILE</span>
                                </a>
                            </li>
							
							 <?php 
								   $prof = '';
								      if (
									  preg_match('/^(change_password)/i', $this->uri->uri_string()) ||
									  preg_match('/^(parent_profile)/i', $this->uri->uri_string()) ||
									
									  preg_match('/^(profile)/i', $this->uri->uri_string()) 
									  ){ $prof = 'active';}
								  ?>
							
							<li class="sidebar-menu-item <?php echo $prof;?> ">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('parent_profile');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left fa fa-user"></span>
                                    <span class="sidebar-menu-text">MY PROFILE</span>
                                </a>
                            </li>
							
								<li class="sidebar-menu-item <?php echo $change_password;?> ">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('change_password');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">lock</span>
                                    <span class="sidebar-menu-text">CHANGE PASSWORD</span>
                                </a>
                            </li>
							
							
                        </ul>

                     
                    </div>
                </div>
            </div>
            <!-- // END drawer -->
        </div>
        <!-- // END drawer-layout -->
		
		<?php

			$students = array();
			foreach ($this->parent->kids as $k)
			{
					$usr = $this->admission_m->find($k->student_id);
					$students[$k->student_id] = strtoupper(trim($usr->first_name . ' ' . $usr->middle_name. ' ' . $usr->last_name));
			}


			?>
		
	           <div id="dairy" class="modal fade diary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<?php echo form_open('portals/parents/diary'); ?>
								<div class="modal-content">
									<div class="modal-header">
										
										<h4 class="modal-title">Students Diary  </h4>
										
									</div>
									<div class="modal-body">
									 
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="field-3" class="control-label">Select Child/Student</label>
												   <?php echo form_dropdown('student', $students, $this->input->post('student'), 'class="xsel form-control " placeholder="Select Student"'); ?>
												</div>
											</div>
										</div>
									 
									</div>
									<div class="modal-footer">
									  
										<button type="submit" class="btn btn-info waves-effect waves-light">Submit</button> 
										<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
									</div>
								</div>
								<?php echo form_close(); ?>
								
							</div>
						</div><!-- /.modal -->


						<div id="assignments" class="modal fade assignments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<?php echo form_open('portals/parents/assignments'); ?>
								<div class="modal-content">
									<div class="modal-header">
										
										<h4 class="modal-title">Class Assignments  </h4>
										
									</div>
									<div class="modal-body">
									 
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="field-3" class="control-label">Select Child/Student</label>
												   <?php echo form_dropdown('student', $students, $this->input->post('student'), 'class="xsel form-control " placeholder="Select Student"'); ?>
												</div>
											</div>
										</div>
									 
									</div>
									<div class="modal-footer">
									  
										<button type="submit" class="btn btn-info waves-effect waves-light">Submit</button> 
										<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
									</div>
								</div>
								<?php echo form_close(); ?>
								
							</div>
						</div><!-- /.modal -->
						
						
						<div id="attendance" class="modal fade attendance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<?php echo form_open('portals/parents/class_attendance'); ?>
								<div class="modal-content">
									<div class="modal-header">
										
										<h4 class="modal-title">Student Attendance / Rollcall  </h4>
										
									</div>
									<div class="modal-body">
									 
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="field-3" class="control-label">Select Child/Student</label>
												   <?php echo form_dropdown('student', $students, $this->input->post('student'), 'class="xsel form-control " placeholder="Select Student"'); ?>
												</div>
											</div>
										</div>
									 
									</div>
									<div class="modal-footer">
									  
										<button type="submit" class="btn btn-info waves-effect waves-light">Submit</button> 
										<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
									</div>
								</div>
								<?php echo form_close(); ?>
								
							</div>
						</div><!-- /.modal -->
		

		
		
      

        <!-- Bootstrap -->
        <script src="<?php echo base_url('assets/default/vendor/popper.min.js')?>"></script>
        <script src="<?php echo base_url('assets/default/vendor/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('assets/default/js/lib/main.js')?>"></script>
        <script src="<?php echo base_url('assets/default/js/lib/locales-all.js')?>"></script>
		
	
        <!-- Perfect Scrollbar -->
        <script src="<?php echo base_url('assets/default/vendor/perfect-scrollbar.min.js')?>"></script>

        <!-- DOM Factory -->
        <script src="<?php echo base_url('assets/default/vendor/dom-factory.js')?>"></script>

        <!-- MDK -->
        <script src="<?php echo base_url('assets/default/vendor/material-design-kit.js')?>"></script>

        <!-- App JS -->
        <script src="<?php echo base_url('assets/default/js/app.js')?>"></script>

        <!-- Highlight.js -->
        <script src="<?php echo base_url('assets/default/js/hljs.js')?>"></script>
        
        <!-- Flatpickr -->
        <script src="<?php echo base_url('assets/default/vendor/flatpickr/flatpickr.min.js')?>"></script>
        <script src="<?php echo base_url('assets/default/js/flatpickr.js')?>"></script>
		
		
		
		
		
        <!-- App Settings (safe to remove) -->
        <script src="<?php echo base_url('assets/default/js/app-settings.js')?>"></script>
        <script src="<?php echo base_url('assets/default/js/sweet-alert.min.js')?>"></script>
      
		
	   <script>
function goBack() {
  window.history.back();
}
</script>


		
<?php
	if (preg_match('/^(portals\/parents\/class_attendance)$/i', $this->uri->uri_string())):
	
	//print_r($att);
?>


<script>

  document.addEventListener('DOMContentLoaded', function() {
    var initialLocaleCode = 'en';
    var localeSelectorEl = document.getElementById('locale-selector');
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      initialDate: '<?php echo date("Y-m-d")?>',
      locale: initialLocaleCode,
      buttonIcons: false, // show the prev/next text
      weekNumbers: true,
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
	  
	  <?php foreach($att as $p){?>
		    {
                title: '<?php echo $p->title;?>',
                start: new Date('<?php echo date("Y-m-d",$p->attendance_date);?>'),
                className: '<?php if($p->status=="Present") echo "bg-success"; else echo "bg-danger";?>'
            },
		<?php } ?>
		
        
         
      ]
    });

    calendar.render();

    // build the locale selector's options
    calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
      var optionEl = document.createElement('option');
      optionEl.value = localeCode;
      optionEl.selected = localeCode == initialLocaleCode;
      optionEl.innerText = localeCode;
      localeSelectorEl.appendChild(optionEl);
    });

    // when the selected option changes, dynamically change the calendar option
    localeSelectorEl.addEventListener('change', function() {
      if (this.value) {
        calendar.setOption('locale', this.value);
      }
    });

  });

</script>
<style>

  body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #top {
    background: #eee;
    border-bottom: 1px solid #ddd;
    padding: 0 10px;
    line-height: 40px;
    font-size: 12px;
  }

  #calendar {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 10px;
  }

</style>



<?php endif ;?>




    </body>
    <?php
$students = array();
foreach ($this->parent->kids as $k)
{
	
        $usr = $this->admission_m->find($k->student_id);
		
		$adm = $usr->admission_number;
				if(!empty($usr->old_adm_no)){
					$adm = $usr->old_adm_no;
				}
		
        $students[$k->student_id] = trim($usr->first_name . ' ' . $usr->last_name . ' - ' .$adm );
}
		$phone =  $this->parent->phone;
		$new_phone = substr_replace($phone, 254, 0, ($phone[0] == '0'));


$items=$this->portal_m->get_shop_items();



		
		
?>
    <div class="modal fade"  id="req" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
          
            <div class="modal-body">
                <h4>Requisition Form</h4>
                <?php echo form_open('shop_item/parents/create')?>
                <div class="form-group ">
					<div class="input-prepend">
					   <?php echo form_dropdown('student', array('' => 'Select Student') + $students, $this->input->post('student'), 'id="reg_no"  class="xsel form-control " placeholder="Select Student"'); ?>

						<?php echo form_error('student'); ?>
					   
					</div>
                 
                </div>

                <div class="form-group ">
					<!-- <div class="input-prepend"> -->
					  <select name="items[]" class="form-control" multiple>
                          <option disabled>Select Uniform</option>
                          <?php foreach($items as $item){?>
                            <option value="<?php echo $item->id?>"><?php echo $item->name?> Size from <?php echo $item->size_from?> To <?php echo $item->size_to?> (Kshs<?php echo number_format($item->sp,2)?>)</option>
                          <?php }?>
                      </select>

					<!-- </div> -->
                </div>

                <button class="btn btn-success" type="submit">Submit</button>

                
                <?php echo form_close()?>
            
       
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</html>