<?php $settings = $this->ion_auth->settings(); ?>          
<div class="col-md-12">

    <div class="widget">

        <div class="blocdk invoice">


            <div class="widget">

                <div class="col-md-12 view-title center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />  </h1>	
                    <h5><?php echo ucwords($settings->school); ?>
                        <br>
                        <span style="font-size:0.7em !important"><?php echo $settings->motto; ?></span>
                    </h5>
                    <h3> TRIAL BALANCE AS AT: <?php echo date('d M, Y', time()); ?> </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx">

                    <table cellpadding="0" cellspacing="0" width="70%" style="margin: 15px auto;">
                        <thead>
                            <tr>
                                <th width="43%">Account</th>
                                <th width="">Code</th>
                                <th width="">Debit</th>
                                <th width="">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cr = 0;
                            $dr = 0;

                            foreach ($accounts as $typ => $fins)
                            {
                                if (is_array($fins) && !empty($fins))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="4"><strong><?php echo$typ; ?></strong></td>
                                    </tr>
                                    <?php
                                    foreach ($fins as $fk)
                                    {
                                        $k = (object) $fk;
                                        // if ($k->side)
                                        // {
                                        //     $cr += $k->balance;
                                        // }
                                        // else
                                        // {
                                        //     $dr += $k->balance;
                                        // }
                                        
                                        if(($k->code >=400) && ($k->code <600)){ 

                                        }else{
                                            $cr += $k->cr;
                                            $dr += $k->dr;
                                        ?>
                                        
                                        <tr>
                                            <td><?php echo $k->account; ?></td>
                                            <td><?php echo $k->code; ?></td>
                                            <td class="rttx"><?php echo number_format($k->dr, 2);?></td>
                                            <td class="rttx"><?php echo number_format($k->cr, 2);?></td>
                                        </tr>
                                        <?php
                                        }
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td class="ctots"><?php echo number_format($dr, 2); ?></td>
                                <td class="ctots"><?php echo number_format($cr, 2) ?></td>
                            </tr>
                        </tbody>
                    </table>

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

