<?php
// print_r($this->presentStds);
// $tt= count($this->presentStds);
// echo $tt.'<br>';

// print_r($this->absentStds);
// $tt= count($this->absentStds);
// echo $tt.'<br>';

// die();
?>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Class Attendance </h2> 
    <div class="right">
        <?php
         $class= $this->uri->segment(4) ;
        ?>
        <button onClick="window.print()" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i></button>
        <button class="btn btn-danger" onClick="window.history.back();"><i class="glyphicon glyphicon-share-alt"></i>Back</button>
        <?php echo anchor('admin/class_attendance/create/' . $class . '/1', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => ' New Attendance')), 'class="btn btn-primary"'); ?>
        <?php echo anchor('admin/class_attendance/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
    </div>    					
</div><?php if ($attendances): ?>
        <div class="block-fluid">
            
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Class</th>
                <th>ClassTeacher</th>
                <th>No of Students</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                     foreach ($attendances as $p):

                         $students= count($this->classlist[$p->class_id]);
                         $absent=count($this->absentStds[$p->class_id]);
                         $present=count($this->presentStds[$p->class_id]);

                        if($p->temperature=="0"){
                            $temperature="<i>null</i>";
                        }else{
                            $temperature= $p->temperature.'<sup>0</sup>C';
                        }
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
                                <td><?php echo $cc; ?></td>
                                <td><?php echo $this->classt[$p->class_id]?></td>		
                                <td><?php echo $students?></td>
                                <td><?php echo $present?></td>
                                <td><?php echo $absent?></td>
                                <td><a class="btn btn-sm btn-success" href="<?php echo base_url('admin/class_attendance/view_attendance')?>/<?php echo $p->class_id?>/<?php echo $p->attendance_date?>/<?php echo $p->title?>/<?php echo $p->status?>">View</a></td>
                                
                               
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?>