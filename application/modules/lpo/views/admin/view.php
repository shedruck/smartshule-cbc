<div >
    <div class="row hidden-print">
        <div class="col-md-12">
            <div class="page-header row">
                <div class="col-md-9">
                    <h3 class="text-bold">View LPO</h3>
                </div>
                <div class="col-md-3">
                     <a href="javascript:window.print()" class="btn btn-success"><i class="glyphicon glyphicon-print"></i> Print</a>
                    <a href="<?php echo base_url('admin/lpo'); ?>" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-box">
        <center>
           <div class="row-fluid center">
        <div class="col-sm-12">
            <span class="" style="text-align:center">
                <img src="<?php echo base_url('uploads/files/' . $this->school->document); ?>" class="center"  width="50" height="50" />
            </span>
            <h3>
                <span style="text-align:center !important;font-size:15px;"><?php echo strtoupper($this->school->school); ?></span>
            </h3>
            <small style="text-align:center !important;font-size:12px; line-height:2px;">
                <?php
                if (!empty($this->school->tel))
                {
                    echo $this->school->postal_addr . ' Tel:' . $this->school->tel . ' ' . $this->school->cell;
                }
                else
                {
                    echo $this->school->postal_addr . ' Cell:' . $this->school->cell;
                }
                ?>
            </small>
            <h3>
                <span style="text-align:center !important;font-size:13px; font-weight:700; border:double; padding:5px;">MOTTO: <?php echo strtoupper($this->school->motto); ?></span>
            </h3>
            <br>
            <small style="text-align:center !important;font-size:20px; line-height:2px; border-bottom:2px solid  #ccc;">Exams Performance Terminal Report</small>
            <br>
            <h4>
                <?php
                $c_t = '';
                if ($class)
                {
                    $c_t = isset($this->streams[$class]) ? $this->streams[$class].' - ' : ' - ';
                }
                if ($ex)
                {
                    echo $c_t.'  ' . $ex->title . ' - Term ' . $ex->term . ' ' . $ex->year;
                }
                ?>
            </h4>
            <br>
        </div>
    </div>
            <h3>LOCAL PURCHASE ORDER</h3>
        </center>
        <hr>
        <div class="row">
            <div class="col-md-12">

                <div class="pull-left m-t-30">
                    <address>
                        <strong>To:</strong><br>
                        <p> <?php echo $lpo->supplier->name; ?></p> 
                        <p> <?php echo $lpo->supplier->email; ?></p> 
                          Tel. <?php echo $lpo->supplier->phone; ?>
                    </address>
                </div>
                <div class="pull-right m-t-30">
                    <h4>LPO # <strong><?php echo str_pad($lpo->id, 4, '0', 0); ?></strong> </h4>
                    <p><strong>Date: </strong><?php echo date('d M Y', $lpo->lpo_date); ?></p>
                    <p> </p>
                </div>
            </div>
        </div>
        <p class="col-md-offset-3"> Please deliver the following goods to ....................................................<br>
            on or before .................................................... and submit invoice <br>without delay to  ....................................................
        </p>
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
                            foreach ($lpo->items as $p)
                            {
                                $i++;
                                $sub_total = $p->quantity * $p->unit_price;
                                $total += $sub_total;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?>.</td>
                                    <td><?php echo $p->name; ?></td>
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
                    <p> Prepared By ....................................................</p>
                    <p> Signature ....................................................</p>
                    <p> Designation ....................................................</p>
                    <hr>
                    <p> Approved By:</p>
                    <p> Head of Institution ....................................................</p>
                    <p>&nbsp;</p>
                    <p> Signature ....................................................</p>
                </div>
                <div class="pull-right mtt">
                    <p> Vote Head ....................................................   </p>
                    <p>&nbsp;</p>
                    <p>Date ....................................................</p>
                    <hr>
                    <p>&nbsp;</p>
                    <p>Date ....................................................</p>
                </div>
                <div class="clearfix"></div>
                <p>Confirm that funds are available and that the commitment has been noted in the Commitment Register/Notebook</p>
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