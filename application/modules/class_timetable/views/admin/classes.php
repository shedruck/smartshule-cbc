<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Class Timetable</h2> 
    <div class="right">                            
       
     

    </div>    					
</div>
<?php if ($classes): ?>               
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Class</th>
                <th>Class Teacher</th>
                <th>Status</th>

                <th><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                  
                   $class = $this->ion_auth->list_classes();
                    $stream = $this->ion_auth->get_stream();

                    foreach ($classes as $p):
                            $i++;
                            $user = $this->ion_auth->get_user($p->class_teacher);
                            
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>	
                                				
                                <td>
								<?php
									$cls = isset($class[$p->class]) ? $class[$p->class] : ' -';
									$strm = isset($stream[$p->stream]) ? $stream[$p->stream] : ' -';
									echo strtoupper($cls . ' ' . $strm);
								?>
								</td>
                                
                                <td><?php echo strtoupper($user->first_name . ' ' . $user->last_name); ?></td>
								<td><?php echo $p->status ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Disabled</span>'; ?></td>

                                <td width="30%">
                                    <div class="btn-group">
                                        <a  href="<?php echo site_url('admin/class_timetable/view/' . $p->class.'/'. $p->id); ?>" class="btn btn-success" > <i class="glyphicon glyphicon-calendar"></i> View  Timetable <i class="glyphicon glyphicon-caret-down"></i></a>

										<a  href="<?php echo site_url('admin/class_timetable/create/' . $p->class.'/'. $p->id); ?>" class="btn btn-primary" > <i class="glyphicon glyphicon-calendar"></i> Manage  Timetable <i class="glyphicon glyphicon-caret-down"></i></a>
                                        

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