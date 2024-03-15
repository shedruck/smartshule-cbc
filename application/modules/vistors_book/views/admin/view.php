<div >
    <div class="row hidden-print">
        <div class="col-md-12">
            <div class="page-header row">
                <div class="col-md-9">
                    <h3 class="text-bold">Visitor Gate Pass</h3>
                </div>
                <div class="col-md-3">
                     <a href="javascript:window.print()" class="btn btn-success"><i class="glyphicon glyphicon-print"></i> Print</a>
                    <a href="<?php echo base_url('admin/vistors_book'); ?>" class="pull-right btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
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
            <h3>Visitors Gate Pass</h3>
        </center>
        <hr>
        <div class="row">
            <div class="col-md-12">

                <div class="pull-left m-t-30">
                    <address>
                        <strong>Visitor :</strong><br>
                        <p> <?php echo $result->name; ?></p> 
                        <p> <?php echo $result->email; ?></p> 
                        <p> Tel. <?php echo $result->phone; ?></p>
                        <p>National Id. <?php echo $result->n_id; ?></p>
                    </address>
                </div>
                <div class="pull-right m-t-30">
                    <h4>Visitor# <strong><?php echo str_pad($result->id, 4, '0', 0); ?></strong> </h4>
                    <p><strong>Date: </strong><?php echo date('d M Y H:m', $result->created_on); ?></p>
                    <p> </p>
                </div>
            </div>
        </div>
        
        <div class="m-h-50"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table m-t-30">
                         <tr>
                             <th>Person To See</th>
                             <th><abbr title="Person" style="font-size:15px"><?php echo $result->person?></abbr></th>
                         </tr>

                         <tr>
                             <th>Reason</th>
                             <th><abbr title="description" style="font-size:15px"><?php echo $result->description?></abbr></th>
                         </tr>

                         <tr>
                             <th>Check In Time</th>
                             <th><abbr title="Time In" style="font-size:15px"><?php echo date('d M,Y H:m',$result->created_on)?></abbr></th>
                         </tr>
                    </table>
                </div>
            </div>
        </div>           
         <br><br><br><br>
        <hr>
        <div class="row">
            <div class="col-md-11 ">
                <div class=" pull-left mtt">
                    <p> Prepared By  <u><strong>
                <?php
			        $u = $this->ion_auth->get_user($result->created_by);
                     echo $u->first_name.' '. $u->last_name;
                ?>
                   </strong></u>
                    </p>
                    <p> Signature ....................................................</p>
                    <p>&nbsp;</p>
                    <hr>
                     
                    <p> Date <abbr title="Time In" style="font-size:15px"><?php echo date('d M,Y H:m',$result->created_on)?></abbr></p>
                </div>
                <div class="pull-right mtt">
                    <p> Received By <abbr title="Person" style="font-size:15px"><?php echo $result->person?></abbr>  </p>
                    <p>&nbsp;</p>
                    <p>Sign ....................................................</p>
                    <hr>
                    <p>&nbsp;</p>
                    <p>Date ....................................................</p>
                </div>
                <div class="clearfix"></div>
                <CENTER><h3>WELCOME</h3></CENTER>
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