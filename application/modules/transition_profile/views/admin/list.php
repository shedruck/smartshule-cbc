<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Transition Profile  </h2>
             <div class="right">  
          
             
                </div>
                </div>
         	                    
              
                 <?php if ($transition_profile): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 			<thead>
                	<th>#</th>
                	<th>Class</th>
                	<th>Class Teacher</th>
                	<th>Population</th>
                	<th ><?php echo lang('web_options');?></th>
				</thead>
				<tbody>
					<?php
						$index = 1;
						foreach($transition_profile as $t){
							$cl = isset($class[$t->class]) ? $class[$t->class] : '-';
		                    $name = $cl['name'];
		                    $size = $cl['size'];
		                    $class_tt = isset($class_t[$t->class]) ? $class_t[$t->class] : '-';
					?>
				<tr>
				 	<td><?php echo $index ?></td>
				 	<td><?php echo $name ?></td>
				 	<td><?php echo $class_tt?></td>
				 	<td><?php echo $size?></td>
				 	<td>
				 		<a href="<?php echo base_url('admin/transition_profile/report/'.$t->class.'')?>" class="btn btn-primary">View</a>
				 	</td>

				 		 
				</tr>
			<?php $index++; }?>
 			 
		</tbody>

	</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>