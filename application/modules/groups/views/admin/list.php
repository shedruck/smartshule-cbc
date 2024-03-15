
                <div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2>Groups Management</h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/groups/create/'.$page, '<i class="glyphicon glyphicon-plus"></i>'.lang('web_add_t', array(':name' => 'New Group')), 'class="btn btn-primary"');?>
			    <?php echo anchor( 'admin/groups/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			  
             
                     </div>    					
                </div>
				
       
              
                 <?php if ($groups): ?>
               
   <div class="block-fluid">
    <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">


           
	 <thead>
                <th>#</th>
				<th>Name</th>
				<th>Description</th>
				<th><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                                {
                                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                                }
                
            foreach ($groups as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->name;?></td>
			    <td><?php echo $p->description;?></td>
                    <td width="20%">
					<div class="btn-group">
					<a  class="btn btn-primary btn-sm" href="<?php echo site_url('admin/groups/edit/'.$p->id);?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
							
							  
					  <?php if($p->id !=1 && $p->id !=3 && $p->id !=6 && $p->id !=8){?>
					<a class="btn btn-danger btn-sm" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/groups/delete/'.$p->id);?>'><i class="glyphicon glyphicon-trash"></i> Delete</a></li>
					  <?php } ?>
							  
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