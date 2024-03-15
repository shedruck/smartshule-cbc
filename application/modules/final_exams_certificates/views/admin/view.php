<div class="col-sm-12"> 
<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Final Exams Certificates  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/final_exams_certificates/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Final Exams Certificates')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/final_exams_certificates' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Final Exams Certificates')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
           </div>
         	                    
	<div class="col-sm-4"> 	 
 <div class="block-fluid">
 <div class="col-sm-11"> 	 
       <p><b>Student</b>: <?php   $student=$this->ion_auth->students_full_details();    echo $student[$p->student]?></p>
       <p><b>Type</b>: <?php echo $p->certificate_type?></p>
       <p><b>Serial Number</b>: <?php echo $p->serial_number?></p>
       <p><b>Mean Grade</b>: <?php echo $p->mean_grade?></p>
       <p><b>Points</b>: <?php echo $p->points?></p>
</div>	
			 <?php if ($grades): ?>
			
			<table cellpadding="0" cellspacing="0" width="100%">
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
					  
					  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>"><i class="glyphicon glyphicon-download"></i> Download File</a>
					  <br>
					 <?php }else{ ?>  
						<h5> No letter uploaded at the moment</h5>
					 <?php } ?> 
 
 </div>
 </div>