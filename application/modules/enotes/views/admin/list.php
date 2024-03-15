<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Enotes  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/enotes/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Enotes')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/enotes' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Enotes')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($enotes): ?>
                 <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
				<th>Term</th>
				<th>Class</th>
				<th>Subject</th>
				<th>File</th>
				<th>Status</th>
				<th>Remarks</th>	
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
          $classes = $this->portal_m->get_class_options();                  
                
            foreach ($enotes as $p ): 
			$sub = $this->portal_m->get_subject($p->class);
                 $i++;
          ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td>
					Term <?php echo $p->term;?>
					<p><?php echo $p->year;?></p>
				
				</td>
				 <td><?php echo $classes[$p->class];?></td>
					<td>
					<?php echo strtoupper($sub[$p->subject]);?>
					<br><b>Topic:</b> <?php echo $p->topic;?>
					<br><b>Subtopic:</b> <?php echo $p->subtopic;?>
					</td>
					<td><a class="btn btn-sm btn-info" target="_blank" href='<?php echo base_url()?><?php echo $p->file_path?>/<?php echo $p->file_name?>' /><i class='glyphicon glyphicon-arrow-down'></i> Download</a></td>
						<td>
						<?php 
						if($p->status==1){
						?>
						<a class="btn btn-sm btn-danger" onClick="return confirm('Are you sure you want to unpublish this E-notes?')" href='<?php echo site_url('admin/enotes/update_status/'.$p->id.'/0');?>'><i class='glyphicon glyphicon-download'></i> Unpublish</a>
							
						<?php }else{?>
						
						<a class="btn btn-sm btn-success" onClick="return confirm('Are you sure you want to publish this  E-notes?')" href='<?php echo site_url('admin/enotes/update_status/'.$p->id.'/1');?>'><i class='glyphicon glyphicon-upload'></i> Publish</a>
						<?php }?>
						</td>
					
					<td><?php echo substr($p->remarks,0,50);?></td>

			 <td width='250'>
						 <div class='btn-group'>
							 <a class="btn btn-sm btn-success" target="_blank" href='<?php echo base_url()?><?php echo $p->file_path?>/<?php echo $p->file_name?>'><i class='glyphicon glyphicon-eye-open'></i> View</a>
							<a class="btn btn-sm btn-primary" href='<?php echo site_url('admin/enotes/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							<a  class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/enotes/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
							
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