 <div class="head">
     <div class="icon"><span class="icosg-target1"></span> </div>
     <h2> Aging Summary </h2>
     <div class="right">
         <a href="<?php echo base_url() ?>admin/supplier_invoices/statement" class="btn btn-primary"><i class="glyphicon glyphicon-file"></i>Statements</a>
         <a href="<?php echo base_url() ?>admin/supplier_invoices/aging" class="btn btn-info"><i class="glyphicon glyphicon-calendar"></i>Aging Summary</a>


         <?php echo anchor('admin/supplier_invoices', '<i class="glyphicon glyphicon-list">
                </i> ' . lang('web_list_all', array(':name' => 'Invoices')), 'class="btn btn-primary"'); ?>

     </div>

     <div class="block-fluid">

         <div class="col-md-12"><br />
             <?php echo form_open(current_url()); ?>
             From
             <?php echo form_dropdown('from', array('' => 'Start Day') + $days, $this->input->post('from'), 'class ="select select-2" '); ?>
             To
             <?php echo form_dropdown('to', array('' => 'End Day') + $days, $this->input->post('to'), ' class ="select select-2" '); ?>

             <button class="btn btn-primary" type="submit">Submit</button>
             <?php echo form_close(); ?>
         </div>

         <?php
            $head = "Aging Summary";
            if ($this->input->post()) {
                $head .=  " Between " . $this->input->post('from') . ' Days To ' . $this->input->post('to') . ' Days';
                echo '<center><h2>' . $head . '</h2></center>';
            ?>

             <table class="table">
                 <thead>
                     <tr>
                         <th>#</th>
                         <th>Invoice Date</th>
                         <th>Supplier</th>
                         <th>Invoice Amount</th>
                         <th>Paid</th>
                         <th>Balance</th>
                         <th>Recorded By</th>
                         <th> Age</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $index = 1;
                        $balances = 0;
                        foreach ($suppliers as $s) {
                            $balances += $s['balance'];
                            $user = $this->ion_auth->get_user($s['created_by']);
                            $days = "Days";
                            if ($s['age'] == 1) {
                                $days = "Day";
                            }
                        ?>
                         <tr>
                             <td><?php echo $index ?></td>
                             <td><?php echo date('M j\<\s\u\p\>S\<\/\s\u\p\> Y', $s['created_on']) ?></td>
                             <td><?php echo $s['supplier'] ?></td>
                             <td><?php echo number_format($s['total'], 2) ?></td>
                             <td><?php echo number_format($s['paid'], 2) ?></td>
                             <td><?php echo number_format($s['balance'], 2) ?></td>
                             <td><?php echo ucwords($user->first_name . ' ' . $user->last_name) ?></td>
                             <td><?php echo $s['age'] ?> <?php echo $days ?></td>
                         </tr>
                     <?php $index++;
                        } ?>
                 </tbody>
             </table>

             <table class="table  table-striped ">
                 <thead>
                     <th colspan="5"></th>
                     <th> Total Balances</th>
                     <th colspan="2"></th>
                 </thead>
                 <tbody>
                     <tr style="border-top:double; border-bottom:double; border-right: hidden; border-left: hidden; font-weight:700">
                         <td colspan="4"> </td>

                         <td> <b class="pull-right">TOTAL Balances</b></td>
                         <td><?php echo number_format($balances, 2); ?></td>
                         <td colspan="2"></td>
                     </tr>
                 </tbody>
             </table>


         <?php } else { ?>

             <pre>Please select number of days!</pre>
         <?php } ?>
     </div>