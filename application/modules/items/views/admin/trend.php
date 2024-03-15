<div class="col-md-12">	
    <div class="head">
        <div class="icon"><span class="icosg-target1"></span></div>
        <h2>Trend for  <?php echo $item->item_name; ?> </h2> 
        <div class="right">                            

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

    <div class="block-fluid">
        <div class="col-md-6" style="border:1px solid #000">	

            <div class="row">	
                <div class="middle">	
                    <div class="informer">
                        <a href="#">
                            <span class="icomg-cart"></span>
                            <span class="text">Stock Addition</span>
                        </a>
                        <span class="caption purple">+</span>
                    </div>	
                </div>	
            </div>	

            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>No.</th>
                <th>Date</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Add by</th>

                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($add as $add_stock_m): $user = $this->ion_auth->get_user($add_stock_m->user_id); ?>
                            <tr class="gradeX">	
                                <td><?php echo $i; ?></td>		
                                <td><?php echo date('d M Y', $add_stock_m->day); ?></td>

                                <td><?php echo $add_stock_m->quantity; ?></td>
                                <td><?php echo number_format($add_stock_m->unit_price, 2); ?></td>
                                <td><?php echo number_format($add_stock_m->total, 2); ?></td>
                                <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>

                            </tr>
        <?php $i++;
endforeach ?>
                </tbody>

            </table>
        </div>

        <div class="col-md-6" style="border:1px solid #000">	
            <div class="row">	
                <div class="middle">	
                    <div class="informer">
                        <a href="#">
                            <span class="icomg-stats-up"></span>
                            <span class="text">Stock Taking</span>
                        </a>
                        <span class="caption purple">+</span>
                    </div>	
                </div>	
            </div>

            <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <th>No.</th>
                <th>Stock Date</th>

                <th>Closing Stock</th>
                <th>Taken On</th>
                <th>Taken by</th>
                </thead>
                <tbody>
<?php $i = 1;
foreach ($take as $stock_taking_m): $user = $this->ion_auth->get_user($stock_taking_m->created_by); ?>
                            <tr class="gradeX">	
                                <td><?php echo $i; ?></td>
                                <td><?php echo date('d M Y', $stock_taking_m->stock_date); ?></td>

                                <td><?php echo $stock_taking_m->closing_stock; ?> Units</td>

                                <td><?php echo date('d M, Y', $stock_taking_m->created_on); ?></td>
                                <td ><?php echo $user->first_name . ' ' . $user->last_name; ?></td>

                            </tr>
        <?php $i++;
endforeach ?>
                </tbody>

            </table>

        </div>

        <div class="col-md-12">
            <div class="row">	
                <div class="middle">	
                    <div class="informer">
                        <a href="#">
                            <span ><h2><?php echo $add_totals->quantity; ?> </h2></span>
                            <span class="text">Total Added Stock</span>
                        </a>
                        <span class="caption purple">Units</span>
                    </div>	
                    <div class="button">
                        <a href="#">

                            <br>
                            <span class="icomg-minus"></span>
                        </a>

                    </div>


                    <div class="informer">
                        <a href="#">
                            <span ><h2> <?php
							
							//$given_out=$this->portal_m->total_given($item->product_id);
                                    $rem = 0;
                                    if (!empty($remove_totals->closing_totals))
                                    {
                                            $rem = $remove_totals->closing_totals;
                                    }
                                    if ($rem == 0)
                                    {
                                            echo $rem;
                                    }
                                    else
                                    {
                                            $total_removed = $add_totals->quantity - $rem;
                                            echo $total_removed;
                                    }
                                    ?></h2></span>
                            <span class="text">Total Removed Stock</span>
                        </a>
                        <span class="caption orange">Units</span>
                    </div>	
                    <div class="button">
                        <a href="#">

                            <br>
                            <br>
                            <span > <img src="<?php echo base_url('assets/themes/admin/img/loaders/1d_4.gif'); ?>"  /> </span><br>
                            <span > <img src="<?php echo base_url('assets/themes/admin/img/loaders/1d_4.gif'); ?>"  /> </span>
                        </a>

                    </div>
                    <div class="informer">
                        <a href="#">
                            <span ><h2>
                                    <?php
                                    if ($rem == 0)
                                    {
                                            echo $add_totals->quantity;
                                    }
                                    else
                                    {
                                            echo $add_totals->quantity - $total_removed;
                                    }
                                    ?> 
                                </h2></span>
                            <span class="text">Total Remaining Stock</span>
                        </a>
                        <span class="caption green">Units</span>
                    </div>	
                </div>	
            </div>

        </div>
    </div>
</div>
