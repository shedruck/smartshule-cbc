<div class="row">
    <div class="col-md-12">
        <div class="card recent-operations-card">
            <div class="card-block">  
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <h4 class="m-b-10"> Final Exams Certificates   </h4>
                            </div>
                            <div class="col-md-7">
                              
                            </div>
                        </div>
                    </div>
                </div>
				<hr>


         	                    
<div class="row"> 	 
<div class="col-sm-4"> 	 
 <div class="block-fluid">
 <div class="col-sm-11"> 	 
       <p class="font-15"><b>Student</b>: <?php   $student=$this->ion_auth->students_full_details();    echo $student[$p->student]?></p>
       <p class="font-15"><b>Type</b>: <?php echo $p->certificate_type?></p>
       <p class="font-15"><b>Serial Number</b>: <?php echo $p->serial_number?></p>
       <p class="font-15"><b>Mean Grade</b>: <?php echo $p->mean_grade?></p>
       <p class="font-15"><b>Points</b>: <?php echo $p->points?></p>
</div>	
			 <?php if ($grades): ?>
			
		  <table class="table table-striped table-bordered"> 
					<thead>
						<th>#</th>
						<th>Subject</th>
						<th>Grade</th>
						
				</thead>
				<tbody>
				<?php 
					 $i = 0;
					foreach ($grades as $g ): 
						 $i++;
				  ?>
				  <tr>
					<td><?php echo $i . '.'; ?></td>					
					<td><?php echo $g->subject;?></td>
					<td><?php echo $g->grade;?></td>
					
				</tr>
					<?php endforeach ?>
				</tbody>

			</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 
 </div>
 
 <div class="col-sm-8"> 
<div class="block-fluid">
				<?php 
				
					if($p->certificate){
					 ?>
					  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>">
					  <embed src="<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>" width="100%" height="850" class="tr_all_hover" type='application/pdf'>
					  </a>
					  
					  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>"><i class="fa fa-download"></i> Download File</a>
					  <br>
					 <?php }else{ ?>  
						<h5> No letter uploaded at the moment</h5>
					 <?php } ?> 
 
 </div>
 </div>
 </div>
 </div>
 </div>