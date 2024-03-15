<?php
$settings = $this->ion_auth->settings(); ?>          
<div class="col-md-12">

    <div class="widget">

        <div class=" invoice">

            <div class="widget">
                    <!-- here -->
                <div class="col-md-12 view-title center">
                    <button class="btn btn-sm btn-danger hidden-print pull-left" onClick='window.history.back()'>Back</button>
                    <button class="btn btn-sm btn-success hidden-print pull-left" onClick='window.print()'>Print</button>
                    <h1><img src="<?php echo base_url('uploads/files/' . $settings->document); ?>" width="80" height="80" />  </h1>	
                    <h5><?php echo ucwords($settings->school); ?>
                        <br>
                        <span style="font-size:0.7em !important"><?php echo $settings->motto; ?></span>
                    </h5>
                    <?php
                    $today = date('d M, Y',time());
                        if(isset($tuition)){
                            $heading = "TUITION FEE INVOICES AS AT $today";
                        }
                        if(isset($f_extras)){
                            $heading = "FEE EXTRAS INVOICES AS AT $today";
                        }
                        if(isset($expenses)){
                            $accID= $this->uri->segment(4);
                            $account =  $accounts[$accID];
                            $heading = "EXPENSES FOR ".strtoupper($account)." AS AT $today";
                        }

                        if(isset($waivers)){
                            $heading = "WAIVERS AS AT ";
                        }

                        if($this->input->post()){
                            $frm = date("d M, Y", $from);
                            $tu = date("d M, Y", $to);
                            if(isset($expenses)){
                                $accID= $this->uri->segment(4);
                                $account =  $accounts[$accID];
                                $heading = "EXPENSES FOR ".strtoupper($account)." BETWEEN $frm AND $tu ";
                            }

                            if(isset($tuition)){
                                $heading = "TUITION FEE INVOICES BETWEEN $frm AND $tu";
                            }

                            if(isset($f_extras)){
                                $heading = "FEE EXTRAS INVOICES BETWEEN $frm AND $tu ";
                            }
                        }

                        
                    ?>
                    <h3> <?php echo $heading?> </h3>
                    <div class="clearfix"></div>
                    <div>&nbsp;</div>
                </div>

                <div id="tabxx">

                    <?php if(isset($tuition)){
                        ?>
                    <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class = "col-md-6 pull-center hidden-print">
                                <?php echo form_open(current_url())?>
                                <div class="col-md-5"> From<input type="text" name="from" class="datepicker" > </div>
                                <div class="col-md-5"> To<input type="text" name="to" class="datepicker" > </div><br>
                                <div class="col-md-2"><button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-filter"></i></button></div>
                                <?php echo form_close()?>
                            </div>
                        </div>
                       
                    <table cellpadding="0" cellspacing="0" width="80%" style="margin: 15px auto;">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Invoiced Date</th>
                            <th>Term</th>
                            <th>Year</th>
                            <th>Amount</th>
                            <th>Created By</th>
                        </tr>
                        <?php
                        $index=1;
                        $total = 0;
                        // echo '<pre>';
                        // print_r($tuition);
                        // echo '</pre>';die;
                        foreach($tuition as $t){
                            $total += $t->amount;
                            $user =  $this->ion_auth->get_user($t->created_by);
                            $std =  $t->student_id;
                            $student = $this->worker->get_student($std);
                            $names = $student->first_name.' '.$student->last_name.' '.$student->middle_name;
                        ?>
                        <tr>
                            <td><?php echo $index?></td>
                            <td><?php echo ucwords($names).'-'.$student->admission_number?></td>
                            <td><?php echo date("d M Y", $t->created_on)?></td>
                            <td>Term <?php echo $t->term?></td>
                            <td><?php echo $t->year?></td>
                            <td><?php echo number_format($t->amount)?></td>
                            <td><?php echo $user->first_name.' '.$user->last_name?></td>
                        </tr>
                       

                        <?php $index++; }?>
                        <tr>
                            <td class="rttb" colspan="5"> TOTAL </td>
                            <td><?php //echo number_format($dr, 2); ?></td>
                            <td class="ctots"><?php echo number_format($total,2) ?></td>
                        </tr>
                    </table>
                    <?php }?>

                    <?php
                        if(isset($f_extras)){?>
                        <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class = "col-md-6 pull-center hidden-print">
                                <?php echo form_open(current_url())?>
                                <div class="col-md-5"> From<input type="text" name="from" class="datepicker" > </div>
                                <div class="col-md-5"> To<input type="text" name="to" class="datepicker" > </div><br>
                                <div class="col-md-2"><button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-filter"></i></button></div>
                                <?php echo form_close()?>
                            </div>
                        </div>
                        <table cellpadding="0" cellspacing="0" width="80%" style="margin: 15px auto;">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Invoiced Date</th>
                            <th>Term</th>
                            <th>Year</th>
                            <th>Amount</th>
                            <th>Created By</th>
                        </tr>
                        <?php
                        $index=1;
                        $total=0;
                        foreach($f_extras as $t){
                            $total +=$t->amount;
                            $user =  $this->ion_auth->get_user($t->created_by);
                            $std =  $t->student;
                            $student = $this->worker->get_student($std);
                            $names = $student->first_name.' '.$student->last_name.' '.$student->middle_name;
                        ?>
                        <tr>
                            <td><?php echo $index?></td>
                            <td><?php echo ucwords($names).'-'.$student->admission_number?></td>
                            <td><?php echo date("d M Y", $t->created_on)?></td>
                            <td>Term <?php echo $t->term?></td>
                            <td><?php echo $t->year?></td>
                            <td><?php echo number_format($t->amount)?></td>
                            <td><?php echo $user->first_name.' '.$user->last_name?></td>
                        </tr>
                       

                        <?php $index++; }?>
                        <tr>
                            <td class="rttb" colspan="5"> TOTAL </td>
                            <td><?php //echo number_format($dr, 2); ?></td>
                            <td class="ctots"><?php echo number_format($total,2) ?></td>
                        </tr>
                       
                    </table>
                    <?php }?>

                    <?php

                        if(isset($expenses)){ ?>
                        <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class = "col-md-6 pull-center hidden-print">
                                <?php echo form_open(current_url())?>
                                <div class="col-md-5"> From<input type="text" name="from" class="datepicker" > </div>
                                <div class="col-md-5"> To<input type="text" name="to" class="datepicker" > </div><br>
                                <div class="col-md-2"><button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-filter"></i></button></div>
                                <?php echo form_close()?>
                            </div>
                        </div>
                        <table cellpadding="0" cellspacing="0" width="80%" style="margin: 15px auto;">
                        <tr>
                            <th>#</th>
                            <th>Expense Date</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Person Responsible</th>
                            <th>Desciption</th>
                            <th>Recorded By</th>
                        </tr>
                        <?php
                        $index=1;
                        $total=0;
                        foreach($expenses as $e){
                            $personel= $this->ion_auth->get_user($e->person_responsible);
                            $user= $this->ion_auth->get_user($e->created_by);
                            $index++;
                            $total += $e->amount;
                        ?>
                        <tr>
                            <td><?php echo $index?></td>
                            <td><?php echo date("d M Y", $e->expense_date)?></td>
                            <td><?php echo $expense_items[$e->title]?></td>
                            <td><?php echo $expense_categories[$e->category]?></td>
                            <td><?php echo number_format($e->amount,2)?></td>
                            <td><?php echo ucfirst($personel->first_name.' '.$personel->last_name)?></td>
                            <td><?php echo $e->description?></td>
                            <td><?php echo ucfirst($user->first_name.' '.$user->last_name)?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td class="rttb" colspan="6"> TOTAL </td>
                            <td><?php //echo number_format($dr, 2); ?></td>
                            <td class="ctots"><?php echo number_format($total,2) ?></td>
                        </tr>
                        </table>
                    <?php } else {?>
                        <pre>No records !</pre>
                    <?php }?>

                    <?php if(isset($waivers)){ ?>
                        <table cellpadding="0" cellspacing="0" width="80%" style="margin: 15px auto;">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Date Issued</th>
                            <th>Term</th>
                            <th>Year</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Recored By</th>
                        </tr>
                        <?php
                        $index=1;
                        $total=0;
                        foreach($waivers as $t){
                            $user= $this->ion_auth->get_user($t->created_by);
                            $total +=$t->amount;
                        ?>
                        <tr>
                            <td><?php echo $index?></td>
                            <td><?php echo $this->stds[$t->student]?></td>
                            <td><?php echo date("d M Y", $t->date)?></td>
                            <td>Term <?php echo $t->term?></td>
                            <td><?php echo $t->year?></td>
                            <td><?php echo number_format($t->amount)?></td>
                            <td><?php echo $t->remarks?></td>
                            <td><?php echo ucfirst($user->first_name.' '.$user->last_name)?></td>
                        </tr>
                       

                        <?php $index++; }?>
                        <tr>
                            <td class="rttb" colspan="6"> TOTAL </td>
                            <td><?php //echo number_format($dr, 2); ?></td>
                            <td class="ctots"><?php echo number_format($total,2) ?></td>
                        </tr>
                       
                    </table>
                     <?php }?>

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
</style> 

