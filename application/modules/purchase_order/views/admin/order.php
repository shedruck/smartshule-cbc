<?php $settings = $this->ion_auth->settings(); ?>		

<div class="col-md-12">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="right print">
            <button onClick="window.print();
                    return false" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                    <?php echo anchor('admin/purchase_order', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Purchase Orders')), 'class="btn btn-primary"'); ?> 
        </div>
    </div>
    <div class="col-md-4"></div>
</div>
<div class="col-md-2"></div>
<div class="slip col-md-8">
 <div class="slip-content">
    <div class="row">

        <div class="col-md-12">

            <div class="clearfix"></div>
           
            <div class="date left">
                <b>Purchase Order #<?php
                    if ($post->id < 99)
                        echo '0' . $post->id;
                    else
                        echo $post->id;
                    ?></b><br>
              
            </div>

            <div class="clear"></div>
            <br>

            <div class="row">

                <div class="col-md-6">
                    <b style="text-decoration:underline">To:  <?php echo $supplier->company_name; ?></b>
                    <br>
                    <address>
                        <strong>Contact Person: </strong><?php echo $supplier->title; ?><br>
                        Box <?php echo $supplier->address; ?> 
                        <?php echo $supplier->city . ', ' . $supplier->country; ?><br>
                        <abbr title="TEL"><b>Tel:</b></abbr> <?php echo $supplier->landline; ?> 
                        <abbr title="Cell"><b>Cell:</b></abbr> <?php echo $supplier->phone; ?>
                    </address>                                
                </div>

                <div class="col-md-6 ">
                    <div class="right">
                        <b style="text-decoration:underline">Purchase Order</b><br>
                        <br>
                        <strong>Date: </strong> <?php echo date('M d, Y ', $post->purchase_date); ?><br>
                        <strong>Reference:</strong> #<?php if ($post->id < 99)
                            echo '0' . $post->id;
                        else
                            echo $post->id;
                        ?><br>
                        <strong>Payment due: </strong> <?php echo date('d M Y', $post->due_date); ?>

                    </div>
                </div>
            </div>

            <b>Attention:</b> <abbr title="name"><?php echo $supplier->title; ?></abbr>
            <br>
            <br>
            <b style="text-decoration:underline">Description</b>
            <p>

                <strong>We are pleased to confirm our purchase of the following Items:</strong>

            </p>

            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="3">No.</th>
                        <th width="67%">Description</th>

                        <th width="10%">Quantity</th>
                        <th width="10%">Amount</th>
                        <th width="10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;

                    foreach ($details as $p):

                        $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $p->description; ?></td>
                            <td><?php echo $p->quantity; ?></td>
                            <td><?php echo number_format($p->unit_price, 2); ?></td>
                            <td><?php echo number_format($p->totals, 2); ?></td>
                        </tr>
<?php endforeach; ?>                                         
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <b style="text-decoration:underline">Comment:</b><br>
<?php echo $post->comment; ?>
                </div>
                <div class="col-md-6">
                    <div class="right">
                        <strong><span>Subtotal: <?php echo $this->currency;?> </span></strong>
                        <strong> <?php echo number_format($post->total, 2); ?><em> </em></strong>
                        <br>
                        <strong><span>VAT: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></strong>
                        <strong><?php
                            $vat = $tax->amount;
                            if ($post->vat == 1)
                            {
                                echo $tax->amount; //echo $vat;
                            }
							else {
                                echo 0; //echo $vat;
                            }
                            ?>  %</strong>
                        <br>
                        <strong><span>Total: <?php echo $this->currency;?>  </span></strong>

                        <b style="border-bottom:1px solid #333"><span></span>
                            <?php
                            $vat = $tax->amount;
                            if ($post->vat == 1)
                            {
                                $t = ($post->total * $vat) / 100; //echo $vat;
								 echo number_format($t + $post->total, 2);
                            }
                            else{ echo number_format($post->total, 2);}
                            ?> <em> </em></b>


                    </div>


                </div>
            </div>
        </div>
        <h3></h3>
        <p>
        </p>


    </div>


    <div class="row">
        <div class="col-md-6">
            <br>
            <br>
            <strong style="border-top:1px solid #000"> Prepared By</strong>

        </div>
        <div class="col-md-6">
            <br>
            <br>
            <strong class="right" style="border-top:1px solid #000"> Approved By </strong>
        </div>


    </div>
    <div class="row">

        <br>
        <div class="col-md-11 center">
            <b>NB:</b> Purchase Order only accepted when stamped and signed.
        </div>
    </div>
    <div class="center" style="border-top:1px solid #ccc">		
        <span class="center" style="font-size:0.8em !important;text-align:center !important;"><?php echo $settings->postal_addr . ' Tel: ' . $settings->tel . ' Cell: ' . $settings->cell ?></span>
    </div>

</div>  
</div>  


<div class="col-md-2"></div>	


<style>
    @media print{

        .col-md-4 {
            width: 200px !important;
            float: left !important;
        }
        .right{
            float:right;

        }
        .bold{
            font-weight:bold;
            font-size:1.5em;
            color:#000;
        }
        .kes{
            color:#000;
            font-weight:bold;
        }
        .item{
            padding:3px;
        }
        .col-md-3 {
            width: 200px !important;
            float: left !important;
        }
        .col-md-6 {
            width: 300px !important;
            float: left !important;
        }
        .col-md-2 {
            width: 150px !important;
            float: left !important;
        }

        .navigation{
            display:none;
        }
        .alert{
            display:none;
        }
        .alert-success{
            display:none;
        }

        .img{
            align:center !important;
        } 
        .print{
            display:none !important;
        }
        .bank{
            float:right;
        }
        .view-title h1{border:none !important; text-align:center }
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