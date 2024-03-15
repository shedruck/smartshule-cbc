

<div class="col-md-6">
<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Student Details </h2> 
					
					 <div class="right">                            
                  
                <?php echo anchor( 'admin/students_placement/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			
                     </div>  
                     					
                </div>
				
			

 <div class="profile clearfix">
                        <div class="image" >
						<?php
						$user=$this->ion_auth->list_student($post->student);
						$passport = $this->ion_auth->passport($user->photo);
						if(!empty($user->photo)):?>	
						<image src="<?php echo base_url('uploads/'.$passport->fpath.'/'.$passport->filename);?>" width="150" height="150" class="img-polaroid" style="align:left">

						 <?php else:?>   
						   <?php echo theme_image("thumb.png", array('class'=>"img-polaroid",'style'=>"width:150px; height:150px; align:left"));?>
											 
						 <?php endif;?>      
                    </div>                       
                        <div class="info-s">
                            <h2><?php  $class=$this->ion_auth->list_classes();   echo $user->first_name.' '.$user->last_name; ?></h2>
                            <p><strong>ADM No.: </strong> <?php  echo $user->admission_number;?></p>
                            <p><strong>UPI No.: </strong> <?php  echo $user->upi_number;?></p>
							<hr>
                            <p><strong>ADM Date.:</strong> <?php  echo date('d M Y',$user->admission_date);?></p>
                            <p><strong>Gender: </strong> <?php  if($user->gender==1) echo 'Male'; else echo 'Female';?></p>
                            <p><strong>Disabled: </strong> <?php  echo $user->disabled;?></p>
                            <p><strong>Class: </strong> <?php  echo $class[$user->class];?></p>
							<br>
                            <p><strong>Representing: </strong><?php if($post->student_class=="Others") echo 'Others'; else echo isset($class[$post->student_class]) ? $class[$post->student_class] : '';?></p>
                           <hr>
                            <p ><strong>POSITION :</strong> <?php echo strtoupper($position[$post->position]);?></p>
                           
							<hr>
                        </div>
						
                        <div class="stats">
						
                            <div class="item">
                               <strong>Description :</strong><br> <?php  echo $post->description;?>                               
                            </div>                            
                            <div class="clearfix"></div>
							<div class="right">
								<div class="item">
									<div class="title">Date From</div>
									<div class="descr"><?php  echo date('d M Y',$post->start_date);?></div>
								</div>
								<div class="item">
									<div class="title">Date To</div>
									<div class="descr"><?php  echo date('d M Y',$post->duration);?></div>                                
								</div>                            
                            </div>                            
                        </div>
                    </div>
         </div>



<div class="col-md-6">

			<div class="head">
                    <div class="icon"><span class="icosg-target1"></span></div>
                    <h2> Placement</h2> 
                     <div class="right">                            
                       
             <?php echo anchor( 'admin/students_placement/create/', '<i class="glyphicon glyphicon-plus"></i> '.lang('web_add_t', array(':name' => ' New Students Placement')), 'class="btn btn-primary"');?>
                <?php echo anchor( 'admin/students_placement/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
			
                     </div>    					
                </div>	
				
				
         	        <?php if ($students_placement): ?>              
               <div class="block-fluid">
				<table class="fpTable" cellpadding="0" cellspacing="0" width="100%">

 
	 <thead>
                <th>#</th>
				<th>Student</th>	
				<th>Position</th>	
				<th>Class</th>	
				<th><?php echo lang('web_options');?></th>
		</thead>
		<tbody>
		<?php 
                             $i = 0;
                       
                
            foreach ($students_placement as $p ): 
                 $i++;
				  $user=$this->ion_auth->list_student($p->student);
				  $class=$this->ion_auth->list_classes();
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>					
				<td><?php echo $user->first_name.' '.$user->last_name;?></td>
				<td><?php echo $position[$p->position];?></td>
				<td><?php if($p->student_class=="Others") echo 'Others'; else echo isset($class[$p->student_class]) ? $class[$p->student_class] : '';?></td>
				
					  <td width="20%">
	                  <a href="<?php echo site_url('admin/students_placement/view/'.$p->id);?>"><i class="glyphicon glyphicon-eye-open"></i> View</a>
				</td>
				</tr>
 			<?php endforeach ?>
		</tbody>

	</table>
	</div>

<?php else: ?>
 	<p class='text'><?php echo lang('web_no_elements');?></p>
 <?php endif ?>
 </div>

