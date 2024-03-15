<div >
    <div class="row hidden-print">
        <div class="col-md-12">
            <div class="page-header row">
                <div class="col-md-9">
                    <h3 class="text-bold">View Invoice</h3>
                </div>
                <div class="col-md-3">
                     <a href="javascript:window.print()" class="btn btn-success"><i class="glyphicon glyphicon-print"></i> Print</a>
                    <a href="<?php echo base_url('admin/supplier_invoices'); ?>" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-box">
        <center>
        <div class="col-xs-3 col-md-3">
                                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" alt="" style="width: 80%;">
                            </div>
                            <div class="col-xs-8 col-md-8">
                                <h1><?php echo $this->school->school; ?></h1>
                                <br>
                                <?php
                                if (!empty($this->school->tel))
                                {
                                    echo $this->school->postal_addr . '<br> Tel:' . $this->school->tel . ' ' . $this->school->cell;
                                }
                                else
                                {
                                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                                }
                                ?>
                            </div>
            <h3>Supplier Invoices</h3>
        </center>
        <hr>
        <div class="row">
            <div class="col-md-12">

                <div class="pull-left m-t-30">
                    <address>
                        <strong>To:</strong><br>
                        <p> <?php echo $receipt->supplier; ?></p> 
                        <p> <?php echo $receipt->supplier_email; ?></p> 
                          Tel. <?php echo $receipt->supplier_phone; ?>
                    </address>
                </div>
                <div class="pull-right m-t-30">
                    <h4>Invoice# <strong>INV<?php echo str_pad($receipt->id, 4, '0', 0); ?></strong> </h4>
                    <p><strong>Date: </strong><?php echo date('d M Y', $receipt->created_on); ?></p>
                    <p> </p>
                </div>
            </div>
        </div>
        
        <div class="m-h-50"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table m-t-30">
                        <thead>
                            <tr>
                                <th>Item No.</th>
                                <th>Description</th>
                                <th>Qty.</th>
                                <th>Unit Price</th>
                                <th>Price in Kshs.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $total = 0;
                            foreach ($receipt->items as $p)
                            {
                                $i++;
                                $sub_total = $p->quantity * $p->unit_price;
                                $total += $sub_total;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?>.</td>
                                    <td><?php echo $p->item; ?></td>
                                    <td><?php echo $p->quantity; ?></td>
                                    <td><?php echo number_format($p->unit_price, 2); ?></td>
                                    <td><?php echo number_format($sub_total, 2); ?></td>
                                </tr>
                            <?php } ?>                              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>           
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">

            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 ">                     
                <h3 class="pull-right">Total: <?php echo number_format($total, 2); ?></h3>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-11 ">
                <div class=" pull-left mtt">
                    <p> Prepared By  <u><strong>
                <?php
			        $u = $this->ion_auth->get_user($receipt->created_by);
                     echo $u->first_name.' '. $u->last_name;
                ?>
                   </strong></u>
                    </p>
                    <p> Signature ....................................................</p>
                    <p> Designation ....................................................</p>
                    <hr>
                    <p> Approved By:</p>
                    <p> Head of Institution ....................................................</p>
                    <p>&nbsp;</p>
                    <p> Signature ....................................................</p>
                </div>
                <div class="pull-right mtt">
                    <p> Vote Head <strong> <?php 

                        $account_id = isset($expense_categories[$receipt->expense]) ? $expense_categories[$receipt->expense] : '';
                        echo  isset($accounts[$account_id]) ? $accounts[$account_id] : '';

                    ?>   </strong></p>
                    <p>&nbsp;</p>
                    <p>Date ....................................................</p>
                    <hr>
                    <p>&nbsp;</p>
                    <p>Date ....................................................</p>
                </div>
                <div class="clearfix"></div>
                <!-- <p>Confirm that funds are available and that the commitment has been noted in the Commitment Register/Notebook</p> -->
            </div>
        </div>        
    </div>
</div>
<style>
    
hr {
    margin-top: 5px;
    margin-bottom: 5px;
}
    @media print
    {
        body{background: #FFF !important; background-image: none;}
        .card-box {  padding: 5px !important;border: 0 !important; }
       #scrollUp { display: none !important; }
    }
    .sepp{page-break-after: always !important;}
    p{ font-size: 14px; margin-bottom: 5px;}
    .mtt p{ margin-bottom: 10px;}
</style>