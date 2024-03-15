<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  Past Papers  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/past_papers/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Past Papers')), 'class="btn btn-primary"');?>

			 <?php echo anchor( 'admin/past_papers/create_folder/'.$page, '<i class="glyphicon glyphicon-plus"></i> New Folder', 'class="btn btn-warning"');?>
			 
			 <?php echo anchor( 'admin/past_papers' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Past Papers')), 'class="btn btn-primary"');?> 
             
                </div>
                </div>
				

 <div class="block-fluid">

 <?php if ($past_papers): ?>
      
		     	<?php 
					 $i = 0;
			if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
			{
				$i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
			}
                
            foreach ($past_papers as $p ): 
                 $i++;
				 $counter = $this->portal_m->file_folders($p->id);
                     ?>
					 
					 <div class="col-sm-2" style="text-align:center"> 
					  <a href='<?php echo site_url('admin/past_papers/create/'.$p->id.'/'.$page);?>'>
							<?php 
							if($counter>0){
								echo theme_image('folder.png');
							}else{
								echo theme_image('folder-open-o.png');
							}
							?>
						</a>
						<br>
					     <a href='<?php echo site_url('admin/past_papers/create/'.$p->id.'/'.$page);?>' class="btn btn-default"><?php echo $p->title;?></a>
				     </div>			

					
<?php endforeach ?>					 

          

			 
		
		<?php else: ?>
			<p class='text'><?php echo lang('web_no_elements');?></p>
		 <?php endif ?>
   
  </div>
  
  
		
		