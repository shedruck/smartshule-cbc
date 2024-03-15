<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h4 class="card-title mb-0 d-inline-block">Self Appraisal</h4>
                                    <button class="btn btn-sm btn-primary" id="appraisebtn">Begin Self Appraisal</button>
                                    <!-- <button class="btn btn-sm btn-primary"data-toggle="modal" data-target="#myModal">Begin Self Appraisal</button> -->

									<div id="targets" hidden>
										<h2>Targets</h2>
										<button class="btn btn-danger close" id="collapseappraisal">Collapse</button>
										<hr>
										
										<?php
										if($targets)
										foreach($targets as $target){
											$date_started=date_create($target->start_date);
											$start_date= date_format($date_started, "d/M/Y");

											$ending_date= date_create($target->end_date);
											$end_date= date_format($ending_date,"d/M/Y");

										?>
										<div class="col-lg-3 col-md-6">
											<a href="<?php echo base_url('trs/selfAppraisal/'.$target->id); ?>">
												<div class="card-box widget-box-two widget-two-purple">
													<i class=" mdi mdi-table-edit widget-two-icon"></i>
													<div class="wigdet-two-content">
														<p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today"><?php echo $target->target?></p>
														<h2><span data-plugin="counterup">
														<small><i class="text-success">From</i> <?php echo $start_date?></small> -
														</span> <small><i class="mdi mdi-calender text-success"></i></small></h2>
														<i>To</i> <p class="text-success m-0"><b><?php echo $end_date?></b> </p>
													</div>
												</div>
											</a>
										 </div>
										<?php }?>
									</div>
							  </div>

							
						</div>
								
		<div class="col-sm-12" id="report">
            
		  <br>
					
					 <?php if ($years): ?>  
                        <fieldset>     
                            <legend>Appraisal Reports</legend>  
                            <h6>Please Select the year</h6>

							<div class="row people-grid-row">

							
										<?php
										$i = 0;
									

										foreach ($years as $year):

												$i++;
												?>
												
									<div class="col-md-2">
                                        <img src="<?php echo base_url()?>/assets/uploads/folder.png" style="width:100%"
                                        onClick="window.location='<?php echo base_url()?>trs/appraisalResult/<?php echo $year->year?>'"
                                        >
                                        <center><strong><?php echo $year->year?></strong></center>
                                    </div>
										
												
							<?php endforeach ?>
								
							</div>
                        </fieldset>
							
							<?php else: ?>
							<p class='text'><?php echo lang('web_no_elements'); ?></p>
					   <?php endif ?>
					   


			</div>
		</div>
    <p>&nbsp;</p>

</div>
</div>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Self Appraisal Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	 
		  <?php echo form_open(current_url())?>
		  <?php
		 	foreach($teacher as $mwalimu){
		  ?>
		  <input type="hidden" name="teacher" value="<?php echo $mwalimu->id?>">

		  <?php }?>
				
      <table class="table table-condensed">
                        <thead>
							<tr class="bg-gradient-secondary">
								<th colspan="2" class=" p-1"><b>Targets</b></th>
								<th class="text-center">1</th>
								<th class="text-center">2</th>
								<th class="text-center">3</th>
								<th class="text-center">4</th>
								<th class="text-center">5</th>
							</tr>
						</thead>
                        <tbody class="tr-sortable">
                        <?php 
                        $index=1;
                        foreach($targets as $target){?>
							<tr class="bg-white">

                                <td class="p-1 text-center" width="5px"><?php echo $index;?></td>
									
								<td class="p-1" width="40%">
									<?php echo $target->target ?>
									<input type="hidden" name="target_id[]" value="<?php echo $target->id ?>">
								</td>
								<?php for($c=0;$c<5;$c++): ?>
								<td class="text-center">
									<div class="icheck-success d-inline">
				                        <input type="radio" name="rate[<?php echo $target->id?>]" id="<?php echo $c+1?>" value="<?php echo $c+1?>">
				                        <label>
				                        </label>
			                      </div>
								</td>
								<?php endfor; ?>
							</tr>
                            <?php $index++; }?>
                            <tr>
                                <td colspan="7" >
                                    <button style="float:right" class="btn btn-sm btn-success">Save</button>
                                </td>
                            </tr>
						</tbody>
                    </table>
					<?php echo form_close()?>
					
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		// $("collapseappraisal").fadeOut("slow"); 

		$("#appraisebtn").click(function(){ 
			$("appraisebtn").hide("slow");        
			$("#targets").show("slow");
			$("#report").hide("slow");
			$("#collapseappraisal").show("slow");
		});
		
		$("#collapseappraisal").click(function(){ 
			$("collapseappraisal").hide("slow");        
			$("appraisebtn").show("slow");        
			$("#targets").hide("slow");
			$("#report").show("slow");
		});

	});
</script>
<style>
    .newsletter{
        border-radius:10,0,10,0;
        border:pink solid 2px;
        height:250px;
        display:inline-block;
        width:100%
    }
</style>