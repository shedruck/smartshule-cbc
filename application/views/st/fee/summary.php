<?php
$ct = count($this->parent->kids);
$bal = 0;
foreach ($this->parent->kids as $pp)
{
        $bal += $pp->balance;
}
?>  
<div class="table-responsive">

    <table class="display">
        <tr >
            <td>#</td>
            <td>Student</td>
            <td title="Fee For Current Term">Term's Fee</td>
            <td>Paid</td>
            <td title="Overall Balance">Balance</td>
            <td></td>
        </tr>
        <tbody>
            <?php
            $i = 0;
            $bl = 0;
            foreach ($this->parent->kids as $k)
            {
                    $std = $this->worker->get_student($k->student_id);
                    $i++;
                    $bl += $k->balance;
                    ?>
                    <tr >
                        <td><?php echo $i . '.'; ?></td>
                        <td><?php echo $std->first_name . ' ' . $std->last_name; ?></td>
                        <td class="rttx"><?php echo number_format($k->invoice_amt, 2); ?></td>
                        <td class="rttx"><?php echo number_format($k->paid, 2); ?></td>
                        <td class="rttx"><?php echo number_format($k->balance, 2); ?></td>
                        <td><a class="btn btn-custom" href="<?php echo base_url('fee_payment/statement/' . $k->student_id); ?>" target="_blank">View Full Statement</a></td>
                    </tr>
                    <?php
            }
            if ($i > 1)
            {
                    ?>
                    <tr >
                        <td> </td>
                        <td> </td>
                        <td class="rttx"> </td>
                        <td class="rttx">TOTAL:  </td>
                        <td class="rttb"><?php echo number_format($bl, 2); ?></td>
                        <td> </td>
                    </tr>
            <?php } ?>

        </tbody></table>
</div><!-- End .row -->
