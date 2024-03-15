<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Fee Pledge  </h2>
    <div class="right">  
        <?php echo anchor('admin/fee_pledge/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Fee Pledge')), 'class="btn btn-primary"'); ?>
         <?php echo anchor('admin/fee_pledge', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Fee Pledge')), 'class="btn btn-primary"'); ?> 
     </div>
</div>
<?php if ($fee_pledge): ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
            <th>#</th>
            <th>Student</th>
            <th>Date</th>
            <th>Amount (<?php echo $this->currency;?>)</th>
            <th>Status</th>
            <th>Remark</th>	
            <th ><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }

                foreach ($fee_pledge as $p):
                    $student = $this->ion_auth->students_full_details();
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i . '.'; ?></td>					
                        <td><?php echo $student[$p->student]; ?></td>
                        <td><?php echo date('d/m/Y', $p->pledge_date); ?></td>
                        <td><?php echo number_format($p->amount, 2); ?></td>
                        <td><?php
                            if ($p->status == 'pending')
                            {
                                echo '<span class="label label-success">' . ucwords($p->status) . '</span> ';

                                $now = time(); // or your date as well
                                $p_date = date('Y-m-d', $p->pledge_date);
                                $act_date = strtotime($p_date);
                                $datediff = $act_date - $now;
                                $days = floor($datediff / (60 * 60 * 24));
                                if ($days < 0)
                                {
                                    echo ' <span class="label label-danger"> Overdue </span>';
                                }
                                elseif (0 == $days)
                                {
                                    echo ' <span class="label label-info"> ' . $days . ' Days to go  </span>';
                                }
                                else
                                {
                                    echo ' <span class="label label-warning">' . $days . ' Day(s) to go </span>';
                                }
                            }
                            else
                            {
                                echo '<span class="label label-warning">' . ucwords($p->status) . '</span>';
                            }
                            ?></td>
                        <td><?php echo $p->remark; ?></td>

                        <td width='20%'>
                            <div class='btn-group'>
                                <button class='btn dropdown-toggle' data-toggle='dropdown'>Action <i class='glyphicon glyphicon-caret-down'></i></button>
                                <ul class='dropdown-menu pull-right'>
                                    <li><a href='<?php echo site_url('admin/fee_pledge/paid/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-hand-right'></i> Mark as Paid</a></li>
                                    <li><a  href='<?php echo site_url('admin/fee_pledge/edit/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-edit'></i> Edit Details</a></li>
        <?php if ($p->status == 'pending'): ?>
                                        <li><a  href='<?php echo site_url('admin/fee_pledge/reminder/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-envelope'></i> Send Reminder</a></li>
        <?php endif; ?>
                                    <li><a  onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/fee_pledge/delete/' . $p->id . '/' . $page); ?>'><i class='glyphicon glyphicon-trash'></i> Trash</a></li>
                                </ul>
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