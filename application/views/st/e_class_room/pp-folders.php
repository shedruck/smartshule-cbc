<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <?php $classes = $this->ion_auth->fetch_classes(); echo $classes[$this->student->class]; ?> Past Papers
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
        <hr>
    </div>
 <div class="content">
	  <div class="row">
	  <div class="col-sm-12">
		
	   <div class="col-sm-12" style="text-align:center"> 
		    <a href='<?php echo site_url('st/level_past_papers/'.$this->session->userdata['session_id']);?>'>
				<?php 
							if(count($level)>0){
								echo theme_image('folder.png',array('width'=>'200', 'height'=>'200'));
							}else{
								echo theme_image('folder-open-o.png',array('width'=>'200', 'height'=>'200'));
							}
				?>
			</a>
			<br>
			 <a href='<?php echo site_url('st/level_past_papers/'.$this->session->userdata['session_id']);?>' class="btn btn-info">VIEW ALL <b> <?php $classes = $this->ion_auth->fetch_classes(); echo strtoupper($classes[$this->student->class]); ?></b> PAST PAPERS
			 <br>
			<b class="text-black"> Available Papers : <?php echo count($level);?></b>
			 </a>
			 
		 </div>		
	</div>	
	
 <div class="col-sm-12">

 <div class="portlet-heading portlet-default border-bottom">
 <hr>
 <h3 class="portlet-title text-dark">
            Other Uploaded Past Papers
        </h3>
	</div>	
	<hr>
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
					  <a href='<?php echo site_url('st/view_past_papers/'.$p->id.'/'.$this->session->userdata['session_id']);?>'>
							<?php 
							if($counter>0){
								echo theme_image('folder.png');
							}else{
								echo theme_image('folder-open-o.png');
							}
							?>
						</a>
						<br>
					     <a href='<?php echo site_url('st/view_past_papers/'.$p->id.'/'.$this->session->userdata['session_id']);?>' class="btn btn-info"><?php echo $p->title;?></a>
				     </div>			

					
<?php endforeach ?>					 

          

			 
		
		<?php else: ?>
			<p class='text'><?php echo lang('web_no_elements');?></p>
		 <?php endif ?>
   
  </div>
  </div>
  </div>
  </div>
  
  
		
		
		
		
		
		
		