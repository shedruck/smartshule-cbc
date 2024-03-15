<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Visitors Book  </h2>
            	
             <div class="right">  
             	
             <a href="<?php echo base_url('admin/visitors_book_cat')?>" class="btn btn-warning">Manage Category</a>
             <?php echo anchor( 'admin/vistors_book/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Vistors Book')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/vistors_book' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Vistors Book')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	              	
              
                 <?php if ($vistors_book): ?>

                 <div class="block-fluid">
                 		<?php echo form_open(current_url())?>
                 	    	<?php echo form_dropdown('category', array('' => 'Select Type here') + $category, $this->input->post('category'), 'class ="select select-2" '); ?>
                 	    	<button class="btn btn-success" type="submit">Filter By Category</button>
                 	    	<?php echo form_close();?>  

				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
					 <thead>
			                <th>#</th>
			                <th>Visitor's Name</th>
			                <th>Phone</th>
			                <th>Email</th>
			                <th>Person To see</th>
			                <th>Type/Reason</th>
			                <th>Checkin</th>
			                <th>Checkout</th>
			                <th ><?php echo lang('web_options');?></th>
						</thead>
						<?php
							if(!$this->input->post('category')){
						?>
						<tbody>
							<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }

				            foreach ($vistors_book as $p ): 
				            	$user = $this->ion_auth->get_user($p->created_by);
				            	$userr = $this->ion_auth->get_user($p->modified_by);
				            	$st = [
				            		1 => '<small class="label label-success">Checked In</small>',
				            		3 => '<small class="label label-danger">Checked Out</small>'
				            	];
				            	$status = isset($st[$p->status]) ? $st[$p->status] : '';
				                 $i++;
				                     ?>
					 			<tr>
				                	<td><?php echo $i . '.'; ?></td>					
				                	<td><?php echo $p->name;?><br><?php echo $status?></td>
				                	<td><?php echo $p->phone;?></td>
				                	<td><?php echo $p->email;?></td>
				                	<td><?php echo isset($users[$p->person]) ? $users[$p->person] : '';?></td>
				                	<td><?php echo  isset($category[$p->category]) ? $category[$p->category] : '-';?></td>
				                	<td>
				                		<?php echo date('d M, Y H:m',$p->created_on);?><br>
				                		<small><label class="label label-primary"><?php echo ucwords($user->first_name.' '.$user->last_name)?></label></small>
				                	</td>
				                	<td>
				                		<?php if($p->modified_on == 0){ echo '-';}else{ echo date('d M, Y H:m',$p->modified_on);}?><br>
				                		<small><label class="label label-warning"><?php if($p->modified_by == 0){echo '-';} else{ echo ucwords($user->first_name.' '.$user->last_name);}?></label></small> 
				                		
				                	</td>
							 		<td width='30'>
							 			<?php if($p->status == 1){?>
										  <a href="<?php echo base_url('admin/vistors_book/checkout/'.$p->id.'')?>" class="btn btn-sm btn-success">Checkout <i class="glyphicon glyphicon-arrow-up"></i></a>
										<?php } ?>

										<a href="<?php echo base_url('admin/vistors_book/view/'.$p->id.'')?>"><i class="glyphicon glyphicon-print"></i></a>

									</td>
								</tr>
				 			<?php endforeach ?>
						</tbody>
					<?php } elseif($this->input->post('category'))
							{?>

														<tbody>
															<?php 
								                             $i = 0;
								                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
								                                {
								                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
								                                }

												            foreach ($vistors_book as $p ): 
												            	$user = $this->ion_auth->get_user($p->created_by);
												            	$userr = $this->ion_auth->get_user($p->modified_by);
												            	$st = [
												            		1 => '<small class="label label-success">Checked In</small>',
												            		3 => '<small class="label label-danger">Checked Out</small>'
												            	];
												            	$status = isset($st[$p->status]) ? $st[$p->status] : '';
												                 $i++;
												                     ?>
													 			<tr>
												                	<td><?php echo $i . '.'; ?></td>					
												                	<td><?php echo $p->name;?><br><?php echo $status?></td>
												                	<td><?php echo $p->phone;?></td>
												                	<td><?php echo $p->email;?></td>
												                	<td><?php echo $p->person;?></td>
												                	<td><?php echo  isset($category[$p->category]) ? $category[$p->category] : '-';?></td>
												                	<td>
												                		<?php echo date('d M, Y H:m',$p->created_on);?><br>
												                		<small><label class="label label-primary"><?php echo ucwords($user->first_name.' '.$user->last_name)?></label></small>
												                	</td>
												                	<td>
												                		<?php if($p->modified_on == 0){ echo '-';}else{ echo date('d M, Y H:m',$p->modified_on);}?><br>
												                		<small><label class="label label-warning"><?php if($p->modified_by == 0){echo '-';} else{ echo ucwords($user->first_name.' '.$user->last_name);}?></label></small> 
												                		
												                	</td>
															 		<td width='30'>
															 			<?php if($p->status == 1){?>
																		  <a href="<?php echo base_url('admin/vistors_book/checkout/'.$p->id.'')?>" class="btn btn-sm btn-success">Checkout <i class="glyphicon glyphicon-arrow-up"></i></a>
																		<?php } ?>

																		<a href="<?php echo base_url('admin/vistors_book/view/'.$p->id.'')?>"><i class="glyphicon glyphicon-print"></i></a>

																	</td>
																</tr>
												 			<?php endforeach ?>
														</tbody>
								
							<?php }
						?>

			</table>

	
</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>