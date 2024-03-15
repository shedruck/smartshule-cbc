<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> Stocks Management</h2> 
    <div class="right">                            
        <?php echo anchor('admin/add_stock/create/', '<i class="glyphicon glyphicon-plus">
                </i> Add Stock ', 'class="btn btn-primary"'); ?> 
        <?php echo anchor('admin/add_stock/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        <div class="btn-group">
            <button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>

            <ul class="dropdown-menu pull-right">
                <li><a class=""  href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-list-alt"></i> Manage Items</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-fullscreen"></i> Manage Items Category</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('admin/add_stock/create'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Stock</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('admin/stock_taking'); ?>"><i class="glyphicon glyphicon-edit"></i> Stock Taking</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url('admin/inventory'); ?>"><i class="glyphicon glyphicon-folder-open"></i> Inventory Listing</a></li>
            </ul>
        </div>

    </div>    					
</div>
<?php if ($add_stock): ?>              
        <div class="block-fluid">
            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>No.</th>
                <th>Date</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Person Responsible</th>
                <th>Receipt</th> 
                <th></th>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($add_stock as $add_stock_m): $user = $this->ion_auth->get_user($add_stock_m->user_id);
                            ?>
                            <tr class="gradeX">	
                                <td><?php echo $i; ?></td>		
                                <td><?php echo date('d M Y', $add_stock_m->day); ?></td>
                                <td><?php echo $product[$add_stock_m->product_id]; ?></td>
                                <td><?php echo $add_stock_m->quantity; ?></td>
                                <td><?php echo number_format($add_stock_m->unit_price, 2); ?></td>
                                <td><?php echo number_format($add_stock_m->total, 2); ?></td>
                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                <td>
                                    <?php if (!empty($add_stock_m->receipt)): ?>
                                            <a href='<?php echo base_url('uploads/files/' . $add_stock_m->receipt); ?>' />Download file (receipt)</a>
                                    <?php else: ?>
                                            ........................
                                    <?php endif; ?>
                                </td>

                                <td width="20%">
                                    <div class="btn-group">
                                        <a class='btn btn-primary' href="<?php echo site_url('admin/add_stock/edit/' . $add_stock_m->id); ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                                        <a class='btn btn-danger' onClick="return confirm('<?php echo lang('web_confirm_delete') ?>')" href='<?php echo site_url('admin/add_stock/delete/' . $p->id); ?>'><i class="glyphicon glyphicon-trash"></i> Trash</a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $i++;
                    endforeach
                    ?>
                </tbody>

            </table>


        </div>


<?php else: ?>
        <p class='text'><?php echo lang('web_no_elements'); ?></p>
<?php endif ?> 








