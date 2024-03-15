<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           Past Papers
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
        <hr>
    </div>
 <div class="content">
	  <div class="row">

 <div class="col-sm-12">

 <?php if ($past_papers): ?>
      
		     	<?php 
					 $i = 0;
	
            foreach ($past_papers as $p ): 
                 $i++;
				 $counter = $this->portal_m->file_folders($p->id);
                     ?>
					 
					 <div class="col-sm-2" style="text-align:center"> 
					  <a href='<?php echo site_url('trs/view_past_papers/'.$p->id.'/'.$this->session->userdata['session_id']);?>'>
							<?php 
							$bg = 'bg-green';
							$txt = 'text-white';
							if($counter>0){
								echo theme_image('folder.png');
							}else{
								$bg = 'bg-grey';
								$txt = 'text-grey';
								echo theme_image('folder-open-o.png');
							}
							?>
						</a>
						<br>
					     <a href='<?php echo site_url('trs/view_past_papers/'.$p->id.'/'.$this->session->userdata['session_id']);?>' class="pad5 <?php echo $bg.' '.$txt;?>"><?php echo $p->title;?></a>
				     </div>			

					
       <?php endforeach ?>					 
	 
		
		<?php else: ?>
			<p class='text'><?php echo lang('web_no_elements');?></p>
		 <?php endif ?>
   <p>&nbsp;</p>
  </div>
 
  </div>
  </div>
  </div>
  
  
		
		
		
		
		
		
		