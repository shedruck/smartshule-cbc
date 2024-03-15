  <?php $settings = $this->ion_auth->settings(); ?>
 
 <div class="mdk-drawer js-mdk-drawer" id="default-drawer1">
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

                        <a href="<?php echo base_url()?>" class="sidebar-brand">
						   
                            <img width="60" src="<?php echo base_url('uploads/files/' . $settings->document); ?>" alt="SCHOOL LOGO">
                            <small><?php echo $settings->school; ?></small>
                        </a>

                        <div class="sidebar-account mx-16pt mb-16pt dropdown">
                            <a href="<?php echo base_url('portals/parents/mpesa_payment')?>"
                               class="nav-link d-flex align-items-center " >
                                <img width="32"
                                     height="32"
                                     class="rounded-circle mr-8pt"
                                     src="<?php echo base_url('assets/default/images/ss/mpesa.png')?>"
                                     alt="account" />
                                <span class="flex d-flex flex-column mr-8pt">
                                   
                                    <small class="text-black-60">PAY VIA M-PESA</small>
                                </span>
                                <i class="material-icons text-black-20 icon-16pt">keyboard_arrow_down</i>
                            </a>
                            
                        </div>

                        <div class="sidebar-heading">NAVIGATION MENU</div>
                        <ul class="sidebar-menu">
                            <li class="sidebar-menu-item active">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url();?>">
                                    <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">insert_chart_outlined</span>
                                    <span class="sidebar-menu-text">DASHBOARD</span>
                                </a>
                            </li>
							
							<li class="sidebar-menu-item">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('fee_payment/fee');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">card_giftcard</span>
                                    <span class="sidebar-menu-text">FINANCE</span>
                                </a>

                            </li>
							
							
							<li class="sidebar-menu-item">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('fee_payment/fee');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">view_compact</span>
                                    <span class="sidebar-menu-text">ACADEMICS</span>
                                </a>
                            </li>
							
							<li class="sidebar-menu-item">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('fee_payment/fee');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">tune</span>
                                    <span class="sidebar-menu-text">COMMUNICATION</span>
                                </a>
                            </li>
							
							<li class="sidebar-menu-item">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('fee_payment/fee');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">people_outline</span>
                                    <span class="sidebar-menu-text">STUDENT(S) PROFILE</span>
                                </a>
                            </li>
							
							<li class="sidebar-menu-item">
                                <a class="sidebar-menu-button"
                                   href="<?php echo base_url('fee_payment/fee');?>">
                                   <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">link</span>
                                    <span class="sidebar-menu-text">MY PROFILE</span>
                                </a>
                            </li>
							
                        </ul>

                     
                    </div>
                </div>
            </div>
			
			
