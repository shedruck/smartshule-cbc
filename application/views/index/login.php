

<?php $settings = $this->ion_auth->settings(); ?>


<div class="loginbox shadow-md grow">
						<div class="login-left">
							 <img  src="<?php echo base_url('uploads/files/' . $settings->document); ?>" style="border-radius:20%" class="center lg text-center"  width="150" height="150" />
								<h5 class="text-center"><?php echo $settings->school; ?></h5>
								
							
								<?php
								if (!empty($settings->tel))
								{
										echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' ' . $settings->cell;
								}
								else
								{
										echo $settings->postal_addr . ' Cell:' . $settings->cell;
								}
								?>
								<br>
								<?php echo $settings->email; ?>
								</span>
								<br> 
								<br> 
								<h6 class="sub-title">SCHOOL MOTTO</h6>
								<?php echo $settings->motto; ?>
					
						</div>
						<div class="login-right">
							<div class="login-right-wrap">
								<h1>Login</h1>
								<p class="account-subtitle">Access to your portal</p>
								 
								   <?php
										$str = is_array($message) ? $message['text'] : $message;
										if (isset($message['type']))
										{
												if ($message['type'] == 'error')
												{
														$message['type'] = 'danger';
												}
												echo (isset($message) && !empty($message)) ? '
												<div class="alert alert-' . $message['type'] . '"> 
												<button type="button" class="close" data-dismiss="alert">
													<i class="glyphicon glyphicon-remove"></i>
												</button> ' . $str . '   
											  </div>' : '';
										}
										else
										{
												echo (isset($message) && !empty($message)) ? '
												<div class="alert alert-danger"> 
												<button type="button" class="close" data-dismiss="alert">
													<i class="glyphicon glyphicon-remove"></i>
												</button> ' . $str . '   
											</div>' : '';
										}
										?> 
				
								
								<!-- Form -->
								 <?php echo form_open(current_url(), 'id="register-form" '); ?> 
									<div class="form-group">
										<input class="form-control" type="text" name="email" placeholder="Email">
									</div>
									<div class="form-group">
										<input class="form-control" name="password" type="password" placeholder="Password">
									</div>
									<div class="form-group">
										<button class="btn btn-theme button-1 text-white ctm-border-radius btn-block" type="submit">Login</button>
									</div>
							  <?php echo form_close(); ?>
								<!-- /Form -->
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
								<div class="text-center forgotpass"><a href="<?php base_url()?>index/forgotPassword">Forgot Password?</a></div>
								
								
								
								
							
							</div>
						</div>
					</div>
					
