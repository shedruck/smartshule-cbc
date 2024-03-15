<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2> School Assets </h2> 

</div>
<?php if ($add_stock): ?>              
    <div class="block-fluid">

        <?php
        $total_cost = 0;

        foreach ($add_stock as $p)
        {
            $cost = $this->add_stock_m->total_cost($p->product_id);
            $total_cost +=$cost->totals;
        }
        ?>
        <div class="middle">
            <div class="informer">
                <a href="#">
                    <span class="title"><?php echo $this->currency;?> <?php echo number_format($total_cost, 2); ?></span>
                    <span class="text">Total Assets Cost</span>
                </a>
            </div>
        </div>
        <table class="fpTable" cellpadding="0" cellspacing="0" width="100%">

            <thead>

            <th>#</th>
            <th>Date</th>
            <th>Item Name</th>
            <th>Total stock</th>
            <th>Closing Stock</th>
            <th>Stock Out</th>

            <th>Total Cost</th>
            <th>Option</th>
            </thead>
            <!-- END -->

            <tbody >

                <?php
                $i = 0;
                if ($this->uri->segment(4) && ( (int) $this->uri->segment(4) > 0))
                {
                    $i = ($this->uri->segment(4) - 1) * $per; // OR  ($this->uri->segment(4)  * $per) -$per;
                }

                $total_cost = 0;

                foreach ($add_stock as $p):
                    $i++;

                    $quantity = $this->add_stock_m->total_quantity($p->product_id);
                    $closing_stock = $this->add_stock_m->total_closing_stock($p->product_id);
                    $cost = $this->add_stock_m->total_cost($p->product_id);

                    $total_cost +=$cost->totals;
                    ?>
                    <tr class="gradeX">	
                        <td ><?php echo $i . '.'; ?></td>
                        <td ><?php echo date('d M, Y', $p->day); ?></td>
                        <td ><?php echo $product[$p->product_id]; ?></td>
                        <td ><?php echo $quantity->quantity; ?></td>
                        <td ><?php echo $closing_stock->quantity; ?></td>
                        <td ><?php echo ($quantity->quantity - $closing_stock->quantity); ?></td>
                        <td><b><?php echo $this->currency;?> <?php echo number_format($cost->totals, 2); ?></b></td>

                        <td ><a class="delete" href="<?php echo base_url('admin/items/trend/' . $p->product_id); ?>">View Trend<div class="progress small progress-success">
                                    <div class="bar tip" style="width: 70%;" data-original-title="50%"></div></a>
                            </div></td>
                    </tr>
                <?php endforeach ?>		
            </tbody>
        </table>

    </div>

<?php else: ?>
    <h3>No Posts at the moment</h3>
<?php endif; ?>
<!-- END TABLE DATA -->





