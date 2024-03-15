<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Extra Curricular Activities  </h2>
    <div class="right">  
        <?php echo anchor('admin/extra_curricular/create/', '<i class="glyphicon glyphicon-plus"></i> Add Student To Activity', 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/activities/', '<i class="glyphicon glyphicon-pencil">  </i> Manage Activities', 'target="blank" class="btn btn-primary"'); ?>
    </div>
</div>
<?php if ($post): ?>
        <div class="block-fluid">
            <table class="table" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Term</th>
                        <th>Year</th>
                        <th>Activity</th> 
						<th>Created On</th>
                        <th>Created By</th>
                      
                        <th><?php echo lang('web_options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                   $stud = $this->ion_auth->students_full_details();  
                   $act = $this->ion_auth->populate('activities','id','name');  
                    foreach ($post as $p):
                          $i++;  
						  $usr = $this->ion_auth->get_user($p->created_by);
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $stud[$p->student]; ?></td>
                                <td><?php echo $p->term; ?></td>
                                <td><?php echo $p->year; ?></td>
                                <td><?php echo $act[$p->activity]; ?></td>
                               
                                <td><?php echo date('d M Y',$p->created_on); ?></td> 
								<td><?php echo $usr->first_name . ' ' . $usr->last_name; ?></td>
                                <td >
                                    <div class="btn-group">
                                      <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href="<?php echo site_url('admin/extra_curricular/delete/' . $p->id); ?>"><i class="glyphicon glyphicon-trash"></i> Remove</a>
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>


        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
 <?php endif ?>