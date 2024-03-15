<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Siblings</h2> 
    <div class="right">                            
       
        <?php echo anchor('admin/admission/', '<i class="glyphicon glyphicon-list">
                </i> All Students', 'class="btn btn-primary"'); ?>
     

    </div>    					
</div>
<?php if ($siblings): ?>              
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>No.</th>
                <th>Parent</th>
                <th>Kids</th>

                </thead>
                <tbody>
                    <?php
					$stud = $this->ion_auth->students_full_details();
					$par = $this->portal_m->fetch_parent_details();
                    $i = 1;
                    foreach ($siblings as $key => $val): 
					
					   $student = $this->portal_m->assigned_kids($val)
					
                      ?>
                            <tr class="gradeX">	
                                <td><?php echo $i; ?></td>		
                                <td><?php echo $par[$val]; ?></td>
                                <td>
								<table>
								  <?php foreach($student as $s){?>
									  <tr>
										 <td><?php echo $stud[$s->student_id]; ?></td>
										  <td width="20%">
												<a class='btn btn-success' href="<?php echo site_url('admin/admission/view/' . $s->id); ?>"><i class="glyphicon glyphicon-view"></i> View</a>

										</td>
									  </tr>
								  <?php } ?>
								</table>
								</td>
                              
                              </tr>
                            <?php
                            $i++;
                    endforeach
                    ?>
                </tbody>

            </table>


        </div>


<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?> 








