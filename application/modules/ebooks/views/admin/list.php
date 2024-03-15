<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Ebooks  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/ebooks/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Ebooks')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/ebooks' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Ebooks')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($ebooks): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Title</th>
				<th>Author</th>
				<th>Level</th>
				<th>Subject</th>
				<th>File</th>
				<th>Description</th>	
				<th>Status</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                  $classes = $this->portal_m->get_class_options();  
                
            foreach ($ebooks as $p ): 
			$sub = $this->portal_m->get_subject($p->level);
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $p->title;?></td>
					<td><?php echo $p->author;?></td>
					<td><?php echo $classes[$p->level];?></td>
					<td><?php echo strtoupper($sub[$p->subject]);?></td>
					<td><a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url()?><?php echo $p->file_path?>/<?php echo $p->file_name?>' /><i class='glyphicon glyphicon-arrow-down'></i> Download</a></td>
					
					
					<td><?php echo substr($p->description,0,20);?>...</td>
					
					<td>
						<?php 
						if($p->status==1){
						?>
						<a class="btn btn-sm btn-danger" onClick="return confirm('Are you sure you want to unpublish this E-Book?')" href='<?php echo site_url('admin/ebooks/update_status/'.$p->id.'/0');?>'><i class='glyphicon glyphicon-download'></i> Unpublish</a>
							
						<?php }else{?>
						
						<a class="btn btn-sm btn-success" onClick="return confirm('Are you sure you want to publish this  E-Book?')" href='<?php echo site_url('admin/ebooks/update_status/'.$p->id.'/1');?>'><i class='glyphicon glyphicon-upload'></i> Publish</a>
						<?php }?>
						</td>
					
					<td width='250'>
						 <div class='btn-group'>
							 <a class="btn btn-sm btn-success" target="_blank" href='<?php echo base_url()?><?php echo $p->file_path?>/<?php echo $p->file_name?>'><i class='glyphicon glyphicon-eye-open'></i> View</a>
							<a class="btn btn-sm btn-primary" href='<?php echo site_url('admin/ebooks/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							<a  class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/ebooks/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
							
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