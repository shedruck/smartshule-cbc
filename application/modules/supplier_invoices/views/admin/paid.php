<div class="head">
    <div class="icon"><span class="icosg-target1"></span> </div>
    <h2> Paid Invoices </h2>
    <div class="right">
        <?php echo anchor('admin/supplier_invoices/create/', '<i class="glyphicon glyphicon-plus"></i> ' . lang('web_add_t', array(':name' => 'Invoice')), 'class="btn btn-primary"'); ?>

        <?php echo anchor('admin/supplier_invoices', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Invoices')), 'class="btn btn-primary"'); ?>

    </div>
</div>


<?php if ($paid) : ?>
    <div class="block-fluid">
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <th>#</th>
                <td>Refrence</td>
                <th>Supplier</th>
                <th>Item</th>
                <th>Amount Paid</th>
                <th>Item Balance</th>
                <th>Overal Balance</th>
                <th>Recorded By</th>
                <th><?php echo lang('web_options'); ?></th>
            </thead>
            <tbody>
                <?php
                $index = 1;
                foreach ($paid as $p) {
                    $sup =  isset($suppliers[$p->invoice]) ? $suppliers[$p->invoice] : '';
                    $user =  $this->ion_auth->get_user($p->created_by);
                    $names = ucwords($user->first_name . ' ' . $user->last_name);
                ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><?php echo $p->ref ?></td>
                        <td><?php echo $sup; ?></td>
                        <td><?php echo ucwords(isset($item[$p->item]) ? $item[$p->item] : '') ?></td>
                        <td><?php echo number_format(isset($paid_total[$p->invoice]) ? $paid_total[$p->invoice] : '', 2); ?></td>
                        <td><?php echo number_format(isset($item_balance[$p->item]) ? $item_balance[$p->item] : '', 2); ?></td>
                        <td><?php echo number_format(isset($balance[$p->invoice]) ? $balance[$p->invoice] : '', 2); ?></td>
                        <td><?php echo $names ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/supplier_invoices/receipt/' . $p->ref . '') ?>" class="btn btn-primary">Receipt</a>

                            <a href="<?php echo base_url('admin/supplier_invoices/void_payment/' . $p->id . '') ?>" class="btn btn-danger" onclick="return confirm('Are you sure to void this payment ?\nTHIS PROCESS CANNOT BE UNDONE!!\nPlease remember to void the expense too!!')">Void</a>
                        </td>
                    </tr>

                <?php $index++;
                } ?>
            </tbody>

        </table>


    </div>

<?php else : ?>
    <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?>