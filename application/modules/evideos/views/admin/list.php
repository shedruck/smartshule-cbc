<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  E-videos  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/evideos/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'E-videos')), 'class="btn btn-primary"');?>
			 
			

				<?php echo anchor( 'admin/evideos/watch_all' , '<i class="glyphicon glyphicon-list">
                </i> Watch All', 'class="btn btn-success"');?> 
             
                </div>
                </div>
         	                    
              
                 <?php if ($evideos): ?>
                 <div class="block-fluid">
				 

				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
	 <thead>
                <th>#</th>
					<th>Preview Link</th>
				<th>Title</th>
				<th>Class/Level</th>
				<th>Subject</th>
				<th>Status</th>
				
				<th ><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
							 
				$sys = $this->ion_auth->populate('class_groups','id','education_system');
				
               //** Check if education system to list subjects/learning areas
			   
			    $sub844 = $this->ion_auth->populate('subjects','id','name');
				$cbc = $this->ion_auth->populate('cbc_subjects','id','name');
			   
                
                             
           $classes = $this->portal_m->get_class_options();     
            foreach ($evideos as $p ): 
			
			   if($sys[$p->level] ==1){
	             $sub = $sub844;
				}elseif($sys[$p->level] ==2){
				 $sub = $cbc;
				}
			
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>	
				<td><a href='<?php echo site_url('admin/evideos/watch_all/'.$p->id);?>'><img src="<?php echo $p->preview_link;?>" width="80" height="50"></a></td>
				<td><?php echo strtoupper($p->title);?></td>
				<td><?php  echo  strtoupper($classes[$p->level]);?></td>
				<td><?php echo isset($sub[$p->subject]) ? strtoupper($sub[$p->subject]) : strtoupper($p->subject);?>
				<br><b>Topic: </b><?php echo $p->topic;?>
				<br><b>Subtopic: </b><?php echo $p->subtopic;?>
				</td>
				<td>
				<?php 
				if($p->status==1){
				?>
				<a class="btn btn-sm btn-danger" onClick="return confirm('Are you sure you want to unpublish this video?')" href='<?php echo site_url('admin/evideos/update_status/'.$p->id.'/0');?>'><i class='glyphicon glyphicon-download'></i> Unpublish</a>
					
				<?php }else{?>
				
				<a class="btn btn-sm btn-success" onClick="return confirm('Are you sure you want to publish this video?')" href='<?php echo site_url('admin/evideos/update_status/'.$p->id.'/1');?>'><i class='glyphicon glyphicon-upload'></i> Publish</a>
				<?php }?>
				</td>
				
				
			 <td width="250" >
						 <div class='btn-group'>
					  <a class="btn btn-sm btn-success" href='<?php echo site_url('admin/evideos/watch_all/'.$p->id);?>'><i class='glyphicon glyphicon-eye-open'></i> Watch</a>
						<a  class="btn btn-sm btn-primary" href='<?php echo site_url('admin/evideos/edit/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-edit'></i> Edit</a>
							  
						<a class="btn btn-sm btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/evideos/delete/'.$p->id.'/'.$page);?>'><i class='glyphicon glyphicon-trash'></i> Trash</a>
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