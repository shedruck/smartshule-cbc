<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Student Placement </h2> 
    <div class="right">
        <?php echo anchor('admin/students_placement/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Students Placement')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/students_placement/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
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
                <th>Start date</th>	
                <th>Duration upto</th>	

                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                    {
                            $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                    }
                    $class = $this->ion_auth->fetch_classes();
                    foreach ($students_placement as $p):
                            $i++;
                            $user = $this->ion_auth->list_student($p->student);
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                <td><?php echo $position[$p->position]; ?></td>
                                <td><?php if ($p->student_class == "Others")
                        echo 'Others';
                else
                        echo $class[$p->student_class];
                ?></td>
                                <td><?php echo date('d/m/Y', $p->start_date); ?></td>
                                <td width="15%"><?php echo date('d/m/Y', $p->duration); ?></td>
                                <td width="23%">
                                    <div class="btn-group">
									
								<a class="btn btn-success" href="<?php echo site_url('admin/students_placement/view/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                              <a class="btn btn-info" href="<?php echo site_url('admin/students_placement/edit/' . $p->id . '/' . $page); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                               <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/students_placement/delete/' . $p->id . '/' . $page); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
									
                                    </div>


                                </td>
                            </tr>
        <?php endforeach ?>
                </tbody>

            </table>
        </div>

<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>
 
