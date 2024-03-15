<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Class Attendance </h2> 
    <div class="right">
        <?php
         $class= $this->uri->segment(4) ;
        ?>
        <button class="btn btn-info" onClick="window.print();"><i class="glyphicon glyphicon-print"></i>Print</button>
        <button class="btn btn-success" onClick="window.location='<?php echo base_url()?>admin/class_attendance/filter_attendance'"><i class="glyphicon glyphicon-list"></i>All Classes</button>
        
    </div>    					
</div><?php if ($attendances): ?>
        <div class="block-fluid">
            
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Attendance Date</th>
                <th>Student</th>
                <th>Class</th>
                <th>Temperature</th>
                <th>Attendance Type</th>	
                <th>Status</th>	
                <th>Taken on</th>	
                <th>Taken By</th>	
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                     foreach ($attendances as $p):

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
                                <td><?php echo date('d M Y', $p->attendance_date); ?></td>				
                                <td><?php echo ucfirst($p->first_name.' '.$p->last_name) ?></td>
                                <td><?php echo $cc; ?></td>
                                <td><?php echo $temperature?></td>
                                <td><?php echo $p->title; ?></td>
                                <td><?php echo $p->status; ?></td>
                                <td><?php echo date('d M Y', $p->created_on); ?></td>
                                <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>
                               
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif; ?>


