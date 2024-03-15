<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php echo $post->title?> - Multiple Choices</b>
        </h3>
		<div class="pull-right">
	
        
		
		 <?php echo anchor( 'mc/st/', '<i class="fa fa-list"></i> List All', 'class="btn btn-info btn-sm "');?>
		  <a class="btn btn-sm btn-danger " onclick="goBack()"><i class="fa fa-caret-left"></i> Go Back</a>
      </div>
        <div class="clearfix"></div>
        <hr>
    </div>

<div class="row">


<div class="col-md-12">

			        <div class="col-sm-12 text-center">
                                <span class="" style="text-align:center">
                                    <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="100" height="100" />
                                </span>
                                <h3>
                                    <span><?php echo strtoupper($this->school->school); ?></span>
                                </h3>
                                <small >
                                    <?php
                                    if (!empty($this->school->tel))
                                    {
                                            echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                    }
                                    else
                                    {
                                            echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                    }
                                    ?>
                                </small>
                                
								<br>
								<hr>
                                <h3 style=""><?php echo strtoupper($post->title)?></h3>
                                <h4 style=""><b>LEVEL:</b> <?php $classes = $this->portal_m->get_class_options(); echo strtoupper($classes[$post->level])?></h4>
                                <h4 style=""><b>SUBJECT / LEARNING AREA:</b> <?php echo strtoupper($post->subject)?></h4>
                                <h4 style=""><b>DURATION:</b> <?php echo isset($post->hours) ? $post->hours : '0';?>hrs : <?php echo isset($post->minutes) ? $post->minutes : '00';?> mins</h4>
								<?php if($post->topic){?>
									<h4 style=""><b>TOPIC / STRAND:</b> <?php echo strtoupper($post->topic)?></h4>
								<?php } ?>
								<hr>
                            </div>
							
				 <div class="col-sm-12 text-center">
					<h4 class="text-center">INSTRUSTIONS</h4>
					<p class="text-center"><?php echo $post->instruction?></p>
				</div>
				
			
	 </div> 
	 
	 </div>
	<div class="row" id="starter">
	
	<div class="col-sm-12 ">
<hr>
						<div class="">
						   <div class="time-show first">
						      <div class="col-md-5">
									
										<a href="#" class="btn btn-default w-lg">DURATION: <?php echo isset($post->hours) ? $post->hours : '0';?>hrs : <?php echo isset($post->minutes) ? $post->minutes : '00';?> mins</a>
									
								</div>
								<div class="col-md-3">
									<a id='start'  href="#" class="btn btn-success w-lg"><i class='fa fa-edit'></i> START QUIZ NOW </a>
								</div>
								<div class="col-md-4">
									<a href="#" class="btn btn-danger w-lg pull-right">NB:<small> Once started no revert</small> </a>
							    </div>

							</div>
							
						</div>
					<br>
					<br>
					<br>
	 </div>
	 </div>
	 
		<div class="row" id="mcs" style="display:none !important">
			<div class="col-sm-12">
				<div class="timeline timeline-left">
					<article class="timeline-item alt">
						<div class="text-left">
							<div class="time-show first">
								<a href="#" class="btn btn-danger w-lg">QUESTIONS</a>
							</div>
						</div>
					</article>
					  <?php $i=0; if($questions){ ?>
					  
						<?php 
						foreach($questions as $p){ $i++; 
						$choices = $this->portal_m->get_unenc_result('question_id',$p->id,'mc_choices'); 
						?>
					<article class="timeline-item ">
						<div class="timeline-desk col-sm-12">
							<div class="panel">
								<div class="timeline-box">
									<span class="arrow"><h4><?php echo $i?>) </h4></span>
									<span class="timeline-icon"><i class="mdi mdi-checkbox-blank-circle-outline"></i></span>
									<h4> <span  class="text-black" style="font-size:24px !important;"> <?php echo $p->question;?></span> </h4>
								   
								 
									  <ol class="choices pad10" style="list-style-type: upper-alpha !important;" >
											  <?php foreach($choices as $c){?>
												   <?php if($c->state==1){?>
												   <li class="text-green pad5">) <b><?php echo $c->choice;?></b> </li>
												   <?php }else{?>
												   <li class="text-red pad5">) <?php echo $c->choice;?> </li>
												   <?php } ?>
											   <?php } ?>
									   </ol>
								</div>
							</div>
						</div>
					</article>
					  <?php  } ?>
					<?php }else{?>
						 No question has been added
					 <?php } ?>

				</div>
			</div>
		</div>
		<!-- end row -->


	 
	 
	 
	</div>
  </div>
  
  
  			

   <script>

	$("#start").click(function () {
				
				   swal({
							  title: "Start Quiz",
							  text: "Are you sure you want to start this quiz? Action is irrevessible",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							  if (willDelete) {
								  window.location="<?php echo base_url('mc/st/mc_start/'.$post->id.'/'.$this->session->userdata['session_id'])?>";
								 swal("Starting quiz please wait....");
							  } else {
								//swal("Your imaginary file is safe!");
							  }
					});
				
			});

</script>

