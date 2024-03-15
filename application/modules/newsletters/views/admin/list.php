<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Newsletters  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/newsletters/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Newsletters')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/newsletters' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Newsletters')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($newsletters): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>File</th>
				<th>Description</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
			 $i = 0;
				if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
				{
					$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
				}
                
            foreach ($newsletters as $p ): 
				if($p->status ==0){
					$status='<span class="btn-success">Open</span>';
				}else{
					$status= '<span class="btn-danger">Closed</span>';
				}	

                 $i++;
                     ?>
	         <tr>
                <td><?php echo $i . '.'; ?></td>				
				<td><?php echo $p->title;?></td>
				<td><a target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>' />Download file (file)</a>
					<?php echo $status?>
			</td>
				<td><?php echo $p->description;?></td>

			 <td width='250'>
						 <div class='btn-group'>
							
						<a class="btn btn-sm btn-success" target="_blank" href='<?php echo base_url()?>uploads/files/<?php echo $p->file?>'><i class='glyphicon glyphicon-eye-open'></i> View</a>
						<a  class="btn btn-sm btn-info" href='<?php echo site_url('admin/newsletters/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							  
						<a  class="btn btn-sm btn-danger"  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/newsletters/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
						<?php
						if($p->status ==0){
						?>
						<a  class="btn btn-sm btn-danger"  onclick="return confirm('Are you sure want to close this newsletter?')" href='<?php echo site_url('admin/newsletters/close/'.$p->id.'/'.$page);?>'>Close</a>
						<?php }else{?>
							<a  class="btn btn-sm btn-success"  onclick="return confirm('Are you sure want to open this newsletter')" href='<?php echo site_url('admin/newsletters/open/'.$p->id.'/'.$page);?>'> Open</a>
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