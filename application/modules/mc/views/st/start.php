<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           <b> <?php echo $post->title?> - Multiple Choices</b>
        </h3>
		<div class="pull-right">
	
      </div>
        <div class="clearfix"></div>
        <hr>
    </div>

	<div class="row" id="starter">
	
	<div class="col-sm-12 ">
<hr>
						<div class="">
						   <div class="time-show first">
						      <div class="col-md-5">
									
											<div class="">
												<h2 class="text-c-white">QUIZ TIMER: 
												
												<button id="c_timer" style="font-size:25px !important" class="btn btn-success waves-effect waves-light btn-lg m-b-5"> <?php if(!empty($p->hours)) echo number_format($p->hours); else '0'; ?>hr : 
													<?php echo isset($p->minutes) ? $p->minutes : '0'; ?>mins</button>
												
													
													</h2>
											</div>
									
								</div>
								<div class="col-md-3">
								
								</div>
								<div class="col-md-4">
									<a href="#" class="btn btn-danger w-lg pull-right">NB:<small> Once started no revert</small> </a>
							    </div>

							</div>
			
						</div>
					
	 </div>
	 </div>
	 
		<div class="row" id="mcs" >
			<div class="col-sm-12">
			<hr>	
				<div class="timeline timeline-left">
					<article class="timeline-item alt">
						<div class="text-center">
							<div class="time-show first">
								<a href="#" class="btn btn-info w-lg">ATEMPT ALL QUESTIONS</a>
							</div>
						</div>
					</article>
					  <?php $counter= 0; $i=0; if($questions){ ?>
					  
						<?php 
						foreach($questions as $p){ $i++; $counter++;
						$choices = $this->portal_m->get_unenc_result('question_id',$p->id,'mc_choices'); 
						
						$qq = preg_replace("/<p.*?>(.*)?<\/p>/im","$1",$p->question); 
						?>
					<article class="timeline-item ">
						<div class="timeline-desk col-sm-12">
							<div class="panel">
								<div class="timeline-box">
									
									<div class="col-sm-1">
									<h4 class="timeline-icon1"><?php echo $i?> )</h4>
									
								     </div>
								   <div class="col-sm-11">
								   <h4> <span  class="text-black" style="font-size:18px !important;"> <?php echo $qq;?></span> </h4>
									  <ol class="choices" style="list-style-type: upper-alpha !important;" >
									 
												 
										  <?php foreach($choices as $c){?>
										      
											   

												 <li style="color:#0083C4; font-size:16px; margin-left:30px;" > ) 
											
											   
											   &nbsp; <input type="radio" class=" " name="<?php echo $p->id?>" id="choice_<?php echo $c->id?>">
											  
											     &nbsp; <?php echo $c->choice;?> </li>
												 
												 	<script>
														$(document).ready(function ()
														{
															var chs = "Your Choice";
															$("#choice_<?php echo $c->id?>").click(function () {
																
														         var chs = "<?php if($c->choice) echo $c->choice;?>";
																	var choice =  <?php echo $c->id?>;
																	var question = <?php echo $p->id?>;
																	var mc_id =  <?php echo $post->id; ?>;
														
																	if(choice ==""||question=="" || mc_id==""){
																	  
																		swal({
																				  title: "Sorry?",
																				  text: "No tricks kindly select and avoid injections",
																				  icon: "warning",
																				  button: "Close",
																				})
																						
																		
																	}
																else{
																
																		
																	$.getJSON("<?php echo base_url('mc/st/mc_answers'); ?>", {choice: choice,question: question,mc_id: mc_id }, function (data) {
																		
																		var url = "<?php echo base_url('mc/st/mc_summary_result/');?>";
																			
																			
																				if(data===0){
																					
																					swal({
																						  title: "Sorry ",
																						   text: "Seems you had submitted this assignment",
																						  icon: "error",
																						  button: "Close",
																						})
																					window.location=url;

																				}else{
																					
																					swal({
																						  title: "Answer Recorded",
																						  text: "Your Choice is: "+chs,
																						  icon: "success",
																						  button: "Next",
																						})
																						
																					
																				}
																			   
																			}); 

																}
															});
														})

												</script>
										      
										   <?php } ?>
										   
				

								   </ol>
								   
								   
								   </div>
								</div>
							</div>
						</div>
					</article>
					  <?php  } ?>
					  
					
					  <div class="text-center"> 
					  <hr>
								     <button id='complete' class='btn btn-primary' > SUBMIT QUIZ </button>
									 
					</div>			
					<?php }else{?>
						 No question has been added
					 <?php } ?>
					 
					 

				</div>
			</div>
		</div>
		<!-- end row -->


	 
	 
	 
	</div>
  </div>



<?php					
		   $timestamp = (time() + ($post->hours*60*60)+($post->minutes*60));
		   $period  = date('F d, Y H:i:s',$timestamp);
	?>

<script>
// Set the date we're counting down to

$(document).ready(function ()
					{

				
					$('.choices').show('slow');
					$('.timer-display').show('slow');
					$('#complete').show('slow');
					$("#start").hide('slow');

					var countDownDate = new Date("<?php echo $period;?>").getTime();

					// Update the count down every 1 second
					var x = setInterval(function() {

					  // Get today's date and time
					  var now = new Date().getTime();
						
					  // Find the distance between now and the count down date
					  var distance = countDownDate - now;
						
					  // Time calculations for days, hours, minutes and seconds
					  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
						
					  // Output the result in an element with id="timer"
					  document.getElementById("c_timer").innerHTML =  hours + "h "
					  + minutes + "m " + seconds + "s ";
						
					  // If the count down is over, write some text 
					  // If the count down is over, write some text 
							 if (distance < 0) {
								
								clearInterval(x);
								
								 document.getElementById("c_timer").innerHTML =  "0 h : 0m : 0s ";
							  
								$('.choices').hide('slow');
								$('.warning').show('slow');
								document.getElementById("warning").innerHTML = "Time has Expired kindly submit your assignment";
								
								swal({
										  title: "Time has Expired",
										  text: "kindly submit your assignment",
										  icon: "warning",
										});
							  }
							  
					}, 1000);


			})

</script>




  	     <script>
					$(document).ready(function ()
					{
						

						
						//********** COMPLETE **********//
						$("#complete").click(function () {
							
							    var mc_id =  <?php echo $post->id; ?>;
								$.getJSON("<?php echo base_url('mc/st/update_done'); ?>", {mc_id: mc_id  }, function (data) {
									
										if(data===0){
											
											swal({
												  title: "Sorry something went wrong",
												  text: "Try again later",
												  icon: "warning",
												  button: "Close",
												})
										
											
										}else{
											var rem = <?php echo $counter?> - data;
											
											var txt = "You have "+rem+" question(s) left";
											if(rem==0){
												
											   txt = "Confirm submission";
											   
											}
											
												swal({
														  title: txt,														  
														  text: "Are you sure you want to submit assignment",
														  icon: "warning",
														  buttons: ["Continue Review", true],
														  dangerMode: false,
														})
													.then((willDelete) => {
														  if (willDelete) {
															swal( {
															  title: "Your Quiz has been successfully posted.",
															  icon: "success",
															});
															
															window.location="<?php echo base_url('mc/st/mc_result/'.$post->id.'/'.$this->session->userdata['session_id'])?>";
															
															 //$('#submit_post').show('slow');
															 //$('#complete').hide('fast');
															 
															 $('html, body').animate({scrollTop:$(document).height()}, 'slow');
															 
															 
														  } else {
															
															  $('html, body').animate({scrollTop:$(document).height()}, 'slow');	
														  }
												});
											
										}
											
									//$('#submit_post').hide();	
									   
									}); 
							
							
						
					

							
						});
						
					
					
					})

			</script>
