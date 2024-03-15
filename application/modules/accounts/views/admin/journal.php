<?php
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
                    
                    <h3> 
                        <?php
                        $from = "";
                        $to = "";
                            if($this->input->post()){
                                $from = $this->input->post('from');
                                $to = $this->input->post('to');
                                if(($from) && ($to)){
                                    $head = "JOURNAL ENTRIES BETWEEN $from AND $to";
                                }else if($from){
                                    $head = "JOURNAL ENTRIES AS AT $from";
                                }else if($to){
                                    $head = "JOURNAL ENTRIES AS AT $to";
                                }
                            }else{
                                $head = "JOURNAL ENTRIES";
                            }
                            echo $head;
                        ?>
                    </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx">
                   

                    <table cellpadding="0" cellspacing="0" width="80%" style="margin: 15px auto;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Ref</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>
                        <thead>
                        <tbody>
                            <tr>
                                <td colspan="6"><h4><b>Accounts Receivable</b></h4></td>
                            </tr>
                            <!-- Accounts Receivable -->

                            <!-- Dr -->
                            <?php
                            $index = 1;
                                foreach($invoices as $in){
                                    $student = $this->worker->get_student($in->student_id);
                                    $fname =  $student->first_name;
                                    $middle =  $student->middle_name;
                                    $lname =  $student->last_name;
                                    $stud = strtoupper($fname.' '.$middle.' '.$lname);
                            ?>
                            <tr>
                                <td><?php echo $index;?></td>
                                <td><?php echo date("d M, Y", $in->created_on)?></td>
                                <td>Tuition Invoice to <b><?php echo $stud?></b></td>
                                <td><?php echo $in->invoice_no?></td>
                                <td><?php echo number_format($in->amount,2)?></td>
                                <td></td>
                            </tr>
                              
                            <?php $index++; }?>
                           
                            <!-- Cr -->
                            <?php 
                            $index = $index;
                            $received = 0;
                            
                            foreach($tuition as $t){
                                
                                $student = $this->worker->get_student($t->reg_no);
                                $fname =  $student->first_name;
                                $middle =  $student->middle_name;
                                $lname =  $student->last_name;
                                $stud = strtoupper($fname.' '.$middle.' '.$lname);
                                $received += $t->amount;

                                ?>
                                
                            <tr>    
                                <td width="10%"><?php echo $index?></td>
                                <td><?php echo date('d M, Y', $t->payment_date)?></td>
                                <td>Fee Payment by<b> <?php echo $stud?></b></td>
                                <td>RECEIPT#:<?php echo $t->receipt_id?></td>
                                <td></td>
                                <td><?php echo number_format($t->amount,2)?></td>
                            </tr>
                            <?php $index ++; }?>
                            
                            <tr>
                            <td class="rttb" colspan="3"> Net Movement</td>
                                <td></td>
                                <td class="ctots"><?php echo number_format($received, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="5"><h4><b>Accounts Payable</b></h4></td>
                            </tr>

                            <!-- Expenses -->
                            <?php
                                $bbalance = 0;
                                $ex = 0;
                                $i = 1;
                                foreach($expenses as $e){ 
                                    $item = isset($e_item[$e->title]) ? $e_item[$e->title] : '';
                                    $ex += $e->amount;
                            ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td><?php echo date("d M, Y", $e->expense_date)?></td>
                                <td>Payment: <?php echo $item?></td>
                                <td><?php echo number_format($e->amount,2)?></td>
                                <td></td>
                            </tr>
                               <?php $i++; }
                                    // $bbalance = ($bank-$ex);
                               ?>

                            <tr>
                            <td class="rttb" colspan="3"> Net Movement</td>
                                <td></td>
                                <td class="ctots"><?php echo number_format($ex, 2) ?></td>
                            </tr>

                             <tr>
                                <td colspan="5"><h4><b>Inventory</b></h4></td>
                            </tr>
                            <?php
                                $ind = 1;
                                $ttin =0;
                                foreach($inventory as $in){
                                    $inve_item = isset($items[$in->product_id]) ? $items[$in->product_id] : '';
                                    $ttin += $in->total;
                            ?>
                            <tr>
                                    <td><?php echo $ind?></td>
                                    <td><?php echo date("d M, Y", $in->day)?></td>
                                    <td>Inventory purchase: <?php echo $inve_item?></td>
                                    <td><?php echo number_format($in->total,2)?></td>
                                    <td></td>
                            </tr>
                            <?php $ind; }?>

                            <td class="rttb" colspan="3"> Net Movement</td>
                                <td></td>
                                <td class="ctots"><?php echo number_format($ttin, 2) ?></td>
                            </tr>

                            <tr>
                                <td colspan="5"><h4><b>Bank Account/Cash</b></h4></td>
                            </tr>

                            <?php 
                            $index = 1;
                            $bank = 0;
                            foreach($tuition as $t){
                                
                                $student = $this->worker->get_student($t->reg_no);
                                $fname =  $student->first_name;
                                $middle =  $student->middle_name;
                                $lname =  $student->last_name;
                                $stud = strtoupper($fname.' '.$middle.' '.$lname);
                                $bank += $t->amount;

                                ?>
                                
                            <tr>    
                                <td width="10%"><?php echo $index?></td>
                                <td><?php echo date('d M, Y', $t->payment_date)?></td>
                                <td><b><?php echo $stud?></b></td>
                                <td><?php echo number_format($t->amount,2)?></td>
                                <td></td>
                            </tr>
                           
                            <?php  $index++; }?>

                            <!-- Expenses -->
                            <?php
                                $bbalance = 0;
                                $ex = 0;
                                $i = $index;
                                foreach($expenses as $e){ 
                                    $item = isset($e_item[$e->title]) ? $e_item[$e->title] : '';
                                    $ex += $e->amount;
                            ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td><?php echo date("d M, Y", $e->expense_date)?></td>
                                <td>Payment: <?php echo $item?></td>
                                <td></td>
                                <td><?php echo number_format($e->amount,2)?></td>
                            </tr>
                               <?php $i++; }
                                    $bbalance = ($bank-$ex);
                               ?>
                            
                            <tr>
                            <td class="rttb" colspan="3"> Net Movement</td>
                                <td></td>
                                <td class="ctots"><?php echo number_format($bbalance, 2) ?></td>
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

    .clk:hover{
        color:blue;
        text-decoration:underline;
    }
</style> 

