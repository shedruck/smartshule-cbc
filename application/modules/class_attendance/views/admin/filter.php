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
</div><?php if ($attendance): ?>
        <div class="block-fluid">
            <div class="col-md-12">
                <?php echo form_open('admin/class_attendance/filtering_attendance')?>
                <table class="table">
                   <tr>
                       <th>
                            <div>
                                <label>Attendance Date</label>
                                    <div id="datetimepicker1" class="input-group date form_datetime">
                                    <input type="text" name="attendance_date" value="" class="form-control datepicker" />                <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                       </th>

                       <th>
                            <div class="">
                                <label>Attendance Type</label>
                                    <select name="title"  class="select select-2" data-placeholder="Select Options..." >
                                        <option value="Whole Day">Whole Day</option>
                                        <option value="Morning">Morning Classes</option>
                                        <option value="Evening">Evening Classes</option>
                                        <option value="Class Time">Class Time</option>
                                    </select>        
                            </div>
                       </th>
                       
                       

                       <th>
                            <button type="submit" class="btn btn-success">Filter</button>
                       </th>
                       
                   </tr>
               </table>
                <?php echo form_close() ?>
            </div>
            <br>
            <br>
            <div class="col-md-12">
                <?php echo form_open('admin/class_attendance/filtering_attendances')?>
               <table class="table">
                   <tr>
                       <th>
                            <div>
                                <label>Attendance Date</label>
                                    <div id="datetimepicker1" class="input-group date form_datetime">
                                    <input type="text" name="attendance_date" value="" class="form-control datepicker" />                <span class="input-group-addon "><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                       </th>

                       <th>
                            <div class="">
                                <label>Attendance Type</label>
                                    <select name="title"  class="select select-2" data-placeholder="Select Options..." >
                                        <option value="Whole Day">Whole Day</option>
                                        <option value="Morning">Morning Classes</option>
                                        <option value="Evening">Evening Classes</option>
                                        <option value="Class Time">Class Time</option>
                                    </select>        
                            </div>
                       </th>
                       
                       <th>
                            <div>
                                <label>Status</label>
                                    <select name="status"  class="select select-2" data-placeholder="Select status..." >
                                        <option value="Absent">Absent</option>
                                        <option value="Present">Present</option>
                                    </select>        
                            </div>
                       </th>

                       <th>
                            <button type="submit" class="btn btn-success">Filter</button>
                       </th>
                       
                   </tr>
               </table>
               <?php echo form_close()?>
            </div>
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
                <th width=""><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                     foreach ($attendance as $p):

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