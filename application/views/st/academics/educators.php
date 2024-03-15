<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
            My Educators / Teachers 
			
			
        </h3>
       <a class="btn btn-sm btn-danger pull-right" onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
        <div class="clearfix"></div>
        <hr>
    </div>
	  <div class="content">
	  
	   <div class="row">
				 <?php 
				  foreach($educators as $p){
				  $class_rep = $this->portal_m->get_teacher_details($p->teacher);
				 ?>
                    <div class=" col-lg-3">
					<div class="text-center card-box">
						<div class="member-card">
							<div class="thumb-xl member-thumb m-b-10 center-block">
							
							  <img src="<?php echo base_url('assets/themes/default/img/member.png'); ?>" width="110" height="110"  class="img-circle img-thumbnail" alt="profile-image">
							
								<i class="mdi mdi-star-circle member-star text-success" title="verified user"></i>
							</div>

							<div class="">
								<h4 class="m-b-5"><?php echo $class_rep->first_name.' '.$class_rep->middle_name.' '.$class_rep->last_name?></h4>
								<p class="text-muted">Class Representative/Teacher</p>
							</div>

							<button type="button" class="btn btn-primary btn-sm w-sm waves-effect m-t-10 waves-light">Send Message</button>
							
							<hr/>

							<div class="text-left">
								
								<p class=" font-13"><strong>Gender :</strong> <span class="m-l-15"><?php echo $class_rep->gender ?></span></p>
								<p class="font-13"><strong>Mobile 1:</strong><span class="m-l-15"><?php echo $class_rep->phone ?></span></p>
								<p class=" font-13"><strong>Mobile 2:</strong><span class="m-l-15"><?php echo $class_rep->phone2 ?></span></p>

								<p class="y font-13"><strong>Email :</strong> <span class="m-l-15"><?php echo $class_rep->email?> </span></p>

								
							</div>


						</div>

					</div> <!-- end card-box -->

				</div> <!-- end col -->
			  <?php } ?>
		</div> <!-- end row -->
	 
   </div>
</div>

