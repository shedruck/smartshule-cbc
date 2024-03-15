<div class="head"> 
             <div class="icon"><span class="icosg-target1"></span></div>		
            <h2>  My Certificates </h2>
             <div class="right"> 
             <?php echo anchor( 'admin/students_certificates/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Students Certificates')), 'class="btn btn-primary"');?>
			 
			 <?php echo anchor( 'admin/students_certificates' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Students Certificates')), 'class="btn btn-primary"');?> 
				
                </div>
                </div>
         	                     
               
				   <div class="block-fluid">
		
                
					
					 <div class="col-sm-12"><hr></div>
					 <?php 
					   if($post){
					 ?>
							 <?php foreach($post as $p){?>
							 <div class="col-md-4 col-sm-4 col-xs-12" style=" text-align:center">
								  <h3><?php echo $p->title;?></h3>
									
									  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $p->file); ?>">
									  <embed src="<?php echo base_url('uploads/files/' . $p->file); ?>" width="250" style="min-height:230px;" class="tr_all_hover" type='application/pdf'>
									  </a>
									  
									  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/files/' . $p->file); ?>"><i>Download File</i></a>
									  <br>
											 
											 
							 </div>
							<?php } ?> 	
					 <?php }else{ ?>  
							<h5> No certificates uploaded at the moment</h5>
				     <?php } ?> 	
					
			</div>
                        
