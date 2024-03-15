<div class="head">
    <div class="icon">
        <span class="icosg-target1"></span>
    </div>
    <h2>Fee Payments Report</h2>
    <div class="right">   
        <a href="" onClick="window.print();
                    return false" class="btn btn-primary"><i class="icos-printer"></i> Print</a>
    </div>    					
</div>

<div class="toolbar">
    <div class="row">
       
        <div class="col-md-3"><?php echo form_open(current_url(), array('class' => 'form-horizontal')); ?>
            Description:
            <?php
            echo form_dropdown('for', /*array('' => '- Select -', 9999999 => 'Tuition Fee Payment') +*/ $extras, $this->input->post('for'), ' class="tsel" ');
            ?>
        </div>
        <div class="col-md-3"> 
            Term:  
            <select class="tsel" name="term">
                <option value="1">Term 1</option>
                <option value="2">Term 2</option>
                <option value="3">Term 3</option>
            </select>
        </div>

        <div class="col-md-3"> 
            Year:  
            <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="tsel" '); ?>
        </div>
        <div class="col-md-2"><br/>
            <button class="btn btn-primary" name="view" type="submit">View Payments</button><br/>
            <button class="btn btn-warning" name="export" type="submit" value="2"> <i class="icos file-excel"></i>      Export</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="block invoice">
    <h1> </h1>

    <div class="row">
        <div class="col-md-10">
            <h3><?php echo $this->school->school; ?>  Fee Payments Report </h3>
        </div>
    </div>

    <table cellpadding="0" cellspacing="0" width="100%" class="nob">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="10%">Date</th>
                <th width="20%">Student</th>
                <th width="20%">ADM NO.</th>
                <th width="14%">Class</th>
                <th width="22%">Description</th>
                <th width="15%">Transaction</th>
                <th width="10%">Method</th> 
                <th width="11%">Invoiced</th>
                <th width="11%">Paid</th>
                <th width="11%">Balance</th>
                <th width="6%">Receipt</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $op = 0;
            $tt_bal=0;
            $tt_invoiced=0;
                        foreach ($paid as $pay)
            {
                                    $i++;
                                    $balances=($this->f_extras[$for]-$pay->amount);
                                    $tt_bal +=$balances;
                                    $tt_invoiced+=$this->f_extras[$for];
                                    $op += $pay->amount;
                                    $stu = $this->worker->get_student($pay->reg_no);
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '. '; ?></td>
                                        <td> <?php echo $pay->payment_date > 10000 ? date('d M Y', $pay->payment_date) : ''; ?></td>
                                        <td><?php echo $stu->first_name . ' ' . $stu->last_name; ?> </td>
                       
                        <td><?php echo isset($stu->old_adm_no) ? $stu->old_adm_no : $stu->admission_number; ?></td>
						 <td><?php echo $stu->cl->name; ?></td>
                        <td>
                            <?php
                                            if ($pay->description == 0)
                            {
                                                    echo 'Tuition Fee Payment';
                            }
                                            elseif (is_numeric($pay->description))
                            {
                                                    echo $extras[$pay->description];
                            }
                                            else
                            {
                                    echo $pay->description;
                            }
                            ?>
                        </td>
                        <td> <?php echo $pay->transaction_no; // isset($bank[$pay->bank_id]) ? $bank[$pay->bank_id] : ' ';          ?></td>
										    <td><?php echo $pay->payment_method; ?> </td> 
                                            <td class="rttb"><?php echo number_format($this->f_extras[$for],2)?></td>
                                        <td class="rttb"><?php echo number_format($pay->amount, 2); ?> </td>
                                        <td class="rttb"><?php echo number_format(($this->f_extras[$for]-$pay->amount),2) ?></td>
                        <td class="rttb"><a href="<?php echo base_url('admin/fee_payment/receipt/' . $pay->receipt_id); ?>" target="_blank"><?php echo $pay->receipt_id; ?></a> </td>
                                    </tr>
            <?php } ?>
            <tr>
                <td colspan="4" > </td>
                <td>&nbsp; </td>
                <td>&nbsp; </td>
                <td></td>
                <td></td>
                <td></td>
                    </tr>
                    <?php
            if (!empty($this->input->post()))
            {
            ?>
            <tr>
                <td></td>
                <td></td>
                        <td colspan="4"  class="rttbd"> Total:  </td>
                        <td colspan="3"  class="rttbd"><?php echo number_format($tt_invoiced, 2); ?></td>
                        <td colspan=""  class="rttbd"><?php echo number_format($op, 2); ?></td>
                        <td colspan=""  class="rttbd"><?php echo number_format($tt_bal, 2); ?></td>
            </tr>

            <tr>
                <td colspan="5" > </td>
                <td >&nbsp; </td>
                <td></td>
                        <td></td>
                        <td></td>
            </tr>
            <tr>
                <td> </td>
                <td> </td>
                        <td  colspan="4" ></td>
                        <td colspan="4" ><small> Date: <?php echo date('d M Y H:i:s'); ?></small></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3"> </div>
    </div>

</div>
<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '100%'});
                });
</script>
