<div class="head"> 
			 <div class="icon"><span class="icosg-target1"></span> </div>
            <h2>  E-videos  </h2>
             <div class="right">  
             <?php echo anchor( 'admin/evideos/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'E-videos')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/evideos' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'E-videos')), 'class="btn btn-info"');?> 

             
                </div>
                </div>
         	                    
              <?php 
			  
			  $classes = $this->portal_m->get_class_options();
              $sys = $this->ion_auth->populate('class_groups','id','education_system');
			  $sub844 = $this->ion_auth->populate('subjects','id','name');
			  $cbc = $this->ion_auth->populate('cbc_subjects','id','name');
				
            if($sys[$post->level] ==1){
	             $sub = $sub844;
				}elseif($sys[$post->level] ==2){
				 $sub = $cbc;
				}			  

			  ?>
               
                 <div class="block-fluid">
				 
				 <div class="col-sm-8">

				 <iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php echo $post->video_embed_code?>?playlist=<?php echo $post->video_embed_code?>&loop=1">
                  </iframe>
				  
				  <h4><b>Title:</b> <?php echo strtoupper($post->title);?></h4>
				  <h4><b>Level:</b> <?php if($post->level=='999') echo 'General'; else  echo $classes[$post->level];?></h4>
				  <h4><b>Subject:</b> <?php echo $sub[$post->subject];?> </h4>
				  <h4><b>Topic:</b> <?php echo $post->topic;?> </h4>
				  <h4><b>Sub Topic:</b> <?php echo $post->subtopic;?> </h4>
				  <hr>
				  <h4><?php echo $post->description;?> </h4>
				 </div>
				 
		<div class="col-sm-4">		 
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">

		<tbody>
		<?php 
                $i = 0;

            foreach ($evideos as $p ): 
                 $i++;
                     ?>
	            <tr>
                
				<td><a href="<?php echo base_url('admin/evideos/watch_all/'.$p->id)?>"><img src="<?php echo $p->preview_link;?>" width="80" height="50"></a></td>
				<td><a href="<?php echo base_url('admin/evideos/watch_all/'.$p->id)?>"><?php echo strtoupper($p->title);?></a></td>

				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>

	
</div>
