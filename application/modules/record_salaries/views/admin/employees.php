<div class="head"> 
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2>  Salaries  </h2>
    <?php
    if ($this->ion_auth->is_in_group($this->user->id, 3))
    {
            ?>
            <?php
    }
    else
    {
            ?>
            <div class="right">  
                <?php echo anchor('admin/record_salaries/create/' . $page, '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Salaries')), 'class="btn btn-primary"'); ?>

                <?php echo anchor('admin/record_salaries', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Salaries')), 'class="btn btn-primary"'); ?> 

            </div>
    <?php } ?>
</div>
<?php if ($record_salaries): ?>
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>#</th>
                <th>Pay Date</th>
                <th>Employee</th>
                <th>Basic Salary (<?php echo $this->currency; ?>)</th>
                <th>Bank Details</th>
                <th>Deductions (<?php echo $this->currency; ?>)</th>
                <th>Allowances (<?php echo $this->currency; ?>)</th>
                <th ><?php echo lang('web_options'); ?></th>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($record_salaries as $p):
                            $i++;
                            $u = $this->ion_auth->get_user($p->employee);
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td><?php echo date('jS M, Y', $p->salary_date); ?></td>				
                                <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>					
                                <td> <?php echo number_format($p->basic_salary, 2); ?></td>
                                <td><?php echo $p->bank_details; ?></td>
                                <td>
                                    <?php
                                    echo 'NHIF -  ' . number_format($p->nhif, 2) . '<br>';
                                    echo 'NSSF -  ' . number_format($p->nssf, 2);
                                    if (!empty($p->deductions))
                                    {
                                            $dec = explode(',', $p->deductions);
                                            foreach ($dec as $d)
                                            {
                                                    $vals = explode(':', $d);
                                                    echo $vals[0] . ' ' . number_format($vals[1], 2) . '<br>';
                                            }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if (!empty($p->allowances))
                                    {
                                            $all = explode(',', $p->allowances);
                                            foreach ($all as $l)
                                            {
                                                    $vals = explode(':', $l);
                                                    echo $vals[0] . ' ' . number_format($vals[1], 2) . '<br>';
                                            }
                                    }
                                    ?>
                                </td>
                                <td width='23%'>
                                    <div class='btn-group'>
                                        <a class="btn btn-success" href='<?php echo site_url('admin/record_salaries/slip/' . $p->id); ?>'><i class='glyphicon glyphicon-eye-open'></i> Pay Slip</a>
                                        <a  class="btn btn-danger" href='<?php echo site_url('admin/record_salaries/delete/' . $p->id); ?>' onClick="return confirm('Are you sure you want to delete this item? actions is irreversible')"><i class='glyphicon glyphicon-trash'></i> Void</a>
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