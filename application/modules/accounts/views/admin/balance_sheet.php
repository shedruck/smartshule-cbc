<?php $settings = $this->ion_auth->settings(); ?>          
<div class="col-md-12">

    <div class="widget">

        <div class=" invoice">

            <div class="widget">

                <div class="col-md-12 view-title center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />  </h1>	
                    <h5><?php echo ucwords($settings->school); ?>
                        <br>
                        <span style="font-size:0.7em !important"><?php echo $settings->motto; ?></span>
                    </h5>
                    <h3> BALANCE SHEET AS AT: <?php echo date('d M, Y', time()); ?> </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx">

                    <table cellpadding="0" cellspacing="0" width="96%" style="margin: 15px auto;">
                        <tr>
                            <td width="48%" valign="top" >
                                <table width="100%"  >
                                    <thead>
                                        <tr>
                                            <th colspan="2">Assets</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php
                                        $as = 0;
 
                                        foreach ($sheet['Assets'] as $typ => $fins)
                                        {
                                            ?>
                                            <tr> <td colspan="2"><strong><?php echo $typ; ?></strong></td> </tr>
                                            <?php
                                            if (is_array($fins) && !empty($fins))
                                            {

                                                foreach ($fins as $fk)
                                                {
                                                    $k = (object) $fk;
                                                    $as += $k->dr;
                                                    ?>
                                                    <tr>
                                                        <td ><?php echo $k->account; ?></td>
                                                        <td class="rttx"><?php echo number_format($k->dr,2); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </td>
                            <td width="48%"  valign="top"> 
                                <table width="100%"  style=" margin: 0px;" >
                                    <thead>
                                        <tr>
                                            <th colspan="2">Liabilities & Equity</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php
                                        $lb = 0;
                                        
                                        foreach ($sheet['Liabilities'] as $typ => $fins)
                                        {
                                            ?>
                                            <tr> <td colspan="2"><strong><?php echo $typ; ?></strong></td> </tr>
                                            <?php
                                            if (is_array($fins) && !empty($fins))
                                            {

                                                foreach ($fins as $fk)
                                                {
                                                    $k = (object) $fk;
                                                    $lb += $k->balance;
                                                    if($k->id == 37){
                                                        $amount = $as;
                                                    }else{
                                                        $amount = $k->balance;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td ><?php echo $k->account; ?></td>
                                                        <td class="rttx"><?php echo number_format($amount,2); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        $eq = $lb;
                                        foreach ($sheet['Equity'] as $typ => $fins)
                                        {
                                            ?>
                                            <tr> <td colspan="2"><strong><?php echo $typ; ?></strong></td> </tr>
                                            <?php
                                            if (is_array($fins) && !empty($fins))
                                            {

                                                foreach ($fins as $fk)
                                                {
                                                    $k = (object) $fk;
                                                    $eq += $k->balance;
                                                    ?>
                                                    <tr>
                                                        <td ><?php echo $k->account; ?></td>
                                                        <td class="rttx"><?php echo number_format($k->balance,2); ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr >
                            <td class="ctots" ><?php echo number_format($as, 2); ?></td>
                            <td class="ctots"><?php echo number_format($as, 2) ?></td>
                          </tr>
                    </table>

                </div>
                <p>&nbsp;</p>
            </div>


        </div>

    </div>

</div>

<style>
    @media print{

        .navigation{
            display:none;
        }
        .head{
            display:none;
        }

        .tip{
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
    }
</style> 
