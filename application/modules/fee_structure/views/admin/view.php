
<?php
$refNo = refNo();
$settings = $this->ion_auth->settings();
?>
<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Fee Structure  </h2> 
    <div class="right">                            

        <?php echo anchor('admin/fee_structure/create/', '<i class="glyphicon glyphicon-plus"></i> Add Fee Structure', 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/fee_structure/', '<i class="glyphicon glyphicon-list"></i> List All', 'class="btn btn-primary"'); ?>
        <a href="" onClick="window.print();
                return false" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span><span class="text"> Print </span>  </a> 
    </div>    					
</div>
<div class="widget">

    <div class="block invoice">

        <div class="row">
            <div class="col-md-12 view-title">
                <span class="center">
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="150" height="150" />
                        <h5><?php echo ucwords($settings->motto); ?>
                            <br>
                            <span style="font-size:0.6em !important"><?php echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' Cell:' . $settings->cell ?></span>
                        </h5>
                    </h1></span>

                 <h3>Fee Structure</h3>			
            </div>
        </div>
 
        <table cellpadding="0" cellspacing="0" width="70%" style="margin:15px  auto;">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th>Description</th>
                    <th >Amount</th>
                    <th >Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $tot = 0;
                foreach ($fees as $fp)
                {
                    $i++;
                    $fee = (object) $fp;
                    $tot += $fee->amount;
                    ?>
                    <tr>
                        <td><?php echo $i . '. '; ?> </td>
                        <td><?php echo $fee->title; ?></td>
                        <td><?php echo $this->currency;?>. <?php echo number_format($fee->amount, 2); ?></td>
                        <td><?php echo $fee->type; ?></td>
                        
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><h2>Totals</h2></td>
                    <td> 
                        <div class="total">
                            <div class="highlight">
                                <strong><span></span> <?php echo $this->currency;?>.<?php echo number_format($tot, 2); ?>  <em></em></strong>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

         
        <div class="col-md-12">

            <div class="col-md-6 banks">
                <h3>Bank Accounts</h3>
                <?php
                foreach ($banks as $s)
                {
                    echo $s->bank_name . ' - <b>' . $s->account_number . '</b> (Branch) ' . $s->branch . '<br>';
                }
                ?>
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
        } .head{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; }
        .view-title h3{border:none !important; }

        .split{

            float:left;
            width:350px;
        } 
        .bank{

            float:left;
            width:350px;
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

