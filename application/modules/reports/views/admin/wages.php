
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Wages Report</h2> 
</div>
<div class="block invoice">

    <?php if (!empty($post)): ?>
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="3%">#</th>
                        <th width="">Month / Year</th>
                        <th width="">No. of Employees Paid</th> 
                        <th width="">Pay Date</th>
                        <th width="">Processed Salary (<?php echo $this->currency;?>)</th>
                        <th width="">Total Deductions (<?php echo $this->currency;?>)</th>
                        <th width="">NHIF (<?php echo $this->currency;?>)</th>
                        <th width="">Total Advance (<?php echo $this->currency;?>)</th>
                        <th width="">Total Paid (<?php echo $this->currency;?>)</th>
                        <th width="">Paid By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($post as $p)
                    {
                            $total_paid = (object) $p->total_paid;
                            $all_deductions = (object) $p->all_deductions;
                            $nhif = (object) $p->nhif;
                            $no_employees = (object) $p->no_employees;
                            $u = $this->ion_auth->get_user($p->created_by);
                             $i++;
                            ?>

                            <tr>
                                <td><?php echo $i . '. '; ?></td>
                                <td><?php echo $p->month . ' - ' . $p->year; ?></td>
                                <td><?php
                                    if ($p->employee == 1)
                                            echo $p->no_employees . ' Employee';
                                    else
                                            echo $p->no_employees . ' Employees';
                                    ?></td> 
                                <td><?php echo date('d M Y', $p->salary_date); ?></td>
                                <td><b ><?php echo number_format($p->total_paid, 2) ?></b></td>
                                <td><b ><?php echo number_format($p->all_deductions, 2) ?></b></td>
                                <td><b ><?php echo number_format($p->nhif, 2) ?></b></td>
                                <td><b > <?php echo number_format($p->advance, 2) ?></b></td>
                                <td><b > <?php
                                        $tt = $p->total_paid - $p->advance;
                                        echo number_format($tt, 2)
                                        ?></b></td>

                                <td><?php echo $u->first_name . ' ' . $u->last_name; ?></td>

                            </tr>
                            <?php
                    }
                    ?>
                </tbody>
            </table>
    <?php else: ?>
            <h3>No Salaries processed at the moment</h3>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">

        </div>
    </div>

