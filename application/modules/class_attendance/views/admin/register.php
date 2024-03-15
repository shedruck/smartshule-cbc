<?php
$settings = $this->ion_auth->settings();
$refNo = refNo();
?>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Class Attendance </h2> 
    <div class="right">                            
        <?php echo anchor('admin/class_attendance/list_attendance/' . $dat->class_id, '<i class="glyphicon glyphicon-list"></i> List All Class Attendance', 'class="btn btn-primary"'); ?>
    </div>    					
</div>
<?php if ($post): ?>  
        <div class="widget">
            <div class="block invoice">
                <div class="date right">F-<?php echo $refNo; ?>-<?php echo date('y', time()) . '-' . date('2', time()) . '-' . date('H', time()); ?></div>
                <div class="clearfix"></div>
                <div class="col-md-11 view-title center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="100" height="100" />
                        <h5><?php echo ucwords($settings->motto); ?>
                            <br>
                            <span style="font-size:0.8em !important"><?php echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' Cell:' . $settings->cell ?></span>
                        </h5>
                    </h1>	
                </div>
				    <div class="clearfix"></div>
				  <div class="text-center">
							 <?php
							$cc = '';
							if (isset($this->classlist[$dat->class_id]))
							{
									$cro = $this->classlist[$dat->class_id];
									$cc = isset($cro['name']) ? $cro['name'] : '';
							}
							?>
							<h3 class="text-uppercase"><?php  echo $cc; ?> Class Register / Roll Call </h3>
							<hr>
				 <h4 class="left">
                    <abbr title="Phone"><b>Attendance Date</b>:</abbr>
                    <?php echo date('d M Y', $dat->attendance_date); ?><br>
                    <abbr title="Phone"><b>Attendance Title</b>:</abbr>
                    <?php echo $dat->title; ?>
                </h4>
				
				 <h4 class="right">
				<b>Total Present:</b> <?php echo $present; ?> Student(s)  <b>
				<br>Total Absent:</b> <?php echo $absent; ?> Student(s) </h4>
				
				
				  </div>
				    
               
                <div class="clearfix"></div>
               
               
				
                <div class="clearfix"></div>
				<hr>
                <table class="table-hover table bordered mailbox fpTable" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th >Student Details</th>
                            <th  >ADM No.</th>
                            <th style="background:#449D44" >Present</th>
                            <th style="background:#C9302C" >Absent</th>
                            <th>Body Temperature</th>
                            <th  >Remarks</th>
                            <!--<th width="15%">Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($post as $p):
                                $i++;
                                $classes = $this->ion_auth->list_classes();
                                $u = $this->ion_auth->list_student($p->student);
                                ?>
                                <tr class="new">
                                    <td><?php echo $i; ?></td>
                                    <td>
									   <span class="col-sm-2" style="text-align:center">
											<?php
											if (!empty($u->photo)):
													$passport = $this->ion_auth->passport($u->photo);
													if ($passport)
													{
															?> 
															<image src="<?php echo base_url('uploads/' . $passport->fpath . '/' . $passport->filename); ?>" width="50" height="50" class="img-polaroid" style="align:left">
													<?php } ?>	

											<?php else: ?>   
													<?php echo theme_image("thumb.png", array('class' => "img-polaroid", 'style' => "width:100px; height:100px; align:left")); ?>
											<?php endif; ?>
										</span>
									</td>
                                    <td>
                                       
                                        <a href="<?php echo base_url('admin/admission/view/' . $p->student); ?>" >
										<?php echo $u->first_name . ' ' . $u->middle_name. ' ' . $u->last_name; ?> 

										</a>
                                    </td>
                                    <td>
									     <?php
                                            if (!empty($u->old_adm_no))
                                                    echo $u->old_adm_no;
                                            else
                                                    echo $u->admission_number;
                                            ?> 
                                    </td>
                <?php if ($p->status == 'Present'): ?>
                                            <td style="text-align:center">
                                                <button class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
                                            </td>
                                            <td style="text-align:center">---</td>
                <?php else: ?>
                                            <td style="text-align:center">---</td>
                                            <td style="text-align:center">
                                                <button class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                                            </td>
                <?php endif; ?> 
                <td>
                    <?php echo $p->temperature?><sup>0</sup>C
                </td>
                                    <td><?php echo $p->remarks; ?></td>
                                </tr>
        <?php endforeach ?>        
                    </tbody>
                </table>
            </div>
        </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
                                                                        <?php endif ?>