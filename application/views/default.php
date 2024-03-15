<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Smartshule"> 
        <title>Smartshule - <?php echo $template['title']; ?></title>
        <!-- css -->
        <link href="<?php //echo base_url('assets/themes/default/css/summernote.css'); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/themes/default/css/comm.css'); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/themes/default/css/select2/select2.css'); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/themes/default/css/font-awesome.min.css'); ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/themes/admin/css/select2/multiselect.css'); ?>" type="text/css" rel="stylesheet" />
		
		
        <?php echo theme_css('offline.min.css'); ?>
        <?php echo theme_css('bootstrap-editable.css'); ?>
        <?php echo theme_css('fullcalendar.min.css'); ?>
        <?php echo theme_css('bootstrap.min.css'); ?>
        <?php echo theme_css('core.css?'. time()); ?>
        <?php echo theme_css('jquery-ui.min.css'); ?>
        <?php echo theme_css('components.css'); ?>
        <?php echo theme_css('icons.css'); ?>
		<?php if(
		preg_match('/^(trs\/view_message)/', $this->uri->uri_string()) || 
		preg_match('/^(mc\/trs\/view_mc)/', $this->uri->uri_string()) || 
		preg_match('/^(mc\/st\/view_mc)/', $this->uri->uri_string()) || 
		preg_match('/^(mc\/st\/mc_start)/', $this->uri->uri_string()) || 
		preg_match('/^(qa\/st\/qa_result)/', $this->uri->uri_string()) || 
		preg_match('/^(qa\/trs\/qa_result)/', $this->uri->uri_string()) || 
		preg_match('/^(qa\/trs\/view_qa)/', $this->uri->uri_string()))
		{; ?>
           <?php echo theme_css('pages.css'); ?>
		<?php } ?>
        <?php echo theme_css('menu.css'); ?>
        <?php echo theme_css('responsive.css'); ?>
        <?php echo theme_css('datatables/jquery.dataTables.min.css'); ?>
        <?php echo theme_css('datatables/buttons.bootstrap.min.css'); ?>
        <?php echo theme_css('datatables/dataTables.bootstrap.min.css'); ?>
        <?php echo theme_css('summernote/summernote.css'); ?>
        <link href="<?php echo base_url('assets/themes/admin/css/pnotify/jquery.pnotify.default.css'); ?>" type="text/css" rel="stylesheet" />
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style>.mdi{    font-size: 19px;}</style>
        <!-- jQuery  -->
        <?php echo theme_js('jquery.min.js'); ?>
        <?php echo theme_js('offline.min.js'); ?>
        <?php echo theme_js('modernizr.min.js'); ?>
        <?php echo theme_js('jquery-ui.min.js'); ?>
        <?php echo theme_js('datatables/jquery.dataTables.min.js'); ?>
        <?php echo theme_js('datatables/dataTables.bootstrap.js'); ?>
        <?php echo theme_js('datatables/dataTables.buttons.min.js'); ?>
        <?php echo theme_js('datatables/buttons.bootstrap.min.js'); ?>
        <?php echo theme_js('datatables/jszip.min.js'); ?>
        <?php echo theme_js('datatables/pdfmake.min.js'); ?>
        <?php echo theme_js('datatables/buttons.html5.min.js'); ?>
        <?php echo theme_js('datatables/vfs_fonts.js'); ?>
		 <?php echo theme_js('plupload/plupload.full.min.js'); ?>
        <?php echo theme_js('bootstrap.min.js'); ?>
        <script src="<?php echo base_url('assets/themes/admin/plugins/libs.js'); ?>?<?php echo time(); ?>"></script>
        <script> var BASE_URL = '<?php echo base_url(); ?>';</script>
        <?php $avt = strtolower(substr($this->user->first_name, 0, 1)); ?>
        <style>.card-box { padding: 10px;} </style>
    </head>
	<?php
	  if ($this->ion_auth->is_in_group($this->user->id, 3))
		{
	?>
    <body class="<?php //echo $this->school->theme_color . ' ' . $this->school->background; ?>">
							<?php }else{ ?>
    <body class="">
							<?php } ?>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">
                    <!-- Logo container-->
                    <div class="logo col-md-4">
                        <!-- Text Logo -->
                        <a href="#" class="logo hidden-xsd">
                            <?php echo $this->school->school; ?>
                        </a>
                    </div>
                    <!-- End Logo container-->
					
					<div class="text-center col-md-4 phead ">
						<a class="">
						 <?php
							  if ($this->ion_auth->is_in_group($this->user->id, 3))
								{
							?>
							TEACHER'S PORTAL
						 <?php } ?>
						 
						 <?php
							  if ($this->ion_auth->is_in_group($this->user->id, 8))
								{
							?>
							STUDENT'S PORTAL
						 <?php } ?>
						</a>
					</div>

                    <div class="menu-extras col-md-4">
                        <ul class="nav navbar-nav navbar-right pull-right">
						
						 <?php
							  if ($this->ion_auth->is_in_group($this->user->id, 8))
								{
							?>
						   <li>
                               <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                                    <i class="mdi mdi-bell"></i>
                                    <span class="badge up bg-success">
									
											<?php 
												$all = $this->portal_m->notifactions(); 
												$cc = count($all); 
												echo $cc;
												?>
										
									</span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                                    <li>
                                        <h5>Notifications</h5>
                                    </li>
									<?php 
									/**
									** update notifications table
									** ATT - 1
									** QA - 2
									** MC - 3
									****/
									$table ='';
									$url ='';
									foreach($all as $n){
										if($n->type==1) {$table='assignments'; $url= base_url('st/assignments_view/'.$n->id.'/'.$n->class.'/'.$this->session->userdata['session_id']);}
										if($n->type==2){ $table='qa'; $url= base_url('qa/st/qa_view/'.$n->id.'/'.$this->session->userdata['session_id']);}
										if($n->type==3){ $table='mc'; $url= base_url('mc/st/mc_view/'.$n->item_id.'/'.$this->session->userdata['session_id'].'/'.$n->id);}
										
									$ass = $this->portal_m->get_unenc_row('id',$n->item_id,$table);	
										?>
                                    <li>
                                        <a href="<?php echo $url?>" class="user-list-item">
                                            <div class="icon bg-info">
                                                <i class="mdi mdi-bell-ring-outline"></i>
                                            </div>
                                            <div class="user-desc">
                                                <span class="name"><?php echo substr($ass->title,0,50); ?></span>
                                                <span class="time"><?php echo time_ago($n->created_on)?></span>
                                            </div>
                                        </a>
                                    </li>
									<?php } ?>
                                    
                                    <li class="all-msgs text-center bg-black">
                                        <p class="m-0"><a href="#" class="text-white">See all Notification</a></p>
                                    </li>
                                </ul>
                            </li>
							<?php } ?>
							
                            <li class="dropdown">
                                <a class="dropdown-toggle profile-pic waves-effect waves-light" data-toggle="dropdown" href="#" aria-expanded="false">
								
                                    <b class="hidden-xs"> <?php echo $this->user->first_name . ' ' . $this->user->last_name ?></b><span class="caret"></span> 
									<?php
										  if ($this->ion_auth->is_in_group($this->user->id, 3))
											{
										?>
									<img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" alt="user-img"   class="img-circle">
											<?php } ?>
									<?php
										  if ($this->ion_auth->is_in_group($this->user->id, 8))
											{
										?>
								    	<img src="<?php echo $this->passport; ?>" alt="user-img"  width="60" height="60" class="img-circle">
										<?php } ?>
									</a>
									<?php
									$url = "";
									  if ($this->ion_auth->is_in_group($this->user->id, 3)) $url ='trs';
									  if ($this->ion_auth->is_in_group($this->user->id, 8)) $url ='st';
										
									?>
                                <ul class="dropdown-menu dropdown-user animated flipInY">
                                    <li><a href="<?php echo base_url($url.'/account'); ?>"><i class=" mdi mdi-account-settings"></i> Profile</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo base_url($url.'/change_password'); ?>"><i class=" mdi mdi-settings"></i> Change Password</a></li>
                                    <?php
					  if ($this->ion_auth->is_in_group($this->user->id, 3))
					 	{
										?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo base_url('trs/switch_account'); ?>"><i class=" mdi mdi-settings"></i> Switch Account </a></li>
                                    <?php } ?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo base_url($url .'/logout'); ?>"><i class="mdi mdi-power"></i> Logout</a></li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>
                </div> <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
						
							<!--- TEACHER --->
						<?php
						  if ($this->ion_auth->is_in_group($this->user->id, 3))
							{
						?>
                        <ul class="navigation-menu">
                            <li class="<?php echo preg_match('/^(trs)$/', $this->uri->uri_string()) ? 'active' : ''; ?>">
                                <a href="<?php echo base_url(); ?>"><i class=" mdi mdi-view-dashboard"></i>Home</a>
                            </li>
							   
                            <li class="has-submenu  
							
							<?php echo preg_match('/^(trs\/view_student)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/students)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							">
                                <a href="<?php echo base_url('trs/students'); ?>"><i class="mdi mdi-account-multiple"></i>My Students</a>
                               
                            </li>
							
							<li class="has-submenu  
							<?php echo preg_match('/^(trs\/register)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/list_register)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/view_register)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							
							">
                                <a href="<?php echo base_url('trs/attendance'); ?>"><i class="mdi fa-check"></i>Roll Call</a>
                               
                            </li>
							
                       
							
							 <li class="has-submenu
							<?php echo preg_match('/^(qa\/trs)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/diary)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(mc\/trs)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(enotes\/trs)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(lesson_materials\/trs)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/cbc)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/assign)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/results)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/view_assign)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/list_assign)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/evideos_landing)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/watch_general)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/watch)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/level_evideos)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							
							<?php echo preg_match('/^(trs\/past_papers)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/view_past_papers)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/bulk_edit)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/record)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/add_plan)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/edit_plan)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(trs\/view_plan)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							">
                                <a href="<?php echo base_url('trs/eclassroom'); ?>"><i class="mdi mdi-checkbox-marked-outline"></i>E-Classroom</a>
                                
                            </li>
							
							
							
                            <li class="<?php echo preg_match('/^(trs\/view_message)/', $this->uri->uri_string()) ? 'active' : ''; ?>" >
                                <a href="<?php echo base_url('trs/messages'); ?>"><i class="mdi mdi-comment"></i>Messages</a>
                            </li>                          
                        </ul>
						
							<?php } ?>
							
		<!--- STUDENT --->
		
		<?php
		  if ($this->ion_auth->is_in_group($this->user->id, 8))
			{
		?>
							
							   <ul class="navigation-menu">
                            <li class="<?php echo preg_match('/^(st)$/', $this->uri->uri_string()) ? 'active' : ''; ?>">
                                <a href="<?php echo base_url('st'); ?>"><i class=" mdi mdi-view-dashboard"></i>Home</a>
                            </li>
							    
                           
							
                          
							<li class="
							<?php echo preg_match('/^(st\/landing\/academics)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/diary)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/exams)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/results)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/attendance_register)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/certificates)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/class_subjects)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/grading_system)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/view_grades)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							">
                                <a href="<?php echo base_url('st/landing/academics'); ?>"><i class="mdi fa fa-comment-o"></i>Academics</a>
                                
                            </li>
							
							<li class="
							<?php echo preg_match('/^(st\/landing\/e-classroom)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/past_papers)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/view_past_papers)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/level_past_papers)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/evideos)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/watch)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(qa\/st)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(mc\/st)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/enotes)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/view_enotes)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/assignments)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/assignments_view)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							">
                                <a href="<?php echo base_url('st/landing/e-classroom'); ?>"><i class="mdi mdi-home-map-marker"></i>E-Classroom</a>
                            </li>
							
							<li class="has-submenu">
                                <a href="#"><i class="mdi mdi-comment-text"></i>Class Discussions</a>
                            </li>
							
							<li class="<?php echo preg_match('/^(st\/landing\/school-life)/', $this->uri->uri_string()) ? 'active' : ''; ?><?php echo preg_match('/^(st\/account)/', $this->uri->uri_string()) ? 'active' : ''; ?>">
                                <a href="<?php echo base_url('st/profile'); ?>"><i class="mdi fa fa-user"></i> Profile History</a>
                            </li>
						<!--	
							<li class="has-submenu">
                                <a href="#"><i class="mdi fa fa-envelope"></i>Communication</a>
								
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url('st/events'); ?>">School Events</a></li>
                                    <li><a href="<?php echo base_url('st/sms'); ?>">SMS Messages</a></li>
                                    <li><a href="<?php echo base_url('st/newsletters'); ?>">Newsletters</a></li>
                                    <li><a href="<?php echo base_url('st/notices'); ?>">Notice Board</a></li>
                                    <li><a href="<?php echo base_url('st/rules'); ?>">Rules and Regulations</a></li>
                                </ul>
                            </li>
							-->
							 <li class="has-submenu  
							<?php echo preg_match('/^(st\/fee)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/receipts)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							<?php echo preg_match('/^(st\/waivers)/', $this->uri->uri_string()) ? 'active' : ''; ?>
							
							">
                                <a href="#"><i class="mdi fa fa-money"></i>Financials</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url('st/fee'); ?>">Fee Statement</a></li>
                                    <li><a href="<?php echo base_url('st/receipts'); ?>">Payment Receipts</a></li>
									<!--
                                    <li><a href="<?php echo base_url('st/waivers'); ?>">Awarded Waivers</a></li>
                                    <li><a href="<?php echo base_url('st/pledges'); ?>">Fee Pledges</a></li>
									-->
                                </ul>
                            </li>
                                                
                        </ul>
						
							
							<?php } ?>
                        <!-- End navigation menu -->
                    </div> <!-- end #navigation -->
                </div> <!-- end container -->
            </div> 
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
        <div class="wrapper">
            <div class="clearfix m-b-10 hidden-print"></div>
            <div class="container">
                <?php
                if ($this->session->flashdata('message'))
                {
                        $message = $this->session->flashdata('message');
                        $str = is_array($message) ? $message['text'] : $message;
                        $type = is_array($message) ? $message['type'] : 'info';
                        $title = ucfirst($type);
                        ?>
                        <div class="alert alert-icon alert-dismissible fade in alert-<?php echo $type; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <i class="mdi mdi-information"></i>
                            <strong><?php echo $title; ?>!  </strong><?php echo $str; ?>
                        </div>
                <?php } ?>
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="btn-group pull-right">
                                <ol class="breadcrumb hide-phone p-0 m-0">
                                    <li>
                                        <?php echo anchor('/', 'Home'); ?>
                                    </li>
                                    <li>
                                        <?php
                                        if ($this->uri->segment(2))
                                        {
                                                ?>
                                                <span ><?php echo anchor('trs/' . $this->uri->segment(2), humanize($this->uri->segment(2))); ?> </span>
                                        <?php } ?>
                                    </li>
                                    <?php
                                    if (!preg_match('/^(trs)$/', $this->uri->uri_string()))
                                    {
                                            ?>
                                            <li class="active hidden-xs">
                                                <?php echo $template['title']; ?> 
                                            </li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
			<hr class="hidden-print">
                    </div>
                </div>
                <!-- end page title end breadcrumb -->              
                <?php echo $template['body']; ?>
                <!-- Footer -->
                <footer class="footer text-right hidden-print">
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
        <?php echo theme_js('detect.js'); ?>
        <?php echo theme_js('fastclick.js'); ?>
        <?php echo theme_js('jquery.blockUI.js'); ?>
        <?php echo theme_js('waves.js'); ?>
        <?php echo theme_js('jquery.slimscroll.js'); ?>
        <?php echo theme_js('jquery.scrollTo.min.js'); ?>
        <?php echo theme_js('moment/moment.js'); ?>
        <?php echo theme_js('fullcalendar.min.js'); ?>
        <?php echo theme_js('jquery.fullcalendar.js'); ?>
        <?php echo theme_js('bootstrap-editable.min.js'); ?>        
        <?php echo theme_js('jquery.app.js'); ?>
        <?php echo theme_js('summernote/summernote.min.js'); ?>
        <script src="<?php echo base_url('assets/themes/admin/js/plugins/pnotify/jquery.pnotify.min.js'); ?>"></script>
        <script src="<?php //echo base_url('assets/themes/default/js/summernote.js'); ?>"></script>
        <script src="<?php echo base_url('assets/themes/default/js/select2/select2.min.js'); ?>"></script>
		
		
		 <?php echo theme_js('datatables/jquery.dataTables.min.js'); ?>   
         <?php echo theme_js('datatables/dataTables.bootstrap.js'); ?>   

         <?php echo theme_js('datatables/dataTables.buttons.min.js'); ?>   
         <?php echo theme_js('datatables/buttons.bootstrap.min.js'); ?>   
         <?php echo theme_js('datatables/jszip.min.js'); ?>   
         <?php echo theme_js('datatables/pdfmake.min.js'); ?>   
         <?php echo theme_js('datatables/vfs_fonts.js'); ?>   
         <?php echo theme_js('datatables/buttons.html5.min.js'); ?>   
         <?php echo theme_js('datatables/buttons.print.min.js'); ?>   
         <?php echo theme_js('datatables/dataTables.fixedHeader.min.js'); ?>   
         <?php echo theme_js('datatables/dataTables.keyTable.min.js'); ?>   
         <?php echo theme_js('datatables/dataTables.responsive.min.js'); ?>   
         <?php echo theme_js('datatables/responsive.bootstrap.min.js'); ?>   
         <?php echo theme_js('datatables/dataTables.scroller.min.js'); ?>   
         <?php echo theme_js('datatables/dataTables.colVis.js'); ?>   
         <?php echo theme_js('datatables/dataTables.fixedColumns.min.js'); ?>   
         <?php echo theme_js('sweet-alert.min.js'); ?>   

        <!-- init -->
       <?php echo theme_js('pages/jquery.datatables.init.js'); ?>   

	   <script>
function goBack() {
  window.history.back();
}
</script>
		
		
        <script>
                function notify(title, text)
                {
                    $.pnotify({
                        title: title,
                        text: text,
                        addclass: 'custom',
                        hide: true,
                        opacity: 100,
                        nonblock: true,
                        nonblock_opacity: .5
                    });
                }
                $(document).ready(function ()
                {
                    $(".select").select2({'placeholder': 'Please Select', 'width': '100%'});
                    $('#summernote').summernote({
                        placeholder: 'Write description here...',
						 height: 100,                 // set editor height
						minHeight: null,             // set minimum height of editor
						maxHeight: null, 
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline']],
                            ['font', ['strikethrough']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']]
                        ]
                    });
                    $(".datepicker").datepicker({
                        changeMonth: true,
                        changeYear: true
                    });
                });
				
				
        </script>
		
		 <script>

            jQuery(document).ready(function(){

                $('.summernote').summernote({
                    placeholder: 'Write description here...',
					height: 100,                 // set editor height
                    minHeight: null,             // set minimum height of editor
                    maxHeight: null,             // set maximum height of editor
                    focus: false                 // set focus to editable area after initializing summernote
                });

                $('.inline-editor').summernote({
                    airMode: true
                });

            });
        </script>
		
		   <script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').dataTable();
                $('#datatable-keytable').DataTable({keys: true});
                $('#datatable-responsive').DataTable();
                $('#datatable-colvid').DataTable({
                    "dom": 'C<"clear">lfrtip',
                    "colVis": {
                        "buttonText": "Change columns"
                    }
                });
                $('#datatable-scroller').DataTable({
                    ajax: "../plugins/datatables/json/scroller-demo.json",
                    deferRender: true,
                    scrollY: 380,
                    scrollCollapse: true,
                    scroller: true
                });
                var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
            });
            TableManageButtons.init();

        </script>
		
		
    </body>
</html>