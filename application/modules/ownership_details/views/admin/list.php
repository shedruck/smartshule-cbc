<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Ownership Details  </h2>
             <div class="right">  
           
                </div>
                </div>
         	                    
              
                 <?php if ($ownership_details): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Ownership</th>
				<th>Proprietor</th>
				<th>Ownership Type</th>
				<th>Certificate No</th>
				<th>Town</th>
				<th>Police Station</th>
				<th>Health Facility</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($ownership_details as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					<td><?php echo $p->ownership;?></td>
					<td><?php echo $p->proprietor;?></td>
					<td><?php echo $p->ownership_type;?></td>
					<td><?php echo $p->certificate_no;?></td>
					<td><?php echo $p->town;?></td>
					<td><?php echo $p->police_station;?></td>
					<td><?php echo $p->health_facility;?></td>

			 <td width='30'>
						 <div class='btn-group'>
						 
						 <a  class='btn btn-success' href='<?php echo site_url('admin/ownership_details/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
						 
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>