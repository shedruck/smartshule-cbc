<?php
$ct = count($this->parent->kids);
$bal = 0;
?>  
<div class="table-responsive">
    <?php
    if (!count($pledges))
    {
            ?>
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>No</strong> Pledges found.
            </div>
            <?php
    }
    else
    {
            ?>
            <table class="display">
                <tr>
                    <td>#</td>
                    <td >Due Date</td>
                    <td>Student</td>
                    <td class="text-center">Amount</td>
                    <td title="">Status</td>
                </tr>
                <tbody>
                    <?php
                    $i = 0;
                    $bl = 0;
                    foreach ($pledges as $k)
                    {
                            $std = $this->worker->get_student($k->student);
                            $i++;
                            $bl += $k->amount;
                            ?>
                            <tr >
                                <td><?php echo $i . '.'; ?></td>
                                <td class=""><?php echo date('d M Y', $k->pledge_date); ?></td>
                                <td><?php echo $std->first_name . ' ' . $std->last_name; ?></td>
                                <td class="rttx"><?php echo number_format($k->amount, 2); ?></td>
                                <td class=""><?php echo $k->status; ?></td>
                            </tr>
                            <?php
                    }
                    if ($i > 1)
                    {
                            ?>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td class="rttx"> </td>
                                <td class="rttx">TOTAL: </td>
                                <td class="rttb"><?php echo number_format($bl, 2); ?></td>
                                <td></td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
    <?php } ?>
</div><!-- End .row -->
