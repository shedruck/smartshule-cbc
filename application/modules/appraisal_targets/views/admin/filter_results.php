<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Appraisal Results for  </h2>
             <div class="right">  

			 
			 <?php echo anchor( 'admin/appraisal_targets' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?> 
             <button class="btn btn-primary"  onClick="window.location='<?php echo base_url()?>admin/appraisal_targets/appraise'" ><i class="glyphicon glyphicon-check"></i>Appraise</button>
            
			 <button class="btn btn-primary"  onClick="window.location='<?php echo base_url()?>admin/appraisal_targets/appraisalResults'" ><i class="glyphicon glyphicon-check"></i>Appraisal Results</button>
			
			</div>
                </div>
         	                    
              
                 <?php if ($results): ?>
                 <div class="block-fluid ">
                
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	    <thead>
                <th>#</th>
				<th>Period</th>
				<th>Target</th>
				<th>Teacher</th>	
				<th>Score (Appraiser)</th>	
				<th>Score (Appraisee)</th>	
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
					<td><?php echo ucfirst($p->first_name.' '.$p->last_name)?></td>
					<td><?php echo $p->rate. ' <small>('.$score.')</small>'?></td>
					<td><?php echo $p->appraisee_rate. ' <small>('.$appraisee_ratee.')</small>'?></td>

			       
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>



<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>