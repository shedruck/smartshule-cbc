<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <?php $classes = $this->portal_m->get_class_options(); echo $classes[$class]; ?> E-Videos
        </h3>
      <div class="pull-right">
      
	    <?php echo anchor( 'trs/evideos_landing', '<i class="fa fa-list"></i> List All Videos', 'class="btn btn-primary btn-sm "');?>
		 <a class="btn btn-sm btn-danger" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        </div>
		 <div class="clearfix"></div>
        <hr>
    </div>
 <div class="content">
	  <div class="row">

 <div class="col-sm-12">


 <?php if ($subjects): ?>
      
		     	<?php 
					 $i = 0;
		
            foreach ($subjects as $p ): 
                 $i++;
				 $counter = $this->portal_m->count_video_files($class,$p->subject_id);
				 
                     ?>
					 
					 <?php 
							$url = site_url('trs/watch/'.$p->subject_id.'/'.$class.'/'.$this->session->userdata['session_id']);
							if($counter<=0){
								$url='#';
							}
					?>
					 
							
						 <a href='<?php echo $url;?>'>
					 <div class="col-sm-3" style="text-align:center"> 
					 
					   <?php 
							
							
							$tx = 'text-green';
							if($counter>0){
								echo theme_image('videos.png');
							}else{
								echo theme_image('videos-empty.png');
								$tx ='text-grey';
								
							}
					?>
						<br>
					    
						 <?php $ln = strlen($subs[$p->subject_id]); echo strtoupper(substr($subs[$p->subject_id],0,20)); if($ln >20) echo '...'?> 
						 <br>
						 <b class="<?php echo $tx?>">( <?php echo number_format($counter);?> Videos )</b>
						 
						 <hr>
				     </div>	</a>		

					
        <?php endforeach ?>	
		 

		<?php else: ?>
			<p class='text'><?php echo lang('web_no_elements');?></p>
		<?php endif ?>
   
  </div>
  </div>
  </div>
  </div>
  
  
		
		
		
		
		
		
		