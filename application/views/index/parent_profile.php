
    <?php
    $u = $this->ion_auth->get_user();
    $user = $this->ion_auth->parent_profile($u->id);
    ?> 

  <div class="row">
  
    <div class="col-md-6">

	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">
			<div class="user-avatar mb-4">
				 <?php
						if (!empty($user->father_photo)):
						$passport = $this->portal_m->parent_photo($user->father_photo);
						  if ($passport)
								{
										?> 
							<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" class=" rounded-circle" width="100" >
						 <?php } ?>	

						<?php else: ?>   
							<?php echo theme_image("member.png", array('class' => " rounded-circle", 'width' => "80")); ?>
						<?php endif; ?>
			</div>
			<div class="user-details">
				<h5><b><?php echo trim($user->first_name . ' ' . $user->last_name); ?></b></h5>
				<table class="table bordered">
					<tr><td><strong>Email:</strong></td><td><small> <?php echo $user->email; ?></small></td></tr>
					<tr><td><strong>Phone:</strong></td><td> <?php echo $user->phone; ?></td></tr>
					<tr><td><strong>Occupation:</strong></td><td> <?php echo $user->occupation; ?></td></tr>
					<tr><td><strong>Registration Date:</strong></td><td> <?php echo $user->created_on > 0 ? date('d M Y H:i', $user->created_on) : ' - '; ?></td></tr>
					<tr><td><strong>Address:</strong></td><td> <?php echo $user->address; ?></td></tr>
				</table>
			</div>
	
		
		 <div class="" style=" text-align:center">
		 <hr>
				  <h4> ID/Passport Copy</h4>
				  <hr>
					<?php 
						if($user->father_id_copy){
							$id_copy = $this->portal_m->parents_ids($user->father_id_copy);
						 ?>
						  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/'. $id_copy->fpath . '/' . $id_copy->filename); ?>">
						  <embed src="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>" width="100%" height="100%" style="" class="tr_all_hover" type='application/pdf'>
						  </a>
						  
						  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>"> <i class="fa fa-download"></i> Download File</a>
						  <br>
						 <?php }else{ ?>  
								<h6> No document uploaded at the moment</h6>
						 <?php } ?> 		 
							 
			 </div>
			</div>	 
			 
	  </div>
	</div>

	<div class="col-md-6">

	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">
			<div class="user-avatar mb-4">
				 <?php
						if (!empty($user->mother_photo)):
						$mpp = $this->portal_m->parent_photo($user->mother_photo);
						  if ($mpp)
								{
										?> 
										<image src="<?php echo base_url('uploads/' . $mpp->fpath . '/' . $mpp->filename); ?>" class="rounded-circle" width="100" >
						 <?php } ?>	

						<?php else: ?>   
								<?php echo theme_image("member.png", array('class' => "rounded-circle", 'width' => "100")); ?>
						<?php endif; ?> 
			</div>
			<div class="user-details">
				<h5><b><?php echo trim($user->mother_fname . ' ' . $user->mother_lname); ?></b></h5>
				<table class="table bordered">
				    <tr><td><strong>Email:</strong></td><td> <small> <?php echo $user->mother_email; ?></small> </td></tr>
					<tr><td><strong>Phone:</strong></td><td> <?php echo $user->mother_phone; ?></td></tr>
					<tr><td><strong>Occupation:</strong></td><td> <?php echo $user->mother_occupation; ?></td></tr>
					<tr><td><strong>Registration Date:</strong></td><td> <?php echo $user->created_on > 0 ? date('d M Y H:i', $user->created_on) : ' - '; ?></td></tr>
					<tr><td><strong>Address:</strong></td><td> <?php echo $user->mother_address; ?></td></tr>
				</table>
			</div>
			<hr>
			<div class="" style=" text-align:center">
				  <h4>  ID/Passport Copy</h4>
				  <hr>
					<?php 
						if($user->mother_id_copy){
							$id_copy = $this->portal_m->parents_ids($user->mother_id_copy);
						 ?>
						  <a style="font-size:18px; text-align:center" target="_blank" href="<?php echo base_url('uploads/'. $id_copy->fpath . '/' . $id_copy->filename); ?>">
						  <embed src="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>" width="100%" height="100%" style="" class="tr_all_hover" type='application/pdf'>
						  </a>
						  
						  <a style="font-size:15px; text-align:center" target="_blank" href="<?php echo base_url('uploads/' . $id_copy->fpath . '/' . $id_copy->filename); ?>"> <i class="fa fa-download"></i> Download File</a>
						  <br>
						 <?php }else{ ?>  
							<h6> No document uploaded at the moment</h6>
						 <?php } ?> 		 
							 
			 </div>
			 
			 
		</div>
	  </div>
	</div>
	
	<div class="col-md-6">

	<div class="user-card card shadow-sm bg-white text-center ctm-border-radius grow">
		<div class="user-info card-body">                      
						<div class="info-s" style="text-align:center">
						
						<div class='btn btn-default btn-sm'>
											 
													<?php echo theme_image("member.png", array('class' => " rounded-circle", 'style' => "width:100px; height:100px; align:left")); ?>
													
											</div>	
											
											
						<h4>Emergency Contacts</h4>
						<hr>
						 <?php 
						 
						 $em_cont = $this->portal_m->get_enc_row('parent_id',$this->parent->id,'emergency_contacts');
						
						 if($em_cont){?>
						 <h5><b> <?php echo ucwords($em_cont->name.' '.$em_cont->middle_name.' '.$em_cont->last_name); ?></b></h5>
							<table class="bordered table">
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




