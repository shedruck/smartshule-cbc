
<div class="row"  id="">

	<div class="card-header col-md-12">

			 <h5 class="text-18-bold"> <?php echo theme_image('classes.jpg',array('width'=>'93','height'=>'80'))?> Exams - Class Exams 
			 <div class="pull-right">
		   <a href="<?php echo base_url('trs#academics'); ?>" class="btn btn-danger"><i class="fa fa-caret-left">
								  </i> Exit</a>
				</div>
			 </h5>

	</div>
	
	 <div class=" col-md-12 clearfix"></div>
		<!-- statustic card start -->
		<?php 
		 $start_year = $this->school->starting_year;
		 $limit = $this->school->years_limit;
		
		for($i=0; $i<$limit ; $i++){
			
		?>	
			
		<div class="col-lg-2 col-md-6 default-grid-item">
				<div class="card gallery-desc">
					<div class="masonry-media">
						<a class="media-middle" target="" href="<?php echo base_url('st/exams_by_year/'.$start_year)?>">
						   <?php echo theme_image('classes.jpg',array('width'=>'165','height'=>'130'))?>
						</a>
					</div>
					<div class="home_card">
					 <a class="media-middle" target="" href="<?php echo base_url('st/exams_by_year/'.$start_year)?>">
						<h6 class="text-center text-18-bold">YEAR <?php echo $start_year;?> </h6>
					  </a>
					</div>
				</div>
			</div>
			
		 <?php $start_year +=1; } ?>

</div>

