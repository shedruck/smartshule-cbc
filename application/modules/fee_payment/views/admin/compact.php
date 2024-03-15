<?php
$refNo = refNo();
$settings = $this->ion_auth->settings();
?>

<div class="widget">

    <div class="block invoice">
        <div class="row">
            <div class="date  right" id="menus">
                <a href="<?php echo site_url('admin/fee_payment/fee_stat/'); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-file"></i>View Detailed</a>
                <a href="<?php echo site_url('admin/fee_payment/'); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-list"></i> List Fee Statements</a>
                <a href="" onClick="window.print();
                        return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
            </div>
            <div class="col-md-11 view-title ">
                <span class="center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="150" height="150" />
                        <h5><?php echo ucwords($settings->motto); ?>
                            <br>
                            <span style="font-size:0.6em !important"><?php echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' Cell:' . $settings->cell ?></span>
                        </h5>
                    </h1>
                </span>
                <h3> SCHOOL FEE PAYMENT STATEMENT AS AT: <?php echo date('d M, Y H:i', time()); ?> </h3>
                <span class="date">Date: <?php echo date('d M, Y H:i', time()); ?></span>

                <?php
                $cl = $this->ion_auth->list_classes();
                $stream = $this->ion_auth->get_stream();
                ?>	
                <div class="clearfix"></div>

            </div>
        </div>
        <div style="width:80%; margin:15px auto;">
            <?php
            $ibal = 0;
            ksort($payload);
            $ypd = 0;
            $ywv = 0;
            $yinv = 0;
            foreach ($payload as $y => $p):
                ksort($p)
                ?>
                <span class="highlight">  <strong><span><?php echo $y; ?></span>  </strong>  </span> 
                <?php
                $i = 0;
                foreach ($p as $term => $trans)
                {
                    ?> <table cellpadding="0" cellspacing="0" width="100%" > 
                        <tr >
                            <td width="55%"><b><?php echo $this->terms[$term]; ?></b></td> 
                            <td width="45%"  class="rttx"><b>Balance Brought Forward: </b><?php echo number_format($ibal, 2); ?></td>
                        </tr> 
                    </table>

                    <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 6px;">
                        <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th width="27%">Transaction Type</th>
                                <th width="15%">Debit</th>
                                <th width="15%">Credit</th>
                                <th width="15%">Balance</th>
                            </tr>
                        </thead>
                        <tbody> <?php
                            $dr = 0;
                            $cr = 0;
                            $wv = 0;
                            $idw = 0;
                            foreach ($trans as $type => $paidd)
                            {
                                sort_by_field($paidd, 'date');
                                foreach ($paidd as $paid)
                                {
                                    $paid = (object) $paid;

                                    $debit = $type == 'Debit' ? $paid->amount : 0;
                                    $credit = $type == 'Credit' ? $paid->amount : 0;

                                    if ($debit)
                                    {
                                        $idw = $paid->date;
                                    }
                                    $waiver = $type == 'Waivers' ? $paid->amount : 0;
                                    $dr +=$debit;
                                    $cr +=$credit;
                                    $wv +=$waiver;
                                }
                            }
                            $ypd += $cr;
                            $yinv += $dr;
                            $ywv += $wv;
                            $ibal +=$dr;
                            ?>
                            <tr><td><?php echo ($i + 1) . '. '; ?></td> 
                                <td>Fees Payable - Invoices</td> 
                                <td class="rttx"><?php echo number_format($dr, 2); ?></td>
                                <td class="rttx">0.00</td>
                                <td class="rttx"><?php echo number_format($ibal, 2); ?></td>
                            </tr>
                            <?php $ibal -=$wv; ?>
                            <tr><td><?php echo ($i + 2) . '. '; ?></td> 
                                <td>Total Fees Waivers</td>
                                <td class="rttx">0.00</td> 
                                <td class="rttx"><?php echo number_format($wv, 2); ?></td>
                                <td class="rttx"><?php echo number_format($ibal, 2); ?></td>
                            </tr>
                            <?php $ibal -=$cr; ?>
                            <tr><td><?php echo ($i + 3) . '. '; ?></td> 
                                <td>Total Fee Paid </td> 
                                <td class="rttx">0.00</td>
                                <td class="rttx"><?php echo number_format($cr, 2); ?></td>
                                <td class="rttx"><?php echo number_format($ibal, 2); ?></td>
                            </tr>

                            <tr style="border-bottom:3px #000 double;">
                                <td></td>
                                <td class="rttb"><b>TERM TOTALS</b></td>
                                <td class="rttb"><?php echo number_format($dr, 2); ?></td>
                                <td class="rttb"><?php echo number_format($cr + $wv, 2); ?></td>
                                <td class="rttb"><?php echo number_format($ibal, 2); ?></td> 
                            <tr>

                        </tbody>
                    </table>

                <?php } ?>
            <?php endforeach; ?>
            <hr><table width="100%"><tr style="border-bottom:3px #000 double;">
                    <td></td>
                    <td></td>
                    <td class="rttb"><b>YEAR TOTALS</b></td>
                    <td class="rttb">Fee Due: <?php echo number_format($yinv, 2); ?></td>
                    <td class="rttb">Paid: <?php echo number_format($ypd, 2); ?></td>
                    <td class="rttb">Waivers: <?php echo number_format($ywv, 2); ?></td> 
                    <td></td>
                    <td></td>
                <tr></table>
        
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="total"> 
                    <span class="highlight">
                        <strong><span>Balance:</span> <?php echo $this->currency;?>.<?php echo number_format($ibal, 2); ?>   <em></em></strong>

                    </span>
                </div>
            </div>
        </div>
</div>
    </div>

</div>


<style>
    @media print{

        .navigation{
            display:none;
        }

        .tip{
            display:none !important;
        } 
        #menus{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; }
        .view-title h3{border:none !important; }

        .split{

            float:left;
        }
        .header{display:none}
        .invoice { 
            width:100%;
            margin: auto !important;
            padding: 0px !important;
        }
        .invoice table{padding-left: 0; margin-left: 0; }

        .smf .content {
            margin-left: 0px;
        }
        .content {
            margin-left: 0px;
            padding: 0px;
        }

        view-title{
            border: none !important;

        }
        h3{
            border: none !important;

        }
    }
</style>     

