<div class="row1 " id="x-acts">
				<div class="card shadow-sm ctm-border-radius grow">

			
				<div class="employee-office-table">
					<div class="table-responsive1">
							<div class="card-header d-flex align-items-center justify-content-between">
							
							  <div class="col-sm-12">
									<h3 class="card-title mb-0 d-inline-block">Appraisal Results</h3>
							  </div>		
							
						</div>
								
		<div class="col-sm-12">
            
		  <br>
					
					 <?php if ($results): ?>              
							<div class="row people-grid-row">

							<table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                        <th>#</th>
                                        <th>Period</th>
                                        <th>Target</th>
                                        <th>Appraiser</th>
                                        <th>Appraisee</th>	
                                        <th>Score(Appraiser)</th>	
                                        <th>Score(Appraisee)</th>	
                                </thead>
                                <tbody>
                                <?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($results as $p ): 
				$rate=$p->rate;
                if($rate ==5){
                    $score= "<span class='text-success'>Strongly Agree</span>";
                }elseif($rate ==4){
                    $score ="<span class='text-primary'>Agree</span>";
                }elseif($rate ==3){
                    $score= "<span class='text-secondary'>Uncertain</span>";
                }elseif($rate ==2){
                    $score = "<span class='text-warning'>Disagree</span>";
                }elseif($rate ==1){
                    $score= "<Span class='text-danger'>Strongly Disagree</span>";
                }else{
                    $score= "<span class='text-muted'>INVALID DATA!</span>";
                }

				if($p->created_by ==1){
					$appraiser='Admin User';
				}else{
					$appraiser= 'Self';
				}

				if($p->appraisee_rate==""){
					$appraisee_ratee='Null';
				}else{
                    if($p->appraisee_rate==5){
					    $appraisee_ratee="<span class='text-success'>Strongly Agree</span>";
                    }elseif($p->appraisee_rate==4){
                        $appraisee_ratee ="<span class='text-primary'>Agree</span>";
                    }elseif($p->appraisee_rate==3){
                        $appraisee_ratee= "<span class='text-secondary'>Uncertain</span>";
                    }elseif($p->appraisee_rate==2){
                        $appraisee_ratee = "<span class='text-warning'>Disagree</span>";
                    }elseif($p->appraisee_rate==1){
                        $appraisee_ratee= "<Span class='text-danger'>Strongly Disagree</span>";
                    }else{
                        $appraisee_ratee= "<span class='text-muted'>INVALID DATA!</span>";
                    }
				}
			
                 $i++;
                     ?>
					
	            <tr>
                    <td><?php echo $i . '.'; ?></td>					
                    <td><?php echo ucfirst($p->term.', '.$p->year)?></td>
					<td><?php echo $p->target;?></td>
					<td><?php echo $appraiser;?></td>
					<td><?php echo ucfirst($p->first_name.' '.$p->last_name)?></td>
					<td><?php echo $p->rate. ' <small>('.$score.')</small>'?></td>
					<td><?php echo $p->appraisee_rate. ' <small>('.$appraisee_ratee.')</small>'?></td>

			       
				</tr>
 			<?php endforeach ?>
		</tbody>
								
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