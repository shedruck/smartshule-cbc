<div class="col-md-12 invoice">

    <span class="date right">F-3-45-1-2</span>
    <div class="col-md-12 view-title">
        <h1><img src="<?php echo base_url('assets/themes/admin/img/logo-sm.png'); ?>" /></h1>
        <h3><?php echo $this->school->school; ?>  </h3>
        <h5>  <?php echo $this->school->postal_addr; ?> <br>
            <?php echo $this->school->email; ?><br>
            <strong>NAME:</strong> <?php echo $user->first_name . ' ' . $user->last_name; ?>
            <strong> REGNO:</strong><?php echo strtoupper($no); ?>
            <BR> <strong> PAYMENT HISTORY -  <?php echo date('Y', time()); ?> </strong></h5>
        <span class="date">Date: <?php echo date('d M, Y H:i', time()); ?></span>
        <h3>Payment History</h3>			
    </div>

    <table class="tlb">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th>Date</th>
                <th>Description</th>
                <th>Method</th>
                <th>TRANS_ID.</th>
                <th>Bank.</th>
                <th>Amount</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($p as $p):
                    $amt = 0; //$this->fee_payment_m->total_paid($p->reg_no);
                    $user = $this->ion_auth->get_user($p->created_by);

                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo date('d/m/Y', $p->payment_date); ?></td>
                        <td><?php
                            if ($p->description == 0)
                                    echo 'Tuition Fee Payment';
                            elseif (is_numeric($p->description))
                                    echo $extras[$p->description];
                            else
                                    echo $p->description;
                            ?></td>
                        <td><?php echo $p->payment_method; ?></td>
                        <td><?php echo $p->transaction_no; ?></td>
                        <td><?php echo $banks[$p->bank_id]; ?></td>
                        <td><?php echo number_format($p->amount, 2); ?></td>
                    </tr>
            <?php endforeach ?>

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-7"></div>
        <div class="col-md-3">
            <div class="totalr">

                <div class="highlight right">
                    <strong><span>Total:</span> KES.  <?php
                        echo number_format($totals, 2);
                        ?>  <em></em></strong>
                </div>
            </div>
        </div>
    </div>

</div>