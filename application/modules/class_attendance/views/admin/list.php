<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Class Attendance </h2> 
    <div class="right">
        <?php
         $class= $this->uri->segment(4) ;
        ?>
       
        <?php echo anchor('admin/class_attendance/create/' . $class . '/1', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Attendance')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/class_attendance/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
    </div>    					
</div><?php if ($class_attendance): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Date</th>
                <th>Class</th>
                <th>Attendance Type</th>	
                <th>Taken on</th>	
                <th>Taken By</th>	
                <th width=""><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                     foreach ($class_attendance as $p):
                            $cc = '';
                            if (isset($this->classlist[$p->class_id]))
                            {
                                    $cro = $this->classlist[$p->class_id];
                                    $cc = isset($cro['name']) ? $cro['name'] : '';
                            }
                            $i++;
                            $u = $this->ion_auth->get_user($p->created_by);
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo date('d M Y', $p->attendance_date); ?></td>
                                <td><?php echo $cc; ?></td>
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                                <td width="300">
                                    <div class='btn-group'>
                                        <a href="<?php echo site_url('admin/class_attendance/view/' . $p->id); ?>" class="btn btn-success"><i class="glyphicon glyphicon-eye-open"></i> View </a>

										<a href="<?php echo site_url('admin/class_attendance/sms/' . $p->id); ?>" class="btn btn-warning"><i class="glyphicon glyphicon-comment"></i> SMS Parent </a>
										
                                        <a class="btn btn-danger" onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/class_attendance/delete/' . $p->id); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
										
                                    </div>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?>