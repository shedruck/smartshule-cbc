<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Diary  </h2>
    <div class="right">  
         
        <?php echo anchor('admin/diary', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Diary')), 'class="btn btn-primary"'); ?> 
    </div>
</div>

<?php if ($diary): ?>
    <div class="block-fluid">
         <?php echo form_open(base_url('admin/diary/approve'))?>
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th><th>Student</th><th>Activity</th><th>Date </th><th>Teacher</th><th>Status</th>
            <th>Teacher Comment</th><th>Parent Comment</th>    <th ><?php echo lang('web_options'); ?></th>
            <th width="5%"><input type="checkbox" class="checkall"/></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }
                foreach ($diary as $p):
                    $i++;
                    $status =  ['1' => '<span class="label label-success">Approved</span>', 0 => '<span class="label label-warning">Waiting Approval</span>'];
                    $tr = $this->ion_auth->get_user($p->created_by);
                    $st=$this->worker->get_student($p->student);
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>                   
                         <td><?php echo $st->first_name.' '.$st->middle_name.' '.$st->last_name; ?> (<?php echo isset($this->streams[$st->class]) ? $this->streams[$st->class] : '-'?>)</td>
                        <td><?php echo isset($activities[$p->activity]) ? $activities[$p->activity] : '-'; ?></td>
                        <td><?php echo date('dS M, Y',$p->date_); ?></td>
                        <td><?php echo $tr->first_name.' '.$tr->last_name; ?></td>
                        <td><?php echo isset($status[$p->status]) ? $status[$p->status] : ''; ?></td>
                        <td><?php echo $p->teacher_comment; ?></td>
                        <td><?php echo $p->parent_comment; ?></td>

                        <td width='30'>
                            <div class='btn-group'>
                                <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                <ul class='dropdown-menu pull-right'>
                                    <li><a href='<?php echo site_url('admin/diary/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-eye-open'></i> View</a></li>
                                    <li><a  href='<?php echo site_url('admin/diary/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit</a></li>

                                    <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/diary/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                </ul>
                            </div>
                        </td>
                        <?php
                            if($p->status == 0){
                        ?>
                        <td>
                        <input type="checkbox" name="items[<?php echo $p->id?>]" value="<?php echo $p->id ?>"/></td>
                    <?php }elseif($p->status == 1){ echo '<td></td>'; }?>
                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>

           <hr>
        <center>
            <button class="btn btn-primary" onclick="return confirm('Are you sure?')" type="submit" value="2" name="extra">Approve Selected</button>
        </center>
        <?php echo form_close()?>

    </div>

<?php else: ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
                 <?php endif ?>