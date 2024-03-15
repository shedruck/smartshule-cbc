<div class="portlet mt-2">
    <div class="portlet-heading portlet-default border-bottom">
        <h3 class="portlet-title text-dark">
           END OF YEAR LEARNERS TRANSITION PROFILE
        </h3>
        <div class="portlet-widgets">
            
            <button Class="btn btn-success btn-sm" onclick="window.location='<?php echo base_url('trs/transition_profile/create')?>'">New Entry</button>
        </div>
        <div class="clearfix"></div>
        <hr>
    </div>
    <div id="bg-default" class="panel-collapse collapse in">
        <div class="portlet-body">
            <?php if ($profiles): ?>
                <div class="table-responsive">
                     <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Allergies</th>
                                <th>Health comment</th>
                                <th>Academic Performance</th>
                                <th>Feeding habit</th>
                                <th>Behavior</th>
                                <th>Co-curriculum Activities</th>
                                <th>Parental involvement</th>
                                <th>Transport</th>
                                <th><?php echo lang('web_options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                            {
                                $i = ($this->uri->segment(4) - 1) * $per;
                            }

                            foreach ($profiles  as $p):
                                $i++;
                                $student = $this->worker->get_student($p->student);
                                
                                ?>
                                <tr>
                                    <td><?php echo $i . '.'; ?></td>					
                                    <td><?php echo $student->first_name.' '. $student->last_name; ?></td>
                                    <td><?php echo $p->allergy ?></td>
                                    <td><?php echo $p->general_health ?></td>
                                    <td><?php echo $p->general_academic ?></td>
                                    <td><?php echo $p->feeding_habit ?></td>
                                    <td><?php echo $p->behaviour ?></td>
                                    <td><?php echo $p->co_curriculum ?></td>
                                    <td><?php echo $p->parental_involvement ?></td>
                                    <td><?php echo $p->transport ?></td>
                                   
                                    <td width='30'>
                                        <div class='btn-group'>
                                            <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='mdi mdi-chevron-down'></i></button>
                                            <ul class='dropdown-menu pull-right'>
                                                <li><a href='<?php echo site_url('trs/transition_profile/view/'.$p->id.'/'.$page);?>'><i class='mdi mdi-eye-open'></i> View</a></li>
                                                <li><a  href='<?php echo site_url('trs/transition_profile/edit/'.$p->id.'/'.$page);?>'><i class='mdi mdi-pencil'></i> Edit</a></li>
                                                <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete')?>')" href='<?php echo site_url('admin/transition_profile/delete/'.$p->id.'/'.$page);?>'><i class='mdi mdi-delete-forever'></i> Trash</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
<?php echo $links; ?>
            <?php else: ?>
                <p class='text'><?php echo lang('web_no_elements'); ?></p>
            <?php endif ?>
        </div>
    </div>
</div>

