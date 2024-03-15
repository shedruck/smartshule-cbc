	<div class="row">
			<div class="col-md-8 d-flex">
                    <div class="mdk-drawer-layout__content"
                         data-perfect-scrollbar>

                        <div class="app-messages__container d-flex flex-column h-100 pb-4">
						
						  <div class="card">
								<div class="card-body d-flex align-items-center">
									<div class="mr-3">
										<div class="avatar avatar-xl">
											<span class="avatar-title rounded-circle">TITLE</span>
										</div>
									</div>
									<div class="flex">
										<h4 class="mb-0"><?php echo $message->title ?></h4>
										<p class="text-50 mb-0">Posted On <?php echo date('d M Y',$message->created_on) ?></p>
									</div>
								</div>
							</div>
                          
                            <div class="flex pt-4"
                                 style="position: relative;"
                                 data-perfect-scrollbar>
                                <div class="container page__container page__container">
                                  
                                    <ul class="d-flex flex-column list-unstyled"
                                        id="messages">
                         <?php
								foreach ($message->items as $m)
								{
									
							?>
							
							<?php if($m->from=='Me'){?>
                                        <li class="message d-inline-flex pull-left">
                                            <div class="message__aside bg-red">
												<?php
													$u = $this->ion_auth->get_user();
													$user = $this->ion_auth->parent_profile($u->id);
													?> 
                                                <a href="#" class="avatar avatar-sm " style="background-color:red !important; color:#fff">
												   <span class="avatar-title rounded-circle bg-red" ><?php echo substr($u->first_name,0,1); ?></span>
                                                </a>
                                            </div>
                                            <div class="message__body card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex mr-3">
                                                            <a href="fixed-profile.html"
                                                               class="text-body"><strong><?php echo $m->from; ?></strong></a>
                                                        </div>
                                                        <div>
                                                            <small class="text-50"><?php echo $m->created_on > 10000 ? date('jS M Y H:i', $m->created_on) : ' - '; ?></small>
                                                        </div>
                                                    </div>
                                                    <span class="text-70"><?php echo $m->message; ?></span>

                                                </div>
                                            </div>
                                        </li>
							<?php }else{?>
                                        <li class="message d-inline-flex pull-right">
                                            <div class="message__aside">
                                                <a href="#"
                                                   class="avatar avatar-sm">
                                                  <span class="avatar-title rounded-circle"><?php echo substr($m->from,0,1); ?></span>
                                                </a>
                                            </div>
                                            <div class="message__body card">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex mr-3">
                                                            <a href="fixed-profile.html"
                                                               class="text-body"><strong><?php echo $m->from; ?></strong></a>
                                                        </div>
                                                        <div>
                                                            <small class="text-50"><?php echo $m->created_on > 10000 ? date('jS M Y H:i', $m->created_on) : ' - '; ?></small>
                                                        </div>
                                                    </div>
                                                    <span class="text-70"><?php echo $m->message; ?></span>

                                                </div>
                                            </div>
                                        </li>

                                  	<?php } ?>     
                                  	<?php } ?>     
                                    </ul>
                                </div>
                            </div>
                            <div class="container page__container page__container">
                               <?php
							$attributes = array('class' => 'form-horizontal', 'id' => '');
							echo form_open_multipart(current_url(), $attributes);
							?>
							<?php echo form_error('message'); ?>
                                 <label>
                                                        Type message here..
                                                    </label>
                                    <div class="input-group input-group-merge">
									 
                                       <textarea type="text" name="message" rows="2" class="form-control" placeholder="Your message here..."> </textarea>
                                        <div class="input-group-append ">
                                            
                                            <div class="input-group-text pl-0 bg-red">
                                                <div class="custom-file custom-file-naked d-flex"
                                                     style="width: 24px; overflow: hidden;">
                                                    <input type="submit"
                                                           class="custom-file-input"
                                                           id="customFile">
                                                    <label class="custom-file-label"
                                                           style="color: #fff; font-size:18px;"
                                                           for="customFile">
                                                        <i class="fa fa-paper-plane"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               <?php echo form_close(); ?>
                            </div>
							
							
                        </div>
                    </div>
					
					
					
              </div>
			  
			  <div class="col-md-4 card">
			  
			   <?php if ($feed): ?>              
							 <div class="table-responsive"
                                 data-toggle="lists"
                                 data-lists-sort-by="js-lists-values-from"
                                 data-lists-sort-desc="true"
                                 data-lists-values='["js-lists-values-name", "js-lists-values-status", "js-lists-values-policy", "js-lists-values-reason", "js-lists-values-days", "js-lists-values-available", "js-lists-values-from", "js-lists-values-to"]'>

                                <table class="table mb-0 thead-border-top-0 table-nowrap">

									<thead> 
									 <th style="width: 18px;"
										class="pr-0">
										<div class="custom-control custom-checkbox">
											<input type="checkbox"
												   class="custom-control-input js-toggle-check-all"
												   data-target="#leaves"
												   id="customCheckAll">
											<label class="custom-control-label"
												   for="customCheckAll"><span class="text-hide">Toggle all</span></label>
										</div>
									</th>
									<th>MESSAGES</th>
									
									
									<th></th>
								
									</thead>
									<tbody>
										<?php
										$i = 0;
										

										foreach ($feed as $m):

												$i++;
												?>
												<tr>
													<td class="pr-0">
														<div class="custom-control custom-checkbox">
															<input type="checkbox"
																   class="custom-control-input js-check-selected-row"
																   id="customCheck1_1">
															<label class="custom-control-label"
																   for="customCheck1_1"><span class="text-hide">Check</span></label>
														</div>
													</td>					
													<td> 
															<a href="<?php echo base_url('messages/view/' . $m->id); ?>">
															<p class="title"><?php echo $m->title; ?></p>
															</a>
													</td>
												
													<td >
													 <a href="<?php echo base_url('messages/view/' . $m->id); ?>"  class="btn btn-sm btn-outline-primary">
															<span class="fa fa-folder-open"></span> &nbsp; View 
														</a>
								
													</td>


												</tr>
										
	
							<?php endforeach ?>
									</tbody>

								</table>
							</div>
							
							<?php else: ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
					   <?php endif ?>
					   <p>&nbsp;</p>
					   
					   
			  </div>
         </div>
                  
