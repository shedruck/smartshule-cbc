<?php

// echo '<pre>';
// print_r($expenses);
// echo '</pre>';
// die;
$settings = $this->ion_auth->settings(); ?>          
<div class="col-md-12">
 

    <div class="widget">

        <div class=" invoice">

            <div class="widget">
                <div class="col-md-3"></div>
                <div class = "col-md-6 pull-center hidden-print">
                    <?php echo form_open(current_url())?>
                    <div class="col-md-4"> From<input type="text" name="from" class="datepicker" > </div>
                    <div class="col-md-4"> To<input type="text" name="to" class="datepicker" > </div><br>
                    <div class="col-md-2"><button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-filter"></i></button></div>
                    <div class="col-md-2"><button class="btn btn-warning" type="button" onClick="window.print()"><i class="glyphicon glyphicon-print"></i></button></div>
                    <?php echo form_close()?>
                </div>

                <div class="col-md-12 view-title center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />  </h1>	
                    <h5><?php echo ucwords($settings->school); ?>
                        <br>
                        <span style="font-size:0.7em !important"><?php echo $settings->motto; ?></span>
                    </h5>
                    
                    <h3 > 
                            <?php
                                if($this->input->post()){
                                    $from =  $this->input->post('from');
                                    $to = $this->input->post("to");
                                    $title = "PROFIT AND LOSS STATEMENT BETWEEN $from  AND $to";
                                }else{
                                    $title = "PROFIT AND LOSS STATEMENT";
                                }
                                echo $title;
                            ?>    
                    </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx">

                    <table cellpadding="0" cellspacing="0" width="80%" style="margin: 15px auto;">

                        <tbody>
                            <?php
                            $rv = 0;
                            $exp = 0;
                            $xp = array();
                            // echo '<pre>';
                            // print_r($accounts);
                            // echo '</pre>';die;
                            foreach ($accounts as $typ => $fins)
                            {
                                if (is_array($fins) && !empty($fins))
                                {
                                    ?>
                                    <tr>
                                        <td colspan="3"><strong><?php echo$typ; ?></strong></td>
                                    </tr>
                                    <?php
                                    $exp_t = 0;
                                    foreach ($fins as $fk)
                                    {
                                        $k = (object) $fk;
                                        $rv +=$k->cr;
                                        $code= $k->code;
                                        switch ($code)
                                                {
                                                    case ($code < 400 && $code > 199):
                                                        $link = base_url('admin/accounts/expand_revenue/'.$k->code);
                                                        break;

                                                    case ($code < 600 && $code > 399):
                                                        $link = base_url('admin/accounts/expand_expenses/'.$k->id);
                                                        break;

                                                    case ($code < 800 && $code > 599):
                                                        $link = base_url('admin/accounts/expand_assets/'.$k->id);
                                                        break;

                                                    case ($code < 900 && $code > 799):
                                                        $link = base_url('admin/accounts/expand_liabilities/'.$k->id);
                                                        break;

                                                    case ($code < 1000 && $code > 899):
                                                        $link = base_url('admin/accounts/expand_equity/'.$k->id);
                                                        break;

                                                    default:
                                                        $link = 'Other';
                                                        break;
                                                 }
                                        ?>
                                        <tr>
                                            <td onclick="window.location='<?php echo $link?>'" class="clk"><i class="glyphicon glyphicon-plus btn btn-sm btn-primary hidden-print bri"></i> <?php echo $k->account; ?></td>
                                            <td class="rttx">
                                                <?php
                                                   
                                                    if($code == 200){
                                                        echo number_format($tuition->total,2);
                                                    }else if($code == 260){
                                                        echo number_format($extra->total,2);
                                                    }else if($code >= 400){
                                                        $exx = isset($e_cat[$k->id]) ? $e_cat[$k->id] : '';
                                                        $xx = isset($expenses[$exx]) ? $expenses[$exx] : '';
                                                        $exp_t += $xx;
                                                        echo $xx;
                                                    }

                                                ?>
                                            </td>
                                            <td class="rttx"></td>
                                        </tr>
                                        <?php
                                    }
                                    $xp[] = $rv;
                                }
                                ?>
                                <tr>
                                    <td class="rttb"> <strong>Total <?php echo$typ; ?></td>
                                    <td class="rttx"></td>
                                    <td class="rttx"><strong>
                                        <?php 
                                            
                                            $revenue = $tuition->total +$extra->total;
                                            if($typ == "Revenue"){
                                                echo number_format($revenue,2);
                                            }else{
                                                echo number_format($exp_t,2);
                                            }
                                            
                                        ?>
                                     </strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp; </td>
                                </tr>
                                <?php
                                $rv = 0;
                            }
                            ?>
                            <tr>
                                <td class="rttb"> PROFIT/(LOSS)</td>
                                <td></td>
                                <td class="ctots"><?php echo number_format($revenue - $exp_t,2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <p>&nbsp; </p>
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

    a{
        text-decoration:none;
    }

   .bri{

   }

    .clk:hover + .bri{
        color:blue;
        text-decoration:underline;
    }
</style> 

