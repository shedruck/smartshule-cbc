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


<div class="block-fluid">
    <table class="table table-bordered fpTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Supplier Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 0;
            foreach ($suppliers as $p) {

                if (empty($p->supplier_phone)) {
                    continue;
                }
                $index++;

            ?>

                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo $p->supplier ?></td>
                    <td><?php echo $p->supplier_phone ?></td>
                    <td><?php echo $p->supplier_email ?></td>
                    <td><a class="btn btn-primary" href="<?php echo base_url('admin/supplier_invoices/view_statement/' . $p->id) ?>">Statement</a></td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
</div>