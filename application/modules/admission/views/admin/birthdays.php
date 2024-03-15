<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Admission </h2>
    <div class="right">  
        <?php echo anchor('admin/admission/create/', '<i class="glyphicon glyphicon-plus"></i> New Admission', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/admission', '<i class="glyphicon glyphicon-list"></i> ' . lang('web_list_all', array(':name' => 'Students')), 'class="btn btn-primary"'); ?> 
        <?php echo anchor('admin/admission/alumni/', '<i class="glyphicon glyphicon-thumbs-up"></i> Alumni Students', 'class="btn btn-success"'); ?>
        <?php echo anchor('admin/admission/inactive/', '<i class="glyphicon glyphicon-question-sign"></i> Inactive Students', 'class="btn btn-warning"'); ?>
    </div>
</div>

<div class="block-fluid">
   <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Student Name</th>
				<th>Gender</th>
				<th>ADM/UPI</th>
                <th>Class</th>
                <th>Birthday</th>	
                <th>Age</th>	
                <th width="20%"><?php echo lang('web_options'); ?></th>
            </tr>
        </thead>
       	<tbody>
		<?php 
              $i=0;            
            foreach ($birthdays as $p ): 
                 $i++;
                     ?>
	 <tr>
                <td><?php echo $i . '.'; ?></td>
                <td>
				    <?php
                        if (!empty($p->photo)):
						 $passport = $this->portal_m->student_passport($p->photo);
                                if ($passport)
                                {
                                        ?> 
                                        <image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="40" height="40" class="img-polaroid" style="align:left">
                         <?php } ?>	

                        <?php else: ?>   
                                <?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:40px; height:40px; align:left")); ?>
                        <?php endif; ?>  
				</td>
				<td>
				<?php echo ucwords($p->first_name . ' ' .$p->middle_name . ' ' . $p->last_name); ?>
				</td>
				<td>
				   <?php
						if (!empty($p->old_adm_no))
						{
								echo $p->old_adm_no;
						}
						else
						{
								echo $p->admission_number;
						}
						?>
						<br>
							UPI: <?php echo $p->upi_number;?>
				</td>				
				<td>
				   <?php
                        if ($p->gender == 1)
                                echo 'Male';
                        elseif($p->gender == 2)
                                echo 'Female';
						else echo $p->gender;
                        ?>
				</td>				
				<td> <?php  $classes = $this->ion_auth->fetch_classes(); echo $classes[$p->class];?></td>
				<td><?php echo date('d M Y',$p->dob);?></td>
				<td><?php 
				$date = $p->dob>10000?date('Y-m-d',$p->dob):0;
						$age = $date && $p->dob>10000?date_diff(date_create($date), date_create('today'))->y:'';
						
						if($age==0){
							$age = 1;
						}
				echo $age;?></td>

			 <td width='25%'>
						 <div class='btn-group'>
						 
							
							<a class="btn btn-success" href='<?php echo site_url('admin/admission/view/'.$p->id);?>'><i class='glyphicon glyphicon-eye-open'></i> View </a>
							
								<a class="btn btn-warning tip" onclick="return confirm('Are you sure you want to send SMS reminder to parent/guardian?')" href="<?php echo base_url('admin/admission/send_bday_sms/'.$p->id); ?>" data-original-title="To <?php echo ucwords($p->first_name); ?>, Another adventure filled year awaits you. Welcome it by celebrating your birthday with pomp and splendor. Wishing you a very happy and fun-filled birthday"><i class="glyphicon glyphicon-envelope"></i> Send  Birthday Wish</a>
							
						</div>
					</td>
				</tr>
 			<?php endforeach ?>
		</tbody>
    </table>

</div>
