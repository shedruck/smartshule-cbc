<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Supplier Invoice</h2> 
    <div class="right">  
        <div class='btn-grdoup'>	
        
        </div>
    </div>
</div>
 
<div class="block invoice">
    <div class="row">
        <div class="col-md-12">
            <h3> Supplier Invoice Payments To 
                <?php
                    echo isset($suppliers[$supplier]) ? $suppliers[$supplier] : '';
                ?>  
                (
                    <?php echo isset($phone[$supplier]) ? $phone[$supplier] : ''; ?>
                )  
             </h3>
            <hr/>
            <?php if (!empty($items)): ?>
                 
                 <?php echo form_open(current_url())?>
                    <table class="table" width="100%">
                        <thead>
                        <th>#</th>
                        <th>Item</th>
                        <th>Amount Due</th>
                        <th>Amount</th>	
                        <th ><input type="checkbox" class="checkall" /></th>
                         
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                        
                            foreach ($items as $l):
                                if($l->amount_due == 0)
                                {
                                    continue;
                                }
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>					
                                        <td><?php echo $l->item ?></td>
                                        <td><?php echo number_format($l->amount_due,2); ?></td>
                                        <td>
                                            <input type="number" name="amount[]" class="form-control" placeholder="Enter Amount">
                                        </td>

                                         
                                        <td>
                                          
                                            <input type="checkbox" name="itemss[]" value="<?php echo $l->id?>" class="switchx check-lef"> 
                                            
                                         </td>
                                        
                                    </tr>
                            <?php endforeach ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><input type="text" name="check_no" placeholder="Check No"></td>
                                <td> <?php
                                echo form_dropdown('bank', array('' => 'Select Bank Account') + $banks, (isset($result->bank_id)) ? $result->bank_id : '', ' class="select select-2" style="width:100%" id="bank_id" ');
                                ?></td>
                            </tr>
                        </tbody>
                    </table>
                        
                        <button class="btn  btn-success text-right" type="submit">Submit</button>
                        <a href="<?php echo base_url('admin/supplier_invoices')?>" class="btn btn-danger text-right">Cancel</a>
                        <?php echo form_close()?>
            <?php else: ?>
                    <p class='text'>No Results Found</p>
            <?php endif ?>
        </div>
    </div>
</div>
<script>
        $(document).ready(
                function ()
                {
                    $(".tsel").select2({'placeholder': 'Please Select', 'width': '140px'});
                    $(".tsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".fsel").select2({'placeholder': 'Please Select', 'width': '100px'});
                    $(".fsel").on("change", function (e) {

                        notify('Select', 'Value changed: ' + e.added.text);
                    });

                    $(".checks").on('change', function ()
            {
                $("input.check-lef").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });

            $(".checkall").on('change', function ()
            {
                $("input.check").each(function ()
                {
                    $(this).prop("checked", !$(this).prop("checked"));
                });
            });
            $.uniform.update();
                });
</script>

<style>
    .selected_rt{
        color: navy;
        background-color: green;
    }
</style>