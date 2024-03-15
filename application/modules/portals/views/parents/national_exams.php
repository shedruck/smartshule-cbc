
<div class="quicklink-sidebar-menu ctm-border-radius shadow-sm bg-white card grow">
	<div class="card-body">
		<div class="flex-row list-group list-group-horizontal-lg" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			
			<a class="  list-group-item text-center"   href="<?php echo base_url('portals/parents/diary')?>" >Student Diary</a>
			<a class=" list-group-item text-center"  href="<?php echo base_url('portals/parents/results')?>" >Exams Results</a>
			<a class=" list-group-item text-center"  href="<?php echo base_url('portals/parents/assignments')?>" >Class Assignments</a>
			<a class=" list-group-item text-center"  href="<?php echo base_url('portals/parents/class_attendance')?>" >Class Attendance</a>
				<a class="list-group-item text-center " title="Coming Soon"  href="<?php echo base_url('parents/cbc/assessment')?>" >CBC Assessment  </a>
			<a class="active list-group-item text-center"  href="<?php echo base_url('portals/parents/national_exam_cert')?>" >National Exams Cert</a>
			<a class="list-group-item text-center"  href="<?php echo base_url('portals/parents/other_certificates')?>" >Other Certificates</a>

		</div>
	</div>
</div>
         	                    
 <div class="card flex-fill ctm-border-radius shadow-sm grow">             
	 <?php if ($nx): ?>
		<div class="table-responsive">
	<table class="fpTable table bordered" cellpadding="0" cellspacing="0" width="100%">
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
				<td><a target="_blank" href='<?php echo base_url()?>uploads/<?php echo $p->fpath?>/<?php echo $p->certificate?>' />Download file (certificate)</a></td>

			
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