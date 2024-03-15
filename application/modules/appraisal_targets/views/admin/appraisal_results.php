<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Appraisal Results (General)  </h2>
             <div class="right">  

			 
			 <?php echo anchor( 'admin/appraisal_targets' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Appraisal Targets')), 'class="btn btn-primary"');?> 
             <!-- <button class="btn btn-primary"  onClick="window.location='<?php echo base_url()?>admin/appraisal_targets/appraise'" ><i class="glyphicon glyphicon-check"></i>Appraise</button> -->
            
			 <button class="btn btn-primary"  onClick="window.location='<?php echo base_url()?>admin/appraisal_targets/appraisalResults'" ><i class="glyphicon glyphicon-check"></i>Appraisal Results</button>
			
			</div>
                </div>
         	                    
              
                 <?php if ($results): ?>
                 <div class="block-fluid ">
                 <div class="col-md-12">
						 <form method="post" action="<?php echo base_url('admin/appraisal_targets/filterByTeacher')?>">
						 	<div class="form-group col-md-4">
								 <select class="select select-2" name="teacher">
									 <option>Filter By Teacher</option>
									 <?php foreach($teachers as $teacher){?>
                                        <option value="<?php echo $teacher->teacher?>"><?php echo ucfirst($teacher->first_name. ' '.$teacher->last_name)?></option>
                                        <?php } ?>
								 </select>
								 <button name="filter_by_class" class="btn btn-sm btn-primary">Submit</button>
							 </div>
						 </form>

						 <div class="col-md-4"></div>
						 <div class="col-md-4">
							 <button id="refresh" onClick="refreshResults()" class='btn btn-sm btn-info'><i class="glyphicon glyphicon-refresh"></i></button>
							</div>
					 </div>
					 
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
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
					<td id="td<?php echo $i?>"><?php echo $p->rate. ' <small>('.$score.')</small>'?>
					<div id="appInput<?php echo $i?>" hidden>
						<input type="hidden" value="<?php echo $p->appraisal_id?>" id="appraisal_id<?php echo $i?>">
						<input type="text"  placeholder="rate" id="rate<?php echo $i?>">
						<button id="submitBtn<?php echo $i?>" class="btn btn-sm btn-success">Rate</button>
					</div>
					<?php
						if($p->rate==""){
					?>
					 <button class="btn btn-sm btn-primary" id="appBtn<?php echo $i?>"><i class="glyphicon glyphicon-check"></i></button>
					<?php }?>
					</td>
					<td><?php echo $p->appraisee_rate. ' <small>('.$appraisee_ratee.')</small>'?></td>

			       
				</tr>
				<script>
					$(document).ready(function(){
						$("#appBtn<?php echo $i?>").click(function(){ 
							$("#appBtn<?php echo $i?>").fadeOut("slow");        
							$("#appInput<?php echo $i?>").fadeToggle("slow");
							
							// $("#addMeeting").fadeOut(); 

						});
					});

						$(function(){
								$(document).on('click', '#submitBtn<?php echo $i?>', function(){
									var conn= confirm("Are you sure you want to appraise the selected teacher?");
									if(conn==true){
										var appraisal_id = $('#appraisal_id<?php echo $i?>').val();
										var rate = $('#rate<?php echo $i?>').val();
										if(rate >5){
											alert('Enter A number equal or less than 5')
										}else{
											$.ajax({
												type: 'POST',
												url: '<?php echo base_url("admin/appraisal_targets/appraiseTeacher")?>',
												data: {'appraisal_id':appraisal_id,'rate':rate},
												// dataType: 'json',
												success: function(data){
													alert(data);
													$("#td<?php echo $i?>").load(" #td<?php echo $i?> > *");
													if(data=="success"){
														$ele.fadeOut().remove();
														alert('Success');
														$(".fpTable").load(" .fpTable > *");
													}else{
														alert('Failed ');
													}
												}
											})
											$("#submitBtn<?php echo $i?>").fadeOut("slow");   
										}
									}
								});
						});

						function refreshResults(){
							$(".fpTable").html('<center>Loading...</center>');
							var checkEvents= window.setTimeout(function (){
								$(".fpTable").load(" .fpTable > *");
							},800);
						}

				</script>

 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>
<style>
	#refresh{
		float:right;
	}
</style>
<!-- <script>
	$(document).ready(function(){
    $("#appBtn").click(function(){        
        // $("#appBtn").fadeToggle("slow");
        $("#appBtn").fadeOut("slow"); 
        // $("#addMeeting").fadeOut(); 

    });
});
</script> -->



<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>