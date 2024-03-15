
         	                    
 <div class="card flex-fill ctm-border-radius shadow-sm grow">  
 <div class="col-sm-12"> <br><h5> National Exam Certificates</h5>   </div> 
	 <?php if ($nx): ?>
		<div class="table-responsive">
			 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
	 <thead>
                <th>#</th>
				<th>Student</th>
				<th>Certificate Type</th>
				<th>Serial Number</th>
				<th>Mean Grade</th>
				<th>Points</th>
				<th>Certificate</th>	
				
		</thead>
		<tbody>
		<?php 
                             $i = 0;
           
          $student=$this->ion_auth->students_full_details();  
  			 
           foreach($nx as $re){
								
								foreach($re as $p){
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $student[$p->student];?></td>
				<td><?php echo $p->certificate_type;?></td>
				<td><?php echo $p->serial_number;?></td>
				<td><?php echo $p->mean_grade;?></td>
				<td><?php echo $p->points;?></td>
				<td><a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' /> <i class="fa fa-download"></i> &nbsp;&nbsp; Download </a></td>

			
				</tr>
				<?php } ?>
			<?php } ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 
 </div>
 
   <div class="card flex-fill ctm-border-radius shadow-sm grow">  
   <div class="col-sm-12"> <br><h5> Other Certificates</h5>   </div>
	 <?php if ($other): ?>
		<div class="table-responsive">
		 <table class="table table-bordered table-flush mb-0 thead-border-top-0 table-nowrap">
	 <thead>
                <th>#</th>
				<th>Date</th>
				<th>Student</th>
				<th>Title</th>
				<th>Certificate No</th>
				<th>Certificate</th>
				<th>Description</th>
				
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                             
              foreach($other as $re){
								
								foreach($re as $p){
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->created_on);?></td>
					<td><?php $students=$this->ion_auth->students_full_details(); echo $students[$p->student];?></td>
				<td><?php echo $p->title;?></td>
			
			
				<td><?php echo $p->certificate_number;?></td>
				<td><a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /> <i class=" glyphicon glyphicon-download"></i>  Download </a></td>
				<td><?php echo $p->description;?></td>

			
				</tr>
				<?php } ?>
			<?php } ?>
		</tbody>

	</table>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
	
</div>
</div>
 
 
 
 
 
 
 
 
 
 