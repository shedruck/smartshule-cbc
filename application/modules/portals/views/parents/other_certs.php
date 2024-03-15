
         	                    
 <div class="card flex-fill ctm-border-radius shadow-sm grow">             
	 <?php if ($nx): ?>
		<div class="table-responsive">
		<table class="table bordered" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Uploaded On</th>
				<th>Student</th>
				<th>Title</th>
				<th>Certificate No</th>
				<th>Certificate</th>
				<th>Description</th>
				
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                             
              foreach($nx as $re){
								
								foreach($re as $p){
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo date('d M Y',$p->created_on);?></td>
					<td><?php $students=$this->ion_auth->students_full_details(); echo $students[$p->student];?></td>
				<td><?php echo $p->title;?></td>
			
			
				<td><?php echo $p->certificate_number;?></td>
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' /> <i class=" glyphicon glyphicon-download"></i>  Download Cert</a></td>
				<td><?php echo $p->description;?></td>

			
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