<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Supplier Statements </h2>
    <div class="right">
        <a href="<?php echo base_url() ?>admin/supplier_invoices/statement" class="btn btn-primary"><i class="glyphicon glyphicon-file"></i>Statements</a>
        <a href="<?php echo base_url() ?>admin/supplier_invoices/aging" class="btn btn-info"><i class="glyphicon glyphicon-calendar"></i>Aging Summary</a>
        <a href="<?php echo base_url('admin/supplier_invoices/paid_invoices') ?>" class="btn btn-warning"><i class="glyphicon glyphicon-list"></i> Payment Vouchers </a>
        <?php echo anchor('admin/supplier_invoices/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Invoice')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/supplier_invoices', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Invoices')), 'class="btn btn-primary"'); ?>

    </div>
</div>

<div class="invoice">
    <?php
    echo form_open(current_url())
    ?>
    <div class="row hidden-print">
        <div class="col-md-4">
            From: <input type="text" name="from" class="datepicker" value="<?php echo $this->input->post('from') ? $this->input->post('from') : date('Y-m-d') ?>">
        </div>

        <div class="col-md-4">
            To: <input type="text" name="to" class="datepicker" value="<?php echo $this->input->post('from') ? $this->input->post('from') : date('Y-m-d') ?>">
        </div>

        <div class="col-md-4">
            <br>
            <button class="btn btn-primary" type="submit">Filter</button>
            <button class="btn btn-info" onclick="window.print()" type="button">Print</button>
        </div>
    </div>
    <?php echo form_close() ?>

    <div class="row">
        <div class="col-md-12 col-xs-12">


            <div class="col-md-12 col-xs-12">
                <center>
                    <img src="<?php echo base_url('uploads/files/' . $this->school->document) ?>" style="width:80px">
                    <h1><?php echo $this->school->school ?></h1>
                    <p><b>Address:</b> <?php echo $this->school->postal_addr ?>&nbsp;&nbsp;&nbsp; <b>Email:</b> <?php echo $this->school->email ?> </p>
                    <p><b>Telephone No:</b> <?php echo $this->school->tel ?>&nbsp;&nbsp;&nbsp; <b>Cellphone No:</b><?php echo $this->school->cell ?></p>

                    <?php
                     $head = 'Supplier Statement';

                     if($this->input->post())
                     {
                        $from = strtotime($this->input->post('from'));
                        $to = strtotime($this->input->post('to'));

                        $head = 'Supplier Statement from '.date('dS M Y',$from).' to '.date('dS M Y',$to);
                     }
                    ?>
                    <h2><?php echo $head?></h2>
                    <hr style="border: solid 2px navy;">
                </center>
            </div>

        </div>
    </div>

    <div class="row invoice">
        <div class="col-md-12 col-xs-12">

            <div class="col-md-4 col-xs-4 col-sm-4">
                <strong>Name:</strong> <?php echo $post->supplier ?>
            </div>

            <div class="col-md-4 col-xs-4 col-sm-4">
                <strong>Email:</strong><?php echo $post->supplier_email ?>
            </div>

            <div class="col-md-3 col-xs-3 col-sm-3">
                <strong>Phone:</strong><?php echo $post->supplier_phone ?>
            </div>
        </div>

        <div class="col-md-12 col-xs-12">
            <hr>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ref</th>
                    <th>Description</th>
                    <th>Dr</th>
                    <th>Cr</th>
                    <th>Balance</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $index = 1;
                $l_bal = 0;
                $current = 0;
                $drs = 0;
                $crs = 0;
                foreach ($payload as $dt => $rows) {

                ?>
                    <tr>
                        <td style="border-bottom: solid 2px grey; border-left:none; border-right:none"></td>
                        <td style="border-bottom: solid 2px grey; border-left:none; border-right:none" colspan="5"><strong><?php echo date('dS M Y', $dt) ?></strong></td>
                    </tr>

                    <?php
                    foreach ($rows as $r) {
                        $p  = (object)$r;

                        $l_bal = $p->dr;
                        $current +=  $p->cr == 0 ? $l_bal :  -$p->cr - $l_bal;
                        $crs += $p->cr;
                        $drs += $p->dr;
                    ?>
                        <tr>
                            <td><?php echo $index ?></td>
                            <td><?php echo $p->ref ?></td>
                            <td><?php echo $p->description ?></td>
                            <td><?php echo number_format($p->dr, 2) ?></td>
                            <td><?php echo number_format($p->cr, 2) ?></td>
                            <td><?php echo number_format($current, 2) ?></td>
                        </tr>
                    <?php
                        $index++;
                    }
                    ?>
                <?php } ?>

                <tr>
                    <td colspan="3">
                        <h4>Totals</h4>
                    </td>
                    <td><strong><?php echo number_format($drs, 2) ?></strong></td>
                    <td><strong><?php echo number_format($crs, 2) ?></strong></td>
                    <td><strong><?php echo number_format($drs - $crs, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>