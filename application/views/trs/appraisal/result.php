<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">Appraisal Reports</h4>
                                    <h6>Select Term</h6>
							  </div>		
							
						</div>
								
		<div class="col-sm-12">
            
		  <br>
					
					 <?php if ($terms): ?>              
							<div class="row people-grid-row">

							
										<?php
										$i = 0;
                                            $year= $this->uri->segment(3);

										foreach ($terms as $term):

												$i++;
												?>
												
									<div class="col-md-2">
                                        <img src="<?php echo base_url()?>/assets/uploads/file.png" style="width:100%"
                                        onClick="window.location='<?php echo base_url()?>trs/appraisalResults/<?php echo $year?>/<?php echo $term->term?>'"
                                        >
                                        <center><strong><?php echo ucfirst($term->term)?></strong></center>
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