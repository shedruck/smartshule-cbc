<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Parents  </h2>
    <div class="right">  
        <?php //echo anchor( 'admin/parents/create/'.$page, '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => 'Parents')), 'class="btn btn-primary"');?>
        <?php echo anchor('admin/parents', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Parents')), 'class="btn btn-primary"'); ?> 

    </div>
</div>
<div class="block-fluid">
    <div class="col-md-12">
	    <div >
	  <h4>Children Details</h4>
	  <br>
       
		 <div class="col-md-12"> 
		 <div class="widget">
		<table border="0" width="600">
										
			  <?php if($my_children){?>	
				  <?php foreach($my_children as $st){?>	
				 <tr class="">
					  <td>
                     <a  class='btn btn-default btn-sm' href='<?php echo site_url('admin/admission//view/' .$st->id); ?>'>					  
                          <?php
                        if (!empty($st->photo)):
						     $passport = $this->portal_m->student_passport($st->photo);
                                if ($passport)
                                {
                                        ?> 
                                        <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="40" height="40" class="img-polaroid" style="align:left">
                         <?php } ?>	

                        <?php else: ?>   
                                <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
                        <?php endif; ?> 
					</a>  
					  </td>												 
					 <td>	  
					   <a  href="<?php echo base_url('admin/admission/view/' . $st->id); ?>" >
						   <?php echo $st->first_name?>	 <?php echo $st->last_name?><br></a>
						     Gender: <?php
                        if ($st->gender == 1)
                                echo 'Male';
                        elseif($st->gender == 2)
                                echo 'Female';
						else echo $st->gender;
                        ?><br>
						 <a  class='btn btn-success btn-sm' href='<?php echo site_url('admin/admission//view/' .$st->id); ?>'>
                                                    <i class='glyphicon glyphicon-eye-open'></i> Profile</a>
					  </td>
					  <td>	  
						<strong>Class:</strong> 
						
						<?php $classes = $this->ion_auth->fetch_classes();
							$cls = isset($classes[$st->class]) ? $classes[$st->class] : ' -';
						   
							echo $cls;
							?>
							<br>
							<strong>UPI:</strong> <?php
                          
                                    echo $st->upi_number;
                                   
                            ?><br>
							<strong>ADM:</strong> 
							<?php
                            if (!empty($st->old_adm_no))
                            {
                                    echo $st->old_adm_no;
                            }
                            else
                            {
                                    echo $st->admission_number;
                            }
                            ?>
					  </td>
				  </tr>
				  <?php }?>											 
			  <?php }?>											 
			</table>
	
		</div>
		</div>
		</div>
	</div>
	
<div class="col-md-12">
    <div class="col-md-4">
        <div class="widget"> 
		<div class="info-s" style="text-align:center">
            <div class="profile clearfix">
			 <?php $ttl = $this->ion_auth->populate('titles','id','name');?>
                 <br>
				 <div  class='btn btn-default btn-sm' style="text-align:center">
				
                    <?php
						if (!empty($p->father_photo)):
						$passport = $this->portal_m->parent_photo($p->father_photo);
						  if ($passport)
								{
										?> 
							<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="100" height="100" class="img-polaroid" >
						 <?php } ?>	

						<?php else: ?>   
								<?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; ")); ?>
						<?php endif; ?> 
                </div>                        
                <div class="info-s">
                    <h4><?php echo isset($p->f_title) ? $p->f_title.' ' : '' ?> 
					<?php echo ucwords($p->first_name . ' ' . $p->f_middle_name . ' ' . $p->last_name); ?></h4>
				
                    <table border="0" width="275">
					     <tr> <td><strong>Relation:</strong></td><td> <?php echo $p->f_relation ?></td></tr>
                        <tr> <td><strong>Email:</strong></td><td> <?php echo $p->email ?></td></tr>
                        <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $p->phone ?></td></tr>
                      
                        <tr> <td><strong>Occupation:</strong></td><td><?php echo $p->occupation ?></td></tr>
                        <tr> <td><strong>ID No:</strong></td><td><?php echo $p->f_id ?></td></tr>
                        <tr> <td><strong>Address:</strong></td><td><?php echo $p->address ?></td></tr>
                    </table>
                    <div class="status">Father Details</div>
                </div>
				
			

             </div>
			 
			 	<hr>				 
			 <div class="" style=" text-align:center">
				  <h4> <?php echo $p->first_name ?> ID/Passport Copy</h4>
					<?php 
						if($p->father_id_copy){
							$id_copy = $this->portal_m->parents_ids($p->father_id_copy);
						 ?>
						  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/'. $id_copy->fpath . '/' . $id_copy->filename); ?>">
						  <embed src="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>" width="100%" height="100%" style="" class="tr_all_hover" type='application/pdf'>
						  </a>
						  
						  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>"> <i class="glyphicon glyphicon-download"></i> Download File</a>
						  <br>
						 <?php }else{ ?>  
							<h5> No ID uploaded at the moment</h5>
						 <?php } ?> 		 
							 
			 </div>
			 
            </div>
        </div>
        </div>
 <div class="col-md-4">
        <div class="widget">
		<div class="info-s" style="text-align:center">
            <div class="profile clearfix">
			  <br>
                <div  class='btn btn-default btn-sm' style="text-align:center">
				
                   <?php
						if (!empty($p->mother_photo)):
						$mpp = $this->portal_m->parent_photo($p->mother_photo);
						  if ($mpp)
								{
										?> 
										<image src="<?php echo base_url('uploads/' . $mpp->fpath . '/' . $mpp->filename); ?>" width="100" height="100" class="img-polaroid" >
						 <?php } ?>	

						<?php else: ?>   
								<?php echo theme_image("member.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px;")); ?>
						<?php endif; ?> 
                </div>                        
                <div class="info-s">
                    <h4><?php echo isset($p->m_title) ? $p->m_title.' ' : '' ?>
					<?php echo ucwords($p->mother_fname . ' ' .$p->m_middle_name . ' ' . $p->mother_lname); ?>
				
					</h4>
                    <table border="0" width="275">
					    <tr> <td><strong>Relation:</strong></td><td> <?php echo $p->m_relation ?></td></tr>
                        <tr> <td><strong>Email:</strong></td><td> <?php echo $p->mother_email ?></td></tr>
                        <tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $p->mother_phone ?></td></tr>
                       
                        <tr> <td><strong>Occupation:</strong></td><td><?php echo ''; ?></td></tr>
						 <tr> <td><strong>ID No:</strong></td><td><?php echo $p->m_id ?></td></tr>
                        <tr> <td><strong>Address:</strong></td><td><?php echo $p->address ?></td></tr>
                      
                    </table>

                    <div class="status">Mother Details</div>
                </div>
                </div>

            </div>
				<hr>				 
			 <div class="" style=" text-align:center">
				  <h4> <?php echo $p->mother_fname ?> ID/Passport Copy</h4>
					<?php 
						if($p->mother_id_copy){
							$id_copy = $this->portal_m->parents_ids($p->mother_id_copy);
						 ?>
						  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/'. $id_copy->fpath . '/' . $id_copy->filename); ?>">
						  <embed src="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>" width="100%" height="100%" style="" class="tr_all_hover" type='application/pdf'>
						  </a>
						  
						  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>"> <i class="glyphicon glyphicon-download"></i> Download File</a>
						  <br>
						 <?php }else{ ?>  
							<h5> No ID uploaded at the moment</h5>
						 <?php } ?> 		 
							 
			 </div>
			 
        </div>
    </div>
	
	
		
		
		<div class="col-md-4">
				<div class="widget">
					<div class="profile clearfix">                        
						<div class="info-s" style="text-align:center">
						<h4>Emergency Contacts</h4>
						<hr>
						 <?php 
						
						 if($em_cont){?>
						 <h5> Name: <?php echo ucwords($em_cont->name.' '.$em_cont->middle_name.' '.$em_cont->last_name); ?></h5>
							<table border="0" width="250">
								<tr> <td><strong>Relation:</strong></td><td> <?php echo $em_cont->relation ?></td></tr>
								<tr> <td><strong>Cell Phone:</strong></td><td> <?php echo $em_cont->phone ?></td></tr>
								 <tr> <td><strong>Email:</strong></td><td> <?php echo $em_cont->email ?></td></tr>
								  <tr> <td><strong>ID No:</strong></td><td> <?php echo $em_cont->id_no ?></td></tr>
								<tr> <td><strong>Address:</strong></td><td><?php echo $em_cont->address ?></td></tr>
								  <tr> <td><strong>Provided By:</strong></td><td><?php echo $em_cont->provided_by ?></td></tr>
							</table>
																	 
						  <?php }else{?>
							 No records uploaded at the moment
						  <?php }?>									 
						
						 </div>
					 </div>  
				  </div>
			</div>
	</div>
								
</div>