<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Registration Details  </h2>
             <div class="right">  
             
                </div>
                </div>
         	                    
              
                 <?php if ($registration_details): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Registration No</th>
				<th>Date Reg</th>
				<th>Institution Category</th>
				<th>Institution Cluster</th>
				<th>Location</th>
				<th>Institution Type</th>
				<th>Education Level</th>
				<th>KNEC Code</th>
				<th>Scholars Gender</th>
				<th>KRA Pin</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
            $counties = $this->portal_m->populate('counties','id','name');    
            foreach ($registration_details as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->registration_no;?></td>
					<td><?php echo date('d M Y',$p->date_reg);?></td>
					<td><?php echo $p->institution_category;?></td>
					<td><?php echo $p->institution_cluster;?></td>
					<td>
						<span class="glyphicon glyphicon-ok"></span> <?php echo $counties[$p->county];?><br>
						<span class="glyphicon glyphicon-ok"></span> <?php echo $p->sub_county;?><br>
						<span class="glyphicon glyphicon-ok"></span> <?php echo $p->ward;?>
					</td>
					<td>
					<span class="glyphicon glyphicon-ok"></span> <?php echo $p->institution_type;?><br>
					<span class="glyphicon glyphicon-ok"></span> <?php echo $p->education_system;?>
					</td>
					<td><?php echo $p->education_level;?></td>
					<td><?php echo $p->knec_code;?></td>
					<td>
					<span class="glyphicon glyphicon-ok"></span> <?php echo $p->institution_accommodation;?><br> 
					<span class="glyphicon glyphicon-ok"></span> <?php echo $p->scholars_gender;?><br>
					<span class="glyphicon glyphicon-ok"></span> <?php echo $p->locality;?>
					</td>
					<td><?php echo $p->kra_pin;?></td>

			 <td width='30'>
						 <div class='btn-group'>
						 
						 <a  class='btn btn-success' href='<?php echo site_url('admin/registration_details/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
						 
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