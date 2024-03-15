<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Class Attendance 
        <div class="pull-right">
            <?php echo anchor('trs/list_register/' . $dat->class_id, '<i class="mdi mdi-reply"></i> Back', 'class="btn btn-primary"'); ?>
        </div>    					
    </h2>
</div>
<?php if ($post): ?> 
        <hr/>
        <div class="widget card-box table-responsive">
            <div class="block invoice">
                <div class="clearfix"></div>
                <div class="col-md-4 ">
                    <p><strong>Date: </strong><?php echo date('d M Y', $dat->attendance_date); ?> </p>
                    <p><strong>Attendance Type: </strong> <?php echo $dat->title; ?></p>
                    <p>&nbsp;</p>
					
                </div>
				 <div class="col-md-8 ">
						 <?php
						$cc = '';
						if (isset($this->classlist[$dat->class_id]))
						{
								$cro = $this->classlist[$dat->class_id];
								$cc = isset($cro['name']) ? $cro['name'] : '';
						}
						?>
						<h4>Class Register For <span style="color:green"> <?php
								echo $cc;
								?></span>
						</h4>
						<hr>
						<span class="right"><b>Total Present:</b> <?php echo $present; ?> Student(s) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   <b>Total Absent:</b> <?php echo $absent; ?> Student(s) </span>
				<hr> </div>
                
				
                <table class="table-hover table" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="8%">#</th>
                            <th width="30%">Student Details</th>
                            <th style="text-align:center" width="10%">Present</th>
                            <th style="text-align:center" width="10%">Absent</th>
                            <th width="40%">Remarks</th>
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
                                        <?php echo $u->first_name . ' ' . $u->last_name; ?>  [ ADM No. <?php
                                        if (!empty($u->old_adm_no))
                                                echo $u->old_adm_no;
                                        else
                                                echo $u->admission_number;
                                        ?> ] 
                                    </td>
                                    <?php if ($p->status == 'Present'): ?>
                                            <td style="text-align:center">
                                                <button class="btn btn-success"><span class="mdi mdi-checkbox-marked-outline"></span></button>
                                            </td>
                                            <td style="text-align:center">---</td>
                                    <?php else: ?>
                                            <td style="text-align:center">---</td>
                                            <td style="text-align:center;">
                                                <button class="btn btn-danger"><span class="mdi mdi-close"></span></button>
                                            </td>
                                    <?php endif; ?> 
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