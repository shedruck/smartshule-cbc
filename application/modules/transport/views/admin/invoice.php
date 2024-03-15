<div class="head">
    <div class="icon"><span class="icosg-target1"></span></div>
    <h2>Students in Transport</h2> 
    <div class="right">  
        <div class='btn-grdoup'>	
            <?php echo anchor('admin/transport/invoice', '<i class="glyphicon glyphicon-arrow-up"></i> Invoice Students', 'class="btn btn-warning"'); ?> 
            <?php echo anchor('admin/transport/add', '<i class="glyphicon glyphicon-list"></i> Add Students', 'class="btn btn-primary"'); ?> 
            <?php echo anchor('admin/transport/routes/', '<i class="glyphicon glyphicon-thumbs-up"></i> Routes', 'class="btn btn-success"'); ?>
        </div>
    </div>
</div>
<div class="toolbar">
    <div class="col-md-12"><br/>
        <?php echo form_open(current_url()); ?>
        Route
        <?php echo form_dropdown('route', array('' => 'All Routes') + $routes, $this->input->post('fee'), 'class ="tsel" '); ?>
        Class
        <?php echo form_dropdown('class', array('' => 'Select Class') + $classes, $this->input->post('class'), 'class ="tsel" '); ?>
        Term
        <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
        Year 
        <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>
        <button class="btn btn-primary"  type="submit">Submit</button>
        <?php echo form_close(); ?>
    </div>
</div>
<div class="block invoice">
    <div class="row">
        <div class="col-md-12">
            <h3> Invoice Transport </h3>
            <hr/>
            <?php if (!empty($res)): ?>
                <?php echo form_open(base_url('admin/transport/invoice_std')) ?>
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Route</th>	
                            <th>Way</th>	
                            <th><input type="checkbox" class="checkall" /></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($res as $r)
                        {
                            $ways = [
                                '1' => 'One way',
                                '2' => 'Two way'
                            ];

                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>					
                                <td><?php echo $r->student; ?></td>
                                <td><?php echo $r->class; ?></td>
                                <td>
                                    <?php
                                    $rtt = isset($routes[$r->route]) ? $routes[$r->route] : ' - ';
                                    echo form_dropdown('route['.$r->stud.']', $routes, $r->route ? $r->route : '', ' class="select select-2"');
                                    ?>
                                </td>
                                <td>
                                    <?php
                                     echo form_dropdown('way['.$r->stud.']',   $ways, $r->way ? $r->way : '', ' class="fsel fetcher"');
                                    ?>
                                </td>
                                <td>
                                    <input type="checkbox" name="sids[]" value="<?php echo $r->stud ?>" class="switchx check-lef"> 
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                Term                                   
                <?php echo form_dropdown('term', array('' => 'Select Term') + $this->terms, $this->input->post('term'), 'class ="fsel" '); ?>
                Year 
                <?php echo form_dropdown('year', array('' => 'Select Year') + $yrs, $this->input->post('year'), 'class ="fsel" '); ?>

                <button class="btn  btn-success" type="submit">Submit</button>
                <button class="btn btn-sm btn-danger" onClick="window.location = '<?php echo base_url('admin/transport') ?>?'">Cancel</button>
                <?php echo form_close() ?>
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