<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Class Timetable</h2> 
                     <div class="right">                            
                       
           
                <?php echo anchor( 'admin/class_timetable/' , '<i class="glyphicon glyphicon-arrow-left">
                </i> Back', 'class="btn btn-danger"');?>
			
                     </div>    					
                </div>
         	               
          <div class="block-fluid">
		
		
		<?php 
			foreach($days as $d){
		?>
		<div class="row-fluid">	 
		<div class="col-sm-12">	 
			<h3> <center><?php echo strtoupper($d->day_of_the_week)?></center></h3>
			<hr>
			<?php 
					   $period = $this->portal_m->get_period($tbl, $d->day_of_the_week);
						foreach($period as $p){
					?>
			 <div class="col-sm-3">
					
					<div class="widget">
						<div class="head">
							
							<h2>
							<?php 
							if($p->subject==99) echo 'FREE CLASS';
							elseif($p->subject==999) echo 'LUNCH';
							elseif($p->subject==9999) echo 'GAMES';
							elseif($p->subject==99999) echo 'BREAK';
							elseif($p->subject==999999) echo 'P.E';
							else { $num = strlen($subjects[$p->subject]); echo   substr($subjects[$p->subject],0,15); if( $num < 15) echo '...';}
							
							?>
							</h2> 
						   
						</div>
						<div class="block" 
						<?php if($p->subject==999999) echo "style='background:green; color:#fff;'"; ?>
						<?php if($p->subject==99999) echo "style='background:yellow'"; ?>
						<?php if($p->subject==9999) echo "style='background:grey'"; ?>
						<?php if($p->subject==999) echo "style='background:red'"; ?>
						>
							From <?php echo $p->start_time ?> - <?php echo $p->end_time ?> <br>
							By: <?php echo $p->teacher ?>
						</div>
					</div>                
					
				</div>	
				<?php } ?>
			</div>
			<?php } ?>
		
  
         
    </div>







