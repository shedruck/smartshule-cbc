<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>&nbsp;</h2> 
    <div class="right">                       
    </div>    					
</div>
<style>
    a{color:#000;}
</style>
<div class="block invoice">
    <div class="row">
        <div class="col-md-10">           
            <h3> Inactive/Suspended Students with Balance</h3>
        </div>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th>Name</th>
                <th>Balance</th>
                <th class="rttx">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $psum = 0;
            $nsum = 0;
            foreach ($result as $s)
            {
                    $stu = $this->worker->get_student($s->student);
                    $i++;
                    $psum += $s->balance > 0 ? $s->balance : 0;
                    $nsum += $s->balance < 0 ? $s->balance : 0;
                    ?>
                    <tr>
                        <td><?php echo $i . '. '; ?></td>
                        <td class=""><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                        <td class="rttx"><?php echo number_format($s->balance, 2); ?></td>
                        <td class="rttx"><?php echo anchor('admin/fee_payment/statement/' . $s->student, 'Statement', 'target="_blank" title="View Statement" class="btn btn-primary" '); ?> </td>
                    </tr>
            <?php } ?>
            <tr>
                <td colspan="2" > </td>
                <td class="rttbx">Unpaid: <strong><?php echo number_format($psum, 2); ?></strong></td>
                <td> </td>
            </tr>
            <tr>
                <td colspan="2" > </td>
                <td class="rttbx"> Overpay: <strong><?php echo number_format($nsum, 2); ?></strong></td>
                <td> </td>
            </tr>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>
</div>
