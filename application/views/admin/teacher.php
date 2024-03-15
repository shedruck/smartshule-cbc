<div class="row">
    <div class="col-md-12 middle">
        <div class="informer">
            <a href="<?php echo base_url('admin/admission/my_students'); ?>">
                <span class="icomg-user2"></span>
                <span class="text">My Students</span>
            </a>
            <span class="caption purple">Total: <?php echo $my_students; ?></span>
        </div>

        <div class="informer">
            <a href="<?php echo base_url('admin/exams'); ?>">
                <span class="icomg-clipboard1"></span>
                <span class="text">Exams Management</span>                        
            </a>
        </div>               

        <div class="informer">
            <a href="<?php echo base_url('admin/class_attendance'); ?>">
                <span class="icomg-folder"></span>
                <span class="text">Class Register</span>                        
            </a>
        </div>  
        <div class="informer">
            <a href="<?php echo base_url('admin/record_salaries/my_slips'); ?>">
                <span class="icomg-download"></span>
                <span class="text">My Payslips</span>                        
            </a>
        </div>   
        <div class="informer">
            <a href="<?php echo base_url('admin/assignments'); ?>">
                <span class="icomg-printer"></span>
                <span class="text">Assignments</span>
            </a>
        </div>  

        <div class="informer">
            <a href="<?php echo base_url('admin/extra_curricular'); ?>">
                <span class="icomg-list"></span>
                <span class="text">Extra Curricular</span>
            </a>
        </div>        
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="head dark">
                <div class="icon"><i class="icos-list"></i></div>
                <h2>Class Assignments</h2>
                <ul class="buttons">                            

                    <li><a href="<?php echo base_url('admin/assignments/'); ?>"><span class="icos-cog"></span></a></li>
                </ul>                         
            </div>                
            <div class="block-fluid">
                <table class="table table-hover" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkall"/></th>
                            <th width="25%">Title</th>
                            <th width="20%">Start </th>
                            <th width="20%">End</th>
                            <th width="20%">Status</th>
                            <th width="15%" class="TAC">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($assignments as $st):
                                $i++;
                                if ($i == 6)
                                        break;
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="order[]" value="528"/></td>

                                    <td><?php echo substr($st->title, 0, 9) . '...'; ?></td>
                                    <td><?php echo date('d/m/Y', $st->start_date); ?></td>
                                    <td><?php echo date('d/m/Y', $st->end_date); ?></td>
                                    <td><?php
                                        if ($st->end_date < time())
                                                echo '<div class="item done">
                            <span class="label label-warning">Done</span> </div>';
                                        else
                                                echo '<div class="item new">
                            <span class="label label-success">Pending</span> 
                        </div>';
                                        ?></td>                                           
                                    <td class="TAC">
                                        <a href="<?php echo base_url('admin/admission/view/' . $st->id); ?>"><span class="glyphicon glyphicon-eye-open"></span></a> 
                                        <a href="<?php echo base_url('admin/admission/edit/' . $st->id); ?>"><span class="glyphicon glyphicon-pencil"></span></a> 

                                    </td>
                                </tr>
                        <?php endforeach ?>                         
                    </tbody>
                </table>                    
            </div> 
        </div>
    </div>
</div>