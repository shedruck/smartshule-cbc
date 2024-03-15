<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">Newsletters</h4>
							  </div>		
							
						</div>
								
		<div class="col-sm-12">
            
		  <br>
					
					 <?php if ($newsletters): ?>              
							<div class="row people-grid-row">

							
										<?php
										$i = 0;
									

										foreach ($newsletters as $p):

												$i++;
												?>
												
									<div class="col-md-4 col-lg-4 col-xl-4">
											<div class="card widget-profile">
												<div class="card-body">
													<div class="pro-widget-content text-center">
														<div class="profile-info-widget">
															<a href="<?php echo base_url()?>uploads/files/<?php echo $p->file?>" class="booking-doc-img">
																 <iframe src="<?php echo base_url()?>uploads/files/<?php echo $p->file?>" class="newsletter"></iframe>
															</a>
															<div class="profile-det-info bg-black">
																<h4 class="text-white"><a target="_blank" href="<?php echo base_url()?>uploads/files/<?php echo $p->file?>" class="text-primary"><?php echo $p->title;?></a></h4>
																<div>
																	<p class="mb-0"><a target="_blank" href="<?php echo base_url()?>uploads/files/<?php echo $p->file?>" class="text-primary"><i class="fa fa-caret-right"></i> Read More</a></p>
																	
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
												
							<?php endforeach ?>
								
							</div>
							
							<?php else: ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
					   <?php endif ?>
					   


			</div>
		</div>
    <p>&nbsp;</p>

</div>
</div>

<style>
    .newsletter{
        border-radius:10,0,10,0;
        border:pink solid 2px;
        height:250px;
        display:inline-block;
        width:100%
    }
</style>